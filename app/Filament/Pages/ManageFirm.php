<?php

namespace App\Filament\Pages;

use App\Models\FirmContent;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Repeater;
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

class ManageFirm extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.pages.manage-firm';

    protected static ?string $slug = 'firm-page';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static ?string $navigationLabel = 'Firm page';

    protected static ?string $title = 'Firm page';

    protected static ?int $navigationSort = 2;

    /** @var array<string, mixed> */
    public array $data = [];

    public function mount(): void
    {
        $this->form->fill(FirmContent::current()->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([

                Tab::make('Hero')->icon(Heroicon::OutlinedSparkles)->schema([
                    Section::make('Top of the firm page')->schema([
                        TextInput::make('hero_eyebrow')->label('Eyebrow')->placeholder('THE FIRM')->columnSpanFull(),
                        Textarea::make('hero_headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull()
                            ->helperText('Use <span class="am">word</span> for the amber highlight.'),
                        Textarea::make('hero_sub')->label('Intro paragraph')->rows(5)->columnSpanFull(),
                    ]),
                    Section::make('SEO')->schema([
                        Textarea::make('meta_description')->label('Meta description')->rows(2)->columnSpanFull(),
                    ]),
                ]),

                Tab::make('Engagement steps')->icon(Heroicon::OutlinedListBullet)->schema([
                    Section::make('“How an engagement runs”')->schema([
                        TextInput::make('engagement_heading')->label('Section heading')->placeholder('How an engagement runs')->columnSpanFull(),
                        Repeater::make('engagement_steps')
                            ->label(false)
                            ->schema([
                                TextInput::make('number')->label('No.')->placeholder('01')->maxLength(6),
                                TextInput::make('title')->label('Title')->required()->placeholder('Discovery (no-cost)')->columnSpan(2),
                                Textarea::make('body')->label('Description')->rows(3)->columnSpanFull(),
                            ])
                            ->columns(3)
                            ->reorderable()
                            ->defaultItems(0)
                            ->maxItems(12)
                            ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ]),
                ]),
            ])->columnSpanFull(),
        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label('View live firm page')
                ->color('gray')
                ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                ->url(url('/firm'), shouldOpenInNewTab: true),
        ];
    }

    public function save(): void
    {
        FirmContent::current()->update($this->form->getState());

        Notification::make()->title('Firm page updated')->success()->send();
    }
}
