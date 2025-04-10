<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'wcfm_query_vars', 'uwa_wcb_wcfm_query_vars', 20 );
add_action( 'init','uwt_wcb_wcfm_init', 20, 2 );
add_filter( 'wcfm_menus', 'uwa_wcb_wcfm_menus', 20 );
add_filter('wcfm_product_types', 'uwa_vendor_support_add_product_type', 25 );
add_filter( 'wcfm_capability_settings_fields_product_types', 'uwa_vendor_support_auction_tab',20, 3);
add_action( 'wcfm_load_views', 'uwa_wcb_load_views');

function uwt_wcb_wcfm_init(){

	global $WCFM_Query;
	// Intialize WCFM End points
	$WCFM_Query->init_query_vars();
	$WCFM_Query->add_endpoints();
	
	if( !get_option( 'wcfm_updated_end_point_uwt_auctions' ) ) {
		// Flush rules after endpoint update
		flush_rewrite_rules();
		update_option( 'wcfm_updated_end_point_uwt_auctions', 1 );
	}
	
}
// Bookings Load WCFMu Styles
add_action( 'wcfm_load_styles',  'wcb_uwa_load_styles' , 30 );
add_action( 'after_wcfm_load_styles',  'wcb_uwa_load_styles' , 30 );

 function wcb_uwa_load_styles( $end_point ) {
  global $WCFM, $WCFMu;
	
//   switch( $end_point ) {
	  
// 	case 'uwt-auctionslist':
// 		wp_enqueue_style( 'wcfm_uwa_auctions_css',  plugin_dir_url( __FILE__ ). 'css/wcfm_uwa_auctions.css', array(), '1.0.1' );
// 	  break;
// 	case 'uwt-auction-detail':
// 		wp_enqueue_style( 'wcfm_uwa_auctions_css',  plugin_dir_url( __FILE__ ). 'css/wcfm_uwa_auctions.css', array(), '1.0.1' );
// 	  break; 
//   }
}
/* Register Auction Product Type */
function uwa_vendor_support_add_product_type($product_types){
	$product_types['auction'] =  __('Auction Product', 'ultimate-auction-pro-software');
	return $product_types;	
}


function uwa_wcb_wcfm_menus (  $menus ){
	global $WCFM;
	if( WCFM_Dependencies::wcfmu_plugin_active_check() ) {
		$menus = array_slice($menus, 0, 3, true) +
		array( 'wcfm-uwt-auctionslist' => array(   'label'  => __( 'Auctions', 'ultimate-auction-pro-software'),
		'url'       => get_wcfm_uwt_auction_url(),
		'icon'      => 'fa-gavel',
		'priority'  => 15
		) )	 +
		array_slice($menus, 3, count($menus) - 3, true) ;
	} else {
		$menus = array_slice($menus, 0, 3, true) +
		array( 'wcfm-uwt-auctionslist' => array(   'label'  => __( 'Auctions', 'ultimate-auction-pro-software'),
		'url'       => get_wcfm_uwt_auction_url(),
		'icon'      => 'fa-gavel',
		'priority'  => 15
		) )	 +
		array_slice($menus, 3, count($menus) - 3, true) ;
	}

  return $menus;
}
if(!function_exists('get_wcfm_uwt_auction_url')) {
	function get_wcfm_uwt_auction_url( $auction_status = '') {
		global $WCFM;
		$wcfm_page = get_wcfm_page();		
		$wcfm_auctions_url = wcfm_get_endpoint_url( 'uwt-auctionslist', '', $wcfm_page );
		if( $auction_status ) $wcfm_auctions_url = add_query_arg( 'auction_status', $auction_status, $wcfm_auctions_url );
		return $wcfm_auctions_url;
	}
}
if(!function_exists('get_wcfm_view_auction_url')) {
	function get_wcfm_view_auction_url( $auction_id = '' ) {
		global $WCFM;
		$wcfm_page = get_wcfm_page();
		$wcfm_view_auction_url = wcfm_get_endpoint_url( 'uwt-auction-detail', $auction_id, $wcfm_page );
		return $wcfm_view_auction_url;
	}
}
function uwa_wcb_wcfm_query_vars( $query_vars ) {
	
	
	$query_vars['uwt-auctionslist'] = ! empty( $wcfm_modified_endpoints['uwt-auctionslist'] ) ? $wcfm_modified_endpoints['uwt-auctionslist'] : 'uwt-auctionslist';
	
	$query_vars['uwt-auction-detail'] = ! empty( $wcfm_modified_endpoints['uwt-auction-detail'] ) ? $wcfm_modified_endpoints['uwt-auction-detail'] : 'uwt-auction-detail';
		
		return $query_vars;
  }

function uwa_wcb_load_views( $end_point ) {
	global $WCFM, $WCFMu;
	// echo UAT_THEME_PRO_URI;
	// exit();
	 switch( $end_point ) {	  	    
		 case 'uwt-auctionslist':
			include( "wcfm-uwt-auctions-lists.php");		
			break;
		case 'uwt-auction-detail':
			include("wcfm-uwt-auctions-detail.php");		
		break;
	 }
   }


   /* Add Auction Product In Capability Setting */

function uwa_vendor_support_auction_tab( $product_types, $handler = 'wcfm_capability_options', 
$wcfm_capability_options = array() ) {
	global $WCFM;
	$uwa_auction = ( isset( $wcfm_capability_options['auction'] ) ) ? $wcfm_capability_options['auction'] : 'no';
	$product_types["auction"] =  array(
			'label' => __('Auction Product', 'ultimate-auction-pro-software'), 
			'name' => $handler . '[auction]',
			'type' => 'checkboxoffon', 
			'class' => 'wcfm-checkbox wcfm_ele', 
			'value' => 'yes', 
			'label_class' => 'wcfm_title checkbox_title', 
			'dfvalue' => $uwa_auction
	);
			
	return $product_types;
}
/* Register globally scripts */
add_action( 'wp_footer',  'uwa_vendor_support_add_scripts');
//add_action( 'wcfm_load_scripts',  'uwa_vendor_support_add_scripts');
//add_action( 'after_wcfm_load_scripts',  'uwa_vendor_support_add_scripts');

