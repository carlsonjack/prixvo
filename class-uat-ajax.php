<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
/** 
 *
 * Handling AJAX Event.
 *
 * @class  UAT_AJAX
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh 
 * @since 1.0
 *
 */
 

class UAT_AJAX {

	/**
	 * Hook in ajax handlers.
	 *
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'define_uat_ajax' ), 0 );
		add_action( 'wp_loaded', array( __CLASS__, 'do_uat_ajax' ), 10 );		
	}

	/**
	 * Set AJAX constant and headers.
	 *
	 */
	public static function define_uat_ajax() {
		if ( !empty( $_GET['uat-ajax'] ) ) {
			wc_maybe_define_constant( 'UAT_DOING_AJAX', true );
			wc_maybe_define_constant( 'WC_DOING_AJAX', true );
			if ( ! WP_DEBUG || ( WP_DEBUG && ! WP_DEBUG_DISPLAY ) ) {
				@ini_set( 'display_errors', 0 ); // Turn off display_errors during AJAX events to prevent malformed JSON
			}
			$GLOBALS['wpdb']->hide_errors();
		}
	}

	/**
	 * Check for ajax request and fire action.
	 *
	 */
	public static function do_uat_ajax() {
		global $wp_query;
		if ( ! empty( $_GET['uat-ajax'] ) ) {
			self::wc_ajax_headers();
			do_action( 'uat_ajax_' . sanitize_text_field( $_GET['uat-ajax'] ) );
			wp_die();
		}
	}

	/**
	 * Send headers for Ajax Requests.
	 *
	 */
	private static function wc_ajax_headers() {
		send_origin_headers();
		@header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
		@header( 'X-Robots-Tag: noindex' );
		send_nosniff_header();
		nocache_headers();
		status_header( 200 );
	}
}

UAT_AJAX::init();