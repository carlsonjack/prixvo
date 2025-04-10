<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ultimate Auction Pro Software
 */
// Ajax call For events list
add_action('wp_ajax_uat_EventSearch_Results_ajax', 'uat_EventSearch_Results_ajax_callback');
add_action('wp_ajax_nopriv_uat_EventSearch_Results_ajax', 'uat_EventSearch_Results_ajax_callback');
function uat_EventSearch_Results_ajax_callback()
{
	global $wpdb;
	global $sitepress;
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$lang = $_REQUEST['ajax_ICL_LANGUAGE_CODE'];
		$sitepress->switch_lang($lang);
	}
	$table = UA_EVENTS_TABLE;
	$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
	$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
	$postids = uat_get_all_events_ids_by_filters($_REQUEST['date_from'], $_REQUEST['date_to']);
	if (empty($postids)) {
		$postids[] = array();
	}
	$postids = array_unique($postids);
	//Search Argument
	$ajax_search_str = isset($_REQUEST['ajax_search_str']) ? sanitize_text_field($_REQUEST['ajax_search_str']) : '';
	//Categories IDS
	$conditinalarr = array('relation' => 'AND');
	$p_cat_ids = "";
	$p_cat_ids = explode("&", $_REQUEST['p_cat_ids']);
	$p_cat_ids_arr = array();
	if ($_REQUEST['p_cat_ids'] != "") {
		foreach ($p_cat_ids as $p_cat_idsval) {
			$valget = explode("=", $p_cat_idsval);
			$p_cat_ids_arr[] = $valget[1];
		}
		if (count($p_cat_ids_arr) > 0) {
			$conditinalarr[] = array(
				'taxonomy' => 'uat-event-cat',
				'field' => 'id',
				'terms' => $p_cat_ids_arr
			);
		}
	}
	$meta_queryarr = array('relation' => 'AND');
	//$meta_queryarr=array();
	//eCountries
	$eCountries = "";
	$eCountries = explode("&", $_REQUEST['eCountries']);
	$p_eCountries_arr = array();
	if ($_REQUEST['eCountries'] != "") {
		foreach ($eCountries as $p_eCountriesval) {
			$valget = explode("=", $p_eCountriesval);
			$p_eCountries_arr[] = $valget[1];
		}
		// meta query eCountries query
		if (count($p_eCountries_arr) > 0) {
			$meta_queryarr[] = array(
				'key' => 'uat_event_loc_country',
				'value'   => array_values($p_eCountries_arr),
				'compare' 	=> 'IN',
			);
		}
	}
	//eStates
	$eStates = "";
	$eStates = explode("&", $_REQUEST['eStates']);
	$p_eStates_arr = array();
	if ($_REQUEST['eStates'] != "") {
		foreach ($eStates as $p_eStatesval) {
			$valget = explode("=", $p_eStatesval);
			$p_eStates_arr[] = $valget[1];
		}
		// meta query eStates query
		if (count($p_eStates_arr) > 0) {
			$meta_queryarr[] = array(
				'key' => 'uat_event_loc_state',
				'value'   => array_values($p_eStates_arr),
				'compare' 	=> 'IN',
			);
		}
	}
	$eCities = "";
	$eCities = explode("&", wp_trim_words($_REQUEST['eCities']));
	$p_eCities_arr = array();
	if ($_REQUEST['eCities'] != "") {
		foreach ($eCities as $p_eCitiesval) {
			$valget = explode("=", $p_eCitiesval);
			$p_eCities_arr[] = $valget[1];
		}
		// meta query eCities query
		if (count($p_eCities_arr) > 0) {
			$meta_queryarr[] = array(
				'key' => 'uat_event_loc_city',
				'value'   => array_values($p_eCities_arr),
				'compare' 	=> 'IN',
			);
		}
	}
	//date meta query past-auction not included
	if (empty($_REQUEST['date_from']) && empty($_REQUEST['date_to'])) {
		$meta_queryarr[] = array(
			'key' => 'end_time_and_date',
			'value' => get_ultimate_auction_now_date(),
			'type' => 'DATE',
			'compare' => '>='
		);
	}
	//User for total result count
	$args_total = array(
		'post_type' => array('uat_event'),
		'post_status' => array('Publish'),
		'ignore_sticky_posts' => 1,
		'posts_per_page' => -1,
		'paged'         => $_REQUEST['setpage'],
		'post__in'  =>  $postids,
	);
	//Search Argument
	if (!empty($ajax_search_str)) {
		$args_total['s'] = $ajax_search_str;
	}
	if (count($conditinalarr) > 1) {
		$args_total['tax_query'] = $conditinalarr;
	}
	if (count($meta_queryarr) > 1) {
		$args_total['meta_query'] = $meta_queryarr;
	}
	$total_query = new WP_Query($args_total);
	$total_events_found = $total_query->post_count;
	//Used for fetch record and display in result
	$args = array(
		'post_type' => array('uat_event'),
		'post_status' => array('Publish'),
		'ignore_sticky_posts' => 1,
		'posts_per_page' => $_REQUEST['perpage'],
		'paged'         => $_REQUEST['setpage'],
		'post__in'  =>  $postids,
	);
	//Search Argument
	if (!empty($ajax_search_str)) {
		$args['s'] = $ajax_search_str;
	}
	// tax_query
	if (count($conditinalarr) > 1) {
		$args['tax_query'] = $conditinalarr;
	}
	if (count($meta_queryarr) > 1) {
		$args['meta_query'] = $meta_queryarr;
	}
	if ($_REQUEST['end_date_by'] == "ASC") {
		$args['orderby'] = 'meta_value';
		$args['meta_key'] = 'end_time_and_date';
		$args['order'] = 'ASC';
	}
	if ($_REQUEST['end_date_by'] == "DESC") {
		$args['orderby'] = 'meta_value';
		$args['meta_key'] = 'end_time_and_date';
		$args['order'] = 'DESC';
	}

	$query = new WP_Query($args);
	$trecord = $query->post_count;
	$mpage = $query->max_num_pages;
	if ($query->have_posts()) {
		// Start the Loop
		while ($query->have_posts()) : $query->the_post();
			$event_id =  get_the_ID();
			$featured_img_url = get_the_post_thumbnail_url($event_id, 'events-fw-list-thumbnails');
			if (empty($featured_img_url)) {
				$featured_img_url = uat_get_event_default_image();
			}
			$starting_on_date = get_post_meta($event_id, 'start_time_and_date', true);
			$ending_date = get_post_meta($event_id, 'end_time_and_date', true);
			$event_status = uat_get_event_status($event_id);
			$uat_expired = uat_event_is_past_event($event_id);
			if ($event_status == "uat_live") {
				$sr_only_txt = __('LIVE Auction', 'ultimate-auction-pro-software');
			} elseif ($event_status == "uat_past") {
				$sr_only_txt = __('PAST Auction', 'ultimate-auction-pro-software');
			} elseif ($event_status == "uat_future") {
				$sr_only_txt = __('Future Auction', 'ultimate-auction-pro-software');
			}
			get_template_part( 'templates/events/uat', 'event-box' );
	?>
			<!-- <div class="item">
				<div class="product-img-box">
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo esc_url($featured_img_url); ?>"></a>
				</div>
				<?php

				$page_id = $_REQUEST['event_page_id'];
				if ($page_id == "cat") {
					$timer = get_option('options_uat_event_list_timer', 'off');
				} else {

					$timer = get_field('event_list_page_timer', $page_id);
				}


				if ($event_status == "uat_live") {
					global $wpdb;
					$event_end_date = $wpdb->get_var('SELECT event_end_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
					$auc_end_date = $event_end_date;
					$rem_arr = get_remaining_time_by_timezone($auc_end_date);
					if ($timer === 'true') { ?>
						<div class="box-timer">
							<?php
							event_countdown_clock(
								$end_date = $auc_end_date,
								$item_id = $event_id,
								$item_class = 'time_countdown_event',
							);
							?>
						</div>
					<?php }
				} elseif ($event_status == "uat_future") {
					global $wpdb;
					$event_start_date = $wpdb->get_var('SELECT event_start_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
					$auc_end_date = $event_start_date;
					$rem_arr = get_remaining_time_by_timezone($auc_end_date);
					if ($timer === 'true') { ?>
						<div class="box-timer">
							<?php
							event_countdown_clock(
								$end_date = $auc_end_date,
								$item_id = $event_id,
								$item_class = 'time_countdown_event',
							);
							?>
						</div>
				<?php }
				} ?>
				<div class="ua-box-detail">
					<div class="Ua-category"><span class="sr-only"><?php _e('Category', 'ultimate-auction-pro-software'); ?>: </span><?php echo esc_attr($sr_only_txt); ?></div>
					<div class="Ua-box-title"><?php the_title(); ?></div>
					<div class="Card-details">
						<?php echo date_i18n(get_option('date_format'), strtotime($starting_on_date));  ?>–<?php echo date_i18n(get_option('date_format'), strtotime($ending_date));  ?>
						| <?php echo date_i18n(get_option('time_format'), strtotime($ending_date));  ?> <?php echo esc_attr($timezone_string); ?>

					</div>
				</div>

				<?php
				if ($event_status == "uat_live") { ?>
					<a class="ua-button" href="<?php the_permalink(); ?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?></a>
				<?php } elseif ($event_status == "uat_future") { ?>
					<a class="ua-button" href="<?php the_permalink(); ?>"><?php _e('Preview', 'ultimate-auction-pro-software'); ?></a>
				<?php } else { ?>
					<a class="ua-button" href="<?php the_permalink(); ?>"><?php _e('View Results', 'ultimate-auction-pro-software'); ?></a>
				<?php } ?>
			</div> -->
		<?php endwhile; ?>
	<?php /*pagination*/
	} else { ?>
		<div class='no-result-found'>
			<div class="no-result-text"><?php _e('Sorry, there are no results', 'ultimate-auction-pro-software'); ?></div>
			<a href="Javascript:void(0);" class="clear-efilter ua-button-black"><?php _e('Clear Filters', 'ultimate-auction-pro-software'); ?></a>
		</div>
	<?php }
	// Restore original Post Data
	wp_reset_postdata();
	?>
	<script type="text/javascript">
		jQuery(".Result-Counts").text(<?php echo $total_events_found; ?>);
		<?php if ($mpage == trim($_POST['setpage']) || $mpage == 0) { ?>
			jQuery(".show-more").hide();
			jQuery("#max_page").val("hide");
		<?php } else { ?>
			jQuery("#max_page").val("");
			jQuery(".show-more").show();
		<?php } ?>
	</script>
	<?php
	wp_die();
}
// Ajax call For events detail page
add_action('wp_ajax_uat_Event_ProductsSearch_Results_ajax', 'uat_Event_ProductsSearch_Results_ajax_callback');
add_action('wp_ajax_nopriv_uat_Event_ProductsSearch_Results_ajax', 'uat_Event_ProductsSearch_Results_ajax_callback');
function uat_Event_ProductsSearch_Results_ajax_callback()
{
	global $wpdb;
	global $sitepress;
	$active_theme_slug = get_stylesheet();
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$lang = $_REQUEST['ajax_ICL_LANGUAGE_CODE'];
		$sitepress->switch_lang($lang);
	}
	$ValidStatusForProductVisible = getValidStatusForProductVisible();
	$event_id = isset($_REQUEST['event_id']) ? absint($_REQUEST['event_id']) : '';
	if(!empty($event_id)){
		$lot_ids_array  = get_auction_products_ids_by_event($event_id);
		$original_array = unserialize($lot_ids_array);
		if (empty($original_array)) {
			$original_array[] = array();
		}
		$original_array = array_unique($original_array);
	}
	$cat_id = isset($_REQUEST['cat_id']) ? absint($_REQUEST['cat_id']) : '';
	if(!empty($cat_id)){
		$original_array  = get_auction_products_ids_by_event_categorie($cat_id);
		if (empty($original_array)) {
			$original_array[] = array();
		}
		$original_array = array_unique($original_array);
	}
	
	//Search Argument
	$ajax_search_str = isset($_REQUEST['ajax_search_str']) ? sanitize_text_field($_REQUEST['ajax_search_str']) : '';
	$conditinalarr = array('relation' => 'AND');
	if (!empty($_REQUEST['estiamte_price_to'])  && !empty($_REQUEST['estiamte_price_from'])) {
		$conditinalarr[] = array(
			'relation' => 'OR',
			array(
				'key' => 'uat_estimate_price_from',
				'value' => array($_REQUEST['estiamte_price_from'], $_REQUEST['estiamte_price_to']),
				'compare' => 'BETWEEN',
				'type'    => 'numeric',
			),
			array(
				'key' => 'uat_estimate_price_to',
				'value' => array($_REQUEST['estiamte_price_from'], $_REQUEST['estiamte_price_to']),
				'compare' => 'BETWEEN',
				'type'    => 'numeric',
			)
		);
	}
	if (!empty($_REQUEST['bid_price_to'])  && !empty($_REQUEST['bid_price_from'])) {
		$conditinalarr[] = array(
			array(
				'key' => 'woo_ua_auction_current_bid',
				'value' => array($_REQUEST['bid_price_from'], $_REQUEST['bid_price_to']),
				'compare' => 'BETWEEN',
				'type'    => 'numeric',
			),
		);
	}
	//User for total result count
	$args_total = array(
		'post_type'	=> 'product',
		'post_status' => $ValidStatusForProductVisible,
		'ignore_sticky_posts'	=> 1,
		'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),
		'posts_per_page' => -1,
		'paged' => $_REQUEST['setpage'],
	);
	if(!empty($original_array)){
		$args_total['post__in'] = $original_array;
	}
	//date meta query included
	if (count($conditinalarr) > 1) {
		$args_total['meta_query'] = $conditinalarr;
	}
	//Search Argument
	if (!empty($ajax_search_str)) {
		$args_total['s'] = $ajax_search_str;
	}
	$total_query = new WP_Query($args_total);
	$total_lots_found = $total_query->post_count;
	//Used for fetch record and display in result
	$args = array(
		'post_type'	=> 'product',
		'post_status' => $ValidStatusForProductVisible,
		'ignore_sticky_posts'	=> 1,
		'post__in' => $original_array,
		'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),
		'posts_per_page' => $_REQUEST['perpage'],
		'paged'         => $_REQUEST['setpage'],
	);
	//date meta query included
	if (count($conditinalarr) > 1) {
		$args['meta_query'] = $conditinalarr;
	}
	//Search Argument
	if (!empty($ajax_search_str)) {
		$args['s'] = $ajax_search_str;
	}
	if($active_theme_slug != 'ultimate-auction-pro-vehicle-software') {
		if ($_REQUEST['event_sortby_by'] == "lot_number_asc") {
			$args['orderby'] = 'meta_value';
			$args['meta_key'] = 'uat_auction_lot_number';
			$args['order'] = 'ASC';
		}
		if ($_REQUEST['event_sortby_by'] == "lot_number_desc") {
			$args['orderby'] = 'meta_value';
			$args['meta_key'] = 'uat_auction_lot_number';
			$args['order'] = 'DESC';
		}
		if ($_REQUEST['event_sortby_by'] == "estimate_asc") {
			$args['orderby'] = 'meta_value';
			$args['meta_key'] = 'uat_estimate_price_from';
			$args['order'] = 'ASC';
		}
		if ($_REQUEST['event_sortby_by'] == "estimate_desc") {
			$args['orderby'] = 'meta_value';
			$args['meta_key'] = 'uat_estimate_price_from';
			$args['order'] = 'DESC';
		}
	}

	$query = new WP_Query($args);

	$trecord = $query->post_count;
	$mpage = $query->max_num_pages;
	$uat_theme_option = get_option('options_uat_search_results_page_timer');
	if ($query->have_posts()) {
		while ($query->have_posts()) : $query->the_post();
			set_query_var('show_timer', $uat_theme_option);
			wc_get_template_part('content', 'product');
		endwhile;
	} else { 
		?>
		<div class='no-result-found'>
			<?php echo __("Sorry, there are no results", 'ultimate-auction-pro-software'); ?>
			<a href="Javascript:void(0);" class="clear-pfilter ua-button-black"><?php echo __("Clear Filters", 'ultimate-auction-pro-software'); ?></a>
		</div>
	<?php }
	// Restore original Post Data
	wp_reset_postdata();
	?>
	<script type="text/javascript">
		jQuery(".PResult-Counts").text(<?php echo $total_lots_found; ?>);
		<?php if ($mpage == trim($_POST['setpage']) || $mpage == 0) { ?>
			jQuery(".show-more").hide();
			jQuery("#max_page").val("hide");
		<?php } else { ?>
			jQuery("#max_page").val("");
			jQuery(".show-more").show();
		<?php } ?>
		/* --------------------------------------------------------
		 Add / Remove savedlist loop
		----------------------------------------------------------- */
		jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);

		function savedlist_loop(event) {
			var auction_id = jQuery(this).data('auction-id');
			var currentelement = jQuery(this);
			jQuery.ajax({
				type: "get",
				url: UAT_Ajax_Url,
				data: {
					post_id: auction_id,
					'uat-ajax': "savedlist_loop"
				},
				success: function(response) {
					currentelement.parent().replaceWith(response);
					jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);
					jQuery(document.body).trigger('uat-savedlist-action-loop', [response, auction_id]);
				}
			});
		}
	</script>
	<?php
	wp_die();
}
add_action('wp_ajax_uwa_event_expired', 'uwa_event_expired_ajax_callback');
add_action('wp_ajax_nopriv_uwa_event_expired', 'uwa_event_expired_ajax_callback');
function uwa_event_expired_ajax_callback()
{
	$return = null;
	if (isset($_REQUEST['eventid']) && !empty($_REQUEST['eventid'])) {
		uat_event_is_past_event($_REQUEST['eventid']);
		$return['status'] = 'success';
	}
	$return;
	wp_die();
}
/**
 * Ajax watch list Events
 *
 * Function for adding or removing event to watchlist
 *
 */
