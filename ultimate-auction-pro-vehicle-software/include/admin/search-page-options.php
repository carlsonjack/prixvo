<?php

function add_custom_fields_to_filter(){
	
	$filter_fields =  get_all_filters();
	$fields_array = [];
	if(count($filter_fields) > 0)
	{
		if(!empty($filter_fields)){
			foreach($filter_fields as $field){
				if(empty($field)) { continue; }
				
				$one_field = [];
				$sub_fields = [];

				$filed_key = $field['key'];
				$filed_slug = $field['slug'];
				$filed_name = $field['label'];
				$field_input_type = $field['input_type'];
				$field_type = $field['type'];

				$sub_fields[] = array(
					'key' => 'clf_title_'.$filed_slug,
					'label' => __("Display Title", 'ultimate-auction-theme'),
					'name' => 'clf_title_'.$filed_slug,
					'type' => 'text',
					'instructions' => __("Enter title to show this field in filters.", 'ultimate-auction-theme'),
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '25',
						'class' => '',
						'id' => '',
					),
					'default_value' => $filed_name,
					'layout' => 'horizontal',
					'return_format' => 'value',
				);
				$sub_fields[] = array(
										'key' => 'clf_show_'.$filed_slug,
										'label' => __("Display this field in filters?", 'ultimate-auction-theme'),
										'name' => 'clf_show_'.$filed_slug,
										'type' => 'button_group',
										'instructions' => __('If you want this field to appear in filters, choose "Yes".', 'ultimate-auction-theme'),
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '25',
											'class' => '',
											'id' => '',
										),
										'choices' => array(
											'yes' => __("Yes", 'ultimate-auction-theme'),
											'no' => __("No", 'ultimate-auction-theme'),
										),
										'allow_null' => 1,
										'default_value' => 'yes',
										'layout' => 'horizontal',
										'return_format' => 'value',
									);
				$input_type_choices = 	array('text' => __("Text", 'ultimate-auction-theme'));			
				$number_input_type_choices = 	array('checkbox' => __("Checkboxs", 'ultimate-auction-theme'));			
				if($field_input_type == 'number'){
					$input_type_choices['number'] = __("Number", 'ultimate-auction-theme');
					$number_input_type_choices['range_slider'] = __("Number Range slider", 'ultimate-auction-theme');			
				}
				if(count($input_type_choices) > 1){
					$sub_fields[] = array(
											'key' => 'clf_input_type_'.$filed_slug,
											'label' => __("Input type", 'ultimate-auction-theme'),
											'name' => 'clf_input_type_'.$filed_slug,
											'type' => 'button_group',
											'instructions' => __("Select which type of data added in field this. Text or Number", 'ultimate-auction-theme'),
											'required' => 0,
											'conditional_logic' => 0,
											'wrapper' => array(
												'width' => '25',
												'class' => '',
												'id' => '',
											),
											'choices' => $input_type_choices,
											'allow_null' => 1,
											'default_value' => $field_input_type,
											'layout' => 'horizontal',
											'return_format' => 'value',
										);
					
					$sub_fields[] = array(
						'key' => 'clf_number_input_type_'.$filed_slug,
						'label' => __("Filter options type", 'ultimate-auction-theme'),
						'name' => 'clf_number_input_type_'.$filed_slug,
						'type' => 'button_group',
						'instructions' => __("Select which type of data added in field this. Text or Number", 'ultimate-auction-theme'),
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'clf_input_type_'.$filed_slug,
									'operator' => '==',
									'value' => 'number',
								),
							),
						),
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'choices' => $number_input_type_choices,
						'allow_null' => 1,
						'default_value' => 'checkbox',
						'layout' => 'horizontal',
						'return_format' => 'value',
					);
					$cur_symbole = get_woocommerce_currency_symbol();
					$sub_fields[] = array(
						'key' => 'clf_slider_text_'.$filed_slug,
						'label' => __("Range slider text", 'ultimate-auction-theme'),
						'name' => 'clf_slider_text_'.$filed_slug,
						'type' => 'text',
						'instructions' => __('Please input the text to be displayed alongside the range slider in the filters. For example, if you want to display a range from $100 to $1000, you can enter "$" as the text.', 'ultimate-auction-theme'),
						'required' => 0,
						'conditional_logic' => array(
							array(
								array(
									'field' => 'clf_number_input_type_'.$filed_slug,
									'operator' => '==',
									'value' => 'range_slider',
								),
							),
						),
						'wrapper' => array(
							'width' => '25',
							'class' => '',
							'id' => '',
						),
						'default_value' => $cur_symbole,
						'layout' => 'horizontal',
						'return_format' => 'value',
					);
				}
				$one_field = array (
					'key' => $filed_key,
					'name' => $filed_slug,
					'label' => $filed_name,
					'display' => 'block',
					'sub_fields' => $sub_fields,
				);
				$fields_array[] = $one_field;
			}
		}
	}
	return $fields_array;
}

