<?php

namespace App\Filament\Widgets;


use App\Models\Venda;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TotalVendaStatsOverview extends BaseWidget
{

    public ?Model $record = null;




    protected function getCards(): array
    {

        $mes = date('m');
        $dia = date('d');
        return [
            Card::make('Quantidade de Itens',DB::table('itens_vendas')->where('venda_id', $this->record->id)->sum('qtd'))
                ->description('total')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Valor Total da Venda', number_format(Venda::all()->where('id', $this->record->id)->sum('valor_total'),2, ",", "."))
                ->description('Itens da Venda')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
         /*   Card::make('Total de Vendas', DB::table('vendas')->whereDay('data_venda', $dia)->sum('valor_total'))
                ->description('Hoje')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'), */
        ];
    }


}
