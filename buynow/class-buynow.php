<?php


function buynow_js($hook)
{
	$my_js_ver = '';




	wp_enqueue_script('buynow_js',  trailingslashit(get_template_directory_uri()) . 'includes/buynow/js/buynow.js', array('jQuery'), $my_js_ver);
	wp_localize_script(
		'buynow_js',
		'frontend_buynow_object',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
            'react_currency_symbol' => get_woocommerce_currency_symbol(),
            'uwa_nonce' => wp_create_nonce('UtAajax-nonce') 
		)
	);
}
add_action('wp_enqueue_scripts', 'buynow_js');
add_action('woocommerce_cart_calculate_fees', function() {
	if (is_admin() && !defined('DOING_AJAX')) {
		return;
	}
	global $wpdb;
	$auction_product_ids=array();
	$products_in_cart = WC()->cart->get_cart_contents();
	$product_ids_in_cart = array_column(array_values($products_in_cart), 'product_id');
	foreach($product_ids_in_cart as $get_val){
		$product = wc_get_product( $get_val );
		if($product->get_type() == "auction"){
			$auction_product_ids[]=$get_val;
		}
	}
	if(empty($auction_product_ids)){
		return;
	}
	
	foreach($auction_product_ids as $product_id){
		$strip_payment_amount_grand = 0;
 
		$product = wc_get_product( $product_id );		
		if($product->get_type() == "auction"){
			$uat_event_id=get_post_meta( $product_id, 'uat_event_id', true );
			$auction_current_bid = $product->get_uwa_auction_current_bid();
			$product_nm = get_the_title($product_id);
			$currency = get_woocommerce_currency_symbol();
			$enable_buy_now_bp = false;
			if (!empty($uat_event_id)) {
				$enable_buy_now_bp = uwt_get_event_buyer_premium_enabled_for_buynow($uat_event_id);
			}else{
				$enable_buy_now_bp = uwt_get_buyer_premium_enabled_for_buynow($product_id);
			}
			if($enable_buy_now_bp){
				$get_total_bp_amount = $product->get_total_bp_amount();
				$bp_text = __("Buyer's Premium","ultimate-auction-pro-software");
				if($get_total_bp_amount > 0){
					WC()->cart->add_fee($product_nm." : ".$bp_text, $get_total_bp_amount);
				}
				$get_uwa_stripe_auto_debit_bpm_amt = $product->get_uwa_stripe_auto_debit_bpm_amt(); 
				if($get_uwa_stripe_auto_debit_bpm_amt > 0){				
					$auto_bp_text = __("Auto debit of buyer's premium","ultimate-auction-pro-software");				
					WC()->cart->add_fee(__($product_nm." : ".$auto_bp_text, 'ultimate-auction-pro-software'), -$get_uwa_stripe_auto_debit_bpm_amt);
				}
			}
			$get_uwa_stripe_auto_debit_total_amt = $product->get_uwa_stripe_auto_debit_total_amt();
			$get_uwa_stripe_auto_debit_bid_amt = $product->get_uwa_stripe_auto_debit_bid_amt();
			$get_uwa_stripe_hold_total_amt = $product->get_uwa_stripe_hold_total_amt();
			
			
			$hold_type = "";
			$is_fix_hold = false;
			$is_hold = false;
			if(!empty($get_uwa_stripe_hold_total_amt)){
				$uat_event_id = get_post_meta( $product_id, 'uat_event_id', true );
				if (!empty($uat_event_id)) {
					$hold_type = get_post_meta( $uat_event_id, 'ep_type_automatically_debit_hold_type', true );
				}else{
					$hold_type = get_post_meta( $product_id, 'sp_type_automatically_debit_hold_type', true );
				}
				if($hold_type == "stripe_charge_hold_fix_amount" || $hold_type == "ep_stripe_charge_type_fixed")
				{
					$is_fix_hold = true;
					$is_hold = true;       
				}
				if($is_fix_hold)
				{		
					$win_amount = (int)$auction_current_bid;
					$auction_current_bid_ = strip_tags(wc_price($win_amount));
					$get_uwa_stripe_hold_total_amt_ = strip_tags(wc_price($get_uwa_stripe_hold_total_amt));
					$note = $product_nm.' : '.sprintf(__('Winning bid was %s. Amount held and debited will be %s. ', 'ultimate-auction-pro-software'), $auction_current_bid_, $get_uwa_stripe_hold_total_amt_);
					$get_uwa_stripe_refund_total_amt = $product->get_uwa_stripe_refund_total_amt();
					if(0 < $get_uwa_stripe_refund_total_amt)
					{
						$get_uwa_stripe_refund_total_amt_ = strip_tags(wc_price($get_uwa_stripe_refund_total_amt));
						$auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
						$release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'), $get_uwa_stripe_refund_total_amt_, $auction_current_bid_);
						$note .= $release;
					}		
					$final_amount = $win_amount;
					if($get_uwa_stripe_hold_total_amt < $auction_current_bid){
						$final_amount = $get_uwa_stripe_hold_total_amt;
					}		
					WC()->cart->add_fee($note, -$final_amount);
				}else{
					$is_hold = true;       
					$note = __("Amount held and auto debited", 'ultimate-auction-pro-software');					
					WC()->cart->add_fee($product_nm." : ".$note, -$get_uwa_stripe_hold_total_amt);
				}
			}
			if($get_uwa_stripe_auto_debit_bid_amt > 0){
				$note =__("Auto Debit", 'ultimate-auction-pro-software');					
				WC()->cart->add_fee($product_nm." : ".$note, -$get_uwa_stripe_auto_debit_bid_amt);
			}
			
		}
	}
});


