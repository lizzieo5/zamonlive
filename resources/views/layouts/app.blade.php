<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ZamonLive - Yangiliklar Portali')</title>
    <meta name="description" content="@yield('description', 'ZamonLive - O\'zbekistonning eng tezkor yangiliklar portali')">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Noto+Sans:wght@300;400;500;600;700&family=Noto+Serif:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('css/zamonlive.css') }}">

    @stack('styles')
</head>
<body>

{{-- TOP BAR --}}
<div class="topbar">
    <div class="topbar-inner">
        <div class="topbar-left">
            <span class="topbar-date">
                <i class="fas fa-calendar-alt"></i>
                <span id="current-date"></span>
            </span>
            <span class="topbar-divider">|</span>
            <span class="topbar-time">
                <i class="fas fa-clock"></i>
                <span id="current-time"></span>
            </span>
        </div>

        <div class="topbar-right">
            {{-- Social Icons --}}
            <div class="social-icons">
                <a href="{{ config('zamonlive.social.facebook', '#') }}" target="_blank" class="social-icon facebook" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="{{ config('zamonlive.social.instagram', '#') }}" target="_blank" class="social-icon instagram" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="{{ config('zamonlive.social.telegram', '#') }}" target="_blank" class="social-icon telegram" title="Telegram">
                    <i class="fab fa-telegram-plane"></i>
                </a>
                <a href="{{ config('zamonlive.social.youtube', '#') }}" target="_blank" class="social-icon youtube" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>

            {{-- Language Dropdown --}}
            <div class="lang-dropdown">
                <button class="lang-btn" id="langDropBtn">
                    <i class="fas fa-globe"></i>
                    <span id="currentLangLabel">
                        @php
                            $langs = ['uz' => "O'zbek", 'uz_cyrl' => 'Ўзбек', 'ru' => 'Русский', 'en' => 'English'];
                            echo $langs[app()->getLocale()] ?? "O'zbek";
                        @endphp
                    </span>
                    <i class="fas fa-chevron-down lang-arrow"></i>
                </button>
                <ul class="lang-menu" id="langMenu">
                    <li><a href="{{ route('lang.switch', 'uz') }}" class="{{ app()->getLocale() === 'uz' ? 'active' : '' }}">
                        <span class="lang-flag">🇺🇿</span> O'zbek (Lotin)
                    </a></li>
                    <li><a href="{{ route('lang.switch', 'uz_cyrl') }}" class="{{ app()->getLocale() === 'uz_cyrl' ? 'active' : '' }}">
                        <span class="lang-flag">🇺🇿</span> Ўзбек (Кирилл)
                    </a></li>
                    <li><a href="{{ route('lang.switch', 'ru') }}" class="{{ app()->getLocale() === 'ru' ? 'active' : '' }}">
                        <span class="lang-flag">🇷🇺</span> Русский
                    </a></li>
                    <li><a href="{{ route('lang.switch', 'en') }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">
                        <span class="lang-flag">🇬🇧</span> English
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- NAVBAR --}}
<header class="navbar-wrapper" id="mainNavbar">
    <div class="navbar-inner">
        {{-- Logo / Site Name --}}
        <div class="navbar-logo">
            <a href="{{ route('home') }}" class="logo-link">
                <span class="logo-text">
                    <span class="logo-zamon">Zamon</span><span class="logo-live">Live</span>
                </span>
                <span class="logo-tagline">Yangiliklar Portali</span>
            </a>
        </div>

        {{-- Search --}}
        <div class="navbar-search">
            <form action="{{ route('search') }}" method="GET" class="search-form">
                <input type="text" name="q" placeholder="Qidirish..." value="{{ request('q') }}" class="search-input">
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>

        {{-- Subscribe CTA --}}
        <div class="navbar-cta">
            <a href="{{ route('about') }}" class="about-btn">
                <i class="fas fa-circle-info"></i>
                <span>Biz haqimizda</span>
            </a>
            <a href="{{ route('subscribe') }}" class="subscribe-btn">
                <i class="fas fa-bell"></i>
                <span>Obuna</span>
            </a>
        </div>

        {{-- Mobile toggle --}}
        <button class="mobile-toggle" id="mobileToggle" aria-label="Menyu">
            <span></span><span></span><span></span>
        </button>
    </div>

    {{-- Category Navigation --}}
    <nav class="category-nav" id="categoryNav">
        <div class="category-nav-inner">
            <ul class="cat-menu">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> Asosiy
                </a></li>
                @foreach($navCategories ?? [] as $cat)
                <li><a href="{{ route('category', $cat->slug) }}"
                       class="{{ (isset($currentCategory) && $currentCategory->id === $cat->id) ? 'active' : '' }}">
                    {{ $cat->name }}
                </a></li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>

{{-- BREAKING NEWS TICKER --}}
@if(isset($breakingNews) && $breakingNews->count())
<div class="breaking-bar">
    <div class="breaking-label">
        <i class="fas fa-bolt"></i>
        <span>Tezkor</span>
    </div>
    <div class="breaking-ticker-wrap">
        <ul class="breaking-ticker" id="breakingTicker">
            @foreach($breakingNews as $bn)
            <li><a href="{{ route('news.show', $bn->slug) }}">{{ $bn->title }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
@endif

{{-- MAIN CONTENT --}}
<main class="main-content">
    @yield('content')
</main>

{{-- FOOTER --}}
@include('partials.footer')

{{-- Scripts --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])
@stack('scripts')

</body>
</html>
