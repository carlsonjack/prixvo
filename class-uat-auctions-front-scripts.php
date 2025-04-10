<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Scripts Class
 * Handles Scripts and Styles enqueues functionality.
 *
 * @class  Ultimate_Auction_Pro_Front_Scripts
 * @package Ultimate Auction Pro Software
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if ( ! class_exists( 'Ultimate_Auction_Pro_Front_Scripts' ) ) :

	class Ultimate_Auction_Pro_Front_Scripts {

	/**
	 * Plugin actions
	 *
	 */
	public function __construct() {

		/* front side scripts */
		add_action( 'wp_enqueue_scripts', array( $this, 'ultimate_auction_pro_register_front_scripts') );

		/* Add front side styles */
		add_action( 'wp_enqueue_scripts', array( $this, 'ultimate_auction_pro_register_front_styles') );

	}

	/**
	 * Manage admin side scripts
	 *
	 * @param.
	 *
	 */
	public function ultimate_auction_pro_register_front_scripts( $hook_sufix ) {
		global $wp_query;
		
		/* Register globally scripts for auction Product */
		wp_register_script( 'uat-auction-front', UAT_THEME_PRO_JS_URI . 'auction/uat-auctions-front.js', array('jquery'), UAT_THEME_PRO_VERSION );
		wp_register_script( 'uat-front-js', UAT_THEME_PRO_JS_URI . 'uat-front.js', array('jquery'), UAT_THEME_PRO_VERSION );
		wp_register_script( 'uat-slick-js', UAT_THEME_PRO_JS_URI . 'slider/slick.min.js', array('jquery'), UAT_THEME_PRO_VERSION );


	


		wp_localize_script('uat-auction-front', 'UATAUCTION', array('ajaxurl' => admin_url('admin-ajax.php'), 'ua_nonce' => wp_create_nonce('UatAajax-nonce'),'last_timestamp' => get_option('woo_ua_auction_last_activity','0')));
		wp_localize_script('uat-auction-front', 'Uat_Ajax_Qry',array('ajaxqry' => add_query_arg('uat-ajax', '')));
		wp_enqueue_script( 'uat-auction-front' );



		/* Register globally scripts */
		wp_register_script( 'uat-owl-carousel-min', UAT_THEME_PRO_JS_URI . 'owl.carousel.min.js', array(), UAT_THEME_PRO_VERSION );
		wp_register_script( 'uat-jquery-fancybox-min', UAT_THEME_PRO_JS_URI . 'jquery.fancybox.min.js', array(), UAT_THEME_PRO_VERSION );
		wp_enqueue_script( 'uat-owl-carousel-min');
		wp_enqueue_script( 'uat-jquery-fancybox-min');
		wp_enqueue_script( 'uat-slick-js');


		/* localization custom data */
		$uat_front_data = array(			
			'menu_sticky' =>get_option( 'options_uat_menu_sticky', 'off' ),
		);
		wp_localize_script('uat-front-js', 'front_data', $uat_front_data);
		wp_enqueue_script( 'uat-front-js');



		/* Event JS File */
		wp_register_script( 'uat-event-front', UAT_THEME_PRO_JS_URI . 'event/uat-event-front.js', array('jquery'), UAT_THEME_PRO_VERSION );
		/* localization events custom data */
		$uat_events_data = array(
			'uatexpired' => __('Event has Expired!', 'ultimate-auction-pro-software'),
			'gtm_offset' => get_option('gmt_offset'),
			'uatstarted' => __('Event Started! Please refresh page.', 'ultimate-auction-pro-software'),
			'perpage' => get_option( 'options_uat_auction_products_no', 12 ),
			'loader' => UAT_THEME_PRO_IMAGE_URI."ajax_loader.gif",
			'pagination_type' => get_option( 'options_uat_event_list_pagination_type', 'infinite-scroll' ),
			'products_pagination_type' => get_option( 'options_uat_event_details_pagination_type', 'load-more' ),
			'products_perpage' => get_option( 'options_uat_auction_products_no', 12 ),
			'event_products_perpage' => get_option( 'options_uat_auction_products_no_event_detail', 12 ),	


		);
		wp_localize_script('uat-event-front', 'uat_event_data', $uat_events_data);
		wp_localize_script('uat-event-front', 'UATEVENT', array('ajaxurl' => admin_url('admin-ajax.php'), 'ua_nonce' => wp_create_nonce('UatAajax-nonce')));
		wp_enqueue_script( 'uat-event-front' );
		
		
			wp_enqueue_script( 'jquery-ui-min', UAT_THEME_PRO_JS_URI . 'jquery-ui.min.js', array(), UAT_THEME_PRO_VERSION);

		wp_register_script( 'Single-Auctions-list', UAT_THEME_PRO_JS_URI . 'auction/uat-Single-Auctions-list.js', array('jquery'), UAT_THEME_PRO_VERSION);
		wp_localize_script('Single-Auctions-list', 'AuctionsLIST', array('ajaxurl' => admin_url('admin-ajax.php'), 'ua_nonce' => wp_create_nonce('UatAajax-nonce')));
	   wp_localize_script('uat-event-front', 'uat_event_data', $uat_events_data);
	  wp_enqueue_script('Single-Auctions-list');

		if(is_singular( 'product' )){
			wp_register_script( 'uat-swiper-min', UAT_THEME_PRO_JS_URI . 'swiper.min.js', array('jquery'), UAT_THEME_PRO_VERSION );
			wp_enqueue_script( 'uat-swiper-min' );

		}


	}

	/**
	 * Manage admin side styles
	 *
	 * @param.
	 *
	 */
	public function ultimate_auction_pro_register_front_styles( $hook_sufix ) {

		/* Register styles */
		wp_enqueue_style( 'uat-style', get_template_directory_uri().'/style.css', array(), UAT_THEME_PRO_VERSION );
		//wp_enqueue_style( 'uat-vendor-style', UAT_THEME_PRO_CSS_URI.'/vendor.css', array(), UAT_THEME_PRO_VERSION );
		wp_enqueue_style( 'front-auction-detail', UAT_THEME_PRO_CSS_URI.'/front-auction-detail.css', array(), UAT_THEME_PRO_VERSION );
		wp_enqueue_style( 'uat-slick-style', UAT_THEME_PRO_CSS_URI.'/jquery_slick.css', array(), UAT_THEME_PRO_VERSION );
		wp_register_style( 'uat-owl-carousel-min', UAT_THEME_PRO_CSS_URI.'owl.carousel.min.css', array());
		wp_register_style( 'uat-all-min', UAT_THEME_PRO_CSS_URI.'all.min.css', array());
		wp_register_style( 'uat-jquery-fancybox-min', UAT_THEME_PRO_CSS_URI.'jquery.fancybox.min.css', array());
		wp_register_style( 'uat-woocommerce', UAT_THEME_PRO_CSS_URI.'woocommerce/woocommerce.css', array());

		/* Enqueue styles */
		wp_enqueue_style( 'uat-owl-carousel-min');
		wp_enqueue_style( 'uat-jquery-fancybox-min');
		wp_enqueue_style( 'uat-all-min');
		wp_enqueue_style( 'uat-woocommerce');


		if(is_singular( 'product' )){
				wp_register_style( 'uat-swiper-bundle-min', UAT_THEME_PRO_CSS_URI.'swiper-bundle.min.css', array());
				wp_enqueue_style( 'uat-swiper-bundle-min');
		}

	}

}

endif;