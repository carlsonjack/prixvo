<?php
if( function_exists('acf_add_local_field_group') ){


	$default_exterior_images = get_option( 'options_default_exterior_images','1');
	$default_interior_images = get_option( 'options_default_interior_images','1');;
	$default_mechanical_images = get_option( 'options_default_mechanical_images','1');
	$default_other_images = get_option( 'options_default_other_images','1');
	$default_docs_images = get_option( 'options_default_docs_images','1');
	$default_videos_gallery = get_option( 'options_default_videos_gallery','1');
	$default_upload_carfax_history_report = get_option( 'options_default_upload_carfax_history_report','1');
	$default_vehicle_history_report = get_option( 'options_default_vehicle_history_report','1');
	$default_specification_summary = get_option( 'options_default_specification_summary','1');
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
	$default_vehicle_highlights = get_option( 'options_default_vehicle_highlights','1');
	$default_vehicle_equipment = get_option( 'options_default_vehicle_equipment','1');
	$default_vehicle_modifications = get_option( 'options_default_vehicle_modifications','1');
	$default_dealer_notes = get_option( 'options_default_dealer_notes','1');
	$default_vehicle_known_issues = get_option( 'options_default_vehicle_known_issues','1');
	$default_vehicle_history_report = get_option( 'options_default_vehicle_history_report','1');
	
	/*$default_seller_name = get_option( 'default_seller_name' );
	$default_details_public_or_private = get_option( 'default_details_public_or_private' );
	$default_details_company_logo = get_option( 'default_details_company_logo' );
	$default_contact_details = get_option( 'default_contact_details' );
	$default_location_map = get_option( 'default_location_map' );*/


$acf_fields = array();

if($default_exterior_images==1){

		$exterior_images_tab = array(
					'key' => 'exterior_images_tab',
					'label' => __("Exterior Images", 'ultimate-auction-pro-software'),
					'name' => 'exterior_images_tab',
					'type' => 'tab',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'placement' => 'left',
					'endpoint' => 0,
				);
		$exterior_images = array(
					'key' => 'exterior_images',
					'label' => __("Exterior Images", 'ultimate-auction-pro-software'),
					'name' => 'exterior_images',
					'type' => 'gallery',
					'instructions' => 'Add Exterior Images',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'medium',
					'insert' => 'append',
					'library' => 'all',
					'min' => '',
					'max' => '',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
					'wpml_cf_preferences' => 1,
				);
		$acf_fields[] = $exterior_images_tab;
		$acf_fields[] = $exterior_images;				
}

if($default_interior_images==1){

	$interior_images_tab = array(
							'key' => 'interior_images_tab',
							'label' => __("Interior Images", 'ultimate-auction-pro-software'),
							'name' => 'interior_images_tab',
							'type' => 'tab',
							'instructions' => '',
							'required' => 0,
							'conditional_logic' => 0,
							'wrapper' => array(
								'width' => '',
								'class' => '',
								'id' => '',
							),
							'placement' => 'left',
							'endpoint' => 0,
						);
	$interior_images = array(
						'key' => 'field_6231e50d8661e',
						'label' => __("Interior Images", 'ultimate-auction-pro-software'),
						'name' => 'interior_images',
						'type' => 'gallery',
						'instructions' => 'Add Interior Images',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'wpml_cf_preferences' => 1,
						'return_format' => 'id',
						'preview_size' => 'medium',
						'insert' => 'append',
						'library' => 'all',
						'min' => '',
						'max' => '',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					);
	$acf_fields[] = $interior_images_tab;
	$acf_fields[] = $interior_images;				
}


if($default_mechanical_images==1){
	$mechanical_images_tab = array(
                            'key' => 'mechanical_images_tab',
                            'label' => __("Mechanical Images", 'ultimate-auction-pro-software'),
                            'name' => 'mechanical_images_tab',
                            'type' => 'tab',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'placement' => 'left',
                            'endpoint' => 0,
                        );
	$mechanical_images = array(
                        'key' => 'mechanical_images',
                        'label' => __("Mechanical Images", 'ultimate-auction-pro-software'),
                        'name' => 'mechanical_images',
                        'type' => 'gallery',
                        'instructions' => 'Add Mechanical Images',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 1,
                        'return_format' => 'id',
                        'preview_size' => 'medium',
                        'insert' => 'append',
                        'library' => 'all',
                        'min' => '',
                        'max' => '',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    );
	$acf_fields[] = $mechanical_images_tab;
	$acf_fields[] = $mechanical_images;				
}

if($default_other_images==1){
    $other_images_tab = array(
                'key' => 'other_images_tab',
                'label' => __("Other Images", 'ultimate-auction-pro-software'),
                'name' => 'other_images_tab',
                'type' => 'tab',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'placement' => 'left',
                'endpoint' => 0,
        );
	$other_images = array(
                    'key' => 'field_6231e55586620',
                    'label' => __("Other Images", 'ultimate-auction-pro-software'),
                    'name' => 'other_images',
                    'type' => 'gallery',
                    'instructions' => 'Add Other Images',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 1,
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                    'min' => '',
                    'max' => '',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                );
	$acf_fields[] = $other_images_tab;
	$acf_fields[] = $other_images;				
}



if($default_docs_images==1){
    $docs_images_tab = array(
                            'key' => 'docs_images_tab',
                            'label' => __("Docs Images", 'ultimate-auction-pro-software'),
                            'name' => 'docs_images_tab',
                            'type' => 'tab',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'placement' => 'left',
                            'endpoint' => 0,
                        );
                $docs_images = array(
                    'key' => 'field_6231e56986621',
                    'label' => __("Docs Images", 'ultimate-auction-pro-software'),
                    'name' => 'docs_images',
                    'type' => 'gallery',
                    'instructions' => 'Add Docs Images',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 1,
                    'return_format' => 'id',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                    'min' => '',
                    'max' => '',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                );
	$acf_fields[] = $docs_images_tab;
	$acf_fields[] = $docs_images;				
}

if($default_videos_gallery=='1'){

$cmf_videos_tab = array(
	'key' => 'cmf_videos_tab',
	'label' => __("Videos", 'ultimate-auction-pro-software'),
	'name' => 'cmf_videos_tab',
	'type' => 'tab',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'placement' => 'top',
	'endpoint' => 0,
);

$cmf_videos_re =	array(
		'key' => 'cmf_videos_re',
		'label' => __("Video", 'ultimate-auction-pro-software'),
		'name' => 'cmf_videos_re',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => 0,
		'max' => 0,
		'layout' => 'table',
		'button_label' => '',
		'sub_fields' => array(
			array(
				'key' => 'cmf_videos',
				'label' => __("Video", 'ultimate-auction-pro-software'),
				'name' => 'cmf_videos',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'width' => '',
				'height' => '',
			),
		),
	);
	$acf_fields[] = $cmf_videos_tab;
	$acf_fields[] = $cmf_videos_re;				
}


if( function_exists('acf_add_local_field_group') ):
if(!empty($acf_fields)){ 
	acf_add_local_field_group(array(
		'key' => 'group_6231de920dd49',
		'title' => 'Media',
		'fields' => $acf_fields,
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'wpml_field_group_language' => 'en',
	));
}	





$acf_fields_vehicle_specification = array();

$acf_fields_vehicle_specification[] = array(
	'key' => 'cmf_vehicle_specification',
	'label' => __("Vehicle Specification", 'ultimate-auction-pro-software'),
	'name' => 'cmf_vehicle_specification',
	'type' => 'tab',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'placement' => 'left',
	'endpoint' => 0,
);

if($default_specification_summary==1){ 
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_specification',
		'label' => __("Specification Summary", 'ultimate-auction-pro-software'),
		'name' => 'cmf_specification',
		'type' => 'textarea',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'maxlength' => '',
		'rows' => '',
		'new_lines' => '',
	);
}
if($default_year==1){ 
$acf_fields_vehicle_specification[] =	array(
		'key' => 'cmf_year',
		'label' => __("Year", 'ultimate-auction-pro-software'),
		'name' => 'cmf_year',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_make==1){
$acf_fields_vehicle_specification[] =	array(
		'key' => 'cmf_make',
		'label' => __("Make", 'ultimate-auction-pro-software'),
		'name' => 'cmf_make',
		'type' => 'taxonomy',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'taxonomy' => 'car_models',
		'field_type' => 'select',
		'allow_null' => 0,
		'add_term' => 0,
		'save_terms' => 1,
		'load_terms' => 0,
		'return_format' => 'id',
		'multiple' => 0,
		'choices' => array(
			array(
			),
			array(
			),
		),
	);
}
if($default_model==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_model_new',
		'label' => __("Model", 'ultimate-auction-pro-software'),
		'name' => 'cmf_model_new',
		'type' => 'taxonomy',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'taxonomy' => 'car_models',
		'field_type' => 'select',
		'allow_null' => 0,
		'add_term' => 0,
		'save_terms' => 1,
		'load_terms' => 0,
		'return_format' => 'id',
		'multiple' => 0,
		'choices' => array(
			array(
			),
			array(
			),
		),
	);
}
if($default_location_country==1){
$acf_fields_vehicle_specification[] = 	array(
		'key' => 'cmf_location_country',
		'label' => __("Location Country", 'ultimate-auction-pro-software'),
		'name' => 'cmf_location_country',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_location_postal_code==1){
$acf_fields_vehicle_specification[] =	array(
		'key' => 'cmf_location_postal_code',
		'label' => __("Location Postal Code", 'ultimate-auction-pro-software'),
		'name' => 'cmf_location_postal_code',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_wheel_size_and_type==1){
$acf_fields_vehicle_specification[] = 	array(
		'key' => 'cmf_wheel_size_and_type',
		'label' => __("Wheel Size and Type", 'ultimate-auction-pro-software'),
		'name' => 'cmf_wheel_size_and_type',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_tire_brand_and_model==1){	
$acf_fields_vehicle_specification[]  =	array(
		'key' => 'cmf_tire_brand_and_model',
		'label' => __("Tire Brand and Model", 'ultimate-auction-pro-software'),
		'name' => 'cmf_tire_brand_and_model',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_tire_size==1){	
$acf_fields_vehicle_specification[] =	array(
		'key' => 'cmf_tire_size',
		'label' => __("Tire Size", 'ultimate-auction-pro-software'),
		'name' => 'cmf_tire_size',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_title_status==1){	
$acf_fields_vehicle_specification[] =	array(
		'key' => 'cmf_title_status',
		'label' => 'Title Status',
		'name' => 'cmf_title_status',
		'aria-label' => '',
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'clean' => 'Clean',
			'rebuilt' => 'Rebuilt',
			'salvage' => 'Salvage',
			'branded' => 'Branded',
			'other' => 'Other',
		),
		'default_value' => false,
		'return_format' => 'value',
		'multiple' => 0,
		'allow_null' => 0,
		'ui' => 0,
		'ajax' => 0,
		'placeholder' => '',
	);
}
if($default_name_on_title==1){

$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_name_on_title',
		'label' => 'Name on Title',
		'name' => 'cmf_name_on_title',
		'aria-label' => '',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'maxlength' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	);

}
if($default_state_on_title==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_state_on_title',
		'label' => 'State on Title',
		'name' => 'cmf_state_on_title',
		'aria-label' => '',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'maxlength' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	);
}
if($default_mileage==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_mileage',
		'label' => 'Current mileage on odometer',
		'name' => 'cmf_mileage',
		'aria-label' => '',
		'type' => 'number',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'maxlength' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	);
	
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_mileage_type',
		'label' => 'Current',
		'name' => 'cmf_mileage_type',
		'aria-label' => '',
		'type' => 'select',
		'instructions' => '',
		'choices' => array(
			'km' => 'KM',
			'MI' => 'MI',
		),
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'maxlength' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	);
}

