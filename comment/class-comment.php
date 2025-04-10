<?php

class Custom_Comments {

private static $instance;

	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 *
	 */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**	 
	 */
	public function __construct() {				
		/* front side scripts */
		add_action( 'wp_enqueue_scripts', array( $this, 'uat_comment_register_front_scripts') );
		/* Add admin side scripts */
		add_action( 'admin_footer', array( $this, 'ultimate_auction_pro_register_admin_scripts_comment') );
		
		add_action( 'wp_ajax_add_custom_comment', array( $this, 'uat_add_custom_comment') );
		add_action( 'wp_ajax_nopriv_add_custom_comment', array( $this, 'uat_add_custom_comment') );
		
		add_action( 'wp_ajax_get_custom_comment_data', array( $this, 'get_custom_comment_data') );
		add_action( 'wp_ajax_nopriv_get_custom_comment_data', array( $this, 'get_custom_comment_data') );
		
		add_filter('admin_comment_types_dropdown', array($this, 'uat_add_comment_type'));
        add_filter('preprocess_comment', array($this, 'uat_new_comment_admin'));
		
       add_action( 'wp_ajax_uat_comment_upvote_downvote', array( $this, 'ua_upvote_downvote_callback') );
	   add_action( 'wp_ajax_nopriv_uat_comment_upvote_downvote', array( $this, 'ua_upvote_downvote_callback') );

	   add_action( 'wp_ajax_uat_comment_flag_reported', array( $this, 'uat_comment_flag_reported_callback') );
	   add_action( 'wp_ajax_nopriv_uat_comment_flag_reported', array( $this, 'uat_comment_flag_reported_callback') );

	   add_filter('manage_edit-comments_columns', array( $this, 'uat_add_comment_reported_column' ) );
	   add_filter('manage_edit-comments_sortable_columns', array( $this, 'uat_add_comment_reported_column' ) );

	   add_action('manage_comments_custom_column', array( $this, 'uat_manage_comment_flag_reported_column' ), 10, 2);
	   
		
		 add_action( 'wp_ajax_uat_moderate_comment', array( $this, 'uat_moderate_comment_callback') );

	}	
	
	public function uat_moderate_comment_callback() {		
		$response =array();
		if (is_user_logged_in()) {
			$comment_id = $_REQUEST["comment_id"];			
			if ($comment_id) {
				$flag_moderated = (int) get_comment_meta( $comment_id, 'uat_comment_flag_moderated', true );
				if($flag_moderated) {
					$response['status'] = 0;
					$response['error_message'] = __('Already Moderated.',"ultimate-auction-pro-software");
				} else {
					update_comment_meta( $comment_id, 'uat_comment_flag_moderated', true );
					delete_comment_meta( $comment_id, 'uat_comment_flag_reported' );
					wp_set_comment_status( $comment_id, 'approve' );
					$response['status'] = 1;
					$response['success_message'] = __('Comment Moderated successfully.',"ultimate-auction-pro-software");
				}
				
			} else {
			   $response['status'] = 0;
			   $response['error_message'] = __('Try again.',"ultimate-auction-pro-software");
			}
		}
		echo json_encode( $response );			
			die;
	}
	
	public function ultimate_auction_pro_register_admin_scripts_comment( $hook_sufix ) {
		/* Register globally scripts */
		if(is_admin()){
		$comment_js_ver="";
		wp_enqueue_script('uat-admin-comment',  UAT_THEME_PRO_INC_DIR_URI . 'comment/js/admin-comment.js', array(), $comment_js_ver);
		/* localization script */		
		wp_localize_script('uat-admin-comment', 'UAT_Comment', array('ajaxurl' => admin_url('admin-ajax.php')));
		wp_enqueue_script( 'uat-admin-comment' );	
		}
	}

