<?php

namespace RalphJSmit\Filament\SEO\Tests;

use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Support\SupportServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\View;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RalphJSmit\Filament\SEO\FilamentSEOServiceProvider;
use RalphJSmit\Laravel\SEO\LaravelSEOServiceProvider;

class TestCase extends Orchestra
{
	use DatabaseTransactions;
	
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(fn (string $modelName) => 'RalphJSmit\\Filament\\SEO\\Database\\Factories\\' . class_basename($modelName) . 'Factory');
	    
	    View::addLocation(__DIR__ . '/Fixtures/resources/views');
		
		(include __DIR__ . '/Fixtures/migrations/create_test_tables.php')->up();
		(include __DIR__ . '/../vendor/ralphjsmit/laravel-seo/database/migrations/create_seo_table.php.stub')->up();
	}

    protected function getPackageProviders($app): array
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
}
