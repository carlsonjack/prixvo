<?php
global $UATS_options, $paged, $wpdb;
$records_per_page = $UATS_options['seller_p_list_per_page'] ?? 12;
$products_table_html = "";
// Get current user ID
$current_user_id = get_current_user_id();
$user = get_user_by('ID', $current_user_id);
$is_admin = false;
if (current_user_can('manage_options')) {
    $is_admin = true;
}
 $current_page = $paged ?? get_query_var('paged');
 $current_page = $current_page??1;

$search_term = "";
// Get the search parameter 'ds' from the URL
$search_term = isset($_GET['ds']) ? sanitize_text_field($_GET['ds']) : '';
// Calculate the offset for the SQL query
if($current_page > 0){
    $offset = ($current_page - 1) * $records_per_page;
}else{
    $offset = 0;
}
// Query your custom table with the search condition
$table_name = $wpdb->prefix . 'auction_seller_payment'; // Replace with your table name
// Create the SQL query with the search condition
$query = $wpdb->prepare(
    "SELECT * FROM $table_name WHERE seller_id = %d",
    $current_user_id
);
if (!empty($search_term)) {
    $query .= $wpdb->prepare(" AND order_id LIKE %s", '%' . $wpdb->esc_like($search_term) . '%');
}
$query .= " ORDER BY updated_at DESC LIMIT $offset, $records_per_page";
// Count the total number of records with the search condition
if (!empty($search_term)) {
    $total_records = $wpdb->get_results($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE seller_id = ".$current_user_id." AND order_id LIKE '%%%s%%' ORDER BY updated_at DESC", $search_term));
    $total_records = count($total_records);
} else {
    $total_records = $wpdb->get_results("SELECT COUNT(*) FROM $table_name WHERE seller_id = ".$current_user_id." GROUP BY order_id");
    $total_records = count($total_records);

}
// Calculate the total number of pages
$total_pages = ceil($total_records / $records_per_page);

$products_table_html .= '<td class="action-box">No payments found.</td>';

// Get custom product statuses
$page_no = $paged ?? get_query_var('paged');

$payments = $wpdb->get_results($query);
$payments_list = [];

if (count($payments) > 0) {
    foreach ($payments as $payment) {

        $order_id = $payment->order_id;
        $product_id = $payment->product_id;
        $transaction_amount = $payment->transaction_amount;
        $date = $payment->updated_at;
        $product_id = $payment->product_id;
        if (isset($payments_list[$order_id])) {
            $payment_deta = $payments_list[$order_id];
            $payment_deta['product_ids'][] = $product_id;
            $payment_deta['products_count'] = $payment_deta['products_count'] + 1;
            $payment_deta['amount'] = $payment_deta['amount'] + $payment->transaction_amount;
            $payment_deta['paid_date'] = $date;
            $payments_list[$order_id] = $payment_deta;
        } else {
            $payment_deta = [];
            $payment_deta['product_ids'][] = $product_id;
            $payment_deta['order_id'] = $order_id;
            $payment_deta['products_count'] = 1;
            $payment_deta['amount'] = $payment->transaction_amount;
            $payment_deta['paid_date'] = $date;
            $payments_list[$order_id] = $payment_deta;
        }
    }
    if (!empty($payments_list)) {
        $products_table_html = "";
        $uat_enable_offline_dealing = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
    
        foreach ($payments_list as $order_id => $order_data) {
            $timestamp = strtotime($order_data['paid_date']);
            $date = date(wc_date_format(), $timestamp);
            $products_count = $order_data['products_count'];
            $amount = $order_data['amount'];
          
            if( $uat_enable_offline_dealing != '1'){
                $action_buttons = '<div class="reciept-links"><a href="#" class="export" data-order-id="' . esc_html($order_id) . '">' . __('Export', 'ultimate-auction-pro-software') . '</a></div>';
            }
            $products_table_html .= ' <tr>
                                                <td class="order-no"><div class="reciept-links"><a href="#" class="export" data-order-id="' . esc_html($order_id) . '">' . esc_html($order_id) . '</a></div></td>
                                                <td class="paid-date">' . esc_html($date) . '</td>
                                                <td class="no-of-products">' . esc_html($products_count) . '</td>
                                                <td class="amount-box">' . wc_price($amount) . '</td>';
            if (check_invoice_plugin_active()) {
                $products_table_html .=  '<td class="action-box">' . $action_buttons . ' </td>';
            }
            $products_table_html .=  '</tr>';
        }
    }
}
wp_reset_postdata(); // Reset post data
?>
<div class="salse_tab-content">
    <div class="page-heading">
        <h1><?php echo __('Payments', 'ultimate-auction-pro-software'); ?></h1>
    </div>
    <div class="tab_con_box">
        <div class="tab_con_box-full">
            <div class="search_and_filter">
                <div class="search_bl">
                    <form name="product-search-filter" id="product-search-filter" method="get">

                        <input type="text" class="form-control" placeholder="<?php echo __('Search here', 'ultimate-auction-pro-software'); ?>" name="ds" id="search-auction" value="<?php echo $search_term; ?>">
                        <button class="search-btn" type="submit"></button>
                    </form>
                </div>
            </div>
            <div class="product_data">
                <table>
                    <tr>
                        <th class="order-no"><?php echo __('Order number', 'ultimate-auction-pro-software'); ?></th>
                        <th class="paid-date"><?php echo __('Paid on', 'ultimate-auction-pro-software'); ?></th>
                        <th class="no-of-products"><?php echo __('Number of products', 'ultimate-auction-pro-software'); ?></th>
                        <th class="amount-box"><?php echo __('Amount', 'ultimate-auction-pro-software'); ?></th>
                        <?php if (check_invoice_plugin_active()) { ?>
                        <th class="action-box"><?php echo __('Report', 'ultimate-auction-pro-software'); ?></th>
                        <?php } ?>
                    </tr>
                    <?php echo $products_table_html ?>
                </table>
                <?php
                // Display pagination links
                echo '<div class="pagination">';
                echo paginate_links(array(
                    // 'base' => add_query_arg(array('page' => $current_page, 'ds' => $search_term)),
                    // 'format' => '',
                    // 'prev_text' => '&laquo; Previous',
                    // 'next_text' => 'Next &raquo;',
                    'total' => $total_pages,
                    'current' => max(1, $current_page),
                ));
                echo '</div>';
                ?>
            </div>
        </div>
    </div>