<?php

/**
 * Order details
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-details.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.2
 */

defined('ABSPATH') || exit;

$order = wc_get_order($order_id); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

if (!$order) {
    return;
}
$order_items           = $order->get_items(apply_filters('woocommerce_purchase_order_item_types', 'line_item'));
$show_purchase_note    = $order->has_status(apply_filters('woocommerce_purchase_note_order_statuses', array('completed', 'processing')));
$show_customer_details = is_user_logged_in() && $order->get_user_id() === get_current_user_id();
$user_id = get_current_user_id();
$downloads             = $order->get_downloadable_items();
$show_downloads        = $order->has_downloadable_item() && $order->is_download_permitted();
$payment_date = $order->get_date_paid();
if (!empty($payment_date)) {
    $payment_date = $payment_date->format(wc_date_format());
}
if (count($order_items) == 0) {
    $payment_date = wc_format_datetime($order->get_date_created());
}
$order_status = $order->get_status();
$order_status_text = wc_get_order_status_name($order->get_status());


$uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
$uat_send_first_last_name = get_option( 'options_uat_send_first_last_name',"0" );
$uat_send_mailing_address = get_option( 'options_uat_send_mailing_address',"0" );
$uat_send_phone_mobile_number = get_option( 'options_uat_send_phone_mobile_number',"0" );
$uat_send_seller_address = get_option( 'options_uat_send_seller_address',"0" );
$uat_do_you_want_to_send_information_via_email = get_option( 'options_uat_do_you_want_to_send_information_via_email',"0" );
$uat_only_show_when_buyers_commission_debited = get_option( 'options_uat_only_show_when_buyers_commission_has_been_automatically_debited',"0" );
$uat_show_seller_details_product_page = get_option( 'options_uat_buyer_and_seller_to_view_each_others_information_on_the_product_page',"0" );
$uat_message_for_winner = get_option( 'options_uat_message_for_winner',"0" );
$seller_name = '';
$seller_email = '';
$seller_phone = '';
$seller_address = '';
$bp_status = 'open';


