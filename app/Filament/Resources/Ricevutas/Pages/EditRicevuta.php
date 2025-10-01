<?php

namespace App\Filament\Resources\Ricevutas\Pages;

use App\Filament\Resources\Ricevutas\RicevutaResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditRicevuta extends EditRecord
{
    protected static string $resource = RicevutaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
