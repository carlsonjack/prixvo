<?php
acf_add_local_field_group(array(
	'key' => 'group_woo_cat_timer',
	'title' => 'test',
	'fields' => array(
		array(
			'key' => 'woo_cat_timer',
			'label' =>__("Do you want display timer for auction products ?", 'ultimate-auction-pro-software'),
			'name' => 'woo_cat_timer',
			'type' => 'button_group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'true' => 'Yes',
				'false' => 'NO',
			),
			'allow_null' => 0,
			'default_value' => 'false',
			'layout' => 'horizontal',
			'return_format' => 'value',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'product_cat',
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
	'show_in_rest' => 0,
));

