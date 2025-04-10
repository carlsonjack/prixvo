<?php
 /**
 * Class for User Block unblock Active deactivate Membership
 * Uat_Users Main class
 */
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
    class Uat_Users_Blocked_Unblocked {
		private static $instance;

		public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
		}
		public function __construct() {
		add_action( 'load-users.php',             array(  $this,'uat_userlist_blocked' ) );

		//Block / Unblock User
		add_filter( 'bulk_actions-users',         array( $this, 'uat_bulk_action_block_unblock_users'));
		add_filter( 'handle_bulk_actions-users',  array( $this, 'uat_handle_bulk_block_unblock_users'), 10, 3 );
		add_action( 'admin_notices',              array( $this, 'uat_handle_bulk_block_unblock_users_notices'));

		/* add_filter( 'manage_users_columns', array( $this,'uat_block_unblock_modify_user_table'));
		add_filter( 'manage_users_custom_column', array( $this,'uat_block_unblock_user_modify_user_table_row'), 10, 3 ); */

		add_action('show_user_profile', array( $this,'uat_block_unblock_user_to_bid_profile_fields'));
		add_action('edit_user_profile', array( $this,'uat_block_unblock_user_to_bid_profile_fields'));

		add_action('personal_options_update', array( $this,'uat_block_unblock_user_to_bid_save_profile_fields'));
		add_action('edit_user_profile_update', array( $this,'uat_block_unblock_user_to_bid_save_profile_fields'));

		add_filter( 'views_users', array( $this,'uat_extra_views_for_users'), 10, 1 );
		}
		public function uat_userlist_blocked() {

		$wp_list_table = _get_list_table( 'WP_Users_List_Table' );
		$action = $wp_list_table->current_action();
		$redirect = '';
			switch ( $action ) {
				case 'display':
					add_action( 'pre_user_query', array( $this, 'pre_user_query_blocked' ) );
					return;
					break;
				default:
					return;
					break;

			}
			wp_safe_redirect( $redirect );
			exit();
		}

		public function pre_user_query_blocked( $user_search ) {

		global $wpdb;
		$display =  isset($_REQUEST['display']) ? $_REQUEST['display'] : "";
		switch ( $display ) {
			case 'block':
			   /* echo "block--";*/
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_block'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "yes" ) . "\" )";
				break;
			case 'unblock':
			 /* echo "unblock--";*/
				$replace_query = "WHERE 1=1 AND {$wpdb->users}.ID IN (
				 SELECT {$wpdb->usermeta}.user_id FROM $wpdb->usermeta
					WHERE {$wpdb->usermeta}.meta_key = 'uat_is_block'
					AND {$wpdb->usermeta}.meta_value = \"" . esc_sql( "no" ) . "\" )";
				break;
			default:
					return;
					break;
		}

		$query_where = str_replace( 'WHERE 1=1', $replace_query, $user_search->query_where );
		/*echo $query_where;*/
		$user_search->query_where = $query_where;
	}

		public function uat_extra_views_for_users( $views ) {
			global $wpdb;
			$sql = "SELECT COUNT(*) FROM " . $wpdb->users;
			$users = $wpdb->get_var( $sql );

			$count_metas = array(
				'block'      => 'block',
				'unblock'        => 'unblock',
			);
			$user_counts = array();
			foreach ( $count_metas as $key => $meta_key ) {
				if ( 'block' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_block' AND meta_value = 'yes'" );
				}

				if ( 'unblock' == $key ) {
					$count = $wpdb->get_var( "SELECT COUNT(*) FROM " . $wpdb->usermeta . " WHERE meta_key = 'uat_is_block' AND meta_value = 'no'" );
				}
				$user_counts[ $key ] = $count;
			}
			$views['block']      = __( 'Blocked',       'ultimate-auction-pro-software' );
			/* $views['unblock']      = __( 'Unblock',       'ultimate-auction-pro-software' ); */

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
		public function uat_bulk_action_block_unblock_users($bulk_actions) {
			$bulk_actions['uat_block_users']  = __( 'Block For Bid',  'ultimate-auction-pro-software' );
			$bulk_actions['uat_unblock_users'] = __( 'Unblock For Bid', 'ultimate-auction-pro-software' );
			return $bulk_actions;
		}
		//Update user status when bulk action done
		public function uat_handle_bulk_block_unblock_users($redirect_to, $doaction, $user_ids) {

			if ($doaction !== 'uat_block_users' && $doaction !== 'uat_unblock_users'){
				return $redirect_to;
			}

			if($doaction == 'uat_block_users'){
				foreach ( $user_ids as $user_id ){
					update_user_meta( $user_id, 'uat_is_block', "yes" );
				}

				$redirect_to = add_query_arg( 'uat_block_users', count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_unblock_users', $redirect_to );

			}elseif($doaction == 'uat_unblock_users') {

				foreach ( $user_ids as $user_id ){
					update_user_meta( $user_id, 'uat_is_block', "no" );
				}

				$redirect_to = add_query_arg( 'uat_unblock_users',  count($user_ids), $redirect_to );
				$redirect_to = remove_query_arg( 'uat_block_users', $redirect_to );

			}
			return $redirect_to;
		}

		//Admin Notice For Block/Unblock Users
		public function uat_handle_bulk_block_unblock_users_notices() {
			if (! empty( $_REQUEST['uat_block_users'] ) ){
				$updated = intval( $_REQUEST['uat_block_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Blocked %s user.',
						'Blocked %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
			if (! empty( $_REQUEST['uat_unblock_users'] ) ){
				$updated = intval( $_REQUEST['uat_unblock_users'] );
				printf( '<div id="message" class="updated">' .
					_n( 'Unblocked %s user.',
						'Unblocked %s users.',
						$updated,
						'ultimate-auction-pro-software'
					) . '</div>', $updated );
			}
		}
		
		/**
		 * Add new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_block_unblock_user_to_bid_profile_fields ( $user ) {
			$user_status = get_the_author_meta( 'uat_is_block', $user->ID,true );
			$block_to_bid_checked="";
			if($user_status == "yes"){
				$block_to_bid_checked = "checked";
			}
			?>
			<h3><?php _e('UA Theme Extra Fields', 'ultimate-auction-pro-software'); ?></h3>
			<table class="form-table">
			 <tr>
				 <th><label for="_block_to_bid"><?php _e('Block User to Bid', 'ultimate-auction-pro-software'); ?></label></th>
				 <td>
					<input <?php echo $block_to_bid_checked; ?> id="uat_is_block" type="checkbox" class="input" name="uat_is_block" value="1">

				 </td>
			 </tr>
			</table>
		   <?php
		}
		/**
		 * Saved new Field to user Profile for Block/Unblock for Bidding.
		 *
		 */
		public function uat_block_unblock_user_to_bid_save_profile_fields ( $user_id ) {

				 if ( !current_user_can( 'edit_user', $user_id ) ) { return false; } else{
					if(isset($_POST['uat_is_block']) && $_POST['uat_is_block'] !=""){
						update_usermeta( $user_id, 'uat_is_block', "yes" );
					}else{
						update_usermeta( $user_id, 'uat_is_block', "no" );
						delete_user_meta($user_id, 'uat_card_invalid_count');
					}
				}

		}

	}
Uat_Users_Blocked_Unblocked::get_instance();