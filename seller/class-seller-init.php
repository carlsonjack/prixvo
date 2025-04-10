<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 *
 * Seller Package Initialize
 *
 * @class  UAT_Sellers_Init
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if (!class_exists('UAT_Sellers_Init')) :
	class UAT_Sellers_Init
	{
		private static $instance;
		private $seller_enabled;
		private $seller_dashboard_sortcode;
		public $seller_all_pages_endpoints;
		public $seller_all_product_statuses;
		public $seller_all_product_shipping_statuses;
		public $seller_order_unpaid_status;
		public $seller_order_paid_status;
		public $seller_template_location;
		public $seller_action_auction_slug;
		public $seller_action_user_badges;
		public $seller_payment_meta_title;
		public $seller_dashboard_p_list_per_page = 12;
		public $imageUploadMode = 'default'; // 'media_gallery' - not working
		public static $seller_all_product_statuses_static;
		public static $seller_all_product_shipping_statuses_static;

		/**
		 * Returns the *Singleton* instance of this class.
		 *
		 * @return Singleton The *Singleton* instance.
		 *
		 */
		public static function get_instance()
		{
			if (null === self::$instance) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		public function __construct()
		{
			global $UATS_options;
			$this->seller_action_auction_slug = 'auction-action';
			$UATS_options['seller_action_auction_slug'] = 'auction-action';
			$this->seller_action_user_badges = array(
				'top' => __('Top', 'ultimate-auction-pro-software'),
				'private' => __('Private', 'ultimate-auction-pro-software'),
				'professional' => __('Professional', 'ultimate-auction-pro-software'),
				'trusted' => __('Trusted', 'ultimate-auction-pro-software'),
				'verified' => __('Verified', 'ultimate-auction-pro-software'),
				'expert' => __('Expert', 'ultimate-auction-pro-software'),
			);
			$UATS_options['seller_action_user_badges'] = $this->seller_action_user_badges;
			$this->seller_template_location = 'page-templates/seller/';
			$UATS_options['page_template_location'] = $this->seller_template_location;
			$this->seller_dashboard_sortcode = 'uat_seller_dashboard';
			$this->seller_all_product_statuses = $this->uat_get_product_status_results();
			$UATS_options['all_product_statuses'] = $this->seller_all_product_statuses;
			$this->seller_all_product_shipping_statuses = $this->uat_get_product_shipping_status_results();
			$UATS_options['all_product_shipping_statuses'] = $this->seller_all_product_shipping_statuses;
			$UATS_options['seller_p_list_per_page'] = $this->seller_dashboard_p_list_per_page;
			$UATS_options['imageUploadMode'] = $this->imageUploadMode;
			$this->seller_payment_meta_title = __('Seller payment details', 'ultimate-auction-pro-software');
			add_action('init', array($this, 'uat_add_seller_role'));
			add_filter('woocommerce_product_post_statuses', array($this, 'uat_add_product_status'));
			add_action('init', array($this, 'uat_register_product_status'));
			add_action('admin_footer-edit.php', array($this, 'uat_product_statuses_display_admin'));
			add_action('admin_footer-post.php', array($this, 'uat_product_statuses_display_admin'));
			add_action('admin_footer-post-new.php', array($this, 'uat_product_statuses_display_admin'));
			add_action('pre_get_posts', array($this, 'uat_filter_media_library_by_user'));
			add_action('init', array($this, 'uat_seller_payment_setings'));
			add_action('init', array($this, 'setup_seller_dashboard_page'));
			add_action('init', array($this, 'seller_pages_endpoints'));
			add_action('init', array($this, 'register_pages_endpoints'));
			add_action('wp_enqueue_scripts', array($this, 'seller_pages_style_scripts'));
			add_action('uat_seller_product_status_update', array($this, 'uat_seller_product_status_update'), 10, 3);
			add_action('uat_seller_product_status_changed', array($this, 'uat_seller_product_status_changed'), 10, 3);
			add_filter('uat_seller_product_json_status_changed', array($this, 'uat_seller_product_json_status_changed'), 10, 3);

			/* add badges to user page admin */
			add_action('show_user_profile', array($this, 'uat_seller_profile_fields'));
			add_action('edit_user_profile', array($this, 'uat_seller_profile_fields'));
			add_action('personal_options_update', array($this, 'uat_seller_save_profile_fields'));
			add_action('edit_user_profile_update', array($this, 'uat_seller_save_profile_fields'));


			add_action('init', array($this, 'uat_seller_order_unpaid_status'));
			add_action('init', array($this, 'uat_seller_order_paid_status'));
			add_action('init', array($this, 'uat_seller_order_add_meta_box'));
			// add_action('init', array($this, 'uat_seller_invoice_plugin_init'));
		}

		/* register order meta box add for seller */
		public function uat_seller_order_add_meta_box()
		{
			add_meta_box(
				'uat-seller-payment-order-meta-box',
				$this->seller_payment_meta_title,
				array($this, 'render_custom_order_meta_box'),
				array( 'shop_order','woocommerce_page_wc-orders' ),
				'normal',
				'default'
			);
		}
		/* conent of order meta box added for seller */
		public function render_custom_order_meta_box($post)
		{
			// Get the order object
			$order = wc_get_order($post->ID);
			$order_id = $post->ID;
			$has_offline_dealing_order = get_post_meta($order_id, 'uat_offline_dealing_order', true);
			if(!empty($has_offline_dealing_order)){
				echo __("This offline order needs to be completed with payment outside the website.", 'ultimate-auction-pro-software');
				return false;

			}
			$all_seller_products = [];
			// Get the order items
			$order_items = $order->get_items();

			$currency = get_woocommerce_currency_symbol();
			foreach ($order_items as $item_id => $item) {
				$product_id = $item->get_product_id();
				$product = wc_get_product($product_id);

				// Get seller_id from product meta
				$seller_user_id = get_post_meta($product_id, 'uat_seller_id', true);
				$seller_user_data = get_userdata($seller_user_id);
				$payment_status = __('Pending', 'ultimate-auction-pro-software');
				$payment_method = "-";
				$payment_method_text = "-";
				if (!empty($seller_user_id)) {
					$seller_profile_url = get_author_posts_url($seller_user_id);
					$seller_user_name =    '<a href="' . esc_url($seller_profile_url) . '">' . esc_html($seller_user_data->user_login) . '</a>';
					$seller_payment_method = get_seller_payment_method($seller_user_id);
					if (!empty($seller_payment_method)) {
						$payment_method_text = $seller_payment_method['title'];
						$payment_method = $seller_payment_method['key'];
					}
					$seller_payment_status = 'pending';
					$product_name = $product->get_name();
					$product_link =    '<a href="' . get_edit_post_link($product_id) . '">' . esc_html($product_name) . '</a>';
					$product_price = $product->get_price();
					$seller_payment_total = 0;
					$admin_commission_amount = get_post_meta($product_id, 'admin_commission_amount', true);
					if (!empty($admin_commission_amount)) {
						$seller_payment_total =  $product_price - $admin_commission_amount;
					} else {
						$uat_admin_commission_percentage = get_option("options_uat_admin_commission_percentage", '0');
						if (!empty($uat_admin_commission_percentage) && $uat_admin_commission_percentage > 0) {
							$seller_payment_total = ($product_price * $uat_admin_commission_percentage) / 100;
							update_post_meta($product_id, 'admin_commission_amount', $seller_payment_total);
						}
						$seller_payment_total =  $product_price - $seller_payment_total;
					}
					$total_seller_payment_paid = 0;
					$payment_id = 0;
					$payments = get_seller_product_payment_details($product_id);
					if (count($payments) > 0) {
						foreach ($payments as $payment) {
							$payment_id = (int)$payment->id;
							$seller_payment_status = $payment->status;
							if ($seller_payment_status == 'paid') {
								$payment_status = __('Paid', 'ultimate-auction-pro-software');
								$total_seller_payment_paid = $payment->transaction_amount;
							}
							if ($seller_payment_status == 'started') {
								$payment_status = __('Started', 'ultimate-auction-pro-software');
							}
						}
					}
					$seller_product = [];
					$seller_product['id'] = $product_id;
					$seller_product['name'] = $product_link;
					$seller_product['price'] = $product_price;
					$seller_product['admin_commission'] = $admin_commission_amount;
					$seller_product['seller_payout'] = $seller_payment_total;
					$seller_product['seller_paid'] = $total_seller_payment_paid;
					$seller_product['payment_id'] = $payment_id;
					$seller_product['payout_status'] = $seller_payment_status;
					$seller_product['payout_status_text'] = $payment_status;
					$seller_product['payments'] = $payments;

					if (isset($all_seller_products[$seller_user_id])) {
						$seller_data = $all_seller_products[$seller_user_id];
					} else {
						$seller_data = [];
						$seller_data['id'] = $seller_user_id;
						$seller_data['name'] = $seller_user_name;
						$seller_data['payment_method'] = $payment_method;
						$seller_data['payment_method_data'] = $seller_payment_method;
						$seller_data['payment_method_text'] = $payment_method_text;
					}
					$seller_data['products'][] = $seller_product;
					$all_seller_products[$seller_user_id] = $seller_data;
				} else {
					continue;
				}
			}
			if (!empty($all_seller_products)) {
				foreach ($all_seller_products as $seller_id => $seller_data) {
					$seller_name = $seller_data['name'];
					$payment_method = $seller_data['payment_method'];
					$payment_method_text = $seller_data['payment_method_text'];
					$payment_method_data = $seller_data['payment_method_data'];
					$seller_products = $seller_data['products'];
					echo "<h3>" . __('Seller', 'ultimate-auction-pro-software') . " : " . $seller_name . "</h3>";
					echo "<h3>" . __('Payment method', 'ultimate-auction-pro-software') . " : " . $payment_method_text . "</h3>";

					echo '<table class="wp-list-table widefat fixed striped">';
					echo '<thead><tr>';
					echo '<th>' . __('Product', 'ultimate-auction-pro-software') . '</th>';
					echo '<th>' . __('Product price', 'ultimate-auction-pro-software') . '</th>';
					echo '<th>' . __('Admin commission', 'ultimate-auction-pro-software') . '</th>';
					echo '<th>' . __('Amount to pay', 'ultimate-auction-pro-software') . '</th>';
					echo '<th>' . __('Amount paid', 'ultimate-auction-pro-software') . '</th>';
					echo '<th>' . __('Payout action', 'ultimate-auction-pro-software') . '</th>';
					if (check_invoice_plugin_active()) {
						echo '<th>' . __('Invoice/Receipt', 'ultimate-auction-pro-software') . '</th>';
					}
					echo '</tr></thead>';
					echo '<tbody>';
					$total_seller_payment = 0;
					$total_seller_payment_paid = 0;
					$payment_ids = [];
					foreach ($seller_products as $no => $product) {
						$invoice_btns = "";
						$payout_msg = __('Pending payment', 'ultimate-auction-pro-software');
						$product_id = $product['id'];
						$product_name = $product['name'];
						$product_price = $product['price'];
						$product_payments = $product['payments'];
						$product_admin_commission = $product['admin_commission'];
						$product_seller_payout = $product['seller_payout'];
						$seller_paid = $product['seller_paid'];
						$product_payout_status = $product['payout_status'];
						$seller_payment_status = 'pending';
						$payment_id = $product['payment_id'];
						if (!empty($payment_id)) {
							$payment_ids[] = (int)$payment_id;
						}
						if ($product_payout_status == 'paid' && check_invoice_plugin_active()) {
							$invoice_btns = get_sold_action_buttons($product_id);
						}

						if ($product_payout_status == 'failed') {
							if ($payment_method != 'bank') {
								$payout_msg = __('Payment is failed to pay with automatic payment', 'ultimate-auction-pro-software');
							} else {
								$payout_msg = __('Payment is failed to pay with manual payment', 'ultimate-auction-pro-software');
							}
						}
						if ($product_payout_status == 'started') {
							if ($payment_method != 'bank') {
								$payout_msg = __('Payment is started with automatic payment', 'ultimate-auction-pro-software');
							} else {
								$payout_msg = __('Payment is started with manual payment', 'ultimate-auction-pro-software');
							}
						}
						echo '<tr>';
						echo '<td>' . $product_name . '</td>';
						echo '<td>' . wc_price($product_price) . '</td>';
						echo '<td>' . wc_price($product_admin_commission) . '</td>';
						echo '<td>' . wc_price($product_seller_payout) . '</td>';
						echo '<td>' . wc_price($seller_paid) . '</td>';
						echo '<td>';
						if (empty($seller_payment_method)) {
							echo __('No payment method found on seller', 'ultimate-auction-pro-software');
						}
						add_thickbox();
						$view_api_log = "<a title='Seller payment status' href='#TB_inline?&inlineId=payment-log-id-" . $product_id . "' class='button button-secondary thickbox'>" . __('View details', 'ultimate-auction-pro-software') . '</a>';
						echo $view_api_log;
						?>
						<div class="payment-details-popup" id="payment-log-id-<?php echo $product_id; ?>" style="display:none;">
							<input type="hidden" name="order_id" value="<?php echo $order_id; ?>" />
							<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
							<input type="hidden" name="seller_id" value="<?php echo $seller_id; ?>" />
							<input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>" />
							<input type="hidden" name="admin_commission" value="<?php echo $product_admin_commission; ?>" />
							<input type="hidden" name="transaction_type" value="seller_payout" />
							<div class="order-popup-main-heading">
								<h1><?php echo __('Seller details', 'ultimate-auction-pro-software'); ?></h1>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Seller', 'ultimate-auction-pro-software'); ?>: <span><?php echo $seller_name; ?></span></h4>
							</div>
							<h4><?php echo __('Payment method', 'ultimate-auction-pro-software'); ?>: <span><?php echo $payment_method_text; ?></span></h4>
							<?php
							if ($payment_method == 'bank') {
								$payment_method_data = $payment_method_data['data'] ?? [];
								if (!empty($payment_method_data)) {
									$payment_method_data_bank = $payment_method_data['bank'] ?? "";
									if (!empty($payment_method_data_bank)) {
										$ac_name = $payment_method_data_bank['ac_name'];
										$ac_number = $payment_method_data_bank['ac_number'];
										$bank_name = $payment_method_data_bank['bank_name'];
										$bank_addr = $payment_method_data_bank['bank_addr'];
										$routing_number = $payment_method_data_bank['routing_number'];
										$iban = $payment_method_data_bank['iban'];
										$swift = $payment_method_data_bank['swift'];
										$ifsc = $payment_method_data_bank['ifsc'];
							?>
										<div class="order-popup-main-heading">
											<h1><?php echo __('Bank details', 'ultimate-auction-pro-software'); ?></h1>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Account Name', 'ultimate-auction-pro-software'); ?>: <span><?php echo $ac_name; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Account Number', 'ultimate-auction-pro-software'); ?>: <span><?php echo $ac_number; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Bank Name', 'ultimate-auction-pro-software'); ?>: <span><?php echo $bank_name; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Bank Address', 'ultimate-auction-pro-software'); ?>: <span><?php echo $bank_addr; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Routing Number', 'ultimate-auction-pro-software'); ?>: <span><?php echo $routing_number; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('IBAN', 'ultimate-auction-pro-software'); ?>: <span><?php echo $iban; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Swift Code', 'ultimate-auction-pro-software'); ?>: <span><?php echo $swift; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('IFSC Code', 'ultimate-auction-pro-software'); ?>: <span><?php echo $ifsc; ?></span></h4>
										</div>
							<?php
									}
								}
							}
							?>
							<div class="order-popup-main-heading">
								<h1><?php echo __('Product details', 'ultimate-auction-pro-software'); ?></h1>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Product', 'ultimate-auction-pro-software'); ?>: <span><?php echo $product_name; ?></span></h4>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Winning bid', 'ultimate-auction-pro-software'); ?>: <span><?php echo wc_price($product_price); ?></span></h4>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Admin commission', 'ultimate-auction-pro-software'); ?>: <span><?php echo wc_price($product_admin_commission); ?></span></h4>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Amount to pay', 'ultimate-auction-pro-software'); ?>: <span><?php echo wc_price($product_seller_payout); ?></span></h4>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Amount paid', 'ultimate-auction-pro-software'); ?>: <span><?php echo wc_price($seller_paid); ?></span></h4>
							</div>
							<div class="order-popup-heading">
								<h4><?php echo __('Payment status', 'ultimate-auction-pro-software'); ?>: <span><?php echo $payout_msg; ?></span></h4>
							</div>
							<?php
							if (empty($seller_payment_method)) {
							?>
								<div class="order-popup-heading">
									<h4><?php echo __('There is no payment method setup on the seller', 'ultimate-auction-pro-software'); ?></h4>
								</div>
							<?php
							} else {
							?>
								<div class="order-popup-main-heading">
									<h1><?php echo __('Transaction details', 'ultimate-auction-pro-software'); ?></h1>
								</div>
								<?php
								if (count($product_payments) > 0) {

									foreach ($product_payments as $payment) {
										$payment_id = $payment->id;
										$transaction_id = $payment->transaction_id;
										$transaction_msg = $payment->transaction_msg;
										$updated_at = $payment->updated_at;
										$transaction_status = $payment->status;
										$transaction_amount = $payment->transaction_amount;
										$formatted_date = date_i18n(get_option('date_format'), strtotime($updated_at));

								?>
										<div class="order-popup-heading">
											<h4><?php echo __('Transaction id', 'ultimate-auction-pro-software'); ?>: <span><?php echo $transaction_id; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Transaction amount', 'ultimate-auction-pro-software'); ?>: <span><?php echo wc_price($transaction_amount); ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Transaction status', 'ultimate-auction-pro-software'); ?>: <span><?php echo ucfirst($transaction_status); ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Transaction date', 'ultimate-auction-pro-software'); ?>: <span><?php echo $formatted_date; ?></span></h4>
										</div>
										<div class="order-popup-heading">
											<h4><?php echo __('Transaction message', 'ultimate-auction-pro-software'); ?>: <span><?php echo $transaction_msg; ?></span></h4>
										</div>
										<?php
										if ($product_payout_status == 'started') {
										?>
											<h3><?php echo __('Note:', 'ultimate-auction-pro-software'); ?></h3>
											<h4><?php echo __('This transaction was made by automated payment so please verify from your payment gateway with this transaction id that the payment transfer is successful then mark it as paid', 'ultimate-auction-pro-software'); ?></h4>
										<?php
										} else if ($product_payout_status == 'pending') {
										?>
											<div class="uat-seller-order-popup-row order-popup-heading">
												<h4><?php echo __('Transaction id', 'ultimate-auction-pro-software'); ?></h4>
												<input type="text" name="transaction_id" id="transaction_id" value="<?php echo $transaction_id; ?>" />
											</div>
											<div class="uat-seller-order-popup-row order-popup-heading">
												<h4><?php echo __('Transaction amount', 'ultimate-auction-pro-software') . "(" . $currency . ")"; ?></h4>
												<input type="text" name="transaction_amount" id="transaction_amount" value="<?php echo $product_seller_payout; ?>" />
											</div>
											<div class="uat-seller-order-popup-row order-popup-heading">
												<h4><?php echo __('Transaction message', 'ultimate-auction-pro-software'); ?></h4>
												<input type="text" name="transaction_msg" id="transaction_msg" value="<?php echo __('Payment is paid with manual payment', 'ultimate-auction-pro-software'); ?>" />
											</div>
											<div class="uat-seller-order-popup-row order-popup-heading">
												<h3><?php echo __('Note:', 'ultimate-auction-pro-software'); ?></h3>
												<h4><?php echo __('This transaction needs to be done through manual payment.', 'ultimate-auction-pro-software'); ?></h4>
												<h4><?php echo __('So please transfer the payment manually for the above details, if transferred add the \'Transaction ID\', message (for your reference) and then mark it as paid.', 'ultimate-auction-pro-software'); ?></h4>
											</div>
										<?php
										}
										if ($product_payout_status != 'paid') {
										?>
											<div class="uat-seller-order-popup-row order-popup-heading">
												<div>
													<h4><?php echo __('Payment actions', 'ultimate-auction-pro-software'); ?>:
												</div>
												<button type='button' class='button button-secondary thickbox ' id="make_as_paid" data-payment-status="paid" data-payment-id="<?php echo $payment_id; ?>">
													<?php echo __('Mark as paid', 'ultimate-auction-pro-software'); ?>
												</button>
												</h4>
											</div>
									<?php
										}
									}
								} else {
									?>
									<div class="uat-seller-order-popup-row order-popup-heading">
										<h4><?php echo __('Transaction id', 'ultimate-auction-pro-software'); ?></h4>
										<input type="text" name="transaction_id" id="transaction_id" />
									</div>
									<div class="uat-seller-order-popup-row order-popup-heading">
										<h4><?php echo __('Transaction amount', 'ultimate-auction-pro-software') . "(" . $currency . ")"; ?></h4>
										<input type="text" name="transaction_amount" id="transaction_amount" value="<?php echo $product_seller_payout; ?>" />
									</div>
									<div class="uat-seller-order-popup-row order-popup-heading">
										<h4><?php echo __('Transaction message', 'ultimate-auction-pro-software'); ?></h4>
										<input type="text" name="transaction_msg" id="transaction_msg" value="<?php echo __('Payment is paid with manual payment', 'ultimate-auction-pro-software'); ?>" />
									</div>
									<div class="uat-seller-order-popup-row order-popup-heading">
										<h3><?php echo __('Note:', 'ultimate-auction-pro-software'); ?></h3>
										<h4><?php echo __('This transaction needs to be done through manual payment.', 'ultimate-auction-pro-software'); ?></h4>
										<h4><?php echo __('So please transfer the payment manually for the above details, if transferred add the \'Transaction ID\', message (for your reference) and then mark it as paid.', 'ultimate-auction-pro-software'); ?></h4>
									</div>
									<div class="uat-seller-order-popup-row order-popup-heading">
										<div>
											<h4><?php echo __('Payment actions', 'ultimate-auction-pro-software'); ?>:
										</div>
										<button type='button' class='button button-secondary thickbox ' id="make_as_paid" data-payment-status="paid" data-payment-id="">
											<?php echo __('Mark as paid', 'ultimate-auction-pro-software'); ?>
										</button>
										</h4>
									</div>
							<?php
								}
							}

							echo "<h2 id='payment-details-container' style='display:none;'></h2>"
							?>
						</div>
						<?php
						echo '</td>';
						if (check_invoice_plugin_active()) {
							echo '<td>' . $invoice_btns . '</td>';
						}
						echo '</tr>';
						$total_seller_payment += $product_seller_payout;
						$total_seller_payment_paid += $seller_paid;
					}
					echo '</tbody>';
					echo '</table>';
					echo "<h3>" . __('Total amount to pay', 'ultimate-auction-pro-software') . " : " . wc_price($total_seller_payment) . "</h3>";
					echo "<h3>" . __('Total amount paid', 'ultimate-auction-pro-software') . " : " . wc_price($total_seller_payment_paid) . "</h3>";
					if (count($all_seller_products) > 1) {
						echo "<hr>";
					}
				}
				wp_enqueue_script('seller-order-admin-js', get_stylesheet_directory_uri() . '/assets/js/seller/seller-order-admin.js', array('jquery'), '1.0', true);
				$seller_payment_js_data = [];
				$seller_payment_js_data['ajax_url']  = admin_url('admin-ajax.php');
				wp_localize_script('seller-order-admin-js', 'sellerAdminOrderData', $seller_payment_js_data);
			} else {
				echo "<h2>" . __('No seller products found in this order', 'ultimate-auction-pro-software') . "</h2>";
			}
		}
		/* setup payment setings for seller */
		public function uat_seller_payment_setings()
		{
			global $UATS_options;
			$seller_payment_settings = [];
			$uat_seller_settings_payment_methods = get_option("options_uat_seller_settings_payment_methods");
			if (!empty($uat_seller_settings_payment_methods)) {
				if ($uat_seller_settings_payment_methods == 'manual') {
					$seller_payment_settings["payment_methods"][] = array("key" => "bank", "title" => __('Manual payment', 'ultimate-auction-pro-software'));
				}
				if ($uat_seller_settings_payment_methods == 'automatic') {
					$Uat_Auction_Payment = new Uat_Auction_Payment();
					$payment_gatway_settings = $Uat_Auction_Payment->get_payment_gatway_settings();
					$gateway = $payment_gatway_settings['gateway'] ?? "";
					if ($gateway == 'stripe') {
						$seller_payment_settings["payment_methods"][] = array("key" => "stripe_split_pay", "title" => __('Automate payment', 'ultimate-auction-pro-software'));
					}
					/* Braintree options add here */
				}
			}
			$UATS_options['seller_payment_settings'] = $seller_payment_settings;
		}
		/* get default wocomerce order that contains unpaid status */
		public function uat_seller_order_unpaid_status()
		{
			global $UATS_options;
			$unpaid_statuses = array(
				'pending' => 'Pending Payment',
				'failed' => 'Failed',
			);
			$this->seller_order_unpaid_status = apply_filters('uat_order_unpaid_status', $unpaid_statuses);
			$UATS_options['uat_seller_order_unpaid_status'] = $this->seller_order_unpaid_status;
		}
		/* get default wocomerce order that contains paid status */
		public function uat_seller_order_paid_status()
		{
			global $UATS_options;
			$paid_statuses = array(
				'completed' => 'Completed',
				'processing' => 'Processing',
				'on-hold' => 'On Hold',
				'refunded' => 'Refunded',
			);
			$this->seller_order_paid_status = apply_filters('uat_order_paid_status', $paid_statuses);
			$UATS_options['uat_seller_order_paid_status'] = $this->seller_order_paid_status;
		}
		/* add badges to user page admin */
		public function uat_seller_profile_fields($user)
		{
			if (in_array(UAT_SELLER_ROLE_KEY, (array) $user->roles)) {
				$user_badges = get_the_author_meta('user_badges', $user->ID, true);
				$seller_action_user_badges = $this->seller_action_user_badges
				?>
				<table class="form-table">
					<tr>
						<th><label for="_block_to_bid"><?php _e('User badges', 'ultimate-auction-pro-software'); ?></label></th>
						<td>
							<?php
							foreach ($seller_action_user_badges as $key => $badge) {
								$checked = in_array($key, explode(',', $user_badges)) ? 'checked' : '';
								echo '<label><input type="checkbox" name="user_badges[]" value="' . $key . '" ' . $checked . '> ' . $badge . '</label>';
							}
							?>
						</td>
					</tr>
				</table>
<?php
			}
		}
		/* save badges to user page admin */
		public function uat_seller_save_profile_fields($user_id)
		{
			if (!current_user_can('edit_user', $user_id)) {
				return false;
			} else {
				$user = get_userdata($user_id);
				if (in_array(UAT_SELLER_ROLE_KEY, (array) $user->roles)) {
					$selected_badges = isset($_POST['user_badges']) ? $_POST['user_badges'] : array();
					$user_badges = implode(',', $selected_badges);
					update_user_meta($user_id, 'user_badges', $user_badges);
				}
			}
		}
		/* when new product added in event change status */
		public function uat_seller_product_json_status_changed($old_status, $status, $product_id)
		{
			$new_status = "";
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
			return $new_status;
		}
		/* when new product added in event change status */
		public function uat_seller_product_status_update($product_ids_array, $new_status)
		{
			foreach ($product_ids_array as $product_id) {
				$uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
				$uat_seller_id = get_post_meta($product_id, 'uat_seller_id', true);
				if (!empty($uat_event_id) && !empty($uat_seller_id)) {
					$old_status = "";
					wp_update_post(array(
						'ID' => $product_id,
						'post_status' => $new_status,
					));
				}
			}
		}
		/* when new status is changed on product then will use this callback is used like send notifications */
		public function uat_seller_product_status_changed($old_status, $new_status, $product_id)
		{
			if (empty($product_id) || empty($new_status)) {
				return;
			}
			$is_seller_product = get_post_meta($product_id, 'uat_seller_id', true);
			if (empty($is_seller_product)) {
				return;
			}
			/* send notifications to seller of product status changed*/
			$statuses_all = self::$seller_all_product_statuses_static;
			$statuses = self::uat_get_product_status($new_status);

			if (count($statuses) != count($statuses_all)) {
				wc_get_logger()->info('product submied ' . $old_status . " - " . $new_status, array('source' => 'new_status-product'));
				$ProductStatusChange = new ProductStatusChange();
				$ProductStatusChange->status_change_email($new_status . '_mail', $product_id);
			}
		}
		/* add all seller roles used in saller dashboard */
		public function uat_add_seller_role()
		{
			// remove_role(UAT_SELLER_ROLE_KEY);
			$capabilities = array(
				// 'read' => true,  
				'upload_files' => true,
				// 'edit_post' => false,
				// 'edit_product' => false,
				// 'read_post' => false,
				// 'read_product' => false,
				// 'delete_post' => false,
				// 'delete_product' => false,
				// 'edit_posts' => false,
				// 'edit_products' => false,
				// 'publish_posts' => false,
				// 'publish_products' => false
				// 'activate_plugins' => false,
				// 'level_0'=> false
			);
			add_role(UAT_SELLER_ROLE_KEY, UAT_SELLER_ROLE_TEXT, $capabilities);
		}

		/* add all seller scripts used in saller dashboard */
		public function seller_pages_style_scripts()
		{
			wp_enqueue_media();
			wp_enqueue_script('jquery');
			wp_register_style('uat-seller-style', UAT_THEME_PRO_CSS_URI . '/vendor.css', array());
			wp_enqueue_style('uat-seller-style');
		}

		/* add all seller end-points used in saller with name and template file name */
		public function seller_pages_endpoints()
		{

			$seller_pages_endpoints = array(
				array(
					'slug' => 'dashboard',
					'title_text' => 'Dashboard',
					'template' => 'dashboard.php',
					'is_dashboard_page' => 'yes'
				),
				array(
					'slug' => $this->seller_action_auction_slug,
					'title_text' => 'Add Auction',
					'template' => 'add-auction.php',
					'is_dashboard_page' => 'no'
				),
				array(
					'slug' => 'in-auction',
					'title_text' => 'In Auction',
					'template' => 'in-auction.php',
					'is_dashboard_page' => 'yes'
				),
				array(
					'slug' => 'invalid',
					'title_text' => 'Invalid Page',
					'template' => 'invalid.php',
					'is_dashboard_page' => 'no'
				),
				array(
					'slug' => 'submission',
					'title_text' => 'submission',
					'template' => 'submission.php',
					'is_dashboard_page' => 'yes',
					'have_pagination' => 'yes'
				),
				array(
					'slug' => 'sold',
					'title_text' => 'Sold',
					'template' => 'sold.php',
					'is_dashboard_page' => 'yes'
				),
				array(
					'slug' => 'order-view',
					'title_text' => 'Order view',
					'template' => 'order-view.php',
					'is_dashboard_page' => 'yes'
				),
				array(
					'slug' => 'payments',
					'title_text' => 'Payments',
					'template' => 'payments.php',
					'is_dashboard_page' => 'yes'
				)
			);


			$seller_pages_endpoints = apply_filters('custom_seller_pages_endpoints', $seller_pages_endpoints);
			$this->seller_all_pages_endpoints = $seller_pages_endpoints;
			return $seller_pages_endpoints;
		}
		/* get one endpoint by slug */
		public function uat_get_one_endpoint($slug = "")
		{
			$endpoint = [];
			if (!empty($slug)) {
				$seller_pages_endpoints = $this->seller_all_pages_endpoints;
				foreach ($seller_pages_endpoints as $array) {
					if ($array['slug'] === $slug) {
						$endpoint = $array;
						break; // Stop the loop once a match is found
					}
				}
			}
			return $endpoint;
		}
		/* Add all product status that used on seller products */
		public function uat_get_product_status_results()
		{
			// $seller_lot_actions = ['preview', 'edit', 'copy', 'delete', 'view_lot', 'view_order', 'request_changes'];
			$seller_product_statuses = [];
			$seller_product_statuses[] = [
				'slug' => 'draft',
				'label' => __('Draft', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'no',
				'seller_actions' => ['edit', 'copy', 'delete'],
			];
			// $seller_product_statuses[] = [  'slug' => 'publish',
			// 								'label' => __('Published', 'ultimate-auction-pro-software'), 
			// 								'show_on_edit_product' => 'yes', 
			// 								'show_on_submission_page' => 'yes', 
			// 								'selectable_for_event' => 'no',
			// 								'is_viewable' => 'no',
			// 								'seller_actions' => ['edit', 'copy', 'delete'],
			// 							];
			$seller_product_statuses[] = [
				'slug' => 'uat_submited',
				'label' => __('Submitted', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'no',
				'seller_actions' => ['copy', 'edit', 'delete'],
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_under_review',
				'label' => __('Under Review', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'no',
				'seller_actions' => ['edit', 'copy', 'delete'],
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_not_approved',
				'label' => __('Not Approved', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'no',
				'seller_actions' => ['copy', 'delete']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_change_needed',
				'label' => __('Adjustment Needed', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'no',
				'seller_actions' => ['edit', 'copy', 'delete']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_approved',
				'label' => __('Approved', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'yes',
				'is_viewable' => 'no',
				'seller_actions' => ['copy']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_planned',
				'label' => __('Planned', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['copy', 'view_lot']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_in_auction',
				'label' => __('Live', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['copy', 'view_lot']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_auctined',
				'label' => __('Auctioned', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['view_lot']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_not_sold',
				'label' => __('Not sold', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['view_lot']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_payment_received',
				'label' => __('Payment received', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['view_lot']
			];
			$seller_product_statuses[] = [
				'slug' => 'uat_paid',
				'label' => __('Paid', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'yes',
				'show_on_submission_page' => 'yes',
				'selectable_for_event' => 'no',
				'is_viewable' => 'yes',
				'seller_actions' => ['view_lot']
			];
			$seller_product_statuses = apply_filters('add_custom_seller_product_statuse', $seller_product_statuses);
			$this->seller_all_product_statuses = $seller_product_statuses;
			self::$seller_all_product_statuses_static = $seller_product_statuses;
			return $seller_product_statuses;
		}
		/* Add all product status that used on seller products */
		public function uat_get_product_shipping_status_results()
		{
			// $seller_lot_actions = ['preview', 'edit', 'copy', 'delete', 'view_lot', 'view_order', 'request_changes'];
			$seller_product_shipping_statuses = [];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_sending',
				'label' => __('Sending', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_transit',
				'label' => __('On Transit', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_delivery',
				'label' => __('On delivery', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_delivered',
				'label' => __('Delivered', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_cancelled',
				'label' => __('Cancelled', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];
			$seller_product_shipping_statuses[] = [
				'slug' => 'uat_claim_open',
				'label' => __('Claim open', 'ultimate-auction-pro-software'),
				'show_on_edit_product' => 'no',
				'show_on_sold_page' => 'yes',
			];

			$seller_product_shipping_statuses = apply_filters('add_custom_seller_product_shipping_statuse', $seller_product_shipping_statuses);
			$this->seller_all_product_shipping_statuses = $seller_product_shipping_statuses;
			self::$seller_all_product_shipping_statuses_static = $seller_product_shipping_statuses;
			return $seller_product_shipping_statuses;
		}
		/* Get one product status */
		public static function uat_get_product_status($key = "")
		{
			$statuses = self::$seller_all_product_statuses_static;
			if (!empty($statuses)) {
				foreach ($statuses as $status) {
					if ($key == $status['slug']) {
						return $status;
					}
				}
			}
			return $statuses;
		}

		/* Register all product status to wocommerce that used on seller products */
		public function uat_add_product_status()
		{
			$seller_product_statuses = $this->seller_all_product_statuses;
			$resgister_status = [];
			foreach ($seller_product_statuses as $status) {
				$slug  = $status['slug'];
				$label = $status['label'];
				$resgister_status[$slug] = $label;
			}
			return $resgister_status;
		}
		/* Register all product status that used on seller products */
		public function uat_register_product_status()
		{
			$seller_product_statuses = $this->seller_all_product_statuses;
			foreach ($seller_product_statuses as $status) {
				$slug  = $status['slug'];
				$label = $status['label'];

				$status_object = get_post_status_object($slug);


				if (!$status_object) {


					register_post_status($slug, array(
						'label'                     => _x($label,  'post'),
						'public'                    => true,
						'exclude_from_search'       => false,
						'show_in_admin_all_list'    => true,
						'show_in_admin_status_list' => true,
						'label_count'               => _n_noop($label . ' <span class="count">(%s)</span>', $label . ' <span class="count">(%s)</span>'),
					));
				}
			}
		}
		/* If admin edit product page all product status that used on seller products */
		public function uat_product_statuses_display_admin()
		{
			global $post, $pagenow;
			$seller_product_statuses = $this->seller_all_product_statuses;
			// $seller_product_statuses[] = ['slug' => 'wc-custom-status','label' => __('Custom Status', 'ultimate-auction-pro-software')];

			/* FROM ALL PRODUCT LIST IN ADMIN CHANGE STATUS FROM QUICK EDIT ALSO */
			if (is_admin()) {
				$script_data = [];
				$script_data['seller_product_statuses']  = $seller_product_statuses;
				wp_enqueue_script('seller-admin-script', get_template_directory_uri() . '/assets/js/seller/seller-admin.js', array('jquery'));
			}

			// Localize the script and pass the PHP array to it
			wp_localize_script('seller-admin-script', 'sellerAdminData', $script_data);
			if (is_admin() && ($pagenow == 'post.php' || $pagenow == 'post-new.php') && get_post_type() == 'product') {
				// Your code for admin edit product page goes here
				echo '<script>
						jQuery(document).ready(function($){';
				$cur_status = $post->post_status;
				foreach ($seller_product_statuses as $status) {
					$slug  = $status['slug'];
					$label = $status['label'];
					// echo 'console.log('.print_r($status, true).')';
					$show_on_edit_product = $status['show_on_edit_product'] ?? "no";
					if ($slug == 'draft') {
						continue;
					}
					if ($show_on_edit_product == 'yes') {
						$selected = "";
						if ($post->post_status === $slug) {
							$selected = ' selected=\"selected\"';
							echo '$(".misc-pub-section #post-status-display").html("' . $label . '");';
						}
						echo '	$("select#post_status").append("<option value=\"' . $slug . '\" ' . $selected . '>' . $label . '</option>");';
						echo '$("select[name=\"_status\"]").append("<option value=\"' . $slug . '\">' . $label . '</option>");';
					}
				}
				echo '  });
					</script>';
			}
		}
		/* modify media access permission  seller specific show */
		public function uat_filter_media_library_by_user($query)
		{
			// Check if we are on the admin media library page
			if (is_admin() && $query->get('post_type') === 'attachment' && !current_user_can('activate_plugins')) {
				// Get the current logged-in user ID
				$user_id = get_current_user_id();
				// Modify the query to include only attachments associated with the current user
				$query->set('author', $user_id);
			}
		}

		/* register all seller end-points to wordpress */
		public function register_pages_endpoints()
		{
			$seller_endpoints = $this->seller_pages_endpoints();
			foreach ($seller_endpoints as $endpoint) {			
				$this->check_and_register_endpoint($endpoint['slug'], $endpoint['title_text'], $endpoint['template']);
			}
		}
		/* Check if endpoint is already registered if not then register */
		public function check_and_register_endpoint($slug, $title_text, $template)
		{
			global $wp_rewrite;
			$endpoints = $wp_rewrite->endpoints;
			// Check if endpoint is already registered
			if (!isset($endpoints[$slug])) {
				// Register endpoint and flush rewrite rules
				add_rewrite_endpoint($slug, EP_ROOT | EP_PAGES);
				flush_rewrite_rules();
			}
		}

		/* this will set seller enabled or not */
		private function is_seller_enabled()
		{
			$uat_seller_dashboard_status = get_option('uat_seller_dashboard_status');
			return UAT_SELLER_PACKAGE_STATUS ?? $uat_seller_dashboard_status;
		}

		/* create dashboard page with sortcode if not exists */
		public function setup_seller_dashboard_page()
		{

			// Check if the seller dashboard page exists
			$page_id = get_option('options_uat_seller_dashboard_page_id');

			// If the page does not exist, create it
			if (empty($page_id)) {
				$page_id = wp_insert_post(array(
					'post_title'     => UAT_SELLER_DEFAULT_PAGE_TITLE ?? 'Seller Dashboard',
					'post_name'      => 'uat-seller-dashboard',
					'post_content'   => '[uat_seller_dashboard]',
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'comment_status' => 'closed',
					'ping_status'    => 'closed',
				));

				// Store the page ID for future reference
				update_option('options_uat_seller_dashboard_page_id', $page_id);
			} else {
				// If the page already exists, update the content with the shortcode
				$post_content = get_post_field('post_content', $page_id);
				$has_shortcode = has_shortcode($post_content, $this->seller_dashboard_sortcode);

				if (!$has_shortcode) {
					if (strpos($post_content, '[uat_seller_dashboard]') === false) {
						$updated_post_content = $post_content . '[uat_seller_dashboard]';
						wp_update_post(array(
							'ID'           => $page_id,
							'post_content' => $updated_post_content,
						));
					}

					// Store the page ID for future reference
					update_option('options_uat_seller_dashboard_page_id', $page_id);
				}
			}
			// Check if the seller dashboard page exists
			$categories_page_id = get_option('options_uat_categories_page_id');

			// If the page does not exist, create it
			if (empty($categories_page_id)) {
				$new_page = array(
					'post_title'    => 'Categories',
					'post_content'  => '',
					'post_status'   => 'publish',
					'post_type'     => 'page',
					'post_author'   => 1,
				);
				// Insert the page into the database
				$categories_page_id = wp_insert_post($new_page);
				// Assign the desired page template to the created page
				update_post_meta($categories_page_id, '_wp_page_template', 'page-categories.php');
				update_option('options_uat_categories_page_id', $categories_page_id);
			} else {
				$template = get_post_meta($categories_page_id, '_wp_page_template');
				if ($template !== 'page-categories.php') {
					update_post_meta($categories_page_id, '_wp_page_template', 'page-categories.php');
				}
			}
		}
		/* create dashboard page with sortcode if not exists */
		public function show_seller_dashboard_page($page = '')
		{
			global $wp, $wp_query, $seller_current_page, $paged;

			if (!is_user_logged_in()) {
				handle_404_error();
			}
			$current_page = "dashboard";
			$current_request = $wp->request;
			$seller_endpoints = $this->seller_pages_endpoints();
			$endpoint_data = [];
			if (!empty($seller_endpoints)) {
				foreach ($seller_endpoints as $endpoint) {
					$endpoint_page = $endpoint['slug'];
					if (substr($current_request, -strlen($endpoint_page)) === $endpoint_page) {
						// echo substr($current_request, -strlen($endpoint_page));
						$current_page = $endpoint_page;
						$endpoint_data = $endpoint;
						break;
					}
				}
			}
			$template_file_name = 'dashboard.php';
			if (!empty($endpoint_data) && $endpoint_data['is_dashboard_page'] == 'no') {
				$template_file_name = $endpoint_data['template'];
				$current_page = $current_request;
			}
			// handle paginations
			if (strpos($current_request, 'page') !== false) {
				$parts = explode("/", $current_request);
				$secondPart = $parts[1];
				if ($secondPart) {
					$have_endpoint = $this->uat_get_one_endpoint($secondPart);
					if ($have_endpoint !== null) {
						$current_page = $secondPart;
						$paged = $parts[3];
					}
				}
			}
			$edit_product_id = "";
			if (strpos($current_request, 'edit') !== false) {
				$template_file_name = 'add-auction.php';
				$parts = explode("/", $current_request);
				$secondPart = $parts[1];
				if ($secondPart) {
					$have_endpoint = $this->uat_get_one_endpoint($secondPart);
					if ($have_endpoint !== null) {
						$edit_product_id = $parts[3];
						$seller_user_id = get_post_meta($edit_product_id, 'uat_seller_id', true);
						if ($seller_user_id == get_current_user_id()) {
							$current_page = $secondPart;
						} else {
							$template_file_name = 'invalid.php';
						}
					}
				}
			}
			$order_id = "";
			if (strpos($current_request, 'order-view') !== false) {
				// $template_file_name = 'order-view.php';
				$parts = explode("/", $current_request);
				$secondPart = $parts[1];
				if ($secondPart) {
					$have_endpoint = $this->uat_get_one_endpoint($secondPart);
					if ($have_endpoint !== null) {
						$order_id = $parts[2];
						if (!empty($order_id)) {
							$current_page = $secondPart;
						} else {
							$template_file_name = 'invalid.php';
						}
					}
				}
			}
			$seller_current_page = $current_page;
			$template_file = $this->seller_template_location . $template_file_name;
			include(locate_template($template_file));
		}
		/* Get total submited products count from seller */
		public static function get_seller_products_count()
		{
			global $UATS_options, $paged;
			$seller_id = get_current_user_id();
			$status_keys = [];
			$all_product_statuses = $UATS_options['all_product_statuses'];
			foreach ($all_product_statuses as $key => $subArray) {
				$one_status = $subArray["slug"];
				if (isset($one_status)) {
					$status_keys[] = $one_status;
				}
			}
			$status_keys[] = 'publish';
			$status_keys[] = 'pending';
			if (current_user_can('manage_options')) {
				$status_keys[] = 'draft';
				$status_keys[] = 'trash';
			}
			$args = array(
				'post_type' => 'product',
				'author' => $seller_id,
				'posts_per_page' => -1,
				'post_status' => $status_keys,
				'tax_query' => array(
					array(
						'taxonomy' => 'product_type',
						'field' => 'slug',
						'terms' => 'auction',
						'operator' => '==',
					),
				),
			);
			$products_query = new WP_Query($args);
			$product_count = $products_query->found_posts;
			return $product_count;
		}
		/* Get total submited products count from seller */
		public function get_seller_add_auction_page()
		{
			$template_file = $this->seller_template_location . $this->seller_action_auction_slug;
			include(locate_template($template_file));
		}
	} /* end of class */

// UAT_Sellers_Init::get_instance();
endif;
