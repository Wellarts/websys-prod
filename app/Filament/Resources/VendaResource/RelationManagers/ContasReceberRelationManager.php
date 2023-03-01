<?php

namespace App\Filament\Resources\VendaResource\RelationManagers;


use App\Models\ContasReceber;
use App\Models\FluxoCaixa;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContasReceberRelationManager extends RelationManager
{
    protected static string $relationship = 'ContasReceber';

    protected static ?string $recordTitleAttribute = 'venda_id';

    protected static ?string $title = 'Contas a Receber';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('venda_id')
            ->hidden()
            ->required(),
        Forms\Components\Select::make('cliente_id')
            ->label('Cliente')
            ->default((function ($livewire): int {
                return $livewire->ownerRecord->cliente_id;
            }))
            ->disablePlaceholderSelection()
            ->options(function (RelationManager $livewire): array {
                return $livewire->ownerRecord
                    ->cliente()
                    ->pluck('nome', 'id')
                    ->toArray();
            }) 
            ->required(),
        Forms\Components\TextInput::make('valor_total')
            ->label('Valor Total')
            ->default((function ($livewire): int {
            return $livewire->ownerRecord->valor_total;
        }))
            ->disabled()
            ->required(),
            Forms\Components\TextInput::make('parcelas')
            ->default('1')
            ->reactive()
            ->afterStateUpdated(function (Closure $get, Closure $set) {
                if($get('parcelas') != 1)
                   {
                    $set('valor_parcela', (($get('valor_total') / $get('parcelas'))));
                    $set('status', 0);
                    $set('valor_recebido', 0);
                    $set('data_pagamento', null);
                    $set('data_vencimento',  Carbon::now()->addDays(30));
                   }
                else
                    {
                        $set('valor_parcela', $get('valor_total'));
                        $set('status', 1);
                        $set('valor_recebido', $get('valor_total'));
                        $set('data_pagamento', Carbon::now());
                        $set('data_vencimento',  Carbon::now());  
                    }    
  
            })
            ->required(),
        Forms\Components\DatePicker::make('data_pagamento')
            ->default(now())
            ->label("Data do Pagamento"),
       Forms\Components\TextInput::make('ordem_parcela')
            ->label('Parcela Nº')
            ->disabled()
            ->default('1')
            ->required(),
        Forms\Components\DatePicker::make('data_vencimento')
             ->default(now())
             ->label("Data do Vencimento")
            ->required(),
        Forms\Components\Toggle::make('status')
            ->default('true')
            ->label('Recebido')
            ->required()
            ->reactive()
            ->afterStateUpdated(function (Closure $get, Closure $set) {
                         if($get('status') == 1)
                             {
                                 $set('valor_recebido', $get('valor_parcela'));
                                 $set('data_pagamento', Carbon::now());

                             }
                         else
                             {
                                 
                                 $set('valor_recebido', 0);
                                 $set('data_pagamento', null);
                             } 
                         }      
             ),
        Forms\Components\TextInput::make('valor_recebido')
            ->default((function ($livewire): int {
                    return $livewire->ownerRecord->valor_total;
            })),
        Forms\Components\TextInput::make('valor_parcela')
            ->default((function ($livewire): int {
                    return $livewire->ownerRecord->valor_total;
            }))
            ->required()
            ->disabled(),
        Forms\Components\Textarea::make('obs')
            ->columnSpanFull()
            ->label('Observações'),
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ordem_parcela')
                    ->label('Parcela Nº'),
                Tables\Columns\TextColumn::make('data_vencimento')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('valor_total'),
                
                Tables\Columns\TextColumn::make('valor_parcela'),       
                Tables\Columns\IconColumn::make('status')
                    ->label('Pago')
                    ->boolean(),
                Tables\Columns\TextColumn::make('data_pagamento')
                    ->date(),    
                Tables\Columns\TextColumn::make('valor_recebido'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->label('Adicionar')
                ->after(function ($data, $record) {
                    if($record->parcelas > 1)
                    {
                        $valor_parcela = ($record->valor_total / $record->parcelas);
                        $vencimentos = Carbon::create($record->data_vencimento);
                        for($cont = 1; $cont < $data['parcelas']; $cont++)
                        {
                                            $dataVencimentos = $vencimentos->addDays(30);
                                            $parcelas = [
                                            'venda_id' => $record->venda_id,
                                            'cliente_id' => $data['cliente_id'],
                                            'valor_total' => $data['valor_total'],
                                            'parcelas' => $data['parcelas'],
                                            'ordem_parcela' => $cont+1,
                                            'data_vencimento' => $dataVencimentos,
                                            'valor_recebido' => 0.00,
                                            'status' => 0,
                                            'obs' => 'Venda...',
                                            'valor_parcela' => $valor_parcela,
                                            ];
                                ContasReceber::create($parcelas);
                        }

                    }
                    else
                    {
                        $addFluxoCaixa = [
                            'valor' => ($record->valor_total),
                            'tipo'  => 'CREDITO',
                            'obs'   => 'Recebido da venda nº: '.$record->venda_id. '',
                        ];

                        FluxoCaixa::create($addFluxoCaixa);
                    }

                }
            ),
        ])
            
            ->actions([
                Tables\Actions\EditAction::make()
                ->after(function ($data, $record) {

                    if($record->status = 1)
                    {
                        $addFluxoCaixa = [
                            'valor' => ($record->valor_parcela),
                            'tipo'  => 'CREDITO',
                            'obs'   => 'Recebido da venda nº: '.$record->venda_id. '',
                        ];

                        FluxoCaixa::create($addFluxoCaixa); 
                    }
                    
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
