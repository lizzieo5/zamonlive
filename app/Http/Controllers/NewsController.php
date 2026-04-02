<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Category;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function show($slug)
    {
        $news = News::with(['category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related news from same category
        $relatedNews = News::with('category')
            ->where('category_id', $news->category_id)
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(4)
            ->get();

        // Get popular news
        $popularNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('news.show', compact('news', 'relatedNews', 'popularNews'));
    }
}