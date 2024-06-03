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
        Schema::create('evaluacion_docentes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignacion_estudiante_id')->nullable();
            $table->integer('pregunta1')->nullable();
            $table->integer('pregunta2')->nullable();
            $table->integer('pregunta3')->nullable();
            $table->integer('pregunta4')->nullable();
            $table->integer('pregunta5')->nullable();
            $table->integer('pregunta6')->nullable();
            $table->integer('pregunta7')->nullable();
            $table->integer('pregunta8')->nullable();
            $table->integer('pregunta9')->nullable();
            $table->integer('pregunta10')->nullable();
            $table->integer('pregunta11')->nullable();
            $table->integer('pregunta12')->nullable();
            $table->integer('pregunta13')->nullable();
            $table->integer('pregunta14')->nullable();
            $table->integer('pregunta15')->nullable();
            $table->integer('pregunta16')->nullable();
            $table->integer('pregunta17')->nullable();
            $table->text('respuesta_abierta')->nullable();
            $table->boolean('estado')->default(false);
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();

            $table->foreign('asignacion_estudiante_id')
                  ->references('id')
                  ->on('asignacion_estudiante')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluacion_docentes');
    }
};
