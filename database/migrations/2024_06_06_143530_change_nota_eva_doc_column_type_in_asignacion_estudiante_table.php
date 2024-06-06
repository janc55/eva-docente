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
        Schema::table('asignacion_estudiante', function (Blueprint $table) {
            $table->decimal('nota_eva_doc', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asignacion_estudiante', function (Blueprint $table) {
            $table->integer('nota_eva_doc')->change();
        });
    }
};
