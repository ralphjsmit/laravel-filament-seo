<?php

namespace RalphJSmit\Filament\SEO\Tests\Fixtures\Http\Livewire;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use RalphJSmit\Filament\SEO\Components\TextInput;
use RalphJSmit\Filament\SEO\SEO;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Models\Post;

class CreatePost extends Component implements HasForms
{
    use InteractsWithForms;

    public static $SEOParameters = [];

    public array $data = [];

    public function render(): string
    {
        return "<div>" . $this->form . '</div>';
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('title'),
            ...SEO::make(...static::$SEOParameters),
        ];
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function submitForm()
    {
        Post::create($this->form->getState());
    }
}