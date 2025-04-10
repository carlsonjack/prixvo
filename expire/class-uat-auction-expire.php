<?php

/**
 * Class for logs and errors
 * Uat_Auction_Activity Main class
 * domain url /?ua-auction-cron=uat-process-auction
 */
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
class Uat_Auction_Expire
{
	public function __construct()
	{
		add_action('init', array($this, 'uat_pro_server_cron_setup'));
	}
	public function email_notification_payment_reminder($url = false)
	{
		$args = array(
			'status' => array('wc-pending'),
			'meta_key'      => 'uat_payement_reminder_sended',
			'meta_compare'  => 'NOT EXISTS',
		);
		$orders = wc_get_orders($args);

		if (!empty($orders)) {
			foreach ($orders as $order) {
				$order_id = $order->get_id();
				$user_id = $order->get_user_id();
				$check_email = new EmailTracking();
				$email_status = $check_email->duplicate_email_check($auction_id = $order_id, $user_id = $user_id, $email_type = 'order_payment_reminder', $amount = $order_id);
				if ($email_status != 1) {
					$PaymentReminderMail = new PaymentReminderMail();
					$PaymentReminderMail->payment_reminder_email($order_id);
					$order->update_meta_data('uat_payement_reminder_sended', 'yes');
					$order->save();
				}
			}
		}
	}
	public function sms_notification_ending_soon($url = false)
	{
		$interval = get_option('options_ending_soon_cron_time_left_sms', '60');
		$interval_time = date('Y-m-d H:i', current_time('timestamp') + ((int)$interval * MINUTE_IN_SECONDS));
		$args = array(
			'post_type'          => 'product',
			'posts_per_page'     => '100',
			'tax_query'          => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'auction',
				),
			),
			'meta_query'         => array(
				'relation' => 'AND',
				array(
					'key'     => 'woo_ua_auction_has_started',
					'value' => '1',
				),
				array(
					'key'     => 'woo_ua_auction_closed',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'uat_auction_ending_soon_sent_sms',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'woo_ua_auction_end_date',
					'compare' => '<',
					'value'   => $interval_time,
					'type '   => 'DATETIME',
				),
			),
		);
		$results = new WP_Query($args);
		$post_ids = wp_list_pluck($results->posts, 'ID');
		if (!empty($post_ids) && count($post_ids) > 0) {
			foreach ($post_ids as $post_id) {
				if (!empty($post_id)) {
					$now_timestamp = current_time("timestamp");
					add_post_meta($post_id, 'uat_auction_ending_soon_sent_sms', $now_timestamp, true);
					$TwilioSMS = new TwilioSMS();
					$TwilioSMS->ending_soon_sms($post_id);
				}
			}
		}
	}
	public function whatsapp_sms_notification_ending_soon($url = false)
	{
		$interval = get_option('options_ending_soon_cron_time_left_whatsapp', '60');
		$interval_time = date('Y-m-d H:i', current_time('timestamp') + ((int)$interval * MINUTE_IN_SECONDS));
		$args = array(
			'post_type'          => 'product',
			'posts_per_page'     => '100',
			'tax_query'          => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'auction',
				),
			),
			'meta_query'         => array(
				'relation' => 'AND',
				array(
					'key'     => 'woo_ua_auction_has_started',
					'value' => '1',
				),
				array(
					'key'     => 'woo_ua_auction_closed',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'uat_auction_ending_soon_sent_whatsapp',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'woo_ua_auction_end_date',
					'compare' => '<',
					'value'   => $interval_time,
					'type '   => 'DATETIME',
				),
			),
		);
		$the_query = new WP_Query($args);
		if ($the_query->have_posts()) {
			while ($the_query->have_posts()) :
				$the_query->the_post();
				$the_query->post->ID;
				get_the_title($the_query->post->ID);
				$now_timestamp = current_time("timestamp");
				add_post_meta($the_query->post->ID, 'uat_auction_ending_soon_sent_whatsapp', $now_timestamp, true);
				$TwilioWhatsapp = new TwilioWhatsapp();
				$TwilioWhatsapp->ending_soon_sms($the_query->post->ID);
			endwhile;
			wp_reset_postdata();
		}
	}
	public function email_notification_ending_soon($url = false)
	{
		$interval = get_option('options_ending_soon_cron_time_left', '60');
		$interval_time = date('Y-m-d H:i', current_time('timestamp') + ((int)$interval * MINUTE_IN_SECONDS));

		$args = array(
			'post_type'          => 'product',
			'posts_per_page'     => '100',
			'tax_query'          => array(
				array(
					'taxonomy' => 'product_type',
					'field'    => 'slug',
					'terms'    => 'auction',
				),
			),
			'meta_query'         => array(
				'relation' => 'AND',
				array(
					'key'     => 'woo_ua_auction_has_started',
					'value' => '1',
				),
				array(
					'key'     => 'woo_ua_auction_closed',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'uat_auction_ending_soon_sent',
					'compare' => 'NOT EXISTS',
				),
				array(
					'key'     => 'woo_ua_auction_end_date',
					'compare' => '<',
					'value'   => $interval_time,
					'type '   => 'DATETIME',
				),
			),
		);
		$results = new WP_Query($args);
		$post_ids = wp_list_pluck($results->posts, 'ID');

		if (!empty($post_ids) && count($post_ids) > 0) {
			foreach ($post_ids as $post_id) {
				if (!empty($post_id)) {
					$EndingSoonMail = new EndingSoonMail();
					$EndingSoonMail->ending_soon_email($post_id);
				}
			}
		}
	}

	public function uat_pro_cron_run()
	{
		global $wpdb;
		$options = get_option('uat_cron_current_status');
		if ($options != '1') {
			update_option('uat_cron_current_status', '1');
			try {

				/* product expire/live/future process */
				$valid_product_status =  getValidStatusForProductVisible();
				$valid_product_status[] =  'uat_approved';
				$args = array(
					'post_type'  => 'product',
					'post_status' => $valid_product_status,
					'meta_query' => array(
						array(
							'key'     => 'woo_ua_auction_selling_type',
							'value'   => array('auction', 'both', 'buyitnow'),
							'compare' => 'IN',
						),
						array(
							'key'     => 'uwa_event_auction',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'woo_ua_order_id',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
					),
				);
				$results = new WP_Query($args);
				$post_ids = wp_list_pluck($results->posts, 'ID');
				if (!empty($post_ids) && count($post_ids) > 0) {
					foreach ($post_ids as $post_id) {
						if (!empty($post_id)) {
							$product_is_completed = $this->uat_product_check_completed($post_id);
							if ($product_is_completed) {
								$this->uat_update_product_status($post_id, 'uat_past');
								$this->uat_product_check_expired_last_callback($post_id);
							} else {
								$this->uat_product_check_live($post_id);
							}
						}
					}
				}
				/* product expire/live/future process end*/

				/* event expire/live/future process */
				$args = array(
					'post_type'  => 'uat_event',

					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key'     => 'ua_auction_events_id',
							// 'value'   => '',
							'compare' => 'EXISTS',
						),
						array(
							'key'     => 'uat_event_order_process',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
						array(
							'key'     => 'uat_event_order_ids',
							'value'   => '',
							'compare' => 'NOT EXISTS',
						),
					),
				);
				$results = new WP_Query($args);
				$post_ids = wp_list_pluck($results->posts, 'ID');

				if (!empty($post_ids) && count($post_ids) > 0) {
					foreach ($post_ids as $post_id) {
						if (!empty($post_id)) {
							if ($this->uat_event_check_expired($post_id)) {
								$this->uat_event_check_expired_last_callback_new($post_id);
							} else {
								$this->uat_event_check_live($post_id);
							}
						}
					}
				}
				/* event expire/live/future process end*/

				/* ending soon notifications email/sms/whatsapp */

				$ending_soon_cron =  get_option('options_ending_soon_cron', 'off');
				if (!empty($ending_soon_cron) && $ending_soon_cron == 'on') {
					$this->email_notification_ending_soon();
				}

				$options_ending_soon_cron_sms =  get_option('options_ending_soon_cron_sms', 'off');
				if (!empty($options_ending_soon_cron_sms) && $options_ending_soon_cron_sms == 'on') {
					$this->sms_notification_ending_soon();
				}

				$options_ending_soon_cron_whatsapp =  get_option('options_ending_soon_cron_whatsapp', 'off');
				if (!empty($options_ending_soon_cron_whatsapp) && $options_ending_soon_cron_whatsapp == 'on') {
					$this->whatsapp_sms_notification_ending_soon();
				}
				/* ending soon notifications email/sms/whatsapp end*/

				/* payment reminder notifications email*/
				$uwa_ending_soon = get_option("uat_email_template_payment_reminder");
				$enable = isset($uwa_ending_soon['enable']) ? $uwa_ending_soon['enable'] : "";
				if ($enable == 'yes') {
					$this->email_notification_payment_reminder();
				}
				/* payment reminder notifications email end*/

				update_option('uat_cron_current_status', '0');
			} catch (Exception $ex) {
				update_option('uat_cron_current_status', '0');
			}
			update_option('uat_cron_current_status', '0');
		}
	}
	public function uat_pro_server_cron_onload($url = false)
	{
		global $wpdb;

		$this->uat_pro_cron_run();
		return false;
	}
	public function uat_pro_server_cron_setup($url = false)
	{
		global $wpdb;

		if (isset($_REQUEST['ua-auction-sms-webhook'])) {
			global $wpdb;
			$meta_value = $_REQUEST['SmsSid'];
			if (!empty($meta_value)) {
				$table = UA_ACTIVITYMETA_TABLE;
				$table_activity = UA_ACTIVITY_TABLE;
				$activity_id = $wpdb->get_var("SELECT activity_id FROM $table WHERE meta_key = 'api_sms_sid' AND meta_value ='" . $meta_value . "'");
				$activity_data = $_REQUEST;
				if (is_array($activity_data)) {
					$activity_data = json_encode($activity_data);
				}
				$SmsStatus = $_REQUEST['SmsStatus'];
				$wpdb->update($table_activity, array('activity_data' => $activity_data), array('activity_id' => $activity_id));
				$wpdb->update($table, array('meta_value' => $SmsStatus), array('activity_id' => $activity_id, 'meta_key' => 'api_response_status'));
			}
			exit();
		}
		if (isset($_REQUEST['ua-auction-cron']) && $_REQUEST['ua-auction-cron'] == 'uat-process-auction') {

			$options_cron_options =  get_option('options_cron_options', 'page');
			if (!empty($options_cron_options) && $options_cron_options == 'server') {
				$this->uat_pro_cron_run();
			}

			die(__("cron run successfully.", 'ultimate-auction-pro-software'));
		}
	}
	public function uat_event_check_expired_last_callback_new($event_id = null)
	{
		global $wpdb;
		/* process product expire payment emails */
		$product_ids = get_auction_products_ids_by_event($event_id);
		$product_ids = unserialize($product_ids);
		if (!is_array($product_ids)) {
			return false;
		}
		if (!empty($product_ids) && count($product_ids) > 0) {
			$winner_email_send = false;
			$loser_email_send = false;
			$options_cron_winner_email =  get_option('options_cron_winner_email', 'on');
			if (!empty($options_cron_winner_email) && $options_cron_winner_email == 'on') {
				$winner_email_send = true;
			}

			$options_cron_loser_email =  get_option('options_cron_loser_email', "off");
			if (!empty($options_cron_loser_email) && $options_cron_loser_email == 'on') {
				$loser_email_send = true;
			}
			$new_product_ids = array();
			foreach ($product_ids as $product_id) {
				$product_type = WC_Product_Factory::get_product_type($product_id);
				if ($product_type == 'auction') {
					$woo_ua_order_id = get_post_meta($product_id, 'woo_ua_order_id', true);
					if (empty($woo_ua_order_id)) {
						$new_product_ids[] =  $product_id;
						$options = get_option('uat_event_product_process_status');
						if ($options != '1') {
							update_option('uat_event_product_process_status', '1');
							$WC_Product_Auction = new WC_Product_Auction($product_id);

							try {
								$WC_Product_Auction->proccess_expire($payment = true, $order = false, $emails = false, $winner_email = $winner_email_send, $loser_email = $loser_email_send);
								update_option('uat_event_product_process_status', '0');
							} catch (Exception $ex) {
								update_option('uat_event_product_process_status', '0');
							}
							update_option('uat_event_product_process_status', '0');
						}
					}
				}
			}
			$uat_auto_order_enable = get_option('options_uat_auto_order_enable', 'disable');
			if ($uat_auto_order_enable == "enable") {
				/* genrate list by user products and process order */
				$Uat_Auction_Orders = new Uat_Auction_Orders();
				$Uat_Auction_Orders->uat_event_order_process($event_id, $new_product_ids);
			}
			/* send emails for event products */
			foreach ($new_product_ids as $product_id) {
				$options = get_option('uat_event_product_process_status');
				if ($options != '1') {
					update_option('uat_event_product_process_status', '1');
					$WC_Product_Auction = new WC_Product_Auction($product_id);

					try {
						$WC_Product_Auction->proccess_expire($payment = false, $order = false, $emails = true, $winner_email = $winner_email_send, $loser_email = $loser_email_send);
						update_option('uat_event_product_process_status', '0');
					} catch (Exception $ex) {
						update_option('uat_event_product_process_status', '0');
					}
					update_option('uat_event_product_process_status', '0');
				}
			}
		}
	}

	public function uat_product_check_live($product_id = null)
	{
		global $wpdb;
		$live_event = $wpdb->get_var('SELECT auction_status FROM ' . UA_AUCTION_PRODUCT_TABLE . " WHERE product_type='auction' AND post_id=" . $product_id);
		if ($live_event === 'uat_live') {
			$this->uat_update_product_status($product_id, 'uat_live');
			return TRUE;
		}
		$auction_start_date = $wpdb->get_var('SELECT auction_start_date FROM ' . UA_AUCTION_PRODUCT_TABLE . " WHERE product_type='auction' AND post_id=" . $product_id);
		if (!empty($auction_start_date)) {
			$date1 = new DateTime($auction_start_date);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2) {
				$this->uat_update_product_status($product_id, 'uat_live');
			} else {
				$this->uat_update_product_status($product_id, 'uat_future');
			}
			return ($date1 < $date2);
		} else {
			return FALSE;
		}
	}
	public  function uat_product_check_completed($product_id = null)
	{
		global $wpdb;
		//   $end_dates = $wpdb->get_var('SELECT auction_end_date FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$product_id);
		$end_dates = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
		if (!empty($end_dates)) {
			$date1 = new DateTime($end_dates);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function uat_update_product_status($product_id, $auction_status)
	{
		global $wpdb;
		/* uat_past | uat_live | uat_future */
		global $wpdb;
		$auction_status_old = $wpdb->get_var('SELECT auction_status FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$product_id);
		$status = str_replace('uat_', '', $auction_status);
		if($auction_status_old != $auction_status){
			$wpdb->query("update " . UA_AUCTION_PRODUCT_TABLE . " set auction_status='$auction_status' WHERE  post_id=" . $product_id);
			json_update_status_auction($product_id, $status);
		}
		$is_seller_product = get_post_meta($product_id, 'uat_seller_id', true);
		if (!empty($is_seller_product)) {
			$new_status = "";
			$old_status = get_post_status($product_id);
			switch ($status) {
				case 'live':
					$new_status = "uat_in_auction";
					break;
				case 'future':
					$new_status = "uat_planned";
					break;
				case 'past':
					$new_status = "uat_auctined";
					break;

				default:
					$new_status = "";
			}
			if (!empty($new_status) && $old_status != $new_status) {
				wp_update_post(array(
					'ID' => $product_id,
					'post_status' => $new_status,
				));
			}
		}
	}
	public  function uat_event_check_expired($event_id = null)
	{
		global $wpdb;
		$event_event_status = $wpdb->get_var('SELECT event_status FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
		if (!empty($event_event_status) && $event_event_status == 'uat_past') {
			return true;
		} else {
			$event_is_running = $this->uat_event_check_live($event_id);
			$event_is_completed = $this->uat_event_check_completed($event_id);
			if ($event_is_completed && $event_is_running) {
				$this->uat_update_events_status($event_id, 'uat_past');
				return TRUE;
			} else {
				return FALSE;
			}
		}
	}
	public function uat_event_check_live($event_id = null)
	{
		global $wpdb;
		$live_event = $wpdb->get_var('SELECT event_status FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
		if ($live_event === 'uat_live') {
			$this->uat_update_events_status($event_id, 'uat_live');
			return TRUE;
		}
		$event_start_date = $wpdb->get_var('SELECT event_start_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
		if (!empty($event_start_date)) {
			$date1 = new DateTime($event_start_date);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2) {
				$this->uat_update_events_status($event_id, 'uat_live');
			} else {
				$this->uat_update_events_status($event_id, 'uat_future');
			}
			return ($date1 < $date2);
		} else {
			return FALSE;
		}
	}
	public function uat_update_events_status($event_id, $event_status)
	{
		global $wpdb;
		/* uat_past | uat_live | uat_future */
		$wpdb->query("update " . UA_EVENTS_TABLE . " set event_status='$event_status' WHERE  post_id=" . $event_id);
		$this->uat_update_events_product_status($event_id, $event_status);
	}
	public function uat_update_events_product_status($event_id, $event_status)
	{
		$product_ids = get_auction_products_ids_by_event($event_id);
		wc_get_logger()->info( wc_print_r( $product_ids, true ), array( 'source' => 'cron-event' ) );
		$product_ids = unserialize($product_ids);
		if (!empty($product_ids) && count($product_ids) > 0) {
			foreach ($product_ids as $product_id) {
				$this->uat_update_product_status($product_id, $event_status);
				$is_seller_product = get_post_meta($product_id, 'uat_seller_id', true);
				if (!empty($is_seller_product)) {
					wc_get_logger()->info('event_status : '.$event_status, array( 'source' => 'cron-event' ) );
					$status = str_replace('uat_', '', $event_status);
					$new_p_status = apply_filters('uat_seller_product_json_status_changed', $old_status = "", $status, $product_id);
					if (!empty($new_p_status)) {
						wc_get_logger()->info('new_p_status : '.$new_p_status.' new_p_status : '.$new_p_status, array( 'source' => 'cron-event' ) );
						wp_update_post(array(
							'ID' => $product_id,
							'post_status' => $new_p_status,
						));
					}
				}
			}
		}
	}
	public  function uat_event_check_completed($event_id = null)
	{
		global $wpdb;
		$end_dates = $wpdb->get_var('SELECT event_end_date FROM ' . UA_EVENTS_TABLE . " WHERE post_id=" . $event_id);
		if (!empty($end_dates)) {
			$date1 = new DateTime($end_dates);
			$date2 = new DateTime(current_time('mysql'));
			if ($date1 < $date2) {
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}
	public function uat_product_check_expired_last_callback($product_id = null)
	{
		$options = get_option('uat_cron_process_status');
		if ($options != '1') {
			update_option('uat_cron_process_status', '1');
			$WC_Product_Auction = new WC_Product_Auction($product_id);
			$winner_email_send = false;
			$loser_email_send = false;
			$options_cron_winner_email =  get_option('options_cron_winner_email', 'on');
			if (!empty($options_cron_winner_email) && $options_cron_winner_email == 'on') {
				$winner_email_send = true;
			}

			$options_cron_loser_email =  get_option('options_cron_loser_email', "off");
			if (!empty($options_cron_loser_email) && $options_cron_loser_email == 'on') {
				$loser_email_send = true;
			}
			try {
				$WC_Product_Auction->proccess_expire($payment = true, $order = true, $emails = true, $winner_email = $winner_email_send, $loser_email = $loser_email_send);
				update_option('uat_cron_process_status', '0');
			} catch (Exception $ex) {
				update_option('uat_cron_process_status', '0');
			}
			update_option('uat_cron_process_status', '0');
		}

		return false;
	}
}
$uwa_auctions = new Uat_Auction_Expire();
function email_order_status_completed($order_id)
{
	$check_fees_order = get_post_meta($order_id, 'onetime_fee_order', true);
	if (empty($check_fees_order)) {
		$PaymentConfirmationMail = new PaymentConfirmationMail();
		$PaymentConfirmationMail->payment_confirmation_email($order_id);
		ob_clean();
	}
}
add_action('woocommerce_order_status_completed', 'email_order_status_completed', 10, 1);
