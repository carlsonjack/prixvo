<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly 
?>
<?php
$has_seller = false;
$seller_id = '';
$is_receipt = false;
if (isset($_REQUEST['seller'])) {
	$has_seller = true;
	$seller_id = $_REQUEST['seller'];
	if (isset($_REQUEST['seller_receipt'])) {
		$is_receipt = true;
	}
}
?>
<?php do_action('wpo_wcpdf_before_document', $this->get_type(), $this->order); ?>

<table class="head container">
	<tr>
		<td class="header">
			<?php
			if ($this->has_header_logo()) {
				do_action('wpo_wcpdf_before_shop_logo', $this->get_type(), $this->order);
				$this->header_logo();
				do_action('wpo_wcpdf_after_shop_logo', $this->get_type(), $this->order);
			} else {
				$this->title();
			}
			?>
		</td>
		<td class="shop-info">
			<?php do_action('wpo_wcpdf_before_shop_name', $this->get_type(), $this->order); ?>
			<div class="shop-name">
				<h3><?php $this->shop_name(); ?></h3>
			</div>
			<?php do_action('wpo_wcpdf_after_shop_name', $this->get_type(), $this->order); ?>
			<?php do_action('wpo_wcpdf_before_shop_address', $this->get_type(), $this->order); ?>
			<div class="shop-address"><?php $this->shop_address(); ?></div>
			<?php do_action('wpo_wcpdf_after_shop_address', $this->get_type(), $this->order); ?>
		</td>
	</tr>
</table>

<?php do_action('wpo_wcpdf_before_document_label', $this->get_type(), $this->order); ?>

<h1 class="document-type-label">
	<?php
	if (!empty($seller_id)) {
		echo __('Commission invoice', 'ultimate-auction-pro-software');
	} else {

		if ($this->has_header_logo()) $this->title();
	}

	?>
</h1>

<?php do_action('wpo_wcpdf_after_document_label', $this->get_type(), $this->order); ?>

<table class="order-data-addresses">
	<tr>
		
		<td class="address shipping-address">
			<?php _e('Full name:', 'ultimate-auction-pro-software'); ?>
			<?php echo 	$author_name = get_the_author_meta('display_name', $seller_id); ?>
		</td>
		<td class="address billing-address">

		</td>
		<td class="order-data">
			<table>
				<?php do_action('wpo_wcpdf_before_order_data', $this->get_type(), $this->order); ?>
				<tr class="order-number">
					<th><?php _e('Order Number:', 'woocommerce-pdf-invoices-packing-slips'); ?></th>
					<td><?php $this->order_number(); ?></td>
				</tr>
				<tr class="order-date">
					<th><?php _e('Order Date:', 'woocommerce-pdf-invoices-packing-slips'); ?></th>
					<td><?php $this->order_date(); ?></td>
				</tr>
				<?php
				if ($has_seller && !empty($seller_id)) {
					$seller_payment_method = get_seller_payment_method($seller_id);
					if (!empty($seller_payment_method)) {
						$payment_method = $seller_payment_method['title'];
				?>
						<tr class="payment-method">
							<th><?php _e('Seller Payment Method:', 'ultimate-auction-pro-software'); ?></th>
							<td><?php echo $payment_method; ?></td>
						</tr>
				<?php
					}
				}
				?>
				<?php do_action('wpo_wcpdf_after_order_data', $this->get_type(), $this->order); ?>
			</table>
		</td>
	</tr>
</table>

<?php do_action('wpo_wcpdf_before_order_details', $this->get_type(), $this->order); ?>

