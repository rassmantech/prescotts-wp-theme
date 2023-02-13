<?php
/**
 * Email Options and Cron Jobs list
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Start Class
if ( ! class_exists( 'Prescott_cron_options' ) ) {

    class Prescott_cron_options {

        /**
         * Start things up
         *
         * @since 1.0.0
         */
        public function __construct() {

            // We only need to register the admin panel on the back-end
            if ( is_admin() ) {
                add_action( 'admin_menu', array( 'Prescott_cron_options', 'add_admin_menu' ) );
                add_action( 'admin_init', array( 'Prescott_cron_options', 'register_settings' ) );
            }

        }

        /**
         * Register a setting and its sanitization callback.
         *
         * We are only registering 1 setting so we can store all options in a single option as
         * an array. You could, however, register a new setting for each option
         *
         * @since 1.0.0
         */
        public static function register_settings() {
            register_setting( 'theme_options', 'theme_options', array( 'Prescott_cron_options' ) );
        }

        /**
         * Returns all theme options
         *
         * @since 1.0.0
         */
        public static function get_theme_options() {
            return get_option( 'theme_options' );
        }

        /**
         * Returns single theme option
         *
         * @since 1.0.0
         */
        public static function get_theme_option( $id ) {
            $options = self::get_theme_options();
            if ( isset( $options[$id] ) ) {
                return $options[$id];
            }
        }

        /**
         * Add sub menu page
         *
         * @since 1.0.0
         */
        public static function add_admin_menu() {

        if ( current_user_can( 'administrator' ) ) {
            add_menu_page(
                esc_html__( 'Email Scheduler Settings', 'text-domain' ),
                esc_html__( 'Email Scheduler Settings', 'text-domain' ),
                'manage_options',
                'theme-settings',
                array( 'Prescott_cron_options', 'create_admin_page' )
            );
        }
        }



        /**
         * Settings page output
         *
         * @since 1.0.0
         */
        public static function create_admin_page() { ?>

            <div class="wrap">

                <h1><?php esc_html_e( 'Email Tasks', 'text-domain' ); ?></h1>
                <p>You should see an email task below if the cron is scheduled correctly, hit "reset" to reschedule the cron</p>
                <div>
                <?php echo( list_reminder_cron()); ?>
                </div>
                <br>
                <button id="reset-email-cron" class="button button-primary">Reset Email Cron</button><br>
                <small>Use this option if emails are not sending</small>

            </div><!-- .wrap -->
        <?php }

    }
}
new Prescott_cron_options();
