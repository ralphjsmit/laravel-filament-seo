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

class EditPost extends Component implements HasForms
{
    use InteractsWithForms;

    public static $SEOParameters = [];

    public array $data = [];

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

    protected function getFormModel(): Model|string|null
    {
        return $this->post;
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('title')->required(),
            static::$SEOParameters ? SEO::make(static::$SEOParameters) : SEO::make(),
        ];
    }

    protected function getFormStatePath(): ?string
    {
        return 'data';
    }

    public function submitForm()
    {
        $this->post->update(
            $this->form->getState(),
        );
    }
}
