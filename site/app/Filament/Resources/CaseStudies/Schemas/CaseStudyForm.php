<?php

namespace App\Filament\Resources\CaseStudies\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CaseStudyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Identity')->schema([
                TextInput::make('code')->placeholder('WORK / 047')->maxLength(40),
                TextInput::make('title')->required()->maxLength(200)->live(onBlur: true),
                TextInput::make('slug')->maxLength(200),
                TextInput::make('client_display')
                    ->label('Client display (anonymized)')
                    ->placeholder('Tier-1 metallurgical coal operator')
                    ->maxLength(160),
            ])->columns(2),

            Section::make('Sector / region')->schema([
                Select::make('sector')->options([
                    'metallurgical_coal' => 'Metallurgical coal',
                    'thermal_coal'       => 'Thermal coal',
                    'diamond'            => 'Diamond',
                    'gold'               => 'Gold',
                    'copper'             => 'Copper',
                    'zinc'               => 'Zinc',
                    'potash'             => 'Potash',
                    'oil_gas'            => 'Oil & Gas',
                    'hydro'              => 'Hydro',
                    'other'              => 'Other',
                ]),
                TextInput::make('sector_label')->placeholder('Coal preparation plant'),
                TextInput::make('region')->placeholder('Western Canada')->maxLength(80),
            ])->columns(3),

            Section::make('Summary + body')->schema([
                Textarea::make('summary')->rows(3)->maxLength(800)
                    ->helperText('1–3 sentences. Used on cards and indexes.'),
                MarkdownEditor::make('body')->columnSpanFull()
                    ->helperText('Long-form. Renders on /work/{slug}.'),
            ]),

            Section::make('KPI stats')
                ->description('Three concise metrics for the case card and detail page header.')
                ->schema([
                    Repeater::make('kpi_stats')
                        ->label(false)
                        ->schema([
                            TextInput::make('value')->required()->placeholder('−62')->maxLength(40),
                            TextInput::make('unit')->placeholder('%')->maxLength(20),
                            TextInput::make('label')->required()->placeholder('Downtime ▼')->maxLength(80),
                            TextInput::make('note')->placeholder('From 14.8% → 5.6%')->maxLength(120),
                        ])
                        ->columns(2)
                        ->reorderable()
                        ->defaultItems(3)
                        ->maxItems(6),
                ]),

            Section::make('Engagement metadata')->schema([
                TextInput::make('engagement_months')->numeric()->placeholder('9')->label('Duration (months)'),
                TextInput::make('year')->numeric()->placeholder('2025'),
                Toggle::make('is_featured')->label('Feature on home page'),
                TextInput::make('display_order')->numeric()->default(0),
                DateTimePicker::make('published_at')->seconds(false)->default(now()),
            ])->columns(2),
        ]);
    }
}
