<?php
global $wpdb, $woocommerce, $sitepress;
if (is_user_logged_in()) {
	$limit = get_sub_field('uat_active_bid_section_no');
	if (empty($limit)) {
		$limit = 10;
	}
	$user_id  = get_current_user_id();
	$table = $wpdb->prefix . "woo_ua_auction_log";
	$table2 = $wpdb->prefix . "ua_auction_product";
	$auction_status = 'uat_live';
	// $valid_status = getValidStatusForProductVisible();
	$valid_status[] = 'uat_live';
	$valid_status[] = 'uat_in_auction';
	$valid_status[] = 'publish';
	$valid_status =  implode("', '", $valid_status);

	$my_active_bids = $wpdb->get_results("SELECT $table.auction_id FROM $table
	INNER JOIN $table2  ON $table.auction_id = $table2 .post_id
	 WHERE $table.userid = $user_id  and $table2 .auction_status IN ( '" . $valid_status . "' ) GROUP by auction_id ORDER by date DESC LIMIT $limit");
	if (count($my_active_bids) > 0) {
		$auctionIds = [];
		foreach ($my_active_bids as $item) {
			$auctionIds[] = $item->auction_id;
		}
		$args = array(
			'post_type'	=> 'product',
			'post_status' => $valid_status,
			'ignore_sticky_posts'	=> 1,
			'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),
		);
		$args['post__in'] = $auctionIds;
		$products = new WP_Query($args);
		if ($products->have_posts()) {
?>
			<section class="currant-and-upcoming-auction">
				<div class="container">
					<div class="section-heading">
						<h4><?php esc_attr(the_sub_field('uat_active_bid_section_title')); ?></h4>
						<?php $uat_active_bid_section_link = get_sub_field('uat_active_bid_section_link'); ?>
						<?php if ($uat_active_bid_section_link) { ?>
							<a href="<?php echo esc_url($uat_active_bid_section_link['url']); ?>" target="<?php echo esc_attr($uat_active_bid_section_link['target']); ?>"><?php echo esc_attr($uat_active_bid_section_link['title']); ?></a>
						<?php } ?>
					</div>
					<div class="owl-carousel trending-item-slider">

						<?php while ($products->have_posts()) : $products->the_post();
							global $product;
							$thumb_id = get_post_thumbnail_id();
							$thumb_url = wp_get_attachment_image_src($thumb_id, 'events-detail-list-thumbnails');
							$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
							$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
						?>
							<div class="owl-item">
								<?php
								$timer = get_sub_field('uat_content_trending_items_timer');
								set_query_var('show_timer', ($timer == 'true') ? 'on' : 'off');
								wc_get_template_part('content', 'product');
								?>
							</div>
						<?php endwhile; // end of the loop. 
						?>
					</div>
				</div>
			</section>
	<?php }
	} ?>
<?php } ?>