if($default_is_this_number_accurate==1){	
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_is_this_number_accurate',
		'label' => 'Is this number accurate?',
		'name' => 'cmf_is_this_number_accurate',
		'aria-label' => '',
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'Yes' => 'Yes',
			'No' => 'No',
		),
		'default_value' => false,
		'return_format' => 'value',
		'multiple' => 0,
		'allow_null' => 0,
		'ui' => 0,
		'ajax' => 0,
		'placeholder' => '',
	);
}
if($default_total_miles_accumulated_under_present_ownership==1){	
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_total_miles_accumulated_under_present_ownership',
		'label' => 'Total Miles Accumulated Under Present Ownership?',
		'name' => 'cmf_total_miles_accumulated_under_present_ownership',
		'aria-label' => '',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'maxlength' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
	);
}
if($default_vin==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vin',
		'label' => __("VIN", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vin',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_body_style==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_body_style',
		'label' => __("Body Style", 'ultimate-auction-pro-software'),
		'name' => 'cmf_body_style',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_engine==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_engine',
		'label' => __("Engine", 'ultimate-auction-pro-software'),
		'name' => 'cmf_engine',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_drivetrain==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_drivetrain',
		'label' => __("Drivetrain", 'ultimate-auction-pro-software'),
		'name' => 'cmf_drivetrain',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_transmission==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_transmission',
		'label' => __("Transmission", 'ultimate-auction-pro-software'),
		'name' => 'cmf_transmission',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_exterior_color==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_exterior_color',
		'label' => __("Exterior Color", 'ultimate-auction-pro-software'),
		'name' => 'cmf_exterior_color',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_interior_color==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_interior_color',
		'label' => __("Interior Color", 'ultimate-auction-pro-software'),
		'name' => 'cmf_interior_color',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_condition==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_condition',
		'label' => __("Condition", 'ultimate-auction-pro-software'),
		'name' => 'cmf_condition',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_registration_date==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_registration_date',
		'label' => __("Registration date", 'ultimate-auction-pro-software'),
		'name' => 'cmf_registration_date',
		'type' => 'date_picker',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'display_format' => 'd/m/Y',
		'return_format' => 'd/m/Y',
		'first_day' => 1,
	);
}
if($default_drive_type==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_drive_type',
		'label' => __("Drive Type", 'ultimate-auction-pro-software'),
		'name' => 'cmf_drive_type',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_cylinders==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_cylinders',
		'label' => __("Cylinders", 'ultimate-auction-pro-software'),
		'name' => 'cmf_cylinders',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_doors==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_doors',
		'label' => __("Doors", 'ultimate-auction-pro-software'),
		'name' => 'cmf_doors',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_fuel_type==1){

$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_fuel_type',
		'label' => __("Fuel type", 'ultimate-auction-pro-software'),
		'name' => 'cmf_fuel_type',
		'aria-label' => '',
		'type' => 'select',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'gas' => 'Gasoline',
			'diesel' => 'Diesel',
			'hybrid' => 'Hybrid',
			'electric' => 'Electric',
			'patrol' => 'Patrol',
		),
		'default_value' => false,
		'return_format' => 'value',
		'multiple' => 0,
		'allow_null' => 0,
		'ui' => 0,
		'ajax' => 0,
		'placeholder' => '',
	);
}
if($default_fuel_economy==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_fuel_economy',
		'label' => __("Fuel economy", 'ultimate-auction-pro-software'),
		'name' => 'cmf_fuel_economy',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_vehicle_owner==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_car_owner',
		'label' => __("Vehicle Owner", 'ultimate-auction-pro-software'),
		'name' => 'cmf_car_owner',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_nft_owner==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_nft_owner',
		'label' => __("NFT Owner", 'ultimate-auction-pro-software'),
		'name' => 'cmf_nft_owner',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_date_verified==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_date_verified',
		'label' => __("Date Verified", 'ultimate-auction-pro-software'),
		'name' => 'cmf_date_verified',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}
