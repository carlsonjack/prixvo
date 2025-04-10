<?php

/**
 * Class for order create
 * Uat_Auction_Orders Main class
 */
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
class Uat_Auction_Orders
{
	private $gateway = "";
	private $offline_order_note_text = "";

	public function __construct()
	{
		try {
			$payment = new Uat_Auction_Payment();
			$this->gateway = $payment->gateway;
			$offline_order_note_text_ = __("This offline order needs to be completed with payment outside the website.", 'ultimate-auction-pro-software');
			$offline_order_note = apply_filters('uat_offline_dealing_order_note_text', $offline_order_note_text_);
			$this->offline_order_note_text = $offline_order_note;
		} catch (\Throwable $th) {
			$this->gateway = "";
		}
	}
	public function uat_single_product_order($product_id)
	{
		global $wpdb, $woocommerce, $post, $WCFM;
		$uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
		if (!empty($uat_event_id)) {
			return;
		}
		$order_status =  get_post_meta($product_id, 'order_status', true);
		if (!empty($order_status) && $order_status == 'created') {
			return;
		}
		$order_status_product =  get_post_meta($product_id, 'woo_ua_order_id', true);
		if (!empty($order_status_product)) {
			return;
		}
		$auction_id = $product_id;
		$product = wc_get_product($auction_id);
		$customer_id = $product->get_uwa_auction_current_bider();
		$auction_current_bid = $product->get_uwa_auction_current_bid();
		//$customer_id = 39;
		$expired_auct = $product->get_uwa_auction_expired();
		//$expired_auct = 2;
		$first_name = "";
		$last_name = "";
		$company = "";
		$email = "";
		$add_1 = "";
		$add_2 = "";
		$city = "";
		$state = "";
		$postcode = "";
		$phone = "";
		$cntry_code = "";
		$first_name = get_user_meta($customer_id, 'billing_first_name', true);
		$last_name = get_user_meta($customer_id, 'billing_last_name', true);
		$company = get_user_meta($customer_id, 'billing_company', true);
		$email = get_user_meta($customer_id, 'billing_email', true);
		$add_1 = get_user_meta($customer_id, 'billing_address_1', true);
		$add_2 = get_user_meta($customer_id, 'billing_address_2', true);
		$city = get_user_meta($customer_id, 'billing_city', true);
		$state = get_user_meta($customer_id, 'billing_state', true);
		$postcode = get_user_meta($customer_id, 'billing_postcode', true);
		$phone = get_user_meta($customer_id, 'billing_phone', true);
		$cntry_code = get_user_meta($customer_id, 'billing_country', true);
		$address = array(
			'first_name' => $first_name,
			'last_name'  => $last_name,
			'company'    => $company,
			'email'      => $email,
			'phone'      => $phone,
			'address_1'  => $add_1,
			'address_2'  => $add_2,
			'city'       => $city,
			'state'      => $state,
			'postcode'   => $postcode,
			'country'    => $cntry_code
		);
		$shipping_address = $address;
		$billing_address = $address;
		if (!empty($customer_id) &&  $expired_auct == '2') {
			$order = wc_create_order();
			$order_id = $order->get_id();
			$order->set_customer_id($customer_id);
			$order->set_address($address, 'billing');
			$order->set_address($address, 'shipping');
			$order->update_meta_data('auctions_order', 'Auctions Orders');
			$product = wc_get_product($auction_id);
			$item_id    = $order->add_product($product, 1);
			$line_item  = $order->get_item($item_id, false);
			$calculate_taxes_for = array(
				'country'  => !empty($shipping_address['country']) ? $shipping_address['country'] : $billing_address['country'],
				'state'    => !empty($shipping_address['state']) ? $shipping_address['state'] : $billing_address['state'],
				'postcode' => !empty($shipping_address['postcode']) ? $shipping_address['postcode'] : $billing_address['postcode'],
				'city'     => !empty($shipping_address['city']) ? $shipping_address['city'] : $billing_address['city'],
			);
			$line_item->calculate_taxes($calculate_taxes_for);
			$line_item->save();
			$uat_auto_order_enable = get_option('options_uat_auto_order_enable', 'disable');
			$fix_shipping = get_option('options_uat_fix_shipping', 'disable');
			if ($uat_auto_order_enable === "enable" && $fix_shipping === "enable") {
				$fix_shipping_amount = get_option('options_uat_fix_shipping_amount');
				$fix_shipping_title = get_option('options_uat_fix_shipping_title', 'Fix rate shipping');
				if ($fix_shipping_amount > 0) {
					$shipping_taxes = WC_Tax::calc_shipping_tax($fix_shipping_amount, WC_Tax::get_shipping_tax_rates());
					$rate   = new WC_Shipping_Rate('fix_rate_shipping', $fix_shipping_title, $fix_shipping_amount, $shipping_taxes, 'fix_rate');
					$item   = new WC_Order_Item_Shipping();
					$item->set_props(array(
						'method_title' => $rate->label,
						'method_id'    => $rate->id,
						'total'        => wc_format_decimal($rate->cost),
						'taxes'        => $rate->taxes,
					));
					foreach ($rate->get_meta_data() as $key => $value) {
						$item->add_meta_data($key, $value, true);
					}
					$order->add_item($item);
				}
			}

			$currency = get_woocommerce_currency_symbol();
			$is_autodebit_bp = false;

			$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_hold_fix' ORDER BY `id` DESC";
			$results_ = $wpdb->get_results($query_);
			$stripe_hold = 0;
			if (count($results_) > 0) {
				if (!empty($results_[0]->transaction_amount)) {
					$transaction_amount = $results_[0]->transaction_amount;
					$stripe_hold = $results_[0]->transaction_amount;
					$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='hold_fix_refund' ORDER BY `id` DESC";
					$results_ = $wpdb->get_results($query_);
					if (count($results_) > 0) {
						if (!empty($results_[0]->transaction_amount) && $stripe_hold != 0) {
							$win_amount = $auction_current_bid;
							$win_amount_ = strip_tags(wc_price($auction_current_bid));
							$stripe_hold_ = strip_tags(wc_price($stripe_hold));
							$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $win_amount_, $stripe_hold_);
							if ($auction_current_bid < $results_[0]->transaction_amount) {
								$transaction_amount_ = strip_tags(wc_price($results_[0]->transaction_amount));
								$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
								$release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'), $transaction_amount_, $auction_current_bid_);
								$note .= $release;
							}
							$item_fee = new WC_Order_Item_Fee();
							$item_fee->set_name($note); // Generic fee name
							$item_fee->set_amount(-$win_amount); // Fee amount
							$item_fee->set_tax_class(''); // default for ''
							$item_fee->set_tax_status('none'); // or 'none'
							$item_fee->set_total(-$win_amount); // Fee amount
							$order->add_item($item_fee);
						}
					} else {
						if ($this->gateway == "stripe") {

							$item_fee = new WC_Order_Item_Fee();
							$stripe_hold_ = strip_tags(wc_price($stripe_hold));
							$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
							$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $auction_current_bid_, $stripe_hold_);

							$item_fee->set_name($note); // Generic fee name

							$item_fee->set_amount(-$stripe_hold); // Fee amount
							$item_fee->set_tax_class(''); // default for ''
							$item_fee->set_tax_status('none'); // or 'none'
							$item_fee->set_total(-$stripe_hold); // Fee amount
							$order->add_item($item_fee);
							/*if($auction_current_bid > $stripe_hold)
						{
							$item_fee = new WC_Order_Item_Fee();
							$stripe_hold = $auction_current_bid - $stripe_hold;
							$release = sprintf(__('%s due amount', 'ultimate-auction-pro-software'), $currency.$stripe_hold);
							$note = $release;
							$item_fee->set_name( $note ); // Generic fee name

							$item_fee->set_amount($stripe_hold ); // Fee amount
							$item_fee->set_tax_class( '' ); // default for ''
							$item_fee->set_tax_status( 'none' ); // or 'none'
							$item_fee->set_total( $stripe_hold); // Fee amount
							$order->add_item( $item_fee );
							
						}*/
						}
						if ($this->gateway == "braintree") {
							$UAT_Bid = new UAT_Bid();
							$is_hold = $UAT_Bid->check_is_hold($product_id);
							if ($is_hold) {
								$hold_type = get_post_meta($product_id, 'sp_type_automatically_debit_hold_type', true);
								if ($hold_type == "stripe_charge_hold_fix_amount") {
									$hold_fix_amount = get_post_meta($product_id, 'charge_hold_fix_amount', true);
									$stripe_hold = (float)$hold_fix_amount;
								}
							}
							$item_fee = new WC_Order_Item_Fee();
							$stripe_hold_ = strip_tags(wc_price($stripe_hold));
							$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
							$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $auction_current_bid_, $stripe_hold_);
							if ($auction_current_bid < $stripe_hold) {
								$release_amount = $stripe_hold - $auction_current_bid;
								$release_amount_ = strip_tags(wc_price($release_amount));
								$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
								$release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'), $release_amount_, $auction_current_bid_);
								$note .= $release;
							}
							$item_fee->set_name($note); // Generic fee name

							$item_fee->set_amount(-$stripe_hold); // Fee amount
							$item_fee->set_tax_class(''); // default for ''
							$item_fee->set_tax_status('none'); // or 'none'
							$item_fee->set_total(-$stripe_hold); // Fee amount
							$order->add_item($item_fee);
						}
					}
				}
			}


			$strip_payment_amount = 0;
			$transaction_amount = 0;
			$buyers_premium_rs = 0;
			$query   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_bid' ORDER BY `id` DESC";
			$results = $wpdb->get_results($query);
			if (count($results) > 0) {
				$strip_payment_amount += $results[0]->transaction_amount;
				$transaction_amount = $results[0]->transaction_amount;
				if (uwt_get_buyer_premium_enabled_for_bidding($product_id)) {
					$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
					$results_bp = $wpdb->get_results($query_bp);
					$buyers_premium_rs = '';
					if (count($results_bp) > 0) {
						// $strip_payment_amount +=$results_bp[0]->transaction_amount;
						$transaction_amount += $results_bp[0]->transaction_amount;
						$buyers_premium_rs = $results_bp[0]->transaction_amount;
					}

					if (!empty($buyers_premium_rs)) {
						$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
						$bp_item_id = wc_add_order_item($order_id, array(
							'order_item_name' => $bp_text,
							'order_item_type' => 'fee',
						));
						$is_autodebit_bp = true;

						wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
						wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
						$auto_bp_text = __("Auto debit of buyer's premium", "ultimate-auction-pro-software");
						$bp_item_id_ = wc_add_order_item($order_id, array(
							'order_item_name' => $auto_bp_text,
							'order_item_type' => 'fee',
						));
						$is_autodebit_bp = true;
						wc_add_order_item_meta($bp_item_id_, '_fee_amount', $buyers_premium_rs, true);
						wc_add_order_item_meta($bp_item_id_, '_line_total', -$buyers_premium_rs, true);
					}
				}
				if (!empty($strip_payment_amount)) {
					$help_amt_text = __("Amount held and auto debited", "ultimate-auction-pro-software");
					$ad_item_id = wc_add_order_item($order_id, array(
						'order_item_name' => $help_amt_text,
						'order_item_type' => 'fee',
					));
					wc_add_order_item_meta($ad_item_id, '_fee_amount', $strip_payment_amount, true);
					wc_add_order_item_meta($ad_item_id, '_line_total', -$strip_payment_amount, true);
				}
			} else {
				if (uwt_get_buyer_premium_enabled_for_bidding($product_id)) {
					$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
					$results_bp = $wpdb->get_results($query_bp);
					if (count($results_bp) > 0) {
						// $strip_payment_amount +=$results_bp[0]->transaction_amount;
						$transaction_amount += $results_bp[0]->transaction_amount;
						$buyers_premium_rs = $results_bp[0]->transaction_amount;
						if (!empty($buyers_premium_rs)) {
							$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
							$bp_item_id = wc_add_order_item($order_id, array(
								'order_item_name' => $bp_text,
								'order_item_type' => 'fee',
							));
							$is_autodebit_bp = true;
							wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
							wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
							$auto_bp_text = __("Auto debit of buyer's premium", "ultimate-auction-pro-software");
							$bp_item_id_ = wc_add_order_item($order_id, array(
								'order_item_name' => $auto_bp_text,
								'order_item_type' => 'fee',
							));
							$is_autodebit_bp = true;
							wc_add_order_item_meta($bp_item_id_, '_fee_amount', $buyers_premium_rs, true);
							wc_add_order_item_meta($bp_item_id_, '_line_total', -$buyers_premium_rs, true);
						}
					}
				}

				$query_ad   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='uat_partially_bid_amount_type' and status='succeeded' ORDER BY `id` DESC";
				$results_ad = $wpdb->get_results($query_ad);
				if (count($results_ad) > 0) {
					$strip_payment_amount += $results_ad[0]->transaction_amount;
				}
				$query_adfull   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='" . $this->gateway . "_charge_type_full' and status='succeeded' ORDER BY `id` DESC";
				$results_adfull = $wpdb->get_results($query_adfull);
				if (count($results_adfull) > 0) {
					$strip_payment_amount += $results_adfull[0]->transaction_amount;
				}
				if (!empty($strip_payment_amount)) {
					$auto_text = __("Auto Debit", "ultimate-auction-pro-software");
					$ad_item_id = wc_add_order_item($order_id, array(
						'order_item_name' => $auto_text,
						'order_item_type' => 'fee',
					));
					wc_add_order_item_meta($ad_item_id, '_fee_amount', $strip_payment_amount, true);
					wc_add_order_item_meta($ad_item_id, '_line_total', -$strip_payment_amount, true);
				}
			}

			/** add buyers premium for vendor product */

			if (uwt_is_vendor_product($product_id) && $is_autodebit_bp == false) {
				$uwt_get_buyer_premium__globle_value_wcfm = uwt_get_buyer_premium__globle_value_wcfm($auction_current_bid);
				if (!empty($uwt_get_buyer_premium__globle_value_wcfm) && $uwt_get_buyer_premium__globle_value_wcfm > 0) {
					$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
					$bp_item_id = wc_add_order_item($order_id, array(
						'order_item_name' => $bp_text,
						'order_item_type' => 'fee',
					));
					$buyers_premium_rs = $uwt_get_buyer_premium__globle_value_wcfm;
					wc_add_order_item_meta($bp_item_id, '_fee_amount', $uwt_get_buyer_premium__globle_value_wcfm, true);
					wc_add_order_item_meta($bp_item_id, '_line_total', $uwt_get_buyer_premium__globle_value_wcfm, true);
				}
			} else {
				if (uwt_get_buyer_premium_enabled_for_bidding($product_id)) {
					$sp_buyers_premium_auto_debit =  get_post_meta($product_id, 'sp_buyers_premium_auto_debit', true);
					if ($sp_buyers_premium_auto_debit != "yes" && $is_autodebit_bp == false) {

						$buyers_premium_rs = '0';
						$uat_buyers_premium_amount = get_post_meta($product_id, 'sp_buyers_premium_fee_amt', true);
						$uat_buyers_premium_type =  get_post_meta($product_id, 'sp_buyers_premium_type', true);
						if ($uat_buyers_premium_type == 'percentage') {
							$uwa_buyer_price = ($auction_current_bid * $uat_buyers_premium_amount) / 100;
							/* calculations for min max buyers premium */
							$uwa_bpm_min_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_min', true);
							$uwa_bpm_max_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_max', true);
							$min_val = $uwa_bpm_min_val;
							$max_val = $uwa_bpm_max_val;
							if ($min_val > 0) {
								if ($uwa_buyer_price < $min_val) {
									$uwa_buyer_price = $min_val;
								}
							}
							if ($max_val > 0) {
								if ($uwa_buyer_price > $max_val) {
									$uwa_buyer_price = $max_val;
								}
							}
						} else {
							$uwa_buyer_price = $uat_buyers_premium_amount;
						}
						if (!empty($uwa_buyer_price)) {
							$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
							$bp_item_id = wc_add_order_item($order_id, array(
								'order_item_name' => $bp_text,
								'order_item_type' => 'fee',
							));
							$buyers_premium_rs = $uwa_buyer_price;
							wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
							wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
						}
					}
				}
			}

			$newTotal = $order->calculate_totals();
			$order->set_total($newTotal);
			$uat_enable_offline_dealing_for_buyer_seller = get_option('options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller', "0");
			if ($uat_enable_offline_dealing_for_buyer_seller == '1') {
				// Add a note to offline dealing the order
				$order->add_order_note($this->offline_order_note_text);
				$order->set_customer_note($this->offline_order_note_text);
				$order->update_status('processing');
				// Add order meta to offline dealing 
				$meta_key = 'uat_offline_dealing_order';
				$meta_value = 'yes';
				$order->update_meta_data($meta_key, $meta_value);
			}
			update_post_meta($product_id, 'order_status', 'created');
			update_post_meta($product_id, 'woo_ua_order_id', $order_id);
			$order->update_meta_data('p_p_id', $product_id);
			$order->save();
		}
		$out_of_stock_staus = 'outofstock';

		// 1. Updating the stock quantity
		// update_post_meta($product_id, '_stock', 0);
		// 2. Updating the stock quantity
		// update_post_meta( $product_id, '_stock_status', wc_clean( $out_of_stock_staus ) );

		// 3. Updating post term relationship
		// wp_set_post_terms( $product_id, 'outofstock', 'product_visibility', true );

		// And finally (optionally if needed)
		wc_delete_product_transients($product_id); // Clear/refresh the variation cache
	}

	public function uat_event_order_process($event_id, $product_ids)
	{
		global $wpdb;
		$uat_event_order_process =  get_post_meta($event_id, 'uat_event_order_process', true);
		if ($uat_event_order_process == 'completed') {
			return false;
		}
		/* genrate list by user products and process order */
		$event_orders = [];
		foreach ($product_ids as $product_id) {
			$winner_user = get_post_meta($product_id, 'woo_ua_auction_current_bider', true);
			$event_orders[$winner_user][] = $product_id;
		}

		if (count($event_orders) > 0) {
			$event_order_ids = [];
			foreach ($event_orders as $user => $products) {
				/* create order */
				// $order = wc_create_order();
				// $order_id = $order->get_id();

				// $order->set_customer_id($user);
				$customer_id = $user;

				$first_name = "";
				$last_name = "";
				$company = "";
				$email = "";
				$add_1 = "";
				$add_2 = "";
				$city = "";
				$state = "";
				$postcode = "";
				$phone = "";
				$cntry_code = "";
				$first_name = get_user_meta($customer_id, 'billing_first_name', true);
				$last_name = get_user_meta($customer_id, 'billing_last_name', true);
				$company = get_user_meta($customer_id, 'billing_company', true);
				$email = get_user_meta($customer_id, 'billing_email', true);
				$add_1 = get_user_meta($customer_id, 'billing_address_1', true);
				$add_2 = get_user_meta($customer_id, 'billing_address_2', true);
				$city = get_user_meta($customer_id, 'billing_city', true);
				$state = get_user_meta($customer_id, 'billing_state', true);
				$postcode = get_user_meta($customer_id, 'billing_postcode', true);
				$phone = get_user_meta($customer_id, 'billing_phone', true);
				$cntry_code = get_user_meta($customer_id, 'billing_country', true);
				$address = array(
					'first_name' => $first_name,
					'last_name'  => $last_name,
					'company'    => $company,
					'email'      => $email,
					'phone'      => $phone,
					'address_1'  => $add_1,
					'address_2'  => $add_2,
					'city'       => $city,
					'state'      => $state,
					'postcode'   => $postcode,
					'country'    => $cntry_code
				);
				$shipping_address = $address;
				$billing_address = $address;

				$order = wc_create_order();
				$order_id = $order->get_id();
				$event_order_ids[] = $order_id;
				$order->set_customer_id($customer_id);
				$order->set_address($address, 'billing');
				$order->set_address($address, 'shipping');
				$order->update_meta_data('auctions_order', 'Auctions Orders');


				$order->update_meta_data('auctions_order', 'Auctions Orders');
				/* add products to order */
				$strip_payment_amount_grand = 0;
				$order_products = [];

				foreach ($products as $product_id) {
					$product = wc_get_product($product_id);
					$auction_current_bid = $product->get_uwa_auction_current_bid();

					$customer_id = $product->get_uwa_auction_current_bider();
					$auction_current_bid = $product->get_uwa_auction_current_bid();
					$expired_auct = $product->get_uwa_auction_expired();
					if (!empty($customer_id) &&  $expired_auct == '2') {
						$order_products[] = $product_id;
						$item_id    = $order->add_product($product, 1);
						$line_item  = $order->get_item($item_id, false);
						$calculate_taxes_for = array(
							'country'  => !empty($shipping_address['country']) ? $shipping_address['country'] : $billing_address['country'],
							'state'    => !empty($shipping_address['state']) ? $shipping_address['state'] : $billing_address['state'],
							'postcode' => !empty($shipping_address['postcode']) ? $shipping_address['postcode'] : $billing_address['postcode'],
							'city'     => !empty($shipping_address['city']) ? $shipping_address['city'] : $billing_address['city'],
						);
						$line_item->calculate_taxes($calculate_taxes_for);
						$line_item->save();

						$product_nm = $product->get_title();

						$currency = get_woocommerce_currency_symbol();
						$is_autodebit_bp = false;

						$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_hold_fix' ORDER BY `id` DESC";
						$results_ = $wpdb->get_results($query_);
						$stripe_hold = 0;
						if (count($results_) > 0) {
							if (!empty($results_[0]->transaction_amount)) {
								$transaction_amount = $results_[0]->transaction_amount;
								$stripe_hold = $results_[0]->transaction_amount;
								$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='hold_fix_refund' ORDER BY `id` DESC";
								$results_ = $wpdb->get_results($query_);
								if (count($results_) > 0) {
									if (!empty($results_[0]->transaction_amount) && $stripe_hold != 0) {
										$win_amount = $auction_current_bid;
										$win_amount_ = strip_tags(wc_price($auction_current_bid));
										$stripe_hold_ = strip_tags(wc_price($stripe_hold));
										$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $win_amount_, $stripe_hold_);
										if ($auction_current_bid < $results_[0]->transaction_amount) {
											$transaction_amount_ = strip_tags(wc_price($results_[0]->transaction_amount));
											$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
											$release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'), $transaction_amount_, $auction_current_bid_);
											$note .= $release;
										}

										$item_fee = new WC_Order_Item_Fee();
										$item_fee->set_name($note); // Generic fee name
										$item_fee->set_amount(-$win_amount); // Fee amount
										$item_fee->set_tax_class(''); // default for ''
										$item_fee->set_tax_status('none'); // or 'none'
										$item_fee->set_total(-$win_amount); // Fee amount
										$order->add_item($item_fee);
									}
								} else {
									if ($this->gateway == "stripe") {

										$item_fee = new WC_Order_Item_Fee();
										$stripe_hold_ = strip_tags(wc_price($stripe_hold));
										$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
										$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $auction_current_bid_, $stripe_hold_);

										$item_fee->set_name($note); // Generic fee name

										$item_fee->set_amount(-$stripe_hold); // Fee amount
										$item_fee->set_tax_class(''); // default for ''
										$item_fee->set_tax_status('none'); // or 'none'
										$item_fee->set_total(-$stripe_hold); // Fee amount
										$order->add_item($item_fee);

										/*if($auction_current_bid > $stripe_hold)
										{
											$item_fee = new WC_Order_Item_Fee();
											$stripe_hold = $auction_current_bid - $stripe_hold;
											$release = $product_nm.' : '.sprintf(__('%s due amount', 'ultimate-auction-pro-software'), $currency.$stripe_hold);
											$note = $release;
											$item_fee->set_name( $note ); // Generic fee name

											$item_fee->set_amount($stripe_hold ); // Fee amount
											$item_fee->set_tax_class( '' ); // default for ''
											$item_fee->set_tax_status( 'none' ); // or 'none'
											$item_fee->set_total( $stripe_hold); // Fee amount
											$order->add_item( $item_fee );
											
										}*/
									}
									if ($this->gateway == "braintree") {
										$UAT_Bid = new UAT_Bid();
										$is_hold = $UAT_Bid->check_is_hold($product_id);
										if ($is_hold) {
											$hold_type = get_post_meta($product_id, 'sp_type_automatically_debit_hold_type', true);
											if ($hold_type == "stripe_charge_hold_fix_amount") {
												$hold_fix_amount = get_post_meta($product_id, 'charge_hold_fix_amount', true);
												$stripe_hold = (float)$hold_fix_amount;
											}
										}
										$item_fee = new WC_Order_Item_Fee();
										$stripe_hold_ = strip_tags(wc_price($stripe_hold));
										$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
										$note = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'), $auction_current_bid_, $stripe_hold_);
										if ($auction_current_bid < $stripe_hold) {
											$release_amount = $stripe_hold - $auction_current_bid;
											$release_amount_ = strip_tags(wc_price($release_amount));
											$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
											$release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'), $release_amount_, $auction_current_bid_);
											$note .= $release;
										}
										$item_fee->set_name($note); // Generic fee name

										$item_fee->set_amount(-$stripe_hold); // Fee amount
										$item_fee->set_tax_class(''); // default for ''
										$item_fee->set_tax_status('none'); // or 'none'
										$item_fee->set_total(-$stripe_hold); // Fee amount
										$order->add_item($item_fee);
									}
								}
							}
						}


						$strip_payment_amount = 0;
						$transaction_amount = 0;
						$buyers_premium_rs = 0;
						$query   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_bid' ORDER BY `id` DESC";
						$results = $wpdb->get_results($query);
						if (count($results) > 0) {
							$strip_payment_amount += $results[0]->transaction_amount;
							$transaction_amount = $results[0]->transaction_amount;
							if (uwt_get_event_buyer_premium_enabled_for_bidding($event_id)) {
								$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
								$results_bp = $wpdb->get_results($query_bp);
								$buyers_premium_rs = '';
								if (count($results_bp) > 0) {
									// $strip_payment_amount +=$results_bp[0]->transaction_amount;
									$transaction_amount += $results_bp[0]->transaction_amount;
									$buyers_premium_rs = $results_bp[0]->transaction_amount;
								}
								if (!empty($buyers_premium_rs)) {
									$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
									$bp_item_id = wc_add_order_item($order_id, array(
										'order_item_name' => $product_nm . " : " . $bp_text,
										'order_item_type' => 'fee',
									));
									$is_autodebit_bp = true;

									wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
									wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
									$auto_bp_text = __("Auto debit of buyer's premium", "ultimate-auction-pro-software");
									$bp_item_id_ = wc_add_order_item($order_id, array(
										'order_item_name' => $product_nm . " : " . $auto_bp_text,
										'order_item_type' => 'fee',
									));
									$is_autodebit_bp = true;
									wc_add_order_item_meta($bp_item_id_, '_fee_amount', $buyers_premium_rs, true);
									wc_add_order_item_meta($bp_item_id_, '_line_total', -$buyers_premium_rs, true);
								}
							}

							if (!empty($strip_payment_amount)) {
								$help_amt_text = __("Amount held and auto debited", "ultimate-auction-pro-software");
								$ad_item_id = wc_add_order_item($order_id, array(
									'order_item_name' => $product_nm . " : " . $help_amt_text,
									'order_item_type' => 'fee',
								));
								wc_add_order_item_meta($ad_item_id, '_fee_amount', $strip_payment_amount, true);
								wc_add_order_item_meta($ad_item_id, '_line_total', -$strip_payment_amount, true);
							}
						} else {
							if (uwt_get_event_buyer_premium_enabled_for_bidding($event_id)) {
								$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
								$results_bp = $wpdb->get_results($query_bp);
								if (count($results_bp) > 0) {
									// $strip_payment_amount +=$results_bp[0]->transaction_amount;
									$transaction_amount += $results_bp[0]->transaction_amount;
									$buyers_premium_rs = $results_bp[0]->transaction_amount;
									if (!empty($buyers_premium_rs)) {
										$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
										$bp_item_id = wc_add_order_item($order_id, array(
											'order_item_name' => $product_nm . " : " . $bp_text,
											'order_item_type' => 'fee',
										));
										$is_autodebit_bp = true;
										wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
										wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
										$auto_bp_text = __("Auto debit of buyer's premium", "ultimate-auction-pro-software");
										$bp_item_id_ = wc_add_order_item($order_id, array(
											'order_item_name' => $product_nm . " : " . $auto_bp_text,
											'order_item_type' => 'fee',
										));
										$is_autodebit_bp = true;
										wc_add_order_item_meta($bp_item_id_, '_fee_amount', $buyers_premium_rs, true);
										wc_add_order_item_meta($bp_item_id_, '_line_total', -$buyers_premium_rs, true);
									}
								}
							}
							$query_ad   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='uat_partially_bid_amount_type' and status='succeeded' ORDER BY `id` DESC";
							$results_ad = $wpdb->get_results($query_ad);
							if (count($results_ad) > 0) {
								$strip_payment_amount += $results_ad[0]->transaction_amount;
							}
							$query_adfull   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='" . $this->gateway . "_charge_type_full' and status='succeeded' ORDER BY `id` DESC";
							$results_adfull = $wpdb->get_results($query_adfull);
							if (count($results_adfull) > 0) {
								$strip_payment_amount += $results_adfull[0]->transaction_amount;
							}
							if (!empty($strip_payment_amount)) {
								$auto_text = __("Auto Debit", "ultimate-auction-pro-software");
								$ad_item_id = wc_add_order_item($order_id, array(

									'order_item_name' => $product_nm . " : " . $auto_text,

									'order_item_type' => 'fee',
								));
								wc_add_order_item_meta($ad_item_id, '_fee_amount', $strip_payment_amount, true);
								wc_add_order_item_meta($ad_item_id, '_line_total', -$strip_payment_amount, true);
								// $strip_payment_amount_grand +=$strip_payment_amount;
							}
						}

						/** add buyers premium for without autodebit */
						$bp_auto_debit = false;
						$bp_enabled = 'no';
						$uat_enable_buyers_premium_ge = get_option('options_uat_enable_buyers_premium_ge', "");
						if ($uat_enable_buyers_premium_ge == "yes" && uwt_get_event_buyer_premium_enabled_for_bidding($event_id)) {
							$uat_event_buyers_premium_type = get_post_meta($event_id, 'uat_event_buyers_premium_type', true);
							$uat_enable_bp_for_bidding_ge = get_option('options_uat_enable_bp_for_bidding_ge', "");
							if ($uat_event_buyers_premium_type == "global" && $uat_enable_bp_for_bidding_ge == "yes") {
								$bp_enabled = 'yes';
								$uat_stripe_buyers_premium_enable_ge = get_option('options_uat_stripe_buyers_premium_enable_ge', "");
								if ($uat_stripe_buyers_premium_enable_ge == "yes") {
									$bp_auto_debit = true;
								}
							} else {
								$uat_enable_buyers_premium = get_post_meta($event_id, 'uat_enable_buyers_premium', true);
								$uat_enable_buyers_premium_bidding = get_post_meta($event_id, 'uat_enable_buyers_premium_bidding', true);
								if ($uat_enable_buyers_premium == "yes" && $uat_enable_buyers_premium_bidding == 'yes') {
									$bp_enabled = 'yes';
									$uat_stripe_buyers_premium_enable = get_post_meta($event_id, 'uat_stripe_buyers_premium_enable', true);
									if ($uat_stripe_buyers_premium_enable == 'yes') {
										$bp_auto_debit = true;
									}
								}
							}
						}

						if ($bp_enabled == "yes" && $bp_auto_debit == false) {

							$buyers_premium_rs = '0';
							$auction_current_bid = $product->get_uwa_auction_current_bid();
							$uwa_buyer_price = uat_buyer_premium_value_event_products($event_id, $auction_current_bid);

							if (!empty($uwa_buyer_price)) {
								$bp_text = __("Buyer's Premium Amount", "ultimate-auction-pro-software");
								$bp_item_id = wc_add_order_item($order_id, array(
									'order_item_name' => $product_nm . " : " . $bp_text,
									'order_item_type' => 'fee',
								));
								$buyers_premium_rs = $uwa_buyer_price;
								wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
								wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
							}
						}
						update_post_meta($product_id, 'order_status', 'created');
						update_post_meta($product_id, 'woo_ua_order_id', $order_id);
						$out_of_stock_staus = 'outofstock';

						// 1. Updating the stock quantity
						// update_post_meta($product_id, '_stock', 0);

						$order->update_meta_data('p_p_id',  $product_id);

						// update_post_meta($order_id, 'p_p_id', $product_id);

						// 2. Updating the stock quantity
						// update_post_meta( $product_id, '_stock_status', wc_clean( $out_of_stock_staus ) );

						// 3. Updating post term relationship
						// wp_set_post_terms( $product_id, 'outofstock', 'product_visibility', true );

						// And finally (optionally if needed)
						wc_delete_product_transients($product_id);
					}
				}
				if (empty($order_products)) {
					wp_delete_post($order_id, true);
				}


				$uat_auto_order_enable = get_option('options_uat_auto_order_enable', 'disable');
				$fix_shipping = get_option('options_uat_fix_shipping', 'disable');
				if ($uat_auto_order_enable === "enable" && $fix_shipping === "enable") {
					$fix_shipping_amount = get_option('options_uat_fix_shipping_amount');
					$fix_shipping_title = get_option('options_uat_fix_shipping_title', 'Fix rate shipping');
					if ($fix_shipping_amount > 0) {
						$shipping_taxes = WC_Tax::calc_shipping_tax($fix_shipping_amount, WC_Tax::get_shipping_tax_rates());
						$rate   = new WC_Shipping_Rate('fix_rate_shipping', $fix_shipping_title, $fix_shipping_amount, $shipping_taxes, 'fix_rate');
						$item   = new WC_Order_Item_Shipping();
						$item->set_props(array(
							'method_title' => $rate->label,
							'method_id'    => $rate->id,
							'total'        => wc_format_decimal($rate->cost),
							'taxes'        => $rate->taxes,
						));
						foreach ($rate->get_meta_data() as $key => $value) {
							$item->add_meta_data($key, $value, true);
						}
						$order->add_item($item);
					}
				}

				// if(!empty($strip_payment_amount_grand)){
				// 	$ad_item_id = wc_add_order_item( $order_id, array(

				// 		'order_item_name' => "Auto Debit",

				// 		'order_item_type' => 'fee',
				// 	));
				// 	wc_add_order_item_meta( $ad_item_id, '_fee_amount', $strip_payment_amount_grand, true );
				// 	wc_add_order_item_meta( $ad_item_id, '_line_total', -$strip_payment_amount_grand, true );
				// }

				$newTotal = $order->calculate_totals();
				$order->set_total($newTotal);
				$uat_enable_offline_dealing_for_buyer_seller = get_option('options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller', "0");
				if ($uat_enable_offline_dealing_for_buyer_seller == '1') {
					// Add a note to offline dealing the order
					$order->add_order_note($this->offline_order_note_text);
					$order->set_customer_note($this->offline_order_note_text);
					$order->update_status('processing');
					// Add order meta to offline dealing 
					$meta_key = 'uat_offline_dealing_order';
					$meta_value = 'yes';
					// update_post_meta($order_id, $meta_key, $meta_value);
					$order->update_meta_data($meta_key, $meta_value);
				}
				$order->save();
			}
			update_post_meta($event_id, 'uat_event_order_ids', $event_order_ids);
		}
		update_post_meta($event_id, 'uat_event_order_process', 'completed');
	}
	public function uat_event_order($event_id)
	{
		return false;
		global $wpdb, $woocommerce, $post, $WCFM;
		$order_status =  get_post_meta($event_id, 'order_status', true);
		if (!empty($order_status) && $order_status == 'created') {
			return;
		}
		if (empty($event_id)) {
			return;
		}
		$query   = "SELECT * FROM  `" . $wpdb->prefix . "ua_auction_events` where post_id=" . $event_id . " ";
		$results = $wpdb->get_results($query);
		$order_event_user_arr = array();
		$order_event_ids_arr = array();
		$user_arr = array();
		$product_arr = array();
		$product_arr2 = array();
		foreach ($results as $row) {
			$event_products_ids = $row->event_products_ids;
			$products_ids_arr = unserialize($event_products_ids);
			if (!empty($products_ids_arr) && count($products_ids_arr) > 0) {
				foreach ($products_ids_arr as $product_id) {
					$product = wc_get_product($product_id);
					$win_user_id = $product->get_uwa_auction_current_bider();
					$product_arr[$win_user_id][] = $product_id;
				}
			}
		}
		update_post_meta($event_id, 'order_status', 'created');
		$currency = get_woocommerce_currency_symbol();
		$this->gateway = $this->gateway;

		foreach ($product_arr as $userid => $user_product) {


			$first_name = "";
			$last_name = "";
			$company = "";
			$email = "";
			$add_1 = "";
			$add_2 = "";
			$city = "";
			$state = "";
			$postcode = "";
			$phone = "";
			$cntry_code = "";
			$customer_id = $userid;
			$first_name = get_user_meta($customer_id, 'billing_first_name', true);
			$last_name = get_user_meta($customer_id, 'billing_last_name', true);
			$company = get_user_meta($customer_id, 'billing_company', true);
			$email = get_user_meta($customer_id, 'billing_email', true);
			$add_1 = get_user_meta($customer_id, 'billing_address_1', true);
			$add_2 = get_user_meta($customer_id, 'billing_address_2', true);
			$city = get_user_meta($customer_id, 'billing_city', true);
			$state = get_user_meta($customer_id, 'billing_state', true);
			$postcode = get_user_meta($customer_id, 'billing_postcode', true);
			$phone = get_user_meta($customer_id, 'billing_phone', true);
			$cntry_code = get_user_meta($customer_id, 'billing_country', true);
			$address = array(
				'first_name' => $first_name,
				'last_name'  => $last_name,
				'company'    => $company,
				'email'      => $email,
				'phone'      => $phone,
				'address_1'  => $add_1,
				'address_2'  => $add_2,
				'city'       => $city,
				'state'      => $state,
				'postcode'   => $postcode,
				'country'    => $cntry_code
			);
			$shipping_address = $address;
			$billing_address = $address;

			$order = wc_create_order();
			$order_id = $order->get_id();
			$order->set_customer_id($customer_id);
			$order->set_address($address, 'billing');
			$order->set_address($address, 'shipping');
			$order->update_meta_data('auctions_order', 'Auctions Orders');
			$strip_payment_amount_grand = 0;


			foreach ($user_product as $pid) {
				$product_id = $pid;
				$order_status_product =  get_post_meta($product_id, 'woo_ua_order_id', true);
				// if(!empty($order_status_product)){
				// 	continue;
				// }

				$product = wc_get_product($pid);
				$product_nm = $product->get_title();
				$item_id    = $order->add_product($product, 1);

				$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_hold_fix' ORDER BY `id` DESC";
				$results_ = $wpdb->get_results($query_);
				$stripe_hold = 0;
				if (count($results_) > 0) {
					if (!empty($results_[0]->transaction_amount)) {
						$transaction_amount = $results_[0]->transaction_amount;
						$stripe_hold = $results_[0]->transaction_amount;
						$query_   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='hold_fix_refund' ORDER BY `id` DESC";
						$results_ = $wpdb->get_results($query_);
						$auction_current_bid = get_post_meta($product_id, 'woo_ua_auction_current_bid', true);
						if (count($results_) > 0) {
							if (!empty($results_[0]->transaction_amount)) {
								$currency = get_woocommerce_currency_symbol();
								$note = sprintf(__('Amount held was %s. Winning Bid Amount was %s. ', 'ultimate-auction-pro-software'), $currency . $stripe_hold, $currency . $auction_current_bid);
								if ($auction_current_bid < $results_[0]->transaction_amount) {
									$release = sprintf(__('%s will be released', 'ultimate-auction-pro-software'), $currency . $results_[0]->transaction_amount);
									$note .= $release;
								}
								$item_fee = new WC_Order_Item_Fee();
								$item_fee->set_name($note); // Generic fee name
								$item_fee->set_amount(-$auction_current_bid); // Fee amount
								$item_fee->set_tax_class(''); // default for ''
								$item_fee->set_tax_status('none'); // or 'none'
								$item_fee->set_total(-$auction_current_bid); // Fee amount
								$order->add_item($item_fee);

								// $order->add_order_note( $note );
							}
						} else {


							if ($this->gateway == "stripe") {

								$item_fee = new WC_Order_Item_Fee();
								$note = sprintf(__('Amount held was %s. Winning Bid Amount was %s. ', 'ultimate-auction-pro-software'), $currency . $stripe_hold, $currency . $auction_current_bid);

								$item_fee->set_name($note); // Generic fee name

								$item_fee->set_amount(-$stripe_hold); // Fee amount
								$item_fee->set_tax_class(''); // default for ''
								$item_fee->set_tax_status('none'); // or 'none'
								$item_fee->set_total(-$stripe_hold); // Fee amount
								$order->add_item($item_fee);
							}
							if ($this->gateway == "braintree") {
								$UAT_Bid = new UAT_Bid();
								$is_hold = $UAT_Bid->check_is_hold($product_id);
								if ($is_hold) {
									$uat_event_id = get_post_meta($product_id, 'uat_event_id', true);

									$hold_type = get_post_meta($uat_event_id, 'ep_type_automatically_debit_hold_type', true);
									if ($hold_type == "ep_stripe_charge_type_fixed") {
										$hold_fix_amount = get_post_meta($uat_event_id, 'ep_stripe_charge_type_fixed_amount', true);
										$stripe_hold = (float)$hold_fix_amount;
									}
								}
								$item_fee = new WC_Order_Item_Fee();
								$note = sprintf(__('Amount held was %s. Winning Bid Amount was %s. ', 'ultimate-auction-pro-software'), $currency . $stripe_hold, $currency . $auction_current_bid);
								if ($auction_current_bid < $stripe_hold) {
									$release_amount = $stripe_hold - $auction_current_bid;
									$release = sprintf(__('%s will be released', 'ultimate-auction-pro-software'), $currency . $release_amount);
									$note .= $release;
								}
								$item_fee->set_name($note); // Generic fee name

								$item_fee->set_amount(-$stripe_hold); // Fee amount
								$item_fee->set_tax_class(''); // default for ''
								$item_fee->set_tax_status('none'); // or 'none'
								$item_fee->set_total(-$stripe_hold); // Fee amount
								$order->add_item($item_fee);
							}
						}
					}
				}

				$query   = "SELECT * FROM `" . $wpdb->prefix . "auction_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and status='retrieved_bid' ORDER BY `id` DESC";
				$results = $wpdb->get_results($query);
				$strip_payment_amount = 0;
				$transaction_amount = 0;
				$buyers_premium_rs = 0;
				if (count($results) > 0) {
					$strip_payment_amount += $results[0]->transaction_amount;
					$transaction_amount = $results[0]->transaction_amount;
					$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
					$results_bp = $wpdb->get_results($query_bp);
					//print_r($results_bp);
					$buyers_premium_rs = '';
					if (count($results_bp) > 0) {
						$strip_payment_amount += $results_bp[0]->transaction_amount;
						$transaction_amount += $results_bp[0]->transaction_amount;
						$buyers_premium_rs = $results_bp[0]->transaction_amount;
					}
					if (!empty($buyers_premium_rs)) {
						$bp_item_id = wc_add_order_item($order_id, array(
							'order_item_name' => $product_nm . " : Buyer's Premium Amount",
							'order_item_type' => 'fee',
						));
						wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
						wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
					}
					if (!empty($strip_payment_amount)) {
						/*$ad_item_id = wc_add_order_item( $order_id, array(
							'order_item_name' => "Auto Debit",
							'order_item_type' => 'fee',
						));
						wc_add_order_item_meta( $ad_item_id, '_fee_amount', $strip_payment_amount, true );
						wc_add_order_item_meta( $ad_item_id, '_line_total', -$strip_payment_amount, true );*/
					}
					$strip_payment_amount_grand += $strip_payment_amount;
				} else {
					$query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
					$results_bp = $wpdb->get_results($query_bp);
					//print_r($results_bp);
					if (count($results_bp) > 0) {
						$strip_payment_amount += $results_bp[0]->transaction_amount;
						$transaction_amount += $results_bp[0]->transaction_amount;
						$buyers_premium_rs = $results_bp[0]->transaction_amount;
						if (!empty($buyers_premium_rs)) {
							$bp_item_id = wc_add_order_item($order_id, array(
								'order_item_name' => $product_nm . " : Buyer's Premium Amount",
								'order_item_type' => 'fee',
							));
							wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
							wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
						}
					}
					$query_ad   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='uat_partially_bid_amount_type' and status='succeeded' ORDER BY `id` DESC";
					$results_ad = $wpdb->get_results($query_ad);
					//print_r($results_bp);
					if (count($results_ad) > 0) {
						$strip_payment_amount += $results_bp[0]->transaction_amount;
					}
					$query_adfull   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $customer_id . " and pid=" . $product_id . " and debit_type='" . $this->gateway . "_charge_type_full' and status='succeeded' ORDER BY `id` DESC";
					$results_adfull = $wpdb->get_results($query_adfull);
					//print_r($results_bp);
					if (count($results_adfull) > 0) {
						$strip_payment_amount += $results_adfull[0]->transaction_amount;
					}
					if (!empty($strip_payment_amount)) {
						/*$ad_item_id = wc_add_order_item( $order_id, array(
								'order_item_name' => "Auto Debit",
								'order_item_type' => 'fee',
							));
							wc_add_order_item_meta( $ad_item_id, '_fee_amount', $strip_payment_amount, true );
							wc_add_order_item_meta( $ad_item_id, '_line_total', -$strip_payment_amount, true );*/
					}
					$strip_payment_amount_grand += $strip_payment_amount;
				}
				$line_item  = $order->get_item($item_id, false);
				$out_of_stock_staus = 'outofstock';

				// uat_update_auction_status( $product_id , 'uat_past' );
				// json_update_status_auction($product_id, $status = "past");

				// 1. Updating the stock quantity
				// update_post_meta($product_id, '_stock', 0);

				// 2. Updating the stock quantity
				// update_post_meta( $product_id, '_stock_status', wc_clean( $out_of_stock_staus ) );

				// 3. Updating post term relationship
				// wp_set_post_terms( $product_id, 'outofstock', 'product_visibility', true );

				// And finally (optionally if needed)
				wc_delete_product_transients($product_id); // Clear/refresh the variation cache
				update_post_meta($product_id, 'woo_ua_order_id', $order_id);
			}
			if (!empty($strip_payment_amount_grand)) {
				$ad_item_id = wc_add_order_item($order_id, array(

					'order_item_name' => "Auto Debit",

					'order_item_type' => 'fee',
				));
				wc_add_order_item_meta($ad_item_id, '_fee_amount', $strip_payment_amount_grand, true);
				wc_add_order_item_meta($ad_item_id, '_line_total', -$strip_payment_amount_grand, true);
			}

			$calculate_taxes_for = array(
				'country'  => !empty($shipping_address['country']) ? $shipping_address['country'] : $billing_address['country'],
				'state'    => !empty($shipping_address['state']) ? $shipping_address['state'] : $billing_address['state'],
				'postcode' => !empty($shipping_address['postcode']) ? $shipping_address['postcode'] : $billing_address['postcode'],
				'city'     => !empty($shipping_address['city']) ? $shipping_address['city'] : $billing_address['city'],
			);
			$line_item->calculate_taxes($calculate_taxes_for);
			$line_item->save();
			/*
			$shipping_taxes = WC_Tax::calc_shipping_tax( '10', WC_Tax::get_shipping_tax_rates() );
			$rate   = new WC_Shipping_Rate( 'flat_rate_shipping', 'Flat rate shipping', '10', $shipping_taxes, 'flat_rate' );
			$item   = new WC_Order_Item_Shipping();
			$item->set_props( array(
				'method_title' => $rate->label,
				'method_id'    => $rate->id,
				'total'        => wc_format_decimal( $rate->cost ),
				'taxes'        => $rate->taxes,
			) );
			foreach ( $rate->get_meta_data() as $key => $value ) {
				$item->add_meta_data( $key, $value, true );
			}
			$order->add_item( $item );
			*/
			$uat_enable_buyers_premium =  get_post_meta($event_id, 'uat_enable_buyers_premium', true);
			$uat_stripe_buyers_premium_enable =  get_post_meta($event_id, 'uat_stripe_buyers_premium_enable', true);
			$bp_auto_debit = true;
			if (empty($uat_stripe_buyers_premium_enable) || $uat_stripe_buyers_premium_enable != "yes") {
				$bp_auto_debit = false;
			}

			if ($uat_enable_buyers_premium == "yes" && $bp_auto_debit == false) {

				$buyers_premium_rs = '0';
				$uat_buyers_premium_amount = get_post_meta($event_id, 'uat_buyers_premium_amount', true);
				$uat_buyers_premium_type =  get_post_meta($event_id, 'uat_buyers_premium_type', true);
				$auction_current_bid = $product->get_uwa_auction_current_bid();
				if ($uat_buyers_premium_type == 'percentage') {
					$uwa_buyer_price = ($auction_current_bid * $uat_buyers_premium_amount) / 100;
					/* calculations for min max buyers premium */
					$uwa_bpm_min_val =  get_post_meta($event_id, 'uat_buyers_min_premium', true);
					$uwa_bpm_max_val =  get_post_meta($event_id, 'uat_buyers_min_premium', true);
					$min_val = $uwa_bpm_min_val;
					$max_val = $uwa_bpm_max_val;
					if ($min_val > 0) {
						if ($uwa_buyer_price < $min_val) {
							$uwa_buyer_price = $min_val;
						}
					}
					if ($max_val > 0) {
						if ($uwa_buyer_price > $max_val) {
							$uwa_buyer_price = $max_val;
						}
					}
				} else {
					$uwa_buyer_price = $uat_buyers_premium_amount;
				}
				if (!empty($uwa_buyer_price)) {
					$bp_item_id = wc_add_order_item($order_id, array(
						'order_item_name' => "Buyer's Premium Amount",
						'order_item_type' => 'fee',
					));
					$buyers_premium_rs = $uwa_buyer_price;
					wc_add_order_item_meta($bp_item_id, '_fee_amount', $buyers_premium_rs, true);
					wc_add_order_item_meta($bp_item_id, '_line_total', $buyers_premium_rs, true);
				}
			}

			$newTotal = $order->calculate_totals();
			$order->set_total($newTotal);
		}
		$user_arr = array_values(array_unique($user_arr));
		update_post_meta($event_id, 'order_status', 'created');
	}
}