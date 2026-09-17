/**
 * Portfolio CMS — frontend entry & theme management
 *
 * Supports Light & Dark themes with localStorage persistence.
 * Bootstrap components initialize via data-bs-* attributes.
 */
(function () {
    const storedTheme = localStorage.getItem('portfolio_theme');
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initialTheme = storedTheme || (systemDark ? 'dark' : 'light');

    function applyTheme(theme) {
        document.documentElement.setAttribute('data-bs-theme', theme);
        document.documentElement.classList.toggle('dark', theme === 'dark');
        document.body && document.body.classList.toggle('dark', theme === 'dark');
        localStorage.setItem('portfolio_theme', theme);
        syncThemeToggleIcon(theme);
    }

    function syncThemeToggleIcon(theme) {
        const isDark = (theme || document.documentElement.getAttribute('data-bs-theme')) === 'dark';
        document.querySelectorAll('.theme-toggle').forEach(function (btn) {
            const icon = btn.querySelector('i');
            if (icon) {
                icon.className = isDark ? 'bi bi-sun' : 'bi bi-moon-stars';
            }
            btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            btn.setAttribute('title', isDark ? 'Switch to light theme' : 'Switch to dark theme');
        });
    }

    applyTheme(initialTheme);

    window.setTheme = function (theme) {
        applyTheme(theme);
    };

    window.toggleTheme = function () {
        const current = document.documentElement.getAttribute('data-bs-theme') || 'light';
        const next = current === 'dark' ? 'light' : 'dark';
        applyTheme(next);
        return next;
    };

    window.syncThemeToggleIcon = syncThemeToggleIcon;
})();

document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.syncThemeToggleIcon === 'function') {
        window.syncThemeToggleIcon();
    }

    document.querySelectorAll('.theme-toggle, #toggle').forEach(function (btn) {
        btn.addEventListener('click', function () {
            window.toggleTheme();
        });
    });

    initToasts();
    initPublicNav();
});

function initToasts() {
    if (typeof Toastify === 'undefined' || !window.portfolioToast) {
        return;
    }

    const cfg = window.portfolioToast;
    const duration = cfg.duration || 3000;
    const types = [
        { key: 'success', background: '#16a34a' },
        { key: 'error', background: '#dc2626' },
        { key: 'warning', background: '#d97706' },
        { key: 'info', background: '#0ea5e9' }
    ];

    types.forEach(function (type) {
        const text = cfg[type.key];
        if (!text) {
            return;
        }

        Toastify({
            text: String(text),
            duration: type.key === 'error' ? duration * 2 : duration,
            gravity: 'top',
            position: 'right',
            close: true,
            stopOnFocus: true,
            style: {
                background: type.background,
                color: '#ffffff',
                borderRadius: '0.5rem'
            }
        }).showToast();
    });
}

function initPublicNav() {
    const nav = document.querySelector('.pf-public-nav');
    if (!nav) {
        return;
    }

    const navLinks = Array.prototype.slice.call(
        nav.querySelectorAll('.navbar-nav .nav-link[href^="#"]')
    );
    const sections = navLinks
        .map(function (link) {
            const id = link.getAttribute('href');
            return id ? document.querySelector(id) : null;
        })
        .filter(Boolean);

    function navOffset() {
        return (nav.offsetHeight || 72) + 16;
    }

    function scrollToHash(hash, updateHistory) {
        if (!hash || hash === '#') {
            return false;
        }

        const target = document.querySelector(hash);
        if (!target) {
            return false;
        }

        const top = target.getBoundingClientRect().top + window.scrollY - navOffset();
        window.scrollTo({
            top: Math.max(0, top),
            behavior: window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth'
        });

        if (updateHistory && window.history && window.history.pushState) {
            window.history.pushState(null, '', hash);
        }

        return true;
    }

    function setActiveLink() {
        if (!sections.length) {
            return;
        }

        const probe = window.scrollY + navOffset() + 8;
        let currentId = sections[0].id;

        sections.forEach(function (section) {
            if (section.offsetTop <= probe) {
                currentId = section.id;
            }
        });

        if ((window.innerHeight + window.scrollY) >= (document.documentElement.scrollHeight - 4)) {
            currentId = sections[sections.length - 1].id;
        }

        navLinks.forEach(function (link) {
            const isActive = link.getAttribute('href') === '#' + currentId;
            link.classList.toggle('active', isActive);
            if (isActive) {
                link.setAttribute('aria-current', 'page');
            } else {
                link.removeAttribute('aria-current');
            }
        });
    }

    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (event) {
            const hash = this.getAttribute('href');
            if (!hash || hash === '#' || hash.length < 2) {
                return;
            }
            if (scrollToHash(hash, true)) {
                event.preventDefault();
                const collapse = document.getElementById('publicNav');
                if (collapse && collapse.classList.contains('show') && window.bootstrap) {
                    const instance = window.bootstrap.Collapse.getInstance(collapse);
                    if (instance) {
                        instance.hide();
                    }
                }
            }
        });
    });

    window.addEventListener('scroll', setActiveLink, { passive: true });
    setActiveLink();

    if (window.location.hash) {
        window.setTimeout(function () {
            scrollToHash(window.location.hash, false);
        }, 50);
    }
}
