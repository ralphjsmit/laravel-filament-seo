<?php

namespace RalphJSmit\Filament\SEO;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class SEO
{
    public static function make(array $only = ['title', 'author', 'description', 'robots']): Section
    {
        return Section::make(
            Arr::only([
                'title' => TextInput::make('title')
                    ->translateLabel()
                    ->label(__('filament-seo::translations.title'))
                    ->helperText(function (?string $state): string {
                        return (string) Str::of(strlen($state))
                            ->append(' / ')
                            ->append(60 . ' ')
                            ->append(Str::of(__('filament-seo::translations.characters'))->lower());
                    })
                    ->reactive()
                    ->columnSpan(2),
                'author' => TextInput::make('author')
                    ->translateLabel()
                    ->label(__('filament-seo::translations.author'))
                    ->columnSpan(2),
                'description' => Textarea::make('description')
                    ->translateLabel()
                    ->label(__('filament-seo::translations.description'))
                    ->helperText(function (?string $state): string {
                        return (string) Str::of(strlen($state))
                            ->append(' / ')
                            ->append(160 . ' ')
                            ->append(Str::of(__('filament-seo::translations.characters'))->lower());
                    })
                    ->reactive()
                    ->columnSpan(2),
                'robots' => Select::make('robots')
                    ->label(__('filament-seo::translations.robots'))
                    ->options([
                        'index, follow' => 'Index, Follow',
                        'index, nofollow' => 'Index, Nofollow',
                        'noindex, follow' => 'Noindex, Follow',
                        'noindex, nofollow' => 'Noindex, Nofollow',
                    ]),

            ], $only)
        )
            ->afterStateHydrated(function (Section $component, ?Model $record) use ($only): void {
                $component->getChildComponentContainer()->fill(
                    $record?->seo?->only($only) ?: []
                );
            })
            ->statePath('seo')
            ->dehydrated(false)
            ->saveRelationshipsUsing(function (Model $record, array $state) use ($only): void {
                $state = collect($state)->only($only)->map(fn ($value) => $value ?: null)->all();

                if ($record->seo && $record->seo->exists) {
                    $record->seo->update($state);
                } else {
                    $record->seo()->create($state);
                }
            });
    }
}
