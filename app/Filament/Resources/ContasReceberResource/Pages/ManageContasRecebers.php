<?php

namespace App\Filament\Resources\ContasReceberResource\Pages;

use App\Filament\Resources\ContasReceberResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

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
}
