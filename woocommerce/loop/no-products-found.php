<?php
/**
 * Displayed when no products are found matching the current query
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/no-products-found.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.5.2
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="woocommerce-no-products-found">
    <?php
    if (function_exists('wc_print_notice')) {
        wc_print_notice( esc_html__( 'No products were found matching your selection.', 'woocommerce' ), 'notice' );
    } else {
        echo '<div class="notice">' . esc_html__( 'No products were found matching your selection.', 'woocommerce' ) . '</div>';
    }
    ?>
</div>