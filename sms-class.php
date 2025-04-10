<?php
if (!defined('ABSPATH')) {
    exit;
}
class TwilioSMS{
    // public function __construct(){

    // }
    public function outbidsms($product_id, $outbiddeduser)
	{
        if( empty($product_id) || empty($outbiddeduser) )
        {
            return false;
        }
        $uwt_twilio_sms_sid = get_option('uwt_twilio_sms_sid');
        $uwt_twilio_sms_token = get_option('uwt_twilio_sms_token');
        $uwt_twilio_sms_from_number = get_option('uwt_twilio_sms_from_number');
        if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_sms_from_number) )
        {
            return false;
        }
        $uwt_twilio_sms_outbid_user_enabled = get_user_meta($outbiddeduser,'uwt_twilio_sms_outbid_user_enabled', true);
        if( $uwt_twilio_sms_outbid_user_enabled != "yes" )
        {
            return false;
        }
        $uwt_twilio_sms_outbid_enabled = get_option('uwt_twilio_sms_outbid_enabled');
            if($uwt_twilio_sms_outbid_enabled == "yes"){
                global $wpdb, $woocommerce, $post;
                if ($outbiddeduser) {

                    $message = "";
                    $billing_country = "";
                   

                    $product = wc_get_product($product_id);
                    $currency_symbol = get_woocommerce_currency();
                    $auction_bid_value = $currency_symbol." ".$product->get_uwa_current_bid();
                    $product_id =  $product->get_id();
                    $auction_title = $product->get_title();
                    $sorturl = get_post_meta($product_id, 'uat_sort_link', true);
                    if( $sorturl == "" ){
                        $link = get_permalink($product->get_id());
                    }else{
                        $link = esc_url( home_url( '/?uaturl='.$sorturl ) );
                    }
                    $customer_id = $outbiddeduser;

                    $ctm_phone = get_user_meta( $customer_id, 'billing_phone', true );
                    $billing_country = get_user_meta( $customer_id, 'billing_country', true );
                    if( empty($ctm_phone) || empty($billing_country) )
                    {
                        return false;
                    }
                    $to = uwt_twilio_sm_format_e164( $ctm_phone, $billing_country );

                    $uwt_message_pp = get_option('uwt_twilio_sms_outbid_template',"You have been outbid on product id {product_id}, title {product_name}. The current highest bid is {bid_value}. Open {link} and place your bid.");

                    $uwt_message_pp = str_replace('{bid_value}', $auction_bid_value, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_name}',$auction_title, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{link}', $link, $uwt_message_pp);
                    $message .= $uwt_message_pp;
                    $this->plugin_log( 'sending sms for outbid...' );

                    require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );
                    $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                    try {
                        $fmessage = $client->messages->create( $to, array(
                            'from' => $uwt_twilio_sms_from_number,
                            'body' => $message,
                             ) );
                            $uat_auction_activity = new Uat_Auction_Activity();
                            $fmessage->url = "https://api.twilio.com".$fmessage->uri;
                            $fmessage->status = $fmessage->status;
                            $activity_data = array(
                                'post_parent'	=> $product_id,
                                'activity_name'	=> "Outbid sms",
                                'activity_type'	=> 'ua_api_requests_logs',
                                'activity_data'	=> json_encode($fmessage),
                            );
                            $activity_meta = array(
                                'api_name'	=> "https://api.twilio.com".$fmessage->uri,
                                'api_sms_sid'	=> $fmessage->sid,
                                'api_response_status'	=> $fmessage->status,
                                'api_sms_to_user_id'	=> $customer_id,
                            );
                            $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        $this->plugin_log($fmessage);
                        $this->plugin_log( 'sended sms for outbid successfully.' );

                    }
                    catch( \Exception $e ) {
                        $uat_auction_activity = new Uat_Auction_Activity();

                        $activity_data = array(
                            'post_parent'	=> $product_id,
                            'activity_name'	=> "Outbid sms",
                            'activity_type'	=> 'ua_api_requests_logs',
                            'activity_data'	=> json_encode($e->getMessage()),
                        );
                        $activity_meta = array(
                            'api_name'	=> "https://api.twilio.com",
                            'api_sms_sid'	=> "",
                            'api_response_status'	=> "failed",
                            'api_sms_to_user_id'	=> $customer_id,
                        );
                        $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        $this->plugin_log($e->getMessage());
                    }
                }
            }
    }

    public function wonbidsms($auction_id, $customer_id,$order = "")
	{
            if( empty($auction_id) || empty($customer_id) )
            {
                return false;
            }
            $uwt_twilio_sms_sid = get_option('uwt_twilio_sms_sid');
            $uwt_twilio_sms_token = get_option('uwt_twilio_sms_token');
            $uwt_twilio_sms_from_number = get_option('uwt_twilio_sms_from_number');
            if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_sms_from_number) )
            {
                return false;
            }
            $uwt_twilio_sms_won_user_enabled = get_user_meta($customer_id,'uwt_twilio_sms_won_user_enabled', true);
            if( $uwt_twilio_sms_won_user_enabled != "yes" )
            {
                return false;
            }
            global $wpdb, $woocommerce, $post;
            $uwt_twilio_sms_won_enabled = get_option('uwt_twilio_sms_won_enabled');
            if($uwt_twilio_sms_won_enabled == "yes"){
                $sms_sent_status = get_post_meta( $auction_id, '_uwt_won_sms_sent_status', true );
                $auto_one_time_sms = get_post_meta( $auction_id, '_done_one_time_sms', true );

                if($auto_one_time_sms!='done_one_time_sms_1'){
                        add_post_meta($auction_id, '_done_one_time_sms','done_one_time_sms_0');
                }

                if($sms_sent_status !="sent"){
                    if($auto_one_time_sms !="done_one_time_sms_1" ){
                        update_post_meta($auction_id, '_done_one_time_sms' ,"done_one_time_sms_1");

                        $message = "";
                        $billing_country = "";
                     

                            $product = wc_get_product($auction_id);
                            $product_id =  $product->get_id();
                            $auction_title = $product->get_title();
                            // $customer_id = $product->get_uwa_auction_current_bider();

                            $ctm_phone = get_user_meta( $customer_id, 'billing_phone', true );
                            $billing_country = get_user_meta( $customer_id, 'billing_country', true );
                            if( empty($ctm_phone) || empty($billing_country) )
                            {
                                return false;
                            }
                            $to = uwt_twilio_sm_format_e164( $ctm_phone, $billing_country );
                            // $WC_Order = new WC_Order($order);

                            // $checkout_url = $WC_Order->get_checkout_payment_url();
                            $checkout_url = wc_get_checkout_url();
                            $uwt_message_pp = get_option('uwt_twilio_sms_won_template',
                                "You have won auction product id {product_id}, title {product_name}. Click {this_pay_link} to pay.");

                            $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                            $uwt_message_pp = str_replace('{product_name}', $auction_title, $uwt_message_pp);
                            $uwt_message_pp = str_replace('{this_pay_link}', $checkout_url, $uwt_message_pp);

                            $message .= $uwt_message_pp;
                            $this->plugin_log( 'sending sms for winbid...' );

                            require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );
                            $uat_auction_activity = new Uat_Auction_Activity();
                            $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                            try {
                                $fmessage = $client->messages->create( $to, array(
                                    'from' => $uwt_twilio_sms_from_number,
                                    'body' => $message,
                                     ));
                                    $sms_sent_status_metakey = "_uwt_won_sms_sent_status";
                                    update_post_meta($product_id, $sms_sent_status_metakey,"sent");
                                    $fmessage->url = "https://api.twilio.com".$fmessage->uri;
                                    $fmessage->status = $fmessage->status;
                                    $activity_data = array(
                                        'post_parent'	=> $product_id,
                                        'activity_name'	=> "Win bid sms",
                                        'activity_type'	=> 'ua_api_requests_logs',
                                        'activity_data'	=> json_encode($fmessage),
                                    );
                                    $activity_meta = array(
                                        'api_name'	=> "https://api.twilio.com".$fmessage->uri,
                                        'api_sms_sid'	=> $fmessage->sid,
                                        'api_response_status'	=> $fmessage->status,
                                        'api_sms_to_user_id'	=> $customer_id,
                                    );
                                    $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                    $this->plugin_log( 'sended sms for wonbid successfully.' );

                            }
                            catch( \Exception $e ) {
                                $uat_auction_activity = new Uat_Auction_Activity();

                                $activity_data = array(
                                    'post_parent'	=> $product_id,
                                    'activity_name'	=> "Win bid sms",
                                    'activity_type'	=> 'ua_api_requests_logs',
                                    'activity_data'	=> json_encode($e->getMessage()),
                                );
                                $activity_meta = array(
                                    'api_name'	=> "https://api.twilio.com",
                                    'api_sms_sid'	=> "",
                                    'api_response_status'	=> "failed",
                                    'api_sms_to_user_id'	=> $customer_id,
                                );
                                $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                $this->plugin_log($e->getMessage());
                                $response['message'] =  $e->getMessage();
                                $this->plugin_log( "SMS Sent Won Error: " . $e->getMessage()." Auction ID=".$product_id);
                            }




                    }
                }
            }

    }

    public function ending_soon_sms($product_id = ""){
        global $wpdb;
        if( empty($product_id) )
        {
            return false;
        }
        $uwt_twilio_sms_sid = get_option('uwt_twilio_sms_sid');
        $uwt_twilio_sms_token = get_option('uwt_twilio_sms_token');
        $uwt_twilio_sms_from_number = get_option('uwt_twilio_sms_from_number');
        if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_sms_from_number) )
        {
            return false;
        }
        $product = wc_get_product($product_id);
        $product_id =  $product->get_id();
            $ending_auction_users = $wpdb->get_results("SELECT DISTINCT userid
                    FROM ". $wpdb->prefix ."woo_ua_auction_log
                    WHERE auction_id = ". $product_id);

                    $message = "";
                    $billing_country = "";
                   


                    $auction_title = $product->get_title();
                    $sorturl = get_post_meta($product_id, 'uat_sort_link', true);
                    if( $sorturl == "" ){
                        $link = get_permalink($product->get_id());
                    }else{
                        $link = esc_url( home_url( '/?uaturl='.$sorturl ) );
                    }

                    $uwt_message_pp = get_option('uwt_twilio_sms_ending_soon_template',"Auction id {product_id}, title {product_name} will be expiring soon. Place your highest bid to win it.");
                    $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_name}', $auction_title, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{link}', $link, $uwt_message_pp);
                    $message .= $uwt_message_pp;
                    if (  count($ending_auction_users) > 0 ) {
                        require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );


                        foreach ( $ending_auction_users as $user) {
                            $customer_id = $user->userid;
                            $uwt_twilio_sms_ending_soon_user_enabled = get_user_meta($customer_id,'uwt_twilio_sms_ending_soon_user_enabled', true);
                            if( $uwt_twilio_sms_ending_soon_user_enabled != "yes" )
                            {
                                continue;
                            }
                            $ctm_phone = get_user_meta( $customer_id, 'billing_phone', true );
                            $billing_country = get_user_meta( $customer_id, 'billing_country', true );
                            if( empty($ctm_phone) || empty($billing_country) )
                            {
                               continue;
                            }
                            $to = uwt_twilio_sm_format_e164( $ctm_phone, $billing_country );

                            $this->plugin_log( 'sending sms for ending soon...' );
                            $uat_auction_activity = new Uat_Auction_Activity();
                            $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                            try {
                                $fmessage = $client->messages->create( $to, array(
                                    'from' => $uwt_twilio_sms_from_number,
                                    'body' => $message,
                                     ) );

                                $fmessage->url = "https://api.twilio.com".$fmessage->uri;
                                $fmessage->status = $fmessage->status;
                                $activity_data = array(
                                    'post_parent'	=> $product_id,
                                    'activity_name'	=> "Ending soon sms",
                                    'activity_type'	=> 'ua_api_requests_logs',
                                    'activity_data'	=> json_encode($fmessage),
                                );
                                $activity_meta = array(
                                    'api_name'	=> "https://api.twilio.com".$fmessage->uri,
                                    'api_sms_sid'	=> $fmessage->sid,
                                    'api_response_status'	=> $fmessage->status,
                                    'api_sms_to_user_id'	=> $customer_id,
                                );
                                $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                $this->plugin_log($fmessage);
                                $this->plugin_log( 'sended sms for ending soon successfully.'.$fmessage->sid." status : ".$fmessage->uri );

                            }
                            catch( \Exception $e ) {
                                $uat_auction_activity = new Uat_Auction_Activity();

                                $activity_data = array(
                                    'post_parent'	=> $product_id,
                                    'activity_name'	=> "Ending soon sms",
                                    'activity_type'	=> 'ua_api_requests_logs',
                                    'activity_data'	=> json_encode($e->getMessage()),
                                );
                                $activity_meta = array(
                                    'api_name'	=> "https://api.twilio.com",
                                    'api_sms_sid'	=> "",
                                    'api_response_status'	=> "failed",
                                    'api_sms_to_user_id'	=> $customer_id,
                                );
                                $activity_api_log = $uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                $this->plugin_log($e->getMessage());
                            }
                        }
                        return true;
                    }

    }

    public function uwt_auction_get_checkout_url() {

        $checkout_page_id = wc_get_page_id('checkout');
        $checkout_url     = '';

        if ( $checkout_page_id ) {

            if ( is_ssl() || get_option('woocommerce_force_ssl_checkout') == 'yes' )
                $checkout_url = str_replace( 'http:', 'https:', get_permalink( $checkout_page_id ) );

            else
                $checkout_url = get_permalink( $checkout_page_id );
        }
        return apply_filters( 'woocommerce_get_checkout_url', $checkout_url );
    }

    public function plugin_log( $entry, $mode = 'a', $file = 'theme-uat' ) {
        return false;
        // Get WordPress uploads directory.
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];

        // If the entry is array, json_encode.
        if ( is_array( $entry ) ) {
          $entry = json_encode( $entry );
        }

        // Write the log file.
        $file  = $upload_dir . '/' . $file . '.log';
        $file  = fopen( $file, $mode );
        $bytes = fwrite( $file, current_time( 'mysql' ) . "::" . $entry . "\n" );
        fclose( $file );

        return $bytes;
      }
}

