<?php
/**
 * The Template for displaying products in a product category. Simply includes the archive template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/taxonomy-product-cat.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     4.7.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

?>

<?php $product_cat_object = get_queried_object(); ?>
<?php $timer = get_field('woo_cat_timer', 'product_cat_' . $product_cat_object->term_id); ?>
<div class="container">
	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	<?php endif; ?>
	<div class="row">
	<?php
	$page_type = get_option('options_uat_woo_category_page_layout', 'full-width');
	if(empty($page_type)){
		$page_type ="full-width";
	}
	if($page_type=="full-width"){ ?>
		<div class="left-full">
	<?php } ?>

	<div class="left-block">
<header class="woocommerce-products-header">

	<?php
	/**
	 * Hook: woocommerce_archive_description.
	 *
	 * @hooked woocommerce_taxonomy_archive_description - 10
	 * @hooked woocommerce_product_archive_description - 10
	 */
	do_action( 'woocommerce_archive_description' );
	?>
</header>
<?php
if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	woocommerce_product_loop_start();

	if ( wc_get_loop_prop( 'total' ) ) {
		while ( have_posts() ) {
			the_post();

			/**
			 * Hook: woocommerce_shop_loop.
			 */
			do_action( 'woocommerce_shop_loop' );
			
			$product_type = WC_Product_Factory::get_product_type($post_id);
			set_query_var('show_timer', ($timer == 'true') ? 'on' : 'off');
			wc_get_template_part('content', 'product');
			
			
		}
	}

	woocommerce_product_loop_end();

	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */

	if($page_type=="full-width"){ ?>
		</div>
	<?php }

	if($page_type=="left-sidebar" || $page_type=="right-sidebar" ){ ?>
		 <?php $sidebar ="left-sidebar";
		 if($page_type === "right-sidebar"){
			 $sidebar ="right-sidebar";
		 } ?>

		<div class="right-block <?php echo esc_attr($sidebar);?>">
			<?php //do_action( 'woocommerce_sidebar' ); ?>
			<?php get_sidebar( 'woocommerce' ); ?>
		</div>
	<?php }

	echo "</div>";
	echo "</div>";
echo "</div>";
get_footer();

