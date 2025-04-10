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
global $wpdb, $woocommerce;
global $product;
global $sitepress;
$user_id  = get_current_user_id();
$active_tab = get_query_var('ua-auctions') ? get_query_var('ua-auctions') : 'notification';
$my_auction_page_url = wc_get_endpoint_url('ua-auctions');
?>
<h1>
	<?php _e('Email & Notifications', 'ultimate-auction-pro-software'); ?>
</h1>



<?php
$uat_custom_fields_seller_registration = get_option("options_uat_custom_fields_seller_registration", "no");
if (isset($_POST['uwt-notifications-submit']) == 'Save Changes') {

	if (isset($_POST['uwt_email_outbid_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_outbid_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_outbid_user_enabled', "no");
	}

	if (isset($_POST['uwt_email_wonbid_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_wonbid_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_wonbid_user_enabled', "no");
	}

	if (isset($_POST['uwt_email_placebid_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_placebid_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_placebid_user_enabled', "no");
	}

	if (isset($_POST['uwt_email_endingsoon_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_endingsoon_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_endingsoon_user_enabled', "no");
	}

	if (isset($_POST['uwt_email_payment_reminder_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_payment_reminder_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_payment_reminder_user_enabled', "no");
	}

	if (isset($_POST['uwt_email_payment_confirmation_user_enabled'])) {
		update_user_meta($user_id, 'uwt_email_payment_confirmation_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_email_payment_confirmation_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_whatsapp_outbid_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_outbid_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_outbid_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_whatsapp_won_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_won_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_won_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_whatsapp_ending_soon_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_ending_soon_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_whatsapp_ending_soon_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_sms_outbid_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_sms_outbid_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_sms_outbid_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_sms_won_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_sms_won_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_sms_won_user_enabled', "no");
	}

	if (isset($_POST['uwt_twilio_sms_ending_soon_user_enabled'])) {
		update_user_meta($user_id, 'uwt_twilio_sms_ending_soon_user_enabled', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_sms_ending_soon_user_enabled', "no");
	}
	
	/* NEW CUSTOM META */
	if (isset($_POST['send_me_the_daily_prixvo_market_briefing'])) {
		update_user_meta($user_id, 'send_me_the_daily_prixvo_market_briefing', "yes");
	} else {
		update_user_meta($user_id, 'uwt_twilio_sms_ending_soon_user_enabled', "no");
	}
	if (isset($_POST['mailing_about_future_events'])) {
		update_user_meta($user_id, 'mailing_about_future_events', "yes");
	} else {
		update_user_meta($user_id, 'mailing_about_future_events', "no");
	}
	
	if (isset($_POST['send_new_comments_via_email'])) {
		update_user_meta($user_id, 'send_new_comments_via_email', "yes");
	} else {
		update_user_meta($user_id, 'send_new_comments_via_email', "no");
	}
	if (isset($_POST['send_new_bids_via_email'])) {
		update_user_meta($user_id, 'send_new_bids_via_email', "yes");
	} else {
		update_user_meta($user_id, 'send_new_bids_via_email', "no");
	}
	if (isset($_POST['send_new_bids_via_whatsapp'])) {
		update_user_meta($user_id, 'send_new_bids_via_whatsapp', "yes");
	} else {
		update_user_meta($user_id, 'send_new_bids_via_whatsapp', "no");
	}
	if (isset($_POST['send_new_bids_via_sms'])) {
		update_user_meta($user_id, 'send_new_bids_via_sms', "yes");
	} else {
		update_user_meta($user_id, 'send_new_bids_via_sms', "no");
	}
	
	
	if (isset($_POST['watchlist_email_me_when_there_is_1_hour_left_to_bid'])) {
		update_user_meta($user_id, 'watchlist_email_me_when_there_is_1_hour_left_to_bid', "yes");
	} else {
		update_user_meta($user_id, 'watchlist_email_me_when_there_is_1_hour_left_to_bid', "no");
	}
	
	if (isset($_POST['watchlist_email_if_new_bids'])) {
		update_user_meta($user_id, 'watchlist_email_if_new_bids', "yes");
	} else {
		update_user_meta($user_id, 'watchlist_email_if_new_bids', "no");
	}
	
	if (isset($_POST['email_me_if_mentioned_in_comments'])) {
		update_user_meta($user_id, 'email_me_if_mentioned_in_comments', "yes");
	} else {
		update_user_meta($user_id, 'email_me_if_mentioned_in_comments', "no");
	}
	
	if (isset($_POST['email_me_on_comment_responses'])) {
		update_user_meta($user_id, 'email_me_on_comment_responses', "yes");
	} else {
		update_user_meta($user_id, 'email_me_on_comment_responses', "no");
	}
	
	if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == "yes") {
		$input_values = array();
		$email_tabs = ultimate_auction_pro_seller_emails_tabs();
		foreach ($email_tabs as $tab) {
			$slug = $tab['slug'];
			$input_name = $slug . '_enabled';
			if (isset($_POST[$input_name])) {
				update_user_meta($user_id, $input_name, "yes");
			} else {
				update_user_meta($user_id, $input_name, "no");
			}
		}
	}
} /* end of if - save changes */

$uwt_email_outbid_user_enabled = get_user_meta($user_id, 'uwt_email_outbid_user_enabled', true);
$uwt_email_wonbid_user_enabled = get_user_meta($user_id, 'uwt_email_wonbid_user_enabled', true);
$uwt_email_placebid_user_enabled = get_user_meta($user_id, 'uwt_email_placebid_user_enabled', true);
$uwt_email_endingsoon_user_enabled = get_user_meta($user_id, 'uwt_email_endingsoon_user_enabled', true);
$uwt_email_payment_reminder_user_enabled = get_user_meta($user_id, 'uwt_email_payment_reminder_user_enabled', true);
$uwt_email_payment_confirmation_user_enabled = get_user_meta($user_id, 'uwt_email_payment_confirmation_user_enabled', true);


$send_me_the_daily_prixvo_market_briefing = get_user_meta($user_id, 'send_me_the_daily_prixvo_market_briefing', true);
$mailing_about_future_events = get_user_meta($user_id, 'mailing_about_future_events', true);

$send_new_comments_via_email = get_user_meta($user_id, 'send_new_comments_via_email', true);
$send_new_bids_via_email = get_user_meta($user_id, 'send_new_bids_via_email', true);
$send_new_bids_via_whatsapp = get_user_meta($user_id, 'send_new_bids_via_whatsapp', true);
$send_new_bids_via_sms = get_user_meta($user_id, 'send_new_bids_via_sms', true);

$watchlist_email_me_when_there_is_1_hour_left_to_bid = get_user_meta($user_id, 'watchlist_email_me_when_there_is_1_hour_left_to_bid', true);
$watchlist_email_if_new_bids = get_user_meta($user_id, 'watchlist_email_if_new_bids', true);
$email_me_if_mentioned_in_comments = get_user_meta($user_id, 'email_me_if_mentioned_in_comments', true);
$email_me_on_comment_responses = get_user_meta($user_id, 'email_me_on_comment_responses', true);



$send_me_the_daily_prixvo_market_briefing == "yes" ? $send_me_the_daily_prixvo_market_briefing = "checked" : $send_me_the_daily_prixvo_market_briefing = "";
$mailing_about_future_events == "yes" ? $mailing_about_future_events = "checked" : $mailing_about_future_events = "";

$send_new_comments_via_email == "yes" ? $send_new_comments_via_email = "checked" : $send_new_comments_via_email = "";
$send_new_bids_via_email == "yes" ? $send_new_bids_via_email = "checked" : $send_new_bids_via_email = "";
$send_new_bids_via_whatsapp == "yes" ? $send_new_bids_via_whatsapp = "checked" : $send_new_bids_via_whatsapp = "";
$send_new_bids_via_sms == "yes" ? $send_new_bids_via_sms = "checked" : $send_new_bids_via_sms = "";

$watchlist_email_me_when_there_is_1_hour_left_to_bid == "yes" ? $watchlist_email_me_when_there_is_1_hour_left_to_bid = "checked" : $watchlist_email_me_when_there_is_1_hour_left_to_bid = "";
$watchlist_email_if_new_bids == "yes" ? $watchlist_email_if_new_bids = "checked" : $watchlist_email_if_new_bids = "";
$email_me_if_mentioned_in_comments == "yes" ? $email_me_if_mentioned_in_comments = "checked" : $email_me_if_mentioned_in_comments = "";
$email_me_on_comment_responses == "yes" ? $email_me_on_comment_responses = "checked" : $email_me_on_comment_responses = "";



$uwt_email_outbid_user_enabled == "yes" ? $uwt_email_outbid_checked = "checked" : $uwt_email_outbid_checked = "";
$uwt_email_wonbid_user_enabled == "yes" ? $uwt_email_wonbid_checked = "checked" : $uwt_email_wonbid_checked = "";
$uwt_email_placebid_user_enabled == "yes" ? $uwt_email_placebid_user_enabled = "checked" : $uwt_email_placebid_user_enabled = "";
$uwt_email_endingsoon_user_enabled == "yes" ? $uwt_email_endingsoon_checked = "checked" : $uwt_email_endingsoon_checked = "";
$uwt_email_payment_reminder_user_enabled == "yes" ? $uwt_email_payment_reminder_checked = "checked" : $uwt_email_payment_reminder_checked = "";
$uwt_email_payment_confirmation_user_enabled == "yes" ? $uwt_email_payment_confirmation_checked = "checked" : $uwt_email_payment_confirmation_checked = "";

$uwt_twilio_sms_outbid_user_enabled = get_user_meta($user_id, 'uwt_twilio_sms_outbid_user_enabled', true);
$uwt_twilio_sms_won_user_enabled = get_user_meta($user_id, 'uwt_twilio_sms_won_user_enabled', true);
$uwt_twilio_sms_ending_soon_user_enabled = get_user_meta($user_id, 'uwt_twilio_sms_ending_soon_user_enabled', true);


$uwt_twilio_sms_outbid_user_enabled == "yes" ? $uwt_twilio_sms_outbid_checked = "checked" :
	$uwt_twilio_sms_outbid_checked = "";
$uwt_twilio_sms_won_user_enabled == "yes" ? $uwt_twilio_sms_won_checked = "checked" :
	$uwt_twilio_sms_won_checked = "";
$uwt_twilio_sms_ending_soon_user_enabled == "yes" ? $uwt_twilio_sms_ending_soon_checked = "checked" :
	$uwt_twilio_sms_ending_soon_checked = "";


$uwt_twilio_whatsapp_outbid_user_enabled = get_user_meta($user_id, 'uwt_twilio_whatsapp_outbid_user_enabled', true);
$uwt_twilio_whatsapp_won_user_enabled = get_user_meta($user_id, 'uwt_twilio_whatsapp_won_user_enabled', true);
$uwt_twilio_whatsapp_ending_soon_user_enabled = get_user_meta($user_id, 'uwt_twilio_whatsapp_ending_soon_user_enabled', true);



$uwt_twilio_whatsapp_outbid_user_enabled == "yes" ? $uwt_twilio_whatsapp_outbid_checked = "checked" :
	$uwt_twilio_whatsapp_outbid_checked = "";
$uwt_twilio_whatsapp_won_user_enabled == "yes" ? $uwt_twilio_whatsapp_won_checked = "checked" :
	$uwt_twilio_whatsapp_won_checked = "";
$uwt_twilio_whatsapp_ending_soon_user_enabled == "yes" ? $uwt_twilio_whatsapp_ending_soon_checked = "checked" :
	$uwt_twilio_whatsapp_ending_soon_checked = "";

$ctm_phone = get_user_meta($user_id, 'billing_phone', true);
$billing_country = get_user_meta($user_id, 'billing_country', true);
$message = "";
if (empty($ctm_phone) || empty($billing_country)) {
	$message =  __("Please update your phone and country for receive notification.", "ultimate-auction-pro-software");
	echo '<p class="notification-msg">' . $message . '</p>';
}

?>

<form action="" method="post">
	<h2 class="mr-top-25">
		<?php _e('Email Settings', 'ultimate-auction-pro-software'); ?>
	</h2>
	
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Send me the daily Prixvo market briefing', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="send_me_the_daily_prixvo_market_briefing">
			<input type="checkbox" <?php echo $send_me_the_daily_prixvo_market_briefing; ?> id="send_me_the_daily_prixvo_market_briefing" value="1" name="send_me_the_daily_prixvo_market_briefing">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Join our mailing list to hear about future events, news and promotions.', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="mailing_about_future_events">
			<input type="checkbox" <?php echo $mailing_about_future_events; ?> id="mailing_about_future_events" value="1" name="mailing_about_future_events">
			<div class="checkbox-slider round"></div>
		</label>
	</div> 
	
	
	<h2 class="mr-top-25">
		<?php _e('Buyer Email Notifications', 'ultimate-auction-pro-software'); ?>
	</h2>
	<div class="sep-line"></div>

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Place bid Email', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an email notification when you successfully place a bid on your auction.', 'ultimate-auction-pro-software'); ?></span>*/ ?>
		</div>
		<label class="checkbox_switch" for="uwt_email_placebid_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_placebid_user_enabled; ?> id="uwt_email_placebid_user_enabled" value="1" name="uwt_email_placebid_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e("Email me when I'm Outbid", 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an email notification when you are outbid by another bidder on your auction.', 'ultimate-auction-pro-software'); ?></span>*/ ?>
		</div>
		<label class="checkbox_switch" for="uwt_email_outbid_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_outbid_checked; ?> id="uwt_email_outbid_user_enabled" value="1" name="uwt_email_outbid_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	<?php /* Email me if I do not win the auction */ ?>
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Email me if I do not win the auction', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an email notification when your auction is about to end.', 'ultimate-auction-pro-software'); ?></span>*/ ?>
		</div>
		<label class="checkbox_switch" for="uwt_email_endingsoon_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_endingsoon_checked; ?> id="uwt_email_endingsoon_user_enabled" value="1" name="uwt_email_endingsoon_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Email me if I do not win the auction', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an email notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span>*/ ?>
		</div>
		<label class="checkbox_switch" for="uwt_email_wonbid_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_wonbid_checked; ?> id="uwt_email_wonbid_user_enabled" value="1" name="uwt_email_wonbid_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	
	
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Notify me via WhatsApp as well', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive a WhatsApp notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span>*/ ?>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_whatsapp_won_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_whatsapp_won_checked; ?> id="uwt_twilio_whatsapp_won_user_enabled" value="1" name="uwt_twilio_whatsapp_won_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Notify me via SMS as well', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_sms_won_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_sms_won_checked; ?> id="uwt_twilio_sms_won_user_enabled" value="1" name="uwt_twilio_sms_won_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>


	<?php /*
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Payment Reminder Email', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive an email reminder to make payment for your won auction.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_email_payment_reminder_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_payment_reminder_checked; ?> id="uwt_email_payment_reminder_user_enabled" value="1" name="uwt_email_payment_reminder_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Payment Confirmation Email', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive an email confirmation after successfully completing the payment for your won auction.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_email_payment_confirmation_user_enabled">
			<input type="checkbox" <?php echo $uwt_email_payment_confirmation_checked; ?> id="uwt_email_payment_confirmation_user_enabled" value="1" name="uwt_email_payment_confirmation_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	*/ ?>
	<?php

	if (!empty($uat_custom_fields_seller_registration) && $uat_custom_fields_seller_registration == "yes") {
	?>
		<h2 class="mr-top-25">
			<?php _e('Seller Email Notifications', 'ultimate-auction-pro-software'); ?>
		</h2>
		<div class="sep-line"></div>
		<?php
		// Generate the input fields based on the function.
		/*$email_tabs = ultimate_auction_pro_seller_emails_tabs();
		foreach ($email_tabs as $tab) {
			$slug = $tab['slug'];
			$user_label = $tab['user_label'];
			$hint = $tab['hint'];
			$input_name = $slug . '_enabled';
			$email_notification_seller_enabled = get_user_meta($user_id, $input_name, true);
			$email_notification_seller_enabled == "yes" ? $email_notification_seller_checked = "checked" : $email_notification_seller_checked = "";
		?>
			<div class="lable-with-switch">
				<div class="notification-lable">
					<?php echo $user_label; ?>
					<span class="notification-sub-lable"><?php echo $hint; ?></span>
				</div>
				<label class="checkbox_switch" for="<?php echo $input_name; ?>">
					<input type="checkbox" id="<?php echo $input_name; ?>" <?php echo $email_notification_seller_checked; ?> value="1" name="<?php echo $input_name; ?>">
					<div class="checkbox-slider round"></div>
				</label>
			</div>
	<?php
		} */
		?>
		
		
		<div class="lable-with-switch">
			<div class="notification-lable">
				<?php _e('Send new comments via email', 'ultimate-auction-pro-software'); ?>
				<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
			</div>
			<label class="checkbox_switch" for="send_new_comments_via_email">
				<input type="checkbox" <?php echo $send_new_comments_via_email ; ?> id="send_new_comments_via_email" value="1" name="send_new_comments_via_email">
				<div class="checkbox-slider round"></div>
			</label>
		</div>
		<div class="lable-with-switch">
			<div class="notification-lable">
				<?php _e('Send new bids via email', 'ultimate-auction-pro-software'); ?>
				<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
			</div>
			<label class="checkbox_switch" for="send_new_bids_via_email">
				<input type="checkbox" <?php echo $send_new_bids_via_email; ?> id="send_new_bids_via_email" value="1" name="send_new_bids_via_email">
				<div class="checkbox-slider round"></div>
			</label>
		</div>
		<div class="lable-with-switch">
			<div class="notification-lable">
				<?php _e('Notify me via WhatsApp as well', 'ultimate-auction-pro-software'); ?>
				<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
			</div>
			<label class="checkbox_switch" for="send_new_bids_via_whatsapp">
				<input type="checkbox" <?php echo $send_new_bids_via_whatsapp; ?> id="send_new_bids_via_whatsapp" value="1" name="send_new_bids_via_whatsapp">
				<div class="checkbox-slider round"></div>
			</label>
		</div>
		<div class="lable-with-switch">
			<div class="notification-lable">
				<?php _e('Notify me via SMS as well', 'ultimate-auction-pro-software'); ?>
				<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
			</div>
			<label class="checkbox_switch" for="send_new_bids_via_sms">
				<input type="checkbox" <?php echo $send_new_bids_via_sms; ?> id="send_new_bids_via_sms" value="1" name="send_new_bids_via_sms">
				<div class="checkbox-slider round"></div>
			</label>
		</div>
		
		


		


		
	<?php 	
	}
	?>

	<h2 class="mr-top-25">
		<?php _e('Other Notification Settings', 'ultimate-auction-pro-software'); ?>
	</h2>
	<div class="sep-line"></div>

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Watchlist: Email me when there is 1 hour left to bid', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
		</div>
		<label class="checkbox_switch" for="watchlist_email_me_when_there_is_1_hour_left_to_bid">
			<input type="checkbox" <?php echo $watchlist_email_me_when_there_is_1_hour_left_to_bid; ?> id="watchlist_email_me_when_there_is_1_hour_left_to_bid" value="1" name="watchlist_email_me_when_there_is_1_hour_left_to_bid">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	<?php /*Watchlist: Email me if there are new bids */ ?>
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Watchlist: Email me if there are new bids', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
		</div>
		<label class="checkbox_switch" for="watchlist_email_if_new_bids">
			<input type="checkbox" <?php echo $watchlist_email_if_new_bids; ?> id="watchlist_email_if_new_bids" value="1" name="watchlist_email_if_new_bids">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Email me if I am mentioned in any comments', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
		</div>
		<label class="checkbox_switch" for="email_me_if_mentioned_in_comments">
			<input type="checkbox" <?php echo $email_me_if_mentioned_in_comments; ?> id="email_me_if_mentioned_in_comments" value="1" name="email_me_if_mentioned_in_comments">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Email me if someone responds to me in a comment', 'ultimate-auction-pro-software'); ?>
			<?php /*<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you win your auction and need to complete the purchase.', 'ultimate-auction-pro-software'); ?></span> */ ?>
		</div>
		<label class="checkbox_switch" for="email_me_on_comment_responses">
			<input type="checkbox" <?php echo $email_me_on_comment_responses; ?> id="email_me_on_comment_responses" value="1" name="email_me_on_comment_responses">
			<div class="checkbox-slider round"></div>
		</label>
	</div>
	

	
	<?php /*
	
	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Outbid SMS', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive an SMS notification when you are outbid by another bidder on your auction.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_sms_outbid_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_sms_outbid_checked; ?> id="uwt_twilio_sms_outbid_user_enabled" value="1" name="uwt_twilio_sms_outbid_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>

	

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Ending soon SMS', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive an SMS notification when your auction is about to end.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_sms_ending_soon_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_sms_ending_soon_checked; ?> id="uwt_twilio_sms_ending_soon_user_enabled" value="1" name="uwt_twilio_sms_ending_soon_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>


	<h2 class="mr-top-25">
		<?php _e('Whatsapp Notifications', 'ultimate-auction-pro-software'); ?>
	</h2>
	<div class="sep-line"></div>

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Outbid WhatsApp', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive a WhatsApp notification when you are outbid by another bidder on your auction.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_whatsapp_outbid_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_whatsapp_outbid_checked; ?> id="uwt_twilio_whatsapp_outbid_user_enabled" value="1" name="uwt_twilio_whatsapp_outbid_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>

	

	<div class="lable-with-switch">
		<div class="notification-lable">
			<?php _e('Enable Ending soon WhatsApp', 'ultimate-auction-pro-software'); ?>
			<span class="notification-sub-lable"><?php _e('Receive a WhatsApp notification when your auction is about to end.', 'ultimate-auction-pro-software'); ?></span>
		</div>
		<label class="checkbox_switch" for="uwt_twilio_whatsapp_ending_soon_user_enabled">
			<input type="checkbox" <?php echo $uwt_twilio_whatsapp_ending_soon_checked; ?> id="uwt_twilio_whatsapp_ending_soon_user_enabled" value="1" name="uwt_twilio_whatsapp_ending_soon_user_enabled">
			<div class="checkbox-slider round"></div>
		</label>
	</div>*/ ?>


	<div class="mr-top-25">
		<input type="submit" id="uwt-notifications-submit" name="uwt-notifications-submit" class="woocommerce-Button woocommerce-Button--alt button alt" value="<?php _e('Save Changes', "ultimate-auction-pro-software"); ?>" />
	</div>
</form>