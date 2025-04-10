<?php

/**
 * Class for payment
 * Uat_Auction_Payment Main class
 */
// Exit if accessed directly
if (!defined('ABSPATH')) exit;
class Uat_Auction_Payment
{

    public $gateway = '';
    private $gatway_mode = '';


    private $gatway_not_found_msg = '';

    private $stripe_mode = '';
    private $stripe_publishable_key = '';
    private $stripe_secret_key = '';
    private $stripe_client_id = '';
    private $stripe_ready = false;

    private $uat_payment_hold_logs = '';
    private $uat_api_requests_logs = '';
    private $ua_payment_hold_debit_logs = '';
    private $ua_payment_direct_debit_logs = '';
    private $uat_auction_activity  = '';
    private $payment_payment_not_retrive  = '';
    private $gatway_payment_not_direct_debit  = '';
    private $gatway_payment_not_capture  = '';
    private $gatway_card_not_found_msg  = '';
    private $gatway_payment_not_capture_no_default  = '';

    private $_uwa_stripe_auto_debit_status  = '_uwa_stripe_auto_debit_status';

    private $_uwa_stripe_auto_debit_amt  = '_uwa_stripe_auto_debit_amt';
    private $_uwa_stripe_auto_debit_bpm_amt  = '_uwa_stripe_auto_debit_bpm_amt';
    private $_uwa_stripe_auto_debit_total_amt  = '_uwa_stripe_auto_debit_total_amt';

    private $_uwa_stripe_hold_total_amt  = '_uwa_stripe_hold_total_amt';
    private $_uwa_stripe_refund_total_amt  = '_uwa_stripe_refund_total_amt';

    function __construct()
    {
        $this->setup_log_options();
        $this->checkpaymentMode();
    }
    /**
     * Check payment gateway state
     */
    function get_state()
    {
        return $this->stripe_ready;
    }
    /**
     * Check payment gateway api details
     */
    function setup_log_options()
    {
        $paymentGateway = get_option('options_uat_payment_gateway', 'stripe');
        if ($paymentGateway == 'braintree') {
            $this->gateway = 'braintree';
        }
        if ($paymentGateway == 'stripe') {
            $this->gateway = 'stripe';
        }


        /* Invalid Payment messages */
        $this->gatway_not_found_msg = __('Payment Method Invalid', 'ultimate-auction-pro-software');
        $uat_stripe_link = get_permalink(wc_get_page_id('myaccount'));
        $this->gatway_card_not_found_msg = sprintf(__('Your card is not saved <a href="%suat-stripe/"  target="_blank"  class="button">Add Payment Method</a>', 'ultimate-auction-pro-software'), $uat_stripe_link);
        $this->payment_payment_not_retrive = __('Your payment not retrieve', 'ultimate-auction-pro-software');
        $this->gatway_payment_not_direct_debit = __('Your payment not Direct Debit', 'ultimate-auction-pro-software');
        $this->gatway_payment_not_capture =  __('Your payment not captured', 'ultimate-auction-pro-software');
        $this->gatway_payment_not_capture_no_default = sprintf(__('Your payment has not been held! Please set any one as default card <a href="%suat-stripe/"  target="_blank"  class="button">See cards</a>', 'ultimate-auction-pro-software'), $uat_stripe_link);




        /* Log options setup */
        $this->uat_payment_hold_logs = get_option('options_uat_payment_hold_logs', 'disable');
        $this->uat_api_requests_logs = get_option('options_uat_api_requests_logs', 'disable');
        $this->ua_payment_hold_debit_logs = get_option('options_ua_payment_hold_debit_logs', 'disable');
        $this->ua_payment_direct_debit_logs = get_option('options_ua_payment_direct_debit_logs', 'disable');


        $this->uat_auction_activity = new Uat_Auction_Activity();
    }
    /**

     * Check payment gateway api details

     */
    function get_payment_gatway_settings()
    {
        $payment_gatway = [];
        if ($this->get_state()) {
            $payment_gatway['gateway'] = $this->gateway;
            $payment_gatway['status'] = $this->get_state();
            $api_keys = [];
            if ($this->gateway == 'stripe') {
                $api_keys['gateway_mode'] = $this->stripe_mode;
                $api_keys['publishable_key'] = $this->stripe_publishable_key;
                $api_keys['secret_key'] = $this->stripe_secret_key;
                $api_keys['client_id'] = $this->stripe_client_id;
            }
            if ($this->gateway == 'braintree') {
                $Uat_Auction_Braintree = new Uat_Auction_Braintree();
                if (!empty($Uat_Auction_Braintree->gateway) && $Uat_Auction_Braintree->gateway == 'braintree') {
                    $api_keys = $Uat_Auction_Braintree->getGatewaySetings();
                }
            }
            $payment_gatway['api_keys'] = $api_keys;
        }
        return $payment_gatway;
    }
    /**

     * Check payment gateway api details

     */
    function checkpaymentMode()
    {
        /* check for stipe */

        if ($this->gateway == 'stripe') {
            $this->stripe_mode = get_option('options_uat_stripe_mode_types',  'uat_stripe_test_mode');
            if ($this->stripe_mode == 'uat_stripe_live_mode') {
                $this->stripe_publishable_key = get_option('options_uat_stripe_live_publishable_key', '');
                $this->stripe_secret_key = get_option('options_uat_stripe_live_secret_key', '');
                $this->stripe_client_id = get_option('options_uat_stripe_live_client_id', '');
            } else {
                $this->stripe_publishable_key = get_option('options_stripe_test_publishable_key', '');
                $this->stripe_secret_key = get_option('options_uat_stripe_test_secret_key', '');
                $this->stripe_client_id = get_option('options_uat_stripe_test_client_id', '');
            }
            if (!empty($this->stripe_publishable_key) && !empty($this->stripe_secret_key)) {
                $this->stripe_ready = true;
            } else {
                // throw new Exception($this->gatway_not_found_msg);
            }
        }

        if ($this->gateway == 'braintree') {
            $Uat_Auction_Braintree = new Uat_Auction_Braintree();
            if (!empty($Uat_Auction_Braintree->gateway) && $Uat_Auction_Braintree->gateway == 'braintree') {
                $this->stripe_ready = true;
            } else {
                // throw new Exception($this->gatway_not_found_msg);
            }
        }
    }

