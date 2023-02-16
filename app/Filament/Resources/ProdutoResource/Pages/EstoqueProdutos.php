<?php

namespace App\Filament\Resources\ProdutoResource\Pages;


use App\Filament\Resources\ProdutoResource;
use App\Models\Produto;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class EstoqueProdutos extends Page implements HasTable
{

    use InteractsWithTable;

    protected static string $resource = ProdutoResource::class;

    protected static ?string $navigationLabel = 'Lucratividade';

    protected static ?string $navigationGroup = 'Consultas';




    protected static string $view = 'filament.resources.produto-resource.pages.estoque-produtos';


    protected function getTableQuery(): Builder
    {
        return Produto::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nome'),
           
                Tables\Columns\TextColumn::make('estoque'),
                Tables\Columns\TextColumn::make('valor_compra')
                ->money('BRL'),
                Tables\Columns\TextColumn::make('lucratividade')
                ->label('Lucratividade (%)'),
                Tables\Columns\TextColumn::make('valor_venda')
                ->money('BRL'),
                Tables\Columns\BadgeColumn::make('total_compra')
                ->getStateUsing(function (Produto $record): float {
                    return ($record->estoque * $record->valor_compra)*100;
                })
                ->money('BRL')
                ->color('danger'),
                Tables\Columns\BadgeColumn::make('total_venda')
                ->getStateUsing(function (Produto $record): float {
                    return ($record->estoque * $record->valor_venda)*100;
                })
                ->money('BRL')
                ->color('warning'),
                Tables\Columns\BadgeColumn::make('lucratividade_real')
                ->getStateUsing(function (Produto $record): float {
                    return ((($record->estoque * $record->valor_venda)*100) - (($record->estoque * $record->valor_compra)*100));
                })
                ->color('success')
                ->money('BRL'),


        ];
    }


}
