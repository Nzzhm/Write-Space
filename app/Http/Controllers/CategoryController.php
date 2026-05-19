<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Models\Article;
use App\Models\Category;


class CategoryController extends Controller
{
    public function show(Category $category){
        $articles = $category->articles()->latest()->paginate(10);
        return view('articles.category_show', compact('category', 'articles'));
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required|max:100'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return back()->with('success', 'Kategori berhasil di tambahkan');
    }
}
