<section class="currant-and-upcoming-auction">
    <div class="container">
        <div class="section-heading">
            <h4><?php the_sub_field( 'uat_content_featured_categories_section_title' ); ?></h4>
            <?php $uat_content_featured_categories_link = get_sub_field( 'uat_content_featured_categories_link' ); ?>
            <?php if ( $uat_content_featured_categories_link ) { ?>
            <a href="<?php echo esc_url($uat_content_featured_categories_link['url']); ?>"
                target="<?php echo esc_attr($uat_content_featured_categories_link['target']); ?>"><?php echo esc_attr($uat_content_featured_categories_link['title']); ?></a>
            <?php } ?>
        </div>

        <?php $terms = get_sub_field( 'uat_content_featured_categories_list' ); ?>
        <?php if ( $terms ): ?>
        <ul class="featured_categories">
            <?php foreach ( $terms as $term ): ?>
            <?php 
				$cat_thumb_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb_url_array = wp_get_attachment_image_src( $cat_thumb_id, 'uat-featured-categories',false );
				$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/featured-categories-default.png';
				$thumb_image = isset($thumb_url_array[0]) ? $thumb_url_array[0] : $thumb_image_d;
				?>
            <li>
                <a href="<?php echo esc_attr(get_term_link($term->term_id));?>">
                    <div class="featured-box">
                        <div class="featured_cat_img"
                            style="background-image:url(<?php echo esc_url($thumb_image); ?>);background-repeat: no-repeat;background-size: cover;background-position: top center;">
                        </div>
                        <h4><?php echo esc_attr($term->name); ?></h4>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

    </div>
</section>