<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ricevute', function (Blueprint $table) {
            $table->string('cerimonia')->nullable()->after('operatore');
            $table->string('immagine')->nullable()->after('cerimonia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ricevute', function (Blueprint $table) {
            $table->dropColumn(['cerimonia', 'immagine']);
        });
    }
};