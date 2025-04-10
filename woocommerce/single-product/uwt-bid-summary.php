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
$product_id = $product->get_id();
$uat_auction_expired_payment=get_post_meta( $product_id, 'uat_auction_expired_payment', true );
$woo_ua_order_id = get_post_meta( $product_id, 'woo_ua_order_id', true );					
if($uat_auction_expired_payment == 'yes' || !empty($woo_ua_order_id)){
    if ( $user_id == $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ) {
        $have_to_show_table = false;
        $strip_payment_amount_grand = 0;
        $uat_event_id=get_post_meta( $product_id, 'uat_event_id', true );
        $auction_current_bid = $product->get_uwa_auction_current_bid();
        $currency = get_woocommerce_currency_symbol();
        $get_total_bp_amount = $product->get_total_bp_amount();
        if($auction_current_bid > 0){
            $have_to_show_table = true;
        }
        if($get_total_bp_amount > 0){
            $have_to_show_table = true;
        }
        
        $get_uwa_stripe_auto_debit_bpm_amt = $product->get_uwa_stripe_auto_debit_bpm_amt();       
        $get_uwa_stripe_auto_debit_bid_amt = $product->get_uwa_stripe_auto_debit_bid_amt();
       
        $get_uwa_stripe_hold_total_amt = $product->get_uwa_stripe_hold_total_amt();
        $hold_type = "";
        $is_hold = false;
        $is_fix_hold = false;
        $autodebit_message = "";
        $hold_message = "";
        $hold_amount = "";
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
                $hold_message = sprintf(__('Winning bid was %s. Amount held and debited will be %s.', 'ultimate-auction-pro-software'),$auction_current_bid_,$get_uwa_stripe_hold_total_amt_);
                $get_uwa_stripe_refund_total_amt = $product->get_uwa_stripe_refund_total_amt();
                if(0 < $get_uwa_stripe_refund_total_amt)
                {
                    $get_uwa_stripe_refund_total_amt_ = strip_tags(wc_price($get_uwa_stripe_refund_total_amt));
                    $auction_current_bid_ = strip_tags(wc_price($auction_current_bid));
                    $release = sprintf(__(' %s will be released and amount debited will be %s.', 'ultimate-auction-pro-software'),$get_uwa_stripe_refund_total_amt_,$auction_current_bid_);
                    $hold_message .= $release;
                }	
                $have_to_show_table = true;			
            }else{      
                $is_hold = true;          
                $strip_payment_amount_grand += $get_uwa_stripe_hold_total_amt;
            }
        }
      
        if(!$is_fix_hold){             
            $have_to_show_table = true;
            $autodebit_message = __("Amount held and auto debited", 'ultimate-auction-pro-software');
        }
       
        
    if($have_to_show_table){
     ?>
        <div class="uat-bid-summary-box">
            <?php 
            $uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
			$uat_send_first_last_name = get_option( 'options_uat_send_first_last_name',"0" );
			$uat_send_mailing_address = get_option( 'options_uat_send_mailing_address',"0" );
			$uat_send_phone_mobile_number = get_option( 'options_uat_send_phone_mobile_number',"0" );
			$uat_send_seller_address = get_option( 'options_uat_send_seller_address',"0" );
			$uat_do_you_want_to_send_information_via_email = get_option( 'options_uat_do_you_want_to_send_information_via_email',"0" );
			$uat_only_show_when_buyers_commission_debited = get_option( 'options_uat_only_show_when_buyers_commission_has_been_automatically_debited',"0" );
            $uat_show_seller_details_product_page = get_option( 'options_uat_buyer_and_seller_to_view_each_others_information_on_the_product_page',"0" );
            $uat_message_for_winner = get_option( 'options_uat_message_for_winner',"0" );
			$seller_name = '';
			$seller_email = '';
			$seller_phone = '';
			$seller_address = '';
            $bp_status = 'open';
            if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_show_seller_details_product_page=='1'){
                	
                echo '<div class=win-bid-hisorty>';
                echo $uat_message_for_winner;
                if($uat_only_show_when_buyers_commission_debited=='1'){
					global $wpdb;
					$query_bp = "SELECT `status` FROM `".$wpdb->prefix."auction_direct_payment` WHERE uid=".$user_id." AND pid=".$product_id." AND debit_type='buyers_premium'";
					$results_bp = $wpdb->get_results($query_bp);
					if(!empty($results_bp)){
						$status_bp = $results_bp[0]->status;
                        if($status_bp == 'succeeded'){  
                            $bp_status = 'succeeded';  
                          }else{  
                            $bp_status = 'failed';  
                        }
					}
				}
                ?>
                    <table cellspacing="0" class="seller-details-for-winner-table shop_table shop_table_responsive">
                        <tbody>
                            <?php if($auction_current_bid > 0): ?>
                                <tr class="fee seller-row">
                                    <th><?php echo __("Winning bid", 'ultimate-auction-pro-software'); ?></th>
                                    <td><span class="woocommerce-Price-amount amount"><?php echo wc_price($auction_current_bid); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($bp_status == 'succeeded'){ ?>
                                <?php if($get_total_bp_amount > 0): ?>
                                    <tr class="fee seller-row">
                                        <th><?php echo __("Buyer's Premium", 'ultimate-auction-pro-software'); ?></th>
                                        <td><span class="woocommerce-Price-amount amount"><?php echo wc_price($get_total_bp_amount); ?></td>
                                    </tr>
                                <?php endif; ?>
                                <?php if(!empty($get_uwa_stripe_auto_debit_bpm_amt) && $get_uwa_stripe_auto_debit_bpm_amt > 0): ?>
                                    <tr class="fee seller-row">
                                        <th><?php echo __("Auto debit of buyer's premium", 'ultimate-auction-pro-software'); ?></th>
                                        <td><span class="woocommerce-Price-amount amount"><?php echo wc_price(-$get_uwa_stripe_auto_debit_bpm_amt); ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php } ?>
                            <?php if($bp_status == 'failed'){ ?>
                                <tr class="fee seller-row failed-message">
                                        <th colspan="2"><?php echo __("The payment for the buyer's premium was unsuccessful. Kindly reach out to settle the commission in order to access the seller's information.", 'ultimate-auction-pro-software'); ?></th>
                                </tr>
                            <?php } ?>
                            
                            <?php if($bp_status != 'failed'|| $uat_only_show_when_buyers_commission_debited=='0'){ ?>
                                <tr class="fee seller-row seller-details" >
                                    <th colspan="2" style="border: 0;margin: 10px 0;"><?php echo __("Seller Detail", 'ultimate-auction-pro-software'); ?></th>
                                </tr>
                            <?php if($uat_send_first_last_name=='1' && !empty(get_field('auction_seller_name', $product_id))): ?>
                                <tr class="fee seller-row seller-name">
                                    <th><?php echo __("Name:", 'ultimate-auction-pro-software'); ?></th>
                                    <td><span class="woocommerce-seller-name"><?php echo get_field('auction_seller_name', $product_id); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($uat_send_mailing_address=='1' && !empty(get_field('seller_email_id', $product_id))): ?>
                                <tr class="fee seller-row  seller-email-id">
                                    <th><?php echo __("Email ID:", 'ultimate-auction-pro-software'); ?></th>
                                    <td><span class="woocommerce-seller-email-id"><?php echo get_field('seller_email_id', $product_id); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($uat_send_phone_mobile_number=='1' && !empty(get_field('seller_phone_number', $product_id))): ?>
                                <tr class="fee seller-row seller-phone-number">
                                    <th><?php echo __("Phone:", 'ultimate-auction-pro-software'); ?></th>
                                    <td><span class="woocommerce-seller-phone-number"><?php echo get_field('seller_phone_number', $product_id); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php if($uat_send_seller_address=='1' && !empty(get_field('contact_details', $product_id))): ?>
                                <tr class="fee seller-row contact-details">
                                    <th><?php echo __("Location:", 'ultimate-auction-pro-software'); ?></th>
                                    <td><span class="woocommerce-contact-details"><?php echo get_field('contact_details', $product_id); ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php } ?>
                            
                        </tbody>
                    </table>
                <?php 
                echo '</div>';
			}else{ ?>
				<h5><?php echo __("Auction Payment Summary", 'ultimate-auction-pro-software'); ?></h5>
                <table cellspacing="0" class="shop_table shop_table_responsive">
                <tbody>
                    <?php if($auction_current_bid > 0): ?>
                        <tr class="fee">
                            <th><?php echo __("Winning bid", 'ultimate-auction-pro-software'); ?></th>
                            <td><span class="woocommerce-Price-amount amount"><?php echo wc_price($auction_current_bid); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if($get_total_bp_amount > 0): ?>
                        <tr class="fee">
                            <th><?php echo __("Buyer's Premium", 'ultimate-auction-pro-software'); ?></th>
                            <td><span class="woocommerce-Price-amount amount"><?php echo wc_price($get_total_bp_amount); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if(!empty($get_uwa_stripe_auto_debit_bpm_amt) && $get_uwa_stripe_auto_debit_bpm_amt > 0): ?>
                        <tr class="fee">
                            <th><?php echo __("Auto debit of buyer's premium", 'ultimate-auction-pro-software'); ?></th>
                            <td><span class="woocommerce-Price-amount amount"><?php echo wc_price(-$get_uwa_stripe_auto_debit_bpm_amt); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if($get_uwa_stripe_auto_debit_bid_amt > 0): ?>
                        <tr class="fee">
                            <th><?php echo __("Auto Debit", 'ultimate-auction-pro-software'); ?></th>
                            <td><span class="woocommerce-Price-amount amount"><?php echo wc_price(-$get_uwa_stripe_auto_debit_bid_amt); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if(!empty($get_uwa_stripe_hold_total_amt) && !$is_fix_hold): ?>
                        <tr class="fee">
                            <th><?php echo __("Amount held and auto debited", 'ultimate-auction-pro-software'); ?></th>
                            <td><span class="woocommerce-Price-amount amount"><?php echo wc_price(-$get_uwa_stripe_hold_total_amt); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if($is_fix_hold && $auction_current_bid > 0): ?>
                        <tr class="fee">
                            <th><?php echo $hold_message; ?></th>
                            <td><span class="woocommerce-Price-amount amount">
                                <?php 
                                    $final_amount = $auction_current_bid;
                                    if($get_uwa_stripe_hold_total_amt < $auction_current_bid){
                                        $final_amount = $get_uwa_stripe_hold_total_amt;
                                    }
                                    $final_amount = (int)$final_amount;
                                    echo wc_price(-$final_amount); 
                                    ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                    <?php if(empty($order_id)): ?>
                    <tr class="fee">
                            <th><?php echo __("Shipping and taxes on next page", 'ultimate-auction-pro-software'); ?></th>
                    </tr>
                    <?php endif; ?>
                </tbody>
                </table>
			<?php } ?>


            
        </div>
    <?php 
    }
    }
}else{
    if($product->is_uwa_completed() && $user_id == $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2'){
    ?>
        <div class="uat-bid-summary-box">
        <?php echo __("Calculating results. Please refresh in a few seconds.", 'ultimate-auction-pro-software'); ?>  
            <a href="javascript:;" onclick="location.reload();" class="btn_refresh button" ><?php echo __("Refresh", 'ultimate-auction-pro-software') ?></a>
        </div>

    <?php
        }else{
    ?>
            <div class="uat-bid-summary-box-live" style="display: none;">
        <?php echo __("Calculating results. Please refresh in a few seconds.", 'ultimate-auction-pro-software'); ?>  
            <a href="javascript:;" onclick="location.reload();" class="btn_refresh button" ><?php echo __("Refresh", 'ultimate-auction-pro-software') ?></a>
        </div>
    <?php
    }
}

/* ---------------------------- END PAY NOW Button  ---------------------------- */