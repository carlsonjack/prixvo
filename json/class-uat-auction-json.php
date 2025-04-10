<?php
// add_action('save_post', 'wat_auction_save_post_callback', 10, 1);

add_action('woocommerce_update_product', 'wat_auction_save_post_callback');
add_action('woocommerce_new_product', 'wat_auction_save_post_callback');

if (!function_exists('getArgs')) {
	function  getArgs(){
		return array();
	}
}
function wat_auction_save_post_callback($post_id)
{
	global $wpdb;
	$product_type= WC_Product_Factory::get_product_type($post_id);
	if ($product_type != 'auction') {
		return false;		
	}
	if (isset($_REQUEST['is_seller_product'])) {
		return false;		
	}

	$upload = wp_upload_dir();
	$upload_dir = $upload['basedir'];
	$upload_dir = $upload_dir . '/auction_json';
	if (!is_dir($upload_dir)) {
		mkdir($upload_dir, 0755);
	}
	$upload_dir = wp_get_upload_dir();
	$file_name = $post_id . '.json';
	$save_path = $upload_dir['basedir'] . '/auction_json/' . $file_name;

	if (file_exists($save_path)) {
		/*echo 'file_exists';*/
		$result_product = $wpdb->get_results('SELECT * FROM ' . $wpdb->posts . ' where ID=' . $post_id . ' ');
		$ID = $result_product[0]->ID;
		$post_title = $result_product[0]->post_title;
		$post_name = $result_product[0]->post_name;
		$woo_ua_auction_start_date_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_start_date" AND post_id=' . $post_id . ' ');

		$woo_ua_auction_start_date = "";
		if (!empty($woo_ua_auction_start_date_re[0]->meta_value)) {
			$woo_ua_auction_start_date = $woo_ua_auction_start_date_re[0]->meta_value;
		}

		$woo_ua_auction_end_date_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $post_id . ' ');


		$woo_ua_auction_end_date = "";
		if (!empty($woo_ua_auction_end_date_re[0]->meta_value)) {
			$woo_ua_auction_end_date = $woo_ua_auction_end_date_re[0]->meta_value;
		}

		$file_path = $upload_dir['baseurl'] . '/auction_json/' . $file_name;
		$url      = $file_path;
		// $response = wp_remote_get($url, getArgs());
	    // $api_response = json_decode(wp_remote_retrieve_body($response), true);
		$api_response = get_auction_json_file($post_id,$file_type="");
		$api_response[0]['ID'] = $ID;
		$api_response[0]['post_title'] = $post_title;
		$api_response[0]['post_name'] = $post_name;
		$api_response[0]['woo_ua_auction_start_date'] = $woo_ua_auction_start_date;
		$api_response[0]['woo_ua_auction_end_date'] = $woo_ua_auction_end_date;
		// $api_response[0]['woo_ua_auction_reserve_price'] = $woo_ua_auction_end_date;
		$woo_ua_lowest_price = get_post_meta($post_id, 'woo_ua_lowest_price', true);
		if (!empty($woo_ua_lowest_price)) {
			$api_response[0]['woo_ua_auction_reserve_price'] = $woo_ua_lowest_price;
		}
		$date_start = $api_response[0]['woo_ua_auction_start_date'];
		$date_end = $api_response[0]['woo_ua_auction_end_date'];
		$date_currrent = current_time('mysql');

		$start_str = "";
		if ($date_start > $date_currrent) {
			$start_str = "future";
		} else if ($date_start <= $date_currrent) {

			if ($date_end < $date_currrent) {
				$start_str = "past";
			} else if ($date_end > $date_currrent && $date_start <= $date_currrent) {

				$start_str = "live";
			}
		}

		$api_response[0]['woo_ua_auction_status'] = $start_str;

		$woo_ua_auction_max_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_bid" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_bid_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_max_bid'] = $woo_ua_auction_max_bid_re[0]->meta_value;
		}
		$woo_ua_auction_max_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_current_bider" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_current_bider_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_max_current_bider'] = $woo_ua_auction_max_current_bider_re[0]->meta_value;
		}
		$woo_ua_auction_current_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bid_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_current_bid'] = $woo_ua_auction_current_bid_re[0]->meta_value;
			$woo_ua_auction_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bider" AND post_id=' . $post_id . ' ');
			if (!empty($woo_ua_auction_current_bider_re[0]->meta_value)) {
				$api_response[0]['woo_ua_auction_current_bider'] = $woo_ua_auction_current_bider_re[0]->meta_value;
			}
			$woo_ua_auction_bid_count_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_bid_count" AND post_id=' . $post_id . ' ');
			if (!empty($woo_ua_auction_bid_count_re[0]->meta_value)) {
				$api_response[0]['woo_ua_auction_bid_count'] = $woo_ua_auction_bid_count_re[0]->meta_value;
			}
		} else {
			if (isset($api_response[0]['woo_ua_auction_current_bider'])) {
				unset($api_response[0]['woo_ua_auction_current_bider']);
			}
			if (isset($api_response[0]['woo_ua_auction_bid_count'])) {
				unset($api_response[0]['woo_ua_auction_bid_count']);
			}
			$woo_ua_opening_price_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_opening_price" AND post_id=' . $post_id . ' ');
			if (!empty($woo_ua_opening_price_re[0]->meta_value)) {
				$api_response[0]['woo_ua_auction_current_bid'] = $woo_ua_opening_price_re[0]->meta_value;
			}
		}
		$woo_ua_auction_current_bid_proxy_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid_proxy" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bid_proxy_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_current_bid_proxy'] = $woo_ua_auction_current_bid_proxy_re[0]->meta_value;
		}
		
		$data = json_encode($api_response);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
		json_update_end_time_auction($post_id);
	} else {

		/*echo 'not file_exists';*/

		global $wpdb;
		/*$post->ID;
		$post->post_type;
		$product = wc_get_product($post->ID);
		$post_id = $post->ID;*/
		$upload_dir = wp_get_upload_dir();
		$file_name = $post_id . '.json';
		$save_path = $upload_dir['basedir'] . '/auction_json/' . $file_name;
		$result_product = $wpdb->get_results('SELECT * FROM ' . $wpdb->posts . ' where ID=' . $post_id . ' ');
		$ID = $result_product[0]->ID;
		$post_status = $result_product[0]->post_status;
		$is_seller_product = get_post_meta($ID, 'uat_seller_id', true);
		$valid_product_status =  getValidStatusForProductVisible();
		$valid_product_status[] =  'uat_approved';
		if (!in_array($post_status, $valid_product_status) && !empty($is_seller_product) ){
			return false;
		}
		$post_title = $result_product[0]->post_title;
		$post_name = $result_product[0]->post_name;
		$woo_ua_auction_start_date_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_start_date" AND post_id=' . $post_id . ' ');

		$woo_ua_auction_start_date = "";
		if (!empty($woo_ua_auction_start_date_re[0]->meta_value)) {

			$woo_ua_auction_start_date = $woo_ua_auction_start_date_re[0]->meta_value;
		}

		$woo_ua_auction_end_date_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $post_id . ' ');


		$woo_ua_auction_end_date = "";
		if (!empty($woo_ua_auction_end_date_re[0]->meta_value)) {
			$woo_ua_auction_end_date = $woo_ua_auction_end_date_re[0]->meta_value;
		}

		$posts['ID'] = $ID;
		$posts['post_title'] = $post_title;
		$posts['post_name'] = $post_name;
		$posts['woo_ua_auction_start_date'] = $woo_ua_auction_start_date;
		$posts['woo_ua_auction_end_date'] = $woo_ua_auction_end_date;
		$woo_ua_lowest_price = get_post_meta($post_id, 'woo_ua_lowest_price', true);
		if (!empty($woo_ua_lowest_price)) {
			$api_response[0]['woo_ua_auction_reserve_price'] = $woo_ua_lowest_price;
		}
		$date_start = $posts['woo_ua_auction_start_date'];
		$date_end = $posts['woo_ua_auction_end_date'];
		$date_currrent = current_time('mysql');

		$start_str = "";
		if ($date_start > $date_currrent) {
			$start_str = "future";
		} else if ($date_start <= $date_currrent) {

			if ($date_end < $date_currrent) {
				$start_str = "past";
			} else if ($date_end > $date_currrent && $date_start <= $date_currrent) {

				$start_str = "live";
			}
		}

		$posts['woo_ua_auction_status'] = $start_str;

		$woo_ua_auction_max_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_bid" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_bid_re[0]->meta_value)) {
			$posts['woo_ua_auction_max_bid'] = $woo_ua_auction_max_bid_re[0]->meta_value;
		}
		$woo_ua_auction_max_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_current_bider" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_current_bider_re[0]->meta_value)) {
			$posts['woo_ua_auction_max_current_bider'] = $woo_ua_auction_max_current_bider_re[0]->meta_value;
		}
		$woo_ua_auction_current_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bid_re[0]->meta_value)) {
			$posts['woo_ua_auction_current_bid'] = $woo_ua_auction_current_bid_re[0]->meta_value;
		} else {
			$woo_ua_opening_price_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_opening_price" AND post_id=' . $post_id . ' ');
			if (!empty($woo_ua_opening_price_re[0]->meta_value)) {
				$posts['woo_ua_auction_current_bid'] = $woo_ua_opening_price_re[0]->meta_value;
			}
		}
		$woo_ua_auction_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bider" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bider_re[0]->meta_value)) {
			$posts['woo_ua_auction_current_bider'] = $woo_ua_auction_current_bider_re[0]->meta_value;
		}
		$woo_ua_auction_bid_count_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_bid_count" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_bid_count_re[0]->meta_value)) {
			$posts['woo_ua_auction_bid_count'] = $woo_ua_auction_bid_count_re[0]->meta_value;
		}
		$woo_ua_auction_current_bid_proxy_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid_proxy" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bid_proxy_re[0]->meta_value)) {
			$posts['woo_ua_auction_current_bid_proxy'] = $woo_ua_auction_current_bid_proxy_re[0]->meta_value;
		}



		$api_response1[] = $posts;
		$data = json_encode($api_response1);
		//$data = json_encode($posts);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
		// json_update_end_time_auction($post_id);

	}
	$file_name_bids = $post_id . '_bids.json';
	$save_path_bids = $upload_dir['basedir'] . '/auction_json/' . $file_name_bids;
	if (file_exists($save_path_bids)) {
		/*	$bids_re = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'woo_ua_auction_log where auction_id=' . $post_id . ' ');
		$data = json_encode($bids_re);
		$f = fopen($save_path_bids, "w");
		fwrite($f, $data);
		fclose($f);*/
	} else {
		$bids_re = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'woo_ua_auction_log where auction_id=' . $post_id . ' ');
		$data = json_encode($bids_re);
		$f = fopen($save_path_bids, "w");
		fwrite($f, $data);
		fclose($f);
	}
}
/**
 * Never worry about cache again!
 */
