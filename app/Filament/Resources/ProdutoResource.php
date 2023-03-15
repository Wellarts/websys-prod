<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProdutoResource\Pages;
use App\Filament\Resources\ProdutoResource\RelationManagers;
use App\Filament\Resources\ProdutoResource\RelationManagers\ProdutoFornecedorRelationManager;
use App\Models\Produto;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProdutoResource extends Resource
{
    protected static ?string $model = Produto::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-bag';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('nome')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('estoque'),
                        Forms\Components\TextInput::make('valor_compra')
                            ->reactive()
                            ->afterStateUpdated(function (Closure $get, Closure $set) {
                                $set('valor_venda', ((($get('valor_compra') * $get('lucratividade'))/100) + $get('valor_compra')));
                            }),
                        Forms\Components\TextInput::make('lucratividade')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (Closure $get, Closure $set) {
                                $set('valor_venda', ((($get('valor_compra') * $get('lucratividade'))/100) + $get('valor_compra')));
                            }),
                        Forms\Components\TextInput::make('valor_venda')
                            ->disabled(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('estoque'),
                Tables\Columns\TextColumn::make('valor_compra')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('lucratividade')
                    ->label('Lucratividade (%)'),
                Tables\Columns\TextColumn::make('valor_venda')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            ProdutoFornecedorRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProdutos::route('/'),
            'create' => Pages\CreateProduto::route('/create'),
            'edit' => Pages\EditProduto::route('/{record}/edit'),
            
        ];
    }    
}
