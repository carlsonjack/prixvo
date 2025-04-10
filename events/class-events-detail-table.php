<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* == NOTICE ===================================================================
 * Please do not alter this file. Instead: make a copy of the entire plugin,
 * rename it, and work inside the copy. If you modify this plugin directly and
 * an update is released, your changes will be lost!
 * ========================================================================== */



/*************************** LOAD THE BASE CLASS *******************************
 *******************************************************************************
 * The WP_List_Table class isn't automatically available to plugins, so we need
 * to check if it's available and load it if necessary. In this tutorial, we are
 * going to use the WP_List_Table class directly from WordPress core.
 *
 * IMPORTANT:
 * Please note that the WP_List_Table class technically isn't an official API,
 * and it could change at some point in the distant future. Should that happen,
 * I will update this plugin with the most current techniques for your reference
 * immediately.
 *
 * If you are really worried about future compatibility, you can make a copy of
 * the WP_List_Table class (file path is shown just below) to use and distribute
 * with your plugins. If you do that, just remember to change the name of the
 * class to avoid conflicts with core.
 *
 * Since I will be keeping this tutorial up-to-date for the foreseeable future,
 * I am going to work with the copy of the class provided in WordPress core.
 */

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/************************** CREATE A PACKAGE CLASS *****************************
 *******************************************************************************
 * Create a new list table package that extends the core WP_List_Table class.
 * WP_List_Table contains most of the framework for generating the table, but we
 * need to define and override some methods so that our data can be displayed
 * exactly the way we need it to be.
 *
 * To display this example on a page, you will first need to instantiate the class,
 * then call $yourInstance->prepare_items() to handle any data manipulation, then
 * finally call $yourInstance->display() to render the table to the page.
 *
 * Our theme for this list table is going to be movies.
 */

class UAT_Auctions_List_In_Event_Table extends WP_List_Table {
	public $allData;

