<?php

namespace App\Filament\Estudiante\Resources;

use App\Filament\Estudiante\Resources\EvaluacionDocenteResource\Pages;
use App\Filament\Estudiante\Resources\EvaluacionDocenteResource\RelationManagers;
use App\Models\AsignacionEstudiante;
use App\Models\Estudiante;
use App\Models\EvaluacionDocente;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EvaluacionDocenteResource extends Resource
{
    protected static ?string $model = EvaluacionDocente::class;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    public static function getEloquentQuery(): Builder
        {
            $usuarioId = Auth::user()->id;

            $query = parent::getEloquentQuery();

            // Primero, verificar si el usuario autenticado tiene un registro en la tabla estudiantes
            $estudiante = Estudiante::where('user_id', $usuarioId)->first();
            //$estudiante = Estudiante::with('asignaciones')->where('user_id', $usuarioId)->first();
            //dd($estudiante);
            // Si el estudiante existe, filtrar por estudiante_id pertenecientes a ese estudiante
            if ($estudiante) {
                //$query->where('estudiante_id', $estudiante->id);
                // Obtener los ids de las asignaciones del estudiante
                $asignacionEstudianteIds = AsignacionEstudiante::where('estudiante_id', $estudiante->id)->pluck('id');
                
                // Filtrar las evaluaciones por los ids de las asignaciones del estudiante
                $query->whereIn('asignacion_estudiante_id', $asignacionEstudianteIds);
            } else {
                // Si no existe el estudiante, no se aplican filtros adicionales
            }

            return $query;
        }

    public static function getNavigationBadge(): ?string
        {
            // Obtener el ID del usuario autenticado
            $usuarioId = Auth::user()->id;

            // Obtener el estudiante correspondiente al usuario autenticado
            $estudiante = Estudiante::where('user_id', $usuarioId)->first();

            // Si el estudiante no existe, retornar null
            if (!$estudiante) {
                return null;
            }

            // Obtener los IDs de las asignaciones del estudiante
            $asignacionEstudianteIds = AsignacionEstudiante::where('estudiante_id', $estudiante->id)->pluck('id');

            // Contar las evaluaciones pendientes del estudiante
            $evaluacionesPendientesCount = EvaluacionDocente::whereIn('asignacion_estudiante_id', $asignacionEstudianteIds)
                ->where('estado', false) // Filtrar las evaluaciones pendientes
                ->count();

            return $evaluacionesPendientesCount > 0 ? (string)$evaluacionesPendientesCount : null;
        }

    
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('asignacion_estudiante_id')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta1')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta2')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta3')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta4')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta5')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta6')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta7')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta8')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta9')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta10')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta11')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta12')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta13')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta14')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta15')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta16')
                    ->numeric(),
                Forms\Components\TextInput::make('pregunta17')
                    ->numeric(),
                Forms\Components\Textarea::make('respuesta_abierta')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('estado')
                    ->required(),
                Forms\Components\DatePicker::make('fecha_inicio'),
                Forms\Components\DatePicker::make('fecha_fin'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asignacionEstudiante.asignacion.materia.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('estado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\Action::make('Evaluar')
                    ->color('success')
                    ->icon('heroicon-o-pencil')
                    ->hidden(fn(EvaluacionDocente $record) => $record->estado)
                    ->url(fn(EvaluacionDocente $record): string =>  self::getUrl('evaluar', ['record' => $record])),
            ])
            ->filters([
                //
            ])->recordUrl(null);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvaluacionDocentes::route('/'),
            'create' => Pages\CreateEvaluacionDocente::route('/create'),
            'edit' => Pages\EditEvaluacionDocente::route('/{record}/edit'),
            'evaluar' => Pages\EvaDocForm::route('/{record}/evaluar'),
        ];
    }
}
