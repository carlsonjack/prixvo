<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Admin Email Setting page
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */


	wp_enqueue_style( 'wp-color-picker' );
    // wp_enqueue_script( 'my-script-handle', plugins_url('my-script.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
 ?>
 <div class="wrap welcome-wrap uat-admin-wrap">

		<?php
		$link_head = isset($_GET['email_for']) ? $_GET['email_for'] : 'buyer';
		if ($active_tab == 'uat-auctions-emails') {
		?>
		<ul class="subsubsub" style="width: 100%;">
			<li><a href="?page=ua-auctions-emails&email_type=email_settings&email_for=buyer" class="<?php echo $link_head == 'buyer' ? 'current' : '';?>">Buyer</a>|</li>
			<li><a href="?page=ua-auctions-emails&email_type=email_settings&email_for=seller" class="<?php echo $link_head == 'seller' ? 'current' : '';?>">Seller</a></li>
		</ul>
		<ul class="subsubsub">
			<?php
			$email_tabs = [];
			if($link_head=='buyer'){
				$email_tabs = apply_filters('ua_add_email_templates_tabs', ultimate_auction_pro_emails_tabs());
				$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
				/*Confirm new user while registration*/
				if(!empty($confirmation) && $confirmation=='disable'){
				unset($email_tabs[1]);
				}
				$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
				/*uat_registration_confirmation*/
				if(!empty($approval) && $approval=='disable'){
					foreach(array_keys($email_tabs) as $key) {
					unset($email_tabs[2]);
					unset($email_tabs[3]);
					unset($email_tabs[4]);
					}

				}
			}			
			$link = isset($_GET['email_type']) ? $_GET['email_type'] : 'email_settings';		
			if($link_head=='seller'){
				$email_tabs = apply_filters('ua_add_seller_email_templates_tabs', ultimate_auction_pro_seller_emails_tabs());
			}

			?>
			<li><a href="?page=ua-auctions-emails&email_type=email_settings&email_for=<?php echo $link_head;?>" class="<?php echo $link == 'email_settings' ? 'current' : '';?>"><?php _e('Email Settings', 'ultimate-auction-pro-software');?></a>|</li>
			<?php foreach ($email_tabs as $email_tab) { ?>
				<li><a href="?page=ua-auctions-emails&email_type=<?php echo $email_tab['slug'];?>&email_for=<?php echo $link_head;?>" class="<?php echo $link == $email_tab['slug'] ? 'current' : '';?>"><?php echo $email_tab['label'];?></a>|</li>
			<?php } ?>
			
			<?php if (function_exists('car_email_template')) { car_email_template(); } ?>
		</ul>
 
	<br class="clear">
	<?php
	$email_type_tab = isset($_GET['email_type']) ? $_GET['email_type'] : 'email_settings';
	
	if($email_type_tab=='email_settings'){
		include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/emails-setting.php');
	}
	if($link_head=='buyer'){
		if($email_type_tab=='email_save_search'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/save-search-email.php');
		}

		if( $email_type_tab == 'registration_confirm' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/registration-confirm.php');
		}
		if( $email_type_tab == 'place_bid' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/place-bid.php');
		}
		if( $email_type_tab == 'registration_reject' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/registration-reject.php');
		}
		if( $email_type_tab == 'registration_approved' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/registration-approved.php');
		}
		if( $email_type_tab == 'registration_approved_admin' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/registration-approved-admin.php');
		}

		if( $email_type_tab == 'answer' ) {
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/answer.php');
		}

		if( $email_type_tab == 'question' ) {
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/question.php');
		}
		if( $email_type_tab == 'outbid' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/outbid.php');
		}

		if( $email_type_tab == 'won_bid' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/won-bid.php');
		}
		if( $email_type_tab == 'loose_bid' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/loose-bid.php');
		}

		if( $email_type_tab == 'payment_reminder' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/payment-reminder.php');
		}
		if( $email_type_tab == 'payment_confirmation' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/payment-confirmation.php');
		}

		if( $email_type_tab == 'ending_soon' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/ending_soon.php');
		}
		if( $email_type_tab == 'payment_hold' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/payment_hold.php');
		}
	
		if( $email_type_tab == 'password_reset' ) {

			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/password-reset.php');
		}
	}
	if($link_head=='seller'){
		if($email_type_tab=='uat_submited_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/submitted_mail.php');
		}
		if($email_type_tab=='uat_under_review_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/under_review_mail.php');
		}
		if($email_type_tab=='uat_not_approved_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/not_approved_mail.php');
		}
		if($email_type_tab=='uat_change_needed_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/change_needed_mail.php');
		}
		if($email_type_tab=='uat_approved_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/approved_mail.php');
		}
		if($email_type_tab=='uat_planned_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/planned_mail.php');
		}
		if($email_type_tab=='uat_in_auction_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/in_auction_mail.php');
		}
		if($email_type_tab=='uat_auctined_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/auctined_mail.php');
		}
		if($email_type_tab=='uat_not_sold_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/not_sold_mail.php');
		}
		if($email_type_tab=='uat_payment_received_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/payment_received_mail.php');
		}
		if($email_type_tab=='uat_paid_mail'){
			include_once (UAT_THEME_PRO_ADMIN . 'emails/tabs/seller-mail/paid_mail.php');
		}
	}
}
	?>

</div>