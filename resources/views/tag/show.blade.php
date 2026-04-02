@extends('layouts.app')

@section('title', $tag->name . ' - ZamonLive')

@section('content')

<div class="tag-wrapper">
    <div class="container">
        <div class="tag-header">
            <h1 class="tag-title">
                <i class="fas fa-hashtag"></i>
                {{ $tag->name }}
            </h1>
            <p class="tag-meta">
                {{ $news->total() }} ta yangilik
            </p>
        </div>

        <div class="tag-news-grid">
            @forelse($news as $item)
            <article class="grid-news-card">
                <a href="{{ route('news.show', $item->slug) }}" class="grid-news-card__img">
                    <img src="{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : asset('images/placeholder.jpg') }}"
                         alt="{{ $item->title }}" loading="lazy">
                    <span class="grid-news-card__cat-badge">{{ $item->category->name ?? '' }}</span>
                </a>
                <div class="grid-news-card__body">
                    <div class="grid-news-card__meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ $item->created_at->format('d.m.Y') }}</span>
                        <span><i class="fas fa-clock"></i> {{ $item->created_at->format('H:i') }}</span>
                    </div>
                    <h3 class="grid-news-card__title">
                        <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                    </h3>
                    <p class="grid-news-card__excerpt">
                        {{ Str::limit(strip_tags($item->body), 80) }}
                    </p>
                </div>
            </article>
            @empty
            <div class="empty-state">
                <i class="fas fa-file-alt" style="font-size: 3rem; color: var(--gray-400); display: block; margin-bottom: 16px;"></i>
                <p style="color: var(--gray-600);">Bu teg bilan yangiliklar hozircha mavjud emas</p>
            </div>
            @endforelse
        </div>

        @if($news->hasPages())
        <div class="pagination">
            {{ $news->links() }}
        </div>
        @endif
    </div>
</div>

<style>
.tag-wrapper {
    padding: 40px 20px;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.tag-header {
    text-align: center;
    margin-bottom: 40px;
    padding: 40px 20px;
    background: linear-gradient(135deg, var(--green-mid-dark), var(--green-dark));
    border-radius: var(--radius-lg);
    color: white;
}

.tag-title {
    font-family: var(--font-display);
    font-size: 2.5rem;
    margin: 0 0 10px 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}

.tag-meta {
    font-size: 1.1rem;
    opacity: 0.9;
}

.tag-news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

.empty-state {
    grid-column: 1/-1;
    text-align: center;
    padding: 60px 20px;
}

.pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}

.pagination ::v-deep span, .pagination ::v-deep a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 4px;
    border-radius: var(--radius-sm);
    text-decoration: none;
    color: var(--text-dark);
}

.pagination ::v-deep a:hover {
    background: var(--green-mid);
    color: white;
}

.pagination ::v-deep .active {
    background: var(--green-mid);
    color: white;
}
</style>

@endsection