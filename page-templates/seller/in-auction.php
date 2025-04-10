<style>
    .auction-countdown-check {
        padding: 0px;
        border: none;
        border-radius: 0px;
        margin: 0;
        text-align: center;
        display: inline-block;
        align-items: center;
        justify-content: center;
        width: fit-content;
    }
</style>
<?php
$product_filter = "all_product";

if (isset($_POST['product_filter'])) {
    $product_filter = $_POST['product_filter'];
}
$page_heading_text =  __('In Auction', 'ultimate-auction-pro-software');
$page_helping_text =  __('if a lot hasn\'t met its reserve price, lower it here to increase your chances of selling.', 'ultimate-auction-pro-software');

$live_lot_text =  __('All live lots', 'ultimate-auction-pro-software');
$reserve_not_lot_text =  __('Reserve price not met', 'ultimate-auction-pro-software');
$no_reserve_lot_text =  __('Reserve price met / No reserve Price', 'ultimate-auction-pro-software');
$update_btn_text =  __('Update', 'ultimate-auction-pro-software');
$current_bid_text = __('Current bid', 'ultimate-auction-pro-software');

$no_products_text =  __('You have no lots in auction at the moment.', 'ultimate-auction-pro-software');
$in_auction_html = $no_products_text;

$current_user_id = get_current_user_id();
$user = get_user_by('ID', $current_user_id);
$is_admin = false;
if (current_user_can('manage_options')) {
    $is_admin = true;
}
if ($current_user_id && (in_array(UAT_SELLER_ROLE_KEY,  $user->roles) || $is_admin)) {
    $args_p = array(
        'post_type' => 'product',
        'author' => $current_user_id,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_type',
                'field' => 'slug',
                'terms' => 'auction',
                'operator' => '==',
            ),
        ),
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => 'uat_auction_expired', 
                'compare' => 'NOT EXISTS', 
            ),
            array(
                'key' => 'woo_ua_auction_closed', 
                'compare' => 'NOT EXISTS', 
            ),
            
        ),
    );
    $args_p['post_status'] = 'uat_in_auction';
    $products = new WP_Query($args_p);
    $all_product_count = $products->found_posts;
    $reserve_not_met_lot_count = 0;
    $reserve_met_lot_count = 0;
    // Loop through the products and display them
    if ($products->have_posts()) {
        $in_auction_html = "";
        while ($products->have_posts()) {
            $products->the_post();
            global $product;
            $product_id = $product->get_uwa_wpml_default_product_id();
            $thumb_id = get_post_thumbnail_id();
            $thumb_url = wp_get_attachment_image_src($thumb_id, 'product-related');
            $thumb_image_d = UAT_THEME_PRO_IMAGE_URI . 'front/product_single_one_default.png';
            $thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
            $product_title =  get_the_title();
            $product_link =  get_the_permalink();

            $uwa_reserve_txt_ = __('No reserve', 'ultimate-auction-pro-software');
            $uwa_reserve_txt = '<div class="gen-msg">' . $uwa_reserve_txt_ . '</div>';
            $reserve_price = get_post_meta($product_id, 'woo_ua_lowest_price', true);
            $current_bid = $product->get_uwa_auction_current_bid();
            $current_bid_html = wc_price($current_bid);
            $red_class = "";
            $is_reserve_met = "";
            $is_reserve_not_met = "";
            if ($product->is_uwa_reserve_enabled()) {
                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === FALSE)) {
                    $is_reserve_not_met = "yes";
                    $red_class = "red-error";
                    $reserve_price_html = wc_price($reserve_price);
                    $uwa_reserve_txt_ = __('Reserve price not met', 'ultimate-auction-pro-software');
                    $uwa_reserve_txt = "<div class='gen-msg'>
                   <svg xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' width='20px' height='20px' viewBox='0 0 20 20' version='1.1'>
                   <g id='surface1'>
                   <path style=' stroke:none;fill-rule:nonzero;fill:rgb(84.313725%,15.686275%,15.686275%);fill-opacity:1;' d='M 20 10 C 20 15.523438 15.523438 20 10 20 C 4.476562 20 0 15.523438 0 10 C 0 4.476562 4.476562 0 10 0 C 15.523438 0 20 4.476562 20 10 Z M 20 10 '></path>
                   <path style=' stroke:none;fill-rule:nonzero;fill:rgb(90.196078%,90.196078%,90.196078%);fill-opacity:1;' d='M 9.0625 15.625 L 10.9375 15.625 L 10.9375 13.75 L 9.0625 13.75 Z M 9.0625 3.75 L 9.0625 11.875 L 10.9375 11.875 L 10.9375 3.75 Z M 9.0625 3.75 '></path>
                   </g>
                   </svg>
                   <span class='text-red mr-right-left-10'>$uwa_reserve_txt_: </span>
                   <span class='text-bold'>$reserve_price_html</span>
                   </div>
                   <!-- <a href='#' class='blue-btn'>adjust</a> -->
                   ";
                    $reserve_not_met_lot_count++;
                }

                if (($product->is_uwa_reserved() === TRUE) && ($product->is_uwa_reserve_met() === TRUE)) {
                    $reserve_met_lot_count++;
                    $is_reserve_met = "yes";
                    $uwa_reserve_txt_ = __('Reserve price met', 'ultimate-auction-pro-software');
                    $uwa_reserve_txt = "<div class='gen-msg'>
                                            <svg xmlns='http://www.w3.org/2000/svg' width='20px' height='20px' viewBox='0 0 24 24' fill='none' stroke='#14a88b'>
                                                <g id='SVGRepo_bgCarrier' stroke-width='0'></g>
                                                <g id='SVGRepo_tracerCarrier' stroke-linecap='round' stroke-linejoin='round'></g>
                                                <g id='SVGRepo_iconCarrier'>
                                                    <path fill-rule='evenodd' clip-rule='evenodd' d='M1 12C1 5.92487 5.92487 1 12 1C18.0751 1 23 5.92487 23 12C23 18.0751 18.0751 23 12 23C5.92487 23 1 18.0751 1 12ZM18.4158 9.70405C18.8055 9.31268 18.8041 8.67952 18.4127 8.28984L17.7041 7.58426C17.3127 7.19458 16.6796 7.19594 16.2899 7.58731L10.5183 13.3838L7.19723 10.1089C6.80398 9.72117 6.17083 9.7256 5.78305 10.1189L5.08092 10.8309C4.69314 11.2241 4.69758 11.8573 5.09083 12.2451L9.82912 16.9174C10.221 17.3039 10.8515 17.301 11.2399 16.911L18.4158 9.70405Z' fill='#14a88b'></path>
                                                </g>
                                            </svg>
                                            <span class='text-green mr-right-left-10'>$uwa_reserve_txt_: </span>
                                        </div>";
                }
            } else {
                $is_reserve_met = "yes";
                $reserve_met_lot_count++;
            }
            if ($product_filter == "reserve_met_lot") {
                if (empty($is_reserve_met)) {
                    continue;
                }
            }
            if ($product_filter == "reserve_not_met_lot") {
                if (empty($is_reserve_not_met)) {
                    continue;
                }
            }
            $uwa_remaining_seconds = $product->get_uwa_remaining_seconds();
            $auc_end_date = get_post_meta($product_id, 'woo_ua_auction_end_date', true);
            $rem_arr = get_remaining_time_by_timezone($auc_end_date);
            ob_start();
            countdown_clock(
                $end_date = $auc_end_date,
                $item_id = $product_id,
                $item_class = 'auction-countdown-check',
            );
            $clock_html = ob_get_clean();
            $clock_html = __('Ends in ', 'ultimate-auction-pro-software') . $clock_html;
            $in_auction_html .= "<div class='in-auc-product'>
                                    <div class='product-img-content'>
                                        <div class='product-img'>
                                            <img src='" . esc_url($thumb_image) . "'>
                                        </div>
                                        <div class='product-cont'>
                                            <p><a href='$product_link'>$product_title</a></p>
                                            <div class='in-auc-timer'>$clock_html</div>
                                            <div class='bottom-left-fix'>$current_bid_text: <span class='text-bold'>$current_bid_html</span></div>
                                        </div>
                                        <div class='in-auc-footer $red_class'>$uwa_reserve_txt</div>
                                    </div>
                                </div>";
        }
    }
