<?php

namespace App\Filament\Estudiante\Resources;

use App\Filament\Estudiante\Resources\AsignacionEstudianteResource\Pages;
use App\Filament\Estudiante\Resources\AsignacionEstudianteResource\RelationManagers;
use App\Models\AsignacionEstudiante;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class AsignacionEstudianteResource extends Resource
{
    protected static ?string $model = AsignacionEstudiante::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getEloquentQuery(): Builder
        {
            $usuarioId = Auth::user()->id;

            $query = parent::getEloquentQuery();

            // Primero, verificar si el usuario autenticado tiene un registro en la tabla estudiantes
            $estudiante = Estudiante::where('user_id', $usuarioId)->first();

            // Si el estudiante existe, filtrar por estudiante_id pertenecientes a ese estudiante
            if ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            } else {
                // Si no existe el estudiante, no se aplican filtros adicionales
            }

            return $query;
        }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asignacion.materia.nombre')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignacion.turno')
                    ->label('Turno')
                    ->sortable(),
                Tables\Columns\TextColumn::make('asignacion.paralelo')
                    ->label('Paralelo')
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('estado'),
                Tables\Columns\TextColumn::make('asignacion.created_at')
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListAsignacionEstudiantes::route('/'),
            'create' => Pages\CreateAsignacionEstudiante::route('/create'),
            'edit' => Pages\EditAsignacionEstudiante::route('/{record}/edit'),
        ];
    }
}
