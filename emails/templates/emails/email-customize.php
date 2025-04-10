<?php
/**
 * Customize Email Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
$email_slug = $args['email_slug'];
$user_type = isset($args['user_type'])?$args['user_type']:"";
$footer_txt = $args['footer_txt'];
$base_color = $args['base_color'];
$bg_color = $args['bg_color'];
$body_bg_color = $args['body_bg_color'];
$body_text_color = $args['body_text_color'];
$h_image = get_email_header_image();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="padding: 0;">
		<div id="wrapper" dir="ltr" style="background-color: <?php echo $bg_color;?>; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tbody><tr>
					<td align="center" valign="top">
						 
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: <?php echo $body_bg_color;?>; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
							<tbody><tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style="color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;">
										<tbody><tr>
											<td id="header_wrapper" style="padding: 36px 48px; display: block;">
                                            <div id="uat_template_header_image">
						<?php
							if ( $h_image ) {
								echo '<p style="margin-top:0;"><img src="' . esc_url( $h_image ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '"style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; max-width: 100%; margin: 0 auto; text-align: center;display: block;" ></p>';
							}
							?>
							
						</div>
                                            <h1 style="font-family: 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif; font-size: 20px; font-weight: 300; line-height: 150%; margin: 0; text-align: center; text-shadow: none; color: #000; background-color: inherit;"> 
	
												<?php
													if(!empty($user_type) && $user_type=='admin'){
															echo get_admin_email_subject( $email_slug );
													}else if(!empty($user_type) && $user_type=='seller'){
															echo get_seller_email_subject( $email_slug );
													}
													else{
														echo get_email_subject( $email_slug );
													} 
												?>	

												
											
											</h1>
											</td>
										</tr>
									</tbody></table>
									<!-- End Header -->
								</td>
							</tr>
							<tr>
								<td align="center" valign="top">
									<!-- Body -->
									<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_body">
										<tbody><tr>
											<td valign="top" id="body_content" style="background-color: <?php echo $body_bg_color;?>;">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tbody><tr>
														<td valign="top" style="padding: 48px 48px 32px;">
															<div id="body_content_inner" style="color:<?php echo $body_text_color;?>; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: center;">

																<p style="margin: 0 0 16px;">

																<?php
																if(!empty($user_type) && $user_type=='admin'){
																	echo get_admin_email_body( $email_slug );
																	
																}else if(!empty($user_type) && $user_type=='seller'){
																	echo get_admin_seller_email_body( $email_slug );
																}
																else{
																	echo get_email_body( $email_slug );
																}

																?>	
															</p>
															
															</div>
														</td>
													</tr>
												</table>
												
											</td>
										</tr>
									</table>
									
								</td>
							</tr>
<tr><td align="center" valign="top">
						
						<table border="0" cellpadding="10" cellspacing="0" width="600" id="uat_template_footer">
							<tr>
								<td valign="top">
									<table border="0" cellpadding="10" cellspacing="0" width="100%">
										<tr>
										<td colspan="2" valign="middle" id="credit" style="border-radius: 6px; border: 0;font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: center; padding: 24px 0;">
											<hr style="margin-bottom: 30px;width: 70%;">
											<p style="margin: 0 0 16px;">Copyright (C) 2024 PRIXVO L.L.C-FZ. All rights reserved.</p>	
											<p style="margin: 0 0 16px;">Our mailing address is:</p>	
											<p style="margin: 0 0 16px;">PRIXVO L.L.C-FZ</p>	
											<p style="margin: 0 0 16px;">FI 6, Meydan Road</p>	
											<p style="margin: 0 0 16px;">Grandstand, Abu Hail</p>	
											<p style="margin: 0 0 16px;">Grandstand, Abu Hail, Dubai United Arab Emirates</p>	
										</td>										
										</tr>
									</table>
								</td>
							</tr>
						</table>
						
					</td>
							</tr>
						</table>
					</td>
				</tr>
			
			</table>
		</div>
	</body>
</html>