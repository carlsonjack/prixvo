<?php

/**
 * The template for displaying event content box in the many template have event box on list, slides, etc
 *
 * This template can be overridden by copying it to yourtheme/templates/events/uat-event-box.php.
 *
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('uat_before_event_box');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
global $wpdb, $post;
global $sitepress;
$event_id =  $post->ID;
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
	$event_id = icl_object_id($event_id, 'product', false, $sitepress->get_default_language());
}
$post_url = get_permalink($event_id);
$featured_img_url = get_the_post_thumbnail_url($event_id, 'events-detail-list-thumbnails');
if (empty($featured_img_url)) {
	$featured_img_url = UAT_THEME_PRO_IMAGE_URI . "front/event_default_banner.png";
}
$event_products_count  = 0;
$lot_ids_array  = get_auction_products_ids_by_event($event_id);
$original_array = unserialize($lot_ids_array);
if(!empty($original_array)){
	$event_products_count  = count($original_array);
}
$all_lot_text = sprintf(__('Discover all %s objects', 'ultimate-auction-pro-software'),$event_products_count);

$uat_expired = uat_event_is_past_event($event_id);
$uat_live = uat_event_is_live($event_id);
$event_status = uat_get_event_status($event_id);
if ($event_status == "uat_live") {
	$sr_only_txt = __("Live Auction", 'ultimate-auction-pro-software');
} elseif ($event_status == "uat_past") {
	$sr_only_txt = __("Past Auction", 'ultimate-auction-pro-software');
} elseif ($event_status == "uat_future") {
	$sr_only_txt = __("Future Auction", 'ultimate-auction-pro-software');
}

$timer_text = "";
$clock_html = "";
$item_class = 'time_countdown_event';

$timer = get_query_var( 'show_timer' , 'false');
$page_id = $_REQUEST['event_page_id']??"";
if ($page_id) {
	$page_template = get_post_meta($page_id, '_wp_page_template', true);
	if ($page_template == "page-templates/template-events-list.php") {
		$timer = get_field('event_list_page_timer', $page_id);
	}
} 
if ($timer === 'true') {
	if ($event_status != "uat_past") {
	

		if ($event_status == "uat_live") {
			$event_end_date = $wpdb->get_var('SELECT event_end_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
			$event_timer_date = $event_end_date;
			$timer_text = __('Ends in', 'ultimate-auction-pro-software');
		} elseif ($event_status == "uat_future") {
			$event_start_date = $wpdb->get_var('SELECT event_start_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
			$event_timer_date = $event_start_date;
			$item_class .= ' scheduled';
			$timer_text = __('Due in', 'ultimate-auction-pro-software');
		}
		ob_start();
		event_countdown_clock(
			$end_date = $event_timer_date,
			$item_id = $event_id,
			$item_class = $item_class
		);
		$clock_html = ob_get_clean();
	} else {
		$timer_text = __('Auction Closed', 'ultimate-auction-pro-software');
	}
}

$timer_text .= $clock_html;

?>
<div class="product-list-item slide-content">
	
	<a href="<?php echo $post_url; ?>" class="product-box-link">
		<div class="c-lot-card__image">
			<div class="image_blocks">
				<img src="<?php echo $featured_img_url; ?>" alt="" class="product-card-img">
			</div>
			<div class="c-lot-card__content">
			<p class="prod-head"><?php the_title(); ?></p>
			<div class="bidding-wrapper">
			<p class="prod-bid-text"><?php echo $all_lot_text; ?></p>
			</div>
			<div class="c-lot-time-time">
				<time class="time-left">
					<?php echo $timer_text; ?>
				</time>
			</div>
			</div>
		</div>
	</a>
</div>
<?php do_action('uat_after_event_box'); ?>