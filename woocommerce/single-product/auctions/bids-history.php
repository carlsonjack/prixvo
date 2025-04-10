<?php

/**
 * Auction history tab
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if (!defined('ABSPATH')) {
	exit;
}
global $woocommerce, $post, $product;
$datetimeformat = get_option('date_format') . ' ' . get_option('time_format');
$datetimeformat = get_option('date_format') . ' ' . get_option('time_format');
$heading = apply_filters('ultimate_woocommerce_auction_pro_total_bids_heading', __('Bid History', 'ultimate-auction-pro-software'));
?>
<h3><?php echo esc_html($heading); ?></h3>
<div class="bids_history_data" data-auction-id="<?php echo esc_attr($product->get_id()); ?>"> <!-- main container -->
	<table id="auction-history-table-<?php echo esc_attr($product->get_id()); ?>" class="auction-history-table">
		<?php
		$uwa_auction_log_history = $product->uwa_auction_log_history();
		?>
		<thead>
			<tr>
				<th><?php _e('Bidder Name', 'ultimate-auction-pro-software') ?></th>
				<th><?php _e('Time', 'ultimate-auction-pro-software') ?></th>
				<th><?php _e('Bid', 'ultimate-auction-pro-software') ?></th>
				<?php if ($product->get_uwa_auction_proxy()) { ?>
					<th><?php _e('Absentee Bid?', 'ultimate-auction-pro-software') ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody class="uaw-auction-bid-list" data-acution-id="<?php echo $product->get_id(); ?>">
			<?php
			if (!empty($uwa_auction_log_history)) :
				foreach ($uwa_auction_log_history as $history_value) {
			?>
					<tr>
						<?php
						$user_name = uat_user_display_name($history_value->userid);
						if ($product->get_uwa_auction_proxy() == "yes") {
							$user_name = uat_proxy_mask_user_display_name($history_value->userid);
						} elseif ($product->get_uwa_auction_silent() == "yes") {
							$user_name = uat_silent_mask_user_display_name($history_value->userid);
						}
						?>
						<td class="bid_username"><?php echo esc_attr($user_name); ?></td>
						<td class="bid_date">
							<?php 
									// echo mysql2date($datetimeformat, $history_value->date);
									echo custom_time_ago( $history_value->date ) 
									
									?></td>
						<?php
						if ($product->get_uwa_auction_proxy() == "yes") { ?>
							<td class="bid_price"><?php echo uat_proxy_mask_bid_amt($history_value->bid); ?></td>
						<?php
						} elseif ($product->get_uwa_auction_silent() == "yes") {
						?><td class="bid_price"><?php echo uat_silent_mask_bid_amt($history_value->bid); ?>
							</td>
						<?php
						} else { ?>
							<td class="bid_price"><?php echo wc_price($history_value->bid); ?></td>
							<?php }
						if ($product->get_uwa_auction_proxy()) {
							if ($history_value->proxy == 1) { ?>
								<td class="proxy"><?php _e('Is it a Proxy Bid?', 'ultimate-auction-pro-software'); ?></td>
							<?php } else { ?>
								<td class="proxy"></td>
						<?php   }
						} ?>
					</tr>
			<?php }
			endif; ?>
		</tbody>
		<?php //endif;
		?>

	</table>
</div>