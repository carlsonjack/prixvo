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
$get_auction_subtitle='';
if ($product->get_type() == 'auction') {
	$get_auction_subtitle=$product->get_auction_subtitle();
}
?>


<?php 

    


	$default_year = get_option( 'options_default_year','1');
	$default_make = get_option( 'options_default_make','1');
	$default_model = get_option( 'options_default_model','1');
	$default_location_country = get_option( 'options_default_location_country','1');
	$default_location_postal_code = get_option( 'options_default_location_postal_code','1');
	$default_wheel_size_and_type = get_option( 'options_default_wheel_size_and_type','1');
	$default_tire_brand_and_model = get_option( 'options_default_tire_brand_and_model','1');
	$default_tire_size = get_option( 'options_default_tire_size','1');
	$default_title_status = get_option( 'options_default_title_status','1');
	$default_name_on_title = get_option( 'options_default_name_on_title','1');
	$default_state_on_title = get_option( 'options_default_state_on_title' ,'1');
	$default_mileage = get_option( 'options_default_mileage','1');
	$default_is_this_number_accurate = get_option( 'options_default_is_this_number_accurate','1');
	$default_total_miles_accumulated_under_present_ownership = get_option( 'options_default_total_miles_accumulated_under_present_ownership','1');
	$default_vin = get_option( 'options_default_vin','1');
	$default_body_style = get_option( 'options_default_body_style','1');
	$default_engine = get_option( 'options_default_engine','1');
	$default_drivetrain = get_option( 'options_default_drivetrain','1');
	$default_transmission = get_option( 'options_default_transmission','1');
	$default_exterior_color = get_option( 'options_default_exterior_color','1');
	$default_interior_color = get_option( 'options_default_interior_color','1');
	$default_condition = get_option( 'options_default_condition','1');
	$default_registration_date = get_option( 'options_default_registration_date','1');
	$default_drive_type = get_option( 'options_default_drive_type','1');
	$default_cylinders = get_option( 'options_default_cylinders','1');
	$default_doors = get_option( 'options_default_doors');
	$default_fuel_type = get_option( 'options_default_fuel_type','1');
	$default_fuel_economy = get_option( 'options_default_fuel_economy','1');
	$default_vehicle_owner = get_option( 'options_default_vehicle_owner','1');
	$default_nft_owner = get_option( 'options_default_nft_owner','1');
	$default_date_verified = get_option( 'options_default_date_verified','1');
	$default_mileage_reported = get_option( 'options_default_mileage_reported','1');
	$default_is_the_vehicle_titled_in_your_name = get_option( 'options_default_is_the_vehicle_titled_in_your_name','1');
	$default_do_you_have_the_title_in_hand = get_option( 'options_default_do_you_have_the_title_in_hand','1');


	



    /* GET filed Value */ 
    $cmf_year = get_field('cmf_year'); 
    $cmf_make = get_field('cmf_make'); 
    $cmf_model = get_field('cmf_model_new');
	$cmf_location_country = get_field('cmf_location_country');
    $cmf_location_postal_code = get_field('cmf_location_postal_code');
    $cmf_wheel_size_and_type = get_field('cmf_wheel_size_and_type');
    $cmf_tire_brand_and_model = get_field('cmf_tire_brand_and_model');
    $cmf_tire_size = get_field('cmf_tire_size');
    $cmf_title_status = get_field('cmf_title_status');
    $cmf_name_on_title = get_field('cmf_name_on_title');
    $cmf_state_on_title = get_field('cmf_state_on_title');
    $cmf_mileage = get_field('cmf_mileage');
    $cmf_mileage_type = get_field('cmf_mileage_type');
    $cmf_is_this_number_accurate = get_field('cmf_is_this_number_accurate');
    $cmf_total_miles_accumulated_under_present_ownership = get_field('cmf_total_miles_accumulated_under_present_ownership');
    $cmf_vin =  get_field('cmf_vin');
    $cmf_body_style =  get_field('cmf_body_style');
    $cmf_engine =  get_field('cmf_engine');
    $cmf_drivetrain = get_field('cmf_drivetrain');
    $cmf_transmission = get_field('cmf_transmission');
    $cmf_exterior_color = get_field('cmf_exterior_color');
    $cmf_interior_color = get_field('cmf_interior_color');
    $cmf_condition = get_field('cmf_condition');
    $cmf_registration_date = get_field('cmf_registration_date');
    $cmf_drive_type = get_field('cmf_drive_type');
    $cmf_cylinders = get_field('cmf_cylinders');
    $cmf_doors = get_field('cmf_doors');
    $cmf_fuel_type = get_field('cmf_fuel_type');
    $cmf_fuel_economy = get_field('cmf_fuel_economy');
    $cmf_car_owner = get_field('cmf_car_owner');
    $cmf_nft_owner = get_field('cmf_nft_owner');
    $cmf_date_verified = get_field('cmf_date_verified');
    $cmf_mileage_reported = get_field('cmf_mileage_reported');
    $cmf_vehicle_titled = get_field('cmf_vehicle_titled');
    $cmf_hand_title = get_field('cmf_hand_title');


    

    $vehical_specification = '';    
    if(!empty($cmf_year) && $default_year=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Year', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_year.'</span></li>';
    }

    if(!empty($cmf_make) && $default_make=='1'){ 
    $cmf_make_term_name = get_term( $cmf_make )->name;
    $make_url = "https://prixvo.com/car_models/" . urlencode(strtolower($cmf_make_term_name)) . "/";
    $vehical_specification .= '<li><span class="details-left">'.__('Make', 'ultimate-auction-pro-software').'</span><span class="details-right"><a href="'.$make_url.'" target="_blank">'.$cmf_make_term_name.'</a></span></li>'; 
}


    if(!empty($cmf_model) && $default_model=='1'){ 
        $cmf_model_term_name = get_term( $cmf_model )->name;
		$model_url = "https://prixvo.com/car_models/" . urlencode(strtolower($cmf_model_term_name)) . "/";
    $vehical_specification .= '<li><span class="details-left">'.__('Model', 'ultimate-auction-pro-software').'</span><span class="details-right"><a href="'.$model_url.'" target="_blank">'.$cmf_model_term_name.'</a></span></li>';
    }

    if(!empty($cmf_location_country) && $default_location_country=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Location', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_location_country.'</span></li>'; 
    }

    if(!empty($cmf_location_postal_code) && $default_location_postal_code=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Postal Code', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_location_postal_code.'</span></li>';
     }

    if(!empty($cmf_wheel_size_and_type) && $default_wheel_size_and_type=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Wheel Size and Type', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_wheel_size_and_type.'</span></li>'; 
    }

    if(!empty($cmf_tire_brand_and_model) && $default_tire_brand_and_model=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Tire Brand and Model', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_tire_brand_and_model.'</span></li>'; 
    }

    if(!empty($cmf_tire_size) && $default_tire_size=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Tire Size', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_tire_size.'</span></li>'; 
    }

    if(!empty($cmf_title_status) && $default_title_status=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Title Status', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_title_status.'</span></li>'; 
    }

    if(!empty($cmf_name_on_title) && $default_name_on_title=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Name on Title', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_name_on_title.'</span></li>'; 
    }

    if(!empty($cmf_state_on_title) && $default_state_on_title=='1'){  
        $vehical_specification .='<li><span class="details-left">'.__('State on Title', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_state_on_title.'</span></li>';
     }

    if(!empty($cmf_mileage) && $default_mileage=='1'){ 
		
        $vehical_specification .='<li><span class="details-left">'.__('Mileage', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_mileage.' '.$cmf_mileage_type.'</span></li>';
     }

    if(!empty($cmf_is_this_number_accurate) && $default_is_this_number_accurate=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Mileage Accurate', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_is_this_number_accurate.'</span></li>';
     }

    if(!empty($cmf_total_miles_accumulated_under_present_ownership) && $default_total_miles_accumulated_under_present_ownership=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Total Miles Accumulated Under Present Ownership', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_total_miles_accumulated_under_present_ownership.'</span></li>'; 
    }

    if(!empty($cmf_vin) && $default_vin=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('VIN', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_vin.'</span></li>'; 
    }

    if(!empty($cmf_body_style) && $default_body_style=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Body Style', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_body_style.'</span></li>';
    }

    if(!empty($cmf_engine) && $default_engine=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Engine', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_engine.'</span></li>'; 
    }

    if(!empty($cmf_drivetrain) && $default_drivetrain=='1'){  
        $vehical_specification .='<li><span class="details-left">'.__('Drivetrain', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_drivetrain.'</span></li>'; 
    }

    if(!empty($cmf_transmission) && $default_transmission=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Transmission', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_transmission.'</span></li>';
    }

    if(!empty($cmf_exterior_color) && $default_exterior_color=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Exterior Color', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_exterior_color.'</span></li>'; 
    }

    if(!empty($cmf_interior_color) && $default_interior_color=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Interior Color', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_interior_color.'</span></li>'; 
    }

    if(!empty($cmf_condition) && $default_condition=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Condition', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_condition.'</span></li>'; 
    }

    if(!empty($cmf_registration_date) && $default_registration_date=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Registration Date', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_registration_date.'</span></li>'; 
    }

    if(!empty($cmf_drive_type) && $default_drive_type=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Drive Type', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_drive_type.'</span></li>'; 
    }

    if(!empty($cmf_cylinders) && $default_cylinders=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Cylinders', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_cylinders.'</span></li>'; 
    }

    if(!empty($cmf_doors) && $default_doors=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Doors', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_doors.'</span></li>'; 
    }

    if(!empty($cmf_fuel_type) && $default_fuel_type=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Fuel Type', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_fuel_type.'</span></li>'; 
    }

    if(!empty($cmf_fuel_economy) && $default_fuel_economy=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Fuel Economy', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_fuel_economy.'</span></li>'; 
    }

    if(!empty($cmf_car_owner) && $default_vehicle_owner=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Vehicle Owner', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_car_owner.'</span></li>'; 
    }

    if(!empty($cmf_nft_owner) && $default_nft_owner=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('NFT Owner', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_nft_owner.'</span></li>'; 
    }

    if(!empty($cmf_date_verified) && $default_date_verified=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Date Verified', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_date_verified.'</span></li>'; 
    }

    if(!empty($cmf_mileage_reported) && $default_mileage_reported=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Mileage Reported', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_mileage_reported.'</span></li>'; 
    }

    if(!empty($cmf_vehicle_titled) && $default_is_the_vehicle_titled_in_your_name=='1'){  
        $vehical_specification .='<li><span class="details-left">'.__('Vehicle Titled in Sellers Name', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_vehicle_titled.'</span></li>'; 
    }

    if(!empty($cmf_hand_title) && $default_do_you_have_the_title_in_hand=='1'){ 
        $vehical_specification .='<li><span class="details-left">'.__('Title in Hand', 'ultimate-auction-pro-software').'</span><span class="details-right">'.$cmf_hand_title.'</span></li>'; 
    }

    $uat_custom_enable = get_option('uat_custom_enable', 'no');
    if ($uat_custom_enable == "yes") {
        global $wpdb;
        global $product;
        $product_id = $product->get_id();
        $query = "SELECT meta_key FROM " . $wpdb->prefix . "postmeta where post_id='" . $product_id . "'  AND meta_key LIKE   'uat_custom_field_%' AND meta_value IS NOT NULL AND meta_value != ''";
        $result = $wpdb->get_results($query);
        $count_rows = $wpdb->num_rows;
        if ($count_rows > 0) {

            $final_array = [];
            foreach ($result as $field_name) {
                $fields = get_field_object($field_name->meta_key);
                if (is_array($fields)) {

                    if (!empty($fields)) {
                        $one_array = [];
                        $one_array['name'] = $fields['label'];
                        $field_value = $fields['value'];
                        if ($fields['type'] == 'select') {
                            $field_value = $selected_value = $fields['choices'][$field_value];
                        }
                        $one_array['value'] = $field_value;
                    }
                    $final_array[] = $one_array;
                }
            }
            $data_count = count($final_array);

            $uat_custom_fields_display_tabel =  get_option('uat_custom_fields_display_tabel', 2);
            for ($i = 0; $i < $uat_custom_fields_display_tabel; $i++) {
                for ($j = $i; $j < $data_count; $j += $uat_custom_fields_display_tabel) {
                    $value = $final_array[$j]['value'];
                    if (!empty($value)) {
                        $vehical_specification .='<li><span class="details-left">'.$final_array[$j]['name'].'</span><span class="details-right">'.$final_array[$j]['value'].'</span></li>'; 
                    }
                }
            }

        }
    }


?>


<?php if(!empty($vehical_specification)) { ?>
<div class="car-info-tab">
    <div class="car-info-box">
        
            

        
        <ul class="Car_details">
            
            <?php echo $vehical_specification; ?>
           
        </ul>
        
    </div>
</div>
<?php } ?>