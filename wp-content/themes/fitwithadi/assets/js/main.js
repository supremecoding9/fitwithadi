(function () {
    const navigation = document.querySelector('.site-nav');
    const toggleButton = document.querySelector('.nav-toggle');

    if (navigation && toggleButton) {
        toggleButton.addEventListener('click', function () {
            const isExpanded = toggleButton.getAttribute('aria-expanded') === 'true';
            toggleButton.setAttribute('aria-expanded', (!isExpanded).toString());
            navigation.classList.toggle('is-open');
        });

        navigation.addEventListener('click', function (event) {
            if (event.target.closest('a')) {
                toggleButton.setAttribute('aria-expanded', 'false');
                navigation.classList.remove('is-open');
            }
        });
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    if (!prefersReducedMotion || !prefersReducedMotion.matches) {
        document.documentElement.style.scrollBehavior = 'smooth';
    }
})();
