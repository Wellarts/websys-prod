<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FluxoCaixaResource\Pages;
use App\Filament\Resources\FluxoCaixaResource\RelationManagers;
use App\Models\FluxoCaixa;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FluxoCaixaResource extends Resource
{
    protected static ?string $model = FluxoCaixa::class;

    protected static ?string $navigationIcon = 'heroicon-s-scale';

    protected static ?string $navigationLabel = 'Fluxo de Caixa';

    protected static ?string $navigationGroup = 'Financeiro';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            
             Forms\Components\Select::make('tipo')
                 ->options([
                     'CREDITO' => 'CREDITO',
                     'DEBITO' => 'DEBITO',
                 ])   
                 ->required(),
                
             Forms\Components\TextInput::make('valor')
                 ->required(),
             
             Forms\Components\Textarea::make('obs')
                 ->columnSpanFull()
                 ->required(),
            
         ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('tipo')
                ->color(static function ($state): string {
                    if ($state === 'CREDITO') {
                        return 'success';
                    }
             
                    return 'danger';
                })
                ->sortable(),                
                Tables\Columns\TextColumn::make('valor'),
                Tables\Columns\TextColumn::make('obs')
                    ->searchable(),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFluxoCaixas::route('/'),
        ];
    } 
    
    protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
}
