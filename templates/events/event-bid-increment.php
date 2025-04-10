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

global $post;
$heading = apply_filters( 'ultimate_auction_theme_pro_event_bid_increment_heading', __( 'Bid increments', 'ultimate-auction-pro-software' ) );
$event_id = $post->ID;
?>
<?php if ( $heading ) : ?>
	<h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>

<?php $uat_inc_type = get_post_meta($event_id, 'uat_set_bid_incremental_type', true); ?>
	<?php if($uat_inc_type == 'var_inc' ) {
		$uwa_auction_variable_bid_increment_type_event =  get_post_meta( $event_id, 'uwa_auction_variable_bid_increment_type_event', true );
		if($uwa_auction_variable_bid_increment_type_event == "global"){
			$event_global_bid_inc_variable = get_uwa_var_inc_price_global_event();
			?>
			<table style="width:360px;">
				<tr>
					<th><?php _e( "Price", 'ultimate-auction-pro-software' ); ?> </th>
					<th><?php _e( "Bid Increment", 'ultimate-auction-pro-software' ); ?></th>
				</tr>
				<?php
					if(!empty($event_global_bid_inc_variable)){
						foreach($event_global_bid_inc_variable as $range){ ?>
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
								<?php }
					}
				?>
			</table>
			<?php
		}else{
		?>
	<?php if ( have_rows( 'uat_var_incremental_price' ) ) : ?>
	<table style="width:360px;">
		<tr>
			<th><?php _e( "Price", 'ultimate-auction-pro-software' ); ?> </th>
			<th><?php _e( "Bid Increment", 'ultimate-auction-pro-software' ); ?></th>
		</tr>
		<?php while ( have_rows( 'uat_var_incremental_price' ) ) : the_row(); ?>
		<tr>
	    <td>
	    <?php
		if(get_sub_field( 'end' ) == 'onwards'){
			echo get_sub_field( 'end' );
		}else {
			echo wc_price(get_sub_field( 'end' ));
		}
		 ?>
		</td>
		<td><?php echo wc_price(get_sub_field( 'inc_val' ));?></td>
	</tr>

		<?php endwhile; ?>
	</table>
<?php endif; } ?>
<?php } else{ ?>
		<p><?php echo wc_price(get_post_meta($event_id, 'uat_flat_incremental_price', true));?></p>
	<?php }
