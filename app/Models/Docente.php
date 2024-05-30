<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Clave primaria autoincremental

    protected $fillable = [
        'cod_doc',
        'nombre',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'celular',
        'foto',
        'activo',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'cod_doc', 'cod_doc');
    }
}
