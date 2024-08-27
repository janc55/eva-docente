<?php

namespace App\Filament\Docente\Resources;

use App\Filament\Docente\Resources\AsignacionResource\Pages;
use App\Filament\Docente\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use App\Models\Docente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Label;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
        {
            $usuarioId = Auth::user()->id;

            $query = parent::getEloquentQuery();

            // Primero, verificar si el usuario autenticado tiene un registro en la tabla estudiantes
            $docente = Docente::where('user_id', $usuarioId)->first();

            // Si el estudiante existe, filtrar por estudiante_id pertenecientes a ese estudiante
            if ($docente) {
                $query->where('cod_doc', $docente->cod_doc);
            } else {
                // Si no existe el estudiante, no se aplican filtros adicionales
            }

            return $query;
        }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cod_doc')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cod_mat')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('gestion_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('activo')
                    ->required(),
                Forms\Components\TextInput::make('turno')
                    ->required(),
                Forms\Components\TextInput::make('paralelo')
                    ->required()
                    ->maxLength(255)
                    ->default('A'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('materia.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gestion_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('turno'),
                Tables\Columns\TextColumn::make('paralelo')
                    ->searchable(),
                TextColumn::make('promedio_evaluacion_docente')
                    ->label('Evaluación Docente')
                    ->state(function (Model $record): float {
                        return $record->asignacionesEstudiantes()
                            ->whereNotNull('nota_eva_doc')
                            ->avg('nota_eva_doc') ?? 0;
                    })
                    ->numeric(2),
                TextColumn::make('evaluaciones_realizadas')
                    ->label('Evaluaciones Realizadas')
                    ->state(function (Asignacion $record): int {
                        return $record->estudiantes()
                            ->whereNotNull('nota_eva_doc')
                            ->count();
                    }),
                TextColumn::make('evaluaciones_vs_total')
                    ->label('Evaluaciones / Total Estudiantes')
                    ->state(function (Asignacion $record): string {
                        $evaluacionesRealizadas = $record->estudiantes()
                            ->whereNotNull('nota_eva_doc')
                            ->count();
                        $totalEstudiantes = $record->estudiantes()->count();
                        
                        return "{$evaluacionesRealizadas} / {$totalEstudiantes}";
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
               
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
            'index' => Pages\ListAsignacions::route('/'),
            'create' => Pages\CreateAsignacion::route('/create'),
            'edit' => Pages\EditAsignacion::route('/{record}/edit'),
            'evaluacion-docente' => Pages\EvaluacionDocente::route('/{record}/evaluacion-docente'),
        ];
    }
}
