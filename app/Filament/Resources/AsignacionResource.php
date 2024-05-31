<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionResource\Pages;
use App\Filament\Resources\AsignacionResource\RelationManagers;
use App\Models\Asignacion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
            'index' => Pages\ListAsignacions::route('/'),
            'create' => Pages\CreateAsignacion::route('/create'),
            'edit' => Pages\EditAsignacion::route('/{record}/edit'),
        ];
    }
}