function jsone_react_include($hook)
{
	$my_js_ver = '';
	wp_enqueue_script('react_development',  trailingslashit(get_template_directory_uri()) . 'includes/json/js/react.development.js', array(), $my_js_ver);
	wp_enqueue_script('react_dom_development', trailingslashit(get_template_directory_uri()) . 'includes/json/js/react-dom.development.js', array(), $my_js_ver);
	wp_enqueue_script('babel_min',   trailingslashit(get_template_directory_uri()) . 'includes/json/js/babel.min.js', array(), $my_js_ver);
	$upload = wp_get_upload_dir();
	$baseurl = $upload['baseurl'];
	wp_enqueue_script('text_babel',  trailingslashit(get_template_directory_uri()) . 'includes/json/js/index.js', array(), $my_js_ver);
	// wp_enqueue_script('text_babel_',  trailingslashit(get_template_directory_uri()) . 'includes/json/js/mainreact.js', array(), $my_js_ver);
	wp_localize_script(
		'text_babel',
		'frontend_react_object',
		array(
			'expired' => __('Auction has Expired!', 'ultimate-auction-pro-software'),
			'ajaxurl' => admin_url('admin-ajax.php'),
			'react_uploadurl' => $baseurl,
			'react_currency_symbol' => get_woocommerce_currency_symbol(),
			'react_curent_user_id' => get_current_user_id(),
		)
	);
}
add_action('wp_enqueue_scripts', 'jsone_react_include');
function wis_wp_theme_script_loader_tag($tag, $handle, $src)
{
	// Check that this is output of JSX file
	if ('text_babel' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}
	if ('text_babel' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}
	if ('text_babel_' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}

	return $tag;
}
add_filter('script_loader_tag', 'wis_wp_theme_script_loader_tag', 10, 3);
function update_auction_json($post_id, $bid_amout, $proxy_, $history_bid_id_ = "")
{
	global $wpdb;
	global $post;
	if (empty($post_id)) {
		return;
	}
	$product = wc_get_product($post_id);
	if ($product->get_type() != "auction") {
		return;
	}
	$upload = wp_get_upload_dir();
	$file_name = $post_id . '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$user_id = "";
	if (file_exists($save_path)) {
		$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
		$url      = $file_path;
		// $response = wp_remote_get($url, getArgs());
		// $api_response = json_decode(wp_remote_retrieve_body($response), true);
		$api_response = get_auction_json_file($post_id,$file_type="");

		$date_start = $api_response[0]['woo_ua_auction_start_date'];
		$date_end = $api_response[0]['woo_ua_auction_end_date'];
		$date_currrent = current_time('mysql');

		$start_str = "";
		if ($date_start > $date_currrent) {
			$start_str = "future";
		} else if ($date_start <= $date_currrent) {

			if ($date_end < $date_currrent) {
				$start_str = "past";
			} else if ($date_end > $date_currrent && $date_start <= $date_currrent) {

				$start_str = "live";
			}
		}



		$api_response[0]['woo_ua_auction_status'] = $start_str;

		$woo_ua_auction_end_date_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_end_date_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_end_date'] = $woo_ua_auction_end_date_re[0]->meta_value;
		}
		$woo_ua_auction_max_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_bid" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_bid_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_max_bid'] = $woo_ua_auction_max_bid_re[0]->meta_value;
		}
		$woo_ua_auction_max_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_max_current_bider" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_max_current_bider_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_max_current_bider'] = $woo_ua_auction_max_current_bider_re[0]->meta_value;
		}
		// if($bid_amout != 0){
		// 	$api_response[0]['woo_ua_auction_current_bid'] = wc_format_decimal($bid_amout,2);
		// }else{
			$woo_ua_auction_current_bid_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid" AND post_id=' . $post_id . ' ');
			if (!empty($woo_ua_auction_current_bid_re[0]->meta_value)) {
				$api_response[0]['woo_ua_auction_current_bid'] = $woo_ua_auction_current_bid_re[0]->meta_value;
			}else{
				$woo_ua_opening_price_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_opening_price" AND post_id=' . $post_id . ' ');
				if (!empty($woo_ua_opening_price_re[0]->meta_value)) {
					$api_response[0]['woo_ua_auction_current_bid'] = $woo_ua_opening_price_re[0]->meta_value;
				}
			}
		// }
		$woo_ua_auction_current_bider_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bider" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bider_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_current_bider'] = $woo_ua_auction_current_bider_re[0]->meta_value;
			$user_id = $woo_ua_auction_current_bider_re[0]->meta_value;
		}
		$woo_ua_auction_bid_count_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_bid_count" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_bid_count_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_bid_count'] = $woo_ua_auction_bid_count_re[0]->meta_value;
		}
		$woo_ua_auction_current_bid_proxy_re = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_current_bid_proxy" AND post_id=' . $post_id . ' ');
		if (!empty($woo_ua_auction_current_bid_proxy_re[0]->meta_value)) {
			$api_response[0]['woo_ua_auction_current_bid_proxy'] = $woo_ua_auction_current_bid_proxy_re[0]->meta_value;
		}
		// reserve price set
		if($product->is_uwa_reserve_enabled()){
				if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
					$uwa_reserve_txt = __('Reserve price not met', 'ultimate-auction-pro-software');
				}
				if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
					$uwa_reserve_txt = __('Reserve price met', 'ultimate-auction-pro-software');
				}
		}else{
			$uwa_reserve_txt = __( 'No reserve', 'ultimate-auction-pro-software' );
		}
		$api_response[0]['uwa_reserve_txt'] = $uwa_reserve_txt;
		if ($history_bid_id_ != "" || $history_bid_id_ != false) {
			$api_response[0]['history_bid_id'] = $history_bid_id_;
		}
		$data = json_encode($api_response);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
	}
}
function save_user_auction_bids($userId, $auctionId, $bid_amount, $proxy_ = 0, $history_bid_id_ = "")
{
	global $wpdb;
	global $post;
	if (empty($auctionId) || empty($bid_amount)) {
		return;
	}
	$before_time = "";
	$woo_ua_auction_end_date_re_ = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $auctionId . ' ');
	if (!empty($woo_ua_auction_end_date_re_[0]->meta_value)) {
		$before_time = strtotime($woo_ua_auction_end_date_re_[0]->meta_value)  -  (get_option('gmt_offset') * 3600);
	}
	/* start of anti snipping */
	$enable = get_option( 'options_uat_anti_snipping_enable', 'on');
	if($enable =="on"){
		$type_of_antisnipping  = get_option('options_uat_aviod_snipping_type', 'snipping_only_once');

		if($type_of_antisnipping == "snipping_recursive"){

			do_action('uat_sniping_extend_auction_time', $auctionId);

		} /* end of if - snipping recursive */
		else if($type_of_antisnipping == "snipping_only_once" || $type_of_antisnipping == "" ){

			/* Anti snipping hook and it must be called only once  -- start */
			$is_antisnipped = get_post_meta($auctionId,'uat_from_anti_snipping', true);
			/* Extend auction end time only if it not extended before */
			if($is_antisnipped != 'yes'){
				do_action('uat_sniping_extend_auction_time', $auctionId);
			}
			/* Anti snipping hook and it must be called only once  -- end */

		}/* end of if - snipping  only once */
	}/* end of anti snipping */
	$upload = wp_get_upload_dir();
	$file_name = $auctionId . '_bids.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	$url      = $file_path;
	// $response = wp_remote_get($url, getArgs());
	// $api_response = json_decode(wp_remote_retrieve_body($response), true);
	$api_response = get_auction_json_file($auctionId,$file_type="_bids");
	// if (!empty($api_response)) {
	// }
	// $user_name_ = uat_user_display_name($userId);
	// $product = wc_get_product($auctionId);
	$no_user_name = get_userdata($userId)->display_name;

	$user_strlen = strlen($no_user_name);
	// Ensure that $user_strlen - 2 is greater than or equal to 0
	$user_repeat_count = max($user_strlen - 2, 0);

	$user_firstchar = strtolower($no_user_name[0]);
	$user_lastchar = strtolower($no_user_name[$user_strlen - 1]);
	$user_middlechars = str_repeat("*", $user_repeat_count);

	$user_name = $user_firstchar . $user_middlechars . $user_lastchar;
	$array_sub = array();
	$array_sub['woo_ua_auction_user_id'] = $userId;
	$array_sub['woo_ua_auction_user_name'] = $no_user_name;
	$array_sub['woo_ua_auction_user_name_proxy_mask'] = $user_name;
	$array_sub['woo_ua_auction_user_name_silent_mask'] = $user_name;
	$array_sub['woo_ua_auction_id'] = $auctionId;
	$array_sub['woo_ua_auction_bid_amount'] = $bid_amount;
	$array_sub['woo_ua_auction_bid_amount_mask'] = str_repeat("*", strlen($bid_amount));
	$array_sub['woo_ua_auction_bid_proxy'] = $proxy_;
	$array_sub['woo_ua_auction_bid_time'] = current_time('mysql');

	// save auction end time for enti sniping feture
	$woo_ua_auction_end_date_re_ = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $auctionId . ' ');
	if (!empty($woo_ua_auction_end_date_re_[0]->meta_value)) {
		$woo_ua_auction_end_date = strtotime($woo_ua_auction_end_date_re_[0]->meta_value)  -  (get_option('gmt_offset') * 3600);

		$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
		$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
		$woo_ua_auction_end_date_formated_with_timezone = date_i18n(get_option('date_format'),  strtotime($woo_ua_auction_end_date_re_[0]->meta_value)) . "," . date_i18n(get_option('time_format'),  strtotime($woo_ua_auction_end_date_re_[0]->meta_value)) . " (" . $timezone_string . ")";

		$woo_ua_auction_end_date_formated_with_timezone = $woo_ua_auction_end_date_formated_with_timezone;
		if( $woo_ua_auction_end_date )
		{
			$array_sub['woo_ua_auction_end_date'] = $woo_ua_auction_end_date;
		}
		if( $woo_ua_auction_end_date_formated_with_timezone )
		{
			$array_sub['woo_ua_auction_end_date_formated_with_timezone'] = $woo_ua_auction_end_date_formated_with_timezone;
		}
		if($woo_ua_auction_end_date != $before_time){
			$array_sub['has_time_sniping'] = true;
		}else{
			$array_sub['has_time_sniping'] = false;
		}
	}
	if ($history_bid_id_ != "" || $history_bid_id_ != false) {
		$array_sub['history_bid_id'] = $history_bid_id_;
	}
	$api_response[] = $array_sub;

	$data = json_encode($api_response);
	$f = fopen($save_path, "w");
	fwrite($f, $data);
	fclose($f);
	
	return;

}

