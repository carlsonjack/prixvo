<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-auction-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package Ultimate Auction Theme Pro
 * @since Ultimate Auction Theme Pro 1.0
 */
defined('ABSPATH') || exit;
global $product;
$product_id = $product->get_id();
$uat_event_id = '';
$uat_event_id = uat_get_event_id_by_auction_id($product_id);
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');
if (post_password_required()) {
	echo get_the_password_form();
	return;
}
$auction_id = get_the_ID();

$attachment_ids = $product->get_gallery_image_ids();
$thumb_image_id = $product->get_image_id();
$auction_status = json_chk_auction($product_id);
//$curent_bid = $product->uwa_bid_value();
$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
$display_timezone_ed = get_option('options_uat_auction_timezone', "on");
$display_timezone = "";
if ($display_timezone_ed == "on") {
	$display_timezone = __($timezone_string, 'ultimate-auction-pro-software');
	$display_timezone = "(" . $display_timezone . ")";
}
$setclassfor_design = "";
$seller_user_id = get_post_meta($product_id, 'uat_seller_id', true);
$seller_billing_country_code = "";
$seller_user = "";
if (!empty($seller_user_id)) {
  $seller_user = get_user_by('ID', $seller_user_id);
  $seller_billing_country_code = get_user_meta($seller_user_id, 'billing_country', true);
}

if (json_chk_auction($product_id) == "live") {
	$setclassfor_design = "custom_design_live";
} elseif (json_chk_auction($product_id) == "future") {
	$setclassfor_design = "custom_design_future";
} else {
	$setclassfor_design = "custom_desi	533333gn_expire";
}
$previous_preview_post_link = get_adjacent_post(false, '', true);
$next_preview_post_link = get_adjacent_post(false, '', false);

$user_id = get_current_user_id();
$bid_box_vars = [];
$bid_box_vars['product'] = $product;
$bid_box_vars['product_id'] = $product_id;
$bid_box_vars['auction_status'] = $auction_status;
$seller_email_id = get_post_meta($product_id, 'seller_email_id', true);
/* For Update View count */ 
uat_theme_set_view_count_products();

?>
<?php if (json_chk_auction($product_id) == "live" || json_chk_auction($product_id) == "future") : ?>
<span class='span-auction-id' data-acution-id='<?php echo esc_attr($product_id); ?>' data-user-id='<?php echo esc_attr(get_current_user_id()); ?>'></span>
<?php endif; ?>

<section class="product-details-sec custom_design_live">
   <div class="container">
		<?php /* Top navigation bar */ ?>
   		<?php wc_get_template('single-product/uat-top-bar-navigation.php'); ?>
		<div class="image-gallery">
			<!-- Galleries -->
			<?php wc_get_template('single-product/uat-product-gallery-image.php'); ?>	
			<!-- Galleries -->
		</div>
		

      	<div class="product-destails-desc">
         	<div class="product-details-area">
            	<div class="single_pro_row">
               		<div class="single_pro_left">
						<?php 
							/* Product Title and Subtile */
							wc_get_template('single-product/title.php');
							
							/* Vehicle Specification */ 
							wc_get_template('single-product/uat-vehicle-specification.php'); 
							
							/* content and Vehicle Specification Summary */ 
							wc_get_template('single-product/uat-vehicle-specification-summary.php'); 
							
							/* Vehicle media Gallery */ 
							wc_get_template('single-product/uat-vehicle-media-gallery.php'); 
						?>					
					</div>
					<div class="single_pro_right" id="bid_sec">
						<div class="spr_in_main">
							<?php wc_get_template('single-product/auctions/simple-bid-box.php', $bid_box_vars); ?>
							<a data-fancybox="" data-src="#contact-seller" href="javascript:;" class="black_bg_btn contact-seller">Contact Seller</a>
							<div style="display: none;" id="contact-seller">
								<div class="popup-header">Contact the Seller</div>
								<p><strong>Please note:</strong> You may not ask the seller their reserve price or try to make a deal outside of the auction. Doing so may result in your account being banned.</p>
								<?php echo do_shortcode('[contact-form-7 id="b8b402f" title="Contact the seller"]'); ?>
								<script>
									document.addEventListener("DOMContentLoaded", function() {
										document.querySelector('input[name="auction-name-1"]').value = "<?php echo get_the_title(); ?>";
										document.querySelector('input[name="auction-url-1"]').value = "<?php echo get_permalink(get_the_ID()); ?>";
										document.querySelector('input[name="seller-email-1"]').value = "<?php echo $seller_email_id; ?>";
									});
								</script> 
							</div>
						</div>
					</div>
				</div>
            
				
         	</div>
      	</div>
		  <?php
				$q_a_auction_product_page = get_option('options_q_a_auction_product_page', 'on');
				if ($q_a_auction_product_page == 'on') {
					require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/tpl-questions_answers.php');
				}
			
				$comments = get_option('options_uat_auction_comments', 'on');
				if (!empty($comments) && $comments == 'on') {
					wc_get_template('single-product/product-comments.php');
				}
			?>
	  <?php /*
	  <div class="sticky_bid_footer">
			<div class="sb_inner">
				<div class="sb_l">
					<?php wc_get_template('single-product/title.php'); ?>
					<label class="Current-bid-detail" data-product_id="<?php echo esc_attr($product_id); ?>">
						<span class="current-bid-text" ><?php _e('Current bid', 'ultimate-auction-pro-software'); ?>:</span>				
					</label>
					<h2>
						<?php if ($product->get_uwa_auction_silent() == 'yes') { ?>
							<?php echo __("**********", 'ultimate-auction-pro-software'); ?>
						<?php } else { ?>
						<div class="json_current_bid" data-userid="<?php echo esc_attr($product_id); ?>" data-starting="<?php echo $product->get_uwa_auction_start_price(); ?>">
							<?php echo wc_price($product->get_uwa_current_bid()); ?>
						</div>
						<?php } ?>
					</h2>
					<div class="product-d-timer">
						<?php 
						if (get_option('options_uat_auction_timer', 'on') == 'on' && ($auction_status == "live" || $auction_status == "future")) { ?>
							
									<?php
									$uwa_time_zone =  (array)wp_timezone();
									if ($auction_status == "live") {
										$auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
										$rem_arr = get_remaining_time_by_timezone($auc_end_date);
										countdown_clock(
											$end_date = $auc_end_date,
											$item_id = $product_id,
											$item_class = 'auction-countdown-check',
										);
									} elseif ($auction_status == "future") {
										$auc_end_date = get_post_meta($product_id, 'woo_ua_auction_start_date', true);
										$rem_arr = get_remaining_time_by_timezone($auc_end_date);
										countdown_clock(
											$end_date = $auc_end_date,
											$item_id = $product_id,
											$item_class = 'auction-countdown-check scheduled',
										);
									}
									?>
								
						<?php }else{ 
								if ($auction_status == "past") {
								echo 'Bidding Closed';	
							}
						} ?>
					</div>

				</div>
				<div class="sb_r">
					<a href="#bid_sec" class="default-btn">Place Bid</a>
				</div>
			</div>
		</div>
		<?php */ ?>
	  
	  
   </div>
</section>
