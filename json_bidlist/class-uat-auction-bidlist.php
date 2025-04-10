<?php
function bidlist_react_include($hook)
{
	$my_js_ver = '145ds';
	// wp_enqueue_style( 'react_bidlist', 'https://cdn.jsdelivr.net/npm/react-notifications@1.7.2/dist/react-notifications.css', array(),  $my_js_ver );

	// wp_enqueue_script('react_bidlist',  '<script src="https://cdn.jsdelivr.net/npm/@zendeskgarden/react-notifications@8.40.0/dist/index.cjs.min.js"></script>', array(), $my_js_ver);
	wp_enqueue_script('react_bidlist',  trailingslashit(get_template_directory_uri()) . 'includes/json_bidlist/js/bidlist.js', array(), $my_js_ver);


	// $upload = wp_get_upload_dir();
	// $file_name = wc_get_product()->get_id(). '_bids.json';
	// $save_path = $upload['basedir'] . '/auction_json/' . $file_name;
	// $file_path = $upload['baseurl'] . '/auction_json/' . $file_name;
	// $url      = $file_path;
	$c_user_id = get_current_user_id();
	if(current_user_can('administrator') || current_user_can('manage_options') ||
		current_user_can('manage_woocommerce')){
		$user_name = get_userdata($c_user_id)->display_name;
	}
	$product = wc_get_product();
	if( $product )
	{
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {						
			$is_admin = "0";
			$admin_user_id = get_userdata( get_current_user_id() );
			if(!empty( $admin_user_id ) && $admin_user_id){
			  $role = 'administrator';
			  if(in_array($role, $admin_user_id->roles)){
				  $is_admin = '1';
			  }
			}			
			$product_id = $product->get_id();
			$author_id = get_post_field( 'post_author', $product_id );						
			$uwa_reserve_txt_n = __('Reserve price not met', 'ultimate-auction-pro-software');
			$uwa_reserve_txt = __('Reserve price met', 'ultimate-auction-pro-software');	
			$uwa_no_reserve_txt = __('No reserve', 'ultimate-auction-pro-software');
			$now_time = get_ultimate_auction_now_date();
			$uat_custom_data = array(
				'react_currency_symbol' => get_woocommerce_currency_symbol(),
				'react_currency_pos' => get_option( 'woocommerce_currency_pos' ),
				'react_user_name' => $user_name??"",
				'react_current_user_id' => $c_user_id??"",
				'react_user_is_admin' => $is_admin??"",
				'product_owner_id' => $author_id??"",
				'uat_simple_maskusername_enable' => ($product->get_uwa_auction_proxy()!="yes" && $product->get_uwa_auction_silent()!="yes" ) ?get_option('options_uat_simple_maskusername_enable','off'):"" ,
				'uat_proxy_maskusername_enable' => ($product->get_uwa_auction_proxy()=="yes" ) ?get_option('options_uat_proxy_maskusername_enable', 'off'):"" ,
				'uat_silent_maskusername_enable' => ($product->get_uwa_auction_silent()=="yes" ) ?get_option('options_uat_silent_maskusername_enable', 'on'):"",
				'options_uat_proxy_maskbid_enable' => ($product->get_uwa_auction_proxy()=="yes" ) ?get_option('options_uat_proxy_maskbid_enable','off'):"" ,
				'options_uat_silent_maskbid_enable' => ($product->get_uwa_auction_silent()=="yes" ) ?get_option('options_uat_silent_maskbid_enable', 'on'):"",
				'nobid_text' => __('No bids yet.', 'ultimate-auction-pro-software'),
				'is_proxy_auction' => $product->get_uwa_auction_proxy(),
				'reserve_price_not_met' => uat_bid_message_in_popup($uwa_reserve_txt_n),
				'reserve_price_met' => uat_bid_message_in_popup($uwa_reserve_txt),
				'uwa_no_reserve_txt' => uat_bid_message_in_popup($uwa_no_reserve_txt),
				'uwa_now_time' => $now_time,
			);
			wp_localize_script('react_bidlist', 'uat_data_bid', $uat_custom_data);
		}
	}


}
add_action('wp_enqueue_scripts', 'bidlist_react_include');



function bidlist_change_type_of_javascript($tag, $handle, $src)
{

	if ('react_bidlist' == $handle) {
		$tag = str_replace("<script type='text/javascript'", "<script type='text/babel'", $tag);
	}

	return $tag;
}
add_filter('script_loader_tag', 'bidlist_change_type_of_javascript', 10, 3);

