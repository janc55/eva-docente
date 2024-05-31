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
            Actions\CreateAction::make(),
            ImportAction::make() 
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
                        return Asignacion::create([
                            'cod_doc' => $data['cod_doc'],
                            'cod_mat' => $data['cod_mat'],
                            'gestion_id' => $data['gestion_id'],
                            'turno' => $data['turno'],
                            'paralelo' => $data['paralelo'],
                        ]);
                    }
 
                    return null;  // Retorna null si no hay datos válidos
                }),
        ];
    }
}
