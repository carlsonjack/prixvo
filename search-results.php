<?php
$search_term = $_GET['s'] ?? "";
?>

<div class="container">
	<?php if (apply_filters('woocommerce_show_page_title', true)) : ?>
		<h1 class="Search-result_head"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	<div class="save-search-box">
		<?php
		$userId = get_current_user_id();
		$save_style = "";
		$saved_style = "";
		$saved_status = "";
		$savedSearches = get_user_meta($userId, 'search_terms', true);
		if (is_array($savedSearches) && in_array($search_term, $savedSearches)) {
			$save_style = "display: none;";
			$saved_status = "true";
		} else {
			$saved_style = "display: none;";
			$saved_status = "false";
		}
		?>
		<a href="javascript:void(0)" class="save-search" data-search-term="<?php echo $search_term; ?>" data-status="<?php echo $saved_status; ?>">
			<span class="save" style="<?php echo $save_style; ?>"><i class="far fa-heart"></i><span class="inner-text"><?php _e('Save Search', 'ultimate-auction-pro-software') ?></span></span>
			<span class="saved" style="<?php echo $saved_style; ?>"><i class="fas fa-heart"></i><span class="inner-text"><?php _e('Saved', 'ultimate-auction-pro-software') ?></span></span>
		</a>
	</div>
	<div class="related-search-box">

		<?php
		$related_search_terms = generate_related_search_terms($search_term);
		$related_search_terms = array_slice($related_search_terms, 0, 10);
		if (!empty($related_search_terms)) {
			echo '<ul>';
			echo '<li>' . __('Related search terms: ', 'ultimate-auction-pro-software') . '</li>';
			foreach ($related_search_terms as $related_term) {
				echo '<li><a href="'.get_search_url($related_term).'" >' . $related_term . '</a></li>';
			}
			echo '</ul>';
		}
		?>
	</div>

	<section class="product-list-sec">
		<!-- pro-list-row -->
			<?php
			$detail_page_layout = get_option('options_uat_search_results_page_layout', 'full-width');
			$page_type = isset($detail_page_layout) ? $detail_page_layout : "full-width";
			?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<div class="ua-filter-sidebar">
					<?php
					$resultbar_set = get_option('options_uat_search_results_resultbar', 'on');
					$resultbar = $resultbar_set ? $resultbar_set : "on";
					if ($resultbar == "on") { ?>
						<div class="ua-search-presults">
							<h5><?php _e('Showing', 'ultimate-auction-pro-software'); ?> <span class="PResult-Counts"></span> <?php _e('results', 'ultimate-auction-pro-software'); ?></h5>
						</div>
					<?php } ?>
					<?php
					$pricerange_bid_set = get_option('options_uat_search_results_pricerange_bids', 'on');
					$pricerange_bid = $pricerange_bid_set ? $pricerange_bid_set : "on";
					if ($pricerange_bid == "on") {
						$pricerange_values = uat_get_searched_term_pricerange_values($search_term);
						$pricerange_highest = $pricerange_values['highest'];
						$pricerange_lowest = $pricerange_values['lowest'];
					?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('Current Bid', 'ultimate-auction-pro-software'); ?></h4>
							<div class="price-range-slider ua-input-group">
								<p class="range-value">
									<input type="text" id="pricerange_bid_amount_event" readonly>
								</p>
								<div id="pricerange-bid-slider-range-event" class="range-bar"></div>
								<input type="hidden" id="pricerange_bid_from_event">
								<input type="hidden" id="pricerange_bid_to_event">
								<input type="hidden" name="pricerange_bid_high_event" value="<?php echo $pricerange_highest; ?>" id="pricerange_bid_high_event" />
								<input type="hidden" name="pricerange_bid_low_event" value="<?php echo $pricerange_lowest; ?>" id="pricerange_bid_low_event" />
								<input type="hidden" name="ctm_currency_symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>" class="ctm_currency_symbol" />
							</div>
						</div>
					<?php } ?>
					<?php
					$pricerange_set = get_option('options_uat_search_results_pricerange', 'on');
					$pricerange = $pricerange_set ? $pricerange_set : "on";
					if ($pricerange == "on") {
						$estiamte_values = uat_get_searched_term_estimate_values($search_term);
						$estiamte_highest = $estiamte_values['highest'];
						$estiamte_lowest = $estiamte_values['lowest'];
					?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('Estimate', 'ultimate-auction-pro-software'); ?></h4>
							<div class="price-range-slider ua-input-group">
								<p class="range-value">
									<input type="text" id="pricerange_estiamte_amount_event" readonly>
								</p>
								<div id="pricerange-slider-range-event" class="range-bar"></div>
								<input type="hidden" id="pricerange_estiamte_price_from_event">
								<input type="hidden" id="pricerange_estiamte_price_to_event">
								<input type="hidden" name="pricerange_estiamte_high_event" value="<?php echo $estiamte_highest; ?>" id="pricerange_estiamte_high_event" />
								<input type="hidden" name="pricerange_estiamte_low_event" value="<?php echo $estiamte_lowest; ?>" id="pricerange_estiamte_low_event" />
								<input type="hidden" name="ctm_currency_symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>" class="ctm_currency_symbol" />
							</div>
						</div>
					<?php } ?>
				</div>
				<?php
				$default_view_set = get_option('options_uat_search_results_default_view', 'grid-view');
				$default_view = $default_view_set ? $default_view_set : "grid-view";
				?>
				<div class="ua-product-listing    prod <?php echo $default_view; ?>">
					<div class="ua-live-search-list">
						<div class="ua-live-search">
							<?php
							$searchbar_set = get_option('options_uat_search_results_searchbar', 'on');
							$searchbar = $searchbar_set ? $searchbar_set : "on";
							if ($searchbar == "on") { ?>
								<div class="search-input">
									<input name="ajax_products_search_str" class="ajax_products_search_str" type="text" autocomplete="off" placeholder="<?php _e('Search by name.', 'ultimate-auction-pro-software'); ?>" value="<?php echo $search_term; ?>" style="padding-right: 34px;">
								</div>
								<div class="search-button  ajax_products_search_btn">
									<button type="submit" cursor="pointer" class="">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="c-button__icon u-icon-m"><path fill="currentColor" fill-rule="evenodd" d="m17.9 16.5 5.1 5.1.7.7-1.4 1.4-.7-.7-5.1-5.1a9.7 9.7 0 0 1-6 2.1A9.6 9.6 0 0 1 1 10.5 9.6 9.6 0 0 1 10.5 1a9.6 9.6 0 0 1 9.5 9.5 9.7 9.7 0 0 1-2.1 6ZM10.5 3A7.6 7.6 0 0 0 3 10.5a7.6 7.6 0 0 0 7.5 7.5 7.6 7.6 0 0 0 7.5-7.5A7.6 7.6 0 0 0 10.5 3Z" clip-rule="evenodd"></path></svg>
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
							$viewbar_set = get_option('options_uat_search_results_viewbar', 'on');
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
							$pagination_type = get_option('options_uat_search_results_pagination_type', 'load-more');
							if ($pagination_type == "load-more") { ?>
								<a href="Javascript:void(0);" style="display:none;" class="show-more ua-button-black" onclick="load_events_products_serach_result('');"><?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
							<?php } ?>
						</div>
					</div>
					<input type="hidden" name="max_page" value="" id="max_page" />
					<input type="hidden" name="cat_id" value="<?php echo $term_id; ?>" id="cat_id" />
					<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat" />
				</div>
			</div>
	</section>
</div>
<script>
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
			var $oldaction = jQuery('input[name="event_sortby_by"').val();
			var $action = jQuery(this).data("value");
			if ($oldaction != $action) {
				var $action_html = jQuery(this).html();
				jQuery('input[name="event_sortby_by"').val($action);
				load_events_products_serach_result(1);
				jQuery('.drop-down .selected span').html($action_html)
			}
		});


		// Handle click event on the save-search button/link
		$('.save-search').on('click', function(e) {
			e.preventDefault();

			var searchTerm = $(this).data('search-term');
			var searchStatus = $(this).data('data-status');
			var button = $(this);

			// Run the AJAX request
			$.ajax({
				url: UAT_Ajax_Url,
				type: 'POST',
				data: {
					action: 'save_search',
					search_term: searchTerm,
					search_status: searchStatus,
				},
				success: function(response) {
					console.log(response)
					if (response.search_action == 'removed') {
						button.find('.save').show();
						button.find('.saved').hide();
					} else {
						button.find('.save').hide();
						button.find('.saved').show();
					}
				}
			});
		});

	});
</script>