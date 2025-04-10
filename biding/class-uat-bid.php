<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * UAT_Bidding Class
 *
 * @class  UAT_Bid
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
class UAT_Bid
{
	public $bid;
	/**
	 * Constructor for Loads options and hooks in the init method.
	 *
	 */
	public function __construct()
	{
		add_action('init', array($this, 'init'), 5);
	}
	/**
	 * Load bid data while Wordpress init and hooks in method.
	 *
	 */
	public function init()
	{
	}
	/**
	 * Bid Place On Auction Product
	 *
	 * @param string Product id and Bid Value
	 * @return bool
	 *
	 */
	public function uat_bidplace($product_id, $bid)
	{
		global $product_data, $wpdb;
		global $sitepress;
		$proxy_engine = false;
		$history_bid_id = false;
		/* For WPML Support*/
		if (function_exists('icl_object_id') && method_exists(
			$sitepress,
			'get_default_language'
		)) {
			$product_id = icl_object_id(
				$product_id,
				'product',
				false,
				$sitepress->get_default_language()
			);
		}
		$product_data = wc_get_product($product_id);

		
		$product_base_currency = $product_data->uwa_aelia_get_base_currency();
		$args = array("currency" => $product_base_currency);
		$post_obj    = get_post($product_id); // The WP_Post object
		$post_author = $post_obj->post_author; // <=== The post author ID
		do_action('ultimate_woocommerce_auction_before_place_bid', $product_id, $bid, $product_data);
		if (!is_user_logged_in()) {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid user', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$menu_link_types = get_option('options_menu_link_types', 'menu_open_in_popup');
			if ($menu_link_types == 'menu_open_in_direct_link') {			
			$message .= sprintf(__("Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
			} else {
			$message .= sprintf(__("Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
			}

			$message.= "</div>";
			echo $message;
			exit;
		}else{

			$uat_address_mandatory_bid_place=get_option('options_uat_address_mandatory_bid_place', 'false');

			if($uat_address_mandatory_bid_place=="true"){


				$user_id = get_current_user_id();
				$customer = new WC_Customer( $user_id );

				$shipping_first_name = $customer->get_shipping_first_name();
				$shipping_last_name  = $customer->get_shipping_last_name();

				$shipping_address_1  = $customer->get_shipping_address_1();

				$shipping_city       = $customer->get_shipping_city();
				$shipping_state      = $customer->get_shipping_state();
				$shipping_postcode   = $customer->get_shipping_postcode();
				$shipping_country    = $customer->get_shipping_country();

				if($shipping_first_name=="" || $shipping_last_name=="" || $shipping_country=="" || $shipping_address_1=="" || $shipping_city=="" || $shipping_state=="" || $shipping_postcode=="" ){
					$addressPageLink =  get_permalink(get_option('woocommerce_myaccount_page_id')).'edit-address';

					$message = "";
					$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
					$message .= __('Invalid shipping address', 'ultimate-auction-pro-software');
					$message.= "</div><div class='msgbox-text'>";
					$message .= sprintf(__('Please enter your shipping address before placing bid.</p> <a href="%s"  target="_blank"  class="button">Update Shipping Address &rarr;</a>', 'ultimate-auction-pro-software'), $addressPageLink);
					$message.= "</div>";
					echo $message;
					exit;
				}
			}
			$uat_billing_address_mandatory_bid_place=get_option('options_uat_billing_address_mandatory_bid_place', 'true');
			if($uat_billing_address_mandatory_bid_place == "true"){
				$user_id = get_current_user_id();
				$customer = new WC_Customer( $user_id );

				$billing_first_name = $customer->get_billing_first_name();
				$billing_last_name  = $customer->get_billing_last_name();

				$billing_address_1  = $customer->get_billing_address_1();

				$billing_city       = $customer->get_billing_city();
				$billing_state      = $customer->get_billing_state();
				$billing_postcode   = $customer->get_billing_postcode();
				$billing_country    = $customer->get_billing_country();

				if($billing_first_name=="" || $billing_last_name=="" || $billing_country=="" || $billing_address_1=="" || $billing_city=="" || $billing_state=="" || $billing_postcode=="" ){
					$addressPageLink =  get_permalink(get_option('woocommerce_myaccount_page_id')).'edit-address';

					$message = "";
					$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
					$message .= __('Invalid billing address', 'ultimate-auction-pro-software');
					$message.= "</div><div class='msgbox-text'>";
					$message .= sprintf(__('Please enter your billing address before placing bid.</p> <a href="%s"  target="_blank"  class="button">Update Billing Address &rarr;</a>', 'ultimate-auction-pro-software'), $addressPageLink);
					$message.= "</div>";
					echo $message;
					exit;
				}
			}
		}
		$current_user = wp_get_current_user();
		$user_status = get_user_meta($current_user->ID, 'uat_is_block', true);
		if ($user_status == "yes") {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Not allowed to place bid', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('You are not allowed to place bid please contact to admin.', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;
			exit;

		}
		if ((apply_filters(
			'ultimate_woocommerce_auction_before_place_bid_filter',
			$product_data,
			$bid
		) == false) or !is_object($product_data)) {
			return false;
		}
		$uwa_allow_admin_to_bid = get_option('options_uat_allow_admin_to_bid', 'off');
		$uwa_allow_owner_to_bid = get_option('options_uat_allow_owner_to_bid', 'off');
		$field_options_to_place_bid = get_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
		if (is_user_logged_in()) {
			/* for administrator role only */
			if (current_user_can('administrator')) {
				if ($uwa_allow_admin_to_bid == "off" && $current_user->ID == $post_author) {

					$message = "";
					$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
					$message .= __('Not allowed to place bid', 'ultimate-auction-pro-software');
					$message.= "</div><div class='msgbox-text'>";
					$message .= __('Sorry, you can not bid on your own auction product.', 'ultimate-auction-pro-software');
					$message.= "</div>";
					echo $message;
					exit;

				}
			} else { /* for seller/vendor/other role  */
				if ($uwa_allow_owner_to_bid == "off" && $current_user->ID == $post_author) {

					$message = "";
					$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
					$message .= __('Not allowed to place bid', 'ultimate-auction-pro-software');
					$message.= "</div><div class='msgbox-text'>";
					$message .= __('Sorry, you can not bid on your own auction product.', 'ultimate-auction-pro-software');
					$message.= "</div>";
					echo $message;
					exit;

				}
			}
		}
		if ($bid <= 0) {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('Please enter a value greater than 0!', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;
			exit;

		}
		if ($bid <= $product_data->get_uwa_auction_current_bid()) {
			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('<p>Please enter bid value greater than the next bid value</p>', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;
			exit;
		}
		
		/* Check if auction product expired */
		
		if ($product_data->is_uwa_completed() || json_chk_auction($product_id) == "past") {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Auction expired', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= sprintf(__('This auction &quot;%s&quot; has expired', 'ultimate-auction-pro-software'),$product_data->get_title());
			$message.= "</div>";
			echo $message;
			exit;

		}
		/* Check if auction product Live or schedule */
		if (json_chk_auction($product_id) == "future") {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Auction not started', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= sprintf(__('Sorry, the auction for &quot;%s&quot; has not started yet','ultimate-auction-pro-software'), $product_data->get_title());
			$message.= "</div>";
			echo $message;
			exit;

		}
		/* Check Stock */
		if (!$product_data->is_in_stock()) {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Auction is out of stock', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= sprintf(__('You cannot place a bid for &quot;%s&quot; because the product is out of stock.', 'ultimate-auction-pro-software'), $product_data->get_title());
			$message.= "</div>";
			echo $message;
			exit;

		}
		/* Check User Can Max Bid */
		$max_bid_amt = get_option('options_uat_can_max_bid_amt', '999999999999.99');
		if (empty($max_bid_amt)) {
			$max_bid_amt = 999999999999.99;
		}
		if ($bid >= $max_bid_amt) {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= sprintf(__('Bid Value must less than %s !', 'ultimate-auction-pro-software'),wc_price($max_bid_amt, $args));
			$message.= "</div>";
			echo $message;
			exit;

		}
		try {
			$Uat_Auction_Payment = new Uat_Auction_Payment();
		} catch (\Throwable $th) {
			//throw $th;
		}
		$check_is_bp_autodebit = $this->check_is_bp_autodebit($product_id);
		if($check_is_bp_autodebit){
			try {
				if($Uat_Auction_Payment)
				{
					$Uat_Auction_Payment->gateway_card_check($current_user->ID);
				}
			} catch (\Exception $th) {
				echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$th->getMessage());
				return false;
			}
		}
		$auction_type = $product_data->get_uwa_auction_type();
		$auction_bid_value = $product_data->uwa_bid_value();
		$auction_bid_increment = $product_data->get_uwa_auction_bid_increment();
		$auction_current_bid = $product_data->get_uwa_auction_current_bid();
		$auction_current_bider = $product_data->get_uwa_auction_current_bider();
		$auction_high_bid = $product_data->get_uwa_auction_max_bid();
		$auction_high_current_bider = $product_data->get_uwa_auction_max_current_bider();
		$auction_reserved_price = $product_data->get_uwa_auction_reserved_price();
		$auction_bid_count = $product_data->get_uwa_auction_bid_count();
		$uat_products_logs = get_option('options_uat_bids_logs', 'enable');
		if ($product_data->get_uwa_auction_silent() == 'yes') {
			return $this->silent_bidplace_process($product_data, $bid);
		}
		$check_is_hold = $this->check_is_hold($product_id);
		
	
		$uat_proxy_autobid_accept_bid = get_option('options_uat_proxy_autobid_accept_bid','autobid-with-bid');
		if($check_is_hold)
		{
			try {
				if($Uat_Auction_Payment)
				{
					$Uat_Auction_Payment->gateway_card_check($current_user->ID);
				}else{
					echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$th->getMessage());
					return false;
				}
			} catch (\Exception $th) {
				echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$th->getMessage());
				return false;
			}
		}
		
		if ($auction_type == 'normal') {
			if (apply_filters('ultimate_woocommerce_auction_minimum_bid_value', $auction_bid_value, $product_data, $bid) <= ($bid)) {
				/* Check for proxy bidding	*/
				$bidtype = "";
				if( isset($_REQUEST['bidtype']) )
				{
					$bidtype = $_REQUEST['bidtype'];
				}
				if ($product_data->get_uwa_auction_proxy() ) {
					$activity = "";
					
					if ($bid > (float) $auction_high_bid && $auction_high_current_bider == $current_user->ID && $bidtype != "directbid") {
						
							update_post_meta($product_id, 'woo_ua_auction_max_bid', $bid);
							if ($uat_products_logs == "enable") {
								$uat_auction_activity = new Uat_Auction_Activity();
								$activity_data = array(
									'post_parent'	=> $product_id,
									'activity_name'	=> "Changed New Maximum Bid",
									'activity_type'	=> 'ua_bids',
									'activity_by'	=> $current_user->ID,
								);
								$activity_meta = array(
									'bid_value'	=> $bid,
								);
								$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
							}
							// update maxbid in usermeta
							$maxbid_metakey = "woo_ua_auction_user_max_bid_" . $product_id;
							update_user_meta($current_user->ID,$maxbid_metakey,$bid);
							update_auction_json($post_id = $product_id, $bid_amout = $auction_high_bid, $proxy_ = "");
						$hold_msg = "";
						if($uat_proxy_autobid_accept_bid == 'autobid-with-bid')
						{

							$hold_status = "";
							$curent_bid = $product_data->uwa_bid_value();
							if($check_is_hold)
							{
								try {
									$hold_status = $Uat_Auction_Payment->hold_payment($curent_bid, $product_id, $current_user->ID, $activity);
									if($hold_status == "1")
									{
										$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
										$hold_status = "";
									}
								} catch (\Exception $th) {
									$hold_status = $th->getMessage();
								}
							}
							if($hold_status == "")
							{
								// place bid if need
								update_post_meta($product_id, 'woo_ua_auction_current_bid', $curent_bid);
								update_post_meta($product_id, 'woo_ua_auction_current_bid_proxy', 'yes');
								update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
								update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
								if ($uat_products_logs == "enable") {
									$uat_auction_activity = new Uat_Auction_Activity();
									$activity_data = array(
										'post_parent'	=> $product_id,
										'activity_name'	=> "Placed Bid",
										'activity_type'	=> 'ua_bids',
										'activity_by'	=> $current_user->ID,
									);
									$activity_meta = array(
										'bid_value'	=> $curent_bid,
									);
									$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
								}
								$history_bid_id = $this->history_bid($product_id, $curent_bid, $current_user);
							}else{
								echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
								return false;
							}
						}
						$message = "";
						$message = "<div class='msgbox-title' id='outbidMsg'>";
						$message .= __('Your bid is on top!', 'ultimate-auction-pro-software');
						$message.= "</div><div class='msgbox-text'>";

						$message .= __('Now you can relax and let us do the work. We\'ll bid for you until we reach your max amount.', 'ultimate-auction-pro-software');

						$message.= "</div>";

						echo $message;


					} elseif ($bid < (float) $auction_high_bid && $auction_high_current_bider == $current_user->ID && $bidtype != "directbid") {
						$message = "";

						$message = "";
						$message = "<div class='msgbox-title  msgbox-title-red' id='outbidMsg'>";
						$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
						$message.= "</div><div class='msgbox-text'>";
						$message .= __('New maximum bid cannot be smaller than old maximum bid.', 'ultimate-auction-pro-software');
						$message.= "</div>";
						echo $message;


					} elseif ($bid > (float) $auction_high_bid && $bidtype == "maxbidchange") {
							
							update_post_meta($product_id, 'woo_ua_auction_max_bid', $bid);
							update_post_meta($product_id, 'woo_ua_auction_max_current_bider', $current_user->ID);
							if ($uat_products_logs == "enable") {
								$uat_auction_activity = new Uat_Auction_Activity();
								$activity_data = array(
									'post_parent'	=> $product_id,
									'activity_name'	=> "Changed New Maximum Bid",
									'activity_type'	=> 'ua_bids',
									'activity_by'	=> $current_user->ID,
								);
								$activity_meta = array(
									'bid_value'	=> $bid,
								);
								$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
							}

							$maxbid_metakey = "woo_ua_auction_user_max_bid_" . $product_id;
							update_user_meta($current_user->ID,$maxbid_metakey,$bid);
							update_auction_json($post_id = $product_id, $bid_amout = $auction_current_bid, $proxy_ = "");
							$hold_msg = "";
							if($uat_proxy_autobid_accept_bid == 'autobid-with-bid')
							{
								$hold_status = "";
								$get_uwa_auction_current_bid_ = $product_data->get_uwa_auction_current_bid();


								$curent_bid = (float)$auction_high_bid+(float)$auction_bid_increment;

								if(!$auction_high_bid){
									$curent_bid = $product_data->get_uwa_auction_start_price();
								}
								if($check_is_hold)
								{
									$auction_high_current_bider_ = get_user_by('id', $auction_high_current_bider);
									/* previous user maximum bid place hold */
									if($get_uwa_auction_current_bid_ != $auction_high_bid && $current_user->ID != $auction_high_current_bider){
										try {
											$hold_status = $Uat_Auction_Payment->hold_payment($auction_high_bid, $product_id, $auction_high_current_bider_->ID, $activity);
										} catch (\Exception $th) {
											$hold_status = $th->getMessage();
										}
									}
									/* current user bid place hold */
									try {
										$hold_status = $Uat_Auction_Payment->hold_payment($curent_bid, $product_id, $current_user->ID, $activity);
										if($hold_status == "1")
										{
											$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
											$hold_status = "";
										}
									} catch (\Exception $th) {
										$hold_status = $th->getMessage();
									}
								}
								if($hold_status == "")
								{
									// place bid if need
									update_post_meta($product_id, 'woo_ua_auction_current_bid', $curent_bid);
									update_post_meta($product_id, 'woo_ua_auction_current_bid_proxy', 'yes');
									update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
									update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
									
									if ($uat_products_logs == "enable") {
										$uat_auction_activity = new Uat_Auction_Activity();
										$activity_data = array(
											'post_parent'	=> $product_id,
											'activity_name'	=> "Placed Bid",
											'activity_type'	=> 'ua_bids',
											'activity_by'	=> $current_user->ID,
										);
										$activity_meta = array(
											'bid_value'	=> $curent_bid,
										);
										$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
									}
									$auction_high_current_bider_ = get_user_by('id', $auction_high_current_bider);
									/* previous user maximum bid place */
									if($get_uwa_auction_current_bid_ != $auction_high_bid && $current_user->ID != $auction_high_current_bider){
										$history_bid_id = $this->history_bid($product_id, $auction_high_bid,$auction_high_current_bider_,1);
									}
									/* current user bid place */
									$history_bid_id = $this->history_bid($product_id, $curent_bid, $current_user);
									if($product_data->get_uwa_auction_max_current_bider() > 0)
									{
										$outbiddeduser = $auction_high_current_bider;
										$this->send_outbid_notifications($product_id,$outbiddeduser, $curent_bid);
									}
								}else{
									echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
									return false;
								}
							}
							$message = "";
							$message = "<div class='msgbox-title' id='outbidMsg'>";
							$message .= __('Your bid is on top!', 'ultimate-auction-pro-software');
							$message.= "</div><div class='msgbox-text'>";

							$message .= __('Now you can relax and let us do the work. We\'ll bid for you until we reach your max amount.', 'ultimate-auction-pro-software');

							$message.= "</div>";

							echo $message;

							if($uat_proxy_autobid_accept_bid != 'autobid-with-bid')
							{
								return false;
							}
					} elseif ($bid < (float) $auction_high_bid && $bidtype == "maxbidchange" && $uat_proxy_autobid_accept_bid == 'autobid-only-maximum') {
							$message = "";

							$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";

							$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
							$message.= "</div><div class='msgbox-text'>";
							$message .= __('Your automatic bid value is less or equal than the highest automatic bid. Kindly try again and your value should be greater than the current highest automatic bid.', 'ultimate-auction-pro-software');
							$message.= "</div>";
							echo $message;
							exit;

					} else {
						if ($bid > (float)$auction_high_bid) {
							

							if ($auction_high_bid) {
								$temp_bid = (float) $auction_high_bid + (float)$product_data->get_uwa_increase_bid_value();
								$curent_bid = ($bid  < $temp_bid) ? $bid  : $temp_bid;
							} else {
								$curent_bid = ($bid  < $auction_bid_value) ? $bid  : $auction_bid_value;
							}

							if($bidtype == "directbid"){
								$curent_bid = $bid;
							}
							$hold_status = "";
							if ($auction_high_bid > $auction_current_bid) {
								/* proxy user bid place */
								if ($uat_products_logs == "enable") {
									$uat_auction_activity = new Uat_Auction_Activity();
									$activity_data = array(
										'post_parent'	=> $product_id,
										'activity_name'	=> "Placed Bid Auto",
										'activity_type'	=> 'ua_bids',
										'activity_by'	=> $auction_high_current_bider,
									);
									$activity_meta = array(
										'bid_value'	=> $auction_high_bid,
									);
									$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
								}
								if($check_is_hold)
								{
									/* proxy user bid place hold */
									try {
										$hold_status = $Uat_Auction_Payment->hold_payment($auction_high_bid, $product_id, $auction_high_current_bider, $activity);
									} catch (\Exception $th) {
										$hold_status = $th->getMessage();
									}
								}
								if($hold_status == "")
								{
									$this->history_bid($product_id, $auction_high_bid, get_userdata($auction_high_current_bider), 1);
								}else{
									echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
									return false;
								}
							}
							$curent_bid =  apply_filters(
								'ultimate_woocommerce_auction_proxy_curent_bid_value',
								$curent_bid,
								$product_data,
								$bid
							);
							if($bidtype == "directbid"){
								$curent_bid = $bid;
							}
							$outbiddeduser = $auction_current_bider;
							$activity = "";
							$hold_status = "";
							if ($uat_products_logs == "enable") {
								$uat_auction_activity = new Uat_Auction_Activity();
								$activity_data = array(
									'post_parent'	=> $product_id,
									'activity_name'	=> "Placed Bid",
									'activity_type'	=> 'ua_bids',
									'activity_by'	=> $current_user->ID,
								);
								$activity_meta = array(
									'bid_value'	=> $curent_bid,
								);
								$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
							}

							/* current user bid place */
							$hold_msg = "";
							if($check_is_hold)
							{
								/* current user bid place hold */
								try {
									$hold_status = $Uat_Auction_Payment->hold_payment($curent_bid, $product_id, $current_user->ID, $activity);
									if($hold_status == "1")
									{
										$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
										$hold_status = "";
									}
								} catch (\Exception $th) {
									$hold_status = $th->getMessage();
								}
							}
							if($hold_status == "")
							{
								update_post_meta($product_id, 'woo_ua_auction_max_bid', $bid);

								$maxbid_metakey = "woo_ua_auction_user_max_bid_" . $product_id;
								update_user_meta($current_user->ID,$maxbid_metakey,$bid);

								update_post_meta($product_id, 'woo_ua_auction_max_current_bider', $current_user->ID);
								update_post_meta($product_id, 'woo_ua_auction_current_bid', $curent_bid);
								update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
								update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
								delete_post_meta($product_id, 'woo_ua_auction_current_bid_proxy');
							
								$history_bid_id = $this->history_bid($product_id, $curent_bid, $current_user, 0);
							}else{
								echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
								return false;
							}
							

							$message = "";
							$message = "<div class='msgbox-title' id='outbidMsg'>";
							$message .= __('Your bid is on top!', 'ultimate-auction-pro-software');
							$message.= "</div><div class='msgbox-text'>";

							$message .= __('Your bid has been placed successfully.', 'ultimate-auction-pro-software');

							$message.= "</div>";
							$this->send_outbid_notifications($product_id,$outbiddeduser,$curent_bid);
							echo $message;
						} elseif ($bid  == (float)$auction_high_bid) {
							if ($uat_proxy_autobid_accept_bid == 'autobid-with-bid') {
								
								$hold_status = "";
								$hold_msg = "";
								/* current user bid place */
								if ($uat_products_logs == "enable") {
									$uat_auction_activity = new Uat_Auction_Activity();
									$activity_data = array(
										'post_parent'	=> $product_id,
										'activity_name'	=> "Placed Bid",
										'activity_type'	=> 'ua_bids',
										'activity_by'	=> $current_user->ID,
									);
									$activity_meta = array(
										'bid_value'	=> $bid,
									);
									$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
								}
								if ($uat_products_logs == "enable") {
									$uat_auction_activity = new Uat_Auction_Activity();
									$activity_data = array(
										'post_parent'	=> $product_id,
										'activity_name'	=> "Placed Bid",
										'activity_type'	=> 'ua_bids',
										'activity_by'	=> $auction_high_current_bider,
									);
									$activity_meta = array(
										'bid_value'	=> $bid,
									);
									$activity_proxy = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
								}
								if ($uat_products_logs == "enable") {
									$uat_auction_activity = new Uat_Auction_Activity();
									$activity_data = array(
										'post_parent'	=> $product_id,
										'activity_name'	=> "Placed Bid",
										'activity_type'	=> 'ua_bids',
										'activity_by'	=> $current_user->ID,
									);
									$activity_meta = array(
										'bid_value'	=> $bid,
									);
									$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
								}

								if($check_is_hold)
								{
									/* current user bid place hold */
									try {
										$hold_status = $Uat_Auction_Payment->hold_payment($bid, $product_id, $current_user->ID, $activity);
										if($hold_status == "1")
										{
											$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
											$hold_status = "";
										}
									} catch (\Exception $th) {
										$hold_status = $th->getMessage();
									}
									/* proxy user bid place hold */
									try {
										$Uat_Auction_Payment->hold_payment($bid, $product_id, $auction_high_current_bider, $activity_proxy);
									} catch (\Exception $th) {
										$th->getMessage();
									}
								}
								if($hold_status == "")
								{
									update_post_meta($product_id, 'woo_ua_auction_current_bid',	$bid);
									update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
									delete_post_meta($product_id, 'woo_ua_auction_current_bid_proxy');
									update_user_meta($current_user->ID, "uwa_samemaxbid_bidmsg_display", "no");
									update_user_meta($current_user->ID, "uwa_samemaxbid_bidmsg_auction", $product_id);
									/* proxy user bid place */
									$this->history_bid($product_id, $auction_high_bid, get_userdata($auction_high_current_bider), 1);
									/* current user bid place */
									$this->history_bid($product_id, $auction_high_bid, get_userdata($current_user->ID), 0);
								}else{
									echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
									return false;
								}
								
							
								$message = "";
								$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
								$message .= __('You\'ve been outbid!', 'ultimate-auction-pro-software');
								$message.= "</div><div class='msgbox-text'>";

								$message .= __('You\'ve been outbid by someone\'s automatic bid. An auto is a great strategy to stay on top. Give it a try!', 'ultimate-auction-pro-software');

								$message.= "</div>";

								echo $message;
								$outbiddeduser = $current_user->ID;
								$check_email = new EmailTracking();
								$email_status = $check_email->duplicate_email_check($auction_id = $product_id, $user_id = $outbiddeduser, $email_type = 'outbid', $amount = $bid);
								if (!$email_status) {
									$uat_Email = new OutBidMail();
									$uat_Email->outbid_email($product_id, $outbiddeduser);
								}
								try {
									$TwilioSMS = new TwilioSMS();
									$TwilioSMS->outbidsms($product_id, $outbiddeduser);
								} catch (\Exception $e) {
									
								}
								try {
									$TwilioWhatsapp = new TwilioWhatsapp();
									$TwilioWhatsapp->outbidsms($product_id, $outbiddeduser);
								} catch (\Exception $e) {
									
								}
								return false;
							} else {
								/* default */
								if($bidtype == "maxbidchange"){

									$message = "";
									$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
									$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
									$message.= "</div><div class='msgbox-text'>";
									$message .= __('Your automatic bid value is equal to an automatic bid already set by one user. Your value should exceed highest automatic bid to get accepted. Please try again.', 'ultimate-auction-pro-software');
									$message.= "</div>";
									echo $message;
								}else{

									$message = "";
									$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
									$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
									$message.= "</div><div class='msgbox-text'>";
									$message .= __('Your amount matches with maximum bidding amount of an user. Kindly check new bid and enter more value.', 'ultimate-auction-pro-software');
									$message.= "</div>";
									echo $message;
								}
								return false;
							}
						} else {
							$proxy_engine = true;
							
						
							if ($bid  == (float)$auction_high_bid) {
								$proxy_bid = $auction_high_bid;
							} else {
								$proxy_bid =  apply_filters('ultimate_woocommerce_auction_proxy_bid_value', $bid + absint($auction_bid_increment), $product_data, $bid);
								if ($proxy_bid > (float)$auction_high_bid)
								$proxy_bid = (float)$auction_high_bid;
							}
							/* current user bid place */
							if ($uat_products_logs == "enable") {
								$uat_auction_activity = new Uat_Auction_Activity();
								$activity_data = array(
									'post_parent'	=> $product_id,
									'activity_name'	=> "Placed Bid",
									'activity_type'	=> 'ua_bids',
									'activity_by'	=> $current_user->ID,
								);
								$activity_meta = array(
									'bid_value'	=> $bid,
								);
								$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
							}
							$hold_status = "";
							$hold_msg = "";
							if($check_is_hold)
							{
								/* current user bid place hold */
								try {
									$hold_status = $Uat_Auction_Payment->hold_payment($bid, $product_id, $current_user->ID, $activity);
									if($hold_status == "1")
									{
										$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
										$hold_status = "";
									}
								} catch (\Exception $th) {
									$hold_status = $th->getMessage();
								}
							}
							if($hold_status == "")
							{
								$this->history_bid($product_id, $bid, $current_user, 0);
							}else{
								echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
								return false;
							}
							/* proxy user bid place */
							$activity = "";
							if ($uat_products_logs == "enable") {
								$uat_auction_activity = new Uat_Auction_Activity();
								$activity_data = array(
									'post_parent'	=> $product_id,
									'activity_name'	=> "Placed Bid Auto",
									'activity_type'	=> 'ua_bids',
									'activity_by'	=> $auction_high_current_bider,
								);
								$activity_meta = array(
									'bid_value'	=> $proxy_bid,
								);
								$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
							}
							
							$hold_auto_error = "";
							
							if($check_is_hold)
							{
								/* proxy user bid place hold */
								try {
									$Uat_Auction_Payment->hold_payment($proxy_bid, $product_id, $auction_high_current_bider, $activity, false);
								} catch (\Exception $th) {
									$hold_auto_error = $th->getMessage();
								}
							}

							if($hold_status == "")
							{
								if($hold_auto_error == "")
								{
									update_post_meta($product_id, 'woo_ua_auction_current_bid', $proxy_bid);
									update_post_meta($product_id, 'woo_ua_auction_current_bid_proxy', 'yes');
									update_post_meta($product_id, 'woo_ua_auction_current_bider', $auction_high_current_bider);
									update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 2);
									$history_bid_id = $this->history_bid($product_id, $proxy_bid, get_userdata($auction_high_current_bider), 1);
								}else{
									update_post_meta($product_id, 'woo_ua_auction_current_bid', $bid);
									update_post_meta($product_id, 'woo_ua_auction_current_bid_proxy', 'no');
									update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
									update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
								}
							}else{
								echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
								return false;
							}
						
							$message = "";
							$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
							$message .= __('You\'ve been outbid!', 'ultimate-auction-pro-software');
							$message.= "</div><div class='msgbox-text'>";

							$message .= __('You\'ve been outbid by someone\'s automatic bid. An auto is a great strategy to stay on top. Give it a try!', 'ultimate-auction-pro-software');

							$message.= "</div>";

							echo $message;
							$outbiddeduser = $current_user->ID;
							$check_email = new EmailTracking();
							$email_status = $check_email->duplicate_email_check($auction_id = $product_id, $user_id = $outbiddeduser, $email_type = 'outbid', $amount = $bid);
							if (!$email_status) {
								$uat_Email = new OutBidMail();
								$uat_Email->outbid_email($product_id, $outbiddeduser);
							}
							try {
								$TwilioSMS = new TwilioSMS();
								$TwilioSMS->outbidsms($product_id, $outbiddeduser);
							} catch (\Exception $e) {
								
							}
							try {
								$TwilioWhatsapp = new TwilioWhatsapp();
								$TwilioWhatsapp->outbidsms($product_id, $outbiddeduser);
							} catch (\Exception $e) {
								
							}
						}
					}
				} else {
					
					if ($uat_products_logs == "enable") {
						$uat_auction_activity = new Uat_Auction_Activity();
						$activity_data = array(
							'post_parent'	=> $product_id,
							'activity_name'	=> "Placed Bid",
							'activity_type'	=> 'ua_bids',
							'activity_by'	=> $current_user->ID,
						);
						$activity_meta = array(
							'bid_value'	=> $bid,
						);
						$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
					}

					$hold_status = "";
					$hold_msg = "";
					
					if($check_is_hold)
					{
						try {
							$hold_status = $Uat_Auction_Payment->hold_payment($bid, $product_id, $current_user->ID, $activity);
							if($hold_status == "1")
							{
								$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
								$hold_status = "";
							}
						} catch (\Exception $th) {
							$hold_status = $th->getMessage();
						}
					}


					if($hold_status == "")
					{
						$outbiddeduser = $auction_current_bider;
						$curent_bid = $product_data->get_uwa_current_bid();
						update_post_meta($product_id, 'woo_ua_auction_current_bid', $bid);
						update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
						update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
						$history_bid_id = $this->history_bid($product_id, $bid, $current_user);

						$message = "";
						$message = "<div class='msgbox-title' id='outbidMsg'>";
						$message .= __('Your bid is on top!', 'ultimate-auction-pro-software');
						$message.= "</div><div class='msgbox-text'>";
						if($hold_msg == "")
						{
							$message .= __('Your bid is placed successfully.', 'ultimate-auction-pro-software').$hold_msg;
						}else{
							$message .= $hold_msg;
						}
						$message.= "</div>";

						// $message = uat_popup_msg($type="success",$title="Your bid is on top!",$msg="Your bid is placed successfully");

						echo $message;
						if($auction_bid_count > 0)
						{

							$this->send_outbid_notifications($product_id,$outbiddeduser, $bid);
							
						}
					}else{
						echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
					}
				}
			} else {

				$message = "";
				$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
				$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
				$message.= "</div><div class='msgbox-text'>";
				$message .= sprintf(__('Please enter a bid value for &quot;%s&quot; greater than the next bid value. Your bid must be at least %s', 'ultimate-auction-pro-software'), $product_data->get_title(), wc_price($product_data->uwa_bid_value(), $args));
				$message.= "</div>";
				exit;

			}
		} else {

			$message = "";
			$message = "<div class=' msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('There was no bid Placed.', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;
			exit;

		}
		do_action('ultimate_auction_theme_place_bid', array('product_id' => $product_id, 'log_id' => $history_bid_id));
		return true;
	}
	/**
	 * Process For Silent Bid
	 *
	 */
	function silent_bidplace_process($product_data, $bid)
	{
		global $wpdb;
		$current_user = wp_get_current_user();
		$product_id = $product_data->get_id();
		$auction_type = $product_data->get_uwa_auction_type();
		$auction_bid_count = $product_data->get_uwa_auction_bid_count();
		$product_base_currency = $product_data->uwa_aelia_get_base_currency();
		$args = array("currency" => $product_base_currency);
		if (($product_data->is_uwa_user_biding($current_user->ID) > 0) && get_option('options_uat_restrict_bidder_enable', 'on') == 'on') {


			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('You already placed bid for this auction.', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;
			exit;

		}
		if ($auction_type == 'normal') {
			$check_is_hold = $this->check_is_hold($product_id);
			if (!empty($product_data->get_uwa_auction_start_price())) {
				if ($product_data->get_uwa_auction_start_price()  > $bid) {

					$message = "";
					$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
					$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
					$message.= "</div><div class='msgbox-text'>";
					$message .= sprintf(__('Your bid is smaller for &quot;%s&quot;.Your bid must be at least %s', 'ultimate-auction-pro-software'), $product_data->get_title(), wc_price($product_data->get_uwa_auction_start_price(), $args));
					$message.= "</div>";
					echo $message;
					exit;

				}
				/* check user bid must be greater than his previous max bid */
				$slient_userid = $current_user->ID;
				/* Select max(bid) from wp_woo_ua_auction_log where userid = 2 and auction_id = 198 */
				$user_max_bid = $wpdb->get_var('SELECT MAX(bid) FROM ' . $wpdb->prefix . 'woo_ua_auction_log  WHERE auction_id = ' . $product_id . ' AND userid = ' . $slient_userid);
				/* echo $user_max_bid; */
				if (!empty($user_max_bid) && $user_max_bid >= $bid) {
					if ($user_max_bid == $bid) {

						$message = "";
						$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
						$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
						$message.= "</div><div class='msgbox-text'>";
						$message .= sprintf(__('Your bid is same as your previous bid %s, Please enter higher bid.', 'ultimate-auction-pro-software'), wc_price($user_max_bid, $args));
						$message.= "</div>";
						echo $message;
						exit;

					} elseif ($user_max_bid > $bid) {

						$message = "";
						$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
						$message .= __('Invalid bid amount', 'ultimate-auction-pro-software');
						$message.= "</div><div class='msgbox-text'>";
						$message .= sprintf(__('Your bid is lower than your previous bid %s, Please enter higher bid.', 'ultimate-auction-pro-software'), wc_price($user_max_bid, $args));
						$message.= "</div>";
						echo $message;
						exit;

					}
				} /* end of if - user_max-bid */
			}
			$activity = "";
			$hold_status = "";
			$hold_msg = "";
			$uat_products_logs = get_option('options_uat_bids_logs', 'enable');
			/* current user bid place */
			if ($uat_products_logs == "enable") {
				$uat_auction_activity = new Uat_Auction_Activity();
				$activity_data = array(
					'post_parent'	=> $product_id,
					'activity_name'	=> "Placed Bid",
					'activity_type'	=> 'ua_bids',
					'activity_by'	=> $current_user->ID,
				);
				$activity_meta = array(
					'bid_value'	=> $bid,
				);
				$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
			}
			if($check_is_hold)
			{
				/* current user bid place hold */
				try {
					$Uat_Auction_Payment = new Uat_Auction_Payment();
					$hold_status = $Uat_Auction_Payment->hold_payment($bid, $product_id, $current_user->ID, $activity);
					if($hold_status == "1")
					{
						$hold_msg = $this->check_is_hold_done($product_id,$current_user->ID);
						$hold_status = "";
					}
				} catch (\Exception $th) {
					$hold_status = $th->getMessage();
				}
			}
			if($hold_status == "")
			{
				if ($bid > (float)$product_data->get_uwa_current_bid()) {
					update_post_meta($product_id, 'woo_ua_auction_current_bid', $bid);
					update_post_meta($product_id, 'woo_ua_auction_current_bider', $current_user->ID);
				}
				update_post_meta($product_id, 'woo_ua_auction_bid_count', (int)$auction_bid_count + 1);
				update_post_meta($product_id, 'woo_ua_auction_last_bid', $bid);
				$history_bid_id = $this->history_bid($product_id, $bid, $current_user);
			}else{
				echo uat_popup_msg($type="error",$title="Something is wrong!",$msg=$hold_status);
				return false;
			}
			
			

			$message = "";
			$message = "<div class='msgbox-title' id='outbidMsg'>";
			$message .= __('Bid placed', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";

			$message .= __('Your bid has been placed successfully.', 'ultimate-auction-pro-software');

			$message.= "</div>";
			echo $message;
		} elseif ($auction_type == 'reverse') {
		} else {

			$message = "";
			$message = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>";
			$message .= __('Invalid bid', 'ultimate-auction-pro-software');
			$message.= "</div><div class='msgbox-text'>";
			$message .= __('There was no bid', 'ultimate-auction-pro-software');
			$message.= "</div>";
			echo $message;

		}
		do_action('ultimate_auction_theme_place_bid', array('product_id' => $product_id));
		return true;
	}
	/**
	 * Adding Bid data to history
	 *
	 * @param string $current_user, int $product_id, $bid, $proxy
	 * @return.
	 *
	 */
	public function history_bid($product_id, $bid, $current_user, $proxy = 0)
	{
		global $wpdb;
		$history_bid_id = false;
		$history_bid = $wpdb->insert($wpdb->prefix . 'woo_ua_auction_log', array('userid' => $current_user->ID, 'auction_id' => $product_id, 'bid' => $bid, 'proxy' => $proxy, 'date' => current_time('mysql')), array('%d', '%d', '%f', '%d', '%s'));
		if ($history_bid) {
			$history_bid_id = $wpdb->insert_id;
		}
		update_auction_json($post_id = $product_id, $bid_amout = $bid, $proxy_ = $proxy, $history_bid_id_ = $history_bid_id);
		save_user_auction_bids($userId = $current_user->ID, $auctionId = $product_id, $bid_amount = $bid, $proxy_ = $proxy, $history_bid_id_ = $history_bid_id);
		do_action('ultimate_auction_theme_after_bid_placed', array('product_id' => $product_id,'bid_user' => $current_user->ID,'bid_amount' => $bid));
		return $history_bid_id;
	}
	/**
	 * Check product has hold amount or not 
	 *
	 * @param string $product_id
	 * @return.
	 *
	 */
	public function check_is_hold($product_id="")
	{
		if(!empty($product_id))
		{
			global $product_data,$wpdb;
			$uat_event_id = get_post_meta( $product_id, 'uat_event_id', true );
			if (!empty($uat_event_id)) {
				/* Event product */
				
					$seting_adhe = get_post_meta($uat_event_id, 'uat_event_auto_debit_hold_enable', true);
					if (!empty($seting_adhe) && $seting_adhe == 'yes') {
						return true;
					}
			
			} else {
				/* Without Event product */
				
					$sp_automatically_debit = get_post_meta($product_id, 'sp_automatically_debit', true);
					if ($sp_automatically_debit == 'yes') {
						return true;
					}
				
			}
		}
		
		return false;
	}
	/**
	 * Check hold amount done in product of user 
	 *
	 * @param string $product_id
	 * @return.
	 *
	 */
	public function check_is_hold_done($product_id="",$user_id="")
	{
		$hold_message = "";
		if(!empty($product_id))
		{
			global $product_data,$wpdb;
			$uat_event_id = get_post_meta( $product_id, 'uat_event_id', true );
			if (!empty($uat_event_id)) {
				/* Event product */
				$sp_automatically_debit = get_post_meta($uat_event_id, 'uat_event_auto_debit_hold_enable', true);
				if ($sp_automatically_debit == 'yes') {
					$hold_type = get_post_meta( $uat_event_id, 'ep_type_automatically_debit_hold_type', true );
					
						$currency = get_woocommerce_currency_symbol();

						$refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE uid='" . $user_id . "' AND  pid='" . $product_id . "' ORDER BY id DESC LIMIT 1");
						if (!empty($refunresult)) {
							if ($hold_type != "stripe_charge_hold_fix_amount") {
								$hold_message = sprintf(__('Your bid has been placed and %s has been held on your card.', 'ultimate-auction-pro-software'), $currency.$refunresult[0]->transaction_amount);
							}
							if ($hold_type == "stripe_charge_hold_fix_amount") {

								$hold_message = sprintf(__('Your bid has been placed and %s has been held on your card.', 'ultimate-auction-pro-software'), $currency.$refunresult[0]->transaction_amount);
								
							}
						}
				}
			}else{
				$sp_automatically_debit = get_post_meta($product_id, 'sp_automatically_debit', true);
				if ($sp_automatically_debit == 'yes') {
					$hold_type = get_post_meta( $product_id, 'sp_type_automatically_debit_hold_type', true );
					
						$currency = get_woocommerce_currency_symbol();

						$refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE uid='" . $user_id . "' AND  pid='" . $product_id . "' ORDER BY id DESC LIMIT 1");
						if (!empty($refunresult)) {
							if ($hold_type != "stripe_charge_hold_fix_amount") {
								$hold_message = sprintf(__('Your bid has been placed and %s has been held on your card.', 'ultimate-auction-pro-software'), $currency.$refunresult[0]->transaction_amount);
							}
							if ($hold_type == "stripe_charge_hold_fix_amount") {

								$hold_message = sprintf(__('Your bid has been placed and %s has been held on your card.', 'ultimate-auction-pro-software'), $currency.$refunresult[0]->transaction_amount);
								
							}
							
						}
				}
			}
		}
		
		return $hold_message;
	}


	/**
	 * check and send outbid email and sms when bid placed
	 *
	 * @param int $product_id
	 * @return true/false.
	 *
	 */
	public function send_outbid_notifications($product_id = 0,$outbiddeduser = 0, $bid = 0)
	{
		global $wpdb;
		$userid = get_current_user_id();
		if($product_id > 0 && $userid > 0 && $outbiddeduser > 0 && $userid != $outbiddeduser )
		{
			$check_email = new EmailTracking();
			$email_status = $check_email->duplicate_email_check($auction_id=$product_id ,$user_id=$outbiddeduser,$email_type='outbid',$amount=$bid);
			if( !$email_status )
			{
				$uat_Email = new OutBidMail();
				$uat_Email->outbid_email($product_id, $outbiddeduser);
			}
			try {
				$TwilioSMS = new TwilioSMS();
				$TwilioSMS->outbidsms($product_id, $outbiddeduser);
			} catch (\Exception $e) {
				$TwilioSMS = new TwilioSMS();
			}
		}

	}

	/**
	 * Check product has autodebit BP on or not 
	 *
	 * @param string $product_id
	 * @return.
	 *
	 */
	public function check_is_bp_autodebit($product_id="")
	{
		if(!empty($product_id))
		{
			$uat_event_id = get_post_meta( $product_id, 'uat_event_id', true );
			if (!empty($uat_event_id)) {
				/* Event product */
				
					/* check for BP Autodebit */
					$uat_enable_buyers_premium_ge = get_option('options_uat_enable_buyers_premium_ge', "");
					if ($uat_enable_buyers_premium_ge == "yes") {
						$uat_event_buyers_premium_type = get_post_meta($uat_event_id, 'uat_event_buyers_premium_type', true);
						if($uat_event_buyers_premium_type == "global"){
							$uat_stripe_buyers_premium_enable_ge = get_option('options_uat_stripe_buyers_premium_enable_ge', "");
							if ($uat_stripe_buyers_premium_enable_ge == "yes") {
								return true;
							}							
						}else{
							$uat_enable_buyers_premium = get_post_meta($uat_event_id, 'uat_enable_buyers_premium', true);
							$uat_stripe_buyers_premium_enable = get_post_meta($uat_event_id, 'uat_stripe_buyers_premium_enable', true);
							if ( $uat_enable_buyers_premium == "yes" && $uat_stripe_buyers_premium_enable == 'yes' ) {
								return true;
							}
						}
					}
					/* check for Bid amount Autodebit */
					$uat_event_auto_debit_hold_enable = get_post_meta($uat_event_id, 'uat_event_auto_debit_hold_enable', true);
					if (!empty($uat_event_auto_debit_hold_enable) && $uat_event_auto_debit_hold_enable == 'no') {
						$uat_auto_debit_options = get_post_meta( $uat_event_id,'uat_auto_debit_options' , true );
						if ($uat_auto_debit_options == 'stripe_charge_type_full' || $uat_auto_debit_options == 'stripe_charge_type_partially') {
							return true;
						}
					}
			
			} else {
				/* Without Event product */

				/* check product BP enabled and autodebit enabled */
				$uat_enable_autodebit_vendor_sp_products = get_option( 'options_uat_enable_autodebit_vendor_sp_products', 'yes' );
                if(uwt_is_vendor_product($product_id) && !empty($uat_enable_autodebit_vendor_sp_products) && $uat_enable_autodebit_vendor_sp_products == 'yes'){
					return true;
				}
				$uat_buyers_premium_type_sp_main = get_post_meta($product_id, 'uat_buyers_premium_type_sp_main', true);
				$uat_enable_buyers_premium_sp = get_option('options_uat_enable_buyers_premium_sp', "");
				if ($uat_enable_buyers_premium_sp == "yes") {
					if ($uat_buyers_premium_type_sp_main == "global") {
						return true;
					}else{
						$sp_buyers_premium = get_post_meta($product_id, 'sp_buyers_premium', true);
						$sp_buyers_premium_auto_debit = get_post_meta($product_id, 'sp_buyers_premium_auto_debit', true);
						if ( $sp_buyers_premium == "yes" && $sp_buyers_premium_auto_debit == 'yes' ) {
							return true;
						}
					}
				}

				/* check product Winning bid autodebit enabled */
				$sp_automatically_debit = get_post_meta($product_id, 'sp_automatically_debit', true);
				if ($sp_automatically_debit == 'no') {						
					$sp_type_automatically_debit = get_post_meta($product_id, 'sp_type_automatically_debit', true);
					if ($sp_type_automatically_debit == 'stripe_charge_type_full' || $sp_type_automatically_debit == 'stripe_charge_type_partially') {
						return true;
					}
				}
			}
		}
		
		return false;
	}
}