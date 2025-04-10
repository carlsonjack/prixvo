<?php
/**
 * Extra Functions for theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @packageUltimate Auction Pro Software
 */
 function ultimate_auction_pro_theme_info_version() {
	?>
	 <span class="uat_theme_info_text"> - Ultimate Auction Pro Software</span>
	 <span class="uat_theme_version_text">(Version:<?php echo UAT_THEME_PRO_VERSION; ?>)</span>
	<?php
}

function get_ultimate_auction_wp_timezone()
{
    $uat_time_zone = wp_timezone();
    return $uat_time_zone;
}
function get_ultimate_auction_now_date()
{
    $uat_now_date = wp_date('Y-m-d H:i:s', time() , get_ultimate_auction_wp_timezone());
    return $uat_now_date;
}
function get_ultimate_auction_now_date_ymd()
{
    $uat_now_date = wp_date('Y-m-d', time() , get_ultimate_auction_wp_timezone());
    return $uat_now_date;
}
//user display name
function uat_user_display_name($user_id) {
	global $wpdb;
	$uat_simple_maskusername_enable = get_option('options_uat_simple_maskusername_enable', 'off');
	$c_user_id = get_current_user_id();
	$user_name = "";

	if(current_user_can('administrator') || current_user_can('manage_options') ||
		current_user_can('manage_woocommerce') || $c_user_id == $user_id){
		$user_name = get_userdata($user_id)->display_name;
	}
	elseif($uat_simple_maskusername_enable == "on"){

		$no_user_name = get_userdata($user_id)->display_name;

		$user_strlen = strlen($no_user_name);

		if ($user_strlen <= 2) {
			$user_name = $no_user_name;
		} else {
			$user_firstchar = strtolower($no_user_name[0]);
			$user_lastchar = strtolower($no_user_name[$user_strlen - 1]);
			$user_middlechars = str_repeat("*", $user_strlen - 2);
			$user_name = $user_firstchar . $user_middlechars . $user_lastchar;
		}

	}else{
		$user_name = get_userdata($user_id)->display_name;
	}

	return $user_name;
}

function uat_proxy_mask_user_display_name($user_id) {

	global $wpdb;
	$uat_proxy_maskusername_enable = get_option('options_uat_proxy_maskusername_enable');
	$c_user_id = get_current_user_id();
	$user_name = "";
	if(current_user_can('administrator') || current_user_can('manage_options') ||
		current_user_can('manage_woocommerce') || $c_user_id == $user_id){
		$user_name = get_userdata($user_id)->display_name;
	}
	elseif($uat_proxy_maskusername_enable == "on"){
		$no_user_name = get_userdata($user_id)->display_name;
		$user_strlen = strlen($no_user_name);
		$user_firstchar = strtolower($no_user_name[0]);
		$user_lastchar = strtolower($no_user_name[$user_strlen-1]);
		$user_middlechars = str_repeat("*", $user_strlen - 2);
		$user_name = $user_firstchar. $user_middlechars . $user_lastchar;
	}else{
		$user_name = get_userdata($user_id)->display_name;
	}

	return $user_name;
}
function uat_silent_mask_user_display_name($user_id) {
	global $wpdb;
	$uat_silent_maskusername_enable = get_option('options_uat_silent_maskusername_enable', 'on');
	$c_user_id = get_current_user_id();
	$user_name = "";
	if(current_user_can('administrator') || current_user_can('manage_options') ||
		current_user_can('manage_woocommerce') || $c_user_id == $user_id){
		$user_name = get_userdata($user_id)->display_name;
	}
	elseif($uat_silent_maskusername_enable == "on"){
		$no_user_name = get_userdata($user_id)->display_name;
		$user_strlen = strlen($no_user_name);
		$user_firstchar = strtolower($no_user_name[0]);
		$user_lastchar = strtolower($no_user_name[$user_strlen-1]);
		$user_middlechars = str_repeat("*", $user_strlen - 2);
		$user_name = $user_firstchar. $user_middlechars . $user_lastchar;
	}else{
		$user_name = get_userdata($user_id)->display_name;
	}

	return $user_name;
}
function uat_proxy_mask_bid_amt($bid_value) {
		global $wpdb;
		$uat_proxy_maskbid_enable = get_option('options_uat_proxy_maskbid_enable', 'off');
		if($uat_proxy_maskbid_enable == "on"){
			$bid_value_amt = str_repeat("*", strlen($bid_value));

		} else {
			$bid_value_amt = wc_price($bid_value);
		}
		if (current_user_can('administrator') || current_user_can('manage_options') ) {
			$bid_value_amt = wc_price($bid_value);
		}
		return $bid_value_amt;
}

