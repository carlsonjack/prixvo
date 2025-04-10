<?php
/**
 * Query Files
 *
 * 
 *
 * @package Ultimate_Auction
 */

/**
* Get user wise product active/bid history
*/

function uat_get_bids_list_by_user( $auction_status ) {	
	global $wpdb, $woocommerce;
	global $product;
	global $sitepress;
	$user_id  = get_current_user_id();
	$table = $wpdb->prefix."woo_ua_auction_log";	 
	$table2 = $wpdb->prefix."ua_auction_product";
	$users_bidlist = $wpdb->get_results( "SELECT $table.auction_id,MAX($table.bid) as max_userbid,$table.userid ,$table2.event_id FROM $table INNER JOIN $table2  ON $table.auction_id = $table2.post_id
	 WHERE $table.userid = $user_id  and $table2.auction_status='$auction_status' GROUP by $table.auction_id ORDER by $table.date DESC"  );	 
	return $users_bidlist; 
}
function uat_get_active_bids_auction_ids_by_user( $auction_status ) {	
	global $wpdb;
	$user_id  = get_current_user_id();
	$table = $wpdb->prefix."woo_ua_auction_log";	 
	$table2 = $wpdb->prefix."ua_auction_product";
	$users_bidlist = $wpdb->get_results( "SELECT $table.auction_id FROM $table INNER JOIN $table2  ON $table.auction_id = $table2.post_id
	 WHERE $table.userid = $user_id  and $table2.auction_status='$auction_status' GROUP by $table.auction_id ORDER by $table.date DESC"  );	 
	$users_bidlist = array_column($users_bidlist, 'auction_id');
	return $users_bidlist; 
}

function uat_get_events_saved_by_user( $user_id ) {	
	global $wpdb;	
	$results = get_user_meta( $user_id, "uat_event_follow_id"); 

	return $results;
}

function uat_get_auctions_saved_by_user( $user_id ) {		
	global $wpdb;	
	$results = get_user_meta( $user_id, "uat_auction_saved_id");
	return $results;
}
