<?php

namespace RalphJSmit\Filament\SEO\Tests;

use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\View;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filament\SEO\FilamentSEOServiceProvider;
use RalphJSmit\Laravel\SEO\LaravelSEOServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(fn (string $modelName) => 'RalphJSmit\\Filament\\SEO\\Database\\Factories\\' . class_basename($modelName) . 'Factory');
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            LaravelSEOServiceProvider::class,
            FilamentSEOServiceProvider::class,
            SupportServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        View::addLocation(__DIR__ . '/Fixtures/resources/views');

        (include __DIR__ . '/Fixtures/migrations/create_test_tables.php')->up();
        (include __DIR__ . '/../vendor/ralphjsmit/laravel-seo/database/migrations/create_seo_table.php.stub')->up();
    }
}
