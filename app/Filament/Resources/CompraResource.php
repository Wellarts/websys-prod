<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompraResource\Pages;
use App\Filament\Resources\CompraResource\RelationManagers;
use App\Filament\Resources\CompraResource\RelationManagers\ContasPagarRelationManager;
use App\Filament\Resources\CompraResource\RelationManagers\ItensCompraRelationManager;
use App\Models\Compra;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;

class CompraResource extends Resource
{
    protected static ?string $model = Compra::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-cart';

    protected static ?string $navigationGroup = 'Entradas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Card::make()->schema([
                        Forms\Components\Select::make('fornecedor_id')
                            ->label('Fornecedor')
                            ->options(Fornecedor::all()->pluck('nome', 'id')->toArray())
                            ->required(),
                        Forms\Components\DatePicker::make('data_compra')
                            ->default(now())
                            ->required(),
                        Forms\Components\TextInput::make('outros_custos'),
                        Forms\Components\Textarea::make('obs')
                            ->label('Observações'),
                        ])->columns(2)
            ]);        
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fornecedor.nome'),
                Tables\Columns\TextColumn::make('data_compra')
                    ->date(),
                Tables\Columns\TextColumn::make('valor_total')
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
            ItensCompraRelationManager::class,
            ContasPagarRelationManager::class
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompras::route('/'),
            'create' => Pages\CreateCompra::route('/create'),
            'edit' => Pages\EditCompra::route('/{record}/edit'),
        ];
    }    
}
