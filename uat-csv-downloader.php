<?php


// Add action hook only if action=download_csv
if ( isset($_GET['action'] ) && $_GET['action'] == 'uat_download_csv' )  {
	// Handle CSV Export
	add_action( 'admin_init', 'uat_auctions_download_csv');
}

function uat_auctions_download_csv() {
	global $wpdb,$sitepress;
	$table_name = UA_AUCTION_PRODUCT_TABLE;
	 $sitename = sanitize_key( get_bloginfo( 'name' ) );
    // Check for current user privileges
    if( !current_user_can( 'manage_options' ) ){ return false; }

    // Check if we are in WP-Admin
    if( !is_admin() ){ return false; }

    // Nonce Check
    $nonce = isset( $_GET['_wpnonce'] ) ? $_GET['_wpnonce'] : '';
    if ( ! wp_verify_nonce( $nonce, 'uat_download_csv' ) ) {
        die( 'Security check error' );
    }
    ob_clean(); // Clear the output buffer
    ob_start();
	if ( ! empty( $sitename ) )
		$sitename .= '.';
	$filename = $sitename . 'auctions.' . date( 'Y-m-d-H-i-s' ) . '.csv';
    $auction_status = isset( $_GET['auction-status'] ) ? $_GET['auction-status'] : 'uat_past';
    $auction_event = isset( $_REQUEST['auction-event'] ) ?  $_REQUEST['auction-event'] :"";
    $post_ids = isset( $_REQUEST['post_ids'] ) ?  $_REQUEST['post_ids'] :"";
    if($auction_status == 'uat_past')
    {
        $header_row = array(
            'Title',
            'SKU',
            'Content',
            'Event Title',
            'Order ID',
            'Start Date',
            'End Date',
            'Winner Name',
            'Winner Email',
            'Winner\'s max proxy bid',
            'Highest Bid',
            'Lowest Bid',
            'Final Bid Amount',
            'Earnings',
            'Status',
            'Expired Reason',
        );
    }else{
        $header_row = array(
            'Title',
            'SKU',
            'Content',
            'Event Title',
            'Start Date',
            'End Date',
            'Winner\'s max proxy bid',
            'Highest Bid',
            'Lowest Bid',
        );
    }
    $data_rows = array();
		$do_search = "";

		if (!empty($auction_status) && empty($auction_event)) {
		   $log_types_qry_where = " where auction_status ='".$auction_status."' ".$do_search;
		}
		elseif (!empty($auction_event) && empty($auction_status)){
			$log_types_qry_where=" where event_id ='".$auction_event."'  ".$do_search;
		}
		elseif (!empty($auction_event) && !empty($auction_status)) {
			$log_types_qry_where=" where auction_status ='".$auction_status."' and event_id ='".$auction_event."'  ".$do_search;
		} else {
			$log_types_qry_where = "";		}

		$from =isset( $_GET['DateFrom'] ) ? $_GET['DateFrom'] : '';
		$to = isset( $_GET['DateTo'] ) ? $_GET['DateTo'] : '';
		 if( !($from=='' && $to=='') ){
			$log_types_qry_where = $log_types_qry_where."  AND (auction_end_date  BETWEEN '$from' AND '$to')";
		 }
         if (!empty($post_ids) && $post_ids != "all") {
            $log_types_qry_where = " where post_id IN (".$post_ids.")";
         }

	$sql = "SELECT * FROM $table_name $log_types_qry_where ORDER BY post_id desc";
    $a_products = $wpdb->get_results( $sql, 'ARRAY_A' );
    foreach ( $a_products as $a_product ) {
        $auction_ID =  $a_product['post_id'];
        if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
            $auction_ID = icl_object_id($auction_ID,'product',false, $sitepress->get_default_language());
        }
        $product = wc_get_product( $auction_ID );
        $sku = $product->get_sku();
        $orderid = "N/A";
        $winner_proxy_bid = "";
        $status = "Unsold";
        $expired_reason = $product->get_uwa_auction_expired();
        $get_uwa_auction_fail_reason = $product->get_uwa_auction_fail_reason();
        $expired_reason_text = "";
			$event_title ="N/A";
			if(!empty($a_product['event_id']) && $a_product['event_id']!=0){
			   $event_title = get_the_title( $a_product['event_id'] );
			}
			$highest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
			$Highest_Bid = $highest_bid;
			$lowest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` asc limit 1' );
			$Lowest_Bid = $lowest_bid;
		    $Final_Bid = $Highest_Bid;
		    $Earnings = $Highest_Bid;
			$userid = $wpdb->get_var( 'SELECT userid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
			$winner_name = "";
			$winner_email = "";
			if(!empty($userid)) {
			$user = get_user_by('ID', $userid);
				$winner_name = $user->data->display_name;
				$winner_email = $user->data->user_email;
			}
            if($expired_reason == '1'){
                $expired_reason_text = "No bid";
                if($get_uwa_auction_fail_reason == '2'){
                    $expired_reason_text = "Reserve Price No Met";
                }
            }else{
                $orderid = $product->get_uwa_order_id();
                $winner_proxy_bid = $product->get_uwa_auction_current_bid();
                // $expired_reason_text = "Has Winner";
                $status = "Sold";
            }
            if($auction_status == 'uat_past')
            {
                $row = array(
                    $a_product['auction_name'],
                    $sku,
                    $a_product['auction_content'],
                    $event_title,
                    $orderid,
                    $a_product['auction_start_date'],
                    $a_product['auction_end_date'],
                    $winner_name,
                    $winner_email,
                    $winner_proxy_bid,
                    $Highest_Bid,
                    $Lowest_Bid,
                    $Final_Bid,
                    $Earnings,
                    $status,
                    $expired_reason_text,
                );
            }else{
                $row = array(
                    $a_product['auction_name'],
                    $sku,
                    $a_product['auction_content'],
                    $event_title,
                    $a_product['auction_start_date'],
                    $a_product['auction_end_date'],
                    $winner_proxy_bid,
                    $Highest_Bid,
                    $Lowest_Bid,
                );
            }
        $data_rows[] = $row;
    }
    $fh = @fopen( 'php://output', 'w' );
    //fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
    header( 'Content-Description: File Transfer' );
    header( 'Content-type: text/csv' );
    header( "Content-Disposition: attachment; filename={$filename}" );
    header( 'Expires: 0' );
    header( 'Pragma: public' );
    fputcsv( $fh, $header_row );
    foreach ( $data_rows as $data_row ) {
        fputcsv( $fh, $data_row );
    }
    fclose( $fh );

    ob_end_flush();

    die();
}


// Add action hook only if action=download_csv
if (isset($_GET['action']) && $_GET['action'] == 'uat_report_csv') {
    // Handle CSV Export
    add_action('admin_init', 'uat_auctions_uat_report_csv_csv');
}

function uat_auctions_uat_report_csv_csv()
{

    // Check for current user privileges
    if (!current_user_can('manage_options')) {
        return false;
    }

    // Check if we are in WP-Admin
    if (!is_admin()) {
        return false;
    }
    ob_clean(); // Clear the output buffer
    ob_start();

    $sitename = sanitize_key(get_bloginfo('name'));
    if (!empty($sitename)) {
        $sitename .= '.';
    }

    $filename = $sitename . 'auctions.report' . date('Y-m-d-H-i-s') . '.csv';

    $data_rows = array();


    global $wpdb;
    $reporttab = "";
    if (!empty($_GET['uat-report-tab'])) {
        $reporttab = $_GET['uat-report-tab'];
    }
    $page = "";
    if (!empty($_GET['page'])) {
        $page = $_GET['page'];
    }
    $range = "";
    if (!empty($_GET['range'])) {
        $range = $_GET['range'];
    }

    if (!empty($reporttab) && $reporttab == 'uat-report-report' &&  !empty($page) && $page == 'ua-auctions-reports' &&  !empty($range)) {


        $today_date = date('Y-m-d');

        $start_date = $today_date;
        $end_date =  $today_date;

        if ($range == 'year') {
            $end_date = date("Y-m-d", strtotime('-1 year', strtotime($today_date)));
        } else if ($range == 'last_month') {

            $query_date = date('Y-m-d', strtotime($start_date . " -1 month"));


            $start_date =  date('Y-m-t', strtotime($query_date));

            $end_date = date('Y-m-01', strtotime($query_date));
        } else if ($range == 'month') {

            $query_date = $start_date;


            $start_date =  date('Y-m-t', strtotime($query_date));


            $end_date =  date('Y-m-01', strtotime($query_date));
        } else if ($range == '7day') {

            $query_date = $start_date;


            $start_date = date('Y-m-d');


            $end_date =  date('Y-m-d', strtotime('-7 days'));
        } else if ($range == 'custom') {

            $setstartdate = "";
            if (!empty($_REQUEST['start_date'])) {
                $setstartdate = $_REQUEST['start_date'];
            }
            $setenddate = "";
            if (!empty($_REQUEST['end_date'])) {
                $setenddate = $_REQUEST['end_date'];
            }




            $start_date = $setenddate;


            $end_date = $setstartdate;
        }


        $args = array(
            'status' => array('wc-completed'),
            'date_paid' => $end_date . '...' . $start_date

        );
        // print_r($args);
        $orders = wc_get_orders($args);
        echo '<pre>';
        $totlaamount = 0;
        $totlaamount_arr = array();
        $total_tax = 0;
        $total_tax_arr = array();

        $total_no_of_bid = array();
        $csv_data_arr = array();

        foreach ($orders as $oval) {
            $order_id = $oval->get_id();
            $customer_id = $oval->get_customer_id();
            //print_r($oval);

            $order = wc_get_order($order_id);
            $items = $order->get_items();

            foreach ($items as $item) {
                $product_name = $item->get_name();
                $product_id = $item->get_product_id();


                $query   = "SELECT * FROM `wp_woo_ua_auction_log` WHERE `auction_id` = $product_id ORDER BY `userid` ASC";
                $results = $wpdb->get_results($query);

                foreach ($results as $row) {

                    $total_no_of_bid[] = $row->bid;
                    $csv_row_data = array();
                    $csv_row_data['product_name'] =  $product_name;
                    $csv_row_data['bid'] =  $row->bid;
                    $csv_data_arr[] = $csv_row_data;
                }
            }
        }
    }


    $fh = @fopen('php://output', 'w');
    //fprintf( $fh, chr(0xEF) . chr(0xBB) . chr(0xBF) );
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Content-Description: File Transfer');
    header('Content-type: text/csv');
    header("Content-Disposition: attachment; filename={$filename}");
    header('Expires: 0');
    header('Pragma: public');
    fputcsv($fh, $header_row);
    foreach ($csv_data_arr as $data_row) {
        fputcsv($fh, $data_row);
    }
    fclose($fh);

    ob_end_flush();

    die();
}
add_action('wp_ajax_nopriv_uat_auctions_uat_report_csv_csv', 'uat_auctions_uat_report_csv_csv');
add_action('wp_ajax_uat_auctions_uat_report_csv_csv', 'uat_auctions_uat_report_csv_csv');