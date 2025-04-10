<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
do_action( 'woocommerce_before_customer_login_form' ); ?>
<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
<div class="u-columns col2-set" id="customer_login">
	<div class="u-column1 col-1">
<?php endif; ?>
		<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
		<form class="woocommerce-form woocommerce-form-login login" method="post">
			<?php do_action( 'woocommerce_login_form_start' ); ?>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="username"><?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" placeholder="<?php esc_html_e( 'Username or email address', 'woocommerce' ); ?>" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				<span class="input__icon"><i class="fa fa-user"></i></span>
			</p>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" placeholder="<?php esc_html_e( 'Password', 'woocommerce' ); ?>" name="password" id="password" autocomplete="current-password" />
				<span class="input__icon"><i class="fa fa-lock"></i></span>
			</p>
			<?php do_action( 'woocommerce_login_form' ); ?>
			<div class="form-row custom-row">
				<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="<?php echo esc_attr( 'forever', 'ultimate-auction-pro-software' ); ?>" />
					<span><?php esc_html_e( 'Remember me', 'woocommerce' ); ?></span>
				</label>
				<div class="woocommerce-LostPassword lost_password">
						<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'woocommerce' ); ?></a>
				</div>
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<div class="d-flex align-item-center justify-center"><button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>"><?php esc_html_e( 'Log in', 'woocommerce' ); ?>
				</button></div>
			</div>
			<?php do_action( 'woocommerce_login_form_end' ); ?>
		</form>
<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
	</div>
	<div class="u-column2 col-2">
		<h2><?php esc_html_e( 'Register Now', 'ultimate-auction-pro-software' ); ?></h2>
