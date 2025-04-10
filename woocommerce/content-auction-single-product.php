<?php

/**
 * The template for displaying product content in the single-product.php template for catabooks
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

defined('ABSPATH') || exit;
global $product, $UATS_options;

$product_id = $product->get_id();
$uat_event_id = '';
$uat_event_id = uat_get_event_id_by_auction_id($product_id);
$auction_status = json_chk_auction($product_id);

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');
if (post_password_required()) {
  echo get_the_password_form(); // WPCS: XSS ok.
  return;
}
$attachment_ids = $product->get_gallery_image_ids();
$thumb_image_id = $product->get_image_id();
$seller_user_id = get_post_meta($product_id, 'uat_seller_id', true);
$seller_billing_country_code = "";
$seller_user = "";
if (!empty($seller_user_id)) {
  $seller_user = get_user_by('ID', $seller_user_id);
  $seller_billing_country_code = get_user_meta($seller_user_id, 'billing_country', true);
}
$user_id = get_current_user_id();
$bid_box_vars = [];
$bid_box_vars['product'] = $product;
$bid_box_vars['product_id'] = $product_id;
$bid_box_vars['auction_status'] = $auction_status;
?>
<?php if (json_chk_auction($product_id) == "live" || json_chk_auction($product_id) == "future") : ?>
  <span class='span-auction-id' data-acution-id='<?php echo esc_attr($product_id); ?>' data-user-id='<?php echo esc_attr(get_current_user_id()); ?>'></span>
<?php endif; ?>
<div class="container">
  <div <?php wc_product_class('product-detail-row', $product); ?>>
    <div class="product-left-block">
      <div class="left-pro-heading">
        <h1><?php the_title(); ?></h1>
        <?php
        /* show first and main category from product/event */
        $category_slug = "product_cat";
        $post_id = $product_id;
        if (!empty($uat_event_id)) {
          $post_id = $uat_event_id;
          $category_slug = "uat-event-cat";
          $main_category = get_the_terms($uat_event_id, 'uat-event-cat');
        }
        $main_category = get_the_terms($post_id, $category_slug);
        if (!empty($main_category) && !is_wp_error($main_category)) {
          $main_category_url = get_term_link($main_category[0]->term_id, $category_slug);
          if (!is_wp_error($main_category_url)) {
            $main_category_text = $main_category[0]->name;
            echo '<a class="btn-books" href="' . esc_url($main_category_url) . '">' . esc_html($main_category_text) . '</a>';
          }
        }
        ?>
        <!-- <a class="btn-books" href="#">Books</a> -->
      </div>
      <div class="like-count detail-icon-box">
        <?php
        wc_get_template('single-product/share.php');
        wc_get_template('single-product/uat-auction-saved.php');
        ?>
      </div>
      <div class="seller-product-slider">
        <?php wc_get_template('single-product/auctions/product-image.php'); ?>
        <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Product-details-page-slider.jpg" alt="slider"> -->
      </div>
      <?php
      $uat_custom_fields_display_position = get_option('uat_custom_fields_display_position', 'top');
      if (!empty($uat_custom_fields_display_position) && $uat_custom_fields_display_position == 'top') { ?>
        <?php wc_get_template('single-product/auctions/product-custom-fields.php'); ?>
      <?php }
      if (!empty($product->get_description())) {
      ?>
        <div class="d-flex-center">
          <h3><?php echo __('Description', 'ultimate-auction-pro-software'); ?></h3>
        </div>
        <div class="Description-text-box">
          <div class="description-text" id="descriptionText">
            <?php the_content(); ?>
          </div>
          <button class="read-more " style="display:block;" id="toggleButton" onclick="toggleDescription()"><?php echo __('Show more', 'ultimate-auction-pro-software'); ?></button>
        </div>
      <?php } ?>
      <div class="lot-info">
        <?php
        $uat_custom_fields_display_position = get_option('uat_custom_fields_display_position', 'top');
        if (!empty($uat_custom_fields_display_position) && $uat_custom_fields_display_position == 'bottom') { ?>
          <?php wc_get_template('single-product/auctions/product-custom-fields.php'); ?>
        <?php } ?>

        <div class="online-d-flex">
          <?php
          if (!empty($seller_billing_country_code)) {
            $seller_billing_country_code_lower = strtolower($seller_billing_country_code);
          ?>
            <div class="contry-img-with-text">
              <span class="be-lot-seller-info__flag-wrapper">
                <img src="https://flagcdn.com/<?php echo $seller_billing_country_code_lower; ?>.svg" alt="Flag">
              </span>
              <span class="contry-name">
                <?php
                $countries = WC()->countries->get_countries();
                $seller_billing_country_name = isset($countries[$seller_billing_country_code]) ? $countries[$seller_billing_country_code] : '';
                echo $seller_billing_country_name;
                ?>
              </span>
            </div>
          <?php } ?>
          <?php
          $seller_badges = $UATS_options['seller_action_user_badges'];
          $user_badges = get_user_meta($seller_user_id, 'user_badges', true);
          $selected_badges = explode(',', $user_badges);
          if (count($selected_badges) > 0) {
            echo '<div class="squar-tag">';
            foreach ($selected_badges as $badge) {
              if (isset($seller_badges[$badge])) {
                echo '<span class="tag-text">' . $seller_badges[$badge] . '</span>';
              }
            }
            echo '</div>';
          }
          ?>
        </div>
      </div>
    </div>
    <div class="product-right-block">
      <div class="single_pro_right" id="bid_sec">
        <div class="spr_in_main">
          <?php wc_get_template('single-product/auctions/bid-box.php', $bid_box_vars); ?>
        </div>
      </div>
      <?php if(!empty($seller_user)){ ?>
        <div class="spr_inner second-block">
          <div class="bl_seller_name"><?php echo __('Sold by', 'ultimate-auction-pro-software')." ".$seller_user->display_name??""; ?> </div>
          <?php
          $seller_badges = $UATS_options['seller_action_user_badges'];
          $user_badges = get_user_meta($seller_user_id, 'user_badges', true);
          $selected_badges = explode(',', $user_badges);
          if (count($selected_badges) > 0) {
            echo '<div class="seller_info_summary"><div class="s_badges">';
            foreach ($selected_badges as $badge) {
              if (isset($seller_badges[$badge])) {
                echo ' <span>' . $seller_badges[$badge] . '</span>';
              }
            }
            echo '</div></div>';
          }
          ?>
        </div>
      <?php } ?>
      <div class="ask-quastion-block">
        <button class="ask-quaastion-btn">
          <?php
          $q_a_auction_button_with_title = get_option('options_q_a_auction_button_with_title', 'on');
          $q_a_auction_Label_title = get_option('options_q_a_auction_Label_title', 'Ask a Question');
          if ($q_a_auction_button_with_title == 'on') { ?>
            <?php if (!is_user_logged_in()) { ?>
              <a data-fancybox data-src="#uat-login-form" class="btn-link ml-auto view-all" href="javascript:;"><?php echo $q_a_auction_Label_title; ?></a>
            <?php } else { ?>
              <a data-fancybox="" data-src="#ask-qus-popup" href="javascript:;" class="btn-link ml-auto view-all"><?php echo $q_a_auction_Label_title; ?></a>
            <?php } ?>
          <?php } ?>
        </button>
      </div>
    </div>
  </div>
  <?php
  $q_a_auction_product_page = get_option('options_q_a_auction_product_page', 'on');
  if ($q_a_auction_product_page == 'on') {
    require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/tpl-questions_answers.php');
  }
  $comments = get_option('options_uat_auction_comments', 'on');
  if (!empty($comments) && $comments == 'on') {
    wc_get_template('single-product/product-comments.php');
  }
  $uat_auction_related_products = get_option('options_uat_auction_related_products', "on");
  /*Used for fetch record and display in result*/
  if ($uat_auction_related_products == "on") {
    if (!empty($uat_event_id)) {
      $lot_ids_array  = get_auction_products_ids_by_event($uat_event_id);
      $original_array = unserialize($lot_ids_array);
      if (empty($original_array)) {
        $original_array[] = array();
      }
      if (($key = array_search($product_id, $original_array)) !== false) {
        unset($original_array[$key]);
      }
    }
    $valid_status = getValidStatusForProductVisible();
    $valid_status[] = 'publish';
    $args = array(
      'post_type'  => 'product',
      'post_status' => $valid_status,
      'ignore_sticky_posts'  => 1,
      'posts_per_page' => 12,
      'post__not_in' => array($product_id),
    );
    if (!empty($uat_event_id)) {
      $args['post__in'] = $original_array;
    } else {
      $related_products = wc_get_related_products($product_id);
      $args['post__in'] = $related_products;
    }
    $conditinalarr = array('relation' => 'AND');
    $conditinalarr[] = array(
      'taxonomy' => 'product_type',
      'field' => 'slug',
      'terms' => 'auction',
    );
    if (count($conditinalarr) > 1) {
      $args['tax_query'] = $conditinalarr;
    }
    $query = new WP_Query($args);
    $trecord = $query->post_count;
    $mpage = $query->max_num_pages;
    if ($query->have_posts()) {
  ?>
      <div class="product-list-sec">
        <div class="product-sec-head">
          <h3 class="mr-top-60 mr-bottom--60"><?php echo __('Related Product', 'ultimate-auction-pro-software');  ?></h3>
        </div>
        <div class="pro-list-row  <?php echo ($trecord >= 4 )?"slick-carousel":""; ?>">
          <?php
          $timer = get_option('options_related_products_timer', 'false');
          $show_timer = 'off';
          if ($timer === 'true') {
            $show_timer = 'on';
          }
          while ($query->have_posts()) : $query->the_post();
            $product_box_options = [
              'show_timer' => $show_timer
            ];
            wc_get_template_part('content', 'product', array('product_box_options' => $product_box_options));
          // get_template_part('templates/products/uat', 'product-box', array('product_box_options' => $product_box_options));
          endwhile;
          /*Restore original Post Data*/
          wp_reset_postdata();
          ?>

        </div>
      </div>
  <?php
    }
  } ?>
