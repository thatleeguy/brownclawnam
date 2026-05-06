<?php

namespace App\Filament\Resources\Insights\Tables;

use App\Models\Insight;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class InsightsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('published_at', 'desc')
            ->columns([
                TextColumn::make('code')->fontFamily('mono')->size('xs'),
                TextColumn::make('title')->searchable()->limit(60),
                TextColumn::make('kicker')->badge()->toggleable(),
                TextColumn::make('reading_minutes')->label('Min')->sortable(),
                IconColumn::make('is_lead')->label('Lead')->boolean(),
                IconColumn::make('published_at')
                    ->label('Live')
                    ->boolean()
                    ->getStateUsing(fn ($r) => $r && $r->published_at && $r->published_at->isPast()),
                IconColumn::make('syndicated_at')
                    ->label('M&E')
                    ->boolean()
                    ->trueIcon(Heroicon::CheckCircle)
                    ->falseIcon(Heroicon::MinusCircle)
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip('Syndicated to Mining & Energy?'),
                TextColumn::make('published_at')->date()->sortable(),
            ])
            ->filters([
                TernaryFilter::make('syndicated_at')
                    ->label('Syndicated to M&E')
                    ->placeholder('All')
                    ->trueLabel('Syndicated')
                    ->falseLabel('Not syndicated')
                    ->queries(
                        true:  fn ($q) => $q->whereNotNull('syndicated_at'),
                        false: fn ($q) => $q->whereNull('syndicated_at'),
                    ),
            ])
            ->recordActions([
                self::syndicationPacketAction(),
                self::markSyndicatedAction(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function syndicationPacketAction(): Action
    {
        return Action::make('publishToMiningAndEnergy')
            ->label('Publish to M&E')
            ->icon(Heroicon::OutlinedPaperAirplane)
            ->color('warning')
            ->modalHeading('Publish to Mining & Energy')
            ->modalDescription(fn (Insight $record) => 'Copy-ready bundle for "' . $record->title . '". Paste into the editor\'s submission flow.')
            ->modalSubmitAction(false)
            ->modalCancelActionLabel('Close')
            ->modalWidth('5xl')
            ->schema(fn (Insight $record) => [
                Section::make('Headline')->schema([
                    TextInput::make('packet_title')
                        ->label('Title')
                        ->default($record->title)
                        ->disabled()
                        ->extraInputAttributes(['onfocus' => 'this.select()']),
                    TextInput::make('packet_byline')
                        ->label('Byline')
                        ->default('Connor Schriver, P.Eng, CMRP — Brownclaw Asset Management')
                        ->disabled(),
                ])->columns(1),

                Section::make('Excerpt')->schema([
                    Textarea::make('packet_excerpt')
                        ->label(false)
                        ->default($record->excerpt)
                        ->rows(3)
                        ->disabled(),
                ]),

                Section::make('Body — Markdown')
                    ->description('Most editors accept Markdown directly. If they need plain text, copy and paste into a converter.')
                    ->schema([
                        Textarea::make('packet_body')
                            ->label(false)
                            ->default($record->body)
                            ->rows(20)
                            ->disabled()
                            ->extraInputAttributes(['style' => 'font-family: ui-monospace, Menlo, monospace; font-size: 13px;']),
                    ]),

                Section::make('Attribution + canonical link')->schema([
                    Textarea::make('packet_footer')
                        ->label('Suggested footer line')
                        ->default(self::footerLine($record))
                        ->rows(2)
                        ->disabled(),
                    TextInput::make('packet_canonical')
                        ->label('Canonical URL')
                        ->default(route('briefings.show', $record))
                        ->disabled(),
                ])->columns(1),
            ]);
    }

    public static function markSyndicatedAction(): Action
    {
        return Action::make('markSyndicated')
            ->label(fn (Insight $r) => $r->syndicated_at ? 'Update syndication record' : 'Mark syndicated to M&E')
            ->icon(Heroicon::OutlinedCheckBadge)
            ->color('success')
            ->modalHeading('Mark as syndicated to Mining & Energy')
            ->modalDescription('Record when this briefing was syndicated, where it was published, and any editor notes.')
            ->fillForm(fn (Insight $r) => [
                'syndicated_at'     => $r->syndicated_at,
                'syndication_url'   => $r->syndication_url,
                'syndication_notes' => $r->syndication_notes,
            ])
            ->schema([
                \Filament\Forms\Components\DateTimePicker::make('syndicated_at')
                    ->label('Syndicated on')
                    ->seconds(false)
                    ->required()
                    ->default(now()),
                TextInput::make('syndication_url')
                    ->label('Published URL')
                    ->url()
                    ->placeholder('https://miningandenergy.example.com/...'),
                Textarea::make('syndication_notes')
                    ->label('Notes')
                    ->rows(3)
                    ->placeholder('Editor contact, follow-up, etc.'),
            ])
            ->action(function (Insight $record, array $data) {
                $record->update($data);
                Notification::make()
                    ->title('Syndication recorded')
                    ->success()
                    ->send();
            });
    }

    private static function footerLine(Insight $record): string
    {
        return 'Originally published by Brownclaw Asset Management. Read the source: ' . route('briefings.show', $record);
    }
}
