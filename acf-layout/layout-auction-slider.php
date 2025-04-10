<section class="main-slider for-desktop">
    <div class="container">
        <?php $uat_auction_product_slider_section_title = get_sub_field( 'uat_auction_product_slider_section_title' ); ?>
        <?php $uat_auction_product_slider_section_link = get_sub_field( 'uat_auction_product_slider_section_link' ); ?>
        <?php if(!empty($uat_auction_product_slider_section_title) || !empty($uat_auction_product_slider_section_link) ){ ?>

        <div class="section-heading">
            <h4><?php echo get_sub_field( 'uat_auction_product_slider_section_title' ); ?></h4>
            <?php if ( $uat_auction_product_slider_section_link ) { ?>
            <a href="<?php echo esc_url($uat_auction_product_slider_section_link['url']); ?>"
                target="<?php echo esc_attr($uat_auction_product_slider_section_link['target']); ?>"><?php echo esc_attr($uat_auction_product_slider_section_link['title']); ?></a>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ( have_rows( 'uat_auction_product_slider' ) ) : ?>
        <div class="owl-carousel home-slider">
            <?php while ( have_rows( 'uat_auction_product_slider' ) ) : the_row();  ?>
            <div class="item">
                <div class="slider-row">
                    <?php $post_object = get_sub_field( 'select_auction_product' ); ?>
                    <?php if ( $post_object ): ?>
                    <?php $post = $post_object; ?>
                    <?php setup_postdata( $post ); ?>
                    <?php
						$thumb_id = get_post_thumbnail_id(get_the_ID());
						$thumb_url = wp_get_attachment_image_src($thumb_id, 'full', false );
						$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
						$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
					?>
                    <div class="slider-left-part" style="background-image: url(<?php echo esc_url($thumb_image);?>);">
                        <div class="slider-cap">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php $button_link = get_sub_field( 'button_link' ); ?>
                            <?php if ( $button_link ) { ?>
                            <a class="see-more" href="<?php echo esc_url($button_link['url']); ?>"
                                target="<?php echo esc_attr($button_link['target']); ?>"><?php echo esc_attr($button_link['title']); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php wp_reset_postdata(); ?>
                    <?php endif; ?>

                    <?php $post_object = get_sub_field( 'select_auction_product_right' ); ?>
                    <?php if ( $post_object ): ?>
                    <?php $post = $post_object; ?>
                    <?php setup_postdata( $post ); ?>
                    <?php
					    $thumb_id = get_post_thumbnail_id(get_the_ID());
						$thumb_url = wp_get_attachment_image_src($thumb_id, 'full', false );
						$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
						$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
						?>
                    <div class="slider-right-part" style="background-image: url(<?php echo esc_url($thumb_image);?>);">
                        <div class="slider-cap">
                            <h2> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> </h2>
                            <?php $button_link_right = get_sub_field( 'button_link_right' ); ?>
                            <?php if ( $button_link_right ) { ?>
                            <a class="see-more" href="<?php echo esc_url($button_link_right['url']); ?>"
                                target="<?php echo esc_attr($button_link_right['target']); ?>"><?php echo esc_attr($button_link_right['title']); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php wp_reset_postdata(); ?>
                    <?php endif; ?>

                </div>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>

    </div>
</section>

<!-- main slider start here -->
<section class="main-slider for-mobile">
    <div class="container">
        <?php if ( have_rows( 'uat_auction_product_slider' ) ) : ?>
        <div class="owl-carousel home-slider">
            <?php while ( have_rows( 'uat_auction_product_slider' ) ) : the_row();  ?>
            <div class="item">
                <?php $post_object = get_sub_field( 'select_auction_product' ); ?>
                <?php if ( $post_object ): ?>
                <?php $post = $post_object; ?>
                <?php setup_postdata( $post ); ?>
                <?php
					$thumb_id = get_post_thumbnail_id(get_the_ID());
					$thumb_url = wp_get_attachment_image_src($thumb_id, 'full', false );
					$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/media_default_big.png';
					$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
				?>
                <div class="slider-row">
                    <div class="slider-left-part" style="background-image: url(<?php echo esc_url($thumb_image);?>);">
                        <div class="slider-cap">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php $button_link = get_sub_field( 'button_link' ); ?>
                            <?php if ( $button_link ) { ?>
                            <a class="see-more" href="<?php echo esc_url($button_link['url']); ?>"
                                target="<?php echo esc_attr($button_link['target']); ?>"><?php echo esc_attr($button_link['title']); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>