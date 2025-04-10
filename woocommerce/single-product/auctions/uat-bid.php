<?php
/*
/**
 * Auction Simple Auction Bid Area
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if (!defined('ABSPATH')) {
    exit;
}
global $woocommerce, $product, $post;
global $sitepress;
if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction')) {
    return;
}
$product_id =  $product->get_id();
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
    $product_id = icl_object_id($product_id, 'product', false, $sitepress->get_default_language());
}
$auction_status = json_chk_auction($product_id);
$user_id = get_current_user_id();

$date_format = get_option('date_format');
$time_format = get_option('time_format');
$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
$display_timezone_ed = get_option('options_uat_auction_timezone', "on");
$display_timezone = "";
if ($display_timezone_ed == "on") {
    $display_timezone = __($timezone_string, 'ultimate-auction-pro-software');
    $display_timezone = "(" . $display_timezone . ")";
}

$uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);

$curent_bid = $product->uwa_bid_value();
$bid_increment = $product->get_uwa_increase_bid_value();
$next_bids = $product->get_uwa_number_of_next_bids();
$no_of_next_bids = !empty($next_bids) ? $next_bids : 10;
$uat_variable_inc_enable = $product->get_uwa_auction_variable_bid_increment();
$ua_inc_price_range = "";
if (empty($bid_increment)) {
    if (!empty($product->get_event_id())) {
        $bid_increment = get_option('options_uat_global_bid_increment_event', $bid_increment);
    } else {
        $bid_increment = get_option('options_uat_global_bid_increment', $bid_increment);
    }
}
$ua_inc_price_range = "";
if ($uat_variable_inc_enable == 'yes') {
    $variable_type = get_post_meta($product_id, 'uwa_auction_variable_bid_increment_type', true);
    if ($variable_type == "global") {
        $ua_inc_price_range =    $product->get_uwa_var_inc_price_val();
    } else {
        $ua_inc_price_range = get_post_meta($product_id, 'uwa_var_inc_price_val', true);
    }
    if (!empty($ua_inc_price_range)) {
        foreach ($ua_inc_price_range as $range) {
            if (($range['start'] <= $curent_bid) && ($range['end'] >= $curent_bid)) {
                $bid_increment = $range['inc_val'];
                break;
            }
            if (($range['start'] <= $curent_bid) && ($range['end'] == 'onwards')) {
                $bid_increment = $range['inc_val'];
                break;
            }
        }
    }
}
$uat_auction_ending_date = get_option('options_uat_auction_ending_date', "on");
$uat_auction_start_date = get_option('options_uat_auction_start_date', "on");

$seller_user_id = get_post_meta($product_id, 'uat_seller_id', true);
$seller_billing_country_code = "";
$seller_user = "";
if (!empty($seller_user_id)) {
    $seller_user = get_user_by('ID', $seller_user_id);
    $seller_billing_country_code = get_user_meta($seller_user_id, 'billing_country', true);
}
?>

<div class="react-div" data-auction-id="<?php echo $product_id; ?>" data-auction-type=""></div>
<div class="product-details-right details spr_inner first-block">
    <div class="timer-closes-text">
        <?php
        if (get_option('options_uat_auction_timer', 'on') == 'on' && ($auction_status == "live" || $auction_status == "future")) { ?>
            <div class="product-d-timer">
                <?php
                $uwa_time_zone =  (array)wp_timezone();
                if ($auction_status == "live") {
                    echo '<span class="closes-text">' . __('Ends in', 'ultimate-auction-pro-software') . '</span>';
                    $uwa_remaining_seconds = $product->get_uwa_remaining_seconds();
                    $auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
                    $rem_arr = get_remaining_time_by_timezone($auc_end_date);
                ?>

                    <?php
                    countdown_clock(
                        $end_date = $auc_end_date,
                        $item_id = $product_id,
                        $item_class = 'auction-countdown-check',
                    );
                    ?>
                <?php  } elseif ($auction_status == "future") {
                    echo '<span class="closes-text">' . __('Starts in', 'ultimate-auction-pro-software') . '</span>';
                    $auc_end_date = get_post_meta($product_id, 'woo_ua_auction_start_date', true);
                    $rem_arr = get_remaining_time_by_timezone($auc_end_date);
                ?>
                    <?php
                    countdown_clock(
                        $end_date = $auc_end_date,
                        $item_id = $product_id,
                        $item_class = 'auction-countdown-check scheduled',
                    );
                    ?>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="lot-close-detail-date">
            <?php
            if  ($auction_status == "past") {

                if ($product->get_uwa_auction_fail_reason() == '1') { ?>

                    <h5><?php _e('Auction has expired because there were no bids', 'ultimate-auction-pro-software'); ?></h5>

                <?php } elseif ($product->get_uwa_auction_fail_reason() == '2') { ?>

                    <h5><?php _e('Auction has expired without reaching its reserve price', 'ultimate-auction-pro-software'); ?> </h5>

                <?php } ?>

                <?php if ($product->get_uwa_auction_expired() == '3') { ?>

                    <span class="auction-ends-date" style="display:none"></span>
                    <h5><?php _e('This Auction Product has been sold for buy it now price', 'ultimate-auction-pro-software'); ?>: <?php echo wc_price($product->get_regular_price()) ?></h5>

                <?php } ?>

                <?php if ($product->get_uwa_auction_expired() == '2') { ?>

                    <span class="auction-ends-date" style="display:none"></span>
                    <h5><?php _e('This auction product has expired', 'ultimate-auction-pro-software'); ?> </h5>

                <?php } ?>

            <?php } ?>
        </div>
    </div>
    <div class="bid-inf-box">
        <?php
        if ($uwa_auction_selling_type_buyitnow != 'buyitnow') :    
            $uwa_reserve_txt = __('No reserve', 'ultimate-auction-pro-software');
            if ($product->is_uwa_reserve_enabled()) {
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
                    $uwa_reserve_txt = __('Reserve price not met', 'ultimate-auction-pro-software');
                }
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
                    $uwa_reserve_txt = __('Reserve price met', 'ultimate-auction-pro-software');
                }
            } else {
                $uwa_reserve_txt = __('No reserve', 'ultimate-auction-pro-software');
            }
            $bid_count = $product->get_uwa_auction_bid_count();
            if (empty($bid_count)) {
                $bid_count = 0;
            }
        ?>
            <?php if ($auction_status == "live" || $auction_status == "future") : ?>
                <div class="bid-status-msg bid-status-msg-green" id="bid-status-msg-top"><?php _e('Your bid is on top!', 'ultimate-auction-pro-software'); ?></div>
                <div class="bid-status-msg bid-status-msg-red" id="bid-status-msg-outbid"><?php _e("You've been outbid!", 'ultimate-auction-pro-software'); ?></div>
                <div class="Current-bid-detail" data-product_id="<?php echo esc_attr($product_id); ?>">
                    <h5>
                        <strong class="current-bid-text" style="display:none"><?php _e('Current bid', 'ultimate-auction-pro-software'); ?></strong>
                        <strong class="starting-bid-text" style="display:none"><?php _e('Starting bid', 'ultimate-auction-pro-software'); ?></strong>
                    </h5>
                    <h5>
                        <div class="json_current_bid" data-userid="<?php echo esc_attr($product_id); ?>" data-starting="<?php echo $product->get_uwa_auction_start_price(); ?>">
                            <?php echo wc_price($product->get_uwa_auction_start_price()); ?></div>
                    </h5>
                    <?php 
                        if ($auction_status == "live") {
                            echo '<span class="auction-reserve-price-text">' . $uwa_reserve_txt . '</span>'; 
                        }
                    ?>
                </div>
                <?php if ($auction_status == "live") { ?>
                    <div class="Next-bid-detail">
                        <h5>
                            <strong><?php _e('Minimum Bid', 'ultimate-auction-pro-software'); ?>:</strong>
                        </h5>
                        <h5 class="pricel-l-right">
                            <div class="json_next_bid" data-userid="<?php echo esc_attr($product_id); ?>" data-starting="<?php echo $product->get_uwa_auction_start_price(); ?>"><?php echo wc_price($product->get_uwa_auction_start_price()); ?></div>
                        </h5>
                    </div>
                <?php } ?>
                <?php if (!empty($product->get_estimate_price_from()) || !empty($product->get_estimate_price_to())) : ?>
                    <div class="estimate-values">
                        <h5>
                            <strong><?php _e('Estimated value', 'ultimate-auction-pro-software'); ?>:</strong>
                            <div class="value-right">
                                <?php echo wc_price($product->get_estimate_price_from()); ?> -
                                <?php echo wc_price($product->get_estimate_price_to()); ?>
                            </div>
                        </h5>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
            <!-- <small><a id="bid-inc-tab" href="#tab-uat_auction_bids_increments"><?php _e('Increment details', 'ultimate-auction-pro-software'); ?></a></small> -->
            <?php if ($auction_status == "live") : ?>
                <div class="bid-price-selection place-bid-sec">
                    <?php
                    $field_options_to_place_bid = get_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
                    if ($field_options_to_place_bid == "show-drop-down-with-bid-values") { ?>
                        <form id="uat_auction_form" class="uat_auction_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $product_id; ?>">
                            <div class="jdropdown" data-auctionid="<?php echo esc_attr($product_id); ?>"></div>
                            <?php
                            $narr = array();
                            if ($ua_inc_price_range) {
                                foreach ($ua_inc_price_range as $range) {
                                    $narr[] = $range;
                                }
                            }
                            ?>
                            <div id="reactsel" data-total-bids="<?php echo $no_of_next_bids; ?>" data-inc-enable="<?php echo $uat_variable_inc_enable; ?>" data-current-bid="<?php echo $curent_bid; ?>" data-price-range="<?php echo htmlspecialchars(json_encode($narr)); ?>" data-bid-increment="<?php echo $bid_increment; ?>" data-userid="<?php echo $product_id; ?>">
                            </div>
                            <div class="product-details-btn">
                                <?php if (!is_user_logged_in()) { ?>
                                    <button type="button" id="uat_placebidbutton" class="black_bg_btn bid_directly_btn" onclick="location.href='<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>'">
                                        <?php _e('Bid', 'ultimate-auction-pro-software'); ?> </button>
                                <?php } else { ?>
                                    <button type="submit" id="uat_placebidbutton" class="ua-button-black">
                                        <?php _e('Bid', 'ultimate-auction-pro-software'); ?> </button>
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
                    <?php if ($field_options_to_place_bid == "show-text-field-and-quick-bid") { ?>
                        <?php
                        $narr = array();
                        if ($ua_inc_price_range) {

                            foreach ($ua_inc_price_range as $range) {
                                $narr[] = $range;
                            }
                        }

                        $hide_quick_bid = get_option('options_hide_quick_bid_buttons_simple', "off");
                        if ($hide_quick_bid == "off") {  ?>
                            <div class="bid-price-l">
                                <h5 style="margin-bottom: 0;"><strong><?php _e('Quick bid', 'ultimate-auction-pro-software'); ?></strong>
                            </div>
                        <?php } ?>
                        <div id="reactplacebid" data-total-bids="<?php echo $no_of_next_bids; ?>" data-inc-enable="<?php echo $uat_variable_inc_enable; ?>" data-current-bid="<?php echo $curent_bid; ?>" data-price-range="<?php echo htmlspecialchars(json_encode($narr)); ?>" data-bid-increment="<?php echo $bid_increment; ?>" data-userid="<?php echo $product_id; ?>"></div>
                        <?php if ($hide_quick_bid == "off") {  ?>
                            <div class="three-btn quick-bid-btns"></div>
                        <?php } ?>
                        <div class="bid-price-l">
                            <h5 style="margin-bottom: 0;"><strong><?php _e('Direct Bid', 'ultimate-auction-pro-software'); ?></strong>
                        </div>
                        <div class="two-attr-block">
                            <input type="number" class="bid_directly_input" name="bid_directly_input" data-current-bid="<?php echo $curent_bid; ?>">
                            <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                            <?php if (is_user_logged_in()) { ?>
								<button class="black_bg_btn bid_directly_btn"><?php _e('Place Bid', 'ultimate-auction-pro-software'); ?></button>
							<?php }else{ ?>
								<a  data-fancybox="" style="width: 200px;padding: 10px 16px;display: inline-block;margin: 0;margin-left: 10px;" data-src="#uat-login-form" href="javascript:;" class="black_bg_btn contact-seller"><?php echo apply_filters('uat_detail_page_direct_bid_button_text', __('Place Bid', 'ultimate-auction-pro-software')); ?></a>
							<?php } ?>
                        </div>
                        <div class="error-msg-box" id="bid_msg"></div>
                    <?php  } ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
		<div class="faq-link"><svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="
    margin-right: 6px;
    position: relative;
    top: 3px;
"><g id="SVGRepo_iconCarrier"><path d="M12,22A10,10,0,1,0,2,12,10,10,0,0,0,12,22Zm0-2a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,12,20ZM8,8.994a3.907,3.907,0,0,1,2.319-3.645,4.061,4.061,0,0,1,3.889.316,4,4,0,0,1,.294,6.456,3.972,3.972,0,0,0-1.411,2.114,1,1,0,0,1-1.944-.47,5.908,5.908,0,0,1,2.1-3.2,2,2,0,0,0-.146-3.23,2.06,2.06,0,0,0-2.006-.14,1.937,1.937,0,0,0-1.1,1.8A1,1,0,0,1,8,9Z"></path></g></svg><a href="<?php echo home_url(); ?>/faq" target="_blank">Learn how buying works</a></div>
        <?php
        $buyNowPrice = get_post_meta($product_id, '_regular_price', true);
        $uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);

        if ($auction_status == "live" && $buyNowPrice > 0 && $buyNowPrice > $curent_bid && ($uwa_auction_selling_type_buyitnow == "both" || $uwa_auction_selling_type_buyitnow == "buyitnow")) {
        ?>
            <form class="buy-now cart buy-now-frm buy-now-singal-product" method="post" enctype='multipart/form-data' data-product_id="<?php echo $product_id; ?>">
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
        <div class="uat-bid-summery">
            <?php
            do_action('uat_bid_summery');
            do_action('uat_pay_now_button');
            ?>
        </div>
        <div class="icon-with-text">
            <?php
              $shippingText =  getShippingValues($user_id, $product_id);
              if (!empty($shippingText)) {
            ?>
                  <div class="icon-with-text-inner">
                      <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ship-arrive.png">
                      <span>
                          <?php echo getShippingValues($user_id, $product_id); ?>
                      </span>
                  </div>
              <?php
              }
             
            ?>
        <?php if ($auction_status == "live" || $auction_status == "future") :  echo apply_filters('uat_product_detail_bp_text_html', $product_id);  endif; ?>
        </div>
        <div class="bid-table-box">
            <?php
            wc_get_template('single-product/auctions/bids-history.php');
            ?>
        </div>
    </div>
</div>
<a data-fancybox data-src="#uat-onetime-fee-form" class="feeform" href="javascript:;"></a>
<a data-fancybox data-src="#uat-msgbox" class="msgbox" href="javascript:;"></a>
<?php $uat_bid_place_warning = get_option('options_uat_bid_place_warning', 'on'); ?>
<?php $uat_fee_to_place_bid = get_option('options_uat_fee_to_place_bid', 'off');
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
                    if (data.order_create == 1) {
                        window.location.href = data.checkout_url;
                    }
                    if (data.order_create == 3) {
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
            if (biding_enable != '1') {
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
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" . __("Invalid user", 'ultimate-auction-pro-software') . "</div><div class='msgbox-text'>" . $message . "</div>";
            ?>
                document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup($bidvallue_msg); ?>";
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
                        document.querySelector('#uat-msgbox-message').innerHTML = data;
                        document.querySelector('.msgbox').click();

                        var getyimr = jquery_get_new_time("<?php echo $product_id; ?>");

                    },
                    error: function() {}
                });
                <?php if ($uat_bid_place_warning  == "on") { ?>
                }
            <?php } ?>
        });
        // end dropdown bid


        // start quickbid button
        jQuery(document).on('click', ".quick_bid_button_one", function(event) {
            event.preventDefault();
            if (biding_enable != '1') {
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
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" . __("Invalid user", 'ultimate-auction-pro-software') . "</div><div class='msgbox-text'>" . $message . "</div>";
            ?>
                document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup($bidvallue_msg); ?>";
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
                        uwa_bid_value: uwa_bid_value
                    },
                    success: function(data) {
                        document.querySelector('#uat-msgbox-message').innerHTML = data;
                        document.querySelector('.msgbox').click();
                        var getyimr = jquery_get_new_time("<?php echo $product_id; ?>");
                    },
                    error: function() {}

                });
                <?php if ($uat_bid_place_warning  == "on") { ?>
                }
            <?php } ?>
        });
        // end quickbid button

        // start directbid bid
        jQuery(document).on('click', ".bid_directly_btn", function(event) {
            event.preventDefault();
            if (biding_enable != '1') {
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
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" . __("Invalid user", 'ultimate-auction-pro-software') . "</div><div class='msgbox-text'>" . $message . "</div>";
            ?>
                document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup($bidvallue_msg); ?>";
                document.querySelector('.msgbox').click();
                return false;

            <?php } ?>
            var bid_directly_input = $(".bid_directly_input");
            var current_bid = bid_directly_input.attr('data-current-bid');
            var uwa_bid_value = bid_directly_input.val();
            if (!uwa_bid_value) {
                <?php
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" . __("Invalid bid amount", 'ultimate-auction-pro-software') . "</div><div class='msgbox-text'>" . __("Please enter bid amount", 'ultimate-auction-pro-software') . "</div>";
                ?>
                document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup($bidvallue_msg); ?>";
                document.querySelector('.msgbox').click();
                return false;
            }
            if (parseFloat(current_bid) > parseFloat(uwa_bid_value)) {
                <?php
                $bidvallue_msg = "<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" . __("Invalid bid amount", 'ultimate-auction-pro-software') . "</div>
                <div class='msgbox-text'>" . __("Please enter bid value greater than the next bid value", 'ultimate-auction-pro-software') . "</div>";
                ?>
                document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup($bidvallue_msg); ?>";
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
                        bidtype: "directbid",
                    },
                    success: function(data) {
                        document.querySelector('#uat-msgbox-message').innerHTML = data;
                        document.querySelector('.msgbox').click();
                        bid_directly_input.val("");
                        var getyimr = jquery_get_new_time("<?php echo $product_id; ?>");
                    },
                    error: function() {}

                });
                <?php if ($uat_bid_place_warning  == "on") { ?>
                }
            <?php } ?>
        });
        // end directbid bid
        jQuery(document).on('click', '.remove-msg', function() {
            jQuery(".error-msg").fadeOut(1500);
            jQuery(".success-msg").fadeOut(1500);
        });

    }); /* end of document ready */
    function confirm_bid(formname, id_Bid) {
        if (id_Bid != "") {

            var confirm1 = "";
            if (formname == "uat_auction_form") {
                <?php
                $confirm = __("Do you really want to bid", 'ultimate-auction-pro-software');
                ?>

                var confirm1 = "<?php echo uat_bid_message_in_popup($confirm); ?>";
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
</script>