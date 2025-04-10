<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ultimate_Auction
 */


 /* Specify the path For favicon */

 function uat_header_favicon() { 
	$favicon_ID = get_option('options_uat_website_favicon');
	$website_favicons = wp_get_attachment_image_src($favicon_ID, 'full');
	$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/favicon.png';
	$favicon = isset($website_favicons[0]) ? $website_favicons[0] : $thumb_image_d;
	if (!empty($favicon)) { ?>
		<link rel="shortcut icon" href="<?php echo esc_url($favicon); ?>" type="image/x-icon" />
	<?php } else { ?>
		<link rel="shortcut icon" href="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>front/favicon.png" type="image/x-icon" />
	<?php } 
    /* Theme custom style */
    ?>
    <style>
        .site-header { background-color: <?php echo get_theme_mod('header_color_setting', '#ffffff'); ?>; }
        .uat-theme-footer{ background-color: <?php echo get_theme_mod('footer-bg-color', '#ffffff'); ?>; }
        body.uat-custom-background { background-color: <?php echo get_theme_mod('custom-background', '#ffffff'); ?>; }
        body{
             --wp--header--text-color:<?php echo get_theme_mod('header_color_text_setting', '#000000'); ?>;
             --wp--header--text-color-on-hover:<?php echo get_theme_mod('header_hover_color_text_setting', '#8f8f8f'); ?>;
             --wp--body--text-color:<?php echo get_theme_mod('custom-text-color', '#000000'); ?>; 
             --wp--custom-primary-link-color:<?php echo get_theme_mod('custom-primary-text-color', '#130e86'); ?>;
             --wp--custom-primary-link-hover-color:<?php echo get_theme_mod('custom-primary-text-hover-color', '#080067'); ?>;
             --wp--custom-footer-text-color:<?php echo get_theme_mod('footer-text-color', '#919397'); ?>;
             --wp--custom-footer-bg-color:<?php echo get_theme_mod('footer-bg-color', '#fff'); ?>;
             --wp--header-bg-color:<?php echo get_theme_mod('header_color_setting', '#ffffff'); ?>;        
            }
        
    </style>
    <?php
}
add_action('wp_head', 'uat_header_favicon');





add_action('uat_header_logo', 'display_uat_header_logo');

function display_uat_header_logo() { ?>
    <div class="site-logo">
       
        <a href="<?php echo esc_url(home_url('/home/')); ?>">
            <?php
            $image_ID = get_option('options_uat_website_logo');
            $site_title = get_bloginfo( 'name' );
            $website_logos = wp_get_attachment_image_src($image_ID, 'full');
            $thumb_image_d = UAT_THEME_PRO_IMAGE_URI. '/ultimate-aution-pro-software-logo.svg';
            $website_logo = isset($website_logos[0]) ? $website_logos[0] : $thumb_image_d;
            if (!empty($website_logo)) { ?>
                <img src="<?php echo esc_url($website_logo); ?>" alt="<?php echo $site_title; ?>" title="<?php echo $site_title; ?>" />
            <?php } else { ?>
                <img style="padding: 20px 0 20px 0;" src="<?php echo $thumb_image_d; ?>" alt="<?php echo $site_title; ?>" title="<?php echo $site_title; ?>">
            <?php } ?>
        </a>
    </div>
<?php }

add_action('uat_search_box', 'display_uat_search_box');
function display_uat_search_box() { 
    $menu_search_box = get_option('options_uat_menu_search_box', "on");
    if ($menu_search_box == 'on') { 
    ?>
    <div class="Search-bar-block">
        <form class="Search-box-form" method="get" action="<?php echo esc_url(home_url('/')); ?>">
            <input type="text" value="<?php echo get_search_query(); ?>" name="s" placeholder="<?php _e('Search here', 'ultimate-auction-pro-software'); ?>" />
            <input type="hidden" name="post_type" value="product" />
             <input type="hidden" name="uat_auctions_search" value="true" />
            <button type="submit" cursor="pointer" class="">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path d="M15.7955 15.8111L21 21M18 10.5C18 14.6421 14.6421 18 10.5 18C6.35786 18 3 14.6421 3 10.5C3 6.35786 6.35786 3 10.5 3C14.6421 3 18 6.35786 18 10.5Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            </button>
        </form>
    </div>
<?php }

}

