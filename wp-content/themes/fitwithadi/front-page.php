<?php
/**
 * Template for the static front page.
 *
 * @package FitWithAdi
 */

get_header();
?>
<main id="main-content" class="site-main">
    <?php get_template_part( 'template-parts/content', 'home' ); ?>
</main>
<?php
get_footer();
