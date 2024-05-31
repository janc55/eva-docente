<?php

namespace App\Filament\Estudiante\Resources\AsignacionEstudianteResource\Pages;

use App\Filament\Estudiante\Resources\AsignacionEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsignacionEstudiantes extends ListRecords
{
    protected static string $resource = AsignacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
