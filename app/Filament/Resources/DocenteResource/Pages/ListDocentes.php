<?php

namespace App\Filament\Resources\DocenteResource\Pages;

use App\Filament\Resources\DocenteResource;
use App\Models\Docente;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Hash;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListDocentes extends ListRecords
{
    protected static string $resource = DocenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->uniqueField('cod_doc')
                ->fields([
                    ImportField::make('cod_doc')
                        ->required(),
                    ImportField::make('nombre')
                        ->required(), 
                    ImportField::make('apellido_paterno')
                        ->required(),
                    ImportField::make('apellido_materno')
                        ->required(), 
                ])
                ->handleRecordCreation(function(array $data) { 
                    if (!empty($data)) {
                        // Obtener solo el primer nombre en caso de nombres compuestos
                        $nombres = explode(' ', $data['nombre']);
                        $primerNombre = strtolower($nombres[0]);

                        $apellido = strtolower($data['apellido_paterno']);
                        
                        // Eliminar acentos y caracteres especiales
                        $primerNombre = iconv('UTF-8', 'ASCII//TRANSLIT', $primerNombre);
                        $apellido = iconv('UTF-8', 'ASCII//TRANSLIT', $apellido);
                        
                        // Reemplazar 'ñ' con 'n'
                        $primerNombre = str_replace('ñ', 'n', $primerNombre);
                        $apellido = str_replace('ñ', 'n', $apellido);
                        
                        // Quitar cualquier carácter no deseado que pueda haber quedado
                        $primerNombre = preg_replace('/[^a-z]/', '', $primerNombre);
                        $apellido = preg_replace('/[^a-z]/', '', $apellido);
                        
                        // Concatenar nombre y apellido con guión bajo
                        $username = $primerNombre . '_' . $apellido;
                        
                        // Crear correo electrónico
                        $email = $username . '@unior.edu.bo';
                        
                        // Crear contraseña por defecto
                        $password = Hash::make('123456#Un');
                        
                        // Crear registro de usuario
                        $user = User::create([
                            'name' => $username,
                            'email' => $email,
                            'password' => $password,
                        ]);
                        
                        // Crear registro de docente incluyendo el user_id
                        $docente = Docente::create([
                            'cod_doc' => $data['cod_doc'],
                            'nombre' => $data['nombre'],
                            'apellido_paterno' => $data['apellido_paterno'],
                            'apellido_materno' => $data['apellido_materno'],
                            'user_id' => $user->id,  // Relación con el usuario
                        ]);
                        
                        return $docente;
                    }
            
                    return null;  // Retorna null si no hay datos válidos
                }),
        ];
    }
}
