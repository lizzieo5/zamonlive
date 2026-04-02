<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $category = Category::with('news')
            ->where('slug', $slug)
            ->firstOrFail();

        $news = News::with('category')
            ->where('category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('category.index', compact('category', 'news'));
    }
}