	public function uat_manage_comment_flag_reported_column( $column_name, $comment_id ) {
		if ( $column_name === 'comment_flag_reported' ) {
			$flag_reports = 0;
			$already_reported = (int) get_comment_meta( $comment_id, 'uat_comment_flag_reported', true );
			if ( $already_reported > 0 ) {
				$flag_reports = $already_reported;
			}
			$result_id = 'uat-comments-result-' . $comment_id;
			echo '<span class="uat-comments-report-moderate" id="' . $result_id . '">';
			echo esc_attr( $flag_reports );
			if ( $already_reported > 0 ) {
				echo '
				<span class="row-actions">
					<a href="#" aria-label="' . esc_html__( 'Moderate and remove Flag reports.', 'ultimate-auction-pro-software' ) . '" title="' . esc_html__( 'Moderate and remove Flag reports.', 'ultimate-auction-pro-software' ) . '" data-uat-comment-id="' . $comment_id . '">(' . esc_html__( 'allow and remove Flag reports', 'ultimate-auction-pro-software') . ')</a>
				</span>';
			}
			echo '</span>';
			
			$already_moderated = (int) get_comment_meta( $comment_id, 'uat_comment_flag_moderated', true );
			if ( $already_moderated > 0 ) {
				echo '<span class="uat-comments-report-moderated" id="' . $result_id . '">';
				echo '
				<span class="row-actions">
					(' . esc_html__( 'Moderated', 'ultimate-auction-pro-software') . ')
				</span>';
				echo '</span>';
			}
		}
	}


	public function uat_add_comment_reported_column( $comment_columns ) {
		$comment_columns['comment_flag_reported'] = esc_html_x('Flag Reported', 'column name', 'ultimate-auction-pro-software');
		return $comment_columns;
	}

	public function uat_comment_flag_reported_callback() {		
		$response =array();
		if (is_user_logged_in()) {
			$comment_id = $_REQUEST["comment_id"];					
			if ($comment_id) {
				update_comment_meta($comment_id, 'uat_comment_flag_reported', 1);								
				$response['flag_reported'] = "yes";
			}
			
		}
		echo json_encode( $response );			
			die;
	}


	public function ua_upvote_downvote_callback() {		
		$response =array();
		if (is_user_logged_in()) {
			$comment_id = $_REQUEST["comment_id"];
			$user_ID = get_current_user_id();		
			if ($comment_id) {
				$vote_count = get_comment_meta( $comment_id, 'ua_comment_total_vote',true);
				if (is_user_comment_voting($user_ID,$comment_id)) {					
					$vote_minus = (int)$vote_count-1;					
					update_comment_meta($comment_id, 'ua_comment_total_vote', $vote_minus);
					delete_comment_meta($comment_id, 'ua_comment_vote_uid', $user_ID);
					delete_user_meta($user_ID, 'ua_comment_vote_cid', $comment_id);					
					$response['user_voted'] = "no";
				} else {					 
					    $vote_plus = (int)$vote_count+1;					
					    update_comment_meta($comment_id, 'ua_comment_total_vote', $vote_plus);
						add_comment_meta($comment_id, 'ua_comment_vote_uid', $user_ID);
						add_user_meta($user_ID, 'ua_comment_vote_cid', $comment_id);						
						$response['user_voted'] = "yes";
				}
				 $vote_count = get_comment_meta( $comment_id, 'ua_comment_total_vote',true);
				 $response['vote_count'] = $vote_count;
				
			}
			
		}
		echo json_encode( $response );			
			die;
	}
	
	public function uat_add_comment_type($args) {
        $this->comment_types = $args;
        $args['ua_comment'] = __('UA Comments', 'ultimate-auction-pro-software');        
        return $args;
    }
	
	public function uat_new_comment_admin($commentdata) {
        
		if($commentdata['comment_type'] =="woodiscuz"){
			return $commentdata;
		}
		
		if($commentdata['comment_type'] =="review"){
			return $commentdata;
		}
		if($commentdata['comment_type'] =="comment"){
			return $commentdata;
		}
		  $commentdata['comment_type'] = isset($commentdata['comment_type']) ? $commentdata['comment_type'] : '';
			$comment_post = get_post($commentdata['comment_post_ID']);
			if ($comment_post->post_type === 'product' && $commentdata['comment_type'] != 'ua_comment') {
				$com_parent = $commentdata['comment_parent'];
				if ($com_parent != 0) {
					$parent_comment = get_comment($com_parent);
					if ($parent_comment->comment_type == 'ua_comment') {
						$commentdata['comment_type'] = 'ua_comment';
					} else {
						$commentdata['comment_type'] = 'review';
					}
				} else {
					$commentdata['comment_type'] = 'review';
				}
			 }        
		
		return $commentdata;
    }
	