<div class="example3" >
		<form method="post" id="ctm-woocommerce-form-register" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >
			<?php do_action( 'woocommerce_register_form_start' ); ?>
			<?php
			$uat_custom_fields_seller_registration = get_option('options_uat_custom_fields_seller_registration', 'no');
			if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == 'yes') { ?>
	
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide" style="display:none">
				<strong><?php _e('Become a ', "ultimate-auction-pro-software"); ?></strong>
			</p>
			<div class="ua-switches-container">								
				<input type="radio" id="switchbuyer" name="switchPlan" value="Buyer"  />
				<input type="radio" id="switchseller" name="switchPlan" value="Seller" checked="checked" />
				<label for="switchbuyer"><?php _e('Buyer', "ultimate-auction-pro-software"); ?></label>
				<label for="switchseller"><?php _e('Seller', "ultimate-auction-pro-software"); ?></label>
				<div class="switch-wrapper">
				<div class="switch">
					<div><?php _e('Buyer', "ultimate-auction-pro-software"); ?></div>
					<div><?php _e('Seller', "ultimate-auction-pro-software"); ?></div>
				</div>
				</div>
			</div>
			<?php } ?>
			
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text reg_username" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" required /><?php // @codingStandardsIgnoreLine ?>
					<span class="input__icon"><i class="fa fa-user"></i></span>
				</p>
			<?php endif; ?>
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" placeholder="Email address" class="woocommerce-Input woocommerce-Input--text input-text reg_email" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" required  /><?php // @codingStandardsIgnoreLine ?>
				<span class="input__icon"><i class="fa fa-envelope"></i></span>
			</p>
			
			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text reg_password" name="password" id="reg_password" required autocomplete="new-password" />
					<span class="input__icon"><i class="fa fa-lock"></i></span>
				</p>
			<?php else : ?>
				<div><strong><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></strong></div>
			<?php endif;
			$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
			$myAcountcardIsEnable = get_option( 'options_uwt_stripe_card_myaccount_page', 'disable' );
			if(!empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable'){
				if($paymentGateway == 'braintree'){
					
					$braintreePaymentModeTypes = get_option( 'options_uat_braintree_mode_types' , 'uat_braintree_test_mode' );
					if($braintreePaymentModeTypes=='uat_braintree_live_mode'){
						$TPublishableKey = get_option( 'options_uat_braintree_live_public_key', "" );
					}else{
						$TPublishableKey = get_option( 'options_uat_braintree_test_public_key', "" );
					}
					if(!empty($TPublishableKey)){  ?>
						<h4 class="form-row form-row-wide">
							<strong><?php _e( 'Enter your Credit Card Details:', 'ultimate-auction-pro-software' ); ?></strong>
						</h4>
						<p class="form-row form-row-wide">
							<label for="card-element"><?php _e( 'Credit Card Number', 'ultimate-auction-pro-software' ); ?>
							<span class="required">*</span></label>
							<div id="uwa-card-number" class="field empty" style="height: 50px;"> </div>
						</p>
						<div class="form-row form-custom-row">
						<div class="form-row form-row-wide">
							<label for="card-element"><?php _e( 'Expiration', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
							<div id="uwa-card-expiry" class="field empty third-width"  style="height: 50px;"></div>
						</div>
						<div class="form-row form-row-wide">
							<label for="card-element"><?php _e( 'CVV', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
							<div id="uwa-card-cvc" class="field empty third-width"  style="height: 50px;"></div>
						</div>
						</div>
					<?php } ?>
					<p id="uwa-card-errors"></p>
					<?php
						if(!empty($TPublishableKey) ){
							try {
								$pubkey = "";
								$braintree = new Uat_Auction_Braintree();
								$pubkey = $braintree->getClientToken();

								wp_enqueue_script('jquery');
								wp_enqueue_script('uwa-braintree', 'https://js.braintreegateway.com/web/3.85.5/js/hosted-fields.min.js');
								wp_enqueue_script('uwa-braintree-client', 'https://js.braintreegateway.com/web/3.85.5/js/client.min.js');
								wp_enqueue_script('uat-braintree-my-account', UAT_THEME_PRO_JS_URI . 'braintree/uat-braintree-my-account.js',array(), null );
								wp_localize_script('uat-braintree-my-account', 'braintree_vars',array('source_key' => $pubkey,'invalid_card_details_msg' => __("Please enter valid card details", 'ultimate-auction-pro-software')));
							} catch (\Throwable $th) {
								//throw $th;
						}
						}
				}
				if($paymentGateway == 'stripe'){
				
					$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types' , 'uat_stripe_test_mode' );
					if($StripePaymentModeTypes=='uat_stripe_live_mode'){
						$TPublishableKey = get_option( 'options_uat_stripe_live_publishable_key' );
					}else{
						$TPublishableKey = get_option( 'options_stripe_test_publishable_key' );
					}
					?>
					<?php if(!empty($TPublishableKey) && !empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable'){  ?>
					<h4 class="form-row form-row-wide">
						<strong><?php _e( 'Enter your Credit Card Details:', 'ultimate-auction-pro-software' ); ?></strong>
					</h4>
					<p class="form-row form-row-wide">
					<label for="card-element"><?php _e( 'Credit Card Number', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="uwa-card-number" class="field empty"> </i></span></div>
					</p>
					<div class="form-row form-custom-row">
					<div class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'Expiration', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="uwa-card-expiry" class="field empty third-width"> </i></span></div>
					</div>
					<div class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'CVV', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="uwa-card-cvc" class="field empty third-width"><span class="input__icon">
					<i class="far fa-credit-card"></i>
					</span></div>
					</div>
					</div>
					<?php } ?>
					<p id="uwa-card-errors"></p>
					<?php
						if(!empty($TPublishableKey) && !empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable' ){
							$pubkey = $TPublishableKey;
							wp_enqueue_script('jquery');
							wp_enqueue_script('uwa-stripe', 'https://js.stripe.com/v3/');
							wp_enqueue_script('uat-stripe-my-account', UAT_THEME_PRO_JS_URI . 'stripe/uat-stripe-my-account.js',array(), null );
							wp_localize_script('uat-stripe-my-account', 'stripe_vars',array('publishable_key' => $pubkey));
						}
				}
			}
				$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
				$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
				if($uat_need_registration_address_enabled == "enable"){
			?>
				<p class="form-row form-row-wide">
					<strong><?php _e( 'Billing details', "ultimate-auction-pro-software" ); ?></strong>
				</p>
			<?php
				}
				global $woocommerce;
				$checkout = $woocommerce->checkout();
				foreach ( $checkout->get_checkout_fields( 'billing' ) as $key => $field ) {
					if($key=='billing_phone' && $registration_phone_enabled == "enable"){
						woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
					}
					if($uat_need_registration_address_enabled == "enable"){
						if($key=='billing_address_1' || $key=='billing_address_2' || $key=='billing_city' || $key=='billing_country' || $key=='billing_state' || $key=='billing_postcode' ){
							woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
						}
					}
				}
				// add address javascript from default woocommerce
				wp_enqueue_script('wc-country-select', get_site_url().'/wp-content/plugins/woocommerce/assets/js/frontend/country-select.min.js', array('jquery'), true);
				wp_localize_script(
					'wc-enhanced-select',
					'wc_enhanced_select_params',
					array(
						'i18n_no_matches'           => _x( 'No matches found', 'enhanced select', 'woocommerce' ),
						'i18n_ajax_error'           => _x( 'Loading failed', 'enhanced select', 'woocommerce' ),
						'i18n_input_too_short_1'    => _x( 'Please enter 1 or more characters', 'enhanced select', 'woocommerce' ),
						'i18n_input_too_short_n'    => _x( 'Please enter %qty% or more characters', 'enhanced select', 'woocommerce' ),
						'i18n_input_too_long_1'     => _x( 'Please delete 1 character', 'enhanced select', 'woocommerce' ),
						'i18n_input_too_long_n'     => _x( 'Please delete %qty% characters', 'enhanced select', 'woocommerce' ),
						'i18n_selection_too_long_1' => _x( 'You can only select 1 item', 'enhanced select', 'woocommerce' ),
						'i18n_selection_too_long_n' => _x( 'You can only select %qty% items', 'enhanced select', 'woocommerce' ),
						'i18n_load_more'            => _x( 'Loading more results&hellip;', 'enhanced select', 'woocommerce' ),
						'i18n_searching'            => _x( 'Searching&hellip;', 'enhanced select', 'woocommerce' ),
						'ajax_url'                  => admin_url( 'admin-ajax.php' ),
						'search_products_nonce'     => wp_create_nonce( 'search-products' ),
						'search_customers_nonce'    => wp_create_nonce( 'search-customers' ),
						'search_categories_nonce'   => wp_create_nonce( 'search-categories' ),
					)
				);
			?>
				<input type="hidden" name="uwa_stripe_k_id" value="" id="uwa_stripe_k_id"/>
				<input type="hidden" name="uwa_braintree_k_id" value="" id="uwa_braintree_k_id"/>
				<p class="form-row validate-required terms-condition">
					<input type="checkbox" id="terms" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox vh" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?>/>
                    <label class="checkbox" for="terms"><?php wc_terms_and_conditions_checkbox_text(); ?><span class="required">*</span></label>
					<input type="hidden" name="terms-field" value="<?php echo esc_attr( 'terms', 'ultimate-auction-pro-software' ); ?>" />
				</p>
	    	<div class="clear"></div>
			<div class="clear"></div>
			<?php do_action( 'woocommerce_register_form' ); ?>
			<p class="woocommerce-form-row form-row">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" id="uat-woo-reg" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
			</p>
			<?php do_action( 'woocommerce_register_form_end' ); ?>
		</form>
		</div>
	</div>
</div>
<?php endif; ?>
<?php do_action( 'woocommerce_after_customer_login_form' ); ?>