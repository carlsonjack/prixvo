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

    if ($_POST['uwt_twilio_sms_sid']) {
        update_option('uwt_twilio_sms_sid', sanitize_text_field($_POST['uwt_twilio_sms_sid']));
    } else {
        delete_option('uwt_twilio_sms_sid');
    }

    if ($_POST['uwt_twilio_sms_token']) {
        update_option('uwt_twilio_sms_token', sanitize_text_field($_POST['uwt_twilio_sms_token']));
    } else {
        delete_option('uwt_twilio_sms_token');
    }

    if ($_POST['uwt_twilio_sms_from_number']) {
        update_option(
            'uwt_twilio_sms_from_number',
            $_POST['uwt_twilio_sms_from_number']
        );
    } else {
        delete_option('uwt_twilio_sms_from_number');
    }
    if ($_POST['uwt_twilio_whatsapp_from_number']) {
        update_option(
            'uwt_twilio_whatsapp_from_number',
            $_POST['uwt_twilio_whatsapp_from_number']
        );
    } else {
        delete_option('uwt_twilio_whatsapp_from_number');
    }
} /* end of if - save changes */

$uwt_twilio_sms_sid = get_option('uwt_twilio_sms_sid');
$uwt_twilio_sms_token = get_option('uwt_twilio_sms_token');
$uwt_twilio_sms_from_number = get_option('uwt_twilio_sms_from_number');
$uwt_twilio_whatsapp_from_number = get_option('uwt_twilio_whatsapp_from_number');
?>

<div class="uwt_main_setting_content">

    <form method='post' class='uwt_auction_setting_style'>
        <table class="form-table">
            <tbody>
                <tr class="uwt_heading">
                    <th colspan="2"><?php _e('Twilio Connection', "ultimate-auction-pro-software"); ?></th>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Account SID', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <div class="wrapper-tootltip">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
                                <path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
                            </svg>
                            <div class="tooltip"><?php echo wc_help_tip(_e('Log into your Twilio Account to find your Account SID.', "ultimate-auction-pro-software")); ?></div>
                            <input type="text" name="uwt_twilio_sms_sid" class="regular-text" id="uwt_twilio_sms_sid" value="<?php
                                                                                                                                echo $uwt_twilio_sms_sid; ?>">
                        </div>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Auth Token', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <div class="wrapper-tootltip">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
                                <path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
                            </svg>
                            <div class="tooltip"><?php echo wc_help_tip(_e('Log into your Twilio Account to find your Auth Token.', "ultimate-auction-pro-software")); ?></div>
                            <input type="text" name="uwt_twilio_sms_token" class="regular-text" id="uwt_twilio_sms_token" value="<?php
                                                                                                                                    echo $uwt_twilio_sms_token; ?>">
                        </div>
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('From Number', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <div class="wrapper-tootltip">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
                                <path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
                            </svg>
                            <div class="tooltip"><?php echo wc_help_tip(_e('Enter the number to send SMS messages from. This must be a purchased number from Twilio.', "ultimate-auction-pro-software")); ?></div>
                            <input type="text" name="uwt_twilio_sms_from_number" class="regular-text" id="uwt_twilio_sms_from_number" value="<?php echo $uwt_twilio_sms_from_number; ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('From Number for whatsapp', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <div class="wrapper-tootltip">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
                                <path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
                            </svg>
                            <div class="tooltip"><?php echo wc_help_tip(_e('Enter the number to send whatsapp SMS messages from. This must be a purchased number from Twilio.', "ultimate-auction-pro-software")); ?></div>
                            <input type="text" name="uwt_twilio_whatsapp_from_number" class="regular-text" id="uwt_twilio_whatsapp_from_number" value="<?php echo $uwt_twilio_whatsapp_from_number; ?>">
                        </div>
                    </td>
                </tr>
                <tr class="uwt_heading">
                    <th colspan="2"><?php _e('Send Test SMS', "ultimate-auction-pro-software"); ?></th>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Mobile Number', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <input type="text" name="uwt_twilio_sms_test_number" class="regular-text" id="uwt_twilio_sms_test_number" value="">
                    </td>
                </tr>

                <tr>
                    <th scope="row"><?php _e('Message', "ultimate-auction-pro-software"); ?></th>
                    <td class="uwaforminp">
                        <textarea name="uwt_twilio_sms_test_template" id="uwt_twilio_sms_test_template" style="min-width:500px;" class="" placeholder=""></textarea>
                    </td>
                </tr>

                <tr>
                    <th scope="row"></th>
                    <td class="uwaforminp">
                        <a href="#" class="uwt_twilio_sms_test_sms_button button">Send</a>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td class="uwaforminp">
                        <a href="#" class="uwt_twilio_sms_test_whatsapp_button button">Send Whatsapp SMS</a>
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