<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>

	<div class="bid-inf-box">
		<div class="next-prev-navigation">
		<?php $back_img = UAT_THEME_PRO_IMAGE_URI.'front/left-side.png';?>
			<div class="prev-lot">
				<?php previous_post_link( '%link',  '<img src='.$back_img.'>', TRUE, ' ', 'product_cat' ); ?>					
			</div>	
			<?php $next_img = UAT_THEME_PRO_IMAGE_URI.'front/right-side.png';?>				
			<div class="next-lot">
				<?php next_post_link( '%link', '<img src='.$next_img.'>', TRUE, ' ', 'product_cat' ); ?>					
			</div>
		</div>
		<div class="product-name-detail">
			<h1><?php the_title();?></h1>
		</div> 
	