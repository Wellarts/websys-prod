<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContasPagarResource\Pages;
use App\Filament\Resources\ContasPagarResource\RelationManagers;
use App\Models\ContasPagar;
use App\Models\FluxoCaixa;
use App\Models\Fornecedor;
use Carbon\Carbon;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContasPagarResource extends Resource
{
    protected static ?string $model = ContasPagar::class;

    protected static ?string $navigationIcon = 'heroicon-s-trending-down';

    protected static ?string $navigationLabel = 'Contas a Pagar';

    protected static ?string $navigationGroup = 'Financeiro';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('fornecedor_id')
                    ->label('Fornecedor')
                    ->options(Fornecedor::all()->pluck('nome', 'id')->toArray())
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('compra_id')
                    ->hidden()
                    ->required(),
                Forms\Components\TextInput::make('parcelas')
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ordem_parcela')
                    ->label('Parcela Nº')
                    ->disabled()
                    ->maxLength(10),
                Forms\Components\DatePicker::make('data_vencimento')
                    ->required(),
                    Forms\Components\TextInput::make('valor_total')
                    ->disabled()
                    ->required(),
                Forms\Components\DatePicker::make('data_pagamento'),
                Forms\Components\Toggle::make('status')
                ->default('true')
                ->label('Recebido')
                ->required()
                ->reactive()
                ->afterStateUpdated(function (Closure $get, Closure $set) {
                             if($get('status') == 1)
                                 {
                                     $set('valor_pago', $get('valor_parcela'));
                                     $set('data_pagamento', Carbon::now());

                                 }
                             else
                                 {

                                     $set('valor_pago', 0);
                                     $set('data_pagamento', null);
                                 }
                             }
                 ),

                Forms\Components\TextInput::make('valor_parcela')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('valor_pago'),
                Forms\Components\Textarea::make('obs'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('compra_id')
                    ->alignCenter()
                    ->label('Compra'),
                Tables\Columns\TextColumn::make('fornecedor.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ordem_parcela')
                    ->alignCenter()
                    ->label('Parcela Nº'),
                Tables\Columns\BadgeColumn::make('data_vencimento')
                    ->sortable()
                    ->alignCenter()
                    ->color('danger')
                    ->date(),
                Tables\Columns\BadgeColumn::make('valor_total')
                    ->alignCenter()
                    ->color('success')
                     ->money('BRL'),
                Tables\Columns\BadgeColumn::make('valor_parcela')
                    ->alignCenter()
                    ->color('danger')
                    ->money('BRL'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Pago')
                    ->boolean(),
                Tables\Columns\BadgeColumn::make('data_pagamento')
                    ->alignCenter()
                    ->color('warning')
                    ->date(),
                Tables\Columns\BadgeColumn::make('valor_pago')
                    ->alignCenter()
                    ->color('warning')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('Aberta')
                ->query(fn (Builder $query): Builder => $query->where('status', false)),
                 SelectFilter::make('fornecedor')->relationship('fornecedor', 'nome'),
                 Tables\Filters\Filter::make('data_vencimento')
                    ->form([
                        Forms\Components\DatePicker::make('vencimento_de')
                            ->label('Vencimento de:'),
                        Forms\Components\DatePicker::make('vencimento_ate')
                            ->label('Vencimento até:'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['vencimento_de'],
                                fn($query) => $query->whereDate('data_vencimento', '>=', $data['vencimento_de']))
                            ->when($data['vencimento_ate'],
                                fn($query) => $query->whereDate('data_vencimento', '<=', $data['vencimento_ate']));
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($data, $record) {

                    if($record->status = 1)
                    {
                        $addFluxoCaixa = [
                            'valor' => ($record->valor_parcela * -1),
                            'tipo'  => 'DEBITO',
                            'obs'   => 'Pagamento da compra nº: '.$record->compra_id. '',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageContasPagars::route('/'),
        ];
    }
}
