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

	$email_slug ="registration_confirm";
	$subject_hint = __("Enter the subject of the email that is sent to the user after the registration on the site. Available template tags:-\\n
					{site_title} - The name of the blog\\n
					{username} - Name of user\\n
               {first_name} - First Name of user", 'ultimate-auction-pro-software');

	$body_hint =__("Enter the email that is sent to the user after successful registration on the site. HTML is accepted. Available template tags:-\\n
					{username} - Name of user\\n
					{confirmation_link} - Confirmation link\\n
               {first_name} - First Name of user ", 'ultimate-auction-pro-software');
	uat_email_form_data_save($email_slug);
	?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php _e("Registration Confirm Email", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>

		<?php echo get_email_enable_disable_field($email_slug);?>

      <?php echo get_email_admin_enable_disable_field( $email_slug );?>

		<?php echo get_email_templates($email_slug);?>

		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>

		<?php echo get_email_body_field($email_slug, $body_hint);?>

      </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>