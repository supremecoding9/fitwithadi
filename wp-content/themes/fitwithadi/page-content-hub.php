<?php
/**
 * Template for the Content Hub page.
 *
 * @package FitWithAdi
 */

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
                            esc_html_e( 'Organize your workouts, challenges, and coaching resources so members always know what to train next.', 'fitwithadi' );
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
    $sections = array(
        array(
            'slug'        => 'videos',
            'title'       => __( 'On-demand video library', 'fitwithadi' ),
            'description' => __( 'Upload follow-along strength sessions, mobility resets, and technique breakdowns. Embed your video links directly in the post content so members can train from anywhere.', 'fitwithadi' ),
            'empty'       => __( 'Add your first video post and tag it with the “videos” category to populate this section.', 'fitwithadi' ),
        ),
        array(
            'slug'        => 'daily-challenges',
            'title'       => __( 'Daily challenge vault', 'fitwithadi' ),
            'description' => __( 'Keep momentum high with quick wins—post micro workouts, mindset prompts, or habit stacks that members can tackle in 15 minutes or less.', 'fitwithadi' ),
            'empty'       => __( 'Share a new challenge and assign it to the “daily-challenges” category to feature it here.', 'fitwithadi' ),
        ),
        array(
            'slug'        => 'weekly-plans',
            'title'       => __( 'Weekly training plans', 'fitwithadi' ),
            'description' => __( 'Map out the workouts, recovery sessions, and accountability touchpoints for each week. Attach PDFs or Google Drive links directly in the post body.', 'fitwithadi' ),
            'empty'       => __( 'Publish your first plan and mark it with the “weekly-plans” category to display it for members.', 'fitwithadi' ),
        ),
    );

    foreach ( $sections as $section ) :
        $category = get_category_by_slug( $section['slug'] );
        $query    = null;

        if ( $category && ! is_wp_error( $category ) ) {
            $query = new WP_Query(
                array(
                    'cat'            => $category->term_id,
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                )
            );
        }
        ?>
        <section class="section content-section" id="<?php echo esc_attr( $section['slug'] ); ?>">
            <div class="container">
                <div class="content-section__header">
                    <h2><?php echo esc_html( $section['title'] ); ?></h2>
                    <p><?php echo esc_html( $section['description'] ); ?></p>
                </div>

                <?php if ( $query instanceof WP_Query && $query->have_posts() ) : ?>
                    <div class="content-section__grid">
                        <?php
                        while ( $query->have_posts() ) :
                            $query->the_post();
                            ?>
                            <article class="content-card">
                                <div class="content-card__body">
                                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                                    <p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
                                </div>
                                <div class="content-card__meta">
                                    <span><?php echo esc_html( get_the_date() ); ?></span>
                                    <a class="content-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'View resource', 'fitwithadi' ); ?></a>
                                </div>
                            </article>
                            <?php
                        endwhile;
                        ?>
                    </div>
                    <div class="content-section__cta">
                        <a class="btn btn--outline" href="<?php echo esc_url( get_category_link( $category ) ); ?>"><?php esc_html_e( 'Browse all posts in this collection', 'fitwithadi' ); ?></a>
                    </div>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div class="content-section__empty">
                        <p><?php echo esc_html( $section['empty'] ); ?></p>
                        <a class="btn btn--light" href="<?php echo esc_url( admin_url( 'post-new.php' ) ); ?>"><?php esc_html_e( 'Create a new post', 'fitwithadi' ); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    endforeach;
    ?>
</main>
<?php
get_footer();
