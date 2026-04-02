@extends('layouts.app')

@section('title', ($currentCategory->name ?? 'Kategoriya') . ' — ZamonLive')

@section('content')

<div class="category-page-wrapper">
    <div class="category-page-container">

        {{-- Category Header --}}
        <div class="category-page-header">
            <div class="category-page-title-wrap">
                <span class="cat-page-icon">
                    @switch($currentCategory->slug ?? '')
                        @case('sport') <i class="fas fa-futbol"></i> @break
                        @case('dunyo') <i class="fas fa-globe"></i> @break
                        @case('jahon') <i class="fas fa-earth-americas"></i> @break
                        @case('jamiyat') <i class="fas fa-users"></i> @break
                        @case('madaniyat') <i class="fas fa-masks-theater"></i> @break
                        @case('jinoyat') <i class="fas fa-scale-balanced"></i> @break
                        @case('salomatlik') <i class="fas fa-heart-pulse"></i> @break
                        @case('hi-tech') <i class="fas fa-microchip"></i> @break
                        @case('bu-qiziq') <i class="fas fa-lightbulb"></i> @break
                        @case('savol-javob') <i class="fas fa-circle-question"></i> @break
                        @default <i class="fas fa-newspaper"></i>
                    @endswitch
                </span>
                <h1 class="category-page-title">{{ $currentCategory->name ?? 'Kategoriya' }}</h1>
            </div>
            <p class="category-page-desc">
                {{ $currentCategory->description ?? $currentCategory->name . ' bo\'yicha eng so\'nggi yangiliklar' }}
            </p>
        </div>

        {{-- News Grid --}}
        <div class="cat-page-grid">
            @forelse($news as $n)
            <article class="grid-news-card">
                <a href="{{ route('news.show', $n->slug) }}" class="grid-news-card__img">
                    <img src="{{ $n->thumbnail ? asset('storage/'.$n->thumbnail) : asset('images/placeholder.jpg') }}"
                         alt="{{ $n->title }}" loading="lazy">
                    <span class="grid-news-card__cat-badge">{{ $n->category->name }}</span>
                </a>
                <div class="grid-news-card__body">
                    <div class="grid-news-card__meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ $n->created_at->format('d.m.Y') }}</span>
                        <span><i class="fas fa-clock"></i> {{ $n->created_at->format('H:i') }}</span>
                    </div>
                    <h3 class="grid-news-card__title">
                        <a href="{{ route('news.show', $n->slug) }}">{{ $n->title }}</a>
                    </h3>
                    <p class="grid-news-card__excerpt">
                        {{ Str::limit(strip_tags($n->body), 90) }}
                    </p>
                </div>
            </article>
            @empty
            <div class="empty-state" style="grid-column: 1/-1; text-align: center; padding: 60px 20px;">
                <i class="fas fa-newspaper" style="font-size: 3rem; color: var(--gray-400); display: block; margin-bottom: 16px;"></i>
                <p style="color: var(--gray-600);">Hozircha yangiliklar mavjud emas</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($news) && $news->hasPages())
        <div class="pagination-wrap">
            {{ $news->links('partials.pagination') }}
        </div>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
.category-page-wrapper { padding: 24px 0 50px; }
.category-page-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

.category-page-header {
    background: linear-gradient(135deg, var(--green-dark), var(--green-mid-dark));
    color: white;
    padding: 30px;
    border-radius: var(--radius-lg);
    margin-bottom: 28px;
}

.category-page-title-wrap { display: flex; align-items: center; gap: 14px; margin-bottom: 8px; }

.cat-page-icon {
    width: 50px; height: 50px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.4rem;
}

.category-page-title { font-family: var(--font-display); font-size: 2rem; font-weight: 700; }

.category-page-desc { font-size: 0.88rem; opacity: 0.8; margin-top: 4px; }

.cat-page-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.pagination-wrap { margin-top: 32px; display: flex; justify-content: center; }

@media (max-width: 1024px) { .cat-page-grid { grid-template-columns: repeat(3, 1fr); } }
@media (max-width: 768px)  { .cat-page-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 480px)  { .cat-page-grid { grid-template-columns: 1fr; } }
</style>
@endpush