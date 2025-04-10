<?php
 /**
 * Class for User Block unblock Active deactivate Membership
 * Uat_Users Main class
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
    class Uat_Users_Member {
		private static $instance;

		public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
		}
		public function __construct() {

		if ( current_user_can( 'list_users' ) ) {
		add_action( 'load-users.php',             array(  $this,'uat_userlist_member' ) );

		//Block / Unblock User
		add_filter( 'bulk_actions-users',         array( $this, 'uat_bulk_action_rejection_users'));
		add_filter( 'handle_bulk_actions-users',  array( $this, 'uat_handle_bulk_rejection_users'), 10, 3 );
		add_action( 'admin_notices',              array( $this, 'uat_handle_bulk_rejection_users_notices'));

		//add_filter( 'manage_users_columns', array( $this,'uat_rejection_modify_user_table'));
		//add_filter( 'manage_users_custom_column', array( $this,'uat_rejection_user_modify_user_table_row'), 10, 3 );

		add_action('show_user_profile', array( $this,'uat_rejection_user_to_bid_profile_fields'));
		add_action('edit_user_profile', array( $this,'uat_rejection_user_to_bid_profile_fields'));

		add_action('personal_options_update', array( $this,'uat_rejection_user_to_bid_save_profile_fields'));
		add_action('edit_user_profile_update', array( $this,'uat_rejection_user_to_bid_save_profile_fields'));

		add_filter( 'views_users', array( $this,'uat_extra_views_for_users'), 10, 1 );

		}
		}
		public function uat_userlist_member() {

		$wp_list_table = _get_list_table( 'WP_Users_List_Table' );
		$action = $wp_list_table->current_action();
		$redirect = '';
			switch ( $action ) {
				case 'display':
					add_action( 'pre_user_query', array( $this, 'pre_user_query' ) );
					return;
					break;
				default:
					return;
					break;

			}
			wp_safe_redirect( $redirect );
			exit();
		}

		public function pre_user_query( $user_search ) {

		global $wpdb;
		$display =  isset($_REQUEST['display']) ? $_REQUEST['display'] : "";
		switch ( $display ) {
			case 'approved':
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_approved'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "yes" ) . "\" )";
				break;
			case 'rejected':
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_approved'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "no" ) . "\" )";
				break;
			case 'pending':
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_approved'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "pending" ) . "\" )";
				break;
			default:
					return;
					break;
		}

		$query_where = str_replace( 'WHERE 1=1', $replace_query, $user_search->query_where );
		//echo $query_where;
		$user_search->query_where = $query_where;
	}

		public function uat_extra_views_for_users( $views ) {
			global $wpdb;
			$sql = "SELECT COUNT(*) FROM " . $wpdb->users;
			$users = $wpdb->get_var( $sql );

			$count_metas = array(
				'rejected'      => 'rejected',
				'approved'      => 'approved',
				'pending'      => 'pending',
			);
			$user_counts = array();
			foreach ( $count_metas as $key => $meta_key ) {
				if ( 'approved' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_approved' AND meta_value = 'yes'" );
				}
				if ( 'pending' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_approved' AND meta_value = 'pending'" );
				}
				if ( 'rejected' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_approved' AND meta_value = 'no'" );
				}
				$user_counts[ $key ] = $count;
			}

			$views['approved']      = __( 'Approved',       'ultimate-auction-pro-software' );
			$views['pending']      = __( 'Pending Approval','ultimate-auction-pro-software' );
			$views['rejected']      = __( 'Rejected',       'ultimate-auction-pro-software' );

			foreach ( $views as $key => $view ) {
			if ( isset( $user_counts[ $key ] ) ) {
				$link          = "users.php?action=display&amp;display=" . $key;
				$display =  isset($_REQUEST['display']) ? $_REQUEST['display'] : "";
				$current       = ( $display == $key ) ? ' class="current"' : '';
				$views[ $key ] = sprintf(
					'<a href="%s" %s>%s <span class="count">(%d)</span></a>',
					esc_url( $link ),
					$current,
					$view,
					isset( $user_counts[ $key ] ) ? $user_counts[ $key ] : ''
				);
			}
			}
			return $views;
		}

		//Display user list bulk action in admin
		public function uat_bulk_action_rejection_users($bulk_actions) {
			$bulk_actions['uat_approved_users'] = __( 'Approve', 'ultimate-auction-pro-software' );
			$bulk_actions['uat_reject_users']  = __( 'Reject',  'ultimate-auction-pro-software' );

			return $bulk_actions;
		}
		//Update user status when bulk action done
		public function uat_handle_bulk_rejection_users($redirect_to, $doaction, $user_ids) {

			if ($doaction !== 'uat_reject_users' && $doaction !== 'uat_approved_users'){
				return $redirect_to;
			}
			if($doaction == 'uat_approved_users'){
				foreach ( $user_ids as $user_id ){
					$update = update_user_meta( $user_id, 'uat_is_approved', "yes" );
					//$update = update_user_meta( $user_id, 'uat_is_approved', "no" );
					$approved_email_sent = get_user_meta( $user_id, 'uat_is_approved_email_sent', true );

					if($update && $approved_email_sent!="yes" ){
						$check_email = new EmailTracking();
						$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_approved');
						if( !$email_status )
						{
							$uat_Email = new RegistrationApprovedMail();
							$uat_Email->registration_approved_email($user_id ) ;
						}
					}
				}

				$redirect_to = add_query_arg( 'uat_approved_users', count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_reject_users', $redirect_to );
			} elseif($doaction == 'uat_reject_users') {

				foreach ( $user_ids as $user_id ){
					$update = update_user_meta( $user_id, 'uat_is_approved', "no" );
					$reject_email_sent = get_user_meta( $user_id, 'uat_is_reject_email_sent', true );

					if($update && $reject_email_sent!="yes" ){
						$check_email = new EmailTracking();
						$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_reject');
						if( !$email_status )
						{
							$uat_Email = new RegistrationRejectMail();
							$uat_Email->registration_reject_email($user_id );
						}
					}
				}

				$redirect_to = add_query_arg( 'uat_reject_users',  count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_approved_users', $redirect_to );

			}

			return $redirect_to;
		}

		//Admin Notice For Block/Unblock Users
		public function uat_handle_bulk_rejection_users_notices() {
			if (! empty( $_REQUEST['uat_reject_users'] ) ){
				$updated = intval( $_REQUEST['uat_reject_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Rejected %s user.',
						'Rejected %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
			if (! empty( $_REQUEST['uat_approved_users'] ) ){
				$updated = intval( $_REQUEST['uat_approved_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Approved %s user.',
						'Approved %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
		}

		/**
		 * Add new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_rejection_user_to_bid_profile_fields ( $user ) {
			$user_status = get_the_author_meta( 'uat_is_approved', $user->ID,true );
			?>
			<table class="form-table">
			 <tr>
					<th><label for="uat_is_approved"><?php _e('Registration Status', 'ultimate-auction-pro-software'); ?></label></th>
					<td>
					<select id="uat_is_approved" name="uat_is_approved">
						<option value=""><?php _e('Registration Status', 'ultimate-auction-pro-software'); ?> </option>
						<option value="yes" <?php selected( $user_status , 'yes'); ?>><?php _e('Approve', 'ultimate-auction-pro-software'); ?> </option>
						<option value="pending" <?php selected( $user_status, 'pending'); ?>> <?php _e('Pending Activation', 'ultimate-auction-pro-software'); ?></option>
						<option value="no" <?php selected( $user_status, 'no'); ?>> <?php _e('Reject', 'ultimate-auction-pro-software'); ?></option>
					</select>
				 </td>
				 </tr>
			</table>
		   <?php
		}
		/**
		 * Saved new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_rejection_user_to_bid_save_profile_fields ( $user_id ) {

				 if ( !current_user_can( 'edit_user', $user_id ) ) { return false; } else{
					if(isset($_POST['uat_is_approved']) && $_POST['uat_is_approved'] !=""){
						update_usermeta( $user_id, 'uat_is_approved',$_POST['uat_is_approved']);

						$approved_email_sent = get_user_meta( $user_id, 'uat_is_approved_email_sent', true );
						$reject_email_sent = get_user_meta( $user_id, 'uat_is_reject_email_sent', true );

						if($_POST['uat_is_approved'] =="yes"  && $approved_email_sent!="yes" ){
							$check_email = new EmailTracking();
							$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_approved');
							if( !$email_status )
							{
								$uat_Email = new RegistrationApprovedMail();
								$uat_Email->registration_approved_email($user_id ) ;
							}

							update_usermeta( $user_id, 'uat_is_approved_email_sent',"yes");

						}elseif($_POST['uat_is_approved'] =="no" && $reject_email_sent!="yes" ){

							$check_email = new EmailTracking();
							$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_reject');
							if( !$email_status )
							{
								$uat_Email = new RegistrationRejectMail();
								$uat_Email->registration_reject_email($user_id );
							}
							update_usermeta( $user_id, 'uat_is_reject_email_sent',"yes");
						}
					}

				}

		}

	}
Uat_Users_Member::get_instance();