<?php

namespace App\Filament\Resources\ContasPagarResource\Pages;

use App\Filament\Resources\ContasPagarResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageContasPagars extends ManageRecords
{
    protected static string $resource = ContasPagarResource::class;

    protected static ?string $title = 'Contas a Pagar';

    protected function getActions(): array
    {
        return [
            //Actions\CreateAction::make(),
        ];
    }
}
