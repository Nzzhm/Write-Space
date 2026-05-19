<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SiteSetting;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class AdminController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $editingId  = $request->query('edit');
        $currentHero    = Article::where('is_hero', true)->first();
        $editorsChoice  = Article::where('is_editors_choice', true)->get();
        $quoteText      = SiteSetting::get('quote_text', '');
        $quoteAuthor    = SiteSetting::get('quote_author', '');
    
        // Search artikel — query TIDAK ditimpa lagi
        $articles = Article::with('category', 'user')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString(); // agar search ikut ke halaman pagination berikutnya
    
        // Search kategori
        $categories = Category::when($request->filled('search_category'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search_category . '%');
            })
            ->paginate(10, ['*'], 'category_page')
            ->withQueryString();
    
        return view('admin.index', compact(
            'articles', 'quoteText', 'quoteAuthor',
            'currentHero', 'editorsChoice', 'categories', 'editingId'
        ));
    }
    public function updateHero(Request $request)
    {
        // Reset semua hero dulu
        Article::where('is_hero', true)->update(['is_hero' => false]);
        // Set yang baru
        Article::findOrFail($request->article_id)->update(['is_hero' => true]);
        return back()->with('success', 'Hero artikel berhasil diupdate!');
    }

    public function updateEditorsChoice(Request $request, Article $article)
    {
        $count = Article::where('is_editors_choice', true)
                        ->where('id', '!=', $article->id)
                        ->count();

        if ($request->is_editors_choice && $count >= 3) {
            return back()->withErrors(['editors_choice' => 'Maksimal 3 Editor\'s Choice!']);
        }

        $article->update(['is_editors_choice' => $request->boolean('is_editors_choice')]);
        return back()->with('success', 'Editor\'s Choice berhasil diupdate!');
    }

    public function updateQuote(Request $request)
    {
        $request->validate([
            'quote_text'   => 'required',
            'quote_author' => 'required',
        ]);

        SiteSetting::updateOrCreate(
            ['key' => 'quote_text'],
            ['value' => $request->quote_text]
        );
        SiteSetting::updateOrCreate(
            ['key' => 'quote_author'],
            ['value' => $request->quote_author]
        );

        return back()->with('success', 'Quote berhasil diupdate!');
    }

    public function searchArticles(Request $request)
    {
        $articles = Article::where('title', 'like', '%' . $request->q . '%')
                        ->select('id', 'title', 'is_hero', 'is_editors_choice')
                        ->take(10)
                        ->get();
        return response()->json($articles);
    }

    public function destroy(Article $article){
        if ($article->thumbnail){
            Storage::disk('public')->delete($article->thumbnail);
        }
        $article->delete();
        return back()->with('success', 'artikel berhasil di hapus');
    }

    public function createCategories(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Kategori berhasil di tambahkan');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.index')->with('success', 'Kategori berhasil di edit');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil di hapus');
    }

    public function tags(Request $request)
    {
        $tags = Tag::withCount('articles')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('articles_count', 'desc')
            ->paginate(15)
            ->withQueryString();
    
        return view('admin.tags', compact('tags'));
    }

    public function destroyTag(Tag $tag)
    {
        $tag->delete(); // pivot article_tag ikut terhapus karena cascade
        return back()->with('success', 'Tag berhasil dihapus!');
    }
}