<?php
global $UATS_options;
$gateway = get_option('options_uat_payment_gateway', 'stripe');

$Uat_Auction_Payment = new Uat_Auction_Payment();
$payment_gatway_settings = $Uat_Auction_Payment->get_payment_gatway_settings();
$gateway = $payment_gatway_settings['gateway'] ?? "";

$user_id = get_current_user_id(); // Get the current user's ID
$seller_data = get_userdata($user_id);
$seller_email = $seller_data->user_email;
$store_name = $seller_data->user_login;


if (isset($_POST['seller_payment_methods_save'])) {
    if (isset($_POST['current_payment_method'])) {
        $seller_payment_methods = get_user_meta($user_id, 'uat_seller_payment_method_options', true);

        $selected_method = sanitize_text_field($_POST['current_payment_method']);
        update_user_meta($user_id, 'uat_seller_payment_method', $selected_method);
        if (empty($seller_payment_methods)) {
            $seller_payment_methods  = [];
        }
        if ($selected_method == 'bank') {
            $seller_payment_methods['bank']['ac_name'] = isset($_POST['ac_name']) ? sanitize_text_field($_POST['ac_name']) : '';
            $seller_payment_methods['bank']['ac_number'] = isset($_POST['ac_number']) ? sanitize_text_field($_POST['ac_number']) : '';
            $seller_payment_methods['bank']['bank_name'] = isset($_POST['bank_name']) ? sanitize_text_field($_POST['bank_name']) : '';
            $seller_payment_methods['bank']['bank_addr'] = isset($_POST['bank_addr']) ? sanitize_text_field($_POST['bank_addr']) : '';
            $seller_payment_methods['bank']['routing_number'] = isset($_POST['routing_number']) ? sanitize_text_field($_POST['routing_number']) : '';
            $seller_payment_methods['bank']['iban'] = isset($_POST['iban']) ? sanitize_text_field($_POST['iban']) : '';
            $seller_payment_methods['bank']['swift'] = isset($_POST['swift']) ? sanitize_text_field($_POST['swift']) : '';
            $seller_payment_methods['bank']['ifsc'] = isset($_POST['ifsc']) ? sanitize_text_field($_POST['ifsc']) : '';
        } elseif ($selected_method == 'stripe_split_pay') {
            $uat_seller_stripe_connected = get_user_meta($user_id, 'uat_seller_stripe_connected', true);
            $uat_stripe_user_id = get_user_meta($user_id, 'uat_stripe_user_id', true);
            $uat_seller_payment_method_data = [];
            $uat_seller_payment_method_data['connected'] = $uat_seller_stripe_connected;
            $uat_seller_payment_method_data['uat_stripe_user_id'] = $uat_stripe_user_id;
            $seller_payment_methods['stripe_split']['data'] = $uat_seller_payment_method_data;
        } elseif ($selected_method == 'braintree_split_pay') {
            $seller_payment_methods['braintree_split'] = [];
        }
        update_user_meta($user_id, 'uat_seller_payment_method_options', $seller_payment_methods);
    }
}
$seller_payment_methods = get_user_meta($user_id, 'uat_seller_payment_method_options', true);

$uat_seller_payment_method = get_user_meta($user_id, 'uat_seller_payment_method', true);
$ac_name = $seller_payment_methods['bank']['ac_name'] ?? "";
$ac_number = $seller_payment_methods['bank']['ac_number'] ?? "";
$bank_name = $seller_payment_methods['bank']['bank_name'] ?? "";
$bank_addr = $seller_payment_methods['bank']['bank_addr'] ?? "";
$routing_number = $seller_payment_methods['bank']['routing_number'] ?? "";
$iban = $seller_payment_methods['bank']['iban'] ?? "";
$swift = $seller_payment_methods['bank']['swift'] ?? "";
$ifsc = $seller_payment_methods['bank']['ifsc'] ?? "";

