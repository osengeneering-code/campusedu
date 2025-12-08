<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('parcours', function (Blueprint $table) {
            $table->decimal('frais_inscription', 10, 2)->nullable()->after('description');
            $table->decimal('frais_formation', 10, 2)->nullable()->after('frais_inscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('parcours', function (Blueprint $table) {
            $table->dropColumn(['frais_inscription', 'frais_formation']);
        });
    }
};
