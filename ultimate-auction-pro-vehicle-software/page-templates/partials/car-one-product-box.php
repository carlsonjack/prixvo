<?php
global $product;
$product_id = $product->get_id();
$thumb_id = get_post_thumbnail_id();
$thumb_url = wp_get_attachment_image_src($thumb_id, 'uat-home-blog-small');
$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
$product_type = $product->get_type();

?>
<div class="product-block">
    <div class="product-img-b" style="background-image: url(<?php echo esc_url($thumb_image); ?>);">
        <?php if (get_field('front_end_watch_list_display', 'option') == 1) : ?>
            <div class="product-wishlist">
                <?php wc_get_template('loop/uat-auction-saved.php'); ?>
                
            </div>
        <?php endif; ?>
        <a href="<?php the_permalink(); ?>" class="overlay_link"></a> 
        <div class="timer_label">
        <?php
            $timer = get_field('ctos_grid_car_timer', 'option');
            $car_timer = isset($timer) ? $timer : "on";
            $auction_closed = get_post_meta($product_id, 'woo_ua_auction_closed', true);
            if ($car_timer == "on" && !$auction_closed) { ?>
                <div class="timer-b-left-bottom">
                    <div class="timer-box">
                        <?php
                        $auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
                        $rem_arr = get_remaining_time_by_timezone($auc_end_date);
                        countdown_clock(
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
            if ($car_current_bid == "on") { ?>
                <div class="bid-amount">
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
            
            if ($car_bid_count == "on") {
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
                /*if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
                    $uwa_reserve_txt = __('Reserve Price not met', 'ultimate-auction-pro-software');
                }
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
                    $uwa_reserve_txt = __('Reserve Price met', 'ultimate-auction-pro-software');
                }*/
            } else {
                $uwa_reserve_txt = __('No Reserve', 'ultimate-auction-pro-software');
				 echo '<span class="no_reserve">'.$uwa_reserve_txt.'</span>';
            }
           
        ?>

        </div>
        <h2 class="product-tital"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php
            $sub_title = get_field('ctos_grid_car_sub_title', 'option');
            $car_sub_title = isset($sub_title) ? $sub_title : "on";
            if ($car_sub_title == "on") {
                $get_auction_subtitle = $product->get_auction_subtitle();
                if (!empty($get_auction_subtitle)) { ?>
                    <h4 class="product-sub-t"><?php echo $get_auction_subtitle; ?></h4>
                <?php } else { ?>
                    <h4 class="product-sub-t"></h4>
            <?php  }
            } ?>
            <?php
            $location_name = get_field('ctos_grid_car_location', 'option');
            $location = isset($location_name) ? $location_name : "on";
            $loc_city = get_field('uat_locationP_address', $product_id);
			$country_flag = get_option('options_ctos_grid_car_location_flag');
			
            if ($location == "on") {				
                echo '<div class="location-text">';
				if (!empty($loc_city['country_short']) && $country_flag =="on") {					
				 echo "<img src='https://flagcdn.com/".strtolower($loc_city['country_short']).".svg' alt='Flag'>";
				}
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
                echo "</div>";
            } ?>
    </div>
</div>

