<?php

/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ultimate_Auction
 */

/* Code for Login/Register popup  */
function uat_footer_code_for_login_register_pupup()
{
	if (class_exists('WooCommerce') && !is_user_logged_in()) {
		if (!is_account_page()) { ?>
			<div style="display: none;" id="uat-login-form">
				<div class="popup-header"><?php _e("Sign In or Create an Account", "ultimate-auction-pro-software"); ?></div>
				<div class="login-top-bar">
					<div class="lt-right"><?php _e("Welcome back!", "ultimate-auction-pro-software"); ?></div>
					<div class="lt-left">
						<a data-src="#uat-register-form" class="text-link registerModal" href="javascript:;"><?php _e("Create account", "ultimate-auction-pro-software"); ?></a>
					</div>
				</div>
				<form id="uat-user-login-form" class="ajax-auth" action="login" method="post">
					<?php
					
					$tag_line = get_option("options_uat_register_login_popup_tag_line", "options");
					if (!empty($tag_line)) { ?><h1><?php echo $tag_line; ?></h1><?php } ?>
					<?php wp_nonce_field("ajax-uat-login-nonce", "security"); ?>
					<label for="username"><?php _e("User Name or Email", "ultimate-auction-pro-software"); ?></label>
					<input id="username" type="text" class="required" name="username">
					<label for="uat-password"><?php _e("Password", "ultimate-auction-pro-software"); ?></label>
					<input id="password" type="password" class="required" name="password">
					<a class="text-link" target="_blank" href="<?php echo wp_lostpassword_url(); ?>"><?php _e("Forgot your password?", "ultimate-auction-pro-software"); ?></a>
					<input class="submit_button" type="submit" value="<?php _e("Sign in", "ultimate-auction-pro-software"); ?>">
					<p class="status"></p>
					<?php 
					$social_enabled = get_option("options_registration_social_enabled", "disable");
					if (!empty($social_enabled) && $social_enabled == "enable") {
						if (class_exists("NextendSocialLogin", false)) {
							echo "<div class='abc'></div>";
							echo NextendSocialLogin::renderButtonsWithContainer();
						}
					}
					?>
				</form>
			</div>
			<svg display="none" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="768" height="800" viewBox="0 0 768 800">
				<defs>
					<g id="icon-close">
						<path class="path1" d="M31.708 25.708c-0-0-0-0-0-0l-9.708-9.708 9.708-9.708c0-0 0-0 0-0 0.105-0.105 0.18-0.227 0.229-0.357 0.133-0.356 0.057-0.771-0.229-1.057l-4.586-4.586c-0.286-0.286-0.702-0.361-1.057-0.229-0.13 0.048-0.252 0.124-0.357 0.228 0 0-0 0-0 0l-9.708 9.708-9.708-9.708c-0-0-0-0-0-0-0.105-0.104-0.227-0.18-0.357-0.228-0.356-0.133-0.771-0.057-1.057 0.229l-4.586 4.586c-0.286 0.286-0.361 0.702-0.229 1.057 0.049 0.13 0.124 0.252 0.229 0.357 0 0 0 0 0 0l9.708 9.708-9.708 9.708c-0 0-0 0-0 0-0.104 0.105-0.18 0.227-0.229 0.357-0.133 0.355-0.057 0.771 0.229 1.057l4.586 4.586c0.286 0.286 0.702 0.361 1.057 0.229 0.13-0.049 0.252-0.124 0.357-0.229 0-0 0-0 0-0l9.708-9.708 9.708 9.708c0 0 0 0 0 0 0.105 0.105 0.227 0.18 0.357 0.229 0.356 0.133 0.771 0.057 1.057-0.229l4.586-4.586c0.286-0.286 0.362-0.702 0.229-1.057-0.049-0.13-0.124-0.252-0.229-0.357z"></path>
					</g>
				</defs>
			</svg>
			<div class="uatmodal">
				<div class="uatmodal-wrapper uatmodal-transition">
					<div class="uatmodal-header">
						<button class="uatmodal-close register registerModal"><svg class="icon-close uta-icon" viewBox="0 0 32 32">
								<use xlink:href="#icon-close"></use>
							</svg></button>
					</div>
					<div class="uatmodal-body">
						<div class="uatmodal-content">
							<div id="uat-register-form" class="example3 fancybox-content">
								<div class="popup-header">
									<?php _e("Sign In or Create an Account", "ultimate-auction-pro-software"); ?>
								</div>
								<div class="login-top-bar">
									<div class="lt-right"><?php _e("Create account", "ultimate-auction-pro-software"); ?></div>
									<div class="lt-left">
										 <a data-fancybox data-src="#uat-login-form" class="text-link" href="javascript:;">
											<?php _e("<span style='color: #000;'>Already have an account?</span> Sign In", "ultimate-auction-pro-software"); ?></a>
									</div>
								</div>
								<form id="uat-user-register-form" class="ajax-auth" action="register" method="post">
									<?php
									$tag_line = get_option("options_uat_register_login_popup_tag_line");
									$options_uwt_enable_firstname_lastname_on_reg_page = get_option("options_uwt_enable_firstname_lastname_on_reg_page");
									if (!empty($tag_line)) { ?><h1><?php echo $tag_line; ?></h1><?php }

										wp_nonce_field("ajax-register-nonce", "signonsecurity");

									if (!empty($options_uwt_enable_firstname_lastname_on_reg_page) && $options_uwt_enable_firstname_lastname_on_reg_page == "enable") { ?>
										<label for="reg_billing_first_name"><?php _e("First name", "ultimate-auction-pro-software"); ?> <span class="required">*</span></label>
										<input type="text" class="input-text required" name="billing_first_name" placeholder="<?php _e("First name", "ultimate-auction-pro-software"); ?>" id="reg_billing_first_name" value="" />
										<label for="reg_billing_last_name"><?php _e("Last name", "ultimate-auction-pro-software"); ?> <span class="required">*</span></label>
										<input type="text" class="input-text required" name="billing_last_name" placeholder="<?php _e("Last name", "ultimate-auction-pro-software"); ?>" id="reg_billing_last_name" value="" />
									<?php } ?>
									
									<label for="username"><?php _e("Username", "ultimate-auction-pro-software"); ?><span class="required">*</span></label>
									<input id="username" type="text" class="required username"  name="username" placeholder="<?php _e("Username", "ultimate-auction-pro-software"); ?>">
									
									<label for="email"><?php _e("Email", "ultimate-auction-pro-software"); ?><span class="required">*</span></label>
									<input id="email" type="text" class="required email" name="email" placeholder="<?php _e("Email", "ultimate-auction-pro-software"); ?>">
									<label for="signonpassword"><?php _e("Password", "ultimate-auction-pro-software"); ?><span class="required">*</span></label>
									<input id="signonpassword" type="password" class="required" name="signonpassword" placeholder="<?php _e("Password", "ultimate-auction-pro-software"); ?>">
									<?php

									$paymentGateway = get_option("options_uat_payment_gateway", "stripe");
									$myAcountcardIsEnable = get_option("options_uwt_stripe_card_myaccount_page", "disable");
									$isCardForm = "off";
									if (!empty($myAcountcardIsEnable) && $myAcountcardIsEnable == "enable") {
										if ($paymentGateway == "braintree") {
											$braintreePaymentModeTypes = get_option("options_uat_braintree_mode_types", "uat_braintree_test_mode");
											if ($braintreePaymentModeTypes == "uat_braintree_live_mode") {
												$TPublishableKey = get_option("options_uat_braintree_live_public_key", "");
											} else {
												$TPublishableKey = get_option("options_uat_braintree_test_public_key", "");
											}
											if (!empty($TPublishableKey)) { ?>
												<label for="Card"><?php _e("Credit card detail", "ultimate-auction-pro-software"); ?><span class="required">*</span></label>
												<div id="example3-card-number" class="field empty required hosted-field "></div>
												<div id="example3-card-expiry" class="field empty third-width required hosted-field"></div>
												<div id="example3-card-cvc" class="field empty third-width required hosted-field "></div>
												<span class="token"></span>
												<input type="hidden" name="uwa_braintree_k_id" value="" id="uwa_braintree_k_id" />
												<div class="error" role="alert" style="color: red;margin-bottom: 10px;display: inline-block;">
													<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
														<path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
													</svg>
													<span class="message"></span>
												</div>
												<a class="reset" href="#">
													<svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
														<path fill="#000000" d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z">
														</path>
													</svg>
												</a>
												<?php
												$pubkey = "";
												try {
													$braintree = new Uat_Auction_Braintree();
													$pubkey = $braintree->getClientToken();
													$isCardForm = "on";
													wp_enqueue_script("jquery");
													wp_enqueue_script(
														"uwa-braintree-dropin",
														"https://js.braintreegateway.com/web/dropin/1.33.2/js/dropin.js"
													);
													wp_enqueue_script(
														"uwa-braintree",
														"https://js.braintreegateway.com/web/3.85.5/js/hosted-fields.min.js"
													);
													wp_enqueue_script(
														"uwa-braintree-client",
														"https://js.braintreegateway.com/web/3.85.5/js/client.min.js"
													);
													wp_enqueue_script(
														"uat-braintree-default-form-js",
														UAT_THEME_PRO_JS_URI .
															"braintree/uat-braintree-processing.js",
														[],
														null
													);
													wp_localize_script(
														"uat-braintree-default-form-js",
														"braintree_vars",
														[
															"source_key" => $pubkey,
															"invalid_card_details_msg" => __(
																"Please enter valid card details",
																"ultimate-auction-pro-software"
															),
														]
													);
												} catch (\Throwable $th) {
													//throw $th;
													$isCardForm = "off";
												}
											} else {
												$isCardForm = "off";
											}
										}
										if ($paymentGateway == "stripe") {
											$StripePaymentModeTypes = get_option("options_uat_stripe_mode_types", "uat_stripe_test_mode");
											if ($StripePaymentModeTypes == "uat_stripe_live_mode") {
												$TPublishableKey = get_option("options_uat_stripe_live_publishable_key");
											} else {
												$TPublishableKey = get_option("options_stripe_test_publishable_key");
											}
											if (!empty($TPublishableKey)) { ?>
												<div class="fieldset">
													<label for="Card"><?php _e("Credit card detail", "ultimate-auction-pro-software"); ?><span class="required">*</span></label>
													<div id="example3-card-number" class="field empty required "></div>
													<div id="example3-card-expiry" class="field empty third-width required"></div>
													<div id="example3-card-cvc" class="field empty third-width required "></div>
													<span class="token"></span>
													<input type="hidden" name="uwa_stripe_k_id" value="" id="uwa_stripe_k_id" />
												</div>
												<div class="error" role="alert" style="color: red;margin-bottom: 10px;display: inline-block;">
													<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
														<path class="glyph" fill="#FFF" d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
													</svg>
													<span class="message"></span>
												</div>

												<a class="reset" href="#">
													<svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
														<path fill="#000000" d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z">
														</path>
													</svg>
												</a>
									<?php }

											if (!empty($TPublishableKey)) {
												$pubkey = $TPublishableKey;
												wp_enqueue_script("jquery");
												wp_enqueue_script("uwa-stripe", "https://js.stripe.com/v3/");
												wp_enqueue_script("stripe-processing", UAT_THEME_PRO_JS_URI . "stripe/uat-stripe-processing.js", [], null);
												wp_localize_script("stripe-processing", "stripe_vars", ["publishable_key" => $pubkey,]);
												$isCardForm = "on";
											} else {
												$isCardForm = "off";
											}
										}
									} ?>
									<script>
										var isCardForm = '<?php echo $isCardForm; ?>';
									</script>
									<?php
									$registration_phone_enabled = get_option("options_uat_need_registration_phone_enabled", "disable");
									$uat_need_registration_address_enabled = get_option("options_uat_need_registration_address_enabled", "disable");
									if ($uat_need_registration_address_enabled == "enable") { ?>
										<p class="form-row form-row-wide">
											<strong><?php _e("Billing details", "ultimate-auction-pro-software"); ?></strong>
										</p>
									<?php }
									global $woocommerce;
									$checkout = $woocommerce->checkout();
									foreach ($checkout->get_checkout_fields("billing") as $key => $field) {
										if (
											$key == "billing_phone" &&
											$registration_phone_enabled == "enable"
										) {
											woocommerce_form_field(
												$key,
												$field,
												$checkout->get_value($key)
											);
										}
										if ($uat_need_registration_address_enabled == "enable") {
											if (
												$key == "billing_address_1" ||
												$key == "billing_address_2" ||
												$key == "billing_city" ||
												$key == "billing_country" ||
												$key == "billing_state" ||
												$key == "billing_postcode"
											) {
												woocommerce_form_field(
													$key,
													$field,
													$checkout->get_value($key)
												);
											}
										}
									}
									wp_enqueue_script(
										"wc-country-select",
										get_site_url() .
											"/wp-content/plugins/woocommerce/assets/js/frontend/country-select.min.js",
										["jquery"],
										true
									);
									wp_localize_script("wc-enhanced-select", "wc_enhanced_select_params", [
										"i18n_no_matches" => _x(
											"No matches found",
											"enhanced select",
											"woocommerce"
										),
										"i18n_ajax_error" => _x(
											"Loading failed",
											"enhanced select",
											"woocommerce"
										),
										"i18n_input_too_short_1" => _x(
											"Please enter 1 or more characters",
											"enhanced select",
											"woocommerce"
										),
										"i18n_input_too_short_n" => _x(
											"Please enter %qty% or more characters",
											"enhanced select",
											"woocommerce"
										),
										"i18n_input_too_long_1" => _x(
											"Please delete 1 character",
											"enhanced select",
											"woocommerce"
										),
										"i18n_input_too_long_n" => _x(
											"Please delete %qty% characters",
											"enhanced select",
											"woocommerce"
										),
										"i18n_selection_too_long_1" => _x(
											"You can only select 1 item",
											"enhanced select",
											"woocommerce"
										),
										"i18n_selection_too_long_n" => _x(
											"You can only select %qty% items",
											"enhanced select",
											"woocommerce"
										),
										"i18n_load_more" => _x(
											"Loading more results&hellip;",
											"enhanced select",
											"woocommerce"
										),
										"i18n_searching" => _x(
											"Searching&hellip;",
											"enhanced select",
											"woocommerce"
										),
										"ajax_url" => admin_url("admin-ajax.php"),
										"search_products_nonce" => wp_create_nonce("search-products"),
										"search_customers_nonce" => wp_create_nonce("search-customers"),
										"search_categories_nonce" => wp_create_nonce("search-categories"),
									]);
									$uat_custom_fields_seller_registration = get_option("options_uat_custom_fields_seller_registration", "no");
									if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == "yes") { ?>
										<div class="ua-switches-container" style="display:none">
											<input type="radio" id="switchbuyer" name="switchPlan" value="Buyer" />
											<input type="radio" id="switchseller" name="switchPlan" value="Seller" checked="checked" />
											<label for="switchbuyer"><?php _e("Buyer", "ultimate-auction-pro-software"); ?></label>
											<label for="switchseller"><?php _e("Seller", "ultimate-auction-pro-software"); ?></label>
											<div class="switch-wrapper">
												<div class="switch">
													<div><?php _e("Buyer", "ultimate-auction-pro-software"); ?></div>
													<div><?php _e("Seller", "ultimate-auction-pro-software"); ?></div>
												</div>
											</div>
										</div>
									<?php }
									$options_term_condition = get_option("options_uat_register_login_popup_uat_term_condition", "off");
									if (!empty($options_term_condition) && $options_term_condition == "on") {
										$uat_term_condition_txt = get_option("options_uat_register_login_popup_uat_term_condition_txt", ""); ?>
										<input type="checkbox" id="uat_term_condition" name="uat_term_condition" value="uat_term_condition">
										<label for="uat_term_condition"><?php echo $uat_term_condition_txt; ?>
											<span class="required">*</span> </label>
									<?php } ?>
									<div class="error-red"></div>
									<p class="status-reg"></p>
									<input class="submit_button" type="submit" value="<?php _e("Register", "ultimate-auction-pro-software"); ?>">
									<?php
									$social_enabled = get_option("options_registration_social_enabled", "disable");
									if (!empty($social_enabled) && $social_enabled == "enable") {
										if (class_exists("NextendSocialLogin", false)) {
											echo "<div class='abc'></div>";
											echo NextendSocialLogin::renderButtonsWithContainer();
										}
									}
									?>
								</form>
								<?php
								$wcfm_store = "";
								if (function_exists("get_wcfm_url")) {
									$wcfm_store = get_wcfm_url();
								}
								if ($wcfm_store != "") { ?>
									<h3 class="text-link"><?php _e("Already have a vendor account?", "ultimate-auction-pro-software"); ?>
										<a href="<?php echo $wcfm_store; ?>"><?php _e("Vendor login", "ultimate-auction-pro-software"); ?></a>
									</h3>
								<?php } ?>
							</div>
							<div style="display: none;" class="example4 fancybox-content" id="uat-login-form-success">
								<div class="popup-header">
									<div class="lt-right"><?php _e("Registration successful", "ultimate-auction-pro-software"); ?></div>
								</div>
								<div class="quick-link-phopup">
									<a class="btn submit_button" href="<?php echo home_url(); ?>/my-account/uat-stripe/"><?php _e("Register to bid", "ultimate-auction-pro-software"); ?></a>
									<?php $uat_custom_fields_seller_registration = get_option("options_uat_custom_fields_seller_registration", "no"); ?>
									<?php if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == "yes") { ?>
										<a class="btn submit_button" href="<?php echo home_url(); ?>/my-account/uat-stripe/"><?php _e("Sell your car", "ultimate-auction-pro-software"); ?></a>
									<?php } ?>
									<a class="btn submit_button" href="<?php echo home_url(); ?>"><?php _e("Continue browsing", "ultimate-auction-pro-software"); ?></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php }
}
add_action("wp_footer", "uat_footer_code_for_login_register_pupup");

