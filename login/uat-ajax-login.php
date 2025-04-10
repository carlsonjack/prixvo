<?php
if (!is_user_logged_in()) {
	add_action('init', 'uat_theme_ajax_auth_init');	
	add_action( 'register_form', 'uat_theme_registration_form' );
	/*Validation*/
	add_filter('registration_errors', 'uat_theme_registration_validate_errors', 10, 3);
	/*Save user data*/
	add_action('user_register', 'uat_theme_registration_save_user_data');
}



function uat_theme_registration_form() {
		global $wpdb;
		$options_uwt_enable_firstname_lastname_on_reg_page = get_option( 'options_uwt_enable_firstname_lastname_on_reg_page'); 
		if(!empty($options_uwt_enable_firstname_lastname_on_reg_page) && $options_uwt_enable_firstname_lastname_on_reg_page == 'enable'){  
		$billing_first_name = ( ! empty( $_POST['billing_first_name'] ) ) ? trim( $_POST['billing_first_name'] ) : '';
		$billing_last_name = ( ! empty( $_POST['billing_last_name'] ) ) ? trim( $_POST['billing_last_name'] ) : '';
        ?>
        <p>
            <label for="billing_first_name"><?php _e( 'First Name', 'ultimate-auction-pro-software' ) ?></label>
			<input type="text" name="billing_first_name" id="billing_first_name" class="input" value="<?php echo esc_attr( wp_unslash( $billing_first_name ) ); ?>" size="25" />
        </p>

        <p>
            <label for="billing_last_name"><?php _e( 'Last Name', 'ultimate-auction-pro-software' ) ?></label>
			<input type="text" name="billing_last_name" id="billing_last_name" class="input" value="<?php echo esc_attr( wp_unslash( $billing_last_name ) ); ?>" size="25" />
        </p>
		<?php		
		}
		?>
		<?php
		$uat_custom_fields_seller_registration = get_option('options_uat_custom_fields_seller_registration', 'no');
		if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == 'yes') { ?>
	
		<p class="form-row form-row-wide" style="display:none">
			<strong><?php _e('Become a ', "ultimate-auction-pro-software"); ?></strong>
		</p>
		<div class="ua-switches-container" style="display:none">								
			<input type="radio" id="switchbuyer" name="switchPlan" value="Buyer"  />
			<input type="radio" id="switchseller" name="switchPlan" value="Seller" checked="checked"/>
			<label for="switchbuyer">Buyer</label>
			<label for="switchseller">Seller</label>
			<div class="switch-wrapper">
			<div class="switch">
				<div>Buyer</div>
				<div>Seller</div>
			</div>
			</div>
		</div>
		<?php } ?>


		<?php	
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
				if(!empty($TPublishableKey) ){  ?>
					<h4 class="form-row form-row-wide">
						<strong><?php _e( 'Enter your Credit Card Details:', 'ultimate-auction-pro-software' ); ?></strong>					
					</h4>					
					<p class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'Card Number', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="example3-card-number" class="field empty"> </i></span></div>
					</p>
					<div class="form-row form-custom-row">
					<div class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'Expiration', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="example3-card-expiry" class="field empty third-width"> </i></span></div>
					</div>
					<div class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'CVV', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
						<div id="example3-card-cvc" class="field empty third-width"><span class="input__icon">
					<i class="far fa-credit-card"></i>
					</span></div>
					</div>
					</div>
					<p class="status-reg"></p>
					<p id="uwa-card-errors"></p>
					<?php
						try {
							$pubkey = "";
							$braintree = new Uat_Auction_Braintree();
							
							$pubkey = $braintree->getClientToken();

							wp_enqueue_script('jquery');
							wp_enqueue_script('uwa-braintree', 'https://js.braintreegateway.com/web/3.85.5/js/hosted-fields.min.js');
							wp_enqueue_script('uwa-braintree-client', 'https://js.braintreegateway.com/web/3.85.5/js/client.min.js');
							wp_enqueue_script('uat-braintree-default-WP-form', UAT_THEME_PRO_JS_URI . 'braintree/braintree-default-form.js',array(), null );
							wp_localize_script('uat-braintree-default-WP-form', 'braintree_vars',array('source_key' => $pubkey,'invalid_card_details_msg' => __("Please enter valid card details", 'ultimate-auction-pro-software')));
						} catch (\Throwable $th) {
							//throw $th;
						}
				}
					
			}
			if($paymentGateway == 'stripe'){
				
				$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types',  'uat_stripe_test_mode', 'uat_stripe_test_mode' );
				if($StripePaymentModeTypes=='uat_stripe_live_mode'){
					$TPublishableKey = get_option( 'options_uat_stripe_live_publishable_key' );
				}else{
					$TPublishableKey = get_option( 'options_stripe_test_publishable_key' );
				}
				if(!empty($TPublishableKey) ){  ?>
					<h4 class="form-row form-row-wide">
						<strong><?php _e( 'Enter your Credit Card Details:', 'ultimate-auction-pro-software' ); ?></strong>
					</h4>
					<p class="form-row form-row-wide">
						<label for="card-element"><?php _e( 'Card Number', 'ultimate-auction-pro-software' ); ?><span class="required">*</span></label>
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
				<p class="status-reg"></p>
				<p id="uwa-card-errors"></p>
				<?php
					$pubkey = $TPublishableKey;
					wp_enqueue_script('jquery');
					wp_enqueue_script('uwa-stripe', 'https://js.stripe.com/v3/');
					wp_enqueue_script('stripe-default-form-js', UAT_THEME_PRO_JS_URI . 'stripe/stripe-default-form.js',array(), null );
					wp_localize_script('stripe-default-form-js', 'stripe_vars',array('publishable_key' => $pubkey));
				}
			}
		}
	$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
	$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
	if($uat_need_registration_address_enabled == "enable"){ ?>
			<p class="form-row form-row-wide">
				<strong><?php _e( 'Billing details', "ultimate-auction-pro-software" ); ?></strong>
			</p>

   		<?php     	global $woocommerce;
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

		}
		?>
		<input type="hidden" name="uwa_stripe_k_id" value="" id="uwa_stripe_k_id"/>
		<input type="hidden" name="uwa_braintree_k_id" value="" id="uwa_braintree_k_id"/>
		<p class="form-row validate-required terms-condition">
		<input type="checkbox" id="terms" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox vh" name="terms" <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?>/>
		<label class="checkbox" for="terms"><?php wc_terms_and_conditions_checkbox_text(); ?><span class="required">*</span></label>
		<input type="hidden" name="terms-field" value="<?php echo esc_attr( 'terms', 'ultimate-auction-pro-software' ); ?>" />
		</p>
		<style>
		
	#registerform div#uwa-card-number, #registerform div#uwa-card-expiry, #registerform div#uwa-card-cvc {
    font-size: 24px;
    line-height: 1.33333333;
    width: 100%;
    margin: 0 6px 11px 0;
    min-height: 28px;
    padding: 10px 0 0 7px;
    max-height: none;
    direction: ltr;
    box-shadow: 0 0 0 transparent;
    border-radius: 4px;
    border: 1px solid #8c8f94;
    color: #2c3338;
    vertical-align: middle;
    max-width: 97%;
}
.login form .input, .login input[type=password], .login input[type=text]{
    font-size: 16px!important;
}
p.form-row.form-row-wide.address-field select {
    width: 100%;
}
p.form-row.form-row-wide label {
    display: block;
    line-height: 1.5;
    margin-bottom: 3px;
}
#registerform p#billing_phone_field span.woocommerce-input-wrapper input#billing_phone {
    min-height: 40px;
    width: 100%;
    margin-bottom: 15px;
}

