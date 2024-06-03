<?php

namespace App\Filament\Estudiante\Resources\EvaluacionDocenteResource\Pages;

use App\Filament\Estudiante\Resources\EvaluacionDocenteResource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class EvaDocForm extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithRecord;

    public ?array $data = [];
  
    protected static string $resource = EvaluacionDocenteResource::class;

    protected static string $view = 'filament.estudiante.resources.evaluacion-docente-resource.pages.eva-doc-form';

    
    public function mount(int | string $record): void
        {
            $this->form->fill();
            $this->record = $this->resolveRecord($record);
        }
    
        public function form(Form $form): Form
        {
            return $form
                ->schema([
                TextInput::make('pregunta1')
                    ->numeric(),
                TextInput::make('pregunta2')
                    ->numeric(),
                TextInput::make('pregunta3')
                    ->numeric(),
                TextInput::make('pregunta4')
                    ->numeric(),
                TextInput::make('pregunta5')
                    ->numeric(),
                TextInput::make('pregunta6')
                    ->numeric(),
                TextInput::make('pregunta7')
                    ->numeric(),
                TextInput::make('pregunta8')
                    ->numeric(),
                TextInput::make('pregunta9')
                    ->numeric(),
                TextInput::make('pregunta10')
                    ->numeric(),
                TextInput::make('pregunta11')
                    ->numeric(),
                TextInput::make('pregunta12')
                    ->numeric(),
                TextInput::make('pregunta13')
                    ->numeric(),
                TextInput::make('pregunta14')
                    ->numeric(),
                TextInput::make('pregunta15')
                    ->numeric(),
                TextInput::make('pregunta16')
                    ->numeric(),
                TextInput::make('pregunta17')
                    ->numeric(),
                Textarea::make('respuesta_abierta')
                    ->columnSpanFull(),
                ])
                ->statePath('data');
        }

}
