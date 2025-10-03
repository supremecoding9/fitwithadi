<?php
/**
 * Template for the Testimonials page.
 *
 * @package FitWithAdi
 */

$content_hub_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'content-hub' ) : '#';
$subscriptions_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'subscriptions' ) : '#';
$member_access_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'member-access' ) : '#';

global $post;

get_header();
?>
<main id="main-content" class="site-main site-main--page">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <section class="page-hero">
                <div class="container page-hero__inner">
                    <h1><?php the_title(); ?></h1>
                    <p class="lead">
                        <?php
                        if ( has_excerpt() ) {
                            echo esc_html( get_the_excerpt() );
                        } else {
                            esc_html_e( 'Celebrate transformation stories from the FitWithAdi community.', 'fitwithadi' );
                        }
                        ?>
                    </p>
                </div>
            </section>

            <?php if ( '' !== get_the_content() ) : ?>
                <section class="section section--light page-section">
                    <div class="container">
                        <?php the_content(); ?>
                    </div>
                </section>
            <?php endif; ?>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <?php
    $testimonials = new WP_Query(
        array(
            'post_type'      => 'fit_testimonial',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        )
    );
    ?>

    <section class="section testimonials-page">
        <div class="container">
            <?php if ( $testimonials->have_posts() ) : ?>
                <div class="testimonial-grid testimonial-grid--full">
                    <?php
                    while ( $testimonials->have_posts() ) :
                        $testimonials->the_post();
                        ?>
                        <article class="testimonial testimonial--detailed">
                            <div class="testimonial__content">
                                <h2><?php the_title(); ?></h2>
                                <div class="testimonial__text">
                                    <?php the_content(); ?>
                                </div>
                                <?php if ( has_excerpt() ) : ?>
                                    <p class="testimonial__summary">“<?php echo esc_html( get_the_excerpt() ); ?>”</p>
                                <?php endif; ?>
                            </div>
                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="testimonial__media">
                                    <?php the_post_thumbnail( 'medium_large' ); ?>
                                </div>
                            <?php endif; ?>
                        </article>
                        <?php
                    endwhile;
                    ?>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="testimonial-empty">
                    <h2><?php esc_html_e( 'Testimonials are on the way', 'fitwithadi' ); ?></h2>
                    <p><?php esc_html_e( 'Share your clients’ stories by adding new Testimonial entries from the WordPress dashboard.', 'fitwithadi' ); ?></p>
                    <a class="btn btn--outline" href="<?php echo esc_url( admin_url( 'post-new.php?post_type=fit_testimonial' ) ); ?>"><?php esc_html_e( 'Add a testimonial', 'fitwithadi' ); ?></a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section class="section section--light testimonials-cta">
        <div class="container testimonials-cta__inner">
            <div class="testimonials-cta__content">
                <h2><?php esc_html_e( 'Ready to write your own story?', 'fitwithadi' ); ?></h2>
                <p><?php esc_html_e( 'Join the FitWithAdi community, start training with Adi, and we’ll feature your wins next.', 'fitwithadi' ); ?></p>
            </div>
            <div class="testimonials-cta__actions">
                <a class="btn" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Create your account', 'fitwithadi' ); ?></a>
                <a class="btn btn--outline" href="<?php echo esc_url( $subscriptions_link ); ?>"><?php esc_html_e( 'Explore memberships', 'fitwithadi' ); ?></a>
                <a class="btn btn--light" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'See the content library', 'fitwithadi' ); ?></a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
