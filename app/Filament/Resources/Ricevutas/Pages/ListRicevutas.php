<?php

namespace App\Filament\Resources\Ricevutas\Pages;

use App\Filament\Resources\Ricevutas\RicevutaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRicevutas extends ListRecords
{
    protected static string $resource = RicevutaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
