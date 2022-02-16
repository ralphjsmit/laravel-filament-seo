<?php

namespace RalphJSmit\Filament\SEO;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use RalphJSmit\Filament\SEO\Components\TextInput;

class SEO
{
    public static function make(): array
    {
        return [
            Group::make([
                TextInput::make('title')
                    ->label(tr('title'))
                    ->columnSpan(2),
                TextInput::make('author')
                    ->label(tr('author'))
                    ->columnSpan(2),
                Textarea::make('description')
                    ->label(tr('description'))
                    ->columnSpan(2),
            ])
                ->afterStateHydrated(function (Group $component, ?Model $record): void {
                    $component->getChildComponentContainer()->fill(
                        $record?->seo->only(['title', 'description', 'author']) ?? []
                    );
                })
                ->statePath('seo')
                ->dehydrated(false)
                ->saveRelationshipsUsing(function (Model $record, array $state): void {
                    $record->seo->update($state);
                }),
        ];
    }
}
