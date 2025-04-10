<?php

/**
 * Theme functions and definitions
 *
 * @package WordPress
 * @subpackage Defaulut Theme
 * @author Defaulut Theme, Inc.
 *
 */
get_header();
global $wpdb, $post;
global $sitepress;
$date_format = get_option('date_format');
$time_format = get_option('time_format');
$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
$display_timezone = __($timezone_string, 'ultimate-auction-pro-software');
$datetimeformat = get_option('date_format') . ' ' . get_option('time_format');
while (have_posts()) : the_post();
	$event_id =  $post->ID;
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$event_id = icl_object_id($event_id, 'product', false, $sitepress->get_default_language());
	}
	$featured_img_url = get_the_post_thumbnail_url($event_id);
	if (empty($featured_img_url)) {
		$featured_img_url = UAT_THEME_PRO_IMAGE_URI . "front/event_default_banner.png";
	}
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
	$starting_on_date = get_post_meta($event_id, 'start_time_and_date', true);
	$ending_date = get_post_meta($event_id, 'end_time_and_date', true);
	// $loc_city = get_field('uat_location_address', $event_id);
	// if ($loc_city) {
	// 	$loc_city = $loc_city['city'];
	// }
	// Get the author of the post
	$author_id = get_post_field('post_author', $event_id);
	$author_name = get_the_author_meta('display_name', $author_id);

	// Get the featured image URL
	$image_id = get_post_thumbnail_id($event_id);
	$image_url = wp_get_attachment_image_src($image_id, 'full')[0] ?? "#";
