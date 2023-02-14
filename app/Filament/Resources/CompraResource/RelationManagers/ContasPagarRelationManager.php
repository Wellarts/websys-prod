<?php

namespace App\Filament\Resources\CompraResource\RelationManagers;

use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContasPagarRelationManager extends RelationManager
{
    protected static string $relationship = 'ContasPagar';

    protected static ?string $recordTitleAttribute = 'compra_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('compra_id')
                ->hidden()
                ->required(),
            Forms\Components\Select::make('fornecedor_id')
                ->label('Fornecedor')
                ->default((function ($livewire): int {
                    return $livewire->ownerRecord->fornecedor_id;
                }))
                ->disablePlaceholderSelection()
                ->options(function (RelationManager $livewire): array {
                    return $livewire->ownerRecord
                        ->fornecedor()
                        ->pluck('nome', 'id')
                        ->toArray();
                }) 
                ->required(),


            Forms\Components\TextInput::make('valor_total')
                ->label('Valor Total')
                ->default((function ($livewire): int {
                return $livewire->ownerRecord->valor_total;
            }))
                ->required(),
            Forms\Components\TextInput::make('parcelas')
                ->default('1')
                ->required(),
            Forms\Components\DatePicker::make('data_pagamento')
                ->default(now())
                ->label("Data do Pagamento")
                ->required(),
            Forms\Components\TextInput::make('ordemParcela')
                ->default('1')
                ->required(),
            Forms\Components\DatePicker::make('data_vencimento')
                 ->default(now())
                 ->label("Data do Vencimento")
                ->required(),
            Forms\Components\Toggle::make('status')
                ->default('true')
                ->label('Pago')
                ->required(),
            Forms\Components\TextInput::make('obs')
                ->maxLength(191),
            Forms\Components\TextInput::make('valor_pago')
                ->default((function ($livewire): int {
                        return $livewire->ownerRecord->valor_total;
                }))
                ->required(),
            Forms\Components\TextInput::make('valor_parcela')
                ->default((function ($livewire): int {
                        return $livewire->ownerRecord->valor_total;
                }))
                ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('compra_id'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