if($default_mileage_reported==1){
$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_mileage_reported',
		'label' => __("Mileage Reported", 'ultimate-auction-pro-software'),
		'name' => 'cmf_mileage_reported',
		'type' => 'text',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	);
}


if($default_is_the_vehicle_titled_in_your_name==1 || $default_do_you_have_the_title_in_hand==1){
	
		
	$acf_fields_vehicle_specification[] =array(
			'key' => 'cmf_title_information',
			'label' => __("Title Information", 'ultimate-auction-pro-software'),
			'name' => 'cmf_title_information',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		);

	if($default_is_the_vehicle_titled_in_your_name==1){
		
		$acf_fields_vehicle_specification[] =array(
			'key' => 'cmf_vehicle_titled',
			'label' => __("Is the vehicle titled in your name?", 'ultimate-auction-pro-software'),
			'name' => 'cmf_vehicle_titled',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		);
		
	}

	if($default_do_you_have_the_title_in_hand==1){

		$acf_fields_vehicle_specification[] = array(
			'key' => 'cmf_hand_title',
			'label' => __("Do you have the title in hand?", 'ultimate-auction-pro-software'),
			'name' => 'cmf_hand_title',
			'type' => 'radio',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => 'Yes',
				'no' => 'No',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
			'save_other_choice' => 0,
		);
	}
}

