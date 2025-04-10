<?php
acf_add_local_field_group(array(
	'key' => 'event_categorie_fields',
	'title' => '',
	'fields' => array(
		array(
			'key' => 'event_categorie_image',
			'label' =>__("Thumbnail image", 'ultimate-auction-pro-software'),
			'name' => 'event_categorie_image',
			'type' => 'image',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'allow_null' => 0,
			'default_value' => 'false',
			'layout' => 'horizontal',
			'return_format' => 'array',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'taxonomy',
				'operator' => '==',
				'value' => 'uat-event-cat',
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

