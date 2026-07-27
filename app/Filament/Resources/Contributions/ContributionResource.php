<?php

namespace App\Filament\Resources\Contributions;

use App\Filament\Resources\Contributions\Pages\ManageContributions;
use App\Models\Contribution;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContributionResource extends Resource
{
    protected static ?string $model = Contribution::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedHeart;

    protected static ?string $navigationLabel = 'Contributions';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Photo')->schema([
                FileUpload::make('image')
                    ->label('Photo')
                    ->image()
                    ->disk('uploads')
                    ->directory('contributions')
                    ->visibility('public')
                    ->fetchFileInformation(false)
                    ->imageEditor()
                    ->helperText('The photo shown on the card. Landscape works best.')
                    ->columnSpanFull(),
            ]),
            Section::make('Content')->schema([
                TextInput::make('title')->required()->placeholder('Fernie Trails Alliance'),
                TextInput::make('year')->label('Year')->placeholder('2024')->maxLength(12),
                Textarea::make('blurb')->label('Description')->rows(4)->columnSpanFull()
                    ->helperText('A sentence or two on the support / cause.'),
                TextInput::make('link')->label('Link (optional)')->url()->placeholder('https://…')->columnSpanFull(),
            ])->columns(2),
            Section::make('Highlighted metric')->schema([
                TextInput::make('metric_value')->label('Value')->placeholder('$25K'),
                TextInput::make('metric_label')->label('Label')->placeholder('Raised'),
            ])->columns(2),
            Section::make('Publishing')->schema([
                TextInput::make('display_order')->numeric()->default(0),
                Toggle::make('published')->label('Published')->default(true),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('display_order')
            ->columns([
                ImageColumn::make('image')->label('Photo')->disk('uploads')->height(40),
                TextColumn::make('title')->searchable(),
                TextColumn::make('year')->sortable(),
                TextColumn::make('metric_value')->label('Metric'),
                IconColumn::make('published')->boolean(),
                TextColumn::make('display_order')->label('Order')->sortable(),
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
            'index' => ManageContributions::route('/'),
        ];
    }
}
