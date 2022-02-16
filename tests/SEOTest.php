<?php

use RalphJSmit\Filament\SEO\Tests\Fixtures\Http\Livewire\CreatePost;

it('can render the input', function () {
    $livewire = Livewire\Livewire::test(CreatePost::class);

    $livewire
        ->set('data.title', 'Hello World')
        ->set('seo.title', 'Hello World – Google')
        ->set('seo.description', 'Description – Google')
        ->call('submitForm')
        ->assertHasNoErrors();
});
