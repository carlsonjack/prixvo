<?php

acf_add_local_field_group(array(
	'key' => 'group_6124958cc5ada',
	'title' => '<span class="dashicons dashicons-location-alt"></span>Event Location Details',
	'fields' => array(
		array(
			'key' => 'field_612495ad2a1b3',
			'label' => __("Address", 'ultimate-auction-pro-software'),
			'name' => 'uat_location_address',
			'type' => 'google_map',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'center_lat' => '',
			'center_lng' => '',
			'zoom' => '',
			'height' => '',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'uat_event',
			),
		),
	),
	'menu_order' => 20,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));