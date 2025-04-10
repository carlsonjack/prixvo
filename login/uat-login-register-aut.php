<?php
if (!is_user_logged_in()) {

	//Check User confirmation status before login
	$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
	if(!empty($confirmation) && $confirmation=='enable'){
	 add_action('wp_authenticate_user', 'check_validation_for_registration_confirm', 20, 2);
	}
	//Check User approval status before login
	$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
	if(!empty($approval) && $approval=='enable'){
		add_action('wp_authenticate_user', 'check_validation_for_registration_approval', 20, 2);
	}

}

function check_validation_for_registration_confirm($user, $password) {
    $userID = $user->ID;
	$userdata = get_userdata( $userID );
	if ( in_array( 'administrator', (array) $userdata->roles ) || in_array( 'wcfm_vendor', (array) $userdata->roles ) ) {

	} else {
		$status = get_user_meta($userID, 'uat_is_confirmed', true);
		if($status == 'no') {
			$user = new WP_Error();
			$user->add('uat_not_confirmed', __('This account has not been confirm. Please confirm before login.', 'ultimate-auction-pro-software'));
			return $user;
		}
	}


     return $user;
}
function check_validation_for_registration_approval($user, $password) {
	$userID = $user->ID;
	$userdata = get_userdata( $userID );
	if ( in_array( 'administrator', (array) $userdata->roles ) || in_array( 'wcfm_vendor', (array) $userdata->roles ) ) {
	} else {
		$status = get_user_meta($userID, 'uat_is_approved', true);
		if($status == 'no') {
			$user = new WP_Error();
			$user->add('uat_rejected_user', __('Your Account rejected by Admin. Please contact to admin for more.', 'ultimate-auction-pro-software'));
			return $user;
		}
		if($status == 'pending') {
			$user = new WP_Error();
			$user->add('uat_not_approved', __('User has not been Approve By Admin.', 'ultimate-auction-pro-software'));
			return $user;
		}
	}
    return $user;
}


// the hooks to make it all work
add_action( 'init', 'uat_user_login_register_message' );
$confirmation = get_option( 'options_uat_need_registration_confirmation', 'disable' );
if(!empty($confirmation) && $confirmation=='enable'){
	add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
	add_action('user_register', 'uat_user_register_sent_confirm_email',10,2);
}

$approval = get_option( 'options_uat_need_registration_approval', 'disable' );
if(!empty($approval) && $approval=='enable'){
	add_filter('woocommerce_registration_redirect', 'wc_registration_redirect');
	add_action('user_register', 'uat_user_register_sent_approval_admin_email',10,2);
}


function uat_user_login_register_message(){
    if ( isset($_REQUEST['con'])) {
	// If accessed via an authentification link
        $data = unserialize(base64_decode($_GET['con']));
		$code = get_user_meta($data['id'], 'uat_is_confirmed', true);

        $isActivated = get_user_meta($data['id'], 'uat_is_confirmed', true);    // checks if the account has already been activated. We're doing this to prevent someone from logging in with an outdated confirmation link
        if( $isActivated =="yes") {                                                // generates an error message if the account was already active
           if (!is_user_logged_in()) {
			wc_add_notice( __( 'This account has already been activated. Please log in with your username and password.' ), 'error' );
		   }
        }
        else {
            if($code !="yes"){
			// checks whether the decoded code given is the same as the one in the data base
                update_user_meta($data['id'], 'uat_is_confirmed', 'yes');           // updates the database upon successful activation
                $user_id = $data['id'];                                     // logs the user in
                $user = get_user_by( 'id', $user_id );
                if( $user ) {
                   // wp_set_current_user( $user_id, $user->user_login );
                   // wp_set_auth_cookie( $user_id );
                    //do_action( 'wp_login', $user->user_login, $user );
                }
                wc_add_notice( __( '<strong>Success:</strong> Your account has been activated! Please login to use the site to its full extent.' ), 'notice' );
            } else {
                wc_add_notice( __( '<strong>Error:</strong> Account activation failed. Please try again in a few minutes.<br />If the verification fails repeatedly, please contact our administrator.' ), 'error' );
            }
        }
    }

	if ( isset($_REQUEST['approve']) ) {
		$data = unserialize(base64_decode($_REQUEST['approve']));
		$isApproved = get_user_meta($data['id'], 'uat_is_approved', true);

		if( $isApproved =="yes") {
			 wc_add_notice( __( 'This account has already been Approved.' ), 'error' );
		}
		else if( $isApproved !="yes"){
			 update_user_meta($data['id'], 'uat_is_approved', 'yes');
			 wc_add_notice( __( '<strong>Success:</strong> User Approved Successfully.' ), 'notice' );
		} else{
			wc_add_notice( __( '<strong>Error:</strong> Approval failed. Please visit user List page in admin Dashboard.' ), 'error' );

		}
	}
    if(isset($_GET['uat_activate_account_message'])){
        wc_add_notice( __( 'Thank you for creating your account. You will need to confirm your email address in order to activate your account. An email containing the activation link has been sent to your email address. If the email does not arrive within a few minutes, check your spam folder.' ), 'notice' );
    }
}

