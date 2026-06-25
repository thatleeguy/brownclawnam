<?php

namespace App\Filament\Resources\TeamMembers;

use App\Filament\Resources\TeamMembers\Pages\ManageTeamMembers;
use App\Models\TeamMember;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Team / bios';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Card')->schema([
                TextInput::make('name')->required()->placeholder('CONNOR SCHRIVER'),
                TextInput::make('title')->label('Title')->placeholder('Founder · Reliability Engineer'),
                TextInput::make('creds')->label('Credentials / location')
                    ->placeholder('FERNIE BC')
                    ->helperText('Use / to separate — shown stacked.'),
                FileUpload::make('photo')
                    ->label('Headshot photo')
                    ->image()
                    ->disk('public_root')
                    ->directory('img/team')
                    ->visibility('public')
                    ->fetchFileInformation(false)
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1', null])
                    ->helperText('Upload a headshot — a square crop works best (shown in a circle).')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Biography')->schema([
                TextInput::make('eyebrow')->label('Eyebrow')->placeholder('FILE 005 · ABOUT THE FIRM')->columnSpanFull(),
                Textarea::make('headline_html')->label('Headline (HTML)')->rows(2)->columnSpanFull()
                    ->helperText('Use <span class="am">word</span> for the amber highlight.'),
                Textarea::make('bio_html')->label('Biography (HTML)')->rows(6)->columnSpanFull(),
                Textarea::make('quote')->label('Pull quote (optional)')->rows(3)->columnSpanFull(),
                TextInput::make('quote_sign')->label('Quote attribution (optional)')->columnSpanFull(),
            ]),

            Section::make('CV cells')->schema([
                Repeater::make('cv')
                    ->label(false)
                    ->schema([
                        TextInput::make('label')->label('Label')->placeholder('YEARS'),
                        TextInput::make('value')->label('Value (HTML)')->placeholder('9<span class="am">+</span>'),
                    ])
                    ->columns(2)
                    ->reorderable()
                    ->defaultItems(0)
                    ->maxItems(6)
                    ->columnSpanFull(),
            ]),

            Section::make('Publishing')->schema([
                TextInput::make('display_order')->numeric()->default(0),
                Toggle::make('visible')->label('Visible on site')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('display_order')
            ->columns([
                TextColumn::make('display_order')->label('Order')->sortable(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('title')->limit(40),
                IconColumn::make('visible')->boolean(),
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
            'index' => ManageTeamMembers::route('/'),
        ];
    }
}
