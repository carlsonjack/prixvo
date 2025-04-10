<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-auction-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package Ultimate Auction Pro Software
 * @since Ultimate Auction Pro Software 1.0
 */
 
defined( 'ABSPATH' ) || exit;
global $product;
$product_id= $product->get_id();
$uat_event_id ='';
$uat_event_id = uat_get_event_id_by_auction_id($product_id);
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );
if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
	$attachment_ids = $product->get_gallery_image_ids();
	$thumb_image_id = $product->get_image_id();
?>
<?php if (json_chk_auction($product_id) == "live" || json_chk_auction($product_id) == "future") : ?>
      <span class='span-auction-id' data-acution-id='<?php echo esc_attr($product_id); ?>' data-user-id='<?php echo esc_attr(get_current_user_id()); ?>'></span>
   <?php endif; ?>
<div class="container">
	<div <?php wc_product_class( '', $product ); ?>>
		<div class="product-details-sec">
			<!-- partial:index.partial.html -->
				<!-- Slider main wrapper -->
				<?php wc_get_template( 'single-product/product-image.php' );?>
				  <!---bidding form and details -->
					<?php if($product->get_uwa_auction_proxy()== 'yes'){ ?>
					<?php wc_get_template( 'single-product/uat-proxy-bid.php' );?>
					<?php }elseif($product->get_uwa_auction_silent() == 'yes'){ ?>
					<?php wc_get_template( 'single-product/uat-silent-bid.php' );?>
					<?php }else { ?>
					<?php wc_get_template( 'single-product/uat-bid.php' );?>
					<?php } ?>
					<?php  if(get_option('options_uat_auction_meta_data', 'on') == 'on'){ ?>
						<?php wc_get_template( 'single-product/meta.php' ); ?>
					<?php }  ?>
		</div>
	</div>
