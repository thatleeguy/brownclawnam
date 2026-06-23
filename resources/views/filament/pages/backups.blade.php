<x-filament-panels::page>
    @php($backups = $this->getBackups())

    <x-filament::section>
        <x-slot name="heading">Available backups</x-slot>
        <x-slot name="description">
            Each backup is a ZIP containing a database dump (and any uploaded files). Download one before making changes; restore by importing the dump if needed.
        </x-slot>

        @if (empty($backups))
            <div class="text-sm text-gray-500 dark:text-gray-400 py-4">
                No backups yet. Click <span class="font-medium">“Create backup now”</span> above to make your first one.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px] text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 dark:text-gray-400 border-b border-gray-200 dark:border-white/10">
                            <th class="py-2 pr-4 font-medium">Backup</th>
                            <th class="py-2 pr-4 font-medium">Size</th>
                            <th class="py-2 pr-4 font-medium">Created</th>
                            <th class="py-2 pr-4 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($backups as $backup)
                            <tr class="border-b border-gray-100 dark:border-white/5">
                                <td class="py-3 pr-4 font-mono text-gray-700 dark:text-gray-200 whitespace-nowrap">{{ $backup['name'] }}</td>
                                <td class="py-3 pr-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $backup['size'] }}</td>
                                <td class="py-3 pr-4 text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $backup['date'] }}</td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center justify-end gap-2 flex-nowrap">
                                        <x-filament::button
                                            size="sm"
                                            color="gray"
                                            icon="heroicon-o-arrow-down-tray"
                                            wire:click="downloadBackup('{{ $backup['name'] }}')"
                                            wire:loading.attr="disabled"
                                        >
                                            Download
                                        </x-filament::button>
                                        <x-filament::button
                                            size="sm"
                                            color="danger"
                                            icon="heroicon-o-trash"
                                            wire:click="deleteBackup('{{ $backup['name'] }}')"
                                            wire:confirm="Permanently delete this backup?"
                                        >
                                            Delete
                                        </x-filament::button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
