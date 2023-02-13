<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FornecedorResource\Pages;
use App\Filament\Resources\FornecedorResource\RelationManagers;
use App\Models\Estado;
use App\Models\Fornecedor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FornecedorResource extends Resource
{
    protected static ?string $model = Fornecedor::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-circle';

    protected static ?string $navigationLabel = 'Fornecedores';

    protected static ?string $navigationGroup = 'Cadastros';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('cpf_cnpj')
                ->label('CPF/CNPJ')
               // ->placeholder('000.000.000-00 ou 000.000.000/0000-00')
                //->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('000.000.000-00'))
                ->maxLength(50),
            Forms\Components\Textarea::make('endereco')
                ->label('Endereço'),
            Forms\Components\Select::make('estado_id')
                ->label('Estado')
                ->required()
                ->options(Estado::all()->pluck('nome', 'id')->toArray())
                ->reactive(),
            Forms\Components\Select::make('cidade_id')
                ->label('Cidade')
                ->required()
                ->options(function (callable $get) {
                    $estado = Estado::find($get('estado_id'));
                    if(!$estado) {
                        return Estado::all()->pluck('nome', 'id');
                    }
                    return $estado->cidade->pluck('nome','id');
                })
                ->reactive(),
            Forms\Components\TextInput::make('telefone')
                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask->pattern('(00)00000-0000)'))
                ->tel()
                ->maxLength(255),
            Forms\Components\TextInput::make('email')
                ->email()
                ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome'),
                Tables\Columns\TextColumn::make('endereco')
                    ->label('Endereço'),
                Tables\Columns\TextColumn::make('estado.nome')
                    ->label('Estado'),
                Tables\Columns\TextColumn::make('cidade.nome')
                    ->label('Cidade'),
                Tables\Columns\TextColumn::make('telefone')
                    ->label('Telefone'),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('created_at')
                     ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->modalHeading('Fornecedores'),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageFornecedors::route('/'),
        ];
    }    
}
