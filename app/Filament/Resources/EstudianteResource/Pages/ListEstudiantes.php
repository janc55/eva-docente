<?php

namespace App\Filament\Resources\EstudianteResource\Pages;

use App\Filament\Resources\EstudianteResource;
use App\Models\Carrera;
use App\Models\Estudiante;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Hash;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListEstudiantes extends ListRecords
{
    protected static string $resource = EstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->uniqueField('cod_est')
                ->fields([
                    ImportField::make('cod_est')
                        ->required(),
                    ImportField::make('nombre')
                        ->required(), 
                    ImportField::make('apellido_paterno'),
                    ImportField::make('apellido_materno'),
                    ImportField::make('ci')
                        ->required(),
                    ImportField::make('celular'),
                    ImportField::make('car_sigla')
                        ->required(),
                ])
                ->handleRecordCreation(function(array $data) { 
                    if (!empty($data)) {
                        // Convertir nombres y apellidos a mayúsculas manteniendo acentos
                        $nombre = mb_strtoupper($data['nombre'], 'UTF-8');
                        // Verificar si 'apellido_paterno' está definido en $data
                        if (isset($data['apellido_paterno'])) {
                            $apellidoPaterno = mb_strtoupper($data['apellido_paterno'], 'UTF-8');
                        } else {
                            // Asignar un valor predeterminado si 'apellido_paterno' no está definido
                            $apellidoPaterno = ''; // O cualquier otro valor predeterminado que desees
                        }

                        if (isset($data['apellido_materno'])) {
                            $apellidoMaterno = mb_strtoupper($data['apellido_materno'], 'UTF-8');
                        } else {
                            // Asignar un valor predeterminado si 'apellido_paterno' no está definido
                            $apellidoMaterno = ''; // O cualquier otro valor predeterminado que desees
                        }
                        
                        
                        // Reemplazar 'ñ' con 'n' y eliminar caracteres especiales en el apellido paterno
                        $apellidoPaternoFormatted = iconv('UTF-8', 'ASCII//TRANSLIT', $apellidoPaterno);
                        $apellidoPaternoFormatted = preg_replace('/[^a-zA-Z]/', '', $apellidoPaternoFormatted);

                        // Reemplazar 'ñ' con 'n' y eliminar caracteres especiales en el apellido paterno
                        $apellidoMaternoFormatted = iconv('UTF-8', 'ASCII//TRANSLIT', $apellidoMaterno);
                        $apellidoMaternoFormatted = preg_replace('/[^a-zA-Z]/', '', $apellidoMaternoFormatted);
                        
                        if (isset($data['apellido_paterno'])) {
                            // Concatenar apellido paterno formateado y código de estudiante para el correo
                            $email = strtolower($apellidoPaternoFormatted) . $data['cod_est'] . '@unior.edu.bo';
                        } else {
                            $email = strtolower($apellidoMaternoFormatted) . $data['cod_est'] . '@unior.edu.bo';
                        }
                        
                        // Concatenar apellido paterno formateado y código de estudiante para el correo
                        $email = strtolower($apellidoPaternoFormatted) . $data['cod_est'] . '@unior.edu.bo';

                        // Obtener solo la parte numérica inicial del CI
                        preg_match('/^\d+/', $data['ci'], $matches);
                        $ciNumero = $matches[0] ?? null;

                        if (!$ciNumero) {
                            throw new \Exception('El CI no es válido.');
                        }
                        
                        // Crear contraseña por defecto
                        $password = Hash::make($ciNumero . '#Un');
                        
                        // Crear registro de usuario
                        $user = User::create([
                            'name' => $data['cod_est'],
                            'email' => $email,
                            'password' => $password,
                        ]);
                        
                        // Crear registro de docente incluyendo el user_id
                        $estudiante = Estudiante::create([
                            'cod_est' => $data['cod_est'],
                            'nombre' => $nombre,
                            'apellido_paterno' => $apellidoPaterno ?? null,
                            'apellido_materno' => $apellidoMaterno ?? null,
                            'ci' => $ciNumero,
                            'celular' => $data['celular'] ?? null,
                            'user_id' => $user->id,  // Relación con el usuario
                        ]);

                        // Relacionar estudiante con carrera
                        $carrera = Carrera::where('sigla', $data['car_sigla'])->first();

                        if ($carrera) {
                            $estudiante->carreras()->attach($carrera->id);
                        } else {
                            throw new \Exception('La carrera con sigla ' . $data['car_sigla'] . ' no fue encontrada.');
                        }
                        
                        return $estudiante;
                    }
            
                    return null;  // Retorna null si no hay datos válidos
                }),
        ];
    }
}
