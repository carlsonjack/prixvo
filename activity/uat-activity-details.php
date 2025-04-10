<?php
/**
 * Theme welcome page
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.', 'ultimate-auction-pro-software' ) );
	$title = __( 'Activity Detail', 'ultimate-auction-pro-software' );
	global $wpdb;
    $table_name = UA_ACTIVITY_TABLE;
    $UA_ACTIVITYMETA = UA_ACTIVITYMETA_TABLE;
    $product_id = $_REQUEST['p_id'];
	$datetimeformat = get_option('date_format').' '.get_option('time_format');
	add_thickbox();
 ?>
<div class="wrap welcome-wrap uat-admin-wrap activity-detail-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uwa_admin_page_title"><?php _e( 'Activity Detail', 'ultimate-auction-pro-software' ); ?>
	<a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=ua-auctions-reports');?>"><?php _e('Back To Listing', 'ultimate-auction-pro-software')?></a>
	</h1>
		<h2 class="nav-tab-wrapper">
		<?php
		$tabs = array(
		    array( 'slug' => 'ua_bids', 'label' => __('Bids', 'ultimate-auction-pro-software')),
			array( 'slug' => 'ua_email', 'label' => __('Email', 'ultimate-auction-pro-software')),
			array( 'slug' => 'ua_payment_hold_logs', 'label' => __('Payment Hold', 'ultimate-auction-pro-software')),
			array( 'slug' => 'ua_payment_debit_logs', 'label' => __('Payment Hold & Debit', 'ultimate-auction-pro-software')),
			array( 'slug' => 'ua_payment_direct_debit_logs', 'label' => __('Payment Direct Debit', 'ultimate-auction-pro-software')),
			array( 'slug' => 'ua_api_requests_logs', 'label' => __('API Requests', 'ultimate-auction-pro-software')),
		 );
		$activity_tabs = apply_filters('uat_activity_detail_tabs', $tabs);
		$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'ua_bids';
		foreach( $activity_tabs as $tab){ ?>
		<a href="?page=uat-auctions-activity-details&p_id=<?php echo $product_id;?>&tab=<?php echo $tab['slug'];?>" class="nav-tab <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label'];?></a>
	    <?php } ?>
        </h2>
	<div class="tab-section">
	<div class="uat-main-box">
		<div class="uat-profile-details">
                    <div class="uat-pic-text">
                        <div class="uat-right-text-block">
                            <div class="uat-product-title"><?php _e( 'Product Title', 'ultimate-auction-pro-software' ); ?> : <?php echo '<a href="'.get_edit_post_link( $product_id ).'">'.get_the_title( $product_id ).'</a>'; ?></div>
                           <?php $uat_event_id = get_post_meta($product_id,'uat_event_id',true);
							if(!empty($uat_event_id)){ ?>
                            <div class="uat-product-title"><?php _e( 'Event Title', 'ultimate-auction-pro-software' ); ?> : <?php echo '<a href="'.get_edit_post_link( $uat_event_id ).'">'.get_the_title( $uat_event_id ).'</a>'; ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="uat-right-nb">
                        <h2><?php _e( 'Product ID', 'ultimate-auction-pro-software' ); ?> # <?php echo $product_id; ?></h2>
                    </div>
        </div>
		 <?php
		if (!empty($active_tab)) {
		    $log_types_qry_where = " where  post_parent=".$product_id." and activity_type ='".$active_tab."'";
		}
		elseif (!empty($_REQUEST['bid_id']) ) {
			$log_types_qry_where=" where post_parent=".$product_id." and activity_type ='".$active_tab."' and activity_id ='".$_REQUEST['bid_id']."'";
		}
		$logs_loops = $wpdb->get_results("SELECT * FROM $table_name $log_types_qry_where ORDER BY activity_id DESC");
		?>
		<?php if( $active_tab == 'ua_bids' ) { ?>
		<div class="uat-table">
		<h2 class="uat-logs-title"><?php _e( 'Bid Logs', 'ultimate-auction-pro-software' ); ?> <span class="dashicons dashicons-warning"></span></h2>
		<table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th><?php _e( 'Log ID', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Action Detail', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Bid Value', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'User name', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Timestamp', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'SMS Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Payment Hold Status', 'ultimate-auction-pro-software' ); ?></th>
                    </tr>
                </thead>
                <?php
				if (count($logs_loops) > 0 ) {
					foreach ($logs_loops as $logs_loop) {
					$activity_id = $logs_loop->activity_id;
					$activity_name = $logs_loop->activity_name;
					$action_by = $logs_loop->activity_by;
					$user_obj = get_user_by( 'ID', $action_by);
					$action_date = $logs_loop->activity_date;
					$action_bid_value = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='bid_value'");
					$activityhold_ID = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='hold_activity_id'");
					$activityEmail_ID ="";
					$activitySMS_ID ="";
					?>
                <tr>
					<td><?php echo $activity_id;?></td>
					<td><?php echo $activity_name;?></td>
					<td><?php if($action_bid_value > 0) { echo wc_price($action_bid_value);}?></td>
					<?php if(!empty($action_by)){ ?>
					<td>
					<a href="<?php echo get_edit_user_link($action_by); ?>"><?php  echo   $user_obj->display_name;?></a></td>
						<?php } else {?> <td>N/A</td> <?php } ?>
					<td><?php echo mysql2date($datetimeformat ,$action_date)?></td>
					<td></td>
				    <td>
					<?php if(!empty($activityhold_ID)){ ?>
					<a title="Message" href="?page=uat-auctions-activity-details&tab=ua_payment_hold_logs&p_id=<?php echo $product_id;?>&bid_id=<?php echo $activityhold_ID;?>"
					class="button button-secondary">
					<?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></a>
					<?php } ?>
					</td>
                </tr>
				<?php } } else { ?>
				<tr> <td colspan="8"><?php _e( 'No record found', 'ultimate-auction-pro-software' ); ?></td></tr>
				<?php } wp_reset_query(); ?>
            </table>
		 </div>
		<?php } ?>
		<?php if( $active_tab == 'ua_email' ) { ?>
		<div class="uat-table">
			<h2 class="uat-logs-title"><?php _e('Email', 'ultimate-auction-pro-software'); ?> <span class="dashicons dashicons-warning"></span></h2>
			<p><?php _e('Install', 'ultimate-auction-pro-software'); ?> <a href="https://wordpress.org/plugins/wp-mail-logging/" target="blank"><?php _e('WP Mail Logging plugin', 'ultimate-auction-pro-software'); ?></a>. <?php _e('Once installed, this will log all outgoing emails so you can see what is being sent.', 'ultimate-auction-pro-software'); ?>:</p>
			<p><?php _e('Go to your admin dashboard > WP Mail Log', 'ultimate-auction-pro-software'); ?></p>
		 </div>
		<?php } ?>
		<?php if( $active_tab == 'ua_payment_hold_logs' ) { ?>
		<div class="uat-table">
		<h2 class="uat-logs-title"><?php _e('Payment Hold', 'ultimate-auction-pro-software'); ?> <span class="dashicons dashicons-warning"></span></h2>
		<table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
						<th><?php _e( 'Log ID', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Bidder Name', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Bid Value', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Timestamp', 'ultimate-auction-pro-software' ); ?></th>
						<th><?php _e( 'Hold Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Refund Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></th>
                    </tr>
                </thead>
                 <?php
				if (count($logs_loops) > 0 ) {
					foreach ($logs_loops as $logs_loop) {
					$activity_id = $logs_loop->activity_id;
					$action_by = $logs_loop->activity_by;
					$user_obj = get_user_by( 'ID', $action_by);
					$action_date = $logs_loop->activity_date;
					$action_bid_value = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='bid_value'");
					$p_hold_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='p_hold_status'");
					$p_release_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='p_release_status'");
					$p_hold_content = $logs_loop->activity_data;
					?>
                <tr>
					<td><?php echo $activity_id;?></td>
					<?php if(!empty($action_by)){ ?>
					<td>
					<a href="<?php echo get_edit_user_link($action_by); ?>"><?php  echo   $user_obj->display_name;?></a></td>
						<?php } else {?> <td>N/A</td> <?php } ?>
					<td><?php if($action_bid_value > 0) { echo wc_price($action_bid_value);}?></td>
					<td><?php echo mysql2date($datetimeformat ,$action_date)?></td>
					<td><?php echo $p_hold_status;?></td>
					<td><?php echo $p_release_status;?></td>
				    <td> <?php
						if(!empty($p_hold_content)){ ?>
						<a title="Message" href="#TB_inline?&width=600&height=550&inlineId=message-id-<?php echo $activity_id;?>" class='button button-secondary thickbox'><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></a>
						<div id="message-id-<?php echo $activity_id;?>" style="display:none;">
							<p><?php echo $p_hold_content;?></p>
						</div>
						<?php } ?>
					</td>
                </tr>
				<?php } } else { ?>
				<tr> <td colspan="8"><?php _e( 'No record found', 'ultimate-auction-pro-software' ); ?></td></tr>
				<?php } wp_reset_query(); ?>
            </table>
		 </div>
		<?php } ?>
		<?php if( $active_tab == 'ua_payment_debit_logs' ) { ?>
		<div class="uat-table">
		<h2 class="uat-logs-title"><?php _e('Payment Debit', 'ultimate-auction-pro-software'); ?> <span class="dashicons dashicons-warning"></span></h2>
		<table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
						<th><?php _e( 'Log ID', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Winner Name', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Winning Bid Value', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Timestamp', 'ultimate-auction-pro-software' ); ?></th>
						<th><?php _e( 'Debit Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></th>
                    </tr>
                </thead>
                <?php
				if (count($logs_loops) > 0 ) {
					foreach ($logs_loops as $logs_loop) {
					$activity_id = $logs_loop->activity_id;
					$action_by = $logs_loop->activity_by;
					$user_obj = get_user_by( 'ID', $action_by);
					$action_date = $logs_loop->activity_date;
					$action_bid_value = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='bid_value'");
					$p_debit_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='p_debit_status'");
					$activity_data = $logs_loop->activity_data;
					?>
                <tr>
					<td><?php echo $activity_id;?></td>
					<?php if(!empty($action_by)){ ?>
					<td>
					<a href="<?php echo get_edit_user_link($action_by); ?>"><?php  echo   $user_obj->display_name;?></a></td>
						<?php } else {?> <td>N/A</td> <?php } ?>
					<td><?php if($action_bid_value > 0) { echo wc_price($action_bid_value);}?></td>
					<td><?php echo mysql2date($datetimeformat ,$action_date)?></td>
					<td><?php echo $p_debit_status;?></td>
				    <td> <?php
						if(!empty($activity_data)){ ?>
						<a title="Message" href="#TB_inline?&width=600&height=550&inlineId=message-id-<?php echo $activity_id;?>" class='button button-secondary thickbox'><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></a>
						<div id="message-id-<?php echo $activity_id;?>" style="display:none;">
							<p><?php echo $activity_data;?></p>
						</div>
						<?php } ?>
					</td>
                </tr>
				<?php } } else { ?>
				<tr> <td colspan="8"><?php _e( 'No record found', 'ultimate-auction-pro-software' ); ?></td></tr>
				<?php } wp_reset_query(); ?>
            </table>
		 </div>
		<?php } ?>
		<?php if( $active_tab == 'ua_payment_direct_debit_logs' ) { ?>
		<div class="uat-table">
		<h2 class="uat-logs-title"><?php _e('Payment Direct Debit', 'ultimate-auction-pro-software'); ?> <span class="dashicons dashicons-warning"></span></h2>
		<table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
						<th><?php _e( 'Log ID', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Winner Name', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Winning Bid Value', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Timestamp', 'ultimate-auction-pro-software' ); ?></th>
						<th><?php _e( 'Debit Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></th>
                    </tr>
                </thead>
                 <?php
				if (count($logs_loops) > 0 ) {
					foreach ($logs_loops as $logs_loop) {
					$activity_id = $logs_loop->activity_id;
					$action_by = $logs_loop->activity_by;
					$user_obj = get_user_by( 'ID', $action_by);
					$action_date = $logs_loop->activity_date;
					$action_bid_value = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='bid_value'");
					$p_debit_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='p_debit_status'");
					$activity_data = $logs_loop->activity_data;
					?>
                <tr>
					<td><?php echo $activity_id;?></td>
					<?php if(!empty($action_by)){ ?>
					<td>
					<a href="<?php echo get_edit_user_link($action_by); ?>"><?php  echo   $user_obj->display_name;?></a></td>
						<?php } else {?> <td>N/A</td> <?php } ?>
					<td><?php if($action_bid_value > 0) { echo wc_price($action_bid_value);}?></td>
					<td><?php echo mysql2date($datetimeformat ,$action_date)?></td>
					<td><?php echo $p_debit_status;?></td>
				    <td> <?php
						if(!empty($activity_data)){ ?>
						<a title="Message" href="#TB_inline?&width=600&height=550&inlineId=message-id-<?php echo $activity_id;?>" class='button button-secondary thickbox'><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></a>
						<div id="message-id-<?php echo $activity_id;?>" style="display:none;">
							<p><?php echo $activity_data;?></p>
						</div>
						<?php } ?>
					</td>
                </tr>
				<?php } } else { ?>
				<tr> <td colspan="8"><?php _e( 'No record found', 'ultimate-auction-pro-software' ); ?></td></tr>
				<?php } wp_reset_query(); ?>
            </table>
		 </div>
		<?php } ?>
		<?php if( $active_tab == 'ua_api_requests_logs' ) { ?>
		<div class="uat-table">
		<h2 class="uat-logs-title"><?php _e('API Requests', 'ultimate-auction-pro-software'); ?> <span class="dashicons dashicons-warning"></span></h2>
		<table cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
						<th><?php _e( 'Log ID', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'API Name', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'API Response Status', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'Timestamp', 'ultimate-auction-pro-software' ); ?></th>
                        <th><?php _e( 'View API Log', 'ultimate-auction-pro-software' ); ?></th>
                    </tr>
                </thead>
                <?php
				if (count($logs_loops) > 0 ) {
					foreach ($logs_loops as $logs_loop) {
					$activity_id = $logs_loop->activity_id;
					$action_date = $logs_loop->activity_date;
					$api_name = "";
				    $api_name = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='api_name'");
					$api_response = $logs_loop->activity_data;
					$api_response_status = "";
					$api_response_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$activity_id." AND meta_key ='api_response_status'");
					?>
                <tr>
					<td><?php echo $activity_id;?></td>
					<td><?php  echo $api_name;?></td>
					<td><?php echo $api_response_status;?></td>
					<td><?php echo mysql2date($datetimeformat ,$action_date)?></td>
				    <td> <?php
						if(!empty($api_response)){ ?>
						<a title="Message" href="#TB_inline?&width=600&height=550&inlineId=message-id-<?php echo $activity_id;?>" class='button button-secondary thickbox'><?php _e( 'View Detail', 'ultimate-auction-pro-software' ); ?></a>
						<div id="message-id-<?php echo $activity_id;?>" style="display:none;">
							<p><?php echo $api_response;?></p>
						</div>
						<?php } ?>
					</td>
                </tr>
				<?php } } else { ?>
				<tr> <td colspan="8"><?php _e( 'No record found', 'ultimate-auction-pro-software' ); ?></td></tr>
				<?php } wp_reset_query(); ?>
            </table>
		 </div>
		<?php } ?>
        </div>
        </div>
    </div>
</div>
</div>
<style>
/* --------------------------------------------- */
 /* Center tables for demo */
