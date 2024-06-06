<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getFilamentName(): string
    {
        $userId = Auth::user()->id;

        // Verificar si el usuario es un estudiante
        $estudiante = Estudiante::where('user_id', $userId)->first();
        if ($estudiante) {
            return "{$estudiante->nombre} {$estudiante->apellido_paterno}";
        }

        // Verificar si el usuario es un docente
        $docente = Docente::where('user_id', $userId)->first();
        if ($docente) {
            return "{$docente->nombre} {$docente->apellido_paterno}";
        }

        // Si el usuario no es ni estudiante ni docente, utilizar el nombre de la tabla de usuarios
        return Auth::user()->name;
    }

    public function canAccessPanel(Panel $panel): bool
        {
            if ($panel->getId() === 'admin'){
                return $this->hasRole('Admin');
            }
            return true; 
        }
}
