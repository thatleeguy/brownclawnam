<?php

namespace App\Filament\Resources\Capabilities;

use App\Filament\Resources\Capabilities\Pages\ManageCapabilities;
use App\Models\Capability;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class CapabilityResource extends Resource
{
    protected static ?string $model = Capability::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Capabilities';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identity')->schema([
                TextInput::make('code')->placeholder('CAP / 01')->maxLength(40),
                TextInput::make('eyebrow')->placeholder('Reliability')->maxLength(80),
                TextInput::make('title')->required()->maxLength(160)->live(onBlur: true),
                TextInput::make('slug')->maxLength(160)
                    ->helperText('Auto-generated from title if left blank.'),
            ])->columns(2),

            Section::make('Card summary')->schema([
                Textarea::make('summary')->rows(3)->maxLength(500)
                    ->helperText('1–3 sentences shown on the home grid and the index card.'),
            ]),

            Section::make('Detail page body')->schema([
                MarkdownEditor::make('body')->columnSpanFull()
                    ->helperText('Long-form. Renders on /capabilities/{slug}.'),
            ]),

            Section::make('Methods + deliverables')->schema([
                TagsInput::make('methods')->placeholder('Add method')
                    ->helperText('First tag is highlighted in amber.'),
                TagsInput::make('deliverables')->placeholder('Add deliverable'),
            ])->columns(2),

            Section::make('Publishing')->schema([
                TextInput::make('display_order')->numeric()->default(0),
                DateTimePicker::make('published_at')->seconds(false)
                    ->helperText('Leave empty to keep as draft.')
                    ->default(now()),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('display_order')
            ->columns([
                TextColumn::make('code')->label('Code')->fontFamily('mono')->size('xs'),
                TextColumn::make('title')->searchable()->limit(60),
                TextColumn::make('eyebrow')->label('Track')->badge(),
                IconColumn::make('published_at')
                    ->label('Live')
                    ->boolean()
                    ->getStateUsing(fn ($record) => $record && $record->published_at && $record->published_at->isPast()),
                TextColumn::make('display_order')->label('Order')->sortable(),
                TextColumn::make('updated_at')->label('Updated')->since()->sortable(),
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

    public static function getPages(): array
    {
        return [
            'index' => ManageCapabilities::route('/'),
        ];
    }
}
