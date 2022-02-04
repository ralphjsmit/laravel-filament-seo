<?php

namespace RalphJSmit\Filament\SEO;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSEOServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-filament-seo')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-filament-seo_table');
    }
}
