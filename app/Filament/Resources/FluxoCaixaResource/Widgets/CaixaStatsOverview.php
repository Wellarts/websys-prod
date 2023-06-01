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
             Card::make('Saldo', number_format(FluxoCaixa::all()->sum('valor'),2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary'),
             Card::make('Débitos', number_format(FluxoCaixa::all()->where('valor', '<', 0)->sum('valor'),2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('danger'),
            Card::make('Crétidos', number_format(FluxoCaixa::all()->where('valor', '>', 0)->sum('valor'),2, ",", "."))
                ->description('Valor atual')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
         //   Card::make('Total de Vendas do Mês', DB::table('vendas')->whereDay('data_venda', $dia)->sum('valor_total'))
        ];
    }
}