if( function_exists('acf_add_local_field_group') ){
$custom_fields_array = add_custom_fields_to_filter();


acf_add_local_field_group(array (
    'key' => 'car_filers_group',
    'title' => __("Car Filter options", 'ultimate-auction-theme'),
    'fields' => array (
		array(
			'key' => 'car_filers_options_show_expired',
			'label' => __("Show expired auctions?", 'ultimate-auction-theme'),
			'name' => 'car_filers_options_show_expired',
			'type' => 'button_group',
			'instructions' => __('If you want expired auctions appear in filters, choose "Yes".', 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'yes' => __("Yes", 'ultimate-auction-theme'),
				'no' => __("No", 'ultimate-auction-theme'),
			),
			'allow_null' => 1,
			'default_value' => 'no',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
        array (
            'key' => 'car_filers_options',
            'label' => 'Filter Options',
            'name' => 'car_filers_options',
            'type' => 'flexible_content',
            'instructions' => __("Customize your filters by adding new fields with the 'Add Filter' button. You can drag and drop the fields to rearrange their order. Choose from a list of default fields or added custom fields with a title that will be displayed on the front-end filter. Make your product search easier and more efficient with these customizable filters.", 'ultimate-auction-theme'),
            'wrapper' => array (
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'button_label' =>  __("Add Filter", 'ultimate-auction-theme'),
            'min' => '',
            'max' => '',
            'layouts' =>$custom_fields_array,
        ),
    ),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-templates/search-page-template.php',
			),
		),
	),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => 1,
    'description' => '',
));
acf_add_local_field_group(array(
	'key' => 'group_uat_car_list_page_layout',
	'title' => '<span class="dashicons dashicons-layout"></span> Page Layout',
	'fields' => array(
		array(
			'key' => 'car_list_page_tmp_page_layout',
			'label' => __("Page Layout", 'ultimate-auction-theme'),
			'name' => 'car_list_page_tmp_page_layout',
			'type' => 'button_group',
			'instructions' => __("Select page layout. Default is left width.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				// 'full-width' => __("Full Width Content", 'ultimate-auction-theme'),
				'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-theme'),
				'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-theme'),
			),
			'allow_null' => 1,
			'default_value' => 'left-width',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),		
		array(
			'key' => 'car_list_page_tmp_perpage',
			'label' => __("Number of Car to show per page", 'ultimate-auction-theme'),
			'name' => 'car_list_page_tmp_perpage',
			'type' => 'range',
			'instructions' => __("Controls the number of Car that display per page for Car List page. Set to -1 to display all.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 12,
			'min' => -1,
			'max' => '',
			'step' => '',
			'prepend' => '',
			'append' => __("Default is 12", 'ultimate-auction-theme'),
		),
		array(
			'key' => 'car_list_page_tmp_pagination_type',
			'label' => __("Pagination Type", 'ultimate-auction-theme'),
			'name' => 'car_list_page_tmp_pagination_type',
			'type' => 'button_group',
			'instructions' => __("Controls the pagination type.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'infinite-scroll' => __("Infinite Scroll", 'ultimate-auction-theme'),
				'load-more' => __("Load More Button", 'ultimate-auction-theme'),
			),
			'allow_null' => 1,
			'default_value' => 'load-more',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		
	),			
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-templates/search-page-template.php',
			),
		),
	),
	'menu_order' => 2,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
		0 => 'the_content',
	),
	'active' => true,
	'description' => '',
));

}