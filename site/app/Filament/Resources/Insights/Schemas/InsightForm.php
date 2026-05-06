<?php

namespace App\Filament\Resources\Insights\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InsightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identity')->schema([
                TextInput::make('code')->placeholder('BRIEF / 014')->maxLength(40),
                Select::make('kicker')->options([
                    'Reliability' => 'Reliability',
                    'Method'      => 'Method',
                    'Field'       => 'Field-note',
                    'Position'    => 'Position',
                    'Review'      => 'Review',
                ])->placeholder('Choose category'),
                TextInput::make('title')->required()->maxLength(200)->live(onBlur: true)->columnSpanFull(),
                TextInput::make('slug')->maxLength(200)->columnSpanFull(),
            ])->columns(2),

            Section::make('Excerpt + body')->schema([
                Textarea::make('excerpt')->rows(3)->maxLength(500)
                    ->helperText('1–3 sentences. Used on cards.'),
                MarkdownEditor::make('body')->columnSpanFull()
                    ->helperText('The article body. Renders on /briefings/{slug}.'),
            ]),

            Section::make('Publishing')->schema([
                TextInput::make('reading_minutes')->numeric()->label('Reading time (min)'),
                Toggle::make('is_lead')->label('Lead briefing (top spot on index)'),
                DateTimePicker::make('published_at')->seconds(false)->default(now()),
            ])->columns(3),

            Section::make('Syndication — Mining & Energy')
                ->description('Track when this briefing was syndicated to Mining & Energy. Use the "Generate syndication packet" header action for a copy-ready bundle.')
                ->collapsed(fn ($record) => ! ($record?->syndicated_at))
                ->schema([
                    DateTimePicker::make('syndicated_at')
                        ->label('Syndicated on')
                        ->seconds(false)
                        ->helperText('Set when Mining & Energy publishes the piece.'),
                    TextInput::make('syndication_url')
                        ->label('Syndicated URL')
                        ->url()
                        ->placeholder('https://miningandenergy.example.com/...'),
                    Textarea::make('syndication_notes')
                        ->label('Notes')
                        ->rows(3)
                        ->columnSpanFull()
                        ->placeholder('Editor contact, follow-up, etc.'),
                ])->columns(2),
        ]);
    }
}
