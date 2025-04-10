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
global $product;
$get_auction_subtitle='';
if ($product->get_type() == 'auction') {
	$get_auction_subtitle=$product->get_auction_subtitle();
}
?>

<div class="product-details-desc">
	<div class="title_area">
		<h1 class="peoduct-name"><?php the_title();?></h1>
		<?php if(!empty($get_auction_subtitle)){ ?>
		<h3 class="peoduct-sub-details"><?php echo $get_auction_subtitle; ?></h3>
		<?php } ?>
	</div> 
</div>
	
	