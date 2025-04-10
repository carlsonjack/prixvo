<?php
/**
 * Email Header
 * 
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$uat_mail_h_image = get_option('uat_mail_h_image');
$uat_mail_base_color = get_option('uat_mail_base_color',"#96588a");
$uat_mail_bg_color = get_option('uat_mail_bg_color',"#f7f7f7");
$uat_mail_body_main_color = get_option('uat_mail_body_main_color',"#ffffff");
$uat_mail_body_text_color = get_option('uat_mail_body_text_color',"#636363");
$email_heading = $args['email_heading'];
$email_body = $args['email_body'];
$email_subject = $args['email_subject'];
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="padding: 0;">
		<div id="wrapper" dir="ltr" style="background-color: <?php echo $uat_mail_bg_color;?>; margin: 0; padding: 70px 0; width: 100%; -webkit-text-size-adjust: none;">
		<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
				<tbody><tr>
					<td align="center" valign="top">
						<div id="uat_template_header_image">
						<?php
							if ( $uat_mail_h_image ) {
								echo '<p style="margin-top:0;"><img src="' . esc_url( $uat_mail_h_image ) . '" alt="' . get_bloginfo( 'name', 'display' ) . '" style="border: none; display: inline-block; font-size: 14px; font-weight: bold; height: auto; outline: none; text-decoration: none; text-transform: capitalize; vertical-align: middle; max-width: 100%; margin-left: 0; margin-right: 0;"/></p>';
							}
							?>
							
						</div>
						<table border="0" cellpadding="0" cellspacing="0" width="600" id="template_container" style="background-color: <?php echo $uat_mail_body_main_color;?>; border: 1px solid #dedede; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); border-radius: 3px;">
							<tbody><tr>
								<td align="center" valign="top">
									<!-- Header -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%" id="template_header" style="background-color: <?php  echo $uat_mail_base_color; ?>; color: #ffffff; border-bottom: 0; font-weight: bold; line-height: 100%; vertical-align: middle; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; border-radius: 3px 3px 0 0;">
										<tbody><tr>
											<td id="header_wrapper" style="padding: 36px 48px; display: block;">
												<h1 style="font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 30px; font-weight: 300; line-height: 150%; margin: 0; text-align: left; text-shadow: 0 1px 0 #ab79a1; color: #ffffff; background-color: inherit;"><?php echo $email_heading; ?></h1>
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
											<td valign="top" id="body_content" style="background-color: <?php echo $uat_mail_body_main_color;?>;">
												<!-- Content -->
												<table border="0" cellpadding="20" cellspacing="0" width="100%">
													<tbody><tr>
														<td valign="top" style="padding: 48px 48px 32px;">
															<div id="body_content_inner" style="color:<?php echo $uat_mail_body_text_color;?>; font-family: &quot;Helvetica Neue&quot;, Helvetica, Roboto, Arial, sans-serif; font-size: 14px; line-height: 150%; text-align: left;">
			
