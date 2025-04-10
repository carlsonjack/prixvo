<?php
acf_add_local_field_group(array(
	'key' => 'group_event_categories_page_layout',
	'title' => '<span class="dashicons dashicons-layout"></span> Page Layout',
	'fields' => array(
		array(
			'key' => 'uat_categories_list_show',
			'label' => __("Show categories list", 'ultimate-auction-pro-software'),
			'name' => 'uat_categories_list_show',
			'type' => 'button_group',
			'instructions' => __("Show categories list", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'yes' => __("Yes", 'ultimate-auction-pro-software'),
				'no' => __("No", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 1,
			'default_value' => 'yes',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'uat_event_categories_populer_events',
			'label' => __("Show populer events", 'ultimate-auction-pro-software'),
			'name' => 'uat_event_categories_populer_events',
			'type' => 'button_group',
			'instructions' => __("Show event list in slider", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'yes' => __("Yes", 'ultimate-auction-pro-software'),
				'no' => __("No", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 1,
			'default_value' => 'yes',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
		array(
			'key' => 'uat_event_categories_populer_auctions',
			'label' => __("Show populer auctions", 'ultimate-auction-pro-software'),
			'name' => 'uat_event_categories_populer_auctions',
			'type' => 'button_group',
			'instructions' => __("Show auction list in slider", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => 'uat_button_group',
				'id' => '',
			),
			'choices' => array(
				'yes' => __("Yes", 'ultimate-auction-pro-software'),
				'no' => __("No", 'ultimate-auction-pro-software'),
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
				'value' => 'page-categories.php',
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