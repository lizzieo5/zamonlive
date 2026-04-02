<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\News;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = Tag::with('news')
            ->where('slug', $slug)
            ->firstOrFail();

        $news = News::with(['category', 'tags'])
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->latest()
            ->paginate(12);

        return view('tag.show', compact('tag', 'news'));
    }
}