<?php
if( function_exists('acf_add_local_field_group') ){
acf_add_local_field_group(array(
	'key' => 'group_uat_car_home_page_layout',
	'title' => '<span class="dashicons dashicons-layout"></span> Page Layout',
	'fields' => array(
		array(
			'key' => 'car_page_tmp_page_layout',
			'label' => __("Page Layout", 'ultimate-auction-theme'),
			'name' => 'car_page_tmp_page_layout',
			'type' => 'button_group',
			'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '100',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'full-width' => __("Full Width Content", 'ultimate-auction-theme'),
				'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-theme'),
				'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-theme'),
			),
			'allow_null' => 1,
			'default_value' => 'full-width',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),		
		array(
			'key' => 'car_page_tmp_perpage',
			'label' => __("Number of Car to show per page", 'ultimate-auction-theme'),
			'name' => 'car_page_tmp_perpage',
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
			'key' => 'car_page_tmp_pagination_type',
			'label' => __("Pagination Type", 'ultimate-auction-theme'),
			'name' => 'car_page_tmp_pagination_type',
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
		array(
			'key' => 'simple_heading',
			'label' => __("Manage Sidebar Fields from the Following Options", 'ultimate-auction-theme'),
			'name' => 'simple_heading',
			'type' => 'group',
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '100',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'allow_null' => 1,
			'layout' => 'horizontal',
		),
		array(
			'key' => 'car_page_sidebar_no_auctions',
			'label' => __("Number of Car to show in sidebar", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_no_auctions',
			'type' => 'range',
			'instructions' => __("Controls the number of Car that display in sidebar for Car List page.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
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
			'key' => 'car_page_sidebar_title',
			'label' => __("Sidebar Display Title", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_title',
			'type' => 'text',
			'instructions' => __("Sidebar Display Title for Car List page.", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => __("New Listings", 'ultimate-auction-theme'),
		),
		
		array(
			'key' => 'car_page_sidebar_car_show_title',
			'label' => __("Display the Car's Title?", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_car_show_title',
			'type' => 'button_group',
			'instructions' => __("Would you like to display the title of the car?", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => 'uat_button_group',
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
		),
		array(
			'key' => 'car_page_sidebar_car_show_subtitle',
			'label' => __("Display the Car's Subtitle?", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_car_show_subtitle',
			'type' => 'button_group',
			'instructions' => __("Would you like to display the subtitle of the car?", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => 'uat_button_group',
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
		),
		array(
			'key' => 'car_page_sidebar_car_show_watchlist',
			'label' => __("Display a watchlist icon?", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_car_show_watchlist',
			'type' => 'button_group',
			'instructions' => __("Would you like to display a watchlist icon for each product?", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => 'uat_button_group',
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
		),
		array(
			'key' => 'car_page_sidebar_car_show_highlights',
			'label' => __("Display the Car's Highlights?", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_car_show_highlights',
			'type' => 'button_group',
			'instructions' => __("Would you like to display the Highlights of the car?", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => 'uat_button_group',
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
		),
		array(
			'key' => 'car_page_sidebar_car_show_location',
			'label' => __("Display the Car's Location?", 'ultimate-auction-theme'),
			'name' => 'car_page_sidebar_car_show_location',
			'type' => 'button_group',
			'instructions' => __("Would you like to display the Location of the car?", 'ultimate-auction-theme'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'car_page_tmp_page_layout',
						'operator' => '!=',
						'value' => 'full-width',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => 'uat_button_group',
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
		),
	),			
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'front-page.php',
			),
		),
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => array(
	//	0 => 'the_content',
	),
	'active' => true,
	'description' => '',
));
}