?>

    <div class="Sales-tab-con">
        <div id="tabs-content">
            <div class="salse_tab-content">
                <div class="page-heading">
                    <h1 class="mr-bottom-0"><?php echo $page_heading_text; ?></h1>
                    <p><?php echo $page_helping_text; ?></p>
                </div>
                <div class="select-Radio-update">
                    <form name="in-auction-filter" method="POST">
                        <div class="radio-row">
                            <div class="form-radio-gr">
                                <input type="radio" id="1" name="product_filter" value="all_product" <?php if ($product_filter == 'all_product') echo "checked"; ?>>
                                <label for="1"><?php echo $live_lot_text; ?> (<?php echo  $all_product_count; ?>)</label>
                            </div>
                            <div class="form-radio-gr">
                                <input type="radio" id="2" name="product_filter" value="reserve_not_met_lot" <?php if ($product_filter == 'reserve_not_met_lot') echo "checked"; ?>>
                                <label for="2"><?php echo $reserve_not_lot_text; ?><span class="budge-digit"><?php echo  $reserve_not_met_lot_count; ?></span></label>
                            </div>
                            <div class="form-radio-gr">
                                <input type="radio" id="3" name="product_filter" value="reserve_met_lot" <?php if ($product_filter == 'reserve_met_lot') echo "checked"; ?>>
                                <label for="3"><?php echo $no_reserve_lot_text; ?> (<?php echo  $reserve_met_lot_count; ?>)</label>
                            </div>
                        </div>
                        <div class="update-link">
                            <svg class="mr-right-5" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0,0,256,256" width="17px" height="17px" fill-rule="nonzero">
                                <g fill-opacity="0" fill="#dddddd" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                    <path d="M0,256v-256h256v256z" id="bgRectangle" style="&#10;" />
                                </g>
                                <g fill="#000000" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal;fill: var(--wp--custom-primary-link-color);">
                                    <g transform="scale(5.12,5.12)">
                                        <path d="M25,2c-0.72127,-0.0102 -1.39216,0.36875 -1.75578,0.99175c-0.36361,0.623 -0.36361,1.39351 0,2.01651c0.36361,0.623 1.0345,1.00195 1.75578,0.99175c10.51712,0 19,8.48288 19,19c0,10.51712 -8.48288,19 -19,19c-10.51712,0 -19,-8.48288 -19,-19c0,-5.4758 2.30802,-10.39189 6,-13.85547v3.85547c-0.0102,0.72127 0.36875,1.39216 0.99175,1.75578c0.623,0.36361 1.39351,0.36361 2.01651,0c0.623,-0.36361 1.00195,-1.0345 0.99175,-1.75578v-11h-11c-0.72127,-0.0102 -1.39216,0.36875 -1.75578,0.99175c-0.36361,0.623 -0.36361,1.39351 0,2.01651c0.36361,0.623 1.0345,1.00195 1.75578,0.99175h4.52539c-4.61869,4.20948 -7.52539,10.27232 -7.52539,17c0,12.67888 10.32112,23 23,23c12.67888,0 23,-10.32112 23,-23c0,-12.67888 -10.32112,-23 -23,-23z" />
                                    </g>
                                </g>
                            </svg>
                            <input type="submit" name="submit_filter_form" value="<?php echo $update_btn_text; ?>">
                        </div>
                    </form>
                </div>
                <div class="in-acution-row">
                    <?php echo $in_auction_html;  ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    jQuery(document).ready(function($) {
        $('input[name="product_filter"]').change(function() {
            $('form[name="in-auction-filter"')[0].submit();
        });
    });
</script>