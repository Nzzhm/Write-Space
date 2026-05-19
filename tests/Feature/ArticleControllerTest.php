<?php

use App\Models\User;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guest can access article index', function () {
    $response = $this->get(route('articles.index'));
    $response->assertStatus(200);
});

test('guest cannot create article', function () {
    $response = $this->post(route('articles.store'), [
        'title' => 'Artikel Tanpa Login',
        'body'  => 'Isi artikel',
    ]);
    $response->assertRedirect(route('login'));
});

test('authenticated user can create article', function () {
    Storage::fake('public');

    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post(route('articles.store'), [
        'title'       => 'Artikel Pertama Saya',
        'body'        => 'Ini adalah isi artikel yang cukup panjang.',
        'category_id' => $category->id,
        'thumbnail'   => UploadedFile::fake()->image('foto.jpg'),
    ]);

    $response->assertRedirect(route('articles.index'));
    $this->assertDatabaseHas('articles', ['title' => 'Artikel Pertama Saya']);
});

test('store article fails without title', function () {
    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post(route('articles.store'), [
        'title'       => '',
        'body'        => 'Isi artikel',
        'category_id' => $category->id,
    ]);

    $response->assertSessionHasErrors('title');
});

test('store article fails without body', function () {
    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->post(route('articles.store'), [
        'title'       => 'Ada Judul',
        'body'        => '',
        'category_id' => $category->id,
    ]);

    $response->assertSessionHasErrors('body');
});

test('slug is unique when title is duplicate', function () {
    $user     = User::factory()->create();
    $category = Category::factory()->create();

    $this->actingAs($user)->post(route('articles.store'), [
        'title'       => 'Judul Sama',
        'body'        => 'Isi pertama',
        'category_id' => $category->id,
    ]);

    $this->actingAs($user)->post(route('articles.store'), [
        'title'       => 'Judul Sama',
        'body'        => 'Isi kedua',
        'category_id' => $category->id,
    ]);

    $this->assertDatabaseHas('articles', ['slug' => 'judul-sama']);
    $this->assertDatabaseHas('articles', ['slug' => 'judul-sama-1']);
});

test('user can update their own article', function () {
    $user     = User::factory()->create();
    $article  = Article::factory()->create(['user_id' => $user->id]);
    $category = Category::factory()->create();

    $response = $this->actingAs($user)->put(route('articles.update', $article), [
        'title'       => 'Judul Diupdate',
        'body'        => 'Isi artikel diupdate',
        'category_id' => $category->id,
    ]);

    // Refresh article karena slug berubah setelah update
    $updatedArticle = $article->fresh();

    $response->assertRedirect(route('articles.show', $updatedArticle));
    $this->assertDatabaseHas('articles', ['title' => 'Judul Diupdate']);
});

test('user can delete their own article', function () {
    Storage::fake('public');

    $user    = User::factory()->create();
    $article = Article::factory()->create(['user_id' => $user->id]);

    $response = $this->actingAs($user)->delete(route('articles.destroy', $article));

    $response->assertRedirect(route('articles.index'));
    $this->assertDatabaseMissing('articles', ['id' => $article->id]);
});

test('show article increments view count', function () {
    $article = Article::factory()->create(['views' => 0]);

    $this->get(route('articles.show', $article));

    expect($article->fresh()->views)->toBe(1);
});