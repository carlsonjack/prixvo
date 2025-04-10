<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ultimate_Auction
 */


/* Auction Product saved shop/loop */
add_action('woocommerce_after_shop_loop_item','uat_theme_saved_icon_in_loop_fun', 60);
function uat_theme_saved_icon_in_loop_fun() {	
	global $product;		
		if (method_exists( $product, 'get_type') && $product->get_type() == 'auction') {	
			echo '<div class="saved-icon loop">';
			wc_get_template('loop/uat-auction-saved.php'); 
			echo '</div>';
		}
	}

add_action( 'woocommerce_after_single_product', 'uat_theme_set_view_count_products' );
/**
 * Set view counts for all products once viewed
 */
function uat_theme_set_view_count_products() {
	global $product;
	$post_id  = $product->get_id();
	$count_key = 'uat_product_view_count';
	$count     = get_post_meta( $post_id, $count_key, true );
	if ( $count == '' ) {
		delete_post_meta( $post_id, $count_key );
		update_post_meta( $post_id, $count_key, '1' );
	} else {
		$count ++;
		update_post_meta( $post_id, $count_key, (string) $count );
	}
}
	/* Total Bids Place Section On Auction Detail Page */
	if( get_option( 'options_uat_auction_bid_tab', 'on' ) == 'on' ) {
		add_action('woocommerce_product_tabs', 'uat_auction_bids_tab', 10);
	}
	/**
	 * Add Bids Tab Single Page.
	 */
	 function uat_auction_bids_tab($tabs) {
		global $product;
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
			$tabs['uat_auction_bids_history'] = array(
				'title' => __('Bids', 'ultimate-auction-pro-software'),
				'priority' => 25,
				'callback' => 'uat_auction_bids_tab_callback',
			);
		}
		return $tabs;
	}
	/**
	 * Auction call back from bids tab.
	 */
	 function uat_auction_bids_tab_callback($tabs) {
		wc_get_template('single-product/tabs/bids-history.php');
	}
	/* Total Bid increments Tab Section On Auction Detail Page */
	if( get_option( 'options_uat_auction_bid_increments_tab',"on" ) == 'on' ) {
		add_action('woocommerce_product_tabs', 'uat_auction_bid_increments_tab', 10);
	}
	/**
	 * Add Bid increments Tab Single Page.
	 */
	 function uat_auction_bid_increments_tab($tabs) {
		global $product;
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
			$tabs['uat_auction_bids_increments'] = array(
				'title' => __('Bid increments', 'ultimate-auction-pro-software'),
				'priority' => 25,
				'callback' => 'uat_auction_bid_increments_tab_callback',
			);
		}
		return $tabs;
	}
	/**
	 * Auction call back from Bid increments Tab.
	 */
	 function uat_auction_bid_increments_tab_callback($tabs) {
		wc_get_template('single-product/tabs/bid-increment.php');
	}
	/* Total BUYER'S PREMIUM Tab Section On Auction Detail Page */
	if( get_option( 'options_uat_auction_buyers_premium_tab',"on" ) == 'on' ) {		
		add_action('woocommerce_product_tabs', 'uat_auction_buyers_premium_tab', 10);
	}
	/**
	 * Add BUYER'S PREMIUM Tab Single Page.
	 */
	 function uat_auction_buyers_premium_tab($tabs) {
		global $product;
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
			$tabs['uat_auction_buyers_premium'] = array(
				'title' => __("Buyer's Premium", 'ultimate-auction-pro-software'),
				'priority' => 25,
				'class' => array(
                    'show_if_auction',
                    'hide_if_grouped',
                    'hide_if_external',
                    'hide_if_variable',
                    'hide_if_simple'
                ) ,
				'callback' => 'uat_auction_buyers_premium_tab_callback',
			);
		}
		return $tabs;
	}
	/**
	 * Auction call back from BUYER'S PREMIUM.
	 */
	 function uat_auction_buyers_premium_tab_callback($tabs) {
		wc_get_template('single-product/tabs/buyers-premium.php');
	}
	/* Total Terms & conditions Tab Section On Auction Detail Page */
	if( get_option( 'options_single_terms_conditions_tab',"off" ) == 'on' ) {
		add_action('woocommerce_product_tabs', 'uat_auction_terms_conditions_tab', 10);
	}
	/**
	 * Add Terms & conditions Tab Single Page.
	 */
	 function uat_auction_terms_conditions_tab($tabs) {
		global $product;
		if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
			$tabs['uat_auction_terms_conditions'] = array(
				'title' => __("Terms & conditions", 'ultimate-auction-pro-software'),
				'priority' => 25,
				'class' => array(
                    'show_if_auction',
                    'hide_if_grouped',
                    'hide_if_external',
                    'hide_if_variable',
                    'hide_if_simple'
                ) ,
				'callback' => 'uat_auction_terms_conditions_tab_callback',
			);
		}
		return $tabs;
	}
	/**
	 * Auction call back from Terms & conditions.
	 */
	 function uat_auction_terms_conditions_tab_callback($tabs) {
		wc_get_template('single-product/tabs/terms-conditions.php');
	}
	/**
	 * Registration on my account page.
	 */
	global $wpdb;
	$StripeIsEnable = get_option( 'options_uwt_stripe_card_myaccount_page', 'disable' );
	$paymentGateway = get_option( 'options_uat_payment_gateway', 'stripe' );
	if($paymentGateway == 'braintree'){
		$StripePaymentModeTypes = get_option( 'options_uat_braintree_mode_types' , 'uat_braintree_test_mode' );
		if($StripePaymentModeTypes=='uat_braintree_live_mode'){
			$braintree_mode = "production";
			$braintree_merchantId = get_option( 'options_uat_braintree_live_merchant_id', "" );
			$braintree_publicKey = get_option( 'options_uat_braintree_live_public_key', "" );
			$braintree_privateKey = get_option( 'options_uat_braintree_live_private_key', "" );
		}else{
			$braintree_mode = "sandbox";
			$braintree_merchantId = get_option( 'options_uat_braintree_test_merchant_id', "" );
			$braintree_publicKey = get_option( 'options_uat_braintree_test_public_key', "" );
			$braintree_privateKey = get_option( 'options_uat_braintree_test_private_key', "" );
		}
		if (!empty($braintree_mode) && !empty($braintree_merchantId) && !empty($braintree_publicKey) && !empty($braintree_privateKey) && !empty($StripeIsEnable) && $StripeIsEnable=='enable') {
			add_action( 'woocommerce_registration_errors', 'uat_stripe_wc_register_form_validate', 10, 3);
			add_action( 'woocommerce_created_customer', 'uat_braintree_wc_register_form_fields_save');
		}
		function uat_stripe_wc_register_form_validate( $errors, $username, $email ) {
			if (empty( $_POST["uwa_braintree_k_id"]) ) {
				$errors->add( 'uwa_stripe_card_error', __( '<strong>Your Payment Information is not valid. Please check and fill correct payment information.</strong>','ultimate-auction-pro-software' ));
			}
			return $errors;
		}
	}else{
		$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types', 'uat_stripe_test_mode' );
		if($StripePaymentModeTypes=='uat_stripe_live_mode'){
			$publishable_key = get_option( 'options_uat_stripe_live_publishable_key' );
			$secret_key = get_option( 'options_uat_stripe_live_secret_key' );
		}else{
			$publishable_key = get_option( 'options_stripe_test_publishable_key' );
			$secret_key = get_option( 'options_uat_stripe_test_secret_key' );
		}
		if(!empty($secret_key) && !empty($StripeIsEnable) && $StripeIsEnable=='enable'){
			add_action( 'woocommerce_registration_errors', 'uat_stripe_wc_register_form_validate', 10, 3);
			add_action( 'woocommerce_created_customer', 'uat_stripe_wc_register_form_fields_save');
		}
		function uat_stripe_wc_register_form_validate( $errors, $username, $email ) {
			if (empty( $_POST["uwa_stripe_k_id"]) ) {
				$errors->add( 'uwa_stripe_card_error', __( '<strong>Your Payment Information is not valid. Please check and fill correct payment information.</strong>','ultimate-auction-pro-software' ));
			}
			return $errors;
		}
	}
	function uat_stripe_wc_register_form_fields_save( $customer_id ) {
		global $wpdb;
		if ( isset( $_POST['uwa_stripe_k_id'] ) ) {
			if ( !empty( $_POST['uwa_stripe_k_id'] ) ) {
				$StripePaymentModeTypes = get_option( 'options_uat_stripe_mode_types', 'uat_stripe_test_mode' );
				if($StripePaymentModeTypes=='uat_stripe_live_mode'){
					$publishable_key = get_option( 'options_uat_stripe_live_publishable_key' );
					$secret_key = get_option( 'options_uat_stripe_live_secret_key' );
				}else{
					$publishable_key = get_option( 'options_stripe_test_publishable_key' );
					$secret_key = get_option( 'options_uat_stripe_test_secret_key' );
				}
				$gateway = "";
				try {
					$Uat_Auction_Payment = new Uat_Auction_Payment();
					$gateway = $Uat_Auction_Payment->gateway;
				} catch (\Throwable $th) {
					//throw $th;
				}
				\Stripe\Stripe::setApiKey($secret_key);
				if(!empty($customer_id)){
					$sources_id = $_POST['uwa_stripe_k_id'];
					$customer = \Stripe\Customer::create([
									'email' => strip_tags(trim($_POST['email'])),
									'source' => $sources_id,
									'name' => strip_tags(trim($_POST['username'])),
									]);
									$customer->save();
									$stripe = new \Stripe\StripeClient($secret_key);
									$customer = $stripe->customers->retrieve($customer->id,[]);
									
									
									$newcardadd = $stripe->customers->retrieveSource(
										$customer->id,
										$customer->default_source,
										[]
									  );

									$card_meta_array['gateway_id'] = $gateway;
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
				$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
				$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
				if(!empty($approval) && $approval=='enable'){
					update_user_meta( $customer_id, "uat_is_approved", "pending" );
				}
			}
		}
	}
	function uat_braintree_wc_register_form_fields_save( $customer_id ) {
		global $wpdb;
			if ( isset( $_REQUEST['uwa_braintree_k_id'] ) ) {
			
				if(!empty($customer_id)){
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
						//throw $th;
					}
				}
				$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
				$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
				if(!empty($approval) && $approval=='enable'){
					update_user_meta( $customer_id, "uat_is_approved", "pending" );
				}
			}
	}

	// phone and address validation on register
	$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
	$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
	if( $registration_phone_enabled == "enable" || $uat_need_registration_address_enabled == "enable")
	{
		add_action( 'woocommerce_created_customer', 'register_save_phone_address_fields');
		add_action( 'woocommerce_registration_errors', 'validate_phone_address_register', 10, 3);
		// Checking & validation of the phone and address field in registration form.
		function validate_phone_address_register( $errors, $username, $email ){
			global $woocommerce;
			$address = $_POST;
			$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
			$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
			foreach ($address as $key => $field) :
				// Validation: Required fields

				if($key == 'billing_phone' && $field == '' && $registration_phone_enabled == "enable"){

					  $errors->add( 'billing_phone_error', __( ' Please enter phone number', 'ultimate-auction-pro-software' ) );
				}
				if( $uat_need_registration_address_enabled == "enable" ){
					if($key == 'billing_country' && $field == ''){

						$errors->add( 'billing_country_error', __( ' Please select a country', 'ultimate-auction-pro-software' ) );
					 }
					 if($key == 'billing_address_1' && $field == ''){

						  $errors->add( 'billing_address_1_error', __( ' Please enter address', 'ultimate-auction-pro-software' ) );
					 }
					 if($key == 'billing_city' && $field == ''){

						  $errors->add( 'billing_city_error', __( ' Please enter city', 'ultimate-auction-pro-software' ) );
					 }

					 if($key == 'billing_postcode' && $field == ''){

						  $errors->add( 'billing_postcode_error', __( ' Please enter a postcode', 'ultimate-auction-pro-software' ) );
					 }
				}

			endforeach;
			return $errors;
		}
		// Save the phone and address field in registration form.
		function register_save_phone_address_fields( $customer_id ){
			global $woocommerce;
			$address = $_POST;
			$registration_phone_enabled = get_option( 'options_uat_need_registration_phone_enabled', 'disable' );
			$uat_need_registration_address_enabled = get_option( 'options_uat_need_registration_address_enabled', 'disable' );
			foreach ($address as $key => $field){
				$new_key = explode('billing_', $key);
				if($key == 'billing_phone' && $registration_phone_enabled == "enable"){
					$new_key = explode('billing_', $key);
					update_user_meta( $customer_id, $new_key[1], $_POST[$key] );
					$new_key = str_replace('billing_','shipping_',$key);
						update_user_meta( $customer_id, $new_key, $_POST[$key] );
				}
				if( $uat_need_registration_address_enabled == "enable" ){
					if($key=='billing_address_1' || $key=='billing_address_2' || $key=='billing_city' || $key=='billing_country' || $key=='billing_state' || $key=='billing_postcode' ){
						update_user_meta( $customer_id, $new_key[1], $_POST[$key] );
						$new_key = str_replace('billing_','shipping_',$key);
						update_user_meta( $customer_id, $new_key, $_POST[$key] );
					}
				}
				update_user_meta( $customer_id, $key, $_POST[$key] );
			}
		}
	}

