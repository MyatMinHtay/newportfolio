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

window.showToast = function (message, type, duration) {
    type = type || 'info';
    if (typeof Toastify === 'undefined') {
        console.warn('Toastify not loaded:', message);
        return;
    }

    const cfg = window.portfolioToast || {};
    const defaultDuration = cfg.duration || 3500;
    const toastDuration = duration !== null && duration !== undefined ? duration : (type === 'error' ? defaultDuration * 2 : defaultDuration);

    const colors = {
        success: '#16a34a',
        error: '#dc2626',
        warning: '#d97706',
        info: '#0ea5e9'
    };

    const background = colors[type] || colors.info;

    Toastify({
        text: String(message),
        duration: toastDuration,
        gravity: 'top',
        position: 'right',
        close: true,
        stopOnFocus: true,
        style: {
            background: background,
            color: '#ffffff',
            borderRadius: '0.5rem',
            boxShadow: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            fontWeight: '500',
            fontSize: '0.9rem',
            padding: '12px 16px'
        }
    }).showToast();
};

function initToasts() {
    if (!window.portfolioToast) {
        return;
    }

    const cfg = window.portfolioToast;
    ['success', 'error', 'warning', 'info'].forEach(function (key) {
        if (cfg[key]) {
            window.showToast(cfg[key], key);
        }
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