$seller_payment_settings = $UATS_options['seller_payment_settings'];
if (!empty($seller_payment_settings)) {
    $payment_methods = $seller_payment_settings['payment_methods'];
?>
    <div class="payment-options-seller border-bottom">

        <h2><?php echo __('Receive payment as seller', 'ultimate-auction-pro-software'); ?></h2>
        <form method="post">
            <?php
            if (!empty($payment_methods)) {
                $payment_method_selected = $payment_methods[0];
                $payment_method_key = $payment_method_selected['key'];
                $payment_method_title = $payment_method_selected['title'];
                echo "<input type='hidden' name='current_payment_method' value='" . $payment_method_key . "' />";
                if ($payment_method_key == 'stripe_split_pay') {
            ?>
                    <div class="payment-options" data-option="stripe_split_pay">
                        <div class="payment-box">
                            <div class="sub-text-cc"><?php echo __('Mention your bank account details', 'ultimate-auction-pro-software'); ?></div>
                            <?php
                            $account_url = '#';
                            $account_msg = '';
                            if ($gateway == 'stripe') {
                                $stripe_return_url = get_permalink() . 'uat-stripe';

                                $secret_key = $payment_gatway_settings['api_keys']['secret_key'] ?? "";
                                $client_id = $payment_gatway_settings['api_keys']['client_id'] ?? "";

                                $stripe = new \Stripe\StripeClient($secret_key);
                                if (isset($_GET['refresh_url'])) {
                                    delete_user_meta($user_id, 'uat_seller_stripe_connected');
                                    $account_msg = __('Please Retry!!!', 'ultimate-auction-pro-software');;
                                } elseif (isset($_GET['return_url'])) {
                                    update_user_meta($user_id, 'uat_seller_stripe_connected', 1);
                                    $account_url = add_query_arg('disconnect_stripe', 'disconnect_stripe', get_permalink());
                                    $account_msg = __('You are connected for receive automatic payments', 'ultimate-auction-pro-software');
                                    update_user_meta($user_id, 'uat_admin_client_id', $client_id);
                            ?>
                                    <script>
                                        window.location = '<?php echo $stripe_return_url; ?>';
                                    </script>
                                    <?php
                                } else {
                                    /* check account connected */
                                    $stripe_user_id = get_user_meta($user_id, 'uat_stripe_user_id', true);
                                    if (!empty($stripe_user_id)) {
                                        $seller_account = $stripe->accounts->retrieve($stripe_user_id, []);
                                        if (!empty($seller_account)) {
                                            if ($seller_account->details_submitted) {
                                                update_user_meta($user_id, 'uat_seller_stripe_connected', 1);
                                            } else {
                                                delete_user_meta($user_id, 'uat_seller_stripe_connected');
                                            }
                                        }
                                    } else {
                                        delete_user_meta($user_id, 'uat_seller_stripe_connected');
                                    }

                                    if (isset($_GET['disconnect_stripe']) && !empty($stripe_user_id)) {
                                        $testmode =  true;
                                        $client_id = $client_id;
                                        $secret_key = $secret_key;
                                        $token_request_body = array(
                                            'client_id' => $client_id,
                                            'stripe_user_id' => $stripe_user_id,
                                            'client_secret' => $secret_key
                                        );

                                        $target_url = 'https://connect.stripe.com/oauth/deauthorize';
                                        $headers = array(
                                            'User-Agent'    => __('UATS Stripe Split Pay', 'ultimate-auction-pro-software'),
                                            'Authorization' => 'Bearer ' . $secret_key,
                                        );
                                        $response    = wp_remote_post(
                                            $target_url,
                                            array(
                                                'sslverify'   => apply_filters('https_local_ssl_verify', false),
                                                'timeout'     => 70,
                                                'redirection' => 5,
                                                'blocking'    => true,
                                                'headers'     => $headers,
                                                'body'        => $token_request_body
                                            )
                                        );
                                        if (!is_wp_error($response)) {
                                            $resp = (array) json_decode($response['body']);
                                            if ((isset($resp['error']) && ($resp['error'] == 'invalid_client'))  || isset($resp['stripe_user_id'])) {
                                                delete_user_meta($user_id, 'uat_seller_stripe_connected');
                                                delete_user_meta($user_id, 'uat_admin_client_id');
                                                delete_user_meta($user_id, 'access_token');
                                                delete_user_meta($user_id, 'refresh_token');
                                                delete_user_meta($user_id, 'stripe_publishable_key');
                                                delete_user_meta($user_id, 'uat_stripe_user_id');
                                                $vendor_data['payment']['method'] = '';
                                                update_user_meta($user_id, 'wcfmmp_profile_settings', $vendor_data);
                                    ?>
                                                <script>
                                                    window.location = '<?php echo $stripe_return_url; ?>';
                                                </script>
                            <?php
                                            } else {
                                                $account_msg = __('Unable to disconnect your account pleease try again', 'ultimate-auction-pro-software');
                                            }
                                        } else {
                                            $account_msg = __('Unable to disconnect your account pleease try again', 'ultimate-auction-pro-software');
                                        }
                                    }
                                    $vendor_connected = get_user_meta($user_id, 'uat_seller_stripe_connected', true);
                                    $connected = true;
                                    if (isset($vendor_connected) && $vendor_connected == 1) {
                                        $account_url = add_query_arg('disconnect_stripe', 'disconnect_stripe', $stripe_return_url);
                                        $account_msg = __('You are connected for receive automatic payments', 'ultimate-auction-pro-software');
                                    } else {
                                        $connected = false;
                                    }
                                    if (!$connected) {
                                        $url = "#";
                                        $first_name = get_user_meta($user_id, 'first_name', true);
                                        $last_name  = get_user_meta($user_id, 'last_name', true);

                                        $status = delete_user_meta($user_id, 'uat_seller_stripe_connected');

                                        $stripe_connect_url = esc_url($stripe_return_url . 'assets/images/blue-on-light.png');
                                        $stripe_connect_url_ = $url;
                                        $account_id = get_user_meta($user_id, 'uat_stripe_user_id', true);
                                        if (empty($account_id)) {
                                            $accountsLinks = $stripe->accounts->create(['type' => 'express']);
                                            if (!empty($accountsLinks)) {
                                                $account_id = $accountsLinks->id;
                                                update_user_meta($user_id, 'uat_stripe_user_id', $account_id);
                                            }
                                        }
                                        if (!empty($account_id)) {
                                            $stripe_refresh_url = add_query_arg('refresh_url', 'yes', $stripe_return_url);
                                            $stripe_return_url = add_query_arg('return_url', 'yes', $stripe_return_url);
                                            $accountsLinks_url =  $stripe->accountLinks->create([
                                                'account' => $account_id,
                                                'refresh_url' => $stripe_refresh_url,
                                                'return_url' => $stripe_return_url,
                                                'type' => 'account_onboarding',
                                            ]);
                                            if (!empty($accountsLinks_url)) {
                                                $url = $accountsLinks_url->url;
                                            }
                                            if (!$status) {
                                                $account_url = $url;
                                                $account_msg = __('You are not connected for receive automatic payments', 'ultimate-auction-pro-software');
                                            } else {
                                                $account_url = $url;
                                                $account_msg = __('Please connected again.', 'ultimate-auction-pro-software');
                                            }
                                        } else {
                                            $account_url = $url;
                                            $account_msg = __('Please connected again.', 'ultimate-auction-pro-software');
                                        }
                                    }
                                }
                            }
                            $connected_seller = get_user_meta($user_id, 'uat_seller_stripe_connected');
                            $msg_class = "";
                            if (!$connected_seller) {
                                $msg_class = "error";
                                echo "<a class='payment-connect-btn woocommerce-Button woocommerce-Button--alt button alt' href='" . esc_url($account_url) . "' target='_self'>" . __('Activate bank account', 'ultimate-auction-pro-software') . "</a>";
                            } else {
                                $seller_payment_methods = get_user_meta($user_id, 'uat_seller_payment_method_options', true);
                                if (empty($seller_payment_methods)) {
                                    $seller_payment_methods = [];
                                }
                                $uat_seller_stripe_connected = get_user_meta($user_id, 'uat_seller_stripe_connected', true);
                                $uat_stripe_user_id = get_user_meta($user_id, 'uat_stripe_user_id', true);
                                $uat_seller_payment_method_data = [];
                                $uat_seller_payment_method_data['connected'] = $uat_seller_stripe_connected;
                                $uat_seller_payment_method_data['uat_stripe_user_id'] = $uat_stripe_user_id;
                                $seller_payment_methods['stripe_split']['data'] = $uat_seller_payment_method_data;
                                update_user_meta($user_id, 'uat_seller_payment_method_options', $seller_payment_methods);
                                update_user_meta($user_id, 'uat_seller_payment_method', $payment_method_key);
                                $msg_class = "success";
                                echo "<a class='payment-connect-btn woocommerce-Button woocommerce-Button--alt button alt' href='" . esc_url($account_url) . "' target='_self'>" . __('Bank account updated', 'ultimate-auction-pro-software') . "</a>";
                            }
                            if (!empty($account_msg)) {
                                echo "<p class='payment-connect-msg " . $msg_class . "' >" . $account_msg . "</p>";
                                // use "success" class for green massage
                            }
                            ?>
                        </div>
                    </div>
                <?php
                }
                if ($payment_method_key == 'bank') {
                ?>

                    <div class="payment-options" data-option="bank">
                        <h3><?php echo __('Bank account details', 'ultimate-auction-pro-software'); ?></h3>
                        <div class="seller-payment-row">
                            <label for="ac_name"><?php echo __('Account Name', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="ac_name" id="ac_name" placeholder="<?php echo __('Your bank account name', 'ultimate-auction-pro-software'); ?>" value="<?php echo $ac_name; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="ac_number"><?php echo __('Account Number', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="ac_number" id="ac_number" placeholder="<?php echo __('Your bank account number', 'ultimate-auction-pro-software'); ?>" value="<?php echo $ac_number; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="bank_name"><?php echo __('Bank Name', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="bank_name" id="bank_name" placeholder="<?php echo __('Name of bank', 'ultimate-auction-pro-software'); ?>" value="<?php echo $bank_name; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="bank_addr"><?php echo __('Bank Address', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="bank_addr" id="bank_addr" placeholder="<?php echo __('Address of your bank', 'ultimate-auction-pro-software'); ?>" value="<?php echo $bank_addr; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="routing_number"><?php echo __('Routing Number', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="routing_number" id="routing_number" placeholder="<?php echo __('Routing number', 'ultimate-auction-pro-software'); ?>" value="<?php echo $routing_number; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="iban"><?php echo __('IBAN', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="iban" id="iban" placeholder="<?php echo __('IBAN', 'ultimate-auction-pro-software'); ?>" value="<?php echo $iban; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="swift"><?php echo __('Swift Code', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="swift" id="swift" placeholder="<?php echo __('Swift code', 'ultimate-auction-pro-software'); ?>" value="<?php echo $swift; ?>">
                        </div>
                        <div class="seller-payment-row">
                            <label for="ifsc"><?php echo __('IFSC Code', 'ultimate-auction-pro-software'); ?></label>
                            <input type="text" class="input-text" name="ifsc" id="ifsc" placeholder="<?php echo __('IFSC code', 'ultimate-auction-pro-software'); ?>" value="<?php echo $ifsc; ?>">
                        </div>
                    </div>
                    <input class="woocommerce-Button woocommerce-Button--alt button alt" type="submit" name="seller_payment_methods_save" />
            <?php
                }
            }
            ?>
        </form>
    </div>
<?php
}
wp_register_script('uat-seller-payment-options', get_stylesheet_directory_uri() . '/assets/js/seller/payment-options.js', array('jquery'));
wp_enqueue_script('uat-seller-payment-options');
?>