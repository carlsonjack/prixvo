<?php
/**
 * Single Product Vehicle Specification
 *
 * 
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
global $product;


$default_specification_summary = get_option( 'options_default_specification_summary','1');
$specification = get_field('cmf_specification');


$default_vehicle_highlights = get_option( 'options_default_vehicle_highlights','1');
$default_vehicle_equipment = get_option( 'options_default_vehicle_equipment','1');
$default_vehicle_modifications = get_option( 'options_default_vehicle_modifications','1');
$default_dealer_notes = get_option( 'options_default_dealer_notes','1');
$default_vehicle_known_issues = get_option( 'options_default_vehicle_known_issues','1');
$default_vehicle_history_report = get_option( 'options_default_vehicle_history_report','1');

$highlights = get_field('cmf_vehicle_highlights');
$equipment = get_field('cmf_equipment');
$modifications = get_field('cmf_modifications'); 
$known_issues = get_field('cmf_known_issues'); 
$dealer_notes = get_field('cmf_dealer_notes'); 
?>
<div class="car-details-text-descripton auction_details">
    <?php the_content(); ?>
    <?php if (!empty($specification) && $default_specification_summary=='1') { ?>
    <div class="custum-text-block detail-specification">
        <h4><?php _e('Specification Summary', 'ultimate-auction-pro-software'); ?></h4>
        <div class="detail-body"><?php echo wpautop($specification); ?></div>
    </div>
    <?php } ?>
    <?php if (!empty($highlights) && $default_vehicle_highlights=='1') { ?>
        <div class="custum-text-block detail-highlights">
            <h4><?php _e('Highlights', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body"><?php echo $highlights; ?></div>
        </div>
    <?php } ?>
    <?php if (!empty($equipment) && $default_vehicle_equipment=='1') { ?>
        <div class="custum-text-block detail-equipment">
            <h4><?php _e('Equipment', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body"><?php echo $equipment; ?></div>
        </div>
    <?php } ?>
    <?php if (!empty($modifications) && $default_vehicle_modifications=='1') { ?>
        <div class="custum-text-block detail-modifications">
            <h4><?php _e('Modifications', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body"><?php echo $modifications; ?></div>
        </div>
    <?php } ?>
    <?php if (!empty($known_issues) && $default_vehicle_known_issues=='1') { ?>
        <div class="custum-text-block detail-known_flaws">
            <h4><?php _e('Known Flaws', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body"><?php echo $known_issues; ?></div>
        </div>
    <?php } ?>
    <?php if ($default_vehicle_history_report=='1') { ?>    
    <?php if (have_rows('attached_report')) : ?>
        <div class="custum-text-block vehicle-history-section listing-section">
            <h4><?php _e('Vehicle History Report', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body">
                <?php while (have_rows('attached_report')) : the_row(); ?>
                    <div class="list-sec-item report-text">
                    <?php $file_history_report = get_sub_field('file_history_report'); ?>
                        <?php if ($file_history_report) { ?>
                        <svg style="float: left;" fill="var(--wp--custom-primary-link-color)" height="30px" width="30px" xml:space="preserve" viewBox="0 0 32 32" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" id="Icons" version="1.1"><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:none;stroke:#000000;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;} </style> <path d="M24,16c-4.4,0-8,3.6-8,8s3.6,8,8,8s8-3.6,8-8S28.4,16,24,16z M27.7,24.6l-3,3.1c0,0,0,0,0,0c-0.1,0.1-0.2,0.2-0.3,0.2 c0,0,0,0,0,0C24.3,28,24.1,28,24,28s-0.3,0-0.4-0.1c0,0,0,0,0,0c-0.1-0.1-0.2-0.1-0.3-0.2c0,0,0,0,0,0l-3-3.1c-0.4-0.4-0.4-1,0-1.4 c0.4-0.4,1-0.4,1.4,0l1.3,1.3V20c0-0.6,0.4-1,1-1s1,0.4,1,1v4.5l1.3-1.3c0.4-0.4,1-0.4,1.4,0C28.1,23.6,28.1,24.2,27.7,24.6z"></path> <g> <polygon points="17,2.6 17,8 22.4,8 "></polygon> <path d="M20.5,10H16c-0.6,0-1-0.4-1-1V2H4C3.4,2,3,2.4,3,3v26c0,0.6,0.4,1,1,1h12c-1.3-1.7-2-3.7-2-6c0-5.2,4-9.4,9-9.9v-1.6 C23,11.1,21.9,10,20.5,10z"></path> </g> </g></svg>
                        <a href="<?php echo $file_history_report['url']; ?>" download><?php the_sub_field('file_history_report_label'); ?></a> <?php } ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php } ?>                        
    <?php if (!empty($dealer_notes) && $default_dealer_notes=='1') { ?>
        <div class="custum-text-block detail-ownership_history">
            <h4><?php _e('Seller Notes', 'ultimate-auction-pro-software'); ?></h4>
            <div class="detail-body"><?php echo $dealer_notes; ?></div>
        </div>
    <?php } ?>    
</div>