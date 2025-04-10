<?php
/**
 * Extra Functions file for Auctions
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) { exit;}

if (!function_exists('uat_get_all_events_ids')) {

    /**
     * Return all event id as per parameter events ids
     *
     */
    function uat_get_all_events_ids($event_status="",$order="",$orderby="",$selected_datetime="") {

		global $wpdb;
		$table = UA_EVENTS_TABLE;
        $all_events_ids = array();

		$order = $order ? $order : 'DESC';
		$orderby = $orderby ? $orderby : 'ID';
		$event_status = $event_status ? $event_status : '';
		$selected_datetime = $selected_datetime ? $selected_datetime : '';

		if($orderby =="ID"){
			$orderby ="post_id";
		}elseif($orderby =="date"){
			$orderby ="event_start_date";
		}elseif($orderby =="title"){
			$orderby ="event_name";
		}
		if(!empty($selected_datetime)){
          	$dates = explode(',', $selected_datetime);
			$date1 = $dates[0];
			$date2 = $dates[1];

			if($date1=="today"){
				$date1 = get_ultimate_auction_now_date_ymd();
			}elseif($date1=="tomorrow"){
				$date1 = wp_date('Y-m-d',strtotime('+1 day', time()),get_ultimate_auction_wp_timezone());;
			}
		}

		if(!empty($event_status)){

			$event_status_where = "and event_status = '$event_status'";
		}else{
			$event_status_where = "";
		}
		$date_where ="";
		if(!empty($date1) && !empty($date2)){

			$date_where = "and (event_end_date  BETWEEN '$date1' AND '$date2')";
		}
		$query  ="SELECT post_id FROM $table WHERE post_status='publish' $event_status_where $date_where ORDER by $orderby $order";
		$results = $wpdb->get_results( $query );

		foreach($results as $row) {
		$all_events_ids[] =  $row->post_id;
		}
		// $all_events_ids = get_wpml_trans_product_ids($all_events_ids, false);
		return $all_events_ids;

	}
}
/**
 * Get expired_events_id from custom tables wp_ua_auction_product
 *
 */
if (!function_exists('uat_get_live_events_ids')) {

    /**
     * Return Expired events ids
     *
     */
    function uat_get_live_events_ids() {

		global $wpdb;
        $live_events_ids = array();

		$table = UA_EVENTS_TABLE;
		$where = "WHERE post_status='publish' AND event_status = 'uat_live'";
		$query   ="SELECT post_id FROM $table $where ORDER by event_id DESC";

		$results = $wpdb->get_results( $query );


		foreach($results as $row) {
		$live_events_ids[] =  $row->post_id;
		}
		return $live_events_ids;

	}
}

/**
 * Get ending_soon_events_id from custom tables wp_ua_auction_product
 *
 */
if (!function_exists('uat_get_ending_soon_events_ids')) {

    /**
     * Return Expired events ids
     *
     */
    function uat_get_ending_soon_events_ids($days_left = '12') {

		global $wpdb;
        $live_events_ids = array();

		$table = UA_EVENTS_TABLE;
		$days_when_added_pera = "+" . $days_left . " days";
		$after_day = wp_date('Y-m-d H:i:s', strtotime($days_when_added_pera), get_ultimate_auction_wp_timezone());
		$before_day = wp_date("Y-m-d H:i:s", null, get_ultimate_auction_wp_timezone() );

		$where = "WHERE t.event_end_date BETWEEN  '".$before_day."' AND '".$after_day."' AND t.post_status = 'publish' AND t.event_status='uat_live'";
		$query   ="SELECT post_id FROM $table t $where ORDER by event_id DESC";

		$results = $wpdb->get_results( $query );


		foreach($results as $row) {
		$live_events_ids[] =  $row->post_id;
		}
		return $live_events_ids;

	}
}

if (!function_exists('uat_get_future_events_ids')) {

    /**
     * Return Expired events ids
     *
     */
    function uat_get_future_events_ids() {

		global $wpdb;
        $future_events_ids = array();

		$table = UA_EVENTS_TABLE;
		$where = "WHERE post_status='publish' AND event_status = 'uat_future'";
		$query   ="SELECT post_id FROM $table $where ORDER by event_id DESC";

		$results = $wpdb->get_results( $query );


		foreach($results as $row) {
		$future_events_ids[] =  $row->post_id;
		}
		return $future_events_ids;

	}
}

