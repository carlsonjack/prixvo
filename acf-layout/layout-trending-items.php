<?php
$trending_items_type = get_sub_field('uat_content_trending_items_type');
$trending_items_no = get_sub_field('uat_content_trending_items_no');
if ($trending_items_type == "most_view") {
	$meta_query[] = array(
		array(
			'key'     => 'uat_product_view_count',
			'compare' => 'EXISTS',
		),
	);
	$meta_key = "uat_product_view_count";
} else {
	$meta_query[] = array(
		array(
			'key'     => 'woo_ua_auction_bid_count',
			'compare' => 'EXISTS',
		),
	);

	$meta_key = "woo_ua_auction_bid_count";
}
$postin_array = array();
$live_ids_array  = uat_get_live_auctions_ids();
$postin_array = $live_ids_array;
$postids = $postin_array;
if (empty($postids)) {
	$postids[] = array();
}
$valid_status = getValidStatusForProductVisible();
$valid_status[] = 'uat_live';
// $valid_status =  implode(",", $valid_status);
$args = array(
	'post_type'	=> 'product',
	'post_status' => $valid_status,
	// 'post_status' => 'publish',
	'ignore_sticky_posts'	=> 1,
	'orderby'              => "meta_value_num",
	'order'              => "DESC",
	'meta_query'           => $meta_query,
	'meta_key'           => $meta_key,
	'posts_per_page' => $trending_items_no,
	'tax_query' => array(array('taxonomy' => 'product_type', 'field' => 'slug', 'terms' => 'auction')),

);
$args['post__in'] = $postids;
$products  = new WP_Query($args);
$products->post_count;
if ($products->have_posts()) : ?>

	<section class="currant-and-upcoming-auction trending-slider">
		<div class="container">
			<div class="section-heading">
				<h4><?php the_sub_field('uat_content_trending_items_title'); ?></h4>
				<?php $uat_content_trending_items_link = get_sub_field('uat_content_trending_items_link'); ?>
				<?php if ($uat_content_trending_items_link) { ?>
					<a href="<?php echo $uat_content_trending_items_link['url']; ?>" target="<?php echo $uat_content_trending_items_link['target']; ?>"><?php echo $uat_content_trending_items_link['title']; ?></a>
				<?php } ?>
			</div>
			<div class="owl-carousel trending-item-slider">
				<?php while ($products->have_posts()) : $products->the_post();
					global $product;
					$thumb_id = get_post_thumbnail_id();
					$thumb_url = wp_get_attachment_image_src($thumb_id, 'events-detail-list-thumbnails');
					$thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
					$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
				?>
					<div class="owl-item">
						<?php 
							$timer = get_sub_field('uat_content_trending_items_timer');
							set_query_var('show_timer', ($timer == 'true') ? 'on' : 'off');
							wc_get_template_part('content', 'product');
						?>
					</div>
				<?php endwhile; // end of the loop. 
				?>
			</div>
		</div>
	</section>
<?php endif;
wp_reset_postdata(); ?>