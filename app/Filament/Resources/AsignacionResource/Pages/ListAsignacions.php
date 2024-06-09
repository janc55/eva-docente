<?php

namespace App\Filament\Resources\AsignacionResource\Pages;

use App\Filament\Resources\AsignacionResource;
use App\Models\Asignacion;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListAsignacions extends ListRecords
{
    protected static string $resource = AsignacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Nueva Asignación'),
            ImportAction::make()
                ->label('Importar') 
                ->fields([
                    ImportField::make('cod_doc')
                        ->required(),
                    ImportField::make('cod_mat')
                        ->required(), 
                    ImportField::make('gestion_id')
                        ->required(),
                    ImportField::make('turno')
                        ->required(), 
                    ImportField::make('paralelo')
                        ->required(),
                ])
                ->handleRecordCreation(function(array $data) { 
                    if (!empty($data)) {
                        try {
                            // Convertir el turno a mayúsculas
                            $turno = strtoupper($data['turno']);
            
                            // Crear la asignación
                            return Asignacion::create([
                                'cod_doc' => $data['cod_doc'],
                                'cod_mat' => $data['cod_mat'],
                                'gestion_id' => $data['gestion_id'],
                                'turno' => $turno,
                                'paralelo' => $data['paralelo'],
                            ]);
                        } catch (\Illuminate\Database\QueryException $exception) {
                            // Manejar el error de duplicado
                            if ($exception->getCode() == 23000) { // Código de error para violación de restricción única
                                // Puedes manejar este error como prefieras
                                // Por ejemplo, podrías loguearlo o devolver un mensaje específico
                                return new Asignacion(); // O manejarlo de otra manera
                            } else {
                                // Relanzar la excepción si no es un error de duplicado
                                throw $exception;
                            }
                        }
                    }
 
                    return new Asignacion();  // Retorna una instancia vacía si no hay datos válidos
                }),
        ];
    }
}
