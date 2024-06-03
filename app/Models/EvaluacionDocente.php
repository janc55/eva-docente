<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluacionDocente extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_estudiante_id',
        'pregunta1',
        'pregunta2',
        'pregunta3',
        'pregunta4',
        'pregunta5',
        'pregunta6',
        'pregunta7',
        'pregunta8',
        'pregunta9',
        'pregunta10',
        'pregunta11',
        'pregunta12',
        'pregunta13',
        'pregunta14',
        'pregunta15',
        'pregunta16',
        'pregunta17',
        'respuesta_abierta',
        'estado',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function asignacionEstudiante()
    {
        return $this->belongsTo(AsignacionEstudiante::class);
    }
}
