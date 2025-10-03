<?php
/**
 * Template for the Member Access page with registration + waiver upload.
 *
 * @package FitWithAdi
 */

$registration_errors  = array();
$registration_success = false;
$form_values          = array(
    'first_name' => '',
    'last_name'  => '',
    'email'      => '',
    'goals'      => '',
);

if ( ! is_user_logged_in() && 'POST' === $_SERVER['REQUEST_METHOD'] ) {
    $nonce = isset( $_POST['fitwithadi_member_register_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['fitwithadi_member_register_nonce'] ) ) : '';

    if ( ! wp_verify_nonce( $nonce, 'fitwithadi_member_register' ) ) {
        $registration_errors[] = __( 'Your session expired. Please refresh the page and try again.', 'fitwithadi' );
    } else {
        $form_values['first_name'] = isset( $_POST['first_name'] ) ? sanitize_text_field( wp_unslash( $_POST['first_name'] ) ) : '';
        $form_values['last_name']  = isset( $_POST['last_name'] ) ? sanitize_text_field( wp_unslash( $_POST['last_name'] ) ) : '';
        $form_values['email']      = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        $password                  = isset( $_POST['password'] ) ? (string) $_POST['password'] : '';
        $confirm_password          = isset( $_POST['confirm_password'] ) ? (string) $_POST['confirm_password'] : '';
        $form_values['goals']      = isset( $_POST['goals'] ) ? sanitize_textarea_field( wp_unslash( $_POST['goals'] ) ) : '';

        if ( '' === $form_values['first_name'] || '' === $form_values['last_name'] ) {
            $registration_errors[] = __( 'Please share your first and last name.', 'fitwithadi' );
        }

        if ( '' === $form_values['email'] || ! is_email( $form_values['email'] ) ) {
            $registration_errors[] = __( 'Enter a valid email address.', 'fitwithadi' );
        } elseif ( email_exists( $form_values['email'] ) ) {
            $registration_errors[] = __( 'An account with this email already exists. Try logging in or resetting your password.', 'fitwithadi' );
        }

        if ( strlen( $password ) < 8 ) {
            $registration_errors[] = __( 'Choose a password that is at least eight characters long.', 'fitwithadi' );
        }

        if ( $password !== $confirm_password ) {
            $registration_errors[] = __( 'Your password confirmation does not match.', 'fitwithadi' );
        }

        if ( empty( $_FILES['waiver']['name'] ) ) {
            $registration_errors[] = __( 'Please upload your signed waiver as a PDF or image file.', 'fitwithadi' );
        }

        $waiver_attachment_id = 0;

        if ( empty( $registration_errors ) ) {
            require_once ABSPATH . 'wp-admin/includes/file.php';

            $uploaded_file = wp_handle_upload(
                $_FILES['waiver'],
                array(
                    'test_form' => false,
                )
            );

            if ( isset( $uploaded_file['error'] ) ) {
                $registration_errors[] = $uploaded_file['error'];
            } else {
                $file_type = wp_check_filetype( basename( $uploaded_file['file'] ), null );
                $allowed   = array( 'application/pdf', 'image/jpeg', 'image/png' );

                if ( ! in_array( $file_type['type'], $allowed, true ) ) {
                    $registration_errors[] = __( 'The waiver must be a PDF, JPG, or PNG file.', 'fitwithadi' );
                    if ( file_exists( $uploaded_file['file'] ) ) {
                        unlink( $uploaded_file['file'] );
                    }
                } else {
                    require_once ABSPATH . 'wp-admin/includes/image.php';

                    $attachment = array(
                        'guid'           => $uploaded_file['url'],
                        'post_mime_type' => $file_type['type'],
                        'post_title'     => sprintf( __( '%1$s %2$s Waiver', 'fitwithadi' ), $form_values['first_name'], $form_values['last_name'] ),
                        'post_content'   => '',
                        'post_status'    => 'inherit',
                    );

                    $waiver_attachment_id = wp_insert_attachment( $attachment, $uploaded_file['file'] );

                    if ( is_wp_error( $waiver_attachment_id ) ) {
                        $registration_errors[] = __( 'We could not save your waiver. Please try again.', 'fitwithadi' );
                        if ( file_exists( $uploaded_file['file'] ) ) {
                            unlink( $uploaded_file['file'] );
                        }
                    } else {
                        $attach_data = wp_generate_attachment_metadata( $waiver_attachment_id, $uploaded_file['file'] );
                        wp_update_attachment_metadata( $waiver_attachment_id, $attach_data );
                    }
                }
            }
        }

        if ( empty( $registration_errors ) ) {
            $base_username = sanitize_user( current( explode( '@', $form_values['email'] ) ), true );

            if ( '' === $base_username ) {
                $base_username = 'fitmember';
            }

            $username = $base_username;
            $suffix   = 1;

            while ( username_exists( $username ) ) {
                $username = $base_username . $suffix;
                $suffix  += 1;
            }

            $user_id = wp_insert_user(
                array(
                    'user_login'   => $username,
                    'user_pass'    => $password,
                    'user_email'   => $form_values['email'],
                    'first_name'   => $form_values['first_name'],
                    'last_name'    => $form_values['last_name'],
                    'display_name' => trim( $form_values['first_name'] . ' ' . $form_values['last_name'] ),
                    'role'         => 'subscriber',
                )
            );

            if ( is_wp_error( $user_id ) ) {
                $registration_errors[] = $user_id->get_error_message();

                if ( $waiver_attachment_id ) {
                    wp_delete_attachment( $waiver_attachment_id, true );
                }
            } else {
                update_user_meta( $user_id, 'fitwithadi_fitness_goals', $form_values['goals'] );

                if ( $waiver_attachment_id ) {
                    update_user_meta( $user_id, 'fitwithadi_waiver_attachment_id', $waiver_attachment_id );
                }

                if ( function_exists( 'wp_new_user_notification' ) ) {
                    wp_new_user_notification( $user_id, null, 'both' );
                }

                $registration_success = true;
                $form_values          = array(
                    'first_name' => '',
                    'last_name'  => '',
                    'email'      => '',
                    'goals'      => '',
                );
            }
        }
    }
}

$content_hub_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'content-hub' ) : '#';
$subscriptions_link = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'subscriptions' ) : '#';
$testimonials_link  = function_exists( 'fitwithadi_get_page_link' ) ? fitwithadi_get_page_link( 'testimonials' ) : '#';

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
                            esc_html_e( 'Create your FitWithAdi login, sign the waiver, and unlock every training resource.', 'fitwithadi' );
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

    <section class="section member-access">
        <div class="container member-access__grid">
            <div class="member-access__info">
                <h2><?php esc_html_e( 'What you get with your account', 'fitwithadi' ); ?></h2>
                <ul>
                    <li><?php esc_html_e( 'Instant access to the content hub with videos, challenges, and weekly plans.', 'fitwithadi' ); ?></li>
                    <li><?php esc_html_e( 'Ability to join subscriptions, enroll in challenges, and track your progress.', 'fitwithadi' ); ?></li>
                    <li><?php esc_html_e( 'Direct communication from Adi for accountability and program updates.', 'fitwithadi' ); ?></li>
                </ul>
                <div class="member-access__links">
                    <a class="btn btn--outline" href="<?php echo esc_url( $subscriptions_link ); ?>"><?php esc_html_e( 'View membership options', 'fitwithadi' ); ?></a>
                    <a class="btn btn--light" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'Preview the content hub', 'fitwithadi' ); ?></a>
                    <a class="btn btn--light" href="<?php echo esc_url( $testimonials_link ); ?>"><?php esc_html_e( 'Read member stories', 'fitwithadi' ); ?></a>
                </div>
            </div>
            <div class="member-access__form">
                <?php if ( is_user_logged_in() ) : ?>
                    <div class="notice notice--success">
                        <h2><?php esc_html_e( 'You’re already logged in!', 'fitwithadi' ); ?></h2>
                        <p><?php esc_html_e( 'Head to the content hub to start your next session.', 'fitwithadi' ); ?></p>
                        <a class="btn" href="<?php echo esc_url( $content_hub_link ); ?>"><?php esc_html_e( 'Go to the content hub', 'fitwithadi' ); ?></a>
                    </div>
                <?php else : ?>
                    <?php if ( $registration_success ) : ?>
                        <div class="notice notice--success">
                            <h2><?php esc_html_e( 'Account created!', 'fitwithadi' ); ?></h2>
                            <p><?php esc_html_e( 'Check your email for login details and next steps from Adi. You can now log in and access all member resources.', 'fitwithadi' ); ?></p>
                        </div>
                    <?php else : ?>
                        <?php if ( ! empty( $registration_errors ) ) : ?>
                            <div class="notice notice--error">
                                <h2><?php esc_html_e( 'We need a quick fix.', 'fitwithadi' ); ?></h2>
                                <ul>
                                    <?php foreach ( $registration_errors as $error ) : ?>
                                        <li><?php echo esc_html( $error ); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form class="member-form" method="post" enctype="multipart/form-data">
                            <?php wp_nonce_field( 'fitwithadi_member_register', 'fitwithadi_member_register_nonce' ); ?>
                            <div class="member-form__grid">
                                <div class="member-form__group">
                                    <label for="member-first-name"><?php esc_html_e( 'First name', 'fitwithadi' ); ?></label>
                                    <input type="text" id="member-first-name" name="first_name" value="<?php echo esc_attr( $form_values['first_name'] ); ?>" required>
                                </div>
                                <div class="member-form__group">
                                    <label for="member-last-name"><?php esc_html_e( 'Last name', 'fitwithadi' ); ?></label>
                                    <input type="text" id="member-last-name" name="last_name" value="<?php echo esc_attr( $form_values['last_name'] ); ?>" required>
                                </div>
                                <div class="member-form__group member-form__group--full">
                                    <label for="member-email"><?php esc_html_e( 'Email address', 'fitwithadi' ); ?></label>
                                    <input type="email" id="member-email" name="email" value="<?php echo esc_attr( $form_values['email'] ); ?>" required>
                                </div>
                                <div class="member-form__group">
                                    <label for="member-password"><?php esc_html_e( 'Create password', 'fitwithadi' ); ?></label>
                                    <input type="password" id="member-password" name="password" minlength="8" required>
                                </div>
                                <div class="member-form__group">
                                    <label for="member-password-confirm"><?php esc_html_e( 'Confirm password', 'fitwithadi' ); ?></label>
                                    <input type="password" id="member-password-confirm" name="confirm_password" minlength="8" required>
                                </div>
                                <div class="member-form__group member-form__group--full">
                                    <label for="member-goals"><?php esc_html_e( 'Share your goals + any injuries', 'fitwithadi' ); ?></label>
                                    <textarea id="member-goals" name="goals" rows="4"><?php echo esc_textarea( $form_values['goals'] ); ?></textarea>
                                </div>
                                <div class="member-form__group member-form__group--full">
                                    <label for="member-waiver"><?php esc_html_e( 'Upload signed waiver (PDF, JPG, or PNG)', 'fitwithadi' ); ?></label>
                                    <input type="file" id="member-waiver" name="waiver" accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>
                            </div>
                            <div class="member-form__actions">
                                <button type="submit" class="btn btn--dark"><?php esc_html_e( 'Create my account', 'fitwithadi' ); ?></button>
                                <p class="member-form__note"><?php esc_html_e( 'By submitting you agree to the FitWithAdi terms, privacy policy, and community guidelines.', 'fitwithadi' ); ?></p>
                            </div>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
