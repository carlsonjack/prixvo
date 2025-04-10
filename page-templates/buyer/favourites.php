<?php
global $UATS_options, $paged;
$page_url = get_buyer_page_url($slug = "favourites");
$default_title = __('Watchlist', 'ultimate-auction-pro-software');
$title = $buyer_current_page_data['title_text'] ?? $default_title;

$sorting_options = [];
$sorting_options[] = ['key' => 'recently_added', 'text' => __('Recently added', 'ultimate-auction-pro-software')];
$sorting_options[] = ['key' => 'time_remaining', 'text' => __('Time remaining', 'ultimate-auction-pro-software')];
// $sorting_options[] = ['key' => 'recently_closed', 'text' => __('Recently closed', 'ultimate-auction-pro-software')];
$selected_sorting = 'recently_added';
if (isset($_GET['sort_by']) && !empty($_GET['sort_by'])) {
    $selected_sorting = $_GET['sort_by'];
}
$selected_sorting_text = __('Recently added', 'ultimate-auction-pro-software');

$options = "";
foreach ($sorting_options as $sorting_option) {
    $key = $sorting_option['key'];
    $text = $sorting_option['text'];
    $link = esc_url(add_query_arg('sort_by', $key));
    if ($key == $selected_sorting) {
        $selected_sorting_text = $text;
    }
    $options .= '<li><a data-value="' . $key . '" href="' . $link . '">' . $text . '<span class="value"></span></a></li>';
}
$current_user = wp_get_current_user();
$user_id = $current_user->ID;

$uat_auction_saved_ids = uat_get_auctions_saved_by_user($user_id);
$products_list_html = '<div class="no-result-found"><h5>' . __('Your watchlist is empty.', 'ultimate-auction-pro-software') . '</h5></div>';
$products_lot_count_html = '';
$products_list_pagination_html = '';

$buyer_p_list_per_page = $UATS_options['buyer_p_list_per_page'] ?? 12;
$page_no = $paged ?? get_query_var('paged');
if (!empty($uat_auction_saved_ids)) {
   
    $args = array(
        'post_type' => 'product',
        'post__in' => $uat_auction_saved_ids,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => '==',
            ),
        ),
        'posts_per_page' => $buyer_p_list_per_page,
        'paged' => $page_no
    );
    if ($selected_sorting == 'recently_added') {
        $args['meta_key'] = 'woo_ua_auction_end_date';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'DESC';
        $args['meta_query'] = array(
            array(
                'key'     => 'woo_ua_auction_end_date',
                'compare' => 'EXISTS', // Ensure the meta key exists
            ),
        );
    } elseif ($selected_sorting == 'time_remaining') {
        $args['meta_key'] = 'woo_ua_auction_end_date';
        $args['orderby'] = 'meta_value';
        $args['order'] = 'ASC';
        $args['meta_query'] = array(
            array(
                'key'     => 'woo_ua_auction_end_date',
                'compare' => 'EXISTS', // Ensure the meta key exists
            ),
        );
    }
    $favourites_products = new WP_Query($args);
    $total = $favourites_products->found_posts;


    if ($total > 0) {
        $products_list_html = '';
        $lots_text = __('Live Auctions', 'ultimate-auction-pro-software');
        if ($total == 1) {
            $lots_text = __('Live Auction', 'ultimate-auction-pro-software');
        }
        $products_lot_count_html .= '<h5>' . $total . " " . $lots_text . '</h5>';
        if ($favourites_products->have_posts()) {
            while ($favourites_products->have_posts()) {
                $favourites_products->the_post();
                ob_start();
                $product_box_options = [
                    'show_timer' => 'on'
                ];
                wc_get_template_part('content', 'product', array('product_box_options' => $product_box_options));
                // get_template_part('templates/products/uat', 'product-box');
                $products_list_html .= ob_get_clean();
            }
            // Pagination
            if (!empty($favourites_products) && $favourites_products->max_num_pages > 1) {
                $products_list_pagination_html .= '<div class="product_data buyer-pagination"><div class="pagination">';
                $products_list_pagination_html .= paginate_links(array(
                    'base' => $page_url . '%_%', // Use the base URL without query parameters
                    'format' => '/page/%#%',
                    'total' => $favourites_products->max_num_pages,
                    'current' => max(1, $page_no),
                    'add_args' => false,
                ));
                $products_list_pagination_html .= '</div></div>';
            }
            wp_reset_postdata();
        }
    }else {
        $products_list_html = '<div class="no-result-found"><h5>' . __('Your watchlist is empty', 'ultimate-auction-pro-software') . '</h5></div>';
    }
} else {
    $products_list_html = '<div class="no-result-found"><h5>' . __('Your watchlist is empty.', 'ultimate-auction-pro-software') . '</h5></div>';
}


?>
<div class="buyer-page containter">
    <div class="buyer-page-title">
        <h1><?php echo $title; ?></h1>
    </div>
    <div class="buyer-page-content">
        <div class="buyer-page-sorting-box" style="width: 300px;">
            <div class="drop-down">
                <div class="selected">
                    <span><?php echo $selected_sorting_text; ?></span>
                </div>
                <div class="options">
                    <input type="hidden" id="selected_sort_option" value="recently_added" />
                    <ul>
                        <?php echo $options; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="buyer-page-sorting-box-result">
            <?php echo $products_lot_count_html; ?>
        </div>

        <div class="buyer-page-list-box">
            <div class="ua-product-listing    prod grid-view">
                <div class="product-list-columns Event-ProductsSearch-Results pro-list-row">
                    <?php echo $products_list_html; ?>
                </div>
                <?php echo $products_list_pagination_html; ?>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function($) {
        jQuery(document).on('click', ".drop-down", function(e) {
            //  e.preventDefault();
            var options = jQuery(this).children(".options");
            if (options.is(":visible")) {
                options.hide();
            } else {
                jQuery(".drop-down .options").hide();
                options.show();
            }
        });
    });
</script>