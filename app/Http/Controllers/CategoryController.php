<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;

class CategoryController extends Controller
{
    public function index($slug)
    {
        $navCategories = Category::orderBy('id')->get();
        $breakingNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();

        $currentCategory = Category::with('news')
            ->where('slug', $slug)
            ->firstOrFail();

        $news = News::with('category')
            ->where('category_id', $currentCategory->id)
            ->latest()
            ->paginate(12);

        return view('category.index', compact('navCategories', 'breakingNews', 'currentCategory', 'news'));
    }
}
