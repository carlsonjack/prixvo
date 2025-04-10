<?php
global $wpdb, $woocommerce,$sitepress;
$page_id = get_the_ID();
$car_page_sidebar_no_auctions = get_field('car_page_sidebar_no_auctions', $page_id);

$car_page_sidebar_no_auctions_display = '';
if ( $car_page_sidebar_no_auctions <= 0) {
    $car_page_sidebar_no_auctions_display = 'style="display:none"';
}
$car_page_sidebar_title = get_field('car_page_sidebar_title', $page_id);

$car_page_sidebar_car_show_title = get_field('car_page_sidebar_car_show_title', $page_id);
$car_page_sidebar_car_show_subtitle = get_field('car_page_sidebar_car_show_subtitle', $page_id);
$car_page_sidebar_car_show_watchlist = get_field('car_page_sidebar_car_show_watchlist', $page_id);
$car_page_sidebar_car_show_highlights = get_field('car_page_sidebar_car_show_highlights', $page_id);
$car_page_sidebar_car_show_location = get_field('car_page_sidebar_car_show_location', $page_id);
$front_end_watch_list_display=get_field( 'front_end_watch_list_display', 'option' );


echo '<div class="sidebar">';
if( $car_page_sidebar_title ) {
   echo '<div class="sidebar-heading"><h2>'. $car_page_sidebar_title .'</h2></div>';
}


