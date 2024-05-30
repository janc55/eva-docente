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
        Schema::create('asignacion_estudiante', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asignacion_id');
            $table->unsignedBigInteger('estudiante_id');

            $table->foreign('asignacion_id')->references('id')->on('asignacions')->onDelete('cascade');
            $table->foreign('estudiante_id')->references('id')->on('estudiantes')->onDelete('cascade');

            $table->boolean('activo')->default(true);
            $table->enum('estado', ['Aprobado', 'Reprobado', 'En curso'])->default('En curso');
            $table->boolean('eva_estado')->default(false);
            $table->integer('nota_eva_doc')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_estudiantes');
    }
};
