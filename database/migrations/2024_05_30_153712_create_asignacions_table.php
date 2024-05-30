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
        Schema::create('asignacions', function (Blueprint $table) {
            $table->id();
            $table->string('cod_doc');  
            $table->string('cod_mat');  
            $table->foreignId('gestion_id')->constrained();
            $table->boolean('activo')->default(true);
            $table->enum('turno', ['MAÑANA', 'NOCHE'])->default('MAÑANA');
            $table->string('paralelo')->default('A');
            $table->string('slug')->nullable();

            // Definir las claves foráneas
            $table->foreign('cod_doc')->references('cod_doc')->on('docentes')->onDelete('set null');
            $table->foreign('cod_mat')->references('cod_mat')->on('materias')->onDelete('set null');
            $table->unique(['gestion_id', 'cod_mat', 'turno', 'paralelo'], 'asignacion_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacions');
    }
};