function uat_silent_mask_bid_amt($bid_value) {
		global $wpdb;
		$uat_silent_bid_enable = get_option('options_uat_silent_maskbid_enable', 'on');
		if($uat_silent_bid_enable == "on"){
			$bid_value_amt = str_repeat("*", strlen($bid_value));

		} else {
			$bid_value_amt = wc_price($bid_value);
		}
		if (current_user_can('administrator') || current_user_can('manage_options') ) {
			$bid_value_amt = wc_price($bid_value);
		}
		return $bid_value_amt;
}
// Breadcrumbs
function uat_theme_breadcrumbs() {
	global $wpdb;
	$hide_breadcrumbs = get_option('options_uat_hide_breadcrumbs', 'on');
	if($hide_breadcrumbs =="on"){
	
    // Settings
    $separator          = '';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumb';  
    $home_title         = __('Home', 'ultimate-auction-pro-software' );
    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';
    $custom_taxonomy_event    = 'uat-event-cat';
    // Get the query & post information
    global $post,$wp_query;
    // Do not display on the homepage
    if ( !is_front_page() ) {
        // Build the breadcrums
        echo '<div class="container">';
        echo '<ul  class="' . $breadcrums_class . '">';
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
			echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title() . '</strong></li>';
			
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
			// If post is a custom post type
			$queried_object = get_queried_object();
			if(!empty($queried_object)){
				if($queried_object->taxonomy == $custom_taxonomy_event){
					$categories_page_id = get_option( 'options_uat_categories_page_id');
					if(!empty($categories_page_id)){
						$page_permalink = get_permalink($categories_page_id);
						echo '<li class="item-current item-archive"><a href="' . $page_permalink . '" >' . UAT_CATEGORIES_PAGE_TITLE . '</a></li>';
						if(!empty($queried_object->parent)){
							$parent_category = get_term($queried_object->parent, $custom_taxonomy_event);
							if ($parent_category && !is_wp_error($parent_category)) {
								$parent_category_name = $parent_category->name;
								$parent_category_link = get_term_link($parent_category);
								echo '<li class="item-current item-archive"><a href="' . $parent_category_link . '" >' . $parent_category_name . '</a></li>';
							}
						}
					}
				}
			}else{

				$post_type = get_post_type();
				// If it is a custom post type display name and link
				if(!empty($post_type) && $post_type != 'post') {
					$post_type_object = get_post_type_object($post_type);
					$post_type_archive = get_post_type_archive_link($post_type);
					echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
				}
            }
            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {
			// If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
				//$parts = explode('.', $category);
                //$last_category = end(array_values($category));
                $vals = array_values($category);
				$last_category = end($vals);
                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    //$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
				if($taxonomy_terms){					
					$cat_id         = $taxonomy_terms[0]->term_id;
					$cat_nicename   = $taxonomy_terms[0]->slug;
					$cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
					$cat_name       = $taxonomy_terms[0]->name;
				}
            }
			// If it's a event post type within a event taxonomy
            $taxonomy_exists_event = taxonomy_exists($custom_taxonomy_event);
            if(empty($last_category) && !empty($custom_taxonomy_event) && $taxonomy_exists_event) {
                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy_event );
				if($taxonomy_terms){					
					$cat_id         = $taxonomy_terms[0]->term_id;
					$cat_nicename   = $taxonomy_terms[0]->slug;
					$cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy_event);
					$cat_name       = $taxonomy_terms[0]->name;
				}

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

				// Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {
				echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
				$subcategory = get_terms(array(
					'taxonomy' => $custom_taxonomy_event,
					'hide_empty' => false,
					'parent' => $cat_id,
				));
				if($subcategory){
					$subcategory_id = $subcategory[0]->term_id;
					$subcategory_name = $subcategory[0]->name;
					$link_sub = get_category_link($subcategory_id);
					echo '<li class="item-current item-' . $post->ID . '"><a href="'.$link_sub.'" >' . $subcategory_name . '</a></li>';
				}
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){
                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';
        echo '</div>';

    }
	
	} else { //Hide Breadcrumbs
			/*echo '<div class="container">';
			echo '<div style="display: block;width: 100%;margin: 0 0 30px 0;">';
			echo '</div>';*/
		} 
	

}
// Next previous navigation for product page.
function get_next_post_id_with_event_products($event_id = "", $product_id = "") {
    $next_post_id = "";
    $lot_ids_array = get_auction_products_ids_by_event($event_id);
    $original_array = unserialize($lot_ids_array);

    if (empty($original_array)) {
        $original_array = array();
    }

    $valid_status = getValidStatusForProductVisible();
    $valid_status[] = 'publish';

    $args = array(
        'post_type' => 'product',
        'post_status' => $valid_status,
        'ignore_sticky_posts' => 1,
        'post__in' => $original_array,
        "orderby" => 'meta_value_num',
        "meta_key" => 'uat_auction_lot_number',
        "order" => 'ASC',
        'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),
        'fields' => 'ids',
    );

    $query = new WP_Query($args);
    $ids = $query->posts;

    $index = array_search($product_id, $ids);

    if ($index !== false) {
        // Check if the product_id is found in the $ids array
        if ($index < count($ids) - 1) {
            // Check if the index is less than the last index before accessing the next post
            $next_post_id = $ids[$index + 1];
        }
    }

    return $next_post_id;
}
function get_previous_post_id_with_event_products($event_id = "", $product_id = "") {
    $previous_post = "";
    $lot_ids_array = get_auction_products_ids_by_event($event_id);
    $original_array = unserialize($lot_ids_array);
    
    if (empty($original_array)) {
        $original_array = array();
    }

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $valid_status = getValidStatusForProductVisible();
    $valid_status[] = 'publish';
    
    $args = array(
        'post_type' => 'product',
        'post_status' => $valid_status,
        'ignore_sticky_posts' => 1,
        'post__in' => $original_array,
        "orderby" => 'meta_value_num',
        "meta_key" => 'uat_auction_lot_number',
        "order" => 'ASC',
        'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),
        'fields' => 'ids',
    );

    $query = new WP_Query($args);
    $ids = $query->posts;

    $index = array_search($product_id, $ids);

    if ($index !== false) {
        // Check if the product_id is found in the $ids array
        if ($index > 0) {
            // Check if the index is greater than 0 before accessing the previous post
            $previous_post = $ids[$index - 1];
        }
    }

    return $previous_post;
}
function uat_admin_side_top_menu (){ ?>
<div class="wrap uat-das uat-db-welcome uat-registration-pending about-wrap">
	<header class="uat-db-header-main">
             <div class="uat-db-header-main-container">
                <a class="uat-db-logo" href="#" aria-label="Link to uat das">
                    <img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ultimate-aution-pro-software-logo.svg">
                </a>
				<nav class="uat-db-menu-main">
                    <ul class="uat-db-menu">
					<?php $option_url = admin_url( 'admin.php?page=ua-auctions-theme-options' );	?>
                        <li class="uat-db-menu-item uat-db-menu-item-options">
						<a class="uat-db-menu-item-link" href="<?php echo $option_url;?>"><span class="uat-db-menu-item-text">Options</span></a>
                        </li>
							<?php $uat_event_url = admin_url( 'edit.php?post_type=uat_event' );	?>

                        <li class="uat-db-menu-item uat-db-menu-item-prebuilt-websites"><a class="uat-db-menu-item-link" href="<?php echo $uat_event_url;?>"><span class="uat-db-menu-item-text">Auction Events</span></a></li>
						<?php $products_url = admin_url( 'admin.php?page=ua-auctions-theme-products-lots' );	?>
                        <li class="uat-db-menu-item uat-db-menu-item-maintenance"><a class="uat-db-menu-item-link" href="<?php echo $products_url;?>"><span class="uat-db-menu-item-text">Product/Lot</span><span class="uat-db-maintenance-counter" style="display: inline;"></span></a>
                        <ul class="uat-db-menu-sub uat-db-menu-sub-maintenance">
                          <?php $Emails_url = admin_url( 'admin.php?page=ua-auctions-emails' );	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $Emails_url;?>">Notification</a>
								</li>
								<?php $logs_url = admin_url( 'admin.php?page=ua-auctions-reports' );	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $logs_url;?>">Logs</a>
								</li>
								<?php $import_url = admin_url( 'admin.php?page=ua_auctions_products_import' );	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $import_url;?>">Import Auctions</a>
								</li>
						 <?php $hel_url = admin_url( 'admin.php?page=ua-auctions-help' );	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $hel_url;?>">Support</a>
								</li>

						 <?php $status_url = admin_url( 'admin.php?page=ua-auctions-theme-status' );	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $status_url;?>">Theme Status</a>
								</li>
								<?php $cf_url = admin_url('admin.php?page=ua-auctions-theme-custom-fields');	?>
								<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
									<a class="uat-db-menu-sub-item-link" href="<?php echo $cf_url; ?>"><?php _e('Custom Fields', 'ultimate-auction-pro-software'); ?></a>
								</li>

                            </ul>
                        </li>
                    </ul>
                </nav>
				</div>
		</header>
		<header class="uat-db-header-sticky">
            <div class="uat-db-menu-sticky">
                <div class="uat-db-menu-sticky-label">
                   <?php
					$uat_theme = wp_get_theme();
					$uat_theme_version = esc_html( $uat_theme->get( 'Version' ) );
					?>
                    <span class="uat-db-version"><span>v<?php echo $uat_theme_version; ?></span> </span>
                </div>
            </div>
		</header>
        </div>
<?php }
function uat_front_user_bid_list( $user_id ,$auction_status, $bid_status ) {

	global $wpdb, $woocommerce;
	$my_auctions = uat_get_bids_list_by_user($auction_status);
    $active_bids_count = 0;
    $lost_bids_count = 0;
    $won_bids_count = 0;
    $won_bids_products_ids = array();
    $won_bids_pay_products_ids = array();

	if ( count($my_auctions ) > 0 ) {
		?>
		<table class=" tbl_bidauc_list uat_table">
			<tr class="bidauc_heading">
			    <?php if($bid_status == "active"){ ?>
					<th class="toptable"><?php echo __( 'Image', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Product', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Event', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Your bid', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Current bid', 'ultimate-auction-pro-software' ); ?></td>
				<?php }elseif($bid_status == "won"){ ?>
					<th class="toptable"><?php echo __( 'Image', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Product', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Event', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Won bid', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Order', 'ultimate-auction-pro-software' ); ?></td>
				<?php }elseif($bid_status == "lost"){ ?>
					<th class="toptable"><?php echo __( 'Image', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Product', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Event', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Your bid', 'ultimate-auction-pro-software' ); ?></td>
					<th class="toptable"><?php echo __( 'Won bid', 'ultimate-auction-pro-software' ); ?></td>
				<?php }else{}?>
			</tr>
			<?php
			foreach ( $my_auctions as $my_auction ) {

			   global $product;
			   global $sitepress;

			   $product_id =  $my_auction->auction_id;

				if (function_exists('icl_object_id') && method_exists($sitepress, 'get_current_language')) {					
					$product_id = icl_object_id($my_auction->auction_id	,'product',false, $sitepress->get_current_language());
				}


			   $product = wc_get_product( $product_id );

				if ( method_exists( $product, 'get_type') && $product->get_type() == 'auction' ) {
			        $product_name = get_the_title( $product_id );
			        $product_url  = get_the_permalink( $product_id );
			        $a            = $product->get_image( 'thumbnail' );

			    	if ($bid_status == "won" && $user_id == $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ){
					$won_bids_count++;
			    	$event_name ="";
					$event_url ="#";
					if(!empty($my_auction->event_id) && $my_auction->event_id!=0){
						$event_name = get_the_title( $my_auction->event_id );
			            $event_url  = get_the_permalink( $my_auction->event_id );

					}

					$product_stock_status =  $product->get_stock_status();
					$product_status =  $product->get_status();
					$btn_text = __( 'View', 'ultimate-auction-pro-software' );
					$view_link = "";
					$uat_auction_expired_payment=get_post_meta( $product_id, 'uat_auction_expired_payment', true );
					$ValidStatusForProductVisible = getValidStatusForProductVisible();
					
					if( in_array($product_status  , $ValidStatusForProductVisible) ){	
						if($uat_auction_expired_payment == 'yes'){	
							$view_order = "";								
							$view_link = "";								
							if(!empty($product->get_uwa_order_id())){
								
								$view_order  = wc_get_endpoint_url('view-order').$product->get_uwa_order_id();
								$view_link = '<a href="'.$view_order.'" class="button alt uwa_pay_now">'.$btn_text.'</a>';
							}else{
								if($product_stock_status != "outofstock")
								{							
									$won_bids_pay_products_ids[] = $product_id;
									$view_order = esc_attr(add_query_arg("pay-uwa-auction",$product->get_id(), wc_get_checkout_url()));
									$btn_text = __('Proceed to checkout', 'ultimate-auction-pro-software' );
									$view_link = '<a href="'.$view_order.'" class="button alt uwa_pay_now">'.$btn_text.'</a>';
								}
							}
						}

			    	?>
						<tr class="bidauc_won">
			            	<td class="bidauc_img"><?php echo $a ;?></td>
			            	<td class="bidauc_name"><a href="<?php echo $product_url; ?>"><?php echo $product_name ?></a></td>
			            	<td class="bidauc_name"><a href="<?php echo  $event_url; ?>"><?php echo $event_name ?></a></td>
			            	<td class="bidauc_curbid"><?php echo $product->get_price_html(); ?></td>
			            	<td class="bidauc_curbid"><?php echo $view_link; ?></td>
						</tr>
			     	<?php } } /* end of if of won  */

			    	/* ------------------------ For Lost bids  ---------------------- */

			    	elseif ($bid_status == "lost" && $user_id != $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ){
					$lost_bids_count++;
			    	$event_name ="";
					$event_url ="#";
					if(!empty($my_auction->event_id) && $my_auction->event_id!=0){
						$event_name = get_the_title( $my_auction->event_id );
			            $event_url  = get_the_permalink( $my_auction->event_id );
					}
			    	?>
						<tr class="bidauc_won">
			            	<td class="bidauc_img"><?php echo $a ;?></td>
			            	<td class="bidauc_name"><a href="<?php echo $product_url; ?>"><?php echo $product_name ?></a></td>
			            	<td class="bidauc_name"><a href="<?php echo  $event_url; ?>"><?php echo $event_name ?></a></td>
			            	<td class="bidauc_bid"><?php echo wc_price($my_auction->max_userbid); ?></td>
			            	<td class="bidauc_curbid"><?php echo $product->get_price_html(); ?></td>
						</tr>
			     	<?php } /* end of if of lost */

			     	/* ------------------------ For active bids  ---------------------- */

			     	elseif($bid_status == "active" && $product->get_uwa_auction_expired() == false){
			     			$active_bids_count++;
						$event_name ="";
						$event_url ="#";
						if(!empty($my_auction->event_id) && $my_auction->event_id!=0){
							$event_name = get_the_title( $my_auction->event_id );
							$event_url  = get_the_permalink( $my_auction->event_id );
						}
						$losing_bid="wining_bid";
						if($user_id != $product->get_uwa_auction_current_bider()){
							$losing_bid="losing_bid";
						}
						
			     		?>
			     		<tr class="bidauc_won <?php echo $losing_bid;?>">
			            	<td class="bidauc_img"><?php echo $a ;?></td>
			            	<td class="bidauc_name"><a href="<?php echo $product_url; ?>"><?php echo $product_name ?></a></td>
			            	<td class="bidauc_name"><a href="<?php echo  $event_url; ?>"><?php echo $event_name ?></a></td>
			            	<td class="bidauc_bid"><?php echo wc_price($my_auction->max_userbid); ?></td>
			            	<td class="bidauc_curbid"><?php echo $product->get_price_html(); ?></td>
						</tr>
							<?php
			     	}

				}  /* end of if method exists  */

			} /* end of foreach */

			if($bid_status == "won" && count($won_bids_pay_products_ids) > 1){ 
				$ids= implode(",",$won_bids_pay_products_ids);
				$view_order = esc_attr(add_query_arg("pay-uwa-auction",$ids, wc_get_checkout_url()));
				$btn_text = __('Checkout all', 'ultimate-auction-pro-software' );
			?>

				<tr class="bidauc_won">
					<td colspan="5" style="text-align: center;">
						<a href="<?php echo  $view_order; ?>" class="button alt uwa_pay_now">
							<?php echo $btn_text; ?>
						</a>
					</td>
				</tr>
			 <?php
			}
			elseif($bid_status == "won" && $won_bids_count == 0){ ?>

				<tr class="bidauc_msg"><td colspan="6"><div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				  <?php _e( 'No bids available yet.' , "ultimate-auction-pro-software" ) ?>
				</div></td></tr>
			 <?php
			}elseif($bid_status == "lost" && $lost_bids_count == 0){ ?>

				<tr class="bidauc_msg"><td colspan="6"><div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				  <?php _e( 'No bids available yet.' , "ultimate-auction-pro-software" ) ?>
				</div></td></tr>

			 <?php
			}elseif($bid_status == "active" && $active_bids_count == 0){ ?>

				<tr class="bidauc_msg"><td colspan="6"><div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
				  <?php _e( 'No bids available yet.' , "ultimate-auction-pro-software" ) ?>
				</div></td></tr>

				 <?php
			}
			?>
		</table>

	<?php
	} /* end of if - count */
	else {
		$shop_page_id = wc_get_page_id( 'shop' );
		$shop_page_url = $shop_page_id ? get_permalink( $shop_page_id ) : '';
		?>
		<div class="woocommerce-message woocommerce-message--info woocommerce-Message
			woocommerce-Message--info woocommerce-info">
			  <a class="woocommerce-Button button" href="<?php echo $shop_page_url;?>">
				<?php _e( 'Go shop' , 'ultimate-auction-pro-software' ) ?>		</a> <?php _e( 'No bids available yet.' , "ultimate-auction-pro-software" ) ?>
		</div>

	<?php } /* end of else */

}
function uat_front_user_bids_count( $user_id ,$auction_status, $bid_status  ) {

	global $wpdb, $woocommerce;
	$my_auctions = uat_get_bids_list_by_user($auction_status);
    $active_bids_count = 0;
    $lost_bids_count = 0;
    $won_bids_count = 0;

	if ( count($my_auctions ) > 0 ) {
	   foreach ( $my_auctions as $my_auction ) {
		   global $product;
	      // $product = wc_get_product( $my_auction->auction_id );

			 global $sitepress;

			   $product_id =  $my_auction->auction_id;

				if (function_exists('icl_object_id') && method_exists($sitepress, 'get_current_language')) {

					$product_id = icl_object_id($my_auction->auction_id	,'product',false, $sitepress->get_current_language());
				}


			   $product = wc_get_product( $product_id );

			if ( method_exists( $product, 'get_type') && $product->get_type() == 'auction' ) {

	        	if ($bid_status == "won" && $user_id == $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ){
	        		/* echo "in won bids"; */
	        		$won_bids_count++;

	         	} /* end of if */

	        	/* ------------------------ For Lost bids  ---------------------- */


	        	elseif ($bid_status == "lost" && $user_id != $product->get_uwa_auction_current_bider() && $product->get_uwa_auction_expired() == '2' ){
	        		/* echo "in lost bids"; */
	        		$lost_bids_count++;
	         	} /* end of if of lost */

	         	elseif($bid_status == "active" && $product->get_uwa_auction_expired() == false){
	         		/* echo "in active bids"; */
	         		$active_bids_count++;
	         	}

			}  /* end of if method exists  */

	    } /* end of foreach  */

	} /* end of if - count */

	if($bid_status == "won"){
		return  $won_bids_count;
	}elseif($bid_status == "lost"){
		return  $lost_bids_count;
	}elseif($bid_status == "active"){
		return  $active_bids_count;
	}else{
		return "null";
	}
}

function get_events_countries_list( ){
		$countries = array();
		$args = array(
		'post_type'      => 'uat_event',
		'posts_per_page' => -1,
		);
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_location_address');
		if( !empty($location) ) {
			$countries[] = $location['country'];
		}
		 endwhile;
		$countries = array_unique($countries, SORT_REGULAR);

	return $countries;
}

function get_Products_location_countries_list( ){
		$countries = array();
		$postids  = uat_get_all_auctions_ids();
		if(empty($postids)){
			$postids[]= array();
		}
		$valid_status = getValidStatusForProductVisible();
		$valid_status[] = 'publish';
		$args = array (
		'post_type'	=> 'product',
		'post_status' => $valid_status,
		'ignore_sticky_posts'	=> 1,
		'post__in' => $postids,
		'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
		'posts_per_page' => -1,

		);
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_locationP_address');
		if( !empty($location) ) {
			$countries[] = $location['country'];
		}
		 endwhile;
		$countries = array_unique($countries, SORT_REGULAR);

	return $countries;
}


function get_Products_location_state_list_by_country( $country_name ){

		$states = array();
		$postids  = uat_get_all_auctions_ids();
		if(empty($postids)){
			$postids[]= array();
		}
		$valid_status = getValidStatusForProductVisible();
		$valid_status[] = 'publish';
		$args = array (
		'post_type'	=> 'product',
		'post_status' => $valid_status,
		'ignore_sticky_posts'	=> 1,
		'post__in' => $postids,
		'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
		'posts_per_page' => -1,

		);
		$meta_queryarr=array('relation' => 'AND');
		$meta_queryarr[]= array(
					'key' => 'uat_Product_loc_country',
					'value'   => $country_name,
					'compare' 	=> 'LIKE',
				);
		if(count($meta_queryarr)>1){
		 $args['meta_query'] =$meta_queryarr;
		}


		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_locationP_address');
		if( !empty($location) ) {
			$states[] = $location['state'];
		}
		 endwhile;
		$states = array_unique($states);
	return $states;
}

function get_Products_location_city_list_by_state( $state_name ){

		$cities = array();
		$postids  = uat_get_all_auctions_ids();
		if(empty($postids)){
			$postids[]= array();
		}
		$valid_status = getValidStatusForProductVisible();
		$valid_status[] = 'publish';
		$args = array (
		'post_type'	=> 'product',
		'post_status' => $valid_status,
		'ignore_sticky_posts'	=> 1,
		'post__in' => $postids,
		'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
		'posts_per_page' => -1,

		);
		$meta_queryarr=array('relation' => 'AND');
		$meta_queryarr[]= array(
					'key' => 'uat_Product_loc_state',
					'value'   => $state_name,
					'compare' 	=> 'LIKE',
				);
		if(count($meta_queryarr)>1){
		 $args['meta_query'] =$meta_queryarr;
		}
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_locationP_address');
		if( !empty($location) ) {
			$cities[] = $location['city'];
		}
		 endwhile;
		$cities = array_unique($cities);
	return $cities;
}



function get_events_state_list_by_country( $country_name ){

		$states = array();
		$args = array(
		'post_type'      => 'uat_event',
		'posts_per_page' => -1,
		);
		$meta_queryarr=array('relation' => 'AND');
		$meta_queryarr[]= array(
					'key' => 'uat_event_loc_country',
					'value'   => $country_name,
					'compare' 	=> 'LIKE',
				);
		if(count($meta_queryarr)>1){
		 $args['meta_query'] =$meta_queryarr;
		}


		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_location_address');
		if( !empty($location) ) {
			$states[] = $location['state'];
		}
		 endwhile;
		$states = array_unique($states);
	return $states;
}
function get_events_city_list_by_state( $state_name ){

		$cities = array();
		$args = array(
		'post_type'      => 'uat_event',
		'posts_per_page' => -1,
		);
		$meta_queryarr=array('relation' => 'AND');
		$meta_queryarr[]= array(
					'key' => 'uat_event_loc_state',
					'value'   => $state_name,
					'compare' 	=> 'LIKE',
				);
		if(count($meta_queryarr)>1){
		 $args['meta_query'] =$meta_queryarr;
		}
		$the_query = new WP_Query($args);
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$location = get_field('uat_location_address');
		if( !empty($location) ) {
			$cities[] = $location['city'];
		}
		 endwhile;
		$cities = array_unique($cities);
	return $cities;
}

function get_wpml_trans_product_ids($products, $serialize = true,$lang = ""){
	global $sitepress;
	if(empty($products)){
		return $products;
	}
			if(is_array($products) && function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')){

			$original_array = array();
			foreach ($products as $product_id){
				if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
					$lang = $lang??$sitepress->get_default_language();
			// $lang =$sitepress->get_default_language();

					$original_array[] = icl_object_id($product_id,'product',false, $lang);
				}
			}
			if( $serialize ){
				return serialize($original_array);
			}else{
				return $original_array;
			}
		}
	return $products;
}
function get_wpml_trans_product_id($product, $lang = ""){
	global $sitepress;
	if(empty($product)){
		return $product;
	}
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$lang = $lang??ICL_LANGUAGE_CODE;
		// $lang =$sitepress->get_default_language();

		$product = icl_object_id($product,'product',false, $lang);
	}
	return $product;
}



function uat_front_user_comment_count( $user_id ,$comment_status ) {
	global $wpdb;
	$args = array(
		'user_id' => $user_id,
        'count' => true, //return only the count
        'status' => $comment_status

	);
	$comments_count = get_comments($args);
	return $comments_count;
}
function is_user_comment_voting( $user_ID = false,$Comment_ID = false){
		if(!$user_ID){
			$user_ID = get_current_user_id();
		}
		$comment_voting = get_comment_meta( $Comment_ID, 'ua_comment_vote_uid', FALSE );
		if(is_array($comment_voting) && in_array($user_ID, $comment_voting)){
			$return =  true;
		} else{
			$return =  false;
		}
		return $return;
	}

function uat_bid_message_in_popup($str)
    {
   	 $str = str_replace("\t", ' ', $str);
   	 $str = str_replace("\n",  '', $str);
   	 $str = str_replace("\r",  '', $str);
   	 
   	 while (stristr($str, '  '))
   	 {
   		 $str = str_replace('  ', ' ', $str);
   	 }
   	 
   	 return $str;
    }

