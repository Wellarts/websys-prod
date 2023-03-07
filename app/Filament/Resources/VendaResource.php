<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendaResource\Pages;
use App\Filament\Resources\VendaResource\RelationManagers;
use App\Filament\Resources\VendaResource\RelationManagers\ContasReceberRelationManager;
use App\Filament\Resources\VendaResource\RelationManagers\ItensVendaRelationManager;
use App\Models\Cliente;
use App\Models\FormaPgmto;
use App\Models\Funcionario;
use App\Models\ItensVenda;
use App\Models\Venda;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VendaResource extends Resource
{
    protected static ?string $model = Venda::class;

    protected static ?string $navigationIcon = 'heroicon-s-shopping-bag';

    protected static ?string $navigationGroup = 'Saídas';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                        Forms\Components\Select::make('cliente_id')
                            ->label('Cliente')
                            ->options(Cliente::all()->pluck('nome', 'id')->toArray())
                            ->required(),
                        Forms\Components\Select::make('funcionario_id')
                            ->label('Vendedor')
                            ->options(Funcionario::all()->pluck('nome', 'id')->toArray())
                            ->required(),
                        Forms\Components\DatePicker::make('data_venda')
                            ->label('Data da Venda')
                            ->default(now())
                            ->required(),
                        Forms\Components\Select::make('formaPgmto_id')
                            ->label('Forma de Pagamento')
                            ->options(FormaPgmto::all()->pluck('nome', 'id')->toArray())
                            ->required(),
                        Forms\Components\Textarea::make('obs')
                            ->label('Observações'),

                ])->columns('2')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('cliente.nome')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('data_venda')
                    ->sortable()
                    ->label('Data da Venda')
                    ->date(),
                Tables\Columns\TextColumn::make('funcionario.nome')
                    ->label('Vendedor'),
                Tables\Columns\TextColumn::make('formaPgmto.nome')
                    ->label('Forma de Pagamento'),
                Tables\Columns\TextColumn::make('valor_total')
                    ->money('BRL'),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Imprimir')
                ->url(fn (Venda $record): string => route('comprovante', $record))
                ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),

            ]);
    }

    public static function getRelations(): array
    {
        return [
            ItensVendaRelationManager::class,
            ContasReceberRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVendas::route('/'),
            'create' => Pages\CreateVenda::route('/create'),
            'edit' => Pages\EditVenda::route('/{record}/edit'),
            'lucro' => Pages\LucroVenda::route('/lucro'),
        ];
    }


}
