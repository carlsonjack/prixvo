<?php
if (!defined('ABSPATH')) {
	exit;
}
/**
 * Admin Class
 *
 * Handles generic Admin functionality and AJAX requests.
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
class Uat_Auction_Product_Types
{
	private static $instance;
	public $uat_auction_item_condition;
	public $uwa_auction_types;
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
		global $woocommerce;
		/* Create Auction Product Tab */
		add_filter('woocommerce_product_data_tabs', array($this, 'uat_custom_product_tabs'));
		add_action('woocommerce_product_data_panels', array($this, 'uat_options_product_tab_content'));
		/* Create new Product Type - Auction */
		add_filter('product_type_selector', array($this, 'uat_add_auction_product'));
		/* Save Auction Product Data */
		add_action('woocommerce_process_product_meta_auction', array($this, 'uat_save_auction_option_field'));
		/* Auction Product Metabox - Bid History */
		add_action('add_meta_boxes_product', array($this, 'uat_add_auction_metabox'));
		/* Auction Product Condition */
		$this->uat_auction_item_condition =  array('new' => __('New', 'ultimate-auction-pro-software'), 'used' => __('Used', 'ultimate-auction-pro-software'));
		/* Added In Pro */
		$this->uwa_auction_types =  array('normal' => __('Normal', 'ultimate-auction-pro-software'));
		/* Bid Cancel By Admin */
		add_action("wp_ajax_admin_cancel_bid", array($this, "wp_ajax_admin_cancel_bid"));
		/* End Auction by Admin */
		add_action("wp_ajax_uwa_admin_force_end_now", array($this, "uwa_admin_force_end_now_callback"));
		add_action("wp_ajax_uwa_admin_force_make_live_now", array($this, "uwa_admin_force_make_live_now_callback"));
		/* Delete Auction product Meta While duplicating Products */
		add_action("woocommerce_duplicate_product", array($this, "uwa_woocommerce_duplicate_product"));
		/* custom js */
		add_action('admin_footer', array($this, 'uwa_auction_custom_js'));
		/* new auction status in admin side in product list page */
		add_filter('manage_edit-product_columns', array($this, 'uwa_auctions_status_columns'), 20);
		add_action('manage_product_posts_custom_column', array($this, 'uwa_auctions_status_columns_status'), 10, 2);
		add_action('widgets_init', array($this, 'uat_register_auctions_widgets'));
		add_action('woocommerce_update_product', array($this, 'auction_products_type_save_post'), 10, 1);
		add_action('before_delete_post', array($this, 'auction_products_type_before_delete_post'), 10, 1);
		add_action('trashed_post', array($this, 'auction_products_type_trashed_post'), 10, 1);
		add_action('untrash_post', array($this, 'auction_products_type_trashed_post'), 10, 1);
		add_action('untrashed_post', array($this, 'auction_products_type_trashed_post'), 10, 1);
		$gatewayIsReady = gatewayIsReady();
		add_filter('woocommerce_product_data_tabs', array($this, 'uwa_seller_admin_buyer_premium_tabs'));
		add_action('woocommerce_product_data_panels', array($this, 'uwa_seller_admin_buyer_premium_tab_content'));
		if (get_option('options_uat_enable_buyers_premium_sp', "no") == 'yes') {

			add_action('woocommerce_process_product_meta_auction', array($this, 'uwa_seller_save_buyer_premium_auction_option_field'));
		}
		add_filter('woocommerce_product_data_tabs', array($this, 'uwa_admin_sp_credit_card_tabs'));
		add_action('woocommerce_product_data_panels', array($this, 'uwa_admin_sp_credit_card_tab_content'));
		if (get_option('options_uat_enable_credit_cart_sp_products', "no") == 'yes' && $gatewayIsReady) {

			add_action('woocommerce_process_product_meta_auction', array($this, 'uwa_seller_save_credit_card_auction_option_field'));
		}
		/* Total Terms & conditions Tab Section On Auction Detail Page */
		add_filter('woocommerce_product_data_tabs', array($this, 'uat_terms_conditions_tabs'));
		add_action('woocommerce_product_data_panels', array($this, 'uat_terms_conditions_tab_content'));
		if (get_option('options_single_terms_conditions_tab', "off") == 'on') {

			add_action('woocommerce_process_product_meta_auction', array($this, 'uat_terms_conditions_tab_option_field'));
		}
	}
	/**
	 * Save Auction Product Data.
	 *
	 */
	function uat_terms_conditions_tab_option_field($post_id)
	{
		global $wpdb, $woocommerce, $woocommerce_errors;
		$product_type = empty($_POST['product-type']) ? 'simple' : sanitize_title(stripslashes($_POST['product-type']));
		if ($product_type == 'auction') {
			if (isset($_POST['_uat_terms_conditions'])) {
				update_post_meta($post_id, '_uat_terms_conditions', wp_kses_post(stripslashes($_REQUEST['_uat_terms_conditions'])));
			}
		}
	}
	public function uat_terms_conditions_tab_content()
	{
		global $post;
		$product = wc_get_product($post->ID);
		$terms_conditions = get_post_meta($post->ID, '_uat_terms_conditions', true);
?>

		<div id="terms_conditions_auction_options" class="panel woocommerce_options_panel hidden">
			<?php if (get_option('options_single_terms_conditions_tab', "off") == 'on') { ?>
				<div class="uwa_auction_buyers_heading" style="margin-top:15px;margin-bottom:10px;padding-left:12px;font-size:15px;">
					<strong><u><i>
								<?php echo __("Terms & conditions", 'ultimate-auction-pro-software'); ?>
							</i></u></strong>
				</div>
				<?php
				wp_editor($terms_conditions, "_uat_terms_conditions", array('media_buttons' => false, 'textarea_name' => "_uat_terms_conditions", 'textarea_rows' => 4));
				?>

			<?php } else {
				echo '<p>';
				$var = "admin.php?page=ua-auctions-theme-options#uat_pages_setting_tabs";
				$var2 = "Page: Auction Product Detail";
				printf(__('Turn ON Terms &amp; Conditions from the <a target="_blank" href="%s">%s</a> feature for Product Detail Page from Theme settings.', 'ultimate-auction-pro-software'), $var, $var2);
				echo '</p>';
			}
			?>
		</div>


	<?php }
	public function uat_terms_conditions_tabs($product_data_tabs)
	{
		$terms_conditions_tab = array(
			'terms_conditions_tab' => array(
				'label'  => __("Terms & conditions", 'ultimate-auction-pro-software'),
				'target' => 'terms_conditions_auction_options',
				'class'  => array('show_if_auction', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple', 'hide_for_uat_event'),
				'priority' => 5,
			),
		);
		return $terms_conditions_tab + $product_data_tabs;
	}
	/**
	 * Save Auction Product Data.
	 *
	 */
	function uwa_seller_save_credit_card_auction_option_field($post_id)
	{
		global $wpdb, $woocommerce, $woocommerce_errors;
		$product_type = empty($_POST['product-type']) ? 'simple' : sanitize_title(stripslashes($_POST['product-type']));
		if ($product_type == 'auction') {
			/* ---------- credit_card  ---------- */
			$hold_debit = empty($_POST['sp_automatically_debit']) ? 'yes' : sanitize_title(stripslashes($_POST['sp_automatically_debit']));
			update_post_meta($post_id, 'sp_automatically_debit', $hold_debit);
			if ($hold_debit == "no") {
				delete_post_meta($post_id, 'sp_type_automatically_debit_hold_type');
				delete_post_meta($post_id, 'charge_hold_fix_amount');
				$auto_debit_type = empty($_POST['sp_type_automatically_debit']) ? 'stripe_charge_type_full' : sanitize_title(stripslashes($_POST['sp_type_automatically_debit']));
				update_post_meta($post_id, 'sp_type_automatically_debit', $auto_debit_type);
				if ($auto_debit_type == "stripe_charge_type_partially") {
					$p_type = empty($_POST['sp_partial_amount_type']) ? 'flat_rate' : sanitize_title(stripslashes($_POST['sp_partial_amount_type']));
					update_post_meta($post_id, 'sp_partial_amount_type', $p_type);
					$p_amt = empty($_POST['sp_partially_amount']) ? '' : sanitize_title(stripslashes($_POST['sp_partially_amount']));
					update_post_meta($post_id, 'sp_partially_amount', $p_amt);
				} else {
					delete_post_meta($post_id, 'sp_partial_amount_type');
					delete_post_meta($post_id, 'sp_partially_amount');
				}
			} else {

				$sp_type_automatically_debit_hold_type = empty($_POST['sp_type_automatically_debit_hold_type']) ? 'stripe_charge_hold_fix_amount' : sanitize_title(stripslashes($_POST['sp_type_automatically_debit_hold_type']));
				$charge_hold_fix_amount = empty($_POST['charge_hold_fix_amount']) ? '0' : sanitize_title(stripslashes($_POST['charge_hold_fix_amount']));

				update_post_meta($post_id, 'sp_type_automatically_debit_hold_type', $sp_type_automatically_debit_hold_type);
				update_post_meta($post_id, 'charge_hold_fix_amount', $charge_hold_fix_amount);

				delete_post_meta($post_id, 'sp_type_automatically_debit');
				delete_post_meta($post_id, 'sp_partial_amount_type');
				delete_post_meta($post_id, 'sp_partially_amount');
			}
		}  /* end of credit_card */
	}
	/**
	 * Save Auction Product Data.
	 *
	 */
	function uwa_seller_save_buyer_premium_auction_option_field($post_id)
	{
		global $wpdb, $woocommerce, $woocommerce_errors;
		$product_type = empty($_POST['product-type']) ? 'simple' : sanitize_title(stripslashes($_POST['product-type']));
		if ($product_type == 'auction') {
			/* ---------- buyers premium  ---------- */

			if (isset($_POST['uat_buyers_premium_type_sp_main'])) {
				$bp_level = $_POST['uat_buyers_premium_type_sp_main'];
				update_post_meta($post_id, 'uat_buyers_premium_type_sp_main', $bp_level);
				if ($bp_level == "global") {
					delete_post_meta($post_id, 'sp_buyers_premium');
					delete_post_meta($post_id, 'sp_buyers_premium_auto_debit');
					delete_post_meta($post_id, 'sp_buyers_premium_type');
					delete_post_meta($post_id, 'sp_buyers_premium_fee_amt');
					delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_min');
					delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_max');
					delete_post_meta($post_id, 'sp_buyers_premium_bidding');
					delete_post_meta($post_id, 'sp_buyers_premium_buy_now');
				} else {
					if (isset($_POST['sp_buyers_premium'])) {
						$b_level = $_POST['sp_buyers_premium'];
						if ($b_level == "yes") {
							$sp_buyers_premium_auto_debit = $_POST['sp_buyers_premium_auto_debit'];
							$sp_buyers_premium_bidding = $_POST['sp_buyers_premium_bidding'];
							$sp_buyers_premium_buy_now = $_POST['sp_buyers_premium_buy_now'];
							$b_type = $_POST['sp_buyers_premium_type'];
							$b_feeamt = $_POST['sp_buyers_premium_fee_amt'];
							update_post_meta($post_id, 'sp_buyers_premium', $b_level);
							update_post_meta($post_id, 'sp_buyers_premium_auto_debit', $sp_buyers_premium_auto_debit);
							update_post_meta($post_id, 'sp_buyers_premium_bidding', $sp_buyers_premium_bidding);
							update_post_meta($post_id, 'sp_buyers_premium_buy_now', $sp_buyers_premium_buy_now);
							update_post_meta($post_id, 'sp_buyers_premium_type', $b_type);
							delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_min');
							delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_max');
							if ($b_type == "percentage") {
								// fee amount
								if ($b_feeamt >= 0 && $b_feeamt <= 100) {
									update_post_meta($post_id, 'sp_buyers_premium_fee_amt', $b_feeamt);
								} else {
									update_post_meta($post_id, 'sp_buyers_premium_fee_amt', 0);
								}
								// min amount
								if (isset($_POST['sp_buyers_premium_fee_amt_min'])) {
									$b_minamt = $_POST['sp_buyers_premium_fee_amt_min'];
									if (!empty($b_minamt)) {
										update_post_meta($post_id, 'sp_buyers_premium_fee_amt_min', $b_minamt);
									}
								}
								// max amount
								if (isset($_POST['sp_buyers_premium_fee_amt_max'])) {
									$b_maxamt = $_POST['sp_buyers_premium_fee_amt_max'];
									if (!empty($b_maxamt)) {
										update_post_meta($post_id, 'sp_buyers_premium_fee_amt_max', $b_maxamt);
									}
								}
							} elseif ($b_type == "flat") {
								update_post_meta($post_id, 'sp_buyers_premium_fee_amt', $b_feeamt);
							}
						} elseif ($b_level == "no") {
							update_post_meta($post_id, 'sp_buyers_premium', $b_level);
							delete_post_meta($post_id, 'sp_buyers_premium_auto_debit');
							delete_post_meta($post_id, 'sp_buyers_premium_type');
							delete_post_meta($post_id, 'sp_buyers_premium_fee_amt');
							delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_min');
							delete_post_meta($post_id, 'sp_buyers_premium_fee_amt_max');
						}
					}  /* end of buyers premium level */
				}
			}
		}
	}

	public function uwa_admin_sp_credit_card_tab_content()
	{
		global $post;
		$product = wc_get_product($post->ID);
		$gatewayIsReady = gatewayIsReady();

	?>
		<div id="sp_creadit_card_auction_options" class="panel woocommerce_options_panel hidden">
			<?php if (get_option('options_uat_enable_credit_cart_sp_products', "no") == 'yes' && $gatewayIsReady) { ?>
				<div class="uwa_auction_credit_card_main fix-style-issue">
					<div class="uat_credit_cart_heading" style="margin-top:15px;margin-bottom:10px;padding-left:12px;font-size:15px;">
						<strong>
							<u>
								<i><?php echo __("Payment Hold & Debit option on Product Level", 'ultimate-auction-pro-software'); ?> </i>
							</u>
						</strong>
					</div>
					<script>
						jQuery(document).ready(function($) {
							//first load
							var hold_on = jQuery("input[name='sp_automatically_debit']:checked").val();
							if (hold_on == "no") {
								jQuery("div.uat_credit_cart_inner1").css("display", "block");
								jQuery("div.uat_credit_card_hold_inner").css("display", "none");
							} else {
								jQuery("div.uat_credit_card_hold_inner").css("display", "block");
								jQuery("div.uat_credit_cart_inner1").css("display", "none");
							}
							var partially = jQuery("input[name='sp_type_automatically_debit']:checked").val();
							if (partially == "stripe_charge_type_partially") {
								jQuery("div.uat_credit_cart_inner2").css("display", "block");
							} else {
								jQuery("div.uat_credit_cart_inner2").css("display", "none");
							}
							var sp_type_automatically_debit_hold_type = jQuery("input[name='sp_type_automatically_debit_hold_type']:checked").val();
							if (sp_type_automatically_debit_hold_type == "stripe_charge_hold_fix_amount") {
								jQuery("div.uat_credit_card_hold_inner2").css("display", "block");
							} else {
								jQuery("div.uat_credit_card_hold_inner2").css("display", "none");
							}
							//when clock on globally type/
							jQuery('.uat_credit_cart_level_field').on('click', function() {
								if (jQuery("input[name='uat_credit_cart_level']").is(":checked")) {
									var b_selection = jQuery("input[name='uat_credit_cart_level']:checked").val();
									if (b_selection == "product_level") {
										jQuery("div.uat_credit_cart_productlevel").slideDown("slow");
									} else if (b_selection == "globally") {
										jQuery("div.uat_credit_cart_productlevel").slideUp("slow");
									}
								}
							});
							//when click hold the bidding/
							jQuery('.sp_automatically_debit_field').on('click', function() {
								if (jQuery("input[name='sp_automatically_debit']").is(":checked")) {
									var b_selection = jQuery("input[name='sp_automatically_debit']:checked").val();
									if (b_selection == "no") {
										jQuery("div.uat_credit_cart_inner1").slideDown("slow");
										jQuery("div.uat_credit_card_hold_inner").slideUp("slow");

									} else if (b_selection == "yes") {
										jQuery("div.uat_credit_cart_inner1").slideUp("slow");
										jQuery("div.uat_credit_card_hold_inner").slideDown("slow");

									}
								}
							});
							//when click partially /
							jQuery('.sp_type_automatically_debit_field').on('click', function() {
								if (jQuery("input[name='sp_type_automatically_debit']").is(":checked")) {
									var b_selection = jQuery("input[name='sp_type_automatically_debit']:checked").val();
									if (b_selection == "stripe_charge_type_partially") {
										jQuery("div.uat_credit_cart_inner2").slideDown("slow");
									} else {
										jQuery("div.uat_credit_cart_inner2").slideUp("slow");
									}
								}
							});
							//when click fix amount /
							jQuery('.sp_type_automatically_debit_hold_type_field').on('click', function() {
								if (jQuery("input[name='sp_type_automatically_debit_hold_type']").is(":checked")) {
									var b_selection = jQuery("input[name='sp_type_automatically_debit_hold_type']:checked").val();
									if (b_selection == "stripe_charge_hold_fix_amount") {
										jQuery("div.uat_credit_card_hold_inner2").slideDown("slow");
									} else {
										jQuery("div.uat_credit_card_hold_inner2").slideUp("slow");
									}
								}
							});
						}); /* end of document ready */
					</script>
					<div class="uat_credit_cart_productlevel uat_credit_cart_productlevel_fix" style="margin-top:20px;margin-bottom:30px;">
						<?php
						$sp_automatically_debit = get_post_meta($post->ID, 'sp_automatically_debit', true);
						if (!$sp_automatically_debit) {
							$sp_automatically_debit = "no";
						}
						woocommerce_wp_radio(array(
							'id'			=> 'sp_automatically_debit',
							'label'			=> __('Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed.', 'ultimate-auction-pro-software'),
							'value' 		=> $sp_automatically_debit,
							//'style' 		=> '',
							//'wrapper_class' => '',
							'name' 			=> 'sp_automatically_debit',
							'options'		=> array(
								'yes' 		=> __('Yes', 'ultimate-auction-pro-software'),
								'no' 	=> __('No', 'ultimate-auction-pro-software')
							),
						));
						?>

						<div class="uat_credit_card_hold_inner" style="margin-top:20px;margin-bottom:30px;">
							<?php
							$sp_type_automatically_debit_hold_type = get_post_meta($post->ID, 'sp_type_automatically_debit_hold_type', true);
							if (!$sp_type_automatically_debit_hold_type) {
								$sp_type_automatically_debit_hold_type = "stripe_charge_hold_bid_amount";
							}
							woocommerce_wp_radio(array(
								'id'			=> 'sp_type_automatically_debit_hold_type',
								'label'			=> __("Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed.", 'ultimate-auction-pro-software'),
								'value' 		=> $sp_type_automatically_debit_hold_type,
								'name' 			=> 'sp_type_automatically_debit_hold_type',
								'style' => 'width: 10px;',
								'options'		=> array(
									'stripe_charge_hold_fix_amount' 		=> __('One Time Specific Amount', 'ultimate-auction-pro-software'),
									'stripe_charge_hold_bid_amount' 	=> __('Exact Bid Amount Each Time', 'ultimate-auction-pro-software')
								),
							)); ?>
							<div class="uat_credit_card_hold_inner2" style="margin-top:20px;margin-bottom:30px;">
								<?php
								$charge_hold_fix_amount = get_post_meta($post->ID, 'charge_hold_fix_amount', true);
								if (!$charge_hold_fix_amount) {
									$charge_hold_fix_amount = "1";
								}
								woocommerce_wp_text_input(array(
									'id'			=> 'charge_hold_fix_amount',
									'name' 			=> 'charge_hold_fix_amount',
									'label'			=> __("Enter specific amount", 'ultimate-auction-pro-software'),
									'style' 		=> 'width:30%;',
									'desc_tip'		=> 'true',
									'description'	=> '',
									'data_type' 	=> 'price',
									'type'          => 'number',
									'value' 		=> $charge_hold_fix_amount,
									'custom_attributes' => array(
										'step' 	=> 'any',
										'min' 	=> '1',
									),
								));
								?>
							</div>
						</div>
						<div class="uat_credit_cart_inner1" style="margin-top:20px;margin-bottom:30px;">
							<?php
							$sp_type_automatically_debit = get_post_meta($post->ID, 'sp_type_automatically_debit', true);
							if (!$sp_type_automatically_debit) {
								$sp_type_automatically_debit = "stripe_charge_type_no";
							}
							woocommerce_wp_radio(array(
								'id'			=> 'sp_type_automatically_debit',
								'label'			=> __("Do you want to automatically debit the winning amount on user's credit card", 'ultimate-auction-pro-software'),
								'value' 		=> $sp_type_automatically_debit,
								'name' 			=> 'sp_type_automatically_debit',
								'options'		=> array(
									'stripe_charge_type_full' 		=> __('Full Amount', 'ultimate-auction-pro-software'),
									'stripe_charge_type_partially' 	=> __('Partial Amount', 'ultimate-auction-pro-software'),
									'stripe_charge_type_no' 	=> __('No Auto Debit. Collect Payment on checkout page.', 'ultimate-auction-pro-software')
								),
							)); ?>
							<div class="uat_credit_cart_inner2" style="margin-top:20px;margin-bottom:30px;">
								<?php
								$sp_partial_amount_type = get_post_meta($post->ID, 'sp_partial_amount_type', true);
								if (!$sp_partial_amount_type) {
									$sp_partial_amount_type = "flat_rate";
								}
								woocommerce_wp_radio(array(
									'id'			=> 'sp_partial_amount_type',
									'label'			=> __('Partial Amount Type', 'ultimate-auction-pro-software'),
									'value' 		=> $sp_partial_amount_type,
									'name' 			=> 'sp_partial_amount_type',
									'options'		=> array(
										'flat_rate' 		=> __('Flat Rate', 'ultimate-auction-pro-software'),
										'percentage' 	=> __('Percentage', 'ultimate-auction-pro-software')
									),
								));
								woocommerce_wp_text_input(array(
									'id'			=> 'sp_partially_amount',
									'name' 			=> 'sp_partially_amount',
									'label'			=> __("Enter Partial Amount or Percentage", 'ultimate-auction-pro-software'),
									'style' 		=> 'width:30%;',
									'desc_tip'		=> 'true',
									'description'	=> __("", 'ultimate-auction-pro-software'),
									'data_type' 	=> 'price',
									'type'              => 'number',
									'custom_attributes' => array(
										'step' 	=> 'any',
										'min' 	=> '1',
									),
								));
								?></div>
							<!--Inner2 end-->
						</div>
						<!--Inner1 end-->
					</div>
					<!--uat_credit_cart_level end-->
				</div>
			<?php } else {
				echo '<p>';
				$var = "admin.php?page=ua-auctions-theme-options#field_5f7585998b014";
				$var2 = "Payment Gateway";
				printf(__('1. Configure the <a target="_blank" href="%s">%s</a> from Theme settings to make it functional.<br>', 'ultimate-auction-pro-software'), $var, $var2);

				$var_1 = "admin.php?page=ua-auctions-theme-options#uat_credit_cart_setting";
				$var_2 = "Credit Card (Hold &amp; Debit)";
				printf(__('2. Enable <a target="_blank" href="%s">%s</a> feature for Auctions Product from Theme settings.', 'ultimate-auction-pro-software'), $var_1, $var_2);
				echo '</p>';
			}
			?>
		</div>




		<style>
			.woocommerce_options_panel .uwa_auction_credit_card_main.fix-style-issue label {
				width: 184px;
			}

			.woocommerce_options_panel .uwa_auction_credit_card_main.fix-style-issue p.form-field {
				padding: 5px 20px 5px 14px !important;
			}

			.woocommerce_options_panel .uwa_auction_credit_card_main.fix-style-issue label {
				margin: 0;
			}
		</style>
		<script>
			jQuery(document).ready(function() {
				jQuery('input:radio[name=sp_automatically_debit]').change(function() {
					if (this.value == 'no') {
						jQuery('#sp_step_2').show();
					} else {
						jQuery('#sp_step_2').hide();
					}
				});
				jQuery('input:radio[name=sp_type_automatically_debit]').change(function() {
					if (this.value == 'stripe_charge_type_partially') {
						jQuery('#sp_step_3').show();
					} else {
						jQuery('#sp_step_3').hide();
					}
				});
			});
		</script>
	<?php
	}
	public function uwa_admin_sp_credit_card_tabs($product_data_tabs)
	{
		$sp_credit_card_tab = array(
			'sp_credit_card_tab' => array(
				'label'  => __("Payment Hold & Debit", 'ultimate-auction-pro-software'),
				'target' => 'sp_creadit_card_auction_options',
				'class'  => array('show_if_auction', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple', 'hide_for_uat_event'),
				'priority' => 2,
			),
		);
		return $sp_credit_card_tab + $product_data_tabs;
	}
	public function uwa_seller_admin_buyer_premium_tab_content()
	{
		global $post;
		$product = wc_get_product($post->ID);
	?>

		<?php echo '<div id="buyer_premium_auction_options" class="panel woocommerce_options_panel hidden">'; ?>

		<?php if (get_option('options_uat_enable_buyers_premium_sp', "no") == 'yes') { ?>

			<div class="uwa_auction_buyers_main fix-style-issue">
				<div class="uwa_auction_buyers_heading" style="margin-top:15px;margin-bottom:10px;padding-left:12px;font-size:15px;">
					<strong><u><i>
								<?php echo __("Set Buyer's Premium (B.P)", 'ultimate-auction-pro-software'); ?>
							</i></u></strong>
				</div>


				<?php
				$uat_buyers_premium_type_sp_main = get_post_meta($post->ID, 'uat_buyers_premium_type_sp_main', true);
				if (!$uat_buyers_premium_type_sp_main) {
					$uat_buyers_premium_type_sp_main =  'global';
				}
				woocommerce_wp_radio(array(
					'id'            => 'uat_buyers_premium_type_sp_main',
					'value' => $uat_buyers_premium_type_sp_main,
					'label'         => __('Buyer\'s Premium Options', 'ultimate-auction-pro-software'),
					'description'   => __('Buyer\'s Premium options Global settings changes from Wp Admin > Auctions > Theme settings > Commissions > Single Product', 'ultimate-auction-pro-software') . '<br>',
					'desc_tip' => 'true',
					'options'       => array(
						'global'       => __('Global settings', 'ultimate-auction-pro-software'),
						'custom'       => __('Custom settings', 'ultimate-auction-pro-software'),
					)
				));
				$sp_buyers_premium = get_post_meta($post->ID, 'sp_buyers_premium', true);
				if (!$sp_buyers_premium) {
					$sp_buyers_premium = "no";
				}

				woocommerce_wp_radio(array(
					'id'			=> 'sp_buyers_premium',
					'label'			=> __("Do you want to enable Buyers Commission for auction products?", 'ultimate-auction-pro-software'),
					'value' 		=> $sp_buyers_premium,
					'options'		=> array(
						'yes' 		=> __('Yes', 'ultimate-auction-pro-software'),
						'no' 	=> __('No', 'ultimate-auction-pro-software')
					),
				));

				$sp_buyers_premium_bidding = get_post_meta($post->ID, 'sp_buyers_premium_bidding', true);
				if (!$sp_buyers_premium_bidding) {
					$sp_buyers_premium_bidding = "yes";
				}
				woocommerce_wp_radio(array(
					'id'			=> 'sp_buyers_premium_bidding',
					'label'			=> __("Product won by bidding", 'ultimate-auction-pro-software'),
					'value' 		=> $sp_buyers_premium_bidding,
					'description'   => __('Do you want to enable Buyers Commission for auction products won by bidding', 'ultimate-auction-pro-software') . '<br>',
					'desc_tip' => 'true',
					'options'		=> array(
						'yes' 		=> __('Yes', 'ultimate-auction-pro-software'),
						'no' 	=> __('No', 'ultimate-auction-pro-software')
					),
				));

				$sp_buyers_premium_buy_now = get_post_meta($post->ID, 'sp_buyers_premium_buy_now', true);
				if (!$sp_buyers_premium_buy_now) {
					$sp_buyers_premium_buy_now = "yes";
				}
				woocommerce_wp_radio(array(
					'id'			=> 'sp_buyers_premium_buy_now',
					'label'			=> __("Product won by Buy Now", 'ultimate-auction-pro-software'),
					'value' 		=> $sp_buyers_premium_buy_now,
					'description'   => __('Do you want to enable Buyers Commission for auction products won by Buy Now', 'ultimate-auction-pro-software') . '<br>',
					'desc_tip' => 'true',
					'options'		=> array(
						'yes' 		=> __('Yes', 'ultimate-auction-pro-software'),
						'no' 	=> __('No', 'ultimate-auction-pro-software')
					),
				));

				?>

				<div class="uwa_auction_buyers_productlevel" style="margin-top:20px;margin-bottom:30px;">
					<?php
					if (gatewayIsReady()) {
						$sp_buyers_premium_auto_debit = get_post_meta($post->ID, 'sp_buyers_premium_auto_debit', true);
						if (!$sp_buyers_premium_auto_debit) {
							$sp_buyers_premium_auto_debit = "no";
						}
						woocommerce_wp_radio(array(
							'id'			=> 'sp_buyers_premium_auto_debit',
							'label'			=> __("Do you want to automatically debit the Buyer's premium?", 'ultimate-auction-pro-software'),
							'value' 		=> $sp_buyers_premium_auto_debit,
							//'style' 		=> '',
							//'wrapper_class' => '',
							//'name' 			=> 'my_radio_buttons',
							'options'		=> array(
								'yes' 		=> __('Yes', 'ultimate-auction-pro-software'),
								'no' 	=> __('No', 'ultimate-auction-pro-software')
							),
						));
					}
					$sp_buyers_premium_type = get_post_meta($post->ID, 'sp_buyers_premium_type', true);
					if (empty($sp_buyers_premium_type)) {
						$sp_buyers_premium_type = "flat";
					}
					woocommerce_wp_radio(array(
						'id'			=> 'sp_buyers_premium_type',
						'label'			=> __("What will you charge :", 'ultimate-auction-pro-software'),
						'value' 		=> $sp_buyers_premium_type,
						//'style' => '',
						//'wrapper_class' => '',
						//'name' => 'my_radio_buttons',
						'options' 		=> array(
							'flat' 		=> __("Flat", 'ultimate-auction-pro-software'),
							'percentage' 	=> __("Percentage", 'ultimate-auction-pro-software')
						),
					));
					$display = "";
					if ($sp_buyers_premium_type == "flat") {
						$display = get_woocommerce_currency_symbol();
					} elseif ($sp_buyers_premium_type == "percentage") {
						$display = "in %";
					}
					woocommerce_wp_text_input(array(
						'id'			=> 'sp_buyers_premium_fee_amt',
						'label'			=> __("Mention the Charge", 'ultimate-auction-pro-software') . " (<span class='ua_b_fee_amt'>" . $display . "</span>)",
						'style' 		=> 'width:30%;',
						'desc_tip'		=> 'true',
						'description'	=> __("Based on your above selection enter the value for Flat Rate or Percentage", 'ultimate-auction-pro-software'),
						'data_type' 	=> 'price',
						'custom_attributes' => array(
							'step' 	=> 'any',
							'min' 	=> '0',
						),
					));
					woocommerce_wp_text_input(array(
						'id'			=> 'sp_buyers_premium_fee_amt_min',
						'label'			=> __("Minimum Premium Amount", 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
						'style'			=> 'width:30%;',
						'desc_tip'		=> 'true',
						'description'	=> __("This amount is minimum buyer's premium amount in unit of currency that will be applicable. If the amount calculated in percentage is below this minimum amount then this amount will be charged", 'ultimate-auction-pro-software'),
						'data_type' 	=> 'price',
						'custom_attributes' => array(
							'step'	=> 'any',
							'min'	=> '1',
						),
					));
					woocommerce_wp_text_input(array(
						'id'			=> 'sp_buyers_premium_fee_amt_max',
						'label'			=> __("Maximum Premium Amount", 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
						'style' 		=> 'width:30%;',
						'desc_tip'		=> 'true',
						'description'	=> __("This amount is maximum buyer's premium amount in unit of currency that will be applicable. If the amount calculated in percentage is above this maximum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
						'data_type'  	=> 'price',
						'custom_attributes' => array(
							'step'	=> 'any',
							'min'	=> '1',
						),
					));
					?>
				</div> <!-- end of  uwa_auction_buyers_productlevel  -->
			</div> <!-- end of  uwa_auction_buyers_main  -->

			<style>
				/*.uwa_auction_buyers_main .wc-radios li{
				display:inline!important;
			}
			.uwa_auction_buyers_main .wc-radios li:nth-child(2){
				margin-left:20px!important;
			}
			.uwa_auction_buyers_main input{
				disabled:disabled!important;
			}*/
				.woocommerce_options_panel .uwa_auction_buyers_main.fix-style-issue label {
					width: 184px;
				}

				.woocommerce_options_panel .uwa_auction_buyers_main.fix-style-issue p.form-field {
					padding: 5px 20px 5px 14px !important;
				}

				.woocommerce_options_panel .uwa_auction_buyers_main.fix-style-issue label {
					margin: 0;
				}
			</style>
			<script>
				jQuery(document).ready(function($) {
					/* ----- validations for buyers premium at product level  -- start --  */
					jQuery('#publish').on('click', function() {
						var b_selection = jQuery("input[name='sp_buyers_premium']:checked").val();
						if (b_selection == "yes") {
							var p_rate = $("#sp_buyers_premium_fee_amt").val();
							var premium_type = $("input[name='sp_buyers_premium_type']:checked").val();
							if (!p_rate) {
								alert("Please enter premium fee amount");
								$("#sp_buyers_premium_fee_amt").focus();
								return false;
							}
							if (p_rate <= 0) {
								alert("Please enter fee amount more than 0");
								$("#sp_buyers_premium_fee_amt").focus();
								return false;
							}
							if (premium_type == "percentage") {
								var min_val = $("#sp_buyers_premium_fee_amt_min").val();
								var max_val = $("#sp_buyers_premium_fee_amt_max").val();
								if (p_rate > 100) {
									alert(
										"You have selected percentage as buyers premium so more than 100 is not allowed");
									$("#sp_buyers_premium_fee_amt").focus();
									return false;
								}
								if (min_val != "" && min_val <= 0) {
									alert("Please enter Minimum premium more than 0");
									$("#sp_buyers_premium_fee_amt_min").focus();
									return false;
								}
								if (max_val != "" && max_val <= 0) {
									alert("Please enter Maximum premium more than 0");
									$("#sp_buyers_premium_fee_amt_max").focus();
									return false;
								}
								if (max_val != "") {
									if (parseInt(min_val) >= parseInt(max_val)) {
										alert("Maximum premium must be greater than Minimum premium");
										$("#sp_buyers_premium_fee_amt_max").focus();
										return false;
									}
								}
							} /* end of if - percentage */
						} /* end of if - buyers premium is productlevel */
						/* ----- validations for buyers premium at product level  -- end ----- ----- */
					}); /* end of validations */
					/* ----- Buyers premium at product level ----- start */
					jQuery("fieldset.sp_buyers_premium_field").slideUp("slow");
					jQuery("div.uwa_auction_buyers_productlevel").css("display", "none");
					//jQuery("div.uwa_auction_buyers_productlevel").css("background-color", "grey");
					var woo_ua_auction_form_type = jQuery("#woo_ua_auction_form_type").val();
					buyers_disabled_min_max_product_level();
					if (woo_ua_auction_form_type == "edit_product") {
						buyers_display_form();
						//buyers_disabled_min_max_product_level();
						var woo_ua_auction_status_type = jQuery("#woo_ua_auction_status_type").val();
						if (woo_ua_auction_status_type == "expired") {
							jQuery("div.uwa_auction_buyers_main :input").attr("disabled", "disabled");
						}
					}
					jQuery('.uat_buyers_premium_type_sp_main_field').on('click', function() {
						if (jQuery("input[name='uat_buyers_premium_type_sp_main']").is(":checked")) {
							var b_selection = jQuery("input[name='uat_buyers_premium_type_sp_main']:checked").val();
							if (b_selection == "global") {
								jQuery("fieldset.sp_buyers_premium_field").slideUp("slow");
								jQuery("div.uwa_auction_buyers_productlevel").slideUp("slow");
								jQuery("fieldset.sp_buyers_premium_bidding_field").slideUp("slow");
								jQuery("fieldset.sp_buyers_premium_buy_now_field").slideUp("slow");
							} else {
								jQuery("fieldset.sp_buyers_premium_field").slideDown("slow");
								var b_selection_p = jQuery("input[name='sp_buyers_premium']:checked").val();
								if (b_selection_p == "yes") {
									jQuery("div.uwa_auction_buyers_productlevel").slideDown("slow");
									jQuery("fieldset.sp_buyers_premium_bidding_field").slideDown("slow");
									jQuery("fieldset.sp_buyers_premium_buy_now_field").slideDown("slow");
								}
							}
						}
					});
					jQuery('.sp_buyers_premium_field').on('click', function() {
						if (jQuery("input[name='sp_buyers_premium']").is(":checked")) {
							var b_selection = jQuery("input[name='sp_buyers_premium']:checked").val();
							if (b_selection == "yes") {
								jQuery("div.uwa_auction_buyers_productlevel").slideDown("slow");
								jQuery("fieldset.sp_buyers_premium_bidding_field").slideDown("slow");
								jQuery("fieldset.sp_buyers_premium_buy_now_field").slideDown("slow");
							} else if (b_selection == "no") {
								jQuery("div.uwa_auction_buyers_productlevel").slideUp("slow");
								jQuery("fieldset.sp_buyers_premium_bidding_field").slideUp("slow");
								jQuery("fieldset.sp_buyers_premium_buy_now_field").slideUp("slow");
							}
						}
					});
					jQuery('.sp_buyers_premium_type_field').on('click', function() {
						if (jQuery("input[name='sp_buyers_premium_type']").is(":checked")) {
							buyers_disabled_min_max_product_level();
						}
					});

					function buyers_display_form() {
						/* display buyers form at edit time */
						var b_selection_global = jQuery("input[name='uat_buyers_premium_type_sp_main']:checked").val();
						if (b_selection_global == "custom") {
							jQuery("fieldset.sp_buyers_premium_field").slideDown("slow");
							var b_selection = jQuery("input[name='sp_buyers_premium']:checked").val();
							if (b_selection == "yes") {
								jQuery("div.uwa_auction_buyers_productlevel").css("display", "block");
								jQuery("fieldset.sp_buyers_premium_bidding_field").slideDown("slow");
								jQuery("fieldset.sp_buyers_premium_buy_now_field").slideDown("slow");
							}
						} else {
							jQuery("fieldset.sp_buyers_premium_field").slideUp("slow");
							jQuery("div.uwa_auction_buyers_productlevel").slideUp("slow");
							jQuery("fieldset.sp_buyers_premium_bidding_field").slideUp("slow");
							jQuery("fieldset.sp_buyers_premium_buy_now_field").slideUp("slow");
						}
					}

					function buyers_disabled_min_max_product_level() {
						var woo_ua_auction_status_type = jQuery("#woo_ua_auction_status_type").val();
						if (woo_ua_auction_status_type != "expired") {
							var premium_type = $("input[name='sp_buyers_premium_type']:checked").val();
							if (premium_type == "percentage") {
								$("#sp_buyers_premium_fee_amt_min").removeAttr("disabled");
								$("#sp_buyers_premium_fee_amt_max").removeAttr("disabled");
								$("label[for='sp_buyers_premium_fee_amt_min']").css("color", "inherit");
								$("label[for='sp_buyers_premium_fee_amt_max']").css("color", "inherit");
								$("span.ua_b_fee_amt").html("in %");
							} else {
								$("#sp_buyers_premium_fee_amt_min").attr("disabled", "disabled");
								$("#sp_buyers_premium_fee_amt_max").attr("disabled", "disabled");
								$("label[for='sp_buyers_premium_fee_amt_min']").css("color", "lightgrey");
								$("label[for='sp_buyers_premium_fee_amt_max']").css("color", "lightgrey");
								$("#sp_buyers_premium_fee_amt_min").val("");
								$("#sp_buyers_premium_fee_amt_max").val("");
								var cur = $("#woo_ua_auction_currency").val();
								$("span.ua_b_fee_amt").html(cur);
							}
						}
					}
					/* ----- Buyers premium at product level -----  end  */
				}); /* end of document ready */
			</script>
		<?php
		} else {
			echo '<p>';
			$var = "admin.php?page=ua-auctions-theme-options#uat_bp_tab";
			$var2 = "Buyer’s Premium";
			printf(__('Enable <a target="_blank" href="%s">%s</a> feature for Auctions Product from Theme settings.', 'ultimate-auction-pro-software'), $var, $var2);
			echo '</p>';
		}
		echo '</div>';
	}

	public function uwa_seller_admin_buyer_premium_tabs($product_data_tabs)
	{
		$buyer_premium_tab = array(
			'buyer_premium_tab' => array(
				'label'  => __("Buyer's Premium", 'ultimate-auction-pro-software'),
				'target' => 'buyer_premium_auction_options',
				'class'  => array('show_if_auction', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple', 'hide_for_uat_event'),
				'priority' => 1,
			),
		);
		return $buyer_premium_tab + $product_data_tabs;
	}
	/**
	 * Add a custom product tab.
	 *
	 */
	public  function uat_custom_product_tabs($product_data_tabs)
	{
		$auction_tab = array(
			'auction_tab' => array(
				'label'  => __('Auction', 'ultimate-auction-pro-software'),
				'target' => 'auction_options',
				'class'  => array('show_if_auction', 'hide_if_grouped', 'hide_if_external', 'hide_if_variable', 'hide_if_simple'),
				'priority' => 0,
			),
		);
		return $auction_tab + $product_data_tabs;
	}
	/**
	 * Contents of the Auction  Product options product tab.
	 *
	 */
	public function uat_options_product_tab_content()
	{
		global $post;
		$product = wc_get_product($post->ID);
		$woo_ua_form_type = "add_product";
		if (isset($_GET['action'])) {
			if ($_GET['action'] == "edit") {
				$woo_ua_form_type = "edit_product";
			}
		}
		$is_auction_expired = "no";
		$is_auction_live = "no";
		$auction_status_type = "";
		$auction_checked = "checked";
		$buyitnow_checked = "";
		if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {
			if ($woo_ua_form_type == "edit_product") {
				/* GET auction  live/expired */
				if (json_chk_auction($post->ID) == "live") {  // get_uwa_auction_has_started
					$is_auction_live = "yes";
					$auction_status_type = "live";
				}
				if (json_chk_auction($post->ID) == "past") { // get_uwa_auction_expired
					$is_auction_expired = "yes";
					$auction_status_type = "expired";
				}
				/* GET auction selling type */
				$post_id = $post->ID;
				$auction_checked = "";
				$buyitnow_checked = "";
				//$selling_type = get_post_meta( $post_id, 'woo_ua_auction_selling_type', true);
				$selling_type = $product->get_uwa_auction_selling_type();
				if ($selling_type == "auction") {
					$auction_checked = "checked";
				} elseif ($selling_type == "buyitnow") {
					$buyitnow_checked = "checked";
				} elseif ($selling_type == "both") {
					$auction_checked = "checked";
					$buyitnow_checked = "checked";
				} else { //elseif($selling_type == ""){
					/* for old auctions in which key is not set */
					$auction_checked = "checked";
					$buyitnow_checked = "";
				}
			} /* end of if -- edit product */
		} /* end of if -- method exists */
		?>
		<div id='auction_options' class='panel woocommerce_options_panel'>
			<div class='options_group'>
				<?php
				/* product is added or updated */
				woocommerce_wp_hidden_input(array(
					'id'			=> 'woo_ua_auction_form_type',
					'value'         => $woo_ua_form_type,
				));
				/* product status type is live or expired */
				woocommerce_wp_hidden_input(array(
					'id'			=> 'woo_ua_auction_status_type',
					'value'         => $auction_status_type
				));
				if (isset($_GET['action']) && $_GET['action'] == "edit") {
					/* add field during edit product to store product type */
					woocommerce_wp_hidden_input(array(
						'id'			=> 'woo_ua_product_type',
						'value'         => $product->get_type()
					));
				}
				echo "<div  width='70%'> ";  // 1 start - main
				woocommerce_wp_textarea_input(array(
					'id'			=> 'uat_auction_subtitle',
					'label'			=> __('Subtitle', 'ultimate-auction-pro-software'),
					'desc_tip'		=> 'true',
					'description'	=> __('Add Auction Product Subtitle here', 'ultimate-auction-pro-software'),
					'data_type' 			=> 'text',
					'wrapper_class' => '',
				));
				$selling_type_desc = __('There are two options that you get for selling an auction product. First is Auction by bidding. Second is Buy It Now. You can check whichever option you would like to enable.', 'ultimate-auction-pro-software');
				$event_auction_type_desc = __('By checking this box, this auction product will be a lot inside an auction event.', 'ultimate-auction-pro-software');
				$event_auction_checked = "";
				$event_auction =   get_post_meta($post->ID, 'uwa_event_auction', true);
				if ($event_auction == "yes") {
					$event_auction_checked = "checked";
				}
				?>
				<p class="form-field">
					<label><?php _e('Will it be a lot of an Auction Event', 'ultimate-auction-pro-software'); ?></label>
					<input type="checkbox" id="uwa_event_auction" name="uwa_event_auction" <?php echo $event_auction_checked; ?> />
					<?php echo wc_help_tip($event_auction_type_desc); ?>
					<span style="margin-right:25px"> </span>
					<?php
					$event_id = get_post_meta($post->ID, 'uat_event_id', true);
					if (!empty($event_id)) {
						$event_edit_url = get_edit_post_link($event_id);
						printf(__('Event id <a target="_blank" href="%s">%s</a>', 'ultimate-auction-pro-software'), $event_edit_url, $event_id);
					}
					?>
				</p>
				<?php
				woocommerce_wp_text_input(array(
					'id'			=> 'uat_auction_lot_number',
					'label'			=> __('Lot Number #', 'ultimate-auction-pro-software'),
					'desc_tip'		=> 'true',
					'description'	=> __("Set the lot number for the product inside an auction event.", 'ultimate-auction-pro-software'),
					'data_type' 			=> 'text',
					'wrapper_class' => 'show_for_uat_event',
				));
				?>
				<p class="form-field">
					<label><?php _e('Selling Type', 'ultimate-auction-pro-software'); ?></label>
					<input type="checkbox" id="uwa_auction_selling_type_auction" name="uwa_auction_selling_type_auction" <?php echo $auction_checked; ?> /> <?php _e('Auction', 'ultimate-auction-pro-software'); ?>
					<span style="margin-right:25px"> </span>
					<?php
					$setchk_bn = $buyitnow_checked;
					$setdis_bn = "display:block";
					if ($event_auction_checked == 'checked') {
						$setchk_bn = "";
						$setdis_bn = "display:none";
					}
					?>
					<span id="bn_main" style="<?php echo $setdis_bn; ?>">
						<input type="checkbox" id="uwa_auction_selling_type_buyitnow" name="uwa_auction_selling_type_buyitnow" <?php echo $setchk_bn; ?> /> <?php _e('Buy It Now', 'ultimate-auction-pro-software'); ?>

						<?php echo wc_help_tip($selling_type_desc); ?>

					</span>
				</p>
				<?php

				echo "<div class='selling_type_auction'>";     // 2 start -  selling type auction
				woocommerce_wp_select(
					array(
						'id' => 'woo_ua_auction_type',
						'label' => __('Auction type', 'ultimate-auction-pro-software'),
						'options' => $this->uwa_auction_types
					)
				);
				$proxy_value =  in_array(get_post_meta($post->ID, 'uwa_auction_proxy', true), array('0', 'yes')) ? get_post_meta($post->ID, 'uwa_auction_proxy', true) :
					get_option('uwa_proxy_bid_enable', 'no');
				woocommerce_wp_checkbox(
					array(
						'value' => $proxy_value,
						'id' => 'uwa_auction_proxy',
						'wrapper_class' => 'hide_for_uat_event',
						'label' => __('Enable Proxy Bidding', 'ultimate-auction-pro-software'),
						'description' => __("Proxy Bidding (also known as Automatic Bidding) - Our automatic bidding system makes bidding convenient so you don't have to keep coming back to re-bid every time someone places another bid. When you place a bid, you enter the maximum amount you're willing to pay for the item. The seller and other bidders don't know your maximum bid. We'll place bids on your behalf using the automatic bid increment amount, which is based on the current high bid. We'll bid only as much as necessary to make sure that you remain the high bidder, or to meet the reserve price, up to your maximum amount.", 'ultimate-auction-pro-software'),
						'desc_tip' => 'true'
					)
				);
				woocommerce_wp_checkbox(
					array(
						'id' => 'uwa_auction_silent',
						'wrapper_class' => 'hide_for_uat_event',
						'label' => __('Enable Silent Bidding', 'ultimate-auction-pro-software'),
						'description' => __("A Silent-Bid auction is a type of auction process in which all bidders simultaneously submit Silent bids to the auctioneer, so that no bidder knows how much the other auction participants have bid. The highest bidder is usually declared the winner of the bidding process.", 'ultimate-auction-pro-software'),
						'desc_tip' => 'true'
					)
				);
				woocommerce_wp_text_input(array(
					'id'			=> 'woo_ua_opening_price',
					'label'			=> __('Opening Price', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'desc_tip'		=> 'true',
					'description'	=> __('The price at which the bidding will start.', 'ultimate-auction-pro-software'),
					'data_type' 			=> 'price',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '0',
					)
				));
				$uwa_auction_has_reserve = get_post_meta($post->ID, 'uwa_auction_has_reserve', true);
				$uwa_auction_has_reserve_checked = "checked";
				if ($uwa_auction_has_reserve == "no") {
					$uwa_auction_has_reserve_checked = "";
				}
				?>

				<p class="form-field">
					<label><?php _e('Enable Reserve Price', 'ultimate-auction-pro-software'); ?></label>
					<input type="checkbox" id="uwa_auction_has_reserve" name="uwa_auction_has_reserve" <?php echo $uwa_auction_has_reserve_checked; ?> />
				</p>
				<?php
				$woo_ua_lowest_price = get_post_meta(
					$post->ID,
					'woo_ua_lowest_price',
					true
				);
				if (empty($woo_ua_lowest_price)) {
					$woo_ua_lowest_price = '1';
				}
				woocommerce_wp_text_input(array(
					'id'			=> 'woo_ua_lowest_price',
					'label'			=>  __('Reserve Price', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'desc_tip'		=> 'true',
					'value'		=> $woo_ua_lowest_price,
					'description'	=> __('The lowest price at which a seller is willing to sell an item.', 'ultimate-auction-pro-software'),
					'data_type' => 'price',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '0',
					)
				));
				$next_bids_no = get_post_meta(
					$post->ID,
					'uwa_number_of_next_bids',
					true
				);
				if (empty($next_bids_no)) {
					$next_bids_no = '10';
				}
				woocommerce_wp_text_input(array(
					'id'			=> 'uwa_number_of_next_bids',
					'label'			=>  __('Number of incremental bids inside bid drop down', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'desc_tip'		=> 'true',
					'value'		=> $next_bids_no,
					'description'	=> __('Product Detail Page has a smart Bid drop down which shows the next bids that users can choose from. This value determines how many such bids should be presented to user.', 'ultimate-auction-pro-software'),
					'data_type' => 'number',
					'wrapper_class' => '',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '1',
					)
				));
				echo "<div>";
				woocommerce_wp_text_input(array(
					'id'			=> 'uat_estimate_price_from',
					'label'			=>  __('Estimated Opening Price', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'placeholder'		=> 'from',
					//'desc_tip'		=> 'true',
					//'description'	=> __('The price that seller thinks the highest bid should go to.', 'ultimate-auction-pro-software'),
					'wrapper_class' => '',
					'data_type' => 'price',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '0',
					)
				));
				woocommerce_wp_text_input(array(
					'id'			=> 'uat_estimate_price_to',
					'label'			=>  __('Estimated Closing Price', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'placeholder'		=> 'to',
					'desc_tip'		=> 'true',
					'description'	=> __('The price that seller thinks the highest bid should go to.', 'ultimate-auction-pro-software'),
					'wrapper_class' => '',
					'data_type' => 'price',
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '0',
					)
				));
				echo "</div>";
				$default_bid_inc = get_option("options_uat_global_bid_increment", "1");
				$get_inc_val = get_post_meta(
					$post->ID,
					'woo_ua_bid_increment',
					true
				);
				if ($get_inc_val >= 0.1) {       // if($get_inc_val >= 1){
					$bid_inc_val = $get_inc_val;
				} else {
					$bid_inc_val = $default_bid_inc;
				}
				woocommerce_wp_text_input(array(
					'id'			=> 'woo_ua_bid_increment',
					'label'			=> __('Bid Increment', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'desc_tip'		=> 'true',
					'description'	=> __('The price from which next bid should start. Global settings changes from Wp Admin > Auctions > Theme settings > Bid Increment > Product', 'ultimate-auction-pro-software'),
					'data_type' => 'price',
					'wrapper_class' => 'hide_for_uat_event',
					'value' => $bid_inc_val,
					'custom_attributes' => array(
						'step' => 'any',
						'min' => '0',
					)
				));
				$var_bid_inc_value =  get_post_meta($post->ID, 'uwa_auction_variable_bid_increment', true);
				woocommerce_wp_checkbox(
					array(
						'id' => 'uwa_auction_variable_bid_increment',
						'value' => $var_bid_inc_value,
						'wrapper_class' => 'hide_for_uat_event',
						'label'			=> __('Variable Bid Increment', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
						'description' => __("Enable Variable Incremental Price.", 'ultimate-auction-pro-software'),
						'desc_tip' => 'true'
					)
				);
				$uwa_auction_variable_bid_increment_type = get_post_meta($post->ID, 'uwa_auction_variable_bid_increment_type', true);
				if (!$uwa_auction_variable_bid_increment_type) {
					$uwa_auction_variable_bid_increment_type = 'global';
				}
				woocommerce_wp_radio(array(
					'id'            => 'uwa_auction_variable_bid_increment_type',
					'value' => $uwa_auction_variable_bid_increment_type,
					'label'         => __('Variable Bid Increment options', 'ultimate-auction-pro-software'),
					'description'   => __('Variable Bid Increment options. Global settings changes from Wp Admin > Auctions > Theme settings > Bid Increment > Product', 'ultimate-auction-pro-software') . '<br>',
					'desc_tip' => 'true',
					'options'       => array(
						'global'       => __('Global settings', 'ultimate-auction-pro-software'),
						'custom'       => __('Custom price range', 'ultimate-auction-pro-software'),
					)
				));
				?>
				<p class="form-field uwa_variable_bid_increment_main" style="display:none;">
					<span id="uwa_custom_field_add_remove" class="hide_for_uat_event">
						<!-- Don't 	remove -->
						<label><?php _e('Variable Bid Increment', 'ultimate-auction-pro-software'); ?><?php echo '(' . get_woocommerce_currency_symbol() . ')'; ?></label>
						<input type="button" id="plus_field" class="button button-secondary" value="<?php echo esc_attr('Add New'); ?>" />
						<?php
						$uwa_var_inc_data = get_post_meta($post->ID, 'uwa_var_inc_price_val', true);
						//$uwa_var_inc_data_count = count($uwa_var_inc_data);
						$i = 1;
						if (!empty($uwa_var_inc_data)) {
							foreach ($uwa_var_inc_data as $key => $variable_val) {
								if ($key !== 'onwards') { ?>
									<span id="uwa_custom_field_<?php echo $i; ?>" class="uwa_custom_field_main">
										<input type="number" class="uwa_auction_price_fields start_valid" id="start_val_<?php echo $i; ?>" data-startid="<?php echo $i; ?>" name="uwa_var_inc_val[<?php echo $i; ?>][start]" value="<?php echo $variable_val['start']; ?>" placeholder="<?php _e('Start Price', 'ultimate-auction-pro-software'); ?>" />
										<input type="number" class="uwa_auction_price_fields end_valid" id="end_val_<?php echo $i; ?>" data-endid="<?php echo $i; ?>" name="uwa_var_inc_val[<?php echo $i; ?>][end]" value="<?php echo $variable_val['end']; ?>" placeholder="<?php _e('End Price', 'ultimate-auction-pro-software'); ?>" />
										<input type="number" class="uwa_auction_price_fields" id="inc_val_<?php echo $i; ?>" name="uwa_var_inc_val[<?php echo $i; ?>][inc_val]" value="<?php echo $variable_val['inc_val']; ?>" placeholder="<?php _e('Increment Price', 'ultimate-auction-pro-software'); ?>" />
										<?php
										if ($i != 1) { ?>
											<input type="button" class="button button-secondary minus_field" value="-" data-custom="<?php echo $i; ?>" />
										<?php
										} ?>
									</span>
							<?php
								}
								$i++;
							}
						} else { ?>
							<span id="uwa_custom_field_0" class="uwa_custom_field_main">
								<input type="number" class="uwa_auction_price_fields start_valid" id="start_val_0" data-startid="0" name="uwa_var_inc_val[0][start]" value="" placeholder="<?php _e('Start Price', 'ultimate-auction-pro-software'); ?>" />
								<input type="number" class="uwa_auction_price_fields end_valid" id="end_val_0" data-endid="0" name="uwa_var_inc_val[0][end]" value="" placeholder="<?php _e('End Price', 'ultimate-auction-pro-software'); ?>" />
								<input type="number" class="uwa_auction_price_fields" id="inc_val_0" name="uwa_var_inc_val[0][inc_val]" value="" placeholder="<?php _e('Increment Price', 'ultimate-auction-pro-software'); ?>" />
							</span>
						<?php
						} ?>
					</span>
					<script type="text/javascript">
						<?php if ($var_bid_inc_value == "yes") { ?>
							jQuery('p.uwa_variable_bid_increment_main').css("display", "block");
							jQuery('.form-field.woo_ua_bid_increment_field').css("display", "none");
							jQuery('#woo_ua_bid_increment').val("");
						<?php
						} else { ?>
							jQuery('p.uwa_variable_bid_increment_main').css("display", "none");
						<?php
						} ?>
						var flag = <?php echo $i; ?>;
						var arr = [];
						jQuery('#plus_field').click(function() {
							jQuery('#uwa_custom_field_add_remove').append('<span id="uwa_custom_field_' + flag +
								'" class="uwa_custom_field_main"><input type="number" class="uwa_auction_price_fields start_valid" id="start_val_' +
								flag + '" data-startid="' + flag + '" name="uwa_var_inc_val[' + flag +
								'][start]" value="" placeholder="Start Price" /><input type="number" class=" uwa_auction_price_fields end_valid" id="end_val_' +
								flag + '" data-endid="' + flag + '" name="uwa_var_inc_val[' + flag +
								'][end]" value="" placeholder="End Price" /><input type="number" class=" uwa_auction_price_fields" id="inc_val_' +
								flag + '" name="uwa_var_inc_val[' + flag +
								'][inc_val]" value="" placeholder="Increment Price" /><input type="button" class="button button-secondary minus_field" value="-" data-custom="' +
								flag + '"></span>');
							var end_range_valid = (parseInt(flag) - 1);
							var end_range_val = jQuery("#end_val_" + end_range_valid).val();
							jQuery('#start_val_' + flag).val(end_range_val);
							flag++;
						});
						jQuery(document).on('click', '.minus_field', function() {
							var id = jQuery(this).attr('data-custom');
							var id_name = "uwa_custom_field_" + id + "";
							jQuery('#' + id_name + '').remove();
							flag--;
						});
						jQuery(document).on('keyup', '.end_valid', function() {
							var end_range = jQuery(this).attr('data-endid');
							var end_range_val = jQuery(this).val();
							var end_range_valid = (parseInt(end_range) + 1);
							jQuery('#start_val_' + end_range_valid).val(end_range_val);
						});
					</script>
				</p>
				<?php
				echo "</div>";  // 2 end -  selling type auction
				echo "<div class='selling_type_buyitnow'>"; // 6 start - buyit now auction
				woocommerce_wp_text_input(array(
					'id'			=> '_regular_price',
					'label'			=> __('Buy It Now price', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
					'desc_tip'		=> 'true',
					'data_type' => 'price',
					'description'	=> __('Visitors can directly buy your auction product by making a payment with available payment method configured inside WooCommerce.', 'ultimate-auction-pro-software'),
				));
				echo "</div>"; // 6 end - buyit now auction
				echo "</div>";  // 1 end - main
				$is_seller_product = get_post_meta($post->ID, 'uat_seller_id', true);
				$auction_duration = get_post_meta($post->ID, 'auction_duration', true);
				if (!empty($is_seller_product) && !empty($auction_duration)) {
					woocommerce_wp_text_input(array(
						'id'			=> 'auction_duration',
						'label'			=> __('Auction Duration', 'ultimate-auction-pro-software'),
						'desc_tip'		=> 'true',
						'description'	=> __('Please review the auction duration entered by the seller and use it to determine the appropriate start and end dates for the auction.', 'ultimate-auction-pro-software'),
						'type' 			=> 'text',
						'wrapper_class' => '',
						'class'         => '',
						'value'         => $auction_duration,
						'custom_attributes' => array('readonly' => 'readonly'),
					));
				}
				$nowdate_for_start = get_post_meta($post->ID, 'woo_ua_auction_start_date', true) ?: get_ultimate_auction_now_date();
				woocommerce_wp_text_input(array(
					'id'			=> 'woo_ua_auction_start_date',
					'label'			=> __('Start Date', 'ultimate-auction-pro-software'),
					'desc_tip'		=> 'true',
					'description'	=> __('Set the Start date of Auction Product.', 'ultimate-auction-pro-software'),
					'type' 			=> 'text',
					'wrapper_class' => 'hide_for_uat_event',
					'class'         => '-datetimepicker',
					'value'         => $nowdate_for_start
				));
				$nowdate =  wp_date('Y-m-d H:i:s', strtotime('+1 day', time()), get_ultimate_auction_wp_timezone());
				$end_date = get_post_meta($post->ID, 'woo_ua_auction_end_date', true) ?: $nowdate;
				woocommerce_wp_text_input(array(
					'id'			=> 'woo_ua_auction_end_date',
					'label'			=> __('Ending Date', 'ultimate-auction-pro-software'),
					'desc_tip'		=> 'true',
					'wrapper_class' => 'hide_for_uat_event',
					'description'	=> __('Set the end date of Auction Product.', 'ultimate-auction-pro-software'),
					'type' 			=> 'text',
					'class'         => '-datetimepicker',
					'value'         => $end_date
				));
				?>
			</div>
			<div class="uwa_admin_current_time">
				<?php
				printf(__('Current Blog Time is %s', 'ultimate-auction-pro-software'), '<strong>' . get_ultimate_auction_now_date() . '</strong> ');
				echo __('Timezone:', 'ultimate-auction-pro-software') . ' <strong>' . wp_timezone_string() . '</strong>';
				echo __('<a href="' . admin_url('options-general.php?#timezone_string') . '" target="_blank">' . ' ' . __('Change', 'ultimate-auction-pro-software') . '</a>'); ?>
			</div>
			<?php
			$event_id = get_post_meta($post->ID, 'uat_event_id', true);
			if (empty($event_id)) {

				if ((method_exists($product, 'get_type') && $product->get_type() == 'auction') and (json_chk_auction($post->ID) == "future")) { ?>
					<p class="form-field uwa_admin_uwa_make_live">
						<a href="#" class="button uwa_force_make_live" data-auction_id="<?php echo $post->ID; ?>">
							<?php _e('Make It Live', 'ultimate-auction-pro-software'); ?></a>
					</p>
				<?php
				}
				if ((method_exists($product, 'get_type') && $product->get_type() == 'auction') && (json_chk_auction($post->ID) == "live")) { ?>
					<p class="form-field uwa_admin_uwa_force_end_now">
						<a href="#" class="button uwa_force_end_now" data-auction_id="<?php echo $post->ID; ?>">
							<?php _e('End Now', 'ultimate-auction-pro-software'); ?></a>
					</p> <?php  } ?>

			<?php  } ?>

		</div>
	<?php
	}
	/**
	 * Add to product type drop down
	 *
	 */
	public function uat_add_auction_product($types)
	{
		/* Key should be exactly the same as in the class */
		$types['auction'] = __('Auction Product', 'ultimate-auction-pro-software');
		return $types;
	}
	/**
	 * Save Auction Product Data.
	 *
	 */
	function uat_save_auction_option_field($post_id)
	{
		global $wpdb, $woocommerce, $woocommerce_errors;
		$product_type = empty($_POST['product-type']) ? 'simple' : sanitize_title(stripslashes($_POST['product-type']));
		if ($product_type == 'auction') {
			update_post_meta($post_id, '_manage_stock', 'yes');
			update_post_meta($post_id, '_stock', '1');
			update_post_meta($post_id, '_backorders', 'no');
			update_post_meta($post_id, '_sold_individually', 'yes');
			if (isset($_POST['_regular_price'])) {
				update_post_meta($post_id, '_regular_price', wc_format_decimal(wc_clean($_POST['_regular_price'])));
				update_post_meta($post_id, '_price', wc_format_decimal(wc_clean($_POST['_regular_price'])));
			}
			if (isset($_POST['woo_ua_product_condition'])) {
				update_post_meta($post_id, 'woo_ua_product_condition', esc_attr($_POST['woo_ua_product_condition']));
			}
			if (isset($_POST['uat_auction_subtitle'])) {
				update_post_meta($post_id, 'uat_auction_subtitle', esc_attr($_POST['uat_auction_subtitle']));
			}
			if (isset($_POST['woo_ua_opening_price'])) {
				update_post_meta($post_id, 'woo_ua_opening_price', wc_format_decimal(wc_clean($_POST['woo_ua_opening_price'])));
			}
			if (isset($_POST['uwa_auction_has_reserve'])) {
				update_post_meta($post_id, 'uwa_auction_has_reserve', 'yes');
			} else {
				update_post_meta($post_id, 'uwa_auction_has_reserve', 'no');
			}
			if (isset($_POST['woo_ua_lowest_price'])) {
				update_post_meta($post_id, 'woo_ua_lowest_price', wc_format_decimal(wc_clean($_POST['woo_ua_lowest_price'])));
			}
			if (isset($_POST['uwa_number_of_next_bids'])) {
				update_post_meta($post_id, 'uwa_number_of_next_bids', wc_format_decimal(wc_clean($_POST['uwa_number_of_next_bids'])));
			}
			if (isset($_POST['uat_estimate_price_from'])) {
				update_post_meta($post_id, 'uat_estimate_price_from', wc_format_decimal(wc_clean($_POST['uat_estimate_price_from'])));
			}
			if (isset($_POST['uat_estimate_price_to'])) {
				update_post_meta($post_id, 'uat_estimate_price_to', wc_format_decimal(wc_clean($_POST['uat_estimate_price_to'])));
			}
			/* Add In Pro */
			if (isset($_POST['woo_ua_auction_type'])) {
				update_post_meta($post_id, 'woo_ua_auction_type', esc_attr($_POST['woo_ua_auction_type']));
			}
			/* Selling type */
			/* Note : html static so checkbox checked == on or (blank) */
			if (isset($_POST['uwa_auction_selling_type_auction']) && isset($_POST['uwa_auction_selling_type_buyitnow'])) {
				if ($_POST['uwa_auction_selling_type_auction'] == "on" && $_POST['uwa_auction_selling_type_buyitnow'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "both");
				}
			} else if (isset($_POST['uwa_auction_selling_type_auction'])) {
				if ($_POST['uwa_auction_selling_type_auction'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "auction");
				}
			} else if (isset($_POST['uwa_auction_selling_type_buyitnow'])) {
				if ($_POST['uwa_auction_selling_type_buyitnow'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "buyitnow");
				}
			}
			//if event checkbox checked on
			if (isset($_POST['uwa_event_auction'])) {
				update_post_meta($post_id, 'uwa_event_auction', 'yes');
				update_post_meta($post_id, 'uat_auction_lot_number', $_POST['uat_auction_lot_number']);
			} else {
				delete_post_meta($post_id, 'uat_event_id');
				delete_post_meta($post_id, 'uwa_event_auction');
				//Update add via Event field
				if (!isset($_REQUEST['is_seller_product'])) {
					if (isset($_POST['uwa_auction_proxy'])) {
						update_post_meta($post_id, 'uwa_auction_proxy', stripslashes($_POST['uwa_auction_proxy']));
					} else {
						update_post_meta($post_id, 'uwa_auction_proxy', '0');
					}
					if (isset($_POST['uwa_auction_silent'])) {
						update_post_meta($post_id, 'uwa_auction_silent', stripslashes($_POST['uwa_auction_silent']));
					} else {
						update_post_meta($post_id, 'uwa_auction_silent', '0');
					}
				}
				if (isset($_POST['woo_ua_bid_increment']) && $_POST['woo_ua_bid_increment'] != '') {
					update_post_meta($post_id, 'woo_ua_bid_increment', wc_format_decimal(wc_clean($_POST['woo_ua_bid_increment'])));
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment');
					delete_post_meta($post_id, 'uwa_var_inc_price_val');
				}
				if (!isset($_REQUEST['is_seller_product'])) {
					/* Pro Plugin */
					if (isset($_POST['woo_ua_auction_start_date']) && $_POST['woo_ua_auction_start_date'] != "") {
						update_post_meta($post_id, 'woo_ua_auction_start_date', stripslashes($_POST['woo_ua_auction_start_date']));
					} else {
						//update_post_meta( $post_id, 'woo_ua_auction_start_date', stripslashes( $start_date ) );
					}
					if (isset($_POST['woo_ua_auction_end_date'])) {
						update_post_meta($post_id, 'woo_ua_auction_end_date', stripslashes($_POST['woo_ua_auction_end_date']));
					}
				}
				if (isset($_POST['uwa_auction_variable_bid_increment']) && isset($_POST['uwa_var_inc_val'])) {
					if (isset($_POST['uwa_auction_variable_bid_increment_type'])) {
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment_type', $_POST['uwa_auction_variable_bid_increment_type']);
					} else {
						delete_post_meta($post_id, 'uwa_auction_variable_bid_increment_type');
					}
					if ($_POST['uwa_auction_variable_bid_increment'] == "yes" && !empty($_POST['uwa_var_inc_val']) && empty($_POST['woo_ua_bid_increment'])) {
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment', $_POST['uwa_auction_variable_bid_increment']);
						update_post_meta($post_id, 'uwa_var_inc_price_val', $_POST['uwa_var_inc_val']);
						delete_post_meta($post_id, 'woo_ua_bid_increment');
					}
				} else {
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment');
				}
			}
			/* delete some metadata only when simple, grouped, variable or any product
				 become auction product during edit product */
			if (isset($_POST['woo_ua_product_type'])) {
				if ($_POST['woo_ua_product_type'] != "auction") {
					//delete_post_meta( $post_id, "_sale_price");
				}
			}
		} /*  end of if - auction */ else {
			delete_post_meta($post_id, 'woo_ua_product_condition');
			delete_post_meta($post_id, 'woo_ua_opening_price');
			delete_post_meta($post_id, 'woo_ua_lowest_price');
			delete_post_meta($post_id, 'uwa_auction_proxy');
			delete_post_meta($post_id, 'uwa_auction_silent');
			delete_post_meta($post_id, 'woo_ua_bid_increment');
			delete_post_meta($post_id, 'woo_ua_auction_type');
			delete_post_meta($post_id, 'woo_ua_auction_start_date');
			delete_post_meta($post_id, 'woo_ua_auction_end_date');
			delete_post_meta($post_id, 'woo_ua_auction_has_started');
			delete_post_meta($post_id, 'woo_ua_auction_last_activity');
			delete_post_meta($post_id, 'woo_ua_auction_closed');
			delete_post_meta($post_id, 'woo_ua_auction_fail_reason');
			delete_post_meta($post_id, 'woo_ua_order_id');
			delete_post_meta($post_id, 'woo_ua_auction_payed');
			delete_post_meta($post_id, 'woo_ua_auction_max_bid');
			delete_post_meta($post_id, 'woo_ua_auction_max_current_bider');
			delete_post_meta($post_id, 'woo_ua_auction_current_bid');
			delete_post_meta($post_id, 'woo_ua_auction_current_bider');
			delete_post_meta($post_id, 'woo_ua_auction_bid_count');
			delete_post_meta($post_id, 'woo_ua_auction_current_bid_proxy');
			delete_post_meta($post_id, 'woo_ua_auction_last_bid');
			delete_post_meta($post_id, 'woo_ua_buy_now');
			delete_post_meta($post_id, 'uwa_auction_variable_bid_increment');
			delete_post_meta($post_id, 'uwa_var_inc_price_val');
			delete_post_meta($post_id, 'woo_ua_auction_selling_type');
		}
	}
	/**
	 * Add Metabox for Auction Log/History Section
	 *
	 */
	public function uat_add_auction_metabox($product)
	{
		$woo_pf = new WC_Product_Factory();
		$woo_prd = $woo_pf->get_product($product->ID);
		if ($woo_prd->get_type() !== 'auction') return;
		add_meta_box(
			'uwa-auction-log',
			__('Bid History', 'ultimate-auction-pro-software'),
			array($this, 'uwa_render_auction_log'),
			'product',
			'normal',
			'default'
		);
	}
	/**
	 * Ajax delete bid
	 *
	 * Function for deleting bid in wp admin
	 * @param  array
	 * @return string
	 *
	 */
	function wp_ajax_admin_cancel_bid()
	{
		global $wpdb;
		if (!current_user_can('edit_product', $_POST["postid"])) {
			die();
		}
		if ($_POST["postid"] && $_POST["logid"]) {
			$product_data = wc_get_product($_POST["postid"]);
			$log_table = $wpdb->prefix . "woo_ua_auction_log";
			$history = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$log_table} WHERE id = %d", $_POST["logid"]));
			if (!is_null($history)) {
				/* Get data for delete bid mail before it's deleted */
				//$postid = $_POST["postid"];
				$auctionid = $_POST["postid"];
				$logid = $_POST["logid"];
				$userid = $history->userid;
				$deletedbid = $history->bid;
				if ($product_data->get_uwa_auction_type() == 'normal') {
					if (($history->bid == $product_data->get_uwa_auction_current_bid()) && ($history->userid ==
						$product_data->get_uwa_auction_current_bider())) {
						if ($product_data->get_uwa_auction_silent() == 'yes') {
							/* query for slient auction */
							$newbid = $wpdb->get_row($wpdb->prepare(
								"SELECT * FROM {$log_table} WHERE auction_id = %d and id != %d and
								bid = (SELECT MAX(bid) FROM {$log_table} WHERE auction_id = %d and id != %d ) ORDER BY date ASC LIMIT 1",
								$auctionid,
								$logid,
								$auctionid,
								$logid
							));
						} else {
							/* query for simple and proxy auction */
							$newbid = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$log_table} WHERE auction_id = %d
								ORDER BY date DESC, bid DESC LIMIT 1, 1", $auctionid));
						}
						if (!is_null($newbid)) {
							update_post_meta($auctionid, 'woo_ua_auction_current_bid', $newbid->bid);
							update_post_meta($auctionid, 'woo_ua_auction_current_bider', $newbid->userid);
							delete_post_meta($auctionid, 'woo_ua_auction_max_bid');
							delete_post_meta($auctionid, 'woo_ua_auction_max_current_bider');
							$new_max_bider_id =  $newbid->userid;
							/* send mail to winner only when auction is expired and there */
							if ($product_data->get_uwa_auction_expired() == '2') {
								update_user_meta($newbid->userid, 'woo_ua_auction_win', $auctionid);
								delete_post_meta($auctionid, 'woo_ua_winner_mail_sent');
							}
						} else {
							delete_post_meta($auctionid, 'woo_ua_auction_current_bid');
							delete_post_meta($auctionid, 'woo_ua_auction_current_bider');
							delete_post_meta($auctionid, 'woo_ua_auction_max_bid');
							delete_post_meta($auctionid, 'woo_ua_auction_max_current_bider');
							$new_max_bider_id = false;
						}
						$wpdb->query($wpdb->prepare("DELETE FROM {$log_table} WHERE id = %d", $_POST["logid"]));
						update_post_meta($auctionid, 'woo_ua_auction_bid_count', intval($product_data->get_uwa_auction_bid_count() - 1));
						do_action('ultimate_woocommerce_auction_delete_bid', array(
							'product_id' => $auctionid,
							'delete_user_id' => $history->userid, 'new_max_bider_id ' => $new_max_bider_id
						));
						admin_delete_json_update($auctionid, $logid);
						admin_delete_bids_json_update($auctionid, $logid);
						$response['status'] = 1;
						$response['success_message'] = __('Bid Deleted Successfully', 'ultimate-auction-pro-software');
					} else {
						$wpdb->query($wpdb->prepare("DELETE FROM {$log_table} WHERE id = %d", $_POST["logid"]));
						update_post_meta($auctionid, 'woo_ua_auction_bid_count', intval($product_data->get_uwa_auction_bid_count() - 1));
						admin_delete_json_update($auctionid, $logid);
						admin_delete_bids_json_update($auctionid, $logid);
						$response['status'] = 1;
						$response['success_message'] = __('Bid Deleted Successfully', 'ultimate-auction-pro-software');
					}
				}
				$uat_products_logs = get_option('options_uat_bids_logs', 'enable');
				if ($uat_products_logs == "enable") {
					$current_user = wp_get_current_user();
					$uat_auction_activity = new Uat_Auction_Activity();
					$activity_data = array(
						'post_parent'	=> $auctionid,
						'activity_name'	=> "Bid Deleted",
						'activity_type'	=> 'ua_bids',
						'activity_by'	=> $current_user->ID,
					);
					$activity_meta = array(
						'bid_value'	=> $deletedbid,
					);
					$activity = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
				}
			} /* end of if - is null history */
		} else {
			$response['status'] = 0;
			$response['error_message'] = __('Bid Not Deleted', 'ultimate-auction-pro-software');
		}
		echo json_encode($response);
		exit;
	}

	/**
	 * Ajax End Auction
	 *
	 * Function for deleting bid in wp admin
	 * @param  array
	 * @return string
	 *
	 */
	function uwa_admin_force_end_now_callback()
	{
		global $wpdb;
		$end_time = get_ultimate_auction_now_date();
		if (!current_user_can('edit_product', $_POST["postid"])) {
			die();
		}
		if (!empty($_POST["postid"])) {

			$product_id = $_POST["postid"];
			$auction_status_chk = json_chk_auction($product_id);
			$product_data = wc_get_product(wc_clean($product_id));
			$closed_auction = $product_data->get_uwa_auction_expired();
			if (!empty($closed_auction)) {
				die(); /* Auction Already Ended */
			} else {
				$current_bid = $product_data->get_uwa_auction_current_bid();
				$current_bider = $product_data->get_uwa_auction_current_bider();
				if ($auction_status_chk == 'live') {
					update_post_meta($product_id, 'woo_ua_auction_end_date', $end_time);

					$Auction_Expire = new Uat_Auction_Expire();
					$Auction_Expire->uat_product_check_expired_last_callback($product_id);

					$response['status'] = 1;
					$response['success_message'] = __('Auction ended successfully.', "ultimate-auction-pro-software");
				} else {

					$response['status'] = 0;
					$response['error_message'] = __('Sorry, this auction cannot be ended.', "ultimate-auction-pro-software");
				}
			}
		}

		echo json_encode($response);
		exit;
	}


	/**
	 * Ajax End Auction
	 *
	 * Function for deleting bid in wp admin
	 * @param  array
	 * @return string
	 *
	 */
	function uwa_admin_force_make_live_now_callback()
	{
		global $wpdb;
		$nowdate_for_start = get_ultimate_auction_now_date();
		if (!current_user_can('edit_product', $_POST["auction_id"])) {
			die();
		}
		if (!empty($_POST["auction_id"])) {
			$product_id = $_POST["auction_id"];
			$product_data = wc_get_product(wc_clean($product_id));
			if (json_chk_auction($product_id) == "live") {
				$response['status'] = 0;
				$response['error_message'] = __('Auction Already Live.', 'ultimate-auction-pro-software');
			} else {
				update_post_meta($product_id, 'woo_ua_auction_start_date', $nowdate_for_start);
				update_post_meta($product_id, 'woo_ua_auction_has_started', "1");
				delete_post_meta($product_id, "woo_ua_auction_started");
				json_update_status_auction($product_id, $status = "live");
				uat_update_auction_status($product_id, 'uat_live');
				$response['status'] = 1;
				$response['success_message'] = __('Auction Live successfully.', 'ultimate-auction-pro-software');
			}
		}
		echo json_encode($response);
		exit;
	}
	/**
	 * Duplicate product
	 *
	 * Clear metadata when copy auction
	 * @param  array
	 * @return string
	 *
	 */
	function uwa_woocommerce_duplicate_product($postid)
	{
		$product = wc_get_product($postid);
		if (!$product) {
			return FALSE;
		}
		if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction')) {
			return FALSE;
		}
		delete_post_meta($postid, 'woo_ua_auction_end_date');
		delete_post_meta($postid, 'woo_ua_auction_start_date');
		delete_post_meta($postid, 'woo_ua_auction_current_bid');
		delete_post_meta($postid, 'woo_ua_auction_current_bider');
		delete_post_meta($postid, 'woo_ua_auction_bid_count');
		delete_post_meta($postid, 'woo_ua_winner_mail_sent');
		delete_post_meta($postid, 'woo_ua_auction_has_started');
		delete_post_meta($postid, 'woo_ua_auction_closed');
		delete_post_meta($postid, 'woo_ua_auction_started');
		delete_post_meta($postid, 'woo_ua_auction_max_bid');
		delete_post_meta($postid, 'woo_ua_auction_max_current_bider');
		delete_post_meta($postid, 'woo_ua_auction_current_bid_proxy');
		delete_post_meta($postid, 'woo_ua_auction_last_bid');
		delete_post_meta($postid, 'woo_ua_auction_fail_reason');
		delete_post_meta($postid, 'woo_ua_auction_payed');
		delete_post_meta($postid, 'woo_ua_order_id');
		delete_post_meta($postid, '_stock_status');
		delete_post_meta($postid, 'woo_ua_auction_extend_time_antisnipping');
		delete_post_meta($postid, 'uwa_auction_relisted');
		delete_post_meta($postid, 'uwa_number_of_sent_mails');
		delete_post_meta($postid, 'uwa_dates_of_sent_mails');
		delete_post_meta($postid, 'uwa_auction_stop_mails');
		delete_post_meta($postid, 'woo_ua_auction_watch');
		delete_post_meta($postid, 'woo_ua_auction_last_activity');
		update_post_meta($postid, '_stock_status', 'instock');
		//buyers premium fields
		delete_post_meta($postid, '_uwa_buyer_premium_amt');
		//auto debit fields
		//update_post_meta($postid, '_uwa_buyer_premium_amt');
		delete_post_meta($postid, '_uwa_stripe_auto_debit_amt');
		delete_post_meta($postid, '_uwa_stripe_auto_debit_bpm_amt');
		//auction staus
		delete_post_meta($postid, '_done_one_time_payment');
		delete_post_meta($postid, '_done_one_time_sms');
		delete_post_meta($postid, '_uwa_stripe_auto_debit_status');
		delete_post_meta($postid, '_uwa_won_sms_sent_status');


		delete_post_meta($postid, 'woo_ua_order_id');
		delete_post_meta($postid, 'woo_ua_auction_closed');
		delete_post_meta($postid, 'uat_auction_expired');
		delete_post_meta($postid, 'uat_auction_ending_soon_sent_whatsapp');
		delete_post_meta($postid, 'uat_auction_ending_soon_sent_sms');
		delete_post_meta($postid, 'uat_auction_ending_soon_sent');
		delete_post_meta($postid, 'woo_ua_auction_last_activity');
		delete_post_meta($postid, 'woo_ua_auction_bid_count');
		delete_post_meta($postid, 'woo_ua_auction_current_bider');
		delete_post_meta($postid, 'woo_ua_auction_current_bid');
		delete_post_meta($postid, 'woo_ua_auction_has_started');
		delete_post_meta($postid, 'woo_ua_auction_end_date');
		delete_post_meta($postid, 'woo_ua_auction_start_date');
		delete_post_meta($postid, '_regular_price');
		delete_post_meta($postid, '_visibility');
		delete_post_meta($postid, '_edit_last');
		delete_post_meta($postid, '_edit_lock');
		delete_post_meta($postid, '_stock_status');
		delete_post_meta($postid, 'uat_auction_expired_emails');
		delete_post_meta($postid, 'uat_auction_expired_order');
		delete_post_meta($postid, 'order_status');
		delete_post_meta($postid, 'uat_auction_expired_payment');
		delete_post_meta($postid, '_uwa_stripe_hold_total_amt');
		delete_post_meta($postid, '_uwa_stripe_auto_debit_total_amt');
		delete_post_meta($postid, '_wcfm_product_views');
		delete_post_meta($postid, 'uat_sort_link');
		return TRUE;
	}
	/**
	 * Show pricing fields for Action product.
	 *
	 */
	function uwa_auction_custom_js()
	{
		if ('product' != get_post_type()) :
			return;
		endif;
	?>
		<script type='text/javascript'>
			jQuery(document).ready(function() {
				jQuery('.inventory_tab').addClass('show_if_auction').show();
			});
		</script>
		<?php
	}
	/**
	 * Add New Column In Product list in admins side.
	 *
	 * @param  array
	 * @return string
	 *
	 */
	function uwa_auctions_status_columns($columns_array)
	{
		/* I want to display Brand column just after the product name column */
		$auction_status_columns = __('Auction Status', 'ultimate-auction-pro-software');
		return array_slice($columns_array, 0, 5, true)
			+ array('admin_auction_status' => $auction_status_columns)
			+ array_slice($columns_array, 5, NULL, true);
	}
	/**
	 * Add New Column Data In Product list in admins side.
	 *
	 * @param  array
	 * @return string
	 *
	 */
	function uwa_auctions_status_columns_status($column, $postid)
	{
		global $woocommerce, $post;
		if ($column  == 'admin_auction_status') {
			$product_data = wc_get_product($postid);
			if ($product_data->get_type() == 'auction') {
				$uat_seller_id = get_post_meta($postid, 'uat_seller_id', true);
				if (!empty($uat_seller_id)) {
					$product_status = $product_data->get_status();
					$product_status_one =  UAT_Sellers_Init::uat_get_product_status($product_status);
					if (!empty($product_status_one) && isset($product_status_one['slug'])) {
						echo $product_status = $product_status_one['label'];
					}
				} else {

					$failed = $product_data->get_uwa_auction_fail_reason();
					if (json_chk_auction($postid) == "live") { ?>
						<span style="color:#7ad03a;font-size:18px"><?php _e('Live', 'ultimate-auction-pro-software') ?></span>
					<?php
					} elseif (json_chk_auction($postid) == "future") { ?>
						<span style="color:orange;font-size:18px"><?php _e('Future', 'ultimate-auction-pro-software') ?></span>
						</br><span style="color:#0073aa;font-size:10px"><?php _e('Not Started', 'ultimate-auction-pro-software') ?></span>
					<?php
					} else {
						$isbn = 0;
						$woo_ua_buy_now = get_post_meta($postid, 'woo_ua_buy_now', true);
						if (!empty($woo_ua_buy_now)) {
							$isbn = 1;
						}
					?>
						<span style="color:red;font-size:18px"><?php _e('Expired', 'ultimate-auction-pro-software') ?></span>
						<?php if ($product_data->get_uwa_auction_expired() == '3') { ?>
							</br><span style="color:#0073aa;font-size:10px"><?php _e('Sold', 'ultimate-auction-pro-software') ?></span>
						<?php } elseif ($product_data->get_uwa_auction_fail_reason() == '1') { ?>
							</br><span style="color:#0073aa;font-size:10px"><?php _e('No Bid', 'ultimate-auction-pro-software') ?></span>
						<?php } elseif ($product_data->get_uwa_auction_fail_reason() == '2') { ?>
							</br><span style="color:#0073aa;font-size:10px"><?php _e('Reserve Not Met', 'ultimate-auction-pro-software') ?></span>
							<?php } else {
							if ($isbn == 1) { ?>
								</br><span style="color:#0073aa;font-size:10px"><?php _e('Buy now', 'ultimate-auction-pro-software') ?></span>
							<?php } else { ?>
								</br><span style="color:#0073aa;font-size:10px"><?php _e('Won', 'ultimate-auction-pro-software') ?></span>
				<?php }
						} /* end of else */
					} /* end of else */ /* main Expired */
				}
			} /* end of if - auction */
		} /* end of if - admin-auction-status */
	}
	/**
	 * Callback for adding a meta box to the product editing screen used in uwa_render_auction_log
	 *
	 */
	function uwa_render_auction_log()
	{
		global $woocommerce, $post;
		$datetimeformat = get_option('date_format') . ' ' . get_option('time_format');
		$product_data = wc_get_product($post->ID);
		$auction_status = json_chk_auction($product_data->get_id());
		$uwa_auction_relisted = $product_data->get_uwa_auction_relisted();
		if ($auction_status == "past") :
			if (!empty($uwa_auction_relisted)) {
				?>
				<p><?php _e('Auction has been relisted on:', 'ultimate-auction-pro-software'); ?>
					<?php echo mysql2date($datetimeformat, $uwa_auction_relisted) ?> </p>
			<?php } ?>

			<?php if ($product_data->get_uwa_auction_fail_reason() == '1') { ?>
				<p><?php _e('Auction Expired without any bids.', 'ultimate-auction-pro-software') ?></p>
			<?php } elseif ($product_data->get_uwa_auction_fail_reason() == '2') { ?>
				<p><?php _e('Auction Expired without a reserve price met', 'ultimate-auction-pro-software') ?></p>
			<?php }
			if ($product_data->get_uwa_auction_expired() == '3') { ?>
				<p><?php _e('This Auction Product has been sold for buy it now price', 'ultimate-auction-pro-software') ?>:
					<span><?php echo wc_price($product_data->get_regular_price()) ?></span>
				</p>
				<?php
				$order = wc_get_order($product_data->get_uwa_order_id());
				if ($order) {
					$order_status = $order->get_status() ? $order->get_status() : __('unknown', 'ultimate-auction-pro-software'); ?>
					<p><?php _e('Order has been made, order status is', 'ultimate-auction-pro-software') ?>: <a href='post.php?&action=edit&post=<?php echo $product_data->get_uwa_order_id() ?>'><?php echo $order_status ?></a><span>
						<?php }
				} elseif ($product_data->get_uwa_auction_current_bider()) { ?>
						<?php
						$current_bidder = $product_data->get_uwa_auction_current_bider();
						?>
						<p><?php _e('Highest bidder was', 'ultimate-auction-pro-software') ?>: <span class="maxbider"><a href='<?php echo get_edit_user_link($current_bidder) ?>'><?php echo uat_user_display_name($current_bidder); ?></a></span>
						</p>
						<p><?php _e('Highest bid was', 'ultimate-auction-pro-software') ?>: <span class="maxbid"><?php echo wc_price($product_data->get_uwa_current_bid()) ?></span></p>
						<?php if ($product_data->get_uwa_auction_payed()) { ?>
							<p><?php _e('Order has been paid, order ID is', 'ultimate-auction-pro-software') ?>: <span><a href='post.php?&action=edit&post=<?php echo $product_data->get_uwa_order_id() ?>'><?php echo $product_data->get_uwa_order_id() ?></a></span>
							</p>
							<?php } elseif ($product_data->get_uwa_order_id()) {
							$order = wc_get_order($product_data->get_uwa_order_id());
							if ($order) {
								$order_status = $order->get_status() ? $order->get_status() : __('unknown', 'ultimate-auction-pro-software'); ?>
								<p><?php _e('Order has been made, order status is', 'ultimate-auction-pro-software') ?>: <a href='post.php?&action=edit&post=<?php echo $product_data->get_uwa_order_id() ?>'><?php echo $order_status ?></a><span>
								<?php }
						} ?>
								<?php if ($product_data->get_uwa_stripe_auto_debit_bid_amt()) { ?>
									<p><?php _e('Bid won auto debit amount', 'ultimate-auction-pro-software') ?> :
										<?php echo wc_price($product_data->get_uwa_stripe_auto_debit_bid_amt()) ?></p>
								<?php } ?>
								<?php if ($product_data->get_uwa_stripe_auto_debit_bpm_amt()) { ?>
									<p><?php _e("Auto debit of buyer's premium", 'ultimate-auction-pro-software') ?> :
										<?php echo wc_price($product_data->get_uwa_stripe_auto_debit_bpm_amt()) ?></p>
								<?php } ?>
								<?php if ($product_data->get_uwa_stripe_auto_debit_total_amt()) { ?>
									<p><?php _e('Total Auto Debit', 'ultimate-auction-pro-software') ?> :
										<?php echo wc_price($product_data->get_uwa_stripe_auto_debit_total_amt()) ?></p>
								<?php } ?>
						<?php }
				endif;
				$uwa_auction_log_history = $product_data->uwa_auction_log_history();
				$heading = "";
				if (!empty($uwa_auction_log_history)) {
					$heading = apply_filters('ultimate_woocommerce_auction_total_bids_heading', __('Total Bids Placed:', 'ultimate-auction-pro-software'));
					$heading .= sizeof((array)$uwa_auction_log_history);
				}
						?>
						<h2><?php echo $heading; ?></h2>
						<div class='ultimate-auction-pro-software' id="uwa_auction_log_history" v-cloak>
							<div class="uwa-table-responsive">
								<table class="uwa-admin-table uwa-admin-table-bordered">
									<?php
									if (!empty($uwa_auction_log_history)) : ?>
										<tr>
											<th><?php _e('Bidder Name', 'ultimate-auction-pro-software') ?></th>
											<th><?php _e('Bidding Time', 'ultimate-auction-pro-software') ?></th>
											<th><?php _e('Bid', 'ultimate-auction-pro-software') ?></th>
											<?php if ($product_data->get_uwa_auction_proxy()) { ?>
												<th><?php _e('Is it a Proxy Bid?', 'ultimate-auction-pro-software') ?></th>
											<?php } ?>
											<th class="actions"><?php _e('Actions', 'ultimate-auction-pro-software') ?></th>
										</tr>
										<?php foreach ($uwa_auction_log_history as $history_value) {
											$start_date = $product_data->get_uwa_auction_start_time();
											if ($history_value->date < $product_data->get_uwa_auction_relisted() && !isset($uwa_relisted)) {
										?>
												<tr>
													<td><?php echo __('Auction relisted', 'ultimate-auction-pro-software'); ?></td>
													<td colspan="4" class="bid_date"><?php echo mysql2date($datetimeformat, $start_date) ?>
													</td>
												</tr>
											<?php $uwa_relisted = true;
											} ?>
											<tr>
												<td class="bid_username"><a href="<?php echo get_edit_user_link($history_value->userid); ?>">
														<?php echo uat_user_display_name($history_value->userid); ?></a></td>
												<td class="bid_date"><?php echo mysql2date($datetimeformat, $history_value->date) ?>
												</td>
												<td class="bid_price"><?php echo wc_price($history_value->bid) ?></td>
												<?php
												if ($product_data->get_uwa_auction_proxy()) {
													if ($history_value->proxy == 1) { ?>
														<td class="proxy"><?php _e('Yes', 'ultimate-auction-pro-software'); ?></td>
													<?php } else { ?>
														<td class="proxy"></td>
												<?php }
												} ?>
												<td class="bid_action">
													<?php
													/*if ($product_data->get_uwa_auction_expired() != '2') { */ ?>
													<?php if (!$product_data->get_uwa_auction_payed() && $auction_status == "live") { ?>
														<a href='#' data-id=<?php echo $history_value->id; ?> data-postid=<?php echo $post->ID; ?>><?php echo __('Delete', 'ultimate-auction-pro-software'); ?></a>
													<?php } ?>
												</td>
											</tr>
										<?php } ?>
									<?php endif; ?>
									<tr class="start">
										<?php
										$start_date = $product_data->get_uwa_auction_start_time();
										if ($auction_status == "live") { ?>
											<td class="started"><?php echo __('The Auction has started', 'ultimate-auction-pro-software'); ?>
											<?php } else { ?>
											<td class="started"><?php echo __('The Auction will start', 'ultimate-auction-pro-software'); ?>
											<?php } ?></td>
											<td colspan="4" class="bid_date"><?php echo mysql2date($datetimeformat, $start_date) ?>
											</td>
									</tr>
								</table>
							</div>
						</div>
				<?php
			}
			/**
			 * Widgets Register
			 *
			 */
			public function uat_register_auctions_widgets()
			{
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-live-auctions.php');
				/* Register widgets	 */
				register_widget('UAT_Widget_Live_Auctions');
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-expired-auctions.php');
				/* Register widgets	 */
				register_widget('UAT_Widget_Expired_Auctions');
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-future-auctions.php');
				/* Register widgets */
				register_widget('UAT_Widget_Future_Auctions');
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-auction-search.php');
				/* Register widgets	*/
				register_widget('UAT_Widget_Auction_Search');
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-latest-auctions.php');
				register_widget('UAT_Widget_Latest_Auctions');
				include_once(UAT_THEME_PRO_ADMIN . 'auctions-products/widgets/class-uat-widget-ending-soon-auctions.php');
				/* Register widgets */
				register_widget('UAT_Widget_Ending_Soon_Auctions');
			}
			public function auction_products_type_save_post($post_id)
			{
				global $wpdb;
				$product = wc_get_product($post_id);
				if ($product->get_type() == "auction") {
					$auction_array = array();
					$auction_array['post_id'] = $product->get_id();
					$auction_array['post_status'] = $product->get_status();
					$auction_array['auction_owner'] = 1;
					$auction_array['auction_status'] = $product->get_update_auction_status();
					$auction_array['auction_name'] = $product->get_name();
					$auction_array['auction_content'] = get_post_field('post_content', $post_id);
					$auction_array['product_type'] = $product->get_type();
					$auction_array['auction_start_date'] = get_post_meta($post_id, 'woo_ua_auction_start_date', true);
					$auction_array['auction_end_date'] = get_post_meta($post_id, 'woo_ua_auction_end_date', true);
					$event_id = get_post_meta($post_id, 'uat_event_id', true);
					if (!empty($event_id)) {
						$auction_array['event_id'] = $event_id;
					} else {
						$auction_array['event_id'] = "";
					}
					$event_exists = $wpdb->get_var('SELECT post_id FROM ' . UA_AUCTION_PRODUCT_TABLE . " WHERE post_id=" . $product->get_id());
					if ($event_exists) {
						$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $auction_array, array('post_id' => $product->get_id()));
					} else {
						$wpdb->insert(UA_AUCTION_PRODUCT_TABLE, $auction_array);
						$insert_id = $wpdb->insert_id;
						update_post_meta($post_id, 'auction_id', $insert_id);
					}
					$location = get_field('uat_locationP_address', $product->get_id());
					$post_id = $product->get_id();
					if (!empty($location)) {
						//address
						if (!empty($location['address'])) {
							update_post_meta($post_id, 'uat_Product_loc_address', $location['address']);
						}
						//lat
						if (!empty($location['lat'])) {
							update_post_meta($post_id, 'uat_Product_loc_lat', $location['lat']);
						}
						//lng
						if (!empty($location['lng'])) {
							update_post_meta($post_id, 'uat_Product_loc_lng', $location['lng']);
						}
						//zoom
						if (!empty($location['zoom'])) {
							update_post_meta($post_id, 'uat_Product_loc_zoom', $location['zoom']);
						}
						//place_id
						if (!empty($location['place_id'])) {
							update_post_meta($post_id, 'uat_Product_loc_place_id', $location['place_id']);
						}
						//name
						if (!empty($location['name'])) {
							update_post_meta($post_id, 'uat_Product_loc_name', $location['name']);
						}
						//city
						if (!empty($location['city'])) {
							update_post_meta($post_id, 'uat_Product_loc_city', $location['city']);
						}
						//state
						if (!empty($location['state'])) {
							update_post_meta($post_id, 'uat_Product_loc_state', $location['state']);
						}
						//state
						if (!empty($location['state_short'])) {
							update_post_meta($post_id, 'uat_Product_loc_state_short', $location['state_short']);
						}
						//post_code
						if (!empty($location['post_code'])) {
							update_post_meta($post_id, 'uat_Product_loc_post_code', $location['post_code']);
						}
						//country
						if (!empty($location['country'])) {
							update_post_meta($post_id, 'uat_Product_loc_country', $location['country']);
						}
						//country_short
						if (!empty($location['country_short'])) {
							update_post_meta($post_id, 'uat_Product_loc_country_short', $location['country_short']);
						}
					}
				}
			}
			public static function auction_products_type_trashed_post($post_id)
			{
				global $wpdb;
				if (get_post_type($post_id) == "product") {
					$product = wc_get_product($post_id);
					if ($product->get_type() == "auction") {
						$post_status = get_post_status($post_id);
						$result = $wpdb->query($wpdb->prepare("update " . UA_AUCTION_PRODUCT_TABLE . " SET post_status=%s WHERE post_id=%d", $post_status, $post_id));
					}
				}
			}
			public static function auction_products_type_before_delete_post($post_id)
			{
				global $wpdb;
				if (get_post_type($post_id) == "product") {
					$product = wc_get_product($post_id);
					if ($product->get_type() == "auction") {
						$result = $wpdb->query($wpdb->prepare("DELETE FROM " . UA_AUCTION_PRODUCT_TABLE . " WHERE post_id=%d", $post_id));
					}
				}
			}
		} /* end of class */
		Uat_Auction_Product_Types::get_instance();
