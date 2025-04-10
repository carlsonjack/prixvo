<?php
get_header();
$hide_breadcrumbs = get_option('options_uat_hide_breadcrumbs', 'on');
if ($hide_breadcrumbs == "on") {
	echo uat_theme_breadcrumbs();
}
?>
<!-- <link rel="stylesheet" href=" <?php echo UAT_THEME_PRO_CSS_URI; ?>/jquery_slick.css" type="text/css" media="screen" /> -->
<div class="catagory-blocks">
	<div class="container">
		<?php
		$queried_object = get_queried_object();
		$term_id = $queried_object->term_id;
		$term_name = $queried_object->name;
		$term_parent_id = $queried_object->parent;
		if ($term_parent_id == 0) {
			$term_parent_id = '';
		}
		$list_page_layout = get_option('options_uat_event_list_page_layout');
		$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
		?>
		<h1 class="page-title cat-title"><?php single_cat_title(); ?></h1>
		<?php if (category_description()) : // Show an optional category description. 
		?>
			<div class="cat-meta"><?php echo category_description(); ?></div>
		<?php
		endif;
		$uat_event_list_page_populer_sub_cat_show = get_option('options_uat_event_list_page_populer_sub_cat_show', 'yes');
		if ($uat_event_list_page_populer_sub_cat_show == "yes") {
		?>
			<div class="mr-top-30 mr-bottom-30 catagoty-box-row">
				<?php
				$sub_categories = [];
				if (empty($term_parent_id)) {
					$sub_categories = getEventCategoriesList($term_id);
					foreach ($sub_categories as $categorie) {
						$name = $categorie['name'];
						$image_url = $categorie['image_url'];
						$link = $categorie['link'] ?? "";
				?>
						<div class="catagory-box">
							<a href="<?php echo $link; ?>" class="catagory_link">
								<h4><?php echo $name; ?></h4>
								<div class="catagory_link_img"><img src="<?php echo $image_url; ?>" width="100px" /></div>
							</a>
						</div>
				<?php
					}
				}
				?>
			</div>

		<?php
		}
		$uat_event_list_page_populer_event_show = get_option('options_uat_event_list_page_populer_event_show', 'yes');
		if ($uat_event_list_page_populer_event_show == "yes" && class_exists( 'woocommerce' )) {
			$slide_options = [
				'header_title'      => __('Popular collections', 'ultimate-auction-pro-software'),
				'slide_type'        => 'events', // auctions, events
				'total_slides'      => 10, // 5, 10, 20...
				'event_catagory_id' => $term_id, // pass the categorys id to show that category data only in slides
				'slides_to_show'    => "3", // number of data slides to show on page
			];
			echo getAuctionSlider($slide_options);
		}
		$uat_event_list_page_list_type = get_option('options_uat_event_list_page_list_type', 'auction');
		if ($uat_event_list_page_list_type == 'auction') {
		?>
			<section class="product-list-sec">
				<!-- pro-list-row -->
				<div class="container">
					<?php
					$detail_page_layout = get_option('options_uat_event_categories_auctions_layout', 'full-width');
					$page_type = isset($detail_page_layout) ? $detail_page_layout : "full-width";
					?>
					<div class="ua-product-list-sec <?php echo $page_type; ?>">
						<div class="ua-filter-sidebar">
							<?php
							$resultbar_set = get_option('options_uat_event_categories_auction_resultbar', 'on');
							$resultbar = $resultbar_set ? $resultbar_set : "on";
							if ($resultbar == "on") { ?>
								<div class="ua-search-presults">
									<h5><?php _e('Showing', 'ultimate-auction-pro-software'); ?> <span class="PResult-Counts"></span> <?php _e('results', 'ultimate-auction-pro-software'); ?></h5>
								</div>
							<?php } ?>
							<?php
							$reset_filter_set = get_option('options_uat_event_categories_auction_reset_filter', 'off');
							$reset_filter = $reset_filter_set ? $reset_filter_set : "on";
							if ($reset_filter == "on") { ?>
								<div class="ua-Filter-modual-box" id="APPLIED_Pfilter" style="display:none;">
									<h4 class="ua-Filter-modual-heading"><a href="javascript:;" class="RemovePFilterall"><?php _e('CLEAR ALL', 'ultimate-auction-pro-software'); ?></a></h4>
								</div>
							<?php } ?>
							<?php
							$pricerange_bid_set = get_option('options_uat_event_categories_auction_pricerange_bids', 'on');
							$pricerange_bid = $pricerange_bid_set ? $pricerange_bid_set : "on";
							if ($pricerange_bid == "on") {
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
										<input type="hidden" name="pricerange_bid_high_event" value="<?php echo uat_get_event_category_highest_bids($term_id); ?>" id="pricerange_bid_high_event" />
										<input type="hidden" name="pricerange_bid_low_event" value="<?php echo uat_get_event_category_lowest_bids($term_id); ?>" id="pricerange_bid_low_event" />
										<input type="hidden" name="ctm_currency_symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>" class="ctm_currency_symbol" />
									</div>
								</div>
							<?php } ?>
							<?php
							$pricerange_set = get_option('options_uat_event_categories_auction_pricerange', 'on');
							$pricerange = $pricerange_set ? $pricerange_set : "on";
							if ($pricerange == "on") { ?>
								<div class="ua-Filter-modual-box">
									<h4 class="ua-Filter-modual-heading"><?php _e('Estimate', 'ultimate-auction-pro-software'); ?></h4>
									<div class="price-range-slider ua-input-group">
										<p class="range-value">
											<input type="text" id="pricerange_estiamte_amount_event" readonly>
										</p>
										<div id="pricerange-slider-range-event" class="range-bar"></div>
										<input type="hidden" id="pricerange_estiamte_price_from_event">
										<input type="hidden" id="pricerange_estiamte_price_to_event">
										<input type="hidden" name="pricerange_estiamte_high_event" value="<?php echo uat_get_event_category_highest_estimate_value($term_id); ?>" id="pricerange_estiamte_high_event" />
										<input type="hidden" name="pricerange_estiamte_low_event" value="<?php echo uat_get_event_category_lowest_estimate_value($term_id); ?>" id="pricerange_estiamte_low_event" />
										<input type="hidden" name="ctm_currency_symbol" value="<?php echo get_woocommerce_currency_symbol(); ?>" class="ctm_currency_symbol" />
									</div>
								</div>
							<?php } ?>
						</div>
						<?php
						$default_view_set = get_option('options_uat_event_categories_auction_default_view', 'grid-view');
						$default_view = $default_view_set ? $default_view_set : "grid-view";
						?>
						<div class="ua-product-listing    prod <?php echo $default_view; ?>">
							<div class="ua-live-search-list">
								<div class="ua-live-search">
									<?php
									$searchbar_set = get_option('options_uat_event_categories_auction_searchbar', 'on');
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
									$viewbar_set = get_option('options_uat_event_categories_auction_viewbar', 'on');
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
									$pagination_type = get_option('options_uat_event_categories_auction_pagination_type', 'load-more');
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
				</div>
			</section>
		<?php
		} else {
			echo "<span class='page_category'></span>";
			$list_page_layout = get_option('options_uat_event_list_page_layout');
			$page_type = isset($list_page_layout) ? $list_page_layout : "full-width";
		?>
			<div class="ua-product-list-sec <?php echo $page_type; ?>">
				<div class="ua-filter-sidebar">
					<?php
					$resultbar_set = get_option('options_uat_event_list_resultbar', 'on');
					$resultbar = $resultbar_set ? $resultbar_set : "on";
					if ($resultbar == "on") { ?>
						<div class="ua-search-results">
							<h5><?php _e('Showing', 'ultimate-auction-pro-software'); ?>
								<span class="Result-Counts"></span>&nbsp;<?php _e('results', 'ultimate-auction-pro-software'); ?>
							</h5>
						</div>
					<?php } ?>
					<?php
					$sortbydate_set = get_option('options_uat_event_list_sortbydate', 'on');
					$sortbydate = $sortbydate_set ? $sortbydate_set : "on";
					if ($sortbydate == "on") { ?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('sort by', 'ultimate-auction-pro-software'); ?></h4>
							<ul class="ua-input-group ">
								<li>
									<input class="sortbyenddate" type="radio" id="sortbyenddate_ASC" value="<?php echo esc_attr('ASC'); ?>" name="sort-by-enddate" checked>
									<label for="sortbyenddate_ASC"><?php _e('End Date - Ascending', 'ultimate-auction-pro-software'); ?></label>
								</li>
								<li>
									<input class="sortbyenddate" type="radio" id="sortbyenddate_DESC" value="<?php echo esc_attr('DESC'); ?>" name="sort-by-enddate">
									<label for="sortbyenddate_DESC"><?php _e('End Date - Descending', 'ultimate-auction-pro-software'); ?></label>
								</li>
							</ul>
						</div>
					<?php } ?>
					<?php
					$reset_filter_set = get_option('options_uat_event_list_reset_filter', 'off');
					$reset_filter = $reset_filter_set ? $reset_filter_set : "on";
					if ($reset_filter == "on") { ?>
						<div class="ua-Filter-modual-box APPLIED_filter" id="APPLIED_filter" style="display:none;">
							<h4 class="ua-Filter-modual-heading"><?php _e('Applied Filters', 'ultimate-auction-pro-software'); ?></h4>
							<div class="APPLIED_filtered"></div>
							<div class="clear-all">
								<h5><a href="javascript:;" class="RemoveFilterall"><?php _e('CLEAR ALL', 'ultimate-auction-pro-software'); ?></a></h5>
							</div>
						</div>
					<?php } ?>
					<?php
					$daterange_set = get_option('options_uat_event_list_daterange', 'on');
					$daterange = $daterange_set ? $daterange_set : "on";
					if ($daterange == "on") { ?>
						<div class="ua-Filter-modual-box">
							<h4 class="ua-Filter-modual-heading"><?php _e('Date', 'ultimate-auction-pro-software'); ?></h4>
							<ul class="ua-input-group">
								<li>
									<input type="text" class="from_date" placeholder="<?php _e('From', 'ultimate-auction-pro-software'); ?>" value="" name="from_date" id="from_dateD">
								</li>
								<li>
									<input type="text" class="to_date" placeholder="<?php _e('to', 'ultimate-auction-pro-software'); ?>" value="" name="to_date" id="to_dateD">
								</li>
							</ul>
						</div>
					<?php } ?>
					<?php
					$location_set = get_option('options_uat_event_list_location', 'off');
					$location = $location_set ? $location_set : "on";
					if ($location == "on") {
						$countries = get_events_countries_list();
						$Countries_filter_Set = get_option('options_uat_event_list_location_county', 'off');
						$Countries_filter = $Countries_filter_Set ? $Countries_filter_Set : "off";
						if ($Countries_filter == "on") { ?>
							<!--//country -->
							<div class="ua-Filter-modual-box">
								<h4 class="ua-Filter-modual-heading"><?php _e('Locations', 'ultimate-auction-pro-software'); ?></h4>
								<ul class="ua-input-group eCountriesList" id="eCountries">
									<?php
									foreach ($countries as $val) : ?>
										<?php if (!empty($val)) {  ?>
											<li style="display:none;">
												<input type="checkbox" data-lname="<?php echo esc_attr($val); ?>" name="eCountries[]" id="eCountries_<?php echo str_replace(' ', '', $val); ?>" class="vh eCountries" value="<?php echo esc_attr($val); ?>">
												<label class="checkbox" for="eCountries_<?php echo str_replace(' ', '', $val); ?>"><?php echo esc_attr($val); ?></label>
												<?php
												$States_filter_Set = get_option('options_uat_event_list_location_state', 'off');
												$States_filter = $States_filter_Set ? $States_filter_Set : "off";
												if ($States_filter == "on") { ?>
													<div class="expandableCollapsibleDiv">
														<i class="Uat_Expand fas fa-plus"></i>
														<ul class="ua-input-group estateUL eStatesList" id="eStates">
															<?php $states = get_events_state_list_by_country($val);
															foreach ($states as $state) : ?>
																<?php if (!empty($state)) { ?>
																	<li style="display:none;">
																		<input type="checkbox" data-lname="<?php echo esc_attr($state); ?>" name="eStates[]" id="eStates_<?php echo str_replace(' ', '', $state); ?>" class="vh eStates" value="<?php echo esc_attr($state); ?>">
																		<label class="checkbox" for="eStates_<?php echo str_replace(' ', '', $state); ?>"><?php echo esc_attr($state); ?></label>
																		<?php
																		$Cities_filter_Set = get_option('options_uat_event_list_location_city', 'off');
																		$Cities_filter = $Cities_filter_Set ? $Cities_filter_Set : "on";
																		if ($Cities_filter == "on") { ?>
																			<div class="expandableCollapsibleDivCity">
																				<i class="Uat_Expand_city fas fa-plus"></i>
																				<ul class="ua-input-group eCitiesList" id="eCities">
																					<?php $cities = get_events_city_list_by_state($state);
																					foreach ($cities as $city) : ?>
																						<?php if (!empty($city)) { ?>
																							<li style="display:none;">
																								<input type="checkbox" data-lname="<?php echo esc_attr($city); ?>" name="eCities[]" id="eCities_<?php echo str_replace(' ', '', $city); ?>" class="vh eCities" value="<?php echo esc_attr($city); ?>">
																								<label class="checkbox" for="eCities_<?php echo str_replace(' ', '', $city); ?>"><?php echo esc_attr($city); ?></label>
																							</li>
																						<?php } ?>
																					<?php endforeach; ?>
																				</ul>
																			</div>
																		<?php } ?>
																	</li>
																<?php } ?>
															<?php endforeach; ?>
														</ul>
													</div>
												<?php } ?>
											</li>
										<?php } ?>
									<?php endforeach; ?>
								</ul>
								<div class="clear-all see_all_eCountries_div">
									<h5><a class="see_all_eCountries_btn" id="see_all_eCountries" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
								</div>
							</div>
						<?php } ?>
					<?php  } //location on off  
					?>
					<div class="ua-Filter-modual-box" style="display:none;">
						<ul class="ua-input-group" id="ecategory">
							<li>
								<input type="checkbox" checked data-lname="<?php echo esc_attr($term_name); ?>" name="chk_cat_ids[]" id="cat_<?php echo esc_attr($term_id); ?>" class="vh p_cats" value="<?php echo esc_attr($term_id); ?>">
								<label class="checkbox" for="cat_<?php echo esc_attr($term_id); ?>"><?php echo esc_attr($term_name); ?></label>
							</li>
						</ul>
					</div>
				</div>
				<?php
				$default_view_set = get_option('options_uat_event_list_default_view', 'grid-view');
				$default_view = $default_view_set ? $default_view_set : "grid-view";
				?>
				<!--Event Grid List view Start-->
				<div class="ua-product-listing  prod <?php echo $default_view; ?>">
					<div class="ua-live-search-list">
						<!--Search box Start-->
						<div class="ua-live-search">
							<?php
							$searchbar_set = get_option('options_uat_event_list_searchbar', 'on');
							$searchbar = $searchbar_set ? $searchbar_set : "on";
							if ($searchbar == "on") { ?>
								<div class="search-input">
									<input name="ajax_search_str" class="ajax_search_str" type="text" autocomplete="off" placeholder="<?php _e('Search by name.', 'ultimate-auction-pro-software'); ?>" value="" style="padding-right: 34px;">
								</div>
								<div class="search-button ajax_search_btn">
									<button type="submit" class="" cursor="pointer">
										<svg viewBox="0 0 18 18" fill="black100" height="18px" width="18px" class="search-icon">
											<title><?php _e('Search', 'ultimate-auction-pro-software'); ?></title>
											<path d="M11.5 3a3.5 3.5 0 1 1 0 7 3.5 3.5 0 0 1 0-7zm0-1A4.5 4.5 0 1 0 16 6.5 4.49 4.49 0 0 0 11.5 2zM9.442 9.525l-.88-.88L2.06 15.06l.88.88 6.502-6.415z" fill-rule="nonzero"></path>
										</svg>
									</button>
								</div>
							<?php } ?>
						</div>
						<!--Search box End-->
						<!--Mobile Filter start-->
						<?php
						$viewbar_set = get_option('options_uat_event_list_viewbar', 'on');
						$viewbar = $viewbar_set ? $viewbar_set : "on";
						if ($viewbar == "on") { ?>
							<!--View type Start-->
							<div class="list-and-grid-icon">
								<div class="view">
									<div class="table_center" style="display:none">
										<div class="drop-down">
											<div id="dropDown" class="drop-down__button">
												<span class="drop-down__name">Sort by </span>
												<i class="fas fa-sort-amount-down-alt"></i>
											</div>
											<div class="drop-down__menu-box" style="display: none;">
												<div class="drop-down__menu">
													<div class="ua-filter-sidebar">
														<?php
														$resultbar_set = get_option('options_uat_event_list_resultbar', 'on');
														$resultbar = $resultbar_set ? $resultbar_set : "on";
														if ($resultbar == "on") { ?>
															<div class="ua-search-results">
																<h5>Showing <span class="Result-Counts"></span> results</h5>
															</div>
														<?php } ?>
														<?php
														$sortbydate_set = get_option('options_uat_event_list_sortbydate', 'on');
														$sortbydate = $sortbydate_set ? $sortbydate_set : "on";
														if ($sortbydate == "on") { ?>
															<div class="ua-Filter-modual-box">
																<h4 class="ua-Filter-modual-heading">sort by</h4>
																<ul class="ua-input-group ">
																	<li>
																		<input class="sortbyenddate" type="radio" id="sortbyenddate_ASC_m" value="<?php echo esc_attr('ASC'); ?>" name="sort-by-enddate" checked>
																		<label for="sortbyenddate_ASC_m">End Date - Ascending</label>
																	</li>
																	<li>
																		<input class="sortbyenddate" type="radio" id="sortbyenddate_DESC_m" value="<?php echo esc_attr('DESC'); ?>" name="sort-by-enddate">
																		<label for="sortbyenddate_DESC_m">End Date - Descending</label>
																	</li>
																</ul>
															</div>
														<?php } ?>
														<?php
														$reset_filter_set = get_option('options_uat_event_list_reset_filter', 'off');
														$reset_filter = $reset_filter_set ? $reset_filter_set : "on";
														if ($reset_filter == "on") { ?>
															<div class="ua-Filter-modual-box APPLIED_filter" id="APPLIED_filter" style="display:none;">
																<h4 class="ua-Filter-modual-heading">Applied Filters</h4>
																<div class="APPLIED_filtered"></div>
																<div class="clear-all">
																	<h5><a href="javascript:;" class="RemoveFilterall">CLEAR ALL</a></h5>
																</div>
															</div>
														<?php } ?>
														<?php
														$daterange_set = get_option('options_uat_event_list_daterange', 'on');
														$daterange = $daterange_set ? $daterange_set : "on";
														if ($daterange == "on") { ?>
															<div class="ua-Filter-modual-box">
																<h4 class="ua-Filter-modual-heading"><?php _e('Date', 'ultimate-auction-pro-software'); ?></h4>
																<ul class="ua-input-group">
																	<li>
																		<input type="text" class="from_date" placeholder="<?php _e('From', 'ultimate-auction-pro-software'); ?>" value="" name="from_date" id="from_dateM">
																	</li>
																	<li>
																		<input type="text" class="to_date" placeholder="<?php _e('to', 'ultimate-auction-pro-software'); ?>" value="" name="to_date" id="to_dateM">
																	</li>
																</ul>
															</div>
														<?php } ?>
														<?php
														$location_set = get_option('options_uat_event_list_location', 'off');
														$location = $location_set ? $location_set : "on";
														if ($location == "on") {
															$countries = get_events_countries_list();
															$Countries_filter_Set = get_option('options_uat_event_list_location_county', 'off');
															$Countries_filter = $Countries_filter_Set ? $Countries_filter_Set : "off";
															if ($Countries_filter == "on") { ?>
																<!--//country -->
																<div class="ua-Filter-modual-box">
																	<h4 class="ua-Filter-modual-heading"><?php _e('Locations', 'ultimate-auction-pro-software'); ?></h4>
																	<ul class="ua-input-group eCountriesList" id="eCountries">
																		<?php
																		foreach ($countries as $val) : ?>
																			<?php if (!empty($val)) {  ?>
																				<li style="display:none;">
																					<input type="checkbox" data-lname="<?php echo esc_attr($val); ?>" name="eCountries[]" id="eCountriesM_<?php echo str_replace(' ', '', $val); ?>" class="vh eCountries" value="<?php echo esc_attr($val); ?>">
																					<label class="checkbox" for="eCountriesM_<?php echo str_replace(' ', '', $val); ?>"><?php echo esc_attr($val); ?></label>
																					<?php
																					$States_filter_Set = get_option('options_uat_event_list_location_state', 'off');
																					$States_filter = $States_filter_Set ? $States_filter_Set : "off";
																					if ($States_filter == "on") { ?>
																						<div class="expandableCollapsibleDiv">
																							<i class="Uat_Expand fas fa-plus"></i>
																							<ul class="ua-input-group estateUL eStatesList" id="eStatesMobile">
																								<?php $states = get_events_state_list_by_country($val);
																								foreach ($states as $state) : ?>
																									<?php if (!empty($state)) { ?>
																										<li style="display:none;">
																											<input type="checkbox" data-lname="<?php echo esc_attr($state); ?>" name="eStatesMobile[]" id="eStatesMobileM_<?php echo str_replace(' ', '', $state); ?>" class="vh eStates" value="<?php echo esc_attr($state); ?>">
																											<label class="checkbox" for="eStatesMobileM_<?php echo str_replace(' ', '', $state); ?>"><?php echo esc_attr($state); ?></label>
																											<?php
																											$Cities_filter_Set = get_option('options_uat_event_list_location_city', 'off');
																											$Cities_filter = $Cities_filter_Set ? $Cities_filter_Set : "on";
																											if ($Cities_filter == "on") { ?>
																												<div class="expandableCollapsibleDivCity">
																													<i class="Uat_Expand_city fas fa-plus"></i>
																													<ul class="ua-input-group" id="eCitiesMobile">
																														<?php $cities = get_events_city_list_by_state($state);
																														foreach ($cities as $city) : ?>
																															<?php if (!empty($city)) { ?>
																																<li style="display:none;">
																																	<input type="checkbox" data-lname="<?php echo esc_attr($city); ?>" name="eCitiesMobile[]" id="eCitiesMobileM_<?php echo str_replace(' ', '', $city); ?>" class="vh eCities" value="<?php echo esc_attr($city); ?>">
																																	<label class="checkbox" for="eCitiesMobileM_<?php echo str_replace(' ', '', $city); ?>"><?php echo esc_attr($city); ?></label>
																																</li>
																															<?php } ?>
																														<?php endforeach; ?>
																													</ul>
																												</div>
																											<?php } ?>
																										</li>
																									<?php } ?>
																								<?php endforeach; ?>
																							</ul>
																						</div>
																					<?php } ?>
																				</li>
																			<?php } ?>
																		<?php endforeach; ?>
																	</ul>
																	<div class="clear-all see_all_eCountries_div">
																		<h5><a class="see_all_eCountries_btn" id="see_all_eCountries" href="javascript:;"><?php _e('See ALL', 'ultimate-auction-pro-software'); ?></a></h5>
																	</div>
																</div>
															<?php } ?>
														<?php  } //location on off  
														?>
													</div>
												</div>
											</div>
										</div>
									</div>
									<i class="fa fa-list " data-view="list-view"></i>
									<i class="selected fa fa-th" data-view="grid-view"></i>
								</div>
							</div>
							<!--View type End-->
						<?php } ?>
					</div>
					<!--Event list start-->
					<div class="product-list-columns EventSearch-results" id="EventSearch-results">
					</div>
					<div class="show-more-link full-section">
						<div class="container">
							<div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
								<img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
							</div>
							<?php
							$pagination_type = get_option('options_uat_event_list_pagination_type', 'infinite-scroll');
							if ($pagination_type == "load-more") { ?>
								<a href="Javascript:void(0);" style="display:none;" class="show-more ua-button-black" onclick="load_events_serach_result('');"><?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
							<?php } ?>
						</div>
					</div>
					<input type="hidden" name="max_page" value="" id="max_page" />
					<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat" />
					<input type="hidden" name="event-page-name" value="<?php echo esc_attr('event-category-page'); ?>" id="event-page-name" />
					<!--Event list END -->
				</div>
				<!--Event Grid List view END-->
			</div>
		<?php } ?>
	</div>
