<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/share.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */
if (!defined('ABSPATH'))
{
    exit; // Exit if accessed directly.
}
global $woocommerce, $product, $post;
if (!(method_exists($product, 'get_type') && $product->get_type() == 'auction'))
{
    // return;
}
$media = "";
$image_id = $product->get_image_id();
$image_array = wp_get_attachment_image_src($image_id, "full");
$media = isset($image_array[0]) ? $image_array[0] : "";

$share_button = get_option('options_uat_auction_share_button',"on");
if($share_button =="on") {
?>
 <div class="share-icon">
					<svg height="21px" width="21px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 481.60 481.60" xml:space="preserve" stroke="#000000" stroke-width="10.595200000000002"><g id="SVGRepo_iconCarrier"> <g> <path d="M381.6,309.4c-27.7,0-52.4,13.2-68.2,33.6l-132.3-73.9c3.1-8.9,4.8-18.5,4.8-28.4c0-10-1.7-19.5-4.9-28.5l132.2-73.8 c15.7,20.5,40.5,33.8,68.3,33.8c47.4,0,86.1-38.6,86.1-86.1S429,0,381.5,0s-86.1,38.6-86.1,86.1c0,10,1.7,19.6,4.9,28.5 l-132.1,73.8c-15.7-20.6-40.5-33.8-68.3-33.8c-47.4,0-86.1,38.6-86.1,86.1s38.7,86.1,86.2,86.1c27.8,0,52.6-13.3,68.4-33.9 l132.2,73.9c-3.2,9-5,18.7-5,28.7c0,47.4,38.6,86.1,86.1,86.1s86.1-38.6,86.1-86.1S429.1,309.4,381.6,309.4z M381.6,27.1 c32.6,0,59.1,26.5,59.1,59.1s-26.5,59.1-59.1,59.1s-59.1-26.5-59.1-59.1S349.1,27.1,381.6,27.1z M100,299.8 c-32.6,0-59.1-26.5-59.1-59.1s26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1S132.5,299.8,100,299.8z M381.6,454.5 c-32.6,0-59.1-26.5-59.1-59.1c0-32.6,26.5-59.1,59.1-59.1s59.1,26.5,59.1,59.1C440.7,428,414.2,454.5,381.6,454.5z"></path> </g> </g></svg>
				</div>

				<div id="share-icon-list" style="display:none;">
               <a class="share-facebook" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url(get_permalink( $product->get_id() )); ?>&amp;src=sdkpreparse" " target="_blank"><i class="fab fa-facebook-square"></i><span><?php _e( 'Facebook', 'ultimate-auction-pro-software' ); ?></span></a>

               <a class="share-twitter" href="https://twitter.com/intent/tweet?text=<?php echo esc_attr($product->get_name()); ?>&amp;url=<?php echo esc_url(get_permalink( $product->get_id() )); ?>&amp;via=UltimateAuctionThemePro" target="_blank">
               <i class="fas fa-times"></i><span><?php _e( 'Twitter', 'ultimate-auction-pro-software' ); ?></span></a>

               <a href="mailto:?subject=<?php echo esc_attr($product->get_name()); ?>&amp;body=<?php echo esc_url(get_permalink( $product->get_id() )); ?>"><i class="fas fa-envelope-square"></i><span><?php _e( 'Mail', 'ultimate-auction-pro-software' ); ?></span></a>

               <a class="share-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo esc_url(get_permalink( $product->get_id() )); ?>&amp;media=<?php echo $media; ?>&amp;description=<?php echo esc_attr($product->get_name()); ?>" target="_blank">
               <i class="fab fa-pinterest-square"></i><span><?php _e( 'pinterest', 'ultimate-auction-pro-software' ); ?></span></a>

               <a href="http://www.tumblr.com/share/link?url=<?php echo esc_url(get_permalink( $product->get_id() )); ?>" target="blank_"><i class="fab fa-tumblr-square"></i><span><?php _e( 'Tumblr', 'ultimate-auction-pro-software' ); ?></span></a>

				</div> 

<?php } ?>