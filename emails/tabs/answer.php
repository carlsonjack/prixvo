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
	$email_slug ="answer";
	$subject_hint = __("{product_name} - Auction item name\\n
	{seller_name}\\n
	{username}\\n", 'ultimate-auction-pro-software');

	$body_hint =__("{product_name} - Auction item name\\n
	{seller_name}\\n
	{username}\\n", 'ultimate-auction-pro-software');
	uat_email_form_data_save($email_slug);
	?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php _e("Answer", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>
		 
		<?php echo get_email_templates($email_slug);?>

		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>

		<?php echo get_email_body_field($email_slug, $body_hint);?>
      </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>