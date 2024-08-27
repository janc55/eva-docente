<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistaNombre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'nombre_comp'
    ];

    protected $table = 'vista_nombre';

    protected $primary = 'id';

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'id', 'id');

    }
}
