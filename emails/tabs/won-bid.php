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

	$email_slug ="won_bid";
	$uat_enable_offline_dealing_for_buyer_seller = get_option( 'options_uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',"0" );
	$uat_do_you_want_to_send_information_via_email = get_option( 'options_uat_do_you_want_to_send_information_via_email',"0" );
	
	
	
	
	$subject_hint = __("Enter the subject of the email that is sent to the bidder after winning an auction. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									{event_name} - Event name of product\\n
									{bidder_name} - Bidder name\\n
									", 'ultimate-auction-pro-software');

	$subject_hint_admin = __("Enter the subject of the email that is sent to the admin after winning an auction. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									{event_name} - Event name of product\\n
									{bidder_name} - Bidder name\\n
									", 'ultimate-auction-pro-software');

	
	$subject_hint_seller_admin = __("Enter the subject of the email that is sent to the seller after winning an auction. Available template tags:-\\n
									{site_title} - The name of the blog\\n
									{product_name} - Auction item name\\n
									{event_name} - Event name of product\\n
									{bidder_name} - Bidder name\\n
									", 'ultimate-auction-pro-software');
	


	$body_hint_admin =__("Enter the email that is sent to the admin after winning an auction. HTML is accepted. Available template tags:-\\n
									{event_name} - Event name of product\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{bid_value} - The value of the bid placed\\n
									{bidder_name} - Winner name\\n
									{product_description} - Auction item description", 'ultimate-auction-pro-software');

	
	$body_hint_seller_admin =__("Enter the email that is sent to the seller after winning an auction. HTML is accepted. Available template tags:-\\n
									{event_name} - Event name of product\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{bid_value} - The value of the bid placed\\n
									{bidder_name} - Bidder Name\\n
									{bidder_email} - Bidder Email\\n
									{bidder_phone} - Bidder Phone\\n
									{bidder_address} - Bidder Address\\n
									{product_description} - Auction item description", 'ultimate-auction-pro-software');
	

	$body_hint =__("Enter the email that is sent to the bidder after winning an auction. HTML is accepted. Available template tags:-\\n
									{event_name} - Event name of product\\n
									{product_url} - Auction item page URL\\n
									{product_name} - Auction item name\\n
									{product_image} - Auction image\\n
									{currency_code} - The currency code\\n
									{bid_value} - The value of the bid placed\\n
									{bidder_name} - Winner Name\\n
									{seller_name} - Seller Name\\n
									{seller_email} - Seller Email\\n
									{seller_phone} - Seller Phone\\n
									{seller_address} - Seller Address\\n
									{product_description} - Auction item description\\n
									{order_pay_url} - Auction pay now url", 'ultimate-auction-pro-software');


	uat_email_form_data_save($email_slug);
	?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
   <h3><?php _e("Won Bid", "ultimate-auction-pro-software");?></h3>
   <table class="form-table">
      <tbody>
		<?php 
			echo get_email_enable_disable_field($email_slug);
		?>

		<?php echo get_email_admin_enable_disable_field( $email_slug );?>

		<?php 

		if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_do_you_want_to_send_information_via_email=='1'){
			echo get_email_seller_admin_enable_disable_field( $email_slug );
		}
		
		?>

		<?php echo get_email_templates($email_slug);?>

		<?php echo get_admin_email_subject_field( $email_slug,$subject_hint_admin);?>

		<?php 
		if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_do_you_want_to_send_information_via_email=='1'){
			echo get_seller_admin_email_subject_field( $email_slug,$subject_hint_seller_admin);
		}
		
		?>

		

		<?php echo get_email_subject_field( $email_slug,$subject_hint);?>

		<?php echo get_admin_email_body_field($email_slug, $body_hint_admin);?>

		<?php 
			if($uat_enable_offline_dealing_for_buyer_seller=='1' && $uat_do_you_want_to_send_information_via_email=='1'){
				echo get_seller_admin_email_body_field($email_slug, $body_hint_seller_admin);
			}
		?>

		<?php echo get_email_body_field($email_slug, $body_hint);?>
      </tbody>
   </table>
	<?php 	echo get_email_save_nonce_field($email_slug); ?>
</form>