add_action("wp_ajax_uwt_twilio_send_test_sms", "uwt_twilio_send_test_sms_ajxa_callback");
add_action("wp_ajax_nopriv_uwt_twilio_send_test_sms", "uwt_twilio_send_test_sms_ajxa_callback");

function uwt_twilio_send_test_sms_ajxa_callback()
{
    global $wpdb;
    $mobile_number = trim( $_POST['uwt_test_phone'] );
	$uwt_test_message = sanitize_text_field( $_POST['uwt_test_message'] );
	$from = sanitize_text_field( $_POST['from'] );
	$uwt_twilio_sms_sid = get_option('uwt_twilio_sms_sid');
	$uwt_twilio_sms_token = get_option('uwt_twilio_sms_token');
	$uwt_twilio_sms_from_number = get_option('uwt_twilio_sms_from_number');
    if(isset($_POST['from'])){
	    $uwt_twilio_sms_from_number = get_option('uwt_twilio_whatsapp_from_number');
    }else{
        $from = "";
    }
	if(!empty($uwt_twilio_sms_sid)  && !empty($uwt_twilio_sms_sid) && !empty(
		$uwt_twilio_sms_sid)){
		require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );
    	$client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);

		try {
			$message = $client->messages->create( $from.$mobile_number, array(
				'from' => $from.$uwt_twilio_sms_from_number,
				'body' => $uwt_test_message,
                // "messagingServiceSid" => "MG54cb5acdbbe7334a1b59a4acd68fb9bb"
                 ) );
			$response['message'] = __( 'Test message sent successfully', "ultimate-auction-pro-software" );
		}
		catch( \Exception $e ) {
			$response['message'] =  $e->getMessage();
		    // uwt_create_log("Error While Sending Test SMS : " .$e->getMessage());
		}
	}
	else {
		$response['message'] = __( 'Credentials are required', "ultimate-auction-pro-software" );
	}

	echo json_encode( $response );
	exit;
}




