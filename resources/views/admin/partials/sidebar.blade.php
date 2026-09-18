<nav class="hp-super-sidebar fixed left-0 top-0 h-screen flex flex-col p-inter-element docked w-64 bg-surface-container-low dark:bg-surface-dim flat no shadows z-40 hidden md:flex border-r border-outline-variant/30">
    <!-- Header / Brand -->
    <div class="flex items-center gap-3 px-4 py-4 mb-4">
        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-titre-sm">
            HP
        </div>
        <div>
            <h1 class="font-titre-sm text-titre-sm text-primary dark:text-primary-fixed leading-tight">Administration</h1>
            <p class="font-mention text-mention text-on-surface-variant">Administration</p>
        </div>
    </div>
    
    <!-- Navigation Links -->
    <ul class="flex flex-col gap-2 flex-grow">
        <li>
            <a class="flex items-center gap-3 bg-secondary-container text-on-secondary-container rounded-lg px-4 py-3 font-label-bold text-label-bold active:translate-x-1 duration-200" href="{{ route('admin.dashboard', ['section' => 'dashboard']) }}">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                Tableau de bord
            </a>
        </li>
        <li>
            <a class="flex items-center gap-3 text-on-surface-variant dark:text-outline px-4 py-3 font-label-bold text-label-bold hover:bg-surface-container-high dark:hover:bg-surface-container-highest transition-all rounded-lg active:translate-x-1 duration-200" href="{{ route('admin.dashboard', ['section' => 'audit']) }}">
                <span class="material-symbols-outlined">history_edu</span>
                Journal d'Audit
            </a>
        </li>
        <li>
            <a class="flex items-center gap-3 text-on-surface-variant dark:text-outline px-4 py-3 font-label-bold text-label-bold hover:bg-surface-container-high dark:hover:bg-surface-container-highest transition-all rounded-lg active:translate-x-1 duration-200" href="{{ route('admin.dashboard', ['section' => 'patients']) }}">
                <span class="material-symbols-outlined">group</span>
                Patients
            </a>
        </li>
        <li>
            <a class="flex items-center gap-3 text-on-surface-variant dark:text-outline px-4 py-3 font-label-bold text-label-bold hover:bg-surface-container-high dark:hover:bg-surface-container-highest transition-all rounded-lg active:translate-x-1 duration-200" href="{{ route('admin.dashboard', ['section' => 'utilisateurs']) }}">
                <span class="material-symbols-outlined">manage_accounts</span>
                Utilisateurs
            </a>
        </li>
        <li>
            <a class="flex items-center gap-3 text-on-surface-variant dark:text-outline px-4 py-3 font-label-bold text-label-bold hover:bg-surface-container-high dark:hover:bg-surface-container-highest transition-all rounded-lg active:translate-x-1 duration-200" href="{{ route('admin.dashboard', ['section' => 'parametres']) }}">
                <span class="material-symbols-outlined">settings</span>
                Paramètres
            </a>
        </li>
    </ul>

    <!-- Footer / CTA -->
    <div class="mt-auto flex flex-col gap-2">
        <form action="{{ route('logout') }}" method="POST" class="mt-2">
            @csrf
            <button class="flex w-full items-center gap-3 text-on-surface-variant dark:text-outline px-4 py-3 font-label-bold text-label-bold hover:bg-surface-container-high transition-all rounded-lg text-left" type="submit">
                <span class="material-symbols-outlined">logout</span>
                Déconnexion
            </button>
        </form>
    </div>
</nav>
