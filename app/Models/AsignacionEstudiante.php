<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionEstudiante extends Model
{
    use HasFactory;

    // Personalización de la tabla, si es necesario
    protected $table = 'asignacion_estudiante';

    // Agregar los campos adicionales al modelo
    protected $fillable = [
        'asignacion_id',
        'estudiante_id',
        'activo',
        'estado',
        'eva_estado',
        'nota_eva_doc'
    ];

    // Definir la relación con el modelo Estudiante
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    // Definir la relación con el modelo Asignacion
    public function asignacion()
    {
        return $this->belongsTo(Asignacion::class);
    }

    public function evaluacionDocente()
    {
        return $this->hasOne(EvaluacionDocente::class);
    }
}
