<?php
/**
 *  Traditional Email Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
$email_slug = $args['email_slug'];
$h_image = get_email_header_image();
$footer_txt = isset($args['footer_txt']) ? $args['footer_txt'] :"";
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
						<div id="uat_template_header_image">
						<?php
							if ( $h_image ) {
								echo '<p style="margin-top:0;"><img src="' . esc_url( $h_image ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; max-width: 100%; margin-left: 0; margin-right: 0;"/></p>';
							}
							?>
							
						</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: <?php echo $body_bg_color;?>; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
							<tbody><tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style="background-color: <?php  echo $base_color; ?>; color: #000; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;">
										<tbody><tr>
											<td id="header_wrapper" style="padding: 36px 48px; display: block;">
												<h1 style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; color: #000; background-color: inherit;"><?php echo get_email_subject( $email_slug ); ?></h1>
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
															<div id="body_content_inner" style="color:<?php echo $body_text_color;?>; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">

																<p style="margin: 0 0 16px;"><?php echo get_email_body( $email_slug ); ?></p>
															
															</div>
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
				<tr>
					<td align="center" valign="top">
						
						<table border="0" cellpadding="10" cellspacing="0" width="600" id="uat_template_footer">
							<tr>
								<td valign="top">
									<table border="0" cellpadding="10" cellspacing="0" width="100%">
										<tr>
										<td colspan="2" valign="middle" id="credit" style="border-radius: 6px; border: 0; color: #8a8a8a; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 12px; line-height: 150%; text-align: center; padding: 24px 0;">
											<p style="margin: 0 0 16px;"><?php echo $footer_txt; ?></p>	
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
															