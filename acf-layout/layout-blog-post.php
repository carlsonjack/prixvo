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
            <?php 
		$args = array(      
			'post_type'      => 'post',
			'post_status' =>'publish',
			'order'          => 'DESC',       
			'orderby'        => 'date',        
			'posts_per_page' => 1,        
			  	
		);
		query_posts( $args );  
		if (have_posts()):while (have_posts()) :the_post();?>
            <div class="media-left">
            <?php
			$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'uat-home-blog-big');
			$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
		    $thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
			?> 
			<div class="media-left-img"
                    style="background-image:url(<?php echo esc_url($thumb_image);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                </div>
                <a href="<?php the_permalink();?>">
                    <h4><?php the_title(); ?></h4>
                </a>
                <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
            </div>
            <?php  endwhile; wp_reset_query();  endif; ?>

            <div class="media-right">
                <?php 
			$args = array(      
				'post_type'      => 'post',
				'post_status' =>'publish',
				'order'          => 'DESC',       
				'orderby'        => 'date',        
				'posts_per_page' => 4,
				'offset' => 1,
				
			);
			query_posts( $args );  
			if (have_posts()):while (have_posts()) :the_post();?>
                <div class="media-right-box">
                <?php
				$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'uat-home-blog-small');
				$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
				$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
				?>
                    <div class="media-right-img"
                        style="background-image:url(<?php echo esc_url($thumb_image);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                    </div>
                    <a href="<?php the_permalink();?>">
                        <h5><?php the_title(); ?></h5>
                    </a>
                    <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                </div>
                <?php  endwhile; wp_reset_query();  endif; ?>

            </div>

        </div>

        <section class="main-slider for-mobile">
            <div class="owl-carousel midia-slider">
                <?php 
			$args = array(      
				'post_type'      => 'post',
				'post_status' =>'publish',
				'order'          => 'DESC',       
				'orderby'        => 'date',        
				'posts_per_page' => 5,
					
			);
			query_posts( $args );  
			if (have_posts()):while (have_posts()) :the_post();?>
                <?php
			$thumb_url = wp_get_attachment_image_src(get_post_thumbnail_id(),'uat-home-blog-big');
			$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
			$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;	
			?>
                <div class="item">
                    <div class="media-block mobile">
                        <div class="media-left">
                            <div class="media-right-img"
                                style="background-image:url(<?php echo esc_url($thumb_image);?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                            </div>
                            <a href="<?php the_permalink();?>">
                                <h4><?php the_title(); ?></h4>
                            </a>
                            <a href="<?php the_permalink();?>"><?php _e('Read more', 'ultimate-auction-pro-software'); ?></a>
                        </div>
                    </div>
                </div>
                <?php  endwhile; wp_reset_query();  endif; ?>
            </div>
    </div>
</section>