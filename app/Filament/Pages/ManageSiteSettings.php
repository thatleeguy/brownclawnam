<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageSiteSettings extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.manage-site-settings';

    protected static ?string $slug = 'site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?string $navigationLabel = 'Site settings';

    protected static ?string $title = 'Site settings';

    protected static ?int $navigationSort = 2;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill(SiteSetting::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([

                Tab::make('Brand')->icon(Heroicon::OutlinedBuildingOffice2)->schema([
                    Section::make('Identity')->schema([
                        TextInput::make('brand_name')
                            ->label('Site / company name')
                            ->placeholder('Brownclaw Asset Management'),
                        TextInput::make('brand_tagline')
                            ->label('Logo tagline')
                            ->placeholder('Asset Management'),
                    ])->columns(2),
                    Section::make('Logo & favicon')
                        ->description('Upload the header logo and browser favicon. Leave blank to keep the current image.')
                        ->schema([
                            FileUpload::make('logo_path')
                                ->label('Header logo')
                                ->image()
                                ->disk('uploads')
                                ->directory('site')
                                ->visibility('public')
                                ->fetchFileInformation(false)
                                ->helperText('Wide / horizontal lockup works best.'),
                            FileUpload::make('favicon_path')
                                ->label('Favicon')
                                ->image()
                                ->disk('uploads')
                                ->directory('site')
                                ->visibility('public')
                                ->fetchFileInformation(false)
                                ->helperText('Small square icon shown in the browser tab.'),
                        ])->columns(2),
                    Section::make('Default SEO')
                        ->description('Used as the browser title and meta description when a page does not set its own.')
                        ->schema([
                            TextInput::make('default_meta_title')->label('Default page title')->columnSpanFull(),
                            Textarea::make('default_meta_description')->label('Default meta description')->rows(2)->columnSpanFull(),
                        ]),
                ]),

                Tab::make('Theme')->icon(Heroicon::OutlinedSwatch)->schema([
                    Section::make('Colours')
                        ->description('Leave a colour blank to keep the original design default.')
                        ->schema([
                            ColorPicker::make('color_amber')->label('Accent (amber)'),
                            ColorPicker::make('color_amber_2')->label('Accent dark'),
                            ColorPicker::make('color_steel_1')->label('Page background'),
                            ColorPicker::make('color_steel_2')->label('Surface'),
                            ColorPicker::make('color_steel_3')->label('Card'),
                            ColorPicker::make('color_text')->label('Text'),
                            ColorPicker::make('color_text_2')->label('Muted text'),
                            ColorPicker::make('color_hazard')->label('Warning / hazard'),
                        ])->columns(2),
                    Section::make('Typography')->schema([
                        TextInput::make('font_base_size')
                            ->label('Base text size (px)')
                            ->numeric()->minValue(11)->maxValue(22)
                            ->placeholder('15')
                            ->helperText('Body copy size. Leave blank for the default (15px).'),
                        TextInput::make('heading_scale')
                            ->label('Heading scale')
                            ->numeric()->step('0.05')->minValue(0.5)->maxValue(2)
                            ->placeholder('1.0')
                            ->helperText('Multiplier on all large display headings. 1 = default, 1.2 = 20% larger.'),
                    ])->columns(2),
                ]),

                Tab::make('Navigation')->icon(Heroicon::OutlinedBars3)->schema([
                    Section::make('Menu items')
                        ->description('Drag to reorder. Untick "Show" to hide an item without deleting it. Link can be a path (/work), a hash (/#evidence), or a full URL.')
                        ->schema([
                            Repeater::make('nav_items')
                                ->label(false)
                                ->schema([
                                    TextInput::make('number')->label('No.')->placeholder('01')->maxLength(4),
                                    TextInput::make('label')->label('Label')->required()->placeholder('CAPABILITIES'),
                                    TextInput::make('url')->label('Link')->required()->placeholder('/capabilities'),
                                    Toggle::make('visible')->label('Show')->default(true)->inline(false),
                                ])
                                ->columns(4)
                                ->reorderable()
                                ->defaultItems(0)
                                ->maxItems(10)
                                ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                ->columnSpanFull(),
                        ]),
                    Section::make('Header button')->schema([
                        TextInput::make('nav_cta_label')->label('Button label')->placeholder('REQUEST ENGAGEMENT'),
                        TextInput::make('nav_cta_url')->label('Button link')->placeholder('/contact'),
                    ])->columns(2),
                ]),

                Tab::make('Footer')->icon(Heroicon::OutlinedRectangleGroup)->schema([
                    Section::make('Footer lines')
                        ->description('Each row is one column in the footer. HTML allowed (e.g. <b>…</b>).')
                        ->schema([
                            Repeater::make('footer_lines')
                                ->label(false)
                                ->schema([
                                    TextInput::make('text')->label(false)->required()->columnSpanFull(),
                                ])
                                ->reorderable()
                                ->defaultItems(0)
                                ->maxItems(6)
                                ->columnSpanFull(),
                        ]),
                ]),

                Tab::make('Status bar')->icon(Heroicon::OutlinedSignal)->schema([
                    Section::make('Top status strip')->schema([
                        Toggle::make('statusbar_visible')->label('Show the status bar')->default(true)->columnSpanFull(),
                        TextInput::make('statusbar_status_label')->label('Status label')->placeholder('Practice'),
                        TextInput::make('statusbar_status_value')->label('Status value')->placeholder('online'),
                        TextInput::make('statusbar_location')->label('Location / timezone')->placeholder('UTC −07:00 · Fernie BC'),
                        TextInput::make('statusbar_availability')->label('Availability')->placeholder('Engagements Q2 2026 · taking inquiries'),
                        TextInput::make('statusbar_creds')->label('Credentials')->placeholder('P.Eng · CMRP'),
                    ])->columns(2),
                ]),

                Tab::make('Contact CTA')->icon(Heroicon::OutlinedEnvelope)->schema([
                    Section::make('Call-to-action band')->schema([
                        Toggle::make('cta_visible')->label('Show the contact CTA band')->default(true)->columnSpanFull(),
                        TextInput::make('cta_eyebrow')->label('Eyebrow')->placeholder('REQUEST · ENGAGEMENT INTAKE')->columnSpanFull(),
                        Textarea::make('cta_headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull()
                            ->helperText('Use <span class="am">word</span> for the amber highlight.'),
                        Textarea::make('cta_lede')->label('Sub-paragraph')->rows(3)->columnSpanFull(),
                        TextInput::make('cta_button_label')->label('Button label')->placeholder('REQUEST ENGAGEMENT'),
                    ]),
                    Section::make('Contact card')->schema([
                        TextInput::make('contact_email')->label('Email')->placeholder('info@brownclawam.ca'),
                        TextInput::make('contact_email_note')->label('Email note')->placeholder('Replies inside 24 hrs, Mon–Fri.'),
                        TextInput::make('contact_phone_display')->label('Phone (shown)')->placeholder('+1 (866) 258-6572'),
                        TextInput::make('contact_phone_url')->label('Phone (dial)')->placeholder('+18662586572'),
                        TextInput::make('contact_phone_note')->label('Phone note')->placeholder('Pacific time. Voicemail forwards to email.'),
                        TextInput::make('contact_location')->label('Location')->placeholder('Fernie, British Columbia'),
                        TextInput::make('contact_location_note')->label('Location note')->columnSpanFull()
                            ->placeholder('Working on-site across Western Canada and the Rocky Mountain corridor.'),
                    ])->columns(2),
                ]),

            ])->columnSpanFull(),
        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View live site')
                ->color('gray')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->url(url('/'), shouldOpenInNewTab: true),
        ];
    }

    public function save(): void
    {
        $state = $this->form->getState();

        SiteSetting::current()->update($state);

        Notification::make()
            ->title('Site settings updated')
            ->success()
            ->send();
    }
}
