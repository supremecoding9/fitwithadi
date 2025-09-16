<?php
/**
 * Main template file.
 *
 * @package FitWithAdi
 */

get_header();
?>
<main id="main-content" class="site-main">
    <?php if ( have_posts() ) : ?>
        <?php if ( is_home() && ! is_front_page() ) : ?>
            <header class="page-header">
                <h1 class="page-title"><?php single_post_title(); ?></h1>
            </header>
        <?php elseif ( is_archive() ) : ?>
            <header class="page-header">
                <?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
                <?php the_archive_description( '<div class="archive-description">', '</div>' ); ?>
            </header>
        <?php endif; ?>

        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class( is_singular() ? 'post-single' : 'post-summary' ); ?>>
                <?php if ( is_singular() ) : ?>
                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                        <div class="entry-meta">
                            <span class="meta-item entry-date">
                                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                            </span>
                            <span class="meta-item entry-author">
                                <?php
                                printf(
                                    esc_html__( 'By %s', 'fitwithadi' ),
                                    esc_html( get_the_author() )
                                );
                                ?>
                            </span>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <figure class="entry-media">
                            <?php the_post_thumbnail( 'large' ); ?>
                        </figure>
                    <?php endif; ?>

                    <div class="entry-content">
                        <?php
                        the_content();
                        wp_link_pages(
                            array(
                                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'fitwithadi' ),
                                'after'  => '</div>',
                            )
                        );
                        ?>
                    </div>

                    <footer class="entry-footer">
                        <?php
                        $categories_list = get_the_category_list( ', ' );
                        if ( $categories_list ) {
                            printf(
                                '<span class="cat-links">%s %s</span>',
                                esc_html__( 'Posted in', 'fitwithadi' ),
                                wp_kses_post( $categories_list )
                            );
                        }

                        $tags_list = get_the_tag_list( '', ', ' );
                        if ( $tags_list ) {
                            printf(
                                '<span class="tags-links">%s %s</span>',
                                esc_html__( 'Tagged', 'fitwithadi' ),
                                wp_kses_post( $tags_list )
                            );
                        }
                        ?>
                    </footer>
                <?php else : ?>
                    <header class="entry-header">
                        <h2 class="entry-title">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <div class="entry-meta">
                            <span class="meta-item entry-date">
                                <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>">
                                    <?php echo esc_html( get_the_date() ); ?>
                                </time>
                            </span>
                            <span class="meta-item entry-author">
                                <?php
                                printf(
                                    esc_html__( 'By %s', 'fitwithadi' ),
                                    esc_html( get_the_author() )
                                );
                                ?>
                            </span>
                        </div>
                    </header>

                    <?php if ( has_post_thumbnail() ) : ?>
                        <figure class="entry-media">
                            <a href="<?php echo esc_url( get_permalink() ); ?>" class="post-thumbnail">
                                <?php the_post_thumbnail( 'medium_large' ); ?>
                            </a>
                        </figure>
                    <?php endif; ?>

                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>

                    <footer class="entry-footer">
                        <a class="read-more" href="<?php echo esc_url( get_permalink() ); ?>">
                            <?php esc_html_e( 'Continue reading', 'fitwithadi' ); ?>
                        </a>
                    </footer>
                <?php endif; ?>
            </article>

            <?php if ( is_singular( 'post' ) ) : ?>
                <?php
                the_post_navigation(
                    array(
                        'prev_text' => sprintf(
                            '<span class="nav-subtitle">%s</span> <span class="nav-title">%%title</span>',
                            esc_html__( 'Previous Post', 'fitwithadi' )
                        ),
                        'next_text' => sprintf(
                            '<span class="nav-subtitle">%s</span> <span class="nav-title">%%title</span>',
                            esc_html__( 'Next Post', 'fitwithadi' )
                        ),
                    )
                );
                ?>
            <?php endif; ?>

            <?php if ( is_singular() && ( comments_open() || get_comments_number() ) ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
        <?php endwhile; ?>

        <?php if ( ! is_singular() ) : ?>
            <?php
            the_posts_pagination(
                array(
                    'mid_size'  => 2,
                    'prev_text' => esc_html__( 'Previous', 'fitwithadi' ),
                    'next_text' => esc_html__( 'Next', 'fitwithadi' ),
                )
            );
            ?>
        <?php endif; ?>
    <?php else : ?>
        <section class="no-results not-found">
            <header class="page-header">
                <h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'fitwithadi' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like we can’t find what you’re looking for.', 'fitwithadi' ); ?></p>
                <?php get_search_form(); ?>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php
get_footer();
