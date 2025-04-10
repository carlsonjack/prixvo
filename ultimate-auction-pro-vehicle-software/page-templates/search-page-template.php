<?php

/* Template Name: Vehicle List With Search Option*/

get_header();
global $wpdb, $sitepress;
$page_id = get_the_ID();
$pagination_type = get_field('car_list_page_tmp_pagination_type', $page_id);
$show_expired = get_field('car_filers_options_show_expired', $page_id);

?>
<div id="primary-main" class="content-area">
	<?php echo uat_theme_breadcrumbs();?>
    <?php the_content(); ?>
</div>
<div class="container">
	<?php
	$list_page_layout = get_field('car_list_page_tmp_page_layout', $page_id);
	$list_page_class = '';
	if ($list_page_layout == "left-sidebar" || $list_page_layout == "right-sidebar") {
		$list_page_class = 'pro-list-with-sidebar';
	} else if ($list_page_layout == "full-width") {
		$list_page_class = 'pro-list-without-sidebar';
	}
	?>
	<div class="<?php echo $list_page_class; ?>">
		<?php if ($list_page_layout == "left-sidebar" || $list_page_layout == "right-sidebar") {
			if ($list_page_layout == "left-sidebar") {
				$list_page_layout = "left-sidebar right-sidebar";
			}
		?>
			<div class="<?php echo esc_attr($list_page_layout); ?>">
				<?php get_template_part('page-templates/partials/car', 'list-filters'); ?>
			</div>
		<?php } ?>

		<div class="product-list-block">
			<div class="title-with-drops carsTotalDiv" style="display: none;">
				<div class="page--sub-heading carsTotalText"></div>
			</div>

			<div class="title-with-drops carsCurFilterDiv" style="display: none;">
				<!-- <div class="page--sub-heading carsCurFilterChildDiv" style="border: 1px solid black;">Car Model: 10</div> -->
				<div class="applied-filters">
					<div class="chipsMain undefined null" style="display: none;">
						<div class="chipsButton active ">
							<span class="buttonLabel"></span>
							<span class="close-icon">
								<?php /*<img decoding="async" class="filter-sm-ic" width="14px" height="14px" alt="Close" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/smallClose.svg" loading="eager">*/ ?>
								<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 4.2L9.8 3.5L7 6.3L4.2 3.5L3.5 4.2L6.3 7L3.5 9.8L4.2 10.5L7 7.7L9.8 10.5L10.5 9.8L7.7 7L10.5 4.2Z" fill="var(--wp--custom-primary-link-color)"/>
								</svg>
							</span>
							<span class="chipDownSecArrow" style="display: none; visibility: hidden;"></span>
						</div>
					</div>
				</div>
			</div>
			<div class="TabSection">
				<div class="tabsList" id="">
					<div class="tabContainer">
						<!-- <ul class="ucrTopTabs">
							<li id="tab-id-used-certified+cars+in+rajkot" class="hover  "><span>Certified Cars</span></li>
							<li id="tab-id-used-cars+2-lakh-to-5-lakh+in+rajkot" class="hover  "><span>Budget Cars</span></li>
							<li id="tab-id-used-honda+hyundai+mahindra+maruti+tata+toyota+cars+in+rajkot" class="hover  "><span>Popular Cars</span></li>
							<li id="tab-id-used-cars+20-lakh-to-5-crore+in+rajkot" class="hover  "><span>Luxury Cars</span></li>
							<li id="tab-id-used-partner+cars+in+rajkot" class="hover  "><span>Partner Cars</span></li>
						</ul> -->
					</div>
				</div>
				<div class="sort-widget">
					<select class="sort-select">
						<option value="" selected=""><?php echo __("Relevance", 'ultimate-auction-theme'); ?></option>
						<option value="date_asc" data-sort-key="woo_ua_auction_end_date" data-sort-order="ASC"><?php echo __("Ending Date - Ascending", 'ultimate-auction-theme'); ?></option>
						<option value="date_desc" data-sort-key="woo_ua_auction_end_date" data-sort-order="DESC"><?php echo __("Ending Date - Descending", 'ultimate-auction-theme'); ?></option>
						<!-- <option value="current_bid_asc"  data-sort-key="woo_ua_auction_current_bid" data-sort-order="ASC">Bidding - Ascending</option>
						<option value="current_bid_desc" data-sort-key="woo_ua_auction_current_bid" data-sort-order="DESC">Bidding - Descending</option> -->
					</select>
				</div>
			</div>
			<div class="product-list-row" id="tabs-content"></div>
			<div class="show-more-link full-section">
				<div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
					<img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
				</div>

				<?php if ($pagination_type != "infinite-scroll") : ?>
					<a href="Javascript:void(0);" style="display:none;" class="view-auc-result show-more ua-button-black"><?php echo __("Load More", 'ultimate-auction-theme'); ?></a>
				<?php endif ?>
			</div>

			<input type="hidden" name="max_page" value="" id="max_page" />
			<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat" />

		</div>
	</div>
</div>

<?php
$svg_close_icon = '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" clip-rule="evenodd" d="M10.5 4.2L9.8 3.5L7 6.3L4.2 3.5L3.5 4.2L6.3 7L3.5 9.8L4.2 10.5L7 7.7L9.8 10.5L10.5 9.8L7.7 7L10.5 4.2Z" fill="var(--wp--custom-primary-link-color)"/>
</svg>';
$car_list_js_vars = array(
	'ajaxurl' => admin_url('admin-ajax.php'),
	'perpage' => get_field('car_list_page_tmp_perpage', $page_id),
	'pagination_type' => $pagination_type,
	'filters' => get_car_list_filers($page_id),
	'page_id' => $page_id,
	'all_filters' => get_car_list_filers($page_id),
	'total_text_show' => true,
	'current_filters_show' => true,
	'show_expired' => $show_expired,
	'close_svg_icon' => $svg_close_icon,
	'total_text' => __("Cars With Selected Filter Options", 'ultimate-auction-theme'),
	'collaps_text' => __("Collapse all filters", 'ultimate-auction-theme'),
	'expand_text' => __("Expand all filters", 'ultimate-auction-theme'),
);

wp_localize_script('child_car_list_js', 'car_list_js_vars', $car_list_js_vars);
wp_enqueue_script('child_car_list_js');
get_footer();
