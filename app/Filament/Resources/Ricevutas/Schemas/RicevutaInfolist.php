<?php

namespace App\Filament\Resources\Ricevutas\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RicevutaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Dati Cliente')
                    ->schema([
                        TextEntry::make('nome_cliente')
                            ->label('Nome'),
                        TextEntry::make('cognome_cliente')
                            ->label('Cognome'),
                        TextEntry::make('telefono')
                            ->label('Telefono'),
                    ])->columns(3),

                Section::make('Dettagli Ordine')
                    ->schema([
                        TextEntry::make('cerimonia')
                            ->label('Tipo Cerimonia')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'matrimonio' => 'success',
                                'compleanno' => 'info',
                                default => 'gray',
                            }),
                        TextEntry::make('data_ritiro')
                            ->label('Data di Ritiro')
                            ->date('d/m/Y'),
                        TextEntry::make('ora_ritiro')
                            ->label('Ora di Ritiro')
                            ->time('H:i'),
                        TextEntry::make('operatore')
                            ->label('Operatore'),
                        TextEntry::make('descrizione')
                            ->label('Descrizione')
                            ->columnSpanFull(),
                        ImageEntry::make('immagine')
                            ->label('Foto Torta')
                            ->disk('public')
                            ->columnSpanFull()
                            ->size(300),
                    ])->columns(2),

                Section::make('Misure')
                    ->schema([
                        TextEntry::make('peso')
                            ->label('Peso')
                            ->suffix(' kg'),
                        TextEntry::make('altezza')
                            ->label('Altezza')
                            ->suffix(' cm'),
                        TextEntry::make('diametro')
                            ->label('Diametro')
                            ->suffix(' cm'),
                    ])->columns(3),
            ]);
    }
}