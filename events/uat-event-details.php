<?php
/**
 * Theme welcome page
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $sitepress;
if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
$lang=ICL_LANGUAGE_CODE;
$sitepress->switch_lang($lang);
}
if ( ! current_user_can( 'manage_options' ) )
	wp_die( __( 'You do not have sufficient permissions to manage options for this site.', 'ultimate-auction-pro-software' ) );
 $title = __( 'Event Detail ', 'ultimate-auction-pro-software' );
 wp_enqueue_style( 'uat-theme-events-admin', UAT_THEME_PRO_CSS_URI.'uat-theme-event-admin.css', array(), UAT_THEME_PRO_VERSION );
?>
<div class="wrap welcome-wrap uat-admin-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uat_theme_admin_page_title"><?php _e( 'Event Detail', 'ultimate-auction-pro-software' ); ?>
	<a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), '/edit.php?post_type=uat_event');?>"><?php _e('Back to List', 'ultimate-auction-pro-software')?></a>
	</h1>
	<?php
	global $wpdb,$post;
	$datetimeformat = get_option('date_format').' '.get_option('time_format');
	$event_id = $_REQUEST['event_id'];
	if (function_exists('icl_object_id') && method_exists($sitepress, 'get_default_language')) {
		$event_id = icl_object_id($event_id,'product',false, ICL_LANGUAGE_CODE);
	}
	$event_status = uat_get_event_status($event_id);
	$uat_expired = uat_event_is_past_event($event_id);
	$uat_live = uat_event_is_live($event_id);
	 if(($uat_expired === FALSE ) and ($uat_live  === TRUE )) :
		$event_status_txt = "Live Event";
	elseif (($uat_expired === FALSE ) and ($uat_live  === FALSE )):
		$event_status_txt = "Future Event";
	else :
		$event_status_txt = "Past Event";
	endif;
	$event_type_txt="";
	$event_type = get_post_meta($event_id, 'uat_type_of_auction_event', true);
	if ($event_type == "uat_event_live") {
		$event_type_txt = esc_html__("Live Event", 'ultimate-auction-pro-software');
	}
	if ($event_type == "uat_event_timed") {
		$event_type_txt =  esc_html__("Timed Event", 'ultimate-auction-pro-software');
	}
	$featured_img_url = get_the_post_thumbnail_url($event_id, 'full');
	if(empty($featured_img_url)){
	   $featured_img_url = UAT_THEME_PRO_IMAGE_URI."admin/event_default.png";
	}
	$starting_on_date = get_post_meta($event_id, 'start_time_and_date', true);
	$ending_date = get_post_meta($event_id, 'end_time_and_date', true);
	?>
	<div class="two-colmun">
		<div class="left-boxes">
			<div class="au-box">
				<h3><?php echo $event_status_txt;?></h3>
				<h2><a style="line-height: normal;"target="_blank" href="<?php echo get_permalink( $event_id ) ;?>"/><?php echo get_the_title( $event_id ) ;?></a></h2>
				<h4><span><?php _e( 'Event Type', 'ultimate-auction-pro-software' ); ?>:</span><?php echo $event_type_txt ;?></h4>
				<h4><span><?php _e( 'Opening Date', 'ultimate-auction-pro-software' ); ?>:</span><?php echo mysql2date($datetimeformat,$starting_on_date);?></h4>
				<h4><span><?php _e( 'Closing Date', 'ultimate-auction-pro-software' ); ?>:</span><?php echo mysql2date($datetimeformat,$ending_date);?></h4>
				<h4><span><?php _e( 'Total Products', 'ultimate-auction-pro-software' ); ?>:</span><?php echo uat_get_event_total_no_products( $event_id ) ;?></h4>
				<h4><span><?php _e( 'Category', 'ultimate-auction-pro-software' ); ?>:</span><?php echo uat_get_event_Categories( $event_id ) ;?></h4>
			</div>
			<div class="au-img-box">
				<img src="<?php echo $featured_img_url ;?>">
			</div>
		</div>
		<div class="right-boxes">
			<?php
			if(($uat_expired === TRUE ) OR ($uat_live  === TRUE )) : ?>
			<div class="small-box">
				<h1><?php echo uat_get_event_total_no_bids( $event_id );?></h1>
				<p><?php _e( 'Total number of Event Bids', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo wc_price( uat_get_event_highest_bids( $event_id )) ;?></h1>
				<p><?php _e( 'Highest Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo wc_price(uat_get_event_lowest_bids( $event_id )) ;?></h1>
				<p><?php _e( 'Lowest Bid', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo uat_get_saved_count( $event_id ) ;?></h1>
				<p><?php _e( 'Number of Saved', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<?php endif; ?>
		<?php
		/* Features */
		/* Bid Increment */
		$enable_inc = get_post_meta($event_id, 'uat_enable_bid_increment', true);
		$inc_type = get_post_meta($event_id, 'uat_set_bid_incremental_type', true);
		$inc_type_txt = "NA";
		if($enable_inc=="yes"){
			if ($inc_type == "fix_inc") {
				$inc_type_txt = esc_html__("Flat Price", 'ultimate-auction-pro-software');
			}
			if ($inc_type == "var_inc") {
				$inc_type_txt = esc_html__("Variable Price", 'ultimate-auction-pro-software');
			}
		}
		/* Soft-Close */
		$enable_anti_sniping = get_post_meta($event_id, 'uat_enable_anti_sniping', true);
		if($enable_anti_sniping=="no"){
			$enable_anti_sniping ="NA";
		}
		/* Buyer's Premium */
		$enable_bp = __( 'Yes', 'ultimate-auction-pro-software' );;
		$uat_enable_buyers_premium_ge = get_option('options_uat_enable_buyers_premium_ge', "");
		if ($uat_enable_buyers_premium_ge == "yes") {
			$enable_bp_enabled = get_post_meta($event_id, 'uat_enable_buyers_premium', true);
			if($enable_bp_enabled=="no"){
				$enable_bp ="NA";
			}
		}else{
			$enable_bp ="NA";
		}
		/* Credit Card */
		$hold_enable = get_post_meta($event_id, 'uat_event_auto_debit_hold_enable', true);
		if($hold_enable=="no" || empty($hold_enable)){
			$hold_enable ="NA";
			$enable_auto_debit ="Yes";
		} else {
			$enable_auto_debit ="NA";
		}
		?>
			<div class="small-box">
				<h1><?php echo $inc_type_txt ;?></h1>
				<p><?php _e( 'Bid Increment Type', 'ultimate-auction-pro-software' ); ?></p>
			</div>
			<div class="small-box">
				<h1><?php echo ucfirst($enable_anti_sniping) ;?></h1>
				<p><?php _e( 'Enable Soft-Close', 'ultimate-auction-pro-software' ); ?></p>
			</div>
				<div class="small-box">
				<h1><?php echo ucfirst($enable_bp) ;?></h1>
				<p><?php _e( "Enable Buyer's Premium", 'ultimate-auction-pro-software' ); ?></p>
			</div>
				<div class="small-box">
				<h1><?php echo ucfirst($hold_enable) ;?></h1>
				<p><?php _e( 'Hold the bidding amount', 'ultimate-auction-pro-software' ); ?></p>
			</div>
				<div class="small-box">
				<h1><?php echo ucfirst($enable_auto_debit) ;?></h1>
				<p><?php _e( 'Enable Credit Card', 'ultimate-auction-pro-software' ); ?></p>
			</div>
		</div>
	</div>
	<?php
	 include_once (UAT_THEME_PRO_ADMIN . 'events/class-events-detail-table.php');
		uat_auctions_events_detail_list_display();
	?>
</div>