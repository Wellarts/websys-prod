<?php

namespace App\Filament\Widgets;

use App\Models\Compra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class PagarHojeStatsOverview extends BaseWidget
{

    protected static ?int $sort = 2;

    protected function getCards(): array
    {

        $mes = date('m');
        $dia = date('d');
        return [
            Card::make('Total a Pagar', number_format(DB::table('contas_pagars')->where('status', 0)->whereDay('data_vencimento', $dia)->sum('valor_parcela'),2))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total a Pagar', number_format(DB::table('contas_pagars')->where('status', 0)->whereMonth('data_vencimento', $mes)->sum('valor_parcela'),2))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
