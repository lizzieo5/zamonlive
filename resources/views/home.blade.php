@extends('layouts.app')

@section('title', 'ZamonLive - Bosh sahifa')

@section('content')

<div class="home-wrapper">
    <div class="container-fluid home-container">
        <div class="home-grid">

            {{-- LEFT EMPTY COLUMN --}}
            <aside class="col-side col-side-left"></aside>

            {{-- MAIN 4 COLUMNS AREA --}}
            <div class="col-main">

                {{-- ============================================================
                     SECTION 1: LATEST NEWS (3 cols) + WEATHER/CURRENCY (1 col)
                     ============================================================ --}}
                <div class="top-section">

                    {{-- Latest News Block: 3 columns wide --}}
                    <div class="latest-news-block">
                        <div class="section-header">
                            <span class="section-badge">
                                <i class="fas fa-bolt"></i> So'nggi Yangiliklar
                            </span>
                        </div>

                        <div class="latest-grid">

                            {{-- BIG NEWS CARD --}}
                            @if(isset($latestNews[0]))
                            <article class="news-card news-card--big">
                                <a href="{{ route('news.show', $latestNews[0]->slug) }}" class="news-card__img-wrap">
                                    <img src="{{ $latestNews[0]->thumbnail ? asset('storage/'.$latestNews[0]->thumbnail) : asset('images/placeholder.jpg') }}"
                                         alt="{{ $latestNews[0]->title }}"
                                         loading="lazy">
                                    <div class="news-card__overlay"></div>
                                    <div class="news-card__meta-over">
                                        <span class="news-cat-badge" style="background: {{ $latestNews[0]->category->color ?? 'var(--green-mid)' }}">
                                            {{ $latestNews[0]->category->name ?? 'Yangilik' }}
                                        </span>
                                        <h2 class="news-card__title-over">
                                            <a href="{{ route('news.show', $latestNews[0]->slug) }}">{{ $latestNews[0]->title }}</a>
                                        </h2>
                                        <div class="news-card__time-over">
                                            <i class="fas fa-clock"></i>
                                            {{ $latestNews[0]->created_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            </article>
                            @else
                            {{-- Placeholder --}}
                            <article class="news-card news-card--big">
                                <div class="news-card__img-wrap placeholder-wrap">
                                    <div class="news-card__overlay"></div>
                                    <div class="news-card__meta-over">
                                        <span class="news-cat-badge">Asosiy</span>
                                        <h2 class="news-card__title-over">Yangilik sarlavhasi bu yerda ko'rinadi</h2>
                                        <div class="news-card__time-over"><i class="fas fa-clock"></i> 5 daqiqa oldin</div>
                                    </div>
                                </div>
                            </article>
                            @endif

                            {{-- TWO SMALL NEWS CARDS --}}
                            <div class="small-news-stack">
                                @foreach([$latestNews[1] ?? null, $latestNews[2] ?? null] as $i => $news)
                                <article class="news-card news-card--small">
                                    <a href="{{ $news ? route('news.show', $news->slug) : '#' }}" class="news-card-small__img-wrap">
                                        <img src="{{ $news && $news->thumbnail ? asset('storage/'.$news->thumbnail) : asset('images/placeholder.jpg') }}"
                                             alt="{{ $news->title ?? 'Yangilik' }}" loading="lazy">
                                        <span class="news-cat-badge-sm">{{ $news->category->name ?? 'Kategoriya' }}</span>
                                    </a>
                                    <div class="news-card-small__body">
                                        <h3 class="news-card-small__title">
                                            <a href="{{ $news ? route('news.show', $news->slug) : '#' }}">
                                                {{ $news->title ?? 'Yangilik sarlavhasi' }}
                                            </a>
                                        </h3>
                                        <div class="news-card-small__meta">
                                            <span><i class="fas fa-clock"></i> {{ $news ? $news->created_at->diffForHumans() : '10 daqiqa oldin' }}</span>
                                        </div>
                                    </div>
                                </article>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- WEATHER + CURRENCY COLUMN --}}
                    <aside class="widget-column">

                        {{-- WEATHER WIDGET --}}
                        <div class="widget weather-widget">
                            <div class="widget__header">
                                <i class="fas fa-cloud-sun"></i>
                                <span>Ob-havo — Andijon</span>
                            </div>
                            <div class="weather-body" id="weatherWidget">
                                <div class="weather-main">
                                    <div class="weather-icon-big">
                                        <i class="fas fa-sun" id="weatherIcon"></i>
                                    </div>
                                    <div class="weather-temp-wrap">
                                        <span class="weather-temp" id="weatherTemp">--°</span>
                                        <span class="weather-desc" id="weatherDesc">Yuklanmoqda...</span>
                                    </div>
                                </div>
                                <div class="weather-details">
                                    <div class="weather-detail-item">
                                        <i class="fas fa-tint"></i>
                                        <span>Namlik</span>
                                        <strong id="weatherHumidity">--%</strong>
                                    </div>
                                    <div class="weather-detail-item">
                                        <i class="fas fa-wind"></i>
                                        <span>Shamol</span>
                                        <strong id="weatherWind">-- m/s</strong>
                                    </div>
                                    <div class="weather-detail-item">
                                        <i class="fas fa-gauge"></i>
                                        <span>Bosim</span>
                                        <strong id="weatherPressure">-- hPa</strong>
                                    </div>
                                    <div class="weather-detail-item">
                                        <i class="fas fa-eye"></i>
                                        <span>Ko'rinish</span>
                                        <strong id="weatherVisibility">-- km</strong>
                                    </div>
                                    <div class="weather-detail-item">
                                        <i class="fas fa-thermometer-half"></i>
                                        <span>His etiladigan</span>
                                        <strong id="weatherFeelsLike">--°</strong>
                                    </div>
                                    <div class="weather-detail-item">
                                        <i class="fas fa-smog"></i>
                                        <span>Havo sifati</span>
                                        <strong id="weatherAQI">--</strong>
                                    </div>
                                </div>
                                <div class="weather-forecast" id="weatherForecast">
                                    {{-- JS tomonidan to'ldiriladi --}}
                                </div>
                            </div>
                        </div>

                        {{-- CURRENCY WIDGET --}}
                        <div class="widget currency-widget">
                            <div class="widget__header">
                                <i class="fas fa-coins"></i>
                                <span>Valyuta Kursi</span>
                            </div>
                            <div class="currency-body" id="currencyWidget">
                                <div class="currency-item">
                                    <div class="currency-flag">🇺🇸</div>
                                    <div class="currency-info">
                                        <span class="currency-code">USD</span>
                                        <span class="currency-name">Dollar</span>
                                    </div>
                                    <div class="currency-rate" id="usdRate">
                                        <span class="rate-value">--</span>
                                        <span class="rate-change" id="usdChange"></span>
                                    </div>
                                </div>
                                <div class="currency-item">
                                    <div class="currency-flag">🇪🇺</div>
                                    <div class="currency-info">
                                        <span class="currency-code">EUR</span>
                                        <span class="currency-name">Yevro</span>
                                    </div>
                                    <div class="currency-rate" id="eurRate">
                                        <span class="rate-value">--</span>
                                        <span class="rate-change" id="eurChange"></span>
                                    </div>
                                </div>
                                <div class="currency-item">
                                    <div class="currency-flag">🇷🇺</div>
                                    <div class="currency-info">
                                        <span class="currency-code">RUB</span>
                                        <span class="currency-name">Rubl</span>
                                    </div>
                                    <div class="currency-rate" id="rubRate">
                                        <span class="rate-value">--</span>
                                        <span class="rate-change" id="rubChange"></span>
                                    </div>
                                </div>
                                <div class="currency-item">
                                    <div class="currency-flag">🇬🇧</div>
                                    <div class="currency-info">
                                        <span class="currency-code">GBP</span>
                                        <span class="currency-name">Funt</span>
                                    </div>
                                    <div class="currency-rate" id="gbpRate">
                                        <span class="rate-value">--</span>
                                        <span class="rate-change" id="gbpChange"></span>
                                    </div>
                                </div>
                                <div class="currency-item">
                                    <div class="currency-flag">🇨🇳</div>
                                    <div class="currency-info">
                                        <span class="currency-code">CNY</span>
                                        <span class="currency-name">Yuan</span>
                                    </div>
                                    <div class="currency-rate" id="cnyRate">
                                        <span class="rate-value">--</span>
                                        <span class="rate-change" id="cnyChange"></span>
                                    </div>
                                </div>
                                <p class="currency-source">Manba: CBU</p>
                            </div>
                        </div>

                    </aside>
                </div>

                {{-- ============================================================
                     SECTION 2: CATEGORY NEWS (3 cols) + NEWSPAPER (1 col)
                     ============================================================ --}}
                <div class="mid-section">

                    {{-- Category News: 3 cols --}}
                    <div class="category-news-block">
                        <div class="section-header">
                            @if(isset($featuredCategory))
                            <span class="section-badge" style="background: {{ $featuredCategory->color ?? 'var(--green-mid)' }}">
                                <i class="fas fa-layer-group"></i> {{ $featuredCategory->name }}
                            </span>
                            @else
                            <span class="section-badge">
                                <i class="fas fa-layer-group"></i> Tanlangan Yangiliklar
                            </span>
                            @endif
                        </div>

                        <div class="category-news-grid">
                            @forelse($featuredCategoryNews ?? [] as $cn)
                            <article class="cat-news-card">
                                <a href="{{ route('news.show', $cn->slug) }}" class="cat-news-card__img">
                                    <img src="{{ $cn->thumbnail ? asset('storage/'.$cn->thumbnail) : asset('images/placeholder.jpg') }}"
                                         alt="{{ $cn->title }}" loading="lazy">
                                </a>
                                <div class="cat-news-card__body">
                                    <span class="cat-badge">
                                        {{ $cn->category->name ?? 'Kategoriya' }}
                                    </span>
                                    <div class="cat-news-card__meta">
                                        <span><i class="fas fa-calendar"></i> {{ $cn->created_at->format('d.m.Y') }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $cn->created_at->format('H:i') }}</span>
                                    </div>
                                    <h3 class="cat-news-card__title">
                                        <a href="{{ route('news.show', $cn->slug) }}">{{ $cn->title }}</a>
                                    </h3>
                                    <p class="cat-news-card__excerpt">
                                        {{ Str::limit(strip_tags($cn->body), 90) }}
                                    </p>
                                </div>
                            </article>
                            @empty
                            @for($p = 0; $p < 8; $p++)
                            <article class="cat-news-card cat-news-card--placeholder">
                                <div class="cat-news-card__img placeholder-img"></div>
                                <div class="cat-news-card__body">
                                    <span class="cat-badge">Kategoriya</span>
                                    <div class="cat-news-card__meta">
                                        <span><i class="fas fa-calendar"></i> 01.01.2025</span>
                                    </div>
                                    <h3 class="cat-news-card__title">Yangilik sarlavhasi</h3>
                                    <p class="cat-news-card__excerpt">Yangilik qisqacha mazmuni bu yerda ko'rinadi...</p>
                                </div>
                            </article>
                            @endfor
                            @endforelse
                        </div>
                    </div>

                    {{-- NEWSPAPER COLUMN --}}
                    <aside class="newspaper-column">
                        <div class="widget newspaper-widget">
                            <div class="widget__header">
                                <i class="fas fa-newspaper"></i>
                                <span>So'nggi Gazeta</span>
                            </div>
                            @if(isset($latestNewspaper))
                            <div class="newspaper-body">
                                <div class="newspaper-img-wrap placeholder-img">
                                    <div class="newspaper-date-badge">
                                        {{ $latestNewspaper->created_at ? $latestNewspaper->created_at->format('d.m.Y') : date('d.m.Y') }}
                                    </div>
                                </div>
                                <div class="newspaper-info">
                                    <h4>{{ $latestNewspaper->title ?? 'ZamonLive Gazetasi' }}</h4>
                                    <p>PDF nashr</p>
                                </div>
                                <div class="newspaper-actions">
                                    <a href="{{ route('subscribe') }}" class="newspaper-btn newspaper-btn--subscribe">
                                        <i class="fas fa-bell"></i>
                                        Obuna bo'lish
                                    </a>
                                    @if($latestNewspaper->file)
                                    <a href="{{ asset('storage/'.$latestNewspaper->file) }}"
                                       download class="newspaper-btn newspaper-btn--pdf">
                                        <i class="fas fa-file-pdf"></i>
                                        PDF yuklab olish
                                    </a>
                                    @else
                                    <button class="newspaper-btn newspaper-btn--pdf" disabled>
                                        <i class="fas fa-file-pdf"></i>
                                        PDF yuklab olish
                                    </button>
                                    @endif
                                </div>
                                @if(isset($latestNewspapers) && $latestNewspapers->count() > 1)
                                <div class="newspaper-archive">
                                    <div class="newspaper-archive__header">
                                        <span>So'nggi PDF'lar</span>
                                    </div>
                                    <div class="newspaper-archive__list">
                                        @foreach($latestNewspapers->skip(1) as $newspaper)
                                        <a href="{{ $newspaper->file ? asset('storage/'.$newspaper->file) : '#' }}"
                                           class="newspaper-archive__item"
                                           @if($newspaper->file) download @endif>
                                            <span class="newspaper-archive__title">{{ $newspaper->title }}</span>
                                            <span class="newspaper-archive__date">
                                                {{ $newspaper->created_at ? $newspaper->created_at->format('d.m.Y') : date('d.m.Y') }}
                                            </span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="newspaper-body">
                                <div class="newspaper-img-wrap placeholder-img">
                                    <div class="newspaper-date-badge">{{ date('d.m.Y') }}</div>
                                </div>
                                <div class="newspaper-info">
                                    <h4>ZamonLive Gazetasi</h4>
                                    <p>PDF nashr</p>
                                </div>
                                <div class="newspaper-actions">
                                    <a href="{{ route('subscribe') }}" class="newspaper-btn newspaper-btn--subscribe">
                                        <i class="fas fa-bell"></i>
                                        Obuna bo'lish
                                    </a>
                                    <button class="newspaper-btn newspaper-btn--pdf">
                                        <i class="fas fa-file-pdf"></i>
                                        PDF yuklab olish
                                    </button>
                                </div>
                                @if(isset($latestNewspapers) && $latestNewspapers->count() > 1)
                                <div class="newspaper-archive">
                                    <div class="newspaper-archive__header">
                                        <span>So'nggi PDF'lar</span>
                                    </div>
                                    <div class="newspaper-archive__list">
                                        @foreach($latestNewspapers->skip(1) as $newspaper)
                                        <a href="{{ $newspaper->file ? asset('storage/'.$newspaper->file) : '#' }}"
                                           class="newspaper-archive__item"
                                           @if($newspaper->file) download @endif>
                                            <span class="newspaper-archive__title">{{ $newspaper->title }}</span>
                                            <span class="newspaper-archive__date">
                                                {{ $newspaper->created_at ? $newspaper->created_at->format('d.m.Y') : date('d.m.Y') }}
                                            </span>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </aside>
                </div>

                {{-- ============================================================
                     SECTION 3: ALL CATEGORIES NEWS — 8 news each, 4-col grid
                     ============================================================ --}}
                <div class="all-categories-section">

                    @php
                        $cats = $allCategoryNews ?? [];
                    @endphp

                    @forelse($cats as $catData)
                    <section class="cat-section">
                        <div class="cat-section__header">
                            <h2 class="cat-section__title">
                                <a href="{{ route('category', $catData['category']->slug ?? '#') }}">
                                    {{ $catData['category']->name ?? 'Kategoriya' }}
                                </a>
                            </h2>
                            <a href="{{ route('category', $catData['category']->slug ?? '#') }}" class="cat-section__more">
                                Ko'proq <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>

                        <div class="cat-section__grid">
                            @foreach($catData['news'] ?? [] as $n)
                            <article class="grid-news-card">
                                <a href="{{ route('news.show', $n->slug) }}" class="grid-news-card__img">
                                    <img src="{{ $n->thumbnail ? asset('storage/'.$n->thumbnail) : asset('images/placeholder.jpg') }}"
                                         alt="{{ $n->title }}" loading="lazy">
                                    <span class="grid-news-card__cat-badge">{{ $n->category->name ?? '' }}</span>
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
                                        {{ Str::limit(strip_tags($n->body), 80) }}
                                    </p>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </section>
                    @empty

                    {{-- Static placeholder sections --}}
                    @foreach(['Dunyo', 'Sport', 'Jamiyat', 'Madaniyat', 'Jinoyat', 'Salomatlik', 'Hi-Tech', 'Bu Qiziq'] as $staticCat)
                    <section class="cat-section">
                        <div class="cat-section__header">
                            <h2 class="cat-section__title">
                                <a href="#">{{ $staticCat }}</a>
                            </h2>
                            <a href="#" class="cat-section__more">Ko'proq <i class="fas fa-arrow-right"></i></a>
                        </div>
                        <div class="cat-section__grid">
                            @for($k = 0; $k < 8; $k++)
                            <article class="grid-news-card">
                                <div class="grid-news-card__img placeholder-img"></div>
                                <div class="grid-news-card__body">
                                    <div class="grid-news-card__meta">
                                        <span><i class="fas fa-calendar-alt"></i> 01.01.2025</span>
                                        <span><i class="fas fa-clock"></i> 12:00</span>
                                    </div>
                                    <h3 class="grid-news-card__title"><a href="#">Yangilik sarlavhasi</a></h3>
                                    <p class="grid-news-card__excerpt">Yangilik qisqacha mazmuni bu yerda ko'rinadi...</p>
                                </div>
                            </article>
                            @endfor
                        </div>
                    </section>
                    @endforeach

                    @endforelse

                </div>

            </div>{{-- end .col-main --}}

            {{-- RIGHT EMPTY COLUMN --}}
            <aside class="col-side col-side-right"></aside>

        </div>{{-- end .home-grid --}}
    </div>{{-- end .home-container --}}
</div>{{-- end .home-wrapper --}}

@endsection

@push('scripts')
<script>
// Weather & Currency are loaded from zamonlive.js
document.addEventListener('DOMContentLoaded', function() {
    if (typeof ZamonLive !== 'undefined') {
        ZamonLive.loadWeather();
        ZamonLive.loadCurrency();
    }
});
</script>
@endpush
