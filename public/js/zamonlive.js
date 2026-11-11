/**
 * ZamonLive.js — Main Frontend Script
 * Ob-havo, Valyuta, Navbar, Animations
 */

const ZamonLive = (function () {

    /* ---- DATE & TIME ---- */
    function initClock() {
        const dateEl = document.getElementById('current-date');
        const timeEl = document.getElementById('current-time');
        if (!dateEl && !timeEl) return;

        const uzDays   = ['Yakshanba','Dushanba','Seshanba','Chorshanba','Payshanba','Juma','Shanba'];
        const uzMonths = ['Yanvar','Fevral','Mart','Aprel','May','Iyun','Iyul','Avgust','Sentabr','Oktabr','Noyabr','Dekabr'];

        function update() {
            const now = new Date();
            if (dateEl) {
                dateEl.textContent = `${uzDays[now.getDay()]}, ${now.getDate()} ${uzMonths[now.getMonth()]} ${now.getFullYear()}`;
            }
            if (timeEl) {
                const h = String(now.getHours()).padStart(2,'0');
                const m = String(now.getMinutes()).padStart(2,'0');
                const s = String(now.getSeconds()).padStart(2,'0');
                timeEl.textContent = `${h}:${m}:${s}`;
            }
        }
        update();
        setInterval(update, 1000);
    }

    /* ---- LANGUAGE DROPDOWN ---- */
    function initLangDropdown() {
        const btn  = document.getElementById('langDropBtn');
        const wrap = btn ? btn.closest('.lang-dropdown') : null;
        if (!btn || !wrap) return;

        btn.addEventListener('click', () => wrap.classList.toggle('open'));

        document.addEventListener('click', (e) => {
            if (!wrap.contains(e.target)) wrap.classList.remove('open');
        });
    }

    /* ---- NAVBAR SCROLL ---- */
    function initNavbarScroll() {
        const navbar = document.getElementById('mainNavbar');
        if (!navbar) return;
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        }, { passive: true });
    }

    /* ---- MOBILE MENU ---- */
    function initMobileMenu() {
        const toggle = document.getElementById('mobileToggle');
        const nav    = document.getElementById('categoryNav');
        if (!toggle || !nav) return;

        toggle.addEventListener('click', () => {
            nav.classList.toggle('mobile-open');
            // Animate hamburger to X
            const spans = toggle.querySelectorAll('span');
            toggle.classList.toggle('open');
            if (toggle.classList.contains('open')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 6px)';
                spans[1].style.opacity   = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(5px, -6px)';
            } else {
                spans.forEach(s => { s.style.transform = ''; s.style.opacity = ''; });
            }
        });
    }

    /* ---- SCROLL ANIMATIONS ---- */
    function initScrollAnimations() {
        const items = document.querySelectorAll('.cat-news-card, .grid-news-card, .news-card--small, .cat-section');
        if (!items.length || !('IntersectionObserver' in window)) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, i) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-in');
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, i * 60);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.08 });

        items.forEach(item => {
            item.classList.add('animate-in');
            observer.observe(item);
        });
    }

    /* ---- WEATHER ---- */
    const WEATHER_CACHE_KEY = 'zamonlive_weather';
    const WEATHER_CACHE_DURATION = 30 * 60 * 1000; // 30 minutes

    async function loadWeather() {
        // Check cache first
        const cached = localStorage.getItem(WEATHER_CACHE_KEY);
        if (cached) {
            const { data, timestamp } = JSON.parse(cached);
            if (Date.now() - timestamp < WEATHER_CACHE_DURATION) {
                displayWeather(data);
                return;
            }
        }

        // Andijon koordinatlari: 40.7828, 72.3442
        const lat = 40.7828;
        const lon = 72.3442;
        // Open-Meteo: bepul, API key talab qilmaydi
        const url = `https://api.open-meteo.com/v1/forecast?latitude=${lat}&longitude=${lon}&current=temperature_2m,relative_humidity_2m,apparent_temperature,weather_code,wind_speed_10m,surface_pressure,visibility&daily=weather_code,temperature_2m_max,temperature_2m_min&timezone=Asia%2FTashkent&forecast_days=5`;

        try {
            // Add timeout to prevent slow loading
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout

            const res  = await fetch(url, { signal: controller.signal });
            clearTimeout(timeoutId);

            const data = await res.json();
            
            // Cache the data
            localStorage.setItem(WEATHER_CACHE_KEY, JSON.stringify({
                data,
                timestamp: Date.now()
            }));

            displayWeather(data);
        } catch (err) {
            console.warn('Weather load error:', err);
            const descEl = document.getElementById('weatherDesc');
            if (descEl) descEl.textContent = 'Ma\'lumot yuklanmadi';
        }
    }

    function displayWeather(data) {
        const cur = data.current;

        const tempEl    = document.getElementById('weatherTemp');
        const descEl    = document.getElementById('weatherDesc');
        const humEl     = document.getElementById('weatherHumidity');
        const windEl    = document.getElementById('weatherWind');
        const pressEl   = document.getElementById('weatherPressure');
        const visEl     = document.getElementById('weatherVisibility');
        const feelsEl   = document.getElementById('weatherFeelsLike');
        const aqiEl     = document.getElementById('weatherAQI');
        const iconEl    = document.getElementById('weatherIcon');
        const forecastEl= document.getElementById('weatherForecast');

        if (tempEl)   tempEl.textContent   = `${Math.round(cur.temperature_2m)}°C`;
        if (humEl)    humEl.textContent     = `${cur.relative_humidity_2m}%`;
        if (windEl)   windEl.textContent    = `${cur.wind_speed_10m} m/s`;
        if (pressEl)  pressEl.textContent   = `${Math.round(cur.surface_pressure)} hPa`;
        if (visEl)    visEl.textContent     = `${(cur.visibility/1000).toFixed(1)} km`;
        if (feelsEl)  feelsEl.textContent   = `${Math.round(cur.apparent_temperature)}°C`;
        if (aqiEl)    aqiEl.textContent     = getAQILabel(cur.surface_pressure);

        // Weather icon and description
        const { icon, desc } = getWeatherInfo(cur.weather_code);
        if (iconEl)  { iconEl.className = `fas ${icon}`; }
        if (descEl)  descEl.textContent = desc;

        // 5-day forecast
        if (forecastEl && data.daily) {
            const uzDays = ['Yak','Dush','Sesh','Chor','Pay','Jum','Shan'];
            forecastEl.innerHTML = '';
            for (let i = 0; i < 5; i++) {
                const d    = new Date(data.daily.time[i]);
                const { icon: fi } = getWeatherInfo(data.daily.weather_code[i]);
                const maxT = Math.round(data.daily.temperature_2m_max[i]);
                const minT = Math.round(data.daily.temperature_2m_min[i]);
                forecastEl.innerHTML += `
                    <div class="forecast-day">
                        <span class="fd-name">${uzDays[d.getDay()]}</span>
                        <i class="fas ${fi} fd-icon"></i>
                        <span class="fd-temp">${maxT}°/${minT}°</span>
                    </div>`;
            }
        }
    }

    function getWeatherInfo(code) {
        const map = {
            0:  { icon: 'fa-sun',         desc: 'Ochiq osmon' },
            1:  { icon: 'fa-sun',         desc: 'Asosan ochiq' },
            2:  { icon: 'fa-cloud-sun',   desc: 'Qisman bulutli' },
            3:  { icon: 'fa-cloud',       desc: 'Bulutli' },
            45: { icon: 'fa-smog',        desc: 'Tuman' },
            48: { icon: 'fa-smog',        desc: 'Muzli tuman' },
            51: { icon: 'fa-cloud-drizzle', desc: 'Mayda yomg\'ir' },
            61: { icon: 'fa-cloud-rain',  desc: 'Yomg\'ir' },
            63: { icon: 'fa-cloud-rain',  desc: 'Kuchli yomg\'ir' },
            71: { icon: 'fa-snowflake',   desc: 'Qor' },
            80: { icon: 'fa-cloud-showers-heavy', desc: 'Jala' },
            95: { icon: 'fa-bolt',        desc: 'Momaqaldiroq' },
        };
        for (const k of Object.keys(map).sort((a,b) => b-a)) {
            if (code >= parseInt(k)) return map[k];
        }
        return { icon: 'fa-cloud', desc: 'Noaniq' };
    }

    function getAQILabel(pressure) {
        if (pressure > 1020) return 'Yaxshi';
        if (pressure > 1010) return 'O\'rtacha';
        return 'Qoniqarli';
    }

    /* ---- CURRENCY (CBU API) ---- */
    const CURRENCY_CACHE_KEY = 'zamonlive_currency';
    const CURRENCY_CACHE_DURATION = 60 * 60 * 1000; // 60 minutes (currencies update daily)

    async function loadCurrency() {
        // Check cache first
        const cached = localStorage.getItem(CURRENCY_CACHE_KEY);
        if (cached) {
            const { data, timestamp } = JSON.parse(cached);
            if (Date.now() - timestamp < CURRENCY_CACHE_DURATION) {
                displayCurrency(data);
                return;
            }
        }

        try {
            // CBU Open API
            const today = new Date().toISOString().slice(0,10);
            const url   = `https://cbu.uz/uz/arkhiv-kursov-valyut/json/${today}/`;
            
            // Add timeout to prevent slow loading
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 8000); // 8 second timeout

            const res   = await fetch(url, { signal: controller.signal });
            clearTimeout(timeoutId);
            
            const data  = await res.json();

            // Cache data
            localStorage.setItem(CURRENCY_CACHE_KEY, JSON.stringify({
                data,
                timestamp: Date.now()
            }));

            displayCurrency(data);
        } catch (err) {
            console.warn('Currency load error:', err);
            // Try fallback URL without date
            try {
                const fallbackUrl = 'https://cbu.uz/uz/arkhiv-kursov-valyut/json/';
                const fallbackRes = await fetch(fallbackUrl);
                const fallbackData = await fallbackRes.json();
                
                localStorage.setItem(CURRENCY_CACHE_KEY, JSON.stringify({
                    data: fallbackData,
                    timestamp: Date.now()
                }));
                
                displayCurrency(fallbackData);
            } catch (fallbackErr) {
                console.warn('Currency fallback error:', fallbackErr);
            }
        }
    }

    function displayCurrency(data) {
        const codes = { USD: 'usdRate', EUR: 'eurRate', RUB: 'rubRate', GBP: 'gbpRate', CNY: 'cnyRate' };

        data.forEach(item => {
            const code = item.Ccy;
            if (codes[code]) {
                const el = document.getElementById(codes[code]);
                if (el) {
                    const rateVal = parseFloat(item.Rate).toLocaleString('uz-UZ', { maximumFractionDigits: 2 });
                    el.querySelector('.rate-value').textContent = rateVal + ' so\'m';
                    const diff = parseFloat(item.Diff);
                    const changeEl = el.querySelector('.rate-change');
                    if (changeEl && diff !== 0) {
                        changeEl.textContent = (diff > 0 ? '▲ +' : '▼ ') + Math.abs(diff).toFixed(2);
                        changeEl.className   = 'rate-change ' + (diff > 0 ? 'up' : 'down');
                    }
                }
            }
        });
    }

    /* ---- BREAKING NEWS TICKER CLONE ---- */
    function initTicker() {
        const ticker = document.getElementById('breakingTicker');
        if (!ticker) return;
        // Clone items for seamless loop
        const clone = ticker.cloneNode(true);
        ticker.parentNode.appendChild(clone);
    }

    /* ---- INIT ---- */
    function init() {
        initClock();
        initLangDropdown();
        initNavbarScroll();
        initMobileMenu();
        initScrollAnimations();
        initTicker();
        
        // Load external API data
        loadWeather();
        loadCurrency();
    }

    document.addEventListener('DOMContentLoaded', init);

    return { loadWeather, loadCurrency };

})();