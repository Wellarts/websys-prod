<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Lucros por Venda')
                    ->url(route('filament.resources.vendas.lucro'))
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Consultas')
                    ->sort(3),
            ]);
        });
        
        Filament::serving(function () {
            Filament::registerNavigationItems([
                NavigationItem::make('Estoque Financeiro')
                    ->url(route('filament.resources.produtos.estoque'))
                    ->icon('heroicon-o-presentation-chart-line')
                    ->activeIcon('heroicon-s-presentation-chart-line')
                    ->group('Consultas')
                    ->sort(3),
            ]);
        });
    }

}
