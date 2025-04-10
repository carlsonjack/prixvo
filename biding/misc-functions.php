<?php

/**
 * Extra Functions file
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bid Placed Message
 *
 */
function uat_bid_place_message( $product_id ) {
	return "";
	global $woocommerce;
	$product_data = wc_get_product($product_id);
  	$args = array();

	$current_user = wp_get_current_user();
	$is_slient_auction = $product_data->get_uwa_auction_silent();

	if($is_slient_auction == "yes"){

		$display_bid_value = wc_price($product_data->get_uwa_last_bid(), $args);
	}
	else{

		$display_bid_value = wc_price($product_data->get_uwa_current_bid(), $args);
	}


	if($current_user->ID == $product_data->get_uwa_auction_current_bider()){

		if(!$product_data->is_uwa_reserve_met()){
			$message ="";
			$message .='<div class="success-msg">
			  <i class="fa fa-check"></i>
			<i class="fas fa-times" id="remove-msg"></i>';
			$message .= __('Your bid of '.$display_bid_value.' has been placed successfully.', 'ultimate-auction-pro-software');
			$message .='</div>';

		}
		else {

			if($product_data->get_uwa_auction_max_bid() && $product_data->get_uwa_auction_proxy()){

				$message ="";
				$message .='<div class="success-msg">
				  <i class="fa fa-check"></i>
				<i class="fas fa-times" id="remove-msg"></i>';
				$message .= __('Your bid of '.$display_bid_value.' has been placed successfully! Your max bid is '.wc_price($product_data->get_uwa_auction_max_bid()).'.', 'ultimate-auction-pro-software');

				$message .='</div>';

			}
			else{

				$message ="";
				$message .='<div class="success-msg">
				  <i class="fa fa-check"></i>
				<i class="fas fa-times" id="remove-msg"></i>';
				$message .=__('Your bid of '.$display_bid_value.' has been placed successfully.','ultimate-auction-pro-software');
				$message .='</div>';
			}
		}

	}
	else {

		if($product_data->get_uwa_auction_proxy() =="yes"){
			$message ="";
			$message .='<div class="success-msg">
			  <i class="fa fa-check"></i>
			<i class="fas fa-times" id="remove-msg"></i>';
			$message .=__( "Your bid has been placed successfully.", 'ultimate-auction-pro-software');
			$message .='</div>';
		}
		else {
			$message ="";
			$message .='<div class="success-msg">
			  <i class="fa fa-check"></i>
			<i class="fas fa-times" id="remove-msg"></i>';
			$message .= __( "Your bid of ".$display_bid_value." has been placed successfully.", 'ultimate-auction-pro-software')  ;
			$message .='</div>';
		}

	}

return $message;
	///wc_add_notice ( apply_filters('ultimate_woocommerce_auction_bid_place_message', $message, $product_id ) );
}