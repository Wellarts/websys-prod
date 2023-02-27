<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
use App\Models\Venda;
use Filament\Tables;
use Filament\Resources\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;

class LucroVenda extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = VendaResource::class;

    protected static string $view = 'filament.resources.venda-resource.pages.lucro-venda';

    protected function getTableQuery(): Builder
    {
        return Venda::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('cliente.nome'),
                Tables\Columns\TextColumn::make('data_venda'),
                Tables\Columns\BadgeColumn::make('itens_venda_sum_valor_custo_atual')->sum('itensVenda', 'valor_custo_atual')
                    ->label('Custo Produtos')
                    ->money('BRL')
                    ->color('danger'),
                Tables\Columns\BadgeColumn::make('valor_total')
                    ->label('Valor da Venda')
                    ->money('BRL')
                    ->color('warning'),
                Tables\Columns\BadgeColumn::make('lucro_venda')
                    ->label('Lucro por Venda')
                     ->money('BRL')
                     ->color('success')
                     ->getStateUsing(function (Venda $record): float {
                        $custoProdutos = $record->itensVenda()->sum('valor_custo_atual');
                        return ($record->valor_total - $custoProdutos)*100;
                    })




        ];
    }

    protected function getTableFilters(): array
     {

        return [
            SelectFilter::make('cliente')->relationship('cliente', 'nome'),

           Filter::make('data_vencimento')
            ->form([
                DatePicker::make('venda_de')
                    ->label('Data da Venda de:'),
               DatePicker::make('venda_ate')
                    ->label('Data da Venda até:'),
            ])
            ->query(function ($query, array $data) {
                $query
                    ->when($data['venda_de'],
                        fn($query) => $query->whereDate('data_venda', '>=', $data['venda_de']))
                    ->when($data['venda_ate'],
                        fn($query) => $query->whereDate('data_venda', '<=', $data['venda_ate']));
            })

        ];


     }

     protected function getFooter(): View
     {
         return view('filament/lucroVenda/footer');
     }



}