function json_chk_auction($post_id)
{
	global $wpdb,$sitepress;
	 $post_id = $post_id;
	if($post_id <= 0)
	{
		return "";
	}
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$post_id = icl_object_id($post_id,'product',false, $sitepress->get_default_language());
	}

	$product_exists = $wpdb->get_row('SELECT auction_status FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$post_id);
	if($product_exists) {
		$auction_status = $product_exists->auction_status;
		$auction_status = str_replace("uat_","",$auction_status);
		return $auction_status;
	}
	$upload = wp_get_upload_dir();
	$file_name = $post_id . '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;

	$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	$url      = $file_path;
	// $response = wp_remote_get($url, getArgs());
	// $api_response = json_decode(wp_remote_retrieve_body($response), true);
	$api_response = get_auction_json_file($post_id,$file_type="");
	$woo_ua_auction_status="";
	if(!empty($api_response[0]['woo_ua_auction_status'])){
		$woo_ua_auction_status=$api_response[0]['woo_ua_auction_status'];
	}
	return $woo_ua_auction_status;
}

function json_update_status_auction($post_id, $status)
{
	global $wpdb;
	$post_id = $post_id;
	$upload = wp_get_upload_dir();
	$file_name = $post_id . '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;

	$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	$url      = $file_path;
	// $response = wp_remote_get($url, getArgs());
	// $api_response = json_decode(wp_remote_retrieve_body($response), true);
	$api_response = get_auction_json_file($post_id,$file_type="");
	if(!empty($api_response)){
		$auction_array['auction_status'] = "uat_".$status;
		$auction_exists = $wpdb->get_var('SELECT post_id FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$post_id);
		if($auction_exists) {
			$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $auction_array, array('post_id'=>$post_id) );
		}
		$old_status = $api_response[0]['woo_ua_auction_status'];
		if(!empty($old_status)){
			if($old_status != $status && $old_status != 'past'){
				$new_p_status = apply_filters( 'uat_seller_product_json_status_changed', $old_status, $status, $post_id );
				if(!empty($new_p_status)){
					wp_update_post(array(
						'ID' => $post_id,
						'post_status' => $new_p_status,
					));
				}
			}
		}
		$api_response[0]['woo_ua_auction_status'] = $status;
		$data = json_encode($api_response);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
	}
	return true;
}

