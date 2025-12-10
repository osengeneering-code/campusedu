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
        Schema::table('ues', function (Blueprint $table) {
            $table->float('coefficient')->default(1)->after('credits_ects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ues', function (Blueprint $table) {
            $table->dropColumn('coefficient');
        });
    }
};
