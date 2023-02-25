<?php

namespace App\Filament\Resources\ContasReceberResource\Pages;

use App\Filament\Resources\ContasReceberResource;
use App\Filament\Resources\ContasReceberResource\Widgets\ReceberStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class ManageContasRecebers extends ManageRecords
{
    protected static string $resource = ContasReceberResource::class;

    protected static ?string $title = 'Contas a Receber';

    protected function getActions(): array
    {
        return [
          // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ReceberStatsOverview::class,
         //   VendasMesChart::class,
        ];
    }

    protected function getFooter(): View
    {
        return view('filament/contasReceber/footer');
    }

}
