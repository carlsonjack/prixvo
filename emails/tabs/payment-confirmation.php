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
    
	$email_slug ="payment_confirmation";	
	$subject_hint = __("Enter the subject of the email that is sent to the winner for payment confirmation. Available template tags:-\\n {site_title} - The name of the blog", 'ultimate-auction-pro-software');
					
	$body_hint =__("Enter the email that is sent to the winner for payment confirmation. HTML is accepted. Available template tags:-\\n  {product_url} - Auction item page URL with Auction name\\n {bid_value} - Auction total Amount\\n {order_summary} - Order summary\\n {order_id} - Order ID", 'ultimate-auction-pro-software');
									
	uat_email_form_data_save($email_slug);										
?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug; ?>-email-setting-form" method="post" action="">
	<h3><?php _e("Payment Confirmation", "ultimate-auction-pro-software"); ?></h3>
	<table class="form-table">
		<tbody>		
			<?php 
				echo get_email_enable_disable_field($email_slug); 
				echo get_email_templates($email_slug);
				echo get_email_subject_field( $email_slug,$subject_hint); 
				echo get_email_body_field($email_slug, $body_hint);
			?> 		
		</tbody>
	</table>
	<?php 	
		echo get_email_save_nonce_field($email_slug); 
	?>
</form>