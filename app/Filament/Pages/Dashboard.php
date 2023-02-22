<?php

namespace App\Filament\Pages;

use App\Filament\Resources\FluxoCaixaResource\Widgets\CaixaStatsOverview;
use App\Filament\Resources\VendaResource\Widgets\VendasMesChart;
use App\Filament\Resources\VendaResource\Widgets\VendaStatsOverview;
use App\Filament\Widgets\TotalVendaStatsOverview;
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
           // Widgets\FilamentInfoWidget::class,
            CaixaStatsOverview::class,
            VendaStatsOverview::class,
            VendasMesChart::class

        ];
    }
}
