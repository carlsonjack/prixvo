<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/*if ( ! empty( $breadcrumb ) ) {
	echo '<div class="container">';
		echo '<ul class="breadcrumb">';
	$event_id ="";
	if(is_product()) {		
		$product_id = get_queried_object_id();
		$event_id = uat_get_event_id_by_auction_id($product_id);
	}	
	if(!empty($event_id)){
		$h =$breadcrumb[0];
		$ac_nam = end( $breadcrumb );
		$event = array(               
			0  => get_the_title( $event_id ) ,
			1  => get_permalink( $event_id )
		);
	$breadcrumb = array();
	$breadcrumb[] = $h;
	$breadcrumb[] = $event;
	$breadcrumb[] = $ac_nam;			
	
	}
	foreach ( $breadcrumb as $key => $crumb ) {
		echo $before;		
	   if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<li><a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a></li>';
		} else {
			echo  '<li>'.esc_html( $crumb[0] ).'</li>';;
		}
		
		echo $after;
		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			
		}
	}	
	echo   '</ul>';
	echo '</div>';
}*/