remove_action( 'woocommerce_before_single_product', 'woocommerce_output_all_notices', 10 );
// ADDING 2 after total on orders list admin side
add_filter( 'manage_edit-shop_order_columns', 'uat_custom_shop_order_column', 20 );
function uat_custom_shop_order_column($columns)
{
    $reordered_columns = array();
    foreach( $columns as $key => $column){
        $reordered_columns[$key] = $column;
        if( $key ==  'order_total' ){
            // Inserting after "Total" column
            $reordered_columns['uat_customer_name'] = __( 'Customer Name','ultimate-auction-pro-software');
            $reordered_columns['uat_customer_email'] = __( 'Customer Email','ultimate-auction-pro-software');
        }
    }
    return $reordered_columns;
}
// Adding custom fields meta data for each new column (example)
add_action( 'manage_shop_order_posts_custom_column' , 'uat_custom_orders_list_column_content', 20, 2 );
function uat_custom_orders_list_column_content( $column, $post_id )
{
    switch ( $column )
    {
        case 'uat_customer_name' :
            // Get custom post meta data
			$winner_name="";
			$customer_id = get_post_meta( $post_id, '_customer_user', true );
			if(!empty($customer_id)) {
				$user = get_user_by('ID', $customer_id);
				 $winner_name = $user->data->display_name;
			}
            if(!empty($winner_name))
                echo $winner_name;
            // Testing (to be removed) - Empty value case
            else
                echo 'NA';
            break;
        case 'uat_customer_email' :
            // Get custom post meta data
			$winner_email="";
			$customer_id = get_post_meta( $post_id, '_customer_user', true );
			if(!empty($customer_id)) {
				$user = get_user_by('ID', $customer_id);
				$winner_email = $user->data->user_email;
			}
            if(!empty($winner_email))
                echo $winner_email;
            // Testing (to be removed) - Empty value case
            else
                echo 'NA';
            break;
    }
}
add_action( 'restrict_manage_posts', 'uat_display_admin_shop_order_language_filter' );
function uat_display_admin_shop_order_language_filter(){
    global $pagenow, $post_type;
    if( 'shop_order' === $post_type && 'edit.php' === $pagenow ) {
        $domain    = 'ultimate-auction-pro-software';
        $languages = array(__('Auctions Orders', $domain) );
        $current   = isset($_GET['filter_shop_order_auctions'])? $_GET['filter_shop_order_auctions'] : '';
        echo '<select name="filter_shop_order_auctions">
        <option value="">' . __('All Orders ', $domain) . '</option>';
        foreach ( $languages as $value ) {
            printf( '<option value="%s"%s>%s</option>', $value,
                $value === $current ? '" selected="selected"' : '', $value );
        }
        echo '</select>';
    }
}
add_action( 'pre_get_posts', 'uat_process_admin_shop_order_language_filter' );
function uat_process_admin_shop_order_language_filter( $query ) {
	global $pagenow;
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    if ( $query->is_admin && $pagenow == 'edit.php' && isset( $_GET['filter_shop_order_auctions'] ) && $_GET['filter_shop_order_auctions'] != '' && $_GET['post_type'] == 'shop_order' ) {
      $meta_key_query = array(
        array(
          'meta_key'     => 'auctions_order',
          'value'   => esc_attr( $_GET['filter_shop_order_auctions'] ),
        )
      );
      $query->set( 'meta_query', $meta_key_query );
    }
}