if (!function_exists('uat_get_expired_events_ids')) {

    /**
     * Return Expired events ids
     *
     */
    function uat_get_expired_events_ids() {

		global $wpdb;
        $expired_events_ids = array();

		$table = UA_EVENTS_TABLE;
		$where = "WHERE post_status='publish' AND event_status = 'uat_past'";
		$query   ="SELECT post_id FROM $table $where ORDER by event_id DESC";

		$results = $wpdb->get_results( $query );


		foreach($results as $row) {
		$expired_events_ids[] =  $row->post_id;
		}
		return $expired_events_ids;

	}
}

/**
	 * Detect if an Event is Past
	 *
	 * Returns true if the current time is past the event end time
	 *
	 * @param null $event
	 *
	 * @return bool
	 */
	function uat_event_is_past_event( $event_id = null ) {
        global $wpdb;
		$event_event_status = $wpdb->get_var('SELECT event_status FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		if(!empty($event_event_status) && $event_event_status=='uat_past'){
			return true;
		}
		else{
			 $event_is_running = uat_event_is_live( $event_id );
		     $event_is_completed = uat_event_is_completed( $event_id );
			if ( $event_is_completed && $event_is_running ){
				uat_update_events_status( $event_id , 'uat_past' );
				return TRUE;
			} else {
				return FALSE;
			}
		}

	}

	/**
	 * Is Event Started
	 *
	 */
	function uat_event_is_live(  $event_id = null ) {
		global $wpdb;
		 $live_event = $wpdb->get_var('SELECT event_status FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		if(!empty($live_event) && $live_event=='uat_live'){
		 // return TRUE;
		}
		$event_start_date = $wpdb->get_var('SELECT event_start_date FROM '.UA_EVENTS_TABLE." WHERE event_status <> 'uat_past' and post_id=".$event_id);
		if ( !empty($event_start_date) ){
			$date1 = new DateTime($event_start_date);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2){
				uat_update_events_status( $event_id , 'uat_live' );
				 return TRUE;
			} else{
				uat_update_events_status( $event_id , 'uat_future' );
			}
			return ($date1 < $date2);
		} else {
			return FALSE;
		}

	}

    /**
	 * Is Event Has completed
	 *
	 */
	function uat_event_is_completed( $event_id = null ) {
		 global $wpdb;
		$end_dates = $wpdb->get_var('SELECT event_end_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		if (!empty($end_dates)){
			$date1 = new DateTime($end_dates);
			$date2 = new DateTime(current_time('mysql'));
			if( $date1 < $date2){
		 	    return TRUE;
			} else{
			   return FALSE;
			}
		} else {
			return FALSE;
		}
	}


function uat_get_event_status($event_id){
	global $wpdb;
	//$status = "uat_live";
	$past  = uat_event_is_past_event($event_id);
	$live = uat_event_is_live($event_id);
	if($past){
		$status = "uat_past";
	}elseif($live){
		$status = "uat_live";
	}else{
		$status = "uat_future";
	}
	//$status = $wpdb->get_var("SELECT event_status FROM ".UA_EVENTS_TABLE." WHERE post_id = $event_id");
	return $status;
}
function uat_get_products_ids_from_cat($cat_id) {
    global $woocommerce;
	$valid_status = getValidStatusForProductVisible();
	$valid_status[] = 'publish';
    $args = array(
        'post_type' => 'product',
        'post_status' => $valid_status,
		'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field' => 'term_id',
                'terms' => $cat_id,
                'operator' => 'IN'
            ) ,
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction'
            )
        ),
        'fields' => 'ids',
    );
    $products = new WP_Query($args);
    $cat_auctions_ids = $products->posts;
    return $cat_auctions_ids;
}

