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

$curent_bid = get_post_meta($product_id, '_regular_price', true);


$uat_auction_ending_date = get_option('options_uat_auction_ending_date', "on");
$uat_auction_start_date = get_option('options_uat_auction_start_date', "on");

$seller_user_id = get_post_meta($product_id, 'uat_seller_id', true);
$seller_billing_country_code = "";
$seller_user = "";
if (!empty($seller_user_id)) {
    $seller_user = get_user_by('ID', $seller_user_id);
    $seller_billing_country_code = get_user_meta($seller_user_id, 'billing_country', true);
    
}
$seller_email_id = get_post_meta($product_id, 'seller_email_id', true);
?>

<div class="react-div" data-auction-id="<?php echo $product_id; ?>" data-auction-type=""></div>
<div class="product-details-right details spr_inner first-block">
    <div class="timer-closes-text">
	
	<div class="product-d-timer">
        <?php
		 $custom_date_field = get_post_meta(get_the_ID(), 'uwa_custom_date_field', true);
			if (!empty($custom_date_field)) {
				$date = DateTime::createFromFormat('Y-m-d', $custom_date_field);
				if ($date) {
					$formatted_date = $date->format('d/m/Y');
					echo '<span class="closes-text">Listed on </span>';
					echo '<div class="uwa_auction_product_countdown auction-countdown-check clock_jquery hasCountdown">';
					echo esc_html($formatted_date) ;
					echo '</div>';
				}
			}
        ?>
		 </div>
        
    </div>
	
	<?php 
			  
			 
	?>
    <div class="bid-inf-box">
			
			<div class="Current-bid-detail" data-product_id="<?php echo esc_attr($product_id); ?>">
				
				<h5>
					<strong class="current-bid-text" ><?php _e('Price', 'ultimate-auction-pro-software'); ?>:</strong>
				</h5>
				<h5>
					<?php echo $product->get_price_html();; ?>
				</h5>
				
			</div>
			
			<div class="Next-bid-detail">
				<h5>
					<strong>Make an Offer:</strong>
				</h5>
			</div>
			<div class="offer-form">
				<?php if ( is_user_logged_in() ) { ?>
					<?php echo do_shortcode('[contact-form-7 id="bd499ae" title="Make an Offer"]'); ?>
					
				<script>
					document.addEventListener("DOMContentLoaded", function() {
						document.querySelector('input[name="auction-name"]').value = "<?php echo get_the_title(); ?>";
						document.querySelector('input[name="auction-url"]').value = "<?php echo get_permalink(get_the_ID()); ?>";
						document.querySelector('input[name="seller-email"]').value = "<?php echo $seller_email_id; ?>";
					});
				</script> 
					
					
				<?php }else{ ?>
					<div class="make-offer-block">
						<div class="input-with-sign">
							<p><span class="price-sign-cus">$ <span><br>
							</span></span>
									</p>
							<div class="input-box">
								<span class="wpcf7-form-control-wrap" data-name="number-774"><input style="height: 44px;" class="wpcf7-form-control wpcf7-number wpcf7-validates-as-required wpcf7-validates-as-number" aria-required="true" aria-invalid="false" value="" type="number" name="number-774"></span>
								
							</div>
							<a class="black_bg_btn contact-seller" data-fancybox="" style="margin: 0 15px;" data-src="#uat-login-form" href="javascript:;" >Submit</a>
							
						</div>
					</div>
				<?php } ?>
			</div>
			
			
			<div class="faq-link">
				<svg fill="#000000" width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-right: 6px;position: relative;top: 3px;"><g id="SVGRepo_iconCarrier"><path d="M12,22A10,10,0,1,0,2,12,10,10,0,0,0,12,22Zm0-2a1.5,1.5,0,1,1,1.5-1.5A1.5,1.5,0,0,1,12,20ZM8,8.994a3.907,3.907,0,0,1,2.319-3.645,4.061,4.061,0,0,1,3.889.316,4,4,0,0,1,.294,6.456,3.972,3.972,0,0,0-1.411,2.114,1,1,0,0,1-1.944-.47,5.908,5.908,0,0,1,2.1-3.2,2,2,0,0,0-.146-3.23,2.06,2.06,0,0,0-2.006-.14,1.937,1.937,0,0,0-1.1,1.8A1,1,0,0,1,8,9Z"></path></g></svg><a href="https://prixvo.com/faq" target="_blank">Learn how buying works</a>
							
				
			</div>
		
        <div class="uat-bid-summery">
            <?php
            do_action('uat_bid_summery');
            do_action('uat_pay_now_button');
            ?>
        </div>
        <?php /*<div class="icon-with-text">
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
        </div>*/ ?>
        
    </div>
</div>
