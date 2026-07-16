// Small helper to mark the current navigation link as active
(function () {
  try {
    const parts = location.pathname.split('/');
    const current = parts.pop() || parts.pop(); // handle trailing slash
    document.querySelectorAll('nav a').forEach((a) => {
      const href = a.getAttribute('href');
      if (!href) return;
      if (href === current || href === location.pathname || href === location.href) {
        a.classList.add('active');
        a.setAttribute('aria-current', 'page');
      }
      // handle index/homepage fallback
      if (!current && (href === 'homepage.html' || href === 'index.html')) {
        a.classList.add('active');
        a.setAttribute('aria-current', 'page');
      }
    });
  } catch (e) {
    // Fail silently — helper is non-critical
    console.warn('finish.js error', e);
  }
})();