/* Sign in Link with login drowpdown */ 

add_action('uat_header_sign_in', 'display_uat_header_sign_in');
function display_uat_header_sign_in(){ 
    $uat_menu_login_link = get_option('options_uat_menu_login_link', "on");
    if ($uat_menu_login_link == 'on') {  
        if (!is_user_logged_in()) { 
            if(class_exists('WooCommerce') && !is_account_page()){

            
            $menu_link_types = get_option('options_menu_link_types', 'menu_open_in_popup');
            if ($menu_link_types == 'menu_open_in_direct_link') { ?>
                <div class="my-acc-btn"> 
                    <a class="sign-btn" href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#1C274C" style="
    fill: var(--wp--custom-primary-link-color);
"></path> </g></svg> <?php _e('Sign in', 'ultimate-auction-pro-software'); ?> </a></div>
            <?php }else{ ?>
                <div class="my-acc-btn"> 
                    <a class="sign-btn" data-fancybox data-src="#uat-login-form"  href="javascript:;" style="font-weight: bold;"><svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#1C274C" style="
    fill: var(--wp--custom-primary-link-color);
"></path> </g></svg> <?php _e('Sign in', 'ultimate-auction-pro-software'); ?></a>  
                    
                </div>
            <?php } } ?>
        <?php }else{ 
            $current_user = wp_get_current_user();
            $INVOICES_page_url = "";
            $edit_account_page_url = "";
            $wc_logout_url = "";
            if (class_exists('WooCommerce')) {
                $INVOICES_page_url = wc_get_endpoint_url('orders', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
                $edit_account_page_url = wc_get_endpoint_url('edit-account', '', get_permalink(get_option('woocommerce_myaccount_page_id')));
                $wc_logout_url = wc_logout_url();
                $dashboard_page_id = get_option('options_uat_seller_dashboard_page_id');
                if (!empty($dashboard_page_id)) {
                    $dashboard_page_url = get_permalink($dashboard_page_id);
                    $seller_dashboard_page_url = $dashboard_page_url;
                }
            }   ?>
            <div class="selct-dropdown h-myaccount my-acc-btn">

            <div class="wrap-drop h-myaccountwrap">
                <span>
                <svg width="25px" height="25px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15 9C15 10.6569 13.6569 12 12 12C10.3431 12 9 10.6569 9 9C9 7.34315 10.3431 6 12 6C13.6569 6 15 7.34315 15 9ZM12 20.5C13.784 20.5 15.4397 19.9504 16.8069 19.0112C17.4108 18.5964 17.6688 17.8062 17.3178 17.1632C16.59 15.8303 15.0902 15 11.9999 15C8.90969 15 7.40997 15.8302 6.68214 17.1632C6.33105 17.8062 6.5891 18.5963 7.19296 19.0111C8.56018 19.9503 10.2159 20.5 12 20.5Z" fill="#1C274C" style="fill: var(--wp--custom-primary-link-color);"></path> </g></svg>
                    <div class="username"><?php echo substr($current_user->display_name, 0, 12); ?></div> 
                <svg class="username-aerrow" width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g> <path d="M7 10L12 15L17 10" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> </g>
                </svg>
                </span>
                <ul class="drop">
                
                            
                            
                    <?php
                    if (class_exists('WooCommerce')) {
                        $buyer_dashboard_page_id = get_option('options_uat_buyer_dashboard_page_id');
                        $buyer_dashboard_page_url = get_buyer_page_url($slug = "");
                        $buyer_search_page_url = get_buyer_page_url($slug = "search");
                        $buyer_favourites_page_url = get_buyer_page_url($slug = "favourites");
                        $buyer_invalid_page_url = get_buyer_page_url($slug = "invalid");
                        $buyer_bids_page_url = get_buyer_page_url($slug = "bids");
                        $buyer_order_page_url = get_buyer_page_url($slug = "order");
                        
                        ?>

                                <li class="menu-heading-text"><span><?php _e('Explore', 'ultimate-auction-pro-software'); ?></span></li>
								<li><a href="<?php echo $edit_account_page_url; ?>"><?php _e('Profile', 'ultimate-auction-pro-software'); ?></a></li>
                                <li><a href="<?php echo $buyer_favourites_page_url; ?>"><?php _e('Watch List', 'ultimate-auction-pro-software'); ?></a></li>
                                <?php /*<li><a href="<?php echo $buyer_bids_page_url; ?>"><?php _e('My bids', 'ultimate-auction-pro-software'); ?></a></li>
                                <li><a href="<?php echo $buyer_order_page_url; ?>"><?php _e('Orders', 'ultimate-auction-pro-software'); ?></a></li>
                                <!-- <li><a href="<?php echo $buyer_favourites_page_url; ?>"><?php _e('Auctions | follow', 'ultimate-auction-pro-software'); ?></a></li> -->
                                <li><a href="<?php echo $buyer_search_page_url; ?>"><?php _e('Saved searches', 'ultimate-auction-pro-software'); ?></a></li>
                                <!-- <li><a href="<?php echo $buyer_favourites_page_url; ?>"><?php _e('Collections | follow', 'ultimate-auction-pro-software'); ?></a></li> -->
								*/?>
                        <?php
                        if (in_array(UAT_SELLER_ROLE_KEY, (array) $current_user->roles) || in_array('administrator', (array) $current_user->roles)) {
                        $dashboard_page_id = get_option('options_uat_seller_dashboard_page_id');
                        $seller_dashboard_page_url = "#";
                        $seller_in_auction_page_url = "#";
                        $seller_submission_page_url = "#";
                        $seller_sold_page_url = "#";
                        if (!empty($dashboard_page_id)) {
                            $dashboard_page_url = get_permalink($dashboard_page_id);
                            $seller_dashboard_page_url = $dashboard_page_url;
                            $seller_in_auction_page_url = $dashboard_page_url . 'in-auction';
                            $seller_submission_page_url = $dashboard_page_url . 'submission';
                            $seller_sold_page_url = $dashboard_page_url . 'sold';
                            $seller_payments_page_url = $dashboard_page_url . 'payments';
                        }
                    }
                    ?>
                        
                            <!-- Add active in list tag class  <li class=active"> for active menu on page  -->
                                
                                <li class="menu-heading-text"><span><?php _e('Sell', 'ultimate-auction-pro-software'); ?></span></li>
                                <!-- <li><a href="<?php echo $seller_dashboard_page_url; ?>"><?php _e('Sales Overview', 'ultimate-auction-pro-software'); ?></a></li> -->
                                <?php /*<li><a href="<?php echo $seller_in_auction_page_url; ?>"><?php _e('In auction', 'ultimate-auction-pro-software'); ?></a></li> */ ?>
                                <li><a href="<?php echo $seller_submission_page_url; ?>"><?php _e('My Listings', 'ultimate-auction-pro-software'); ?></a></li>
                                <?php /*<li><a href="<?php echo $seller_sold_page_url; ?>"><?php _e('Sold', 'ultimate-auction-pro-software'); ?></a></li>
                                <li><a href="<?php echo $seller_payments_page_url; ?>"><?php _e('Payments', 'ultimate-auction-pro-software'); ?></a></li>*/ ?>
                                <?php } ?>
                                <li class="menu-heading-text"><span><?php _e('Accounts', 'ultimate-auction-pro-software'); ?></span></li>
                                <li><a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>"><?php _e('Settings', 'ultimate-auction-pro-software'); ?></a></li>
                                <li><a href="<?php echo esc_url($wc_logout_url); ?>"> <?php _e('Sign out', 'ultimate-auction-pro-software'); ?> </a></li>
                    
                </ul>

            </div>
            </div>


        <?php } ?>
    <?php } ?>
<?php }






function display_div_after_header() {
    // Check if the current page is not one of the excluded IDs

    if ( class_exists( 'woocommerce' ) ){

        $page_id = get_option( 'options_uat_seller_dashboard_page_id' );
        $buyer_page_id = get_option( 'options_uat_buyer_dashboard_page_id' );
        $excluded_ids = array( $page_id, $buyer_page_id);
        $current_id = get_queried_object_id();
        
        if (!in_array($current_id, $excluded_ids)) {
            // Check if it's not the WooCommerce "My Account" page
            if (class_exists('WooCommerce') && !is_wc_endpoint_url('my-account') && !is_account_page()) {
                echo '<div class="container">'.showEventCategoriesHeader().'</div>';
            }
        }
        $current_user_id = get_current_user_id();
        if(isset($_GET['uat_seller_notice']) && !empty($current_user_id)){
            update_user_meta($current_user_id, 'uat_seller_notice', $_GET['uat_seller_notice']);
        }
        if(isset($_GET['uat_buyer_notice']) && !empty($current_user_id)){
            update_user_meta($current_user_id, 'uat_buyer_notice', $_GET['uat_buyer_notice']);
        }
        if (is_user_logged_in()) {
            $user = get_user_by('ID', $current_user_id);
            $current_user_id = get_current_user_id();
            $notice_meta_value = get_user_meta($current_user_id, 'uat_seller_notice', true);
            if($notice_meta_value != 'hide' && (in_array(UAT_SELLER_ROLE_KEY, $user->roles) || in_array("administrator", $user->roles))){
                do_action('uat_check_seller_details');
            }
            $notice_meta_value_buyer = get_user_meta($current_user_id, 'uat_buyer_notice', true);
            if($notice_meta_value_buyer != 'hide'){
                do_action('uat_check_buyer_details');
            }
        }
    }
}
add_action('uat_after_header', 'display_div_after_header');





function uat_show_payment_notice_callback($content) {
    $uat_show_payment_notice = false;
    $uat_seller_settings_payment_methods = get_option("options_uat_seller_settings_payment_methods");
    if (!empty($uat_seller_settings_payment_methods)) {
        if ($uat_seller_settings_payment_methods == 'automatic') {
            if ( class_exists('WooCommerce') && is_account_page() ) {
                $uat_show_payment_notice = true;
            }else{
                $current_page_id = get_the_ID();
                $seller_dashboard_page_id = get_option('options_uat_seller_dashboard_page_id');
                $buyer_dashboard_page_id = get_option('options_uat_buyer_dashboard_page_id');

                if($seller_dashboard_page_id == $current_page_id || $buyer_dashboard_page_id == $current_page_id){
                    $uat_show_payment_notice = true;
                }
            }
        }
    }
    return $uat_show_payment_notice;
}
add_filter('uat_show_payment_notice', 'uat_show_payment_notice_callback');

add_action('uat_check_seller_details', 'uat_check_seller_details_call');
function uat_check_seller_details_call() {
    $uat_show_payment_notice = apply_filters('uat_show_payment_notice', false);

    
	$uat_custom_fields_seller_registration = get_option('options_uat_custom_fields_seller_registration', 'no');
    $current_user_id = get_current_user_id();
    $need_to_show = seller_payment_setup_ready();
    if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == 'yes' && !$need_to_show && $uat_show_payment_notice) {
        $uat_stripe_link = get_permalink(wc_get_page_id('myaccount')); 
        $notice_text = sprintf(__('Complete your seller profile by adding missing Payment information <a href="%suat-stripe/">Click here</a>', 'ultimate-auction-pro-software'), $uat_stripe_link);
        echo '<div class="container">
        <div class="seller-info-notice-row">
                <div class="seller-info-notice">'. $notice_text .'</div>
                <a class="seller-info-notice-close close-user-notice" data-notice-type="seller" data-user-id="'.$current_user_id.'" href="javascript:void(0)" aria-label="'. __('Dismiss the seller notice panel', 'ultimate-auction-pro-software') .'">
                    <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#000"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                </a>
            </div>
            </div>'; 
    }

}

