<section class="currant-and-upcoming-auction">
    <div class="container">
        <div class="section-heading">
            <h4><?php the_sub_field( 'uat_content_blog_post_title' ); ?></h4>
            <?php $uat_content_blog_post_link = get_sub_field( 'uat_content_blog_post_link' ); ?>
            <?php if ( $uat_content_blog_post_link ) { ?>
            <a href="<?php echo $uat_content_blog_post_link['url']; ?>"
                target="<?php echo $uat_content_blog_post_link['target']; ?>"><?php echo $uat_content_blog_post_link['title']; ?></a>
            <?php } ?>
        </div>
        <div class="media-block desktop">
            <?php $post_object = get_sub_field( 'uat_content_blog_post_type_manually' ); ?>
            <?php if ( $post_object ): ?>
            <div class="media-left">
                <?php $post = $post_object; ?>
                <?php setup_postdata( $post ); ?>
                <?php	
					$thumb_id = get_post_thumbnail_id(get_the_ID());						
					$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'uat-home-blog-big', false );			
					$thumb_url = $thumb_url_array[0];
					if ($thumb_url=="")	{
						$thumb_url = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
					 }?>
                <div class="media-left-img"
                    style="background-image:url(<?php echo esc_url($thumb_url);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                </div>
                <a href="<?php the_permalink();?>">
                    <h4><?php the_title(); ?></h4>
                </a>
                <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                <?php wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>
            <?php $post_objects2 = get_sub_field( 'uat_content_blog_post_type_manually_right' ); ?>
            <?php if ( $post_objects2 ): ?>
            <div class="media-right">
                <?php foreach ( $post_objects2 as $post ):  ?>
                <?php setup_postdata( $post ); ?>
                <div class="media-right-box">
                    <?php
					$thumb_url_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'uat-home-blog-small', false );			
					$thumb_url = $thumb_url_array[0];
					if ($thumb_url=="")	{
						$thumb_url = UAT_THEME_PRO_IMAGE_URI.'front/media_default_small.png';
					 }?>
                    <div class="media-right-img"
                        style="background-image:url(<?php echo esc_url($thumb_url);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                    </div>
                    <a href="<?php the_permalink();?>">
                        <h5><?php the_title(); ?></h5>
                    </a>
                    <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>
        </div>
        <section class="main-slider for-mobile">
            <div class="owl-carousel midia-slider">
                <?php $post_object = get_sub_field( 'uat_content_blog_post_type_manually' ); ?>
                <?php if ( $post_object ): ?>
                <?php $post = $post_object; ?>
                <?php setup_postdata( $post ); ?>
                <?php	
				$thumb_id = get_post_thumbnail_id(get_the_ID());						
				$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'uat-home-blog-big', false );			
				$thumb_url = $thumb_url_array[0];
				if ($thumb_url=="")	{
					$thumb_url = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
				 }?>
                <div class="item">
                    <div class="media-block mobile">
                        <div class="media-left">
                            <div class="media-right-img"
                                style="background-image:url(<?php echo $thumb_url;?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                            </div>
                            <a href="<?php the_permalink();?>">
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                        </div>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>

                <?php $post_objects2 = get_sub_field( 'uat_content_blog_post_type_manually_right' ); ?>
                <?php if ( $post_objects2 ): ?>
                <?php foreach ( $post_objects2 as $post ):  ?>
                <?php setup_postdata( $post ); ?>
                <?php
					$thumb_url_array = wp_get_attachment_image_src(get_post_thumbnail_id(), 'uat-home-blog-small', false );			
					$thumb_url = $thumb_url_array[0];
					if ($thumb_url=="")	{
						$thumb_url = UAT_THEME_PRO_IMAGE_URI.'front/media_default_small.png';
					 }?>
                <div class="item">
                    <div class="media-block mobile">
                        <div class="media-left">
                            <div class="media-right-img"
                                style="background-image:url(<?php echo esc_url($thumb_url);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                            </div>
                            <a href="<?php the_permalink();?>">
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
    </div>
</section>