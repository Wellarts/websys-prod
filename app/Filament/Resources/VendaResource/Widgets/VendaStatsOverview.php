<?php

namespace App\Filament\Resources\VendaResource\Widgets;

use App\Models\Venda;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Sum;

class VendaStatsOverview extends BaseWidget
{
    protected function getCards(): array
    {

        $ano = date('Y');
        $mes = date('m');
        $dia = date('d');
       // dd($ano);
        return [
            Card::make('Total de Vendas', number_format(Venda::all()->sum('valor_total'),2))
                ->description('Todo Perído')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total de Vendas', number_format(DB::table('vendas')->whereYear('data_venda', $ano)->whereMonth('data_venda', $mes)->sum('valor_total'),2))
                ->description('Este mês')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Total de Vendas', number_format(DB::table('vendas')->whereYear('data_venda', $ano)->whereMonth('data_venda', $mes)->whereDay('data_venda', $dia)->sum('valor_total'),2))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
        ];
    }
}
