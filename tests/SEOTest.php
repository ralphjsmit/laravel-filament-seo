<?php

use function Pest\Laravel\assertDatabaseHas;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Http\Livewire\CreatePost;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Http\Livewire\EditPost;
use RalphJSmit\Filament\SEO\Tests\Fixtures\Models\Post;

use RalphJSmit\Laravel\SEO\Models\SEO;

it('can create a post with seo', function () {
    $livewire = Livewire\Livewire::test(CreatePost::class);

    $livewire
        ->set('data.title', 'Hello World')
        ->set('data.seo.title', 'Hello World – Google')
        ->set('data.seo.description', 'Description – Google')
        ->set('data.seo.author', 'Author – Google')
        ->call('submitForm')
        ->assertHasNoErrors();

    assertDatabaseHas(Post::class, [
        'title' => 'Hello World',
    ]);

    assertDatabaseHas(SEO::class, [
        'title' => e('Hello World – Google'),
        'description' => e('Description – Google'),
        'author' => e('Author – Google'),
    ]);
});

it('can update the post with seo', function () {
    $post = Post::create([
        'title' => 'Hello World',
    ]);

    $post->seo->update([
        'title' => 'Hello World – Google',
        'description' => 'Description – Google',
        'author' => 'Author – Google',
    ]);

    EditPost::$SEOParameters = [];

    $livewire = Livewire\Livewire::test(EditPost::class, [
        'post' => $post,
    ]);

    $livewire
        ->assertSet('post', $post)
        ->set('title', 'Hello World #2')
        ->set('seo.title', 'Hello World #2 – Google')
        ->set('seo.description', '')
        ->set('seo.author', 'Author #2 – Google')
        ->call('submitForm')
        ->assertHasNoErrors();

    expect($post->refresh())->title->toBe('Hello World #2');

    assertDatabaseHas(Post::class, [
        'title' => 'Hello World #2',
    ]);

    assertDatabaseHas(SEO::class, [
        'title' => e('Hello World #2 – Google'),
        'description' => null,
        'author' => e('Author #2 – Google'),
    ]);
});

it('can update the post with seo and not all fields', function () {
    $post = Post::create([
        'title' => 'Hello World',
    ]);

    $post->seo->update([
        'title' => 'Hello World – Google',
        'description' => 'Description – Google',
        'author' => 'Author – Google',
    ]);

    EditPost::$SEOParameters = ['title', 'author'];

    $livewire = Livewire\Livewire::test(EditPost::class, [
        'post' => $post,
    ]);

    $livewire
        ->assertSet('post', $post)
        ->set('title', 'Hello World #3')
        ->set('seo.title', 'Hello World #3 – Google')
        ->set('seo.description', 'NON-EXISTING SUBSCRIPTION')
        ->set('seo.author', 'Author #3 – Google')
        ->call('submitForm')
        ->assertHasNoErrors();

    expect($post->refresh())->title->toBe('Hello World #3');

    assertDatabaseHas(Post::class, [
        'title' => 'Hello World #3',
    ]);

    assertDatabaseHas(SEO::class, [
        'title' => e('Hello World #3 – Google'),
        'description' => 'Description – Google',
        'author' => e('Author #3 – Google'),
    ]);
});
