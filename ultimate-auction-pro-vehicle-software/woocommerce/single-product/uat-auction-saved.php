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
?>
<?php 
if (is_user_logged_in()) { ?>
	<div class="like-product   <?php echo $hide_desktop_class;?> <?php echo $hide_mobile_class;?>">
		<?php if (get_post_meta( get_the_ID(), 'uat_auction_saved_id', true )): ?>				
			<a href="javascript:void(0)"  data-auction-id="<?php echo esc_attr( $product->get_id() ); ?>"	class="remove-uat uat-savedlist-action ghost_btn icon_btn saved-btn" title="<?php _e('Click to save remove auction product', 'ultimate-auction-pro-software'); ?>"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 14 18"><path id="Path_2" d="M17,3H7A2.006,2.006,0,0,0,5,5V21l7-3,7,3V5A2.006,2.006,0,0,0,17,3Z" transform="translate(-5 -3)" fill="#000000"/></svg><?php _e('Saved', 'ultimate-auction-pro-software'); ?></a>
		
		<?php else : ?>			
			<a href="javascript:void(0)" data-page-name="sing" data-auction-id="<?php echo esc_attr( $product->get_id() ); ?>" <?php if($user_id == 0) echo "no-action ";?>  title="<?php if($user_id == 0) echo 'Please sign in to add auction to save.';?>" class="add-uat uat-savedlist-action ghost_btn icon_btn saved-btn" ><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 30" style="enable-background:new 0 0 24 30;" xml:space="preserve"><g><g><g><path d="M23,30c-0.2,0-0.3,0-0.5-0.1L12,24.5L1.5,29.9c-0.3,0.2-0.7,0.1-1,0C0.2,29.7,0,29.3,0,29V4.2C0,1.9,1.9,0,4.2,0h15.6C22.1,0,24,1.9,24,4.2V29c0,0.3-0.2,0.7-0.5,0.9C23.4,30,23.2,30,23,30z M12,22.4c0.2,0,0.3,0,0.5,0.1l9.5,4.9V4.2C22,3,21,2,19.8,2H4.2C3,2,2,3,2,4.2v23.2l9.5-4.9C11.7,22.4,11.8,22.4,12,22.4z"/></g></g></g></svg><?php _e('Save', 'ultimate-auction-pro-software'); ?></a>
		<?php endif; ?>	
		<?php 
			$previous_count = get_post_meta( $product->get_id(), 'uat_auction_saved_count', true);
			$previous_count = $previous_count > 0 ? $previous_count  : 0;
		?>
		<div class="save_count save-img icon_btn" >
			<label class="ghost_btn"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 14 18"><path id="Path_2" d="M17,3H7A2.006,2.006,0,0,0,5,5V21l7-3,7,3V5A2.006,2.006,0,0,0,17,3Z" transform="translate(-5 -3)" fill="var(--wp--custom-primary-link-color)"/></svg><?php echo getProductWatchingCount($product_id); ?></label>
		</div>
	</div>
<?php }else{ ?>
	<div class="like-product  <?php echo $hide_desktop_class;?> <?php echo $hide_mobile_class;?>">	
		<?php $menu_link_types = get_option('options_menu_link_types', 'menu_open_in_popup');
		if ($menu_link_types == 'menu_open_in_direct_link') {   ?>
		<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" class="ghost_btn icon_btn saved-btn"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 30" style="enable-background:new 0 0 24 30;" xml:space="preserve"><g><g><g><path d="M23,30c-0.2,0-0.3,0-0.5-0.1L12,24.5L1.5,29.9c-0.3,0.2-0.7,0.1-1,0C0.2,29.7,0,29.3,0,29V4.2C0,1.9,1.9,0,4.2,0h15.6C22.1,0,24,1.9,24,4.2V29c0,0.3-0.2,0.7-0.5,0.9C23.4,30,23.2,30,23,30z M12,22.4c0.2,0,0.3,0,0.5,0.1l9.5,4.9V4.2C22,3,21,2,19.8,2H4.2C3,2,2,3,2,4.2v23.2l9.5-4.9C11.7,22.4,11.8,22.4,12,22.4z"/></g></g></g></svg><?php _e('Save', 'ultimate-auction-pro-software'); ?>	</a>
		<?php } else { ?>
		<a href="javascript:void(0)" data-fancybox class="ghost_btn icon_btn saved-btn" data-src="#uat-login-form"><svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 30" style="enable-background:new 0 0 24 30;" xml:space="preserve"><g><g><g><path d="M23,30c-0.2,0-0.3,0-0.5-0.1L12,24.5L1.5,29.9c-0.3,0.2-0.7,0.1-1,0C0.2,29.7,0,29.3,0,29V4.2C0,1.9,1.9,0,4.2,0h15.6C22.1,0,24,1.9,24,4.2V29c0,0.3-0.2,0.7-0.5,0.9C23.4,30,23.2,30,23,30z M12,22.4c0.2,0,0.3,0,0.5,0.1l9.5,4.9V4.2C22,3,21,2,19.8,2H4.2C3,2,2,3,2,4.2v23.2l9.5-4.9C11.7,22.4,11.8,22.4,12,22.4z"/></g></g></g></svg><?php _e('Save', 'ultimate-auction-pro-software'); ?></a>	
		<?php } ?>
		<div class="save_count save-img icon_btn" >
			<label class="ghost_btn"><svg fill="#000000" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 14 18"><path id="Path_2" d="M17,3H7A2.006,2.006,0,0,0,5,5V21l7-3,7,3V5A2.006,2.006,0,0,0,17,3Z" transform="translate(-5 -3)" fill="var(--wp--custom-primary-link-color)"/></svg><?php echo getProductWatchingCount($product_id); ?></label>
		</div>
	</div>
<?php } ?>





