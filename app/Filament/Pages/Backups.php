<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Backups extends Page
{
    protected string $view = 'filament.pages.backups';

    protected static ?string $slug = 'backups';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArchiveBox;

    protected static ?string $navigationLabel = 'Backups';

    protected static ?string $title = 'Backups';

    protected static ?int $navigationSort = 9;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create')
                ->label('Create backup now')
                ->icon(Heroicon::OutlinedArchiveBoxArrowDown)
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Create a backup')
                ->modalDescription('This snapshots the database (and any uploaded files) into a downloadable archive. It can take a few moments.')
                ->modalSubmitActionLabel('Create backup')
                ->action(function (): void {
                    @set_time_limit(300);

                    try {
                        $exit = Artisan::call('backup:run', ['--disable-notifications' => true]);
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Backup failed')
                            ->body($e->getMessage())
                            ->danger()
                            ->persistent()
                            ->send();

                        return;
                    }

                    if ($exit === 0) {
                        Notification::make()->title('Backup created')->success()->send();
                    } else {
                        Notification::make()
                            ->title('Backup failed')
                            ->body((string) str(Artisan::output())->limit(400))
                            ->danger()
                            ->persistent()
                            ->send();
                    }
                }),
        ];
    }

    /**
     * @return array<int, array{name: string, size: string, date: string}>
     */
    public function getBackups(): array
    {
        $disk = Storage::disk($this->diskName());

        return collect($disk->files($this->folder()))
            ->filter(fn (string $f): bool => str_ends_with($f, '.zip'))
            ->sortDesc()
            ->map(fn (string $f): array => [
                'name' => basename($f),
                'size' => number_format($disk->size($f) / 1_048_576, 2) . ' MB',
                'date' => Carbon::createFromTimestamp($disk->lastModified($f))->diffForHumans(),
            ])
            ->values()
            ->all();
    }

    public function downloadBackup(string $file): ?StreamedResponse
    {
        $disk = Storage::disk($this->diskName());
        $path = $this->resolvePath($file);

        if (! $disk->exists($path)) {
            Notification::make()->title('That backup no longer exists')->danger()->send();

            return null;
        }

        return $disk->download($path);
    }

    public function deleteBackup(string $file): void
    {
        $disk = Storage::disk($this->diskName());
        $path = $this->resolvePath($file);

        if ($disk->exists($path)) {
            $disk->delete($path);
            Notification::make()->title('Backup deleted')->success()->send();
        }
    }

    private function diskName(): string
    {
        return config('backup.backup.destination.disks')[0] ?? 'local';
    }

    private function folder(): string
    {
        return config('backup.backup.name', 'Brownclaw');
    }

    /** Resolve to a path inside the backup folder; basename() blocks path traversal. */
    private function resolvePath(string $file): string
    {
        return $this->folder() . '/' . basename($file);
    }
}
