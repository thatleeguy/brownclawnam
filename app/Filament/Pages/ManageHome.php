<?php

namespace App\Filament\Pages;

use App\Models\HomeContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageHome extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.manage-home';

    protected static ?string $slug = 'home';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = 'Home page';

    protected static ?string $title = 'Home page';

    protected static ?int $navigationSort = 1;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill(HomeContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([

                Tab::make('Hero')->icon(Heroicon::OutlinedSparkles)->schema([
                    Section::make('Headline + sub')->schema([
                        TextInput::make('hero_eyebrow')
                            ->label('Eyebrow text')
                            ->placeholder('Reliability Engineering · Asset Strategy · Mining & Energy')
                            ->columnSpanFull(),
                        Textarea::make('hero_headline_html')
                            ->label('Headline (HTML)')
                            ->rows(4)
                            ->helperText('You can use <span class="kw">word</span> for the highlighted background, <span class="am">word</span> for amber, and <br/> for line breaks.')
                            ->columnSpanFull(),
                        Textarea::make('hero_sub')
                            ->label('Sub-paragraph')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
                    Section::make('CTAs')->schema([
                        TextInput::make('hero_primary_cta_label')->label('Primary CTA label'),
                        TextInput::make('hero_secondary_cta_label')->label('Secondary CTA label'),
                    ])->columns(2),
                    Section::make('Spec row (4 metrics)')->schema([
                        Repeater::make('spec_row')
                            ->label(false)
                            ->schema([
                                TextInput::make('label')->required()->placeholder('Practice yrs')->maxLength(40),
                                TextInput::make('value')->required()->placeholder('8')->maxLength(20),
                                TextInput::make('unit')->placeholder('+')->maxLength(20),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->defaultItems(4)
                            ->minItems(1)
                            ->maxItems(6)
                            ->columnSpanFull(),
                    ]),
                ]),

                Tab::make('Position')->icon(Heroicon::OutlinedChatBubbleBottomCenterText)->schema([
                    Section::make('Manifesto paragraphs')
                        ->description('Each paragraph is its own row. HTML allowed: <b>, <span class="am">, <span class="strike">.')
                        ->schema([
                            Repeater::make('position_paragraphs')
                                ->label(false)
                                ->schema([
                                    Textarea::make('text')
                                        ->label(false)
                                        ->rows(4)
                                        ->required(),
                                ])
                                ->reorderable()
                                ->minItems(1)
                                ->maxItems(6)
                                ->columnSpanFull(),
                        ]),
                    Section::make('Signature line')->schema([
                        TextInput::make('position_signature_name')
                            ->label('Name + role')
                            ->placeholder('Connor Schriver, P.Eng, CMRP · Principal'),
                        TextInput::make('position_signature_note')
                            ->label('Tag line')
                            ->placeholder('SIG / 2026.04 / FERNIE BC'),
                    ])->columns(2),
                ]),

                Tab::make('Evidence')->icon(Heroicon::OutlinedChartBar)->schema([
                    Section::make('Section header')->schema([
                        TextInput::make('evidence_kicker')->label('Kicker'),
                        Textarea::make('evidence_headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull(),
                        Textarea::make('evidence_meta')->label('Meta caption')->rows(3)->columnSpanFull(),
                    ]),
                    Section::make('KPI metrics (4 cards)')->schema([
                        Repeater::make('kpi_metrics')
                            ->label(false)
                            ->schema([
                                TextInput::make('name')->label('Label')->required()->placeholder('UNPLANNED DOWNTIME'),
                                TextInput::make('source')->label('Source caption')->placeholder('▼ Δ vs. baseline'),
                                TextInput::make('value_display')->label('Value')->required()->placeholder('−62'),
                                TextInput::make('unit')->placeholder('%'),
                                TextInput::make('unit_prefix')->label('Unit prefix')->placeholder('$'),
                                TextInput::make('delta_caption')->label('Delta caption'),
                                Textarea::make('description')->rows(2)->columnSpanFull(),
                                TextInput::make('context')->label('Context')->placeholder('Metallurgical coal'),
                            ])
                            ->columns(2)
                            ->reorderable()
                            ->minItems(1)
                            ->maxItems(8)
                            ->columnSpanFull(),
                    ]),
                ]),

                Tab::make('Criticality')->icon(Heroicon::OutlinedTableCells)->schema([
                    Section::make('Section header')->schema([
                        TextInput::make('criticality_eyebrow')->label('Eyebrow'),
                        Textarea::make('criticality_headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull(),
                        Textarea::make('criticality_lede_html')->label('Lede paragraph (HTML)')->rows(4)->columnSpanFull(),
                    ]),
                    Section::make('Checks')->schema([
                        Repeater::make('criticality_checks')
                            ->label(false)
                            ->schema([
                                Textarea::make('text')->label(false)->rows(2),
                            ])
                            ->reorderable()
                            ->minItems(1)
                            ->maxItems(8)
                            ->columnSpanFull(),
                    ]),
                    Section::make('Register table')->schema([
                        Repeater::make('criticality_register')
                            ->label(false)
                            ->schema([
                                TextInput::make('tag')->required()->placeholder('CRH-01')->maxLength(20),
                                TextInput::make('equipment')->required()->placeholder('Primary gyratory crusher')->columnSpan(2),
                                Select::make('level')->required()->options(['h' => 'High', 'm' => 'Medium', 'l' => 'Low']),
                                TextInput::make('hours')->placeholder('+712')->maxLength(20),
                                TextInput::make('score')->numeric()->placeholder('80')->helperText('0–100, drives bar fill.')->maxLength(3),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->minItems(1)
                            ->maxItems(20)
                            ->columnSpanFull(),
                    ]),
                ]),

                Tab::make('Briefings head')->icon(Heroicon::OutlinedNewspaper)->schema([
                    Section::make('Section header')
                        ->description('Heads the briefings teaser on the home page. The briefing cards themselves come from the Briefings resource.')
                        ->schema([
                            TextInput::make('briefings_kicker')->label('Kicker'),
                            Textarea::make('briefings_headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull(),
                            Textarea::make('briefings_meta')->label('Meta caption')->rows(3)->columnSpanFull(),
                        ]),
                ]),
            ])->columnSpanFull(),
        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View live home page')
                ->color('gray')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->url(url('/'), shouldOpenInNewTab: true),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        HomeContent::current()->update($state);

        Notification::make()
            ->title('Home page updated')
            ->success()
            ->send();
    }
}
