<?php

namespace App\Filament\Pages;

use App\Filament\Resources\ProdutoResource;
use App\Models\Produto;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;

class EstoqueContabil extends Page  implements HasTable
{

    use InteractsWithTable;

    protected static string $resource = ProdutoResource::class;



    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.estoque-contabil';

    protected static ?string $navigationGroup = 'Consultas';

    protected static ?string $navigationLabel = 'Estoque Contábil';

    protected static ?string $title = 'Estoque Contábil';

    


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

    protected function getTableQuery(): Builder
    {
        return Produto::query();
    }

    protected function getTableColumns(): array
    {
        return [
                Tables\Columns\TextColumn::make('nome')
                    ->label('Produto')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('estoque')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('valor_compra')
                    ->money('BRL'),
                Tables\Columns\TextColumn::make('lucratividade')
                    ->alignCenter()
                    ->label('Lucratividade (%)'),
                Tables\Columns\TextColumn::make('valor_venda')
                    ->alignCenter()
                    ->money('BRL'),
                Tables\Columns\BadgeColumn::make('total_compra')
                    ->alignCenter()
                    ->getStateUsing(function (Produto $record): float {
                        return (($record->estoque * $record->valor_compra)*100);
                })
                    ->money('BRL')
                    ->color('danger'),
                Tables\Columns\BadgeColumn::make('total_venda')
                    ->alignCenter()
                    ->getStateUsing(function (Produto $record): float {
                    return ($record->estoque * $record->valor_venda)*100;
                })
                    ->money('BRL')
                    ->color('warning'),
                Tables\Columns\BadgeColumn::make('total_lucratividade')
                    ->alignCenter()
                    ->getStateUsing(function (Produto $record): float {
                         return ((($record->estoque * $record->valor_venda)*100) - (($record->estoque * $record->valor_compra)*100));
                })
                    ->color('success')
                    ->money('BRL'),


        ];
    }





    protected function getFooter(): View
    {
        $allEstoque = Produto::all();

        foreach($allEstoque as $all)
        {
            $all->total_compra = ($all->estoque * $all->valor_compra);
            $all->total_venda = ($all->estoque * $all->valor_venda);
            $all->total_lucratividade = ($all->total_venda - $all->total_compra);
            $all->save();
        }


        return view('filament/estoqueProduto/footer');
    }

}