function json_update_end_time_auction($auctionId)
{
	global $wpdb;
	global $post;
	if (empty($auctionId)) {
		return;
	}
	$upload = wp_get_upload_dir();
	$file_name = $auctionId . '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	$url      = $file_path;
	// $response = wp_remote_get($url, getArgs());
	// $api_response = json_decode(wp_remote_retrieve_body($response), true);
	$api_response = get_auction_json_file($auctionId,$file_type="");
	if (sizeof((array)$api_response) == 0) {
		return;
	}
	$woo_ua_auction_end_date_re_ = $wpdb->get_results('SELECT meta_value FROM ' . $wpdb->postmeta . ' where meta_key="woo_ua_auction_end_date" AND post_id=' . $auctionId . ' ');
	if (!empty($woo_ua_auction_end_date_re_[0]->meta_value)) {
		$woo_ua_auction_end_date = strtotime($woo_ua_auction_end_date_re_[0]->meta_value)  -  (get_option( 'gmt_offset' )*3600);

		$gmt_offset = get_option('gmt_offset') > 0 ? '+' . get_option('gmt_offset') : get_option('gmt_offset');
		$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ', 'ultimate-auction-pro-software') . $gmt_offset;
		$woo_ua_auction_end_date_formated_with_timezone = date_i18n(get_option('date_format'),  strtotime($woo_ua_auction_end_date_re_[0]->meta_value)).",".date_i18n(get_option('time_format'),  strtotime($woo_ua_auction_end_date_re_[0]->meta_value))." (".$timezone_string.")";

		$woo_ua_auction_end_date_formated_with_timezone = $woo_ua_auction_end_date_formated_with_timezone;
		if( $woo_ua_auction_end_date )
		{
			$api_response[sizeof((array)$api_response) - 1]['woo_ua_auction_end_date_'] = $woo_ua_auction_end_date;
		}
		if( $woo_ua_auction_end_date_formated_with_timezone )
		{
			$api_response[sizeof((array)$api_response) - 1]['woo_ua_auction_end_date_formated_with_timezone'] = $woo_ua_auction_end_date_formated_with_timezone;
		}
	}
	$data = json_encode($api_response);
	$f = fopen($save_path, "w");
	fwrite($f, $data);
	fclose($f);
}

