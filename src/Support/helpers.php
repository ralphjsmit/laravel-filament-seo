<?php

namespace RalphJSmit\Filament\SEO\Support;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

function tr(string $key): Stringable
{
    return Str::of(trans("filament-seo::translations.{$key}"));
}