.wp-core-ui #registerform select{max-width: 100%;min-height: 40px}
.login form#registerform .input, .login #registerform input[type=password], .login #registerforminput[type=text] {
    font-size: 16px;
}
/* custom seller byer CSS */

.ua-switches-container {
		width: 100%;
		position: relative;
		display: flex;
		padding: 0;
		position: relative;
		background: #000;
		line-height: 16px;
		font-size: 16px;
		border-radius: 3rem;
		margin-left: auto;
		margin-right: auto;
		height: 44px;
	}
	.ua-switches-container input {
		visibility: hidden;
		position: absolute;
		top: 0;
	}
	.ua-switches-container label {
		width: 50%;
		padding: 0 45px;
		margin: 0;
		text-align: center;
		cursor: pointer;
		color: #fff;
		height: 100%;
		display: flex!important;
		align-items: center;
	}
	.switch-wrapper {
		position: absolute;
		top: 0px;
		bottom: 0;
		width: 50%;
		padding: 0.15rem;
		z-index: 3;
		transition: transform .5s cubic-bezier(.77, 0, .175, 1);
	}
	.ua-switches-container .switch {
		border-radius: 3rem;
		background: #fff;
		height: 40px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.ua-switches-container .switch div {
		width: 100%;
		text-align: center;
		opacity: 0;
		display: flex;
		color: #000;
		transition: opacity .2s cubic-bezier(.77, 0, .175, 1) .125s;
		will-change: opacity;
		position: absolute;
		top: 0;
		left: 0;
		align-items: center;
		justify-content: center;
		height: 100%;
	}
	.ua-switches-container input:nth-of-type(1):checked~.switch-wrapper {
		transform: translateX(0%);
	}
	.ua-switches-container input:nth-of-type(2):checked~.switch-wrapper {
		transform: translateX(100%);
	}
	.ua-switches-container input:nth-of-type(1):checked~.switch-wrapper .switch div:nth-of-type(1) {
		opacity: 1;
	}
	.ua-switches-container input:nth-of-type(2):checked~.switch-wrapper .switch div:nth-of-type(2) {
		opacity: 1;
	}

/* END */ 

		</style>
<?php
}
function uat_theme_registration_validate_errors($errors, $sanitized_user_login, $user_email) {
	
	
	$options_uwt_enable_firstname_lastname_on_reg_page = get_option( 'options_uwt_enable_firstname_lastname_on_reg_page'); 
	if(!empty($options_uwt_enable_firstname_lastname_on_reg_page) && $options_uwt_enable_firstname_lastname_on_reg_page == 'enable'){
			 if ( empty( $_POST['billing_first_name'] ) || ! empty( $_POST['billing_first_name'] ) && trim( $_POST['billing_first_name'] ) == '' ) {
            $errors->add( 'first_name_error', __( '<strong>ERROR</strong>: You must include a first name.', 'ultimate-auction-pro-software' ) );
			}
			if ( empty( $_POST['billing_last_name'] ) || ! empty( $_POST['billing_last_name'] ) && trim( $_POST['billing_last_name'] ) == '' ) {
				$errors->add( 'last_name_error', __( '<strong>ERROR</strong>: You must include a last name.', 'ultimate-auction-pro-software' ) );
			}
	}	
	
	$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
	$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
	if($uat_need_registration_address_enabled == "enable"){
		if ( empty( $_POST['billing_country'] ) )
			$errors->add( 'billing_country_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('You must choose the country.','ultimate-auction-pro-software') );
		elseif(empty($_POST['billing_address_1']))
		$errors->add( 'billing_address_1_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('Please Enter address.','ultimate-auction-pro-software') );
		elseif(empty($_POST['billing_postcode']))
		$errors->add( 'billing_postcode_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('Please Enter pincode.','ultimate-auction-pro-software') );
		elseif(!empty($_POST['billing_postcode']) && !(preg_match('/^[a-zA-Z0-9 ]*$/', $_POST['billing_postcode'])))
		$errors->add( 'billing_postcode_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('Please enter a valid zip code.','ultimate-auction-pro-software') );		

	}
	if($registration_phone_enabled == "enable"){
	   if(empty($_POST['billing_phone']))
		$errors->add( 'billing_phone_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('Please enter valid phone number.','ultimate-auction-pro-software') );
		elseif(!empty($_POST['billing_phone']) && !(preg_match('/^[0-9 +-]{10,15}$/', $_POST['billing_phone'])))
		$errors->add('billing_phone_error', '<strong>'.__('ERROR','ultimate-auction-pro-software').'</strong>: '.__('Please enter valid phone number.','ultimate-auction-pro-software'));
	}
	
	$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
	if($paymentGateway == 'braintree'){
		$braintreePaymentModeTypes = get_option( 'options_uat_braintree_mode_types' , 'uat_braintree_test_mode' );
		if($braintreePaymentModeTypes=='uat_braintree_live_mode'){
			$TPublishableKey = get_option( 'options_uat_braintree_live_public_key', "" );
		}else{
			$TPublishableKey = get_option( 'options_uat_braintree_test_public_key', "" );
		}
		if(!empty($TPublishableKey) ){			
			if(empty($_POST['uwa_braintree_k_id']))			
			$errors->add( 'uwa_braintree_card_error', __( '<strong>Your Payment Information not valid. Please check and fill correct payment information.</strong>','ultimate-auction-pro-software' ));
			}			
	}else{
		$myAcountcardIsEnable = get_option( 'options_uwt_stripe_card_myaccount_page', 'disable' );
		$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types',  'uat_stripe_test_mode' );
		if($StripePaymentModeTypes=='uat_stripe_live_mode'){
			$TPublishableKey = get_option( 'options_uat_stripe_live_publishable_key' );
		}else{
			$TPublishableKey = get_option( 'options_stripe_test_publishable_key' );
		}
		if(!empty($TPublishableKey) && !empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable'){

			if(empty($_POST['uwa_stripe_k_id']))
			$errors->add( 'uwa_stripe_card_error', __( '<strong>Your Payment Information not valid. Please check and fill correct payment information.</strong>','ultimate-auction-pro-software' ));

		}
	}


return $errors;


}
function uat_theme_registration_save_user_data($user_id) {
	global $wpdb;
	if(isset($_GET['action']) && $_GET['action'] == 'register' )
	{
		$user_info = get_userdata($user_id);

		if (isset($_POST['switchPlan'])) {
			$user = new WP_User($user_id);
			if (!empty($_POST['switchPlan'])) {								
				$switchPlan = $_POST['switchPlan'];
				if($switchPlan == "Seller"){
					$seller_user = $user->set_role( UAT_SELLER_ROLE_KEY );
					update_user_meta($user_id, $seller_user , $switchPlan);
				}else{																			
					update_user_meta($user_id, $user->set_role( 'customer' ), $switchPlan);
				}									
			}
		}

		$username = $user_info->user_login;
		$user_email = $user_info->user_email;				
		$options_uwt_enable_firstname_lastname_on_reg_page = get_option( 'options_uwt_enable_firstname_lastname_on_reg_page'); 
	    if(!empty($options_uwt_enable_firstname_lastname_on_reg_page) && $options_uwt_enable_firstname_lastname_on_reg_page == 'enable'){
			if ( ! empty( $_POST['billing_first_name'] ) ) {
				update_user_meta( $user_id, 'billing_first_name', trim( $_POST['billing_first_name'] ) );
				update_user_meta( $user_id, 'shipping_first_name', trim( $_POST['billing_first_name'] ) );
			}
			if ( ! empty( $_POST['billing_last_name'] ) ) {
				update_user_meta( $user_id, 'billing_last_name', trim( $_POST['billing_last_name'] ) );
				update_user_meta( $user_id, 'shipping_last_name', trim( $_POST['billing_last_name'] ) );
			}
			 update_user_meta( $user_id, 'first_name', trim( $_POST['billing_first_name'] ) );
			 update_user_meta( $user_id, 'last_name', trim( $_POST['billing_last_name'] ) );
		  } else {
			 update_user_meta($user_id, 'billing_first_name', $username );
			 update_user_meta($user_id, 'billing_last_name', $username );
			 update_user_meta($user_id, 'shipping_first_name', $username );
			 update_user_meta($user_id, 'shipping_last_name', $username );
			 update_user_meta( $user_id, 'first_name', $username );
			 update_user_meta( $user_id, 'last_name', $username );
			 
		  }
			
		$billing_country = isset($_POST['billing_country']) ? $_POST['billing_country'] : "";
		if(!empty($billing_country)){
			update_user_meta( $user_id, 'billing_country', $billing_country );
		}
		$billing_address_1 = isset($_POST['billing_address_1']) ? $_POST['billing_address_1'] : "";
		if(!empty($billing_address_1)){
			update_user_meta( $user_id, 'billing_address_1', $billing_address_1 );
		}
		$billing_address_2 = isset($_POST['billing_address_2']) ? $_POST['billing_address_2'] : "";
		if(!empty($billing_address_2)){
			update_user_meta( $user_id, 'billing_address_2', $billing_address_2 );
		}
		$billing_city = isset($_POST['billing_city']) ? $_POST['billing_city'] : "";
		if(!empty($billing_city)){
			update_user_meta( $user_id, 'billing_city', $billing_city );
		}
		$billing_state = isset($_POST['billing_state']) ? $_POST['billing_state'] : "";
		if(!empty($billing_state)){
			update_user_meta( $user_id, 'billing_state', $billing_state );
		}
		$billing_postcode = isset($_POST['billing_postcode']) ? $_POST['billing_postcode'] : "";
		if(!empty($billing_postcode)){
			update_user_meta( $user_id, 'billing_postcode', $billing_postcode );
		}
		$billing_phone = isset($_POST['billing_phone']) ? $_POST['billing_phone'] : "";
		if(!empty($billing_phone)){
			update_user_meta( $user_id, 'billing_phone', $billing_phone );
		}
		$myAcountcardIsEnable = get_option( 'options_uwt_stripe_card_myaccount_page', 'disable' );
		$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
		$customer_id=$user_id;
		if($paymentGateway == 'stripe'){
			$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types',  'uat_stripe_test_mode' );
			if($StripePaymentModeTypes=='uat_stripe_live_mode'){
				$publishable_key = get_option( 'options_uat_stripe_live_publishable_key' );
				$secret_key = get_option( 'options_uat_stripe_live_secret_key' );
			}else{
				$publishable_key = get_option( 'options_stripe_test_publishable_key' );
				$secret_key = get_option( 'options_uat_stripe_test_secret_key' );
			}
			if(!empty($secret_key) && !empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable'){
				\Stripe\Stripe::setApiKey($secret_key);				
				if(!empty($customer_id)){
					$sources_id = $_POST['uwa_stripe_k_id'];
					$username = $user_info->user_login;
					$user_email = $user_info->user_email;
						$customer = \Stripe\Customer::create([
										'email' => strip_tags(trim($user_email)),
										'source' => $sources_id,
										'name' => $username,
										]);
										$customer->save();
										$stripe = new \Stripe\StripeClient($secret_key);
										$customer = $stripe->customers->retrieve(
											$customer->id,
											[]
										);
										
										$newcardadd = $stripe->customers->retrieveSource(
											$customer->id,
											$customer->default_source,
											[]
										  );
										  
										$card_meta_array['gateway_id'] = $paymentGateway;
										$card_meta_array['token'] = $customer->default_source;
										$card_meta_array['last4'] =   $newcardadd->card->last4;
										$card_meta_array['expiry_year'] =   $newcardadd->card->exp_year;
										$card_meta_array['expiry_month'] =  $newcardadd->card->exp_month;
										$card_meta_array['card_type'] =   $newcardadd->card->brand;
										$card_meta_array['user_id'] = $customer_id;
										$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);

						if (!empty($customer->id)) {
							update_user_meta( $customer_id, $wpdb->prefix.'_stripe_customer_id', $customer->id );
						}
				}
			}
		}else{
				if(!empty($customer_id) && isset($_REQUEST['uwa_braintree_k_id'])){
					$sources_id = $_REQUEST['uwa_braintree_k_id'];
					try {
						$braintree = new Uat_Auction_Braintree();
						$braintree_customer = $braintree->createCustomer();
						if (!empty($braintree_customer->id)) {
										$card_meta_array['gateway_id'] = "braintree";
										$card_meta_array['token'] = $braintree_customer->paymentMethods[0]->token;
										$card_meta_array['last4'] =  $braintree_customer->paymentMethods[0]->last4;
										$card_meta_array['expiry_year'] = $braintree_customer->paymentMethods[0]->expirationYear;
										$card_meta_array['expiry_month'] =  $braintree_customer->paymentMethods[0]->expirationMonth;
										$card_meta_array['card_type'] = $braintree_customer->paymentMethods[0]->cardType;
										$card_meta_array['user_id'] = $customer_id;
										$card_meta_array['is_default'] = '1';
							$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
							update_user_meta( $customer_id, $wpdb->prefix.'_braintree_customer_id', $braintree_customer->id );
						}
					} catch (\Throwable $th) {
					}
				}
			}
	}

}
function uat_theme_ajax_auth_init(){
wp_register_script('validate-script', UAT_THEME_PRO_JS_URI . 'login/jquery.validate.js', array('jquery') );
wp_enqueue_script('validate-script');
wp_register_script('uat-login-auth', UAT_THEME_PRO_JS_URI . 'login/uat-login-auth.js', array('jquery'),time() );
wp_enqueue_script('uat-login-auth');
wp_localize_script( 'uat-login-auth', 'ajax_auth_object', array(
	'ajaxurl' => admin_url( 'admin-ajax.php' ),
	'redirecturl' => "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
	'loadingmessage' => __('Sending user info, please wait...','ultimate-auction-pro-software'),
	'requiredmessage' => __('This field is required.','ultimate-auction-pro-software'),
	'requiredmessageemail' => __('Please enter a valid email address.','ultimate-auction-pro-software'),
));
add_action( 'wp_ajax_nopriv_uat_theme_ajaxlogin', 'uat_theme_ajaxlogin_callback' );
add_action( 'wp_ajax_nopriv_uat_theme_ajaxregister', 'uat_theme_ajaxregister_callback' );
}

function uat_theme_ajaxlogin_callback(){
uat_auth_user_login($_POST['username'], $_POST['password'], 'Login');
die();
}
add_action( 'wp_ajax_nopriv_uat_theme_ajaxregister_acount', 'uat_theme_ajaxregister_acount_callback' );
add_action( 'wp_ajax_uat_theme_ajaxregister_acount', 'uat_theme_ajaxregister_acount_callback' );
function uat_theme_ajaxregister_acount_callback(){
	global $wpdb;
	$uwa_stripe_k_id = $_POST['uwa_stripe_k_id']??"";
	$customer_id = get_current_user_id();
	$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
	if($paymentGateway == 'stripe'){
		$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types',  'uat_stripe_test_mode' );
		if($StripePaymentModeTypes=='uat_stripe_live_mode'){
			$publishable_key = get_option( 'options_uat_stripe_live_publishable_key' );
			$secret_key = get_option( 'options_uat_stripe_live_secret_key' );
		}else{
			$publishable_key = get_option( 'options_stripe_test_publishable_key' );
			$secret_key = get_option( 'options_uat_stripe_test_secret_key' );
		}
			
		$logger = wc_get_logger();
		$gateway = "";
			try {
				$Uat_Auction_Payment = new Uat_Auction_Payment();
				$gateway = $Uat_Auction_Payment->gateway;
			} catch (\Throwable $th) {
				//throw $th;
			}
		
		if(!empty($secret_key)){
			\Stripe\Stripe::setApiKey($secret_key);
			if(!empty($customer_id) && isset($_POST['uwa_stripe_k_id'])){
				
				try {
					$sources_id = $_POST['uwa_stripe_k_id'];
					$customer_stripe_id = get_user_meta($customer_id, $wpdb->prefix . '_stripe_customer_id', true);

							if(empty($customer_stripe_id)){

								$user_info = get_userdata($customer_id);
								$customer = \Stripe\Customer::create([
									'email' => strip_tags(trim($user_info->user_email)),
									'source' => $sources_id,
									'name' => strip_tags(trim($user_info->first_name))." ".strip_tags(trim($user_info->last_name)),
								]);

								$customer->save();
								update_user_meta( $customer_id, $wpdb->prefix.'_stripe_customer_id', $customer->id );
								$customer_stripe_id = $customer->id;
							}else{
								 // Attach the new source to the customer
								$customer = \Stripe\Customer::createSource(
									$customer_stripe_id,
									['source' => $sources_id]
								);
							}
							
							$stripe = new \Stripe\StripeClient($secret_key);
							$customer = $stripe->customers->retrieve(
								$customer_stripe_id,
								[]
							);

							$newcardadd = $stripe->customers->retrieveSource(
								$customer_stripe_id,
								$sources_id,
								[]
								);
							$card_meta_array['gateway_id'] = $gateway;
							$card_meta_array['token'] = $sources_id;
							$card_meta_array['last4'] =   $newcardadd->card->last4;
							$card_meta_array['expiry_year'] =   $newcardadd->card->exp_year;
							$card_meta_array['expiry_month'] =  $newcardadd->card->exp_month;
							$card_meta_array['card_type'] =   $newcardadd->card->brand;
							$card_meta_array['user_id'] = $customer_id;
							$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);

					if (!empty($customer->id)) {
						update_user_meta( $customer_id, $wpdb->prefix.'_stripe_customer_id', $customer->id );
					}
					echo json_encode(array('card_added'=>true, 'message'=>__('Card added successfully','ultimate-auction-pro-software')));
					die();
				} catch (\Exception $th) {
					echo json_encode(array('card_added'=>false, 'message'=>__('The card was not added; something is wrong.','ultimate-auction-pro-software')));
					die();

				}
			}
		}
		echo json_encode(array('card_added'=>false, 'message'=>__('The card was not added; something is wrong.','ultimate-auction-pro-software')));
		die();

	}
    
	die();

	
}
function uat_theme_ajaxregister_callback(){
global $wpdb;
$info = array();
$info['user_login'] = esc_attr($_POST['username']);
$info['user_nicename'] = sanitize_user($_POST['username']);
$info['nickname'] =   sanitize_user($_POST['username']) ;
$info['display_name'] = sanitize_user($_POST['firstName'])." ".sanitize_text_field($_POST['lastName']);
$info['first_name'] = sanitize_text_field($_POST['firstName']) ;
$info['last_name'] = sanitize_text_field($_POST['lastName']) ;
$info['user_pass'] =  esc_attr($_POST['password']);
$info['user_email'] = sanitize_email( $_POST['email']);
$info['role'] = sanitize_text_field( $_POST['switchPlan']);
if(!empty($_POST['uwa_stripe_k_id'])){
	$info['uwa_stripe_k_id'] = $_POST['uwa_stripe_k_id'];
}
$user_register = wp_insert_user( $info );

if (isset($_POST['switchPlan'])) {
	$user = new WP_User($user_register);
	if (isset($_POST['switchPlan']) && !empty($_POST['switchPlan'])) {								
		$switchPlan = $_POST['switchPlan'];								
		if($switchPlan == "Seller"){
			$seller_user = $user->set_role( UAT_SELLER_ROLE_KEY );
			update_user_meta($user_register, $seller_user , $switchPlan);
		}else{																			
			update_user_meta($user_register, $user->set_role( 'customer' ), $switchPlan);
		}									
	}
}

  
if ( is_wp_error($user_register) ){
	$error  = $user_register->get_error_codes()	;
	if(in_array('empty_user_login', $error))
		echo json_encode(array('loggedin'=>false, 'message'=>__($user_register->get_error_message('empty_user_login'))));
	elseif(in_array('existing_user_login',$error))
		echo json_encode(array('loggedin'=>false, 'message'=>__('This username is already registered.','ultimate-auction-pro-software')));
	elseif(in_array('existing_user_email',$error))
	echo json_encode(array('loggedin'=>false, 'message'=>__('This email address is already registered.','ultimate-auction-pro-software')));
} else {
	$first_name = isset($_POST['firstName']) ? $_POST['firstName'] : "";
	if(!empty($first_name)){
		update_user_meta( $user_register, 'billing_first_name', $first_name );
		update_user_meta( $user_register, 'shipping_first_name', $first_name );
		update_user_meta( $user_register, 'first_name', $first_name );
	}
     $last_name = isset($_POST['lastName']) ? $_POST['lastName'] : "";
	if(!empty($last_name)){
		update_user_meta( $user_register, 'billing_last_name', $last_name );
		update_user_meta( $user_register, 'shipping_last_name', $last_name );
		update_user_meta( $user_register, 'last_name', $last_name );
	}
	
	$billing_country = isset($_POST['billing_country']) ? $_POST['billing_country'] : "";
	if(!empty($billing_country)){
		update_user_meta( $user_register, 'billing_country', $billing_country );
	}
	$billing_address_1 = isset($_POST['billing_address_1']) ? $_POST['billing_address_1'] : "";
	if(!empty($billing_address_1)){
		update_user_meta( $user_register, 'billing_address_1', $billing_address_1 );
	}
	$billing_address_2 = isset($_POST['billing_address_2']) ? $_POST['billing_address_2'] : "";
	if(!empty($billing_address_2)){
		update_user_meta( $user_register, 'billing_address_2', $billing_address_2 );
	}
	$billing_city = isset($_POST['billing_city']) ? $_POST['billing_city'] : "";
	if(!empty($billing_city)){
		update_user_meta( $user_register, 'billing_city', $billing_city );
	}
	$billing_state = isset($_POST['billing_state']) ? $_POST['billing_state'] : "";
	if(!empty($billing_state)){
		update_user_meta( $user_register, 'billing_state', $billing_state );
	}
	$billing_postcode = isset($_POST['billing_postcode']) ? $_POST['billing_postcode'] : "";
	if(!empty($billing_postcode)){
		update_user_meta( $user_register, 'billing_postcode', $billing_postcode );
	}
	$billing_phone = isset($_POST['billing_phone']) ? $_POST['billing_phone'] : "";
	if(!empty($billing_phone)){
		update_user_meta( $user_register, 'billing_phone', $billing_phone );
	}
		
	$myAcountcardIsEnable = get_option( 'options_uwt_stripe_card_myaccount_page', 'disable' );
		$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
		if(!empty($myAcountcardIsEnable) && $myAcountcardIsEnable=='enable'){
			$customer_id=$user_register;
			if($paymentGateway == 'stripe'){
				$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types',  'uat_stripe_test_mode' );
				if($StripePaymentModeTypes=='uat_stripe_live_mode'){
					$publishable_key = get_option( 'options_uat_stripe_live_publishable_key' );
					$secret_key = get_option( 'options_uat_stripe_live_secret_key' );
				}else{
					$publishable_key = get_option( 'options_stripe_test_publishable_key' );
					$secret_key = get_option( 'options_uat_stripe_test_secret_key' );
				}
				if(!empty($secret_key)){
					\Stripe\Stripe::setApiKey($secret_key);
					if(!empty($customer_id) && isset($_POST['uwa_stripe_k_id'])){
						try {
							$sources_id = $_POST['uwa_stripe_k_id'];
							$customer = \Stripe\Customer::create([
											'email' => strip_tags(trim($_POST['email'])),
											'source' => $sources_id,
											'name' => strip_tags(trim($_POST['firstName']))." ".strip_tags(trim($_POST['lastName'])),
											]);
											$stripe = new \Stripe\StripeClient($secret_key);
											$customer = $stripe->customers->retrieve(
												$customer->id,
												[]
											);
											$customer->save();
											$card_meta_array['token'] = $customer->default_source;
											$card_meta_array['last4'] =  $customer->sources->data[0]->card->last4;
											$card_meta_array['expiry_year'] = $customer->sources->data[0]->card->exp_year;
											$card_meta_array['expiry_month'] =  $customer->sources->data[0]->card->exp_month;
											$card_meta_array['card_type'] = $customer->sources->data[0]->card->brand;
											$card_meta_array['user_id'] = $customer_id;
											$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
							if (!empty($customer->id)) {
								update_user_meta( $customer_id, $wpdb->prefix.'_stripe_customer_id', $customer->id );
							}
						} catch (\Throwable $th) {

						}
					}
				}
			}else{
				if(!empty($customer_id) && isset($_REQUEST['uwa_braintree_k_id'])){
					$sources_id = $_REQUEST['uwa_braintree_k_id'];
					try {
						$braintree = new Uat_Auction_Braintree();
						$braintree_customer = $braintree->createCustomer();
						if (!empty($braintree_customer->id)) {
										$card_meta_array['gateway_id'] = "braintree";
										$card_meta_array['token'] = $braintree_customer->paymentMethods[0]->token;
										$card_meta_array['last4'] =  $braintree_customer->paymentMethods[0]->last4;
										$card_meta_array['expiry_year'] = $braintree_customer->paymentMethods[0]->expirationYear;
										$card_meta_array['expiry_month'] =  $braintree_customer->paymentMethods[0]->expirationMonth;
										$card_meta_array['card_type'] = $braintree_customer->paymentMethods[0]->cardType;
										$card_meta_array['user_id'] = $customer_id;
										$card_meta_array['is_default'] = '1';
							$wpdb->insert($wpdb->prefix . 'ua_auction_payment_cards', $card_meta_array);
							update_user_meta( $customer_id, $wpdb->prefix.'_braintree_customer_id', $braintree_customer->id );
						}
					} catch (\Throwable $th) {
					}
				}
			}
		}
		$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
		$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
		if(!empty($approval) && $approval=='enable'){
			update_user_meta( $user_register, "uat_is_approved", "pending" );
		}
	 if(!empty($confirmation) && $confirmation=='enable'){
		$check_email = new EmailTracking();
		$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_register,$email_type='registration_confirm');
		if( !$email_status )
		{
			$uat_Email = new RegistrationConfirmMail();
			$uat_Email->registration_confirm_email($user_register);
		}
		uat_auth_user_login_need_confirm($info['user_login'], $info['user_pass'], 'Registration');
	}elseif(!empty($approval) && $approval=='enable'){
		uat_auth_user_login_need_confirm($info['user_login'], $info['user_pass'], 'Registration');		}
	else {
		 uat_auth_user_login($info['user_login'], $info['user_pass'], 'Registration');
	}
}
die();
}
function uat_auth_user_login($user_login, $password, $login)
{
$info = array();
$info['user_login'] = $user_login;
$info['user_password'] = $password;
$info['remember'] = true;
$user_signon = wp_signon( $info, false );
if ( is_wp_error($user_signon) ){
	$error_string = $user_signon->get_error_message();
	echo json_encode(array('loggedin'=>false, 'message'=>__($error_string)));
}
else {
	wp_set_current_user($user_signon->ID);
	echo json_encode(array('loggedin'=>true, 'message'=>__($login.' successful, redirecting...')));
}
die();
}
function uat_auth_user_login_need_confirm($user_login, $password, $login)
{
$info = array();
$info['user_login'] = $user_login;
$info['user_password'] = $password;
$info['remember'] = true;
$user_signon = wp_signon( $info, false );
$is_confirmed = get_user_meta( $user_signon->ID, 'uat_is_confirmed' , true );
if ( is_wp_error($user_signon) ){
	$error_string = $user_signon->get_error_message();
	$error_codes = $user_signon->get_error_codes();
	$error_code = $error_codes[0];
	if($error_code =="uat_not_confirmed"){
		$error_string = __("We have sent an email with a confirmation link to your email address.",'ultimate-auction-pro-software');
	}
	if($error_code =="uat_rejected_user"){
		$error_string = __("Your Account rejected by Admin. Please contact to admin for more.",'ultimate-auction-pro-software');
	}
	if($error_code =="uat_not_approved"){
		$error_string = __("User has not been activated.",'ultimate-auction-pro-software');
	}
	echo json_encode(array('loggedin'=>false, 'message'=>$error_string));
} else {
	wp_set_current_user($user_signon->ID);
	echo json_encode(array('loggedin'=>true, 'message'=>__($login.' successful, redirecting...')));
}
die();
}