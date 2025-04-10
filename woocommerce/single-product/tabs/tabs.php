<?php
/**
 * Single Product tabs
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/tabs/tabs.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
 global $woocommerce, $post, $product;
$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $product_tabs ) ) : ?>
	<div class="tab-section mr-t-80" id="auction-details-tab">
		<?php if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') { ?>
			<h2><?php _e('Auction Details', 'ultimate-auction-pro-software');?></h2>
		<?php } ?>
		<div class="tabs">
			<div class="woocommerce-tabs wc-tabs-wrapper">
				<ul class="tabs wc-tabs" role="tablist" id="tabs-nav">
					<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
						<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
						<?php if($key =="uat_auction_bids_history"){
							 $bid_count = $product->get_uwa_auction_bid_count();
							if(empty($bid_count)){ $bid_count = 0;}
						$Bids_tab_title = $product_tab['title'].' (<span class="auction-bid-count">'.$bid_count.'</span>)';
						?>
						<a href="#tab-<?php echo esc_attr( $key ); ?>">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $Bids_tab_title, $key ) ); ?>
						</a>
						<?php } else { ?>
							<a href="#tab-<?php echo esc_attr( $key ); ?>">
								<?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?>
							</a>
							<?php } ?>
						</li>
					<?php endforeach; ?>
				</ul>
				<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
					<div id="tabs-content">
					<div class=" tab-content woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
						<?php
						if ( isset( $product_tab['callback'] ) ) {
							call_user_func( $product_tab['callback'], $key, $product_tab );
						}
						?>
					</div>
					</div>
				<?php endforeach; ?>
				<?php do_action( 'woocommerce_product_after_tabs' ); ?>
			</div>
		</div>
	 </div>
					<!-- END tabs -->
<?php endif;
	if(method_exists( $product, 'get_type') && $product->get_type() == 'auction') {
	} else {


		$q_a_auction_product_page = get_option( 'options_q_a_auction_product_page', 'on' );
		if($q_a_auction_product_page=='on'){
			require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/tpl-questions_answers.php');
		}


		 $comments = get_option('options_wc_default_page_comments','on');
		if (!empty($comments) && $comments == 'on') {
			 wc_get_template( 'single-product/product-comments.php' );
		}
	}
?>