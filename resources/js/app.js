//

document.querySelectorAll('[data-clinic-slider]').forEach((slider) => {
    const slides = [...slider.querySelectorAll('[data-slide]')];
    const dots = [...slider.querySelectorAll('[data-slide-to]')];
    const count = slider.querySelector('[data-slide-count]');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let current = 0;
    let timer;

    const show = (index) => {
        current = (index + slides.length) % slides.length;
        slides.forEach((slide, slideIndex) => {
            const active = slideIndex === current;
            slide.classList.toggle('is-active', active);
            slide.setAttribute('aria-hidden', active ? 'false' : 'true');
        });

        dots.forEach((dot, dotIndex) => {
            const active = dotIndex === current;
            dot.classList.toggle('is-active', active);
            if (active) dot.setAttribute('aria-current', 'true');
            else dot.removeAttribute('aria-current');
        });
        if (count) count.textContent = String(current + 1).padStart(2, '0');
    };

    const start = () => {
        if (reducedMotion) return;
        window.clearInterval(timer);
        timer = window.setInterval(() => show(current + 1), 6500);
    };

    dots.forEach((dot) => dot.addEventListener('click', () => { show(Number(dot.dataset.slideTo)); start(); }));
    slider.querySelector('[data-slide-prev]')?.addEventListener('click', () => { show(current - 1); start(); });
    slider.querySelector('[data-slide-next]')?.addEventListener('click', () => { show(current + 1); start(); });
    slider.addEventListener('mouseenter', () => window.clearInterval(timer));
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', () => window.clearInterval(timer));
    slider.addEventListener('focusout', start);
    start();
});

document.querySelectorAll('[data-password-toggle]').forEach((toggle) => {
    const input = document.getElementById(toggle.dataset.passwordToggle);
    const icon = toggle.querySelector('.material-symbols-outlined');
    if (!input || !icon) return;

    toggle.addEventListener('click', () => {
        const visible = input.type === 'password';
        input.type = visible ? 'text' : 'password';
        icon.textContent = visible ? 'visibility_off' : 'visibility';
        toggle.setAttribute('aria-label', visible ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
        toggle.setAttribute('aria-pressed', String(visible));
    });
});

document.querySelectorAll('[data-site-header]').forEach((header) => {
    const toggle = header.querySelector('[data-menu-toggle]');
    const menu = header.querySelector('[data-mobile-menu]');
    if (!toggle || !menu) return;

    const close = () => {
        header.classList.remove('menu-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Ouvrir le menu');
        toggle.querySelector('.material-symbols-outlined').textContent = 'menu';
    };

    toggle.addEventListener('click', () => {
        const open = header.classList.toggle('menu-open');
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Fermer le menu' : 'Ouvrir le menu');
        toggle.querySelector('.material-symbols-outlined').textContent = open ? 'close' : 'menu';
    });

    menu.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));
    window.matchMedia('(min-width: 900px)').addEventListener('change', (event) => event.matches && close());
});

document.querySelectorAll('[data-user-creation-form]').forEach((form) => {
    const role = form.querySelector('[data-user-role]');
    const label = form.querySelector('[data-user-specialty-label]');
    const input = form.querySelector('[data-user-specialty-input]');
    if (!role || !label || !input) return;

    const updateSpecialtyField = () => {
        const service = role.value === 'role-service';
        label.textContent = service ? 'Nom du service' : 'Spécialité du docteur';
        input.placeholder = service ? 'Ex. Laboratoire central' : 'Ex. Ophtalmologie';
    };

    role.addEventListener('change', updateSpecialtyField);
    updateSpecialtyField();
});

// Responsive navigation shared by every HealthPass professional workspace.
document.querySelectorAll('.hp-workspace').forEach((workspace) => {
    const sidebar = workspace.querySelector(':scope > aside, :scope > nav, :scope > main + aside');
    if (!sidebar || sidebar.dataset.mobileReady) return;

    sidebar.dataset.mobileReady = 'true';
    sidebar.id ||= `hp-workspace-navigation-${Math.random().toString(36).slice(2, 8)}`;

    const toggle = document.createElement('button');
    toggle.type = 'button';
    toggle.className = 'hp-mobile-nav-toggle';
    toggle.setAttribute('aria-controls', sidebar.id);
    toggle.setAttribute('aria-expanded', 'false');
    toggle.setAttribute('aria-label', 'Ouvrir la navigation');
    toggle.innerHTML = '<span class="material-symbols-outlined">menu</span>';

    const backdrop = document.createElement('button');
    backdrop.type = 'button';
    backdrop.className = 'hp-mobile-nav-backdrop';
    backdrop.setAttribute('aria-label', 'Fermer la navigation');

    const close = () => {
        workspace.classList.remove('hp-nav-open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Ouvrir la navigation');
        toggle.querySelector('.material-symbols-outlined').textContent = 'menu';
    };

    toggle.addEventListener('click', () => {
        const open = workspace.classList.toggle('hp-nav-open');
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Fermer la navigation' : 'Ouvrir la navigation');
        toggle.querySelector('.material-symbols-outlined').textContent = open ? 'close' : 'menu';
    });
    backdrop.addEventListener('click', close);
    sidebar.querySelectorAll('a').forEach((link) => link.addEventListener('click', close));
    document.addEventListener('keydown', (event) => event.key === 'Escape' && close());
    window.matchMedia('(min-width: 768px)').addEventListener('change', (event) => event.matches && close());

    workspace.append(backdrop, toggle);
});
