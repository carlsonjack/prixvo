<?php
/**
 * Single Product Vehicle Specification
 *
 * 
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;
$get_auction_subtitle='';


$default_exterior_images = get_option( 'options_default_exterior_images','1');
$default_interior_images = get_option( 'options_default_interior_images','1');;
$default_mechanical_images = get_option( 'options_default_mechanical_images','1');
$default_other_images = get_option( 'options_default_other_images','1');
$default_docs_images = get_option( 'options_default_docs_images','1');
$default_videos_gallery = get_option( 'options_default_videos_gallery','1');
$default_upload_carfax_history_report = get_option( 'options_default_upload_carfax_history_report','1');
$default_vehicle_history_report = get_option( 'options_default_vehicle_history_report','1');

$exterior_images_images = get_field('exterior_images'); 
$interior_images_images = get_field('interior_images');  
$other_images_images_images = get_field('other_images'); 
$mechanical_images_images = get_field('mechanical_images'); 
$docs_images_images = get_field('docs_images'); 
?>

<?php if($default_videos_gallery=='1'){ ?>
    <?php if (have_rows('cmf_videos_re')) : ?>
        <div class="custum-text-block video_gallery">
            <h4><?php _e('Video', 'ultimate-auction-pro-software'); ?></h4>
            <div class="vg_row">
            <?php while (have_rows('cmf_videos_re')) : the_row(); ?>
            <?php 
                $cmf_videos = get_sub_field('cmf_videos'); 
                if($cmf_videos){?>
                    <div class="vg_col">
                    <div class="vg_box">
                        <a href="<?php echo $cmf_videos; ?>" data-fancybox class="overlay_link"></a>
                        <div class="youtube-player" data-id="<?php echo getYoutubeVideoId($cmf_videos); ?>"></div>                                  
                    </div> 
                    </div>
                <?php } ?>									
                <?php endwhile; ?>
                </div>
        </div>
    <?php endif; ?>
<?php } ?>



<?php
    if($default_exterior_images=='1'){ 
        if(!empty($exterior_images_images)){
            $total_img_count = count($exterior_images_images); 	?>
            <div class="galleryGrid">
                <h4><?php _e('Exterior', 'ultimate-auction-pro-software'); ?> <span class="count">(<?php echo $total_img_count; ?>)</span></h4>
                <div class="galleryGrid_container">
                    <div class="gc_row">
                        <ul>
                        <?php foreach ($exterior_images_images as $exterior_images) { 
                                $thumb_url  = wp_get_attachment_image_src( $exterior_images, 'medium', true );
                                $image_url  = wp_get_attachment_image_src( $exterior_images, 'full', true ); ?>
                            <li class="gg_item"><a href="<?php echo $image_url[0]; ?>" data-fancybox="gallery"><img src="<?php echo $thumb_url[0]; ?>"></a></li>
                            <?php } ?>
                        </ul> 
                    </div>
                </div>
            </div>
<?php   } 
    }   ?>

<?php 
    if($default_interior_images=='1'){
    if(!empty($interior_images_images)){ 
    $total_img_count = count($interior_images_images);   ?>
    <div class="galleryGrid">
        <h4><?php _e('Interior', 'ultimate-auction-pro-software'); ?> <span class="count">(<?php echo $total_img_count; ?>)</span></h4>
        <div class="galleryGrid_container">
            <div class="gc_row">
                <ul>
                    <?php foreach ($interior_images_images as $interior_images) {  
                        $thumb_url  = wp_get_attachment_image_src( $interior_images, 'medium', true );
                        $image_url  = wp_get_attachment_image_src( $interior_images, 'full', true );    ?>
                    <li class="gg_item"><a href="<?php echo $image_url[0]; ?>" data-fancybox="gallery"><img src="<?php echo $thumb_url[0]; ?>"></a></li>
                    <?php } ?>
                </ul> 
            </div>
        </div>
    </div>
<?php } ?>
<?php } ?>
<?php if($default_mechanical_images=='1'){
        if(!empty($mechanical_images_images)){  $total_img_count = count($mechanical_images_images); ?>
        <div class="galleryGrid">
            <h4><?php _e('Mechanical', 'ultimate-auction-pro-software'); ?> <span class="count">(<?php echo $total_img_count; ?>)</span></h4>
            <div class="galleryGrid_container">
                <div class="gc_row">
                    <ul>
                        <?php 
                            foreach ($mechanical_images_images as $mechanical_images) {  
                                $thumb_url  = wp_get_attachment_image_src( $mechanical_images, 'medium', true );
                                $image_url  = wp_get_attachment_image_src( $mechanical_images, 'full', true ); ?>
                                <li class="gg_item"><a href="<?php echo $image_url[0]; ?>" data-fancybox="gallery"><img src="<?php echo $thumb_url[0]; ?>"></a></li>
                        <?php } ?>                              
                    </ul> 
                </div>
            </div>        
        </div>
<?php } ?>
<?php } ?>
					
<?php 
    if($default_other_images=='1'){
        if(!empty($other_images_images_images)){ $total_img_count = count($other_images_images_images); ?>
        <div class="galleryGrid">
            <h4><?php _e('Other Images', 'ultimate-auction-pro-software'); ?> <span class="count">(<?php echo $total_img_count; ?>)</span></h4>
            <div class="galleryGrid_container">
                <div class="gc_row">
                    <ul>
                        <?php foreach ($other_images_images_images as $mechanical_images) {  
                            $thumb_url  = wp_get_attachment_image_src( $mechanical_images, 'medium', true );
                            $image_url  = wp_get_attachment_image_src( $mechanical_images, 'full', true );  ?>
                            <li class="gg_item"><a href="<?php echo $image_url[0]; ?>" data-fancybox="gallery"><img src="<?php echo $thumb_url[0]; ?>"></a></li>
                        <?php } ?>                              
                    </ul> 
                </div>
            </div>   
        </div>
<?php } ?>
<?php } ?>
					
<?php 
    if($default_docs_images=='1'){ 
        if(!empty($docs_images_images)){ $total_img_count = count($docs_images_images); ?>
            <div class="galleryGrid">
                <h4><?php _e('Documents', 'ultimate-auction-pro-software'); ?> <span class="count">(<?php echo $total_img_count; ?>)</span></h4>
                <div class="galleryGrid_container">
                    <div class="gc_row">
                        <ul>
                          <?php foreach ($docs_images_images as $docs_images) {  
                                $thumb_url  = wp_get_attachment_image_src( $docs_images, 'medium', true );
                                $image_url  = wp_get_attachment_image_src( $docs_images, 'full', true ); ?>
                            <li class="gg_item"><a href="<?php echo $image_url[0]; ?>" data-fancybox="gallery"><img src="<?php echo $thumb_url[0]; ?>"></a></li>
                            <?php } ?>                              
                        </ul> 
                    </div>
                </div>
            </div>
    <?php } ?>
<?php } ?>