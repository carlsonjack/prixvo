<?php
 /**
 * Class for logs and errors
 * Uat_Auction_Activity Main class
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

    class Uat_Auction_Activity {
    
		public function __construct() {

		}
		
		public function uat_add_activity( $parent = 0, $name = null ,$type = null ,$activity_by = null,$activity_data = null ) {
			$activity_data = array(				
				'post_parent'  => $parent,
				'activity_name'  => $name,
				'activity_type'=>$type,
				'activity_date'=>get_ultimate_auction_now_date(),
				'activity_by' => $activity_by,
				'activity_data' => $activity_data,
			);

			return $this->insert_activity( $activity_data );
		}
		
		function insert_activity( $activity_data = array(), $activity_meta = array() ) {
			global $wpdb; 
				$defaults = array(					
					'post_parent'  => 0,					
					'activity_type'     => false,
					'activity_name'     => false,
					'activity_date'     => get_ultimate_auction_now_date(),
					'activity_by'     => false,
					'activity_data'     => false,
				);

			$args = wp_parse_args( $activity_data, $defaults );
			
			//echo "<pre>";
			//print_r($args);
			//echo "</pre>";
			//$activity_id = wp_insert_post( $args );
			$wpdb->insert(UA_ACTIVITY_TABLE,$args);
			$activity_id = $wpdb->insert_id;
 
			// Set log meta, if any
			if ( $activity_id && ! empty( $activity_meta ) ) {
				foreach ( (array) $activity_meta as $key => $meta ) {
					//update_post_meta( $activity_id, '_ua_activity_' . sanitize_key( $key ), $meta );
					$activity_meta_array['activity_id'] = $activity_id;
					$activity_meta_array['meta_key'] = sanitize_key( $key );
					$activity_meta_array['meta_value'] = $meta;					
					$wpdb->insert(UA_ACTIVITYMETA_TABLE,$activity_meta_array);
				}
			}
		
			do_action( 'ua_auction_insert_activity', $activity_id, $activity_data, $activity_meta );
			
			return $activity_id;
		}
		
		function get_activity_meta( $activity_id ,$metakey ) {
			global $wpdb; 
			$table = UA_ACTIVITYMETA_TABLE;			
			$activity_meta = $wpdb->get_var("SELECT meta_value FROM $table WHERE activity_id = ".$activity_id." AND meta_key ='".$metakey."'");			
			return $activity_meta;
		}
		
		function insert_sub_activity_meta( $activity_id ,$metakey ,$metavalue) {
			global $wpdb; 
			$activity_meta_array['activity_id'] = $activity_id;
			$activity_meta_array['meta_key'] = sanitize_key( $metakey );
			$activity_meta_array['meta_value'] = $metavalue;			
			$wpdb->insert(UA_ACTIVITYMETA_TABLE,$activity_meta_array);
		}
		
	}
$GLOBALS['uat_auction_activity'] = new Uat_Auction_Activity();