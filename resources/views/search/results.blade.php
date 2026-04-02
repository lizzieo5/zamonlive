@extends('layouts.app')

@section('title', ($query !== '' ? "Qidiruv: {$query}" : 'Qidiruv') . ' — ZamonLive')

@section('content')

<div class="search-page-wrapper">
    <div class="search-page-container">
        <div class="search-page-header">
            <h1 class="search-page-title">
                <i class="fas fa-search"></i>
                @if($query !== '')
                    "{{ $query }}" bo'yicha natijalar
                @else
                    Qidiruv natijalari
                @endif
            </h1>
            <p class="search-page-meta">{{ $results->count() }} ta natija topildi</p>
        </div>

        <div class="search-results-grid">
            @forelse($results as $item)
                <article class="grid-news-card">
                    <a href="{{ route('news.show', $item->slug) }}" class="grid-news-card__img">
                        <img src="{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : asset('images/placeholder.jpg') }}"
                             alt="{{ $item->title }}" loading="lazy">
                        <span class="grid-news-card__cat-badge">{{ $item->category->name ?? 'Yangilik' }}</span>
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
                            {{ Str::limit(strip_tags($item->body), 100) }}
                        </p>
                    </div>
                </article>
            @empty
                <div class="empty-state" style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                    <i class="fas fa-search" style="font-size: 3rem; color: var(--gray-400); display: block; margin-bottom: 16px;"></i>
                    <p style="color: var(--gray-600);">
                        @if($query !== '')
                            Hech narsa topilmadi
                        @else
                            Qidirish uchun so'z kiriting
                        @endif
                    </p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.search-page-wrapper { padding: 30px 0 50px; }
.search-page-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }
.search-page-header {
    background: linear-gradient(135deg, var(--green-dark), var(--green-mid-dark));
    color: white;
    padding: 28px 30px;
    border-radius: var(--radius-lg);
    margin-bottom: 28px;
}
.search-page-title {
    font-family: var(--font-display);
    font-size: 2rem;
    display: flex;
    align-items: center;
    gap: 12px;
}
.search-page-meta { margin-top: 8px; opacity: 0.9; }
.search-results-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
}
@media (max-width: 1024px) {
    .search-results-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 768px) {
    .search-results-grid { grid-template-columns: repeat(2, 1fr); }
    .search-page-title { font-size: 1.4rem; }
}
@media (max-width: 480px) {
    .search-results-grid { grid-template-columns: 1fr; }
}
</style>
@endpush
