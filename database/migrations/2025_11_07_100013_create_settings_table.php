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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->decimal('tva', 5, 2)->default(18.00);
            $table->decimal('caution_standard', 10, 2);
            $table->decimal('tarif_km_supplementaire', 10, 2);
            $table->string('email_notification');
            $table->string('logo_facture')->nullable();
            $table->string('devise')->default('FCFA');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