add_action('uat_check_buyer_details', 'uat_check_buyer_details_call');
function uat_check_buyer_details_call() {
    $uat_show_payment_notice = apply_filters('uat_show_payment_notice', false);
	$uat_custom_fields_seller_registration = get_option('options_uat_custom_fields_seller_registration', 'no');
    $current_user_id = get_current_user_id();
    $need_to_show = buyer_payment_setup_ready();
    if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == 'yes' && !$need_to_show && $uat_show_payment_notice) {
        $uat_stripe_link = get_permalink(wc_get_page_id('myaccount')); 
        $notice_text = sprintf(__('Complete your buyer profile by adding missing Payment information <a href="%suat-stripe/">Click here</a>', 'ultimate-auction-pro-software'), $uat_stripe_link);
        echo '<div class="container">
        <div class="seller-info-notice-row">
                <div class="buyer-info-notice">'. $notice_text .'</div>
                <a class="buyer-info-notice-close close-user-notice" data-notice-type="buyer" data-user-id="'.$current_user_id.'" href="javascript:void(0)" aria-label="'. __('Dismiss the buyer notice panel', 'ultimate-auction-pro-software') .'">
                <svg width="20px" height="20px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns" fill="#000000"><g id="SVGRepo_iconCarrier"> <title>cross-circle</title> <desc>Created with Sketch Beta.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage"> <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-568.000000, -1087.000000)" fill="#000"> <path d="M584,1117 C576.268,1117 570,1110.73 570,1103 C570,1095.27 576.268,1089 584,1089 C591.732,1089 598,1095.27 598,1103 C598,1110.73 591.732,1117 584,1117 L584,1117 Z M584,1087 C575.163,1087 568,1094.16 568,1103 C568,1111.84 575.163,1119 584,1119 C592.837,1119 600,1111.84 600,1103 C600,1094.16 592.837,1087 584,1087 L584,1087 Z M589.717,1097.28 C589.323,1096.89 588.686,1096.89 588.292,1097.28 L583.994,1101.58 L579.758,1097.34 C579.367,1096.95 578.733,1096.95 578.344,1097.34 C577.953,1097.73 577.953,1098.37 578.344,1098.76 L582.58,1102.99 L578.314,1107.26 C577.921,1107.65 577.921,1108.29 578.314,1108.69 C578.708,1109.08 579.346,1109.08 579.74,1108.69 L584.006,1104.42 L588.242,1108.66 C588.633,1109.05 589.267,1109.05 589.657,1108.66 C590.048,1108.27 590.048,1107.63 589.657,1107.24 L585.42,1103.01 L589.717,1098.71 C590.11,1098.31 590.11,1097.68 589.717,1097.28 L589.717,1097.28 Z" id="cross-circle" sketch:type="MSShapeGroup"> </path> </g> </g> </g></svg>
                </a>
            </div>
            </div>'; 
    }

}
function update_user_notice_meta() {
    $response = array('message' => 'Thnotice hided.');
    if (isset($_POST['user_type']) && isset($_POST['user_id'])) {
        $user_type = $_POST['user_type'];
        $user_id = $_POST['user_id'];
        if($user_type == 'buyer'){
            update_user_meta($user_id, 'uat_buyer_notice', 'hide');
        }
        if($user_type == 'seller'){
            update_user_meta($user_id, 'uat_seller_notice', 'hide');
        }
    }

    echo json_encode($response);
    wp_die();
}

