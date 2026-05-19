<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Str;
use App\Models\Article;
use App\Models\Category;


class CategoryController extends Controller
{
    public function show(Category $category, Request $request){
        $articles = $category->articles()
        ->when($request->search, function($query) use ($request){
            $query->where('title', 'like', '%' . $request->search . '%');
        })
        ->latest()->paginate(6);

        $articles->appends($request->only('search'));
        return view('articles.category_show', compact('category', 'articles'));

        
    }

}
