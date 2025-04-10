
 <?php
    global $UATS_options, $paged, $submission_args;
    $seller_p_list_per_page = $UATS_options['seller_p_list_per_page'] ?? 12;
    $status_keys = [];
    $all_product_statuses = $UATS_options['all_product_statuses'];
    $products_table_html = "";
    foreach ($all_product_statuses as $key => $subArray) {
        $one_status = $subArray["slug"];
        if (isset($one_status) && ($one_status == 'uat_payment_received' || $one_status == 'uat_paid')) {
            $status_keys[] = $one_status;
        }
    }

    // $status_keys[] = 'pending';
    // $status_keys[] = 'draft';
    if (current_user_can('manage_options')) {
        $status_keys[] = 'trash';
    }
    $current_user_id = get_current_user_id();
    $args = array(
        'post_type' => 'product',
        'author' => $current_user_id,
        'post_status' => array('uat_payment_received','uat_paid'),
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => '==',
            ),
        )
    );
    

    // status filter check
    $status_filters = null;
    if (isset($_REQUEST['sf']) && !empty($_REQUEST['sf'])) {
        $status_filters = $_REQUEST['sf'];
        $status_keys = $status_filters;
    }

    $search_term = "";
    /*Search Argument*/
    if (isset($_REQUEST['ds']) && !empty($_REQUEST['ds'])) {
        $search_term = $_REQUEST['ds'];
        $args['s'] = $search_term;
    }
    $submission_args = $args;


    // Get current user ID
    $user = get_user_by('ID', $current_user_id);
    $is_admin = false;
    if (current_user_can('manage_options')) {
        $is_admin = true;
    }
    $products_table_html .= '<td class="action-box">No products found.</td>';
    if ($current_user_id && (in_array(UAT_SELLER_ROLE_KEY,  $user->roles) || $is_admin)) {
        $products_table_html = "";
        // Get custom product statuses
        $page_no = $paged ?? get_query_var('paged');
        // Query to get all products uploaded by current user with custom product statuses
        $args_p = $args;
        $args_p['posts_per_page'] = $seller_p_list_per_page;
        $args_p['paged'] = $page_no;
        $args_p['post_status'] = $status_keys;

        $products = new WP_Query($args_p);
        $count = $products->found_posts;

        // Loop through the products and display them
        if ($products->have_posts()) {
            while ($products->have_posts()) {
                $products->the_post();
                global $product;

                $product_type = 'auction'; // <== Here define your product type slug
                $class_name   = WC_Product_Factory::get_classname_from_product_type($product_type); // Get the product Class name

                // If the product class exist for the defined product type
                if (!empty($class_name) && class_exists($class_name)) {
                    $product = new $class_name($product); // Get an empty instance of a grouped product Object
                }
                $product_id = $product->get_id();

                /* get order details */
                
                $auction_current_bid = $product->get_uwa_auction_current_bid();
                $auction_current_bidder = $product->get_uwa_auction_current_bider();
                $winner_user = get_user_by( 'ID', $auction_current_bidder );
                $buyer_name = "";
                if($winner_user && !empty($winner_user)){
                    $buyer_name = $winner_user->display_name;
                }
                $order_id = get_post_meta( $product_id, 'woo_ua_order_id', true );
                $order = wc_get_order( $order_id );
                $payment_date = "-";
                if ( is_a( $order, 'WC_Order' ) ) {
                    $payment_date_ = $order->get_date_paid();
                    if(!empty($payment_date_)){
                        $payment_date = $payment_date_??format( wc_date_format() );
                    }
                } 
                $auction_sort_description = get_the_excerpt() ?? $product->get_auction_subtitle();

                $current_price = wc_price($product->get_uwa_current_bid());
                $product_status = $product->get_status();

                $product_status_one =  UAT_Sellers_Init::uat_get_product_status($product_status);
                if (!empty($product_status_one) && isset($product_status_one['slug'])) {
                    $product_status = $product_status_one['label'];
                }
                $product_status_slug = "";
                $product_status_one =  UAT_Sellers_Init::uat_get_product_status($product_status);
                if (!empty($product_status_one) && isset($product_status_one['slug'])) {
                    $product_status = $product_status_one['label'];
                    $product_status_slug = $product_status_one['slug'];
                }
                if ($product->is_uwa_reserve_enabled()) {
                    if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
                        $uwa_reserve_txt = __('Reserve Price', 'ultimate-auction-pro-software');
                    }
                    if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
                        $uwa_reserve_txt = __('Reserve price met', 'ultimate-auction-pro-software');
                    }
                } else {
                    $uwa_reserve_txt = __('No reserve', 'ultimate-auction-pro-software');
                }

                $message_admin = get_post_meta($product->get_id(), '_seller_message', true);
                $admin_sender_id = get_post_meta($product->get_id(), '_sender_id', true);

                $user = get_user_by('ID', $admin_sender_id);
                $full_name = "";
                $profile_image = "";
                if ($user) {
                    $username = $user->user_login;
                    $full_name = $user->display_name;
                    $profile_image = get_avatar_url($admin_sender_id);
                }
                $product_status = '<div>' . $product_status . '</div>';
                if (!empty($message_admin)) {

                    $product_status .= '
                <div class="tooltip">Feedback from the expert
                    <div class="tooltiptext">
                        <div class="user-Profile">
                            <img class="user-icon" src="' . $profile_image . '">
                            <div class="profile-text">
                                <h5>Feedback from the expert</h5>    
                                <span>' . $full_name . '</span>
                            </div>
                        </div>
                        <div class="feedback-msg">
                            <p>Of Course, ss You Wish!</p>
                            <p>Have a Lovely Evening</p>
                            <p>' . $message_admin . '</p>
                        </div>
                        
                    </div>
                </div>';
                }
                
                $sold_action_buttons = "<button>Sending</button>";
                $sold_action_buttons .= get_sold_action_buttons($product_id, $product_status_slug);
                $products_table_html .= ' <tr>
                                                <td class="image-box"><img src="' . get_the_post_thumbnail_url() . '" width="100px" height="" alt="" /></td>
                                                <td class="Title-box">
                                                    <h3>' . get_the_title() . '</h3>
                                                </td>
                                                <td class="order-number-box">' . $order_id . '</td>
                                                <td class="amount-box">' . wc_price( $auction_current_bid ) . '</td>
                                                <td class="buyer-box">' . $buyer_name . '</td>
                                                <td class="payment-date-box">' . $payment_date . '</td>';

                    // $products_table_html .=     '<td class="action-box">' . $sold_action_buttons . ' </td>';
                $products_table_html .=   '</tr>';
            }
        } else {
            $products_table_html .= '<td class="table-no-products" colspan="7">' . __('No products found.', 'ultimate-auction-pro-software') . '</td>';
        }

        wp_reset_postdata(); // Reset post data

    }




    ?>


 <div class="salse_tab-content">

     <div class="page-heading">
         <h1><?php echo __('Sold lots', 'ultimate-auction-pro-software'); ?></h1>
         <!-- <ul class="review-and-user">
            <li class="user_data"><a href="#">user btde751</a></li>
            <li class="reviews_details"><span>100%</span><a href="#">29 reviews</a></li>
        </ul> -->
     </div>
     <div class="tab_con_box">
         <div class="tab_con_box-left" style="display: none;">
             <h3><?php echo __('Status', 'ultimate-auction-pro-software'); ?></h3>
             <form name="product-status-filter" id="product-status-filter" method="get">
                 <input type="hidden" name="sd" value="<?php echo $search_term; ?>" />
                 <?php echo get_product_shipping_status_html(); ?>
             </form>
         </div>
         <div class="tab_con_box-right sold_page_content">
             <div class="search_and_filter">
                 <div class="search_bl">
                     <form name="product-search-filter" id="product-search-filter" method="get">
                         <?php if (!empty($status_filters)) : foreach ($status_filters as $status_filter) : ?>
                                 <input type="hidden" name='sf[]' value="<?php echo $status_filter; ?>" />
                         <?php endforeach;
                            endif; ?>
                         <input type="text" class="form-control" placeholder="<?php echo __('Search here', 'ultimate-auction-pro-software'); ?>" name="ds" id="search-auction" value="<?php echo $search_term; ?>">
                         <button class="search-btn" type="submit"></button>
                     </form>
                 </div>
             </div>
             <div class="product_data">
                 <table>
                     <tr>
                         <!-- <th class="check-box"></th> -->
                         <th class="image-box"><?php echo __('Front', 'ultimate-auction-pro-software'); ?></th>
                         <th class="Title-box"><?php echo __('Title', 'ultimate-auction-pro-software'); ?></th>
                         <th class="order-number-box"><?php echo __('Order number', 'ultimate-auction-pro-software'); ?></th>
                         <th class="amount-box"><?php echo __('Amount', 'ultimate-auction-pro-software'); ?></th>
                         <th class="buyer-box"><?php echo __('Buyer', 'ultimate-auction-pro-software'); ?></th>
                         <th class="payment-date-box"><?php echo __('Payment date', 'ultimate-auction-pro-software'); ?></th>
                         <!-- <th class="status-box"><?php echo __('Status', 'ultimate-auction-pro-software'); ?></th> -->
                     </tr>
                     <?php echo $products_table_html ?>
                 </table>
                 <?php
                    // Pagination
                    if (!empty($products) && $products->max_num_pages > 1) {
                        echo '<div class="pagination">';
                        echo paginate_links(array(
                            'total' => $products->max_num_pages,
                            'current' => max(1, $page_no),
                        ));
                        echo '</div>';
                    }

                    ?>
             </div>
         </div>
     </div>


     <script>
        //  document.addEventListener('DOMContentLoaded', function() {
        //      var form = document.getElementById('product-status-filter');
        //      var checkboxes = form.querySelectorAll('input[type="checkbox"]');
        //      checkboxes.forEach(function(checkbox) {
        //          checkbox.addEventListener('click', function() {
        //              form.submit();
        //          });
        //      });
        //  });
     </script>