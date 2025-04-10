<?php
/*
 * Ultimate_Auction_Theme_Pro Main class
 */
if (!defined('ABSPATH')) {
	die('Access denied.');
}
if (!class_exists('Ultimate_Auction_Theme_Pro')) :
	class Ultimate_Auction_Theme_Pro
	{
		public static $instance = false;
		public $init;
		public $acf;
		public $scripts_front;
		public $plugins;
		public $menu;
		public $uat_event_model;
		public $translation;
		public $version = UAT_THEME_PRO_VERSION;
		private function __construct()
		{
		}
		/*
		* init
		*
		* Initiate all necessary modules
		*/
		public function init()
		{
				$this->load_dependencies();
				$this->scripts_front = new Ultimate_Auction_Pro_Front_Scripts();
				$this->acf = new Ultimate_Auction_Pro_ACF();
				$this->init = new Ultimate_Auction_Pro_Init();
				add_action('after_setup_theme', array($this, 'load_textdomain'));
		}
		/*
		* load_textdomain
		*
		* Load theme textdomain for translations
		*/
		public function load_textdomain()
		{
			load_theme_textdomain('ultimate-auction-pro-software', UAT_THEME_PRO_DIR . '/languages');
		}
		/**
		 * load_dependencies
		 *
		 * Load all files required by theme
		 */
		private function load_dependencies()
		{
			global $sitepress;
			/**
			 * Include WCFM Support
			 *
			 */
			$blog_plugins = get_option( 'active_plugins', array() );
			$site_plugins = is_multisite() ? (array) maybe_unserialize( get_site_option(
				'active_sitewide_plugins' ) ) : array();


			/* For Free */
			if ( in_array( 'wc-frontend-manager/wc_frontend_manager.php', $blog_plugins ) || isset( 
				$site_plugins['wc-frontend-manager/wc_frontend_manager.php'] ) ) {

				require_once ( UAT_THEME_PRO_INC_DIR . 'wcfm/class-wcfm-support.php' );

			}
			
			require_once(UAT_THEME_PRO_INC_DIR . 'uat-theme-functions.php');
			//require_once(UAT_THEME_PRO_ADMIN . 'class-tgm-plugin-activation.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'class-ultimate-auction-init.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'uat-query.php');
			/* ACF Field in Admin Side */
			require_once(UAT_THEME_PRO_ADMIN . 'acf-fields/class-uat-acf.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'class-uat-auctions-front-scripts.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'uat-footer-code.php');
			
			/* Create Auction Product Type */
			if (class_exists('WooCommerce')) {
				require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/class-auction-product.php');
				require_once(UAT_THEME_PRO_ADMIN . 'auctions-products/class-auction-product-type.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/class-auctions-front.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/class-users-auctions.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/class-auctions-front.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/class-uat-shortcodes.php');
			}
			require_once(UAT_THEME_PRO_INC_DIR . 'auctions-products/auctions-misc-functions.php');

			require_once(UAT_THEME_PRO_INC_DIR . 'emails/class-uat-email.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'emails/class-email-init.php');
			require_once(UAT_THEME_PRO_ADMIN . 'emails/functions.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'class-uat-ajax.php');
			/**
			 * Main Admin file
			 */
			require_once(UAT_THEME_PRO_ADMIN . 'class-uat-admin.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'uat-theme-core-functions.php');
			/**
			 * Event Files
			 */
			require_once(UAT_THEME_PRO_INC_DIR . 'events/events-misc-functions.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'events/uat-events-ajax-functions.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'events/class-events-shortcodes.php');
			/**
			 * Admin Event Files
			 */
			require_once(UAT_THEME_PRO_ADMIN . 'events/class-uat-event-post-type.php');
			require_once(UAT_THEME_PRO_ADMIN . 'events/class-uat-event-category.php');
			/*login module*/
			require_once(UAT_THEME_PRO_INC_DIR . 'login/uat-ajax-login.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'login/uat-login-register-aut.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'woocommerce-functions.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'activity/class-uat-auction-activity.php');

			/*payment module*/
			require_once(UAT_THEME_PRO_INC_DIR . 'payment/class-payment.php');

			/*stripe module*/
			require_once(UAT_THEME_PRO_INC_DIR . 'stripe/vendor/autoload.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'stripe/class-menu-auctions.php');



			/*braintree module*/
			require_once(UAT_THEME_PRO_INC_DIR . 'braintree/lib/Braintree.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'braintree/class-uat-auction-braintree.php');


			require_once(UAT_THEME_PRO_INC_DIR . 'install/uat-install.php');

			/* start react*/
			if (class_exists('WooCommerce')) {
				require_once(UAT_THEME_PRO_INC_DIR . 'json_bidlist/class-uat-auction-bidlist.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'notification_bid/class-uat-auction-bid-notify.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'json/class-uat-auction-json.php');


				require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/class-questions_answers.php');
				
				$q_a_auction_porducts = get_option( 'options_q_a_auction_product_page', 'on' );
				$q_a_d_prodcuts = get_option( 'options_q_a_auction_wooCommerce_product_page', 'on' );
				if($q_a_auction_porducts =='on' || $q_a_d_prodcuts =='on'){
					require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/class-users-questions_answers.php');
				}	
				/* end react*/
				require_once(UAT_THEME_PRO_INC_DIR . 'emails/email_tracking/email_tracking.class.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'expire/class-uat-auction-expire.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'orders/class-uat-auction-orders.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'sniping/class-sniping.php');
				require_once(UAT_THEME_PRO_ADMIN . 'users/class-uat-users-blocked.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'sniping/class-sniping.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'buynow/class-buynow.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'clock/class-uat-auction-clock.php');			
			}
			require_once(UAT_THEME_PRO_INC_DIR . 'clock/countdown_clock.php');			

			$wc_products_comments = get_option('options_wc_default_page_comments','on');
			$auctions_comments = get_option('options_uat_auction_comments', 'on');
			$blog_comments = get_option('options_blog_default_page_comments', 'on');
			if ($auctions_comments == 'on' || $wc_products_comments == 'on'  || $blog_comments == 'on' ) {
				require_once(UAT_THEME_PRO_INC_DIR . 'comment/class-comment.php');
				require_once(UAT_THEME_PRO_INC_DIR . 'comment/class-users-comments.php');	
			}
			// Admin approval for new registrations
			$approval = get_option('options_uat_need_registration_approval', 'disable');
			//uat_registration_confirmation
			if (!empty($approval) && $approval == 'enable') {
				require_once(UAT_THEME_PRO_ADMIN . 'users/class-uat-users-member.php');
			}
			$confirmation = get_option('options_uat_need_registration_confirmation', 'disable');
			//Confirm new user while registration
			if (!empty($confirmation) && $confirmation == 'enable') {
				require_once(UAT_THEME_PRO_ADMIN . 'users/class-uat-users-confirm.php');
			}
			require_once(UAT_THEME_PRO_INC_DIR . 'biding/class-uat-bid.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'biding/misc-functions.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'biding/uat-ajax.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'uat-csv-downloader.php');
			/* place bid using page load */
			add_action('init', array($this, 'ultimate_auction_theme_place_bid'));
			//add_action('wp_loaded', array($this, 'uat_user_registration_approval'),10);
			include_once (UAT_THEME_PRO_ADMIN . 'notifications/sms-class.php');
			include_once (UAT_THEME_PRO_ADMIN . 'notifications/whatsapp-class.php');
			require_once(UAT_THEME_PRO_ADMIN . 'sorturl/sort-url-class.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'translations/string-translations.php');

			/* For WPML Support*/
			if ( function_exists( 'icl_object_id' ) && method_exists( $sitepress, 'get_default_language' ) ) {
				add_action( 'woocommerce_process_product_meta', array( $this, 'uwa_syncronise_metadata_wpml' ), 85 );
				add_action( 'save_post', array( $this, 'uwa_syncronise_events_metadata_wpml' ), 85 );

			}
			/* For Custom Fields Support*/
			require_once(UAT_THEME_PRO_ADMIN . 'custom-fields/custom-fields-ajax.php');	
		}
		public function uwa_syncronise_events_metadata_wpml($data){
			global $sitepress,$wpdb;

			$deflanguage = $sitepress->get_default_language();
			if ( is_array( $data ) ) {
				$product_id = $data['product_id'];
			} else {
				$product_id = $data;
			}
			if (get_post_type($product_id) != 'uat_event')
            {
                return;
            }
			$meta_values = get_post_meta( $product_id );
			$orginalid   = $sitepress->get_original_element_id( $product_id, 'post_uat_event' );
			$trid        = $sitepress->get_element_trid( $product_id, 'post_uat_event' );
			$all_posts   = $sitepress->get_element_translations( $trid, 'post_uat_event' );
			$default_lng = $all_posts[ $deflanguage ];
			$default_event_id = $default_lng->element_id;
			$event_exists = $wpdb->get_row('SELECT * FROM '.UA_EVENTS_TABLE." WHERE post_id=".$default_event_id);
			if($event_exists) {
                $default_lang_array = unserialize($event_exists->event_products_ids);
			}
			unset( $all_posts[ $deflanguage ] );
			if ( ! empty( $all_posts ) ) {
				foreach ( $all_posts as $key_ => $translatedpost ) {
					$event_array = [];
					$translated_array = [];
					if($event_exists) {
						foreach ($default_lang_array as $product_id){
							if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
								$lang = $key_??$sitepress->get_default_language();
								$translated_product_id = icl_object_id($product_id,'product',false, $lang);
								$translated_array[] = $translated_product_id;
								$event_exists = $wpdb->get_row('SELECT * FROM '.UA_EVENTS_TABLE." WHERE post_id=".$translatedpost->element_id);
								if($event_exists) {
									$post_id = $event_exists->post_id;
									update_post_meta( $translated_product_id, 'uat_event_id', $post_id);
								}
							}
						}
						$translated_array = serialize($translated_array);
						$event_array['event_products_ids'] = $translated_array;
						$wpdb->update(UA_EVENTS_TABLE, $event_array, array('post_id'=>$translatedpost->element_id) );
					}
					foreach ( $meta_values as $key => $value ) {
						update_post_meta( $translatedpost->element_id, $key, $value[0]);
					}
				}
			}
		}
	/**
			 * Syncronise auction meta data with wpml
			 *
			 * Sync meta via translated products
			 *
			 */
			public function uwa_syncronise_metadata_wpml( $data ) {

				global $wpdb,$sitepress;

				$deflanguage = $sitepress->get_default_language();
				if ( is_array( $data ) ) {
					$product_id = $data['product_id'];
				} else {
					$product_id = $data;
				}

				$meta_values = get_post_meta( $product_id );
				$orginalid   = $sitepress->get_original_element_id( $product_id, 'post_product' );
				$trid        = $sitepress->get_element_trid( $product_id, 'post_product' );
				$all_posts   = $sitepress->get_element_translations( $trid, 'post_product' );
				$ap_exists = $wpdb->get_var('SELECT post_id FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$product_id);
				$ap_exists = (array) $ap_exists;
				unset($ap_exists['auction_id']);
				if($ap_exists) {
					$product_exists['lang_code'] = $sitepress->get_default_language();
					$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $product_exists, array('post_id'=>$product_id) );
				}
				unset( $all_posts[ $deflanguage ] );

				if ( ! empty( $all_posts ) ) {
					foreach ( $all_posts as $key => $translatedpost ) {
						// save transalted in auction_product table.

						$product_trans_exists = get_post($translatedpost->element_id);
						$product_exists = $wpdb->get_row('SELECT * FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$product_id);

						if($product_exists) {
							if($product_trans_exists) {
								$translated_event_id = $product_exists->event_id;
								if (!empty($translated_event_id)  && function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
									$lang = $key??$sitepress->get_default_language();
									$translated_event_id = icl_object_id($product_exists->event_id,'product',false, $lang);
								}
								$product_exists->post_id = $translatedpost->element_id;
								$product_exists->auction_name = $product_trans_exists->post_title;
								$product_exists->auction_content = $product_trans_exists->post_content;
								$product_exists->event_id = $translated_event_id??'0';
								$product_exists->lang_code = $key??$sitepress->get_default_language();
								$p_exists = $wpdb->get_var('SELECT post_id FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$translatedpost->element_id);
								$product_exists = (array) $product_exists;
								unset($product_exists['auction_id']);
								if($p_exists) {
									$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $product_exists, array('post_id'=>$translatedpost->element_id) );
								} else {
									$get_id = $wpdb->get_row("SHOW TABLE STATUS LIKE '".UA_AUCTION_PRODUCT_TABLE."'");
									$last_id = $get_id->Auto_increment;
									$next_id = $last_id + 1;
									$q= $wpdb->insert(UA_AUCTION_PRODUCT_TABLE,$product_exists);
								}
							}
						}

						if ( isset( $meta_values['_manage_stock'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_manage_stock', $meta_values['_manage_stock'][0] );
						}
						if ( isset( $meta_values['_stock'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_stock', $meta_values['_stock'][0] );
						}
						if ( isset( $meta_values['_backorders'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_backorders', $meta_values['_backorders'][0] );
						}
						if ( isset( $meta_values['_sold_individually'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_sold_individually', $meta_values['_sold_individually'][0] );
						}
						if ( isset( $meta_values['_regular_price'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_regular_price', $meta_values['_regular_price'][0] );
						}
						if ( isset( $meta_values['_price'][0] ) ) {
							update_post_meta( $translatedpost->element_id, '_price', $meta_values['_price'][0] );
						}
						if ( isset( $meta_values['woo_ua_product_condition'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_product_condition', $meta_values['woo_ua_product_condition'][0] );
						}
						if ( isset( $meta_values['uat_auction_subtitle'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uat_auction_subtitle', $meta_values['uat_auction_subtitle'][0] );
						}
						if ( isset( $meta_values['woo_ua_opening_price'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_opening_price', $meta_values['woo_ua_opening_price'][0] );
						}
						if ( isset( $meta_values['woo_ua_lowest_price'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_lowest_price', $meta_values['woo_ua_lowest_price'][0] );
						}
						if ( isset( $meta_values['uwa_number_of_next_bids'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_number_of_next_bids', $meta_values['uwa_number_of_next_bids'][0] );
						}
						if ( isset( $meta_values['uat_estimate_price_from'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uat_estimate_price_from', $meta_values['uat_estimate_price_from'][0] );
						}
						if ( isset( $meta_values['uat_estimate_price_to'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uat_estimate_price_to', $meta_values['uat_estimate_price_to'][0] );
						}
						if ( isset( $meta_values['woo_ua_auction_type'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_auction_type', $meta_values['woo_ua_auction_type'][0] );
						}
						if ( isset( $meta_values['woo_ua_auction_selling_type'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_auction_selling_type', $meta_values['woo_ua_auction_selling_type'][0] );
						}
						if ( isset( $meta_values['uwa_event_auction'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_event_auction', $meta_values['uwa_event_auction'][0] );
						}
						if ( isset( $meta_values['uat_auction_lot_number'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uat_auction_lot_number', $meta_values['uat_auction_lot_number'][0] );
						}
						if ( isset( $meta_values['uwa_auction_proxy'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_auction_proxy', $meta_values['uwa_auction_proxy'][0] );
						}
						if ( isset( $meta_values['uwa_auction_silent'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_auction_silent', $meta_values['uwa_auction_silent'][0] );
						}
						if ( isset( $meta_values['woo_ua_bid_increment'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'woo_ua_bid_increment', $meta_values['woo_ua_bid_increment'][0] );
						}
						if (!isset($_REQUEST['is_seller_product'])) {
							if ( isset( $meta_values['woo_ua_auction_start_date'][0] ) ) {
								update_post_meta( $translatedpost->element_id, 'woo_ua_auction_start_date', $meta_values['woo_ua_auction_start_date'][0] );
							}
							if ( isset( $meta_values['woo_ua_auction_end_date'][0] ) ) {
								update_post_meta( $translatedpost->element_id, 'woo_ua_auction_end_date', $meta_values['woo_ua_auction_end_date'][0] );
							}
						}
						if ( isset( $meta_values['uwa_auction_variable_bid_increment_type'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_auction_variable_bid_increment_type', $meta_values['uwa_auction_variable_bid_increment_type'][0] );
						}
						if ( isset( $meta_values['uwa_auction_variable_bid_increment'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_auction_variable_bid_increment', $meta_values['uwa_auction_variable_bid_increment'][0] );
						}
						if ( isset( $meta_values['uwa_var_inc_price_val'][0] ) ) {
							update_post_meta( $translatedpost->element_id, 'uwa_var_inc_price_val', $meta_values['uwa_var_inc_price_val'][0] );
						}

					}
				}
			}


		// registration by admin
		public function uat_user_registration_approval( $url = false ) {
		}
		/**
		 * Function For Place Bid Button Click.
		 *
		 */
		public function ultimate_auction_theme_place_bid($url = false)
		{
			if (empty($_REQUEST['uat-place-bid']) || !is_numeric($_REQUEST['uat-place-bid'])) {
				return;
			}
			global $woocommerce;
			$product_id = absint($_REQUEST['uat-place-bid']);
			$bid = abs(round(str_replace(',', '.', $_REQUEST['uat_bid_value']), wc_get_price_decimals()));
			$was_place_bid = false;
			$placed_bid = array();
			$placing_bid = wc_get_product($product_id);
			$product_type = method_exists($placing_bid, 'get_type') ? $placing_bid->get_type() : $placing_bid->product_type;
			$quantity = 1;
			if ('auction' === $product_type) {
				$product_data = wc_get_product($product_id);
				$current_user = wp_get_current_user();
				$outbiddeduser = $placing_bid->get_uwa_auction_current_bider();
				$auction_high_current_bider = $product_data->get_uwa_auction_max_current_bider();
				$uwa_silent = $product_data->get_uwa_auction_silent();
				if ($auction_high_current_bider == $outbiddeduser) {
					$outbiddeduser = "";
				}
				$uwa_silent_outbid_email = get_option('uwa_silent_outbid_email', "no");
				if ($uwa_silent == 'yes'  && $uwa_silent_outbid_email == "no") {
					$outbiddeduser = "";
				}
				if ($outbiddeduser  == $current_user->ID) {
					$outbiddeduser = "";
				}
				$UAT_Bid = new UAT_Bid;
				/* Placing Bid */
				if ($UAT_Bid->uat_bidplace($product_id, $bid)) {
					/*  --- place bid message not to display -- */

					$was_place_bid = true;
					uat_bid_place_message($product_id);

					$placed_bid[] = $product_id;
					if ($was_place_bid) {
						$check_email = new EmailTracking();
						$email_status = $check_email->duplicate_email_check($auction_id=$product_id ,$user_id=$current_user->ID,$email_type='place_bid',$amount=$bid);
						if( !$email_status )
						{
							$uat_Email = new PlaceBidMail();
							$uat_Email->place_bid_email($product_id ,$current_user->ID );
						}
					}
				}
				
					wp_safe_redirect(esc_url(remove_query_arg(array('uat-place-bid', 'quantity', 'product_id'), wp_get_referer())));
					exit;
				
			} else {
				wc_add_notice(__('This product is not an Auction product.', 'ultimate-auction-pro-software'), 'error');
				return;
			}
		}
		/*
		* get_instance
		*
		* Get Ultimate_Auction_Theme_Pro instance or create if doesn't exists
		*/
		public static function get_instance()
		{
			if (!self::$instance) {
				self::$instance = new Ultimate_Auction_Theme_Pro();
			}
			return self::$instance;
		}
	}
endif;