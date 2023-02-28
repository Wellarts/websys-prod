<?php

namespace App\Filament\Resources\CompraResource\Pages;

use App\Filament\Resources\CompraResource;
use App\Filament\Resources\CompraResource\Widgets\CompraStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompras extends ListRecords
{
    protected static string $resource = CompraResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CompraStatsOverview::class
           
        ];
    }
}
