<?php

namespace App\Filament\Resources\Ricevutas\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Utilities\Get; // ✅ Get giusto per Schema

class RicevutaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Dati Cliente')
                    ->columns(1)
                    ->schema([
                        TextInput::make('nome_cliente')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Mario'),

                        TextInput::make('cognome_cliente')
                            ->label('Cognome')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Rossi'),

                        TextInput::make('telefono')
                            ->label('Telefono')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->placeholder('333 1234567')
                            ->suffixIcon('heroicon-o-chat-bubble-left-right')
                            ->suffixIconColor('success')
                            ->extraAttributes(function (Get $get) {
                                $phone = (string) $get('telefono');
                                if ($phone === '') {
                                    return ['class' => 'cursor-not-allowed opacity-60'];
                                }

                                // Pulisce il numero da spazi e simboli
                                $digits = preg_replace('/\D+/', '', $phone);

                                // (Facoltativo) Normalizza prefisso Italia se manca
                                // if (str_starts_with($digits, '00')) {
                                //     $digits = substr($digits, 2);
                                // }
                                // if (! str_starts_with($digits, '39')) {
                                //     $digits = '39' . ltrim($digits, '0');
                                // }

                                // Costruisce messaggio dinamico
                                $nome   = trim((string) $get('nome_cliente'));
                                $tipo   = (string) ($get('cerimonia') ?? '');
                                $op     = (string) ($get('operatore') ?? '');
                                $dataR  = (string) ($get('data_ritiro') ?? '');
                                $oraR   = (string) ($get('ora_ritiro') ?? '');

                                // Format data in dd/mm/YYYY se possibile
                                $dataFormattata = '';
                                if ($dataR !== '') {
                                    try {
                                        $dataFormattata = \Illuminate\Support\Carbon::parse($dataR)->format('d/m/Y');
                                    } catch (\Throwable $e) {
                                        $dataFormattata = $dataR;
                                    }
                                }

                                // Frasi componibili
                                $saluto   = $nome !== '' ? "Ciao {$nome}," : 'Ciao,';
                                $chi      = $op !== '' ? "sono {$op}." : '';
                                $info     = $tipo !== '' ? "Info ordine: {$tipo}." : "Ti scrivo per la tua torta.";
                                $ritiro   = $dataFormattata !== '' ? "Ritiro: {$dataFormattata}" . ($oraR ? " alle {$oraR}" : '') . "." : '';
                                $finale   = "Se hai bisogno di modifiche, rispondi pure qui. Grazie!";

                                $message = trim(implode(' ', array_filter([$saluto, $chi, $info, $ritiro, $finale])));

                                // URL-encode per WhatsApp
                                $text = rawurlencode($message);

                                return [
                                    'class'   => 'cursor-pointer',
                                    'onclick' => "window.open('https://wa.me/{$digits}?text={$text}', '_blank');",
                                ];
                            }),
                    ]),

                Section::make('Dettagli Ordine')
                    ->columns(1)
                    ->schema([
                        Select::make('cerimonia')
                            ->label('Tipo Cerimonia')
                            ->options([
                                'matrimonio'  => 'Matrimonio',
                                'compleanno'  => 'Compleanno',
                                'battesimo'   => 'Battesimo',
                                'comunione'   => 'Comunione',
                                'cresima'     => 'Cresima',
                                'laurea'      => 'Laurea',
                                'anniversario'=> 'Anniversario',
                                'altro'       => 'Altro',
                            ])
                            ->searchable()
                            ->placeholder('Seleziona il tipo'),

                        DatePicker::make('data_ritiro')
                            ->label('Data Ritiro')
                            ->required()
                            ->default(now())
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        TimePicker::make('ora_ritiro')
                            ->label('Ora Ritiro')
                            ->required()
                            ->default(now())
                            ->seconds(false),

                        TextInput::make('operatore')
                            ->label('Operatore')
                            ->required()
                            ->maxLength(255)
                            ->default(auth()->user()?->name),

                        Textarea::make('descrizione')
                            ->label('Descrizione Torta')
                            ->placeholder('Torta nuziale a 3 piani con decorazioni floreali...')
                            ->rows(5),

FileUpload::make('immagine')
    ->label('Foto Torta')
    ->image()
    ->imageEditor()
    ->imageEditorAspectRatios(['16:9','4:3','1:1'])
    ->maxSize(5120)
    ->disk('public')
    ->directory('ricevute')
    ->visibility('public')
    ->downloadable()
    // 👇 NORMALIZZA: rimuove eventuale "storage/" o "public/" dal valore
    ->formatStateUsing(fn ($state) => $state
        ? ltrim(str_replace(['storage/', 'public/'], '', ltrim($state, '/')), '/')
        : null
    )
    ->dehydrateStateUsing(fn ($state) => $state
        ? ltrim(str_replace(['storage/', 'public/'], '', ltrim($state, '/')), '/')
        : null
    )

                    ]),

                Section::make('Misure')
                    ->columns(1)
                    ->schema([
                        TextInput::make('peso')
                            ->label('Peso (kg)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('kg')
                            ->placeholder('5.5')
                            ->minValue(0),

                        TextInput::make('altezza')
                            ->label('Altezza (cm)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('cm')
                            ->placeholder('45')
                            ->minValue(0),

                        TextInput::make('diametro')
                            ->label('Diametro (cm)')
                            ->numeric()
                            ->step(0.01)
                            ->suffix('cm')
                            ->placeholder('30')
                            ->minValue(0),
                    ]),
            ]);
    }
}
