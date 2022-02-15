<?php

namespace RalphJSmit\Filament\SEO\Components;

class TextInput extends \Filament\Forms\Components\TextInput
{
    public function setUp(): void
    {
        parent::setUp();

        $this->registerListeners([
            'save' => [
                function (TextInput $component): void {
                    ray($component);
                    dd($component);
                },
            ],
        ]);
    }
}