if($default_vehicle_highlights==1){
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vehicle_highlights_tab',
		'label' => __("Vehicle Highlights", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vehicle_highlights_tab',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vehicle_highlights',
		'label' => __("Vehicle Highlights", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vehicle_highlights',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 1,
		'delay' => 0,
	);
}
if($default_vehicle_equipment==1){ 
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vehicle_equipment',
		'label' => __("Vehicle Equipment", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vehicle_equipment',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_equipment',
		'label' => __("Equipment", 'ultimate-auction-pro-software'),
		'name' => 'cmf_equipment',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 1,
		'delay' => 0,
	);
}


if($default_vehicle_modifications==1){ 
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vehicle_modifications',
		'label' => __("Vehicle Modifications", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vehicle_modifications',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_modifications',
		'label' => __("Modifications", 'ultimate-auction-pro-software'),
		'name' => 'cmf_modifications',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 1,
		'delay' => 0,
	);
}
if($default_vehicle_known_issues==1){ 
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_vehicle_known_issues',
		'label' => __("Vehicle Known Issues", 'ultimate-auction-pro-software'),
		'name' => 'cmf_vehicle_known_issues',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_known_issues',
		'label' => __("Known Issues", 'ultimate-auction-pro-software'),
		'name' => 'cmf_known_issues',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 1,
		'delay' => 0,
	);
}

