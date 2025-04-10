<?php
/**
 * Description tab
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/description.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 2.0.0
 */

defined( 'ABSPATH' ) || exit;

global $woocommerce, $product, $post;

$heading = apply_filters( 'ultimate_auction_theme_pro_auction_bid_increment_heading', __( 'Bid increments', 'ultimate-auction-pro-software' ) );

?>

<?php if ( $heading ) : ?>
	<h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>

<?php $uat_fixed_inc = $product->get_fixed_bid_increment();
     $uat_variable_inc_enable = $product->get_uwa_auction_variable_bid_increment();
	 if($uat_variable_inc_enable == 'yes' ) { ?>
<table style="width:360px;">
	<tr>
		<th><?php _e( "Price", 'ultimate-auction-pro-software' ); ?> </th>
		<th><?php _e( "Bid Increment", 'ultimate-auction-pro-software' ); ?></th>
	</tr>
    <?php $ua_inc_price_range = $product->get_uwa_var_inc_price_val();
	 if(!empty($ua_inc_price_range)){
		foreach($ua_inc_price_range as $range){ ?>
		<tr>
			<td>
			<?php
			if($range['end'] == 'onwards'){
				echo $range['start'] ." - ". $range['end'];
			}else {
				echo wc_price($range['start']) ." - ".wc_price($range['end']);
			} ?>
			</td>
			<td><?php echo wc_price($range['inc_val']);?></td>
		</tr>
			<?php } ?>		
		<?php } ?>		
</table>
<?php } else{ ?>
		<p><?php echo wc_price($product->get_fixed_bid_increment());?></p>
	<?php }