/**
 * Formating Phone Number
 *
 */
function uwt_twilio_sm_format_e164( $number, $country_code = null ) {

    /* if customer has allrady full phone number */
    if ( ! strncmp( $number, '+', 1 ) ) {
        return '+' . preg_replace( '[\D]', '', $number );
    }

    /* remove any non-number characters */
    $number = preg_replace( '[\D]', '', $number );
    $country_calling_code = null;

    /* number has international call prefix (00) */
    if ( 0 === strpos( $number, '00' ) ) {

        /* remove international dialing code */
        $number = substr( $number, 2 );

        /* determine if the number has a country calling code entered */
        foreach ( uwt_twilio_sms_get_country_codes() as $code => $prefix ) {
            if ( 0 === strpos( $number, $prefix ) ) {
                $country_calling_code = $prefix;
                break;
            }
        } /* end of foreach */
    }

    /* getting full number with country code. */
    if ( ! $country_calling_code && $country_code ) {
        $country_calling_code = uwt_twilio_sms_get_country_calling_code( $country_code );
        $number = $country_calling_code . $number;
    }

    /* if no country found  */
    if ( ! $country_calling_code ) {
        return $number;
    }

    /* remove 0 from  country code */
    if ( '0' === substr( $number, strlen( $country_calling_code ), 1 ) ) {
        $number = preg_replace( "/{$country_calling_code}0/", $country_calling_code,
            $number, 1 );
    }

    /* prepend + */
    $number = '+' . $number;
    return $number;
}
/**
 * Get country calling code
 *
 */
