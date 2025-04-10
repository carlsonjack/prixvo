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
  class Uat_Bids_List_Table extends WP_List_Table {
	 /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'auctions_lots_list',
            'plural' => 'auctions_lots_lists',
			'ajax'      => false 
        ));
    }
		
	public function column_default($item, $column_name){
		global $wpdb;
		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		$PRODUCT_TABLE = UA_AUCTION_PRODUCT_TABLE;
	    switch ($column_name) {	             
	        case 'bid':
				return wc_price($item['bid'] );				
				break;
			case 'userid':
				$user_name = "<a href=".get_edit_user_link($item['userid']).">".uat_user_display_name($item['userid'])."</a>";			    
				return $user_name;				
				break;	
	        case 'date':
				return mysql2date($datetimeformat ,$item['date']);
				break;
			 case 'proxy':
			    $proxy ="No";
				if($item['proxy'] ==1){
					$proxy ="Yes";
				}
				return $proxy;
				break;		        
	        default:
	            return print_r($item, true); //Show the whole array for troubleshooting purposes
	    }
	}

 function get_columns() {
	  $uwa_bid_type = isset($_GET["uwa_bid_type"]) ? $_GET["uwa_bid_type"] : "active";
        $columns = array(
            'bid' => __('Bid Value', 'ultimate-auction-pro-software'),           
            'userid' => __('User', 'ultimate-auction-pro-software'),           
            'date' => __('Date Time', 'ultimate-auction-pro-software'),          
            'proxy' => __('Proxy Bid','ultimate-auction-pro-software'),                   
			
        );
		
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
            'bid_value' => array('bid_value', true),
            'max_bid_value' => array('max_bid_value', true),
            'winning_bid_bidders' => array('winning_bid_bidders', true),
        );
        return $sortable_columns;
    }
	
	/**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix."woo_ua_auction_log";
        $per_page = 50; // constant, how much records will be shown per page
		if(isset($_REQUEST['s'])) {			
			$search = $_REQUEST['s'];
		}
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();		

        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

		$search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : false;	
		$do_search = ( $search ) ? $wpdb->prepare(" and  (`auction_name` LIKE '%%%s%%' OR `auction_name` LIKE '%%%s%%')" , $search, $search) : '';	
		
		
		$auction_id = isset( $_REQUEST['p_id'] ) ?  $_REQUEST['p_id'] :"";
		if (!empty($auction_id)) {	
		  // echo "1";
		   $log_types_qry_where = " where auction_id ='".$auction_id."' ".$do_search;
		}		
		
			
        // will be used in pagination settings        
		$total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $log_types_qry_where");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] -1) * $per_page) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

		//echo "SELECT * FROM $table_name $log_types_qry_where ORDER BY $orderby $order LIMIT $per_page OFFSET $paged";
		$this->items = $wpdb->get_results("SELECT * FROM $table_name $log_types_qry_where ORDER BY $orderby $order LIMIT $per_page OFFSET $paged", ARRAY_A);
		
		//print_r($test);
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
	


}
/* end of class */

	
function uat_bids_list_page_handler_display() {
		global $wpdb;
		$myListTable = new Uat_Bids_List_Table();
		$myListTable->prepare_items();
	?>
		
		<div class="uat_main_setting wrap">	
		<h1 class="uat_admin_page_title">
					<?php _e( 'Bids Information', 'ultimate-auction-pro-software' ); ?>
		</h1>
			<form id="persons-table" method="GET">	
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>			
			<?php $myListTable->search_box( __( 'Search' ), 'search-box-id' );?>			
			<?php $myListTable->display();?>				
			</form>	

		</div>	
		
		<?php
}
?>