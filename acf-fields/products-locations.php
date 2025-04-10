<?php
acf_add_local_field_group(array(
	'key' => 'group_uat_locationP_address',
	'title' => '<span class="dashicons dashicons-location-alt"></span>Auction Product Location Details',
	'fields' => array(
		array(
			'key' => 'uat_locationP_address',
			'label' => __("Address", 'ultimate-auction-pro-software'),
			'name' => 'uat_locationP_address',
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
								'value' => 'product',
							),
							array(
								'param' => 'post_taxonomy',
								'operator' => '==',
								'value' => 'product_type:auction',
							),
						),
					),
	'menu_order' => 10,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));