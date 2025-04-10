<?php
if (!defined('ABSPATH')) {
    exit;
}
class TwilioWhatsapp{
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
        $uwt_twilio_whatsapp_from_number = get_option('uwt_twilio_whatsapp_from_number');
        if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_whatsapp_from_number) )
        {
            return false;
        }
        $uwt_twilio_whatsapp_outbid_user_enabled = get_user_meta($outbiddeduser,'uwt_twilio_whatsapp_outbid_user_enabled', true);
        if( $uwt_twilio_whatsapp_outbid_user_enabled != "yes" )
        {
            return false;
        }
        $uwt_twilio_whatsapp_outbid_enabled = get_option('uwt_twilio_whatsapp_outbid_enabled');
            if($uwt_twilio_whatsapp_outbid_enabled == "yes"){
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

                    $uwt_message_pp = get_option('uwt_twilio_whatsapp_outbid_template',"You have been outbid on product id {product_id}, title {product_name}. The current highest bid is {bid_value}. Open {link} and place your bid.");

                    $uwt_message_pp = str_replace('{bid_value}', $auction_bid_value, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_name}',$auction_title, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{link}', $link, $uwt_message_pp);
                    $message .= $uwt_message_pp;
                    $this->plugin_log( 'sending whatsapp sms  for outbid...' );

                    require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );
                    $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                    try {
                        $fmessage = $client->messages->create( "whatsapp:".$to, array(
                            'from' =>"whatsapp:". $uwt_twilio_whatsapp_from_number,
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
                        $this->plugin_log( 'sended whatsapp sms  for outbid successfully.' );

                    }
                    catch( \Exception $e ) {
                        $this->plugin_log($e->getMessage());
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
            $uwt_twilio_whatsapp_from_number = get_option('uwt_twilio_whatsapp_from_number');
            if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_whatsapp_from_number) )
            {
                return false;
            }
            $uwt_twilio_whatsapp_won_user_enabled = get_user_meta($customer_id,'uwt_twilio_whatsapp_won_user_enabled', true);
            if( $uwt_twilio_whatsapp_won_user_enabled != "yes" )
            {
                return false;
            }
            global $wpdb, $woocommerce, $post;
            $uwt_twilio_whatsapp_won_enabled = get_option('uwt_twilio_whatsapp_won_enabled');
            if($uwt_twilio_whatsapp_won_enabled == "yes"){
                $sms_sent_status = get_post_meta( $auction_id, '_uwt_won_whatsapp_sent_status', true );
                $auto_one_time_whatsapp = get_post_meta( $auction_id, '_done_one_time_whatsapp', true );

                if($auto_one_time_whatsapp!='done_one_time_whatsapp_1'){
                        add_post_meta($auction_id, '_done_one_time_whatsapp','done_one_time_whatsapp_0');
                }

                if($sms_sent_status !="sent"){
                    if($auto_one_time_whatsapp !="done_one_time_whatsapp_1" ){
                        update_post_meta($auction_id, '_done_one_time_whatsapp' ,"done_one_time_whatsapp_1");

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
                            $uwt_message_pp = get_option('uwt_twilio_whatsapp_won_template',
                                "You have won auction product id {product_id}, title {product_name}. Click {this_pay_link} to pay.");

                            $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                            $uwt_message_pp = str_replace('{product_name}', $auction_title, $uwt_message_pp);
                            $uwt_message_pp = str_replace('{this_pay_link}', $checkout_url, $uwt_message_pp);

                            $message .= $uwt_message_pp;
                            $this->plugin_log( 'sending whatsapp sms  for winbid...' );

                            require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );
                            $uat_auction_activity = new Uat_Auction_Activity();
                            $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                            try {
                                $fmessage = $client->messages->create("whatsapp:". $to, array(
                                    'from' => "whatsapp:".$uwt_twilio_whatsapp_from_number,
                                    'body' => $message,
                                     ));
                                    $sms_sent_status_metakey = "_uwt_won_whatsapp_sent_status";
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
                                    $this->plugin_log( 'sended whatsapp sms  for wonbid successfully.' );

                            }
                            catch( \Exception $e ) {
                                $uat_auction_activity = new Uat_Auction_Activity();

                                $this->plugin_log($e->getMessage());
                                $this->plugin_log( "SMS Sent Won Error: " . $e->getMessage()." Auction ID=".$product_id);
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
        $uwt_twilio_whatsapp_from_number = get_option('uwt_twilio_whatsapp_from_number');
        if( empty($uwt_twilio_sms_sid) || empty($uwt_twilio_sms_token) || empty($uwt_twilio_whatsapp_from_number) )
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
                        $link = $link = esc_url( home_url( '/?uaturl='.$sorturl ) );
                    }

                    $uwt_message_pp = get_option('uwt_twilio_whatsapp_ending_soon_template',"Auction id {product_id}, title {product_name} will be expiring soon. Place your highest bid to win it.");
                    $uwt_message_pp = str_replace('{product_id}', $product_id, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{product_name}', $auction_title, $uwt_message_pp);
                    $uwt_message_pp = str_replace('{link}', $link, $uwt_message_pp);
                    $message .= $uwt_message_pp;
                    if (  count($ending_auction_users) > 0 ) {
                        require_once ( UAT_THEME_PRO_ADMIN .'notifications/lib/Twilio/autoload.php' );


                        foreach ( $ending_auction_users as $user) {
                            $customer_id = $user->userid;
                            $uwt_twilio_whatsapp_ending_soon_user_enabled = get_user_meta($customer_id,'uwt_twilio_whatsapp_ending_soon_user_enabled', true);
                            if( $uwt_twilio_whatsapp_ending_soon_user_enabled != "yes" )
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

                            $this->plugin_log( 'sending whatsapp sms  for ending soon...' );
                            $uat_auction_activity = new Uat_Auction_Activity();
                            $client = new Twilio\Rest\Client( $uwt_twilio_sms_sid, $uwt_twilio_sms_token);
                            try {
                                $fmessage = $client->messages->create( "whatsapp:".$to, array(
                                    'from' => "whatsapp:".$uwt_twilio_whatsapp_from_number,
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
                                $this->plugin_log( 'sended whatsapp sms  for ending soon successfully.'.$fmessage->sid." status : ".$fmessage->uri );

                            }
                            catch( \Exception $e ) {
                                $uat_auction_activity = new Uat_Auction_Activity();

                                $this->plugin_log($e->getMessage());
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