	/**
     * Get auction data
     *
     * @param int $per_page, $page_number
     * @return array
     *
     */
	public function uwa_auction_in_event_get_data($per_page, $page_number){
		global $wpdb,$sitepress;

		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		$search = (isset($_POST['uat_auction_search'])) ? $_POST['uat_auction_search'] : '';
		$pagination = ((int)$page_number - 1) * (int)$per_page;
    $event_id = $_REQUEST['event_id'];
		if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
			$event_id = icl_object_id($event_id,'product',false, ICL_LANGUAGE_CODE);
		}
		$meta_query= array(
			array(
					'key' => 'uat_event_id',
					'value' => $event_id,
					'compare' => '=',
					)
			);
		$event_status = uat_get_event_status($event_id);
		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => $per_page,
			'offset' => $pagination,
			// 'post__in' => $original_array,
			's'=> $search,
			'meta_query' => $meta_query,
			'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
			'auction_arhive' => TRUE
		);

		$auction_item_array = new WP_Query($args);
		$auction_item_array = $auction_item_array->posts;
		$data_array = array();
		foreach ($auction_item_array as $single_auction) {
			$row = array();
			$product_id = $single_auction->ID;

			/* Product auction_lot_number column */
				$row['auction_lot_number'] = '';
				$row['auction_lot_number'] = '#<a href="'.get_permalink( $product_id ).'">'.get_post_meta($product_id, 'uat_auction_lot_number', true).'</a>';


			/* Product Title column */
				$row['title'] = '';
				$row['title'] = '<a href="?page=ua-auctions-details&p_id='.$product_id.'">'.get_the_title(  $product_id ).'</a>';

			/* Product highest_bid column */
				$highest_bid = 0;
				$highest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $product_id .'  ORDER BY  `bid` DESC limit 1');
				$row['highest_bid'] = wc_price($highest_bid);
				$lowest_bid = 0;
				/* Product lowest_bid column */
				$lowest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $product_id .'  ORDER BY  `bid` asc limit 1' );
				$row['lowest_bid'] = wc_price($lowest_bid);

			if ($event_status == 'uat_past' || $event_status == 'uat_live') {
				/* Product opening_price column */
				$row['opening_price'] = '';
				$row['opening_price'] = wc_price(get_post_meta($product_id, 'woo_ua_opening_price', true));

				/* Product no_of_bids column */
				$no_of_bids = $wpdb->get_var( 'SELECT COUNT(*) FROM  '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $product_id .'' );
				if(empty($no_of_bids)){
				    $no_of_bids = 0;
				}
				$row['no_of_bids'] = $no_of_bids;
			}

			if ($event_status == 'uat_future') {

				/* Product opening_price column */
				$row['opening_bid'] = '';
				$row['opening_bid'] = wc_price(get_post_meta($product_id, 'woo_ua_opening_price', true));

				/* Product buy_now_price column */
				$row['buy_now_price'] = '';
				$row['buy_now_price'] = wc_price(get_post_meta($product_id, '_regular_price', true));

				/* Product reserve_price column */
				$row['reserve_price'] = '';
				$row['reserve_price'] = wc_price(get_post_meta($product_id, 'woo_ua_lowest_price', true));

			}

			if ($event_status == 'uat_past') {
				/* Product final_bid_amt column */
				$row['final_bid_amt'] = '';
				$row['final_bid_amt'] = wc_price(get_post_meta($product_id, 'woo_ua_auction_current_bid', true));

			/* Product bp_amt column */
				$row['bp_amt'] = '';
				$row['bp_amt'] = wc_price(get_post_meta($product_id, '_uwa_stripe_auto_debit_bpm_amt', true));

				$row['total_earnings'] = '';
				$row['total_earnings'] = wc_price(get_post_meta($product_id, '_uwa_stripe_auto_debit_bpm_amt', true));

			}


			$data_array[] = $row;
	    }

		$this->allData = $data_array;
		return $data_array;
	}

	/**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     *
     */
    function get_columns() {
		uat_event_is_past_event($_REQUEST['event_id']);
		$event_status = uat_get_event_status($_REQUEST['event_id']);
        $columns = array(
				'auction_lot_number' => __('#Lot No.', 'ultimate-auction-pro-software'),
				'title' => __('Title', 'ultimate-auction-pro-software'),
				'opening_price' => __('Opening Price', 'ultimate-auction-pro-software'),
				'no_of_bids' => __('Number of Bids', 'ultimate-auction-pro-software'),
				'highest_bid' => __('Highest Bid', 'ultimate-auction-pro-software'),
				'lowest_bid' => __('Lowest Bid','ultimate-auction-pro-software'),
			);

		if ($event_status == 'uat_past') {
			$columns = array(
				'auction_lot_number' => __('#Lot No.', 'ultimate-auction-pro-software'),
				'title' => __('Title', 'ultimate-auction-pro-software'),
				'no_of_bids' => __('Number of Bids', 'ultimate-auction-pro-software'),
				'highest_bid' => __('Highest Bid', 'ultimate-auction-pro-software'),
				'lowest_bid' => __('Lowest Bid','ultimate-auction-pro-software'),
				'final_bid_amt' => __('Final Bid Amount', 'ultimate-auction-pro-software'),
				'bp_amt' => __("Buyer's Premium Amount",'ultimate-auction-pro-software'),
				'total_earnings' => __('Earnings', 'ultimate-auction-pro-software'),
			);
		}

		if ($event_status == 'uat_future') {
			 $columns = array(
				'auction_lot_number' => __('#Lot No.', 'ultimate-auction-pro-software'),
				'title' => __('Title', 'ultimate-auction-pro-software'),
				'opening_bid' => __('Opening Bid', 'ultimate-auction-pro-software'),
				'buy_now_price' => __('Buy It Now price', 'ultimate-auction-pro-software'),
				'reserve_price' => __('Reserve Price', 'ultimate-auction-pro-software'),
			);
		}
        return $columns;
    }

	/**
     * [OPTIONAL] This method return columns that may be used to sort table
     * all strings in array - is column names
     * notice that true on name column means that its default sort
     *
     * @return array
     *
     */

    function get_sortable_columns(){
        $sortable_columns = array(
            'auction_lot_number' => array('auction_lot_number', true),
            'title' => array('title', true),
            'no_of_bids' => array('no_of_bids', true),
            'highest_bid' => array('highest_bid', true),
            'lowest_bid' => array('lowest_bid', true),
        );
        return $sortable_columns;
    }


	/**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items() {
		global $wpdb,$sitepress;
		$lot_ids_array  = get_auction_products_ids_by_event( $_REQUEST['event_id'] );
		$original_array=unserialize($lot_ids_array);
		$search = (isset($_POST['uat_auction_search'])) ? $_POST['uat_auction_search'] : '';
		$columns = $this->get_columns();
		$hidden = array();
		$per_page = '';
        $current_page = '';
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array($columns, $hidden, $sortable);
		$orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'title';
		if ($orderby === 'title') {
			$this->items = $this->uat_auction_sort_array($this->uwa_auction_in_event_get_data($per_page, $current_page));
		} else {
			$this->items = $this->uwa_auction_in_event_get_data($per_page, $current_page);
		}

		$per_page = 50;
        $current_page = $this->get_pagenum();
		$meta_query= array(
						array(
								'key' => 'uat_event_id',
								'value' => $_REQUEST['event_id'],
								'compare' => '=',
								)
						);

		$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' => -1,
			'post__in' => $original_array,
			's'=> $search,
			'meta_query' => array($meta_query),
			'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
			'auction_arhive' => TRUE
		);
		if (function_exists('icl_object_id') && method_exists($sitepress, 'get_current_language')) {

			$args['suppress_filters']=0;
		}
		$auctions =  new WP_Query($args);
		$auctions = $auctions->posts;
	    $total_items = count($auctions);
    	$this->found_data = array_slice($this->allData, (($current_page - 1) * $per_page), $per_page);
		$this->set_pagination_args(array(
			'total_items' => $total_items,
			'per_page' => $per_page,
			));
		 $this->items = $this->uat_auction_sort_array($this->uwa_auction_in_event_get_data($per_page, $current_page));
	}

	public function get_result_e(){
    	return $this->allData;
	}

	public function uat_auction_sort_array($args){

    	if (!empty($args)) {
        	$orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'title';

			if($orderby === 'opening_price') {
	            $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
	        }
			if($orderby === 'auction_lot_number') {
	            $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
	        }
			else {
	            $order = 'desc';
	        }

	        foreach ($args as $array) {
	            $sort_key[] = $array[$orderby];
	        }

	        if ($order == 'asc') {
	            array_multisort($sort_key, SORT_ASC, $args);
	        } else {
	            array_multisort($sort_key, SORT_DESC, $args);
	        }
    	}
    	return $args;
	}

	public function column_default($item, $column_name){
	    switch ($column_name) {
	        case 'auction_lot_number':
	        case 'auction_image':
	        case 'title':
	        case 'opening_price':
	        case 'no_of_bids':
	        case 'highest_bid':
	        case 'lowest_bid':
	        case 'opening_bid':
	        case 'buy_now_price':
	        case 'reserve_price':
	        case 'final_bid_amt':
	        case 'total_earnings':
	        case 'bp_amt':
	        	return $item[ $column_name ];
	        default:
	            return print_r($item, true); //Show the whole array for troubleshooting purposes
	    }
	}

} /* end of class */

function uat_auctions_events_detail_list_display() {
	$events_table = new UAT_Auctions_List_In_Event_Table();
	$events_table->prepare_items();
	?>
	<div class="wrap">
		<h1><?php _e( 'Product Information', 'ultimate-auction-pro-software' ); ?></h1>

		<div class="uat-action-container" style="float:right;margin-right: 10px;">
			<form action="" method="POST">
				<input type="text" name="uat_auction_search" value="<?php echo (isset($_POST['uat_auction_search'])) ? $_POST['uat_auction_search'] : ''; ?>" />
				<input type="submit" class="button-secondary" name="uat_auction_search_submit" value="<?php  echo esc_attr('Search'); ?>" />
			</form>
        </div>

		<form id="edd-events-filter" method="get" action="">

			<?php $events_table->display() ?>
		</form>

	</div>
<?php
	}