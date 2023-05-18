<?php

namespace App\Filament\Widgets;

use App\Models\Produto;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsEstoqueContabil extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total de Compra', number_format(Produto::all()->sum('total_compra'),2))
                ->description('Estoque atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('Total de Vendas', number_format(Produto::all()->sum('total_venda'),2))
                ->description('Estoque atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('warning'),
            Card::make('Total Lucro', number_format(Produto::all()->sum('total_venda') - Produto::all()->sum('total_compra'),2))
                ->description('Estoque atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),

        ];
    }
}
