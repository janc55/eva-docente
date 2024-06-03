<?php

namespace App\Filament\Estudiante\Resources\EvaluacionDocenteResource\Pages;

use App\Filament\Estudiante\Resources\EvaluacionDocenteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEvaluacionDocente extends EditRecord
{
    protected static string $resource = EvaluacionDocenteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
