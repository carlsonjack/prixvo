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
  								
	?>

   <h3><?php _e("Password Reset", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>
		<tr>
			<td><?php _e("Ultimate Auction Pro Software used WooCommerce default Reset password email.", "ultimate-auction-pro-software");?></td>
		<tr>
		<tr><?php $reset_mail_url  = admin_url('admin.php?page=wc-settings&tab=email&section=wc_email_customer_reset_password') ;?>
			<td><?php echo sprintf( __( '<a target="blank" href="%s"><strong>Click here for more setting.</strong></a>', "ultimate-auction-pro-software"), $reset_mail_url ); ?></td>
		<tr>
		
      </tbody>
   </table>
	