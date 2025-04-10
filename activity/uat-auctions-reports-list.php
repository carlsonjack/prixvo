<?php
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
wp_register_style('jquery-ui', UAT_THEME_PRO_CSS_URI . 'jquery-ui.css', array(), UAT_THEME_PRO_VERSION);
wp_enqueue_style('jquery-ui');
?>
<ul class="subsubsub">
    <?php  /*
    <li>
        <a href="admin.php?page=ua-auctions-reports&uat-report-tab=uat-report-report&-report-typuate=product">Earning
            for
            Auction product </a> |
        <a href="admin.php?page=ua-auctions-reports&uat-report-tab=uat-report-report&uat-report-type=event"
            class="current">Earning for Event Auction product </a>
    </li>
*/ ?>
    <?php
    $uat_default_tab = array(
        array('range' => 'year', 'slug' => 'products', 'label' => __('Product (without Event)', 'ultimate-auction-pro-software')),
        array('range' => 'year', 'slug' => 'events', 'label' => __('Events', 'ultimate-auction-pro-software'))
    );
    $active_tab = isset($_GET['uat-report-type']) ? $_GET['uat-report-type'] : 'products';
    foreach ($uat_default_tab as $tab) { ?>
    <li><a href="?page=ua-auctions-reports&uat-report-tab=uat-report-report&uat-report-type=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>&amp;uat-report-type=products"
            class="  <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label']; ?></a>
    </li>
    <?php } ?>
</ul>
<?PHP
global $wpdb;
$report_type = "";
if (!empty($_GET['uat-report-type'])) {
    $report_type = $_GET['uat-report-type'];
}
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
?>

<?php 
 
