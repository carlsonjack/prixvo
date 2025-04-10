<?php
/**
 *  Plain Text email Template
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
$email_slug = $args['email_slug'];
$h_image = get_email_header_image();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>" />
		<title><?php echo get_bloginfo( 'name', 'display' ); ?></title>
	</head>
	<body>
		<div>
		<?php echo wp_strip_all_tags(get_email_body( $email_slug )); ?>
		</div>
	</body>
</html>														
															