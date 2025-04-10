<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */
defined( 'ABSPATH' ) || exit;
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}
global $product;
$attachment_ids = $product->get_gallery_image_ids();
$thumb_image_id = $product->get_image_id();
$product_id= $product->get_id();
?>
 <!-- Galleries -->
<?php
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($product_id), 'single-post-thumbnail');
	$featured_image = get_stylesheet_directory_uri() . '/images/gallery_1.jpg';
	if (!empty($image)) { $featured_image = $image[0]; }
	/* New Image Gallery */
	$exterior_images_images = get_field('exterior_images'); 
	$interior_images_images = get_field('interior_images'); 
	$mechanical_images_images = get_field('mechanical_images'); 
	$other_images_images = get_field('other_images');
	$docs_images_images = get_field('docs_images');
	$total_img_count = 0;
	if(!empty($exterior_images_images)){
		$total_img_count = $total_img_count + count($exterior_images_images);
	}
	if(!empty($interior_images_images)){
		$total_img_count = $total_img_count + count($interior_images_images);
	}
	if(!empty($mechanical_images_images)){
		$total_img_count = $total_img_count + count($mechanical_images_images);
	}
	if(!empty($other_images_images)){
		$total_img_count = $total_img_count + count($other_images_images);
	}
	if(!empty($docs_images_images)){
		$total_img_count = $total_img_count + count($docs_images_images);
	}
	$attachment_ids = $product->get_gallery_image_ids();
	$attachments = count($attachment_ids);
?>
<?php if(!empty($exterior_images_images)){ ?>
<div class="grid-row">
    <?php
        $all_images = array();
        $all_images['Exterior'] = $exterior_images_images;
        $all_images['Interior'] = $interior_images_images;
        $all_images['Mechanical'] = $mechanical_images_images;
        $all_images['Docs'] = $docs_images_images;
        $all_images['Other'] = $other_images_images;
		$allimg_array = array_merge((array)$exterior_images_images, (array)$interior_images_images, (array)$mechanical_images_images, (array)$other_images_images, (array)$docs_images_images);
          if ($all_images) :
            $i_count = 1;
			$img_visibale_count = 1;
            $total_show_count = 8;
			$total_menu_image_show_count = 4;
            foreach ($all_images as $type => $one_type_image) :
                $menu_count = 1;
				$menu_img_count = 1;
				if(!empty($one_type_image)){
					
                foreach ($one_type_image as $one_type_image_array) :
					
                    $image_hide = "";
					 $menu_html = "";
                    if ($i_count == 1) {
						$one_type_image_url  = wp_get_attachment_image_src( $one_type_image_array, 'full', true );

						echo '<div class="card-image-left"><div class="card-image card-image-1" data-type="' . $type . '"  style="background-image: url(' . $one_type_image_url[0] . ');"><a href="' . $one_type_image_url[0] . '"  data-fancybox="gallery"></a></div></div>';

                    } else {
                        if ($menu_count == 1 || $i_count == 2) {
                            $menu_html = '<span class="group-name">'.$type.' ('.count($one_type_image).')</span>';
                        }
						if ($i_count == 5 ) {
                            $total_menu_image_show_count = 5;
                        }
                        if ($i_count == 2) {
							$total_img_count_ = $total_img_count - 1;
                            echo '<div class="card-image-right total-image-'.$total_img_count_.'">';
                        }
						$is_all = "";
                        if ($img_visibale_count > $total_show_count) {
                           $image_hide = "display:none;";
                        }elseif ($menu_img_count > $total_menu_image_show_count) {
                            $image_hide = "display:none;";
                        }else{
							if ($img_visibale_count == $total_show_count) {
							$is_all = 'data-all-box="all" data-all-box-img="all" ';
							}
							$img_visibale_count++;
						}
						if ($img_visibale_count-1 == $total_show_count) {
                            $menu_html = '<div data-section="interior" data-id="all" class="all">All Photos ('.$total_img_count.')</div>';
                        }
						$thumb_url  = wp_get_attachment_image_src( $one_type_image_array, 'medium', true );
						$image_url  = wp_get_attachment_image_src( $one_type_image_array, 'full', true );
							echo '<div class="card-image " data-type="' . $type . '"  style="background-image: url(' . $thumb_url[0] . ');' . $image_hide . '"><a class="card-image-url" ' . $is_all . ' href="' . $image_url[0] . '"  data-fancybox="gallery">'.$menu_html.'</a></div>';
                        
						/*if ($i_count == count($total_img_count)) {*/
						if ($i_count == $total_img_count) {
							echo '</div>';
                        }
                    }
                    $i_count++;
                    $menu_count++;
					$menu_img_count++;
                endforeach;
				}
            endforeach;
        endif;
        ?>
    </div>
	<?php 
	}
	else{ 
		if (!empty($attachment_ids)) {
			?>
				<div class="listing-gallery">
					<div class="row no-gutters">
						<div class="col-xl-8">
							<div class="gallery-preview">
								<a href="<?php echo $featured_image; ?>" data-lightbox="car-photo-feature" data-title="My caption"><img src="<?php echo $featured_image; ?>" alt="image preview"></a>
							</div>
						</div>
						<div class="col-xl-4">
							<div class="gallery-thumbnail">
								<?php
								$maxnum = ($attachments > 6) ? 6 : $attachments;
								$label = false;
								for ($i = 0; $i < $maxnum; $i++) {
									$image_link = wp_get_attachment_url($attachment_ids[$i]);
									$addhoverlabel = '';
									$bgimg = 'background-image: url(' . $image_link . ');';
									if ($attachments > 6 && $i == 5) {
										$label = true;
										$bgimg = 'background:linear-gradient(0deg, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url(' . $image_link . ');';
										$addhoverlabel = '<label class="all-photo"><a href="' . $image_link . '" data-lightbox="car-photo-feature">All Photos</a></label>';
									}
									if ($label) { ?>
										<div class="thumbnail-wrap" style="<?php echo $bgimg; ?>">	<?php echo $addhoverlabel; ?>
										</div>
									<?php } else { ?>
										<div class="thumbnail-wrap" style="<?php echo $bgimg; ?>">
											<a href="<?php echo $image_link; ?>" data-lightbox="car-photo-feature" class="thumb_photos"></a><?php echo $addhoverlabel; ?>
										</div>
								<?php }
								}
								foreach ($attachment_ids as $key => $attachment_id) {
									if ($key + 1 > 6) {
										echo '<a href="' . wp_get_attachment_url($attachment_id) . '"  data-lightbox="car-photo-feature" ></a>';
									}
								}
								?>
							</div>
						</div>
					</div>
				</div>
			<?php
		}else{
			$post_thumbnail_id = $product->get_image_id();
			$html  = '<div class="grid-row">';
			$html  .= '<div class="card-image-left">';
			$html  .= '<div class="card-image card-image-1"   style="background-image: url('.esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ).');">';
			$html  .= '<a href="'.esc_url( wc_placeholder_img_src( 'woocommerce_single' ) ).'" >';
			$html  .= '</a>';
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';
			echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id ); /* phpcs:disable WordPress.XSS.EscapeOutput.OutputNotEscaped*/
			?>
			<?php
		}
	} 
	?>
 