add_action('wp_ajax_uat_event_watchlist_action', 'uat_ajax_watchlist_events_ajax_callback');
add_action('wp_ajax_nopriv_uat_event_watchlist_action', 'uat_ajax_watchlist_events_ajax_callback');
function uat_ajax_watchlist_events_ajax_callback()
{
	//$event_id = $_REQUEST['event_id'];
	if (is_user_logged_in()) {
		$event_id = $_REQUEST['event_id'];
		$user_ID = get_current_user_id();
		if ($event_id) {
			if (is_uat_user_watching_event($event_id)) {
				delete_post_meta($event_id, 'uat_event_saved_id', $user_ID);
				delete_user_meta($user_ID, 'uat_event_saved_id', $event_id);
			} else {
				add_post_meta($event_id, 'uat_event_saved_id', $user_ID);
				add_user_meta($user_ID, 'uat_event_saved_id', $event_id);
			}
		}
		uat_watching_event($event_id);
	} else {
		echo "<p>";
		printf(__('<span class="watchlist-error">Please sign in to add event to watchlist. </span><a href="%s" class="button watchlist-error">Login &rarr;</a>', 'ultimate-auction-pro-software'), get_permalink(wc_get_page_id('myaccount')));
		echo "</p>";
	}
	wp_die();
}
?>