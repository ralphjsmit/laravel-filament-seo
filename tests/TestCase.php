<?php

namespace RalphJSmit\Filament\SEO\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filament\SEO\FilamentSEOServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'RalphJSmit\\FilamentSEO\\Database\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            FilamentSEOServiceProvider::class,
            LivewireServiceProvider::class,
            FilamentSEOServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-filament-seo_table.php.stub';
        $migration->up();
        */
    }
}
