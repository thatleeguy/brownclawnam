<x-filament-panels::page>
    <form wire:submit="save" class="fi-form grid gap-y-6">
        {{ $this->form }}

        <div class="flex justify-end gap-3 border-t border-gray-200 dark:border-white/10 pt-6">
            <x-filament::button type="submit" size="lg">
                Save changes
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
