<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

/**
 * mcc my app menu list class that will display our custom table
 * records in nice table
 */
class Uat_Logs_List_Table extends WP_List_Table
{
    /**
     * [REQUIRED] You must declare constructor and give some basic params
     */
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'activity_list',
            'plural' => 'activity_list',
			'ajax'      => false
        ));
    }

    /**
     * [REQUIRED] this is a default column renderer
     *
     * @param $item - row (key, value array)
     * @param $column_name - string (key)
     * @return HTML
     */
    public function column_default($item, $column_name){
		global $wpdb;
		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		$UA_ACTIVITYMETA = UA_ACTIVITYMETA_TABLE;
		switch ($column_name) {
			case 'activity_id':
				return $item[ $column_name ];
				break;
	        case 'auction_name':
				return $item[ $column_name ];
				break;
	        case 'event_title':
			    $event_title = 'N/A';
				$uat_event_id = get_post_meta($item['post_parent'],'uat_event_id',true);
				if(!empty($uat_event_id)){
				   $event_title = '<a href='.get_edit_post_link($uat_event_id).'>'.get_the_title( $uat_event_id ).'</a>';
				}
				return $event_title;
				break;
	        case 'p_title':
				$p_title = '<a href='.get_edit_post_link($item['post_parent']).'>'.get_the_title( $item['post_parent'] ).'</a>';
				return $p_title;
				break;

	        case 'activity_name':
				return $item['activity_name'];
				break;

			case 'user':
				$user_id = $item['activity_by'];
			    $user_obj = get_user_by( 'ID', $user_id);
				if(!empty($user_obj)){
					$user_name = '<a href='.get_edit_user_link($user_id).'>'.$user_obj->user_login.'</a>';
				} else {
					$user_name = 'N/A';
				}
				return $user_name;
				break;

			case 'bid_value':
			    $bid_value = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='bid_value'");
				return wc_price($bid_value);
				break;

			case 'activity_date':
				return mysql2date($datetimeformat ,$item['activity_date']);
				break;

			case 'bid_sms':
				$bid_sms = "";
				return $bid_sms;
				break;

			case 'bid_p_hold':
				$bid_p_hold = "";
				$activityhold_ID = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='hold_activity_id'");
				if(!empty($activityhold_ID)){
				$bid_p_hold .="<a title='Message' href='?page=ua-auctions-reports&logs-types=ua_payment_hold_logs&bid_id=".$activityhold_ID."' class='button button-secondary'>".__('View Detail', 'ultimate-auction-pro-software').'</a>';
				}
				return $bid_p_hold;
				break;

			case 'sms_type':
				$sms_type = "";
				return $sms_type;
				break;

			case 'sms_recipient':
				$sms_recipient = "";
				return $sms_recipient;
				break;

			case 'sms_status':
				$sms_status = "";
				return $sms_status;
				break;

			case 'sms_view_detail':
				$sms_view_detail = "";
				return $sms_view_detail;
				break;

			case 'p_hold_status':
				$p_hold_status = "";
				$p_hold_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='p_hold_status'");
				return $p_hold_status;
				break;
			case 'p_release_status':
				$p_release_status = "";
				$p_release_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='p_release_status'");
				return $p_release_status;
				break;
			case 'p_hold_view_detail':
				$p_hold_view_detail = "";

				if(!empty($item['activity_data'])){
				$p_hold_view_detail = "<a title='Payment HOLD Response' href='#TB_inline?&width=600&height=550&inlineId=hold-id-".$item['activity_id']."' class='button button-secondary thickbox'>".__('View Detail', 'ultimate-auction-pro-software').'</a>';
				?>
				<div id="hold-id-<?php echo $item['activity_id'];?>" style="display:none;">
					<p>
					<?php echo $item['activity_data'];?></p>
				</div>
				<?php }
				return $p_hold_view_detail;
				break;
			case 'p_debit_status':
				$p_debit_status = "";
				$p_debit_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='p_debit_status'");
				return $p_debit_status;
				break;
			case 'p_debit_view_detail':
				$p_debit_view_detail = "";
				if(!empty($item['activity_data'])){
				$p_debit_view_detail = "<a title='Payment HOLD Response' href='#TB_inline?&width=600&height=550&inlineId=message-id-".$item['activity_id']."' class='button button-secondary thickbox'>".__('View Detail', 'ultimate-auction-pro-software').'</a>';
				?>
				<div id="message-id-<?php echo $item['activity_id'];?>" style="display:none;">
					<p>
					<?php echo $item['activity_data'];?></p>
				</div>
				<?php }
				return $p_debit_view_detail;
				break;
			case 'api_name':
				$api_name = "";
				$api_name = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='api_name'");
				return $api_name;
				break;
			case 'api_response_status':
				$api_response_status = "";
				$api_response_status = $wpdb->get_var("SELECT meta_value FROM $UA_ACTIVITYMETA WHERE activity_id = ".$item['activity_id']." AND meta_key ='api_response_status'");
				return $api_response_status;
				break;
			case 'view_api_log':
				$view_api_log = "";
				if(!empty($item['activity_data'])){
				$view_api_log = "<a title='Payment HOLD Response' href='#TB_inline?&width=600&height=550&inlineId=api-log-id-".$item['activity_id']."' class='button button-secondary thickbox'>".__('View Detail', 'ultimate-auction-pro-software').'</a>';
				?>
				<div id="api-log-id-<?php echo $item['activity_id'];?>" style="display:none;">
					<p>
					<?php echo $item['activity_data'];?></p>
				</div>
				<?php }
				return $view_api_log;
				break;
			default:
				$default_value = isset( $item[ $column_name ] ) ? $item[ $column_name ] : '';
    			break;

	    }
	}

    /**
     * [OPTIONAL] this is example, how to render column with actions,
     * when you hover row "Edit | Delete" links showed
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_activity_id($item)
    {
        // links going to /admin.php?page=[your_plugin_page][&other_params]
        // notice how we used $_REQUEST['page'], so action will be done on curren page
        // also notice how we use $this->_args['singular'] so in this example it will
        // be something like &person=2
		$auction_id = $item['post_parent'];
		$actions = array(
            'delete' => sprintf('<a href="?page=%s&action=delete&activity_id=%s">%s</a>', $_REQUEST['page'], $item['activity_id'], __('Delete', 'ultimate-auction-pro-software')),
			'view' => sprintf('<a href="?page=uat-auctions-activity-details&p_id=%s">%s</a>', $auction_id, __('Detail', 'ultimate-auction-pro-software')),
        );

		 return sprintf('%s %s',$item['activity_id'],$this->row_actions($actions));

    }

    /**
     * [REQUIRED] this is how checkbox column renders
     *
     * @param $item - row (key, value array)
     * @return HTML
     */
    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="activity_id[]"   value="%s"/>',
            $item['activity_id']
        );

    }

    /**
     * [REQUIRED] This method return columns to display in table
     * you can skip columns that you do not want to show
     * like content, or description
     *
     * @return array
     */
    function get_columns() {
		$log_types = isset( $_REQUEST['logs-types'] ) ?  $_REQUEST['logs-types'] :"ua_bids";

		$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'event_title' => __('Event Name', 'ultimate-auction-pro-software'),
			 'p_title' => __('Product Name', 'ultimate-auction-pro-software'),
			 'user' => __('User', 'ultimate-auction-pro-software'),
			 'activity_name' => __('Action Detail', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Date & Time', 'ultimate-auction-pro-software'),

        );
		/*	Log ID
		Event Name
		Product Name
		Action Detail - Which part updated (View Detail)
		User
		Date & Time*/

		/*if($log_types =="ua_products"){
			$columns = array(
			 'activity_id' => '<input class="uat_select_all_chk" type="checkbox" style="margin: 0 10px 0 0;" />  '.__('Log ID', 'ultimate-auction-pro-software'),
			 'event_title' => __('Event Name', 'ultimate-auction-pro-software'),
			 'p_title' => __('Product Name', 'ultimate-auction-pro-software'),
			 'user' => __('User', 'ultimate-auction-pro-software'),
			 'action' => __('Action Detail', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Date & Time', 'ultimate-auction-pro-software'),

			);

		}*/
		/*
		Log ID
		Event Name
		Product Name
		Action Detail -
		Bid Value
		User name
		Timestamp
		Email Status	Yes, View Detail
		SMS Status	Yes, View Detail
		Payment Hold Status	Yes, View Detail
		*/
		if($log_types =="ua_bids"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'event_title' => __('Event Name', 'ultimate-auction-pro-software'),
			 'p_title' => __('Product Name', 'ultimate-auction-pro-software'),
			 'activity_name' => __('Action Detail', 'ultimate-auction-pro-software'),
			 'bid_value' => __('Bid Value', 'ultimate-auction-pro-software'),
			 'user' => __('User name', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Timestamp', 'ultimate-auction-pro-software'),
			// 'bid_sms' => __('SMS Status', 'ultimate-auction-pro-software'),
			 'bid_p_hold' => __('Payment Hold Status', 'ultimate-auction-pro-software'),

			);
		}

		/*
		Log ID
		Event Name
		Product Name
		SMS Type
		SMS Recipient
		Date Sent
		Status
		View Detail
		*/

		if($log_types =="ua_sms"){
			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'event_title' => __('Event Name', 'ultimate-auction-pro-software'),
			 'p_title' => __('Product Name', 'ultimate-auction-pro-software'),
			 'sms_type' => __('SMS Type', 'ultimate-auction-pro-software'),
			 'sms_recipient' => __('SMS Recipient', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Date Sent', 'ultimate-auction-pro-software'),
			 'sms_status' => __('Status', 'ultimate-auction-pro-software'),
			 'sms_view_detail' => __('View Detail', 'ultimate-auction-pro-software'),

			);
		}

		/*
		Log ID
		Bidder Name
		Bid Value
		Timestamp
		Hold Status - Yes/No
		View Detail
		Refund Status
		View Detail
		*/

		if($log_types =="ua_payment_hold_logs"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'user' => __('Bidder Name', 'ultimate-auction-pro-software'),
			 'bid_value' => __('Bid Value', 'ultimate-auction-pro-software'),
			 'p_hold_status' => __('Hold Status', 'ultimate-auction-pro-software'),
			 'p_release_status' => __('Refund Status', 'ultimate-auction-pro-software'),
			 'p_hold_view_detail' => __('View Detail', 'ultimate-auction-pro-software'),

			);
		}
		/*
		Log ID
		Winner Name
		Winning Bid Value
		Timestamp
		Debit Status - Yes/No
		View Detail
		*/


		if($log_types =="ua_payment_debit_logs"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'user' => __('Winner Name', 'ultimate-auction-pro-software'),
			 'bid_value' => __('Winning Bid Value', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Timestamp', 'ultimate-auction-pro-software'),
			 'p_debit_status' => __('Debit Status', 'ultimate-auction-pro-software'),
			 'p_debit_view_detail' => __('View Detail', 'ultimate-auction-pro-software'),

			);
		}

		if($log_types =="ua_payment_direct_debit_logs"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'user' => __('Winner Name', 'ultimate-auction-pro-software'),
			 'bid_value' => __('Winning Bid Value', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Timestamp', 'ultimate-auction-pro-software'),
			 'p_debit_status' => __('Debit Status', 'ultimate-auction-pro-software'),
			 'p_debit_view_detail' => __('View Detail', 'ultimate-auction-pro-software'),

			);
		}

		/*
		Log ID
		API Name
		API Response Status
		Timestamp
		View API Log
		*/

		if($log_types =="ua_api_requests_logs"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'api_name' => __('API Name', 'ultimate-auction-pro-software'),
			 'api_response_status' => __('API Response Status', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Timestamp', 'ultimate-auction-pro-software'),
			 'view_api_log' => __('View API Log', 'ultimate-auction-pro-software'),

			);
		}
		if($log_types =="ua_private_msg"){

			$columns = array(
			 'cb' => '<input type="checkbox" />', //Render a checkbox instead of text
			 'activity_id' => __('Log ID', 'ultimate-auction-pro-software'),
			 'event_title' => __('Event Name', 'ultimate-auction-pro-software'),
			 'p_title' => __('Product Name', 'ultimate-auction-pro-software'),
			 'email_sender' => __('Email Sender', 'ultimate-auction-pro-software'),
			 'activity_date' => __('Date Sent', 'ultimate-auction-pro-software'),
			 'email_view_detail' => __('View Detail', 'ultimate-auction-pro-software'),

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
     */
    function get_sortable_columns()
    {
        $sortable_columns = array(
            'activity_name' => array('activity_name', true),
            'activity_date' => array('activity_date', true),

        );
        return $sortable_columns;
    }

    /**
     * [OPTIONAL] Return array of bult actions if has any
     *
     * @return array
     */
    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    /**
     * [OPTIONAL] This method processes bulk actions
     * it can be outside of class
     * it can not use wp_redirect coz there is output already
     * in this example we are processing delete action
     * message about successful deletion will be shown on page in next part
     */
    function process_bulk_action()
    {
        global $wpdb;
        $table_name = UA_ACTIVITY_TABLE; // do not forget about tables prefix

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['activity_id']) ? $_REQUEST['activity_id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE activity_id IN($ids)");
            }
        }
    }


    /**
     * [REQUIRED] This is the most important method
     *
     * It will get rows from database and prepare them to be showed in table
     */
    function prepare_items()
    {
        global $wpdb;
        $table_name = UA_ACTIVITY_TABLE;

        $per_page = 50; // constant, how much records will be shown per page
		if(isset($_REQUEST['s'])) {

			$search = $_REQUEST['s'];
		}


        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();


        // here we configure table headers, defined in our methods
        $this->_column_headers = array($columns, $hidden, $sortable);

        // [OPTIONAL] process bulk action if any
        $this->process_bulk_action();

		$search = ( isset( $_REQUEST['s'] ) ) ? $_REQUEST['s'] : "";
		//$do_search = ( $search ) ? $wpdb->prepare(" and  (`activity_name` LIKE '%%%s%%' OR `activity_type` LIKE '%%%s%%')" , $search, $search) : '';
		
		$log_types_qry_where ="";
		$where_filter_by ="";
		$log_types = isset( $_REQUEST['logs-types'] ) ?  $_REQUEST['logs-types'] :"";		
		if (!empty($log_types)) {
			$where_filter_by = "activity_type ='".$log_types."'";		    
		}
		
		$activity_by = isset( $_REQUEST['activity_by'] ) ?  $_REQUEST['activity_by'] :"";		
		if (!empty($activity_by)) {
			if(!empty($where_filter_by)) {
				$where_filter_by .= " and ";
			}
			$where_filter_by .= "activity_by =".$activity_by."" ;		    
		}
		
		$activity_by_auction = isset( $_REQUEST['activity_by_auction'] ) ?  $_REQUEST['activity_by_auction'] :"";		
		if (!empty($activity_by_auction)) {
			if(!empty($where_filter_by)) {
				$where_filter_by .= " and ";
			}
			$where_filter_by .= "post_parent =".$activity_by_auction."" ;		    
		}
		
		
		//$log_types_qry_where .= $where_filter_by;
		if(!empty($search)) {
			$s_q = sprintf(" (`activity_name` LIKE '%%%s%%' OR `activity_type` LIKE '%%%s%%')", $search, $search);
			if (!empty($where_filter_by)) {
				$where_filter_by .= " and ".$s_q;
			}else{
				$where_filter_by .= $s_q;
			}
				
		}	
		if (!empty($where_filter_by)) {
			
			$log_types_qry_where =" where ".$where_filter_by;		    
		}	
			
		//echo $log_types_qry_where;

        // will be used in pagination settings
		$total_items = $wpdb->get_var("SELECT COUNT(activity_id) FROM $table_name $log_types_qry_where");

        // prepare query params, as usual current page, order by and order direction
        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged'] -1) * $per_page) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'activity_id';
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

	function extra_tablenav( $which ) {
    global $wpdb, $testiURL, $tablename, $tablet;
    if ( $which == "top" ){
        ?>
        <div class="alignleft actions bulkactions">
		<?php $current_user = isset( $_REQUEST['logs-user'] ) ?  $_REQUEST['logs-user'] :"";  ?>

			 <select id="activity_by" name="activity_by">
						<option value=""><?php _e('All Users', 'ultimate-auction-pro-software');?></option>
						<?php
						$allUsers = get_users();
						foreach ($allUsers as $au) {
								$uat_selected = "";
								if (isset($_REQUEST['activity_by']) &&
									$_REQUEST['activity_by'] == $au->ID) {
									$uat_selected = "selected='selected'";
								}
								?>
								<option <?php echo $uat_selected;?>  value='<?php echo $au->ID; ?>'><?php echo $au->user_login;?></option>
						<?php } ?>
			</select>
			<?php
			$current_event = isset( $_REQUEST['logs-event'] ) ?  $_REQUEST['logs-event'] :"";
			$args = array (
						'post_type'              => array( 'uat_event' ),
						'post_status'            => array( 'Publish' ),
						'posts_per_page'         => -1,
						'orderby'                  => 'title',
						'order'                  => 'ASC',

			);
			$query = new WP_Query( $args );  ?>
			<select id="logs-event" name="logs-event">
			<option value=""><?php _e( 'All Auction Event', 'ultimate-auction-pro-software' ); ?></option>
				<?php
					while ( $query->have_posts() ) : $query->the_post();
					?>
					<option value="<?php the_ID(); ?>" <?php selected( get_the_ID(), $current_event ); ?>><?php the_title();?></option>
					<?php  endwhile; wp_reset_query(); ?>
			</select>

        <?php
			$current_auction = isset( $_REQUEST['activity_by_auction'] ) ? $_REQUEST['activity_by_auction'] : "";
			$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'orderby'  => 'title',
			'order'   => 'ASC',
			'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),

		);
			$query = new WP_Query( $args );  ?>
			<select id="activity_by_auction" name="activity_by_auction">
			<option value=""><?php _e( 'All Auction Product', 'ultimate-auction-pro-software' ); ?></option>
				<?php
					while ( $query->have_posts() ) : $query->the_post();
					?>
					<option value="<?php echo the_ID(); ?>" <?php selected( get_the_ID(), $current_auction ); ?>><?php the_title();?></option>

					<?php  endwhile; wp_reset_query(); ?>
			</select>


			<?php
			$current_types = isset( $_REQUEST['logs-types'] ) ?  $_REQUEST['logs-types'] :"ua_bids";

			?>
			<select id="logs-types" name="logs-types">

			<option value=""><?php _e( 'Log Type', 'ultimate-auction-pro-software' ); ?></option>

			<?php $options_uat_bids_logs = get_option( 'options_uat_bids_logs', 'enable' );

			if(!empty($options_uat_bids_logs) && $options_uat_bids_logs=='enable'){  ?>

			<option value="ua_bids" <?php selected( "ua_bids", $current_types ); ?>><?php _e('Bids', 'ultimate-auction-pro-software'); ?></option>

			<?php } ?>

			<?php $options_uat_payment_hold_logs = get_option( 'options_uat_payment_hold_logs', 'disable' );

			if(!empty($options_uat_payment_hold_logs) && $options_uat_payment_hold_logs=='enable'){  ?>

			<option value="ua_payment_hold_logs" <?php selected( "ua_payment_hold_logs", $current_types ); ?>><?php _e('Payment Hold', 'ultimate-auction-pro-software'); ?></option>
			<?php } ?>
			<?php $options_ua_payment_hold_debit_logs = get_option( 'options_ua_payment_hold_debit_logs', 'enable' );

			if(!empty($options_ua_payment_hold_debit_logs) && $options_ua_payment_hold_debit_logs=='enable'){  ?>
			<option value="ua_payment_debit_logs" <?php selected( "ua_payment_debit_logs", $current_types ); ?>><?php _e('Payment Hold & Debit', 'ultimate-auction-pro-software'); ?></option>

			<?php } ?>
			<?php $options_ua_payment_direct_debit_logs = get_option( 'options_ua_payment_direct_debit_logs', 'disable' );

			if(!empty($options_ua_payment_direct_debit_logs) && $options_ua_payment_direct_debit_logs=='enable'){  ?>
			<option value="ua_payment_direct_debit_logs" <?php selected( "ua_payment_direct_debit_logs", $current_types ); ?>><?php _e('Payment Direct Debit', 'ultimate-auction-pro-software'); ?></option>
			<?php } ?>

			<?php $options_uat_api_requests_logs = get_option( 'options_uat_api_requests_logs', 'disable' );

			if(!empty($options_uat_api_requests_logs) && $options_uat_api_requests_logs=='enable'){  ?>
			<option value="ua_api_requests_logs" <?php selected( "ua_api_requests_logs", $current_types ); ?>><?php _e('API Requests', 'ultimate-auction-pro-software'); ?></option>
			<?php } ?>
			<!--<option value="ua_products" <?php selected( "ua_products", $current_types ); ?>><?php _e('Products', 'ultimate-auction-pro-software'); ?></option>-->
			<!--<option value="ua_sms" <?php selected( "ua_sms", $current_types ); ?>><?php _e('SMS', 'ultimate-auction-pro-software'); ?></option>-->
			<!--<option value="ua_private_msg" <?php selected( "ua_private_msg", $current_types ); ?>><?php _e('Private Message', 'ultimate-auction-pro-software'); ?></option></option>-->

			</select>
		<?php submit_button( __( 'Filter', 'ultimate-auction-pro-software' ), 'secondary', 'submit', false ); ?>
        </div>
        <?php
    }
	}
}
	/**
	 * Information Page

	 * @package Devsite MDS Centers of Excellence
	 * @since 1.0.0
	 */
	function uat_logs_list_table_page_handler_display() {
	global $wpdb;
	$table = new Uat_Logs_List_Table();
	$table->prepare_items();
	$message = '';

	if ($table->current_action() == 'delete') {
			$message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Record deleted successfully', 'ultimate-auction-pro-software'), count((array)$_REQUEST['activity_id'])) . '</p></div>';
	}
	?>
	<?php echo $message; ?>
	<?php add_thickbox(); ?>
	<form id="persons-table" method="GET">
    <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
	<?php $table->search_box( __( 'Search' ), 'search-box-id' );?>
	<?php $table->display();?>
	</form>

	<script>
	jQuery(document).on('click', '.uat_select_all_chk', function(){

        if(jQuery(this).is(':checked')){
          jQuery('.uat_chk_auc_act').attr('checked','checked');
          jQuery('.uat_select_all_chk').attr('checked','checked');
        }
        else{
          jQuery('.uat_chk_auc_act').removeAttr('checked');
          jQuery('.uat_select_all_chk').removeAttr('checked','checked');
        }
      });
	</script>
	<?php
}
