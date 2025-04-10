<?php

/**
 * Auction Watchlist Button
 * 
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh 
 * @since 1.0  
 *
 */

if (!defined('ABSPATH')) {
	exit;
}

global $woocommerce, $product, $post;
if(!(method_exists( $product, 'get_type') && $product->get_type() == 'auction')){
	return;
}
$user_id = get_current_user_id();

$hide_desktop_class="";
$hide_desktop = get_option('options_uat_hide_saved_for_desktop',"off");
if($hide_desktop =="on") {
	$hide_desktop_class="saved-hide-on-desktop";
}
$hide_mobile_class="";
$hide_mobile = get_option('options_uat_hide_saved_for_mobile',"off");

if($hide_mobile =="on") {
	$hide_mobile_class="saved-hide-on-mobile";
}
$product_id = $product->get_id();
if (is_user_logged_in()) {
?>
<div class="like-product loop<?php echo $hide_desktop_class;?> <?php echo $hide_mobile_class;?>">
	<?php if ($product->is_uwa_user_watching()): ?>				
	<a href="javascript:void(0)"  data-auction-id="<?php echo esc_attr( $product_id ); ?>"	class="remove-uat uat-savedlist-action-loop" title="<?php _e('Click to save remove auction product', 'ultimate-auction-pro-software'); ?>">
		<i class="fas fa-heart"></i> <span class="prod-like-count"><?php echo getProductWatchingCount($product_id); ?></span>		
	</a>
	<?php else : ?>			
		<a href="javascript:void(0)" data-auction-id="<?php echo esc_attr( $product_id ); ?>" 
		class="add-uat uat-savedlist-action-loop" <?php if($user_id == 0) echo "no-action ";?>  title="<?php if($user_id == 0) echo 'Please sign in to add auction to save.';?>">
		<i class="far fa-heart"></i> <span class="prod-like-count"><?php echo getProductWatchingCount($product_id); ?></span>		
		</a>	
	<?php endif; ?>	
</div>
<?php } else { ?>
	<div class="like-product  <?php echo $hide_desktop_class;?> <?php echo $hide_mobile_class;?>">	
	<?php $menu_link_types = get_option('options_menu_link_types', 'menu_open_in_popup');
	if ($menu_link_types == 'menu_open_in_direct_link') {   ?>
	<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="uat uat-savedlist-action-loop" >
		<i class="far fa-heart"></i>		
	</a>
	<?php } else { ?>
	<a href="javascript:void(0)" data-fancybox data-src="#uat-login-form" class="uat-savedlist-action-loop">
		<i class="far fa-heart"></i><span class="prod-like-count"><?php echo getProductWatchingCount($product_id); ?></span>		
	</a>	
	<?php } ?>
	</div>
<?php }
