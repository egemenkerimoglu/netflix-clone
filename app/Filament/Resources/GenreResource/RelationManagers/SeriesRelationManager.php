<?php

namespace App\Filament\Resources\GenreResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SeriesRelationManager extends RelationManager
{
    protected static string $relationship = 'series';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Details')
                    ->columns(4)
                    ->schema([
                        Select::make('genres')
                            ->multiple()
                            ->relationship(titleAttribute: 'name')
                            ->preload()
                            ->columnSpan(2),
                        DatePicker::make('release_date')->columnSpan(2),
                        TextInput::make('title')
                            ->live()
                            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('slug')->columnSpan(2),
                        Textarea::make('overview')->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Urls')
                    ->columns(2)
                    ->schema([
                        TextInput::make('poster_path')->url(),
                        TextInput::make('backdrop_path')->url(),
                    ])
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('release_date')->date(),
                Tables\Columns\TextColumn::make('created_at')->date(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
