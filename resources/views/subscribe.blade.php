@extends('layouts.app')

@section('title', 'Obuna — ZamonLive')

@section('content')

<div class="subscribe-wrapper">
    <div class="subscribe-container">

        <div class="subscribe-hero">
            <div class="subscribe-hero__icon">
                <i class="fas fa-bell"></i>
            </div>
            <h1 class="subscribe-hero__title">ZamonLive'ga Obuna Bo'ling</h1>
            <p class="subscribe-hero__desc">
                Eng so'nggi yangiliklar, tahlillar va reportajlar to'g'ridan-to'g'ri
                emailingiz yoki telefoningizga kelsin.
            </p>
        </div>

        <div class="subscribe-options">

            {{-- Email subscription --}}
            <div class="subscribe-card">
                <div class="subscribe-card__icon" style="background: var(--green-light);">
                    <i class="fas fa-envelope" style="color: var(--green-mid-dark);"></i>
                </div>
                <h3>Email Obuna</h3>
                <p>Kunlik yangiliklar xulasasini emailingizga oling</p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST" class="subscribe-form">
                    @csrf
                    <input type="text" name="name" placeholder="Ismingiz" required>
                    <input type="email" name="email" placeholder="Email manzilingiz" required>
                    <button type="submit" class="subscribe-form-btn">
                        <i class="fas fa-paper-plane"></i> Obuna bo'lish
                    </button>
                </form>
            </div>

            {{-- Telegram --}}
            <div class="subscribe-card">
                <div class="subscribe-card__icon" style="background: #e3f2fd;">
                    <i class="fab fa-telegram-plane" style="color: #0088cc;"></i>
                </div>
                <h3>Telegram Kanal</h3>
                <p>Telegram kanalimizga qo'shiling, yangiliklar darhol keladi</p>
                <a href="{{ config('zamonlive.social.telegram', '#') }}" target="_blank" class="subscribe-form-btn" style="background: #0088cc; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; color: white; padding: 12px; border-radius: var(--radius-sm); font-weight: 600; margin-top: 12px;">
                    <i class="fab fa-telegram-plane"></i> Telegram kanalga o'tish
                </a>
            </div>

            {{-- Newspaper PDF --}}
            <div class="subscribe-card">
                <div class="subscribe-card__icon" style="background: #fff3e0;">
                    <i class="fas fa-newspaper" style="color: #e65100;"></i>
                </div>
                <h3>Gazeta Obunasi</h3>
                <p>Haftalik gazeta PDF shaklida emailingizga keladi</p>
                <form action="{{ route('newspaper.subscribe') }}" method="POST" class="subscribe-form">
                    @csrf
                    <input type="text" name="name" placeholder="Ismingiz" required>
                    <input type="email" name="email" placeholder="Email manzilingiz" required>
                    <button type="submit" class="subscribe-form-btn" style="background: #e65100;">
                        <i class="fas fa-file-pdf"></i> Gazeta obunasi
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.subscribe-wrapper { padding: 40px 0 60px; }
.subscribe-container { max-width: 960px; margin: 0 auto; padding: 0 20px; }

.subscribe-hero {
    text-align: center;
    margin-bottom: 40px;
}

.subscribe-hero__icon {
    width: 80px; height: 80px;
    background: var(--green-mid);
    color: white;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem;
    margin: 0 auto 20px;
    box-shadow: 0 8px 30px rgba(76,175,80,0.4);
    animation: bellRing 2s infinite;
}

@keyframes bellRing {
    0%, 100% { transform: rotate(0); }
    10%, 30%  { transform: rotate(15deg); }
    20%       { transform: rotate(-15deg); }
    40%       { transform: rotate(0); }
}

.subscribe-hero__title { font-family: var(--font-display); font-size: 2rem; color: var(--text-dark); margin-bottom: 12px; }
.subscribe-hero__desc  { font-size: 0.95rem; color: var(--gray-600); max-width: 500px; margin: 0 auto; line-height: 1.7; }

.subscribe-options { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }

.subscribe-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 28px;
    box-shadow: var(--shadow-sm);
    text-align: center;
    transition: var(--transition);
}

.subscribe-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
}

.subscribe-card__icon {
    width: 60px; height: 60px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    margin: 0 auto 16px;
}

.subscribe-card h3 { font-family: var(--font-display); font-size: 1.1rem; margin-bottom: 8px; }
.subscribe-card p  { font-size: 0.82rem; color: var(--gray-600); margin-bottom: 16px; line-height: 1.6; }

.subscribe-form { display: flex; flex-direction: column; gap: 10px; }
.subscribe-form input {
    border: 1px solid var(--gray-200);
    border-radius: var(--radius-sm);
    padding: 10px 14px;
    font-size: 0.85rem;
    font-family: var(--font-body);
    outline: none;
    transition: border-color 0.3s;
    width: 100%;
}
.subscribe-form input:focus { border-color: var(--green-mid); }

.subscribe-form-btn {
    background: var(--green-mid);
    color: white;
    border: none;
    border-radius: var(--radius-sm);
    padding: 12px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    font-family: var(--font-body);
    transition: var(--transition);
    display: flex; align-items: center; justify-content: center; gap: 8px;
}

.subscribe-form-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

@media (max-width: 768px) { .subscribe-options { grid-template-columns: 1fr; } }
</style>
@endpush