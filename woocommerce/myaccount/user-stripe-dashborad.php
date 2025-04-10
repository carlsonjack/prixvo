<?php

/**
 * My auctions tab list
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if (!defined('ABSPATH')) {
	exit;
}
?>
<div class="payment-options-common">

	<!-- <div class="payment-options "> -->
	<?php
	/* show seller payment option */
	do_action('uat_seller_payment_setings');
	?>
	<!-- </div> -->
	<div class="payment-options payment-options-buyer">
		<h3><?php echo __('Add a credit card for bidding', 'ultimate-auction-pro-software'); ?></h3>
		<div class="sub-text-cc"><?php echo __("Added cards are available to capture credit card details, debit the winning amount & buyer's premium.", "ultimate-auction-pro-software"); ?></div>
		<?php

		/* show buyer payment option */
		$gateway = "";
		try {
			$Uat_Auction_Payment = new Uat_Auction_Payment();
			$gateway = $Uat_Auction_Payment->gateway;
		} catch (\Throwable $th) {
			//throw $th;
		}
		$msg = 0;
		global $wpdb;
		$user_id = get_current_user_id();

		if ($gateway == 'braintree') {
			try {

				$Uat_Auction_Braintree = new Uat_Auction_Braintree();

				if (!empty($user_id)) {
					$customer_id = get_user_meta($user_id, $wpdb->prefix . '_braintree_customer_id', true);
					$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $user_id . " AND gateway_id='" . $gateway . "'  ORDER BY `is_default` DESC ";
					$resultsdata = $wpdb->get_results($query);
					if (!empty($resultsdata) && empty($resultsdata[0]->is_default)) {
						$resultsdata[0]->token;
						$status =  $Uat_Auction_Braintree->makedafaultCard($customer_id, $resultsdata[0]->token);
						if ($status == "1") {

							$sql = "UPDATE `" . $wpdb->prefix . "ua_auction_payment_cards` SET is_default = 1   WHERE user_id = $user_id AND id =" . $resultsdata[0]->id;
							$wpdb->query($sql);
						}
					}
				}
				/* add new card */
				if (isset($_POST['add_card'])) {
					if (is_user_logged_in()) {

						$cardnumber = $_POST['cardnumber'];
						$exp_date = $_POST['exp_date'];
						$cvc = $_POST['cvc'];
						if (!empty($cardnumber) && !empty($exp_date) && !empty($cvc)) {
							$customer_id = get_user_meta($user_id, $wpdb->prefix . '_braintree_customer_id', true);
							if ($customer_id != "") {
								$braintreeCard = $Uat_Auction_Braintree->createCard($customer_id, $cardnumber, $exp_date, $cvc);

								if (isset($braintreeCard->token)) {
									$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where card_type='" . $braintreeCard->cardType . "' and expiry_month='" . $braintreeCard->expirationMonth . "' and expiry_year='" . $braintreeCard->expirationYear . "' and last4='" . $braintreeCard->last4 . "' and user_id=" . $user_id . " and gateway_id='" . $gateway . "' ";
									$results = $wpdb->get_results($query);
									if (count($results) == 0) {
										$card_meta_array['gateway_id'] = $gateway;
										$card_meta_array['token'] = $braintreeCard->token;
										$card_meta_array['last4'] =  $braintreeCard->last4;
										$card_meta_array['expiry_year'] =  $braintreeCard->expirationYear;
										$card_meta_array['expiry_month'] = $braintreeCard->expirationMonth;
										$card_meta_array['card_type'] =  $braintreeCard->cardType;
										$card_meta_array['user_id'] = $user_id;
										$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
										$url = site_url('my-account/uat-stripe/') . '?msg=' . 2;
									} else {
										$url = site_url('my-account/uat-stripe/') . '?msg=' . 5;
									}
								} else {
									$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $braintreeCard;
								}
							} else {
								$braintreeCard = $Uat_Auction_Braintree->addCustomerWithCard($user_id, $cardnumber, $exp_date, $cvc);
								if ($braintreeCard->token) {
									update_user_meta($user_id, $wpdb->prefix . '_braintree_customer_id', $braintreeCard->customerId);
									$card_meta_array['gateway_id'] = $gateway;
									$card_meta_array['token'] = $braintreeCard->token;
									$card_meta_array['last4'] =  $braintreeCard->last4;
									$card_meta_array['expiry_year'] =  $braintreeCard->expirationYear;
									$card_meta_array['expiry_month'] = $braintreeCard->expirationMonth;
									$card_meta_array['card_type'] =  $braintreeCard->cardType;
									$card_meta_array['user_id'] = $user_id;
									$card_meta_array['is_default'] = $braintreeCard->default;
									$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
									$url = site_url('my-account/uat-stripe/') . '?msg=' . 2;
								} else {									
									$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $braintreeCard;
								}
							}
						}
						
		?>
						<script>
							window.location.href = "<?php echo $url; ?>";
						</script>
					<?php
					}
				}

				/* make dafault card */
				if (isset($_REQUEST['mul'])) {

					$id = $_REQUEST['mul'];
					$url = site_url('my-account/uat-stripe/') . '?msg=' . 3;
					$customer_id = get_user_meta($user_id, $wpdb->prefix . '_braintree_customer_id', true);
					$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $user_id . " AND id='" . $id . "'  ORDER BY `is_default` DESC ";
					$resultsdata = $wpdb->get_results($query);
					if (empty($resultsdata[0]->is_default)) {
						try {
							$status =  $Uat_Auction_Braintree->makedafaultCard($customer_id, $resultsdata[0]->token);
							if ($status == "1") {
								$table_name  =  $wpdb->prefix . "ua_auction_payment_cards";
								$sql1 = "UPDATE $table_name SET is_default = 0   WHERE user_id = $user_id  ";
								$wpdb->query($sql1);
								$sql = "UPDATE $table_name SET is_default = 1   WHERE user_id = $user_id AND id = $id ";
								$wpdb->query($sql);
							} else {
								$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $status;
							}
						} catch (\Throwable $th) {
							$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $th->getMessage();
						}
					}
					?>
					<script>
						window.location.href = "<?php echo $url; ?>";
					</script>
				<?php
				}
				/* delete card */
				if (isset($_REQUEST['del'])) {
					$id = $_REQUEST['del'];
					$query   = "SELECT token FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  id=" . $id . " ";
					$resultsdata = $wpdb->get_results($query);
					$resultsdata[0]->token;
					if (!empty($resultsdata[0]->token)) {
						$customer_id = get_user_meta($user_id, $wpdb->prefix . '_braintree_customer_id', true);
						$status = $Uat_Auction_Braintree->deleteCard($customer_id, $resultsdata[0]->token);
						if ($status == "1") {
							$table = $wpdb->prefix . 'ua_auction_payment_cards';
							$wpdb->delete($table, array('id' => $id));
							$url = site_url('my-account/uat-stripe/') . '?msg=' . 1;
						} else {
							$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $status;
						}
					}
				?>
					<script>
						window.location.href = "<?php echo $url; ?>";
					</script>
				<?php
				}
			} catch (\Throwable $th) {
				//throw $th;
			}
		} else {

			$StripeIsEnable = get_option('options_uwt_stripe_card_in_popup');
			$StripePaymentModeTypes = get_option('options_uat_stripe_mode_types', 'uat_stripe_test_mode');
			if ($StripePaymentModeTypes == 'uat_stripe_live_mode') {
				$publishable_key = get_option('options_uat_stripe_live_publishable_key');
				$secret_key = get_option('options_uat_stripe_live_secret_key');
			} else {
				$publishable_key = get_option('options_stripe_test_publishable_key');
				$secret_key = get_option('options_uat_stripe_test_secret_key');
			}
			$publishable_key = $publishable_key;
			$secret_key = $secret_key;
			global $woocommerce, $product;

			$active_tab = get_query_var('ua-auctions') ? get_query_var('ua-auctions') : 'saved';
			$my_auction_page_url = wc_get_endpoint_url('ua-auctions');


			if (!empty($user_id)) {
				if (!empty($secret_key)) {
					$stripe = new \Stripe\StripeClient($secret_key);
					$customer_id = get_user_meta($user_id, $wpdb->prefix . '_stripe_customer_id', true);
					$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $user_id . " and gateway_id IN('" . $gateway . "','')   ORDER BY `is_default` DESC ";
					$resultsdata = $wpdb->get_results($query);
					if (!empty($resultsdata) && empty($resultsdata[0]->is_default)) {
						//$resultsdata[0]->token;
						$customer = $stripe->customers->retrieve(
							$customer_id,
							[]
						);
						$customer->default_source = $resultsdata[0]->token;
						$customer->save();
						$sql = "UPDATE `" . $wpdb->prefix . "ua_auction_payment_cards` SET is_default = 1   WHERE user_id = $user_id AND id =" . $resultsdata[0]->id;
						$wpdb->query($sql);
					}
				}
			}
			if (isset($_REQUEST['del'])) {

				$id = $_REQUEST['del'];
				$query   = "SELECT token FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  id=" . $id . " ";
				$resultsdata = $wpdb->get_results($query);
				$db_token = $resultsdata[0]->token;

				if (!empty($resultsdata[0]->token)) {
					if (!empty($secret_key)) {
						$stripe = new \Stripe\StripeClient($secret_key);

						$customer_id = get_user_meta($user_id, $wpdb->prefix . '_stripe_customer_id', true);


						try {
							// Retrieve the customer
							$customer = $stripe->customers->retrieve($customer_id);
							
							if (str_contains($db_token, 'src_')) {
							$retrievecard = $stripe->customers->deleteSource(
								$customer_id,
								$db_token
							);
							} else {
								$retrievecard = $stripe->customers->allSources(
									$customer_id,
									['object' => 'card', 'limit' => 100]
								);

								$isfind = 0;
								if (count($retrievecard['data']) > 0) {
									foreach ($retrievecard['data'] as $val) {
										if ($val->id == $resultsdata[0]->token) {
											$isfind = 1;
										}
									}
								}
								if ($isfind == 1) {
									$delcard = $stripe->customers->deleteSource(
										$customer_id,
										$db_token,
									);
								}
							}

							
						} catch (\Stripe\Exception\ApiErrorException $e) {
							// Handle error if the customer does not exist or other API errors
							echo 'Error: ' . $e->getMessage();
						}
							

						
						
					}
				}
				$table = $wpdb->prefix . 'ua_auction_payment_cards';
				$wpdb->delete($table, array('id' => $id));
				$url = site_url('my-account/uat-stripe/') . '?msg=' . 1;
				?>
				<script>
					window.location.href = "<?php echo $url; ?>";
				</script>
			<?php
			}
			if (isset($_REQUEST['mul'])) {

				$id = $_REQUEST['mul'];
				$url = site_url('my-account/uat-stripe/') . '?msg=' . 3;
				$uid = $user_id;
				$user_id = $uid;
				if (!empty($secret_key)) {
					$stripe = new \Stripe\StripeClient($secret_key);

					$customer_id = get_user_meta($user_id, $wpdb->prefix . '_stripe_customer_id', true);
					$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $user_id . " AND id='" . $id . "'  ORDER BY `is_default` DESC ";
					$resultsdata = $wpdb->get_results($query);
					if (empty($resultsdata[0]->is_default)) {
						$resultsdata[0]->token;
						$customer = $stripe->customers->retrieve(
							$customer_id,
							[]
						);
						$customer->default_source = $resultsdata[0]->token;
						$customer->save();
					}
				}
				$table_name  =  $wpdb->prefix . "ua_auction_payment_cards";
				$sql1 = "UPDATE $table_name SET is_default = 0   WHERE user_id = $uid  ";
				$wpdb->query($sql1);
				$sql = "UPDATE $table_name SET is_default = 1   WHERE user_id = $uid AND id = $id ";
				$wpdb->query($sql);
			?>
				<script>
					window.location.href = "<?php echo $url; ?>";
				</script>
				<?php
			}
			if (isset($_POST['add_card'])) {

				if (is_user_logged_in()) {

					$cardnumber = $_POST['cardnumber'];
					$exp_date = explode("/", $_POST['exp_date']);
					$cvc = $_POST['cvc'];
					if (!empty($secret_key)) {
						$stripe =  \Stripe\Stripe::setApiKey($secret_key);
						$user_info = get_userdata($user_id);
						$user_email = $user_info->user_email;
						try {
							//code...

							$token =   \Stripe\Token::create(array(
								"card" => array(
									"number" => $cardnumber,
									"exp_month" =>  $exp_date[0],
									"exp_year" => $exp_date[1],
									"cvc" => $cvc
								)
							));
							$customer_id = get_user_meta($user_id, $wpdb->prefix . '_stripe_customer_id', true);
							if ($customer_id != "") {
								$stripe = new \Stripe\StripeClient($secret_key);
								$newcardadd = $stripe->customers->createSource(
									$customer_id,
									['source' => $token['id']]
								);
								$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where card_type='" . $newcardadd->brand . "' and expiry_month='" . $newcardadd->exp_month . "' and expiry_year='" . $newcardadd->exp_year . "' and last4='" . $newcardadd->last4 . "' and user_id=" . $user_id . " ";
								$results = $wpdb->get_results($query);
								if (count($results) == 0) {
									$card_meta_array['gateway_id'] = $gateway;
									$card_meta_array['token'] = $newcardadd->id;
									$card_meta_array['last4'] =  $newcardadd->last4;
									$card_meta_array['expiry_year'] =  $newcardadd->exp_year;
									$card_meta_array['expiry_month'] = $newcardadd->exp_month;
									$card_meta_array['card_type'] =  $newcardadd->brand;
									$card_meta_array['user_id'] = $user_id;
									$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
									$url = site_url('my-account/uat-stripe/') . '?msg=' . 2;
								}
							} else {
								$request['stripe_token'] = $token['id'];
								$customer = \Stripe\Customer::create([
									"email" =>  $user_email,
									"description" => "Customer for " . $user_email,
									"source" => $request['stripe_token'] // obtained with Stripe.js
								]);
								update_user_meta($user_id, $wpdb->prefix . '_stripe_customer_id', $customer->id);
								$card_meta_array['token'] = $token['card']['id'];
								$card_meta_array['last4'] = $token['card']['last4'];
								$card_meta_array['expiry_year'] = $token['card']['exp_year'];
								$card_meta_array['expiry_month'] =  $token['card']['exp_month'];
								$card_meta_array['card_type'] = $token['card']['brand'];
								$card_meta_array['user_id'] = $user_id;
								$card_meta_array['gateway_id'] = $gateway;

								$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
								$url = site_url('my-account/uat-stripe/') . '?msg=' . 2;
							}
						} catch (\Throwable $th) {
							$url = site_url('my-account/uat-stripe/') . '?msg=' . 4 . '&msgStr=' . $th->getMessage();
						}
					}
				?>
					<script>
						window.location.href = "<?php echo $url; ?>";
					</script>
		<?php
				}
			}
		}
		?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js" type="text/javascript"></script>
		<script>
			window.onload = function() {

				const expirationdate = document.getElementById('expirationdate');


				let cctype = null;


				//Mask the Expiration Date
				var expirationdate_mask = new IMask(expirationdate, {
					mask: 'MM{/}YY',
					groups: {
						YY: new IMask.MaskedPattern.Group.Range([0, 99]),
						MM: new IMask.MaskedPattern.Group.Range([1, 12]),
					}
				});



				expirationdate_mask.on('accept', function() {
					if (expirationdate_mask.value.length == 0) {
						document.getElementById('svgexpire').innerHTML = '01/23';
					} else {
						document.getElementById('svgexpire').innerHTML = expirationdate_mask.value;
					}
				});

			};
		</script>
		<?php
		if (isset($_REQUEST['msg'])) {
			$msg = $_REQUEST['msg'];
		}
		if (isset($_REQUEST['msgStr'])) {
			$msgStr = $_REQUEST['msgStr'];
		} else {
			$msgStr = "";
		}
		if ($msg != "") {
			$msg_string = "";
			$msg_class = "success-green";
			if ($msg == 1) {
				$msg_string = __('Card Deleted', 'ultimate-auction-pro-software');
			} else if ($msg == 2) {
				$msg_string = __('Card Added', 'ultimate-auction-pro-software');
			} else if ($msg == 3) {
				$msg_string = __('Default Card', 'ultimate-auction-pro-software');
			} else if ($msg == 4) {
				$msg_string = __('Something is wrong please try again.', 'ultimate-auction-pro-software') . ' ' . $msgStr;
				$msg_class = "error-red";
			} else if ($msg == 5) {
				$msg_string = __('Card already added.', 'ultimate-auction-pro-software');
				$msg_class = "error-red";
			}
			echo '<div class="' . $msg_class . '">' . $msg_string . '</div>';
		}
		if ($gateway == 'braintree') {
		?>
			<form action="" method="POST" name="frm_card_add" class="auction-payment-method">
				<div class="col-1-input"><input class="InputElement is-empty Input Input--empty" maxlength="16" size="16" autocomplete="cc-number" autocorrect="off" spellcheck="false" type="text" name="cardnumber" data-elements-stable-field-name="cardNumber" inputmode="numeric" aria-label="Credit or debit card number" placeholder="1234 1234 1234 1234" aria-invalid="false" value="" required></div>
				<div class="col-2-input"><input class="InputElement is-empty Input Input--empty" autocomplete="cc-exp" autocorrect="off" spellcheck="false" type="text" name="exp_date" data-elements-stable-field-name="cardExpiry" inputmode="numeric" aria-label="Credit or debit card expiration date" placeholder="MM / YY" id="expirationdate" aria-invalid="false" value="" required></div>
				<div class="col-3-input"><input class="InputElement is-empty Input Input--empty" autocomplete="cc-csc" autocorrect="off" spellcheck="false" type="text" name="cvc" data-elements-stable-field-name="cardCvc" inputmode="numeric" aria-label="Credit or debit card CVC/CVV" placeholder="CVC" aria-invalid="false" value="" required></div>
				<div class="col-4-submit"><button type="submit" name="add_card" id="add_card" class="woocommerce-Button woocommerce-Button--alt button alt" value="<?php echo esc_attr('Add Credit Card', 'ultimate-auction-pro-software'); ?>"><?php echo __('Add Credit Card', 'ultimate-auction-pro-software'); ?></button></div>
			</form>
		<?php
		}
		if ($gateway == 'stripe') {
			?>

			<div id="uat-register-form" class="example3 card_number_spacing">
			<form id="uat-user-add-card" class="ajax-auth" action="register" method="post">
				
				<div class="error" role="alert">
					<span class="message"></span>
				</div>
				<div class="fieldset">
					<div id="example3-card-number" class="field empty required "></div>
					<div id="example3-card-expiry" class="field empty third-width required"></div>
					<div id="example3-card-cvc" class="field empty third-width required "></div>
					<span class="token"></span>
					<input type="hidden" name="uwa_stripe_k_id" value="" id="uwa_stripe_k_id"/>
				</div>
				<input class="submit_button" type="submit" value="<?php _e('Add Credit Card', 'ultimate-auction-pro-software'); ?>">
			</form>
			</div>
			<?php 
				$StripePaymentModeTypes = get_option('options_uat_stripe_mode_types', 'uat_stripe_test_mode');
				if ($StripePaymentModeTypes == 'uat_stripe_live_mode') {
					$TPublishableKey = get_option('options_uat_stripe_live_publishable_key');
				} else {
					$TPublishableKey = get_option('options_stripe_test_publishable_key');
				}
				if (!empty($TPublishableKey)) {
					$pubkey = $TPublishableKey;
					wp_enqueue_script('jquery');
					wp_enqueue_script('uwa-stripe', 'https://js.stripe.com/v3/');
					wp_enqueue_script('stripe-processing', UAT_THEME_PRO_JS_URI . 'stripe/uat-stripe-account-page.js', array('jquery','uwa-stripe'), null);
					wp_localize_script('stripe-processing', 'stripe_vars', array('publishable_key' => $pubkey));
					$isCardForm = 'on';
				} 
			?>
				<script>
					var isCardForm = '<?php echo $isCardForm; ?>';
				</script>
				
		<?php } 
		if (is_user_logged_in()) {

			$where = "";
			if ($gateway == 'braintree') {
				$where =  " and gateway_id='" . $gateway . "' ";
			} else {
				$where =  " and gateway_id IN('" . $gateway . "','') ";
			}
			$query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where user_id=" . $user_id . $where;
			$results = $wpdb->get_results($query);
			if (count($results)) {
		?>
				<table class="woocommerce-MyAccount-paymentMethods shop_table shop_table_responsive account-payment-methods-table">
					<thead>
						<tr>
							<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--method payment-method-method"><span class="nobr"><?php echo __('Method', 'ultimate-auction-pro-software'); ?></span></th>
							<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--expires payment-method-expires"><span class="nobr"><?php echo __('Expires', 'ultimate-auction-pro-software'); ?></span></th>
							<th class="woocommerce-PaymentMethod woocommerce-PaymentMethod--actions payment-method-actions"><span class="nobr">&nbsp;</span></th>
						</tr>
					</thead>
					<?php
					foreach ($results as $row) {
						$user_id =  $row->user_id;
						$last4 =  $row->last4;
						$expiry_year =  $row->expiry_year;
						$expiry_month =  $row->expiry_month;
						$edate = $expiry_year . '/' . $expiry_month;
					?>
						<tr class="payment-method default-payment-method">
							<td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--method payment-method-method" data-title="Method">
								<?php echo __('Visa ending in', 'ultimate-auction-pro-software'); ?> <?php echo  $last4; ?> </td>
							<td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--expires payment-method-expires" data-title="Expires">
								<?php echo $edate; ?> </td>
							<td class="woocommerce-PaymentMethod woocommerce-PaymentMethod--actions payment-method-actions" data-title="&nbsp;">
								<a href="<?php echo site_url('my-account/uat-stripe/'); ?>?del=<?php echo $row->id; ?>" class="button delete"><?php echo __('Delete', 'ultimate-auction-pro-software'); ?></a>
								<?php if ($row->is_default == 0) { ?>
									<a href="<?php echo site_url('my-account/uat-stripe/'); ?>?mul=<?php echo $row->id; ?>" class="button default"><?php echo __('Make default', 'ultimate-auction-pro-software'); ?></a>&nbsp;
								<?php } ?>
							</td>
						</tr>
					<?php
					}
					?>
				</table>
		<?php
			}
		}
		?>
	</div>
</div>