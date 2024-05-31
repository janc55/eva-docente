<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GestionResource\Pages;
use App\Filament\Resources\GestionResource\RelationManagers;
use App\Models\Gestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GestionResource extends Resource
{
    protected static ?string $model = Gestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Forms\Components\TextInput::make('gestion')
                    ->required()
                    ->live()
                    ->maxLength(255),
                Forms\Components\Select::make('periodo')
                    ->options([
                        '1' => '1',
                        '2' => '2', 
                    ])
                    ->live()
                    ->afterStateUpdated(function(Set $set, Get $get, $state){
                        $gestion = $get('gestion');
                        $nombre = $state . '/' . $gestion;
                        $set('nombre', $nombre);
                    }),
                Forms\Components\TextInput::make('nombre')
                    ->disabled()
                    ->dehydrated(),
                Forms\Components\DatePicker::make('fecha_inicio'),
                Forms\Components\DatePicker::make('fecha_fin'),
                Forms\Components\Toggle::make('activo')
                    ->default('true')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gestion')
                    ->searchable(),
                Tables\Columns\TextColumn::make('periodo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fecha_fin')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('activo')
                    ->boolean(),
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
            'index' => Pages\ListGestions::route('/'),
            'create' => Pages\CreateGestion::route('/create'),
            'edit' => Pages\EditGestion::route('/{record}/edit'),
        ];
    }
}
