<form role="search" method="get" class="woocommerce-auction-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="woocommerce-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>"><?php esc_html_e( 'Search for:', 'ultimate-auction-pro-software' ); ?></label>
	<input type="search" id="woocommerce-auction-product-search-field-<?php echo isset( $index ) ? absint( $index ) : 0; ?>" class="search-field" placeholder="<?php echo esc_attr__( 'Search Auctions', 'ultimate-auction-pro-software' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
	<button type="submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'ultimate-auction-pro-software' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'ultimate-auction-pro-software' ); ?></button>
	<input type="hidden" name="post_type" value="product" />
	<input type="hidden" name="uat_auctions_search" value="true" />
</form>