.uat-table table {
  margin: 0 auto;
  width:100%;
}
/* Default Table Style */
.uat-table table {
  color: #777;
  background: white;
  border: 1px #dadada;
  font-size: 12pt;
  border-collapse: collapse;
}
.uat-table table thead th,
.uat-table table tfoot th {
  color: #333;
  background-color:#fff;
}
.uat-table table caption {
  padding:.5em;
}
.uat-table table th,
.uat-table table td {
  padding: .5em;
  border: 1px solid #d8d6d6;
  background-color:#f3f3f3;
}
/
div#wpfooter {
    display: none;
}
div#wpfooter {
    display: none;
}
.uat-main-box {
    width: 100%;
    min-height: 500px;
    background-color: #fff;
    padding-bottom:50px;
}
.uat-sales-value a {
    padding: 0 0 0 0;
    display: flex;
    align-items: center;
}
.uat-table {
    margin: 0;
    display: block;
    padding:35px 35px 0 35px ;
}
.uat-sales-value {
    margin: 15% 0 0 0;
}
.uat-sales-value {text-decoration:none;color:#000}
.uat-sales-value {
    margin: 15% 0 0 0;
    padding: 20px;
    border-top: 1px solid #dadada;
    border-bottom: 1px solid #dadada;
    display: flex;
    justify-content: space-evenly;
    align-items: center;
}
.uat-right-nb h2 {
    font-size: 28px;
    margin: 0 0 10px 0;
}
.uat-pic-text {
    display: flex;
    width: 380px;
}
.uat-laft-pic-block {
    display: flex;
    flex-direction: column;
    text-align: center;
    margin-right: 25px;
}
.uat-right-text-block h3 {
    margin: 0 0 10px 0;
    font-size: 25px;
    display: block;
    line-height: 25px;
}
.uat-right-text-block a, .uat-right-text-block div{margin-bottom:5px; }
.uat-right-text-block {
    font-size: 15px;
    margin: 0;
    display: inline-block;
}
.uat-profile-details {
    display: flex;
    padding: 35px 35px 0px 35px;
    justify-content: space-between;
}
.uat-laft-pic-block a {
    margin: 8px 0 0 0;
}
/* --------------------------------------------- */
.tab-section {
    display: flex;
}
.auction-button{
	margin-left: 0;
    padding: 5px 10px;
    text-decoration: none;
    border: 1px solid #0071a1;
    border-radius: 4px;
    text-shadow: none;
    font-weight: 600;
    font-size: 14px;
    line-height: normal;
    color: #0071a1;
    background: #f3f5f6;
    cursor: pointer;
    margin: 0 0 0 2px;
    display: inline-block;
}
.tab-section .nav-tab-wrapper {
    display: flex;
    flex-direction: column;
}
.tab-section .tab-con {
    width: 100%;
}
.tab-section .nav-tab-wrapper .nav-tab {
    float: none;
    border: 1px solid #ccc;
    border-bottom: none;
    margin-left: 0;
    padding: 12px 12px;
    font-size: 14px;
    line-height: 1.71428571;
    font-weight: 600;
    background: #e5e5e5;
    color: #555;
    text-decoration: none;
    white-space: nowrap;
}
.tab-section .nav-tab-wrapper {
    border-bottom: 0;
}
.tab-section .nav-tab-wrapper {
    display: flex;
    flex-direction: column;
    width: 160px;
    padding-top: 0;
    margin-top: 92.5px;
}
.dropdown-sec {
	margin-bottom: 10px;
    display: flex;
    align-items: center;
}
/* table css start here */
.custom-table-auction {
    width: 100%;
    border-collapse: collapse;
    margin: 0px auto;
}
.custom-table-auction tr:nth-of-type(odd) {
    background: #eee;
}
.custom-table-auction th {
    background: #00a0d2;
    color: #ffffff;
    font-weight: 500;
}
.custom-table-auction th {
    font-weight: bold;
}
.custom-table-auction td,
.custom-table-auction th {
    border: 1px solid #ccc;
    text-align: left;
    padding: 12px 12px;
    font-size: 14px;
    line-height: 1.71428571;
}
.dropdown-sec select {
    vertical-align: unset;
}
@media only screen and (max-width: 1023px),
(min-device-width: 768px) and (max-device-width: 1024px) {
    .custom-table-auction {
        width: 100%;
    }
    /* Force table to not be like tables anymore */
    .custom-table-auction,
    .custom-table-auction thead,
    .custom-table-auction tbody,
    .custom-table-auction th,
    .custom-table-auction td,
    .custom-table-auction tr {
        display: block;
    }
    /* Hide table headers (but not display: none;, for accessibility) */
    .custom-table-auction thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
    }
    .custom-table-auction tr {
        border: 1px solid #ccc;
    }
    .custom-table-auction td {
        /* Behave  like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
    }
    .custom-table-auction td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        /* Label the data */
        content: attr(data-column);
        color: #000;
        font-weight: bold;
    }
}
/* table css end */
</style>
<!-- /.wrap -->