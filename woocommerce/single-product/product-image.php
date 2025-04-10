<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.5.2
 */
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$thumb_image_id = $product->get_image_id();
?>
<div class="swiper-container-wrapper">
			<?php if ( $attachment_ids  ) { ?>


				<div class="gallery">
					<div class="swiper-container gallery-slider">
						<div class="swiper-wrapper">
						<?php
						array_unshift($attachment_ids,$thumb_image_id);
						foreach ( $attachment_ids as $attachment_id ) {
							$thumb_url = wp_get_attachment_image_src($attachment_id,"full");
							$thumb_image = $thumb_url[0];
							if(!empty($thumb_image)){ ?>
							<div class="swiper-slide">
							<a data-fancybox="images" title="click to zoom-in" href="<?php echo esc_url($thumb_image);?>" itemprop="contentUrl">
								<img src="<?php echo esc_url($thumb_image);?>" alt="">
							</a>
							</div>
							<?php  } } ?>

						</div>
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>

					<div class="swiper-container gallery-thumbs">
						<div class="swiper-wrapper">

							<?php
								//array_unshift($attachment_ids,$thumb_image_id);
								foreach ( $attachment_ids as $attachment_id ) {
									$thumb_url = wp_get_attachment_image_src($attachment_id,"product-slider-thumb");
									$thumb_image = $thumb_url[0];
								if(!empty($thumb_image)){ ?>
							<div class="swiper-slide">
								<img src="<?php echo esc_url($thumb_image);?>" alt="">
							</div>
							<?php  } } ?>

						</div>
					</div>
				</div>


				<div class="slider-footer">
						<?php wc_get_template('single-product/uat-auction-saved.php'); ?>
						<?php wc_get_template('single-product/share.php'); ?>
						</div>
			 <?php } else {
					$thumb_url = wp_get_attachment_image_src($product->get_image_id(),'product-single-one');
					$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/product_single_one_default.png';
					$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
					$thumb_url_full = wp_get_attachment_image_src($product->get_image_id(),'full');					
					$thumb_image_full = isset($thumb_url_full[0]) ? $thumb_url_full[0] : $thumb_image_d;
					 ?>
				<div class="swiper-container">
					<div class="uat-single-product-no-gallery">
						<a data-fancybox="images" title="click to zoom-in" href="<?php echo esc_url($thumb_image_full);?>" itemprop="contentUrl">
								<img src="<?php echo esc_url($thumb_image);?>" alt="">
							</a>
					</div>
				<div class="slider-footer">
				<?php wc_get_template('single-product/uat-auction-saved.php'); ?>
				<?php wc_get_template('single-product/share.php'); ?>
				</div>
				</div>
			<?php } ?>
 <!-- Slider main container -->
<!-- partial -->
</div>
