<?php

function clock_react_include($hook)
{
	$my_js_ver = '';

	$upload = wp_get_upload_dir();
	$baseurl = $upload['baseurl'];


	$clocktype = get_option('options_timer_type', "timer_jquery");
	$single_product_page = false;
	if (is_product()) {
		$single_product_page = true;
	}
	$single_event_page = false;
	if (is_singular('uat_event')) {
		$single_event_page = true;
	}

	$multi_lang_data = array(
		'labels' => array(
			'Years' => __('Years', 'ultimate-auction-pro-software'),
			'Months' => __('Months', 'ultimate-auction-pro-software'),
			'Weeks' => __('Weeks', 'ultimate-auction-pro-software'),
			'Days' => __("Day(s)", 'ultimate-auction-pro-software'),
			'Hours' => __("Hour(s)", 'ultimate-auction-pro-software'),
			'Minutes' => __("Min(s)", 'ultimate-auction-pro-software'),
			'Seconds' => __("Sec(s)", 'ultimate-auction-pro-software'),
		),
		'labels1' => array(
			'Years' => __('Year', 'ultimate-auction-pro-software'),
			'Months' => __('Month', 'ultimate-auction-pro-software'),
			'Weeks' => __('Week', 'ultimate-auction-pro-software'),
			'Days' => __('Day(s)', 'ultimate-auction-pro-software'),
			'Hours' => __('Hour(s)', 'ultimate-auction-pro-software'),
			'Minutes' => __('Min(s)', 'ultimate-auction-pro-software'),
			'Seconds' => __('Sec(s)', 'ultimate-auction-pro-software'),
		),
		'compactLabels' => array(
			'Years' => __('y', 'ultimate-auction-pro-software'),
			'Months' => __('mo', 'ultimate-auction-pro-software'),
			'Weeks' => __('w', 'ultimate-auction-pro-software'),
			'Days' => __('d', 'ultimate-auction-pro-software'),
			'Hours' => __('h', 'ultimate-auction-pro-software'),
			'Minutes' => __('h', 'ultimate-auction-pro-software'),
			'Seconds' => __('s', 'ultimate-auction-pro-software'),
		),
		'settings' => array(
			'listpage' => get_option('options_uwa_listpage_sync_clock_enable'),
			'single_event_page' => $single_event_page,
			'single_product_page' => $single_product_page,
		),
	);
	wp_enqueue_script('javascript_cookie',  trailingslashit(get_template_directory_uri()) . 'includes/clock/js/cookie_fun.js', array(), $my_js_ver);
	if ($clocktype == 'timer_jquery') {

		wp_enqueue_script('uwa-jquery-countdown', trailingslashit(get_template_directory_uri()) . 'includes/clock/js/jquery.countdown.min.js', array('jquery'), $my_js_ver);
		wp_localize_script('uwa-jquery-countdown', 'multi_lang_data', $multi_lang_data);
		wp_enqueue_script('uwa-jquery-countdown-multi-lang', trailingslashit(get_template_directory_uri()) . 'includes/clock/js/jquery.countdown-multi-lang.js', array('jquery', 'uwa-jquery-countdown'), $my_js_ver);




		wp_enqueue_script('uwa-front', trailingslashit(get_template_directory_uri()) . 'includes/clock/js/uwa-front.js', array(), $my_js_ver);
		wp_localize_script('uwa-front', 'WooUa', array('ajaxurl' => admin_url('admin-ajax.php'), 'ua_nonce' => wp_create_nonce('UtAajax-nonce'), 'last_timestamp' => get_option('woo_ua_auction_last_activity', '0'), 'jQuery_timer_layout' => '<span>{dn}d {hn}h {mn}m {sn}s</span>'));
		wp_localize_script('uwa-front', 'UWA_Ajax_Qry', array('ajaqry' => add_query_arg('uwa-ajax', '')));
	
		

		$uat_custom_data = array(
			'expired' => __('Auction has Expired!', 'ultimate-auction-pro-software'),
			'gtm_offset' => get_option('gmt_offset'),
			'started' => __('Auction Started! Please refresh page.', 'ultimate-auction-pro-software'),
			'outbid_message' =>  wc_get_template_html("notices/error.php", array(
				'notices' => array(
					array(
						'notice' => __("You have been outbid", 'ultimate-auction-pro-software'),
						'data'   => '',
					),
				),
			)),
			'hide_compact' => get_option('options_uat_auction_hide_compact_enable', 'off'),
			'single_event_page' => $single_event_page,
			'single_product_page' => $single_product_page,
		);

		/*$bid_ajax_enable_check = get_option('woo_ua_auctions_bid_ajax_enable');
		$bid_ajax_enable_check_interval = get_option('woo_ua_auctions_bid_ajax_interval');
		if ($bid_ajax_enable_check == 'yes') {			
			$uat_custom_data['refresh_interval'] = isset($bid_ajax_enable_check_interval) && is_numeric($bid_ajax_enable_check_interval) ? $bid_ajax_enable_check_interval : '1';		
		}*/
		$uat_custom_data['refresh_interval'] = '1';
		$uat_custom_data['timer_day'] = __('day', 'ultimate-auction-pro-software');
		$uat_custom_data['timer_days'] = __('days', 'ultimate-auction-pro-software');
		wp_localize_script('uwa-front', 'uat_data', $uat_custom_data);
	} else {



		// wp_enqueue_script('react_clock',  trailingslashit(get_template_directory_uri()) . 'includes/clock/js/clock.js', array(), $my_js_ver);


		wp_localize_script('javascript_cookie', 'multi_lang_data', $multi_lang_data);
		wp_enqueue_script('react_clock');



		wp_localize_script(
			'react_clock',
			'frontend_react_object',
			array(
				'expired' => __('Auction has Expired!', 'ultimate-auction-pro-software'),
				'ajaxurl' => admin_url('admin-ajax.php'),
				'site_url' => site_url(),
				'react_uploadurl' => $baseurl,
				'react_curent_user_id' => get_current_user_id(),
				'timer_day' => __('day', 'ultimate-auction-pro-software'),
				'timer_days' => __('days', 'ultimate-auction-pro-software'),
			)
		);
	}
}
add_action('wp_enqueue_scripts', 'clock_react_include');
function clock_change_type_of_javascript($tag, $handle, $src)
{
	if ('react_clock' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}
	return $tag;
}
add_filter('script_loader_tag', 'clock_change_type_of_javascript', 10, 3);
function get_remaining_time_by_timezone($end_time)
{

	$date = new DateTime($end_time,  wp_timezone());
	$end_time_tz = $date->format('Y-m-d H:i:s');
	//$now_time = new DateTime();
	$now_time = new DateTime('now', wp_timezone());
	$setnag = "";

	$diff_time = $now_time->diff($date);
	$diff = $diff_time->format("%a days and %H hours and %i minutes and %s seconds");

	$days = $setnag . $diff_time->format("%a");
	$hours = $setnag . $diff_time->format("%H");
	$minute = $setnag . $diff_time->format("%i");
	$sec = $setnag . $diff_time->format("%s");

	$re_time = array("days" => $days, "hours" => $hours, "minute" => $minute, "sec" => $sec);
	if ($now_time > $date) {
		$re_time = array("days" => 0, "hours" => 0, "minute" => 0, "sec" => 0);
	}
	return 	$re_time;
}
function get_auction_remaning_time()
{
	ob_clean();
	$_REQUEST['auctionid'];
	$product_id = $_REQUEST['auctionid'];
	$end_time = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
	$date = new DateTime($end_time,  wp_timezone());
	$end_time_tz = $date->format('Y-m-d H:i:s');
	$now_time = new DateTime('now', wp_timezone());
	$diff_time = $now_time->diff($date);
	$diff = $diff_time->format("%a days and %H hours and %i minutes and %s seconds");
	$days = $diff_time->format("%a");
	$hours = $diff_time->format("%H");
	$minute = $diff_time->format("%i");
	$sec = $diff_time->format("%s");
	$re_time = array("days" => $days, "hours" => $hours, "minute" => $minute, "sec" => $sec);
	echo json_encode($re_time);
	wp_die();
}
// creating Ajax call for WordPress
add_action('wp_ajax_nopriv_get_auction_remaning_time', 'get_auction_remaning_time');
add_action('wp_ajax_get_auction_remaning_time', 'get_auction_remaning_time');

function jquery_get_new_time()
{
	ob_clean();

	$posts_id = $_REQUEST['auctionid'];
	$product_data = wc_get_product($posts_id);
	echo $product_data->get_uwa_remaining_seconds();
	wp_die();
}
// creating Ajax call for WordPress
add_action('wp_ajax_nopriv_jquery_get_new_time', 'jquery_get_new_time');
add_action('wp_ajax_jquery_get_new_time', 'jquery_get_new_time');
