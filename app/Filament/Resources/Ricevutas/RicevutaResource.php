<?php

namespace App\Filament\Resources\Ricevutas;

use App\Filament\Resources\Ricevutas\Pages\CreateRicevuta;
use App\Filament\Resources\Ricevutas\Pages\EditRicevuta;
use App\Filament\Resources\Ricevutas\Pages\ListRicevutas;
use App\Filament\Resources\Ricevutas\Pages\ViewRicevuta;
use App\Filament\Resources\Ricevutas\Schemas\RicevutaForm;
use App\Filament\Resources\Ricevutas\Schemas\RicevutaInfolist;
use App\Filament\Resources\Ricevutas\Tables\RicevutasTable;
use App\Models\Ricevuta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RicevutaResource extends Resource
{
    protected static ?string $model = Ricevuta::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'id';
    
    protected static ?string $navigationLabel = 'Ricevute';
    
    protected static ?string $modelLabel = 'ricevuta';
    
    protected static ?string $pluralModelLabel = 'ricevute';

    public static function form(Schema $schema): Schema
    {
        return RicevutaForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return RicevutaInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RicevutasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRicevutas::route('/'),
            'create' => CreateRicevuta::route('/create'),
            'view' => ViewRicevuta::route('/{record}'),
            'edit' => EditRicevuta::route('/{record}/edit'),
        ];
    }
}