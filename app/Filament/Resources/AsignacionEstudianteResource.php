<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionEstudianteResource\Pages;
use App\Filament\Resources\AsignacionEstudianteResource\RelationManagers;
use App\Models\AsignacionEstudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AsignacionEstudianteResource extends Resource
{
    protected static ?string $model = AsignacionEstudiante::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    protected static ?string $navigationGroup = 'Académico';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('asignacion_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('estudiante_id')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('activo')
                    ->required(),
                Forms\Components\TextInput::make('estado')
                    ->required(),
                Forms\Components\Toggle::make('eva_estado')
                    ->required(),
                Forms\Components\TextInput::make('nota_eva_doc')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asignacion.materia.nombre')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('estudiante.vistaNombre.nombre_comp')
                    ->sortable(),
                Tables\Columns\TextColumn::make('estudiante.cod_est')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('estado'),
                Tables\Columns\IconColumn::make('eva_estado')
                    ->boolean(),
                Tables\Columns\TextColumn::make('nota_eva_doc')
                    ->numeric(decimalPlaces: 2)
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
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
