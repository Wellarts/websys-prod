<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class ReceberHojeStatsOverview extends BaseWidget
{
    public $filters = null;

    

    protected function getCards(): array
    {

        $mes = date('m');
        $dia = date('d');

        return [
               
        Card::make('Total a Receber', DB::table('contas_recebers')->where('status', 0)->whereDay('data_vencimento', $dia)->sum('valor_parcela'))
            ->description('Hoje')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
        Card::make('Total a Receber', DB::table('contas_recebers')->where('status', 0)->whereMonth('data_vencimento', $mes)->sum('valor_parcela'))
            ->description('Este mês')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),

        ];
    }
}
