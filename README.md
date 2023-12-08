![laravel-filament-seo](https://github.com/ralphjsmit/laravel-filament-seo/blob/main/docs/images/laravel-filament-seo.jpg)

# Combine the power of Laravel SEO and Filament PHP.

This package is a **convenient helper for using the [laravel-seo](https://github.com/ralphjsmit/laravel-seo) package** with [Filament Admin and Forms](https://filamentphp.com).

It provides a simple component that returns a Filament fieldgroup to modify the `title`, `author` and `description` fields of the SEO model. It automatically **takes care of getting and saving all the data** to the `seo()` relationship, and you can thus use it anywhere, **without additional configuration!**

```php
use Filament\Resources\Form;
use RalphJSmit\Filament\SEO\SEO;

public static function form(Form $form): Form
{
    return $form->schema([
        SEO::make(),
       // .. Your other fields
    ]);
}
```

Here's an example of how the `SEO` component looks like:

![Using the Laravel Filament SEO component](https://raw.githubusercontent.com/ralphjsmit/laravel-filament-seo/main/docs/images/card.png)

## Installation

First, install the packages:

```shell
composer require ralphjsmit/laravel-filament-seo
```

This will the require the `ralphjsmit/laravel-seo` as well if you didn't have that installed. Be sure to [check out the documentation of the main package](https://github.com/ralphjsmit/laravel-seo) and configure the values in the special `seo.php` config file!

Next, make sure that the **Eloquent Model** you're editing **uses the `HasSEO` trait**:

```php
class Post extends Model
{
    use HasSEO;
}
```

Now the **`SEO::make()` helper is available to use anywhere** you want. Below are several examples how to use it:

### In Filament Admin

This is an example of **using this package in the classic [Filament Admin](https://filamentphp.com/docs/2.x/admin/installation)**.

It works for **both creating and editing posts**:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources;
use App\Models\Post;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use RalphJSmit\Filament\SEO\SEO;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    
    protected static ?string $slug = 'posts';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title'),
            SEO::make(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([ /* */ ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Resources\PostResource\Pages\ListPosts::route('/'),
            'create' => Resources\PostResource\Pages\CreatePost::route('/create'),
            'edit' => Resources\PostResource\Pages\EditPost::route('{record}/edit'),
        ];
    }
}
```

### With Filament Forms

You can also **use this package with the stand-alone [Filament Forms](https://filamentphp.com/docs/2.x/forms/installation)** package.

This is a simple example of **how to setup a Livewire component that creates a new post**. In this example, I wrapped the `SEO` component in a Card.

```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use RalphJSmit\Filament\SEO\SEO;

class CreatePost extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function render(): View
    {
        return view('livewire.create-post');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
            Card::make([
                SEO::make()
            ]),
        ];
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    protected function getFormModel(): Model|string|null
    {
        return Post::class;
    }

    public function submitForm()
    {
        $post = Post::create($this->form->getState());

        /** Do not forget this step. */
        $this->form->model($post)->saveRelationships();
    }
}
```

And here's an example of how a **Livewire component for editing a post** might like like:

```php
<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use RalphJSmit\Filament\SEO\SEO;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Models\Post;

class EditPost extends Component implements HasForms
{
    use InteractsWithForms;

    public Post $post;

    public function mount(): void
    {
        $this->form->fill([
            'title' => $this->post->title,
        ]);
    }

    public function render(): View
    {
        return view('livewire.edit-post');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
            SEO::make(),
        ];
    }

    protected function getFormModel(): Model|string|null
    {
        return $this->post;
    }

    public function submitForm()
    {
        $this->post->update(
            $this->form->getState(),
        );
    }
}
```

## General

🐞 If you spot a bug, please submit a detailed issue and I'll try to fix it as soon as possible.

🔐 If you discover a vulnerability, please review [our security policy](../../security/policy).

🙌 If you want to contribute, please submit a pull request. All PRs will be fully credited. If you're unsure whether I'd accept your idea, feel free to contact me!

🙋‍♂️ [Ralph J. Smit](https://ralphjsmit.com)