add_action('woocommerce_checkout_update_order_meta', 'uwt_auction_order_buy_now', 10, 2);
function uwt_auction_order_buy_now($order_id, $posteddata) {

	$order = wc_get_order($order_id);

	if ($order) {

		$order_items = $order->get_items();

		if ($order_items) {

			foreach ($order_items as $item_id => $item) {
				$item_meta 	= method_exists( $order, 'wc_get_order_item_meta' ) ? $order->wc_get_order_item_meta( $item_id ) : $order->get_item_meta( $item_id );
				$product_data = wc_get_product($item_meta["_product_id"][0]);
				if (method_exists( $product_data, 'get_type') && $product_data->get_type() == 'auction') {
						$order->update_meta_data('_auction', '1');
						
						update_post_meta($item_meta["_product_id"][0], 'woo_ua_order_id', $order_id, 
						true);

					if (!$product_data->is_uwa_completed()) {
						update_post_meta($item_meta["_product_id"][0], 'woo_ua_auction_closed', '3');						
						delete_post_meta($item_meta["_product_id"][0], 'woo_ua_auction_fail_reason');
						update_post_meta($item_meta["_product_id"][0], 'woo_ua_buy_now', '1');
						update_post_meta($item_meta["_product_id"][0], 'woo_ua_auction_end_date', get_ultimate_auction_now_date());
						update_post_meta( $item_meta["_product_id"][0], 'order_status', 'created');
						$product_id=$item_meta["_product_id"][0];
						
						uat_update_auction_status( $product_id, 'uat_past' );
						json_update_status_auction($product_id, $status = "past");	
						
						global $wpdb;
						$refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'last_bid'");
						
						if (!empty($refunresult)) {
							if (!empty($refunresult[0]->transaction_id)) {
								try {
									$Uat_Auction_Payment = new Uat_Auction_Payment();
									$activity = '';
									$Uat_Auction_Payment->refunds_payment($refunresult[0]->uid, $bid_amout = $refunresult[0]->transaction_amount, $product_id, $transaction_id = $refunresult[0]->transaction_id, $activity);
								} catch (\Throwable $th) {
									//throw $th;
								}
							}
						}
						
					}
					
					
				}
			}
		}
	}
	$order->update_meta_data( 'auctions_order_type', 'single_product' );
	$order->save();
	
}
?>