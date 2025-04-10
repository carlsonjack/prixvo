<?php
global $UATS_options;
$seller_action_auction_slug = $UATS_options['seller_action_auction_slug'];
$dashboard_page_id = get_option('options_uat_seller_dashboard_page_id');
$dashboard_page_url = get_permalink($dashboard_page_id);
$add_product_url = $dashboard_page_url . $seller_action_auction_slug;

$in_auction_url = $dashboard_page_url . 'in-auction';
$submission_url = $dashboard_page_url . 'submission';
$sold_url = $dashboard_page_url . 'sold';
global $UATS_options;
$page_template_location = $UATS_options['page_template_location'];
$current_user_id = get_current_user_id();
$user = get_user_by('ID', $current_user_id);
$is_admin = false;
if (current_user_can('manage_options')) {
    $is_admin = true;
}
if ($current_user_id && (in_array(UAT_SELLER_ROLE_KEY,  $user->roles) || $is_admin)) {
?>
<section class="vendor-main" style="width:1550px;max-width:100%;margin:0 auto;">
    <div class="container">
        <?php get_template_part($page_template_location . 'dashboard-header'); ?>
        <div class="Sales-tab-con">
            <div id="tabs-content">
                <?php
                if ($current_page == 'dashboard') {
                    get_template_part($page_template_location . 'dashboard-content');
                } else if ($current_page == 'in-auction') {
                    get_template_part($page_template_location . 'in-auction');
                } else if ($current_page == 'submission') {
                    get_template_part($page_template_location . 'submission');
                } else if ($current_page == 'sold') {
                    get_template_part($page_template_location . 'sold');
                } else if ($current_page == 'payments') {
                    get_template_part($page_template_location . 'payments');
                } else if ($current_page == 'order-view') {
                    get_template_part($page_template_location . 'order-view');
                } else {
                    get_template_part($page_template_location . 'invalid');
                }
                ?>
            </div>
        </div>
    </div>
</section>
<?php 
}else{
    get_template_part($page_template_location . 'invalid');
    exit();

}
?>