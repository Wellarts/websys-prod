<?php

namespace App\Filament\Resources\ContasReceberResource\Pages;

use App\Filament\Resources\ContasReceberResource;
use App\Filament\Resources\ContasReceberResource\Widgets\ReceberStatsOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Str;

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

    public function updated($name): void
    {
        if (Str::of($name)->contains('tableFilter')) {
            $this->emit('updateWidget', $this->tableFilters);
        }
    }

}
