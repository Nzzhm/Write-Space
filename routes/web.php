<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;
use App\Models\Article;
use Illuminate\Support\Facades\Route;



Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
Route::resource('articles', ArticleController::class)
->except(['index', 'show'])
->middleware('auth');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');

Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('auth');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/hero', [AdminController::class, 'updateHero'])->name('hero');
    Route::post('/editors-choice/{article}', [AdminController::class, 'updateEditorsChoice'])->name('editorsChoice');
    Route::post('/quote', [AdminController::class, 'updateQuote'])->name('quote');
    Route::delete('articles/{article}', [AdminController::class, 'destroy'])->name('articles.destroy');
    Route::get('/articles/search', [AdminController::class, 'searchArticles'])->name('admin.articles.search');
    Route::post('/category', [AdminController::class, 'createCategories'])->name('create.categories');
    Route::delete('categories/{category}', [AdminController::class, 'destroyCategory'])->name('destroy.category');
    Route::patch('categories/{category}', [AdminController::class, 'updateCategory'])
    ->name('update.category');
    Route::get('/tags', [AdminController::class, 'tags'])->name('tags');
    Route::delete('/tags/{tag}', [AdminController::class, 'destroyTag'])->name('tags.destroy');
});

Route::get('/my-articles', [ArticleController::class, 'myArticles'])->middleware('auth')->name('articles.my');
Route::get('/all-articles', [ArticleController::class, 'allArticles'])->name('articles.all');
Route::get('/about', [ArticleController::class, 'aboutUs'])->name('articles.about');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
