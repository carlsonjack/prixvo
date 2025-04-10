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

global $woocommerce, $product, $post,$sitepress;

if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction')) {
	return;
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
$currency_symbol = $product->uwa_aelia_get_base_currency_symbol();
$product_id =  $product->get_id();
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
    $product_id = icl_object_id($product_id,'product',false, $sitepress->get_default_language());
}
$uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);
$curent_bid = $product->uwa_bid_value();
$bid_increment = $product->get_uwa_auction_bid_increment();
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
                    <span><i class="fas fa-long-arrow-alt-left"></i></span>
                </a>
            </div>
            <?php } else { ?>
            <div class="prev-lot">
                <?php previous_post_link('%link', esc_attr__('Pre', 'ultimate-auction-pro-software'), TRUE, ' ', 'product_cat'); ?>
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
                    <span><i class="fas fa-long-arrow-alt-right"></i></span>

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

        <?php if (get_option('options_uat_auction_timer', 'on') == 'on' && ($auction_status == "live" || $auction_status == "future")) { ?>
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
					$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_end_date', true );
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
            <?php
                if ($auction_status == "live" || $auction_status == "future" ) {
                    if($auction_status == "future" && $uat_auction_start_date == "on"){
            ?>
                <div class="lot-close-date">
                    <h5>
                            <strong><?php _e('Live auction begins on:', 'ultimate-auction-pro-software'); ?></strong></h5>
                        <h5><small><?php echo  date_i18n(get_option('date_format'),  strtotime($product->get_uwa_auction_start_time()));  ?>,
                        <?php echo  date_i18n(get_option('time_format'),  strtotime($product->get_uwa_auction_start_time()));  ?>
                        <?php echo $display_timezone; ?></small>
                    </h5>
                </div>
            <?php
                }
                if($uat_auction_ending_date == "on"){
            ?>
              <div class="lot-close-date">
                    <h5><strong><?php _e('Lot closes', 'ultimate-auction-pro-software'); ?>:</strong></h5>
                        <h5><small class="auction-ends-date"><?php echo  date_i18n(get_option('date_format'),  strtotime($product->get_uwa_auctions_end_time()));  ?>,
                            <?php echo  date_i18n(get_option('time_format'),  strtotime($product->get_uwa_auctions_end_time()));  ?>
                            <?php echo $display_timezone; ?></small>
                    </h5>
              </div>
            <?php } ?>
           <?php } elseif ($auction_status == "past") {
				
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


        <?php if ($uwa_auction_selling_type_buyitnow != 'buyitnow') : 
		$bid_count = $product->get_uwa_auction_bid_count();
        if(empty($bid_count)){ $bid_count = 0;} ?>

        <?php if ($auction_status == "live" || $auction_status == "future") : ?>
        <div class="Current-bid-detail">
            <h5>
                <strong class="current-bid-text" style="display:none"><?php _e('Current bid', 'ultimate-auction-pro-software'); ?>:</strong>
                <strong class="starting-bid-text" style="display:none"><?php _e('Starting bid', 'ultimate-auction-pro-software'); ?>:</strong>
                <?php if ($bid_count > 1) { ?>
                <small>(<?php echo '<span class="auction-bid-count">' . $bid_count . '</span>'; ?>
                    <?php _e("Bids", "ultimate-auction-pro-software") ?>)</small>
                <?php } else { ?>
                <small>(<?php echo '<span class="auction-bid-count">' . $bid_count . '</span>'; ?>
                    <?php _e("Bid", "ultimate-auction-pro-software") ?>)</small>
                <?php } ?>
            </h5>
            <?php if ($product->get_uwa_auction_current_bid()) { ?>
            <h5>**********</h5>
            <?php } else { ?>
            <h5><?php echo wc_price($product->get_uwa_current_bid()); ?></h5>
            <?php } ?>
        </div>
        <?php endif; ?>

        <?php
		if (!empty($product->get_estimate_price_from()) || !empty($product->get_estimate_price_to())) : ?>
        <div class="lot-close-detail">
            <h5><strong><?php _e('Estimate', 'ultimate-auction-pro-software'); ?>:</strong></h5>
            <h5 class="Estimateed-price"><?php echo wc_price($product->get_estimate_price_from()); ?> -
                <?php echo wc_price($product->get_estimate_price_to()); ?></h5>
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


            <div class="bid-price-l">

                <h5 style="margin-bottom: 0;"><strong><?php _e("SET YOUR BID", 'ultimate-auction-pro-software') ?></strong>
                </h5>

                <div class="pricel-l-right" style="display: flex;align-items: center;">
                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock"
                        class="svg-inline--fa fa-lock fa-w-14 ItemBiddingAbsentee__StyledLockIcon-sc-20yfl8-6 bkhYfT"
                        role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                        style="height: 14px;width: 14px;">
                        <path fill="currentColor"
                            d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z"
                            style="width: 20px;height: 220px;"></path>
                    </svg>
                    <h5 style="padding-left: 2px;margin-bottom: 0;">
                        <strong><?php _e('SECURE', 'ultimate-auction-pro-software'); ?></strong>
                    </h5>
                </div>
            </div>

            <form id="uat_auction_form Silent-auction" class="uat_auction_form cart" method="post" enctype='multipart/form-data'
                data-product_id="<?php echo $product_id; ?>">

                <div class="two-attr-block">
                    <input type="number" class="bid_directly_input" name="bid_directly_input" id="bid_directly_input" >
                    <span><?php echo get_woocommerce_currency_symbol(); ?></span>
                    <?php if (!is_user_logged_in()) { ?>
                        <button type="button" id="uat_placebidbutton" class="black_bg_btn bid_directly_btn" >
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
        <?php
            $buyNowPrice = get_post_meta($product_id, '_regular_price', true);
            $uwa_auction_selling_type_buyitnow = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);

            if ($auction_status == "live" && $buyNowPrice > 0 && $buyNowPrice > $curent_bid && ($uwa_auction_selling_type_buyitnow == "both" || $uwa_auction_selling_type_buyitnow == "buyitnow")) {
        ?> <form class="buy-now cart buy-now-frm buy-now-singal-product" method="post" enctype='multipart/form-data'
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
				
					var bid_directly_input = $(".bid_directly_input");
					var current_bid = bid_directly_input.attr('data-current-bid');
					var uwa_bid_value = bid_directly_input.val();					
					if(!uwa_bid_value){
						<?php
						$bidvallue_msg ="<div class='msgbox-title msgbox-title-red' id='outbidMsg'>".__("Invalid bid amount", 'ultimate-auction-pro-software')."</div><div class='msgbox-text'>".__("Please enter bid amount", 'ultimate-auction-pro-software')."</div>";
						?>
						document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup( $bidvallue_msg); ?>";
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

								document.querySelector('#uat-msgbox-message').innerHTML = data ;
								document.querySelector('.msgbox').click();
								jQuery('#bid_directly_input').val("");

							},
							error: function() {}

						});
					
					
					 <?php if ($uat_bid_place_warning  == "on") { ?>
                    }
                <?php } ?>	
				});
							
			
			jQuery(document).on('click','.remove-msg', function(){
            jQuery(".error-msg").fadeOut(1500);
            jQuery(".success-msg").fadeOut(1500);
        });
		}); /* end of document ready */

		function confirm_bid(formname, id_Bid) {
			if (id_Bid != "") {
				var confirm1 ="";
				if (formname == "uat_auction_form") {
					<?php
					  $confirm = addslashes(__("Do you really want to bid", 'ultimate-auction-pro-software'));					
					  $confirm_f = preg_replace( "/<br>|\n/", "", $confirm );
					?>
                        var confirm_msg = "<?php echo $confirm_f; ?>";
					
                    var confirm1 = confirm_msg;
				}

				var confirm_message = confirm1 +  ' ' + Amount_value_with_currency(id_Bid) + ' ?';
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