if($default_dealer_notes==1){ 
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_dealer_notes_tab',
		'label' => __("Dealer Notes", 'ultimate-auction-pro-software'),
		'name' => 'cmf_dealer_notes_tab',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] = array(
		'key' => 'cmf_dealer_notes',
		'label' => __("Notes", 'ultimate-auction-pro-software'),
		'name' => 'cmf_dealer_notes',
		'type' => 'wysiwyg',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'default_value' => '',
		'tabs' => 'all',
		'toolbar' => 'full',
		'media_upload' => 1,
		'delay' => 0,
	);
}

if($default_vehicle_history_report==1){ 
	$acf_fields_vehicle_specification[] = array(
		'key' => 'field_61431a2431556',
		'label' => __("Vehicle History Report", 'ultimate-auction-pro-software'),
		'name' => '',
		'type' => 'tab',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'placement' => 'top',
		'endpoint' => 0,
	);
	$acf_fields_vehicle_specification[] =array(
		'key' => 'attached_report',
		'label' => __("Attached Report", 'ultimate-auction-pro-software'),
		'name' => 'attached_report',
		'type' => 'repeater',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => 0,
		'max' => 0,
		'layout' => 'table',
		'button_label' => '',
		'sub_fields' => array(
			array(
				'key' => 'file_history_report_label',
				'label' => __("Label", 'ultimate-auction-pro-software'),
				'name' => 'file_history_report_label',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'file_history_report',
				'label' => __("Add File", 'ultimate-auction-pro-software'),
				'name' => 'file_history_report',
				'type' => 'file',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_size' => '',
				'max_size' => '',
				'mime_types' => '',
			),
		),
	);
}

