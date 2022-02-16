# Combine the power of Laravel SEO and Filament Admin & Filament Forms.

This package is a nice helper for using the [laravel-seo](https://github.com/ralphjsmit/laravel-seo) package with [Filament Admin and Filament Forms](https://filamentphp.com).

It provides a simple component that returns an array with the fields to modify the `title`, `author` and `description` fields of the SEO model. It automatically takes care of getting and saving all the data to the `seo()` relationship, and you can thus use it anywhere.

```php
use Filament\Resources\Form;
use RalphJSmit\Filament\SEO\SEO;

public static function form(Form $form): Form
{
    return $form->schema([
        ...SEO::make(),
       // .. Your other fields
    ]);
}
```

## Installation

First, install the packages:

```shell
composer require ralphjsmit/laravel-filament-seo
```

This will the require the `ralphjsmit/laravel-seo` as well if you didn't have that installed.

Now this helper is available to use anywhere you want:



