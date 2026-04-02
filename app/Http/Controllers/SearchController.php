<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $results = News::with('category')
            ->when($query !== '', function ($search) use ($query) {
                $search->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('title', 'like', "%{$query}%")
                        ->orWhere('body', 'like', "%{$query}%");
                });
            })
            ->latest()
            ->get();

        return view('search.results', compact('results', 'query'));
    }
}
