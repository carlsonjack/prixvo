<?php
 /**
 * Class for user Confirm Unconfirmed
 * Uat_Users Main class
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
    class Uat_Users_Confirm_Unconfirmed {
		private static $instance;

		public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
		}
		public function __construct() {

		add_action( 'load-users.php',             array(  $this,'uat_userlist_confirm_unconfirmed' ) );
		//Block / Unblock User
		add_filter( 'bulk_actions-users',         array( $this, 'uat_bulk_action_confirm_unconfirmed_users'));
		add_filter( 'handle_bulk_actions-users',  array( $this, 'uat_handle_bulk_confirm_unconfirmed_users'), 10, 3 );
		add_action( 'admin_notices',              array( $this, 'uat_handle_bulk_confirm_unconfirmed_users_notices'));

		//add_filter( 'manage_users_columns', array( $this,'uat_confirm_unconfirmed_modify_user_table'));
		//add_filter( 'manage_users_custom_column', array( $this,'uat_confirm_unconfirmed_user_modify_user_table_row'), 10, 3 );

		add_action('show_user_profile', array( $this,'uat_confirm_unconfirmed_user_to_bid_profile_fields'));
		add_action('edit_user_profile', array( $this,'uat_confirm_unconfirmed_user_to_bid_profile_fields'));

		add_action('personal_options_update', array( $this,'uat_confirm_unconfirmed_user_to_bid_save_profile_fields'));
		add_action('edit_user_profile_update', array( $this,'uat_confirm_unconfirmed_user_to_bid_save_profile_fields'));

		add_filter( 'views_users', array( $this,'uat_extra_views_for_users'), 10, 1 );

		}
		public function uat_userlist_confirm_unconfirmed() {

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
			case 'confirm':
			   // echo "confirm--";
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_confirmed'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "yes" ) . "\" )";
				break;
			case 'unconfirmed':
			   // echo "unconfirmed--";
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_confirmed'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "no" ) . "\" )";
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
				'confirm'      => 'confirm',
				'unconfirmed'        => 'unconfirmed',

			);
			$user_counts = array();
			foreach ( $count_metas as $key => $meta_key ) {
				if ( 'confirm' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_confirmed' AND meta_value = 'yes'" );
				}

				if ( 'unconfirmed' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_confirmed' AND meta_value = 'no'" );
				}

				$user_counts[ $key ] = $count;
			}

			$views['confirm']      = __( 'Confirm',       'ultimate-auction-pro-software' );
			$views['unconfirmed']      = __( 'Unconfirmed',       'ultimate-auction-pro-software' );

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
		public function uat_bulk_action_confirm_unconfirmed_users($bulk_actions) {
			$bulk_actions['uat_confirm_users']  = __( 'Confirm',  'ultimate-auction-pro-software' );
			$bulk_actions['uat_unconfirmed_users'] = __( 'Unconfirm', 'ultimate-auction-pro-software' );
			return $bulk_actions;
		}
		//Update user status when bulk action done
		public function uat_handle_bulk_confirm_unconfirmed_users($redirect_to, $doaction, $user_ids) {

			if ($doaction !== 'uat_confirm_users' && $doaction !== 'uat_unconfirmed_users'){
				return $redirect_to;
			}

			if($doaction == 'uat_confirm_users'){
				foreach ( $user_ids as $user_id ){
					update_user_meta( $user_id, 'uat_is_confirmed', "yes" );
				}

				$redirect_to = add_query_arg( 'uat_confirm_users', count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_unconfirmed_users', $redirect_to );


			}elseif($doaction == 'uat_unconfirmed_users') {

				foreach ( $user_ids as $user_id ){
					update_user_meta( $user_id, 'uat_is_confirmed', "no" );
				}

				$redirect_to = add_query_arg( 'uat_unconfirmed_users',  count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_confirm_users', $redirect_to );

			}

			return $redirect_to;
		}

		//Admin Notice For Block/Unblock Users
		public function uat_handle_bulk_confirm_unconfirmed_users_notices() {
			if (! empty( $_REQUEST['uat_confirm_users'] ) ){
				$updated = intval( $_REQUEST['uat_confirm_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Confirmed %s user.',
						'Confirmed %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
			if (! empty( $_REQUEST['uat_unconfirmed_users'] ) ){
				$updated = intval( $_REQUEST['uat_unconfirmed_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Unconfirmed %s user.',
						'Unconfirmed %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
		}
		// Display in User list coloum
		/*public function uat_confirm_unconfirmed_modify_user_table( $column ) {
			$column['uwa_block_user_status'] = __('Bidding Status', 'ultimate-auction-pro-software');
			return $column;
		}
		// Display in User list ROw
		public function uat_confirm_unconfirmed_user_modify_user_table_row( $val, $column_name, $user_id ) {
			switch ($column_name) {
				case 'uwa_block_user_status' :
					$user_status = get_the_author_meta( 'uwa_block_user_status', $user_id );
						$user_bid_status = __('Unblock', 'ultimate-auction-pro-software');
							if( $user_status =="uwa_block_user_to_bid"){
							$user_bid_status = __('Block', 'ultimate-auction-pro-software');
							}
					return $user_bid_status;
				default:
			}
			return $val;
		}*/

		/**
		 * Add new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_confirm_unconfirmed_user_to_bid_profile_fields ( $user ) {
			$user_status = get_the_author_meta( 'uat_is_confirmed', $user->ID,true );
			$confirmed_checked="";
			if($user_status == "yes"){
				$confirmed_checked = "checked";
			}
			?>

			<table class="form-table">
			 <tr>
				 <th><label for="_block_to_bid"><?php _e('Confirm Registration', 'ultimate-auction-pro-software'); ?></label></th>
				 <td>
					<input <?php echo $confirmed_checked; ?> id="uat_is_confirmed" type="checkbox" class="input" name="uat_is_confirmed" value="1">

				 </td>
			 </tr>
			</table>
		   <?php
		}
		/**
		 * Saved new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_confirm_unconfirmed_user_to_bid_save_profile_fields ( $user_id ) {

				 if ( !current_user_can( 'edit_user', $user_id ) ) { return false; } else{
					if(isset($_POST['uat_is_confirmed']) && $_POST['uat_is_confirmed'] !=""){
						update_usermeta( $user_id, 'uat_is_confirmed', "yes" );
					}else{
						update_usermeta( $user_id, 'uat_is_confirmed', "no" );
					}
				}
		}
	}
Uat_Users_Confirm_Unconfirmed::get_instance();