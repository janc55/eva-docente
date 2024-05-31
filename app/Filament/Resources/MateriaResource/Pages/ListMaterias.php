<?php

namespace App\Filament\Resources\MateriaResource\Pages;

use App\Filament\Resources\MateriaResource;
use App\Models\Carrera;
use App\Models\Materia;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Konnco\FilamentImport\Actions\ImportAction;
use Konnco\FilamentImport\Actions\ImportField;

class ListMaterias extends ListRecords
{
    protected static string $resource = MateriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ImportAction::make() 
                ->uniqueField('cod_mat')
                ->fields([
                    ImportField::make('cod_mat')
                        ->required(),
                    ImportField::make('nombre')
                        ->required(), 
                    ImportField::make('sigla')
                        ->required(),
                    ImportField::make('semestre')
                        ->required(), 
                    ImportField::make('carrera.sigla')
                        ->required()
                        ->label('Carrera'),
                ])
                ->handleRecordCreation(function(array $data) { 
                    if ($carrera = Carrera::all()->where('sigla', $data['carrera']['sigla'])->first()) {
                        return Materia::create([
                            'cod_mat' => $data['cod_mat'],
                            'nombre' => $data['nombre'],
                            'sigla' => $data['sigla'],
                            'semestre' => $data['semestre'],
                            'carrera_id' => $carrera->id,
                        ]);
                    }
 
                    return new Carrera();
                }),
        ];
    }
}