function uat_get_event_total_no_products($event_id) {
   global $wpdb;
   $total_no_products =0;
   $valid_status = getValidStatusForProductVisible();
   $valid_status[] = 'publish';
   $valid_status =  implode("','",$valid_status) ;
   $total_no_products = $wpdb->get_var("SELECT COUNT(DISTINCT post_id) FROM ".UA_AUCTION_PRODUCT_TABLE." WHERE event_id = $event_id AND post_status IN ( '".$valid_status."' ) ");
    return $total_no_products;
}

function uat_get_event_total_no_bids($event_id) {
     global $wpdb;
	$total_no_bids = 0;
	$products_array = array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);
   if ($original_array) {

		foreach ($original_array as $auction_id) {
		    $total_no_bids += $wpdb->get_var("SELECT COUNT(*) FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id ");
			//= ((int)get_post_meta($auction_id, 'woo_ua_auction_bid_count', true));
		}
	}

    return $total_no_bids;
}

function uat_get_event_top_bids_amt($event_id) {
    global $wpdb;
	$total_top_bids_amt =0;
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);
   if ($original_array) {

		foreach ($original_array as $auction_id) {

			//$total_top_bids_amt += ((int)get_post_meta($auction_id, 'woo_ua_auction_current_bid', true));
			$total_top_bids_amt += $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` DESC limit 1");

		}
	}
    return $total_top_bids_amt;
}

function uat_get_event_highest_bids( $event_id ) {
	global $wpdb;
	$highest_bids =0;
	$highest_bids_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);
   if ($original_array) {
		foreach ($original_array as $auction_id) {
		$highest_bids = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` DESC limit 1");
		if(!empty($highest_bids)){
				$highest_bids_array[] = $highest_bids;
			}
		}
	}
	if(!empty($highest_bids_array)){
		$highest_bids = max($highest_bids_array);
	}
    return $highest_bids+100;
}
function uat_get_event_lowest_bids( $event_id ) {
	global $wpdb;
	$lowest_bids =0;
	$lowest_bids_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);

   if ($original_array) {

		foreach ($original_array as $auction_id) {

			$lowest_bids = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` asc limit 1");
			if($lowest_bids){
				$lowest_bids_array[] = $lowest_bids;
			}
		}
	}
	if(!empty($lowest_bids_array)){
		$lowest_bids = min($lowest_bids_array);
	}
    return $lowest_bids+1;
}
function get_auction_products_ids_by_search_term($search_term){
	global $wpdb;
	$post_ids = array();
    $args = array(
        's'         => $search_term, 
        'post_type' => array('post', 'product'),
    );
    $query = new WP_Query($args);

    // Loop through the query results
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_ids[] = get_the_ID(); 
        }
    }
    wp_reset_postdata();
    return $post_ids;
}

function uat_get_searched_term_pricerange_values( $term ) {
	global $wpdb;
	$highest_bids = 0;
	$lowest_bids =0;
	$original_array  = get_auction_products_ids_by_search_term($term);
	if (empty($original_array)) {
	    $highest_bids+100;
	}else{
    	$highest_bids_array =array();
		$lowest_bids_array =array();
    	if (!empty($original_array)) {
    		foreach ($original_array as $auction_id) {
    		    $auction_id = (string) $auction_id;
    			$highest_bids_ = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` DESC limit 1");
    			if(!empty($highest_bids_)){
    				$highest_bids_array[] = $highest_bids_;
    			}
				$lowest_bids_ = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` asc limit 1");
				if($lowest_bids_){
					$lowest_bids_array[] = $lowest_bids_;
				}
    		}
    	}
    	if(!empty($highest_bids_array)){
    		$highest_bids = max($highest_bids_array);
    	}
		if(!empty($lowest_bids_array)){
			$lowest_bids = min($lowest_bids_array);
		}
	}
    return array('highest'=>$highest_bids,'lowest'=>$lowest_bids);
}
function uat_get_event_category_highest_bids( $even_cat_id ) {
	global $wpdb;
	$highest_bids = 0;
	$original_array  = get_auction_products_ids_by_event_categorie($even_cat_id);
	if (empty($original_array)) {
	    return $highest_bids+100;
	}else{
    	$highest_bids_array =array();
    	if (!empty($original_array)) {
    		foreach ($original_array as $auction_id) {
    		    $auction_id = (string) $auction_id;
    			$highest_bids = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` DESC limit 1");
    			if(!empty($highest_bids)){
    				$highest_bids_array[] = $highest_bids;
    			}
    		}
    	}
    	if(!empty($highest_bids_array)){
    		$highest_bids = max($highest_bids_array);
    	}
	}
    return $highest_bids+100;
}
function uat_get_event_category_lowest_bids( $event_cat_id ) {
	global $wpdb;
	$lowest_bids = 0;
	$original_array  = get_auction_products_ids_by_event_categorie($event_cat_id);
	if (empty($original_array)) {
	    return $lowest_bids+1;
	}else{
    	$original_array = array_unique($original_array);
    	$lowest_bids_array =array();
       	if ($original_array) {
    		foreach ($original_array as $auction_id) {
    			$lowest_bids = $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` asc limit 1");
    			if($lowest_bids){
    				$lowest_bids_array[] = $lowest_bids;
    			}
    		}
    	}
    	if(!empty($lowest_bids_array)){
    		$lowest_bids = min($lowest_bids_array);
    	}
	}
    return $lowest_bids+1;
}



	/**
	 * Get Event Remaining Second Count
	 *
	 */
	function uat_get_remaining_seconds ( $event_id )  {
		global $wpdb;
        $event_end_date = $wpdb->get_var('SELECT event_end_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		$ending_date =  $event_end_date;
		if ($ending_date){
			$second_count = strtotime($ending_date)  -  (get_option( 'gmt_offset' )*3600);
			return $second_count;

		} else {
			return FALSE;
		}
	}

	/**
	 * Get Event Remaining Second Count
	 *
	 */
	function uat_get_remaining_to_start_seconds ( $event_id )  {
		global $wpdb;
        $event_start_date = $wpdb->get_var('SELECT event_start_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		$ending_date =  $event_start_date;
		if ($ending_date){
			$second_count = strtotime($ending_date)  -  (get_option( 'gmt_offset' )*3600);
			return $second_count;

		} else {
			return FALSE;
		}
	}

	function is_uat_user_watching_event($event_id, $user_ID = false){

		if(!$user_ID){
			$user_ID = get_current_user_id();
		}

		$users_watching_event = get_post_meta( $event_id, 'uat_event_follow_id', FALSE );

		if(is_array($users_watching_event) && in_array($user_ID, $users_watching_event)){

			$return =  true;

		} else{

			$return =  false;
		}

		return $return;
	}

	function uat_watching_event( $event_id ){
		?>
		<div class="add-block">
			<?php 	if (is_uat_user_watching_event($event_id)){ ?>
			<a title="remove" href="javascript:void(0)" class="uat-watchlist-action" data-event-id="<?php echo esc_attr( $event_id ); ?>" >
				<img src="<?php echo esc_url(UAT_THEME_PRO_IMAGE_URI);?>front/minus-sign.png">
			</a>
			<?php } else { ?>

			<a  title="add" href="javascript:void(0)" class="uat-watchlist-action" data-event-id="<?php echo esc_attr( $event_id ); ?>" >

				<img src="<?php echo esc_url(UAT_THEME_PRO_IMAGE_URI);?>front/add-sign.png">
			</a>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Get Event Remaining Second Count
	 *
	 */
	function uat_get_saved_count($event_id) {
		global $wpdb;
		$saved_count =0;
		$saved_count = get_post_meta( $event_id, "uat_event_saved_id");
		return count($saved_count);
	}



	function uat_get_events_post_ids_by_status_admin( $event_status="",$from="",$to="") {

		global $wpdb;
        $event_ids_array = array();
		$from = ( isset( $_GET['DateFrom'] ) && $_GET['DateFrom'] ) ? $_GET['DateFrom'] : '';
		$to = ( isset( $_GET['DateTo'] ) && $_GET['DateTo'] ) ? $_GET['DateTo'] : '';
		$table = UA_EVENTS_TABLE;
		$where = "WHERE event_status = '$event_status'";
		
		if($event_status=="uat_all"){
			 $where = "WHERE (event_status = 'uat_past' OR event_status = 'uat_live' OR event_status = 'uat_future'  )";
		}
		 
		 
		$where_dates ="";
		 if( !($from=='' && $to=='') ){
			$where_dates = "  AND (event_end_date  BETWEEN '$from' AND '$to')";
		 }
		$query   ="SELECT post_id FROM $table $where $where_dates";
		$results = $wpdb->get_results( $query );
		foreach($results as $row) {
		$event_ids_array[] =  $row->post_id;
		}
		return $event_ids_array;
	}

	function uat_get_events_post_ids_by_status_front( $event_status="" ,$start_date="", $end_date="") {

		global $wpdb;
        $event_ids_array = array();

		$table = UA_EVENTS_TABLE;
        if( !($start_date=='' && $end_date=='') ){
			$where = "WHERE post_status='publish' AND event_status='$event_status' AND (event_end_date  BETWEEN '$start_date' AND '$end_date')";
			$query   = "SELECT post_id FROM $table $where ORDER by event_end_date ASC";
		} else{
			$where = "WHERE post_status='publish' AND event_status = '$event_status'";
			$query   ="SELECT post_id FROM $table $where ORDER by event_start_date ASC";

		}
		$results = $wpdb->get_results( $query );
		foreach($results as $row) {
		$event_ids_array[] =  $row->post_id;
		}
		return $event_ids_array;
	}

	function uat_update_events_status( $event_id , $event_status ) {
		global $wpdb;
		//echo "update ".UA_EVENTS_TABLE." set event_status='$event_status' WHERE  post_id=".$event_id;
        $wpdb->query("update ".UA_EVENTS_TABLE." set event_status='$event_status' WHERE  post_id=".$event_id);
	}

	function get_auction_products_ids_by_event( $event_id ) {
		global $wpdb;
		$event_products_ids = array();
		$event_products_ids = $wpdb->get_var('SELECT event_products_ids FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
		// $event_products_ids = get_wpml_trans_product_ids(unserialize($event_products_ids));
		return $event_products_ids;
	}
	/* get product ids from event's category id */
	function get_auction_products_ids_by_event_categorie( $event_cat_id ) {
		global $wpdb;
		$event_products_ids = array();
		$event_ids = get_event_ids_by_category($event_cat_id);
		if(!empty($event_ids)){
			$event_products_ids = [];
			foreach($event_ids as $event_id){
				$products_array = get_auction_products_ids_by_event( $event_id );
				if(!empty($products_array)){
					$original_array=unserialize($products_array);
					$event_products_ids = array_merge($event_products_ids,$original_array);
				}
			}
		}
		$event_products_ids = get_wpml_trans_product_ids($event_products_ids);
		return $event_products_ids;
	}


	function uat_get_event_sold_items( $event_id ) {
	global $wpdb;
	$sold_items =0;
	$sold_items_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);

   if ($original_array) {

		foreach ($original_array as $auction_id) {

			$woo_ua_auction_payed = get_post_meta($auction_id, 'woo_ua_auction_payed', true);
			if($woo_ua_auction_payed){
				$sold_items_array[] = $auction_id;
			}

		}
	}
	$sold_items = count($sold_items_array);
    return $sold_items;
}

 function uat_get_event_total_earnings( $event_id ) {
	global $wpdb;
	$total_earning_amt = 0;
	$sold_items_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);

   if ($original_array) {

		foreach ($original_array as $auction_id) {

			$woo_ua_auction_payed = get_post_meta($auction_id, 'woo_ua_auction_payed', true);
			if($woo_ua_auction_payed){
				$total_earning_amt += $wpdb->get_var("SELECT bid FROM ".UA_BIDS_TABLE." WHERE auction_id = $auction_id  ORDER BY  `bid` DESC limit 1");
			}

		}
	}

   return $total_earning_amt;
}

function uat_get_event_default_image() {
	$default_image = UAT_THEME_PRO_IMAGE_URI."front/event_default_banner.png";
	return $default_image;
}


/**
 * Return all event id as per parameter events ids
 *
 */
function uat_get_all_events_ids_by_filters($date_from="",$date_to="",$event_status="",$order="",$orderby="") {

	global $wpdb;
	$table = UA_EVENTS_TABLE;
	$all_events_ids = array();

	$order = $order ? $order : 'ASC';
	$orderby = $orderby ? $orderby : 'event_end_date';
	$date1 =$date_from;
	$date2 =$date_to;

	$date_where ="";
	if(!empty($date1) && !empty($date2)){

		$date_where = "and (event_end_date  BETWEEN '$date1' AND '$date2')";
		$date_where = "and CAST(event_end_date AS DATE) between '$date1' and '$date2'";
	}
	$query  ="SELECT post_id FROM $table WHERE post_status='publish' $date_where ORDER by $orderby $order";
	$results = $wpdb->get_results( $query );

	foreach($results as $row) {
	$all_events_ids[] =  $row->post_id;
	}
	$all_events_ids = get_wpml_trans_product_ids($all_events_ids, false);
	return $all_events_ids;

}

function ultimate_auction_theme_pro_event_tabs() {
	$event_tabs = array();
	$event_tabs['event_bid_increment'] = array(
		"title" =>__('Bid Increment', 'ultimate-auction-pro-software'),
		"callback" => "event_bid_increment",
	);
	$event_tabs['event_buyers_premium'] = array(
		"title" =>__("Buyer's Premium", 'ultimate-auction-pro-software'),
		"callback" => "event_buyers_premium",
	);
	$event_tabs['event_term_conditions'] = array(
		"title" =>__("Term & Conditions", 'ultimate-auction-pro-software'),
		"callback" => "event_term_conditions",
	);
	return apply_filters('ultimate_auction_theme_pro_event_tabs', $event_tabs);
}
function event_bid_increment( $event_tab ) {
	get_template_part( 'templates/events/event', 'bid-increment' );
}
function event_buyers_premium( $event_tab ) {
	get_template_part( 'templates/events/event', 'buyers-premium' );
}
function event_term_conditions( $event_tab ) {
	get_template_part( 'templates/events/event', 'terms-conditions' );
}
function uat_get_searched_term_estimate_values( $term ) {
	global $wpdb;
	$highest_estimate_price =100;
	$highest_estimate_price_array =array();
	$lowest_estimate_price =100;
	$lowest_estimate_price_array =array();

	$original_array  = get_auction_products_ids_by_search_term($term);
	if (empty($original_array)) {
	    // $highest_bids+100;
	}else{
    	$highest_bids_array =array();
		$lowest_bids_array =array();
    	if (!empty($original_array)) {
    		foreach ($original_array as $auction_id) {
    		    $highest_estimate_value =  get_post_meta($auction_id, 'uat_estimate_price_to', true);
				if(!empty($highest_estimate_value)){
					$highest_estimate_price_array[] = $highest_estimate_value;
				}
				$lowest_estimate_price_value =  get_post_meta($auction_id, 'uat_estimate_price_from', true);
				if(!empty($lowest_estimate_price_value)){
					$lowest_estimate_price_array[] = $lowest_estimate_price_value;
				}
    		}
    	}
    	if(!empty($highest_estimate_price_array)){
			$highest_estimate_price = max($highest_estimate_price_array);
		}
		if(!empty($lowest_estimate_price_array)){
			$lowest_estimate_price = min(array_filter($lowest_estimate_price_array));
		}
	}
	$highest_estimate_price = $highest_estimate_price+100;
	$lowest_estimate_price = $lowest_estimate_price+1;
    return array('highest'=>$highest_estimate_price,'lowest'=>$lowest_estimate_price);
}
function uat_get_event_highest_estimate_value( $event_id ) {
	global $wpdb;
	$highest_estimate_price =100;
	$highest_estimate_price_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);
   if ($original_array) {
		foreach ($original_array as $auction_id) {
			$highest_estimate_value =  get_post_meta($auction_id, 'uat_estimate_price_to', true);
			if(!empty($highest_estimate_value)){
				$highest_estimate_price_array[] = $highest_estimate_value;
			}
		}
	}
	if(!empty($highest_estimate_price_array)){
		$highest_estimate_price = max($highest_estimate_price_array);
	}
    return $highest_estimate_price+100;
}
function uat_get_event_lowest_estimate_value( $event_id ) {
	global $wpdb;
	$lowest_estimate_price =100;
	$lowest_estimate_price_array =array();
	$products_array = get_auction_products_ids_by_event( $event_id );
	$original_array=unserialize($products_array);
    if ($original_array) {
		foreach ($original_array as $auction_id) {
			$lowest_estimate_price_value =  get_post_meta($auction_id, 'uat_estimate_price_from', true);
			if(!empty($lowest_estimate_price_value)){
				$lowest_estimate_price_array[] = $lowest_estimate_price_value;
			}
		}
	}
	if(!empty($lowest_estimate_price_array)){
		$lowest_estimate_price = min(array_filter($lowest_estimate_price_array));
	}
    return $lowest_estimate_price+1;
}
function uat_get_event_category_highest_estimate_value( $event_cat_id ) {
	global $wpdb;
	$highest_estimate_price =100;
	$highest_estimate_price_array =array();
	$original_array  = get_auction_products_ids_by_event_categorie($event_cat_id);
	if (empty($original_array)) {
		$original_array[] = array();
	}
	$original_array = array_unique($original_array);
   	if ($original_array) {
		foreach ($original_array as $auction_id) {
			$highest_estimate_value =  get_post_meta($auction_id, 'uat_estimate_price_to', true);
			if(!empty($highest_estimate_value)){
				$highest_estimate_price_array[] = $highest_estimate_value;
			}
		}
	}
	if(!empty($highest_estimate_price_array)){
		$highest_estimate_price = max($highest_estimate_price_array);
	}
    return $highest_estimate_price+100;
}
function uat_get_event_category_lowest_estimate_value( $event_cat_id ) {
	global $wpdb;
	$lowest_estimate_price =100;
	$lowest_estimate_price_array =array();
	$original_array  = get_auction_products_ids_by_event_categorie($event_cat_id);
	if (empty($original_array)) {
		$original_array[] = array();
	}
	$original_array = array_unique($original_array);
    if ($original_array) {
		foreach ($original_array as $auction_id) {
			$lowest_estimate_price_value =  get_post_meta($auction_id, 'uat_estimate_price_from', true);
			if(!empty($lowest_estimate_price_value)){
				$lowest_estimate_price_array[] = $lowest_estimate_price_value;
			}
		}
	}
	if(!empty($lowest_estimate_price_array)){
		$lowest_estimate_price = min(array_filter($lowest_estimate_price_array));
	}
    return $lowest_estimate_price+1;
}

function uat_get_event_Categories( $event_id ) {
	$event_locs = get_the_term_list( $event_id, 'uat-event-cat', ' ', ', ' );
  return $event_locs;
}

function uat_get_event_status_custom_db($event_id){
	global $wpdb;
	$status ="";
	$status = $wpdb->get_var("SELECT event_status FROM ".UA_EVENTS_TABLE." WHERE post_id = $event_id");
	return $status;
}
function uat_update_event_status_to_custom_db($event_id,$event_status,$start_date){
	global $wpdb;
	$status ="";
	$status_update = $wpdb->get_var("UPDATE ".UA_EVENTS_TABLE." SET event_status = '".$event_status."',event_start_date = '".$start_date."' WHERE post_id = $event_id");
}
function get_uwa_var_inc_price_global_event($event_id = "") {
	$final_var_bid_inc = [];
	$uat_global_var_incremental_price = get_option('options_uat_global_var_incremental_price_event',"");
		if(!empty($uat_global_var_incremental_price)){
			for ($x = 0; $x < $uat_global_var_incremental_price; $x++) {
				$sub_var_bid_inc = [];
				$sub_start = get_option('options_uat_global_var_incremental_price_event_'.$x.'_start');
				if(!empty($sub_start)){
					$sub_var_bid_inc['start'] =$sub_start;
				}
				$sub_end = get_option('options_uat_global_var_incremental_price_event_'.$x.'_end',"");
				if(!empty($sub_end)){
					$sub_var_bid_inc['end'] =$sub_end;
				}
				$sub_inc_val = get_option('options_uat_global_var_incremental_price_event_'.$x.'_inc_val',"");
				if(!empty($sub_inc_val)){
					$sub_var_bid_inc['inc_val'] =$sub_inc_val;
				}
				$final_var_bid_inc[] = $sub_var_bid_inc;
			  }
			}
			return $final_var_bid_inc;
}
