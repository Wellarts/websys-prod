<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
use App\Filament\Resources\VendaResource\Widgets\VendaStatsOverview;
use App\Filament\Resources\VendasResource\Widgets\ResumoVendas;
use App\Filament\Widgets\TotalVendaStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendas extends ListRecords
{
    protected static string $resource = VendaResource::class;

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
            VendaStatsOverview::class
           
        ];
    }

     
}
