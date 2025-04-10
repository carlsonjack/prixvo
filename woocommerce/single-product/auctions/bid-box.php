<?php if($product->get_uwa_auction_proxy()== 'yes'){ ?>
	<?php wc_get_template( 'single-product/auctions/uat-proxy-bid.php' );?>
<?php }elseif($product->get_uwa_auction_silent() == 'yes'){ ?>
	<?php wc_get_template( 'single-product/auctions/uat-silent-bid.php' );?>
<?php }else { ?>
	<?php wc_get_template( 'single-product/auctions/uat-bid.php' );?>
<?php } ?>