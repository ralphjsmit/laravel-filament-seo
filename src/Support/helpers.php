<?php

function tr(string $key): Stringable
{
    return Str::of(trans("filament-seo::translations.{$key}"));
}