<?php

namespace App\Filament\Resources\Ricevutas\Pages;

use App\Filament\Resources\Ricevutas\RicevutaResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewRicevuta extends ViewRecord
{
    protected static string $resource = RicevutaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
