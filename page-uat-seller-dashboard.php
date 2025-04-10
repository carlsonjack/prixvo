<?php
global $wp;

get_header();

$user_id = get_current_user_id();

if (!empty($user_id) && is_seller_enabled()) {
    $user = get_user_by('ID', $user_id);
    if (class_exists('WooCommerce') && $user && (in_array(UAT_SELLER_ROLE_KEY, $user->roles) || in_array("administrator", $user->roles))) {
        echo get_seller_page();
    } else {
        handle_404_error();
    }
} else {
    if (str_contains($wp->request, 'uat-seller-dashboard')) {
        if (!is_user_logged_in()) {
            $register_url = wc_get_page_permalink('myaccount');
            wp_safe_redirect( $register_url, 301);
            exit();
        }
    }
    handle_404_error();
}

get_footer();


