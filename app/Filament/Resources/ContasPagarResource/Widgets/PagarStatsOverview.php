<?php

namespace App\Filament\Resources\ContasPagarResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;


class PagarStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
        return [
            Card::make('Total a Pagar', DB::table('contas_pagars')->where('status', 0)->sum('valor_parcela'))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total a Pagar', DB::table('contas_pagars')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->sum('valor_parcela'))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total a Pagar', DB::table('contas_pagars')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->whereDay('data_vencimento', $dia)->sum('valor_parcela'))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