</div>
	</div>
					<div>
				<?php
				if(isset($data['woo_ua_bid_increment']) || isset($data['uwa_auction_variable_bid_increment'])){

				/*  --- simple bid increment  ---  */	
				$i_bid_increment = $data['woo_ua_bid_increment'];

				if($i_bid_increment != ""){
					if ( $i_bid_increment >= 0 ) {
						$object->update_meta_data( 'woo_ua_bid_increment', $i_bid_increment );
					}
					else{
						/* no error "you have entered wrong bid increment" */
					}
				}
				else{

					/*  --- variable bid increment  ---  */
					$i_enable_variable_bidinc = $data['uwa_auction_variable_bid_increment'];
					if($i_enable_variable_bidinc == "yes"){

						/* add variable increment price */
						$i_variable_bid_inc = $data['uwa_var_inc_price_val'];

						if(!empty($i_variable_bid_inc)) {
								$array_data = array();
								$jsondatas = explode("*", $i_variable_bid_inc);				
								$i = 0;
								$count_error = 0;
								foreach ($jsondatas as $jsondata){					
									$variable_val = explode("-", $jsondata);

									if(isset($variable_val[0]) && isset($variable_val[1]) && isset($variable_val[2])){
										$start = $variable_val[0];
										$end = $variable_val[1];
										$inc_val = $variable_val[2];

										if($start > 0 && ($end > 0 || $end == $end) && $inc_val > 0 ){
											//if($end=="onwards"){
												//$i=$end;
											//}

											$array_data[$i] = array("start"=>$start,"end"=>$end,"inc_val"=>$inc_val);
										}
										else{
											$count_error++;
										}
										$i++;

									} /* end of if - isset variable_val */

									else{
										$count_error++;
									}					
									
								} /* end of foreach */


								if($count_error > 0){
									/* Error - you have entered wrong format or value in  variable increment */
								}
								else{							

									$arr_i_variable_bid_inc  = $array_data;

									$object->update_meta_data( 'uwa_auction_variable_bid_increment', 
										$i_enable_variable_bidinc );
									$object->update_meta_data( 'uwa_var_inc_price_val', 
										$arr_i_variable_bid_inc );
								}	  
						
						} /* end of if - empty */

					}  /* end of if - enabled variable inc */

				} /* end of else */

			} /* end of isset */
				?>
				</div>
	
	<div class="tab-section mr-t-80" id="auction-details-tab">
	<div class="container">		
	
	<?php
	$uat_custom_fields_display_position = get_option('uat_custom_fields_display_position', 'top');
	if (!empty($uat_custom_fields_display_position) && $uat_custom_fields_display_position == 'top') { ?>
		<?php wc_get_template( 'single-product/product-custom-fields.php' ); ?>		
	<?php } ?>	
		
	<!--AUction details tabs -->
	<?php wc_get_template( 'single-product/tabs/tabs.php' ); ?>
		
	<?php
	if(get_option('uat_custom_fields_display_position') == 'bottom'  ){  ?>								
		<?php wc_get_template( 'single-product/product-custom-fields.php' ); ?>		
	<?php } ?>	
	
	
	<!--AUction comments Section -->
	<?php
		$q_a_auction_product_page = get_option( 'options_q_a_auction_product_page', 'on' );
		if($q_a_auction_product_page=='on'){
			require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/tpl-questions_answers.php');
		}
	?>
	<?php
	$comments = get_option('options_uat_auction_comments', 'on');
	if (!empty($comments) && $comments == 'on') {
		 wc_get_template( 'single-product/product-comments.php' );
	}
		?>

			<?php
			$uat_auction_related_products = get_option('options_uat_auction_related_products', "on");
				/*Used for fetch record and display in result*/
				if($uat_auction_related_products == "on" )
				{
				if(!empty($uat_event_id)){
						$lot_ids_array  = get_auction_products_ids_by_event( $uat_event_id );
						$original_array=unserialize($lot_ids_array);
						if(empty($original_array)){
							$original_array[]= array();
						}
						if (($key = array_search($product_id, $original_array)) !== false) {
							unset($original_array[$key]);
						}
				}
				$args = array(
							'post_type'	=> 'product',
							'post_status' => 'publish',
							'ignore_sticky_posts'	=> 1,
							'posts_per_page' =>12,
							'post__not_in' => array($product_id),
				);
				if(!empty($uat_event_id)){
					$args['post__in'] = $original_array;
				}else {
					$related_products = wc_get_related_products($product_id);
					$args['post__in'] = $related_products;
				}
				$conditinalarr=array('relation' => 'AND');
				$conditinalarr[]= array(
					'taxonomy' => 'product_type',
					'field' => 'slug',
					'terms' => 'auction',
				 );
				if(count($conditinalarr)>1){
					$args['tax_query'] =$conditinalarr;
				}
				$query = new WP_Query( $args );
				$trecord= $query->post_count;
				$mpage= $query->max_num_pages;
				if ( $query->have_posts() ) { ?>
			<div class="ua-product-list-sec full-width">
				<div class="ua-product-listing    prod grid-view">
					<div class="section-heading"><h2><?php _e('More Lots', 'ultimate-auction-pro-software'); ?></h2></div>
					<div class="product-list-columns LotmoreSearch-results" id="LotmoreSearch-results">
		        <?php
				while ( $query->have_posts() ) : $query->the_post(); global $product; ?>
				<?php
				    $auction_status = json_chk_auction($product->get_id());
					$thumb_id = get_post_thumbnail_id();
					$thumb_url = wp_get_attachment_image_src($thumb_id,'product-related');
					$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/product_single_one_default.png';
					$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;	?>
						<div class="item" style="display:none;">
									<div class="event-img-box">
									<a href="<?php the_permalink();?>"><img src="<?php echo esc_url($thumb_image);?>"></a>
										<div class="saved-icon">
										<?php wc_get_template('loop/uat-auction-saved.php'); ?>
										</div>
									</div>
									<?php
									$timer = get_option( 'options_related_products_timer', 'off');
									if($auction_status == "live") {
									$product_id=$product->get_id();
									$uwa_remaining_seconds = $product->get_uwa_remaining_seconds();
									$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_end_date', true );
									$rem_arr=get_remaining_time_by_timezone($auc_end_date);
									if($timer==='true'){ ?>
									 
									<?php
										countdown_clock(
											$end_date=$auc_end_date,
											$item_id=$product_id,
											$item_class='uwa-main-auction-product-loop  auction-countdown-check',   
										);					
									?>
									<?php }
									} elseif ($auction_status == "future") {
									$product_id=$product->get_id();
									$auc_end_date=get_post_meta( $product_id, 'woo_ua_auction_start_date', true );
									$rem_arr=get_remaining_time_by_timezone($auc_end_date);
									 if($timer==='true'){ ?>
									
									<?php
										countdown_clock(
											$end_date=$auc_end_date,
											$item_id=$product_id,
											$item_class='uwa-main-auction-product-loop  auction-countdown-check scheduled',   
										);					
									?>
									<?php } } ?>

									<div class="ua-box-detail">
									<h4 class="event-heading">
									<?php if($product->get_lot_number()) { echo esc_attr($product->get_lot_number())."."; } ?>
									<a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
									<?php if($product->get_auction_subtitle()) { ?>
									<p><?php echo $product->get_auction_subtitle();?></p>
									<?php } else{ ?>
										<p></p>
									<?php } ?>
									<?php if( !empty($product->get_estimate_price_from()) || !empty($product->get_estimate_price_to()) ) { ?>
									<h5 class="Estimate"><?php _e('Estimate:', 'ultimate-auction-pro-software'); ?> <?php echo wc_price($product->get_estimate_price_from());?> - <?php echo wc_price($product->get_estimate_price_to());?></h5>
									<?php } else { ?><h5 class="Estimate"></h5><?php } ?>
									<?php if($auction_status == "live") : ?>
									<h4 class="Lot-Status"><?php _e('Lot closes:', 'ultimate-auction-pro-software'); ?> <?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_uwa_auctions_end_time() ));  ?></h4>
									<?php elseif ($auction_status == "future"):?>
									<h4 class="Lot-Status"><?php _e('Live auction begins on:', 'ultimate-auction-pro-software'); ?><?php echo  date_i18n( get_option( 'date_format' ),  strtotime( $product->get_uwa_auction_start_time() ));  ?></h4>
									<?php else: ?>
									<h4 class="Lot-Status"><?php _e('Lot sold', 'ultimate-auction-pro-software'); ?>:<?php echo wc_price($product->get_uwa_current_bid());?></h4>
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
									<span>(<?php echo esc_attr($bid_count);?>  <?php _e("Bids","ultimate-auction-pro-software") ?>, <?php echo $uwa_reserve_txt;?>)</span>
									<?php } else { ?><span>
									(<?php echo esc_attr($bid_count);?>  <?php _e("Bid","ultimate-auction-pro-software") ?>, <?php echo esc_attr($uwa_reserve_txt);?>)</span>
									<?php } ?>
									</h4>
									
									<?php 
										$setpopucls="";
										$typepb=get_option('options_field_options_to_place_bid', "show-text-field-and-quick-bid");
										
										$bpolp=get_option('options_uat_bid_pop_on_list_page');
										
										if($bpolp=='on' && $typepb!="show-drop-down-with-bid-values"){
											$setpopucls="bid-popup";
										}
									?>
									
									<?php if($auction_status == "live") : ?>
										 <a class="ua-button   <?php echo $setpopucls;?>"  data-auction-id="<?php echo $product->get_id(); ?>" href="<?php the_permalink();?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?>
										 </a>
									<?php elseif ($auction_status == "future"):?>
										 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Preview', 'ultimate-auction-pro-software'); ?>
										 </a>
									<?php else: ?>
										<a class="ua-button" href="<?php the_permalink();?>"><?php _e('Expired', 'ultimate-auction-pro-software'); ?>
										 </a>
									<?php endif; ?>
									</div>
								</div>
			<?php endwhile;?>
						<div class="load-more-btn">
							<a  class="ua-button-black" id="see_more_related" href="javascript:;"><?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
						</div>
				<?php
				/*Restore original Post Data*/
				wp_reset_postdata();
				?>
					</div>
				</div>
			</div>

				<?php } } ?>
		</div>
		</div>