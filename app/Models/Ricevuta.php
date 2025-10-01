<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ricevuta extends Model
{
    protected $table = 'ricevute';
    
    protected $fillable = [
        'nome_cliente',
        'cognome_cliente',
        'telefono',
        'data_ritiro',
        'ora_ritiro',
        'descrizione',
        'peso',
        'altezza',
        'diametro',
        'operatore',
        'cerimonia',
        'immagine',
    ];

    protected $casts = [
        'data_ritiro' => 'date',
        'ora_ritiro' => 'datetime',
        'peso' => 'decimal:2',
        'altezza' => 'decimal:2',
        'diametro' => 'decimal:2',
    ];

    public function getNomeCompletoAttribute(): string
    {
        return $this->nome_cliente . ' ' . $this->cognome_cliente;
    }
}