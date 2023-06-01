<?php

namespace App\Filament\Resources\ContasReceberResource\Widgets;

use App\Models\ContasReceber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class ReceberStatsOverview extends BaseWidget
{

    public $filters = null;



    protected function getCards(): array
    {
        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');

        return [
        Card::make('Total a Receber', number_format(DB::table('contas_recebers')->where('status', 0)->sum('valor_parcela'),2, ",", "."))
            ->description('Todo Perído')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
        Card::make('Total a Receber', number_format(DB::table('contas_recebers')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->sum('valor_parcela'),2, ",", "."))
            ->description('Este mês')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),
        Card::make('Total a Receber', number_format(DB::table('contas_recebers')->where('status', 0)->whereYear('data_vencimento', $ano)->whereMonth('data_vencimento', $mes)->whereDay('data_vencimento', $dia)->sum('valor_parcela'),2, ",", "."))
            ->description('Hoje')
            ->descriptionIcon('heroicon-s-trending-up')
            ->color('success'),


        ];
    }
}