?>
	<section class="event-sec">

		<div class="container">

			<?php
			$hide_breadcrumbs = get_option('options_uat_hide_breadcrumbs', 'on');
			if ($hide_breadcrumbs == "on") {
				echo uat_theme_breadcrumbs();
			}
			?>
			<div class="Seller-details">
				<div class="Seller-text-left">
					<h2 class="mr-bottom-25"><?php the_title(); ?></h2>
					<!-- <button class="wish-list-button"> -->
					<!-- unfill svg image hide show on click -->
					<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="heart-icon">\
						<path fill="currentColor" fill-rule="evenodd" d="M12.084 4.79a5.591 5.591 0 0 1 5.257-1.669 5.758 5.758 0 0 1 4.59 4.924 5.925 5.925 0 0 1-1.585 5.007L12 21.398l-8.346-8.346A5.925 5.925 0 0 1 2.07 8.045a5.758 5.758 0 0 1 4.59-4.924 5.591 5.591 0 0 1 5.257 1.67h.168ZM12 18.894l7.094-7.093a4.006 4.006 0 0 0 1.168-3.673 4.09 4.09 0 0 0-3.171-3.338 4.256 4.256 0 0 0-4.423 1.836.834.834 0 0 1-1.336 0A4.09 4.09 0 0 0 6.91 4.79a4.173 4.173 0 0 0-3.171 3.422 4.09 4.09 0 0 0 1.085 3.672L12 18.894Z" clip-rule="evenodd"></path>
					</svg> -->
					<!-- fill svg image hide show on click -->
					<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="fill-heart-icon">
						<path fill="currentColor" d="M17.341 3.121a5.591 5.591 0 0 0-5.258 1.67h-.167A5.591 5.591 0 0 0 6.66 3.12a5.758 5.758 0 0 0-4.59 4.924 5.925 5.925 0 0 0 1.585 5.007L12 21.398l8.346-8.346a5.925 5.925 0 0 0 1.585-5.007 5.758 5.758 0 0 0-4.59-4.924Z"></path>
					</svg>   -->
					<!-- <span class="FoB7Rgal7smxcF0TQEc9 c0HtRDwRz7tPvDATrYJ6">Follow similar auctions</span> -->
					<!-- </button> -->
					<div class="seller-auction-start-date"><?php echo date_i18n(get_option('date_format'), strtotime($starting_on_date));  ?> – <?php echo date_i18n(get_option('date_format'), strtotime($ending_date));  ?> <?php echo date_i18n(get_option('time_format'), strtotime($ending_date));  ?> <?php echo $display_timezone; ?></div>
					<!-- <h3 class="auction-end-date">Ends today 23:30</h3> -->
					<?php
					$timer_text = "";
					$clock_html = "";
					$item_class = 'time_countdown_event';
					$timer = get_option('options_event_detail_page_timer', 'off');
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
								$item_class = $item_class,
							);
							$clock_html = ob_get_clean();
						} else {
							$timer_text = __('Auction Closed', 'ultimate-auction-pro-software');
						}
					}

					$timer_text .= $clock_html;
					?>
					<h3 class="auction-end-date"><?php echo $timer_text; ?></h3>
				</div>
				<div class="Seller-img-right">
					<a href="#">
						<div class="seller-profile-image">
							<img src="<?php echo $featured_img_url; ?>" alt="<?php echo $author_name . " profile image" ?>">
						</div>
						<div class="seller-profile-info">
							<h4 class="auction-list-expert"> <?php echo __('Created by', 'ultimate-auction-pro-software') . " " . $author_name; ?>
								<span class="auction-list-expert-icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="5" height="9" viewBox="0 0 5 9">
										<path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 8l3-3.5L1 1"></path>
									</svg>
								</span>
							</h4>
							<!-- <h5 class="auction-list-expert-details">Expert in Books - Art &amp; Photography</h5> -->
						</div>
					</a>
				</div>
			</div>
		</div>
	</section>

	<section class="product-list-sec">
		<!-- pro-list-row -->
		<div class="container">
			<?php
			$detail_page_layout = get_option('options_uat_event_details_page_layout', 'full-width');
			$page_type = isset($detail_page_layout) ? $detail_page_layout : "full-width";
			?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<div class="ua-filter-sidebar">
					<?php
					$resultbar_set = get_option('options_uat_event_details_resultbar', 'on');
					$resultbar = $resultbar_set ? $resultbar_set : "on";
					if ($resultbar == "on") { ?>
						<div class="ua-search-presults">
							<h5><?php _e('Showing', 'ultimate-auction-pro-software'); ?> <span class="PResult-Counts"></span> <?php _e('results', 'ultimate-auction-pro-software'); ?></h5>
						</div>
					<?php } ?>
					<?php
					$reset_filter_set = get_option('options_uat_event_details_reset_filter', 'off');
					$reset_filter = $reset_filter_set ? $reset_filter_set : "on";
					if ($reset_filter == "on") { ?>
						<div class="ua-Filter-modual-box" id="APPLIED_Pfilter" style="display:none;">
							<h4 class="ua-Filter-modual-heading"><a href="javascript:;" class="RemovePFilterall"><?php _e('CLEAR ALL', 'ultimate-auction-pro-software'); ?></a></h4>
						</div>
					<?php } ?>

					<?php
					$pricerange_bid_set = get_field('uat_product_single_list_pricerange_bids', $page_id);
					$pricerange_bid = $pricerange_bid_set ? $pricerange_bid_set : "on";
					if ($pricerange_bid == "on") {
						$low_bid_value = uat_get_event_lowest_bids($event_id);
						$high_bid_value = uat_get_event_highest_bids($event_id);
					?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('Current Bid', 'ultimate-auction-pro-software'); ?></h4>
							<div class="price-range-slider ua-input-group selector-slider">
								<div id="pricerange-bid-slider-range" class="range-bar">
									<input type="hidden" id="pricerange_bid_from_event">
									<input type="hidden" id="pricerange_bid_to_event">
									<div class="ui-slider-range ui-corner-all ui-widget-header"></div>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
								</div>
								<input type="hidden" name="pricerange_bid_low" value="<?php echo wc_format_decimal($low_bid_value, 0); ?>" id="pricerange_bid_low" />
								<span id="min-price" data-currency="<?php echo get_woocommerce_currency_symbol(); ?>" class="slider-price">
									<?php echo wc_format_decimal($low_bid_value, 0); ?>
								</span>
								<span class="seperator">-</span>
								<span id="max-price" data-currency="<?php echo get_woocommerce_currency_symbol(); ?>" data-max="<?php echo wc_format_decimal($high_bid_value, 0); ?>" class="slider-price"><?php echo wc_format_decimal($high_bid_value, 0); ?>+</span>
								<input type="hidden" name="pricerange_bid_high" value="<?php echo wc_format_decimal($high_bid_value, 0); ?>" id="pricerange_bid_high" />
							</div>
						</div>
					<?php } ?>
				
					<?php
					$pricerange_set = get_option('options_uat_event_details_pricerange', 'on');
					$pricerange = $pricerange_set ? $pricerange_set : "on";
					if ($pricerange == "on") { 
						$low_estimate_value = uat_get_event_lowest_estimate_value($event_id);
						$high_estimate_value = uat_get_event_highest_estimate_value($event_id);
						?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('Current Bid', 'ultimate-auction-pro-software'); ?></h4>
							<div class="price-range-slider ua-input-group selector-slider">
								<div id="pricerange-slider-range" class="range-bar">
									<input type="hidden" id="pricerange_estiamte_price_from_event">
									<input type="hidden" id="pricerange_estiamte_price_to_event">
									<div class="ui-slider-range ui-corner-all ui-widget-header"></div>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default"></span>
								</div>
								<input type="hidden" name="pricerange_estiamte_low" value="<?php echo wc_format_decimal($low_estimate_value, 0); ?>" id="pricerange_estiamte_low" />
								<span id="min-price-estimate" data-currency="<?php echo get_woocommerce_currency_symbol(); ?>" class="slider-price">
									<?php echo wc_format_decimal($low_estimate_value, 0); ?>
								</span>
								<span class="seperator">-</span>
								<span id="max-price-estimate" data-currency="<?php echo get_woocommerce_currency_symbol(); ?>" data-max="<?php echo wc_format_decimal($high_estimate_value, 0); ?>" class="slider-price"><?php echo wc_format_decimal($high_estimate_value, 0); ?>+</span>
								<input type="hidden" name="pricerange_estiamte_high" value="<?php echo wc_format_decimal($high_estimate_value, 0); ?>" id="pricerange_estiamte_high" />
							</div>
						</div>
					<?php } ?>
				</div>
				<?php
				$default_view_set = get_option('options_uat_event_details_default_view', 'grid-view');
				$default_view = $default_view_set ? $default_view_set : "grid-view";
				?>
				<div class="ua-product-listing    prod <?php echo $default_view; ?>">
					<div class="ua-live-search-list">
						<div class="ua-live-search">
							<?php
							$searchbar_set = get_option('options_uat_event_details_searchbar', 'on');
							$searchbar = $searchbar_set ? $searchbar_set : "on";
							if ($searchbar == "on") { ?>
								<div class="search-input">
									<input name="ajax_products_search_str" class="ajax_products_search_str" type="text" autocomplete="off" placeholder="<?php _e('Search by name.', 'ultimate-auction-pro-software'); ?>" value="" style="padding-right: 34px;">
								</div>
								<div class="search-button  ajax_products_search_btn">
									<button type="submit" cursor="pointer" class="">
										<svg viewBox="0 0 18 18" fill="black100" height="18px" width="18px" class="search-icon">
											<title><?php _e('Search', 'ultimate-auction-pro-software'); ?></title>
											<path d="M11.5 3a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7zm0-1A4.5 4.5 0 1 0 16 6.5 4.49 4.49 0 0 0 11.5 2zM9.442 9.525l-.88-.88L2.06 15.06l.88.88 6.502-6.415z" fill-rule="nonzero"></path>
										</svg>
									</button>
								</div>
							<?php } ?>
						</div>
						<div class="list-and-grid-icon">
							<input type="hidden" name="event_sortby_by" class="event_sortby_by" value="lot_number_asc" />
							<div class="prod_fil" style="position: relative;">
								<div class="drop-down">
									<div class="selected">
										<span><?php _e('Lot number (low to high)', 'ultimate-auction-pro-software'); ?></span>
									</div>
									<div class="options">
										<ul>
											<li><a data-value="lot_number_asc" href="#"><?php _e('Lot number (low to high)', 'ultimate-auction-pro-software'); ?><span class="value"></span></a></li>
											<li><a data-value="lot_number_desc" href="#"><?php _e('Lot number (high to low)', 'ultimate-auction-pro-software'); ?><span class="value"></span></a></li>
											<li><a data-value="estimate_asc" href="#"><?php _e('Estimate (low to high)', 'ultimate-auction-pro-software'); ?><span class="value"></span></a></li>
											<li><a data-value="estimate_desc" href="#"><?php _e('Estimate (high to low)', 'ultimate-auction-pro-software'); ?><span class="value"></span></a></li>
										</ul>
									</div>
								</div>
							</div>


							<?php
							$viewbar_set = get_option('options_uat_event_details_viewbar', 'on');
							$viewbar = $viewbar_set ? $viewbar_set : "on";
							if ($viewbar == "on") { ?>
								<div class="view">

									<a href="#" data-view="list-view">
										<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 25.6" style="enable-background:new 0 0 22 25.6;width: 25px;" xml:space="preserve">
											<style type="text/css">
												.st0 {
													fill: #919397;
												}
											</style>
											<path class="st0" d="M22-0.1H0v12h22V-0.1z M20,9.9H2v-8h18V9.9z M22,13.6H0v12h22V13.6z M20,23.6H2v-8h18V23.6z"></path>
										</svg>
									</a>
									<a href="#" class="selected" data-view="grid-view">
										<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 25.6" style="enable-background:new 0 0 22 25.6;width: 25px;" xml:space="preserve">
											<style type="text/css">
												.st0 {
													fill: #919397;
												}
											</style>
											<g>
												<path class="st0" d="M10,0H0v12h10V0z M8,10H2V2h6V10z M22,0H12v12h10V0z M20,10h-6V2h6V10z M10,13.6H0v12h10V13.6z M8,23.6H2v-8h6 V23.6z M22,13.6H12v12h10V13.6z M20,23.6h-6v-8h6V23.6z"></path>
											</g>
										</svg>
									</a>

									<!-- <i class="fa fa-list " data-view="list-view"></i> 
								<i class="selected fa fa-th" data-view="grid-view"></i>  -->
								</div>
							<?php } ?>
						</div>
					</div>
					<div class="product-list-columns Event-ProductsSearch-Results pro-list-row" id="Event-ProductsSearch-Results">
					</div>
					<div class="show-more-link full-section">
						<div class="container">
							<div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
								<img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
							</div>
							<?php
							$pagination_type = get_option('options_uat_event_details_pagination_type', 'load-more');
							if ($pagination_type == "load-more") { ?>
								<a href="Javascript:void(0);" style="display:none;" class="show-more ua-button-black" onclick="load_events_products_serach_result('');"><?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
							<?php } ?>
						</div>
					</div>
					<input type="hidden" name="max_page" value="" id="max_page" />
					<input type="hidden" name="event_id" value="<?php echo $event_id; ?>" id="event_id" />
					<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat" />
				</div>
			</div>
		</div>
	</section>

	<script>
		var wpml_lang_code = "";
		<?php if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) { ?>
			wpml_lang_code = '<?php echo ICL_LANGUAGE_CODE; ?>';
		<?php } ?>
		jQuery(document).ready(function($) {
			jQuery(document).on('click', ".drop-down", function(e) {
				e.preventDefault();
				var options = jQuery(this).children(".options");
				if (options.is(":visible")) {
					options.hide();
				} else {
					jQuery(".drop-down .options").hide();
					options.show();
				}
			});
			jQuery(document).on('click', ".drop-down li a", function(e) {
				e.preventDefault();
				console.log(e)
				var $action = jQuery(this).data("value");
				var $action_html = jQuery(this).html();
				jQuery('input[name="event_sortby_by"').val($action);
				load_events_products_serach_result(1);
				jQuery('.drop-down .selected span').html($action_html)
			});
		});
	</script>
<?php endwhile; ?>
<?php get_footer(); ?>