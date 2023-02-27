<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContasReceberResource\Pages;
use App\Filament\Resources\ContasReceberResource\RelationManagers;
use App\Models\Cliente;
use App\Models\ContasReceber;
use App\Models\FluxoCaixa;
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

class ContasReceberResource extends Resource
{
    protected static ?string $model = ContasReceber::class;

    protected static ?string $navigationIcon = 'heroicon-s-trending-up';

    protected static ?string $navigationLabel = 'Contas a Receber';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cliente_id')
                    ->label('Cliente')
                    ->options(Cliente::all()->pluck('nome', 'id')->toArray())
                    ->required()
                    ->disabled(),
                Forms\Components\TextInput::make('venda_id')
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

                Forms\Components\TextInput::make('valor_parcela')
                    ->disabled()
                    ->required(),
                Forms\Components\TextInput::make('valor_recebido'),
                Forms\Components\Textarea::make('obs'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('venda_id')
                    ->label('Compra'),
                Tables\Columns\TextColumn::make('cliente.nome'),
                Tables\Columns\TextColumn::make('ordem_parcela')
                    ->label('Parcela Nº'),
                    Tables\Columns\BadgeColumn::make('data_vencimento')
                    ->color('danger')
                    ->date(),
                Tables\Columns\BadgeColumn::make('valor_total')
                    ->color('success')
                     ->money('BRL'),
                Tables\Columns\BadgeColumn::make('valor_parcela')
                    ->color('danger')
                    ->money('BRL'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Recebido')
                    ->boolean(),
                Tables\Columns\BadgeColumn::make('data_pagamento')
                    ->color('warning')
                    ->date(),
                Tables\Columns\BadgeColumn::make('valor_recebido')
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
                 SelectFilter::make('cliente')->relationship('cliente', 'nome'),
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
                            'valor' => ($record->valor_parcela),
                            'tipo'  => 'CREDITO',
                            'obs'   => 'Recebimento da venda nº: '.$record->venda_id. '',
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
            'index' => Pages\ManageContasRecebers::route('/'),
        ];
    }
}
