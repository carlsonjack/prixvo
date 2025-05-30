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
	

 

	$email_slug ="email_save_search";
	$subject_hint = __("Enter the subject of the email that is sent to the bidder after winning an auction. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									 
								 
									", 'ultimate-auction-pro-software');
	$subject_hint_admin = __("Enter the subject of the email that is sent to the admin after winning an auction. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									 
									", 'ultimate-auction-pro-software');

	$body_hint_admin =__("Enter the email that is sent to the admin after winning an auction. HTML is accepted. Available template tags:-\\n									 
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n									 
									{product_description} - Auction item description", 'ultimate-auction-pro-software');

	$body_hint =__("Enter the email that is sent to the bidder after winning an auction. HTML is accepted. Available template tags:-\\n									 
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n									
									{product_description} - Auction item description", 'ultimate-auction-pro-software');

	uat_email_form_data_save($email_slug);
	?>
	
 <div class="wrap welcome-wrap uat-admin-wrap">
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php _e("Save Search", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>
	 

	 

		<?php echo get_email_templates($email_slug);?>

	 
		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>
 
		<?php echo get_email_body_field($email_slug, $body_hint);?>
      </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>
</div>