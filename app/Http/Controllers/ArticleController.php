<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\Tag;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hero = Article::where('is_hero', true)->with('category', 'user')->first();
        $latest = Article::latest()
            ->when($hero, fn($q) => $q->where('id', '!=', $hero->id))
            ->take(3)->with('category', 'user')->get();
        $editorsChoice = Article::where('is_editors_choice', true)
            ->with('category', 'user')->get();
        $quoteText = SiteSetting::get('quote_text', '"Apapun yang terjadi tetaplah bernapas"');
        $quoteAuthor = SiteSetting::get('quote_author', '— Dieter Rams');

        return view('articles.index', compact('hero', 'latest', 'editorsChoice', 'quoteText', 'quoteAuthor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            
            'tags.*' => 'exists:tags,id'
        ]);

        $thumbnailPath = null;
        if($request->hasFile('thumbnail')){
            // $path = $request->file('thumbnail')->store('thumbnails', 'public')
            // $request['thumbnail'] = $path;
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails','public');
        }

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }


        $article = Article::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id
            
        ]);

            if ($request->filled('tags_input')) { 
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags_input)));
            $tagIds = [];
            
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name]
                );
                $tagIds[] = $tag->id;
            }
            
            $article->tags()->sync($tagIds);
            
        }

        return redirect()->route('articles.index')->with('success', 'Article berhasil di publikasikan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->increment('views');
        $article->load('category', 'tags');
        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('articles.edit', compact('article', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
            'category_id' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id'
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        

        $thumbnailPath = $article->thumbnail;
        if($request->hasFile('thumbnail')){
            if($article->thumbnail){
                Storage::disk('public')->delete($article->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        if($request->is_hero){
            Article::where('is_hero', true)->update(['is_hero'=> false]);
        }

        if($request->is_editors_choice){
            $count = Article::where('is_editors_choice', true)->where('id', '!=', $article->id)->count();
            if($count >= 3){
                return back()->withErrors(['is_editors_choice' => 'Maksimal 3 artikel pilihan editor']);
            }
        }

        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath,
            'category_id' => $request->category_id
        ]);

        if ($request->filled('tags_input')) {
            $tagNames = array_filter(array_map('trim', explode(',', $request->tags_input)));
            $tagIds = [];
            foreach ($tagNames as $name) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug($name)],
                    ['name' => $name]
                );
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        } else {
            $article->tags()->detach(); // kosongkan tags kalau input kosong
        }

        return redirect()->route('articles.show', $article)->with('success', 'Artikel berhasil di edit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->thumbnail){
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        
        return redirect()->route('articles.index')->with('success', 'Artikel berhasil di hapus');
    }

    public function myArticles(Request $request)
    {
        $articles = Article::where('user_id', Auth::id())->with('category', 'user')->when($request->filled('search'), function ($query) use ($request){
            $query->where('title', 'like', '%'. $request->search . '%');
        })->latest()->paginate(10);

        return view('articles.my-articles', compact('articles'));
    }

        public function allArticles(Request $request)
    {
        $featured = Article::where('is_hero', true)->with('category', 'user')->first();

        $second = Article::with('category', 'user')->latest()
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->first();

        $query = Article::with('category', 'user')->latest() // ← sebelumnya tidak ada titik koma
            ->when($featured, fn($q) => $q->where('id', '!=', $featured->id))
            ->when($second, fn($q) => $q->where('id', '!=', $second->id));

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'))
                ->orWhereHas('tags', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
            });
        }

        $articles = $query->paginate(9);
        $categories = Category::withCount('articles')
            ->orderBy('articles_count', 'desc')
            ->take(5)
            ->get();

        return view('articles.all-articles', compact('articles', 'featured', 'second', 'categories'));
    }

    public function searchTags(Request $request)
    {
        $tags = Tag::where('name', 'like', '%' . $request->q . '%')
                ->select('id', 'name')
                ->take(10)
                ->get();
        return response()->json($tags);
    }

    public function aboutUs()
    {
        return view('articles.about');
    }
}