function wc_registration_redirect( $redirect_to ) {
    wp_logout();
    $redirect_to = wc_get_page_permalink( 'myaccount' );
	$user_id = get_current_user_id();
	wp_redirect( $redirect_to .'?uat_activate_account_message='.$user_id  );
    exit;
}
function uat_user_register_sent_confirm_email($user_id) {
	$check_email = new EmailTracking();
	$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_confirm');
	if( !$email_status )
	{
		$uat_Email = new RegistrationConfirmMail();
		$uat_Email->registration_confirm_email($user_id);
	}
}

function uat_user_register_sent_approval_admin_email($user_id) {
	update_user_meta( $user_id, "uat_is_approved", "pending" );
	$check_email = new EmailTracking();
	$email_status = $check_email->duplicate_email_check($auction_id='0' ,$user_id=$user_id,$email_type='registration_approved_admin');
	if( !$email_status )
	{
		$uat_Email = new RegistrationApprovalAdminMail();
		$uat_Email->registration_approval_admin_email($user_id);
	}
}

// add default email notification user meta on register user
add_action('user_register', 'uat_user_register_email_notification_meta',10,2);
function uat_user_register_email_notification_meta($user_id){
	$uwt_email_placebid_user_enabled_default = "yes";
	$uwt_email_outbid_user_enabled_default = "yes";
	$uwt_email_wonbid_user_enabled_default = "yes";
	$uwt_email_endingsoon_user_enabled_default = "yes";
	$uwt_email_payment_reminder_user_enabled_default = "no";
	
	
	$send_me_the_daily_prixvo_market_briefing = "yes";
	$mailing_about_future_events = "yes";
	$uwt_email_wonbid_user_enabled = "yes";
	$uwt_twilio_whatsapp_won_user_enabled = "yes";
	
	$uwt_twilio_sms_won_user_enabled = "yes";
	$send_new_comments_via_email = "yes";
	$send_new_bids_via_email = "yes";
	$send_new_bids_via_sms = "yes";
	$watchlist_email_me_when_there_is_1_hour_left_to_bid = "yes";
	$watchlist_email_if_new_bids = "yes";
	$email_me_if_mentioned_in_comments = "yes";
	$email_me_on_comment_responses = "yes";
	
	
	
	update_user_meta( $user_id, 'uwt_email_placebid_user_enabled', $uwt_email_placebid_user_enabled_default );
	update_user_meta( $user_id, 'uwt_email_outbid_user_enabled', $uwt_email_outbid_user_enabled_default );
	update_user_meta( $user_id, 'uwt_email_wonbid_user_enabled', $uwt_email_wonbid_user_enabled_default );
	update_user_meta( $user_id, 'uwt_email_endingsoon_user_enabled', $uwt_email_endingsoon_user_enabled_default );
	update_user_meta( $user_id, 'uwt_email_payment_reminder_user_enabled', $uwt_email_payment_reminder_user_enabled_default );
	update_user_meta( $user_id, 'uwt_email_payment_confirmation_user_enabled', $uwt_email_wonbid_user_enabled );
	update_user_meta( $user_id, 'send_me_the_daily_prixvo_market_briefing', $send_me_the_daily_prixvo_market_briefing );
	update_user_meta( $user_id, 'mailing_about_future_events', $mailing_about_future_events );
	update_user_meta( $user_id, 'uwt_twilio_whatsapp_won_user_enabled', $uwt_twilio_whatsapp_won_user_enabled );
	update_user_meta( $user_id, 'uwt_twilio_sms_won_user_enabled', $uwt_twilio_sms_won_user_enabled );
	
	/* Seller */
	
	update_user_meta( $user_id, 'send_new_comments_via_email', $send_new_comments_via_email );
	update_user_meta( $user_id, 'send_new_bids_via_email', $send_new_bids_via_email );
	update_user_meta( $user_id, 'send_new_bids_via_whatsapp', $send_new_bids_via_whatsapp );
	update_user_meta( $user_id, 'send_new_bids_via_sms', $send_new_bids_via_sms );
	update_user_meta( $user_id, 'watchlist_email_me_when_there_is_1_hour_left_to_bid', $watchlist_email_me_when_there_is_1_hour_left_to_bid );
	update_user_meta( $user_id, 'watchlist_email_if_new_bids', $watchlist_email_if_new_bids );
	update_user_meta( $user_id, 'email_me_if_mentioned_in_comments', $email_me_if_mentioned_in_comments );
	update_user_meta( $user_id, 'email_me_on_comment_responses', $email_me_on_comment_responses );
	
	
}