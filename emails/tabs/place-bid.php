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

	$email_slug ="place_bid";
	$admin_subject_hint = __("Enter the subject of the email that is sent to the admin after successfully placing a bid. Available template tags:-\\n
									{username} - Bidder name\\n
									{event_name} - Event name of product\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction name\\n
									{product_url} - Auction URL\\n
									", 'ultimate-auction-pro-software');
	$subject_hint = __("Enter the subject of the email that is sent to the bidder after successfully placing a bid. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									{event_name} - Event name of product\\n
									{username} - Bidder name\\n
									", 'ultimate-auction-pro-software');

	$admin_body_hint =__("Enter the email that is sent to the admin after successfully placing a bid. HTML is accepted. Available template tags:-\\n
									{event_name} - Event name of product\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{bid_value} - The value of the bid placed\\n
									{username} - Bidder name\\n
									{product_description} - Auction item description", 'ultimate-auction-pro-software');

	$body_hint =__("Enter the email that is sent to the bidder after successfully placing a bid. HTML is accepted. Available template tags:-\\n
									{event_name} - Event name of product\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{bid_value} - The value of the bid placed\\n
									{username} - Bidder name\\n
									{product_description} - Auction item description", 'ultimate-auction-pro-software');

	uat_email_form_data_save($email_slug);
	?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php _e("Place Bid", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>
		<?php echo get_email_enable_disable_field($email_slug);?>

		<?php echo get_email_admin_enable_disable_field( $email_slug );?>

		<?php echo get_email_templates($email_slug);?>

		<?php echo get_admin_email_subject_field( $email_slug,$admin_subject_hint);?>


		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>

		<?php echo get_admin_email_body_field($email_slug, $admin_body_hint);?>
		<?php echo get_email_body_field($email_slug, $body_hint);?>
      </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>