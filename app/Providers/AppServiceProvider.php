<?php

namespace App\Providers;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Contracts\Role;

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

        Filament::serving(function () {
           // $user = auth('web')->user()->hasRole('Administrador');;
        //   /** @var \App\Models\User */
       //     $authUser =  auth()->user();    
           // dd($authUser);
       //     if($authUser->hasRole('Administrador')) {
                Filament::registerNavigationItems([
                    NavigationItem::make('Estoque Financeiro')
                        ->url(route('filament.resources.produtos.estoque'))
                        ->icon('heroicon-o-presentation-chart-line')
                        ->activeIcon('heroicon-s-presentation-chart-line')
                        ->group('Consultas')
                        ->sort(3),
                        
                ]);
       //     }
       
       });   
    }

}
