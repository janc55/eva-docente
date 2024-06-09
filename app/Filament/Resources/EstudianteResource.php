<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Académico';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cod_est')
                    ->disabled()
                    ->live()
                    ->unique(ignoreRecord:true)
                    ->dehydrated()
                    ->default(function () {
                        $lastCodEst = Estudiante::max('cod_est');
                        //dd($lastCodEst);
                        return $lastCodEst ? $lastCodEst + 1 : 1;
                    }),
                Forms\Components\TextInput::make('nombre')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_paterno')
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_materno')
                    ->maxLength(255),
                Forms\Components\TextInput::make('ci')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('complemento_ci')
                    ->maxLength(255),
                Forms\Components\TextInput::make('celular')
                    ->maxLength(255),
                Forms\Components\TextInput::make('foto')
                    ->maxLength(255),
                Forms\Components\Toggle::make('activo')
                    ->required(),
                Forms\Components\Select::make('carrera_id')
                    ->relationship('carreras', 'nombre')
                    ->multiple()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('cod_est')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido_paterno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('apellido_materno')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ci')
                    ->sortable(),
                Tables\Columns\TextColumn::make('complemento_ci')
                    ->searchable(),
                Tables\Columns\TextColumn::make('celular')
                    ->searchable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
                Tables\Columns\TextColumn::make('carreras.sigla')
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
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
        ];
    }
}
