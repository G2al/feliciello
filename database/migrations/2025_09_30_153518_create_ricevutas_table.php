<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ricevute', function (Blueprint $table) {
            $table->id();
            $table->string('nome_cliente');
            $table->string('cognome_cliente');
            $table->string('telefono');
            $table->date('data_ritiro');
            $table->time('ora_ritiro');
            $table->text('descrizione')->nullable();
            $table->decimal('peso', 8, 2)->nullable();
            $table->decimal('altezza', 8, 2)->nullable();
            $table->decimal('diametro', 8, 2)->nullable();
            $table->string('operatore');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ricevute');
    }
};