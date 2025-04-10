<?php
/*
Template Name: Home Page Template
Template Post Type: page
*/
get_header();


global $wpdb, $sitepress;
$page_id = get_the_ID();

$ctos_car_years = get_field('ctos_car_years', 'option');
$ctos_car_years_d = '';
if (!empty($ctos_car_years) && $ctos_car_years == 'off') {
	$ctos_car_years_d = 'style="display:none"';
}
$ctos_car_transmission = get_field('ctos_car_transmission', 'option');
$ctos_car_transmission_d = '';
if (!empty($ctos_car_transmission) && $ctos_car_transmission == 'off') {
	$ctos_car_transmission_d = 'style="display:none"';
}
$ctos_car_body_style = get_field('ctos_car_body_style', 'option');
$ctos_car_body_style_d = '';
if (!empty($ctos_car_body_style) && $ctos_car_body_style == 'off') {
	$ctos_car_body_style_d = 'style="display:none"';
}
$ctos_car_ending_soon = get_field('ctos_car_ending_soon', 'option');
$ctos_car_ending_soon_d = '';
if (!empty($ctos_car_ending_soon) && $ctos_car_ending_soon == 'off') {
	$ctos_car_ending_soon_d = 'style="display:none"';
}
$ctos_car_newly_listed = get_field('ctos_car_newly_listed', 'option');
$ctos_car_newly_listed_d = '';
if (!empty($ctos_car_newly_listed) && $ctos_car_newly_listed == 'off') {
	$ctos_car_newly_listed_d = 'style="display:none"';
}
$ctos_car_no_reserve = get_field('ctos_car_no_reserve', 'option');
$ctos_car_no_reserve_d = '';
if (!empty($ctos_car_no_reserve) && $ctos_car_no_reserve == 'off') {
	$ctos_car_no_reserve_d = 'style="display:none"';
}
$ctos_car_lowest_mileage = get_field('ctos_car_lowest_mileage', 'option');
$ctos_car_lowest_mileage_d = '';
if (!empty($ctos_car_lowest_mileage) && $ctos_car_lowest_mileage == 'off') {
	$ctos_car_lowest_mileage_d = 'style="display:none"';
}
$ctos_car_highest_mileage = get_field('ctos_car_highest_mileage', 'option');
$ctos_car_highest_mileage_d = '';
if (!empty($ctos_car_highest_mileage) && $ctos_car_highest_mileage == 'off') {
	$ctos_car_highest_mileage_d = 'style="display:none"';
}

$ctos_car_closest_to_me_d = '';
if (!show_closest_to_me()) {
	$ctos_car_closest_to_me_d = 'style="display:none"';
}

$ctos_car_recently_ended = get_field('ctos_car_recently_ended', 'option');
$ctos_car_recently_ended_d = '';
if (!empty($ctos_car_recently_ended) && $ctos_car_recently_ended == 'off') {
	$ctos_car_recently_ended_d = 'style="display:none"';
}

$ctos_car_lowest_price = get_field('ctos_car_lowest_price', 'option');
$ctos_car_lowest_price_d = '';
if (!empty($ctos_car_lowest_price) && $ctos_car_lowest_price == 'off') {
	$ctos_car_lowest_price_d = 'style="display:none"';
}

$ctos_car_highest_price = get_field('ctos_car_highest_price', 'option');
$ctos_car_highest_price_d = '';
if (!empty($ctos_car_highest_price) && $ctos_car_highest_price == 'off') {
	$ctos_car_highest_price_d = 'style="display:none"';
}
?>

<div id="primary" class="content-area">
	<?php //echo uat_theme_breadcrumbs(); ?>
    <?php the_content(); ?>
</div>

