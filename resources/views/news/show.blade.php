@extends('layouts.app')

@section('title', $news->title . ' — ZamonLive')
@section('description', Str::limit(strip_tags($news->body), 160))

@section('content')

<div class="news-page-wrapper">
    <div class="news-page-container">

        {{-- Breadcrumb --}}
        <nav class="breadcrumb-nav">
            <a href="{{ route('home') }}"><i class="fas fa-home"></i> Bosh sahifa</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('category', $news->category->slug) }}">{{ $news->category->name }}</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ Str::limit($news->title, 50) }}</span>
        </nav>

        <div class="news-page-grid">

            {{-- ARTICLE --}}
            <article class="news-article">
                <header class="news-article__header">
                    <span class="news-cat-badge" style="background: {{ $news->category->color ?? 'var(--green-mid)' }}">
                        {{ $news->category->name }}
                    </span>
                    <h1 class="news-article__title">{{ $news->title }}</h1>
                    <div class="news-article__meta">
                        <span><i class="fas fa-calendar"></i> {{ $news->created_at->format('d.m.Y') }}</span>
                        <span><i class="fas fa-clock"></i> {{ $news->created_at->format('H:i') }}</span>
                        @if($news->author)
                        <span><i class="fas fa-user"></i> {{ $news->author->name }}</span>
                        @endif
                        <span><i class="fas fa-eye"></i> {{ number_format($news->views ?? 0) }}</span>
                    </div>
                    <div class="news-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="share-btn share-fb">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://t.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($news->title) }}" target="_blank" class="share-btn share-tg">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                        <button class="share-btn share-copy" onclick="copyLink()" title="Havolani nusxalash">
                            <i class="fas fa-link"></i>
                        </button>
                    </div>
                </header>

                @if($news->thumbnail)
                <div class="news-article__featured-img">
                    <img src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}">
                    @if($news->image_caption)
                    <p class="img-caption">{{ $news->image_caption }}</p>
                    @endif
                </div>
                @endif

                <div class="news-article__body">
                    {!! $news->body !!}
                </div>

                {{-- Tags --}}
                @if($news->tags && $news->tags->count())
                <div class="news-tags">
                    <i class="fas fa-tags"></i>
                    @foreach($news->tags as $tag)
                    <a href="{{ route('tag', $tag->slug) }}" class="tag-link">{{ $tag->name }}</a>
                    @endforeach
                </div>
                @endif
            </article>

            {{-- SIDEBAR --}}
            <aside class="news-sidebar">

                {{-- Popular news --}}
                <div class="widget">
                    <div class="widget__header">
                        <i class="fas fa-fire"></i>
                        <span>Ko'p o'qilganlar</span>
                    </div>
                    <div class="popular-list">
                        @forelse($popularNews ?? [] as $i => $pn)
                        <div class="popular-item">
                            <span class="popular-num">{{ str_pad($i+1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="popular-info">
                                <a href="{{ route('news.show', $pn->slug) }}" class="popular-title">{{ $pn->title }}</a>
                                <span class="popular-meta">{{ $pn->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @empty
                        <p style="padding:12px; color: var(--gray-600); font-size: 0.82rem;">Ma'lumot yo'q</p>
                        @endforelse
                    </div>
                </div>

                {{-- Subscribe --}}
                <div class="widget sidebar-subscribe">
                    <div class="widget__header">
                        <i class="fas fa-bell"></i>
                        <span>Obuna bo'ling</span>
                    </div>
                    <div style="padding: 14px;">
                        <p style="font-size: 0.8rem; color: var(--gray-600); margin-bottom: 12px;">Eng so'nggi yangiliklar emailingizga kelsin</p>
                        <a href="{{ route('subscribe') }}" class="subscribe-btn" style="display: flex; justify-content: center;">
                            <i class="fas fa-bell"></i> Obuna
                        </a>
                    </div>
                </div>

            </aside>
        </div>

        {{-- Related News --}}
        @if(isset($relatedNews) && $relatedNews->count())
        <section class="related-section">
            <div class="cat-section__header">
                <h2 class="cat-section__title">O'xshash yangiliklar</h2>
                <a href="{{ route('category', $news->category->slug) }}" class="cat-section__more">
                    Ko'proq <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="cat-section__grid">
                @foreach($relatedNews as $rn)
                <article class="grid-news-card">
                    <a href="{{ route('news.show', $rn->slug) }}" class="grid-news-card__img">
                        <img src="{{ $rn->thumbnail ? asset('storage/'.$rn->thumbnail) : asset('images/placeholder.jpg') }}"
                             alt="{{ $rn->title }}" loading="lazy">
                        <span class="grid-news-card__cat-badge">{{ $rn->category->name }}</span>
                    </a>
                    <div class="grid-news-card__body">
                        <div class="grid-news-card__meta">
                            <span><i class="fas fa-clock"></i> {{ $rn->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="grid-news-card__title">
                            <a href="{{ route('news.show', $rn->slug) }}">{{ $rn->title }}</a>
                        </h3>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
.news-page-wrapper { padding: 20px 0 40px; }
.news-page-container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

.breadcrumb-nav {
    display: flex; align-items: center; gap: 8px;
    font-size: 0.78rem; color: var(--gray-600); margin-bottom: 20px; flex-wrap: wrap;
}
.breadcrumb-nav a { color: var(--green-mid-dark); }
.breadcrumb-nav a:hover { text-decoration: underline; }
.breadcrumb-nav i { font-size: 0.65rem; color: var(--gray-400); }

.news-page-grid { display: grid; grid-template-columns: 1fr 280px; gap: 24px; margin-bottom: 40px; }

.news-article { background: var(--white); border-radius: var(--radius-lg); padding: 30px; box-shadow: var(--shadow-sm); }

.news-article__header { margin-bottom: 20px; }
.news-article__title { font-family: var(--font-display); font-size: 1.9rem; line-height: 1.3; color: var(--text-dark); margin: 12px 0; }
.news-article__meta { display: flex; gap: 16px; flex-wrap: wrap; font-size: 0.78rem; color: var(--gray-600); margin-bottom: 14px; }
.news-article__meta span { display: flex; align-items: center; gap: 5px; }
.news-article__meta i { color: var(--green-mid); }

.news-share { display: flex; gap: 8px; }
.share-btn { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; color: white; border: none; cursor: pointer; transition: var(--transition); }
.share-fb { background: #1877f2; }
.share-tg { background: #0088cc; }
.share-copy { background: var(--gray-600); }
.share-btn:hover { transform: translateY(-2px); }

.news-article__featured-img { margin-bottom: 24px; border-radius: var(--radius-md); overflow: hidden; }
.news-article__featured-img img { width: 100%; max-height: 480px; object-fit: cover; }
.img-caption { font-size: 0.75rem; color: var(--gray-600); text-align: center; margin-top: 8px; font-style: italic; }

.news-article__body { font-family: var(--font-serif); font-size: 1rem; line-height: 1.85; color: var(--text-mid); }
.news-article__body p { margin-bottom: 1.2em; }
.news-article__body h2, .news-article__body h3 { font-family: var(--font-display); color: var(--green-dark); margin: 1.5em 0 0.5em; }
.news-article__body img { border-radius: var(--radius-sm); margin: 1em 0; }
.news-article__body blockquote { border-left: 4px solid var(--green-mid); padding: 12px 20px; background: var(--green-light); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; margin: 1.5em 0; color: var(--gray-800); font-style: italic; }

.news-tags { display: flex; flex-wrap: wrap; gap: 8px; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--gray-200); font-size: 0.78rem; color: var(--gray-600); }
.tag-link { background: var(--green-light); color: var(--green-dark); padding: 4px 12px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; transition: background 0.2s; }
.tag-link:hover { background: var(--green-light2); }

/* Sidebar */
.news-sidebar { display: flex; flex-direction: column; gap: 16px; }

.popular-list { padding: 10px 0; }
.popular-item { display: flex; gap: 12px; padding: 10px 14px; border-bottom: 1px solid var(--gray-100); }
.popular-item:last-child { border-bottom: none; }
.popular-num { font-family: var(--font-display); font-size: 1.4rem; font-weight: 700; color: var(--green-light2); min-width: 30px; line-height: 1; }
.popular-title { font-size: 0.82rem; font-weight: 600; line-height: 1.4; display: block; color: var(--text-dark); }
.popular-title:hover { color: var(--green-mid-dark); }
.popular-meta { font-size: 0.7rem; color: var(--gray-600); display: block; margin-top: 4px; }

.related-section { margin-top: 10px; }

@media (max-width: 768px) {
    .news-page-grid { grid-template-columns: 1fr; }
    .news-article__title { font-size: 1.4rem; }
}
</style>
@endpush

@push('scripts')
<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const btn = document.querySelector('.share-copy');
        btn.innerHTML = '<i class="fas fa-check"></i>';
        setTimeout(() => { btn.innerHTML = '<i class="fas fa-link"></i>'; }, 2000);
    });
}
</script>
@endpush