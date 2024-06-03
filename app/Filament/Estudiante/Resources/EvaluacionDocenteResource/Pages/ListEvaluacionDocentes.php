<?php

namespace App\Filament\Estudiante\Resources\EvaluacionDocenteResource\Pages;

use App\Filament\Estudiante\Resources\EvaluacionDocenteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEvaluacionDocentes extends ListRecords
{
    protected static string $resource = EvaluacionDocenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            
        ];
    }
}
