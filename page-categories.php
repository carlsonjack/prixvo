<?php
/*
Template Name: Events Categories list page
Template Post Type: page
*/
get_header();
$page_id = get_the_ID();
$categories = getEventCategoriesList();
?>
<!-- <link rel="stylesheet" href="<?php echo UAT_THEME_PRO_CSS_URI; ?>/vendor.css" type="text/css" media="screen" /> -->
<!-- <link rel="stylesheet" href=" <?php echo UAT_THEME_PRO_CSS_URI; ?>/jquery_slick.css" type="text/css" media="screen" /> -->

<div class="catagory-blocks">
    <div class="container">
        <div class="Breadcrumb-data">
            <ul class="custom-Breadcrumb">
                <li><a href="<?php echo get_home_url(); ?>"><?php _e('Home', 'ultimate-auction-pro-software'); ?></a></li>
                <li><?php the_title(); ?></li>
            </ul>
        </div>
        <div class="catagory_heading">
            <h1><?php the_title(); ?></h1>
        </div>

        <?php
        $uat_categories_list_show = get_field('uat_categories_list_show', $page_id);
        if ($uat_categories_list_show == 'yes') {
        ?>
            <div class="mr-top-30 mr-bottom-30 catagoty-box-row">
                <?php

                foreach ($categories as $categorie) {
                    $name = $categorie['name'];
                    $image_url = $categorie['image_url'];
                    $link = $categorie['link'] ?? "";

                ?>
                    <div class="catagory-box">
                        <a href="<?php echo $link; ?>" class="catagory_link">
                            <h4><?php echo $name; ?></h4>
                            <div class="catagory_link_img"><img src="<?php echo $image_url; ?>" width="100px" /></div>
                        </a>
                    </div>
                <?php
                }
                ?>
            </div>
        <?php
        }
        $show_populer_events = get_field('uat_event_categories_populer_events', $page_id);
        if ($show_populer_events == 'yes' && class_exists( 'woocommerce' )) {
            $slide_options = [
                'header_title'      => __('Popular collections', 'ultimate-auction-pro-software'),
                'slide_type'        => 'events', // auctions, events
                'total_slides'      => 10, // 5, 10, 20...
                'event_catagory_id' => "", // pass the categorys id to show that category data only in slides
                'slides_to_show'    => "3", // number of data slides to show on page
            ];
            echo getAuctionSlider($slide_options);
        }
        $show_populer_auctions = get_field('uat_event_categories_populer_auctions', $page_id);
        if ($show_populer_auctions == 'yes' && class_exists( 'woocommerce' )) {
            $slide_options = [
                'header_title'      => __('Popular Auctions', 'ultimate-auction-pro-software'),
                'slide_type'        => 'auctions', // auctions, events
                'total_slides'      => 10, // 5, 10, 20...
                'event_catagory_id' => "", // pass the categorys id to show that category data only in slides
                'slides_to_show'    => "4", // number of data slides to show on page

            ];
            echo getAuctionSlider($slide_options);
        }
        ?>

    </div>
</div>

<!-- <script type='text/javascript' src='<?php echo UAT_THEME_PRO_JS_URI; ?>/slider/slick.min.js'></script> -->

<?php
get_footer();
?>