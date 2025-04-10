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
	$email_slug = $email_type_tab;
	$subject_hint_admin = __("Enter the subject of the email that is sent to the seller once their product is Submitted. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									{seller_name} - Seller name\\n
									{seller_email} - Seller email\\n
									", 'ultimate-auction-pro-software');

	$body_hint_admin =__("Enter the email that is sent to the seller once their product is submitted. HTML is Submitted. Available template tags:-\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{product_description} - Auction item description\\n
									{seller_name} - Seller name\\n
									{seller_email} - Seller email", 'ultimate-auction-pro-software');
	$subject_hint = __("Enter the subject of the email that is sent to the seller once their product is Submitted. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									", 'ultimate-auction-pro-software');

	$body_hint =__("Enter the email that is sent to the seller once their product is submitted. HTML is Submitted. Available template tags:-\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{product_description} - Auction item description", 'ultimate-auction-pro-software');
	uat_email_form_data_save($email_slug);

	$newArray = array();
	$label = "";
	foreach ($email_tabs as $email_tab) {
		if ($email_tab['slug'] === $email_slug) {
			$label = $email_tab['label'];
		}
	}
	?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php echo $label; ?></h3>
   <table class="form-table">
      <tbody>
		<?php echo get_email_enable_disable_field($email_slug);?>
		<?php echo get_email_admin_enable_disable_field( $email_slug );?>
		<?php echo get_email_templates($email_slug);?>
		<?php echo get_admin_email_subject_field( $email_slug,$subject_hint_admin);?>
		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>
		<?php echo get_admin_email_body_field($email_slug, $body_hint_admin);?>
		<?php echo get_email_body_field($email_slug, $body_hint);?>
	  </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>