/**
 * @snippet       Add First & Last Name to My Account Register Form - WooCommerce
 */
  
///////////////////////////////
// 1. ADD FIELDS
 
$options_uwt_enable_firstname_lastname_on_reg_page = get_option( 'options_uwt_enable_firstname_lastname_on_reg_page'); 

if(!empty($options_uwt_enable_firstname_lastname_on_reg_page) && $options_uwt_enable_firstname_lastname_on_reg_page == 'enable'){  
	
	add_action( 'woocommerce_register_form_start', 'uwa_woo_add_name_woo_account_registration' );
	add_filter( 'woocommerce_registration_errors', 'uwa_woo_validate_name_fields', 10, 3 );
	add_action( 'woocommerce_created_customer', 'uwa_woo_save_name_fields' );

}
 
  
function uwa_woo_add_name_woo_account_registration() {
    ?>

    <p class="form-row form-row-first">
	<label for="reg_billing_first_name"><?php _e( 'First name', 'ultimate-auction-pro-software' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
    </p>
  
    <p class="form-row form-row-last">
    <label for="reg_billing_last_name"><?php _e( 'Last name', 'ultimate-auction-pro-software' ); ?> <span class="required">*</span></label>
    <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
  
     
  
    <?php
}
  
///////////////////////////////
// 2. VALIDATE FIELDS
  

  
function uwa_woo_validate_name_fields( $errors, $username, $email ) {
    if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
        $errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'ultimate-auction-pro-software' ) );
    }
    if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
        $errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'ultimate-auction-pro-software' ) );
    }
    return $errors;
}
  
///////////////////////////////
// 3. SAVE FIELDS  
function uwa_woo_save_name_fields( $customer_id ) {
    if ( isset( $_POST['billing_first_name'] ) ) {
        update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'shipping_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
        update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
    }
    if ( isset( $_POST['billing_last_name'] ) ) {
        update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'shipping_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
        update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
    }
  
}
add_action('woocommerce_created_customer', 'seller_registration_form_fields');
function seller_registration_form_fields($customer_id) {	
	//$user = get_user_by( 'ID', $customer_id );
	$user = new WP_User($customer_id);
	if (isset($_POST['switchPlan']) && !empty($_POST['switchPlan'])) {								
		$switchPlan = $_POST['switchPlan'];						
		if($switchPlan == "Seller"){
			//$seller_user = $user->set_role( UAT_SELLER_ROLE_KEY );
			update_user_meta($customer_id, $user->set_role( UAT_SELLER_ROLE_KEY ), $switchPlan);
		}else{																			
			update_user_meta($customer_id, $user->set_role( 'customer' ), $switchPlan);
		}									
	}
		
}