// use to update json on bid deleted
function admin_delete_json_update($post_id, $log_id = 0)
{
	global $wpdb;
	global $post;
	if (empty($post_id)) {
		return;
	}
	$product = wc_get_product($post_id);
	if ($product->get_type() != "auction") {
		return;
	}
	$upload = wp_get_upload_dir();
	// update auction json after bid delete by admin
	$file_name = $post_id . '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$user_id = "";
	if (file_exists($save_path)) {
		$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
		$url      = $file_path;
		// $response = wp_remote_get($url, getArgs());
	    // $api_response = json_decode(wp_remote_retrieve_body($response), true);
		$api_response = get_auction_json_file($post_id,$file_type="");

		$woo_ua_auction_bid_count = get_post_meta($post_id, 'woo_ua_auction_bid_count', true);
		if (!empty($woo_ua_auction_bid_count)) {
			$api_response[0]['woo_ua_auction_bid_count'] = $woo_ua_auction_bid_count;
		}

		$woo_ua_auction_current_bid = get_post_meta($post_id, 'woo_ua_auction_current_bid', true);
		if (!empty($woo_ua_auction_current_bid)) {
			$api_response[0]['woo_ua_auction_current_bid'] = wc_format_decimal($woo_ua_auction_current_bid,2);
		}

		$woo_ua_auction_current_bid_proxy = get_post_meta($post_id, 'woo_ua_auction_current_bid_proxy', true);
		if (!empty($woo_ua_auction_current_bid_proxy)) {
			$api_response[0]['woo_ua_auction_current_bid_proxy'] = $woo_ua_auction_current_bid_proxy;
		}

		$woo_ua_auction_current_bider = get_post_meta($post_id, 'woo_ua_auction_current_bider', true);
		if (!empty($woo_ua_auction_current_bider)) {
			$api_response[0]['woo_ua_auction_current_bider'] = $woo_ua_auction_current_bider;
		}

		$woo_ua_auction_max_bid = get_post_meta($post_id, 'woo_ua_auction_max_bid', true);
		if (!empty($woo_ua_auction_max_bid)) {
			$api_response[0]['woo_ua_auction_max_bid'] = $woo_ua_auction_max_bid;
		}

		$woo_ua_auction_max_current_bider = get_post_meta($post_id, 'woo_ua_auction_max_current_bider', true);
		if (!empty($woo_ua_auction_max_current_bider)) {
			$api_response[0]['woo_ua_auction_max_current_bider'] = $woo_ua_auction_max_current_bider;
		}

			$log_table = $wpdb->prefix . "woo_ua_auction_log";
			$newbid = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$log_table} WHERE auction_id = %d
								ORDER BY date DESC, bid DESC LIMIT 1, 1", $post_id));
								if (!is_null($newbid)) {
									$api_response[0]['history_bid_id'] = $newbid->id;
								}else{
									$api_response[0]['woo_ua_auction_current_bid'] = "";
									$api_response[0]['history_bid_id'] = "";

								}

		$data = json_encode($api_response);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
	}
}
// use to update json on bid deleted
function admin_delete_bids_json_update($post_id, $log_id = 0)
{
	global $wpdb;
	global $post;
	if (empty($post_id)) {
		return;
	}
	$product = wc_get_product($post_id);
	if ($product->get_type() != "auction") {
		return;
	}
	if($log_id == 0)
	{
		return false;
	}
	$upload = wp_get_upload_dir();
	// update auction json after bid delete by admin
	$file_name = $post_id . '_bids.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	$user_id = "";
	if (file_exists($save_path)) {
		$file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
		$url      = $file_path;
		// $response = wp_remote_get($url, getArgs());
		// $api_response = json_decode(wp_remote_retrieve_body($response), true);
		$api_response = get_auction_json_file($post_id,$file_type="_bids");
		foreach($api_response as $index => $bid) {
			if($bid['history_bid_id'] == $log_id){
				unset($api_response[$index]);
			}
		}
		$api_response = array_values($api_response);
		$data = json_encode($api_response);
		$f = fopen($save_path, "w");
		fwrite($f, $data);
		fclose($f);
	}
}
function get_auction_json_file($auction_id,$file_type="")
{
	$json_data_response = "";
	if(empty($auction_id))
	{
		return $json_data_response;
	}

	$upload = wp_get_upload_dir();
	$file_name = $auction_id . $file_type. '.json';
	$save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	if (file_exists($save_path)) {
		$file_url = $upload['baseurl'] . '/auction_json/' . $file_name;
		$args = array( 
			'timeout' => 10,
			'method'     => 'POST'
		);
// 		$args = array();
		$response = wp_remote_post($file_url,$args);
		if ( is_wp_error( $response ) ) {
			return $json_data_response;
		}
		$response_body = wp_remote_retrieve_body( $response );
		if ( is_wp_error( $response_body ) ) {
			return $json_data_response;
		}
	    $json_data_response = json_decode($response_body, true);
		
	}
	return $json_data_response;
}
