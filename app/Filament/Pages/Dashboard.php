<?php

namespace App\Filament\Pages;

use App\Filament\Resources\CompraResource\Widgets\ComprasMesChart;
use App\Filament\Resources\VendaResource\Widgets\VendasMesChart;
use App\Filament\Widgets\PagarHojeStatsOverview;
use App\Filament\Widgets\ReceberHojeStatsOverview;
use Filament\Pages\Page;
use Filament\Widgets\AccountWidget;


class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

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