function uwa_vendor_support_add_scripts(){
	global $WCFM;
	//  UAT_THEME_PRO_INC_DIR . 'wcfm/js/wcfm_uwa_auctions.js';
	$WCFM->library->load_datatable_lib();
    $WCFM->library->load_daterangepicker_lib();
	wp_register_script( 'wcfm_uwa_auctions_date_picker', UAT_THEME_PRO_URI . 'includes/wcfm/js/date-picker.js',array('jquery') );	
	wp_enqueue_script( 'wcfm_uwa_auctions_date_picker' );

	$uat_google_maps_api_key = get_option( 'options_uat_google_maps_api_key' ,"");
	if(!empty($uat_google_maps_api_key)){ 
		wp_register_script( 'wcfm_store_google_maps_js', $_SERVER['REQUEST_SCHEME'].'://maps.googleapis.com/maps/api/js?key='.$uat_google_maps_api_key.'&#038;libraries=places&#038;ver=6.1', array('jquery'), UAT_THEME_PRO_VERSION );
	}

	$wcfm_marketplace_options = get_option( 'wcfm_marketplace_options');
	$default_geolocation = $wcfm_marketplace_options['default_geolocation'];
	$d_lat = $default_geolocation['lat'];
	$d_lng = $default_geolocation['lng'];	
	
	wp_register_script( 'wcfm_uwa_auctions', UAT_THEME_PRO_URI.'includes/wcfm//js/wcfm_uwa_auctions.js', array('jquery'), UAT_THEME_PRO_VERSION );
	wp_enqueue_script( 'wcfm_uwa_auctions' );
	wp_localize_script( 'wcfm_uwa_auctions', 'uwa_wcfm_params_add_js', 
	array( 
		'invalid_reserve_msg' => __('Please enter a lowest price to accept more than the opening price', 'ultimate-auction-pro-software'),
		'default_lat' =>$d_lat,
		'default_lng' =>$d_lng
	)
	);
	wp_register_script( 'wcfm_uwa_auctions_list', UAT_THEME_PRO_URI . 'includes/wcfm/js/wcfm_uwa_auctions_list.js' );	

	wp_localize_script( 'wcfm_uwa_auctions_list', 'uwa_wcfm_params',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	wp_enqueue_script( 'wcfm_uwa_auctions_list' );

	wp_register_script( 'wcfm_uwa_auctions_detail', UAT_THEME_PRO_URI . 'includes/wcfm/js/wcfm_uwa_auctions_detail.js');	

	wp_localize_script( 'wcfm_uwa_auctions_detail', 'uwa_wcfm_params',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		
	wp_enqueue_script( 'wcfm_uwa_auctions_detail' );

}


/* Add Auction Product Tab */
add_filter('wcfm_product_type_default_tab', 'uwa_vendor_support_default_tab');
function uwa_vendor_support_default_tab($product_tabs){
	$product_tabs['auction'] =  "wcfm_products_manage_form_auction_options_head";
	return $product_tabs;	
}


add_filter('wcfm_product_manage_fields_auction_options', 'uwa_vendor_support_manage_fields', 20, 3);
add_filter( 'wcfm_is_force_shipping_address', '__return_true' );

function uwa_vendor_support_manage_fields($fields, $product_id){

		
	
	if(get_option('uwa_hide_product_condition_field') == 'yes'){
		/* if not enabled then unset it */				
		unset($fields['woo_ua_product_condition']);		
	}
	return $fields;
}
/*Auction Product Manage View */
// add_action( 'end_wcfm_products_manage', 'uwa_vendor_support_end_products_manage_bp');
/*Auction Product Manage View */
add_action( 'end_wcfm_products_manage', 'uwa_vendor_support_end_products_manage', 20);

function uwa_vendor_support_end_products_manage($product_id){
	global $WCFM, $woocommerce,$post;	
	// echo $product_id;	
	$product = new WC_Product_Auction($product_id);	
		 
	// $product = wc_get_product($product_id);
	$woo_ua_form_type = "add_product";
	if ($product_id > 0) {
			$woo_ua_form_type = "edit_product";
	}
	$is_auction_expired = "no";
	$is_auction_live = "no";
	$auction_status_type = "";
	$auction_checked = "checked";
	$buyitnow_checked = "";
	if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {
		if ($woo_ua_form_type == "edit_product") {
			/* GET auction  live/expired */
			if (json_chk_auction($product_id) == "live") {  // get_uwa_auction_has_started
				$is_auction_live = "yes";
				$auction_status_type = "live";
			}
			if (json_chk_auction($product_id) == "past") { // get_uwa_auction_expired
				$is_auction_expired = "yes";
				$auction_status_type = "expired";
			}
			/* GET auction selling type */
			$post_id = $product_id;
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

		<!-- collapsible 8 - Auction Product -->
		<div class="page_collapsible products_manage_linked auction" id="wcfm_products_manage_form_auction_options_head">

			<label class="wcfmfa fa-gavel"></label>
				<?php _e('Auction Data', 'ultimate-auction-pro-software'); ?>
			<span></span>

		</div>

		<div class="wcfm-container auction ">
				 
			<div id="wcfm_products_manage_form_auction_options_expander" class="wcfm-content">
				
						<?php
								echo '<input type="hidden" class="" name="woo_ua_auction_form_type" id="woo_ua_auction_form_type" value="'.$woo_ua_form_type.'">';
								echo '<input type="hidden" class="" name="woo_ua_auction_status_type" id="woo_ua_auction_status_type" value="'.$auction_status_type.'">';
								
								
								if (isset($_GET['action']) && $_GET['action'] == "edit") {
									/* add field during edit product to store product type */
									echo '<input type="hidden" class="" name="woo_ua_product_type" id="woo_ua_product_type" value="'.$product->get_type().'">';
								
								}
								echo "<div  width='70%'> ";  // 1 start - main
							$subTitle = get_post_meta($product_id, 'uat_auction_subtitle', true);
							// print_r($subTitle);
								$WCFM->wcfm_fields->wcfm_generate_form_field( 
									apply_filters( 'wcfm_product_manage_fields_auction_options', 
										array(  	
									
											/*  no 10 */
											"uat_auction_subtitle" => array(
												'label' => __('Subtitle', 'ultimate-auction-pro-software'),
												'type' => 'text', // date, datepicker
												'value' => $subTitle,
												'class' => 'wcfm-text',
												'label_class' => 'wcfm_title', 								
												'hints' => __("Add Auction Product Subtitle here", 'ultimate-auction-pro-software'),
											),
										), $product_id,$product) );
								$selling_type_desc = __('There are two options that you get for selling an auction product. First is Auction by bidding. Second is Buy It Now. You can check whichever option you would like to enable.', 'ultimate-auction-pro-software');
								$event_auction_type_desc = __('By checking this box, this auction product will be a lot inside an auction event.', 'ultimate-auction-pro-software');
								$event_auction_checked = "";
								$event_auction =   get_post_meta($product_id, 'uwa_event_auction', true);
								if ($event_auction == "yes") {
									$event_auction_checked = "checked";
								}
								?>
							
						<?php
								// $WCFM->wcfm_fields->wcfm_generate_form_field( 
								// 	apply_filters( 'wcfm_product_manage_fields_auction_options', 
								// 		array(  	
									
								// 			/*  no 10 */
								// 			"uat_auction_lot_number" => array(
								// 				'label' => __('Lot Number #', 'ultimate-auction-pro-software'),
								// 				'type' => 'text', // date, datepicker
								// 				//'class' => 'datetimepicker',
								// 				'class' => 'wcfm-text',
								// 				// 'value' => $end_date,
								// 				'label_class' => 'wcfm_title', 								
								// 				'hints' => __("Set the lot number for the product inside an auction event.", 'ultimate-auction-pro-software'),
								// 			),
											
																																	
								// 		), $product_id,$product) );
						?>
			
						<p class="form-field wcfm_title">
							<strong><?php _e('Selling Type', 'ultimate-auction-pro-software'); ?></strong>
						</p>
						<div style="display: inline-block;margin-bottom:4px;">
							<input class="wcfm-checkbox" type="checkbox" id="uwa_auction_selling_type_auction" name="uwa_auction_selling_type_auction"
								<?php echo $auction_checked; ?> style="margin-right: 0px;"/> <?php _e('Auction', 'ultimate-auction-pro-software'); ?>
							<!-- <span style="margin-right:25px"> </span> -->
							<?php
							$setchk_bn=$buyitnow_checked;
							$setdis_bn="display:block";
							if($event_auction_checked=='checked'){
								$setchk_bn="";
								$setdis_bn="display:none";
							}
							?>
							<br>
							<span id="bn_main" style="<?php echo $setdis_bn; ?>">
							<input class="wcfm-checkbox" type="checkbox" id="uwa_auction_selling_type_buyitnow" name="uwa_auction_selling_type_buyitnow"
								<?php  echo $setchk_bn; ?>  style="margin-right: 0px;" /> <?php _e('Buy It Now', 'ultimate-auction-pro-software'); ?>

							<?php echo wc_help_tip($selling_type_desc); ?>

							</span>
						</div>
						
					<?php
					$buynow_class ="display:none";
					$selling_type1 = get_post_meta($product_id, 'woo_ua_auction_selling_type', true);					
					if($selling_type1 =="both" || $selling_type1 =="buyitnow" ){
						$buynow_class ="";
					}
					?>
						<div class='selling_type_buyitnow' style="<?php echo $buynow_class; ?>">
							<?php
							$uwa_buynow_price = $product->get_regular_price();
								$WCFM->wcfm_fields->wcfm_generate_form_field( 
									apply_filters( 'wcfm_product_manage_fields_auction_options', 
									array( "_regular_price" => array(
										'label' => __( 'Buy now price', 'ultimate-auction-pro-software' ). 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',
										'value' => $uwa_buynow_price,
										'label_class' => 'wcfm_title',
										'class' => 'wcfm-text wcfm_non_negative_input', 
										'attributes' => array( 'step' => 'any', 'min' => '0' ), 
										'hints' => __( 'Visitors can buy your auction by making payments via Available payment method.', 'ultimate-auction-pro-software' ),
									)
								), $product_id,$product) );
							?>
						</div>

						<div class='selling_type_auction' style="<?php if($selling_type == "buyitnow"){ echo 'display:none'; }; ?>">
					<?php

						$uwa_auction_types  =  array('normal' => __('Normal', 'ultimate-auction-pro-software'));
						$uwa_auction_proxy = $product->get_uwa_auction_proxy();					
						$proxy_value =  $uwa_auction_proxy;		
						$uwa_auction_silent = $product->get_uwa_auction_silent();					
						$silent_value =  '1';

						
						$uwa_opening_price = $product->get_uwa_auction_start_price();
						$uwa_reserved_price = $product->get_uwa_auction_reserved_price();						
						$uat_estimate_price_from = $product->get_estimate_price_from();
						$uat_estimate_price_to = $product->get_estimate_price_to();
						$uwa_start_date = $product->get_uwa_auction_start_dates();		
						$nowdate_for_start = $uwa_start_date ?  : get_ultimate_auction_now_date(); 
						$uwa_end_date = $product->get_uwa_auction_end_dates();
						$end_date = $uwa_end_date ?  :  wp_date('Y-m-d H:i:s',strtotime('+1 day', time()),get_ultimate_auction_wp_timezone());
						//$product->ID;
						$get_inc_val = get_post_meta(
							$product_id,
							'woo_ua_bid_increment',
							true
						);
						$default_bid_inc = get_option("options_uat_global_bid_increment", "1");
						if ($get_inc_val >= 0.1) {       // if($get_inc_val >= 1){
							$bid_inc_val = $get_inc_val;
						} else {
							$bid_inc_val = $default_bid_inc;
						}
						$var_bid_inc_value =  get_post_meta( $product_id, 'uwa_auction_variable_bid_increment', true);
					
						
							$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 3 */
								"uwa_auction_proxy" => array(
									'label' => __('Enable proxy bidding', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',
									'value' => "yes",
									'dfvalue' => $proxy_value, 
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',
									'hints' => __("Proxy Bidding (also known as Automatic Bidding) - Our automatic bidding system makes bidding convenient so you don't have to keep coming back to re-bid every time someone places another bid. When you place a bid, you enter the maximum amount you're willing to pay for the item. The seller and other bidders don't know your maximum bid. We'll place bids on your behalf using the automatic bid increment amount, which is based on the current high bid. We'll bid only as much as necessary to make sure that you remain the high bidder, or to meet the reserve price, up to your maximum amount.", 'ultimate-auction-pro-software'), 
								)
							), $product_id,$product) );
							
							$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 4 */
								"uwa_auction_silent" => array(
									'label' => __('Enable Silent-Bid', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',	
									'value' => "yes",
									'dfvalue' => $silent_value,							
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',
									'hints' => __("A Silent-Bid auction is a type of auction process in which all bidders simultaneously submit Silent bids to the auctioneer, so that no bidder knows how much the other auction participants have bid. The highest bidder is usually declared the winner of the bidding process.", 'ultimate-auction-pro-software'), 
								)
							), $product_id,$product) );							
							
							$uwa_auction_has_reserve = get_post_meta($product_id,'uwa_auction_has_reserve',true);
							
							if (empty($uwa_auction_has_reserve)) {
								$uwa_auction_has_reserve = "yes";
							}
							$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 3 */
								"uwa_auction_has_reserve" => array(
									'label' => __('Enable Reserve Price', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',
									'value' => "yes",
									'dfvalue' => $uwa_auction_has_reserve, 
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',
									'hints' => __("The lowest price at which a seller is willing to sell an item.", 'ultimate-auction-pro-software'), 
								)
							), $product_id,$product) );

								
							if(empty($uwa_reserved_price) || $uwa_reserved_price < 1){
								$uwa_reserved_price = 1;
							}	
							$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 5 */
									"woo_ua_opening_price" => array(
										'label' => __( 'Opening Price', 'ultimate-auction-pro-software' ). 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',							
										'class' => 'wcfm-text wcfm_non_negative_input',
										'label_class' => 'wcfm_title', 
										'value' => $uwa_opening_price,
										'attributes' => array( 'step' => 'any', 'min' => '0',
												'data-required'=> 1, 
												'data-required_message' => 
													"Opening Price: This field is required."), 

										'hints' => __('The price at which the bidding will start.', 'ultimate-auction-pro-software'),
									),
									
									/*  no 6 */
									"woo_ua_lowest_price" => array(
										'label' => __('Reserve Price', 'ultimate-auction-pro-software') . 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',
										'value' => $uwa_reserved_price,
										'label_class' => 'wcfm_title',
										'class' => 'wcfm-text wcfm_non_negative_input', 
										'attributes' => array( 'step' => 'any', 'min' => '1',
																'data-required'=> 1, 
																'data-required_message' => 
																	"Opening Price: This field is required." ), 
										'hints' => __( 'Set Reserve price for your auction.', 'ultimate-auction-pro-software' ),
									),
									
									/*  no 7 */
									"uat_estimate_price_from" => array(
										'label' => __('Estimated Opening Price', 'ultimate-auction-pro-software') . 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',
										'value' => $uat_estimate_price_from,
										'label_class' => 'wcfm_title',
										'class' => 'wcfm-text wcfm_non_negative_input', 
										'attributes' => array( 'step' => 'any', 'min' => '0' ), 
										//'hints' => __( 'The price that seller thinks the highest bid should go to.', 'ultimate-auction-pro-software' ),
									),
									
									/*  no 8 */
									"uat_estimate_price_to" => array(
										'label' => __('Estimated Closing Price', 'ultimate-auction-pro-software') . 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',
										'value' => $uat_estimate_price_to,
										'label_class' => 'wcfm_title',
										'class' => 'wcfm-text wcfm_non_negative_input', 
										'attributes' => array( 'step' => 'any', 'min' => '0' ), 
										'hints' => __( 'The price that seller thinks the highest bid should go to.', 'ultimate-auction-pro-software' ),
									),
									

									/*  no 9 */	
									"woo_ua_auction_start_date" => array(
										'label' => __( 'Start Date', 'ultimate-auction-pro-software' ),
										'type' => 'text',  // date, datepicker
										//'class' => 'datetimepicker',
										'class' => 'wcfm-text',
										'value' => $nowdate_for_start,
										'label_class' => 'wcfm_title', 								
										'hints' => __( 'Set the Start date of Auction Product.', 'ultimate-auction-pro-software' ),
									),

									/*  no 10 */
									"woo_ua_auction_end_date" => array(
										'label' => __( 'Ending Date', 'ultimate-auction-pro-software' ),
										'type' => 'text', // date, datepicker
										//'class' => 'datetimepicker',
										'class' => 'wcfm-text',
										'value' => $end_date,
										'label_class' => 'wcfm_title', 								
										'hints' => __( 'Set the end date for the auction', 'ultimate-auction-pro-software' ),
									),
									/*  no 7 */
									"woo_ua_bid_increment" => array(
										'label' => __( 'Bid Increment', 'ultimate-auction-pro-software' ) . 
											' (' . get_woocommerce_currency_symbol() . ')',
										'type' => 'numeric',
										'value' => $bid_inc_val,  // $uwa_bid_increment,
										'label_class' => 'wcfm_title', 
										'class' => 'wcfm-text wcfm_non_negative_input',
										'attributes' => array( 'step' => 'any', 'min' => '0' ), 
										'hints' => __( 'Set an amount from which next bid should start.','ultimate-auction-pro-software' ),
									),
								), $product_id,$product) );

								$WCFM->wcfm_fields->wcfm_generate_form_field( 
									apply_filters( 'wcfm_product_manage_fields_auction_options', 
									array(
									/*  no 4 */

										"uwa_auction_variable_bid_increment" => array(
											'label' => __('Variable Bid Increment', 'ultimate-auction-pro-software') . ' (' . get_woocommerce_currency_symbol() . ')',
											'type' => 'checkbox',								
											'value' => 'yes', 
											'dfvalue' => $var_bid_inc_value,								
											'label_class' => 'wcfm_title', 								
											'class' => 'wcfm-checkbox',
											'hints' => __("Enable Variable Incremental Price.", 'ultimate-auction-pro-software'), 
										),
									), $product_id,$product) );
							
							$selling_type_desc = __('There are two options that you get for selling an auction product. First is Auction by bidding. Second is Buy It Now. You can check whichever option you would like to enable.', 'ultimate-auction-pro-software');
							$event_auction_type_desc = __('By checking this box, this auction product will be a lot inside an auction event.', 'ultimate-auction-pro-software');
							$event_auction_checked = "";
							$event_auction =   get_post_meta($product_id, 'uwa_event_auction', true);
							if ($event_auction == "yes") {
								$event_auction_checked = "checked";
							}
							$uwa_auction_variable_bid_increment_type = get_post_meta($product_id, 'uwa_auction_variable_bid_increment_type', true);
							$vbi_global_checked = "";
							$vbi_custom_checked = "";
							if($uwa_auction_variable_bid_increment_type == "custom"){
								$vbi_custom_checked = "yes";
								
							}elseif($uwa_auction_variable_bid_increment_type == "global"){
								$vbi_global_checked = "yes";
							}
							
							?>
						
						<div class="uwa_auction_variable_bid_increment_type wcfm_title uwa_auction_variable_bid_increment_type_" style="display: flex;">
						
						<?php
						$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 3 */
								"uwa_auction_variable_bid_increment_type_global" => array(
									'label' => __('Use Global Variable Bid Increment settings', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',
									'value' => "yes",
									'dfvalue' => $vbi_global_checked, 
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',									 
								)
							), $product_id,$product) );
						

							$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 4 */
								"uwa_auction_variable_bid_increment_type_custom" => array(
									'label' => __('Custom price range', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',	
									'value' => "yes",
									'dfvalue' => $vbi_custom_checked, 
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',									
								)
							), $product_id,$product) );	
						
						?>
						

						</div>

						<p class="form-field uwa_variable_bid_increment_main" style="display:none;">
							<span id="uwa_custom_field_add_remove" class="hide_for_uat_event">
								<!-- Don't 	remove -->
								
								<input type="button" id="plus_field" class="button button-secondary" value="<?php echo esc_attr('Add New'); ?>" />
								<?php
									$uwa_var_inc_data = get_post_meta($product_id, 'uwa_var_inc_price_val', true);
									//$uwa_var_inc_data_count = count($uwa_var_inc_data);
									$i = 1;
									if (!empty($uwa_var_inc_data))
									{
										foreach ($uwa_var_inc_data as $key => $variable_val)
										{
											if ($key !== 'onwards')
											{ ?>
											<span id="uwa_custom_field_<?php echo $i; ?>" class="uwa_custom_field_main">
												<input type="number" class="uwa_auction_price_fields start_valid" id="start_val_<?php echo $i; ?>"
													data-startid="<?php echo $i; ?>" name="uwa_var_inc_val[<?php echo $i; ?>][start]"
													value="<?php echo $variable_val['start']; ?>"
													placeholder="<?php _e('Start Price', 'ultimate-auction-pro-software'); ?>" />
												<input type="number" class="uwa_auction_price_fields end_valid" id="end_val_<?php echo $i; ?>"
													data-endid="<?php echo $i; ?>" name="uwa_var_inc_val[<?php echo $i; ?>][end]"
													value="<?php echo $variable_val['end']; ?>"
													placeholder="<?php _e('End Price', 'ultimate-auction-pro-software'); ?>" />
												<input type="number" class="uwa_auction_price_fields" id="inc_val_<?php echo $i; ?>"
													name="uwa_var_inc_val[<?php echo $i; ?>][inc_val]"
													value="<?php echo $variable_val['inc_val']; ?>"
													placeholder="<?php _e('Increment Price', 'ultimate-auction-pro-software'); ?>" />
												<?php
												if ($i != 1)
												{ ?>
												<input type="button" class="button button-secondary minus_field" value="-"
													data-custom="<?php echo $i; ?>" />
												<?php
												} ?>
											</span>
											<?php
											}
											$i++;
										}
									}
									else
									{ ?>
											<span id="uwa_custom_field_0" class="uwa_custom_field_main">
												<input type="number" class="uwa_auction_price_fields start_valid" id="start_val_0" data-startid="0"
													name="uwa_var_inc_val[0][start]" value=""
													placeholder="<?php _e('Start Price', 'ultimate-auction-pro-software'); ?>" />
												<input type="number" class="uwa_auction_price_fields end_valid" id="end_val_0" data-endid="0"
													name="uwa_var_inc_val[0][end]" value=""
													placeholder="<?php _e('End Price', 'ultimate-auction-pro-software'); ?>" />
												<input type="number" class="uwa_auction_price_fields" id="inc_val_0"
													name="uwa_var_inc_val[0][inc_val]" value=""
													placeholder="<?php _e('Increment Price', 'ultimate-auction-pro-software'); ?>" />
											</span>
											<?php
									} ?>
										</span>
										<script type="text/javascript">
										<?php if ($var_bid_inc_value == "yes")
									{ ?>
										jQuery('p.uwa_variable_bid_increment_main').css("display", "block");
										jQuery('.form-field.woo_ua_bid_increment_field').css("display", "none");
										jQuery('#woo_ua_bid_increment').val("");
										<?php
									}
									else
									{ ?>
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

								 // Get the content height of the .wcfm-tabWrap div
								 var tabWrapContentHeight = jQuery(".wcfm-tabWrap").height();
								tabWrapContentHeight = tabWrapContentHeight+60 
								// Set the height of the .wcfm-tabWrap div to the calculated content height
								jQuery(".wcfm-tabWrap").css("height", tabWrapContentHeight + "px");


								
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
							var product_type = jQuery("#product-type").val();
							if (product_type == "auction") {
								var woo_ua_auction_form_type = jQuery("#woo_ua_auction_form_type").val();
								if (woo_ua_auction_form_type == "edit_product") {
									/* make fields disabled when auction is live/expired */
									var woo_ua_auction_status_type = jQuery("#woo_ua_auction_status_type").val();
									if (woo_ua_auction_status_type == "live") {
										jQuery("#woo_ua_auction_start_date").attr("disabled", "disabled");
										/*jQuery("#woo_ua_auction_start_date").datepicker( "option", "disabled", true);*/
									}
									if (woo_ua_auction_status_type == "expired") {
										jQuery("#woo_ua_auction_start_date").attr("disabled", "disabled");
										jQuery("#woo_ua_auction_end_date").attr("disabled", "disabled");
									}
									/* =========  new start  =====   */
									var is_selling_type_auction = jQuery("#uwa_auction_selling_type_auction").is(":checked");
									var is_selling_type_buynow = jQuery("#uwa_auction_selling_type_buyitnow").is(":checked");
									jQuery("div.selling_type_auction").hide();
									jQuery("div.selling_type_buyitnow").hide();
									if (is_selling_type_auction === true) {
										jQuery("div.selling_type_auction").show();
									}
									if (is_selling_type_buynow === true) {
										jQuery("div.selling_type_buyitnow").show();
									}
									/* =========  new end  ======   */
								}
							} /* end of if - producttype */
							/* ======================== new start  ============================ */
							jQuery('#uwa_auction_selling_type_auction').on('click', function () {
								/*jQuery("div.selling_type_auction").toggle();*/
								if (jQuery(this).is(":checked")) {
									jQuery("div.selling_type_auction").slideDown();
								} else {
									jQuery("div.selling_type_auction").slideUp();
								}
							});
							jQuery('#uwa_auction_selling_type_buyitnow').on('click', function () {
								if (jQuery(this).is(":checked")) {
									jQuery("div.selling_type_buyitnow").slideDown();
								} else {
									jQuery("div.selling_type_buyitnow").slideUp();
								}
							});
							</script>
						</p>
						</div><br>
						
						
						<?php
						$uat_google_maps_api_key = get_option( 'options_uat_google_maps_api_key' ,"");
							if(!empty($uat_google_maps_api_key)){ 
							$location_same_as_store = get_post_meta($product_id,'uat_locationP_address_same_as_store',true);
							if (!empty($location_same_as_store)) {
								$location_same_as_store = "yes";
							}
							
							$location = get_field('uat_locationP_address', $product_id, true);								
								//$location = $store_location_json;								
								$location_address = "";
								$location_lat = "";
								$location_lng = "";
								$location_zoom = "";
								if(!empty($location))
								{
									$location_address = $location['address'];
									$location_lat = $location['lat'];
									$location_lng = $location['lng'];
									$location_zoom = $location['zoom'];
									$location = json_encode($location);
								}
								
							
								
							?>
							<p class="wcfm_title" >
									<strong><?php _e('Auction Product Location Details', 'ultimate-auction-pro-software'); ?>
									</strong>
									<span class="img_tip wcfmfa fa-question" data-tip="<?php _e('Enter Product Location', 'ultimate-auction-pro-software'); ?>" data-hasqtip="33"></span>
							</p>
							<br>
							<?php 
								$WCFM->wcfm_fields->wcfm_generate_form_field( 
								apply_filters( 'wcfm_product_manage_fields_auction_options', 
								array(  
								/*  no 3 */
								"uat_locationP_address_same_as_store" => array(
									'label' => __('Same as Store Location', 'ultimate-auction-pro-software'),
									'type' => 'checkbox',
									'value' => "yes",
									'dfvalue' => $location_same_as_store, 
									'label_class' => 'wcfm_title', 								
									'class' => 'wcfm-checkbox',
									'hints' => __("", 'ultimate-auction-pro-software'), 
								)
							), $product_id,$product) );
							?>
							
							
							<script type='text/javascript' src='<?php echo $_SERVER['REQUEST_SCHEME']; ?>://maps.googleapis.com/maps/api/js?key=<?php echo $uat_google_maps_api_key; ?>&#038;libraries=places&#038;ver=6.1' id='wcfm-store-google-maps-js'></script>
							
								<p class="wcfm_title enter_m_lctn" >
									<strong><?php _e('Enter Manually Location', 'ultimate-auction-pro-software'); ?></strong>
									<span class="img_tip wcfmfa fa-question" data-tip="<?php _e('Enter Manually Location', 'ultimate-auction-pro-software'); ?>" data-hasqtip="33"></span>
								</p>
								<input id="pac-input" type="text" class="wcfm-text" value="<?php echo $location_address; ?>" placeholder="<?php _e('Address', 'ultimate-auction-pro-software'); ?>"><div id="location-error"></div>
								<input type="hidden" name="location" value='<?php echo $location; ?>' id="location">
								<input type="hidden" name="location_lat" value='<?php echo $location_lat; ?>' id="location_lat">
								<input type="hidden" name="location_lng" value='<?php echo $location_lng; ?>' id="location_lng">
								<input type="hidden" name="location_zoom" value='<?php echo $location_zoom; ?>' id="location_zoom">
								<div class="uat-ctm-gmap" >
								<div  id="UatWcfmMap" class="uat-wcfm-map"></div>
								<div id="infowindow-content"></div>
								</div>								
						<?php  } ?>	
						<div class="uwa_admin_current_time wcfm-content">
							<p class="wcfm-text">
								<?php
									printf(__('Current Blog Time is %s', 'ultimate-auction-pro-software') , '<strong>' . get_ultimate_auction_now_date() . '</strong> ');
									echo __('Timezone:', 'ultimate-auction-pro-software') . ' <strong>' . wp_timezone_string() . '</strong>';
									echo __('<a href="' . admin_url('options-general.php?#timezone_string') . '" target="_blank">' . ' ' . __('Change', 'ultimate-auction-pro-software') . '</a>'); 
								?>
							</p>	
						</div>
						<?php
							$event_id = get_post_meta($product_id, 'uat_event_id', true);
							if (empty($event_id)) {

								if ((method_exists($product, 'get_type') && $product->get_type() == 'auction') and (json_chk_auction($product_id) == "future"))
								{ ?>
									<p class="form-field uwa_admin_uwa_make_live">
										<a href="#" class="button uwa_force_make_live"  data-auction_id="<?php echo $product_id; ?>">
										<?php _e('Make It Live', 'ultimate-auction-pro-software'); ?></a>
									</p>
									<?php
								}
								if ((method_exists($product, 'get_type') && $product->get_type() == 'auction') && (json_chk_auction($product_id) == "live"))
								{ ?>
									<p class="form-field uwa_admin_uwa_force_end_now">
										<a href="#" class="button uwa_force_end_now"  data-auction_id="<?php echo $product_id; ?>">
										<?php _e('End Now', 'ultimate-auction-pro-software'); ?></a>
								</p> <?php  } ?>

							<?php  } ?>

			</div>
			
		</div>
		<div class="wcfm_clearfix"></div>

		
	<?php
}




