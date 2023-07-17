<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CompraResource\Widgets\ComprasMesChart;
use App\Filament\Resources\VendaResource\Widgets\VendasMesChart;
use App\Filament\Widgets\PagarHojeStatsOverview;
use App\Filament\Widgets\ReceberHojeStatsOverview;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';


    public function mount() {
        Notification::make()
            ->title('ATENÇÃO')
            ->persistent()
            ->danger()
            ->body('Sua mensalidade está atrasada, regularize sua assinatura para evitar o bloqueio do sistema.')
            ->actions([ 
                Action::make('Entendi')
                    ->button()
                    ->close(),
                ]) 
            ->send();
    }



    protected function getHeaderWidgets(): array
    {

        

        return [
            AccountWidget::class,
            PagarHojeStatsOverview::class,
            ReceberHojeStatsOverview::class,
            VendasMesChart::class,
            ComprasMesChart::class,


        ];
    }
}
