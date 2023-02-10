<?php

namespace App\Filament\Resources\FuncionarioResource\Pages;

use App\Filament\Resources\FuncionarioResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageFuncionarios extends ManageRecords
{
    protected static string $resource = FuncionarioResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->modalHeading('Criar funcionários')
            ->label('Novo'),
        ];
    }
}