function uwt_twilio_sms_get_country_calling_code( $country ) {

	$country = strtoupper( $country );
	$country_codes = uwt_twilio_sms_get_country_codes();
	return ( isset( $country_codes[ $country ] ) ) ? $country_codes[ $country ] : '';
}

function uwt_twilio_sms_get_country_codes() {

    $country_codes = array(
        'AC' => '247',
        'AD' => '376',
        'AE' => '971',
        'AF' => '93',
        'AG' => '1268',
        'AI' => '1264',
        'AL' => '355',
        'AM' => '374',
        'AO' => '244',
        'AQ' => '672',
        'AR' => '54',
        'AS' => '1684',
        'AT' => '43',
        'AU' => '61',
        'AW' => '297',
        'AX' => '358',
        'AZ' => '994',
        'BA' => '387',
        'BB' => '1246',
        'BD' => '880',
        'BE' => '32',
        'BF' => '226',
        'BG' => '359',
        'BH' => '973',
        'BI' => '257',
        'BJ' => '229',
        'BL' => '590',
        'BM' => '1441',
        'BN' => '673',
        'BO' => '591',
        'BQ' => '599',
        'BR' => '55',
        'BS' => '1242',
        'BT' => '975',
        'BW' => '267',
        'BY' => '375',
        'BZ' => '501',
        'CA' => '1',
        'CC' => '61',
        'CD' => '243',
        'CF' => '236',
        'CG' => '242',
        'CH' => '41',
        'CI' => '225',
        'CK' => '682',
        'CL' => '56',
        'CM' => '237',
        'CN' => '86',
        'CO' => '57',
        'CR' => '506',
        'CU' => '53',
        'CV' => '238',
        'CW' => '599',
        'CX' => '61',
        'CY' => '357',
        'CZ' => '420',
        'DE' => '49',
        'DJ' => '253',
        'DK' => '45',
        'DM' => '1767',
        'DO' => '1809',
        'DZ' => '213',
        'EC' => '593',
        'EE' => '372',
        'EG' => '20',
        'EH' => '212',
        'ER' => '291',
        'ES' => '34',
        'ET' => '251',
        'EU' => '388',
        'FI' => '358',
        'FJ' => '679',
        'FK' => '500',
        'FM' => '691',
        'FO' => '298',
        'FR' => '33',
        'GA' => '241',
        'GB' => '44',
        'GD' => '1473',
        'GE' => '995',
        'GF' => '594',
        'GG' => '44',
        'GH' => '233',
        'GI' => '350',
        'GL' => '299',
        'GM' => '220',
        'GN' => '224',
        'GP' => '590',
        'GQ' => '240',
        'GR' => '30',
        'GT' => '502',
        'GU' => '1671',
        'GW' => '245',
        'GY' => '592',
        'HK' => '852',
        'HN' => '504',
        'HR' => '385',
        'HT' => '509',
        'HU' => '36',
        'ID' => '62',
        'IE' => '353',
        'IL' => '972',
        'IM' => '44',
        'IN' => '91',
        'IO' => '246',
        'IQ' => '964',
        'IR' => '98',
        'IS' => '354',
        'IT' => '39',
        'JE' => '44',
        'JM' => '1',
        'JO' => '962',
        'JP' => '81',
        'KE' => '254',
        'KG' => '996',
        'KH' => '855',
        'KI' => '686',
        'KM' => '269',
        'KN' => '1869',
        'KP' => '850',
        'KR' => '82',
        'KW' => '965',
        'KY' => '1345',
        'KZ' => '7',
        'LA' => '856',
        'LB' => '961',
        'LC' => '1758',
        'LI' => '423',
        'LK' => '94',
        'LR' => '231',
        'LS' => '266',
        'LT' => '370',
        'LU' => '352',
        'LV' => '371',
        'LY' => '218',
        'MA' => '212',
        'MC' => '377',
        'MD' => '373',
        'ME' => '382',
        'MF' => '590',
        'MG' => '261',
        'MH' => '692',
        'MK' => '389',
        'ML' => '223',
        'MM' => '95',
        'MN' => '976',
        'MO' => '853',
        'MP' => '1670',
        'MQ' => '596',
        'MR' => '222',
        'MS' => '1664',
        'MT' => '356',
        'MU' => '230',
        'MV' => '960',
        'MW' => '265',
        'MX' => '52',
        'MY' => '60',
        'MZ' => '258',
        'NA' => '264',
        'NC' => '687',
        'NE' => '227',
        'NF' => '672',
        'NG' => '234',
        'NI' => '505',
        'NL' => '31',
        'NO' => '47',
        'NP' => '977',
        'NR' => '674',
        'NU' => '683',
        'NZ' => '64',
        'OM' => '968',
        'PA' => '507',
        'PE' => '51',
        'PF' => '689',
        'PG' => '675',
        'PH' => '63',
        'PK' => '92',
        'PL' => '48',
        'PM' => '508',
        'PR' => '1787',
        'PS' => '970',
        'PT' => '351',
        'PW' => '680',
        'PY' => '595',
        'QA' => '974',
        'QN' => '374',
        'QS' => '252',
        'QY' => '90',
        'RE' => '262',
        'RO' => '40',
        'RS' => '381',
        'RU' => '7',
        'RW' => '250',
        'SA' => '966',
        'SB' => '677',
        'SC' => '248',
        'SD' => '249',
        'SE' => '46',
        'SG' => '65',
        'SH' => '290',
        'SI' => '386',
        'SJ' => '47',
        'SK' => '421',
        'SL' => '232',
        'SM' => '378',
        'SN' => '221',
        'SO' => '252',
        'SR' => '597',
        'SS' => '211',
        'ST' => '239',
        'SV' => '503',
        'SX' => '1721',
        'SY' => '963',
        'SZ' => '268',
        'TA' => '290',
        'TC' => '1649',
        'TD' => '235',
        'TG' => '228',
        'TH' => '66',
        'TJ' => '992',
        'TK' => '690',
        'TL' => '670',
        'TM' => '993',
        'TN' => '216',
        'TO' => '676',
        'TR' => '90',
        'TT' => '1868',
        'TV' => '688',
        'TW' => '886',
        'TZ' => '255',
        'UA' => '380',
        'UG' => '256',
        'UK' => '44',
        'US' => '1',
        'UY' => '598',
        'UZ' => '998',
        'VA' => '39',
        'VC' => '1784',
        'VE' => '58',
        'VG' => '1284',
        'VI' => '1340',
        'VN' => '84',
        'VU' => '678',
        'WF' => '681',
        'WS' => '685',
        'XC' => '991',
        'XD' => '888',
        'XG' => '881',
        'XL' => '883',
        'XN' => '857',
        'XP' => '878',
        'XR' => '979',
        'XS' => '808',
        'XT' => '800',
        'XV' => '882',
        'YE' => '967',
        'YT' => '262',
        'ZA' => '27',
        'ZM' => '260',
        'ZW' => '263',
    );

    return $country_codes;

} /* end of function */