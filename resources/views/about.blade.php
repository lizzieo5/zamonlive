@extends('layouts.app')

@section('title', 'Biz haqimizda — ZamonLive')
@section('description', 'ZamonLive haqida: tahririyat qadriyatlari, yo‘nalishlar, jamoa va aloqa ma’lumotlari.')

@section('content')
<div class="about-page">
    <section class="about-hero">
        <span class="about-hero__badge">Biz haqimizda</span>
        <h1 class="about-hero__title">ZamonLive - tezkor, aniq va ishonchli yangiliklar maydoni</h1>
        <p class="about-hero__text">
            Bizning maqsadimiz - O‘zbekiston va dunyodagi muhim voqealarni sodda, tezkor va
            mas'uliyatli tarzda yetkazish. Har bir material aniqlik, muvozanat va o‘quvchi uchun
            foydalilik mezonlari bo‘yicha tahlil qilinadi.
        </p>

        <div class="about-hero__actions">
            <a href="{{ route('home') }}" class="about-primary-btn">
                <i class="fas fa-house"></i>
                Bosh sahifa
            </a>
            <a href="{{ route('subscribe') }}" class="about-secondary-btn">
                <i class="fas fa-bell"></i>
                Obuna bo‘lish
            </a>
        </div>
    </section>

    <section class="about-stats">
        <div class="about-stat">
            <strong>24/7</strong>
            <span>Yangiliklar kuzatuvi</span>
        </div>
        <div class="about-stat">
            <strong>4</strong>
            <span>Til varianti</span>
        </div>
        <div class="about-stat">
            <strong>8+</strong>
            <span>Mavzuli bo‘limlar</span>
        </div>
        <div class="about-stat">
            <strong>PDF</strong>
            <span>Gazeta arxivi</span>
        </div>
    </section>

    <section class="about-grid">
        <article class="about-card about-card--large">
            <h2 class="about-card__title">Bizning vazifa</h2>
            <p>
                ZamonLive yangiliklar, tahlillar, reportajlar va foydali servis ma'lumotlarini bir joyda
                jamlaydi. Biz har kuni o‘quvchiga kerakli axborotni topish, tushunish va kuzatishni osonlashtirishga
                intilamiz.
            </p>
            <p>
                Kontent tahririy nazoratdan o‘tadi, manbalar tekshiriladi va mavzular bo‘yicha muvozanatli
                yondashuv saqlanadi.
            </p>
        </article>

        <aside class="about-card">
            <h2 class="about-card__title">Qadriyatlar</h2>
            <ul class="about-list">
                <li><i class="fas fa-check"></i> Tezkorlik va aniqlik</li>
                <li><i class="fas fa-check"></i> Ochiq va tushunarli til</li>
                <li><i class="fas fa-check"></i> Tahririy mas'uliyat</li>
                <li><i class="fas fa-check"></i> O‘quvchi manfaatini birinchi o‘ringa qo‘yish</li>
            </ul>
        </aside>
    </section>

    <section class="about-grid about-grid--split">
        <article class="about-card">
            <h2 class="about-card__title">Qaysi yo‘nalishlar bor?</h2>
            <div class="about-tags">
                <span>Asosiy</span>
                <span>Jahon</span>
                <span>Sport</span>
                <span>Jamiyat</span>
                <span>Madaniyat</span>
                <span>Salomatlik</span>
                <span>Hi-Tech</span>
                <span>Jinoyat</span>
            </div>
        </article>

        <article class="about-card">
            <h2 class="about-card__title">Aloqa</h2>
            <div class="about-contact">
                <p><i class="fas fa-envelope"></i> info@zamonlive.uz</p>
                <p><i class="fas fa-phone"></i> +998 XX XXX XX XX</p>
                <p><i class="fas fa-map-marker-alt"></i> Toshkent, O'zbekiston</p>
                <p><i class="fas fa-paper-plane"></i> Telegram orqali tezkor xabarlar</p>
            </div>
            <a href="{{ config('zamonlive.social.telegram', '#') }}" target="_blank" class="about-telegram">
                <i class="fab fa-telegram-plane"></i>
                Telegram kanalga o‘tish
            </a>
        </article>
    </section>
</div>
@endsection

@push('styles')
<style>
.about-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 28px 20px 60px;
    display: grid;
    gap: 18px;
}

.about-hero,
.about-card,
.about-stats {
    background: var(--white);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.about-hero {
    padding: 34px;
    background: linear-gradient(135deg, rgba(56,142,60,0.98), rgba(27,94,32,0.96));
    color: white;
}

.about-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    border-radius: 999px;
    background: rgba(255,255,255,0.14);
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.about-hero__title {
    font-family: var(--font-display);
    font-size: clamp(2rem, 4vw, 3.25rem);
    line-height: 1.1;
    margin: 16px 0 14px;
    max-width: 900px;
}

.about-hero__text {
    max-width: 820px;
    font-size: 0.98rem;
    line-height: 1.8;
    color: rgba(255,255,255,0.88);
}

.about-hero__actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 22px;
}

.about-primary-btn,
.about-secondary-btn,
.about-telegram {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    border-radius: 999px;
    font-weight: 700;
    transition: var(--transition);
}

.about-primary-btn {
    background: white;
    color: var(--green-dark);
    padding: 10px 18px;
}

.about-secondary-btn {
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    padding: 10px 18px;
    background: rgba(255,255,255,0.06);
}

.about-primary-btn:hover,
.about-secondary-btn:hover,
.about-telegram:hover {
    transform: translateY(-2px);
}

.about-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    padding: 18px;
}

.about-stat {
    padding: 18px;
    border-radius: var(--radius-md);
    background: linear-gradient(180deg, var(--green-light), #fff);
    border: 1px solid rgba(76,175,80,0.08);
}

.about-stat strong {
    display: block;
    font-family: var(--font-display);
    font-size: 1.8rem;
    color: var(--green-dark);
    line-height: 1;
}

.about-stat span {
    display: block;
    margin-top: 8px;
    font-size: 0.82rem;
    color: var(--gray-600);
}

.about-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 18px;
}

.about-grid--split {
    grid-template-columns: 1fr 1fr;
}

.about-card {
    padding: 26px;
}

.about-card--large {
    min-height: 100%;
}

.about-card__title {
    font-family: var(--font-display);
    font-size: 1.35rem;
    color: var(--text-dark);
    margin-bottom: 14px;
}

.about-card p {
    color: var(--text-mid);
    font-size: 0.92rem;
    line-height: 1.8;
}

.about-card p + p {
    margin-top: 12px;
}

.about-list {
    display: grid;
    gap: 10px;
}

.about-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: var(--text-mid);
    font-size: 0.92rem;
    line-height: 1.6;
}

.about-list i {
    color: var(--green-mid);
    margin-top: 3px;
}

.about-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.about-tags span {
    padding: 8px 12px;
    border-radius: 999px;
    background: var(--green-light);
    color: var(--green-dark);
    font-size: 0.8rem;
    font-weight: 700;
}

.about-contact {
    display: grid;
    gap: 10px;
    margin-bottom: 18px;
}

.about-contact p {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-mid);
    font-size: 0.9rem;
}

.about-contact i {
    color: var(--green-mid-dark);
    width: 16px;
    text-align: center;
}

.about-telegram {
    background: #0088cc;
    color: white;
    padding: 11px 18px;
    justify-content: center;
}

@media (max-width: 1024px) {
    .about-stats,
    .about-grid,
    .about-grid--split {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 768px) {
    .about-hero { padding: 26px; }
    .about-stats,
    .about-grid,
    .about-grid--split {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
