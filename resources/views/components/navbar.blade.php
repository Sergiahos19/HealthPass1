<nav class="sticky top-0 w-full z-50 flex justify-between items-center gap-3 px-marge-page py-unite-base bg-surface-container-lowest border-b border-outline-variant shadow-sm min-h-16">
    <div class="flex items-center gap-inter-bloc">
        <a class="flex items-center gap-2 active:scale-95 duration-150" href="{{ url('/') }}">
            <span class="material-symbols-outlined icon-fill text-primary text-[28px]"></span>
            <span class="font-bold text-xl text-primary">HealthPass</span>
        </a>
    </div>
    <div class="hidden lg:flex items-center gap-inter-bloc">
        <a class="text-base text-on-surface-variant hover:text-primary transition-colors active:scale-95 duration-150" href="#">À propos</a>
        <a class="text-base text-on-surface-variant hover:text-primary transition-colors active:scale-95 duration-150" href="#">Contact</a>
    </div>
    <div class="flex items-center gap-inter-element">
        <a class="hidden sm:block font-semibold text-sm text-on-surface-variant px-4 py-2 hover:bg-surface-container-low rounded-lg transition-colors active:scale-95 duration-150" href="{{ route('login') }}">Connexion</a>
        <a class="font-semibold text-sm bg-primary text-on-primary px-4 sm:px-5 py-2 rounded-lg hover:bg-surface-tint shadow-sm transition-colors active:scale-95 duration-150" href="{{ route('register') }}">Inscription</a>
    </div>
</nav>