<?php

namespace App\Filament\Resources\VendaResource\Pages;

use App\Filament\Resources\VendaResource;
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
}
