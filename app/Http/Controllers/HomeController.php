<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Newspaper;

class HomeController extends Controller
{
    public function index()
    {
        $navCategories = Category::orderBy('id')->get();

        $latestNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();

        $breakingNews = News::with('category')
            ->latest()
            ->take(5)
            ->get();

        $featuredCategory = $latestNews->first()?->category
            ?? Category::whereHas('news')->orderByDesc('id')->first();

        $featuredCategoryNews = $featuredCategory
            ? $featuredCategory->news()
                ->with('category')
                ->latest()
                ->take(8)
                ->get()
            : collect();

        $allCategoryNews = $navCategories
            ->map(function (Category $category) {
                return [
                    'category' => $category,
                    'news' => $category->news()
                        ->with('category')
                        ->latest()
                        ->take(8)
                        ->get(),
                ];
            })
            ->reject(function (array $item) use ($featuredCategory) {
                return $featuredCategory && $item['category']->id === $featuredCategory->id;
            })
            ->filter(function (array $item) {
                return $item['news']->isNotEmpty();
            })
            ->values();

        $latestNewspaper = Newspaper::latest()->first();

        return view('home', compact(
            'navCategories',
            'breakingNews',
            'latestNews',
            'featuredCategory',
            'featuredCategoryNews',
            'allCategoryNews',
            'latestNewspaper'
        ));
    }
}
