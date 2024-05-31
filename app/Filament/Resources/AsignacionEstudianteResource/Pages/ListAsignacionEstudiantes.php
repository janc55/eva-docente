<?php

namespace App\Filament\Resources\AsignacionEstudianteResource\Pages;

use App\Filament\Resources\AsignacionEstudianteResource;
use App\Models\Asignacion;
use App\Models\AsignacionEstudiante;
use App\Models\Estudiante;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListAsignacionEstudiantes extends ListRecords
{
    protected static string $resource = AsignacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->fields([
                    ImportField::make('cod_mat')
                        ->required(),
                    ImportField::make('cod_est')
                        ->required(),
                    ImportField::make('paralelo')
                        ->required(), 
                    ImportField::make('turno')
                        ->required(),
                ])
                ->handleRecordCreation(function(array $data) { 
                    if (!empty($data)) {
                        // Buscar el estudiante utilizando 'cod_est'
                        $estudiante = Estudiante::where('cod_est', $data['cod_est'])->first();
            
                        // Buscar la asignación utilizando 'cod_mat', 'turno', 'paralelo' y 'gestion_id'
                        // Asegúrate de que 'gestion_id' esté disponible en tus datos o contexto
                        $gestion_id = 1; // Cambia esto según tu contexto actual
                        $asignacion = Asignacion::where([
                            ['cod_mat', '=', $data['cod_mat']],
                            ['turno', '=', $data['turno']],
                            ['paralelo', '=', $data['paralelo']],
                            ['gestion_id', '=', $gestion_id],
                        ])->first();
            
                        if ($estudiante && $asignacion) {
                            // Verificar si la combinación ya existe
                            $existingRecord = AsignacionEstudiante::where([
                                ['asignacion_id', '=', $asignacion->id],
                                ['estudiante_id', '=', $estudiante->id],
                            ])->first();
            
                            if (!$existingRecord) {
                                // Crear la entrada en la tabla 'asignacion_estudiante'
                                return AsignacionEstudiante::create([
                                    'asignacion_id' => $asignacion->id,
                                    'estudiante_id' => $estudiante->id,
                                ]);
                                
                            } else {
                                // Devolver el registro existente si ya existe
                                return $existingRecord;
                            }
                        }
                    }
 
                    // Crear un modelo ficticio si no hay datos válidos para evitar el error
                    return new AsignacionEstudiante();
                }),
        ];
    }
}
