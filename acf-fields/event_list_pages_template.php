<?php
acf_add_local_field_group(array(
	'key' => 'group_uat_event_page_template',
	'title' => '<span class="dashicons dashicons-layout"></span> Page Layout',
	'fields' => array(
		array(
			'key' => 'event_page_tmp_page_layout',
			'label' => __("Page Layout", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_page_layout',
			'type' => 'button_group',
			'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'full-width' => __("Full Width Content", 'ultimate-auction-pro-software'),
				'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-pro-software'),
				'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 1,
			'default_value' => 'full-width',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_list_page_timer',
			'label' => __("Timer", 'ultimate-auction-pro-software'),
			'name' => 'event_list_page_timer',
			'type' => 'button_group',
			'instructions' => __("Display countdown clock on event list page.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'true' => __("ON", 'ultimate-auction-pro-software'),
				'false' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'false',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_resultbar',
			'label' => __("Showing results number", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_resultbar',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Showing results number on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_sortbydate',
			'label' => __("Sort by Date", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_sortbydate',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Sort by date on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => 'ON',
				'off' => 'OFF',
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_reset_filter',
			'label' => __("Applied Filters", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_reset_filter',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Applied Filters date on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_daterange',
			'label' => __("Date Range", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_daterange',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Date Range on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_searchbar',
			'label' => __("Event Search Bar", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_searchbar',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Event Search Bar on the events list page.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_category',
			'label' => __("Category Filter", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_category',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Category Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_location',
			'label' => __("Location Filter", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_location',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Location Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'left-sidebar',
					),
				),
				array(
					array(
						'field' => 'event_page_tmp_page_layout',
						'operator' => '==',
						'value' => 'right-sidebar',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_location_county',
			'label' => __("Location Country Filter", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_location_county',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Location Country Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,


			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_location',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_location_state',
			'label' => __("Location State Filter", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_location_state',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Location State Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_location_county',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_location_city',
			'label' => __("Location City Filter", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_location_city',
			'type' => 'button_group',
			'instructions' => __("Turn on to display Location City Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'event_page_tmp_location_state',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => 'ON',
				'off' => 'OFF',
			),
			'allow_null' => 0,
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_default_view',
			'label' => __("Default Events View", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_default_view',
			'type' => 'button_group',
			'instructions' => __("Controls the Default Events View for the events list page.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'grid-view' => __("Grid View", 'ultimate-auction-pro-software'),
				'list-view' => __("List View", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 1,
			'default_value' => 'grid-view',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_viewbar',
			'label' => __("Event View Bar", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_viewbar',
			'type' => 'button_group',
			'instructions' => __("Controls the Event View Bar for the events list page.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => 'on',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_pagination_type',
			'label' => __("Pagination Type", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_pagination_type',
			'type' => 'button_group',
			'instructions' => __("Controls the pagination type.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'infinite-scroll' => __("Infinite Scroll", 'ultimate-auction-pro-software'),
				'load-more' => __("Load More Button", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 1,
			'default_value' => 'infinite-scroll',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'event_page_tmp_perpage',
			'label' => __("Number of events to show per page", 'ultimate-auction-pro-software'),
			'name' => 'event_page_tmp_perpage',
			'type' => 'range',
			'instructions' => __("Controls the number of events that display per page for Event List page. Set to -1 to display all.", 'ultimate-auction-pro-software'),
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
			'append' => __("Default is 12", 'ultimate-auction-pro-software'),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-templates/template-events-list.php',
			),
		),
	),
	'menu_order' => 0,
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