add_action('wp_ajax_update_user_notice_meta', 'update_user_notice_meta');
add_action('wp_ajax_nopriv_update_user_notice_meta', 'update_user_notice_meta');


/* Theme customizer options */

function custom_theme_customize_register($wp_customize) {

    $wp_customize->add_panel('theme_color_section', array(
        'title'    => __('Theme Color Palette', 'ultimate-auction-pro-software'),
        'priority' => 30,
        'description' => __('Customize the colors used in the theme.', 'ultimate-auction-pro-software'),
    ));

    $wp_customize->add_section('theme_color_section_subtab_1', array(
        'title'       => __('Header Section', 'ultimate-auction-pro-software'),
        'priority'    => 30,
        'description' => __('Customize the header colors used in the theme.', 'ultimate-auction-pro-software'),
        'panel'       => 'theme_color_section',
        'title_tag'   => 'h3', // Set the HTML tag for the sub-tab title
    ));

    $wp_customize->add_setting('header_color_setting', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color_setting', array(
        'label'    => __('Header background color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_1',
    )));

    $wp_customize->add_setting('header_color_text_setting', array(
        'default'   => '#000000',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_color_text_setting', array(
        'label'    => __('Header text color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_1',
    )));

    $wp_customize->add_setting('header_hover_color_text_setting', array(
        'default'   => '#8f8f8f',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_hover_color_text_setting', array(
        'label'    => __('Header hover text color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_1',
    )));


    $wp_customize->add_section('theme_color_section_subtab_2', array(
        'title'       => __('Contnet Section', 'ultimate-auction-pro-software'),
        'priority'    => 30,
        'description' => __('Customize the body colors used in the theme.', 'ultimate-auction-pro-software'),
        'panel'       => 'theme_color_section',
        'title_tag'   => 'h3', // Set the HTML tag for the sub-tab title
    ));


    $wp_customize->add_setting('custom-background', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'custom-background', array(
        'label'    => __('Body background color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_2',
    )));

    $wp_customize->add_setting('custom-text-color', array(
        'default'   => '#000000',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'custom-text-color', array(
        'label'    => __('Body text color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_2',
    )));

    $wp_customize->add_setting('custom-primary-text-color', array(
        'default'   => '#130e86',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'custom-primary-text-color', array(
        'label'    => __('Primary color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_2',
        'description' => __('The selected color will now be applied to Links,Buttons and Highlighted Sections.', 'ultimate-auction-pro-software'),
    )));

    $wp_customize->add_setting('custom-primary-text-hover-color', array(
        'default'   => '#5550bf',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'custom-primary-text-hover-color', array(
        'label'    => __('Primary hover color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_2',
        'description' => __('The selected color will now be applied to Links,Buttons and Highlighted Sections.', 'ultimate-auction-pro-software'),
    )));


    $wp_customize->add_section('theme_color_section_subtab_3', array(
        'title'       => __('Footer Section', 'ultimate-auction-pro-software'),
        'priority'    => 30,
        'description' => __('Customize the footer colors used in the theme.', 'ultimate-auction-pro-software'),
        'panel'       => 'theme_color_section',
        'title_tag'   => 'h3', // Set the HTML tag for the sub-tab title
    ));


    $wp_customize->add_setting('footer-bg-color', array(
        'default'   => '#ffffff',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer-bg-color', array(
        'label'    => __('Footer background color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_3',
    )));

    $wp_customize->add_setting('footer-text-color', array(
        'default'   => '#919397',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'footer-text-color', array(
        'label'    => __('Footer text color', 'ultimate-auction-pro-software'),
        'section'  => 'theme_color_section_subtab_3',
    )));
 

}
add_action('customize_register', 'custom_theme_customize_register');


function add_custom_body_class($classes) {
    $classes[] = 'uat-custom-background';
    return $classes;
}
add_filter('body_class', 'add_custom_body_class');

function remove_color_tab_customizer( $wp_customize ) {
    $wp_customize->remove_section( 'colors' );
}
add_action( 'customize_register', 'remove_color_tab_customizer', 20 );


add_action('uat_social_icons', 'display_uat_social_icons');
function display_uat_social_icons() { ?>
    <?php if (class_exists('ACF')) { ?>
        <?php if (have_rows('uat_social_media_icons', 'option')) : ?>
            <div class="social-icons">
                <?php while (have_rows('uat_social_media_icons', 'option')) : the_row(); ?>
                    <?php $social_network_icon = get_sub_field('social_network_icon'); ?>
                    <?php if ($social_network_icon) { ?>
                        <span class="social-icon">
                            <a href="<?php the_sub_field('social_network_url'); ?>">
                                <img src="<?php echo $social_network_icon['url']; ?>" alt="<?php echo $social_network_icon['alt']; ?>" title="<?php echo $social_network_icon['title']; ?>" />
                            </a>
                        </span>
                    <?php } ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    <?php } ?>
<?php }