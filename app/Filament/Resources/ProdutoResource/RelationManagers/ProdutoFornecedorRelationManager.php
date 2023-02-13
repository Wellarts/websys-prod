<?php

namespace App\Filament\Resources\ProdutoResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdutoFornecedorRelationManager extends RelationManager
{
    protected static string $relationship = 'ProdutoFornecedor';

    protected static ?string $recordTitleAttribute = 'produto_id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('produto_id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('compra_id')
                ->label('Venda'),
                Tables\Columns\TextColumn::make('compra.fornecedor.nome'),
                Tables\Columns\TextColumn::make('compra.data_compra')
                ->format('d/m/Y')

            ])
            ->filters([
                //
            ])
            ->headerActions([
              // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
               // Tables\Actions\EditAction::make(),
               // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //Tables\Actions\DeleteBulkAction::make(),
            ]);
    }    
}
