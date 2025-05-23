<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;


if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
if (!$product) {
	$product = get_query_var('product');
}
$product_id = $product->get_id();
$post_url = get_permalink($product_id);
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id, 'events-detail-list-thumbnails');
$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
if (!isset($extra_box_classs)) {
	$extra_box_classs = '';
}
$sub_title = "";
if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {
	// Retrieve the values array passed from the parent file
	$show_bid_status_text = "";
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$show_timer = get_query_var('show_timer', 'on');
	$page = "list";
	if ($page == 'event_detail') {
		$show_timer = get_option('options_event_detail_page_timer', 'off');
	} else if (is_product()) {
		$timer = get_option('options_related_products_timer', 'false');
		$show_timer = 'off';
		if ($timer === 'true') {
			$show_timer = 'on';
		}
	}

	$bid_count = $product->get_uwa_auction_bid_count();
	$auction_status = json_chk_auction($product->get_id());
	$bidding_text = "";
	$bidding_price = 0;
	$timer_text = "";
	$clock_html = "";
	$item_class = 'uwa-main-auction-product-loop  auction-countdown-check';
	$bid_button_text = $product->add_to_cart_text();
	if ($auction_status == "live" || $auction_status == "future") {
		if ($show_timer == 'on') {
			if ($auction_status == "live") {
				$bid_button_text = __('Bid Now', 'ultimate-auction-pro-software');
				$product_timer_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
				$timer_text = __('Ends in', 'ultimate-auction-pro-software');
			} elseif ($auction_status == "future") {
				$bid_button_text = __('Bid Now', 'ultimate-auction-pro-software');
				$product_timer_date = get_post_meta($product_id, 'woo_ua_auction_start_date', true);
				$item_class .= ' scheduled';
				$timer_text = __('Due in', 'ultimate-auction-pro-software');
			}
			ob_start();
			countdown_clock(
				$end_date = $product_timer_date,
				$item_id = $product_id,
				$item_class = $item_class,
			);
			$clock_html = ob_get_clean();
		}
	} else {
		$bidding_price = 0;
	}
	$timer_text .= $clock_html;
	if ($product->get_auction_subtitle()) {
		$sub_title = $product->get_auction_subtitle();
	}
	$auction_text_with_price = $product->get_text_with_price($price = '');
	$bidding_text = '<div class="bidding-wrapper">'; // Opening <div> tag
	$bidding_text .= '<p class="prod-bid-text">' . $auction_text_with_price['text'] . '</p>';
	$bid_amount = $auction_text_with_price['amount'] ?? 0;
	if (!empty($bid_amount) && $bid_amount > 0) {
		$bidding_text .= '<p class="prod-price-amount"> ' . get_woocommerce_currency_symbol() . '' . $bid_amount . '</p>';
	}
	$bidding_text .= '</div>'; // Closing </div> tag
	$bid_button = '<button class="place-bid-btn">' . $bid_button_text . '</button>';
	$bid_status_text = "";

	if (!empty($show_bid_status_text)) {
		if ($auction_status == "live" || $auction_status == "future") {
			$auction_current_bider = $product->get_uwa_auction_current_bider();
			$bid_status_text_class = "";
			if ($auction_current_bider == $current_user_id) {
				$bid_status_text_class = "green";
				$bid_status_text = __('Your bid is on top!', 'ultimate-auction-pro-software');
			} else {
				$bid_status_text_class = "red";
				$bid_status_text = __("You've been outbid!", 'ultimate-auction-pro-software');
			}
		}
	}
?>

	<div <?php wc_product_class('product-list-item' . $extra_box_classs, $product); ?>>
		<a href="<?php echo $post_url; ?>" style="position: absolute;width: 100%;height: 100%; left:0; right: 0;"></a>
		<a href="<?php echo $post_url; ?>" class="product-box-link">
			<div class="c-lot-card__image">
				<div class="saved-icon">
					<?php wc_get_template('loop/uat-auction-saved.php'); ?>
				</div>
				<?php wc_get_template('single-product/share.php'); ?>
				<div class="image_blocks">
					<img src="<?php echo esc_url($thumb_image); ?>" alt="" class="product-card-img">
				</div>
				<div class="c-lot-card__content">

					<p class="prod-head"><?php echo get_the_title(); ?></p>
					<!-- <p class='prod-bid-text-sub'><?php echo $sub_title; ?></p> -->

					<?php echo $bidding_text; ?>
					<?php
					if ($show_timer == 'on') :
					?>
						<div class="c-lot-time-time ">
							<time class="time-left">
								<?php echo $timer_text; ?>
							</time>
						</div>
						<?php
						if (!empty($bid_status_text)) {
							echo '<div class="box_bid_status_text ' . $bid_status_text_class . '"><p class="bid-text">' . $bid_status_text . '</p></div>';
						}
						?>

					<?php endif; ?>

				</div>

			</div>
		</a>
	</div>
<?php
} else {
?>
	<div <?php wc_product_class('product-list-item' . $extra_box_classs, $product); ?>>
		<div class="c-lot-card__image">
			<div class="saved-icon">
				<?php wc_get_template('loop/uat-auction-saved.php'); ?>
			</div>
			<?php wc_get_template('single-product/share.php'); ?>
			<a href="<?php echo $post_url; ?>" class="product-box-link">
				<div class="image_blocks">
					<img src="<?php echo esc_url($thumb_image); ?>" alt="" class="product-card-img">
				</div>
			</a>
			<div class="c-lot-card__content">
				<p class="prod-head"><a href="<?php echo $post_url; ?>" class="product-box-link"><?php echo get_the_title(); ?></a></p>
				<div class="flex-row-block">
					<div class="price_leftside"><?php echo $product->get_price_html(); ?></div>
					<?php do_action('woocommerce_after_shop_loop_item'); ?>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>