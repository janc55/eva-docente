<?php

namespace App\Filament\Estudiante\Resources\EvaluacionDocenteResource\Pages;

use App\Filament\Estudiante\Resources\EvaluacionDocenteResource;
use App\Models\Asignacion;
use App\Models\AsignacionEstudiante;
use App\Models\Docente;
use App\Models\EvaluacionDocente;
use App\Models\Materia;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\HtmlString;
use Yepsua\Filament\Forms\Components\RangeSlider;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class EvaDocForm extends Page implements HasForms
{
    use InteractsWithForms, InteractsWithRecord;

    public ?array $data = [];
  
    protected static string $resource = EvaluacionDocenteResource::class;

    protected static string $view = 'filament.estudiante.resources.evaluacion-docente-resource.pages.eva-doc-form';

    protected static ?string $title = 'Evaluación Docente';

    public function mount(int | string $record): void
        {
            $this->form->fill();
            $this->record = $this->resolveRecord($record);
            if ($this->record && isset($this->record->asignacion_estudiante_id)) {
                // Establecer el valor del campo oculto
                $this->form->fill([
                    'asignacion_estudiante_id' => $this->record->asignacion_estudiante_id,
                ]);
            }
        }

    public function getSubheading(): ?string
        {
            // Obtener la asignación del estudiante utilizando el asignacion_estudiante_id
            $asignacionEstudiante = AsignacionEstudiante::find($this->record->asignacion_estudiante_id);
            //dd($this->record->asignacion_estudiante_id);

            // Si no se encuentra la asignación del estudiante, retornar null
            if (!$asignacionEstudiante) {
                return null;
            }

            // Obtener la asignación utilizando el asignacion_id
            $asignacion = Asignacion::find($asignacionEstudiante->asignacion_id);
            //dd($asignacion);
            // Si no se encuentra la asignación, retornar null
            if (!$asignacion) {
                return null;
            }

            // Obtener la materia y el docente utilizando los IDs en la asignación
            $materia = Materia::where('cod_mat',$asignacion->cod_mat)->first();
            $docente = Docente::where('cod_doc',$asignacion->cod_doc)->first();
            //dd($materia);

            // Si no se encuentran la materia o el docente, retornar null
            if (!$materia || !$docente) {
                return null;
            }

            // Retornar el nombre de la materia y el nombre del docente
            return __(' :materia - :docente', [
                'materia' => $materia->nombre,
                'docente' => $docente->nombre . ' ' . $docente->apellido_paterno,
            ]);
        }
    
        public function form(Form $form): Form
        {
            return $form     
                ->schema([
                    Section::make('Organización y planificación')
                    ->description(fn() => new HtmlString('<p class="text-gray-400">Califica cada pregunta de acuerdo a la siguiente escala: <br>1: NUNCA 2: RARAMENTE  3: A VECES 4: FRECUENTEMENTE 5: MUY FRECUENTEMENTE</p>'))
                    ->aside()
                    ->schema([
                        Hidden::make('asignacion_estudiante_id')
                            //->default($this->record->asignacion_estudiante_id)
                            ,
                        RangeSlider::make('pregunta1')
                        ->label('Las clases están bien preparadas y organizadas exponiendo con precisión los objetivos del aprendizaje')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta2')
                        ->label('Al inicio de las clases se da a conocer el programa y otros recursos necesarios para el desarrollo de la asignatura.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta3')
                        ->label('El docente ha cumplido con el programa establecido.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                    ]),
                Section::make('Desarrollo de catedra')
                    ->description(fn() => new HtmlString('<p class="text-gray-400">Califica cada pregunta de acuerdo a la siguiente escala: <br>1: NUNCA 2: RARAMENTE  3: A VECES 4: FRECUENTEMENTE 5: MUY FRECUENTEMENTE</p>'))
                    ->aside()
                    ->schema([
                        RangeSlider::make('pregunta4')
                        ->label('El docente explica con claridad utilizando un lenguaje comprensible y técnico en el desarrollo de la clase.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta5')
                        ->label('El docente demuestra dominio del contenido de la asignatura.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta6')
                        ->label('El docente complementa adecuadamente la teoría con la práctica y problemas.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta7')
                        ->label('Utiliza métodos y medios didácticos que facilitan el aprendizaje y estimula la motivación de los estudiantes   (Por Ej.: Expositivo, participativo, ilustrativo, uso de pizarra, data display, videos, grabaciones, modelos, etc.)')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta8')
                        ->label('El docente relaciona los contenidos con otras asignaturas.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                        RangeSlider::make('pregunta9')
                        ->label('El docente realiza actividades de investigación y extensión en su asignatura.')
                        ->steps([
                            '1'  => '1', // should get value: 25  for the A
                            '2'  => '2', // should get value: 50  for the B
                            '3'  => '3', // should get value: 75  for the C
                            '4' => '4',
                            '5' => '5'  // should get value: 100 for the D
                        ]),
                    ]),
                    Section::make('Evaluación del aprendizaje')
                        ->description(fn() => new HtmlString('<p class="text-gray-400">Califica cada pregunta de acuerdo a la siguiente escala: <br>1: NUNCA 2: RARAMENTE  3: A VECES 4: FRECUENTEMENTE 5: MUY FRECUENTEMENTE</p>'))
                        ->aside()
                        ->schema([
                            RangeSlider::make('pregunta10')
                            ->label('Los criterios de evaluación de la asignatura se conocen desde el inicio del curso.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta11')
                            ->label('Los exámenes responden a los contenidos de la asignatura.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta12')
                            ->label('Hace conocer oportunamente los resultados de los exámenes')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta13')
                            ->label('Evalúa y califica los exámenes, prácticas, trabajos y tareas asignadas de manera oportuna.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta14')
                            ->label('Ofrece oportunidades para que los alumnos revisen sus trabajos y evaluaciones y planteen sus puntos de vista.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                        ]),
                        Section::make('Responsabilidad y motivación')
                        ->description(fn() => new HtmlString('<p class="text-gray-400">Califica cada pregunta de acuerdo a la siguiente escala: <br>1: NUNCA 2: RARAMENTE  3: A VECES 4: FRECUENTEMENTE 5: MUY FRECUENTEMENTE</p>'))
                        ->aside()
                        ->schema([
                            RangeSlider::make('pregunta15')
                            ->label('El docente inculca valores éticos y morales en el trabajo en aula.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta16')
                            ->label('El docente demuestra una conducta ética con los alumnos dentro y fuera del aula.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                            RangeSlider::make('pregunta17')
                            ->label('El docente motiva a los alumnos a participar activamente en las actividades de aprendizaje.')
                            ->steps([
                                '1'  => '1', // should get value: 25  for the A
                                '2'  => '2', // should get value: 50  for the B
                                '3'  => '3', // should get value: 75  for the C
                                '4' => '4',
                                '5' => '5'  // should get value: 100 for the D
                            ]),
                        ]),
                        Section::make('Comentarios')
                        ->schema([
                            Textarea::make('respuesta_abierta')
                                ->label('')
                                ->columnSpanFull(),
                        ])
                    
                ])
                ->statePath('data');
        }

        protected function getFormActions(): array
        {
            return [
                Action::make('save')
                    ->label('Enviar')
                    ->action('save'),
            ];
        }

        public function save(): void
        {
            try {
                $data = $this->form->getState();

                // Obtener el asignacion_estudiante_id correspondiente
                $asignacionEstudianteId = $this->record->asignacion_estudiante_id;

                // Buscar el registro existente de EvaluacionDocente
                $evaluacionDocente = EvaluacionDocente::where('asignacion_estudiante_id', $asignacionEstudianteId)->first();

                // Si no se encontró ningún registro, crea uno nuevo
                if (!$evaluacionDocente) {
                    $evaluacionDocente = new EvaluacionDocente();
                }

                // Asignar los valores del formulario a los campos del modelo EvaluacionDocente
                $evaluacionDocente->fill($data);

                // Validar que los campos de las preguntas no sean nulos
                $preguntasFields = ['pregunta1', 
                                    'pregunta2', 
                                    'pregunta3',
                                    'pregunta4',
                                    'pregunta5',
                                    'pregunta6',
                                    'pregunta7',
                                    'pregunta8',
                                    'pregunta9',
                                    'pregunta10',
                                    'pregunta11',
                                    'pregunta12',
                                    'pregunta13',
                                    'pregunta14',
                                    'pregunta15',
                                    'pregunta16',
                                    'pregunta17',];
                $camposVacios = [];
                foreach ($preguntasFields as $field) {
                    if (is_null($evaluacionDocente->$field)) {
                        $camposVacios[] = $field;
                    }
                }

                // Verificar si hay campos vacíos
                if (!empty($camposVacios)) {
                    $camposVaciosString = implode(', ', $camposVacios);
                    Notification::make()
                        ->danger()
                        ->title('Campos sin puntuar')
                        ->body("Los siguientes campos no tienen puntuación: $camposVaciosString")
                        ->send();
                    throw new Halt('Debe completar todos los campos para enviar la evaluación.');
                }

                // Guardar la evaluación docente
                $evaluacionDocente->save();

                // Actualizar el campo de estado después de guardar
                $evaluacionDocente->estado = true;
                $evaluacionDocente->save();
                // Redirect to the index route after successful saving
                
                
            } catch (Halt $exception) {
                return;
            }
            Notification::make() 
            ->success()
            ->title('Evaluación Enviada')
            ->send();

            $this->redirect(route('filament.estudiante.resources.evaluacion-docentes.index'));
        }

}