<?php /*
<div class="container">
	<h1 class="page-title cat-title"><?php //the_title(); ?></h1>
	<?php
	$list_page_layout = get_field('car_page_tmp_page_layout', $page_id);
	$list_page_class = 'pro-list-without-sidebar';
	if ($list_page_layout == "left-sidebar" || $list_page_layout == "right-sidebar") {
		$list_page_class = 'pro-list-with-sidebar';
	} else if ($list_page_layout == "full-width") {
		$list_page_class = 'pro-list-without-sidebar';
	}
	?>

	<div class="<?php echo $list_page_class; ?>">


		<?php if ($list_page_layout == "left-sidebar" || $list_page_layout == "right-sidebar") {
			if ($list_page_layout == "left-sidebar"){
				$list_page_layout = "left-sidebar right-sidebar";
			}
			?>
			<div class="<?php echo esc_attr($list_page_layout); ?>">
			<?php if (is_active_sidebar('ua_child_theme_carlist')) { ?>
				<?php dynamic_sidebar('ua_child_theme_carlist'); ?>
			<?php }else{
				get_template_part( 'page-templates/partials/car', 'sidebar' );
			} ?>
			</div>
		<?php } ?>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="product-list-block-entry-content">
			<?php the_content(); ?>
		</div>
		<?php endwhile; ?>
		<?php endif; ?>
		<div class="product-list-block">
			<div class="product-list-filters">
				<div class="title-with-drops">
					<div class="page-heading">
						<h1><?php echo __("Auctions", 'ultimate-auction-pro-software'); ?> </h1>
						<div class="dropdown-filter">
							<?php
							$meta_values = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key='cmf_Year' and meta_value!='' ORDER BY meta_value DESC");
							?>
							<select name="year" class="year" id="year" <?php echo $ctos_car_years_d; ?>>
								<option value=""><?php echo __("Years", 'ultimate-auction-pro-software'); ?></option>
								<?php foreach ($meta_values as $meta_value) : ?>
									<option value="<?= esc_attr($meta_value) ?>"><?= esc_attr($meta_value) ?></option>
								<?php endforeach ?>
							</select>
							<select name="transmission" class="transmission" id="transmission" <?php echo $ctos_car_transmission_d; ?>>
								<?php
								$meta_values1 = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key='cmf_transmission' and meta_value!='' ORDER BY meta_value ASC");
								?>
								<option value=""><?php echo __("Transmission", 'ultimate-auction-pro-software'); ?></option>
								<?php foreach ($meta_values1 as $meta_value) : ?>
									<option value="<?= esc_attr($meta_value) ?>"><?= esc_attr($meta_value) ?></option>
								<?php endforeach ?>
							</select>
							<select name="body_style" class="body_style" id="body_style" <?php echo $ctos_car_body_style_d; ?>>
								<?php
								$meta_values2 = $wpdb->get_col("SELECT DISTINCT meta_value FROM $wpdb->postmeta WHERE meta_key='cmf_body_style' and meta_value!=''ORDER BY meta_value ASC");
								?>
								<option value=""><?php echo __("Body style", 'ultimate-auction-pro-software'); ?></option>
								<?php foreach ($meta_values2 as $meta_value) : ?>
									<option value="<?= esc_attr($meta_value) ?>"><?= esc_attr($meta_value) ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>

					<div class="product-filter-tab">
						<ul id="Filters-tab">
							<li class="active" <?php echo $ctos_car_ending_soon_d; ?>><a href="javascript:;" class="cat_flt_short" data-short="ending_soon"><?php echo __("Ending Soon", 'ultimate-auction-pro-software'); ?></a></li>
							<li class="" <?php echo $ctos_car_newly_listed_d; ?>><a href="javascript:;" class="cat_flt_short" data-short="newly_listed"><?php echo __("Newly Listed", 'ultimate-auction-pro-software'); ?></a></li>
							<li class="" <?php echo $ctos_car_no_reserve_d; ?>><a href="javascript:;" class="cat_flt_short" data-short="no_reserve"><?php echo __("No Reserve", 'ultimate-auction-pro-software'); ?></a></li>
							<li class="" <?php echo $ctos_car_lowest_mileage_d; ?>><a href="javascript:;" class="cat_flt_short" data-short="lowest_mileage"><?php echo __("Lowest Mileage", 'ultimate-auction-pro-software'); ?></a></li>
							<li class="" <?php echo $ctos_car_closest_to_me_d; ?>>
								<a  data-short="closest_to_me" class="cat_flt_short" href="javascript:;">
									<?php echo __("Closest to me", 'ultimate-auction-pro-software'); ?>
								</a>
								<span class="closest_me_text"></span>
							</li>
							<input type="hidden" name="cat_flt_short" id="cat_flt_short" value="ending_soon" />
						</ul>
					</div>
				</div>
			</div>
			<div class="product-list-row" id="tabs-content"></div>
			<div class="show-more-link full-section">
				<div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
					<img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
				</div>
				<?php
				$pagination_type = get_field('car_page_tmp_pagination_type', $page_id);
				if ($pagination_type == "load-more") { ?>
					<a href="Javascript:void(0);" style="display:none;" class="view-auc-result show-more ua-button-black" onclick="load_get_car_results_data('');"><?php echo __("Load More", 'ultimate-auction-pro-software'); ?></a>
				<?php } ?>
			</div>

			<input type="hidden" name="max_page" value="" id="max_page" />
			<input type="hidden" name="ajax_loading_stat" value="" id="ajax_loading_stat" />
			<?php
			$perpage = get_field('car_page_tmp_perpage', $page_id);
			$tmp_perpage = $perpage ? $perpage : 12;
			?>

			<?php
			$p_type = get_field('car_page_tmp_pagination_type', $page_id);
			$tmp_p_type = $p_type ? $p_type : "load-more"; ?>
			<input type="hidden" name="s_tmp_perpage" value="<?php echo $tmp_perpage; ?>" id="s_tmp_perpage" />
			<input type="hidden" name="s_tmp_p_type" value="<?php echo $tmp_p_type; ?>" id="s_tmp_p_type" />
		</div>
	</div>
</div>
<script type="text/javascript">
	var setpage = 1;
	var perpage = "<?php echo get_field('car_page_tmp_perpage', $page_id); ?>";
	var page_id = "<?php echo get_the_ID(); ?>";
	var maxsetpage = jQuery("#max_page").val();
	var zip_code = "";
	var	radius = "";
	if (jQuery('.product-list-row').length > 0) {
		jQuery(".ajax_search_btn").on('click', function() {
			load_get_car_results_data(1, 'html');
		});
	}

	jQuery(document).on('click', '.clear-SPfilter', function(evt) {
		evt.preventDefault();
		jQuery(".year").val("");
		jQuery(".transmission").val("");
		jQuery(".body_style").val("");
		jQuery(".cat_flt_short").val("");
		load_get_car_results_data(1, 'html');
	});

	jQuery('.year').on('change', function() {
		load_get_car_results_data(1, 'html');
	});
	jQuery('.transmission').on('change', function() {
		load_get_car_results_data(1, 'html');
	});
	jQuery('.body_style').on('change', function() {
		load_get_car_results_data(1, 'html');
	});
	jQuery(".closest_me_text").hide();
	jQuery(document).on('click', '.cat_flt_short', function() {
		jQuery('#Filters-tab li').removeClass('active');
		jQuery(this).parent().addClass('active');
		var sorting_by = jQuery(this).attr('data-short');
		jQuery("#tabs-content").html("");
		jQuery("#cat_flt_short").val(sorting_by);	
		if(sorting_by == 'closest_to_me'){
			jQuery(".closest_me_text").show();
			var string = jQuery(".closest_me_text").html();			
			setClosestText();
			if(string == ""){
				jQuery(".show-more").hide();
				jQuery("a.closesToMebox").click();
			}
		}else{
			jQuery(".closest_me_text").hide();
		}
		load_get_car_results_data(1, 'html');
	});
	jQuery(document).on('click', '.closest_me_text', function(e) {
		setClosestText();
		jQuery("a.closesToMebox").click();
	});

	jQuery(document).on('click', '#saveClosestMe', function(e) {
		e.preventDefault();
		zip_code = jQuery("#uat-closesToMebox #zipCode").val();
		if(zip_code == ""){
			jQuery(".invalid_msg").show();
			return false;
		}else{
			jQuery(".invalid_msg").hide();
		}
		var closes_to_me = {
			zipcode: jQuery("#uat-closesToMebox #zipCode").val(),
			distance: jQuery("#uat-closesToMebox #radius").val(),
			distance_text: jQuery("#uat-closesToMebox #radius option:selected").text(),
		};
		setCookie("closes_to_me_filter", JSON.stringify(closes_to_me), '7');
		setClosestText();
		jQuery('#Filters-tab li').removeClass('active');
		jQuery('#Filters-tab li a[data-short="closest_to_me"]').parent().addClass('active');
		jQuery("#cat_flt_short").val('closest_to_me');	
		load_get_car_results_data(1, 'html');
		jQuery("#uat-closesToMebox #zipCode").val("")
		jQuery("#uat-closesToMebox #radius").val("")
		jQuery.fancybox.close();
	});
	
	load_get_car_results_data(1, 'html');
	setClosestText();
	function setClosestText(){
		var closes_to_me_filter = getCookie("closes_to_me_filter");
		closes_to_me_filter = JSON.parse(closes_to_me_filter);
		var string = '';
		if(closes_to_me_filter){
			var from_text = " "+"<?php echo __( 'miles from', 'ultimate-auction-pro-software' ); ?>"+" ";
			string = closes_to_me_filter.distance+from_text+closes_to_me_filter.zipcode;
			jQuery("div#uat-closesToMebox #zipCode").val(closes_to_me_filter.zipcode);
			jQuery("div#uat-closesToMebox #radius").val(closes_to_me_filter.distance);
			jQuery("#resetClosestMe").show();
		}else{
			jQuery("div#uat-closesToMebox #zipCode").val("");
			jQuery("div#uat-closesToMebox #radius").val(jQuery("div#uat-closesToMebox #radius option:first").val());
			jQuery("#resetClosestMe").hide();
		}
		jQuery(".closest_me_text").html(string);
	}
	jQuery(document).on('click', '#resetClosestMe', function(e) {
		e.preventDefault();
		setCookie("closes_to_me_filter", "", '-7');
		setClosestText();
	});
	function load_get_car_results_data(setpage2, type) {
		//var perpage = jQuery("#s_tmp_perpage").val();			 
		jQuery("#loader_ajax").show();
		jQuery("#ajax_loading_stat").val("loading_ajax");
		if (setpage == 1) {
			jQuery(".show-more").hide();
		}
		if (setpage2 != "") {
			setpage = setpage2;
		} else {
			setpage = setpage;
		}

		if (jQuery('.product-list-row').length < 1) {
			return false;
		} else {
			jQuery.ajax({
				type: 'POST',
				url: ajaxurl,
				data: {
					action: 'get_car_results_data',
					setpage: setpage,
					perpage: perpage,
					page_id: page_id,
					year: jQuery(".year").find(":selected").val(),
					transmission: jQuery(".transmission").find(":selected").val(),
					body_style: jQuery(".body_style").find(":selected").val(),
					cat_flt_short: jQuery("#cat_flt_short").val(),
					zip_code: jQuery("#uat-closesToMebox #zipCode").val(),
					radius: jQuery("#uat-closesToMebox #radius").val(),
				},
				success: function(response) {
					if (setpage == 1) {
						jQuery("#tabs-content").html(response);
						jQuery("#tabs-content").show();
						jQuery('body,html').animate({
							scrollTop: jQuery('#tabs-content').offset().top - 240
						});
					} else {
						jQuery("#tabs-content").append(response);
					}
					jQuery("#loader_ajax").hide();
					jQuery("#ajax_loading_stat").val("");
					setpage++;

					if (timer_type != 'timer_jquery') {
						intclock();
					} else {
						jquery_clock_rebind();
					}

				},
			});
		}
	}

	//Pagination Scroll Type for car list pages
	jQuery(document).on('scroll', function() {
		if (jQuery('#tabs-content').length < 1) {
			return false;
		} else {
			var carlist_pagination_type = jQuery("#s_tmp_p_type").val();
			if (carlist_pagination_type == "infinite-scroll") {
				var max_page = jQuery('#max_page').val();
				var loading_stat = jQuery("#ajax_loading_stat").val();
				if (jQuery(this).scrollTop() >= jQuery('.show-more-link').position().top - 500 && max_page != "hide" && loading_stat != "loading_ajax") {
					load_get_car_results_data(setpage);
				}
			}
		}
	});
</script>
*/ ?>
<?php get_footer();