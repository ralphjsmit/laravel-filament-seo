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
            static::$SEOParameters ? SEO::make(static::$SEOParameters) : SEO::make(),
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