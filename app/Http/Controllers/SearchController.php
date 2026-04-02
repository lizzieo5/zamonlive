<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = News::where('title', 'like', "%{$query}%")
                       ->orWhere('content', 'like', "%{$query}%")
                       ->get();

        return view('search.results', compact('results', 'query'));
    }
}
