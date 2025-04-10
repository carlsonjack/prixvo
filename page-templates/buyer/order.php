<div class="Sales-tab-con">
   <div id="tabs-content" class="order-page">
      <div class="salse_tab-content">
         <div class="tab_con_box">
            <?php
            global $wp, $UATS_options, $paged, $submission_args, $buyer_current_page, $wp_query;
            $current_user_id = get_current_user_id();
            if ($current_user_id) {

               $dashboard_page_id = get_option('options_uat_buyer_dashboard_page_id');
               $order_unpaid_status = $UATS_options['uat_seller_order_unpaid_status'];
               $order_paid_status = $UATS_options['uat_seller_order_paid_status'];

               $dashboard_page_url = get_permalink($dashboard_page_id);
               $customer_orders = get_posts(
                  apply_filters(
                     'woocommerce_my_account_my_orders_query',
                     array(
                        'numberposts' => -1,
                        'meta_key'    => '_customer_user',
                        'meta_value'  => get_current_user_id(),
                        'post_type'   => wc_get_order_types('view-orders'),
                        'post_status' => array_keys(wc_get_order_statuses()),
                     )
                  )
               );

               // Get the count of orders for the user.
               $order_count = count($customer_orders);
               if ($order_count == 0) {
            ?>
                  <div class="non-diliverd-product">
                     <h5><?php echo __('Find your orders here', 'ultimate-auction-pro-software'); ?></h5>
                     <p><?php echo __('If you’re the highest bidder, this is where you pay for your order. Explore our auctions to find something special.', 'ultimate-auction-pro-software'); ?></p>
                     <p><?php echo __('Did the auction just end? If so, wait a few minutes then refresh.', 'ultimate-auction-pro-software'); ?></p>
                     <div class="btn-links-group">
                        <a href="<?php echo home_url($wp->request) ?>" class="blue-btn"><?php echo __('Refresh', 'ultimate-auction-pro-software'); ?></a>
                        <a href="<?php echo home_url() ?>" class="small-blue-link" target="_blank">
                           <?php echo __('Explore our Auction', 'ultimate-auction-pro-software'); ?>
                           <svg xmlns="http://www.w3.org/2000/svg" width="5" height="9" viewBox="0 0 5 9">
                              <path fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M1 8l3-3.5L1 1"></path>
                           </svg>
                        </a>
                     </div>
                  </div>
               <?php
               } else {

                  $paid_order = $dashboard_page_url . $UATS_options['current_tab'] . "?type=paid";
                  $unpaid_order = $dashboard_page_url . $UATS_options['current_tab'] . "?type=unpaid";
                  $paid_active =  '';
                  $unpaid_active =  'active';
                  if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'paid') {
                     $paid_active =  'active';
                     $unpaid_active =  '';
                  }


                  $seller_p_list_per_page = $UATS_options['seller_p_list_per_page'] ?? 12;
                  $status_keys = [];
                  $all_product_statuses = $UATS_options['all_product_statuses'];

                  foreach ($all_product_statuses as $key => $subArray) {
                     $one_status = $subArray["slug"];
                     if (isset($one_status) && $one_status == 'uat_payment_received') {
                        $status_keys[] = $one_status;
                     }
                  }
                  if (current_user_can('manage_options')) {
                     $status_keys[] = 'trash';
                  }
                  $per_page = 10;
                  $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                  $orders_paid = [];
                  $orders = [];
                  if ($paid_active ==  'active') {
                     $order_statuses = $order_paid_status;
                  }
                  if ($paid_active !=  'active') {
                     $order_statuses = $order_unpaid_status;
                  }
               ?>
                  <div class="page-heading">
                     <div class="paid-unpaid">
                        <ul>
                           <li class="<?php echo $unpaid_active; ?>">
                              <a href="<?php echo $unpaid_order; ?>">
                                 <?php echo __('Unpaid', 'ultimate-auction-pro-software'); ?>
                              </a>
                           </li>
                           <li class="<?php echo $paid_active; ?>">
                              <a href="<?php echo $paid_order; ?>">
                                 <?php echo __('Paid', 'ultimate-auction-pro-software'); ?>
                              </a>
                           </li>
                        </ul>
                     </div>
                  </div>
                  <?php

                  foreach ($customer_orders as  $key => $customer_order) {
                     $order      = wc_get_order($customer_order);
                     $order_status = $order->get_status();
                     if (!in_array($order_status, array_keys($order_statuses))) {
                        unset($customer_orders[$key]);
                     }
                  }
                  ?>
                  <div class="tab_con_box-right">
                     <div class="product_data">
                        <div class="prod-box-row">
                           <?php
                           $orders = [];
                           /* orders generated */
                           $thumbnail_url = wc_placeholder_img_src();
                           if (count($customer_orders) > 0) {
                              foreach ($customer_orders as $customer_order) {
                                 $one_order = [];
                                 $order      = wc_get_order($customer_order);
                                 $order_total = $order->get_total();
                                 $order_number = $order->get_order_number();
                                 $item_count = $order->get_item_count();
                                 $order_id = $order->get_id();
                                 $order_date = wc_format_datetime($order->get_date_created());
                                 $order_status = $order->get_status();
                                 $order_status_text = wc_get_order_status_name($order->get_status());

                                 $one_order['total'] = $order_total;
                                 $one_order['number'] = $order_number;
                                 $one_order['status'] = $order_status;
                                 $one_order['image'] = $thumbnail_url;
                                 $one_order['status_text'] = $order_status_text;
                                 $one_order['item_count'] = $item_count;
                                 $one_order['create_date'] = $order_date;
                                 $one_order['get_payment_method_title'] = $order->get_payment_method_title();


                                 if ($order_status !== 'completed' && $order_status !== 'processing') {
                                    $link_text = __('Proceed to checkout', 'ultimate-auction-pro-software');
                                    $link =  esc_url($order->get_checkout_payment_url());
                                 } else {
                                    $link_text = __('View order', 'ultimate-auction-pro-software');
                                    $link =  esc_url($order->get_view_order_url());
                                 }
                                 $order_link = '<a href="' . $link . '" class="button alt uwa_pay_now blue-btn dilivery-btn">' . $link_text . '</a>';
                                 $invoice_url = buyer_invoice_generate($order_id);
                                 if(!empty($invoice_url)){
                                    $invoice_text = __('View invoice', 'ultimate-auction-pro-software');
                                    $order_link .= '<a href="' . $invoice_url . '" class="button alt uwa_pay_now blue-btn dilivery-btn">' . $invoice_text . '</a>';
                                 }
                                 $one_order['order_link'] = $order_link;
                                 if ($item_count == 0) {
                                    $i = 0;
                                    $fees = $order->get_fees();
                                    foreach ($fees as $fee) {
                                       if ($i > 0) {
                                          continue;
                                       }
                                       $fee_name = $fee->get_name();
                                       $fee_total = $fee->get_total();
                                       $one_order['name'] = $fee_name;
                                       $one_order['image'] = wc_placeholder_img_src();
                                       $one_order['type'] = 'fees';
                                    }
                                 } else {
                                    $i = 0;
                                    foreach ($order->get_items() as $item_id => $item) {
                                       if ($i > 0) {
                                          continue;
                                       }
                                       $i++;
                                       $product = $item->get_product();
                                       $product_name = $item->get_name();
                                       $product_price = $order->get_formatted_line_subtotal($item); // Get the product price
                                       $product_quantity = $item->get_quantity();
                                       $product_id = $item->get_product_id() . '<br>';
                                       $woo_pf = new WC_Product_Factory();
                                       $product = $woo_pf->get_product($product_id);
                                       $type = 'normal';
                                       if ($product instanceof WC_Product_Auction) {
                                          $type = 'auction';
                                          $one_order['uat_seller_name'] = $product->get_seller_name();
                                          $auction_current_bid = $product->get_uwa_auction_current_bid();
                                          $auction_current_bidder = $product->get_uwa_auction_current_bider();
                                          $winner_user = get_user_by('ID', $auction_current_bidder);
                                          $one_order['auction_current_bid'] = $product->get_uwa_auction_current_bid();
                                          $one_order['auction_current_bidder'] = $product->get_uwa_auction_current_bider();
                                          $one_order['product_link'] = $product->get_permalink();
                                          $one_order['uat_auction_lot_number'] = $product->get_lot_number();
                                          $woo_ua_auction_end_date = $product->get_uwa_auction_end_dates();
                                          $timestamp = strtotime($woo_ua_auction_end_date);
                                          $woo_ua_auction_end_date_formatted = date(wc_date_format(), $timestamp);
                                          $one_order['woo_ua_auction_end_date_formatted'] = $woo_ua_auction_end_date_formatted;
                                       }
                                       $one_order['type'] = $type;
                                       $one_product = [];
                                       $one_product['id'] = $product_id;
                                       $one_product['name'] = $item->get_name();
                                       $one_product['type'] = $type;
                                       $one_product['price'] = $product_price;
                                       $one_product['qty'] = $product_quantity;
                                       $one_order['products'][] = $one_product;
                                       $one_order['name'] = $item->get_name();
                                       $thumbnail_url_main = wp_get_attachment_image_url(get_post_thumbnail_id($item->get_product_id()), 'single-post-thumbnail');
                                       if (!empty($thumbnail_url_main)) {
                                          $one_order['image'] = $thumbnail_url_main;
                                       }
                                    }
                                 }
                                 $orders[] = $one_order;
                              }
                           }
                           if ($paid_active !=  'active') {
                              $expired_p_status = ['uat_past', 'uat_auctined'];
                              $args = array(
                                 'post_type'      => 'product',  
                                 'posts_per_page' => -1,         
                                 'post_status'    => $expired_p_status,  
                                 'tax_query' => array(
                                    array(
                                       'taxonomy' => 'product_type',
                                       'field' => 'slug',
                                       'terms' => 'auction',
                                       'operator' => '==',
                                    ),
                                 ),
                                 'meta_query'     => array(
                                    'relation'    => 'AND',  
                                    array(
                                       'key'     => 'woo_ua_order_id',
                                       'compare' => 'NOT EXISTS',
                                    ),
                                    array(
                                       'key'     => 'uat_auction_expired_payment',
                                       'value'   => 'yes',
                                       'compare' => '=',
                                       'type'    => 'CHAR',  
                                    ),
                                    array(
                                       'key'     => 'woo_ua_auction_closed',
                                       'value'   => '2',
                                       'compare' => '=',
                                       'type'    => 'NUMERIC',  
                                    ),
                                    array(
                                       'key'     => 'woo_ua_auction_current_bider',
                                       'value'   => $current_user_id,
                                       'compare' => '=',
                                    ),
                                 ),
                              );
                              $query = new WP_Query($args);
                              if ($query->have_posts()) {
                                 while ($query->have_posts()) {
                                    $query->the_post();
                                    $product_id = get_the_ID();
                                    $product = wc_get_product($product_id);
                                    $one_order = [];
                                    $type = $product->get_type();
                                    if ($type == 'auction') {
                                       $one_order['uat_seller_name'] = $product->get_seller_name();
                                       $auction_current_bid = $product->get_uwa_auction_current_bid();
                                       $auction_current_bidder = $product->get_uwa_auction_current_bider();
                                       $winner_user = get_user_by('ID', $auction_current_bidder);
                                       $one_order['auction_current_bid'] = $product->get_uwa_auction_current_bid();
                                       $one_order['auction_current_bidder'] = $product->get_uwa_auction_current_bider();
                                       $one_order['product_link'] = $product->get_permalink();
                                       $one_order['uat_auction_lot_number'] = $product->get_lot_number();
                                       $woo_ua_auction_end_date = $product->get_uwa_auction_end_dates();
                                       $timestamp = strtotime($woo_ua_auction_end_date);
                                       $woo_ua_auction_end_date_formatted = date(wc_date_format(), $timestamp);
                                       $one_order['woo_ua_auction_end_date_formatted'] = $woo_ua_auction_end_date_formatted;
                                    }
                                    $one_order['type'] = $type;
                                    $one_product = [];
                                    $one_product['id'] = $product_id;
                                    $one_product['name'] = get_the_title();
                                    $one_product['type'] = $type;
                                    $one_product['price'] = $product->get_price();
                                    $one_order['products'][] = $one_product;
                                    $one_order['image'] = get_the_post_thumbnail_url();
                                    $one_order['name'] = get_the_title();

                                    $checkout_url = esc_attr(add_query_arg("pay-uwa-auction", $product_id, wc_get_checkout_url()));
                                    $link_text = __('Proceed to checkout', 'ultimate-auction-pro-software');
                                    $order_link = '<a href="' . $checkout_url . '" class="button alt uwa_pay_now blue-btn dilivery-btn">' . $link_text . '</a>';
                                    $one_order['order_link'] = $order_link;
                                    $orders[] = $one_order;
                                 }
                                 wp_reset_postdata();
                              }
                           }
                           if (count($orders) > 0) {
                              foreach ($orders as $order) {
                                 $order_name = $order['name'];
                                 $order_image = $order['image'];
                                 $order_type = $order['type'] ?? "";
                                 $order_number = $order['number'] ?? 0;
                                 $order_status_text = $order['status_text'] ?? "";
                                 $order_total = $order['total'] ?? 0;
                                 $item_count = $order['item_count'] ?? 0;
                                 $products = $order['products'] ?? [];
                                 $order_link = $order['order_link'] ?? "";
                                 $create_date = $order['create_date'] ?? "";
                                 $woo_ua_auction_end_date_formatted = $order['woo_ua_auction_end_date_formatted'] ?? "";
                                 $uat_auction_lot_number = $order['uat_auction_lot_number'] ?? "";
                                 $uat_seller_name = $order['uat_seller_name'] ?? "";
                                 $auction_current_bid = $order['auction_current_bid'] ?? "";
                                 $get_payment_method_title = $order['get_payment_method_title'] ?? "";
                           ?>
                                 <div class="prod-box-rows">
                                    <div class="prod-box-left-img">
                                       <img src="<?php echo $order_image; ?>" alt="<?php echo $order_name; ?>" title="<?php echo $order_name; ?>">
                                       <?php if($item_count > 1){ 
                                          $other_iterm_count = $item_count-1; 
                                          $other_iterm_count =  sprintf(__('+%s products', 'ultimate-auction-pro-software'), $other_iterm_count);
                                          ?>
                                       <div class="left-fixed-product-count"><?php echo $other_iterm_count; ?></div>
                                       <?php } ?>
                                    </div>
                                    <div class="prod-box-Right-Content">
                                       <h4><?php echo $order_name; ?></h4>
                                       <div class="dl-info-row">
                                          <?php if (count($products) > 1) { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Total products', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo count($products); ?></h5>
                                             </div>
                                          <?php } ?>
                                          <?php if (!empty($uat_auction_lot_number)) { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Lot number', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $uat_auction_lot_number; ?></h5>
                                             </div>
                                          <?php } ?>
                                          <?php if (!empty($uat_seller_name)) { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Seller', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $uat_seller_name; ?></h5>
                                             </div>
                                          <?php } ?>
                                          <?php if (!empty($auction_current_bid)) { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Final bid', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo wc_price($auction_current_bid); ?></h5>
                                             </div>
                                          <?php } ?>
                                          <?php if (!empty($create_date) && !empty($order_number)) { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Order date', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $create_date; ?></h5>
                                             </div>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Order status', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $order_status_text; ?></h5>
                                             </div>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Payment method', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $get_payment_method_title; ?></h5>
                                             </div>
                                          <?php } else { ?>
                                             <div class="dil-infomation">
                                                <label><?php echo __('Date of auction', 'ultimate-auction-pro-software'); ?></label>
                                                <h5><?php echo $woo_ua_auction_end_date_formatted; ?></h5>
                                             </div>
                                          <?php } ?>
                                       </div>
                                       <div class="dl-btn-row">
                                          <?php echo $order_link; ?>
                                       </div>
                                    </div>
                                 </div>
                              <?php
                              }
                           } else {
                              $no_order_text =  sprintf(__('No %s orders found', 'ultimate-auction-pro-software'), 'paid');
                              if ($paid_active !=  'active') {
                                 $no_order_text =  sprintf(__('No %s orders found', 'ultimate-auction-pro-software'), 'unpaid');
                              }
                              ?>
                              <h4><?php echo $no_order_text; ?></h4>
                           <?php
                           }

                           ?>
                        </div>
                     </div>
                  </div>
            <?php
               }
            }
            ?>
         </div>
      </div>
   </div>
</div>
<?php wp_enqueue_script('uat-buyer-order', UAT_THEME_PRO_JS_URI . 'buyer/order.js', array('jquery'), UAT_THEME_PRO_VERSION); ?>