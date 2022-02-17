<?php

namespace RalphJSmit\Filament\SEO\Tests\Fixtures\Http\Livewire;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use RalphJSmit\Filament\SEO\SEO;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Models\Post;

class CreatePost extends Component implements HasForms
{
    use InteractsWithForms;

    public static $SEOParameters = [];

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
            static::$SEOParameters ? SEO::make(static::$SEOParameters) : SEO::make(),
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

        $this->form->model($post)->saveRelationships();
    }
}
