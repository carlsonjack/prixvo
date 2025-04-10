<?php
global $UATS_options, $buyer_current_page, $wp_query;
$page_template_location = $UATS_options['buyer_page_template_location'];
$buyer_all_pages_endpoints = $UATS_options['buyer_all_pages_endpoints'];
$dashboard_page_id = get_option('options_uat_buyer_dashboard_page_id');
$dashboard_page_url = get_permalink($dashboard_page_id);
$buyer_dashboard_slug = $UATS_options['buyer_dashboard_slug'];
$dashboard_page_url = get_permalink($dashboard_page_id);
$header_tabs = "";
$current_tab = "";
foreach ($buyer_all_pages_endpoints as $buyer_all_pages_endpoint) {
    $is_dashboard_page = $buyer_all_pages_endpoint['is_dashboard_page'];
    $slug = $buyer_all_pages_endpoint['slug'];
    $active_class = '';
    if ($is_dashboard_page == 'yes') {
        $title_text = $buyer_all_pages_endpoint['title_text'];
        $page_url = $dashboard_page_url . $slug;
        if ($buyer_current_page == $slug) {
            $current_tab = $slug;
            $active_class = "active";
        }
		if($slug =='favourites'){
			$title_text = 'Watchlist';
		}
		
		if($slug!='search' && $slug!='order'){
        $header_tabs .= '<li class="'.$active_class.'" data-page="'.$slug.'">
                            <a href="'.$page_url.'">
                                '.$title_text.'
                            </a>
                        </li>';
		}
    }
}
$UATS_options['current_tab'] = $current_tab;
?>
<section class="vendor-main" style="width:1550px;max-width:100%;margin:0 auto;">
    <div class="container">
		<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
		<div class="my-acc-custom-sec">
			<div class="my-ac-row">
				<div class="my-user-icon">
					<?php 
					$current_user_id = get_current_user_id();
					$attachment_id = get_user_meta( $current_user_id, 'image', true );
					if (!empty($attachment_id)) {
						// Display the profile picture
						echo wp_get_attachment_image( $attachment_id, 'medium');
					} else {
						// Display a default profile picture or a placeholder image
						echo '<svg width="150px" height="150px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_iconCarrier"> <path opacity="0.4" d="M22 7.81V16.19C22 19 20.71 20.93 18.44 21.66C17.78 21.89 17.02 22 16.19 22H7.81C6.98 22 6.22 21.89 5.56 21.66C3.29 20.93 2 19 2 16.19V7.81C2 4.17 4.17 2 7.81 2H16.19C19.83 2 22 4.17 22 7.81Z" fill="#292D32"></path> <path d="M18.4406 21.66C17.7806 21.89 17.0206 22 16.1906 22H7.81055C6.98055 22 6.22055 21.89 5.56055 21.66C5.91055 19.02 8.67055 16.97 12.0005 16.97C15.3305 16.97 18.0906 19.02 18.4406 21.66Z" fill="#292D32"></path> <path d="M15.5799 11.58C15.5799 13.56 13.9799 15.17 11.9999 15.17C10.0199 15.17 8.41992 13.56 8.41992 11.58C8.41992 9.60002 10.0199 8 11.9999 8C13.9799 8 15.5799 9.60002 15.5799 11.58Z" fill="#292D32"></path> </g></svg>';
					}
				  
					?>
				</div>
				<div class="my-user-info">
					<?php 
						
						$user_info = get_userdata($current_user_id);
						$member_since = date("F Y", strtotime($user_info->user_registered));
						$logout_url = wp_logout_url(home_url('/'));
						

					?>
					<h2>Hi <?php echo $display_name = $user_info->display_name; ?></h2>
					<h3>Member since <?php echo $member_since; ?></h3>
					<a href="<?php echo esc_url($logout_url); ?>">Logout</a>
				</div>
			</div>
			<div class="my-ac-row border-top" >
				<div class="my-button-group">
					<a class="btn-acc-primery" href="<?php echo home_url(); ?>/my-account/edit-account/">Edit Account</a>
					<a class="btn-acc-primery" href="<?php echo home_url(); ?>/uat-buyer-dashboard/favourites/">Watchlist</a>
					<a class="btn-acc-primery" href="<?php echo home_url(); ?>/uat-seller-dashboard-3/submission/">My Listings</a>
					<a class="btn-acc-primery" href="<?php echo home_url(); ?>/uat-buyer-dashboard/bids/">Bid History</a>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="buyer-dashboard-page" value="<?php echo $current_tab; ?>"/>
    <div class="container">
        <?php /*
		<div class="Sales-Tab">
            <div class="Sales-tab-list">
                <div class="tab-nav-row">
                    <ul id="tabs-nav">
                        <?php
                        echo $header_tabs;
                        ?>
                    </ul>
                </div>
            </div>
        </div> */ ?>
        <div class="Sales-tab-con">
            <div id="tabs-content">
                <?php
                    get_template_part($page_template_location . $current_tab);
                ?>
            </div>
        </div>
    </div>
</section>
<?php wp_enqueue_script('uat-buyer-order', UAT_THEME_PRO_JS_URI . 'buyer/dashboard.js', array('jquery'), UAT_THEME_PRO_VERSION); ?>

