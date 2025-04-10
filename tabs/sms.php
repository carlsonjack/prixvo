<?php

/**
 * Extra Functions file
 *
 * @package Ultimate Auction Pro Software - business- twilio sms
 * @author Nitesh Singh
 * @since 1.0
 *
 */

if (!defined('ABSPATH')) {
    exit;
}

if (isset($_POST['uwt-settings-submit']) == 'Save Changes') {

    if (isset($_POST['uwt_twilio_sms_outbid_enabled'])) {
        update_option('uwt_twilio_sms_outbid_enabled', "yes");
    } else {
        update_option('uwt_twilio_sms_outbid_enabled', "no");
    }

    if (isset($_POST['uwt_twilio_sms_won_enabled'])) {
        update_option('uwt_twilio_sms_won_enabled', "yes");
    } else {
        update_option('uwt_twilio_sms_won_enabled', "no");
    }

    if (isset($_POST['uwt_twilio_sms_outbid_template'])) {
        update_option(
            'uwt_twilio_sms_outbid_template',
            sanitize_text_field($_POST['uwt_twilio_sms_outbid_template'])
        );
    }
    if (isset($_POST['uwt_twilio_sms_won_template'])) {
        update_option(
            'uwt_twilio_sms_won_template',
            sanitize_text_field($_POST['uwt_twilio_sms_won_template'])
        );
    }
    if (isset($_POST['uwt_twilio_sms_ending_soon_template'])) {
        update_option(
            'uwt_twilio_sms_ending_soon_template',
            sanitize_text_field($_POST['uwt_twilio_sms_ending_soon_template'])
        );
    }
} /* end of if - save changes */

$uwt_twilio_sms_outbid_enabled = get_option('uwt_twilio_sms_outbid_enabled');
$uwt_twilio_sms_won_enabled = get_option('uwt_twilio_sms_won_enabled');


$uwt_twilio_sms_outbid_enabled == "yes" ? $uwt_twilio_sms_outbid_checked = "checked" :
    $uwt_twilio_sms_outbid_checked = "";
$uwt_twilio_sms_won_enabled == "yes" ? $uwt_twilio_sms_won_checked = "checked" :
    $uwt_twilio_sms_won_checked = "";

$uwt_twilio_sms_outbid_template = get_option('uwt_twilio_sms_outbid_template', "You have been outbid on product id {product_id}, title {product_name}. The current highest bid is {bid_value}. Open {link} and place your bid.");

$uwt_twilio_sms_won_template = get_option('uwt_twilio_sms_won_template', "You have won auction product id {product_id}, title {product_name}. Click {this_pay_link} to pay.");

$uwt_twilio_sms_ending_soon_template = get_option('uwt_twilio_sms_ending_soon_template', "Auction id {product_id}, title {product_name} will be expiring soon. Place your highest bid to win it.");
?>
<div class="uwt_main_setting_content">
    
    <form method='post' class='uwt_auction_setting_style'>
        <table class="form-table">
            <tbody>
                <tr class="uwt_heading">
                    <th colspan="2"><?php _e('Customer Notifications SMS', "ultimate-auction-pro-software"); ?></th>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Enable Outbid SMS:', "ultimate-auction-pro-software"); ?></th>
                    <td>
                        <input <?php echo $uwt_twilio_sms_outbid_checked; ?> value="1" name="uwt_twilio_sms_outbid_enabled" type="checkbox">
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Outbid SMS Message:', "ultimate-auction-pro-software"); ?></th>
                    <td>
                        <textarea name="uwt_twilio_sms_outbid_template" id="uwt_twilio_sms_outbid_template" style="min-width:500px;" class="" placeholder=""><?php echo
                                                                                                                                                                $uwt_twilio_sms_outbid_template; ?></textarea><br>
                        <span class="description"><?php _e('Use these tags to customize your message: {product_name}, {bid_value}, {product_id}, {link}. Remember that SMS messages may be limited to 160 characters or less.', "ultimate-auction-pro-software");  ?>.</span>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Enable Won SMS:', "ultimate-auction-pro-software"); ?></th>
                    <td>
                        <input <?php echo $uwt_twilio_sms_won_checked; ?> value="1" name="uwt_twilio_sms_won_enabled" type="checkbox">
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Won SMS Message:', "ultimate-auction-pro-software"); ?></th>
                    <td>
                        <textarea name="uwt_twilio_sms_won_template" id="uwt_twilio_sms_won_template" style="min-width:500px;" class="" placeholder=""><?php echo
                                                                                                                                                        $uwt_twilio_sms_won_template; ?></textarea><br>
                        <span class="description"><?php _e('Use these tags to customize your message: {product_name}, {product_id}, {this_pay_link}. Remember that SMS messages may be limited to 160 characters or less.', "ultimate-auction-pro-software");  ?>.</span>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Ending Soon SMS Message:', "ultimate-auction-pro-software"); ?></th>
                    <td>
                        <textarea name="uwt_twilio_sms_ending_soon_template" id="uwt_twilio_sms_ending_soon_template" style="min-width:500px;" class="" placeholder=""><?php echo
                                                                                                                                                                        $uwt_twilio_sms_ending_soon_template; ?></textarea><br>
                        <span class="description"><?php _e(
                                                        'Use these tags to customize
            your message: {product_name}, {product_id}, {link}. Remember
            that SMS messages may be limited to 160 characters or less.',
                                                        "ultimate-auction-pro-software"
                                                    );  ?>.</span>
                    </td>
                </tr>

                <tr class="submit">
                    <th colspan="2">
                        <input type="submit" id="uwt-settings-submit" name="uwt-settings-submit" class="button-primary" value="<?php _e('Save Changes', "ultimate-auction-pro-software"); ?>" />
                    </th>
                </tr>

            </tbody>
        </table>
    </form>
</div>