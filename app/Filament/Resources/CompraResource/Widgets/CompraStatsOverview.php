<?php

namespace App\Filament\Resources\CompraResource\Widgets;

use App\Models\Compra;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class CompraStatsOverview extends BaseWidget
{

    protected function getCards(): array
    {

        $mes = date('m');
        $dia = date('d');
        return [
            Card::make('Total da Compra', number_format(Compra::all()->sum('valor_total'),2, ",", "."))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total da Compra', number_format(DB::table('compras')->whereMonth('data_compra', $mes)->sum('valor_total'),2, ",", "."))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total da Compra', number_format(DB::table('compras')->whereDay('data_compra', $dia)->sum('valor_total'),2, ",", "."))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
