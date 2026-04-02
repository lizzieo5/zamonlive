<footer class="site-footer">

    {{-- Footer Top Wave --}}
    <div class="footer-wave">
        <svg viewBox="0 0 1440 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0,30 C360,60 1080,0 1440,30 L1440,0 L0,0 Z" fill="var(--bg-primary)"/>
        </svg>
    </div>

    <div class="footer-main">
        <div class="footer-container">

            {{-- Footer Top --}}
            <div class="footer-top">

                {{-- Brand Column --}}
                <div class="footer-col footer-brand">
                    <a href="{{ route('home') }}" class="footer-logo">
                        <span class="logo-zamon">Zamon</span><span class="logo-live">Live</span>
                    </a>
                    <p class="footer-about">
                        ZamonLive — O'zbekistonning eng tezkor va ishonchli yangiliklar portali.
                        Har kuni eng so'nggi xabarlar, tahlillar va reportajlar.
                    </p>
                    <div class="footer-social">
                        <a href="{{ config('zamonlive.social.facebook', '#') }}" target="_blank" class="footer-social-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="{{ config('zamonlive.social.instagram', '#') }}" target="_blank" class="footer-social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="{{ config('zamonlive.social.telegram', '#') }}" target="_blank" class="footer-social-link telegram">
                            <i class="fab fa-telegram-plane"></i>
                        </a>
                        <a href="{{ config('zamonlive.social.youtube', '#') }}" target="_blank" class="footer-social-link youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </div>
                </div>

                {{-- Categories Column --}}
                <div class="footer-col">
                    <h4 class="footer-heading">Kategoriyalar</h4>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-angle-right"></i> Asosiy</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Dunyo</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Jahon</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Sport</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Jamiyat</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Madaniyat</a></li>
                    </ul>
                </div>

                {{-- More Categories --}}
                <div class="footer-col">
                    <h4 class="footer-heading">Ko'proq</h4>
                    <ul class="footer-links">
                        <li><a href="#"><i class="fas fa-angle-right"></i> Jinoyat</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Bu Qiziq</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Salomatlik</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Savol-Javob</a></li>
                        <li><a href="#"><i class="fas fa-angle-right"></i> Hi-Tech</a></li>
                        <li><a href="{{ route('subscribe') }}"><i class="fas fa-angle-right"></i> Obuna</a></li>
                    </ul>
                </div>

                {{-- Contact & Newsletter --}}
                <div class="footer-col footer-newsletter">
                    <h4 class="footer-heading">Yangiliklar obunasi</h4>
                    <p>Eng so'nggi yangiliklar to'g'ridan-to'g'ri emailingizga kelsin.</p>
                    <form class="newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <div class="newsletter-input-wrap">
                            <input type="email" name="email" placeholder="Email manzilingiz..." required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                    <div class="footer-contact">
                        <p><i class="fas fa-envelope"></i> info@zamonlive.uz</p>
                        <p><i class="fas fa-phone"></i> +998 XX XXX XX XX</p>
                        <p><i class="fas fa-map-marker-alt"></i> Toshkent, O'zbekiston</p>
                    </div>
                </div>

            </div>

            {{-- Footer Bottom --}}
            <div class="footer-bottom">
                <div class="footer-bottom-left">
                    <p>&copy; {{ date('Y') }} <strong>ZamonLive</strong>. Barcha huquqlar himoyalangan.</p>
                </div>
                <div class="footer-bottom-right">
                    <a href="#">Maxfiylik siyosati</a>
                    <span>|</span>
                    <a href="#">Foydalanish shartlari</a>
                    <span>|</span>
                    <a href="#">Reklama</a>
                    <span>|</span>
                    <a href="#">Biz haqimizda</a>
                </div>
            </div>

        </div>
    </div>
</footer>