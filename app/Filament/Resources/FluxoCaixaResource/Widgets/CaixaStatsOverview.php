<?php

namespace App\Filament\Resources\FluxoCaixaResource\Widgets;

use App\Models\FluxoCaixa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class CaixaStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {

       
        return [
             Card::make('Saldo', FluxoCaixa::all()->sum('valor'))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary'),
             Card::make('Débitos', FluxoCaixa::all()->where('valor', '<', 0)->sum('valor'))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('Crétidos', FluxoCaixa::all()->where('valor', '>', 0)->sum('valor'))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),   
         //   Card::make('Total de Vendas do Mês', DB::table('vendas')->whereDay('data_venda', $dia)->sum('valor_total'))
        ];
    }
}
