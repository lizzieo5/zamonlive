<?php

namespace App\Http\Controllers;
use App\Models\News;
use App\Models\Category;
use App\Models\Newspaper;
use Illuminate\Http\Request;

class HomeController extends Controller{
    public function index(){
        $latestNews = News::latest()->take(5)->get();
        $categories = Category::with('news')->get();
        $newspapers = Newspaper::latest()->first();

        return view('home', compact('latestNews', 'categories', 'newspapers'));
}
}