</div>
<script>
	var wpml_lang_code = "";
	<?php if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) { ?>
		wpml_lang_code = '<?php echo ICL_LANGUAGE_CODE; ?>';
	<?php } ?>
</script>

<?php
$uat_event_list_page_list_type = get_option('options_uat_event_list_page_list_type', 'auction');
if ($uat_event_list_page_list_type == 'event') {

	$daterange_set = get_option('options_uat_event_list_daterange', 'on');
	$daterange = $daterange_set ? $daterange_set : "on";
	if ($daterange == "on") {
		wp_enqueue_script('jquery-ui-datepicker');
		wp_register_style('jquery-ui', UAT_THEME_PRO_CSS_URI . 'jquery-ui.css', array(), UAT_THEME_PRO_VERSION);
		wp_enqueue_style('jquery-ui');
?>
		<script type="text/javascript">
			jQuery(document).ready(function() {

				jQuery(function() {
					var dateFormat = "yy-mm-dd",
						from = jQuery(".from_date").datepicker({
							defaultDate: "+1w",
							numberOfMonths: 2,
							dateFormat: "yy-mm-dd",
						})
						.on("change", function() {
							to.datepicker("option", "minDate", getDate(this));
						}),
						to = jQuery(".to_date").datepicker({
							defaultDate: "+1w",
							numberOfMonths: 2,
							dateFormat: "yy-mm-dd",
						})
						.on("change", function() {
							from.datepicker("option", "maxDate", getDate(this));
							if (jQuery(".from_date").val() == "") {
								jQuery(".from_date").datepicker({
									dateFormat: "yy-mm-dd"
								}).datepicker("setDate", new Date());
							}
							if (jQuery(".from_date").val() != "" && jQuery(".to_date").val() != "") {
								load_events_serach_result(1);
							}
						});

					function getDate(element) {
						var date;
						try {
							date = jQuery.datepicker.parseDate(dateFormat, element.value);
						} catch (error) {
							date = null;
						}
						return date;
					}
				});

			});
		</script>
		<input type="hidden" name="event_page_id" id="event_page_id" value="cat" />
	<?php }
} else { ?>

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
				console.log(e)
				var $oldaction = jQuery('input[name="event_sortby_by"').val();
				var $action = jQuery(this).data("value");
				if ($oldaction != $action) {
					var $action_html = jQuery(this).html();
					jQuery('input[name="event_sortby_by"').val($action);
					load_events_products_serach_result(1);
					jQuery('.drop-down .selected span').html($action_html)
				}
			});
		});
	</script>
<?php } ?>
<!-- <script type='text/javascript' src='<?php echo UAT_THEME_PRO_JS_URI; ?>/slider/slick.min.js'></script> -->

<?php get_footer();
