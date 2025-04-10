<?php

/*
* Ultimate_Auction_Pro_Admin_Emails class
*
* This class initiate general purpose custom fields.
*/
if (!defined('ABSPATH'))
{
    die('Access denied.');
}

	function ultimate_auction_pro_emails_tabs( )
	{
		$uat_email_tabs = array(
			array(
				'slug' => 'place_bid',
				'label' => __('Place Bid', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'registration_confirm',
				'label' => __('Registration Confirm Email', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'registration_approved_admin',
				'label' => __('Registrations Approval Admin', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'registration_approved',
				'label' => __('Registrations approval', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'registration_reject',
				'label' => __('Registration Rejection', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'outbid',
				'label' => __('Outbid', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'password_reset',
				'label' => __('Password Reset', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'won_bid',
				'label' => __('Won Bid', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'loose_bid',
				'label' => __('Lost Bid', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'ending_soon',
				'label' => __('Ending Soon', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'payment_hold',
				'label' => __('Payment Hold', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'payment_reminder',
				'label' => __('Payment Reminder', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'payment_confirmation',
				'label' => __('Payment Confirmation', 'ultimate-auction-pro-software')),
			array(
				'slug' => 'question',
				'label' => __('Question', 'ultimate-auction-pro-software')),
				array(
				'slug' => 'answer',
				'label' => __('Answer', 'ultimate-auction-pro-software')),
		);
		return $uat_email_tabs;

	}
	 /**
	* Seller module used email notifications.
	*/
	function ultimate_auction_pro_seller_emails_tabs( )
	{
		$uat_email_tabs = array(
			array(
				'slug' => 'uat_submited_mail',
				'label' => __('Submitted', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Submitted', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is submitted for review.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_under_review_mail',
				'label' => __('Under review', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Under Review Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is under review.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_not_approved_mail',
				'label' => __('Not approved', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Not Approved Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is not approved.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_change_needed_mail',
				'label' => __('Adjustment Needed', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Adjustment Needed Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when adjustments are needed for your auction.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_approved_mail',
				'label' => __('Approved', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Approved Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is approved.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_planned_mail',
				'label' => __('Planned', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Planned Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is planned.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_in_auction_mail',
				'label' => __('In Auction', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable In Auction Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction is live.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_auctined_mail',
				'label' => __('Auctioned', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Auctioned Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction has been successfully auctioned.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_not_sold_mail',
				'label' => __('Not sold', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Not sold Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when your auction did not sell.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_payment_received_mail',
				'label' => __('Payment received', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Payment Received to admin Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when payment for your auction is received to admin.', 'ultimate-auction-pro-software'),
			),
			array(
				'slug' => 'uat_paid_mail',
				'label' => __('Paid', 'ultimate-auction-pro-software'),
				'user_label' => __('Enable Payment Sended Email', 'ultimate-auction-pro-software'),
				'hint' => __('Receive an email notification when you send payment for an auction.', 'ultimate-auction-pro-software'),
			),

		);
		return $uat_email_tabs;

	}		
     /**
	* Preview email template.
	*/
	add_action('admin_init', 'ultimate_auction_pro_preview_uat_mail');
	function ultimate_auction_pro_preview_uat_mail() {
		if ( isset( $_GET['preview_uat_mail'] ) ) {
			if ( ! ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ), 'preview-uat-mail' ) ) ) {
				//die( 'Security check' );
			}
			$uat_Email = new Ultimate_Auction_Pro_Email();
			$email_slug = isset($_GET['email_type']) ? $_GET['email_type'] : null;
			if(!empty($email_slug)){
				echo $uat_Email->get_content($email_slug, $user_id=1, $product_id="");
			}
			 exit;
		}
	}
	/**
	* Load Default data while theme active
	*/
	if(get_option("uat_email_default_data_loaded") !="yes"){
		add_action('admin_init', 'uat_email_load_default_data');
	}
	function uat_email_load_default_data() {
		$admin_email = get_option('admin_email');
		$blogname = get_option('blogname');
		$image_ID = get_option('options_uat_website_logo');
		$popupLLogos = wp_get_attachment_image_src($image_ID, 'full');
		$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'logo.png';
		$popupLogo = isset($popupLLogos[0]) ? $popupLLogos[0] : $thumb_image_d;
		$email_types = array(
			array(
				'email_type' => 'email_setting',
				'h_image' => $popupLogo,
				'template' => 'customize',
				'from_name' => $blogname,
				'from_address' => $admin_email,
			),
			array(
				'email_type' => 'place_bid',
				'enable' => '',
				'admin_enable' => '',
				'template' => 'custom',
				'subject_admin' => "{username} recently placed a bid on Auction -{product_name}",
				'subject' => "You recently placed a bid on {site_title}.",
				'body_admin' => "Hi
								A bid was placed a bid on {product_url}.

								<strong>Here are the details :</strong>

								<strong>Current bid :</strong> {currency_code}{bid_value}
								<strong>Product :</strong> {product_url}
							",
				'body' => "Hi {bidder_name},
							You recently placed a bid on {product_url}.

							<strong>Here are the details :</strong>

							<strong>Your bid :</strong> {currency_code}{bid_value}
							<strong>Product :</strong> {product_url}
							",

			),
			array(
				'email_type' => 'registration_confirm',
				'enable' => '',
				'admin_enable' => '',
				'template' => 'custom',
				'subject' => "Registration Confirm Email on {site_title}.",
				'body' => "Dear {username},

Many thanks for registering on the {site_title} To activate an account we would like to confirm your email address.

After the successful confirmation of your email address you will login your account. Click the link below to confirm your email address.

{confirmation_link}
",
'admin_enable' => 'yes',
				),
	array(
				'email_type' => 'registration_approved_admin',
				'enable' => '',
				'template' => 'custom',
				'subject' => "New User Registration Approval Email on {site_title}.",
				'body' => "Dear admin,

						New User On {site_title}.

						User Name :  {username}.

						Email :  {useremail}.

						The Admin Approval Feature was activated at the time of registration, so please remember that you need to approve this user before he/she can login!

						You can approvethis user by clicking the the following link : {approve_link}",

				),

			array(
				'email_type' => 'registration_approved',
				'enable' => '',
				'template' => 'custom',
				'subject' => "Your registration for {site_title} has been approved.",
				'body' => "Dear <strong>{username}</strong>,
				Your registration for {site_title} has been approved.
				<strong>Username</strong> : {username}",
				),

			array(
				'email_type' => 'registration_reject',
				'enable' => '',
				'template' => 'custom',
				'subject' => "Your Registration is Rejected on {site_title}.",
				'body' => "Dear {username},

Thank you for taking the time to consider {site_title}. We wanted to let you know that due to some reason your registration is rejected by Admin.
							",
			),
			array(
				'email_type' => 'outbid',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "You have been outbid on {site_title}.",
				'body' => "Hi {bidder_name},

						You have been outbid on the product {product_url}.

						<strong>Here are the details :</strong>

						<strong>Current bid :</strong> {currency_code}{bid_value}
						<strong>Product :</strong> {product_url}

						If you want to bid a new amount, click here {product_url}.
						",


			),
			array(
				'email_type' => 'won_bid',
				'enable' => 'yes',
				'template' => 'custom',
				'admin_enable' => 'yes',
				'seller_enable' => 'yes',
				'subject_admin' => "Congratulations your product - {product_name} sold",
				'subject_seller_admin' => "{bidder_name} won an Auction - {product_name}.",
				'subject' => "You have won an auction on {site_title}.",
				'body' => "Hi {bidder_name},

						Congratulations! You are the winner! of the auction product {product_url}.

						<strong>Here are the details :</strong>

						<strong>Current bid :</strong> {currency_code}{bid_value}
						<strong>Product :</strong> {product_url}
						<strong>Payment Link :</strong> {order_pay_url}
						",
				'body_admin' => "Hi

						The auction has expired and won by user. Auction url {product_url}.

						<strong>Here are the details :</strong>

						<strong>Won bid :</strong> {currency_code}{bid_value}
						<strong>Product :</strong> {product_url}

						",
				'body_admin_seller' => "Hi

				The auction has expired and won by user. Auction url {product_url}.

				You can get in touch with the Buyer to finish the sale.

				Below is the Buyer  contact information:
				<strong>Buyer Name:</strong> {bidder_name}
				<strong>Buyer Contact Information:</strong>
				Email: {bidder_email}
				Phone: {bidder_phone}
				<strong>Here are the details :</strong>

				<strong>Won bid :</strong> {currency_code}{bid_value}
				<strong>Product :</strong> {product_url}

				",


			),
			array(
				'email_type' => 'loose_bid',
				'enable' => '',
				'template' => 'custom',
				'subject' => "You have lost {product_name}.",
				'body' => "Dear {username},
					We regret to inform you that you have lost {product_name} on {site_title}.",

			),
			array(
				'email_type' => 'payment_reminder',
				'template' => 'custom',
				'subject' => "Payment Reminder - You have won an auction on {site_title}.",
				'body' =>  "Hi {bidder_name},
							Your Payment is due.
							You have won an auction product {product_url}.
							<strong>Below are the details :</strong>
							<strong>Winning bid :</strong> {bid_value}
							<strong>Product :</strong> {product_url}
							<strong>Payment Link :</strong> {order_pay_url}
							",

			),
			array(
				'email_type' => 'payment_confirmation',
				'template' => 'custom',
				'subject' => "Payment Confirmed",
				'body' =>  "You payment has been confirmed for {product_url}.
							<strong>Below are the details :</strong>
							<strong>Winning bid :</strong> {bid_value}		
							<strong>Product :</strong> {product_url}",


			),
			array(
				'email_type' => 'question',
				'template' => 'custom',
				'subject' => "New question for {product_name}",
				'body' => "Hi {seller_name},
				{username} has posted a question for your {product_name}. Kindly read and provide answer for it.",


			),
			array(
				'email_type' => 'answer',
				'template' => 'custom',
				'subject' => "Answer posted for {product_name}",
				'body' => "Hi {username} ,
				{seller_name} has answered your question posted for {product_name}. Kindly read it.",


			),
			array(
				'email_type' => 'ending_soon',
				'template' => 'custom',
				'subject' => "Auction Ending soon on {site_title}.",
				'body' => "Hi {bidder_name},

						Auction {product_url} is going to be expire at {auction_endtime}.

						<strong>Here are the details :</strong>
						<strong>Current bid :</strong> {currency_code}{bid_value}
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'payment_hold',
				'template' => 'custom',
				'subject' => "New Payment hold on {product_name}",
				'body' => "Hi,

						Auction {product_url} have new payment hold.

						<strong>Here are the details :</strong>
						<strong>Current bid :</strong> {currency_code}{bid_value}
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_submited_mail',
				'enable' => '',
				'template' => 'custom',
				'admin_enable' => 'yes',
				'subject_admin' => "New product submission received",
				'subject' => "Your product has been submitted successfully",
				'body' => "Hi,
				
				Thank you for submitting your product on our platform. It will now be reviewed by our team. You will be notified when it is approved or if any adjustments are needed.
				
						<strong>Here are the details :</strong>
						<strong>Product :</strong> {product_url}
						",
				'body_admin' => "Dear Admin,

								A new product submission has been received from the following seller:
								
								<strong>Seller Name:</strong> {seller_name}
								<strong>Seller Email:</strong> {seller_email}
								
								<strong>Product Details:</strong>
								
								<strong>Product Name:</strong> {product_name}

								Please review the product submission and take the necessary actions.
								
								Thank you
						",
			),
			array(
				'email_type' => 'uat_under_review_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product is under review.",
				'body' => "Hi,

						Your product is currently under review by our team. We are checking the details and will let you know if any adjustments are needed. Thank you for your patience.

						<strong>Here are the details :</strong>
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_not_approved_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product has not been approved.",
				'body' => "Hi,

						We regret to inform you that your product has not been approved due to various reasons. Please check your email for more information.

						<strong>Here are the details :</strong>
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_change_needed_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Adjustment needed for your product.",
				'body' => "Hi,

						We have reviewed your product and found that some adjustments are needed before it can be approved. Please make the necessary changes and resubmit your product.

						<strong>Here are the details :</strong>
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_approved_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Congratulations! Your product has been approved.",
				'body' => "Hi,

						Your product has been approved and is now available for use in an event. Thank you for using our platform.

						<strong>Here are the details :</strong>
						<strong>Product :</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_planned_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product is scheduled for live.",
				'body' => "Hi,

				We're excited to inform you that your product is now scheduled for publication on our platform. We'll notify you as soon as it's live. Thank you for choosing our platform.
				
				Here are the details:
				
				Product: {product_url}
						",
			),
			array(
				'email_type' => 'uat_in_auction_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product is now live for auction!",
				'body' => "Hi,


						We are excited to inform you that your product has been successfully listed and is now live for auction on our platform. 
						This is a great opportunity for you to showcase your item to potential buyers and get the best possible price.
						
						
						<strong>Here are the details:</strong>
						
						<strong>Product:</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_auctined_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product has been auctioned.",
				'body' => "Hi,

						Congratulations! Your product has been successfully auctioned on our platform. Thank you for using our platform.

						<strong>Here are the details:</strong>
						<strong>Product:</strong> {product_url}
						",
			),
			array(
				'email_type' => 'uat_not_sold_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product did not sell.",
				'body' => "Hi,

						We regret to inform you that your product did not sell at auction. Don't be disheartened; there are always opportunities for success in the future.
						
						Here are the details:
						Product: {product_url}
						
						Feel free to relist your product or explore other options in your seller's dashboard. We appreciate your participation.
						",
			),
			array(
				'email_type' => 'uat_payment_received_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Your product payment has been received.",
				'body' => "Hi,

						We are excited to inform you that the payment for your product has been successfully received from the buyer. Congratulations on the sale!
						
						Here are the details:
						Product: {product_url}
						",
			),
			array(
				'email_type' => 'uat_paid_mail',
				'enable' => 'yes',
				'template' => 'custom',
				'subject' => "Payment for your product has been sent.",
				'body' => "Hi,

						Congratulations! Your product has been successfully auctioned on our platform. Thank you for using our platform.

						<strong>Here are the details:</strong>
						<strong>Product:</strong> {product_url}
						",
			)

		);

		foreach ($email_types as $email_form_data) {
			if (is_array($email_form_data)) {
				$email_type = $email_form_data["email_type"];
					
				$email_template_details = array(
					'template' => (isset($email_form_data["template"]) ? $email_form_data["template"] : ""),
					'enable' => (isset($email_form_data["enable"]) ? $email_form_data["enable"] : "no"),
					'subject' => (isset($email_form_data["subject"]) ? stripslashes($email_form_data["subject"]) : ""),
					'subject_admin' => (isset($email_form_data["subject_admin"]) ? stripslashes($email_form_data["subject_admin"]) : ""),
					'body' => (isset($email_form_data["body"]) ? wpautop($email_form_data["body"]) : ""),
					'body_admin' => (isset($email_form_data["body_admin"]) ? wpautop($email_form_data["body_admin"]) : ""),
					'from_name' => (isset($email_form_data["from_name"]) ? $email_form_data["from_name"] : $blogname),
					'from_address' => (isset($email_form_data["from_address"]) ? $email_form_data["from_address"] : $admin_email),
					'admin_enable' => (isset($email_form_data["admin_enable"]) ? $email_form_data["admin_enable"] : "no"),
					'time_left' => (isset($email_form_data["time_left"]) ? $email_form_data["time_left"] : ""),
				);
				//$email_template_details = apply_filters("uat_email_template_details_save", $email_template_details, $email_form_data, $email_type);
				update_option("uat_email_template_" . $email_type, $email_template_details);						
			}
		}
		update_option("uat_email_default_data_loaded","yes");
	}
	function get_email_preview_link( $email_slug ) {
		?>
		<tr valign="top">
							<th scope="row"></th>
							<td>
							<?php
							$admin_url = get_admin_url().'?preview_uat_mail&email_type='.$email_slug;
							$uwa_email_preview_url = wp_nonce_url( $admin_url, 'preview-uat-mail' );
							echo sprintf( __( "%sClick here to preview your email template%s.", "ultimate-auction-pro-software" ),'<a  class="button-secondary" target="_blank" href='.$uwa_email_preview_url.'>', '</a>' );
							?>
							</td>
					</tr>
		<?php
		}

	function get_email_temaplte_from_db( $email_slug ) {
		$email_template_details = get_option("uat_email_template_" .$email_slug);
		return $email_template_details;
	}

	function get_email_templates( $email_slug ) {
		$template_details = get_email_temaplte_from_db($email_slug);
	    $template = isset($template_details['template']) ? $template_details['template'] : "default";
		$footer_txt = isset($template_details['footer_txt']) ? $template_details['footer_txt'] : "{site_title} — Built with {Ultimate Auction Pro}";
		$base_color = isset($template_details['base_color']) ? $template_details['base_color'] : "#96588a";
		$bg_color = isset($template_details['bg_color']) ? $template_details['bg_color'] : "#f7f7f7";
		$body_bg_color = isset($template_details['body_bg_color']) ? $template_details['body_bg_color'] : "#ffffff";
		$body_text_color = isset($template_details['body_text_color']) ? $template_details['body_text_color'] : "#3c3c3c";
		?>
		 <tr valign="top">
            <th scope="row"><?php _e("Email Template", "ultimate-auction-pro-software");?></th>
            <td>
               <input class="input-text regular-input" type="radio" name="<?php echo $email_slug;?>[template]" id="uat_email_template_default"
			   value="default" <?php checked( "default" == $template ); ?> /><?php _e("Default", "ultimate-auction-pro-software");?>

			   <input class="input-text regular-input" type="radio" name="<?php echo $email_slug;?>[template]" id="uat_email_template_custom"  value="custom" <?php checked( "custom" == $template ); ?>> <?php _e("Custom", "ultimate-auction-pro-software");?>
			   <div class="ult-auc-settings-tip"><?php _e("Select email template for the email type.", "ultimate-auction-pro-software");?>	</div>
            </td>
         </tr>
		 <tr valign="top">
			<th scope="row"></th>
			<td>
			<?php
			$admin_url = get_admin_url().'?preview_uat_mail&email_type='.$email_slug;
			$uwa_email_preview_url = wp_nonce_url( $admin_url, 'preview-uat-mail' );
			echo sprintf( __( "%sClick here to preview your email template%s.", "ultimate-auction-pro-software" ),'<a  class="button-secondary" target="_blank" href='.$uwa_email_preview_url.'>', '</a>' );
			?>
			</td>
		</tr>

			<tr class="show_custom_temp" style="display:none;">
           		<th><h2><?php _e("Custom Email template", "ultimate-auction-pro-software");?></h2></th>
		    </tr>

		   <tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Footer text', "ultimate-auction-pro-software");?></label></th>
           		<td>
				<textarea id="footer_txt" name="<?php echo $email_slug;?>[footer_txt]" rows="4" cols="50"><?php  echo $footer_txt; ?></textarea>
           		<div class="ult-auc-settings-tip"><?php _e("The text to appear in the footer of all Auction emails. Available placeholders: {site_title} {site_url}", "ultimate-auction-pro-software");?>	</div>
           		</td>
           	</tr>
		   <tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Base color', "ultimate-auction-pro-software");?></label></th>
           		<td>
				<input id="base_color" name="<?php echo $email_slug;?>[base_color]"  value="<?php  echo $base_color; ?>" type="text" value="" data-default-color="#96588a" />
           		<div class="ult-auc-settings-tip"><?php _e("The base color for Auction emails templates. Default #96588a.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

			<tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Background color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="bg_color" name="<?php echo $email_slug;?>[bg_color]" value="<?php  echo $bg_color; ?>" type="text" value="" data-default-color="#f7f7f7" />
           		<div class="ult-auc-settings-tip"><?php _e("The background color for WooCommerce email templates. Default #f7f7f7.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

			<tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Body background color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="body_bg_color" name="<?php echo $email_slug;?>[body_bg_color]" type="text" value="<?php  echo $body_bg_color; ?>" data-default-color="#ffffff" />
           		<div class="ult-auc-settings-tip"><?php _e("The main body background color. Default #ffffff.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

		  	<tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Body text color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="body_text_color" name="<?php echo $email_slug;?>[body_text_color]"  type="text" value="<?php  echo $body_text_color; ?>" data-default-color="#3c3c3c" />
           		<div class="ult-auc-settings-tip"><?php _e("The main body text color. Default #3c3c3c.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>
			
			<?php wp_enqueue_script( 'jquery-color-picker', UAT_THEME_PRO_JS_URI . 'color-picker.js', array('wp-color-picker'), UAT_THEME_PRO_VERSION); ?>

			<script type="text/javascript">
			jQuery(document).ready(function($){
				var template = "<?php echo $template;?>";
				if(template  === 'custom'){
				 jQuery("tr.show_custom_temp").show();
				}else{
					jQuery("tr.show_custom_temp").hide();
				}				
			});
			jQuery('input:radio[name="<?php echo $email_slug;?>[template]"]').change(function(){
				if(jQuery(this).val() === 'custom'){
				 jQuery("tr.show_custom_temp").show();
				}else{
					jQuery("tr.show_custom_temp").hide();
				   }
			});			
			
			(function( $ ) { 
				// Add Color Picker to all inputs that have 'color-field' id
				$(function() {
					$('#base_color').wpColorPicker();
					$('#bg_color').wpColorPicker();
					$('#body_bg_color').wpColorPicker();
					$('#body_text_color').wpColorPicker();
				});				 
			})( jQuery );

			</script>
		<?php
	}

	function get_email_pay_interval_field( $email_slug ) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$remind_to_pay_interval = isset($template_details['remind_to_pay_interval']) ? $template_details['remind_to_pay_interval'] :5;
		$remind_to_pay_interval_number = isset($template_details['remind_to_pay_interval_number']) ? $template_details['remind_to_pay_interval_number'] :4;

		?>
		 <tr valign="top" style="display:none">
            <th scope="row"><?php _e( 'Interval in Days.', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="regular-input " min="1" type="number" name="<?php echo $email_slug;?>[remind_to_pay_interval]" id="uat_email_remind_to_pay_interval" style="width:120px;" value="<?php echo $remind_to_pay_interval?>"  placeholder="Enter in Days">
               <br><?php _e( 'Set reminder interval in days. Default is 5', 'ultimate-auction-pro-software' ); ?>
            </td>
         </tr>
		 <tr valign="top"  style="display:none">
            <th scope="row"><?php _e( 'Number of reminder mail.', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="regular-input " min="1" type="number" name="<?php echo $email_slug;?>[remind_to_pay_interval_number]" id="remind_to_pay_interval_number" style="width:140px;" value="<?php echo $remind_to_pay_interval_number?>"  placeholder="Enter in number">
               <br><?php _e( 'if sent numbers of mail stop mail to remind. default is 4', 'ultimate-auction-pro-software' ); ?>
            </td>
         </tr>
		<?php
	}

	function get_email_enable_disable_field( $email_slug ) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$enable = isset($template_details['enable']) ? $template_details['enable'] : "";
		$checked = "";
		if($enable == "yes"){
			$checked = "checked";
		}
		?>
		<tr valign="top">
            <th scope="row"><?php _e( 'Enable/Disable', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="checkbox" name="<?php echo $email_slug;?>[enable]" id="enable"
			   style="" value="1" <?php echo $checked;?> placeholder="">
              <?php _e( 'Enable this email notification.', 'ultimate-auction-pro-software' ); ?>
            </td>
         </tr>
		<?php
	}
	function get_email_admin_enable_disable_field( $email_slug ) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$enable = $template_details['admin_enable'];
		$checked = "";
		if($enable == "yes"){
			$checked = "checked";
		}
		$desc = "Send bid email notification to admin when Bidder places a bid.";
		if($email_slug =="won_bid"){
			$desc = "Send won email notification to admin when Bidder won auction.";
		}
		if($email_slug =="registration_confirm"){
			$desc = "Send registration confirmation email notification to admin when user register on site.";
		}
		if($email_slug =="uat_submited_mail"){
			$desc = "Send email notification to admin when seller submit new product on site.";
		}
		?>
		<tr valign="top">
			<th scope="row"><?php _e( 'Enable for Admin', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="checkbox" name="<?php echo $email_slug;?>[admin_enable]" id="admin_enable"
			   style="" value="1" <?php echo $checked;?> placeholder="">
                <?php echo $desc;?>
            </td>
         </tr>
		<?php
	}

	function get_admin_email_subject_field( $email_slug,$subject_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$subject =  isset($template_details['subject_admin']) ? $template_details['subject_admin'] : _e( "Admin Email Subject", 'ultimate-auction-pro-software' );
		?>

		 <tr valign="top">
            <th scope="row"><?php _e( 'Admin Email Subject', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="text" name="<?php echo $email_slug;?>[subject_admin]" id="uat_email_subject" style="min-width:850px;" value="<?php echo $subject?>"  placeholder="Enter the email subject">
			   <br>
				<?php
				$subject_hint = str_replace('<', '&lt;', $subject_hint);
				$subject_hint = str_replace('>', '&gt;', $subject_hint);
				$subject_hint = str_replace('\n', '</br>', $subject_hint);
				echo '<div class="uat-email-subject-hint">' . $subject_hint . '</div>';
				?>
            </td>
         </tr>
		<?php
	}

	/* Seller Email Subject */ 
	
	function get_email_seller_admin_enable_disable_field( $email_slug ) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$enable = $template_details['seller_enable'];
		$checked = "";
		if($enable == "yes"){
			$checked = "checked";
		}
		$desc = "Send bid email notification to admin when Bidder places a bid.";
		if($email_slug =="won_bid"){
			$desc = "Send won email notification to seller when Bidder won auction.";
		}
		?>
		<tr valign="top">
			<th scope="row"><?php _e( 'Enable for Seller', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="checkbox" name="<?php echo $email_slug;?>[seller_enable]" id="seller_enable"
			   style="" value="1" <?php echo $checked;?> placeholder="">
                <?php echo $desc;?>
            </td>
         </tr>
		<?php
	}
	
	function get_seller_admin_email_subject_field( $email_slug,$subject_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$subject =  isset($template_details['subject_seller_admin']) ? $template_details['subject_seller_admin'] : _e( "Seller Email Subject", 'ultimate-auction-pro-software' );
		?>

		 <tr valign="top">
            <th scope="row"><?php _e( 'Seller Email Subject', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="text" name="<?php echo $email_slug;?>[subject_seller_admin]" id="uat_email_subject" style="min-width:850px;" value="<?php echo $subject?>"  placeholder="Enter the email subject">
			   <br>
				<?php
				$subject_hint = str_replace('<', '&lt;', $subject_hint);
				$subject_hint = str_replace('>', '&gt;', $subject_hint);
				$subject_hint = str_replace('\n', '</br>', $subject_hint);
				echo '<div class="uat-email-subject-hint">' . $subject_hint . '</div>';
				?>
            </td>
         </tr>
		<?php
	}

	function get_seller_admin_email_body_field( $email_slug,$body_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$body =  isset($template_details['body_admin_seller']) ? $template_details['body_admin_seller'] : "";
	    $name = $email_slug."[body_admin_seller]";
		?>
		 <tr valign="top">
            <th scope="row"><?php _e( 'Seller Email Body', 'ultimate-auction-pro-software' ); ?></th>
            <td>
			<?php
			wp_editor($body, "body_admin_seller", array('media_buttons' => false, 'textarea_name' => $name, 'textarea_rows' => 10));
			$body_hint = str_replace('<', '&lt;', $body_hint);
			$body_hint = str_replace('>', '&gt;', $body_hint);
			$body_hint = str_replace('\n', '</br>', $body_hint);
			echo '<div class="uat-email-body-hint">' . $body_hint . '</div>';
			?>

            </td>
         </tr>
		<?php
	}

	function get_email_subject_field( $email_slug,$subject_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$subject =  isset($template_details['subject']) ? $template_details['subject'] : _e( "Email Subject", 'ultimate-auction-pro-software' );
		?>
		 <tr valign="top">
            <th scope="row"><?php _e( 'Email Subject', 'ultimate-auction-pro-software' ); ?></th>
            <td>
               <input class="input-text regular-input " type="text" name="<?php echo $email_slug;?>[subject]" id="uat_email_subject" style="min-width:850px;" value="<?php echo $subject?>"  placeholder="Enter the email subject">
               <br>
				<?php
				$subject_hint = str_replace('<', '&lt;', $subject_hint);
				$subject_hint = str_replace('>', '&gt;', $subject_hint);
				$subject_hint = str_replace('\n', '</br>', $subject_hint);
				echo '<div class="uat-email-subject-hint">' . $subject_hint . '</div>';
				?>
            </td>
         </tr>
		<?php
	}

	function get_admin_email_body_field( $email_slug,$body_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$body =  isset($template_details['body_admin']) ? $template_details['body_admin'] : "";
	    $name = $email_slug."[body_admin]";
		?>
		 <tr valign="top">
            <th scope="row"><?php _e( 'Admin Email Body', 'ultimate-auction-pro-software' ); ?></th>
            <td>
			<?php
			wp_editor($body, "body_admin", array('media_buttons' => false, 'textarea_name' => $name, 'textarea_rows' => 10));
			$body_hint = str_replace('<', '&lt;', $body_hint);
			$body_hint = str_replace('>', '&gt;', $body_hint);
			$body_hint = str_replace('\n', '</br>', $body_hint);
			echo '<div class="uat-email-body-hint">' . $body_hint . '</div>';
			?>

            </td>
         </tr>
		<?php
	}

	function get_email_body_field( $email_slug,$body_hint) {
		$template_details = get_email_temaplte_from_db($email_slug);
		$body =  isset($template_details['body']) ? $template_details['body'] : "";
	    $name = $email_slug."[body]";
		?>
		 <tr valign="top">
            <th scope="row"><?php _e( 'Email Body', 'ultimate-auction-pro-software' ); ?></th>
            <td>
			<?php
			wp_editor($body, "body", array('media_buttons' => false, 'textarea_name' => $name, 'textarea_rows' => 10));
			$body_hint = str_replace('<', '&lt;', $body_hint);
			$body_hint = str_replace('>', '&gt;', $body_hint);
			$body_hint = str_replace('\n', '</br>', $body_hint);
			echo '<div class="uat-email-body-hint">' . $body_hint . '</div>';
			?>

            </td>
         </tr>
		<?php
	}

	function get_email_save_nonce_field( $email_slug) {
		echo '<input type = "hidden" name="'.$email_slug.'[uat_email_hidden_field]">';
	     wp_nonce_field('uat_email_form_nonce', 'uat_email_form_nonce_field');

		submit_button(__("Save Changes", 'ultimate-auction-pro-software'));

	}

function uat_get_wp_editor_field2($title, $desc, $content, $id, $name) {
	?>
    <tr valign="top">
        <th scope="row"><?php echo $title;?></th>
        <td>
            <?php
wp_editor($content, $id, array('media_buttons' => false, 'textarea_name' => $name, 'textarea_rows' => 10));
	$desc = str_replace('<', '&lt;', $desc);
	$desc = str_replace('>', '&gt;', $desc);
	$desc = str_replace('\n', '</br>', $desc);
	echo '<div class="uat-email-body-hint">' . $desc . '</div>';
	?>
        </td>
    </tr>
    <?php
}







function uat_email_form_data_save() {

	if (isset($_POST['uat_email_form_nonce_field']) && wp_verify_nonce($_POST['uat_email_form_nonce_field'], 'uat_email_form_nonce')) {

		if (is_array($_POST)) {
			foreach ($_POST as $email_type => $email_form_data) {
				if (is_array($email_form_data)) {
					if (isset($email_form_data['uat_email_hidden_field'])) {
						//echo"<pre>";print_r($email_form_data);echo"</pre>";
						$email_template_details = array(
							'template' => (isset($email_form_data["template"]) ? $email_form_data["template"] : ""),
							'enable' => (isset($email_form_data["enable"]) ? "yes" : "no"),
							'subject' => (isset($email_form_data["subject"]) ? stripslashes($email_form_data["subject"]) : ""),
							'subject_admin' => (isset($email_form_data["subject_admin"]) ? stripslashes($email_form_data["subject_admin"]) : ""),
							'subject_seller_admin' => (isset($email_form_data["subject_seller_admin"]) ? stripslashes($email_form_data["subject_seller_admin"]) : ""),
							'body' => (isset($email_form_data["body"]) ? wpautop($email_form_data["body"]) : ""),
							'body_admin' => (isset($email_form_data["body_admin"]) ? wpautop($email_form_data["body_admin"]) : ""),
							'body_admin_seller' => (isset($email_form_data["body_admin_seller"]) ? wpautop($email_form_data["body_admin_seller"]) : ""),
							'footer_txt' => (isset($email_form_data["footer_txt"]) ? stripslashes($email_form_data["footer_txt"]) : ""),
							'base_color' => (isset($email_form_data["base_color"]) ? stripslashes($email_form_data["base_color"]) : ""),
							'bg_color' => (isset($email_form_data["bg_color"]) ? stripslashes($email_form_data["bg_color"]) : ""),
							'body_bg_color' => (isset($email_form_data["body_bg_color"]) ? stripslashes($email_form_data["body_bg_color"]) : ""),
							'body_text_color' => (isset($email_form_data["body_text_color"]) ? stripslashes($email_form_data["body_text_color"]) : ""),
							'admin_enable' => (isset($email_form_data["admin_enable"]) ? "yes" : "no"),
							'seller_enable' => (isset($email_form_data["seller_enable"]) ? "yes" : "no"),
							'remind_to_pay_interval' => (isset($email_form_data["remind_to_pay_interval"]) ? $email_form_data["remind_to_pay_interval"]: "5"),
							'remind_to_pay_interval_number' => (isset($email_form_data["remind_to_pay_interval_number"]) ? $email_form_data["remind_to_pay_interval_number"] : "4"),
						);

						$email_template_details = apply_filters("uat_email_template_details_save", $email_template_details, $email_form_data, $email_type);
						update_option("uat_email_template_" . $email_type, $email_template_details);						
					}
				}
			}
		}
	}
}
	function get_email_header_image() {
		$email_setting = get_option('uat_email_template_email_setting');
		$h_image = isset($email_setting['h_image']) ? $email_setting['h_image'] : "";
		return $h_image;
	}


	function get_email_subject( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_subject = isset($email_object['subject']) ? $email_object['subject'] : "";
		return $email_subject;
	}

	function get_admin_email_subject( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_subject = isset($email_object['subject_admin']) ? $email_object['subject_admin'] : "";
		return $email_subject;
	}

	function get_seller_email_subject( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_subject = isset($email_object['subject_seller_admin']) ? $email_object['subject_seller_admin'] : "";
		return $email_subject;
	}

	function get_admin_email_body( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_body = isset($email_object['body_admin']) ? $email_object['body_admin'] : "";
		return $email_body;
	}

	function get_admin_seller_email_body( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_body = isset($email_object['body_admin_seller']) ? $email_object['body_admin_seller'] : "";
		return $email_body;
	}

	function get_email_body( $email_slug ) {
		$email_object = get_email_temaplte_from_db( $email_slug );
		$email_body = isset($email_object['body']) ? $email_object['body'] : "";
		return $email_body;
	}



		function uat_get_text_field($uat_field, $title, $desc, $id, $type, $css, $default, $placeholder, $value, $class) {
	?>
    <tr valign="top">
        <th scope="row"><?php echo $title;?></th>
        <td>
            <input class="input-text regular-input <?php echo esc_attr($class);?>" type="<?php echo esc_attr($type);?>" name="<?php echo esc_attr($uat_field);?>" id="<?php echo esc_attr($id);?>" style="<?php echo esc_attr($css);?>" value="<?php echo $value;?>" <?php echo ((($value == "yes")||(empty($value)))? 'checked="checked"' : "");?> placeholder="<?php echo esc_attr($placeholder);?>" />
            <?php echo (isset($desc) ? (($type != "checkbox") ? "<br>" : "") . $desc : "");?>
        </td>
    </tr>
    <?php
}

function uat_get_radio_field($uat_field, $title, $desc, $id, $type, $css, $default, $options, $set_val, $class) {
	?>
    <tr valign="top">
        <th scope="row"><?php echo $title;?></th>
        <td>
            <?php
$default = (!empty($set_val) ? $set_val : $default);
	$i_count = 0;
	foreach ($options as $value => $display_name) {
		?>
            <input class="input-text regular-input <?php echo esc_attr($class);?>" type="<?php echo esc_attr($type);?>" name="<?php echo esc_attr($uat_field);?>" id="<?php echo esc_attr($id);?>" style="<?php echo esc_attr($css);?>" value="<?php echo $value;?>" <?php echo (($default == $value) ? 'checked="checked"' : "");?> /> <?php echo $display_name;?>
            <?php echo ($i_count == 0 ? "<br>" : "");
		$i_count++;
	}?>
            <?php echo (isset($desc) ? "<br>" . $desc : "");?>
        </td>
    </tr>
    <?php
}

function uat_get_wp_editor_field($title, $desc, $content, $id, $name) {
	?>
    <tr valign="top">
        <th scope="row"><?php echo $title;?></th>
        <td>
            <?php
wp_editor($content, $id, array('media_buttons' => false, 'textarea_name' => $name, 'textarea_rows' => 10));
	$desc = str_replace('<', '&lt;', $desc);
	$desc = str_replace('>', '&gt;', $desc);
	$desc = str_replace('\n', '</br>', $desc);
	echo '<div class="uat-email-body-hint">' . $desc . '</div>';
	?>
        </td>
    </tr>
    <?php
}