/* Code for One Time Fee Payment in loop products  */
function uat_footer_code_for_one_time_fee_payemnt()
{
	?>
	<a data-fancybox data-src="#uat-onetime-fee-form" class="feeform" href="javascript:;"></a>
	<div style="display:none;" id="uat-onetime-fee-form" class="example4">
		<?php
		$image_ID = get_option("options_uat_website_logo");
		$popupLLogos = wp_get_attachment_image_src($image_ID, "full");
		$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . "logo.png";
		$popupLogo = isset($popupLLogos[0]) ? $popupLLogos[0] : $thumb_image_d;
		$options_field_options_to_place_bid_fee_popup_text = get_option(
			"options_field_options_to_place_bid_fee_popup_text",
			__(
				"You need to pay a fee before placing your first bid on the website. After successful payment, you can place any number of bids on any product on the website.",
				"ultimate-auction-pro-software"
			)
		);

		$options_field_options_to_place_bid_fee_popup_btn_text = get_option(
			"options_field_options_to_place_bid_fee_popup_btn_text",
			__("Pay now", "ultimate-auction-pro-software")
		);
		?>
		<img src="<?php echo $popupLogo; ?>" />
		<div class='onetime-popup'>
			<p class='onetime-popup-text'><?php echo $options_field_options_to_place_bid_fee_popup_text; ?></p>
			<?php
			$product_id = get_the_ID();
			$checkout_url = fee_checkout_url($product_id);
			if ($checkout_url != "") {
				echo '<a href="' .
					$checkout_url .
					'" class="btn" >
					' .
					$options_field_options_to_place_bid_fee_popup_btn_text .
					'
					</a>';
			} else {
				echo '<a href="" class="btn onetimeFeePay" >
					' .
					$options_field_options_to_place_bid_fee_popup_btn_text .
					'
					</a>';
			}
			?>
			<span class='onetime-popup-msg'></span>
			<div class="blog_loader" id="loader_ajax_for_fee" style="display:none; height:80px; width:80px; ">
				<img src="<?php echo UAT_THEME_PRO_IMAGE_URI .
								"ajax_loader.gif"; ?>" alt="Loading..." />
			</div>
		</div>
	</div>
<?php
}
$uat_fee_to_place_bid = get_option("options_uat_fee_to_place_bid", "off");
if ($uat_fee_to_place_bid == "on") {
	add_action("wp_footer", "uat_footer_code_for_one_time_fee_payemnt");
}

