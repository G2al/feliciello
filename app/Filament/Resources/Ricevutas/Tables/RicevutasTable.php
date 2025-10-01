<?php

namespace App\Filament\Resources\Ricevutas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Ricevuta;

class RicevutasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                ImageColumn::make('immagine')
                    ->label('Foto')
                    ->disk('public')  // <-- AGGIUNGI QUESTA RIGA
                    ->circular()
                    ->size(40),
                TextColumn::make('nome_cliente')
                    ->label('Nome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cognome_cliente')
                    ->label('Cognome')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('telefono')
                    ->label('Telefono')
                    ->searchable(),
                TextColumn::make('cerimonia')
                    ->label('Cerimonia')
                    ->searchable()
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'matrimonio' => 'success',
                        'compleanno' => 'info',
                        'battesimo' => 'warning',
                        'comunione' => 'primary',
                        'cresima' => 'gray',
                        'laurea' => 'success',
                        'anniversario' => 'danger',
                        'altro' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('data_ritiro')
                    ->label('Data Ritiro')
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('ora_ritiro')
                    ->label('Ora Ritiro')
                    ->time('H:i'),
                TextColumn::make('operatore')
                    ->label('Operatore')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('scarica_pdf')
                    ->label('Ricevuta')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(function (Ricevuta $record) {
                        return response()->streamDownload(function () use ($record) {
                            echo Pdf::loadView('pdf.ricevuta', ['ricevuta' => $record])
                                ->setPaper('a4')
                                ->stream();
                        }, 'ricevuta_' . $record->id . '.pdf');
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }
}