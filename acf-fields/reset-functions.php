<?php
/*
* Reset Functions
*
* This class initiate general purpose custom fields.
*/
if (!defined('ABSPATH')) {
	die('Access denied.');
}

/**
 * Ajax Reset Menu sections
 */
add_action('wp_ajax_uat_reset_menu_section', 'uat_reset_menu_section_ajax_callback');
function uat_reset_menu_section_ajax_callback()
{
	global $wpdb;
	$updated = update_option('options_uat_menu_sticky', "on");
	$updated = update_option('options_uat_menu_search_box', "on");
	$updated = update_option('options_uat_menu_login_link', "on");
	$updated = update_option('options_uat_secondary_menu', "off");
	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax Reset Login And Registration sections
 */
add_action('wp_ajax_uat_reset_login_registration_section', 'uat_reset_login_registration_section_ajax_callback');
function uat_reset_login_registration_section_ajax_callback()
{
	global $wpdb;
	$updated = update_option('options_uwt_stripe_card_myaccount_page', "disable");
	$updated = update_option('options_uat_need_registration_confirmation', "disable");
	$updated = update_option('options_uat_custom_fields_seller_registration', "no");
	$updated = update_option('options_uat_need_registration_approval', "disable");
	$updated = update_option('options_uat_need_registration_address_enabled', "disable");
	$updated = update_option('options_uat_need_registration_phone_enabled', "disable");
	$updated = update_option('options_registration_social_enabled', "disable");
	$updated = update_option('options_menu_link_types', "menu_open_in_popup");
	$updated = update_option('options_uat_register_login_popup_tag_line', "");
	$updated = update_option('options_uat_register_login_popup_uat_term_condition', "off");
	$updated = update_option('options_uat_register_login_popup_uat_term_condition_txt', "");
	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset Footer sections
 */
add_action('wp_ajax_uat_reset_footer_section', 'uat_reset_footer_section_ajax_callback');
function uat_reset_footer_section_ajax_callback()
{
	global $wpdb;
	$copy_right_txt = 'Copyright | <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> by <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> | All Rights Reserved | Powered by <a href="https://wordpress.org">WordPress</a>';

	$updated = update_option('options_uat_copyright_text', $copy_right_txt);

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');


	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset CRON sections
 */
add_action('wp_ajax_uat_reset_cron_section', 'uat_reset_cron_section_ajax_callback');
function uat_reset_cron_section_ajax_callback()
{
	global $wpdb;
	$updated = update_option('options_cron_options', "page");
	$updated = update_option('options_cron_winner_email', "on");
	$updated = update_option('options_cron_loser_email', "off");
	$updated = update_option('options_ending_soon_cron', "off");
	$updated = update_option('options_ending_soon_cron_time_left', "60");
	$updated = update_option('options_ending_soon_for_bidders', "on");
	$updated = update_option('options_ending_soon_for_savelist', "on");
	$updated = update_option('options_ending_soon_cron_sms', "off");
	$updated = update_option('options_ending_soon_cron_time_left_sms', "60");
	$updated = update_option('options_ending_soon_cron_whatsapp', "off");
	$updated = update_option('options_ending_soon_cron_time_left_whatsapp', "60");
	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset Payment sections
 */
add_action('wp_ajax_uat_reset_payment_section', 'uat_reset_payment_section_ajax_callback');
function uat_reset_payment_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_stripe_mode_types', "uat_stripe_test_mode");
	$updated = update_option('options_stripe_test_publishable_key', "");
	$updated = update_option('options_uat_stripe_test_secret_key', "");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');


	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset logo sections
 */
add_action('wp_ajax_uat_reset_logo_section', 'uat_reset_logo_section_ajax_callback');
function uat_reset_logo_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_website_logo', "");
	$updated = update_option('options_uat_website_favicon', "");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');


	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset Soft-Close/Bid Sniping sections
 */
add_action('wp_ajax_uat_reset_uat_anti_snipping_section', 'uat_reset_uat_anti_snipping_section_ajax_callback');
function uat_reset_uat_anti_snipping_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_anti_snipping_enable', "off");
	$updated = update_option('options_uat_aviod_snipping_type', "snipping_only_once");
	$updated = update_option('options_uat_auto_extend_when', "0");
	$updated = update_option('options_uat_auto_extend_when_m', "5");
	$updated = update_option('options_uat_auto_extend_time', "0");
	$updated = update_option('options_uat_auto_extend_time_m', "5");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');


	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset Bid Increment sections
 */
add_action('wp_ajax_uat_reset_uat_bid_increment_section', 'uat_reset_uat_bid_increment_section_ajax_callback');
function uat_reset_uat_bid_increment_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_global_bid_increment_event', "1");
	$updated = update_option('options_uat_global_var_incremental_price_event', "");
	$updated = update_option('options_uat_global_bid_increment', "1");
	$updated = update_option('options_uat_global_var_incremental_price', "");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');


	echo json_encode($response);
	exit;
}
/**
 * Ajax Reset Logs Activity sections
 */
add_action('wp_ajax_uat_reset_log_activity_section', 'uat_reset_log_activity_section_ajax_callback');
function uat_reset_log_activity_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_bids_logs', "enable");
	$updated = update_option('options_uat_payment_hold_logs', "disable");
	$updated = update_option('options_ua_payment_hold_debit_logs', "enable");
	$updated = update_option('options_ua_payment_direct_debit_logs', "disable");
	$updated = update_option('options_uat_api_requests_logs', "disable");
	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
/**
 * Ajax Auction General
 */
add_action('wp_ajax_uat_page_auction_general_setting_section', 'uat_page_auction_general_setting_section_ajax_callback');
function uat_page_auction_general_setting_section_ajax_callback()
{
	global $wpdb;

	//general setting
	$updated = update_option('options_uat_can_max_bid_amt', "999999999999.99");
	$updated = update_option('options_uat_bid_place_warning', "on");
	$updated = update_option('options_uat_fee_to_place_bid', "off");
	$updated = update_option('options_field_options_to_place_bid_fee_type', "fee-for-any-products");
	$updated = update_option('options_field_options_to_place_bid_fee_amount', "1");
	$updated = update_option('options_field_options_to_place_bid_fee_popup_btn_text', __('Pay Now', 'ultimate-auction-pro-software'));
	$updated = update_option('options_uat_address_mandatory_bid_place', 'false');
	$updated = update_option('options_uat_billing_address_mandatory_bid_place', 'true');
	$updated = update_option('options_field_options_to_place_bid_fee_popup_text', __("You need to pay fee once before placing your first bid on the website. After successful payment, you can place any number of bids on any product on the website.", 'ultimate-auction-pro-software'));
	$updated = update_option('options_uat_google_maps_api_key', "");
	$updated = update_option('options_uat_allow_admin_to_bid', "off");
	$updated = update_option('options_uat_allow_owner_to_bid', "off");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax Auction General
 */
add_action('wp_ajax_uat_page_auction_detail_setting_section', 'uat_page_auction_detail_setting_section_ajax_callback');
function uat_page_auction_detail_setting_section_ajax_callback()
{
	global $wpdb;

	//Auction detail page
	$updated = update_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
	$updated = update_option('options_uat_auction_timer', "on");
	$updated = update_option('options_uat_auction_ending_date', "on");
	$updated = update_option('options_uat_auction_start_date', "on");
	$updated = update_option('options_uat_auction_timezone', "on");
	$updated = update_option('options_uat_auction_bid_tab', "on");
	$updated = update_option('options_single_terms_conditions_tab', "off");
	$updated = update_option('options_uat_auction_meta_data', "on");
	$updated = update_option('options_uat_auction_related_products', "on");
	$updated = update_option('options_related_products_timer', "of");
	$updated = update_option('options_uat_auction_comments', "on");

	// Page: Auction Event Detail
	$updated = update_option('options_uat_event_details_page_layout', "full-width");
	$updated = update_option('options_event_detail_page_timer', "on");
	$updated = update_option('options_uat_event_details_searchbar', "on");
	$updated = update_option('options_uat_events_terms_conditions_tab', "off");
	$updated = update_option('options_uat_event_details_default_view', "grid-view");
	$updated = update_option('options_uat_event_details_viewbar', "on");
	$updated = update_option('options_uat_event_details_pagination_type', "load-more");
	$updated = update_option('options_uat_auction_products_no', 12);

	// Page: Auction Event category
	$updated = update_option('options_uat_event_list_page_layout', "full-width");
	$updated = update_option('options_uat_event_list_resultbar', "on");
	$updated = update_option('options_uat_event_list_default_view', "grid-view");
	$updated = update_option('options_uat_event_list_viewbar', "on");
	$updated = update_option('options_uat_event_list_pagination_type', 'infinite-scroll');
	$updated = update_option('options_uat_event_list_timer', "false");

	// Page: WooCommerce
	$updated = update_option('options_uat_shop_page_layout', "full-width");
	$updated = update_option('options_uat_woo_category_page_layout', "full-width");
	$updated = update_option('options_uat_woo_tags_page_layout', "full-width");

	$updated = update_option('options_uat_event_list_sortbydate', "on");
	$updated = update_option('options_uat_event_list_reset_filter', "off");
	$updated = update_option('options_uat_event_list_daterange', "on");
	$updated = update_option('options_uat_event_list_searchbar', "on");
	$updated = update_option('options_uat_event_list_location', "off");
	$updated = update_option('options_uat_event_list_location_county', "off");
	$updated = update_option('options_uat_event_list_location_state', "off");
	$updated = update_option('options_uat_event_list_location_city', "off");

	// Page: Seller page options
	$uat_seller_dashboard_page_id = get_option("options_uat_seller_dashboard_page_id");
	$updated = update_option('options_uat_seller_dashboard_page_id', $uat_seller_dashboard_page_id);
	$uat_buyer_dashboard_page_id = get_option("options_uat_buyer_dashboard_page_id");
	$updated = update_option('options_uat_buyer_dashboard_page_id', $uat_buyer_dashboard_page_id);
	$uat_categories_page_id = get_option("options_uat_categories_page_id");
	$updated = update_option('options_uat_categories_page_id', $uat_categories_page_id);

	$updated = update_option('options_uat_event_details_resultbar', 'on');
	$updated = update_option('options_uat_event_details_reset_filter', 'off');
	$updated = update_option('options_uat_event_details_pricerange_bids', 'on');

	// Page: WooCommerce Default Product Detail Page
	$updated = update_option('options_wc_default_page_comments', 'on');

	// Page: Blog Detail Page
	$updated = update_option('options_blog_default_page_comments', 'on');

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_simple_auction_setting_section', 'uat_page_simple_auction_setting_section_ajax_callback');
function uat_page_simple_auction_setting_section_ajax_callback()
{
	global $wpdb;

	//simple auction
	$updated = update_option('options_uat_simple_maskusername_enable', "off");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_proxy_auction_setting_section', 'uat_page_proxy_auction_setting_section_ajax_callback');
function uat_page_proxy_auction_setting_section_ajax_callback()
{
	global $wpdb;

	//Proxy auction
	$updated = update_option('options_uat_proxy_maskusername_enable', "off");
	$updated = update_option('options_uat_proxy_maskbid_enable', "off");
	$updated = update_option('options_uat_proxy_disable_reserve_price', "off");
	$updated = update_option('options_uat_proxy_autobid_accept_bid', "autobid-with-bid");


	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_silent_auction_setting_section', 'uat_page_silent_auction_setting_section_ajax_callback');
function uat_page_silent_auction_setting_section_ajax_callback()
{
	global $wpdb;

	//Silent auction
	$updated = update_option('options_uat_silent_maskusername_enable', "on");
	$updated = update_option('options_uat_silent_maskbid_enable', "on");
	$updated = update_option('options_uat_restrict_bidder_enable', "on");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_event_general_section', 'uat_page_event_general_section_ajax_callback');
function uat_page_event_general_section_ajax_callback()
{
	global $wpdb;



	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_event_list_section', 'uat_page_event_list_section_ajax_callback');
function uat_page_event_list_section_ajax_callback()
{
	global $wpdb;


	$updated = update_option('options_uat_event_list_page_no', 20);
	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_page_event_detail_section', 'uat_page_event_detail_section_ajax_callback');
function uat_page_event_detail_section_ajax_callback()
{
	global $wpdb;


	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_uat_woocommerce_section', 'uat_woocommerce_section_ajax_callback');
function uat_woocommerce_section_ajax_callback()
{
	global $wpdb;

	$updated = update_option('options_uat_woo_category_page_layout', "full-width");
	$updated = update_option('options_uat_woo_tags_page_layout', "full-width");
	$updated = update_option('options_uat_shop_page_layout', "full-width");
	$updated = update_option('options_uat_mix_auctions_product_on_category_page', "on");
	$updated = update_option('options_uat_display_future_auction_on_cat', "off");
	$updated = update_option('options_uat_mix_auctions_product_on_tag_page', "on");
	$updated = update_option('options_uat_display_expired_auction_on_tag', "off");
	$updated = update_option('options_uat_display_future_auction_on_tag', "off");
	$updated = update_option('options_uat_mix_auctions_product_on_search_page', "on");
	$updated = update_option('options_uat_display_expired_auction_on_search', "off");
	$updated = update_option('options_uat_display_future_auction_on_search', "off");

	$response['status'] = 1;
	$response['success_message'] = __('Section reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}

/**
 * Ajax simple Auction
 */
add_action('wp_ajax_reset_uat_all_theme_options', 'reset_uat_all_theme_options_ajax_callback');
function reset_uat_all_theme_options_ajax_callback()
{
	global $wpdb;

	// Reset logo sections
	$updated = update_option('options_uat_website_logo', "");
	$updated = update_option('options_uat_website_favicon', "");

	//Layout
	$updated = update_option('options_uat_site_layout', "wide");
	$updated = update_option('options_uat_site_width', "1200px");

	//Menu
	$updated = update_option('options_uat_menu_sticky', "on");
	$updated = update_option('options_uat_menu_search_box', "on");
	$updated = update_option('options_uat_menu_login_link', "on");
	$updated = update_option('options_uat_secondary_menu', "off");

	//Login And Registration
	$updated = update_option('options_uwt_stripe_card_myaccount_page', "disable");
	$updated = update_option('options_uwt_stripe_card_in_popup', "disable");
	$updated = update_option('options_uat_need_registration_confirmation', "disable");
	$updated = update_option('options_uat_custom_fields_seller_registration', "no");
	$updated = update_option('options_uat_need_registration_approval', "disable");
	$updated = update_option('options_uat_need_registration_address_enabled', "disable");
	$updated = update_option('options_uat_need_registration_phone_enabled', "disable");
	$updated = update_option('options_registration_social_enabled', "disable");
	$updated = update_option('options_menu_link_types', "menu_open_in_popup");
	$updated = update_option('options_uat_register_login_popup_tag_line', "");
	$updated = update_option('options_uat_register_login_popup_uat_term_condition', "off");
	$updated = update_option('options_uat_register_login_popup_uat_term_condition_txt', "");


	//Footer
	$copy_right_txt = 'Copyright | <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> by <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> | All Rights Reserved | Powered by <a href="https://wordpress.org">WordPress</a>';

	$updated = update_option('options_uat_copyright_text', $copy_right_txt);

	//CRON
	$updated = update_option('options_cron_options', "page");
	$updated = update_option('options_cron_winner_email', "on");
	$updated = update_option('options_cron_loser_email', "off");
	$updated = update_option('options_ending_soon_cron', "off");
	$updated = update_option('options_ending_soon_cron_time_left', "60");
	$updated = update_option('options_ending_soon_for_bidders', "on");
	$updated = update_option('options_ending_soon_for_savelist', "on");
	$updated = update_option('options_ending_soon_cron_sms', "off");
	$updated = update_option('options_ending_soon_cron_time_left_sms', "60");
	$updated = update_option('options_ending_soon_cron_whatsapp', "off");
	$updated = update_option('options_ending_soon_cron_time_left_whatsapp', "60");

	//Payment
	$updated = update_option('options_uat_stripe_mode_types', "uat_stripe_test_mode");
	$updated = update_option('options_stripe_test_publishable_key', "");
	$updated = update_option('options_uat_stripe_test_secret_key', "");

	// Soft-Close/Bid Sniping
	$updated = update_option('options_uat_anti_snipping_enable', "off");
	$updated = update_option('options_uat_aviod_snipping_type', "snipping_only_once");
	$updated = update_option('options_uat_auto_extend_when', "0");
	$updated = update_option('options_uat_auto_extend_when_m', "5");
	$updated = update_option('options_uat_auto_extend_time', "0");
	$updated = update_option('options_uat_auto_extend_time_m', "5");
	// Bid Increment
	$updated = update_option('options_uat_global_bid_increment_event', "1");
	$updated = update_option('options_uat_global_var_incremental_price_event', "");
	$updated = update_option('options_uat_global_bid_increment', "1");
	$updated = update_option('options_uat_global_var_incremental_price', "");
	//Logs Activity
	$updated = update_option('options_uat_bids_logs', "enable");
	$updated = update_option('options_uat_payment_hold_logs', "disable");
	$updated = update_option('options_ua_payment_hold_debit_logs', "enable");
	$updated = update_option('options_ua_payment_direct_debit_logs', "disable");
	$updated = update_option('options_uat_api_requests_logs', "disable");

	//auction general setting
	$updated = update_option('options_uat_can_max_bid_amt', "999999999999.99");
	$updated = update_option('options_uat_bid_place_warning', "on");
	$updated = update_option('options_uat_fee_to_place_bid', "off");
	$updated = update_option('options_field_options_to_place_bid_fee_type', "fee-for-any-products");
	$updated = update_option('options_field_options_to_place_bid_fee_amount', "1");
	$updated = update_option('options_field_options_to_place_bid_fee_popup_btn_text', __('Pay Now', 'ultimate-auction-pro-software'));
	$updated = update_option('options_uat_address_mandatory_bid_place', 'false');
	$updated = update_option('options_uat_billing_address_mandatory_bid_place', 'true');
	$updated = update_option('options_field_options_to_place_bid_fee_popup_text', __("You need to pay fee once before placing your first bid on the website. After successful payment, you can place any number of bids on any product on the website.", 'ultimate-auction-pro-software'));
	$updated = update_option('options_uat_google_maps_api_key', "");
	$updated = update_option('options_uat_allow_admin_to_bid', "off");
	$updated = update_option('options_uat_allow_owner_to_bid', "off");


	//Auction detail page
	$updated = update_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
	$updated = update_option('options_uat_auction_timer', "on");
	$updated = update_option('options_uat_auction_ending_date', "on");
	$updated = update_option('options_uat_auction_start_date', "on");
	$updated = update_option('options_uat_auction_timezone', "on");
	$updated = update_option('options_uat_auction_bid_tab', "on");
	$updated = update_option('options_single_terms_conditions_tab', "off");
	$updated = update_option('options_uat_auction_meta_data', "on");
	$updated = update_option('options_uat_auction_related_products', "on");
	$updated = update_option('options_related_products_timer', "off");
	$updated = update_option('options_uat_auction_comments', "on");
	// Page: Auction Event Detail
	$updated = update_option('options_uat_event_details_page_layout', "full-width");
	$updated = update_option('options_event_detail_page_timer', "on");
	$updated = update_option('options_uat_event_details_searchbar', "on");
	$updated = update_option('options_uat_events_terms_conditions_tab', "off");
	$updated = update_option('options_uat_event_details_default_view', "grid-view");
	$updated = update_option('options_uat_event_details_viewbar', "on");
	$updated = update_option('options_uat_event_details_pagination_type', "load-more");

	$updated = update_option('options_uat_event_details_resultbar', 'on');
	$updated = update_option('options_uat_event_details_reset_filter', 'off');
	$updated = update_option('options_uat_event_details_pricerange_bids', 'on');

	// Page: WooCommerce Default Product Detail Page
	$updated = update_option('options_wc_default_page_comments', 'on');

	// Page: Blog Detail Page
	$updated = update_option('options_blog_default_page_comments', 'on');

	//simple auction
	$updated = update_option('options_uat_simple_maskusername_enable', "off");

	//Proxy auction
	$updated = update_option('options_uat_proxy_maskusername_enable', "off");
	$updated = update_option('options_uat_proxy_maskbid_enable', "off");
	$updated = update_option('options_uat_proxy_disable_reserve_price', "off");
	$updated = update_option('options_uat_proxy_autobid_accept_bid', "autobid-with-bid");

	//Silent auction
	$updated = update_option('options_uat_silent_maskusername_enable', "on");
	$updated = update_option('options_uat_silent_maskbid_enable', "on");
	$updated = update_option('options_uat_restrict_bidder_enable', "on");

	//event general Auction

	//event list Auction
	$updated = update_option('options_uat_event_list_page_no', 20);

	//event detail Auction
	$updated = update_option('options_uat_auction_products_no', 12);

	// Page: Auction Event category
	$updated = update_option('options_uat_event_list_page_layout', "full-width");
	$updated = update_option('options_uat_event_list_resultbar', "on");
	$updated = update_option('options_uat_event_list_default_view', "grid-view");
	$updated = update_option('options_uat_event_list_viewbar', "on");
	$updated = update_option('options_uat_event_list_pagination_type', 'infinite-scroll');
	$updated = update_option('options_uat_event_list_timer', "false");

	// Page: WooCommerce
	$updated = update_option('options_uat_shop_page_layout', "full-width");
	$updated = update_option('options_uat_woo_category_page_layout', "full-width");
	$updated = update_option('options_uat_woo_tags_page_layout', "full-width");
	$updated = update_option('options_uat_mix_auctions_product_on_category_page', "on");
	$updated = update_option('options_uat_display_future_auction_on_cat', "off");
	$updated = update_option('options_uat_mix_auctions_product_on_tag_page', "on");
	$updated = update_option('options_uat_display_expired_auction_on_tag', "off");
	$updated = update_option('options_uat_display_future_auction_on_tag', "off");
	$updated = update_option('options_uat_mix_auctions_product_on_search_page', "on");
	$updated = update_option('options_uat_display_expired_auction_on_search', "off");
	$updated = update_option('options_uat_display_future_auction_on_search', "off");

	$updated = update_option('options_uat_event_list_sortbydate', "on");
	$updated = update_option('options_uat_event_list_reset_filter', "off");
	$updated = update_option('options_uat_event_list_daterange', "on");
	$updated = update_option('options_uat_event_list_searchbar', "on");
	$updated = update_option('options_uat_event_list_location', "off");
	$updated = update_option('options_uat_event_list_location_county', "off");
	$updated = update_option('options_uat_event_list_location_state', "off");
	$updated = update_option('options_uat_event_list_location_city', "off");

	// Page: Seller page options
	$uat_seller_dashboard_page_id = get_option("options_uat_seller_dashboard_page_id");
	$updated = update_option('options_uat_seller_dashboard_page_id', $uat_seller_dashboard_page_id);
	$uat_buyer_dashboard_page_id = get_option("options_uat_buyer_dashboard_page_id");
	$updated = update_option('options_uat_buyer_dashboard_page_id', $uat_buyer_dashboard_page_id);
	$uat_categories_page_id = get_option("options_uat_categories_page_id");
	$updated = update_option('options_uat_categories_page_id', $uat_categories_page_id);

	// Seller settings
	$updated = update_option('options_uat_admin_commission_percentage', '0');






	$response['status'] = 1;
	$response['success_message'] = __('All Theme settings reset successful.', 'ultimate-auction-pro-software');
	echo json_encode($response);
	exit;
}
