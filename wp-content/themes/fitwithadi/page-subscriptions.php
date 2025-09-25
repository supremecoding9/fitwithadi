<?php
/**
 * Template for the Subscriptions page.
 *
 * @package FitWithAdi
 */

$content_hub_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'content-hub' ) : '#';
$member_access_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'member-access' ) : '#';
$testimonials_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'testimonials' ) : '#';

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
                            esc_html_e( 'Choose the training experience that fits your lifestyle and unlock every resource inside FitWithAdi.', 'fitwithadi' );
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

    <section class="section section--light" id="tiers">
        <div class="container">
            <div class="section__heading">
                <h2><?php esc_html_e( 'Memberships designed for every season', 'fitwithadi' ); ?></h2>
                <p><?php esc_html_e( 'Each plan includes access to the content hub, accountability check-ins, and an invite to our private community.', 'fitwithadi' ); ?></p>
            </div>
            <div class="subscription-tiers">
                <article class="tier">
                    <h3><?php esc_html_e( 'Momentum Starter', 'fitwithadi' ); ?></h3>
                    <p class="tier__price">$59<span><?php esc_html_e( '/month', 'fitwithadi' ); ?></span></p>
                    <ul>
                        <li><?php esc_html_e( 'Weekly training plan + video playlist', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Two live group workouts per month', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Progress tracking dashboard', 'fitwithadi' ); ?></li>
                    </ul>
                    <a class="btn btn--outline tier__cta" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Start your trial', 'fitwithadi' ); ?></a>
                </article>
                <article class="tier tier--featured">
                    <div class="tier__flag"><?php esc_html_e( 'Most popular', 'fitwithadi' ); ?></div>
                    <h3><?php esc_html_e( 'Limitless Coaching', 'fitwithadi' ); ?></h3>
                    <p class="tier__price">$149<span><?php esc_html_e( '/month', 'fitwithadi' ); ?></span></p>
                    <ul>
                        <li><?php esc_html_e( 'Weekly 1:1 check-in with Adi', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Unlimited content hub access', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Monthly custom program adjustments', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Priority registration for challenges & events', 'fitwithadi' ); ?></li>
                    </ul>
                    <a class="btn tier__cta" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Join Limitless', 'fitwithadi' ); ?></a>
                </article>
                <article class="tier">
                    <h3><?php esc_html_e( 'Elite VIP', 'fitwithadi' ); ?></h3>
                    <p class="tier__price">$349<span><?php esc_html_e( '/month', 'fitwithadi' ); ?></span></p>
                    <ul>
                        <li><?php esc_html_e( 'Weekly private sessions (in-person or virtual)', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Personalized nutrition check-ins', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Quarterly in-person retreats & labs', 'fitwithadi' ); ?></li>
                        <li><?php esc_html_e( 'Direct message support Monday–Friday', 'fitwithadi' ); ?></li>
                    </ul>
                    <a class="btn btn--outline tier__cta" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Apply for VIP', 'fitwithadi' ); ?></a>
                </article>
            </div>
        </div>
    </section>

    <section class="section" id="benefits">
        <div class="container benefits">
            <div class="benefits__intro">
                <h2><?php esc_html_e( 'Every membership includes', 'fitwithadi' ); ?></h2>
                <p><?php esc_html_e( 'Members get coaching systems that make consistency easy—plus the community vibes that keep you coming back.', 'fitwithadi' ); ?></p>
            </div>
            <div class="benefits__grid">
                <article class="benefit">
                    <h3><?php esc_html_e( 'Training calendars synced to your life', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Swap workouts, add rest days, and mark progress directly inside the content hub.', 'fitwithadi' ); ?></p>
                </article>
                <article class="benefit">
                    <h3><?php esc_html_e( 'Live + on-demand experiences', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Mix energetic group sessions with structured home workouts so you’re never without a plan.', 'fitwithadi' ); ?></p>
                </article>
                <article class="benefit">
                    <h3><?php esc_html_e( 'Accountability from Adi', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Direct support through check-ins, milestone celebrations, and strategy tweaks when life gets busy.', 'fitwithadi' ); ?></p>
                </article>
                <article class="benefit">
                    <h3><?php esc_html_e( 'Community celebrations', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Spotlight members, share testimonials, and highlight wins straight from the FitWithAdi fam.', 'fitwithadi' ); ?></p>
                </article>
            </div>
        </div>
    </section>

    <section class="section section--light" id="next-steps">
        <div class="container next-steps">
            <div class="next-steps__content">
                <h2><?php esc_html_e( 'Next steps', 'fitwithadi' ); ?></h2>
                <ol>
                    <li><?php esc_html_e( 'Create your member profile and sign the waiver.', 'fitwithadi' ); ?></li>
                    <li><?php esc_html_e( 'Choose the subscription that matches your goals.', 'fitwithadi' ); ?></li>
                    <li><?php esc_html_e( 'Dive into the content hub and join our next challenge.', 'fitwithadi' ); ?></li>
                </ol>
            </div>
            <div class="next-steps__actions">
                <a class="btn" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Get started', 'fitwithadi' ); ?></a>
                <a class="btn btn--outline" href="<?php echo esc_url( $testimonials_link ); ?>"><?php esc_html_e( 'Read member success stories', 'fitwithadi' ); ?></a>
                <a class="btn btn--light" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'Preview the content library', 'fitwithadi' ); ?></a>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