if ( $car_page_sidebar_no_auctions > 0) {

        $postids  = uat_get_live_auctions_ids();

		if (empty($postids)) {
			$postids[] = array();
		}
		$query_args = array('posts_per_page' => $car_page_sidebar_no_auctions, 'no_found_rows' => 1, 'post_status' => 'publish', 'post_type' => 'product');
		$query_args['meta_query'] = array();
		$query_args['meta_query'][]    = $woocommerce->query->stock_status_meta_query();
		$query_args['meta_query'][] = array('key' => 'uat_event_id', 'compare' => 'NOT EXISTS');
		$query_args['meta_query']      = array_filter($query_args['meta_query']);
		$query_args['tax_query']       = array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction'));
		$query_args['auction_arhive']  = TRUE;
		$query_args['orderby']  = 'date';
		$query_args['order']    = 'DESC';
		$query_args['post__in'] = $postids;
		$uat_query = new WP_Query($query_args);
		
		
		if ($uat_query->have_posts()) {
			while ($uat_query->have_posts()) {
				$uat_query->the_post();
				global $product;

				$product_id = $product->get_id();
				$uwa_time_zone =  (array)wp_timezone();
                $cmf_vehicle_highlights = get_field('cmf_vehicle_highlights');
                $product_url = get_permalink();
				$product_id = $product->get_id();
				$thumb_id = get_post_thumbnail_id();
				$thumb_url = wp_get_attachment_image_src($thumb_id, 'uat-home-blog-small');
				$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
				$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
				?>

                <div class="product-block">
					<div class="product-img-b" style="background-image: url('<?php echo esc_url($thumb_image); ?>');">
					<?php if(!empty($front_end_watch_list_display) && $front_end_watch_list_display=='on' && $car_page_sidebar_car_show_watchlist == 'yes'){ ?> 
						<div class="product-wishlist">
							<?php wc_get_template('loop/uat-auction-saved.php'); ?>
						</div>
					<?php } ?>
						<a href="<?php echo $product_url; ?>" class="overlay_link"></a>
							<div class="timer_label">
							<?php
								$timer = get_field('ctos_grid_car_timer', 'option');
								$car_timer = isset($timer) ? $timer : "on";
								$auction_closed = get_post_meta($product_id, 'woo_ua_auction_closed', true);
								if ($car_timer = "on" && !$auction_closed) { ?>
									<div class="timer-b-left-bottom">
										<div class="timer-box">
											<?php
											$auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
											$rem_arr = get_remaining_time_by_timezone($auc_end_date);
											countdown_clock_list_block(
												$end_date = $auc_end_date,
												$item_id = $product_id,
												$item_class = 'uwa-main-auction-product-loop  auction-countdown-check',
											);
											?>
										</div>
									</div>
								<?php } ?>
								<?php
								$current_bid = get_field('ctos_grid_car_current_bid', 'option');
								$car_current_bid = isset($current_bid) ? $current_bid : "on";
								if ($car_current_bid = "on") { ?>
									<div class="bid-amount <?php echo $page_id; ?>">
										<?php echo $product->get_price_html(); ?>
									</div>
								<?php } ?>
							</div>
						
                    </div>
				<div class="product-desc">
				<div class="listing_actions">
				<?php 
					$bid_count = get_field('ctos_grid_car_bid_count', 'option');
					$car_bid_count = isset($bid_count) ? $bid_count : "on";    
					
					if ($car_bid_count = "on") {
						$bid_count = $product->get_uwa_auction_bid_count();
							if (empty($bid_count)) {
								$bid_count = 0;
							}
						if ($bid_count > 1) { ?>
							<span class="bid_counter"><?php echo esc_attr($bid_count); ?> <?php _e("Bids", "ultimate-auction-pro-software") ?></span>
					   <?php }else{ ?>
							<span class="bid_counter"><?php echo esc_attr($bid_count); ?> <?php _e("Bid", "ultimate-auction-pro-software") ?></span>
					   <?php }
					}

					if ($product->is_uwa_reserve_enabled()) {
						if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
							$uwa_reserve_txt = __('Reserve Price not met', 'ultimate-auction-pro-software');
						}
						if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
							$uwa_reserve_txt = __('Reserve Price met', 'ultimate-auction-pro-software');
						}
					} else {
						$uwa_reserve_txt = __('No Reserve', 'ultimate-auction-pro-software');
					}
					echo '<span class="no_reserve">'.$uwa_reserve_txt.'</span>';
				?>

				</div>
				<?php if( $car_page_sidebar_car_show_title == 'yes') { ?>
				<h2 class="product-tital"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php } ?>
				<?php
					$sub_title = get_field('ctos_grid_car_sub_title', 'option');
					if( $product->get_auction_subtitle() && $car_page_sidebar_car_show_subtitle == 'yes') {
						$get_auction_subtitle = $product->get_auction_subtitle();
						if (!empty($get_auction_subtitle)) { ?>
							<h4 class="product-sub-t"><?php echo $get_auction_subtitle; ?></h4>
						<?php } else { ?>
							<h4 class="product-sub-t"></h4>
					<?php  }
					} 
					
					if (!empty($cmf_vehicle_highlights)  && $car_page_sidebar_car_show_highlights == 'yes') {
						
						echo $cmf_vehicle_highlights;
					}
					
					$location_name = get_field('ctos_grid_car_sub_title', 'option');
					$location = isset($location_name) ? $location_name : "on";
					$loc_city = get_field('uat_locationP_address', $product_id);
					if ($location = "on") {
						echo '<h4 class="location-text">';
						if (!empty($loc_city)) {
							$address = [];
							if (!empty($loc_city['city'])) {
								$address[] = $loc_city['city'];
							}
							if (!empty($loc_city['state_short'])) {
								$address[] = $loc_city['state_short'];
							}
							if (!empty($loc_city['post_code'])) {
								$address[] = $loc_city['post_code'];
							}
							echo implode(", ", $address);
						}
						echo "</h4>";
					} 
					
					// $location = $product->get_location()??[]; 
						$address = [];
						if(!empty($location) && $car_page_sidebar_car_show_location == 'yes'){
							if(!empty($location['city'])){ $address[] = $location['city']; }
							if(!empty($location['state_short'])){ $address[] = $location['state_short']; }
							if(!empty($location['post_code'])){ $address[] = $location['post_code']; }
							echo '<h4 class="location-text">'.implode(", ", $address).'</h4>';
						} 
					
					
					?>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
<?php } ?>
</div>


				