add_action( 'after_wcfm_products_manage_meta_save', 
	'uat_save_auction_option_field', 200, 2);

function uat_save_auction_option_field($new_product_id, 
$wcfm_products_manage_form_data)
	{
		// print_r($wcfm_products_manage_form_data);
		global $wpdb, $woocommerce, $woocommerce_errors;
		$post_id = $new_product_id;
		$product_type = empty($wcfm_products_manage_form_data['product_type']) ? 'simple' : sanitize_title(stripslashes($wcfm_products_manage_form_data['product_type']));
		if ($product_type == 'auction') {
			update_post_meta($post_id, '_manage_stock', 'yes');
			update_post_meta($post_id, '_stock', '1');
			update_post_meta($post_id, '_backorders', 'no');
			update_post_meta($post_id, '_sold_individually', 'yes');
			if (isset($wcfm_products_manage_form_data['_regular_price'])) {
				update_post_meta($post_id, '_regular_price', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['_regular_price'])));
				update_post_meta($post_id, '_price', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['_regular_price'])));
			}
			if (isset($wcfm_products_manage_form_data['woo_ua_product_condition'])) {
				update_post_meta($post_id, 'woo_ua_product_condition', esc_attr($wcfm_products_manage_form_data['woo_ua_product_condition']));
			}
			if (isset($wcfm_products_manage_form_data['uat_auction_subtitle'])) {
				update_post_meta($post_id, 'uat_auction_subtitle', esc_attr($wcfm_products_manage_form_data['uat_auction_subtitle']));
			}
			if (isset($wcfm_products_manage_form_data['woo_ua_opening_price'])) {
				update_post_meta($post_id, 'woo_ua_opening_price', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['woo_ua_opening_price'])));
			}
			if (isset($wcfm_products_manage_form_data['woo_ua_lowest_price'])) {
				update_post_meta($post_id, 'woo_ua_lowest_price', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['woo_ua_lowest_price'])));
			}
			if (isset($wcfm_products_manage_form_data['uwa_auction_has_reserve']))
			{
				update_post_meta($post_id, 'uwa_auction_has_reserve', 'yes');
			}else{
				update_post_meta($post_id, 'uwa_auction_has_reserve', 'no');
			}
			if (isset($wcfm_products_manage_form_data['uwa_number_of_next_bids'])) {
				update_post_meta($post_id, 'uwa_number_of_next_bids', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['uwa_number_of_next_bids'])));
			}
			if (isset($wcfm_products_manage_form_data['uat_estimate_price_from'])) {
				update_post_meta($post_id, 'uat_estimate_price_from', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['uat_estimate_price_from'])));
			}
			if (isset($wcfm_products_manage_form_data['uat_estimate_price_to'])) {
				update_post_meta($post_id, 'uat_estimate_price_to', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['uat_estimate_price_to'])));
			}
			/* Add In Pro */
			update_post_meta($post_id, 'woo_ua_auction_type','normal');
			/* Selling type */
			/* Note : html static so checkbox checked == on or (blank) */
			if (isset($wcfm_products_manage_form_data['uwa_auction_selling_type_auction']) && isset($wcfm_products_manage_form_data['uwa_auction_selling_type_buyitnow'])) {
				if ($wcfm_products_manage_form_data['uwa_auction_selling_type_auction'] == "on" && $wcfm_products_manage_form_data['uwa_auction_selling_type_buyitnow'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "both");
				}
			} else if (isset($wcfm_products_manage_form_data['uwa_auction_selling_type_auction'])) {
				if ($wcfm_products_manage_form_data['uwa_auction_selling_type_auction'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "auction");
				}
			} else if (isset($wcfm_products_manage_form_data['uwa_auction_selling_type_buyitnow'])) {
				if ($wcfm_products_manage_form_data['uwa_auction_selling_type_buyitnow'] == "on") {
					update_post_meta($post_id, 'woo_ua_auction_selling_type', "buyitnow");
				}
			}
			// echo get_post_meta($post_id, 'woo_ua_auction_selling_type', true);
			//if event checkbox checked on
			if (isset($wcfm_products_manage_form_data['uwa_event_auction'])) {
				update_post_meta($post_id, 'uwa_event_auction', 'yes');
				update_post_meta($post_id, 'uat_auction_lot_number', $wcfm_products_manage_form_data['uat_auction_lot_number']);
			} else {
				delete_post_meta($post_id, 'uat_event_id');
				delete_post_meta($post_id, 'uwa_event_auction');
				//Update add via Event field
				if (isset($wcfm_products_manage_form_data['uwa_auction_proxy'])) {
					update_post_meta($post_id, 'uwa_auction_proxy', stripslashes($wcfm_products_manage_form_data['uwa_auction_proxy']));
					update_post_meta($post_id, 'uwa_auction_silent', '0');
				} else {
					update_post_meta($post_id, 'uwa_auction_proxy', '0');
				}
				if (isset($wcfm_products_manage_form_data['uwa_auction_silent'])) {
					update_post_meta($post_id, 'uwa_auction_silent', stripslashes($wcfm_products_manage_form_data['uwa_auction_silent']));
					update_post_meta($post_id, 'uwa_auction_proxy', '0');
				} else {
					update_post_meta($post_id, 'uwa_auction_silent', '0');
				}
				if (isset($wcfm_products_manage_form_data['woo_ua_bid_increment']) && $wcfm_products_manage_form_data['woo_ua_bid_increment'] != '') {
					update_post_meta($post_id, 'woo_ua_bid_increment', wc_format_decimal(wc_clean($wcfm_products_manage_form_data['woo_ua_bid_increment'])));
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment');
					delete_post_meta($post_id, 'uwa_var_inc_price_val');
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment_type');
				}
				/* Pro Plugin */
				if (isset($wcfm_products_manage_form_data['woo_ua_auction_start_date']) && $wcfm_products_manage_form_data['woo_ua_auction_start_date'] != "") {
					update_post_meta($post_id, 'woo_ua_auction_start_date', stripslashes($wcfm_products_manage_form_data['woo_ua_auction_start_date']));
				} else {
					//update_post_meta( $post_id, 'woo_ua_auction_start_date', stripslashes( $start_date ) );
				}
				if (isset($wcfm_products_manage_form_data['woo_ua_auction_end_date'])) {
					update_post_meta($post_id, 'woo_ua_auction_end_date', stripslashes($wcfm_products_manage_form_data['woo_ua_auction_end_date']));
				}
				
				
				if (isset($wcfm_products_manage_form_data['uwa_auction_variable_bid_increment'])) {
					//uwa_auction_variable_bid_increment_type_global
					//uwa_auction_variable_bid_increment_type_custom
					if (isset($wcfm_products_manage_form_data['uwa_auction_variable_bid_increment_type_global']) && $wcfm_products_manage_form_data['uwa_auction_variable_bid_increment_type_global'] == "yes"){
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment_type', "global");
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment', $wcfm_products_manage_form_data['uwa_auction_variable_bid_increment']);
					}elseif($wcfm_products_manage_form_data['uwa_auction_variable_bid_increment_type_custom'] == "yes" && !empty($wcfm_products_manage_form_data['uwa_var_inc_val'])) {						
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment_type', "custom");
						update_post_meta($post_id, 'uwa_auction_variable_bid_increment', $wcfm_products_manage_form_data['uwa_auction_variable_bid_increment']);
						update_post_meta($post_id, 'uwa_var_inc_price_val', $wcfm_products_manage_form_data['uwa_var_inc_val']);
						delete_post_meta($post_id, 'woo_ua_bid_increment');
					}					
					
				}else {
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment');
					delete_post_meta($post_id, 'uwa_auction_variable_bid_increment_type');
				}
				
			}
			/* delete some metadata only when simple, grouped, variable or any product
				 become auction product during edit product */
			if (isset($wcfm_products_manage_form_data['woo_ua_product_type'])) {
				if ($wcfm_products_manage_form_data['woo_ua_product_type'] != "auction") {
					//delete_post_meta( $post_id, "_sale_price");
				}
			}
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
				if(!empty($event_id)){
					$auction_array['event_id'] = $event_id;
				}else{
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
				
			}
			$location =  json_decode($wcfm_products_manage_form_data['location'], true);
			$location_same_as_store = $wcfm_products_manage_form_data['uat_locationP_address_same_as_store'];
			update_post_meta($post_id, 'uat_locationP_address_same_as_store', $location_same_as_store);
			if($location_same_as_store=="yes") {								
				$user_id =  get_current_user_id(); // replace with the vendor ID you want to retrieve data for
				$_wcfm_street_1 = get_user_meta( $user_id, '_wcfm_street_1', true );
				$_wcfm_street_2 = get_user_meta( $user_id, '_wcfm_street_2', true );						
				$store_location = $_wcfm_street_1.$_wcfm_street_2;
				$store_location_lat = get_user_meta( $user_id, '_wcfm_store_lat', true );
				$store_location_lng = get_user_meta( $user_id, '_wcfm_store_lng', true );						    
				$location_same_as_store = get_post_meta($post->ID,'',true);
				$store_location_json="";
				if(!empty($store_location)) {
					$_wcfm_city = get_user_meta( $user_id, '_wcfm_city', true );
					$_wcfm_zip = get_user_meta( $user_id, '_wcfm_zip', true );
					$_wcfm_country = get_user_meta( $user_id, '_wcfm_country', true );
					$_wcfm_state = get_user_meta( $user_id, '_wcfm_state', true );
					$store_location_json = array(
					'address' => $store_location,
					'lat' => $store_location_lat,
					'lng' => $store_location_lng,
					'city' => $_wcfm_city,
					'zip' => $_wcfm_zip,
					'post_code' => $_wcfm_zip,
					'country' => $_wcfm_country,
					'country_short' => $_wcfm_country,
					'state' => $_wcfm_state,								
					'state_short' => $_wcfm_state,								
					'zoom' => 14,							
					);
				}
				
				$location = $store_location_json;
			}
			$post_id = $product->get_id();
			if (!empty($location))
			{
					update_field('uat_locationP_address', $location, $post_id);
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
			wat_auction_save_post_callback($post_id);
		} /*  end of if - auction */ else {
			delete_post_meta($post_id, 'woo_ua_product_condition');
			delete_post_meta($post_id, 'woo_ua_opening_price');
			delete_post_meta($post_id, 'woo_ua_lowest_price');
			delete_post_meta($post_id, 'uwa_auction_has_reserve');
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


	if(!function_exists('get_wcfm_manager_page_url')) {
		function get_wcfm_manager_page_url( $language_code = '' ) {
			$wcfm_store = "";
			
			$pages = get_option("wcfm_page_options");
			if( isset($pages['wc_frontend_manager_page_id']) && $pages['wc_frontend_manager_page_id'] ) {
				$wcfm_store =  get_wcfm_page();
			}
			return $wcfm_store;

		}
	}



	function wcfm_ajax_uwt_auction_callback(){
		global $wpdb,$woocommerce, $product, $post;    
		$datetimeformat = get_option('date_format').' '.get_option('time_format');	
		$curr_user_id = get_current_user_id();	
		
		$length = $_POST['length'];
		$offset = $_POST['start'];
		
		/* woo_ua_auction_bid_count	*/
			$meta_query = array(
							'relation' => 'AND',
								array(			     
									'key'  => 'woo_ua_auction_closed',
									'compare' => 'NOT EXISTS',
								),
								array(
									'key'     => 'woo_ua_auction_has_started',
									'value' => '1',
								)							
							);
			
			if (isset($_POST["auctions_status"]) && $_POST["auctions_status"]=='expired') {						
				$meta_query= array(
							'relation' => 'AND',
								array(			     
									'key' => 'woo_ua_auction_closed',
									'value' => array('1','2','3','4'),
									'compare' => 'IN',
								),							
							);
			}
	
			if (isset($_POST["auctions_status"]) && $_POST["auctions_status"]=='scheduled') {						
						
				$meta_query= array(						
								array(			     
									'key'     => 'woo_ua_auction_closed',
									'compare' => 'NOT EXISTS',
									),	
								array(
									'key'     => 'woo_ua_auction_started',
									'value' => '0',
								)	
							);						
			}
		
		
		
		
		$args = array(
				'post_type'	=> 'product',
				'post_status' => 'publish',
				'ignore_sticky_posts'	=> 1,
				'posts_per_page'   => $length,
				'offset'           => $offset,
				'orderby'          => 'date',
				'order'            => 'DESC',
				'meta_query' => array($meta_query),
				'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),
				'auction_arhive' => TRUE
			);
			
		if (current_user_can('administrator') or current_user_can('shop_manager')) {		 
			
		} else {
			$curr_user_id = get_current_user_id();
			$args['author__in'] = $curr_user_id;
		}
			$auction_products_array = get_posts( $args );
			// Get Product Count
			$auction_count = 0;
			$filtered_auction_count = 0;		
			$auction_count = count($auction_products_array);
			// Get Filtered Post Count
			$args['posts_per_page'] = -1;
			$args['offset'] = 0;
			$wcfm_filterd_auction_array = get_posts( $args );
			$filtered_auction_count = count($wcfm_filterd_auction_array);
			
			
			
			$wcfm_uwa_auction_json = '';
			$wcfm_uwa_auction_json = '{
																"draw": ' . $_POST['draw'] . ',
																"recordsTotal": ' . $auction_count . ',
																"recordsFiltered": ' . $filtered_auction_count . ',
																"data": ';
			if(!empty($auction_products_array)) {
				
				$index = 0;
				$wcfm_uwa_auction_json_arr = array();
				foreach($auction_products_array as $auction_product) {			
					
					$product_data = new WC_Product_Auction( $auction_product->ID );				
					
					// Thumb				
					$wcfm_uwa_auction_json_arr[$index][] =  $product_data->get_image( 'thumbnail' );
					
					// Title 
					$auction_title = '<a href="'.get_permalink( $auction_product->ID ).'">'.get_the_title(  $auction_product->ID ).'</a>'; 	
					$wcfm_uwa_auction_json_arr[$index][] = $auction_title;
					
					//Start date 
					$starting_on_date = $product_data->get_uwa_auction_start_dates();
					$wcfm_uwa_auction_json_arr[$index][] = mysql2date($datetimeformat,$starting_on_date);
					
					//End date 
					$ending_date = $product_data->get_uwa_auction_end_dates();
					$wcfm_uwa_auction_json_arr[$index][] = mysql2date($datetimeformat,$ending_date);
					
					//Price date 
					$current_price = $product_data->get_price_html();
					$wcfm_uwa_auction_json_arr[$index][] = $current_price;
					
					// View Link				
					$action_view_link = '<a class="wcfm-action-icon" target="_blank" href="'.get_permalink( $auction_product->ID ).'""><span class="wcfmfa fa-eye text_tip" data-tip="View" data-hasqtip="'.$auction_product->ID.'" aria-describedby="qtip-'.$auction_product->ID.'"></span></a><br>';
					
					$action_view_link .= '<a class="wcfm-action-icon" target="_blank" href="'.get_wcfm_edit_product_url( $auction_product->ID,$product_data ).'""><span class="wcfmfa fa-edit text_tip" data-tip="Edit" data-hasqtip="'.$auction_product->ID.'" aria-describedby="qtip-'.$auction_product->ID.'"></span></a><br>';
					
					
					$action_view_link .= '<a class="wcfm-action-icon" target="_blank" href="'.get_wcfm_view_auction_url( $auction_product->ID,$product_data ).'""><span class="wcfmfa fa-info text_tip" data-tip="View Details" data-hasqtip="'.$auction_product->ID.'" aria-describedby="qtip-'.$auction_product->ID.'"></span></a><br>';
					
					$wcfm_uwa_auction_json_arr[$index][] = $action_view_link;
					
					$index++;
				}//end for each
				
				
			} //end 
			if( !empty($wcfm_uwa_auction_json_arr) ) $wcfm_uwa_auction_json .= json_encode($wcfm_uwa_auction_json_arr);
			else $wcfm_uwa_auction_json .= '[]';
			$wcfm_uwa_auction_json .= '
														}';
														
			echo $wcfm_uwa_auction_json;
			die();
	}
	
	add_action('wp_ajax_wcfm_ajax_uwt_auction', 'wcfm_ajax_uwt_auction_callback');
	add_action('wp_ajax_nopriv_wcfm_ajax_uwt_auction', 'wcfm_ajax_uwt_auction_callback');	
	
	/* Also update the status in the auction table when the seller product admin approval setting is turned on in WCFM */
	add_action('transition_post_status', 'send_new_post', 10, 3);
	function send_new_post($new_status, $old_status, $post) {
		if('publish' === $new_status && 'publish' !== $old_status && $post->post_type === 'product') {
			global $wpdb;
			$wpdb->query("update " . UA_AUCTION_PRODUCT_TABLE . " set post_status='$new_status' WHERE  post_id=" . $post->ID);
		}
	}