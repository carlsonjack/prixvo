<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scripts Class
 * Handles Scripts and Styles enqueues functionality.
 *
 * @class  UAT_ADMIN_Scripts
 * @package Ultimate Auction Pro Software
 * @author Nitesh Singh 
 * @since 1.0
 *
 */
class Ultimate_Auction_Pro_ADMIN_Scripts {
	
	private static $instance;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 *
	 */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
	 * Plugin actions
	 *
	 */
	public function __construct() {
		
		/* Add admin side scripts */
		add_action( 'admin_footer', array( $this, 'ultimate_auction_pro_register_admin_scripts') );
		
		/* Add admin side styles */
		add_action( 'admin_enqueue_scripts', array( $this, 'ultimate_auction_pro_register_admin_styles') );
		
	}

	/**
	 * Manage admin side scripts
	 *
	 * @param.
	 *	
	 */
	public function ultimate_auction_pro_register_admin_scripts( $hook_sufix ) {

		/* Register globally scripts */
		wp_register_script( 'uat-auctions-admin', UAT_THEME_PRO_JS_URI . 'auction/uat-auctions-admin.js', array('jquery'), UAT_THEME_PRO_VERSION );
		
		wp_register_script( 'uat-datepicker', UAT_THEME_PRO_JS_URI . 'date-picker.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.0' );
		/* localization script */	
		if (class_exists('WooCommerce')) {
		wp_localize_script('uat-auctions-admin', 'UAT_Auction', array(
																		'ajaxurl' => admin_url('admin-ajax.php'), 
																		'uwa_nonce' => wp_create_nonce('UtAajax-nonce') ,
																		'calendar_image'=> WC()->plugin_url() . '/assets/images/calendar.png', 
																		'gateway_error_msg' => __('There are live auctions for which you have enabled "Credit Card" related features. Once all auctions have expired, you can then switch the payment gateway.', 'ultimate-auction-pro-software'), 
																		'fixamount_error_msg' => __('Enter specific amount', 'ultimate-auction-pro-software'),
																		'invalid_reserve_msg' => __('Please enter a reserve price more than the opening price', 'ultimate-auction-pro-software'),
																		'invalid_auction_data_msg' => __('Please fill auction product related data in \'Auction\' tab', 'ultimate-auction-pro-software'),
																		'invalid_auction_selling_type_msg' => __('Both selling types are selected, Please fill auction product related data in \'Auction\' tab', 'ultimate-auction-pro-software'),
																		'invalid_auction_date_invalid_msg' => __('Please fill auction start date and end date', 'ultimate-auction-pro-software'),
																		'invalid_auction_date_less_msg' => __('End date must be greater than Start date', 'ultimate-auction-pro-software'),
																	));
		}
		wp_enqueue_script( 'uat-auctions-admin' );		
		wp_enqueue_script( 'uat-datepicker' );
		
		/* Register globally scripts */
		wp_register_script( 'uat-theme-options-admin', UAT_THEME_PRO_JS_URI . 'theme-options/uat-theme-options.js', array('jquery'), UAT_THEME_PRO_VERSION );		
				
		wp_localize_script('uat-theme-options-admin', 'UAT_Options', array('ajaxurl' => admin_url('admin-ajax.php'), 'uat_nonce' => wp_create_nonce('UtAajax-nonce') ));
		wp_enqueue_script( 'uat-theme-options-admin' );

		wp_register_script( 'uat-event-admin', UAT_THEME_PRO_JS_URI . 'event/uat-event-admin.js', array('jquery'), UAT_THEME_PRO_VERSION );
		wp_localize_script('uat-event-admin', 'UATE_Events', array('ajaxurl' => admin_url('admin-ajax.php'), 'uat_events_nonce' => wp_create_nonce('uat-events-nonce')));
		wp_enqueue_script( 'uat-event-admin' );
		
	}

	/**
	 * Manage admin side styles
	 *	
	 * @param.
	 * 
	 */
	public function ultimate_auction_pro_register_admin_styles( $hook_sufix ) {
		
		/* Register styles */
		wp_register_style( 'uat-theme-admin', UAT_THEME_PRO_CSS_URI.'uat-theme-admin.css', array(), UAT_THEME_PRO_VERSION );
		
		/* Enqueue styles */
		wp_enqueue_style( 'uat-theme-admin' );
		
	}

}

Ultimate_Auction_Pro_ADMIN_Scripts::get_instance();

