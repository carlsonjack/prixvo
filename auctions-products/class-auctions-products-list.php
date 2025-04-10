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
class Uat_Manage_Auctions_List_Table extends WP_List_Table {
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
	        case 'auction_type':
			case 'check_all':
				$checkbox_input = '<input type="checkbox" name="log_ids[]"  class="log_check_one" />';
				$uat_post_id = $item['post_id'];
				if(!empty($uat_post_id)){
					$checkbox_input = '<input type="checkbox" name="log_ids[]"  class="log_check_one" data-id="'.$uat_post_id.'"/>';
				}
				return $checkbox_input;
				break;
	       case 'event_id':
			    $event_title = 'NA';
				$uat_event_id = $item['event_id'];
				if(!empty($uat_event_id)){
				   $event_title = '<a href='.get_edit_post_link($uat_event_id).'>'.get_the_title( $uat_event_id ).'</a>';
				}
				return $event_title;
				break;
	        case 'post_id':
				$title = 'NA';
				$uat_post_id = $item['post_id'];
				if(!empty($uat_post_id)){
				   $title = '<a href='.get_edit_post_link($uat_post_id).'>'.get_the_title( $uat_post_id ).'</a>';
				}
				return $title;
				break;
	        case 'auction_start_date':
				return mysql2date($datetimeformat ,$item['auction_start_date']);
				break;
			 case 'auction_end_date':
				return mysql2date($datetimeformat ,$item['auction_end_date']);
				break;
	        case 'current_bid':
				$current_bid = get_post_meta($item['post_id'], 'woo_ua_auction_current_bid', true);
				if(empty($current_bid)){
					$current_bid = get_post_meta($item['post_id'], 'woo_ua_opening_price', true);
				}
				return wc_price( $current_bid );
				break;
	        case 'reserve_price':
				$reserve_price = get_post_meta($item['post_id'], 'woo_ua_lowest_price', true);
				return wc_price( $reserve_price );
				break;
	        case 'highest_bid':
			        $auction_ID = $item['post_id'];
					$highest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
					return wc_price($highest_bid);
				break;
			case 'lowest_bid':
			        $auction_ID = $item['post_id'];
					$lowest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` asc limit 1' );
					return wc_price($lowest_bid);
				break;
			case 'final_bid_amt':
			        $auction_ID = $item['post_id'];
					$final_bid_amt = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
					return wc_price($final_bid_amt);
				break;
			case 'total_earnings':
			        $auction_ID = $item['post_id'];
			        $total_earning_amt =0;
					$woo_ua_auction_payed = get_post_meta($auction_ID, 'woo_ua_auction_payed', true);
					if($woo_ua_auction_payed){
						$total_earning_amt = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
					}
					return wc_price($total_earning_amt);
				break;
	        case 'uat_action':
	        	return $item[ $column_name ];
	        default:
	            return print_r($item, true); //Show the whole array for troubleshooting purposes
	    }
	}
	/**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_auction_name($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
		global $sitepress;
		$auction_id = $item['post_id'];
		$auction_url = get_the_permalink( $auction_id );
		$auction_url_edit = get_edit_post_link( $auction_id );
		$lang = "";
		if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
			$lang = "&lang=".ICL_LANGUAGE_CODE;
		}
		$actions = array(
			'delete' => sprintf('%s %d',__('ID:', 'ultimate-auction-pro-software'),$auction_id,),
			'edit' => sprintf('<a href="%s">%s</a>', $auction_url_edit, __('Edit', 'ultimate-auction-pro-software')),
			'view' => sprintf('<a href="?page=ua-auctions-details&p_id=%s'.$lang.'">%s</a>', $auction_id, __('Detail', 'ultimate-auction-pro-software')),
        );
		$title = '<a href='.get_edit_post_link($item['post_id']).'>'.get_the_title( $item['post_id'] ).'</a>';
		 return sprintf('%s %s',$title,$this->row_actions($actions));
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
		$auction_status = isset( $_REQUEST['auction-status'] ) ?  $_REQUEST['auction-status'] :"";
        $columns = array(
			'check_all' => __('<input type="checkbox" name="log_all" class="log_check_all" /> Check All', 'ultimate-auction-pro-software'),
			'auction_name' => __('Product Title', 'ultimate-auction-pro-software'),
            'event_id' => __('Event', 'ultimate-auction-pro-software'),
            'auction_start_date' => __('Start Date', 'ultimate-auction-pro-software'),
            'auction_end_date' => __('End Date', 'ultimate-auction-pro-software'),
            'current_bid' => __('Current Bid', 'ultimate-auction-pro-software'),
            'reserve_price' => __('Reserve Price', 'ultimate-auction-pro-software'),
        );
		if ($auction_status == 'uat_past') {
			$columns = array(
				'check_all' => __('<input type="checkbox" name="log_all" class="log_check_all" /> Check All', 'ultimate-auction-pro-software'),
				'auction_name' => __('Product Title', 'ultimate-auction-pro-software'),
                'event_id' => __('Event', 'ultimate-auction-pro-software'),
				'auction_start_date' => __('Start Date', 'ultimate-auction-pro-software'),
                'auction_end_date' => __('End Date', 'ultimate-auction-pro-software'),
				'highest_bid' => __('Highest Bid', 'ultimate-auction-pro-software'),
				'lowest_bid' => __('Lowest Bid','ultimate-auction-pro-software'),
				'final_bid_amt' => __('Final Bid Amount', 'ultimate-auction-pro-software'),
				'total_earnings' => __('Earnings', 'ultimate-auction-pro-software'),
			);
		}
		if ($auction_status == 'uat_future') {
			 $columns = array(
				'auction_name' => __('Product Title', 'ultimate-auction-pro-software'),
				'event_id' => __('Event', 'ultimate-auction-pro-software'),
				'auction_start_date' => __('Starting Date', 'ultimate-auction-pro-software'),
				'current_bid' => __('Opening Price', 'ultimate-auction-pro-software'),
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
            'auction_name' => array('auction_name', true),
            'event_id' => array('event_id', true),
            'auction_start_date' => array('auction_start_date', true),
            'auction_end_date' => array('auction_end_date', true),
            'current_bid' => array('current_bid', true),
			'reserve_price' => __('reserve_price', 'ultimate-auction-pro-software'),
            'bidders' => array('bidders', true),
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
        global $wpdb,$sitepress;
		if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
			$lang = ICL_LANGUAGE_CODE;
			$sitepress->switch_lang($lang);
		}
        $table_name = UA_AUCTION_PRODUCT_TABLE;
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
		$auction_status = isset( $_REQUEST['auction-status'] ) ?  $_REQUEST['auction-status'] :"";
		$auction_event = isset( $_REQUEST['auction-event'] ) ?  $_REQUEST['auction-event'] :"";
		if (!empty($auction_status) && empty($auction_event)) {
		   //echo "1";
		   $log_types_qry_where = " where auction_status ='".$auction_status."' ".$do_search;
		}
		elseif (!empty($auction_event) && empty($auction_status)){
			 //echo "2";
			$log_types_qry_where=" where event_id ='".$auction_event."'  ".$do_search;
		}
		elseif (!empty($auction_event) && !empty($auction_status)) {
			 //echo "3";
			$log_types_qry_where=" where auction_status ='".$auction_status."' and event_id ='".$auction_event."'  ".$do_search;
		}
		else {
				 //echo "4";
			$log_types_qry_where = "";
		}
		$from = ( isset( $_REQUEST['DateFrom'] ) && $_REQUEST['DateFrom'] ) ? $_REQUEST['DateFrom'] : '';
		$to = ( isset( $_REQUEST['DateTo'] ) && $_REQUEST['DateTo'] ) ? $_REQUEST['DateTo'] : '';
		 if( !($from=='' && $to=='') ){
			$log_types_qry_where = $log_types_qry_where."  AND (auction_end_date  BETWEEN '$from' AND '$to')";
		 }
		 if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
			$lang = ICL_LANGUAGE_CODE;
			if(  $lang != "all" ){
				$log_types_qry_where = $log_types_qry_where." where lang_code='".$lang."'";
			}
		}

        // will be used in pagination settings
		$total_items = $wpdb->get_var("SELECT COUNT(DISTINCT post_id) FROM $table_name $log_types_qry_where");
        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] -1) * $per_page) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'post_id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'desc';

		// echo "SELECT * FROM $table_name $log_types_qry_where ORDER BY $orderby $order LIMIT $per_page OFFSET $paged";
		$this->items = $wpdb->get_results("SELECT * FROM $table_name $log_types_qry_where GROUP BY post_id ORDER BY $orderby $order LIMIT $per_page OFFSET $paged", ARRAY_A);
        // [REQUIRED] configure pagination
        $this->set_pagination_args(array(
            'total_items' => $total_items, // total items defined above
            'per_page' => $per_page, // per page constant defined at top of method
            'total_pages' => ceil($total_items / $per_page) // calculate pages count
        ));
    }
	function extra_tablenav( $which ) {
    global $wpdb, $testiURL, $tablename, $tablet;
    if ( $which == "top" ){
        ?>
        <?php
		$auction_status = isset( $_REQUEST['auction-status'] ) ?  $_REQUEST['auction-status'] :"";
		?>
		<div class="alignleft actions bulkactions">
		<select name="auction-status">
	            <option value=""><?php _e( 'Auction filter By', 'ultimate-auction-pro-software');?> </option>
	        	<option <?php selected( "uat_live", $auction_status ); ?> value="uat_live"><?php _e( 'Live', 'ultimate-auction-pro-software');?></option>
				<option <?php selected( "uat_future", $auction_status ); ?> value="uat_future"><?php _e( 'Future', 'ultimate-auction-pro-software');?></option>
				<option <?php selected( "uat_past", $auction_status ); ?> value="uat_past"><?php _e( 'Past', 'ultimate-auction-pro-software');?></option>
		</select>
			<?php
			$current_event = isset( $_REQUEST['auction-event'] ) ?  $_REQUEST['auction-event'] :"";
			$args = array (
						'post_type'              => array( 'uat_event' ),
						'post_status'            => array( 'Publish' ),
						'posts_per_page'         => -1,
						'orderby'                  => 'title',
						'order'                  => 'ASC',
			);
			$query = new WP_Query( $args );  ?>
			<select id="auction-event" name="auction-event">
			<option value=""><?php _e( 'All Event', 'ultimate-auction-pro-software' ); ?></option>
				<?php
					while ( $query->have_posts() ) : $query->the_post();
					?>
					<option value="<?php the_ID(); ?>" <?php selected( get_the_ID(), $current_event ); ?>><?php the_title();?></option>
					<?php  endwhile; wp_reset_query(); ?>
			</select>
			<input type="hidden" name="post_ids" class="post_ids_h">
		<?php
		if($auction_status =="uat_past" || $auction_status =="uat_live"){
		wp_register_style( 'jquery-ui', UAT_THEME_PRO_CSS_URI.'jquery-ui.css', array(), UAT_THEME_PRO_VERSION );
		wp_enqueue_style( 'jquery-ui' );
				$from = ( isset( $_GET['DateFrom'] ) && $_GET['DateFrom'] ) ? $_GET['DateFrom'] : '';
				$to = ( isset( $_GET['DateTo'] ) && $_GET['DateTo'] ) ? $_GET['DateTo'] : '';
				$post_ids = ( isset( $_GET['post_ids'] ) && $_GET['post_ids'] ) ? $_GET['post_ids'] : '';
				echo '<style>
				input[name="DateFrom"], input[name="DateTo"]{
					line-height: 28px;
					height: 28px;
					margin: 0;
					width:125px;
				}
				</style>
				<input type="text" name="DateFrom" placeholder="End Date From" value="' . esc_attr( $from ) . '" />
				<input type="text" name="DateTo" placeholder="End Date To" value="' . esc_attr( $to ) . '" />
				<input type="hidden" name="post_ids" value="' . esc_attr( $post_ids ) . '" />
				<script>
				jQuery( function($) {
					var from = $(\'input[name="DateFrom"]\'),
						to = $(\'input[name="DateTo"]\');
					$( \'input[name="DateFrom"], input[name="DateTo"]\' ).datepicker( {dateFormat : "yy-mm-dd"} );
						from.on( \'change\', function() {
						to.datepicker( \'option\', \'minDate\', from.val() );
					});
					to.on( \'change\', function() {
						from.datepicker( \'option\', \'maxDate\', to.val() );
					});
				});
				</script>'; ?>
			<a href="<?php echo admin_url( 'admin.php?page=ua-auctions-theme-products-lots' ) ?>&action=uat_download_csv&_wpnonce=<?php echo wp_create_nonce( 'uat_download_csv' )?>&DateFrom=<?php echo $from; ?>&DateTo=<?php echo $to; ?>&auction-status=<?php echo $auction_status; ?>&post_ids=<?php echo $post_ids; ?>" class="page-title-action export-link"><?php _e('Export to CSV','ultimate-auction-pro-software');?></a>
		<?php } ?>
		<?php submit_button( __( 'Filter', 'ultimate-auction-pro-software' ), 'secondary', 'submit', false ); ?>
        </div>
        <?php
    }
	}
} /* end of class */
function uat_manage_auctions_list_page_handler_display() {
	global $wpdb;
	$table = new Uat_Manage_Auctions_List_Table();
	$table->prepare_items();
?>
	<div class="wrap welcome-wrap uat-admin-wrap">
		<?php echo uat_admin_side_top_menu();  ?>
		<h1 class="uat_theme_admin_page_title"> <?php _e( 'Auction Products(Lots)', 'ultimate-auction-pro-software' ); ?>
		<a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), '/post-new.php?post_type=product');?>"><?php _e('Add New', 'ultimate-auction-pro-software')?></a>
		</h1>
			<form id="persons-table" method="GET">
			<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
			<?php $table->search_box( __( 'Search' ), 'search-box-id' );?>
			<?php $table->display();?>
			</form>
		</div>
			<?php
} /* end of fuction - uat_manage_auctions_list_page_handler_display */
?>