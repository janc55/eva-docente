<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use App\Models\AsignacionEstudiante;
use App\Models\EvaluacionDocente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class AsignacionResource extends Resource
{
    protected static ?string $model = Asignacion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('cod_doc')
                    ->required()
                    ->relationship('docente', 'nombre'),
                Forms\Components\Select::make('cod_mat')
                    ->required()
                    ->relationship('materia', 'nombre'),
                Forms\Components\Select::make('gestion_id')
                    ->required()
                    ->relationship('gestion', 'nombre'),
                Forms\Components\Toggle::make('activo')
                    ->required(),
                Forms\Components\Select::make('turno')
                    ->options(
                        [
                            'MAÑANA' => 'MAÑANA',
                            'NOCHE' => 'NOCHE',
                        ]
                    )
                    ->required(),
                Forms\Components\Select::make('paralelo')
                    ->required()
                    ->options(
                        [
                            'A' => 'A',
                            'B' => 'B',
                            'Z' => 'Z',
                        ]
                    ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('materia.nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gestion.nombre')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('turno'),
                Tables\Columns\TextColumn::make('paralelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('docente.nombre')
                    ->searchable(),
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
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('Ver Evaluacion')
                        ->icon('heroicon-m-eye')
                        ->labeledFrom('md')
                        ->requiresConfirmation(),
                        //->url(fn(EvaluacionDocente $record): string =>  self::getUrl('evaluar', ['record' => $record]))
                        //->visible(false)
                    Tables\Actions\Action::make('Habilitar Evaluacion')
                        ->icon('heroicon-m-pencil-square')
                        ->button()
                        ->labeledFrom('md')
                        ->requiresConfirmation()
                        //->visible(false)
                        ->action(function (Asignacion $record) {
                                //dd($record->id);
                                // Obtiene todas las asignaciones de estudiantes correspondientes a la asignación seleccionada
                                $asignacionesEstudiantes = AsignacionEstudiante::where('asignacion_id', $record->id)
                                    ->get();
                                //dd($asignacionesEstudiantes);
                                // Itera sobre cada asignación de estudiante y crea el registro de evaluación
                                foreach ($asignacionesEstudiantes as $asignacionEstudiante) {
                                    EvaluacionDocente::create([
                                        'asignacion_estudiante_id' => $asignacionEstudiante->id,
                                        'pregunta1' => null,
                                        'pregunta2' => null,
                                        'pregunta3' => null,
                                        'pregunta4' => null,
                                        'pregunta5' => null,
                                        'pregunta6' => null,
                                        'pregunta7' => null,
                                        'pregunta8' => null,
                                        'pregunta9' => null,
                                        'pregunta10' => null,
                                        'pregunta11' => null,
                                        'pregunta12' => null,
                                        'pregunta13' => null,
                                        'pregunta14' => null,
                                        'pregunta15' => null,
                                        'pregunta16' => null,
                                        'pregunta17' => null,
                                        'respuesta_abierta' => null,
                                        'estado' => false,
                                        'fecha_inicio' => now(),
                                        'fecha_fin' => now()->addWeeks(2), // Puedes ajustar la fecha de fin según tus necesidades
                                    ]);
                                }
                        }),                        
                ])
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
        ];
    }
}
