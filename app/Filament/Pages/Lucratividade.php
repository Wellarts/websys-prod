<?php

namespace App\Filament\Pages;

use App\Filament\Resources\VendaResource;
use App\Models\Venda;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Illuminate\View\View;


class Lucratividade extends Page implements HasTable
{

    use InteractsWithTable;

    protected static string $resource = VendaResource::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.lucratividade';

    protected static ?string $navigationGroup = 'Consultas';

   
    protected static function shouldRegisterNavigation(): bool
    {
        /** @var \App\Models\User */
        $authUser =  auth()->user();

        if($authUser->hasRole('Administrador'))
        {
              return true;
        }
        else
        {
            return false;
        }


    }

    protected function getTableQuery(): Builder|String
    {


                     return Venda::query();

    }

    protected function getTableColumns(): array
    {

                return [
                        Tables\Columns\TextColumn::make('id')
                                ->alignCenter()
                                ->label('Venda'),
                            Tables\Columns\TextColumn::make('cliente.nome')
                                ->sortable()
                                ->searchable(),
                            Tables\Columns\TextColumn::make('data_venda')
                                ->date('d/m/Y')
                                ->sortable()
                                ->alignCenter(),
                            Tables\Columns\BadgeColumn::make('itens_venda_sum_total_custo_atual')->sum('itensVenda', 'total_custo_atual')
                                ->alignCenter()
                                ->label('Custo Produtos')
                                ->money('BRL')
                                ->color('danger'),
                            Tables\Columns\BadgeColumn::make('valor_total')
                                ->alignCenter()
                                ->label('Valor da Venda')
                                ->money('BRL')
                                ->color('warning'),
                            Tables\Columns\BadgeColumn::make('lucro_venda')
                                    ->alignCenter()
                                ->label('Lucro por Venda')
                                ->money('BRL')
                                ->color('success')
                                ->getStateUsing(function (Venda $record): float {
                                    $custoProdutos = $record->itensVenda()->sum('total_custo_atual');
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
