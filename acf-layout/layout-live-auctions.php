<?php
$live_items_no = get_sub_field( 'uat_content_live_items_no' );
	$postin_array = array();
	$live_ids_array  = uat_get_live_auctions_ids();
	$postin_array = $live_ids_array;
	$postids = $postin_array;
		if (empty($postids)) {
			$postids[] = array();
		}
	$args = array(
			'post_type'	=> 'product',
			'post_status' => 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' =>$live_items_no,
			'tax_query' => array(array('taxonomy' => 'product_type' , 'field' => 'slug', 'terms' => 'auction')),

		);
	$args['post__in'] = $postids;
	$products  = new WP_Query( $args );
	$products->post_count;
	if ( $products->have_posts() ) : ?>

<section class="currant-and-upcoming-auction trending-slider">
    <div class="container">
        <div class="section-heading">
            <h4><?php the_sub_field( 'uat_content_live_items_title' ); ?></h4>
            <?php $uat_content_live_items_link = get_sub_field( 'uat_content_live_items_link' ); ?>
            <?php if ( $uat_content_live_items_link ) { ?>
            <a href="<?php echo $uat_content_live_items_link['url']; ?>"
                target="<?php echo $uat_content_live_items_link['target']; ?>"><?php echo $uat_content_live_items_link['title']; ?></a>
            <?php } ?>
        </div>
        <div class="owl-carousel trending-item-slider">
            <?php while ( $products->have_posts() ) : $products->the_post(); global $product;
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id,'events-detail-list-thumbnails');
			$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/product_single_one_default.png';
			$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;	?>
			<div class="owl-item">
               <div class="event-img-box">
								<a href="<?php the_permalink();?>"><img src="<?php echo $thumb_image;?>"></a>
									<div class="saved-icon">
									<?php wc_get_template('loop/uat-auction-saved.php'); ?>
									</div>
								</div>
								<div class="ua-box-detail">
									<h4 class="event-heading">
									<?php if($product->get_lot_number()) { echo $product->get_lot_number()."."; } ?>
									<a href="<?php the_permalink();?>"><?php the_title();?></a>
									</h4>


									<?php if($product->get_auction_subtitle()) { ?>
										<p><?php echo $product->get_auction_subtitle();?></p>
									<?php } ?>


									<?php if( !empty($product->get_estimate_price_from()) || !empty($product->get_estimate_price_to()) ) : ?>
									<h5 class="Estimate"><?php _e('Estimate:', 'ultimate-auction-pro-software'); ?> <?php echo wc_price($product->get_estimate_price_from());?> - <?php echo wc_price($product->get_estimate_price_to());?></h5>
									<?php endif; ?>



									<?php if(json_chk_auction($product->get_id()) == "live" ) : ?>
									<h4 class="Lot-Status"><?php _e('Lot closes:', 'ultimate-auction-pro-software'); ?> <?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_uwa_auctions_end_time() ));  ?></h4>
									<?php elseif (json_chk_auction($product->get_id()) == "future" ):?>
									<h4 class="Lot-Status"><?php _e('Live auction begins on:', 'ultimate-auction-pro-software'); ?><?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_uwa_auction_start_time() ));  ?></h4>

									<?php else: ?>
									<h4 class="Lot-Status"><?php _e('Lot sold', 'ultimate-auction-pro-software'); ?> : <?php echo wc_price($product->get_uwa_current_bid());?></h4>
									<h5 class="bid-status"><?php _e('Bidding has closed', 'ultimate-auction-pro-software'); ?></h5>
									<?php endif; ?>


									<h4 class="total-bid-with-price">
									<strong><?php echo $product->get_price_html(); ?></strong>

									<?php 
										if($product->is_uwa_reserve_enabled()){
											if(($product->is_uwa_reserved() === TRUE) &&( $product->is_uwa_reserve_met() === FALSE )  ) {
												$uwa_reserve_txt = __( 'Reserve price not met', 'ultimate-auction-pro-software' );
											}
											if(($product->is_uwa_reserved() === TRUE) &&( $product->is_uwa_reserve_met() === TRUE )  ) {
												$uwa_reserve_txt = __( 'Reserve price met', 'ultimate-auction-pro-software' );
											}
										}else{
											$uwa_reserve_txt = __( 'No reserve', 'ultimate-auction-pro-software' );
										}
									$bid_count = $product->get_uwa_auction_bid_count();
										if(empty($bid_count)){ $bid_count = 0;} ?>
									<?php  if($bid_count > 1){ ?>
									<span>(<?php echo $bid_count;?>  <?php _e("Bids","ultimate-auction-pro-software") ?>, <?php echo $uwa_reserve_txt;?>)</span>
									<?php } else { ?><span>
									(<?php echo $bid_count;?>  <?php _e("Bid","ultimate-auction-pro-software") ?>, <?php echo $uwa_reserve_txt;?>)</span>
									<?php } ?>
									</h4>

									<a class="ua-button" href="<?php the_permalink();?>"><?php echo __( "Bid", 'ultimate-auction-pro-software' ); ?></a>

							</div>

            </div>
            <?php endwhile; // end of the loop. ?>
        </div>
    </div>
</section>
<?php endif; wp_reset_postdata(); ?>