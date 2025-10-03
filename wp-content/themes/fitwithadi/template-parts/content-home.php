<?php
/**
 * Front-page content template.
 *
 * @package FitWithAdi
 */

$content_hub_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'content-hub' ) : '#';
$subscriptions_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'subscriptions' ) : '#';
$member_access_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'member-access' ) : '#';
$testimonials_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'testimonials' ) : '#';
?>
<section class="hero hero--front" id="hero">
    <div class="container hero__inner">
        <div class="hero__content">

            <p class="eyebrow"><?php esc_html_e( 'Personal Training · Small Group Coaching · Wellness Lifestyle', 'fitwithadi' ); ?></p>
            <h1><?php esc_html_e( 'Strong looks good on you.', 'fitwithadi' ); ?></h1>
            <p class="lead"><?php esc_html_e( 'I am Adi - your coach, and accountability partner. This is where we blend strength, sweat, flexibility and balance to help you feel unstoppable in every season of life.', 'fitwithadi' ); ?></p>

            <div class="hero__actions">
                <a class="btn" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Create your account', 'fitwithadi' ); ?></a>
                <a class="btn btn--outline" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'Preview the content hub', 'fitwithadi' ); ?></a>
            </div>
            <ul class="hero__highlights">
                <li>
                    <span class="hero__metric">100%</span>
                    <span><?php esc_html_e( 'Personalized training experience', 'fitwithadi' ); ?></span>
                </li>
                <li>
                    <span class="hero__metric">5</span>
                    <span><?php esc_html_e( 'Curated member-only spaces', 'fitwithadi' ); ?></span>
                </li>
                <li>
                    <span class="hero__metric">∞</span>
                    <span><?php esc_html_e( 'Support, encouragement, & community', 'fitwithadi' ); ?></span>
                </li>
            </ul>
        </div>
        <div class="hero__media" aria-hidden="true">
            <div class="hero__badge">Adi · NASM CPT · Women’s Fitness Specialist</div>
            <div class="hero__shape hero__shape--one"></div>
            <div class="hero__shape hero__shape--two"></div>
            <div class="hero__shape hero__shape--three"></div>
        </div>
    </div>
</section>

<section class="section section--light" id="about">
    <div class="container about about--expanded">
        <div class="about__image" aria-hidden="true"></div>
        <div class="about__content">
            <h2><?php esc_html_e( 'Meet Adi', 'fitwithadi' ); ?></h2>

            <p><?php esc_html_e( 'Fitness changed my life, and now I help youth, adults, and elderly rewrite their own stories with movement. From first-time lifters to lifelong athletes, I create training plans that celebrate progress, protect your body, and keep you coming back for more.', 'fitwithadi' ); ?></p>
            <div class="about__grid">
                <div class="about__item">
                    <h3><?php esc_html_e( 'Personal studio sanctuary', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Train in a sunlit Venice studio equipped with everything from kettlebells to reformers—no intimidating crowds, just curated vibes.', 'fitwithadi' ); ?></p>
                </div>
                <div class="about__item">
                    <h3><?php esc_html_e( 'In-home training made effortless', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Adi travels across Los Angeles with customized equipment kits, turning living rooms and home gyms into motivating training grounds.', 'fitwithadi' ); ?></p>
                </div>
                <div class="about__item">
                    <h3><?php esc_html_e( 'Group energy that uplifts', 'fitwithadi' ); ?></h3>
                    <p><?php esc_html_e( 'Small, high-touch classes capped at eight women keep the focus on form, connection, and serious results.', 'fitwithadi' ); ?></p>
                </div>

            </div>
        </div>
    </div>
</section>

<section class="section" id="site-map">
    <div class="container">
        <div class="section__heading">
            <h2><?php esc_html_e( 'Your FitWithAdi journey at a glance', 'fitwithadi' ); ?></h2>
            <p><?php esc_html_e( 'Explore every page of the site to access personal coaching, fresh workouts, exclusive memberships, and community stories.', 'fitwithadi' ); ?></p>
        </div>
        <div class="card-grid card-grid--alt">
            <article class="card card--link">
                <h3><?php esc_html_e( 'Content Hub', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Upload and organize on-demand videos, daily challenges, and weekly training plans for your clients.', 'fitwithadi' ); ?></p>
                <a class="card__link" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'Visit the hub', 'fitwithadi' ); ?></a>
            </article>
            <article class="card card--link">
                <h3><?php esc_html_e( 'Subscriptions', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Package your coaching into flexible membership options and show exactly what each level includes.', 'fitwithadi' ); ?></p>
                <a class="card__link" href="<?php echo esc_url( $subscriptions_link ); ?>"><?php esc_html_e( 'Review plans', 'fitwithadi' ); ?></a>
            </article>
            <article class="card card--link">
                <h3><?php esc_html_e( 'Member Access', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Allow new members to register, submit their waiver, and access subscriber-only training in one place.', 'fitwithadi' ); ?></p>
                <a class="card__link" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Manage sign ups', 'fitwithadi' ); ?></a>
            </article>
            <article class="card card--link">
                <h3><?php esc_html_e( 'Testimonials', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Showcase transformation stories and social proof from your community to inspire future clients.', 'fitwithadi' ); ?></p>
                <a class="card__link" href="<?php echo esc_url( $testimonials_link ); ?>"><?php esc_html_e( 'Read the stories', 'fitwithadi' ); ?></a>
            </article>
        </div>
    </div>
</section>

<section class="section section--accent" id="pillars">
    <div class="container pillars">
        <div class="pillars__intro">
            <h2><?php esc_html_e( 'The FitWithAdi method', 'fitwithadi' ); ?></h2>
            <p><?php esc_html_e( 'Every program blends these five pillars so you can build strength, balance hormones, and keep your energy high.', 'fitwithadi' ); ?></p>
        </div>
        <div class="pillars__grid">
            <article class="pillar">
                <h3><?php esc_html_e( 'Strength foundations', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Progressive overload, proper form, and smart recovery for sustainable results.', 'fitwithadi' ); ?></p>
            </article>
            <article class="pillar">
                <h3><?php esc_html_e( 'Athletic conditioning', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Dynamic intervals and mobility work that improve performance and keep workouts fun.', 'fitwithadi' ); ?></p>
            </article>
            <article class="pillar">
                <h3><?php esc_html_e( 'Nutrition guidance', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Macro-friendly recipes and hydration habits to support training and recovery.', 'fitwithadi' ); ?></p>
            </article>
            <article class="pillar">
                <h3><?php esc_html_e( 'Mindset & accountability', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Check-ins, progress tracking, and community wins to keep motivation high.', 'fitwithadi' ); ?></p>
            </article>
            <article class="pillar">
                <h3><?php esc_html_e( 'Lifestyle integration', 'fitwithadi' ); ?></h3>
                <p><?php esc_html_e( 'Programming that adapts to travel, busy seasons, and every stage of womanhood.', 'fitwithadi' ); ?></p>
            </article>
        </div>
    </div>
</section>

<section class="section" id="cta">
    <div class="container cta cta--front">
        <div class="cta__content">
            <h2><?php esc_html_e( 'Ready to make FitWithAdi your fitness home?', 'fitwithadi' ); ?></h2>
            <p><?php esc_html_e( 'Start your membership, share your goals, and access the resources that keep you consistent—from personalized plans to energetic group challenges.', 'fitwithadi' ); ?></p>
        </div>
        <a class="btn btn--dark" href="<?php echo esc_url( $member_access_link ); ?>"><?php esc_html_e( 'Register & sign the waiver', 'fitwithadi' ); ?></a>
    </div>
</section>