	/**
	 * Manage front side scripts
	 *
	 * @param.
	 * 	
	 */
	public function uat_comment_register_front_scripts( $hook_sufix ) {
		
		if(is_singular()){	
		$comment_js_ver = '';	
			wp_enqueue_script('custom-comment',  UAT_THEME_PRO_INC_DIR_URI . 'comment/js/custom-comment.js', array(), $comment_js_ver);wp_localize_script('custom-comment','frontend_custom_comment_object',
				array(
					'ajaxurl' => admin_url('admin-ajax.php'),
					'upvote_icon' => UAT_THEME_PRO_IMAGE_URI . '/rep-user-top-icon.png',
					'reply_icon' => UAT_THEME_PRO_IMAGE_URI . '/reply-icon.png',
					'flag_icon' => UAT_THEME_PRO_IMAGE_URI . '/flag-icon.png',
					'logged_in' => is_user_logged_in(),
					'loadmore' => __('Load more', 'ultimate-auction-pro-software'),
					'reported' => __('Reported', 'ultimate-auction-pro-software'),
					'moderated' => __('Moderated', 'ultimate-auction-pro-software'),
					'flag_txt' => __('Flag as inappropriate', 'ultimate-auction-pro-software'),
					'bid_text' => __('Bid', 'ultimate-auction-theme'),
					'currency_symbol' => get_woocommerce_currency_symbol(),
					'is_admin' => current_user_can('administrator'),
				)
			);
		}
		
	}
	public function uat_add_custom_comment () {		
		global $wpdb;
		$response=array();
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$user_ids = get_current_user_id();
		$current_user = wp_get_current_user();
		$name = $current_user->display_name;
		$users = get_user_by('id',$user_ids);	
		$current_user =isset($users->data->user_author) ? $users->data->user_author : '';
		$user_emails = isset($users->data->user_email) ? $users->data->user_email : '';
		$messegess = sanitize_text_field($_POST['comment']);
		$comment_type = isset($_POST['comment_type']) ?  $_POST['comment_type']:"ua_comment" ;
		$product_id = absint($_POST['product_id']);
		$Cparent_id = absint($_POST['Cparent_id']);
		$comment_approved = 1;
		$comment_moderation = get_option("comment_moderation");
		$comment_previously_approved = get_option("comment_previously_approved");		
		if($comment_moderation){			
			$comment_approved =0;
		}
			$data = array(
				'comment_post_ID' => $product_id,
				'comment_author' => $name,
				'comment_author_email' => $user_emails,
				'comment_content' => $messegess,
				'comment_author_IP' => '',
				'comment_agent' => $agent,
				'comment_date' => get_ultimate_auction_now_date(),
				'comment_date_gmt' => get_ultimate_auction_now_date(),
				'user_id' => $user_ids,
				'comment_approved' => $comment_approved,				
				'comment_type' => $comment_type,
			);
			if(isset($Cparent_id) && !empty($Cparent_id)){
				$data['comment_parent']=$Cparent_id;
			}		
			$comment_id = wp_insert_comment($data);
			
			if($comment_moderation){
				$response['comment_moderation_msg'] = __("Thank you your comment. Your Comment awaiting moderation.", 'ultimate-auction-pro-software');
			}
			echo json_encode( $response );			
			die;
	}
		
