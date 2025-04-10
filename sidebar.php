<?php

/**
 * Theme functions and definitions
 *
 * @package WordPress
 * @subpackage Defaulut Theme
 * @author Defaulut Theme, Inc.
 *
 */
?>

<?php if ( is_active_sidebar( 'uat-theme-sidebar' ) ) : ?>
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'uat-theme-sidebar' ); ?>
		</div><!-- #secondary -->
	<?php endif; ?>
