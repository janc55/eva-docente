<?php

namespace App\Filament\Resources\AsignacionResource\Pages;

use App\Filament\Resources\AsignacionResource;
use App\Models\Asignacion;
use App\Models\AsignacionEstudiante;
use App\Models\Docente;
use App\Models\EvaluacionDocente;
use App\Models\Materia;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class VistaEvaluacionDocente extends Page
{
    use InteractsWithRecord;
    
    protected static string $resource = AsignacionResource::class;

    protected static string $view = 'filament.resources.asignacion-resource.pages.vista-evaluacion-docente';

    protected static ?string $title = 'Evaluación Docente';

    public Asignacion $asignacion;
    public Collection $asignacionEstudiantes;
    public Collection $evaluaciones;

    public function mount(int | string $record): void
        {
            $this->record = $this->resolveRecord($record);
            $this->asignacion = Asignacion::findOrFail($this->record->id);

            // Obtener todas las asignaciones de estudiantes relacionadas
            $this->asignacionEstudiantes = AsignacionEstudiante::where('asignacion_id', $this->asignacion->id)->get();

             // Obtener todas las evaluaciones relacionadas cuyo estado sea true
            $asignacionEstudianteIds = $this->asignacionEstudiantes->pluck('id');
            $this->evaluaciones = EvaluacionDocente::whereIn('asignacion_estudiante_id', $asignacionEstudianteIds)
                                                ->where('estado', true)
                                                ->get();
        }

    public function getPromediosProperty()
        {
            // Inicializar arreglos para sumar las secciones
            $seccion1 = $seccion2 = $seccion3 = $seccion4 = 0;
            $totalEvaluaciones = $this->evaluaciones->count();
    
            foreach ($this->evaluaciones as $evaluacion) {
                $seccion1 += ($evaluacion->pregunta1 + $evaluacion->pregunta2 + $evaluacion->pregunta3 + $evaluacion->pregunta4) / 4;
                $seccion2 += ($evaluacion->pregunta5 + $evaluacion->pregunta6 + $evaluacion->pregunta7 + $evaluacion->pregunta8) / 4;
                $seccion3 += ($evaluacion->pregunta9 + $evaluacion->pregunta10 + $evaluacion->pregunta11 + $evaluacion->pregunta12) / 4;
                $seccion4 += ($evaluacion->pregunta13 + $evaluacion->pregunta14 + $evaluacion->pregunta15 + $evaluacion->pregunta16 + $evaluacion->pregunta17) / 5;
            }
    
            // Calcular los promedios
            $promedioSeccion1 = $totalEvaluaciones ? $seccion1 / $totalEvaluaciones : 0;
            $promedioSeccion2 = $totalEvaluaciones ? $seccion2 / $totalEvaluaciones : 0;
            $promedioSeccion3 = $totalEvaluaciones ? $seccion3 / $totalEvaluaciones : 0;
            $promedioSeccion4 = $totalEvaluaciones ? $seccion4 / $totalEvaluaciones : 0;
    
            return [
                'seccion1' => number_format($promedioSeccion1, 2),
                'seccion2' => number_format($promedioSeccion2, 2),
                'seccion3' => number_format($promedioSeccion3, 2),
                'seccion4' => number_format($promedioSeccion4, 2),
            ];
        }

    public function getSubheading(): ?string
        {
            // Obtener la asignación utilizando el asignacion_id
            $asignacion = Asignacion::find($this->record->id);
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

    public function getDatosProperty()
        {
            return $this->datos();
        }

    public function datos(){
        return "Hola Mundo 2";
    }
}
