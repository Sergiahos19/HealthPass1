<header class="hp-site-header hk-header" data-site-header>
    <div class="hk-topbar"><div class="hk-header-wide"><div class="hk-topbar-left"><a href="tel:+2290156036800"><span class="material-symbols-outlined">phone</span>+229 01 56 03 68 00</a><a href="mailto:healthpass19@gmail.com"><span class="material-symbols-outlined">mail</span>healthpass19@gmail.com</a><span><span class="material-symbols-outlined">location_on</span>Cotonou, Bénin</span></div><div class="hk-topbar-right"><span><span class="material-symbols-outlined">schedule</span>Assistance médicale · 7j/7</span></div></div></div>
    <nav class="hp-site-nav hk-main-nav" aria-label="Navigation principale">
        <a class="hp-brand" href="{{ route('home') }}" aria-label="HealthPass — Accueil">
            <span class="hp-brand-mark"><span class="material-symbols-outlined" aria-hidden="true">health_and_safety</span></span>
            <span>HealthPass<span class="hp-brand-dot">.</span></span>
        </a>
        <div class="hp-nav-links" id="mobile-menu" data-mobile-menu>
            <a href="{{ route('home') }}">Accueil</a>
            <a href="{{ url('/#a-propos') }}">À propos</a>
            <a href="{{ url('/#parcours') }}">Comment ça marche</a>
            <a href="{{ url('/#solutions') }}">Nos espaces</a>
            <a href="{{ url('/#contact') }}">Contact</a>
            @auth
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="hp-nav-cta" type="submit">Déconnexion <span class="material-symbols-outlined" aria-hidden="true">logout</span></button>
                </form>
            @else
                <a class="hp-nav-cta" href="{{ route('login') }}">Connexion <span class="material-symbols-outlined" aria-hidden="true">arrow_forward</span></a>
            @endauth
        </div>
        <button class="hp-menu-button" type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="Ouvrir le menu">
            <span class="material-symbols-outlined" aria-hidden="true">menu</span>
        </button>
    </nav>
</header>
