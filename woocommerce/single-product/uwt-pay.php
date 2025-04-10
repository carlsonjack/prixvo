<?php

/**
 * Auction Payment Button for winner
 * 
 * @package Ultimate Auction Theme
 * @author Nitesh Singh 
 * @since 1.0.3  
 *
 */

if (!defined('ABSPATH')) {
	exit;
}

global $woocommerce, $product, $post;


if(!(method_exists( $product, 'get_type') && $product->get_type() == 'auction')){
	return;
}

/* ---------------------------- PAY NOW Button  ---------------------------- */
$user_id = get_current_user_id();
$order_id = $product->get_uwa_order_id();
$auction_id = $product->get_id();
$uat_auction_expired_payment=get_post_meta( $auction_id, 'uat_auction_expired_payment', true );
if($uat_auction_expired_payment == 'yes'){
    $show_button = false;
    if ( $user_id == $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ) {
        if(empty($order_id)){
            $show_button = true;
            $checkout_url = esc_attr(add_query_arg("pay-uwa-auction",$product->get_id(), wc_get_checkout_url()));
        }else{
            $order = wc_get_order($order_id);
            $checkout_url = $order->get_checkout_payment_url() ;
            $order_status  = $order->get_status();
            if($order_status == 'pending') {
                $show_button = true;
            }
        }
    }
    if($show_button){    
            
        $uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
        if($uat_enable_offline_dealing_for_buyer_seller!='1'){  ?>
        <div class="uat-pay-now-box">
            <a href="<?php echo $checkout_url; ?>" class="button alt uwa_pay_now">
                <?php echo apply_filters('uat_pay_now_button_text', __('Proceed to checkout', 'ultimate-auction-pro-software' ), $product); ?>
            </a>
        </div>
        <?php } ?>
    <?php 
    }
}

/* ---------------------------- END PAY NOW Button  ---------------------------- */