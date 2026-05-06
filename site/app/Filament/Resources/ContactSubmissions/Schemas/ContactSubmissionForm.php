<?php

namespace App\Filament\Resources\ContactSubmissions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('From')->schema([
                TextInput::make('name')->disabled(),
                TextInput::make('email')->disabled(),
                TextInput::make('company')->disabled(),
                TextInput::make('role')->disabled(),
                TextInput::make('phone')->disabled(),
                TextInput::make('source')->disabled(),
            ])->columns(2),

            Section::make('Message')->schema([
                Textarea::make('message')->disabled()->rows(8)->columnSpanFull(),
            ]),

            Section::make('Status')->schema([
                Toggle::make('is_handled')->label('Handled')
                    ->helperText('Mark when you have replied or closed the inquiry.'),
            ]),
        ]);
    }
}
