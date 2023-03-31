<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Traits\HasRoles;


class AppServiceProvider extends ServiceProvider
{
    use HasRoles;
    /**
     * Register any application services.
     *
     * @return void
     */


    public function register()
    {

    }


    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Filament::registerScripts([
            'https://unpkg.com/@alpinejs/mask@3.x.x/dist/cdn.min.js',
        ], true);
        
       /*      Filament::serving(function () {
                    Filament::registerNavigationItems([
                        NavigationItem::make('Lucros por Venda')
                            ->url(route('filament.resources.vendas.lucro'))
                            ->icon('heroicon-o-presentation-chart-line')
                            ->activeIcon('heroicon-s-presentation-chart-line')
                            ->group('Consultas')
                            ->sort(3),
                    ]);
                });
/*
        Filament::serving(function () {

            $Expira = Config::find(1);
            $validade = $Expira->validade;
            $hoje = date('Y-m-d');

            if($validade <= $hoje)
                {
                    Notification::make()
                    ->title('LICENÇA EXPIRADA!')
                    ->danger()
                    //->persistent()
                    ->send();

                    Auth::logout();
                    return to_route('filament.auth.login')->with('Unauthorized');
                }

        });

   }

}
