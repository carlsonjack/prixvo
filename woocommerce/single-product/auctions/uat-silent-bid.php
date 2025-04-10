<?php

/**
 * Silent Auction Product Bid Area
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

global $woocommerce, $product, $post, $sitepress;

if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction')) {
    return;
}
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
$currency_symbol = $product->uwa_aelia_get_base_currency_symbol();
$product_id =  $product->get_id();
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
    $product_id = icl_object_id($product_id, 'product', false, $sitepress->get_default_language());
}
$user_id = get_current_user_id();

$uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);
$curent_bid = $product->uwa_bid_value();
$bid_increment = $product->get_uwa_auction_bid_increment();
$uat_auction_ending_date = get_option('options_uat_auction_ending_date', "on");
$uat_auction_start_date = get_option('options_uat_auction_start_date', "on");
$auction_status = json_chk_auction($product_id);

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
                        $auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
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
                if ($auction_status == "past") {

                    if ($product->get_uwa_auction_fail_reason() == '1') { ?>
                        <h5><?php _e('Auction has expired because there were no bids', 'ultimate-auction-pro-software'); ?></h5>
                    <?php } elseif ($product->get_uwa_auction_fail_reason() == '2') { ?>
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
        </div>
    <div class="bid-inf-box">
        

        <?php if ($uwa_auction_selling_type_buyitnow != 'buyitnow') :
            $bid_count = $product->get_uwa_auction_bid_count();
            if (empty($bid_count)) {
                $bid_count = 0;
            } ?>

            <?php if ($auction_status == "live" || $auction_status == "future") : ?>
                <div class="Current-bid-detail">
                    <h5>
                        <strong class="current-bid-text" style="display:none"><?php _e('Current bid', 'ultimate-auction-pro-software'); ?>:</strong>
                        <strong class="starting-bid-text" style="display:none"><?php _e('Current bid', 'ultimate-auction-pro-software'); ?>:</strong>
                    </h5>
                    <?php if ($product->get_uwa_auction_current_bid()) { ?>
                        <h5>**********</h5>
                    <?php } else { ?>
                        <h5><?php echo wc_price($product->get_uwa_current_bid()); ?></h5>
                    <?php } ?>
                </div>
            <?php endif; ?>
             
            <?php if ($auction_status == "live") : ?>

                <div class="bid-price-selection place-bid-sec">

                    <p class="uwt-tooltip-block">
                        <?php echo apply_filters('ultimate_auction_theme_pro_silent_bid_text', __("This is a silent auction.", 'ultimate-auction-pro-software')); ?>
                        <a href="" class="uwa_fields_tooltip uwt-tooltip" onclick="return false">
                            <strong><?php _e("This is a silent auction.", 'ultimate-auction-pro-software') ?></strong>
                        </a>
                        <span class="uwt-tooltip">
                            <?php _e("A silent bid auction is a type of auction process in which all bidders simultaneously submit sealed bids to the auctioneer, so that no bidder knows how much the other auction participants have bid. The highest bidder is usually declared the winner of the bidding process", 'ultimate-auction-pro-software') ?>
                        </span>
                    </p>
                    <form id="uat_auction_form Silent-auction" class="uat_auction_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo $product_id; ?>">

                        <div class="two-attr-block">
                            <input type="number" class="bid_directly_input" name="bid_directly_input" id="bid_directly_input">
                            <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                            <?php if (!is_user_logged_in()) { ?>
                                <button type="button" id="uat_placebidbutton" class="black_bg_btn bid_directly_btn">
                                    <?php echo apply_filters('uat_detail_page_direct_bid_button_text', __('Exact Bid', 'ultimate-auction-pro-software')); ?> </button>
                            <?php } else { ?>
                                <button type="submit" id="uat_placebidbutton" class="black_bg_btn bid_directly_btn">
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
					
                </div>
            <?php endif; ?>
        <?php endif; ?>
		<div class="faq-link"><svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="
    margin-right: 6px;
    position: relative;
    top: 3px;
"><g id="SVGRepo_iconCarrier"><path d="M12,22A10,10,0,1,0,2,12,10,10,0,0,0,12,22Zm0-2a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,12,20ZM8,8.994a3.907,3.907,0,0,1,2.319-3.645,4.061,4.061,0,0,1,3.889.316,4,4,0,0,1,.294,6.456,3.972,3.972,0,0,0-1.411,2.114,1,1,0,0,1-1.944-.47,5.908,5.908,0,0,1,2.1-3.2,2,2,0,0,0-.146-3.23,2.06,2.06,0,0,0-2.006-.14,1.937,1.937,0,0,0-1.1,1.8A1,1,0,0,1,8,9Z"></path></g></svg><a href="<?php echo home_url(); ?>/faq" target="_blank">Learn how buying works</a></a></div>
        <?php
        $buyNowPrice = get_post_meta($product_id, '_regular_price', true);
        $uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);

        if ($auction_status == "live" && $buyNowPrice > 0 && $buyNowPrice > $curent_bid && ($uwa_auction_selling_type_buyitnow == "both" || $uwa_auction_selling_type_buyitnow == "buyitnow")) {
        ?> <form class="buy-now cart buy-now-frm buy-now-singal-product" method="post" enctype='multipart/form-data' data-product_id="<?php echo $product_id; ?>">
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
        <div class="uat-bid-summery">
            <?php
            do_action('uat_bid_summery');
            do_action('uat_pay_now_button');
            ?>
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
            <?php if ($uat_bid_place_warning  == "on") { ?>
                var getcon = confirm_bid("uat_auction_form", uwa_bid_value);
                if (getcon) {
                <?php } ?>
                var formname = "uat_auction_form";
                var id_Bid = jQuery('#bid_directly_input').val();

                jQuery.ajax({
                    url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                    type: "post",

                    data: {
                        action: "uat_user_place_bid_ajax",
                        auction_id: <?php echo $product_id; ?>,
                        uwa_bid_value: id_Bid
                    },
                    success: function(data) {

                        document.querySelector('#uat-msgbox-message').innerHTML = data;
                        document.querySelector('.msgbox').click();
                        jQuery('#bid_directly_input').val("");

                    },
                    error: function() {}

                });


                <?php if ($uat_bid_place_warning  == "on") { ?>
                }
            <?php } ?>
        });


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
                $confirm = addslashes(__("Do you really want to bid", 'ultimate-auction-pro-software'));
                $confirm_f = preg_replace("/<br>|\n/", "", $confirm);
                ?>
                var confirm_msg = "<?php echo $confirm_f; ?>";

                var confirm1 = confirm_msg;
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