?>
<section class="order-details-page">
    <div class="container">
        <!-- <div class="page-heading">
            <span>From Australia to New York</span>
            <h1>Your order was delivered</h1>
        </div>
        <div class="delivered-block">
            <div class="dilver-on">
            delivered on
            </div>
            <h4>
                <svg fill="#000000" width="25px" height="25px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M15.17 7.36 13 4.92a1.25 1.25 0 0 0-.94-.42h-2V2.75A1.25 1.25 0 0 0 8.82 1.5H1.76A1.25 1.25 0 0 0 .51 2.75v8.5a1.25 1.25 0 0 0 1.25 1.25h.33a2.07 2.07 0 0 0 2.13 2 2.08 2.08 0 0 0 2.14-2H10a2.07 2.07 0 0 0 2.13 2 2.08 2.08 0 0 0 2.14-2 1.26 1.26 0 0 0 1.2-1.25V8.19a1.22 1.22 0 0 0-.3-.83zM4.22 13.25a.82.82 0 0 1-.88-.75.82.82 0 0 1 .88-.75.83.83 0 0 1 .89.75.83.83 0 0 1-.89.75zm4.6-7.58v5.58H5.89a2.17 2.17 0 0 0-1.67-.75 2.17 2.17 0 0 0-1.66.75h-.8v-8.5h7.06zm1.25.08h2l1.44 1.63h-3.44zm2.08 7.5a.82.82 0 0 1-.88-.75.82.82 0 0 1 .88-.75.83.83 0 0 1 .89.75.83.83 0 0 1-.89.75zm0-2.75a2.17 2.17 0 0 0-1.66.75h-.42V8.62h4.17v2.63h-.42a2.17 2.17 0 0 0-1.67-.75z"></path></g></svg>
                Wednesday, 4 may 2023</h4>
            <a href="" class="getsupportlink">Get Support</a>
        </div> -->
        <div class="hor-line"></div>

        <div class="order-sold-details">
            <h3><?php echo  __('object', 'ultimate-auction-pro-software'); ?></h3>
            <!-- <small>Sold by : Germania inferiar numismatics (GIN)</small> -->
            <div class="number-copy">
                <p id="copy_textarea"><?php echo  __('Order no.', 'ultimate-auction-pro-software') . " : " . $order_id; ?> </p>
                <button data-clipboard-text="<?php echo $order_id; ?>" class="copy-icon" type="button" id="copy_button">
                    <svg width="30px" height="25px" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_iconCarrier">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5 16.5L19.5 4.5L18.75 3.75H9L8.25 4.5L8.25 7.5L5.25 7.5L4.5 8.25V20.25L5.25 21H15L15.75 20.25V17.25H18.75L19.5 16.5ZM15.75 15.75L15.75 8.25L15 7.5L9.75 7.5V5.25L18 5.25V15.75H15.75ZM6 9L14.25 9L14.25 19.5L6 19.5L6 9Z" fill="var(--wp--custom-primary-link-color)"></path>
                        </g>
                    </svg>
                    <span class="" id="copy_tooltip" aria-live="assertive" role="tooltip"><?php echo  __('Copyed', 'ultimate-auction-pro-software'); ?></span>
                </button>
            </div>
            <div class="number-copy">
                <p id="copy_textarea"><?php echo  __('Order status', 'ultimate-auction-pro-software') . " : " . $order_status_text; ?> </p>
            </div>
        </div>
        <div class="product-list-sec ">
            <div class="pro-list-row">
                <?php
                foreach ($order_items as $item_id => $item) {
                    $product = $item->get_product();
                    try {
                    $product_id = $product->get_id();

                    $product_view_url = $product->get_permalink();
                    $thumbnail_url = wc_placeholder_img_src();
                    $uat_seller_name = "";
                    $type = 'normal';
                    if ($product instanceof WC_Product_Auction) {
                        $type = 'auction';
                        $uat_seller_name = $product->get_seller_name();
                    }
                    $thumbnail_url_main = wp_get_attachment_image_url(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
                    if (!empty($thumbnail_url_main)) {
                        $thumbnail_url = $thumbnail_url_main;
                    }
                    $uat_auction_lot_number = get_post_meta($product_id, 'uat_auction_lot_number', true);
                    $woo_ua_auction_end_date_formatted = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
                    if (!empty($woo_ua_auction_end_date_formatted)) {
                        $woo_ua_auction_end_date_formatted = strtotime($woo_ua_auction_end_date_formatted);
                        $woo_ua_auction_end_date_formatted = date('D, j M Y', $woo_ua_auction_end_date_formatted);
                    }
                    $delivery_status = get_post_meta($product_id, 'delivery_status', true);
                ?>
                    <div class="prod-box-rows">
                        <div class="prod-box-left-img uat-order-left-img">
                            <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $product->get_name(); ?>" title="<?php echo $product->get_name(); ?>">
                        </div>
                        <div class="prod-box-Right-Content">
                            <h4><?php echo $product->get_name(); ?></h4>
                            <div class="dl-info-row">
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
                                <div class="dil-infomation">
                                    <label><?php echo ($type == 'auction') ? __('Final bid', 'ultimate-auction-pro-software') : __('Price', 'ultimate-auction-pro-software'); ?></label>
                                    <h5><?php echo $order->get_formatted_line_subtotal($item); ?></h5>
                                </div>

                                <?php if (!empty($woo_ua_auction_end_date_formatted)) { ?>
                                    <div class="dil-infomation">
                                        <label><?php echo __('Date of auction', 'ultimate-auction-pro-software'); ?></label>
                                        <h5><?php echo $woo_ua_auction_end_date_formatted; ?></h5>
                                    </div>
                                <?php } ?>
                                <?php if (!empty($payment_date)) { ?>
                                    <div class="dil-infomation">
                                        <label><?php echo __('Order date', 'ultimate-auction-pro-software'); ?></label>
                                        <h5><?php echo $payment_date; ?></h5>
                                    </div>
                                <?php }  ?>
                                <?php if ($uat_enable_offline_dealing_for_buyer_seller=='1') { ?>
                                    <div class="full-row-text">
                                    <?php 
                                        if($uat_only_show_when_buyers_commission_debited=='1'){
                                            global $wpdb;
                                            $query_bp = "SELECT `status` FROM `".$wpdb->prefix."auction_direct_payment` WHERE uid=".$user_id." AND pid=".$product_id." AND debit_type='buyers_premium'";
                                            $results_bp = $wpdb->get_results($query_bp);
                                            if(!empty($results_bp)){
                                                $status_bp = $results_bp[0]->status;
                                                if($status_bp == 'succeeded'){  
                                                    $bp_status = 'succeeded';  
                                                  }else{  
                                                    $bp_status = 'failed';  
                                                }
                                            }
                                        }
                                    ?>
                                
                               
                                <?php if($bp_status != 'failed' || $uat_only_show_when_buyers_commission_debited=='0'){ ?>
                                    
                                    <?php if(!empty(get_field('auction_seller_name', $product_id))||!empty(get_field('seller_email_id', $product_id)) || !empty(get_field('seller_phone_number', $product_id)) || !empty(get_field('contact_details', $product_id)) ){ ?>

                                        <h4><?php echo __('Seller Detail', 'ultimate-auction-pro-software'); ?></h4>
                                    
                                    <?php } ?>

                                    <?php if($uat_send_first_last_name=='1' && !empty(get_field('auction_seller_name', $product_id))): ?>

                                        <label><?php echo __("Name:", 'ultimate-auction-pro-software'); ?></label>
                                        <h5 class="woocommerce-seller-name"><?php echo get_field('auction_seller_name', $product_id); ?></h5>

                                    <?php endif; ?>

                                    <?php if($uat_send_mailing_address=='1' && !empty(get_field('seller_email_id', $product_id))): ?>

                                        <label><?php echo __("Email ID:", 'ultimate-auction-pro-software'); ?></label>
                                        <h5 class="woocommerce-seller-email-id"><?php echo get_field('seller_email_id', $product_id); ?></h5>

                                    <?php endif; ?>

                                    <?php if($uat_send_phone_mobile_number=='1' && !empty(get_field('seller_phone_number', $product_id))): ?>
                                    
                                        <label><?php echo __("Phone:", 'ultimate-auction-pro-software'); ?></label>
                                        <h5 class="woocommerce-seller-phone-number"><?php echo get_field('seller_phone_number', $product_id); ?></h5>
                                        
                                    <?php endif; ?>

                                    <?php if($uat_send_seller_address=='1' && !empty(get_field('contact_details', $product_id))): ?>
                                        
                                        <label><?php echo __("Location:", 'ultimate-auction-pro-software'); ?></label>
                                        <h5 class="woocommerce-contact-details"><?php echo get_field('contact_details', $product_id); ?></h5>
                                        
                                    <?php endif; ?>

                                <?php } ?>
                                </div>
                                <?php }  ?>





                            </div>
                            <?php if (!empty($delivery_status)) { ?>
                                <div class="diliverd-text">
                                    <h6>
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#11a88a" style="position: relative;top: 4px;margin-right: 5px;width: 16px;">
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 3C1.34315 3 0 4.34315 0 6V15C0 16.3121 0.842366 17.4275 2.01581 17.8348C2.18436 19.6108 3.67994 21 5.5 21C7.26324 21 8.72194 19.6961 8.96456 18H15.0354C15.2781 19.6961 16.7368 21 18.5 21C20.3201 21 21.8156 19.6108 21.9842 17.8348C23.1576 17.4275 24 16.3121 24 15V10.7515C24 10.0248 23.7362 9.32283 23.2577 8.77596L20.8502 6.02449C20.2805 5.37344 19.4576 5 18.5925 5H16.8293C16.4175 3.83481 15.3062 3 14 3H3ZM4 17.4361V17.5639C4.03348 18.3634 4.69224 19.0013 5.5 19.0013C6.30776 19.0013 6.96652 18.3634 7 17.5639V17.4361C6.96652 16.6366 6.30776 15.9987 5.5 15.9987C4.69224 15.9987 4.03348 16.6366 4 17.4361ZM5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H15.3368C15.8985 14.8175 17.1038 14 18.5 14C19.8245 14 20.9771 14.7357 21.5716 15.8207C21.8306 15.64 22 15.3398 22 15V11H17C15.8954 11 15 10.1046 15 9V6C15 5.44772 14.5523 5 14 5H3C2.44772 5 2 5.44772 2 6V15C2 15.3398 2.16945 15.64 2.42845 15.8207C3.02292 14.7357 4.17555 14 5.5 14ZM17 7V8C17 8.55229 17.4477 9 18 9H20.7962L19.345 7.34149C19.1552 7.12448 18.8808 7 18.5925 7H17ZM17 17.4361V17.5639C17.0335 18.3634 17.6922 19.0013 18.5 19.0013C19.3078 19.0013 19.9665 18.3634 20 17.5639V17.4361C19.9665 16.6366 19.3078 15.9987 18.5 15.9987C17.6922 15.9987 17.0335 16.6366 17 17.4361Z" fill="#0F0F0F"></path>
                                            </g>
                                        </svg>
                                        <?php echo $delivery_status; ?>
                                    </h6>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                } catch (\Throwable $th) {
                    //throw $th;
                }
                }

                ?>

            </div>
        </div>

        <div class="details-row">
            <div class="col-3 headings">
                <h2><?php echo __('Address', 'ultimate-auction-pro-software'); ?></h2>
            </div>
            <div class="col-3">
            </div>
            <div class="col-6 right">
                <?php
                /**
                 * Action hook fired after the order details.
                 *
                 * @since 4.4.0
                 * @param WC_Order $order Order data.
                 */
                do_action('woocommerce_after_order_details', $order);

                if ($show_customer_details) {
                    wc_get_template('order/order-details-customer.php', array('order' => $order));
                }

                ?>
                <!-- <h6><a href="#">Track your order</a></h6> -->
            </div>
        </div>


        <div class="hor-line"></div>
        <!-- <div class="details-row">
            <div class="col-3 headings">
                <h2>Seller</h2>
            </div>
            <div class="col-3">
                <h6>Name</h6>
                <h5 class="mr-top-15">Germania inferior Numismatics (GIN)</h5>
                <a class="small-blue-link" href="#">See seller profile</a>
            </div>
        </div> -->
        <!-- <div class="hor-line"></div> -->
        <div class="details-row">
            <div class="col-3 headings">
                <h2 class="woocommerce-order-details__title"><?php esc_html_e('Order details', 'woocommerce'); ?></h2>
            </div>
            <div class="col-6">
                <?php if (!empty($payment_date)) { ?>
                    <h6><?php echo  __('Payment date', 'ultimate-auction-pro-software'); ?></h6>
                    <h5><?php echo $payment_date; ?></h5>
                <?php } ?>
                <!-- <p><strong>Total</strong></p>
                                    <p><strong>$ 114.00</strong></p> -->
                <?php
                if ($show_downloads) {
                    wc_get_template(
                        'order/order-downloads.php',
                        array(
                            'downloads'  => $downloads,
                            'show_title' => true,
                        )
                    );
                }
                ?>
                <section class="woocommerce-order-details">
                    <?php do_action('woocommerce_order_details_before_order_table', $order); ?>
                    <table class="woocommerce-table woocommerce-table--order-details shop_table order_details">
                        <thead>
                            <tr>
                                <th class="woocommerce-table__product-name product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                                <th class="woocommerce-table__product-table product-total"><?php esc_html_e('Total', 'woocommerce'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            do_action('woocommerce_order_details_before_order_table_items', $order);
                            foreach ($order_items as $item_id => $item) {
                                $product = $item->get_product();

                                wc_get_template(
                                    'order/order-details-item.php',
                                    array(
                                        'order'              => $order,
                                        'item_id'            => $item_id,
                                        'item'               => $item,
                                        'show_purchase_note' => $show_purchase_note,
                                        'purchase_note'      => $product ? $product->get_purchase_note() : '',
                                        'product'            => $product,
                                    )
                                );
                            }
                            do_action('woocommerce_order_details_after_order_table_items', $order);
                            ?>
                        </tbody>
                        <tfoot>
                            <?php
                            foreach ($order->get_order_item_totals() as $key => $total) {
                            ?>
                                <tr>
                                    <th scope="row"><?php echo esc_html($total['label']); ?></th>
                                    <td><?php echo wp_kses_post($total['value']); ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                            <?php if ($order->get_customer_note()) : ?>
                                <tr>
                                    <th><?php esc_html_e('Note:', 'woocommerce'); ?></th>
                                    <td><?php echo wp_kses_post(nl2br(wptexturize($order->get_customer_note()))); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tfoot>
                    </table>
                    <?php do_action('woocommerce_order_details_after_order_table', $order); ?>
                </section>
            </div>
            <!-- <div class="col-3 right">
                <h6><a href="#">Receipt & invoices </a></h6>
            </div> -->
        </div>
    </div>
</section>
<?php wp_enqueue_script('uat-buyer-order', UAT_THEME_PRO_JS_URI . 'buyer/order.js', array('jquery'), UAT_THEME_PRO_VERSION); ?>