<?php
function notify_bid_placed_react_include($hook)
{
	$my_js_ver = '';

	wp_enqueue_script('react_bid_notify',  trailingslashit(get_template_directory_uri()) . 'includes/notification_bid/js/bidnotify.js', array(), $my_js_ver);


	// $upload = wp_get_upload_dir();
	// $file_name = wc_get_product()->get_id(). '_bids.json';
	// $save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	// $file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	// $url      = $file_path;
	$product = wc_get_product();
	if( $product )
	{ 

 
		
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
			$uat_custom_data = array(
				'auction_type' => $product->get_uwa_auction_silent()??"",
				'anti_sniping_timer_update_noti' => get_option('options_anti_sniping_timer_update_notification'),
				'anti_sniping_timer_update_noti_msg' => get_option('options_anti_sniping_clock_msg'),
				'refresh_btn_lable' => __('Refresh', 'ultimate-auction-pro-software'),
				'bid_placed_msg_re' => __('Bid Placed:', 'ultimate-auction-pro-software'),
			);
			wp_localize_script('react_bid_notify', 'uat_data_bid_notify', $uat_custom_data);
			
			 
		}
	}
	

}
add_action('wp_enqueue_scripts', 'notify_bid_placed_react_include');
 


function notify_bid_placed_javascript($tag, $handle, $src)
{

	if ('react_bid_notify' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}

	return $tag;
}
add_filter('script_loader_tag', 'notify_bid_placed_javascript', 10, 3);

