<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $sitepress;
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
$lang=ICL_LANGUAGE_CODE;
$sitepress->switch_lang($lang);
}
if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
	$title = __( 'Product/Lot Detail' );
/**
 * Theme welcome page
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
 wp_enqueue_style( 'uat-theme-events-admin', UAT_THEME_PRO_CSS_URI.'uat-theme-event-admin.css', array(), UAT_THEME_PRO_VERSION );
 ?>
<div class="wrap welcome-wrap uat-admin-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uat_theme_admin_page_title"><?php _e( 'Auction Product Detail', 'ultimate-auction-pro-software' ); ?></h1>
	<?php
	global $wpdb,$post;
	$datetimeformat = get_option('date_format').' '.get_option('time_format');
	$auction_ID = (isset($_REQUEST['p_id'])) ? sanitize_key($_REQUEST['p_id']) : '';
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$auction_ID = icl_object_id($auction_ID,'product',false, ICL_LANGUAGE_CODE);
	}
	//echo "tetete".$auction_ID;
	$auction_status_txt ="";
	global $wpdb;
	$auction_status = $wpdb->get_var('SELECT auction_status FROM '.UA_AUCTION_PRODUCT_TABLE." WHERE post_id=".$auction_ID);
	if($auction_status =="uat_live") {
		$auction_status_txt = "Live";
	} elseif ($auction_status =="uat_future"){
		$auction_status_txt = "Future";
	} else {
		$auction_status_txt = "Expired";
	}
	$product_data = wc_get_product($auction_ID);
    $curent_bid = $product_data->uwa_bid_value();
	$featured_img_url = get_the_post_thumbnail_url($auction_ID, 'full');
	if(empty($featured_img_url)){
	   $featured_img_url = UAT_THEME_PRO_IMAGE_URI."admin/event_default.png";
	}
	$auction_types = get_post_meta($auction_ID, 'woo_ua_auction_type', true);
	$auction_proxy = get_post_meta($auction_ID, 'uwa_auction_proxy', true);
	$auction_silent = get_post_meta($auction_ID, 'uwa_auction_silent', true);
	if($auction_proxy =="yes"){
		$auction_type = __('Proxy', 'ultimate-auction-pro-software');
	}elseif($auction_silent =="yes"){
		$auction_type = __('Silent', 'ultimate-auction-pro-software');
	}else{
		$auction_type = __('Simple', 'ultimate-auction-pro-software');
	}
	$bid_count = $product_data->get_uwa_auction_bid_count();
	if(empty($bid_count)){
		$bid_count = 0;
	}
	$starting_on_date = get_post_meta($auction_ID, 'woo_ua_auction_start_date', true);
	$ending_date = get_post_meta($auction_ID, 'woo_ua_auction_end_date', true);
	$event_id=$product_data->get_event_id();
	$max_bid=$product_data->get_uwa_auction_max_bid();
	?>
	<div class="two-colmun">
		<div class="left-boxes">
			<div class="au-box">
				<h2><a style="line-height: normal;"target="_blank" href="<?php echo get_edit_post_link( $auction_ID ) ;?>"/><?php echo get_the_title( $auction_ID ) ;?></a></h2>
				<?php if(!empty($event_id)){?>
				<h4><span><?php _e( 'Auction Event', 'ultimate-auction-pro-software' ); ?>: </span><a style="line-height: normal;"target="_blank" href="<?php echo get_edit_post_link( $event_id ) ;?>"/><?php echo get_the_title( $event_id ) ;?></a></h4>
				<?php } ?>
				<h4><span><?php _e( 'Auction Status', 'ultimate-auction-pro-software' ); ?>: </span><?php echo $auction_status_txt ;?></h4>
				<h4><span><?php _e( 'Opening Date', 'ultimate-auction-pro-software' ); ?>: </span><?php echo mysql2date($datetimeformat,$starting_on_date);?></h4>
				<h4><span><?php _e( 'Closing Date', 'ultimate-auction-pro-software' ); ?>: </span><?php echo mysql2date($datetimeformat,$ending_date);?></h4>
			</div>
			<div class="au-img-box">
				<img src="<?php echo $featured_img_url ;?>">
			</div>
		</div>
		<div class="right-boxes">
			<?php
			$current_bid_price = get_post_meta($auction_ID, 'woo_ua_auction_current_bid', true);?>
			<div class="small-box">
				<h1><?php echo $auction_type;?></h1>
				<p><?php _e( 'Auction Type', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo $bid_count;?></h1>
				<p><?php _e( 'Total number Bids', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo wc_price($max_bid);?></h1>
				<p><?php _e( 'Max Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php if($auction_status=="uat_live") : ?>
			<div class="small-box">
				<h1><?php echo wc_price($current_bid_price);?></h1>
				<p><?php _e( 'Current Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php endif; ?>
			<?php if($auction_status=="uat_past") : ?>
			<div class="small-box">
			<?php
			$highest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
			?>
				<h1><?php echo wc_price($highest_bid);?></h1>
				<p><?php _e( 'Highest Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php
			$lowest_bid = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` asc limit 1' );
			?>
			<div class="small-box">
				<h1><?php echo wc_price($lowest_bid);?></h1>
				<p><?php _e( 'Lowest Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
			<?php
			$final_bid_amt = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
			?>
				<h1><?php echo wc_price($final_bid_amt);?></h1>
				<p><?php _e( 'Final Bid Amount', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
			<?php
			 $total_earning_amt =0;
			$woo_ua_auction_payed = get_post_meta($auction_ID, 'woo_ua_auction_payed', true);
			if($woo_ua_auction_payed){
				$total_earning_amt = $wpdb->get_var( 'SELECT bid FROM '.$wpdb->prefix.'woo_ua_auction_log  WHERE auction_id =' . $auction_ID .'  ORDER BY  `bid` DESC limit 1');
			}
			?>
				<h1><?php echo wc_price($total_earning_amt);?></h1>
				<p><?php _e( 'Earnings', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php endif; ?>
			<?php if($auction_status=="uat_future") : ?>
			<div class="small-box">
				<h1><?php echo wc_price(get_post_meta($auction_ID, 'woo_ua_opening_price', true));?></h1>
				<p><?php _e( 'Opening Price', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<?php
	 include_once (UAT_THEME_PRO_ADMIN . 'auctions-products/class-bids-list.php');
		uat_bids_list_page_handler_display();
	?>
</div>