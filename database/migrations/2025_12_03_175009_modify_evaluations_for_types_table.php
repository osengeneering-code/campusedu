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
        Schema::table('evaluations', function (Blueprint $table) {
            $table->foreignId('evaluation_type_id')->nullable()->constrained('evaluation_types')->cascadeOnDelete();
            $table->dropColumn('type_evaluation');
            $table->dropColumn('bareme_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropForeign(['evaluation_type_id']);
            $table->dropColumn('evaluation_type_id');
            $table->enum('type_evaluation', ['Contrôle Continu', 'Examen Terminal', 'Rattrapage', 'Projet']);
            $table->decimal('bareme_total', 5, 2)->default(20.00);
        });
    }
};