<table class="order-details">
	<thead>
		<tr>
			<th class="product"><?php _e('Product', 'woocommerce-pdf-invoices-packing-slips'); ?></th>
			<th class="date"><?php _e('Auction Date', 'ultimate-auction-pro-software'); ?></th>
			<th class="winning-bid"><?php _e('Winning Bid', 'ultimate-auction-pro-software'); ?></th>
			<th class="commission-fee"><?php _e('Commission Fee', 'ultimate-auction-pro-software'); ?></th>
			<th class="payment-status"><?php _e('Payment Status', 'ultimate-auction-pro-software'); ?></th>
			<th class="payment-paid"><?php _e('Payment Paid', 'ultimate-auction-pro-software'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php

		$total_paid = 0;
		$commission_fee_total = 0;
		$total_amount = 0;
		foreach ($this->get_order_items() as $item_id => $item) :
			$winning_bid = 0;
			$commission_fee = 0;
			$paid_amount = 0;
			$auction_date = "";
			if ($has_seller && !empty($seller_id)) {
				try {
					$product_id = $item['product_id'];
					$uat_seller_id = get_post_meta($product_id, 'uat_seller_id', true);
					if ($uat_seller_id != $seller_id) {
						continue;
					} else {
					
						$woo_ua_auction_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
						$timestamp = strtotime($woo_ua_auction_end_date);
						$woo_ua_auction_end_date_formatted = date(wc_date_format(), $timestamp);
						$auction_date = $woo_ua_auction_end_date_formatted;
						$winning_bid = $item['item']['subtotal'] ?? 0;
						$total_amount = $total_amount + $winning_bid;

						$admin_commission_amount = get_post_meta($product_id, 'admin_commission_amount', true);
						$commission_fee = (int)$admin_commission_amount;
						$commission_fee_total = $commission_fee_total + $commission_fee;

						$seller_payment_status = 'pending';
						$payments = get_seller_product_payment_details($product_id);
						if (count($payments) > 0) {
							foreach ($payments as $payment) {
								$payment_id = (int)$payment->id;
								$seller_payment_status = $payment->status;
								if ($seller_payment_status == 'paid') {
									$paid_amount = $payment->transaction_amount;
									$total_paid = $total_paid + $payment->transaction_amount;
									$payment_status = __('Paid', 'ultimate-auction-pro-software');
									$total_seller_payment_paid = $payment->transaction_amount;
								}
								if ($seller_payment_status == 'started') {
									$payment_status = __('Started', 'ultimate-auction-pro-software');
								}
							}
						}
					}
				} catch (\Throwable $th) {
					//throw $th;
				}
			}
		?>
			<tr class="<?php echo apply_filters('wpo_wcpdf_item_row_class', 'item-' . $item_id, esc_attr($this->get_type()), $this->order, $item_id); ?>">
				<td class="product">
					<?php $description_label = __('Description', 'woocommerce-pdf-invoices-packing-slips'); // registering alternate label translation 
					?>
					<span class="item-name"><?php echo $item['name']; ?></span>
					<?php do_action('wpo_wcpdf_before_item_meta', $this->get_type(), $item, $this->order); ?>
					<span class="item-meta"><?php echo $item['meta']; ?></span>
					<dl class="meta">
						<?php $description_label = __('SKU', 'woocommerce-pdf-invoices-packing-slips'); // registering alternate label translation 
						?>
						<?php if (!empty($item['sku'])) : ?><dt class="sku"><?php _e('SKU:', 'woocommerce-pdf-invoices-packing-slips'); ?></dt>
							<dd class="sku"><?php echo esc_attr($item['sku']); ?></dd><?php endif; ?>
						<?php if (!empty($item['weight'])) : ?><dt class="weight"><?php _e('Weight:', 'woocommerce-pdf-invoices-packing-slips'); ?></dt>
							<dd class="weight"><?php echo esc_attr($item['weight']); ?><?php echo esc_attr(get_option('woocommerce_weight_unit')); ?></dd><?php endif; ?>
					</dl>
					<?php do_action('wpo_wcpdf_after_item_meta', $this->get_type(), $item, $this->order); ?>
				</td>
				<td class="date"><?php echo $auction_date; ?></td>
				<td class="winning-bid"><?php echo wc_price($winning_bid); ?></td>
				<td class="commission-fee"><?php echo wc_price(-$commission_fee); ?></td>
				<td class="commission-fee"><?php echo $payment_status; ?></td>
				<td class="commission-fee"><?php echo wc_price($paid_amount); ?></td>
			</tr>
		<?php endforeach; ?>
	</tbody>
	<tfoot>

		<?php
		if (!empty($total_paid)) {
		?>
			<tr>
				<td style="text-align: right;font-weight: bold; border: none;" colspan="5" class="description"><?php echo __('Subtotal', 'ultimate-auction-pro-software'); ?></td>
				<td style="border: none;" colspan="5" class="price"><span class="totals-price"><?php echo wc_price($total_amount); ?></span></td>
			</tr>
			<tr>
				<td style="text-align: right;font-weight: bold; border: none;" colspan="5" class="description"><?php echo __('Commission', 'ultimate-auction-pro-software'); ?></td>
				<td style="border: none;" colspan="5" class="price"><span class="totals-price"><?php echo wc_price(-$commission_fee_total); ?></span></td>
			</tr>
			<tr>
				<td style="text-align: right;font-weight: bold; border: none;" colspan="5" class="description"><?php echo __('Total Paid', 'ultimate-auction-pro-software'); ?></td>
				<td style="border: none;" colspan="5" class="price"><span class="totals-price"><?php echo wc_price($total_paid); ?></span></td>
			</tr>
			<tr>
				<td style="text-align: right;font-weight: bold; border: none;" colspan="5" class="description"><?php echo __('Total Pending', 'ultimate-auction-pro-software'); ?></td>
				<td style="border: none;" colspan="5" class="price"><span class="totals-price"><?php echo wc_price(($total_amount - $commission_fee_total) - $total_paid); ?></span></td>
			</tr>
		<?php
		}
		?>
	</tfoot>
</table>

<div class="bottom-spacer"></div>

<?php do_action('wpo_wcpdf_after_order_details', $this->get_type(), $this->order); ?>

<?php do_action('wpo_wcpdf_before_customer_notes', $this->get_type(), $this->order); ?>

<div class="customer-notes">
	<?php if ($this->get_shipping_notes()) : ?>
		<h3><?php _e('Customer Notes', 'woocommerce-pdf-invoices-packing-slips'); ?></h3>
		<?php $this->shipping_notes(); ?>
	<?php endif; ?>
</div>

<?php do_action('wpo_wcpdf_after_customer_notes', $this->get_type(), $this->order); ?>

<?php if ($this->get_footer()) : ?>
	<div id="footer">
		<!-- hook available: wpo_wcpdf_before_footer -->
		<?php $this->footer(); ?>
		<!-- hook available: wpo_wcpdf_after_footer -->
	</div><!-- #letter-footer -->
<?php endif; ?>

<?php do_action('wpo_wcpdf_after_document', $this->get_type(), $this->order); ?>