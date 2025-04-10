<?php
/**
 *A calss Manage custom Post type Admin Area
 *
 * @author     NItesh Singh
 * @package    Ultimate Auction Pro Software
 * @since      1.0.0
 */
// Do not allow directly accessing this file.
if (!defined('ABSPATH'))
{
    exit('Direct script access denied.');
}
/**
 *A calss Manage Wordpress Admin Area
 */
class Ultimate_Auction_PRO_Custom_Post_Type_Admin
{
    private static $instance;
    /**
     * Returns the *Singleton* instance of this class.
     *
     * @return Singleton The *Singleton* instance.
     *
     */
    public static function get_instance()
    {
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct()
    {
        /* Admin Menu Page init */
        add_action('init', array( $this,'ultimate_auction_pro_register_post_types_uat_auction_event' ));
        add_action('admin_head', array(  $this, 'ultimate_auction_pro_event_menu_active'));
		add_filter('manage_uat_event_posts_columns', array($this, 'uat_pro_columns_head_events'),10);
		add_filter('manage_uat_event_posts_columns', array($this, 'uat_pro_columns_head_events2'));
		add_action('manage_uat_event_posts_custom_column', array($this, 'uat_pro_columns_content_events'),10, 2);
		add_action('restrict_manage_posts', array($this, 'ultimate_auction_pro_event_admin_posts_filter_restrict_manage_posts'));
	    add_action('parse_query', array($this, 'ultimate_auction_pro_event_posts_filter'));
		add_filter('post_row_actions', array($this, 'ultimate_auction_pro_event_custom_link'),10, 2);
		add_filter( 'bulk_actions-edit-uat_event', array($this, 'ultimate_auction_pro_remove_from_bulk_actions'));
		add_filter( 'manage_edit-uat_event_sortable_columns', array($this, 'ultimate_auction_pro_table_sorting'));
		add_filter( 'request', array($this, 'uat_start_time_and_date_column_orderby'));
		add_filter( 'request', array($this, 'uat_end_time_and_date_column_orderby'));
		add_action('save_post', array( $this,'insert_into_custom_events_table' ), 10);
		add_action('before_delete_post',array($this,'event_before_delete_post'),10,1);
		add_action('trashed_post',array($this,'event_trashed_post'),10,1);
		add_action('untrash_post',array($this,'event_trashed_post'),10,1);
		add_action('untrashed_post',array($this,'event_trashed_post'),10,1);
		add_action( 'widgets_init', array( $this, 'uat_register_events_widgets' ));

		add_action( 'add_meta_boxes', array( $this, 'ultimate_auction_pro_event_meta' ) );
		/* End Auction by Admin */
		add_action("wp_ajax_uat_admin_force_end_now_event", array($this, "uat_admin_force_end_now_even_callback"));
		add_action("wp_ajax_uat_admin_force_make_live_now_event", array($this, "uat_admin_force_make_live_now_event_callback"));
    }

		/**
		*  Add Event metabox for End Now and make it live
		*
		* @access public
		*
		*/
		public function ultimate_auction_pro_event_meta() {

			global $post;
				add_meta_box( 'Event Status', __( 'Event Status', 'ultimate-auction-pro-software' ), array( $this, 'ultimate_auction_pro_event_meta_callback' ), 'uat_event', 'normal','high' );

		}
	public function ultimate_auction_pro_event_meta_callback() {
		global $wpdb,$post;
		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		if (get_post_type($post->ID) == 'uat_event')
		{
		$event_id = $post->ID;
		$event_status = uat_get_event_status($event_id);
		$uat_expired = uat_event_is_past_event($event_id);
		$uat_live = uat_event_is_live($event_id);
		 if(($uat_expired === FALSE ) and ($uat_live  === TRUE )) :
			$event_status_txt = "Live Event";
		elseif (($uat_expired === FALSE ) and ($uat_live  === FALSE )):
			$event_status_txt = "Future Event";
		else :
			$event_status_txt = "Past Event";
		endif;
		$starting_on_date = get_post_meta($event_id, 'start_time_and_date', true);
	    $ending_date = get_post_meta($event_id, 'end_time_and_date', true);
		?>
			<p>
			<strong><?php _e( 'Opening Date', 'ultimate-auction-pro-software' ); ?></strong> : <?php echo mysql2date($datetimeformat,$starting_on_date);?>
			</p>
		<p>
		<strong><?php _e( 'Closing Date', 'ultimate-auction-pro-software' ); ?></strong> : <?php echo mysql2date($datetimeformat,$ending_date);?>
		</p>
		<?php
		$event_status = uat_get_event_status_custom_db( $post->ID );
		if($event_status =="uat_future"){ ?>
			<p >
			<a href="#" class="button uat_force_make_live_events"  data-event_id="<?php echo $post->ID; ?>">
			<?php _e('Make It Live', 'ultimate-auction-pro-software'); ?></a>
			</p>
		<?php }
			if($event_status =="uat_live"){ ?>
			<p>
			<!-- <a href="#" class="button uat_force_end_now_events"  data-event_id="<?php echo $post->ID; ?>">
				<?php _e('End Now', 'ultimate-auction-pro-software'); ?>
			</a> -->
			</p>
			<?php }

		}

	}
	/**
	 * Ajax End Event
	 *
	 * @param  array
	 * @return string
	 *
	 */
	function uat_admin_force_end_now_even_callback () {
		global $wpdb;
		$nowdate_for_start = get_ultimate_auction_now_date();
		if (!current_user_can('edit_post', $_POST["postid"])) {
				die();
		}
		if (!empty($_POST["postid"])) {
			$event_id = $_POST["postid"];
			$event_status = uat_get_event_status_custom_db( $event_id );
		if($event_status =="uat_past"){
			$response['status'] = 0;
			$response['error_message'] = __('Event Already Expired.', 'ultimate-auction-pro-software');
			die();
		}elseif($event_status =="uat_live"){
			$products_array = get_auction_products_ids_by_event( $event_id );
	        $original_array=unserialize($products_array);
			if ($original_array) {
					foreach ($original_array as $auction_id) {
					$Auction_Expire = new Uat_Auction_Expire();
					$Auction_Expire->uat_product_check_expired_last_callback( $auction_id );
					}
				}
				update_post_meta($event_id, 'end_time_and_date', $nowdate_for_start);
				uat_update_event_status_to_custom_db( $event_id ,"uat_past",$nowdate_for_start );
				$response['status'] = 1;
				$response['success_message'] = __('Event Expired successfully.', 'ultimate-auction-pro-software');

			}else{
				$response['status'] = 0;
				$response['error_message'] = __('This Event is Expired.', 'ultimate-auction-pro-software');
			}

		}

		echo json_encode( $response );
		exit;
	}

	/**
	 * Ajax End Event
	 *
	 * @param  array
	 * @return string
	 *
	 */
	function uat_admin_force_make_live_now_event_callback () {
		global $wpdb;
		$nowdate_for_start = get_ultimate_auction_now_date();
		if (!current_user_can('edit_post', $_POST["postid"])) {
				die();
		}
		if (!empty($_POST["postid"])) {
		$event_id = $_POST["postid"];
		$products_array = get_auction_products_ids_by_event( $event_id );
	    $original_array=unserialize($products_array);
		$event_status = uat_get_event_status_custom_db( $event_id );
		if($event_status =="uat_live"){
			$response['status'] = 0;
			$response['error_message'] = __('Event Already Live.', 'ultimate-auction-pro-software');
			die();
		}elseif($event_status =="uat_future"){
				if ($original_array) {
					foreach ($original_array as $auction_id) {
					update_post_meta($auction_id, 'woo_ua_auction_start_date', $nowdate_for_start);
					update_post_meta($auction_id, 'woo_ua_auction_has_started', "1");
					delete_post_meta($auction_id, "woo_ua_auction_started");
					json_update_status_auction($auction_id, $status = "live");
					}
					update_post_meta($auction_id, 'woo_ua_auction_start_date', $nowdate_for_start);
					update_post_meta($auction_id, 'woo_ua_auction_has_started', "1");
				}
				update_post_meta($event_id, 'start_time_and_date', $nowdate_for_start);
				uat_update_event_status_to_custom_db( $event_id ,"uat_live",$nowdate_for_start );
				$response['status'] = 1;
				$response['success_message'] = __('Event Live successfully.', 'ultimate-auction-pro-software');
			}else{
				$response['status'] = 0;
				$response['error_message'] = __('This Event is Past Event.', 'ultimate-auction-pro-software');
			}

		}

		echo json_encode( $response );
		exit;
	}


	public function insert_into_custom_events_table($post_id)
        {
            global $wpdb;
            if (get_post_type($post_id) != 'uat_event')
            {
                return;
            }
			//google map
			$location = get_field('uat_location_address',$post_id);
			if (!empty($location))
			{
		           //address
					if (!empty($location['address'])) {
						update_post_meta($post_id, 'uat_event_loc_address', $location['address']);
					}
		             //lat
					if (!empty($location['lat'])) {
						update_post_meta($post_id, 'uat_event_loc_lat', $location['lat']);
					}
					 //lng
					if (!empty($location['lng'])) {
						update_post_meta($post_id, 'uat_event_loc_lng', $location['lng']);
					}
					 //zoom
					if (!empty($location['zoom'])) {
						update_post_meta($post_id, 'uat_event_loc_zoom', $location['zoom']);
					}
					 //place_id
					if (!empty($location['place_id'])) {
						update_post_meta($post_id, 'uat_event_loc_place_id', $location['place_id']);
					}
					 //name
					if (!empty($location['name'])) {
						update_post_meta($post_id, 'uat_event_loc_name', $location['name']);
					}
					 //city
					if (!empty($location['city'])) {
						update_post_meta($post_id, 'uat_event_loc_city', $location['city']);
					}
					 //state
					if (!empty($location['state'])) {
						update_post_meta($post_id, 'uat_event_loc_state', $location['state']);
					}
					 //state
					if (!empty($location['state_short'])) {
						update_post_meta($post_id, 'uat_event_loc_state_short', $location['state_short']);
					}
					 //post_code
					if (!empty($location['post_code'])) {
						update_post_meta($post_id, 'uat_event_loc_post_code', $location['post_code']);
					}
					 //country
					if (!empty($location['country'])) {
						update_post_meta($post_id, 'uat_event_loc_country', $location['country']);
					}
					 //country_short
					if (!empty($location['country_short'])) {
						update_post_meta($post_id, 'uat_event_loc_country_short', $location['country_short']);
					}
			}
            // Date Time
			$past  = uat_event_is_past_event($post_id);
            $products_array = array();
			$uat_choose_product = get_field('uat_choose_product',$post_id);
			if ($uat_choose_product == "uat_product_category"){
				$cat_id = get_field('uat_select_category',$post_id);
				if (!empty($cat_id))
				{
					$products_array = uat_get_products_ids_from_cat($cat_id);
				}
			} elseif ($uat_choose_product == "uat_product_manually") {
				$manually_ids = get_field('uat_select_products_menually', $post_id);
				 if (!empty($manually_ids))
				{
					$products_array = get_field('uat_select_products_menually', $post_id);
				}
			}
			
			$e_start_date = get_field('start_time_and_date',$post_id) ?  : get_ultimate_auction_now_date();
			$nowdate =  wp_date('Y-m-d H:i:s',strtotime('+1 day', time()),get_ultimate_auction_wp_timezone());
			$e_end_date = get_field('end_time_and_date',$post_id) ?  : $nowdate;
			$e_auction_type = get_field('uat_type_of_auction_type',$post_id);
            if ($products_array)  {
                $e_enable_bid_inc = get_field('uat_enable_bid_increment',$post_id);
                foreach ($products_array as $auction_id)
                {
					$uat_auction_lot_number = get_post_meta($auction_id, 'uat_auction_lot_number');
					if (empty($uat_auction_lot_number))
                    {
                        update_post_meta($auction_id, 'uat_auction_lot_number', "");
                    }
                    // Start End Date
                    if (!empty($e_start_date))
                    {
                        update_post_meta($auction_id, 'woo_ua_auction_start_date', stripslashes($e_start_date));
                    }
                    if (!empty($e_end_date))
                    {
                        update_post_meta($auction_id, 'woo_ua_auction_end_date', stripslashes($e_end_date));
                    }
                    //Auction Type
                    if ($e_auction_type == "proxy")
                    {
                        update_post_meta($auction_id, 'uwa_auction_proxy', "yes");
                        delete_post_meta($auction_id, 'uwa_auction_silent');
                    }
                    elseif ($e_auction_type == "silent")
                    {
                        update_post_meta($auction_id, 'uwa_auction_silent', "yes");
                        delete_post_meta($auction_id, 'uwa_auction_proxy');
                    } else {
                        delete_post_meta($auction_id,'uwa_auction_proxy');
                        delete_post_meta($auction_id,'uwa_auction_silent');
                    }
                    if ($e_enable_bid_inc == "yes")
                    {
                        $e_bid_inc_type = get_field('uat_set_bid_incremental_type',$post_id);
                        if ($e_bid_inc_type == "fix_inc")
                        {
                            $e_bid_inc_flat_price = get_field('uat_flat_incremental_price',$post_id);
                            update_post_meta($auction_id, 'woo_ua_bid_increment', $e_bid_inc_flat_price);
                            delete_post_meta($auction_id, 'uwa_var_inc_price_val');
                            delete_post_meta($auction_id, 'uwa_auction_variable_bid_increment');
                        }
                        if ($e_bid_inc_type == "var_inc")
                        {
							$e_bid_inc_var_type = get_field('uat_set_bid_var_incremental_type',$post_id);
							update_post_meta($auction_id, 'uwa_auction_variable_bid_increment_type', $e_bid_inc_var_type);
							$e_bid_inc_var_price = get_field('uat_var_incremental_price',$post_id);
							update_post_meta($auction_id, 'uwa_auction_variable_bid_increment', "yes");
							update_post_meta($auction_id, 'uwa_var_inc_price_val', $e_bid_inc_var_price);
							delete_post_meta($auction_id, 'woo_ua_bid_increment');
                        }
                    }
                    //Extra Fields for developer
                    update_post_meta($auction_id, 'uat_event_id', $post_id);
                    update_post_meta($auction_id, 'uwa_event_auction', "yes");
                    //update_post_meta($auction_id, 'uat_auction_lot_number', "");
                }
          }
			if (!empty($products_array)) {
				$event_products_ids = serialize($products_array);
			} else {
				$event_products_ids ="";
			}
			//Save to em_event table
			//post_status



			$date_start =  $e_start_date;
			$date_end =  $e_end_date;
			$date_currrent = current_time('mysql');

			$start_str="";
			$new_status = "";
			if( $date_start > $date_currrent){
				$start_str="uat_future";
				$new_status = "uat_planned";
			} else if($date_start <= $date_currrent){

				if($date_end < $date_currrent){
					$start_str="uat_past";
					$new_status = "uat_auctined";
				}  else if($date_end > $date_currrent && $date_start <= $date_currrent){

					$start_str="uat_live";
					$new_status = "uat_in_auction";
				}

			}
		//   $start_str;
			$post_status = get_post_status($post_id);
			$event_type ="time";
			$event_array = array();
			$event_array['post_id'] = $post_id;
			$event_array['event_owner'] = 1;
			$event_array['event_status'] = $start_str;
			$event_array['event_name'] = get_the_title($post_id);
			$event_array['post_content'] = get_post_field('post_content', $post_id);
			$event_array['event_type'] = $event_type;
			$event_array['event_start_date'] = $e_start_date;
			$event_array['event_end_date'] = $e_end_date;
			$event_array['post_status'] = $post_status;
			$event_array['event_products_ids'] = $event_products_ids;
		    $event_exists = $wpdb->get_var('SELECT post_id FROM '.UA_EVENTS_TABLE." WHERE post_id=".$post_id);
		    if($event_exists) {
                $wpdb->update(UA_EVENTS_TABLE, $event_array, array('post_id'=>$post_id) );
			} else {
				$wpdb->insert(UA_EVENTS_TABLE,$event_array);
			    $event_id = $wpdb->insert_id;
			    update_post_meta($post_id, 'ua_auction_events_id', $event_id);
			}
			$e_bid_inc_type = get_field('uat_set_bid_incremental_type',$post_id);
			if ($e_bid_inc_type == "var_inc")
			{
				$uat_set_bid_var_incremental_type = get_field('uat_set_bid_var_incremental_type',$post_id);
				if($uat_set_bid_var_incremental_type=="global"){
					update_post_meta($post_id, 'uwa_auction_variable_bid_increment_type_event', $uat_set_bid_var_incremental_type);
				}else{
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment_type_event');
				}
			}


		   // $event_status = uat_get_event_status($post_id);

		    //Check or delete not exiting auction id from from event
			$auction_not_exists = $wpdb->get_results('SELECT post_id FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE event_id=".$post_id);
			$saved_auction_id_arr =array();
			foreach ($auction_not_exists as $auction_not_exist)
			{
				$saved_auction_id_arr[] = $auction_not_exist->post_id;
			}
			$deletes_ids = array_diff($saved_auction_id_arr, $products_array);
            if (!empty($deletes_ids)) {
				foreach ($deletes_ids as $deletes_id)
                {

					$wpdb->query("update ".UA_AUCTION_PRODUCT_TABLE." set event_id='0' WHERE post_id=".$deletes_id);
					delete_post_meta($deletes_id, 'uwa_event_auction');
					delete_post_meta($deletes_id, 'uat_event_id');

				}
            }
		  //saving into custom wp_ua_auction_product
		  if (!empty($products_array))  {
                foreach ($products_array as $auction_id)
                {
					  $product = wc_get_product( $auction_id );
 				if(!empty($product)){
					if( !empty($product->get_type()) && $product->get_type() == "auction"){

						$auction_array = array();
						$auction_array['post_id'] = $product->get_id();
						$auction_array['post_status'] = $product->get_status();
						$auction_array['auction_owner'] = 1;
						$auction_array['auction_status'] = $start_str;
						$auction_array['auction_name'] = $product->get_name();
						$auction_array['auction_content'] = get_post_field('post_content', $product->get_id());
						$auction_array['product_type'] = $product->get_type();
						$auction_array['auction_start_date'] = $e_start_date;
						$auction_array['auction_end_date'] = $e_end_date;
						$auction_array['event_id'] = $post_id;
						$auction_exists = $wpdb->get_var('SELECT post_id FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$product->get_id());
						if($auction_exists) {
							$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $auction_array, array('post_id'=>$product->get_id()) );
						} else {
							$wpdb->insert(UA_AUCTION_PRODUCT_TABLE,$auction_array);
							$insert_id = $wpdb->insert_id;
							update_post_meta($auction_id, 'auction_id', $insert_id);
						}
						wat_auction_save_post_callback($product->get_id());
					}
					}
				}
		  }
		  do_action('uat_seller_product_status_update', $products_array, $new_status);
		}
	public static function event_trashed_post($post_id){
		global $wpdb;
			if(get_post_type($post_id) == UAT_THEME_PRO_EVENT_POST_TYPE){
			$post_status =get_post_status($post_id);
			$result = $wpdb->query ( $wpdb->prepare("update ". UA_EVENTS_TABLE ." SET post_status=%s WHERE post_id=%d",$post_status, $post_id) );
			}
	}
	public static function event_before_delete_post($post_id){
		global $wpdb;
			if(get_post_type($post_id) == UAT_THEME_PRO_EVENT_POST_TYPE){
				$result = $wpdb->query ( $wpdb->prepare("DELETE FROM ". UA_EVENTS_TABLE ." WHERE post_id=%d", $post_id) );
			}
	}
	public function ultimate_auction_pro_table_sorting( $columns ) {
		$columns['start_time_and_date'] = 'start_time_and_date';
		$columns['end_time_and_date'] = 'end_time_and_date';
		return $columns;
	}
	public function uat_start_time_and_date_column_orderby( $vars ) {
		if ( isset( $vars['orderby'] ) && 'start_time_and_date' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'start_time_and_date',
				'orderby' => 'meta_value'
			) );
		}
		return $vars;
	}
	public function uat_end_time_and_date_column_orderby( $vars ) {
		if ( isset( $vars['orderby'] ) && 'end_time_and_date' == $vars['orderby'] ) {
			$vars = array_merge( $vars, array(
				'meta_key' => 'end_time_and_date',
				'orderby' => 'meta_value'
			) );
		}
		return $vars;
	}
    /**
     * Add Page Auction Event Custom POST Type.
     *
     */
    public function ultimate_auction_pro_register_post_types_uat_auction_event()
    {
        $event_auction_abels = array(
            'name' => _x('Auction Events', 'Post Type General Name', 'ultimate-auction-pro-software') ,
            'singular_name' => _x('Auction Event', 'Post Type Singular Name', 'ultimate-auction-pro-software') ,
            'menu_name' => __('Auction Events', 'ultimate-auction-pro-software') ,
            'name_admin_bar' => __('Auction Events', 'ultimate-auction-pro-software') ,
            'archives' => __('Auction Event Archives', 'ultimate-auction-pro-software') ,
            'attributes' => __('Auction Event Attributes', 'ultimate-auction-pro-software') ,
            'parent_item_colon' => __('Parent Auction Event:', 'ultimate-auction-pro-software') ,
            'all_items' => __('All Auction Events', 'ultimate-auction-pro-software') ,
            'add_new_item' => __('Add New Auction Event', 'ultimate-auction-pro-software') ,
            'add_new' => __('Add New', 'ultimate-auction-pro-software') ,
            'new_item' => __('New Auction Event', 'ultimate-auction-pro-software') ,
            'edit_item' => __('Edit Auction Event', 'ultimate-auction-pro-software') ,
            'update_item' => __('Update Auction Event', 'ultimate-auction-pro-software') ,
            'view_item' => __('View Auction Event', 'ultimate-auction-pro-software') ,
            'view_items' => __('View Auction Events', 'ultimate-auction-pro-software') ,
            'search_items' => __('Search Auction Event', 'ultimate-auction-pro-software') ,
            'not_found' => __('Not found', 'ultimate-auction-pro-software') ,
            'not_found_in_trash' => __('Not found in Trash', 'ultimate-auction-pro-software') ,
            'featured_image' => __('Featured Image', 'ultimate-auction-pro-software') ,
            'set_featured_image' => __('Set featured image', 'ultimate-auction-pro-software') ,
            'remove_featured_image' => __('Remove featured image', 'ultimate-auction-pro-software') ,
            'use_featured_image' => __('Use as featured image', 'ultimate-auction-pro-software') ,
            'insert_into_item' => __('Insert into item', 'ultimate-auction-pro-software') ,
            'uploaded_to_this_item' => __('Uploaded to this item', 'ultimate-auction-pro-software') ,
            'items_list' => __('Auction Events list', 'ultimate-auction-pro-software') ,
            'items_list_navigation' => __('Auction Events list navigation', 'ultimate-auction-pro-software') ,
            'filter_items_list' => __('Filter Auction Events list', 'ultimate-auction-pro-software') ,
        );
        $event_auction_args = array(
            'label' => __('Auction Event', 'ultimate-auction-pro-software') ,
            'labels' => $event_auction_abels,
            'supports' => apply_filters('ultimate_auction_theme_pro_post_type_ua_auction_event', array(
                'title',
                'editor',
                'author',
                'thumbnail',
                'revisions'
            )) ,
            'taxonomies' => array() ,
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => false,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => "post",
            'rewrite' => array(
                'slug' => "uaevents",
                'with_front' => true
            ) ,
        );
        register_post_type(UAT_THEME_PRO_EVENT_POST_TYPE, $event_auction_args);
    }
    function ultimate_auction_pro_event_menu_active()
    {
        global $parent_file, $post_type;
        if ($post_type == UAT_THEME_PRO_EVENT_POST_TYPE)
        {
            $parent_file = 'ua-auctions-theme';
			add_filter('months_dropdown_results', '__return_empty_array');
        }
    }
	/**
     * Event
     *
     */
    public function uat_pro_columns_head_events($columns)  {
			unset( $columns['author'] );
			unset( $columns['date']   );
			$columns['id']     = __('ID', 'ultimate-auction-pro-software');
			$columns['start_time_and_date']     = __('Start Date', 'ultimate-auction-pro-software');
			$columns['end_time_and_date']     = __('End Date', 'ultimate-auction-pro-software');
			$columns['event_total_products']     = __('Total Products', 'ultimate-auction-pro-software');
			$columns['event_total_bids']     = __('Total Bids', 'ultimate-auction-pro-software');
			$columns['event_total_amt_top_bids']     = __('Total Amount of Top Bids', 'ultimate-auction-pro-software');
			$columns['event_total_earnings']     = __('Earnings', 'ultimate-auction-pro-software');
			$columns['event_no_invoice']     = __('No. Of Invoices', 'ultimate-auction-pro-software');
			return $columns;
    }
	public function uat_pro_columns_head_events2($columns)  {
			$columns = array(
			  'cb' => $columns['cb'],
			  'title' => __( 'Title' ),
			  'start_time_and_date' => __('Start Date', 'ultimate-auction-pro-software'),
			  'end_time_and_date' => __('End Date', 'ultimate-auction-pro-software'),
			  'event_total_products' => __('Total Products', 'ultimate-auction-pro-software'),
			  'event_total_bids' => __('Total Bids', 'ultimate-auction-pro-software'),
			  'event_total_amt_top_bids' => __('Total Amount of Top Bids', 'ultimate-auction-pro-software'),
			);
			if ($_GET['uat-event-filter'] == 'uat_future') {
				$columns = array(
				  'cb' => $columns['cb'],
				  'title' => __( 'Title' ),
				  'start_time_and_date' => __('Start Date', 'ultimate-auction-pro-software'),
				  'end_time_and_date' => __('End Date', 'ultimate-auction-pro-software'),
				  'event_total_products' => __('Total Products', 'ultimate-auction-pro-software'),
				);
			}
			if ($_GET['uat-event-filter'] == 'uat_past') {
				$columns = array(
				  'cb' => $columns['cb'],
				  'title' => __( 'Title' ),
				  'start_time_and_date' => __('Start Date', 'ultimate-auction-pro-software'),
				  'end_time_and_date' => __('End Date', 'ultimate-auction-pro-software'),
				  'event_total_earnings' => __('Earnings', 'ultimate-auction-pro-software'),
				  'event_total_products' => __('Items Auctioned', 'ultimate-auction-pro-software'),
				  'event_total_products_sold' => __('Items Sold', 'ultimate-auction-pro-software'),
				  'event_total_bids' => __('Number of Bids', 'ultimate-auction-pro-software'),
				  'event_highest_bid' => __('Highest Bid', 'ultimate-auction-pro-software'),
				  'event_lowest_bid' => __('Lowest Bid', 'ultimate-auction-pro-software'),
				);
			}
		return $columns;
    }
	public function uat_pro_columns_content_events( $column, $post_id ) {
		global $wpdb;
	   $uat_expired = uat_event_is_past_event($post_id);
		$datetimeformat = get_option('date_format').' '.get_option('time_format');
		switch ( $column ) {
			case 'start_time_and_date' :
				$starting_on_date = get_field('start_time_and_date',$post_id);
				echo mysql2date($datetimeformat,$starting_on_date);
				break;
			case 'end_time_and_date' :
				$ending_date = get_field('end_time_and_date',$post_id);
				echo mysql2date($datetimeformat,$ending_date);
				break;
			case 'event_total_products' :
				$event_total_products =  uat_get_event_total_no_products( $post_id );
				echo $event_total_products;
				break;
			case 'event_total_bids' :
				echo uat_get_event_total_no_bids( $post_id );
				break;
			case 'event_total_amt_top_bids' :
				echo wc_price(uat_get_event_top_bids_amt( $post_id ));
				break;
			case 'event_total_earnings' :
				echo wc_price(uat_get_event_total_earnings( $post_id ));
				break;
			case 'event_total_products_sold' :
				echo uat_get_event_sold_items( $post_id );
				break;
			case 'event_highest_bid' :
				echo wc_price( uat_get_event_highest_bids( $post_id ));
				break;
			case 'event_lowest_bid' :
				echo wc_price(uat_get_event_lowest_bids( $post_id ));
				break;
		}
    }
	public function ultimate_auction_pro_event_posts_filter( $query )
    {
		global $pagenow;
		$event_status = (isset($_GET['uat-event-filter']) && !empty($_GET['uat-event-filter'])) ? $_GET['uat-event-filter'] : 'uat_all';
		if (isset($_GET['post_type']) && $_GET['post_type'] == 'uat_event' && is_admin() && $pagenow == 'edit.php') {
		$from = ( isset( $_GET['DateFrom'] ) && $_GET['DateFrom'] ) ? $_GET['DateFrom'] : '';
		$to = ( isset( $_GET['DateTo'] ) && $_GET['DateTo'] ) ? $_GET['DateTo'] : '';
		switch ($event_status) {
				case 'uat_live':
					$postids = uat_get_events_post_ids_by_status_admin('uat_live',$from,$to);
					if(empty($postids)){
						$postids[]= array();
					}
					$query->query_vars['post__in'] = $postids;
				break;
				case 'uat_future':
					$postids = uat_get_events_post_ids_by_status_admin('uat_future',$from,$to);
                    if(empty($postids)){
						$postids[]= array();
					}
					$query->query_vars['post__in'] = $postids;
					break;
				case 'uat_past':
					$postids = uat_get_events_post_ids_by_status_admin('uat_past',$from,$to);
					if(empty($postids)){
						$postids[]= array();
					}
					$query->query_vars['post__in'] = $postids;
					break;
				default:
				     $postids = uat_get_events_post_ids_by_status_admin('uat_all',$from,$to);
				     if(empty($postids)){
						$postids[]= array();
					}
					$query->query_vars['post__in'] = $postids;
    			break;
			}
		}
	}
	public function ultimate_auction_pro_event_admin_posts_filter_restrict_manage_posts()
    {
		/* Drop down list for auction  */
		if (isset($_GET['post_type']) && $_GET['post_type'] == 'uat_event') {
			$filter_values =  array(
					 'All Events' => 'uat_all',
					 'Live Events' => 'uat_live',
					 'Future Events' => 'uat_future',
					 'Past Events' => 'uat_past',
				);
				$current_filter = (isset($_GET['uat-event-filter']) && !empty($_GET['uat-event-filter'])) ? $_GET['uat-event-filter'] : 'uat_all';
				$post_status = (isset($_GET['post_status']) && !empty($_GET['post_status'])) ? $_GET['post_status'] : '';
			?>
			<?php if($post_status!='trash'){ ?>			
	        <select name="uat-event-filter">
	        	<?php
                
                foreach ($filter_values as $label => $value) {
                    printf ( '<option value="%s"%s>%s</option>',$value, $value == $current_filter ? ' selected="selected"' : '', $label );
                }
            	?>
	        </select>
			<?php } ?>
			<?php if($post_status=='trash'){ ?>
			<style>.alignleft.actions input#post-query-submit {display: none;}
				.alignleft.actions input#delete_all{margin-left: -7px;
				margin-top: 1px;}
			</style>
			<?php } ?>
			
		<?php
		$event_status = (isset($_GET['uat-event-filter']) && !empty($_GET['uat-event-filter'])) ? $_GET['uat-event-filter'] : 'uat_all';
		if($event_status =="uat_past"){
			wp_register_style( 'jquery-ui', UAT_THEME_PRO_CSS_URI.'jquery-ui.css', array(), UAT_THEME_PRO_VERSION );
		wp_enqueue_style( 'jquery-ui' );
				$from = ( isset( $_GET['DateFrom'] ) && $_GET['DateFrom'] ) ? $_GET['DateFrom'] : '';
				$to = ( isset( $_GET['DateTo'] ) && $_GET['DateTo'] ) ? $_GET['DateTo'] : '';
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
				</script>';
			}
        }
	}
	public function ultimate_auction_pro_event_custom_link($actions, $post){
		//check for your post type
		if ($post->post_type == UAT_THEME_PRO_EVENT_POST_TYPE ){
			unset( $actions['inline hide-if-no-js'] );
			global $sitepress;
			$lang="";
			if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
				$lang='&lang='.ICL_LANGUAGE_CODE;
			}
			$url = admin_url('admin.php?page=uat_auctions_event_details&event_id='.$post->ID.$lang);
			$actions['event_detail'] = '<a href="' . esc_url( $url ) . '" target="_blank"    > Detail </a>';
		}
		return $actions;
	}
    function ultimate_auction_pro_remove_from_bulk_actions( $actions ){
        unset( $actions[ 'edit' ] );
        return $actions;
    }
	/**
	 * Events Widgets Register
	 *
	 */
	public function uat_register_events_widgets() {
		include_once( UAT_THEME_PRO_ADMIN . 'events/widgets/class-uat-widget-live-events.php');
		/* Register widgets	 */
		register_widget('UAT_Widget_Live_Events');
		include_once( UAT_THEME_PRO_ADMIN . 'events/widgets/class-uat-widget-past-events.php');
		/* Register widgets	 */
		register_widget('UAT_Widget_Past_Events');
		include_once( UAT_THEME_PRO_ADMIN . 'events/widgets/class-uat-widget-future-event.php');
		/* Register widgets	 */
		register_widget('UAT_Widget_Future_Events');

		include_once( UAT_THEME_PRO_ADMIN . 'events/widgets/class-uat-widget-ending-soon-events.php');
		/* Register widgets	 */
		register_widget('UAT_Widget_Ending_Soon_Events');

		include_once( UAT_THEME_PRO_ADMIN . 'events/widgets/class-uat-widget-latest-events.php');
		/* Register widgets	 */
		register_widget('UAT_Widget_Latest_Events');
	}
} /* end of class */
Ultimate_Auction_PRO_Custom_Post_Type_Admin::get_instance();