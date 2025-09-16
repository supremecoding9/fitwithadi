<footer class="site-footer">
    <div class="container site-footer__inner">
        <div class="site-footer__brand">
            <a class="site-logo site-logo--footer" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                <span class="site-logo__accent">Fit</span> With Adi
            </a>
            <p class="site-footer__tagline"><?php esc_html_e( 'Private and group training in-studio or in the comfort of your home.', 'fitwithadi' ); ?></p>
        </div>
        <div class="site-footer__contact">
            <h2 class="h5"><?php esc_html_e( 'Connect', 'fitwithadi' ); ?></h2>
            <ul class="site-footer__list">
                <li><a href="tel:+13105551234">(310) 555-1234</a></li>
                <li><a href="mailto:hello@fitwithadi.com">hello@fitwithadi.com</a></li>
                <li><?php esc_html_e( 'Sunset Studio · Venice, CA', 'fitwithadi' ); ?></li>
            </ul>
        </div>
        <div class="site-footer__social">
            <h2 class="h5"><?php esc_html_e( 'Follow', 'fitwithadi' ); ?></h2>
            <ul class="social-links">
                <li><a href="https://www.instagram.com" target="_blank" rel="noopener noreferrer">Instagram</a></li>
                <li><a href="https://www.youtube.com" target="_blank" rel="noopener noreferrer">YouTube</a></li>
                <li><a href="https://www.facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a></li>
            </ul>
        </div>
    </div>
    <div class="site-footer__bottom">
        <div class="container site-footer__bottom-inner">
            <p>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'All rights reserved.', 'fitwithadi' ); ?></p>
            <a class="site-footer__top" href="#top"><?php esc_html_e( 'Back to top', 'fitwithadi' ); ?></a>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
