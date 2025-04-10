<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>
<section class="order-details-page">
 
  
    <div class="hor-line"></div>

  
<div class="product-list-sec ">
    <div class="pro-list-row">
	<?php 
		do_action( 'uat_seller_checkout_list_before' );
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_view_url = $_product->get_permalink();
				$product_id = $_product->get_id();
				$thumbnail_url = "";
				$thumbnail_url_main = get_the_post_thumbnail_url($_product->get_id());
				if (!empty($thumbnail_url_main)) {
					$thumbnail_url = $thumbnail_url_main;
				} else {
					$thumbnail_url = wc_placeholder_img_src();
				}
				$uat_auction_lot_number = get_post_meta($product_id, 'uat_auction_lot_number', true);
				$woo_ua_auction_end_date_formatted = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
				if(!empty($woo_ua_auction_end_date_formatted)){
					$woo_ua_auction_end_date_formatted = strtotime($woo_ua_auction_end_date_formatted);
					$woo_ua_auction_end_date_formatted = date('D, j M Y', $woo_ua_auction_end_date_formatted);
				}
				$delivery_status = get_post_meta($product_id, 'delivery_status', true);
				?>
				<div class="prod-box-rows">
                        <div class="prod-box-left-img">
                            <img src="<?php echo $thumbnail_url; ?>" alt="<?php echo $_product->get_name(); ?>" title="<?php echo $_product->get_name(); ?>">
                        </div>
                        <div class="prod-box-Right-Content">
                            <h4><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?></h4>
                            <?php if (!empty($uat_auction_lot_number)) { ?>
                                <div class="dil-infomation">
                                    <label><?php echo __('Lot number', 'ultimate-auction-pro-software'); ?></label>
                                    <h5><?php echo $uat_auction_lot_number; ?></h5>
                                </div>
                            <?php } ?>
							<?php if (!empty($uat_seller_name)) { ?>
								<div class="dil-infomation">
									<label><?php echo __('Seller', 'ultimate-auction-pro-software'); ?></label>
									<h5><?php echo $uat_seller_name; ?></h5>
								</div>
							<?php } ?>
							<?php 
								if ($_product instanceof WC_Product_Auction) {
							?>
									<div class="dil-infomation">
										<label><?php echo __('Final bid', 'ultimate-auction-pro-software'); ?></label>
										<h5><?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?></h5>
									</div>
							<?php
							}
							?>
                           
                            <?php if (!empty($woo_ua_auction_end_date_formatted)) { ?>
                                <div class="dil-infomation">
                                    <label><?php echo __('Date of auction', 'ultimate-auction-pro-software'); ?></label>
                                    <h5><?php echo $woo_ua_auction_end_date_formatted; ?></h5>
                                </div>
                            <?php } ?>
                            <?php if (!empty($payment_date)) { ?>
                                <div class="dil-infomation">
                                    <label><?php echo __('Order date', 'ultimate-auction-pro-software'); ?></label>
                                    <h5><?php echo $payment_date; ?></h5>
                                </div>
                            <?php }  ?>
                            <?php if (!empty($delivery_status)) { ?>
                                <div class="diliverd-text">
                                    <h6>
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#11a88a" style="position: relative;top: 4px;margin-right: 5px;width: 16px;">
                                            <g id="SVGRepo_iconCarrier">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M3 3C1.34315 3 0 4.34315 0 6V15C0 16.3121 0.842366 17.4275 2.01581 17.8348C2.18436 19.6108 3.67994 21 5.5 21C7.26324 21 8.72194 19.6961 8.96456 18H15.0354C15.2781 19.6961 16.7368 21 18.5 21C20.3201 21 21.8156 19.6108 21.9842 17.8348C23.1576 17.4275 24 16.3121 24 15V10.7515C24 10.0248 23.7362 9.32283 23.2577 8.77596L20.8502 6.02449C20.2805 5.37344 19.4576 5 18.5925 5H16.8293C16.4175 3.83481 15.3062 3 14 3H3ZM4 17.4361V17.5639C4.03348 18.3634 4.69224 19.0013 5.5 19.0013C6.30776 19.0013 6.96652 18.3634 7 17.5639V17.4361C6.96652 16.6366 6.30776 15.9987 5.5 15.9987C4.69224 15.9987 4.03348 16.6366 4 17.4361ZM5.5 14C6.8962 14 8.10145 14.8175 8.66318 16H15.3368C15.8985 14.8175 17.1038 14 18.5 14C19.8245 14 20.9771 14.7357 21.5716 15.8207C21.8306 15.64 22 15.3398 22 15V11H17C15.8954 11 15 10.1046 15 9V6C15 5.44772 14.5523 5 14 5H3C2.44772 5 2 5.44772 2 6V15C2 15.3398 2.16945 15.64 2.42845 15.8207C3.02292 14.7357 4.17555 14 5.5 14ZM17 7V8C17 8.55229 17.4477 9 18 9H20.7962L19.345 7.34149C19.1552 7.12448 18.8808 7 18.5925 7H17ZM17 17.4361V17.5639C17.0335 18.3634 17.6922 19.0013 18.5 19.0013C19.3078 19.0013 19.9665 18.3634 20 17.5639V17.4361C19.9665 16.6366 19.3078 15.9987 18.5 15.9987C17.6922 15.9987 17.0335 16.6366 17 17.4361Z" fill="#0F0F0F"></path>
                                            </g>
                                        </svg>
                                        <?php echo $delivery_status; ?>
                                    </h6>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
				<?php
			}
		}
		do_action( 'uat_seller_checkout_list_after' );
		?>
    </div>
</div>
<section class="order-details-page">
	
<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
<div class="details-row">
        <div class="col-3 headings">
            <h2><?php echo __('Address', 'ultimate-auction-pro-software'); ?></h2>
        </div>
      
        <div class="col-6 right">
			<?php 
				$shipping_address = WC()->customer->get_shipping_address();
				// If the shipping address is not empty, format and display it
				if (is_array($shipping_address) && !empty($shipping_address)) {
					 // Format the shipping address
					 $formatted_address = [];
					 $formatted_address[] = $shipping_address['first_name'] . ' ' . $shipping_address['last_name'];
					 $formatted_address[] = $shipping_address['company'];
					 $formatted_address[] = $shipping_address['address_1'];
					 $formatted_address[] = $shipping_address['address_2'];
					 $formatted_address[] = $shipping_address['city'] . ', ' . $shipping_address['state'] . ' ' . $shipping_address['postcode'];
					 $formatted_address[] = $shipping_address['country'];
					?>
					<h6><?php echo __('To', 'ultimate-auction-pro-software'); ?></h6>

					<h5><?php echo implode('<br>', array_filter($formatted_address)); ?></h5>
					<?php
				}
			?>
			<?php if ( $checkout->get_checkout_fields() ) : ?>

				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>

					<div class="col2-set" id="customer_details">
						<div class="col-1">
							<?php do_action( 'woocommerce_checkout_billing' ); ?>
						</div>

						<div class="col-2">
							<?php do_action( 'woocommerce_checkout_shipping' ); ?>
						</div>
					</div>

				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

			<?php endif; ?>
        </div>
    </div>

<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
	
	<!-- <h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3> -->
	
	<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>

	<div id="order_review" class="woocommerce-checkout-review-order">
		<?php do_action( 'woocommerce_checkout_order_review' ); ?>
	</div>

	<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
</form>
</section>


<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
