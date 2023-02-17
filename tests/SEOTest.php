<?php

use function Pest\Laravel\assertDatabaseCount;
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

it('can update a post without a seo model', function () {
    $post = Post::create([
        'title' => 'Hello World',
    ]);

    $post->seo->delete();

    $livewire = Livewire\Livewire::test(EditPost::class, [
        'post' => $post,
    ]);

    assertDatabaseCount(SEO::class, 0);

    $livewire
        ->set('data.seo.title', 'Hello World')
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
        ->set('data.title', 'Hello World #2')
        ->assertSet('data.seo.title', 'Hello World – Google')
        ->assertSet('data.seo.description', 'Description – Google')
        ->assertSet('data.seo.author', 'Author – Google')
        ->set('data.seo.title', 'Hello World #2 – Google')
        ->set('data.seo.description', '')
        ->set('data.seo.author', 'Author #2 – Google')
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

    $livewire = Livewire\Livewire::test(EditPost::class, [
        'post' => $post,
    ]);

    $livewire
        ->assertSet('post', $post);

    $livewire
        ->set('data.title', 'Hello World #3')
        ->set('data.seo.title', 'Hello World #3 – Google')
        ->set('data.seo.description', 'Test #4')
        ->set('data.seo.author', 'Author #3 – Google')
        ->call('submitForm')
        ->assertHasNoErrors();

    expect($post->refresh())->title->toBe('Hello World #3');

    assertDatabaseHas(Post::class, [
        'title' => 'Hello World #3',
    ]);

    assertDatabaseHas(SEO::class, [
        'title' => e('Hello World #3 – Google'),
        'description' => e('Test #4'),
        'author' => e('Author #3 – Google'),
    ]);
});
