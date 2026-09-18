<footer class="hp-footer hk-footer">
    <div class="hp-footer__main">
        <div>
            <a class="hp-brand hp-footer__brand" href="{{ route('home') }}">
                <span class="hp-brand-mark"><span class="material-symbols-outlined" aria-hidden="true">health_and_safety</span></span>
                <span>HealthPass<span class="hp-brand-dot">.</span></span>
            </a>
            <p>La gestion des dossiers patients, consultations, prescriptions et analyses dans un environnement réservé aux établissements et professionnels autorisés.</p>
        </div>
        <div><p class="hp-footer__title">Plateforme</p><a href="{{ url('/#parcours') }}">Parcours de soins</a><a href="{{ url('/#a-propos') }}">À propos</a><a href="{{ route('login') }}">Connexion</a></div>
        <div><p class="hp-footer__title">Nous contacter</p><a href="tel:+2290156036800">+229 01 56 03 68 00</a><a href="mailto:healthpass19@gmail.com">healthpass19@gmail.com</a><span>Cotonou, Bénin</span></div>
    </div>
    <div class="hp-footer__bottom"><span>© {{ date('Y') }} HealthPass</span><span><span class="material-symbols-outlined" aria-hidden="true">lock</span>Accès aux données strictement contrôlé</span></div>
</footer>
