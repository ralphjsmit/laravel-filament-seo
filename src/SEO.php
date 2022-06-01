<?php

namespace RalphJSmit\Filament\SEO;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SEO
{
    public static function make(array $only = ['title', 'author', 'description']): Group
    {
        return Group::make(
            Arr::only([
                'title' => TextInput::make('title')
                    ->label(__('filament-seo::translations.title'))
                    ->columnSpan(2),
                'author' => TextInput::make('author')
                    ->label(__('filament-seo::translations.author'))
                    ->columnSpan(2),
                'description' => Textarea::make('description')
                    ->label(__('filament-seo::translations.description'))
                    ->helperText(function (?string $state): string {
                        return Str::of(strlen($state))
                            ->append(' / ')
                            ->append(160 . ' ')
                            ->append(Str::of(__('filament-seo::translations.characters'))->lower())
                            ->value();
                    })
                    ->reactive()
                    ->columnSpan(2),
            ], $only)
        )
            ->afterStateHydrated(function (Group $component, ?Model $record) use ($only): void {
                $component->getChildComponentContainer()->fill(
                    $record?->seo?->only($only) ?: []
                );
            })
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                $state = collect($state)->only($only)->map(fn ($value) => $value ?: null)->all();

                if ($seo = $record->seo) {
                    $seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }
}
