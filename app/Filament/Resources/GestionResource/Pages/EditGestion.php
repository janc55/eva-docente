<?php

namespace App\Filament\Resources\GestionResource\Pages;

use App\Filament\Resources\GestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGestion extends EditRecord
{
    protected static string $resource = GestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}