	public function uat_add_custom_bid_comment ($product_id,$user,$bidAmount,$comment) {		
		global $wpdb;
		$agent = $_SERVER['HTTP_USER_AGENT'];
		$user = get_user_by( 'id', $user);
		$userId = $user->ID;		
		$user_emails = $user->email;		
		$current_user = wp_get_current_user();
		$name = $current_user->user_login;
		$messegess = wc_price($bidAmount);
		$comment_type = "ua_comment" ;
		$comment_approved = 1;
		$comment_moderation = get_option("comment_moderation");
		if($comment_moderation){			
			$comment_approved =0;
		}
		$data = array(
			'comment_post_ID' => $product_id,
			'comment_author' => $name,
			'comment_author_email' => $user_emails,
			'comment_content' => $messegess,
			'comment_author_IP' => '',
			'comment_agent' => $agent,
			'comment_date' => get_ultimate_auction_now_date(),
			'comment_date_gmt' => get_ultimate_auction_now_date(),
			'user_id' => $userId,
			'comment_approved' => $comment_approved,				
			'comment_type' => $comment_type,
		);
		$WC_Product_Auction = new WC_Product_Auction($product_id);
		$auction_type = $WC_Product_Auction->get_auction_type();
		$comment_id = wp_insert_comment($data);
		add_comment_meta( $comment_id, 'uat_bid_amount', $bidAmount );
		add_comment_meta( $comment_id, 'uat_auction_type', $auction_type );
	}	
		public function get_custom_comment_data () {
			global $wpdb;
			$Cuser_id = get_current_user_id();
			$uat_auction_comments = get_option( 'options_uat_auction_comments', "" );
			$uat_auction_bid_comments = get_option("options_uat_auction_bid_comments","on");
			$response =array();
			$comments_countP = 0;
			$comment_type = isset($_POST['comment_type']) ?  $_POST['comment_type']:"ua_comment" ;
			$filter_by = isset($_POST['filter_by']) ?  $_POST['filter_by']:"" ;	
			if(isset($_REQUEST['product_id']) && $uat_auction_comments == 'on'){	   
				$args_to = array(
					'post_id' => $_REQUEST['product_id'],       
					'status' => 1,
					'type'    => $comment_type,	
					'count' => true, 
					
				);
				if( empty($uat_auction_bid_comments) || $uat_auction_bid_comments == 'off'){
					$args_to['meta_query'] = array(
												array(
													'key' => 'uat_bid_amount',
													'compare' => 'NOT EXISTS'
												)
											);
				}
				if($filter_by =="most_upvoted_comment"){												
						$args_to['orderby'] = 'meta_value_num';
						$args_to['meta_key'] = 'ua_comment_total_vote';
						$args_to['order'] = 'DESC';					
					}
					
				if( empty($uat_auction_bid_comments) || $uat_auction_bid_comments == 'off'){
					$args['meta_query'] = array(
												array(
													'key' => 'uat_bid_amount',
													'compare' => 'NOT EXISTS'
												)
											);
				}	
				$comments_countP = get_comments($args_to);
			
				$args = array(
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_id' => $_REQUEST['product_id'],
					'type'    => $comment_type,					
					'paged'   => $_REQUEST['setpage'],					
					'status'  => 1,
					'number'  => $_REQUEST['Cperpage'],
					
				);	
				if($filter_by =="most_upvoted_comment"){												
						$args['orderby'] = 'meta_value_num';
						$args['meta_key'] = 'ua_comment_total_vote';
						$args['order'] = 'ASC';					
					}
				//echo "<pre>";
				//print_r( $args);
				
				$comments = get_comments( $args );
				foreach ( $comments as $comment ) :
				
					
					$attachment_id = get_user_meta( $comment->user_id, 'image', true );
					$custom_avatar_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' ); 
					if ( $custom_avatar_url ) {
						$comment->user_avtar = $custom_avatar_url;
					}else{
						$comment->user_avtar = get_avatar_url( $comment->user_id );
					}
					$comment->c_time = $this->uat_get_comment_time( $comment->comment_ID );
					if($comment->comment_parent !=0){
						$comment->c_parent_name = get_comment_author( $comment->comment_parent );
					}
					$total_vote_count = get_comment_meta( $comment->comment_ID, 'ua_comment_total_vote',true);
					if(empty($total_vote_count)){
						$total_vote_count =0;
					}					
					if (is_user_comment_voting($Cuser_id,$comment->comment_ID)) {					
						$comment->u_voted = 1;
					}
					$flag_reported = get_comment_meta( $comment->comment_ID, 'uat_comment_flag_reported',true);
					if($flag_reported ==1){
						$comment->flag_reported = 1;
					}
					$moderated = get_comment_meta( $comment->comment_ID, 'uat_comment_flag_moderated',true);
					if($moderated){
						$comment->moderated = 1;
					}
					$comment->total_vote_count = $total_vote_count;	
					$uat_bid_amount = get_comment_meta(  $comment->comment_ID, "uat_bid_amount" );
					$uat_auction_type = get_comment_meta(  $comment->comment_ID, "uat_auction_type" );

					$comment->uat_bid_amount = $uat_bid_amount;	
					$comment->uat_auction_type = $uat_auction_type;
					$response['comment_data'][]= $comment;
				endforeach;
				
				$response['count'] = $comments_countP;
				
			}	
			
			echo json_encode( $response );			
			die;
		
		}
		
		public function uat_get_comment_time( $comment_id = 0 ){
		return sprintf( 
			_x( '%s ago', 'Human-readable time', "ultimate-auction-pro-software" ), 
			human_time_diff( 
				get_comment_date( 'U', $comment_id ), 
				current_time( 'timestamp' ) 
			) 
		);
}
		
}

Custom_Comments::get_instance();