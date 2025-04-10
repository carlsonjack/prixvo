 <?php
    global $UATS_options, $paged, $submission_args;
    $seller_action_auction_slug = $UATS_options['seller_action_auction_slug'];
    if (isset($_GET['saved_message'])) {
        echo '<div class="save-msg-green" id="messageBox">' . $_GET['saved_message'] . '</div>';
    }
    if (isset($_POST['lot_action_type'])) {
        if (isset($_REQUEST['action_lot_id']) && !empty($_REQUEST['lot_action_type'])) {
            $action_lot_id = $_REQUEST['action_lot_id'];
            $lot_action_type = $_REQUEST['lot_action_type'];
            if ($lot_action_type == 'delete') {
                wp_delete_post($action_lot_id);
            }
            if ($lot_action_type == 'copy') {
                $wc_adp = new WC_Admin_Duplicate_Product;
                $dproduct = $wc_adp->product_duplicate(wc_get_product($action_lot_id));
            }
            if ($lot_action_type == 'edit') {
                $add_auction_page = get_seller_page_url($seller_action_auction_slug) . "\/edit/" . $action_lot_id;
                wp_safe_redirect($add_auction_page, 301);
            }
            if ($lot_action_type == 'view_lot') {
                $add_auction_page = get_permalink($action_lot_id);
                wp_safe_redirect($add_auction_page, 301);
            }
        }
    }
    $seller_p_list_per_page = $UATS_options['seller_p_list_per_page'] ?? 12;

    $status_keys = [];
    $all_product_statuses = $UATS_options['all_product_statuses'];
    $products_table_html = "";
    foreach ($all_product_statuses as $key => $subArray) {
        $one_status = $subArray["slug"];
        if (isset($one_status)) {
            $status_keys[] = $one_status;
        }
    }

    $status_keys[] = 'publish';
    $status_keys[] = 'pending';
    // $status_keys[] = 'draft';
    if (current_user_can('manage_options')) {
        $status_keys[] = 'trash';
    }
    $current_user_id = get_current_user_id();
    $args = array(
        'post_type' => 'product',
        'author' => $current_user_id,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => '==',
            ),
        )
    );

    $page_no = $paged ?? get_query_var('paged');
    // status filter check
    $status_filters = null;
    if (isset($_REQUEST['sf']) && !empty($_REQUEST['sf']) ) {
        $status_filters = $_REQUEST['sf'];
        $status_keys = $status_filters;
        // $page_no = 0;
    }

    $search_term = "";
    /*Search Argument*/
    if (isset($_REQUEST['ds']) && !empty($_REQUEST['ds']) ) {
        $search_term = $_REQUEST['ds'];
        $args['s'] = $search_term;
        // $page_no = 0;
    }

    $submission_args = $args;


    // Get current user ID
    $user = get_user_by('ID', $current_user_id);
    $is_admin = false;
    if (current_user_can('manage_options')) {
        $is_admin = true;
    }
    $no_products_text =  __('No products found.', 'ultimate-auction-pro-software');
    $products_table_html .= '<td class="action-box"><strong>'.$no_products_text.'</strong></td>';
	if ($current_user_id && (in_array(UAT_SELLER_ROLE_KEY,  $user->roles) || $is_admin)) {
        $products_table_html = "";
        // Get custom product statuses
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
				if($product->get_type()=='auction'){
					
				
                $product_type = 'auction'; // <== Here define your product type slug
                $class_name   = WC_Product_Factory::get_classname_from_product_type($product_type); // Get the product Class name

                // If the product class exist for the defined product type
                if (!empty($class_name) && class_exists($class_name)) {
                    $product = new $class_name($product); // Get an empty instance of a grouped product Object
                }
                $product_id = $product->get_id();

                $auction_sort_description = get_the_excerpt() ?? $product->get_auction_subtitle();

                $product_categories = get_the_terms($product_id, 'product_cat');
                $category_names = array();
                if ($product_categories && !is_wp_error($product_categories)) {
                    foreach ($product_categories as $category) {
                        $category_names[] = $category->name;
                    }
                }

                $current_price = wc_price($product->get_uwa_current_bid());
                $product_status = $product->get_status();
                $product_status_slug = "view_lot";
                $product_status_one =  UAT_Sellers_Init::uat_get_product_status($product_status);
                if (!empty($product_status_one) && isset($product_status_one['slug'])) {
                    $product_status = $product_status_one['label'];
                    $product_status_slug = $product_status_one['slug'];
                }
				if(empty($product_status_slug)){
					$product_status_slug = "view_lot";
				}
                $uwa_reserve_txt = "";
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
                $user_nicename = "";
                $profile_image = "";
                if ($user) {
                    $username = $user->user_login;
                    $full_name = $user->display_name;
                    $user_nicename = $user->user_nicename;
                    $profile_image = get_avatar_url($admin_sender_id);
                }
                $product_status = '<div>' . $product_status . '</div>';
                $tooltip_title =  '';
                if (!empty($message_admin) && $product_status_slug == 'uat_change_needed') {
                    $tooltip_title =  __('Feedback from the expert', 'ultimate-auction-pro-software');

                    $product_status .= '
                <div class="tooltip">' . $tooltip_title . '
                    <div class="tooltiptext">
                        <div class="user-Profile">
                            <img class="user-icon" src="' . $profile_image . '">
                            <div class="profile-text">
                                <h5>' . $tooltip_title . '</h5>    
                                <span>' . $full_name . '</span>
                            </div>
                        </div>
                        <div class="feedback-msg">
                        
                            <p>' . $message_admin . '</p>
                            <p>' . $user_nicename . '</p>
                        </div>
                        
                    </div>
                </div>';
                }
				if(get_the_post_thumbnail_url()){
					$url = get_the_post_thumbnail_url();
				}else{
					$url = 'https://prixvo.com/wp-content/uploads/2024/02/pexels-sergo-karakozov-3684847-scaled.webp';
				}
				//echo $product_status;
				//print_r($product_status);
				if($product_status_slug == 'uat_auctined'){
					if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
						$product_status_a = 'Sold';
					}else{
						$product_status_a = 'Bid To '.$current_price;
					}
					
					
				}else{
					$product_status_a = $product_status;
					
				}
				
				
                $lot_actions_options = get_lot_actions($product_id, $product_status_slug);
                $products_table_html .= ' <tr>
                                        <td class="image-box"><img src="' . $url . '" width="100px" height="" alt="" /></td>
                                        <td class="Title-box">
                                            <h3><a href="'.get_the_permalink($product_id).'">' . get_the_title() . '</a></h3>
                                        </td>
                                        <td class="Status-box">' . $product_status_a . '</td>
                                        <td class="Category-box">' . implode(', ', $category_names) . '</td>
                                        <td class="highest-bid-box">
                                            <h4>' . $current_price . '</h4>
                                            <p>' . $uwa_reserve_txt . '</p>                                            
                                        </td>
                                        <td class="action-box">' . $lot_actions_options . '</td>
                                    </tr>';
				}
            }
        } else {
            $products_table_html .= '<td class="table-no-products" colspan="7"><strong>' . $no_products_text . '</strong></td>';
        }

        wp_reset_postdata(); // Reset post data

    }




    ?>


 <div class="salse_tab-content">

     <div class="page-heading">
         <h1><?php echo __('Submissions', 'ultimate-auction-pro-software'); ?></h1>
         <!-- <ul class="review-and-user">
            <li class="user_data"><a href="#">user btde751</a></li>
            <li class="reviews_details"><span>100%</span><a href="#">29 reviews</a></li>
        </ul> -->
     </div>
     <div class="tab_con_box">
        <!-- <a class="sf_btn">Status Filter</a> -->
         <div class="tab_con_box-left">
             <h3><?php echo __('Status', 'ultimate-auction-pro-software'); ?></h3>
             <form name="product-status-filter" id="product-status-filter" method="get" onchange="">
                 <input type="hidden" name="sd" value="<?php echo $search_term; ?>" />
                 <?php echo get_product_status_html(); ?>
             </form>
         </div>
         <div class="tab_con_box-right">
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
				 <div class="right-bulk-link">
					<?php $add_product_url = home_url().'/seller-lead-form/ '; ?>
					<a class="btn-submit" href="<?php echo esc_url($add_product_url); ?>"><?php echo __('Submit new lot', 'ultimate-auction-pro-software'); ?></a>
				</div>
             </div>
             <div class="product_data">
                 <table>
                     <tr>
                         <!-- <th class="check-box"></th> -->
                         <th class="image-box"><?php echo __('Front', 'ultimate-auction-pro-software'); ?></th>
                         <th class="Title-box"><?php echo __('Title', 'ultimate-auction-pro-software'); ?></th>
                         <th class="Status-box"><?php echo __('Status', 'ultimate-auction-pro-software'); ?></th>
                         <th class="Category-box"><?php echo __('Category', 'ultimate-auction-pro-software'); ?></th>
                         <th class="highest-bid-box"><?php echo __('Highest bid', 'ultimate-auction-pro-software'); ?></th>
                         <th class="action-box"><?php echo __('Actions', 'ultimate-auction-pro-software'); ?></th>
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
 </div>

     <script>
         jQuery(document).ready(function($) {
             $(document).on('change', '#lot_action', function() {
                 $(this).closest("form[name='lot_action'").submit();
             });
             $(document).on('change', 'input[name="sf[]"]', function() {
                 $(this).closest("form[name='product-status-filter'").submit();
             });
             setTimeout(function() {
                 jQuery("#messageBox").hide('blind', {}, 500)
             }, 5000);
             jQuery(document).on('click', ".action-box .drop-down", function(e) {
                 e.preventDefault();
                 var options = jQuery(this).children(".options");
                 if (options.is(":visible")) {
                     options.hide();
                 } else {
                     jQuery(".action-box .drop-down .options").hide();
                     options.show();
                 }
             });
             jQuery(document).on('click', ".action-box .drop-down li a", function(e) {
                 e.preventDefault();
                 console.log(e)
                 var $action = jQuery(this).data("value");
                 var actionForm = jQuery(this).closest("form[name='lot_action']")
                 actionForm.find('input[name="lot_action_type"]').val($action);
                 actionForm.submit();

             });
             jQuery(document).on('click', ".sf_btn", function(e) {             
                jQuery(".tab_con_box-left").slideToggle();
            });

            


         });
     </script>