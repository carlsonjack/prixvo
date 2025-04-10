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

$heading = apply_filters( 'woocommerce_product_term_condition_heading', __( 'Terms & Conditions', 'ultimate-auction-pro-software' ) );

?>

<?php if ( $heading ) : ?>
	<h3><?php echo esc_html( $heading ); ?></h3>
<?php endif; ?>


<?php 
$terms_conditions ="";
$uat_event_id = get_post_meta($post->ID, 'uat_event_id', true);

if($uat_event_id){
	$terms_conditions = get_post_meta($uat_event_id, 'uat_terms_condition', true);
} else {
	$terms_conditions = get_post_meta($post->ID, '_uat_terms_conditions', true);
}
	if ( $terms_conditions ) :
		echo wpautop($terms_conditions);
    endif;
?>