/* Display outbid message on screen  */
function uat_footer_code_for_display_outbidMsg()
{
?>
	<div style="display:none;" id="uat-msgbox" class="example5">
		<div id="uat-msgbox-message">
			<div class="msgbox-title" id="outbidMsg"></div>
			<div class="msgbox-text"></div>
		</div>
	</div>
	<a data-fancybox data-src="#uat-msgbox" class="msgbox" href="javascript:;"></a>
<?php
}
add_action("wp_footer", "uat_footer_code_for_display_outbidMsg");

/* Display outbid message on screen  */
function uat_footer_code_for_popup_bidding()
{
?>
	<div class="popup-main" style="display: none; width: auto; " id="uat-bid-box" class="example6 fancybox-content">
		<div class="popup-inner-m" id="uat-bid-box-inner" data-user-id="<?php echo get_current_user_id(); ?>" data-auction-id="">
			<div class="popup-inner">
				<div class="popup-top">
					<div class="pro-img-m" id="pop_img">
						<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>front/product_single_one_default.png" />
					</div>
					<div class="pro-info product-current-bid">
						<h2 id="pop_product_title"></h2>
						<div class="pro-price current-bid" id="pop_product_title_current_bid"></div>
					</div>
				</div>


				<div class="popup-bottom">
					<div class="pro-detail-row">
						<div class="pd-l">
							<label><?php _e(
										"Lot closes",
										"ultimate-auction-pro-software"
									); ?>:</label>
						</div>
						<div class="pd-r">
							<small id="lot_closes"></small>
						</div>
					</div>
					<div class="pro-detail-row">
						<div class="pd-l">
							<label><?php _e(
										"Starting bid",
										"ultimate-auction-pro-software"
									); ?>:</label>
							<small id="bid_count_msg_dis"></small>
						</div>
						<div class="pd-r">
							<label id="starting_bid_dis"></label>
						</div>
					</div>
					<div class="pro-detail-row">
						<div class="pd-l">
							<label><?php _e(
										"Next Minimum Bid",
										"ultimate-auction-pro-software"
									); ?>:</label>
						</div>
						<div class="pd-r">
							<label id="next_minimum_bid"></label>
						</div>
					</div>
					<div class="pro-detail-row" id="max_bid_dis">
						<div class="pd-l">
							<label id="set_your_max_bid_dis"></label>
						</div>
						<div class="pd-r">
							<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="lock" class="svg-inline--fa fa-lock fa-w-14 ItemBiddingAbsentee__StyledLockIcon-sc-20yfl8-6 bkhYfT" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="height: 14px;width: 14px;">
								<path fill="currentColor" d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" style="width: 20px;height: 220px;"></path>
							</svg>
							<label><?php _e(
										"Secure",
										"ultimate-auction-pro-software"
									); ?></label>
						</div>
					</div>

					<div class="pro-detail-row">
						<div class="row-flex-m">
							<div class="col-m">
								<label><?php _e(
											"Direct Bid",
											"ultimate-auction-pro-software"
										); ?></label>

								<input type="number" class="pop_bid_directly_input" name="pop_bid_directly_input" id="pop_bid_directly_input" data-current-bid="151" min="151" step="1">


								<button class="black_bg_btn" id="pop_bid_directly_btn"><?php _e(
																							"Place bid",
																							"ultimate-auction-pro-software"
																						); ?></button>
							</div>
							<div class="col-m" id="automatic_bid_dis">
								<label><?php _e(
											"Place an automatic bid!",
											"ultimate-auction-pro-software"
										); ?></label>

								<input type="number" class="pop_max_bid_directly_input" name="pop_max_bid_directly_input" id="pop_max_bid_directly_input" data-max-bid="150" data-is-max="1" min="150" step="1">
								<button class="black_bg_btn" id="pop_max_bid_directly_btn"><?php _e(
																								"Automatic bid",
																								"ultimate-auction-pro-software"
																							); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	$uat_bid_place_warning = get_option("options_uat_bid_place_warning", "on");
	$uat_fee_to_place_bid = get_option("options_uat_fee_to_place_bid", "off");
	$biding_enable = check_for_one_time_fee();
	?>
	<?php if (!is_product()) { ?>
		<script>
			var biding_enable = '<?php echo $biding_enable; ?>'
			var product_id = '';
			var currency_symbol = '<?php echo get_woocommerce_currency_symbol(); ?>';
			jQuery("a.onetimeFeePay").on('click', function(event) {
				jQuery("#loader_ajax_for_fee").show();
				event.preventDefault();
				jQuery.ajax({
					url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
					type: "post",
					data: {
						action: "woocommerce_ajax_add_to_cart",
						product_id: product_id,
					},
					success: function(data) {
						if (data.order_create == 1) {
							window.location.href = data.checkout_url;
						}
						if (data.order_create == 3) {
							location.reload();
						}
					},
					error: function() {}
				});

			});

			jQuery(document).on("click", "#pop_bid_directly_btn", function() {

				event.preventDefault();
				var bid_directly_input = jQuery("#pop_bid_directly_input");
				var auction_id = bid_directly_input.attr('data-auction-id');
				if (biding_enable != '1') {
					product_id = auction_id;
					document.querySelector('.feeform').click();
					return false;
				}

				var current_bid = bid_directly_input.attr('data-current-bid');
				var uwa_bid_value = bid_directly_input.val();

				<?php if (!is_user_logged_in()) {

					$menu_link_types = get_option(
						"options_menu_link_types",
						"menu_open_in_popup"
					);
					$message = sprintf(
						__(
							"Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>",
							"ultimate-auction-pro-software"
						),
						get_permalink(wc_get_page_id("myaccount"))
					);
					if ($menu_link_types == "menu_open_in_direct_link") {
						$message = sprintf(
							__(
								"Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>",
								"ultimate-auction-pro-software"
							),
							get_permalink(wc_get_page_id("myaccount"))
						);
					}
					$bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid user", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						$message .
						"</div>";
				?>

					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();
					return false;

				<?php
				} ?>
				if (!uwa_bid_value) {
					<?php $bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid bid amount", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						__("Please enter bid amount", "ultimate-auction-pro-software") .
						"</div>"; ?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();

					return false;
				}
				if (parseFloat(uwa_bid_value) < parseFloat(current_bid)) {
					<?php $bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid bid amount", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						__(
							"Please enter bid value greater than the next bid value",
							"ultimate-auction-pro-software"
						) .
						"</div>"; ?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();

					return false;
				}
				<?php if ($uat_bid_place_warning == "on") { ?>
					var getcon = pop_confirm_bid("uat_auction_form", uwa_bid_value);

					if (getcon) {

					<?php } ?>

					jQuery.ajax({
						url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
						type: "post",

						data: {
							action: "uat_user_place_bid_ajax",
							auction_id: product_id,
							uwa_bid_value: uwa_bid_value,
							bidtype: "directbid",
						},
						success: function(data) {

							document.querySelector('#uat-msgbox-message').innerHTML = data;
							document.querySelector('.msgbox').click();

							bid_directly_input.val("");

						},
						error: function() {}

					});
					<?php if ($uat_bid_place_warning == "on") { ?>
					}
				<?php } ?>

			});


			// start auctomaticbid bid
			jQuery(document).on('click', "#pop_max_bid_directly_btn", function(event) {
				event.preventDefault();
				var bid_directly_input = jQuery("#pop_max_bid_directly_input");
				var auction_id = bid_directly_input.attr('data-auction-id');
				if (biding_enable != '1') {
					product_id = auction_id;
					document.querySelector('.feeform').click();
					return false;
				}
				var current_bid = bid_directly_input.attr('data-max-bid');
				var uwa_bid_value = bid_directly_input.val();
				<?php if (!is_user_logged_in()) {

					$menu_link_types = get_option(
						"options_menu_link_types",
						"menu_open_in_popup"
					);
					$message = sprintf(
						__(
							"Please Login/Register to place your bid or buy the product. <a data-fancybox data-src='#uat-login-form' href='javascript:;'  target='_blank'  class='button'>Login/Register &rarr;</a>",
							"ultimate-auction-pro-software"
						),
						get_permalink(wc_get_page_id("myaccount"))
					);
					if ($menu_link_types == "menu_open_in_direct_link") {
						$message = sprintf(
							__(
								"Please Login/Register to place your bid or buy the product. <a href='%s' target='_blank'  class='button'>Login/Register &rarr;</a>",
								"ultimate-auction-pro-software"
							),
							get_permalink(wc_get_page_id("myaccount"))
						);
					}
					$bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid user", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						$message .
						"</div>";
				?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();
					return false;

				<?php
				} ?>
				if (!uwa_bid_value) {
					<?php $bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid bid amount", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						__("Please enter automatic bid amount", "ultimate-auction-pro-software") .
						"</div>"; ?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();
					return false;
				}
				if (parseFloat(current_bid) > parseFloat(uwa_bid_value)) {
					<?php $bidvallue_msg =
						"<div class='msgbox-title msgbox-title-red' id='outbidMsg'>" .
						__("Invalid bid amount", "ultimate-auction-pro-software") .
						"</div><div class='msgbox-text'>" .
						__(
							"Please enter bid value greater than the next bid value",
							"ultimate-auction-pro-software"
						) .
						"</div>"; ?>
					document.querySelector('#uat-msgbox-message').innerHTML = "<?php echo uat_bid_message_in_popup(
																					$bidvallue_msg
																				); ?>";
					document.querySelector('.msgbox').click();
					return false;
				}
				<?php if ($uat_bid_place_warning == "on") { ?>
					var getcon = pop_confirm_bid("uat_auction_form_max", uwa_bid_value);

					if (getcon) {

					<?php } ?>

					jQuery.ajax({
						url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
						type: "post",

						data: {
							action: "uat_user_place_bid_ajax",
							auction_id: product_id,
							uwa_bid_value: uwa_bid_value,
							bidtype: "maxbidchange",
						},
						success: function(data) {

							document.querySelector('#uat-msgbox-message').innerHTML = data;
							document.querySelector('.msgbox').click();

							bid_directly_input.val("");

						},
						error: function() {}

					});
					<?php if ($uat_bid_place_warning == "on") { ?>
					}
				<?php } ?>
			});



			function pop_confirm_bid(formname, id_Bid) {
				if (id_Bid != "") {
					if (formname == "uat_auction_form") {
						<?php $confirm1 = __("Do you really want to bid", "ultimate-auction-pro-software"); ?>
						var confirm1 = "<?php echo uat_bid_message_in_popup($confirm1); ?>";

					}
					if (formname == "uat_auction_form_max") {

						<?php $confirm1 = __(
							"Do you really want to change your maximum bid",
							"ultimate-auction-pro-software"
						); ?>
						var confirm1 = "<?php echo uat_bid_message_in_popup($confirm1); ?>";
					}

					var confirm_message = confirm1 + ' ' + decodeHTML(currency_symbol) + id_Bid + ' ?';
					var result_conf = confirm(confirm_message);
					if (result_conf == false) {
						event.preventDefault(); /* don't use return it reloads page */
					} else {
						return true;
					}
				}

			}
			var decodeHTML = function(html) {
				var txt = document.createElement('textarea');
				txt.innerHTML = html;
				return txt.value.trim();
			};
		</script>
	<?php } ?>
<?php

}
$uat_bid_pop_on_list_page = get_option(
	"options_uat_bid_pop_on_list_page",
	"off"
);
if ($uat_bid_pop_on_list_page == "on") {
	add_action("wp_footer", "uat_footer_code_for_popup_bidding");
}
