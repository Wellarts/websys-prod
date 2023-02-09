<?php

namespace App\Filament\Resources\FormaPgmtoResource\Pages;

use App\Filament\Resources\FormaPgmtoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFormaPgmtos extends ManageRecords
{
    protected static string $resource = FormaPgmtoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Novo'),
        ];
    }

   
}