    /**
     * Check gateway card available for payment
     */
    function gateway_card_check($userid = '')
    {
        global $wpdb;
        /* check for stipe */

        if ($this->gateway == 'stripe') {
            if ($userid) {
                $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);
                if (!empty($customer_id)) {
                    try {
                        $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
                        $cards = $stripe->paymentMethods->all([
                            'customer' => $customer_id,
                            'type' => 'card',
                        ]);
                        if ($cards->data) {
                            return true;
                        } else {
                            throw new Exception($this->gatway_card_not_found_msg);
                        }
                    } catch (\Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                } else {
                    throw new Exception($this->gatway_card_not_found_msg);
                }
            } else {
                throw new Exception($this->gatway_card_not_found_msg);
            }
        }

        if ($this->gateway == 'braintree') {
            // return false;
            if ($userid) {
                $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);
                if (!empty($customer_id)) {
                    try {
                        $Uat_Auction_Braintree = new Uat_Auction_Braintree();
                        $UserCrads = $Uat_Auction_Braintree->getUserCrads($customer_id);
                        if (count($UserCrads) > 0) {
                            return true;
                        } else {
                            throw new Exception($this->gatway_card_not_found_msg);
                        }
                    } catch (\Exception $e) {
                        throw new Exception($e->getMessage());
                    }
                } else {
                    throw new Exception($this->gatway_card_not_found_msg);
                }
            } else {
                throw new Exception($this->gatway_card_not_found_msg);
            }
        }
    }
    /**
     * hold payment from current payment gateway
     */
    function pay_to_seller($order_id = '')
    {
        global $wpdb;
        $order = wc_get_order($order_id);
        if (!$order) {
            return false;
        }
        $uat_enable_offline_dealing = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
           
            $seller_user_id = "";
            // Loop through order items
            foreach ($order->get_items() as $item_id => $item) {
                // Get the product object
                $product = $item->get_product();
                $product_id = $item->get_product_id();
                $product_name = $product->get_name();
                $product_url = get_permalink($product_id);

                // Get the meta value for the product
                $seller_user_id = $product->get_meta('uat_seller_id');
                $seller_user_data = get_userdata($seller_user_id);
                $product_link =    '<a href="' . esc_url($product_url) . '">' . esc_html($product_name) . '</a>';
                if( $uat_enable_offline_dealing == '1'){
                    $transaction_msg = __('Payment offline', 'ultimate-auction-pro-software');
                }else{
                    $transaction_msg = __('Payment pending ', 'ultimate-auction-pro-software');
                }
                // Check if the meta exists for the product
                if (!empty($seller_user_id)) {
                    $currency = get_woocommerce_currency_symbol();
                    $seller_profile_url = get_author_posts_url($seller_user_id);
                    $seller_user_name =    '<a href="' . esc_url($seller_profile_url) . '">' . esc_html($seller_user_data->user_login) . '</a>';

                    $seller_payment_methods = get_user_meta($seller_user_id, 'uat_seller_payment_method', true);
                    if (empty($seller_payment_methods)) {
                        $order_note = __('Seller not configured any payment methods', 'ultimate-auction-pro-software');
                        $order->add_order_note($order_note);
                        $order->save();
                        // continue;
                    }
                    $transaction_type = 'seller_payout';
                    $transaction_id = "";
                    $status = 'pending';
                    $transfer = "";
                    // if ($seller_payment_methods == 'bank') {
                    // } elseif ($seller_payment_methods == 'stripe_split_pay') {
                    // } elseif ($seller_payment_methods == 'braintree_split_pay') {
                    // }

                    $woo_ua_buy_now = get_post_meta($product_id, 'woo_ua_buy_now', true);
                    if(!empty($woo_ua_buy_now)){
                        $current_bid = $product->get_regular_price();
                    }else{
                        $current_bid = get_post_meta($product_id, 'woo_ua_auction_current_bid', true);
                    }
                    $transfer_amount = $current_bid;
                    $transfer_amount = floatval($transfer_amount);
                    if( $uat_enable_offline_dealing != '1'){
                        $uat_admin_commission_percentage = get_option("options_uat_admin_commission_percentage", '0');
                        $uat_admin_commission_percentage = floatval($uat_admin_commission_percentage);
                        if (is_numeric($transfer_amount) && is_numeric($uat_admin_commission_percentage) && $uat_admin_commission_percentage > 0) {
                            $admin_commission = ($transfer_amount * $uat_admin_commission_percentage) / 100;
                            $transfer_amount = $transfer_amount - $admin_commission;
                            update_post_meta($product_id, 'admin_commission_amount', $admin_commission);
                        }
                    }
                    $uat_seller_make_payment_cut_bp = apply_filters('uat_seller_make_payment_bp_to_admin', true);
                    if ($uat_seller_make_payment_cut_bp) {

                        $query_bp   = "SELECT transaction_amount FROM `" . $wpdb->prefix . "auction_direct_payment` where uid=" . $seller_user_id . " and pid=" . $product_id . " and debit_type='buyers_premium' and status='succeeded' ORDER BY `id` DESC";
                        $results_bp = $wpdb->get_results($query_bp);
                        $buyers_premium_rs = 0;
                        if (count($results_bp) > 0) {
                            // $strip_payment_amount +=$results_bp[0]->transaction_amount;
                            $buyers_premium_rs = $results_bp[0]->transaction_amount;
                        }
                        $transfer_amount = $transfer_amount - $buyers_premium_rs;
                    }
                    if( $uat_enable_offline_dealing != '1'){
                        if ($this->gateway == 'stripe' && $seller_payment_methods == 'stripe_split_pay') {
                            \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                            $stripe_user_id = get_user_meta($seller_user_id, 'uat_stripe_user_id', true);
                            $uat_seller_stripe_connected = get_user_meta($seller_user_id, 'uat_seller_stripe_connected', true);
                            if (!empty($stripe_user_id) && $uat_seller_stripe_connected) {
                                $transaction_msg = __('Payout for %s is made with automated payment', 'ultimate-auction-pro-software');
                                $transaction_msg = sprintf($transaction_msg, $product_name);
                                $transfer = \Stripe\Transfer::create([
                                    "amount" => ($transfer_amount * 100),
                                    "currency" => "usd",
                                    "destination" => $stripe_user_id,
                                    'transfer_group' => 'ORDER_' . $order_id,
                                    'description' => $transaction_msg,
                                ]);
                                $transaction_id = $transfer->id;
                                $status = 'started';
                                $uat_seller_auto_paid_automate_payments = apply_filters('uat_seller_auto_paid_automate_payments', false);
                                if ($uat_seller_auto_paid_automate_payments) {
                                    $status = 'paid';
                                }
                                update_post_meta($product_id, 'seller_payment_status', $status);
                                $order_note = __(sprintf('%s amount transfred started to %s account from stripe split pay for %s ', $currency . $transfer_amount, $seller_user_name, $product_link), 'ultimate-auction-pro-software');
                                $order->add_order_note($order_note);
                                $order->save();

                            } else {
                                $status = 'failed';
                                $order_note = __(sprintf('%s amount transfre failed to %s account from stripe split pay for %s because stripe not connected', $currency . $transfer_amount, $seller_user_name, $product_link), 'ultimate-auction-pro-software');
                                $order->add_order_note($order_note);
                                $order->save();
                                $transaction_msg = __('Payout for ', 'ultimate-auction-pro-software');
                                $transaction_msg .= $product_name;
                                $transaction_msg .= __(' is failed with automated payment', 'ultimate-auction-pro-software');
                            }
                        }
                    }

                    /* add transaction details to table '' */
                    $seller_payment_data = [];
                    $seller_payment_data['order_id'] = $order_id;
                    $seller_payment_data['product_id'] = $product_id;
                    $seller_payment_data['seller_id'] = $seller_user_id;
                    $seller_payment_data['payment_method'] = $seller_payment_methods;
                    $seller_payment_data['transaction_type'] = $transaction_type;
                    $seller_payment_data['transaction_id'] = $transaction_id;
                    $seller_payment_data['transaction_amount'] = $transfer_amount;
                    $seller_payment_data['transaction_msg'] = $transaction_msg;
                    $seller_payment_data['status'] = $status;
                    $seller_payment_data['response_json'] = json_encode($transfer);
                    save_seller_payment($seller_payment_data);

                    /* save seller payment status in order by product id : '{product_id}_payment_status'*/
                    update_post_meta($order_id, $product_id . '_payment_status', $status);
                }
            }
  
        return 'finished';
    }
    /**
     * hold payment from current payment gateway
     */
    function hold_payment($curent_bid = '', $product_id = '', $userid = '', $activity = '', $card_check = true)
    {
        if (empty($product_id)) {
            return false;
        }


        if (!$this->stripe_ready) {
            throw new Exception($this->gatway_not_found_msg);
        } else {
            $this->gateway_card_check($userid);
            $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
            if (!empty($uat_event_id)) {
                $hold_type = get_post_meta($uat_event_id, 'ep_type_automatically_debit_hold_type', true);
            } else {
                $hold_type = get_post_meta($product_id, 'sp_type_automatically_debit_hold_type', true);
            }
            if ($hold_type == "stripe_charge_hold_fix_amount" || $hold_type == "ep_stripe_charge_type_fixed") {
                if ($this->gateway == 'stripe') {
                    return $this->stripe_hold_fix_payment($curent_bid, $product_id, $userid, $activity);
                }
                if ($this->gateway == 'braintree') {
                    return $this->braintree_hold_fix_payment($curent_bid, $product_id, $userid, $activity);
                }
            } else {
                if ($this->gateway == 'stripe') {
                    return $this->stripe_hold_payment($curent_bid, $product_id, $userid, $activity);
                }
                if ($this->gateway == 'braintree') {
                    return $this->braintree_hold_payment($curent_bid, $product_id, $userid, $activity);
                }
            }
        }
    }

    /**
     * stripe payment hold
     */
    function stripe_hold_payment($curent_bid = '', $product_id = '', $userid = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        if ($userid) {
            $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);

            if (!empty($customer_id)) {
                try {
                    $currency = get_woocommerce_currency();
                    $total_amt = wc_format_decimal($curent_bid, 2);
                    \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                    $query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $userid . " and gateway_id IN('stripe','')   ORDER BY `is_default` DESC ";
                    $resultsdata = $wpdb->get_results($query);
                    $hold_status = "No";
                    $Jdata = [];
                    if (!empty($resultsdata) && !empty($resultsdata[0]->is_default)) {
                        $apiData = [
                            'amount' => ($total_amt * 100),
                            'currency' => $currency,
                            'customer' => $customer_id,
                            'payment_method_types' => ['card'],
                            'capture_method' => 'manual',
                            'description' => 'Held payment For Auction#' . $product_id,
                        ];
                        $apiData['payment_method'] = $resultsdata[0]->token;
                        $Jdata = \Stripe\PaymentIntent::create($apiData);

                        if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                            $activity_data = array(
                                'post_parent'    => $product_id,
                                'activity_name'    => "Api request for payment hold",
                                'activity_type'    => 'ua_api_requests_logs',
                                'activity_data'    => json_encode($Jdata),
                            );

                            $activity_meta = array(
                                'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                                'api_response_status'    => $Jdata['status'],
                            );
                            $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        }
                        if ($Jdata['status'] == "requires_confirmation") {
                            $hold_status = "YES";
                            global $wpdb;
                            $data = array();
                            $data['pid'] = $product_id;
                            $data['uid'] = $userid;
                            $data['transaction_id'] = $Jdata['id'];
                            $data['transaction_amount'] = $curent_bid;
                            $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'last_bid'");
                            if (!empty($refunresult)) {
                                if (!empty($refunresult[0]->transaction_id)) {
                                    $message = $this->stripe_refunds_payment($refunresult[0]->uid, $bid_amout = $refunresult[0]->transaction_amount, $product_id, $transaction_id = $refunresult[0]->transaction_id, $activity);
                                }
                            }
                            $data['status'] = 'last_bid';
                            $data['response_json'] = json_encode($Jdata);

                            $format = array('%s', '%d');
                            $dataup = ['status' => 'old_bid'];
                            $whereup = ['pid' => $product_id];
                            $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                            $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
                            $message = "1";
                            $PaymentHoldMail = new PaymentHoldMail();
                            $PaymentHoldMail->payment_hold_email($product_id, $userid, $curent_bid);
                        } else if ($Jdata['status'] == "requires_source" || $Jdata['status'] == "requires_payment_method") {
                            $message = $this->gatway_payment_not_capture_no_default;
                        } else {
                            $hold_status = "No";
                            $user_card_invalid_count = get_user_meta($userid, 'uat_card_invalid_count', true);
                            if (empty($user_card_invalid_count)) {
                                $user_card_invalid_count = 0;
                            }
                            $user_card_invalid_count = $user_card_invalid_count + 1;
                            update_user_meta($userid, 'uat_card_invalid_count', $user_card_invalid_count);
                            if ($user_card_invalid_count >= 3) {
                                update_user_meta($userid, 'uat_is_block', "yes");
                            }
                            $message = $this->gatway_payment_not_capture;
                        }
                    } else {
                        $message = $this->gatway_payment_not_capture_no_default;
                    }
                    if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Hold fix amount ",
                            'activity_type'    => 'ua_payment_hold_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $curent_bid,
                            'p_hold_status'    => $hold_status,
                            'p_release_status'    => "-",
                            'BID_activity_ID'    => $activity,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                        }
                    }
                } catch (\Stripe\Exception\CardException $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $this->gatway_card_not_found_msg;
            }
        }
        return $message;
    }
    /**
     * stripe payment hold fixed amount
     */
    function stripe_hold_fix_payment($curent_bid = '', $product_id = '', $userid = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        if ($userid) {
            $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);

            if (!empty($customer_id)) {
                try {
                    $currency = get_woocommerce_currency();
                    $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
                    if (!empty($uat_event_id)) {
                        $hold_fix_amount = get_post_meta($uat_event_id, 'ep_stripe_charge_type_fixed_amount', true);
                    } else {
                        $hold_fix_amount = get_post_meta($product_id, 'charge_hold_fix_amount', true);
                    }

                    if ($hold_fix_amount > 0) {
                        \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                        // check old hold exists
                        $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE uid='" . $userid . "' AND  pid='" . $product_id . "' AND  status = 'hold_fix'");
                        if (!empty($refunresult)) {
                            if (!empty($refunresult[0]->transaction_id)) {
                                // $message = "exists";
                                // $message = $this->stripe_refunds_payment($refunresult[0]->uid, $bid_amout = $refunresult[0]->transaction_amount, $product_id, $transaction_id = $refunresult[0]->transaction_id, $activity);
                            }
                        } else {


                            $query   = "SELECT * FROM `" . $wpdb->prefix . "ua_auction_payment_cards` where  user_id=" . $userid . " and gateway_id IN('stripe','')   ORDER BY `is_default` DESC ";
                            $resultsdata = $wpdb->get_results($query);
                            $hold_status = "No";
                            $Jdata = [];
                            if (!empty($resultsdata) && !empty($resultsdata[0]->is_default)) {
                                $apiData = [
                                    'amount' => ($hold_fix_amount * 100),
                                    'currency' => $currency,
                                    'customer' => $customer_id,
                                    'payment_method_types' => ['card'],
                                    'capture_method' => 'manual',
                                    'confirm' => false,
                                    'description' => 'Held payment For Auction#' . $product_id,
                                ];
                                $apiData['payment_method'] = $resultsdata[0]->token;

                                $Jdata = \Stripe\PaymentIntent::create($apiData);
                                if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                                    $activity_data = array(
                                        'post_parent'    => $product_id,
                                        'activity_name'    => "Api request for payment hold fix amount",
                                        'activity_type'    => 'ua_api_requests_logs',
                                        'activity_data'    => json_encode($Jdata),
                                    );

                                    $activity_meta = array(
                                        'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                                        'api_response_status'    => $Jdata['status'],
                                    );
                                    $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                }

                                if ($Jdata['status'] == "requires_confirmation") {
                                    global $wpdb;
                                    $hold_status = "YES";
                                    $data = array();
                                    $data['pid'] = $product_id;
                                    $data['uid'] = $userid;
                                    $data['transaction_id'] = $Jdata['id'];
                                    $data['transaction_amount'] = $hold_fix_amount;
                                    $data['status'] = 'hold_fix';
                                    $data['response_json'] = json_encode($Jdata);

                                    $format = array('%s', '%d');
                                    $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
                                    $message = "1";
                                    $PaymentHoldMail = new PaymentHoldMail();
                                    $PaymentHoldMail->payment_hold_email($product_id, $userid, $hold_fix_amount);
                                } else if ($Jdata['status'] == "requires_source" || $Jdata['status'] == "requires_payment_method") {
                                    $message = $this->gatway_payment_not_capture_no_default;
                                } else {
                                    $hold_status = "No";
                                    $user_card_invalid_count = get_user_meta($userid, 'uat_card_invalid_count', true);
                                    if (empty($user_card_invalid_count)) {
                                        $user_card_invalid_count = 0;
                                    }
                                    $user_card_invalid_count = $user_card_invalid_count + 1;
                                    update_user_meta($userid, 'uat_card_invalid_count', $user_card_invalid_count);
                                    if ($user_card_invalid_count >= 3) {
                                        update_user_meta($userid, 'uat_is_block', "yes");
                                    }
                                    $message = $this->gatway_payment_not_capture;
                                }
                            } else {
                                $message = $this->gatway_payment_not_capture_no_default;
                            }
                            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                                $activity_data = array(
                                    'post_parent'    => $product_id,
                                    'activity_name'    => "Payment Hold fix amount ",
                                    'activity_type'    => 'ua_payment_hold_logs',
                                    'activity_by'    => $userid,
                                    'activity_data'    => json_encode($Jdata),
                                );
                                $activity_meta = array(
                                    'bid_value'    => $hold_fix_amount,
                                    'p_hold_status'    => $hold_status,
                                    'p_release_status'    => "-",
                                    'BID_activity_ID'    => $activity,
                                );
                                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                if (!empty($activity)) {
                                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                                }
                            }
                        }
                    }
                } catch (\Stripe\Exception\CardException $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $this->gatway_card_not_found_msg;
            }
        }
        return $message;
    }

    /**
     * refund payment from current payment gateway
     */
    function refunds_payment($userid = '', $bid_amout = '', $product_id = '', $transaction_id = '', $activity = '')
    {
        if (empty($product_id)) {
            return false;
        }

        if ($this->gateway == 'stripe') {
            if (!$this->stripe_ready) {
                throw new Exception($this->gatway_not_found_msg);
            } else {
                $this->gateway_card_check($userid);
                return $this->stripe_refunds_payment($userid, $bid_amout, $product_id, $transaction_id, $activity);
            }
        }
    }

    /**
     * Buyer premium payment from current payment gateway
     */
    function buyer_premium($uat_event_id = "", $winner_bid = "", $product_id = "", $userid = "", $log_type = "", $activity = "")
    {
        if (empty($product_id)) {
            return false;
        }

        if (!$this->stripe_ready) {
            throw new Exception($this->gatway_not_found_msg);
        } else {
            $this->gateway_card_check($userid);
            if ($this->gateway == 'stripe') {
                return $this->stripe_buyer_premium($winner_bid, $product_id, $userid, $log_type, $activity);
            }
            if ($this->gateway == 'braintree') {
                return $this->braintree_buyer_premium($winner_bid, $product_id, $userid, $log_type, $activity);
            }
        }
    }

    /**
     * Retrive payment from current payment gateway
     * it will retrive hold payment or direct payment from auction or event product
     */
    function retrive_debit_payment($uat_event_id = "", $winner_bid = "", $product_id = "", $userid = "", $log_type = "", $activity = "")
    {
        if (empty($product_id)) {
            return "";
        }

        if (!$this->stripe_ready) {
            throw new Exception($this->gatway_not_found_msg);
        } else {
            $this->gateway_card_check($userid);
            return $this->retrive_debit_payment_check($product_id, $userid, $activity);
        }
    }


    /**
     * stripe payment refund hold
     */
    function stripe_refunds_payment($userid = '', $bid_amout = '', $product_id = '', $transaction_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        try {
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
            $Jdata = $stripe->paymentIntents->cancel($transaction_id, []);

            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Payment Refund",
                    'activity_type'    => 'ua_payment_hold_logs',
                    'activity_by'    => $userid,
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'bid_value'    => $bid_amout,
                    'p_hold_status'    => "-",
                    'p_release_status'    => "YES",
                    'BID_activity_ID'    => $activity,
                );
                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                if (!empty($activity)) {
                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                }
            }
            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Api request for payment refund",
                    'activity_type'    => 'ua_api_requests_logs',
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                    'api_response_status'    => $Jdata['status'],
                );
                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
            }
        } catch (\Stripe\Exception\CardException $e) {
            $message = $e->getMessage();
        }
        return $message;
    }

    /**
     * stripe payment refund hold fix amount
     */
    function stripe_refunds_payment_amount($userid = '', $refund_amout = '', $product_id = '', $transaction_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        try {
            $stripe = new \Stripe\StripeClient($this->stripe_secret_key);
            $amount = ($refund_amout * 100);

            $Jdata = $stripe->refunds->create(
                ['payment_intent' => $transaction_id, 'amount' => $amount]
            );

            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Payment Refund from hold fix",
                    'activity_type'    => 'ua_payment_hold_logs',
                    'activity_by'    => $userid,
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'bid_value'    => $refund_amout,
                    'p_hold_status'    => "-",
                    'p_release_status'    => "YES",
                    'BID_activity_ID'    => $activity,
                );
                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                if (!empty($activity)) {
                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                }
            }
            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Api request for payment refund",
                    'activity_type'    => 'ua_api_requests_logs',
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                    'api_response_status'    => $Jdata['status'],
                );
                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
            }

            if ($Jdata['status'] == "succeeded") {
                update_post_meta($product_id, $this->_uwa_stripe_refund_total_amt, $refund_amout);
                $dataup = ['status' => 'retrieved_hold_fix'];
                $whereup = ['transaction_id' => $transaction_id];
                $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);

                $data = array();
                $data['pid'] = $product_id;
                $data['uid'] = $userid;
                $data['transaction_id'] = $Jdata['id'];
                $data['transaction_amount'] = $refund_amout;
                $data['status'] = 'hold_fix_refund';
                $data['response_json'] = json_encode($Jdata);

                $format = array('%s', '%d');
                $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
            } else {
                $message = $this->payment_payment_not_retrive;
            }
        } catch (\Stripe\Exception\CardException $e) {
            $message = $e->getMessage();
        }
        return $message;
    }

    /**
     * stripe Buyer premium
     */
    function stripe_buyer_premium($winner_bid = "", $product_id = "", $userid = "", $log_type = "", $activity = "")
    {

        $message = "";
        global $wpdb;
        if ($userid) {
            $uwa_buyer_status = false;
            $uwa_buyer_price = 0;

            $uat_buyers_premium_amount = 0;
            $uat_buyers_premium_type = "";

            $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);;
            if (!empty($uat_event_id)) {
                /* Event product */
                $uwa_buyer_price = uat_buyer_premium_value_event_products($uat_event_id, $winner_bid);
                if($uwa_buyer_price > 0){
                    $uwa_buyer_status = true;
                }
            } else {
                /* Without Event product */

                if (uwt_is_vendor_product($product_id)) {
                    $uwt_get_buyer_premium__globle_value_wcfm = uwt_get_buyer_premium__globle_value_wcfm($winner_bid);
                    if (!empty($uwt_get_buyer_premium__globle_value_wcfm) && $uwt_get_buyer_premium__globle_value_wcfm > 0) {
                        $uat_stripe_buyers_premium_enable_sp = get_option("options_uat_stripe_buyers_premium_enable_sp", "");
                        if ($uat_stripe_buyers_premium_enable_sp == "yes") {
                            $uwa_buyer_status = true;
                            $uwa_buyer_price = $uwt_get_buyer_premium__globle_value_wcfm;
                        }
                    }
                } else {
                    $uat_buyers_premium_type_sp_main = get_post_meta($product_id, 'uat_buyers_premium_type_sp_main', true);
                    $uat_enable_buyers_premium_sp = get_option('options_uat_enable_buyers_premium_sp', "");
                    if ($uat_enable_buyers_premium_sp == "yes") {
                        if ($uat_buyers_premium_type_sp_main == "global") {
                            $uwa_buyer_status = true;
                            $uwa_buyer_price = uwt_get_buyer_premium__globle_value($winner_bid);
                        } else {
                            $uat_buyers_premium_amount = get_post_meta($product_id, 'sp_buyers_premium_fee_amt', true);
                            $sp_buyers_premium = get_post_meta($product_id, 'sp_buyers_premium', true);
                            $sp_buyers_premium_auto_debit =  get_post_meta($product_id, 'sp_buyers_premium_auto_debit', true);
                            if ($sp_buyers_premium == "yes" && $sp_buyers_premium_auto_debit == "yes") {
                                $uwa_buyer_status = true;
                                $uat_buyers_premium_type =  get_post_meta($product_id, 'sp_buyers_premium_type', true);
                                if ($uat_buyers_premium_type == 'percentage') {
                                    $uwa_buyer_price = ($winner_bid * $uat_buyers_premium_amount) / 100;
                                    /* calculations for min max buyers premium */
                                    $uwa_bpm_min_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_min', true);
                                    $uwa_bpm_max_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_max', true);
                                    $min_val = $uwa_bpm_min_val;
                                    $max_val = $uwa_bpm_max_val;
                                    if ($min_val > 0) {
                                        if ($uwa_buyer_price < $min_val) {
                                            $uwa_buyer_price = $min_val;
                                        }
                                    }
                                    if ($max_val > 0) {
                                        if ($uwa_buyer_price > $max_val) {
                                            $uwa_buyer_price = $max_val;
                                        }
                                    }
                                } else {
                                    $uwa_buyer_price = $uat_buyers_premium_amount;
                                }
                            }
                        }
                    }
                }
            }

            if ($uwa_buyer_status) {
                if ($uwa_buyer_price > 0) {
                    $amount = $uwa_buyer_price;
                    try {
                        $amount = wc_format_decimal($amount, 2);
                        $currency = get_woocommerce_currency();
                        $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);
                        \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                        $Jdata = \Stripe\PaymentIntent::create(array(
                            "amount" => ($amount * 100),
                            "currency" => $currency,
                            "customer" =>  $customer_id,
                            'payment_method_types' => array('card'),
                            'off_session' => true,
                            'confirm' => true,
                            'description' => 'Buyers Premium For Auction#' . $product_id,
                        ));
                        if ($Jdata['status'] == "succeeded") {
                            $total_auto_debit = get_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, true);
                            if (!empty($total_auto_debit)) {
                                $total_auto_debit += $amount;
                            } else {
                                $total_auto_debit = $amount;
                            }
                            update_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, $total_auto_debit);
                            update_post_meta($product_id, $this->_uwa_stripe_auto_debit_bpm_amt, $amount);
                            $data = array();
                            $data['pid'] = $product_id;
                            $data['uid'] = $userid;
                            $data['debit_type'] =  'buyers_premium';

                            $data['debit_amount_type'] = $uat_buyers_premium_type;
                            $data['amount_or_percentage'] = $uat_buyers_premium_amount;

                            $data['transaction_amount'] = $amount;
                            $data['main_amount'] = $amount;
                            $data['status'] =  'succeeded';
                            $data['response_json'] = json_encode($Jdata);
                            $format = array('%s', '%d');
                            $wpdb->insert($wpdb->prefix . 'auction_direct_payment', $data, $format);

                            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                                $activity_data = array(
                                    'post_parent'    => $product_id,
                                    'activity_name'    => "Api request for Buyers Premium",
                                    'activity_type'    => 'ua_api_requests_logs',
                                    'activity_data'    => json_encode($Jdata),
                                );
                                $activity_meta = array(
                                    'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                                    'api_response_status'    => $Jdata['status'],
                                );
                                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                            }
                            $activity_data = array(
                                'post_parent'    => $product_id,
                                'activity_name'    => "Buyers Premium Debit",
                                'activity_type'    => $log_type,
                                'activity_by'    => $userid,
                                'activity_data'    => json_encode($Jdata),
                            );
                            $activity_meta = array(
                                'bid_value'    => $amount,
                                'p_debit_status'    => $Jdata['status'],
                            );
                            $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                            if (!empty($activity)) {
                                $this->uat_auction_activity->insert_sub_activity_meta($activity, "products_activity_ID", $activity_sub);
                            }
                        } else {
                            $message = $this->gatway_payment_not_direct_debit;
                        }
                    } catch (\Stripe\Exception\CardException $e) {
                        $message = $e->getMessage();

                        if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                            $activity_data = array(
                                'post_parent'    => $product_id,
                                'activity_name'    => "Api request for Buyers Premium Debit",
                                'activity_type'    => 'ua_api_requests_logs',
                                'activity_data'    => json_encode($Jdata),
                            );
                            $activity_meta = array(
                                'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                                'api_response_status'    => $Jdata['status'],
                            );
                            $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        }
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Buyers Premium Debit",
                            'activity_type'    => $log_type,
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $message,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }
                }
            }
        }
        return  $message;
    }

    /**
     *  Retrive payment with direct payment
     */
    function retrive_debit_payment_check($product_id = "", $userid = "", $activity = "")
    {

        $message = "";
        global $wpdb;
        if ($userid) {
            $current_bid = get_post_meta($product_id, 'woo_ua_auction_current_bid', true);
            $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
            $winning_bid_amt = $current_bid;
            if (!empty($uat_event_id)) {
                /* Event product */

                $seting_adhe = get_post_meta($uat_event_id, 'uat_event_auto_debit_hold_enable', true);
                if (!empty($seting_adhe) && $seting_adhe == 'yes') {

                    $hold_type = get_post_meta($uat_event_id, 'ep_type_automatically_debit_hold_type', true);

                    if ($this->stripe_ready) {
                        if ($this->gateway == 'stripe') {
                            if ($hold_type == "ep_stripe_charge_type_fixed") {
                                $message = $this->stripe_retrieve_fix_hold_payment($product_id = $product_id, $activity, $userid = $userid);
                            } else {
                                $message = $this->stripe_retrieve_payment($product_id = $product_id, $activity);
                            }
                        }
                        if ($this->gateway == 'braintree') {
                            if ($hold_type == "ep_stripe_charge_type_fixed") {
                                $message = $this->braintree_retrieve_fix_hold_payment($product_id = $product_id, $activity, $userid = $userid);
                            } else {
                                $message = $this->braintree_retrieve_payment($product_id = $product_id, $activity);
                            }
                        }
                    }
                } else {
                    $uat_auto_debit_options = get_post_meta($uat_event_id, 'uat_auto_debit_options', true);
                    if ($uat_auto_debit_options == 'stripe_charge_type_full') {
                        $amount = $winning_bid_amt;

                        if ($this->gateway == 'stripe') {
                            if ($this->stripe_ready) {
                                $message = $this->stripe_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "stripe_charge_type_full", $debit_amount_type = "", $amount_or_percentage = '', $main_amount = $winning_bid_amt);
                            }
                        }
                        if ($this->gateway == 'braintree') {
                            if ($this->stripe_ready) {
                                $message = $this->braintree_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "braintree_charge_type_full", $debit_amount_type = "", $amount_or_percentage = '', $main_amount = $winning_bid_amt);
                            }
                        }
                    } else if ($uat_auto_debit_options == 'stripe_charge_type_partially') {
                        $amount = $winning_bid_amt;
                        $uwa_partially_type = get_post_meta($uat_event_id, 'uat_partially_bid_amount_type', true);
                        if (isset($uwa_partially_type) && !empty($uwa_partially_type)) {

                            $uwa_partially_amt = get_post_meta($uat_event_id, 'uat_stripe_charge_type_partially_amt', true);
                            if ($uwa_partially_type == 'percentage') {
                                /*percentage*/
                                $amount = (intval($winning_bid_amt) * intval($uwa_partially_amt)) / 100;
                            } else {
                                /*Flat Rate*/
                                $amount = $uwa_partially_amt;
                            }
                            if ($this->gateway == 'stripe') {
                                if ($this->stripe_ready) {
                                    $message = $this->stripe_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "uat_partially_bid_amount_type", $debit_amount_type = "flat", $amount_or_percentage = $uwa_partially_amt, $main_amount = $winning_bid_amt);
                                }
                            }
                            if ($this->gateway == 'braintree') {
                                if ($this->stripe_ready) {
                                    $message = $this->braintree_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "uat_partially_bid_amount_type", $debit_amount_type = "flat", $amount_or_percentage = $uwa_partially_amt, $main_amount = $winning_bid_amt);
                                }
                            }
                        }
                    }
                }
            } else {
                /* Without Event product */
                $uat_enable_autodebit_vendor_sp_products = get_option('options_uat_enable_autodebit_vendor_sp_products', 'yes');
                if (uwt_is_vendor_product($product_id) && !empty($uat_enable_autodebit_vendor_sp_products) && $uat_enable_autodebit_vendor_sp_products == 'yes') {

                    $auction_post_author = get_post_field('post_author', $product_id);
                    $vendor_stripe_id = get_user_meta($auction_post_author, 'stripe_user_id', true);
                    $wcfm_withdrawal_options = get_option('wcfm_withdrawal_options', array());
                    $withdrawal_payment_methods = $wcfm_withdrawal_options['payment_methods'];
                    $set = "";
                    if (is_array($withdrawal_payment_methods)) {
                        if (
                            in_array("stripe_split", $withdrawal_payment_methods) &&
                            !empty($vendor_stripe_id)
                        ) {
                            $set = "yes";
                        }
                    }
                    if ($set == "yes") {
                        if ($this->gateway == 'stripe') {
                            $this->stripe_direct_payment_vendor_with_admin($product_id = $product_id, $winning_bid_amt = $winning_bid_amt, $userid = $userid);
                        }
                    }
                } else {
                    $sp_automatically_debit = get_post_meta($product_id, 'sp_automatically_debit', true);
                    if ($sp_automatically_debit == 'yes') {


                        $hold_type = get_post_meta($product_id, 'sp_type_automatically_debit_hold_type', true);
                        if ($this->stripe_ready) {
                            if ($hold_type == "stripe_charge_hold_fix_amount") {
                                if ($this->gateway == 'stripe') {
                                    $message = $this->stripe_retrieve_fix_hold_payment($product_id = $product_id, $activity, $userid = $userid);
                                }
                                if ($this->gateway == 'braintree') {
                                    $message = $this->braintree_retrieve_fix_hold_payment($product_id = $product_id, $activity, $userid = $userid);
                                }
                            } else {
                                if ($this->gateway == 'stripe') {
                                    $message = $this->stripe_retrieve_payment($product_id = $product_id, $activity);
                                }
                                if ($this->gateway == 'braintree') {
                                    $message = $this->braintree_retrieve_payment($product_id = $product_id, $activity);
                                }
                            }
                        }
                    } else {
                        $sp_type_automatically_debit = get_post_meta($product_id, 'sp_type_automatically_debit', true);
                        if ($sp_type_automatically_debit == 'stripe_charge_type_full') {
                            $amount = $winning_bid_amt;

                            if ($this->gateway == 'stripe') {
                                if ($this->stripe_ready) {
                                    $message = $this->stripe_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "stripe_charge_type_full", $debit_amount_type = "", $amount_or_percentage = "", $main_amount = $winning_bid_amt);
                                }
                            }

                            if ($this->gateway == 'braintree') {
                                if ($this->stripe_ready) {
                                    $message = $this->braintree_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "braintree_charge_type_full", $debit_amount_type = "", $amount_or_percentage = '', $main_amount = $winning_bid_amt);
                                }
                            }
                        } else if ($sp_type_automatically_debit == 'stripe_charge_type_partially') {

                            $amount = $winning_bid_amt;
                            $uwa_partially_type = get_post_meta($product_id, 'sp_partial_amount_type', true);
                            if (isset($uwa_partially_type) && !empty($uwa_partially_type)) {

                                $uwa_partially_amt = get_post_meta($product_id, 'sp_partially_amount', true);
                                if ($uwa_partially_type == 'percentage') {
                                    /*percentage*/
                                    $amount = (intval($winning_bid_amt) * intval($uwa_partially_amt)) / 100;
                                } else {
                                    /*Flat Rate*/
                                    $amount = $uwa_partially_amt;
                                }
                                if ($this->gateway == 'stripe') {
                                    if ($this->stripe_ready) {
                                        $message = $this->stripe_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "uat_partially_bid_amount_type", $debit_amount_type = "flat", $amount_or_percentage = $uwa_partially_amt, $main_amount = $winning_bid_amt);
                                    }
                                }
                                if ($this->gateway == 'braintree') {
                                    if ($this->stripe_ready) {
                                        $message = $this->braintree_direct_payment($product_id = $product_id, $activity, $amount, $userid, $debit_type = "uat_partially_bid_amount_type", $debit_amount_type = "flat", $amount_or_percentage = $uwa_partially_amt, $main_amount = $winning_bid_amt);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return  $message;
    }

    /**
     * stripe Retrive payment 
     */
    function stripe_retrieve_payment($product_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;

        if ($product_id) {
            try {
                $transaction_id = "";
                $transaction_amount = "";
                $userid = "";
                $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'last_bid'");
                if (!empty($refunresult)) {
                    if (!empty($refunresult[0]->transaction_id)) {
                        $transaction_id = $refunresult[0]->transaction_id;
                        $transaction_amount = $refunresult[0]->transaction_amount;
                        $userid = $refunresult[0]->uid;
                    }
                }
                if (!empty($transaction_id)) {

                    $stripe = new \Stripe\StripeClient($this->stripe_secret_key);


                    $stripe1 = $stripe->paymentIntents->confirm(
                        $transaction_id,
                        ['payment_method' => 'pm_card_visa']
                    );
                    $amount = ($transaction_amount * 100);

                    \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                    $intent = \Stripe\PaymentIntent::retrieve($transaction_id);
                    $Jdata = $intent->capture(['amount_to_capture' => $amount]);


                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Api request for payment auto debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }

                    if (!empty($this->ua_payment_hold_debit_logs) && $this->ua_payment_hold_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Debit",
                            'activity_type'    => 'ua_payment_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => ($amount / 100),
                            'p_debit_status'    => $Jdata['status'],
                            'BID_activity_ID'    => $activity,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    if ($Jdata['status'] == "succeeded") {
                        update_post_meta($product_id, $this->_uwa_stripe_hold_total_amt, $transaction_amount);
                        $dataup = ['status' => 'retrieved_bid'];
                        $whereup = ['transaction_id' => $transaction_id];
                        $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                    } else {
                        $message = $this->payment_payment_not_retrive;
                    }
                }
            } catch (\Stripe\Exception\CardException $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }


    /**
     * stripe Retrive fix hold payment 
     */
    function stripe_retrieve_fix_hold_payment($product_id = '', $activity = '', $user_id = '')
    {
        $message = "";
        global $wpdb;

        if ($product_id) {
            try {
                $transaction_id = "";
                $transaction_amount = "";
                $userid = "";
                $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'hold_fix'");
                if (!empty($refunresult)) {
                    if (count($refunresult) > 0) {
                        foreach ($refunresult as $key => $transaction) {
                            $onetransaction_id = $transaction->transaction_id;
                            $one_uid = $transaction->uid;
                            $one_transaction_amount = $transaction->transaction_amount;
                            if ($one_uid != $user_id) {
                                $this->stripe_refunds_payment($one_uid, $one_transaction_amount, $product_id, $onetransaction_id, $activity = '');
                            } else {
                                $transaction_id = $transaction->transaction_id;
                                $transaction_amount = $transaction->transaction_amount;
                                $userid = $transaction->uid;
                            }
                        }
                    }
                }

                $winner_bid = get_post_meta($product_id, 'woo_ua_auction_current_bid', true);
                $activity_sub = "";
                if (!empty($transaction_id)) {

                    $stripe = new \Stripe\StripeClient($this->stripe_secret_key);


                    $stripe1 = $stripe->paymentIntents->confirm(
                        $transaction_id,
                        ['payment_method' => 'pm_card_visa']
                    );
                    $amount = ($transaction_amount * 100);

                    \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                    $intent = \Stripe\PaymentIntent::retrieve($transaction_id);
                    $Jdata = $intent->capture(['amount_to_capture' => $amount]);


                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Api request for payment auto debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }

                    if (!empty($this->ua_payment_hold_debit_logs) && $this->ua_payment_hold_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Debit hold fix amount",
                            'activity_type'    => 'ua_payment_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $winner_bid,
                            // 'bid_value'	=> ($amount / 100),
                            'p_debit_status'    => $Jdata['status'],
                            'BID_activity_ID'    => $activity,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    if ($Jdata['status'] == "succeeded") {
                        update_post_meta($product_id, $this->_uwa_stripe_hold_total_amt, $transaction_amount);
                        $dataup = ['status' => 'retrieved_hold_fix'];
                        $whereup = ['transaction_id' => $transaction_id];
                        $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                    } else {
                        $message = $this->payment_payment_not_retrive;
                    }
                }
                if ($winner_bid < $transaction_amount) {
                    $refund_amunt = $transaction_amount - $winner_bid;

                    $this->stripe_refunds_payment_amount($userid, $refund_amunt, $product_id, $transaction_id, $activity_sub);
                }
            } catch (\Stripe\Exception\CardException $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }

    /**
     * stripe direct payment 
     */
    function stripe_direct_payment($product_id = "", $activity = "", $amount = "", $userid = "", $debit_type = "", $debit_amount_type = "", $amount_or_percentage = "", $main_amount = "")
    {
        $message = "";
        global $wpdb;
        if ($product_id) {
            try {

                $currency = get_woocommerce_currency();
                $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);
                \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                $Jdata = \Stripe\PaymentIntent::create(array(
                    "amount" => ($amount * 100),
                    "currency" => $currency,
                    "customer" =>  $customer_id,
                    'payment_method_types' => array('card'),
                    'off_session' => true,
                    'confirm' => true,
                    'description' => 'Auto Debit For Auction#' . $product_id,
                ));
                if ($Jdata['status'] == "succeeded") {
                    $total_auto_debit = get_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, true);
                    if (!empty($total_auto_debit)) {
                        $total_auto_debit += $amount;
                    } else {
                        $total_auto_debit = $amount;
                    }
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, $total_auto_debit);
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_amt, $amount);
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "paid");
                    $data = array();
                    $data['pid'] = $product_id;
                    $data['uid'] = $userid;
                    $data['debit_type'] =  $debit_type;
                    $data['debit_amount_type'] = $debit_amount_type;
                    $data['amount_or_percentage'] = $amount_or_percentage;
                    $data['transaction_amount'] = $amount;
                    $data['main_amount'] = $main_amount;
                    $data['status'] =  'succeeded';
                    $data['response_json'] = json_encode($Jdata);
                    $format = array('%s', '%d');
                    $wpdb->insert($wpdb->prefix . 'auction_direct_payment', $data, $format);

                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $Jdata['status'],
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }
                } else {
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                    $message = $this->gatway_payment_not_direct_debit;
                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $Jdata['status'],
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    return false;
                }
            } catch (\Stripe\Exception\CardException $e) {
                update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                $message = $e->getMessage();

                if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Api request for payment direct debit",
                        'activity_type'    => 'ua_api_requests_logs',
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                        'api_response_status'    => $Jdata['status'],
                    );
                    $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                }
                if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Payment Direct Debit",
                        'activity_type'    => 'ua_payment_direct_debit_logs',
                        'activity_by'    => $userid,
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'bid_value'    => $amount,
                        'p_debit_status'    => $message,
                    );
                    $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    if (!empty($activity)) {
                        $this->uat_auction_activity->insert_sub_activity_meta($activity, "products_activity_ID", $activity_sub);
                    }
                }
            }
        }
        return $message;
    }

    /**
     * stripe direct payment for vendor with admin commission
     */
    function stripe_direct_payment_vendor_with_admin($product_id = "", $winning_bid_amt = "", $userid = "")
    {
        $message = "";
        global $wpdb;
        if ($product_id) {
            try {

                $currency = get_woocommerce_currency();
                $customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);
                $auction_post_author = get_post_field('post_author', $product_id);
                $vendor_stripe_id = get_user_meta($auction_post_author, 'stripe_user_id', true);
                \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                $vednor_paided_amt = 0;
                $vendor_commision = 0;
                $winning_bid_amt = uwt_get_stripe_auto_debit_value_vendor($winning_bid_amt);
                $admin_commission = uwt_get_stripe_auto_debit_admin_commission($winning_bid_amt);
                $vendor_commision = $winning_bid_amt - $admin_commission;
                $Jdata = [];
                $vendor_commision_status = "Failed";
                if ($vendor_commision > 0) {
                    $currency = get_woocommerce_currency();
                    $stripe_customer_id = get_user_meta($userid, $wpdb->prefix . '_stripe_customer_id', true);
                    /* cloning customer to vendor account */
                    try {
                        $v_sourceobj = \Stripe\Source::create(
                            array("customer" => $stripe_customer_id,),
                            array("stripe_account" => $vendor_stripe_id)
                        );
                    } catch (Exception $ex) {
                    }

                    /* Transfer vendor amount to vendor account  */
                    if ($v_sourceobj->id) {

                        try {
                            $vendorobj = \Stripe\PaymentIntent::create(array(
                                "amount" => ($vendor_commision * 100),
                                "currency" => $currency,
                                "source" => $v_sourceobj->id,
                                'payment_method_types' => array('card'),
                                'off_session' => true,
                                'confirm' => true,
                                'description' => 'vendor Auto Debit For Auction#' . $product_id,
                            ), array("stripe_account" => $vendor_stripe_id));
                            if ($vendorobj['status'] == "succeeded") {
                                if (isset($vendorobj['amount'])) {
                                    $vendor_commision_status = "succeeded";
                                    $vednor_paided_amt = $vendorobj['amount'] / 100;
                                }
                            }
                        } catch (\Stripe\Error\Base $e) {
                            // Code to do something with the $e exception object when an error occurs						 
                            // uwa_create_log("Transfer Vendor Amount Error: " . $e->getMessage()." Auction ID=".$product_id);
                        } catch (\Stripe\Exception\CardException $e) {
                            // uwa_create_log("Transfer Vendor Amount Error: " .  $e->getMessage()." Auction ID=".$product_id);
                        }
                    } /* end of if - v_sourceobj */
                }
                if ($vendor_commision_status == "Failed") {
                    $amount = $winning_bid_amt;
                } else {
                    $amount = $admin_commission;
                }
                if ($admin_commission > 0) {
                    $Jdata = \Stripe\PaymentIntent::create(array(
                        "amount" => ($amount * 100),
                        "currency" => $currency,
                        "customer" =>  $customer_id,
                        'payment_method_types' => array('card'),
                        'off_session' => true,
                        'confirm' => true,
                        'description' => 'Auto Debit For Auction#' . $product_id,
                    ));
                }
                if ($Jdata['status'] == "succeeded" && $admin_commission > 0) {
                    $amount = $admin_commission + $vednor_paided_amt;
                    $total_auto_debit = get_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, true);
                    if (!empty($total_auto_debit)) {
                        $total_auto_debit += $amount;
                    } else {
                        $total_auto_debit = $amount;
                    }
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, $total_auto_debit);
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_amt, $amount);
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "paid");
                    $debit_type = 'stripe_charge_type_full';
                    $data = array();
                    $data['pid'] = $product_id;
                    $data['uid'] = $userid;
                    $data['debit_type'] =  $debit_type;
                    $data['debit_amount_type'] = $debit_amount_type ?? "full";
                    $data['amount_or_percentage'] = $amount_or_percentage ?? $amount;
                    $data['transaction_amount'] = $amount;
                    $data['main_amount'] = $main_amount ?? $amount;
                    $data['status'] =  'succeeded';
                    $data['response_json'] = json_encode($Jdata);
                    $format = array('%s', '%d');
                    $wpdb->insert($wpdb->prefix . 'auction_direct_payment', $data, $format);

                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct vendor Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $admin_commission,
                            'p_debit_status'    => $Jdata['status'],
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                        /* vendor debit logs */
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct Debit to vendor",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $vendor_commision,
                            'p_debit_status'    => $vendor_commision_status,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }
                } else {
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                    $message = $this->gatway_payment_not_direct_debit;
                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                            'api_response_status'    => $Jdata['status'],
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct vendor Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $Jdata['status'],
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    return false;
                }
            } catch (\Stripe\Exception\CardException $e) {
                update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                $message = $e->getMessage();

                if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Api request for payment direct debit",
                        'activity_type'    => 'ua_api_requests_logs',
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'api_name'    => "https://api.stripe.com/v1/charges?payment_intent",
                        'api_response_status'    => $Jdata['status'],
                    );
                    $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                }
                if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Payment Direct vendor Debit",
                        'activity_type'    => 'ua_payment_direct_debit_logs',
                        'activity_by'    => $userid,
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'bid_value'    => $amount,
                        'p_debit_status'    => $message,
                    );
                    $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    if (!empty($activity)) {
                        $this->uat_auction_activity->insert_sub_activity_meta($activity, "products_activity_ID", $activity_sub);
                    }
                }
            }
        }
        return $message;
    }

    /**
     * braintree direct payment 
     */
    function braintree_direct_payment($product_id = "", $activity = "", $amount = "", $userid = "", $debit_type = "", $debit_amount_type = "", $amount_or_percentage = "", $main_amount = "")
    {
        $message = "";
        global $wpdb;
        if ($product_id) {
            try {
                update_post_meta($product_id, $this->_uwa_stripe_auto_debit_amt, $amount);
                $Uat_Auction_Braintree = new Uat_Auction_Braintree();

                $currency = get_woocommerce_currency();
                $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);

                $Jdata = $Uat_Auction_Braintree->debitAmount($customer_id, $product_id, $amount);
                $status = "Failed";
                if (isset($Jdata['success']) && $Jdata['success'] == true) {
                    $status = "succeeded";
                }
                if ($Jdata['success'] == true) {
                    $total_auto_debit = get_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, true);
                    if (!empty($total_auto_debit)) {
                        $total_auto_debit += $amount;
                    } else {
                        $total_auto_debit = $amount;
                    }
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, $total_auto_debit);
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "paid");

                    $data = array();
                    $data['pid'] = $product_id;
                    $data['uid'] = $userid;
                    $data['debit_type'] =  $debit_type;
                    $data['debit_amount_type'] = $debit_amount_type;
                    $data['amount_or_percentage'] = $amount_or_percentage;
                    $data['transaction_amount'] = $amount;
                    $data['main_amount'] = $main_amount;
                    $data['status'] =  'succeeded';
                    $data['response_json'] = json_encode($Jdata);
                    $format = array('%s', '%d');
                    $wpdb->insert($wpdb->prefix . 'auction_direct_payment', $data, $format);

                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "Braintree",
                            'api_response_status'    => 'succeeded',
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $status,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }
                } else {
                    update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                    $message = $this->gatway_payment_not_direct_debit;
                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    =>  "Api request for payment direct debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "Braintree",
                            'api_response_status'    => "Failed",
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Direct Debit",
                            'activity_type'    => 'ua_payment_direct_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $status,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    return false;
                }
            } catch (\Exception $e) {
                update_post_meta($product_id, $this->_uwa_stripe_auto_debit_status, "failed");
                $message = $e->getMessage();

                if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Api request for payment direct debit",
                        'activity_type'    => 'ua_api_requests_logs',
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'api_name'    => "Braintree",
                        'api_response_status'    => $status,
                        'api_response_gateway'    => $this->gateway,
                    );
                    $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                }
                if (!empty($this->ua_payment_direct_debit_logs) && $this->ua_payment_direct_debit_logs == 'enable') {
                    $activity_data = array(
                        'post_parent'    => $product_id,
                        'activity_name'    => "Payment Direct Debit",
                        'activity_type'    => 'ua_payment_direct_debit_logs',
                        'activity_by'    => $userid,
                        'activity_data'    => json_encode($Jdata),
                    );
                    $activity_meta = array(
                        'bid_value'    => $amount,
                        'p_debit_status'    => $message,
                    );
                    $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    if (!empty($activity)) {
                        $this->uat_auction_activity->insert_sub_activity_meta($activity, "products_activity_ID", $activity_sub);
                    }
                }
            }
        }
        return $message;
    }

    /**
     * braintree Buyer premium
     */
    function braintree_buyer_premium($winner_bid = "", $product_id = "", $userid = "", $log_type = "", $activity = "")
    {

        $message = "";
        global $wpdb;
        if ($userid) {
            $uwa_buyer_status = false;
            $uwa_buyer_price = 0;
            $uat_buyers_premium_amount = 0;
            $uat_buyers_premium_type = "";
            $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);;
            if (!empty($uat_event_id)) {
                /* Event product */
                $uwa_buyer_status = false;
                $uwa_buyer_price = uat_buyer_premium_value_event_products($uat_event_id, $winner_bid);
            } else {
                /* Without Event product */
                $uat_buyers_premium_type_sp_main = get_post_meta($product_id, 'uat_buyers_premium_type_sp_main', true);
                $uat_enable_buyers_premium_sp = get_option('options_uat_enable_buyers_premium_sp', "");
                if ($uat_enable_buyers_premium_sp == "yes") {
                    if ($uat_buyers_premium_type_sp_main == "global") {
                        $uwa_buyer_status = true;
                        $uwa_buyer_price = uwt_get_buyer_premium__globle_value($winner_bid);
                    } else {
                        $uat_buyers_premium_amount = get_post_meta($product_id, 'sp_buyers_premium_fee_amt', true);
                        $sp_buyers_premium = get_post_meta($product_id, 'sp_buyers_premium', true);
                        $sp_buyers_premium_auto_debit =  get_post_meta($product_id, 'sp_buyers_premium_auto_debit', true);
                        if ($sp_buyers_premium == "yes" && $sp_buyers_premium_auto_debit == "yes") {
                            $uwa_buyer_status = true;
                            $uat_buyers_premium_type =  get_post_meta($product_id, 'sp_buyers_premium_type', true);
                            if ($uat_buyers_premium_type == 'percentage') {
                                $uwa_buyer_price = ($winner_bid * $uat_buyers_premium_amount) / 100;
                                /* calculations for min max buyers premium */
                                $uwa_bpm_min_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_min', true);
                                $uwa_bpm_max_val =  get_post_meta($product_id, 'sp_buyers_premium_fee_amt_max', true);
                                $min_val = $uwa_bpm_min_val;
                                $max_val = $uwa_bpm_max_val;
                                if ($min_val > 0) {
                                    if ($uwa_buyer_price < $min_val) {
                                        $uwa_buyer_price = $min_val;
                                    }
                                }
                                if ($max_val > 0) {
                                    if ($uwa_buyer_price > $max_val) {
                                        $uwa_buyer_price = $max_val;
                                    }
                                }
                            } else {
                                $uwa_buyer_price = $uat_buyers_premium_amount;
                            }
                        }
                    }
                }
            }

            if ($uwa_buyer_status) {
                if ($uwa_buyer_price > 0) {
                    $amount = $uwa_buyer_price;
                    try {
                        $Uat_Auction_Braintree = new Uat_Auction_Braintree();

                        $currency = get_woocommerce_currency();
                        $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);
                        $Jdata = $Uat_Auction_Braintree->buyersPremiumAmount($customer_id, $product_id, $amount);
                        $status = "Failed";
                        if (isset($Jdata['success']) && $Jdata['success'] == true) {
                            $status = "succeeded";
                        }
                        if ($Jdata['success'] == true) {
                            $total_auto_debit = get_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, true);
                            if (!empty($total_auto_debit)) {
                                $total_auto_debit += $amount;
                            } else {
                                $total_auto_debit = $amount;
                            }
                            update_post_meta($product_id, $this->_uwa_stripe_auto_debit_total_amt, $total_auto_debit);
                            update_post_meta($product_id, $this->_uwa_stripe_auto_debit_bpm_amt, $amount);
                            $data = array();
                            $data['pid'] = $product_id;
                            $data['uid'] = $userid;
                            $data['debit_type'] =  'buyers_premium';
                            $data['debit_amount_type'] = $uat_buyers_premium_type;
                            $data['amount_or_percentage'] = $uat_buyers_premium_amount;
                            $data['transaction_amount'] = $amount;
                            $data['main_amount'] = $amount;
                            $data['status'] =  'succeeded';
                            $data['response_json'] = json_encode($Jdata);
                            $format = array('%s', '%d');
                            $wpdb->insert($wpdb->prefix . 'auction_direct_payment', $data, $format);

                            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                                $activity_data = array(
                                    'post_parent'    => $product_id,
                                    'activity_name'    => "Api request for Buyers Premium",
                                    'activity_type'    => 'ua_api_requests_logs',
                                    'activity_data'    => json_encode($Jdata),
                                );
                                $activity_meta = array(
                                    'api_name'    => "Braintree",
                                    'api_response_status'    => "succeeded",
                                    'api_response_gateway'    => $this->gateway,
                                );
                                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                            }
                            $activity_data = array(
                                'post_parent'    => $product_id,
                                'activity_name'    => "Buyers Premium Debit",
                                'activity_type'    => $log_type,
                                'activity_by'    => $userid,
                                'activity_data'    => json_encode($Jdata),
                            );
                            $activity_meta = array(
                                'bid_value'    => $amount,
                                'api_response_status'    => "succeeded",
                                'api_response_gateway'    => $this->gateway,
                            );
                            $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                            if (!empty($activity)) {
                                $this->uat_auction_activity->insert_sub_activity_meta($activity, "products_activity_ID", $activity_sub);
                            }
                        } else {
                            $message = $this->gatway_payment_not_direct_debit;
                        }
                    } catch (\Exception $e) {
                        $message = $e->getMessage();

                        if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                            $activity_data = array(
                                'post_parent'    => $product_id,
                                'activity_name'    => "Api request for Buyers Premium Debit",
                                'activity_type'    => 'ua_api_requests_logs',
                                'activity_data'    => json_encode($Jdata),
                            );
                            $activity_meta = array(
                                'api_name'    => "Braintree",
                                'api_response_status'    => $message,
                                'api_response_gateway'    => $this->gateway,
                            );
                            $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        }
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Buyers Premium Debit",
                            'activity_type'    => $log_type,
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $amount,
                            'p_debit_status'    => $message,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }
                }
            }
        }
        return  $message;
    }

    /**
     * braintree payment hold
     */
    function braintree_hold_payment($curent_bid = '', $product_id = '', $userid = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        if ($userid) {
            $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);

            if (!empty($customer_id)) {
                try {
                    $currency = get_woocommerce_currency();
                    $amount = wc_format_decimal($curent_bid, 2);
                    $Uat_Auction_Braintree = new Uat_Auction_Braintree();

                    $Jdata = $Uat_Auction_Braintree->holdAmount($customer_id, $product_id, $amount);
                    $status = "Failed";
                    if ($Jdata['success'] == true) {
                        $status = "succeeded";
                    }
                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Api request for payment hold",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );

                        $activity_meta = array(
                            'api_name'    => "Braintree",
                            'api_response_status'    => $status,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }
                    if ($Jdata['success'] == true) {
                        $transactionId = $Jdata['transaction']['id'];
                        $hold_status = "YES";
                        global $wpdb;
                        $data = array();
                        $data['pid'] = $product_id;
                        $data['uid'] = $userid;
                        $data['transaction_id'] = $transactionId;
                        $data['transaction_amount'] = $curent_bid;
                        $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'last_bid'");
                        if (!empty($refunresult)) {
                            if (!empty($refunresult[0]->transaction_id)) {
                                $message = $this->braintree_refunds_payment($refunresult[0]->uid, $bid_amout = $refunresult[0]->transaction_amount, $product_id, $transaction_id = $refunresult[0]->transaction_id, $activity);
                            }
                        }
                        $data['status'] = 'last_bid';
                        $data['response_json'] = json_encode($Jdata);

                        $format = array('%s', '%d');
                        $dataup = ['status' => 'old_bid'];
                        $whereup = ['pid' => $product_id];
                        $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                        $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
                        $message = "1";
                        $PaymentHoldMail = new PaymentHoldMail();
                        $PaymentHoldMail->payment_hold_email($product_id, $userid, $curent_bid);
                    } else {
                        $hold_status = "No";
                        $user_card_invalid_count = get_user_meta($userid, 'uat_card_invalid_count', true);
                        if (empty($user_card_invalid_count)) {
                            $user_card_invalid_count = 0;
                        }
                        $user_card_invalid_count = $user_card_invalid_count + 1;
                        update_user_meta($userid, 'uat_card_invalid_count', $user_card_invalid_count);
                        if ($user_card_invalid_count >= 3) {
                            update_user_meta($userid, 'uat_is_block', "yes");
                        }
                        $message = $this->gatway_payment_not_capture;
                    }
                    if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Hold fix amount ",
                            'activity_type'    => 'ua_payment_hold_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $curent_bid,
                            'p_hold_status'    => $hold_status,
                            'p_release_status'    => "-",
                            'BID_activity_ID'    => $activity,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                        }
                    }
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $this->gatway_card_not_found_msg;
            }
        }
        return $message;
    }
    /**
     * braintree payment hold fixed amount
     */
    function braintree_hold_fix_payment($curent_bid = '', $product_id = '', $userid = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        if ($userid) {
            $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);

            if (!empty($customer_id)) {
                try {
                    $currency = get_woocommerce_currency();
                    $uat_event_id = get_post_meta($product_id, 'uat_event_id', true);
                    if (!empty($uat_event_id)) {
                        $hold_fix_amount = get_post_meta($uat_event_id, 'ep_stripe_charge_type_fixed_amount', true);
                    } else {
                        $hold_fix_amount = get_post_meta($product_id, 'charge_hold_fix_amount', true);
                    }

                    if ($hold_fix_amount > 0) {
                        // \Stripe\Stripe::setApiKey($this->stripe_secret_key);
                        // check old hold exists
                        $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE uid='" . $userid . "' AND  pid='" . $product_id . "' AND  status = 'hold_fix'");
                        if (!empty($refunresult)) {
                            if (!empty($refunresult[0]->transaction_id)) {
                                // $message = "exists";
                                // $message = $this->stripe_refunds_payment($refunresult[0]->uid, $bid_amout = $refunresult[0]->transaction_amount, $product_id, $transaction_id = $refunresult[0]->transaction_id, $activity);
                            }
                        } else {

                            $Uat_Auction_Braintree = new Uat_Auction_Braintree();
                            $Jdata = $Uat_Auction_Braintree->holdAmount($customer_id, $product_id, $hold_fix_amount);
                            $status = "Failed";
                            if ($Jdata['success'] == true) {
                                $status = "succeeded";
                            }

                            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {
                                $activity_data = array(
                                    'post_parent'    => $product_id,
                                    'activity_name'    => "Api request for payment hold fix amount",
                                    'activity_type'    => 'ua_api_requests_logs',
                                    'activity_data'    => json_encode($Jdata),
                                );

                                $activity_meta = array(
                                    'api_name'    => "Braintree",
                                    'api_response_status'    => $status,
                                    'api_response_gateway'    => $this->gateway,
                                );
                                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                            }

                            if ($Jdata['success'] == true) {
                                global $wpdb;
                                $transactionId = $Jdata['transaction']['id'];
                                $hold_status = "YES";
                                $data = array();
                                $data['pid'] = $product_id;
                                $data['uid'] = $userid;
                                $data['transaction_id'] = $transactionId;
                                $data['transaction_amount'] = $hold_fix_amount;
                                $data['status'] = 'hold_fix';
                                $data['response_json'] = json_encode($Jdata);

                                $format = array('%s', '%d');
                                $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
                                $message = "1";
                                $PaymentHoldMail = new PaymentHoldMail();
                                $PaymentHoldMail->payment_hold_email($product_id, $userid, $hold_fix_amount);
                            } else {
                                $hold_status = "No";
                                $user_card_invalid_count = get_user_meta($userid, 'uat_card_invalid_count', true);
                                if (empty($user_card_invalid_count)) {
                                    $user_card_invalid_count = 0;
                                }
                                $user_card_invalid_count = $user_card_invalid_count + 1;
                                update_user_meta($userid, 'uat_card_invalid_count', $user_card_invalid_count);
                                if ($user_card_invalid_count >= 3) {
                                    update_user_meta($userid, 'uat_is_block', "yes");
                                }
                                $message = $this->gatway_payment_not_capture;
                            }
                            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                                $activity_data = array(
                                    'post_parent'    => $product_id,
                                    'activity_name'    => "Payment Hold fix amount ",
                                    'activity_type'    => 'ua_payment_hold_logs',
                                    'activity_by'    => $userid,
                                    'activity_data'    => json_encode($Jdata),
                                );
                                $activity_meta = array(
                                    'bid_value'    => $hold_fix_amount,
                                    'p_hold_status'    => $hold_status,
                                    'p_release_status'    => "-",
                                    'BID_activity_ID'    => $activity,
                                    'api_response_gateway'    => $this->gateway,
                                );
                                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                                if (!empty($activity)) {
                                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $message = $e->getMessage();
                }
            } else {
                $message = $this->gatway_card_not_found_msg;
            }
        }
        return $message;
    }
    /**
     * braintree Retrive payment 
     */
    function braintree_retrieve_payment($product_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;

        if ($product_id) {
            try {
                $transaction_id = "";
                $transaction_amount = "";
                $userid = "";
                $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'last_bid'");
                if (!empty($refunresult)) {
                    if (!empty($refunresult[0]->transaction_id)) {
                        $transaction_id = $refunresult[0]->transaction_id;
                        $transaction_amount = $refunresult[0]->transaction_amount;
                        $userid = $refunresult[0]->uid;
                    }
                }
                if (!empty($transaction_id)) {
                    $amount = ($transaction_amount);
                    $Uat_Auction_Braintree = new Uat_Auction_Braintree();
                    $Jdata = $Uat_Auction_Braintree->retriveAmount($userid, $product_id, $transaction_id);
                    $status = "Failed";
                    if (isset($Jdata['success']) && $Jdata['success'] == true) {
                        $status = "succeeded";
                    }
                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Api request for payment auto debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );

                        $activity_meta = array(
                            'api_name'    => "Braintree",
                            'api_response_status'    => $status,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }

                    if (!empty($this->ua_payment_hold_debit_logs) && $this->ua_payment_hold_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Debit",
                            'activity_type'    => 'ua_payment_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => ($amount),
                            'p_debit_status'    => $status,
                            'BID_activity_ID'    => $activity,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    if ($Jdata['success'] == true) {
                        update_post_meta($product_id, $this->_uwa_stripe_hold_total_amt, $transaction_amount);
                        $dataup = ['status' => 'retrieved_bid'];
                        $whereup = ['transaction_id' => $transaction_id];
                        $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                    } else {
                        $message = $this->payment_payment_not_retrive;
                    }
                }
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }
    /**
     * braintree Retrive fix hold payment 
     */
    function braintree_retrieve_fix_hold_payment($product_id = '', $activity = '', $user_id = '')
    {
        $message = "";
        global $wpdb;

        if ($product_id) {
            try {
                $transaction_id = "";
                $transaction_amount = "";
                $userid = "";
                $refunresult = $wpdb->get_results("SELECT transaction_id,transaction_amount,uid FROM " . $wpdb->prefix . 'auction_payment' . "   WHERE pid='" . $product_id . "' AND  status = 'hold_fix'");
                if (!empty($refunresult)) {
                    if (count($refunresult) > 0) {
                        foreach ($refunresult as $key => $transaction) {
                            $onetransaction_id = $transaction->transaction_id;
                            $one_uid = $transaction->uid;
                            $one_transaction_amount = $transaction->transaction_amount;
                            if ($one_uid != $user_id) {
                                $this->braintree_refunds_payment($one_uid, $one_transaction_amount, $product_id, $onetransaction_id, $activity = '');
                            } else {
                                $transaction_id = $transaction->transaction_id;
                                $transaction_amount = $transaction->transaction_amount;
                                $userid = $transaction->uid;
                            }
                        }
                    }
                }

                $winner_bid = get_post_meta($product_id, 'woo_ua_auction_current_bid', true);
                $activity_sub = "";
                if (!empty($transaction_id)) {
                    $customer_id = get_user_meta($userid, $wpdb->prefix . '_braintree_customer_id', true);
                    if ($winner_bid < $transaction_amount) {
                        $retrive_amunt = $winner_bid;
                    } else {
                        $retrive_amunt = $transaction_amount;
                    }
                    $Uat_Auction_Braintree = new Uat_Auction_Braintree();
                    $Jdata = $Uat_Auction_Braintree->retriveAmount($customer_id, $product_id, $transaction_id, $retrive_amunt);
                    $status = "Failed";
                    if (isset($Jdata['success']) && $Jdata['success'] == true) {
                        $status = "succeeded";
                    }

                    if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Api request for payment auto debit",
                            'activity_type'    => 'ua_api_requests_logs',
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'api_name'    => "Braintree",
                            'api_response_status'    => $status,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                    }

                    if (!empty($this->ua_payment_hold_debit_logs) && $this->ua_payment_hold_debit_logs == 'enable') {
                        $activity_data = array(
                            'post_parent'    => $product_id,
                            'activity_name'    => "Payment Debit hold fix amount",
                            'activity_type'    => 'ua_payment_debit_logs',
                            'activity_by'    => $userid,
                            'activity_data'    => json_encode($Jdata),
                        );
                        $activity_meta = array(
                            'bid_value'    => $winner_bid,
                            // 'bid_value'	=> ($amount / 100),
                            'p_debit_status'    => $status,
                            'BID_activity_ID'    => $activity,
                            'api_response_gateway'    => $this->gateway,
                        );
                        $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                        if (!empty($activity)) {
                            $this->uat_auction_activity->insert_sub_activity_meta($activity, "DEBIT_activity_ID", $activity_sub);
                        }
                    }

                    if ($status == "succeeded") {
                        update_post_meta($product_id, $this->_uwa_stripe_hold_total_amt, $transaction_amount);
                        $dataup = ['status' => 'retrieved_hold_fix'];
                        $whereup = ['transaction_id' => $transaction_id];
                        $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);
                    } else {
                        $message = $this->payment_payment_not_retrive;
                    }
                }
                /*if($winner_bid < $transaction_amount)
                {
                    $refund_amunt = $transaction_amount - $winner_bid;

                    $this->braintree_refunds_payment_amount($userid, $refund_amunt, $product_id, $transaction_id, $activity_sub);
                } */
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }
        }
        return $message;
    }
    /**
     * braintree payment refund hold fix amount
     */
    function braintree_refunds_payment_amount($userid = '', $refund_amout = '', $product_id = '', $transaction_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        try {
            $Uat_Auction_Braintree = new Uat_Auction_Braintree();
            $Jdata = $Uat_Auction_Braintree->refundOrVoidAmount($userid, $product_id, $transaction_id, $refund_amout);
            $status = "Failed";
            if (isset($Jdata['success']) && $Jdata['success'] == true) {
                $status = "succeeded";
            }


            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Payment Refund from hold fix",
                    'activity_type'    => 'ua_payment_hold_logs',
                    'activity_by'    => $userid,
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'bid_value'    => $refund_amout,
                    'p_hold_status'    => "-",
                    'p_release_status'    => "YES",
                    'BID_activity_ID'    => $activity,
                    'api_response_gateway'    => $this->gateway,
                );
                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                if (!empty($activity)) {
                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                }
            }
            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Api request for payment refund",
                    'activity_type'    => 'ua_api_requests_logs',
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'api_name'    => "Braintree",
                    'api_response_status'    => $status,
                    'api_response_gateway'    => $this->gateway,
                );
                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
            }

            if ($Jdata['success'] == true) {
                $dataup = ['status' => 'retrieved_hold_fix'];
                $whereup = ['transaction_id' => $transaction_id];
                $wpdb->update($wpdb->prefix . 'auction_payment', $dataup, $whereup);

                $data = array();
                $data['pid'] = $product_id;
                $data['uid'] = $userid;
                $data['transaction_id'] = $Jdata['transaction']['id'];
                $data['transaction_amount'] = $refund_amout;
                $data['status'] = 'hold_fix_refund';
                $data['response_json'] = json_encode($Jdata);

                $format = array('%s', '%d');
                $wpdb->insert($wpdb->prefix . 'auction_payment', $data, $format);
            } else {
                $message = $this->payment_payment_not_retrive;
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return $message;
    }
    /**
     * braintree payment refund hold
     */
    function braintree_refunds_payment($userid = '', $bid_amout = '', $product_id = '', $transaction_id = '', $activity = '')
    {
        $message = "";
        global $wpdb;
        try {
            $Uat_Auction_Braintree = new Uat_Auction_Braintree();
            $Jdata = $Uat_Auction_Braintree->refundOrVoidAmount($userid, $product_id, $transaction_id);
            if (!empty($this->uat_payment_hold_logs) && $this->uat_payment_hold_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Payment Refund",
                    'activity_type'    => 'ua_payment_hold_logs',
                    'activity_by'    => $userid,
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'bid_value'    => $bid_amout,
                    'p_hold_status'    => "-",
                    'p_release_status'    => "YES",
                    'BID_activity_ID'    => $activity,
                    'api_response_gateway'    => $this->gateway,
                );
                $activity_sub = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
                if (!empty($activity)) {
                    $this->uat_auction_activity->insert_sub_activity_meta($activity, "HOLD_activity_ID", $activity_sub);
                }
            }
            if (!empty($this->uat_api_requests_logs) && $this->uat_api_requests_logs == 'enable') {

                $activity_data = array(
                    'post_parent'    => $product_id,
                    'activity_name'    => "Api request for payment refund",
                    'activity_type'    => 'ua_api_requests_logs',
                    'activity_data'    => json_encode($Jdata),
                );
                $activity_meta = array(
                    'api_name'    => "Braintree",
                    'api_response_status'    => "YES",
                    'api_response_gateway'    => $this->gateway,
                );
                $activity_api_log = $this->uat_auction_activity->insert_activity($activity_data, $activity_meta);
            }
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        return $message;
    }
}
