<?php

use App\Models\Article;
use App\Models\User;
use App\Models\Category;

test('article belongs to user', function () {
    $article = Article::factory()->create();
    expect($article->user)->toBeInstanceOf(User::class);
});

test('article belongs to category', function () {
    $article = Article::factory()->create();
    expect($article->category)->toBeInstanceOf(Category::class);
});

test('article views can be incremented', function () {
    $article = Article::factory()->create(['views' => 0]);
    $article->increment('views');
    expect($article->fresh()->views)->toBe(1);
});

test('article can be marked as hero', function () {
    $article = Article::factory()->create(['is_hero' => false]);
    $article->update(['is_hero' => true]);
    expect((bool) $article->fresh()->is_hero)->toBeTrue();
});