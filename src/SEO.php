<?php

namespace RalphJSmit\Filament\SEO;

use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Filament\SEO\Components\TextInput;

class SEO
{
    public static function make(): array
    {
        return [
            TextInput::make('title')
                ->afterStateHydrated(function (TextInput $component, Model $record): void {
                    $component->state($record->seo->title);
                })
                ->label(tr('title'))
                ->columnSpan(2),
            Textarea::make('description')
                ->label(tr('description'))
                ->columnSpan(2),
        ];
    }
}