</div>


<script type="text/babel" src="<?php echo  trailingslashit(get_template_directory_uri()) . 'includes/json/js/mainreact.js' ?>" defer></script>
<script>
  var showDescText = '<?php echo __('Show less', 'ultimate-auction-pro-software');  ?>';
  var moreDescText = '<?php echo __('Show more', 'ultimate-auction-pro-software');  ?>';

  function theInline() {
    let x = document.getElementsByClassName("description-text");
    x[0].style.height = "auto";
  }

  function toggleDescription() {
    let descriptionDiv = document.getElementById("descriptionText");
    let toggleButton = document.getElementById("toggleButton");

    toggleButton.classList.remove('active');
    if (descriptionDiv.style.height === "160px" || descriptionDiv.style.height === "") {
      descriptionDiv.style.height = "auto";
      toggleButton.textContent = showDescText;
      toggleButton.classList.add('active');
    } else {
      descriptionDiv.style.height = "160px";
      toggleButton.textContent = moreDescText;
    }
  }

  document.addEventListener("DOMContentLoaded", function() {
    checkDescriptionHeight();
  });
  function checkDescriptionHeight() {
    var descriptionText = document.getElementById("descriptionText");
    var readMoreBtn = document.getElementById("toggleButton");
    if (descriptionText.scrollHeight > 160) {
      // readMoreBtn.style.display = "block";
    } else {
      readMoreBtn.style.display = "none";
    }
  }
  
</script>