<?php

namespace App\Filament\Resources\CaseStudies\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CaseStudiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('code')->fontFamily('mono')->size('xs'),
                TextColumn::make('title')->searchable()->limit(60),
                TextColumn::make('sector_label')->label('Sector')->badge()->toggleable(),
                TextColumn::make('region')->toggleable(),
                IconColumn::make('is_featured')->label('Featured')->boolean(),
                IconColumn::make('published_at')
                    ->label('Live')
                    ->boolean()
                    ->getStateUsing(fn ($r) => $r && $r->published_at && $r->published_at->isPast()),
                TextColumn::make('year')->sortable(),
                TextColumn::make('updated_at')->since()->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
