<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
use App\Filament\Resources\VendaResource\Widgets\VendaStatsOverview;
use App\Filament\Widgets\TotalVendaStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVenda extends EditRecord
{
    protected static string $resource = VendaResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\CreateAction::make('teste')
            ->label("Imprimir")
            ->url(route('comprovante', $this->record))
            ->openUrlInNewTab(),
        ];
    }

    protected function getHeaderWidgets(): array
    {



        return [
         //  TotalVendaStatsOverview::class

        ];
    }
}
