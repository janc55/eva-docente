<?php

namespace App\Filament\Resources\AsignacionEstudianteResource\Pages;

use App\Filament\Resources\AsignacionEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsignacionEstudiante extends EditRecord
{
    protected static string $resource = AsignacionEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