if (!empty($report_type) && $report_type == 'products') {  ?>

<?php
 
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
	 
    $totlaamount = 0;
    $totlaamount_arr = array();
    $total_tax = 0;
    $total_tax_arr = array();
    $total_no_of_bid = array();
    $csv_data_arr = array();
    $graph_date = array();
    $graph_value = array();
	$buy_now_earning = 0;
	$query   = new WC_Order_Query( array(
        'limit'      => 100000,
        'orderby'    => 'date',
        'order'      => 'DESC',
        'return'     => 'ids',
    ) );
    $orders  = $query->get_orders();
    $completed_dates = array();
    foreach ( $orders as $oval ) {
        $order                       = wc_get_order( $oval );
		$get_status=$order->get_status();
		if($get_status=='completed'){
			$date_completed=$order->get_date_completed();
			$order_date=$date_completed->date("Y-m-d");
			if($order_date>= $end_date && $order_date<=$start_date){
	  $order_id = $order->get_id();
        $customer_id = $order->get_customer_id();
        $order = wc_get_order($order_id);
        $items = $order->get_items();
        foreach ($items as $item) {
            $product_name = $item->get_name();
            $product_id = $item->get_product_id();
			$product = wc_get_product($product_id);
            $query   = "SELECT * FROM `wp_woo_ua_auction_log` WHERE `auction_id` = $product_id ORDER BY `userid` ASC";
            $results = $wpdb->get_results($query);
            foreach ($results as $row) {
                $graph_date[] = $row->date;
                $graph_value[] = $row->bid;
                $total_no_of_bid[] = $row->bid;
                $csv_row_data = array();
                $csv_row_data['product_name'] =  $product_name;
                $csv_row_data['bid'] =  $row->bid;
                $csv_data_arr[] = $csv_row_data;
            }
			$woo_ua_buy_now=get_post_meta( $product_id, 'woo_ua_buy_now', true );
			if(!empty($woo_ua_buy_now) && $woo_ua_buy_now==1){
				  $buy_now_earning +=$product->get_regular_price();
			}	
        }
        /*
		$product_id = $oval->get_id();
		$product = wc_get_product($product_id);
		if ($product->get_type() == "auction") {*/
        $order->get_id() . '<br>'; // The order ID
        $order->get_status() . '<br>'; // The order status
        $order->get_total() . '<br>'; // The order status
        $totlaamount_arr[] = $order->get_total();
        $total_tax_arr[] = $order->get_total_tax();
        $totlaamount += $order->get_total();
        $total_tax += $order->get_total_tax();
        //}
			}
		}
	}
    /*foreach ($orders as $oval) {
      }*/
    sort($total_no_of_bid);
    $count = count($total_no_of_bid);
    $total_tax; ?>
<br class="clear">
<div id="poststuff" class="woocommerce-reports-wide">
    <div class="postbox">
        <div class="stats_range">
            <a class="export_csv" href="<?php echo $actual_link; ?>&export_csv=1&action=uat_report_csv"
                data-export="chart" data-xaxes="Date" data-exclude_series="2" data-groupby="day">
                <?php _e( 'Export CSV', 'ultimate-auction-pro-software' ); ?> </a>
            <ul>
			
			 
                <li class="<?php if ($range == 'year') {  echo 'active'; } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=year&amp;uat-report-type=products"><?php _e( 'Year', 'ultimate-auction-pro-software' ); ?></a>
                </li>
				
                <li class="<?php if ($range == 'last_month') {  echo 'active'; } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=last_month&amp;uat-report-type=products"><?php _e( 'Last month', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                 <li class="<?php if ($range == 'month') {  echo 'active'; } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=month&amp;uat-report-type=products"><?php _e( 'This month', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="<?php if ($range == '7day') {  echo 'active'; } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=7day&amp;uat-report-type=products"><?php _e( 'Last 7 days', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="custom <?php if ($range == 'custom') {  echo 'active'; } ?>">
                <?php _e( 'Custom', 'ultimate-auction-pro-software' ); ?>:
                    <form method="GET">
                        <div>
                            <input type="hidden" name="page" value="ua-auctions-reports">
                            <input type="hidden" name="uat-report-tab" value="uat-report-report">
                            <input type="hidden" name="range" value="month"> <input type="hidden" name="range"
                                value="custom">
                            <input type="text" size="11" placeholder="yyyy-mm-dd" value="" name="start_date"
                                class=" example-datepicker" autocomplete="off" id="dp1618225145177">
                            <span>–</span>
                            <input type="text" size="11" placeholder="yyyy-mm-dd" value="" name="end_date"
                                class="  example-datepicker" autocomplete="off" id="dp1618225145178"> <button
                                type="submit" class="button" value="Go">Go</button>
                            <input type="hidden" id="wc_reports_nonce" name="wc_reports_nonce" value="2d084e5239">
                            <input type="hidden" id="uat-report-type" name="uat-report-type" value="products">
                        </div>
                        <script>
                        jQuery(window).load(function() {
                            jQuery('.example-datepicker').datepicker({
                                dateFormat: 'yy-mm-dd'
                            });
                        });
                        </script>
                    </form>
                </li>
            </ul>
        </div>
        <div class="inside chart-with-sidebar">
            <div class="chart-sidebar">
                <ul class="chart-legend">
                    <?php if (!empty($total_no_of_bid)) { ?>
                    <li style="border-color: #b1d4ea" class="highlight_series tips" data-series="6">
                        <strong><span class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">$</span><?php echo $total_no_of_bid[($count - 1)]; ?></bdi></span></strong>
                        <?php _e( 'Highest Bid', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <li style="border-color: #3498db" class="highlight_series tips" data-series="7">
                        <strong><span class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">$</span><?php echo $total_no_of_bid[0]; ?></bdi></span></strong>
                        <?php _e( 'Lowest Bid', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                    <?php if (!empty($count)) { ?>
                    <li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
                        <strong><?php echo $count; ?></strong> <?php _e( 'Number of Bids', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
					<?php if ($report_type == 'products') { ?>
					
						<li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
							<strong><?php echo wc_price($buy_now_earning); ?></strong> <?php _e( 'Earning from Buy Now', 'ultimate-auction-pro-software' ); ?>
						</li>
						
					 <?php } ?>
                    <?php /*if (!empty($totlaamount)) {*/ ?>
                    <li style="border-color: #ecf0f1" class="highlight_series " data-series="0" data-tip="">
                        <strong><?php echo wc_price($totlaamount); ?></strong> <?php _e( 'Total Earning (with Tax)', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  /*}*/ ?>
                    <?php $wt = ($totlaamount - $total_tax);
                        /*if (!empty($wt)) {*/ ?>
                    <li style="border-color: #e74c3c" class="highlight_series " data-series="8" data-tip="">
                        <strong><?php echo wc_price($wt); ?> </strong>
                        <?php _e( 'Earning (Without Tax)', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  /*}*/ ?>
                </ul>
                <ul class="chart-widgets">
                </ul>
            </div>
            <div class="main">
                <div class="chart-container">
                    <div class="chart-placeholder main" style="padding: 0px;">
                        <canvas id="speedChart" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /*https://www.chartjs.org/docs/latest/*/  ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
<script>
var speedCanvas = document.getElementById("speedChart");
var setlabels = <?php echo json_encode($graph_date); ?>;
var setvalue = <?php echo json_encode($graph_value);  ?>;
var dataFirst = {
    label: "Report",
    data: [0, 59, 75, 20, 20, 55, 40],
    lineTension: 0,
    fill: false,
    borderColor: 'blue'
};
var dataSecond = {
    label: "Car B - Speed (mph)",
    data: [20, 15, 60, 60, 65, 30, 70],
    lineTension: 0,
    fill: false,
    borderColor: 'blue'
};
var speedData = {
    labels: setlabels,
    // datasets: [dataFirst, dataSecond]
    datasets: [dataFirst]
};
var chartOptions = {
    legend: {
        display: true,
        position: 'top',
        labels: {
            boxWidth: 80,
            fontColor: 'black'
        }
    }
};
var lineChart = new Chart(speedCanvas, {
    type: 'line',
    data: speedData,
    options: chartOptions
});
</script>
<?php } ?>

<?php if (!empty($report_type) && $report_type == 'events') { ?>
 
<?php
$today_date = date('Y-m-d', strtotime('1 days'));
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
	
    $totlaamount = 0;
    $totlaamount_arr = array();
    $total_tax = 0;
    $total_tax_arr = array();
    $total_no_of_bid = array();
    $csv_data_arr = array();
    $graph_date = array();
    $graph_value = array();
    $items_sold = array();
    $event_total_product_arr = 0;
	$query   = new WC_Order_Query( array(
        'limit'      => 100000,
        'orderby'    => 'date',
        'order'      => 'DESC',
        'return'     => 'ids',
    ) );
    $orders  = $query->get_orders();
    $completed_dates = array();
    $completed_order_ids = array();
    foreach ( $orders as $oval ) {
        $order                       = wc_get_order( $oval );
		$get_status=$order->get_status();
		if($get_status=='completed'){
			$date_completed=$order->get_date_completed();
			$order_date=$date_completed->date("Y-m-d");
			if($order_date>= $end_date && $order_date<=$start_date){
			  $order_id = $order->get_id();
        $customer_id = $order->get_customer_id();
        //print_r($oval);
        $order = wc_get_order($order_id);
		
		 $auctions_order=$order->get_meta('auctions_order');
        $items = $order->get_items();
        foreach ($items as $item) {
            $product_name = $item->get_name();
            $product_id = $item->get_product_id();
            $product = wc_get_product($product_id);
			$uat_event_id=get_post_meta( $product_id, 'uat_event_id', true );
              $get_event_id = $uat_event_id;
            $event_totl_product = uat_get_event_total_no_products($get_event_id);
            $event_total_product_arr += $event_totl_product;
            $items_sold[] = $product_id;
            $eventnm = get_the_title($get_event_id);
            $query   = "SELECT * FROM `wp_woo_ua_auction_log` WHERE `auction_id` = $product_id ORDER BY `userid` ASC";
            $results = $wpdb->get_results($query);
            foreach ($results as $row) {
                $graph_date[] = $row->date;
                $graph_value[] = $row->bid;
                $total_no_of_bid[] = $row->bid;
                $csv_row_data = array();
                $csv_row_data['event_name'] =  $eventnm;
                $csv_row_data['product_name'] =  $product_name;
                $csv_row_data['bid'] =  $row->bid;
                $csv_data_arr[] = $csv_row_data;
            }
        }
        /*
		$product_id = $oval->get_id();
		$product = wc_get_product($product_id);
		if ($product->get_type() == "auction") {*/
        $order->get_id() . '<br>'; // The order ID
        $order->get_status() . '<br>'; // The order status
        $order->get_total() . '<br>'; // The order status
        $totlaamount_arr[] = $order->get_total();
        $total_tax_arr[] = $order->get_total_tax();
        $totlaamount += $order->get_total();
        $total_tax += $order->get_total_tax();
		 
        //}
			$completed_order_ids[] =$order_id;
			$completed_dates[ $order_id ]    = $order->get_date_completed();
			}
		}
    }
   /* foreach ($orders as $oval) {
        }*/
    sort($total_no_of_bid);
    $count = count($total_no_of_bid);
    //print_r($items_sold);
    $event_total_product_arr;
    $items_sold_count = count($items_sold);
    $total_tax; ?>
<br class="clear">
<div id="poststuff" class="woocommerce-reports-wide">
    <div class="postbox">
        <div class="stats_range">
            <a class="export_csv" href="<?php echo $actual_link; ?>&export_csv=1&action=uat_report_csv"
                data-export="chart" data-xaxes="Date" data-exclude_series="2" data-groupby="day">
                <?php _e( 'Export CSV', 'ultimate-auction-pro-software' ); ?> </a>
            <ul>
                <li class="  <?php if ($range == 'year') {
                                        echo 'active';
                                    } ?>  "><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=year&amp;uat-report-type=events"><?php _e( 'Year', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="<?php if ($range == 'last_month') {
                                    echo 'active';
                                } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=last_month&amp;uat-report-type=events"><?php _e( 'Last month', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="<?php if ($range == 'month') {
                                    echo 'active';
                                } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=month&amp;uat-report-type=events"><?php _e( 'This month', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="<?php if ($range == '7day') {
                                    echo 'active';
                                } ?>"><a
                        href="<?php echo admin_url('admin.php?page=ua-auctions-reports') ?>&uat-report-tab=uat-report-report&amp;range=7day&amp;uat-report-type=events"><?php _e( 'Last 7 days', 'ultimate-auction-pro-software' ); ?></a>
                </li>
                <li class="custom <?php if ($range == 'custom') {
                                            echo 'active';
                                        } ?> ">
                    <?php _e( 'Custom', 'ultimate-auction-pro-software' ); ?>:
                    <form method="GET">
                        <div>
                            <input type="hidden" name="page" value="ua-auctions-reports">
                            <input type="hidden" name="uat-report-tab" value="uat-report-report">
                            <input type="hidden" name="range" value="month"> <input type="hidden" name="range"
                                value="custom">
                            <input type="text" size="11" placeholder="yyyy-mm-dd" value="" name="start_date"
                                class=" example-datepicker" autocomplete="off" id="dp1618225145177">
                            <span>–</span>
                            <input type="text" size="11" placeholder="yyyy-mm-dd" value="" name="end_date"
                                class="  example-datepicker" autocomplete="off" id="dp1618225145178"> <button
                                type="submit" class="button" value="Go">Go</button>
                            <input type="hidden" id="wc_reports_nonce" name="wc_reports_nonce" value="2d084e5239">
                        </div>
                        <script>
                        jQuery(window).load(function() {
                            jQuery('.example-datepicker').datepicker({
                                dateFormat: 'yy-mm-dd'
                            });
                        });
                        </script>
                    </form>
                </li>
            </ul>
        </div>
        <div class="inside chart-with-sidebar">
            <div class="chart-sidebar">
                <ul class="chart-legend">
                    <?php
                        if (!empty($event_total_product_arr) && $report_type == 'events') { ?>
                    <li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
                        <strong><?php echo $event_total_product_arr; ?></strong> <?php _e( 'Total Items', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                    <?php if (!empty($items_sold_count) && $report_type == 'events') { ?>
                    <li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
                        <strong><?php echo $items_sold_count; ?></strong> <?php _e( 'Items Sold', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                    <?php if (!empty($total_no_of_bid)) { ?>
                    <li style="border-color: #b1d4ea" class="highlight_series tips" data-series="6">
                        <strong><span class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">
                                    </span><?php echo wc_price($total_no_of_bid[($count - 1)]); ?></bdi></span></strong>
                        <?php _e( 'Highest Bid', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <li style="border-color: #3498db" class="highlight_series tips" data-series="7">
                        <strong><span class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">
                                    </span><?php echo wc_price($total_no_of_bid[0]); ?></bdi></span></strong>
                        <?php _e( 'Lowest Bid', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                    <?php if (!empty($count)) { ?>
                    <li style="border-color: #dbe1e3" class="highlight_series " data-series="1" data-tip="">
                        <strong><?php echo $count; ?></strong> <?php _e( 'Number of Bids', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
					
                    <?php if (!empty($totlaamount)) { ?>
                    <li style="border-color: #ecf0f1" class="highlight_series " data-series="0" data-tip="">
                        <strong><?php echo wc_price($totlaamount); ?></strong> <?php _e( 'Total Earning (with Tax)', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                    <?php $wt = ($totlaamount - $total_tax);
                        if (!empty($wt)) { ?>
                    <li style="border-color: #e74c3c" class="highlight_series " data-series="8" data-tip="">
                        <strong><span class="woocommerce-Price-amount amount"><bdi><span
                                        class="woocommerce-Price-currencySymbol">
                                    </span><?php echo wc_price($wt); ?></bdi></span></strong>
                        <?php _e( 'Earning (Without Tax)', 'ultimate-auction-pro-software' ); ?>
                    </li>
                    <?php  } ?>
                </ul>
                <ul class="chart-widgets">
                </ul>
            </div>
            <div class="main">
                <div class="chart-container">
                    <div class="chart-placeholder main" style="padding: 0px;">
                        <canvas id="speedChart" width="600" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /*https://www.chartjs.org/docs/latest/*/  ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.2.1/dist/chart.min.js"></script>
<script>
var speedCanvas = document.getElementById("speedChart");
var setlabels = <?php echo json_encode($graph_date); ?>;
var setvalue = <?php echo json_encode($graph_value);  ?>;
var dataFirst = {
    label: "Report",
    data: [0, 59, 75, 20, 20, 55, 40],
    lineTension: 0,
    fill: false,
    borderColor: 'blue'
};
var dataSecond = {
    label: "Car B - Speed (mph)",
    data: [20, 15, 60, 60, 65, 30, 70],
    lineTension: 0,
    fill: false,
    borderColor: 'blue'
};
var speedData = {
    labels: setlabels,
    // datasets: [dataFirst, dataSecond]
    datasets: [dataFirst]
};
var chartOptions = {
    legend: {
        display: true,
        position: 'top',
        labels: {
            boxWidth: 80,
            fontColor: 'black'
        }
    }
};
var lineChart = new Chart(speedCanvas, {
    type: 'line',
    data: speedData,
    options: chartOptions
});
</script>
<?php } ?>
