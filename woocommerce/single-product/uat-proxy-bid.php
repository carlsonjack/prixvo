<?php
/**
 * Proxy Auction ProductBid Area
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if (!defined('ABSPATH')) {
	exit;
}

global $woocommerce, $product, $post,$sitepress;

if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction')) {
	return;
}
$product_id =  $product->get_id();
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
    $product_id = icl_object_id($product_id,'product',false, $sitepress->get_default_language());
}
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
$display_timezone_ed = get_option('options_uat_auction_timezone', "on");
$display_timezone="";
if($display_timezone_ed == "on"){
    $display_timezone=__($timezone_string, 'ultimate-auction-pro-software');
    $display_timezone="(".$display_timezone.")";
}
$uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);
$curent_bid = $product->uwa_bid_value();
$bid_increment = $product->get_uwa_auction_bid_increment();
$next_bids = $product->get_uwa_number_of_next_bids();
$no_of_next_bids = !empty($next_bids) ? $next_bids : 10;
$max_current_bid = $product->get_uwa_auction_max_bid();
$uat_variable_inc_enable = $product->get_uwa_auction_variable_bid_increment();
if (empty($bid_increment)) {
    if (!empty($product->get_event_id())) {
        $bid_increment = get_option('options_uat_global_bid_increment_event',$bid_increment);
    }else{
        $bid_increment = get_option('options_uat_global_bid_increment',$bid_increment);
    }
}
$ua_inc_price_range="";
if ($uat_variable_inc_enable == 'yes') {
	$variable_type = get_post_meta($product_id, 'uwa_auction_variable_bid_increment_type', true);
	if($variable_type == "global"){
		$ua_inc_price_range =	$product->get_uwa_var_inc_price_val();
	}else{
		$ua_inc_price_range = get_post_meta($product_id, 'uwa_var_inc_price_val', true);
	}
	if(!empty($ua_inc_price_range)){
		foreach($ua_inc_price_range as $range){
			if( ($range['start'] <= $curent_bid) && ($range['end']>=$curent_bid) )
			{
				$bid_increment = $range['inc_val'];
				break;
			}
			if( ($range['start'] <= $curent_bid) && ($range['end'] == 'onwards') )
			{
				$bid_increment = $range['inc_val'];
				break;
			}
		}
	}
		
}

$max_current_bider = $product->get_uwa_auction_max_current_bider();

if ($max_current_bider && get_current_user_id() == $max_current_bider) {
	$curent_bid = $max_current_bid + absint($bid_increment);
}
$uat_event_id = $product->get_event_id();
$uat_auction_ending_date = get_option('options_uat_auction_ending_date', "on");
$uat_auction_start_date = get_option('options_uat_auction_start_date', "on");
$auction_status = json_chk_auction($product_id);
?>
<div class="react-div" data-auction-id="<?php echo $product_id; ?>" data-auction-type=""></div>
<div class="product-details-right details">
    <div class="bid-inf-box">
        <?php
		if (!empty($uat_event_id)) {
			$previous_post = get_previous_post_id_with_event_products($uat_event_id, $product_id);
			$next_post = get_next_post_id_with_event_products($uat_event_id, $product_id);
		}
		$previous_post_id = isset($previous_post) ? $previous_post : "";
		$next_post_id = isset($next_post) ? $next_post : "";
		?>
        <div class="next-prev-navigation">
            <?php if (!empty($previous_post_id)) { ?>
            <div class="prev-lot">
                <a href="<?php echo get_the_permalink($previous_post_id); ?>">
                    <svg width="24" height="24" fill="currentColor" class="css-ccdn7j"
                        aria-labelledby="caf37818-9dc5-4261-8dcd-c8c83ce1674f-8001">
                        <path
                            d="M3.054 11.726a.72.72 0 000 .547c.016.039.043.069.065.104.024.04.041.082.073.117l4.87 5.264a.76.76 0 001.06.05.729.729 0 00.05-1.041l-3.728-4.03H20.25c.414 0 .75-.33.75-.737a.744.744 0 00-.75-.737H5.443l3.728-4.03a.729.729 0 00-.05-1.041.76.76 0 00-1.06.05l-4.869 5.262c-.033.035-.049.077-.073.117-.021.036-.049.066-.065.105z"
                            fill="currentColor"></path>
                    </svg>
                    <span><?php _e('Prev', 'ultimate-auction-pro-software'); ?></span>
                </a>
            </div>
            <?php } else { ?>
            <div class="prev-lot">
                <?php previous_post_link('%link', esc_attr__('Prev', 'ultimate-auction-pro-software'), TRUE, ' ', 'product_cat'); ?>
            </div>
            <?php } ?>
            <?php if ($product->get_lot_number()) { ?>
            <div class="Lot-number">
                <h3><?php _e('Lot No', 'ultimate-auction-pro-software'); ?> : <?php echo $product->get_lot_number(); ?></h3>
            </div>
            <?php } ?>
            <?php if (!empty($next_post_id)) { ?>
            <div class="next-lot">
                <a href="<?php echo get_the_permalink($next_post_id); ?>">
                    <span><?php _e('Next', 'ultimate-auction-pro-software'); ?></span>
                    <svg width="24" height="24" fill="currentColor" class="css-ccdn7j"
                        aria-labelledby="8314dab5-fa9d-4a3e-afd0-5bb672db49bd-8003">
                        <path
                            d="M20.946 12.274a.72.72 0 000-.547c-.016-.039-.043-.069-.065-.104-.024-.04-.041-.082-.073-.117l-4.87-5.264a.76.76 0 00-1.06-.05.729.729 0 00-.05 1.041l3.728 4.03H3.75c-.414 0-.75.33-.75.737s.336.737.75.737h14.807l-3.728 4.03a.729.729 0 00.05 1.041.76.76 0 001.06-.05l4.869-5.262c.033-.035.049-.077.073-.117.021-.036.049-.066.065-.105z"
                            fill="currentColor"></path>
                    </svg>
                </a>
            </div>
            <?php } else { ?>
            <div class="next-lot">
                <?php next_post_link('%link', esc_attr__('Next', 'ultimate-auction-pro-software'), TRUE, ' ', 'product_cat'); ?>
            </div>
            <?php } ?>


        </div>

         <div class="product-name-detail">
            <h1><?php the_title(); ?></h1>
			<?php if($product->get_auction_subtitle()) { ?>
			<p><?php echo $product->get_auction_subtitle();?></p>
			<?php }  ?>	
        </div>

        <?php

		if (get_option('options_uat_auction_timer', 'on') == 'on' && ($auction_status == "live" || $auction_status == "future")) { ?>
        <?php //if(get_option('options_uat_auction_timer', 'on') == 'on' ){
			?>
        <div class="Estimate-detail">
            <div class="product-d-timer">
                <?php
                    $uwa_time_zone =  (array)wp_timezone();
					if ($auction_status == "live") {
						$uwa_remaining_seconds = $product->get_uwa_remaining_seconds();
						$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_end_date', true );
						$rem_arr=get_remaining_time_by_timezone($auc_end_date);
						?>
              				
				<?php
					countdown_clock(
						$end_date=$auc_end_date,
						$item_id=$product_id,
						$item_class='auction-countdown-check',   
					);					
				?>
                <?php  } elseif ($auction_status == "future") {
				$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_start_date', true );
				$rem_arr=get_remaining_time_by_timezone($auc_end_date);
				?>                
				<?php
					countdown_clock(
						$end_date=$auc_end_date,
						$item_id=$product_id,
						$item_class='auction-countdown-check scheduled',   
					);					
				?>
                <?php } ?>
            </div>
        </div>
        <?php } ?>

        <div class="lot-close-detail-date">
            <?php  if ($auction_status == "live" || $auction_status == "future" ) { ?>
				
                <?php if($auction_status == "future" && $uat_auction_start_date == "on"){ ?>           
                <div class="lot-close-date">
                    <h5><strong><?php _e('Live auction begins on:', 'ultimate-auction-pro-software'); ?></strong></h5>
                        <h5><small><?php echo  date_i18n(get_option('date_format'),  strtotime($product->get_uwa_auction_start_time()));  ?>,
                        <?php echo  date_i18n(get_option('time_format'),  strtotime($product->get_uwa_auction_start_time()));  ?>
                        <?php echo $display_timezone; ?></small>
                    </h5>
                </div>
				<?php } ?>
              
               <?php if($uat_auction_ending_date == "on"){ ?>
              <div class="lot-close-date">
                    <h5><strong><?php _e('Lot closes', 'ultimate-auction-pro-software'); ?>:</strong></h5>
                        <h5><small class="auction-ends-date"><?php echo  date_i18n(get_option('date_format'),  strtotime($product->get_uwa_auctions_end_time()));  ?>,
                            <?php echo  date_i18n(get_option('time_format'),  strtotime($product->get_uwa_auctions_end_time()));  ?>
                            <?php echo $display_timezone; ?></small>
                    </h5>
              </div>
			  <?php 
                    } 
                } elseif ($auction_status == "past") {
				
				 if ($product->get_uwa_auction_fail_reason() == '1') { ?>
				 
				<h5><?php _e('Auction has expired because there were no bids', 'ultimate-auction-pro-software'); ?></h5>
				
				<?php }elseif ($product->get_uwa_auction_fail_reason() == '2') { ?>
				
				<h5><?php _e('Auction has expired without reaching its reserve price', 'ultimate-auction-pro-software'); ?> </h5>
				
				<?php } ?>
				
				<?php if ($product->get_uwa_auction_expired() == '3') { ?>
				
				<span class="auction-ends-date" style="display:none"></span>
				<h5><strong><?php _e('This Auction Product has been sold for buy it now price', 'ultimate-auction-pro-software'); ?>:</strong> <?php echo wc_price($product->get_regular_price()) ?></h5>
				
				<?php } ?>
                <?php if ($product->get_uwa_auction_expired() == '2') { ?>
				
				<span class="auction-ends-date" style="display:none"></span>
				<h5><strong><?php _e('This auction product has expired', 'ultimate-auction-pro-software'); ?></strong> </h5>
				
				<?php } ?>
				
			<?php } ?>
        </div>

        <?php 
        if ($uwa_auction_selling_type_buyitnow != 'buyitnow') :
            $uwa_reserve_txt = __('No reserve', 'ultimate-auction-pro-software');
            if($product->is_uwa_reserve_enabled()){
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
                    $uwa_reserve_txt = __('Reserve price not met', 'ultimate-auction-pro-software');
                }
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
                    $uwa_reserve_txt = __('Reserve price met', 'ultimate-auction-pro-software');
                }
            }else{
                $uwa_reserve_txt = __( 'No reserve', 'ultimate-auction-pro-software' );
            }
            $bid_count = $product->get_uwa_auction_bid_count();
            if (empty($bid_count)) {
                $bid_count = 0;
            } 
        ?>



        <?php if ($auction_status == "live" || $auction_status == "future") : ?>
        <div class="bid-status-msg bid-status-msg-green" id="bid-status-msg-top"><?php _e('Your bid is on top!', 'ultimate-auction-pro-software'); ?></div>
        <div class="bid-status-msg bid-status-msg-red" id="bid-status-msg-outbid"><?php _e('You\'ve been outbid!', 'ultimate-auction-pro-software'); ?></div>
        <div class="Current-bid-detail">
            <h5>
                <strong class="current-bid-text" style="display:none"><?php _e('Current bid', 'ultimate-auction-pro-software'); ?>:</strong>
                <strong class="starting-bid-text" style="display:none"><?php _e('Starting bid', 'ultimate-auction-pro-software'); ?>:</strong>
                <?php if ($bid_count > 1) { ?>
                <small>(<?php echo '<span class="auction-bid-count">'.$bid_count.'</span>'; ?> <?php _e("Bids", "ultimate-auction-pro-software") ?>,
                    <?php echo '<span class="auction-reserve-price-text">'.$uwa_reserve_txt.'</span>'; ?>)</small>
                <?php } else { ?>
                <small>(<?php echo '<span class="auction-bid-count">'.$bid_count.'</span>'; ?> <?php _e("Bid", "ultimate-auction-pro-software") ?>,
                    <?php echo '<span class="auction-reserve-price-text">'.$uwa_reserve_txt.'</span>'; ?>)</small>
                <?php } ?>
            </h5>

            <h5>
                <div class="json_current_bid" data-userid="<?php echo esc_attr($product_id); ?>" data-starting="<?php echo $product->get_uwa_auction_start_price(); ?>"><?php echo wc_price($product->get_uwa_auction_start_price()); ?></div>

            </h5>

        </div>
        <?php if ($auction_status == "live"){ ?>
            <div  class="Next-bid-detail">
                <h5>
                    <strong ><?php _e('Minimum Bid', 'ultimate-auction-pro-software'); ?>:</strong>
                </h5>
                <h5  class="pricel-l-right">
                    <div class="json_next_bid" data-userid="<?php echo esc_attr($product_id); ?>" data-starting="<?php echo $product->get_uwa_auction_start_price(); ?>"><?php echo wc_price($product->get_uwa_auction_start_price()); ?></div>
                </h5>
            </div>
        <?php } ?>
        <small><a id="bid-inc-tab" href="#tab-uat_auction_bids_increments"><?php _e('Increment details', 'ultimate-auction-pro-software'); ?></a></small>
        <?php endif; ?>


        <?php
		if (!empty($product->get_estimate_price_from()) || !empty($product->get_estimate_price_to())) : ?>
        <div class="lot-close-detail">
            <h5><strong><?php _e('Estimate', 'ultimate-auction-pro-software'); ?>:</strong></h5>
            <h5><?php echo wc_price($product->get_estimate_price_from()); ?> -
                <?php echo wc_price($product->get_estimate_price_to()); ?></h5>
        </div>
        <?php endif; ?>





        <?php if ($auction_status == "live") : ?>

        <div class="bid-price-selection place-bid-sec">

             <div class="bid-price-l">
                <?php if ($max_current_bider && get_current_user_id() == $max_current_bider) { ?>
                <h5 style="margin-bottom: 0;">
                <strong class="auction-max-bid-setmsg" style="display: block;"><?php _e("SET YOUR MAXIMUM BID", 'ultimate-auction-pro-software') ?></strong>
                <?php if($product->get_uwa_auction_type() == 'reverse'){ ?>
                    <strong class="auction-max-bid-maxmsg" style="display: none;"><?php _e("YOUR MINIMUM BID IS", 'ultimate-auction-pro-software') ?>
                        <span class="auction-max-bid-amount"><?php echo wc_price($product->get_uwa_auction_max_bid()) ?></span>
                    </strong>
                <?php }else{ ?>
                    <strong class="auction-max-bid-maxmsg" style="display: none;"><?php _e("YOUR MAXIMUM BID IS", 'ultimate-auction-pro-software') ?>
                        <span class="auction-max-bid-amount"><?php echo wc_price($product->get_uwa_auction_max_bid()) ?></span>
                    </strong>
                <?php } ?>
                    </h5>
                <?php } else { ?>
                <h5 style="margin-bottom: 0;">
                    <strong class="auction-max-bid-setmsg" style="display: block;"><?php _e("SET YOUR MAXIMUM BID", 'ultimate-auction-pro-software') ?></strong>
                    <strong class="auction-max-bid-maxmsg" style="display: none;"><?php _e("YOUR MAXIMUM BID IS", 'ultimate-auction-pro-software') ?><span class="auction-max-bid-amount"></span></strong>

                     </h5>
                <?php } ?>
                <div class="pricel-l-right" style="display: flex;align-items: center;">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock"
                        class="svg-inline--fa fa-lock fa-w-14 ItemBiddingAbsentee__StyledLockIcon-sc-20yfl8-6 bkhYfT"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        style="height: 14px;width: 14px;">
                        <path fill="currentColor"
                            d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"
                            style="width: 20px;height: 220px;"></path>
                    </svg>
                    <h5 style="padding-left: 2px;margin-bottom: 0;"><strong><?php _e('SECURE', 'ultimate-auction-pro-software'); ?></strong></h5>
                </div>
            </div>
            <?php
                $field_options_to_place_bid = get_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
                if($field_options_to_place_bid == "show-drop-down-with-bid-values"){ ?>
                    <form id="uat_auction_form" class="uat_auction_form cart" method="post" enctype='multipart/form-data'
                        data-product_id="<?php echo $product_id; ?>">
                        <div class="jdropdown" data-auctionid="<?php echo esc_attr($product_id); ?>"></div>
                        <?php
                        $narr = array();
                        if( $ua_inc_price_range ){

                            foreach ($ua_inc_price_range as $range) {
                                $narr[] = $range;
                            }
                        }
                        ?>
                        <div id="reactsel" data-total-bids="<?php echo $no_of_next_bids; ?>" data-inc-enable="<?php echo $uat_variable_inc_enable; ?>" data-current-bid="<?php echo $curent_bid; ?>" data-price-range="<?php echo htmlspecialchars(json_encode($narr)); ?>" data-bid-increment="<?php echo $bid_increment; ?>" data-userid="<?php echo $product_id; ?>"></div>


                        <div class="product-details-btn">
                            <?php if (!is_user_logged_in()) { ?>
                                <button type="button" id="uat_placebidbutton" class="black_bg_btn bid_directly_btn" onclick="location.href='<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>'">
                        <?php echo apply_filters('uat_detail_page_direct_bid_button_text', __('Exact Bid', 'ultimate-auction-pro-software')); ?> </button>
                            <?php } else { ?>
                            <button type="submit" id="uat_placebidbutton" class="ua-button-black">
                                <?php echo apply_filters('uat_detail_page_direct_bid_button_text', __('Exact Bid', 'ultimate-auction-pro-software')); ?> </button>
                            <?php } ?>
                        </div>

                        <input type="hidden" name="bid" value="<?php echo esc_attr($product_id); ?>" />
                        <input type="hidden" id="uat_place_bid" name="uat-place-bid" value="<?php echo $product_id; ?>" />
                        <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>" />
                        <?php if (is_user_logged_in()) { ?>
                            <input type="hidden" name="user_id" value="<?php echo  get_current_user_id(); ?>" />
                            <?php  } ?>

                    </form>
                    <div class="error-msg-box" id="bid_msg"></div>
                <?php } ?>

                <!-- </div> -->
                <?php if($field_options_to_place_bid == "show-text-field-and-quick-bid"){ ?>
                <?php
                $narr = array();
                if( $ua_inc_price_range ){

                    foreach ($ua_inc_price_range as $range) {
                        $narr[] = $range;
                    }
                }
                
				  $hide_quick_bid = get_option('options_hide_quick_bid_buttons_proxy',"off");
				if($hide_quick_bid =="off") {  ?>				 
                <div class="bid-price-l">
                    <h5 style="margin-bottom: 0;"><strong><?php _e('Quick bid', 'ultimate-auction-pro-software'); ?></strong>
                </div>
				<?php } ?>
                <div id="reactplacebid" data-total-bids="<?php echo $no_of_next_bids; ?>" data-inc-enable="<?php echo $uat_variable_inc_enable; ?>" data-current-bid="<?php echo $curent_bid; ?>" data-price-range="<?php echo htmlspecialchars(json_encode($narr)); ?>" data-bid-increment="<?php echo $bid_increment; ?>" data-userid="<?php echo $product_id; ?>"></div>
                 <?php if($hide_quick_bid =="off") {  ?>
				<div class="three-btn quick-bid-btns" ></div>
				<?php } 
				 $hide_quick_bid = get_option('options_hide_direct_bid_proxy',"off");
				if($hide_quick_bid =="off") {  ?>
                <div class="bid-price-l">
                    <h5 style="margin-bottom: 0;"><strong><?php _e('Direct Bid', 'ultimate-auction-pro-software'); ?></strong>
                </div>
                <div class="two-attr-block">
                    <input type="number" class="bid_directly_input" name="bid_directly_input" data-current-bid="<?php echo $curent_bid; ?>">
                    <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                    <button class="black_bg_btn bid_directly_btn"><?php echo apply_filters('uat_detail_page_direct_bid_button_text', __('Exact Bid', 'ultimate-auction-pro-software')); ?></button>
                </div>
				
				<?php }?>
                <div class="bid-price-l">
                    <h5 style="margin-bottom: 0;"><strong><?php _e('Place an automatic bid!', 'ultimate-auction-pro-software'); ?></strong>
                </div>
                <div class="two-attr-block">
                    <input type="number" class="max_bid_directly_input" name="max_bid_directly_input" data-max-bid="0" data-is-max="0">
                    <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                    <button class="black_bg_btn max_bid_directly_btn"><?php _e('Automatic bid', 'ultimate-auction-pro-software'); ?></button>
                </div>
                <div class="error-msg-box" id="bid_msg"></div>
            <?php  } ?>
           
        </div>

        <?php endif; ?>
        <?php endif; ?>
        <?php
            $buyNowPrice = get_post_meta($product_id, '_regular_price', true);
            $uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);
            if ($auction_status == "live" && $buyNowPrice > 0 && $buyNowPrice > $curent_bid && ($uwa_auction_selling_type_buyitnow == "both" || $uwa_auction_selling_type_buyitnow == "buyitnow")) {
        ?>
            <form class="buy-now cart buy-now-frm buy-now-singal-product"  method="post" enctype='multipart/form-data'
            data-product_id="<?php echo $product_id; ?>">
                <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />
                <input type="hidden" name="buy-now-price" id="buy-now-price-hidden" value="<?php echo esc_attr($product->get_regular_price()); ?>" />
                <button type="submit" class="single_add_to_cart_button button alt ua-button-black buy-now-btn">
                    <?php echo apply_filters(
                                'single_add_to_cart_text',
                                sprintf(__('Buy Now %s', 'ultimate-auction-pro-software'), wc_price($product->get_regular_price())),
                                $product
                            ); ?>
                </button>
            </form>
        <?php } ?>

        <?php if ($auction_status == "live" || $auction_status == "future") : ?>
        <div class="bid-time-date-details">

            <?php if (!is_user_logged_in()) {

			$menu_link_types = get_option('options_menu_link_types', "menu_open_in_popup");

			if ($menu_link_types == 'menu_open_in_direct_link') {   ?>

            <a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>"

                class="ua-button-black-border"><?php _e('Register For Auction', 'ultimate-auction-pro-software'); ?></a>

            <?php } else { ?>

			<a  data-src="#uat-register-form" class="ua-button-black-border registerModal" href="javascript:;"><?php _e('Register For Auction', 'ultimate-auction-pro-software'); ?></a>

			<?php } } ?>

        </div>
        <?php endif; ?>
        <div class="uat-bid-summery">
            <?php
            do_action( 'uat_bid_summery' );
            do_action( 'uat_pay_now_button' );
            ?>
        </div>
    </div>



    <a data-fancybox data-src="#uat-onetime-fee-form" class="feeform" href="javascript:;"></a>
    <a data-fancybox data-src="#uat-msgbox" class="msgbox" href="javascript:;"></a>
    <?php $uat_bid_place_warning = get_option('options_uat_bid_place_warning', 'on'); ?>
    <?php $uat_fee_to_place_bid = get_option('options_uat_fee_to_place_bid','off');
    $biding_enable = check_for_one_time_fee(); ?>
    <span data-biding-enable="<?php echo $biding_enable; ?>"></span>
    <script type="text/javascript">
        var biding_enable = '<?php echo $biding_enable; ?>'
        jQuery("document").ready(function($) {
            jQuery("a.onetimeFeePay").on('click', function(event) {
                jQuery("#loader_ajax_for_fee").show();
                    event.preventDefault();
                        jQuery.ajax({
                            url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                            type: "post",
                            data: {
                                action: "woocommerce_ajax_add_to_cart",
                                product_id: <?php echo $product_id; ?>,
                            },
                            success: function(data) {
                                if(data.order_create == 1)
                                {
                                    window.location.href = data.checkout_url;
                                }
                                if(data.order_create == 3)
                                {
                                    location.reload();
                                }
                            },
                            error: function() {}
                        });

                });
            /* Extra confirmation message on place bid */
            <?php $uat_bid_place_warning = get_option('options_uat_bid_place_warning', 'on'); ?>
            // start dropdown bid
            jQuery("#uat_placebidbutton").on('click', function(event) {
                event.preventDefault();
                if(biding_enable != '1')
                {
                    document.querySelector('.feeform').click();
                    return false;
                }
                <?php
                    if (!is_user_logged_in()) {
                        $menu_link_types = get_option('options_menu_link_types', "menu_open_in_popup");
                        $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        if ($menu_link_types == 'menu_open_in_direct_link') {
                            $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        }
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid user", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".$message."</div>";
						?>
                        document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                        document.querySelector('.msgbox').click();
                        return false;


                <?php } ?>
                var uwa_place_bid = $('#uat_bid_value').val();
                var uwa_bid_value = $('#uat_bid_value').val();
                <?php if ($uat_bid_place_warning  == "on") { ?>
                    var getcon = confirm_bid("uat_auction_form", uwa_bid_value);
                    if (getcon) {

                    <?php } ?>

                    jQuery.ajax({
                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                        type: "post",

                        data: {
                            action: "uat_user_place_bid_ajax",
                            auction_id: <?php echo $product_id; ?>,
                            uwa_bid_value: uwa_bid_value
                        },
                        success: function(data) {
                            document.querySelector('#uat-msgbox-message').innerHTML = data ;
                            document.querySelector('.msgbox').click();
							 
								var getyimr=jquery_get_new_time("<?php echo $product_id; ?>");
							 
                        },
                        error: function() {}

                    });
                    <?php if ($uat_bid_place_warning  == "on") { ?>
                    }
                <?php } ?>
            });
            // end dropdown bid

            // start quickbid button
            jQuery(document).on('click',".quick_bid_button_one", function(event) {
                event.preventDefault();
                if(biding_enable != '1')
                {
                    document.querySelector('.feeform').click();
                    return false;
                }
                <?php
                    if (!is_user_logged_in()) {
                        $menu_link_types = get_option('options_menu_link_types', "menu_open_in_popup");
                        $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        if ($menu_link_types == 'menu_open_in_direct_link') {
                            $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        }
                 $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid user", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".$message."</div>";
						?>
                        document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                        document.querySelector('.msgbox').click();
                        return false;

                <?php } ?>
                var uwa_bid_value = $(this).attr('data-bid-amount');
                <?php if ($uat_bid_place_warning  == "on") { ?>
                    var getcon = confirm_bid("uat_auction_form", uwa_bid_value);
           

                    if (getcon) {

                    <?php } ?>

                    jQuery.ajax({
                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                        type: "post",

                        data: {
                            action: "uat_user_place_bid_ajax",
                            auction_id: <?php echo $product_id; ?>,
                            uwa_bid_value: uwa_bid_value,
                            bidtype:"directbid",
                        },
                        success: function(data) {
                            document.querySelector('#uat-msgbox-message').innerHTML = data ;
                            document.querySelector('.msgbox').click();
							 
								var getyimr=jquery_get_new_time("<?php echo $product_id; ?>");
							 
                        },
                        error: function() {}

                    });
                    <?php if ($uat_bid_place_warning  == "on") { ?>
                    }
                <?php } ?>
            });
            // end quickbid button

            // start directbid bid
            jQuery(document).on('click',".bid_directly_btn", function(event) {
                event.preventDefault();
                if(biding_enable != '1')
                {
                    document.querySelector('.feeform').click();
                    return false;
                }
                var bid_directly_input = $(".bid_directly_input");
                var current_bid = bid_directly_input.attr('data-current-bid');
                var uwa_bid_value = bid_directly_input.val();
                <?php
                    if (!is_user_logged_in()) {
                        $menu_link_types = get_option('options_menu_link_types', "menu_open_in_popup");
                        $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        if ($menu_link_types == 'menu_open_in_direct_link') {
                            $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        }
               $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid user", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".$message."</div>";
						?>
                        document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                        document.querySelector('.msgbox').click();
                        return false;

                <?php } ?>
                if(!uwa_bid_value){

                   <?php
					$bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid bid amount", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".__("Please enter bid amount", 'ultimate-auction-pro-software')."</div>";
					?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
					document.querySelector('.msgbox').click();
					return false;
                }
                if(parseFloat(current_bid) > parseFloat(uwa_bid_value)){

                    <?php 
					$bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid bid amount", 'ultimate-auction-pro-software')."</div>
			<div class='msgbox-text'>".__("Please enter bid value greater than the next bid value", 'ultimate-auction-pro-software')."</div>";
				?>
                    document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                    document.querySelector('.msgbox').click();
					return false;
                }
                <?php if ($uat_bid_place_warning  == "on") { ?>
                    var getcon = confirm_bid("uat_auction_form", uwa_bid_value);

                    if (getcon) {

                    <?php } ?>

                    jQuery.ajax({
                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                        type: "post",

                        data: {
                            action: "uat_user_place_bid_ajax",
                            auction_id: <?php echo $product_id; ?>,
                            uwa_bid_value: uwa_bid_value,
                            bidtype:"directbid",
                        },
                        success: function(data) {
                            document.querySelector('#uat-msgbox-message').innerHTML = data ;
                            document.querySelector('.msgbox').click();
                            bid_directly_input.val("");
							 
								var getyimr=jquery_get_new_time("<?php echo $product_id; ?>");
							 
                        },
                        error: function() {}

                    });
                    <?php if ($uat_bid_place_warning  == "on") { ?>
                    }
                <?php } ?>
            });
            // end directbid bid

            // start auctomaticbid bid
            jQuery(document).on('click',".max_bid_directly_btn", function(event) {
                event.preventDefault();
                if(biding_enable != '1')
                {
                    document.querySelector('.feeform').click();
                    return false;
                }
                var bid_directly_input = $(".max_bid_directly_input");
                var current_bid = bid_directly_input.attr('data-max-bid');
               
                var uwa_bid_value = bid_directly_input.val();
                <?php
                    if (!is_user_logged_in()) {
                        $menu_link_types = get_option('options_menu_link_types', "menu_open_in_popup");
                        $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        if ($menu_link_types == 'menu_open_in_direct_link') {
                            $message = sprintf(__("Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>", 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
                        }
               $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid user", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".$message."</div>";
						?>
                        document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                        document.querySelector('.msgbox').click();
                        return false;


                <?php } ?>
                if(!uwa_bid_value){

                  <?php 
                    $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid bid amount", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".__("Please enter automatic bid amount", 'ultimate-auction-pro-software')."</div>";
					?>
                    document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                    document.querySelector('.msgbox').click();
                    return false;
                }
                if(parseFloat(current_bid) > parseFloat(uwa_bid_value)){

                  <?php 
                    $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid bid amount", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".__("Please enter bid value greater than the next bid value", 'ultimate-auction-pro-software')."</div>";
					?>
                    document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
                    document.querySelector('.msgbox').click();
                    return false;
                }
                <?php if ($uat_bid_place_warning  == "on") { ?>
                    var getcon = confirm_bid("uat_auction_form_max", uwa_bid_value);

                    if (getcon) {

                    <?php } ?>

                    jQuery.ajax({
                        url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                        type: "post",

                        data: {
                            action: "uat_user_place_bid_ajax",
                            auction_id: <?php echo $product_id; ?>,
                            uwa_bid_value: uwa_bid_value,
                            bidtype:"maxbidchange",
                        },
                        success: function(data) {
                            document.querySelector('#uat-msgbox-message').innerHTML = data ;
                            document.querySelector('.msgbox').click();
                            bid_directly_input.val("");
							 
								var getyimr=jquery_get_new_time("<?php echo $product_id; ?>");
							 

                        },
                        error: function() {}

                    });
                    <?php if ($uat_bid_place_warning  == "on") { ?>
                    }
                <?php } ?>
            });
            // end auctomaticbid bid
            jQuery(document).on('click','.remove-msg', function(){
                jQuery(".error-msg").fadeOut(1500);
                jQuery(".success-msg").fadeOut(1500);
            });


        }); /* end of document ready */
        function confirm_bid(formname, id_Bid) {
            if (id_Bid != "") {
                if (formname == "uat_auction_form") {                   
					<?php $confirm1 = __("Do you really want to bid 1212", 'ultimate-auction-pro-software'); ?>
					var confirm1 = "<?php echo uat_bid_message_in_popup( $confirm1); ?>";
					
                }
                if (formname == "uat_auction_form_max") {
                   
					<?php $confirm1 = __("Do you really want to change your maximum bid", 'ultimate-auction-pro-software'); ?>
					var confirm1 = "<?php echo uat_bid_message_in_popup( $confirm1); ?>";
                }
                var confirm_message = confirm1 + ' ' + Amount_value_with_currency(id_Bid) + ' ?';
                var result_conf = confirm(confirm_message);
                if (result_conf == false) {
                    event.preventDefault(); /* don't use return it reloads page */
                } else {
                    return true;
                }
            }

        } /* end of function - confirm_bid() */
        function update_bid_list() {
            jQuery.ajax({
                url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                type: "post",
                data: {
                    action: "get_bid_list_ajax",
                    auction_id: <?php echo $product_id; ?>
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    if (jQuery('.uat_auction_bids_history_tab').length) {
                        jQuery('.uat_auction_bids_history_tab a').html('Bids (' + data.count + ')');
                    }
                    jQuery('.uaw-auction-bid-list').html(data.html);
                },
                error: function() {}

            });
        } /* update bid list */
    </script>