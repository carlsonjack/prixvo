<section class="main-slider for-desktop">
    <div class="container">
        <?php $uat_content_banner_slider_title = get_sub_field( 'uat_content_banner_slider_title' ); ?>
        <?php $uat_content_banner_slider_link = get_sub_field( 'uat_content_banner_slider_link' ); ?>
        <?php if(!empty($uat_content_banner_slider_title) || !empty($uat_content_banner_slider_link) ){ ?>
        <div class="section-heading">
            <h4><?php echo esc_attr(get_sub_field( 'uat_content_banner_slider_title' )); ?></h4>
            <?php if ( $uat_content_banner_slider_link ) { ?>
            <a href="<?php echo esc_url($uat_content_banner_slider_link['url']); ?>"
                target="<?php echo esc_attr($uat_content_banner_slider_link['target']); ?>"><?php echo esc_attr($uat_content_banner_slider_link['title']); ?></a>
            <?php } ?>
        </div>
        <?php } ?>
        <?php if ( have_rows( 'uat_content_banner_slider' ) ) : ?>
        <div class="owl-carousel home-slider">
            <?php while ( have_rows( 'uat_content_banner_slider' ) ) : the_row();  ?>
            <div class="item">
                <div class="slider-row">
                    <?php $uat_content_banner_left = get_sub_field( 'uat_content_banner_left' ); ?>
                    <?php if ( $uat_content_banner_left ) { ?>
                    <div class="slider-left-part"
                        style="background-image: url(<?php echo esc_url($uat_content_banner_left['url']); ?>);">
                        <div class="slider-cap">
                            <h2><?php esc_attr(the_sub_field( 'uat_content_banner_left_text' )); ?></h2>
                            <?php $button_link = get_sub_field( 'button_link' ); ?>
                            <?php if ( $button_link ) { ?>
                            <a class="see-more" href="<?php echo esc_url($button_link['url']); ?>"
                                target="<?php echo esc_attr($button_link['target']); ?>"><?php echo esc_attr($button_link['title']); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    <?php $uat_content_banner_right = get_sub_field( 'uat_content_banner_right' ); ?>
                    <?php if ( $uat_content_banner_right ) { ?>
                    <div class="slider-right-part"
                        style="background-image: url(<?php echo $uat_content_banner_right['url']; ?>);">
                        <div class="slider-cap">
                            <h2><?php esc_attr(the_sub_field( 'uat_content_banner_right_text' )); ?></h2>
                            <?php $button_link_right = get_sub_field( 'button_link_right' ); ?>
                            <?php if ( $button_link_right ) { ?>
                            <a class="see-more" href="<?php echo esc_url($button_link_right['url']); ?>"
                                target="<?php echo esc_attr($button_link_right['target']); ?>"><?php echo esc_attr($button_link_right['title']); ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
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
        <?php if ( have_rows( 'uat_content_banner_slider' ) ) : ?>
        <div class="owl-carousel home-slider">
            <?php while ( have_rows( 'uat_content_banner_slider' ) ) : the_row();  ?>
            <div class="item">
                <?php $uat_content_banner_left = get_sub_field( 'uat_content_banner_left' ); ?>
                <?php if ( $uat_content_banner_left ) { ?>
                <div class="slider-row">
                    <div class="slider-left-part"
                        style="background-image: url(<?php echo $uat_content_banner_left['url']; ?>);">
                        <div class="slider-cap">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            <?php $button_link = get_sub_field( 'button_link' ); ?>
                            <?php if ( $button_link ) { ?>
                            <a class="see-more" href="<?php echo $button_link['url']; ?>"
                                target="<?php echo $button_link['target']; ?>"><?php echo $button_link['title']; ?></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
    </div>
</section>