acf_add_local_field_group(array(
	'key' => 'group_60a7fb220edfe',
	'title' => 'Vehicle Information',
	'fields' => array_merge( 
		$acf_fields_vehicle_specification,
		array(
			/*array(
				'key' => 'cmf_sample_photo',
				'label' => __("Sample Photo", 'ultimate-auction-pro-software'),
				'name' => 'cmf_sample_photo',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'cmf_sample_photo_exterior',
				'label' => __("Exterior", 'ultimate-auction-pro-software'),
				'name' => 'cmf_sample_photo_exterior',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'cmf_sample_photo_interior',
				'label' => __("Interior", 'ultimate-auction-pro-software'),
				'name' => 'cmf_sample_photo_interior',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			array(
				'key' => 'cmf_professional_photo',
				'label' => __("Do you have professional photos? (yes/no/willing to hire)", 'ultimate-auction-pro-software'),
				'name' => 'cmf_professional_photo',
				'type' => 'radio',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'yes' => 'Yes',
					'no' => 'No',
					'hire' => 'Willing to hire',
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
			*/
			/*array(
				'key' => 'cmf_optional_files',
				'label' => __("Optional Files", 'ultimate-auction-pro-software'),
				'name' => 'cmf_optional_files',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'cmf_upload_carfax',
				'label' => __("Upload Carfax History Report", 'ultimate-auction-pro-software'),
				'name' => 'cmf_upload_carfax',
				'type' => 'radio',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'yes' => 'Yes',
					'no' => 'No',
				),
				'allow_null' => 0,
				'other_choice' => 0,
				'default_value' => '',
				'layout' => 'vertical',
				'return_format' => 'value',
				'save_other_choice' => 0,
			),
			array(
				'key' => 'cmf_files',
				'label' => __("Files", 'ultimate-auction-pro-software'),
				'name' => 'cmf_files',
				'type' => 'gallery',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'min' => '',
				'max' => '',
				'insert' => 'append',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			),
			*/
			
			
			array(
				'key' => 'field_61431a2431556458',
				'label' => __("Seller Details", 'ultimate-auction-pro-software'),
				'name' => '',
				'type' => 'tab',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'placement' => 'top',
				'endpoint' => 0,
			),
			array(
				'key' => 'field_64802e5d41e4d',
				'label' => 'Seller Name',
				'name' => 'auction_seller_name',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),

			/*array(
				'key' => 'field_64802f4941e50',
				'label' => 'Company Logo',
				'name' => 'auction_company_logo',
				'aria-label' => '',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'return_format' => 'array',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
				'preview_size' => 'medium',
			),
			array(
				'key' => 'field_64802f6441e51',
				'label' => 'Seller detail page URL',
				'name' => 'link_to_seller_detail_page',
				'aria-label' => '',
				'type' => 'url',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
			),*/
			array(
				'key' => 'seller_email_id',
				'label' => 'Email',
				'name' => 'seller_email_id',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'rows' => '',
				'placeholder' => '',
				'new_lines' => '',
			),
			array(
				'key' => 'seller_phone_number',
				'label' => 'Phone Number',
				'name' => 'seller_phone_number',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'rows' => '',
				'placeholder' => '',
				'new_lines' => '',
			),
			array(
				'key' => 'field_64802e6f41e4e',
				'label' => 'Additional Details',
				'name' => 'contact_details',
				'aria-label' => '',
				'type' => 'textarea',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'rows' => '',
				'placeholder' => '',
				'new_lines' => '',
			),
			/*array(
				'key' => 'field_64802e8841e4f',
				'label' => 'Details Public or Private',
				'name' => 'details_public_or_privet',
				'aria-label' => '',
				'type' => 'button_group',
				'instructions' => 'If you marked as "public," the contact details will be displayed on the product details page.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'Public' => 'Public',
					'Private' => 'Private',
				),
				'default_value' => 'Private',
				'return_format' => 'value',
				'allow_null' => 0,
				'layout' => 'horizontal',
			),*/

		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'product',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
endif;

}