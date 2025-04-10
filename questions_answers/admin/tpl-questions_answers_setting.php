<?php
add_action('acf/init', 'uat_acf_op_init2');
function uat_acf_op_init2() {
    // Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {
        acf_add_options_sub_page(array(
		'page_title' 	=> 'Q&A Setting',
		'menu_title'	=> 'Q&A Setting',
		'menu_slug' 	=> 'qa_settings',
		'capability'	=> 'edit_posts',
		'parent_slug'	=> 'ua-auctions-theme',
		'redirect'		=> false,
		'icon_url' => 'dashicons-admin-customizer',
        'update_button' => 'Update Options',
        'updated_message' => 'Theme settings successfully updated.',
		'position' => '8',
		'autoload' => true,
	));
    }
}
$q_and_a_array  = array();
$q_a_options_1= array(
			'key' => 'q_a_auction_product_page',
			'label' => __("Enable for Auction Product Page:", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_product_page',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
		);
		$q_and_a_array[] = $q_a_options_1;
		$q_a_options_2= array(
			'key' => 'q_a_auction_wooCommerce_product_page',
			'label' => __("Enable for WooCommerce Product Page:", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_wooCommerce_product_page',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_2;
		//Slider Entries for Q&A
		$q_a_options_3 = array(
			'key' => 'q_a_auction_slider_entries',
			'label' => __("Slider Entries for Q&A", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_slider_entries',
			'type' => 'range',
			'instructions' => __("Controls the number of Auction Products that display per page for Event Detail page. Set to -1 to display all.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 3,
			'min' => 1,
			'max' => '',
			'step' => '',
			'prepend' => '',
			'append' => 'Default is 3',
		);
		$q_and_a_array[] = $q_a_options_3;
 $q_a_options_4= array(
			'key' => 'q_a_auction_approval_by_seller',
			'label' => __("Approval for Question by Seller:", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_approval_by_seller',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_4;
		 $q_a_options_5= array(
			'key' => 'q_a_auction_email_notification_question',
			'label' => __("Email Notification for Question to Seller", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_email_notification_question',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_5;
		$q_a_options_6= array(
			'key' => 'q_a_auction_approval_answer_admin',
			'label' => __("Approval for Answer by Admin:", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_approval_answer_admin',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
		);
		$q_and_a_array[] = $q_a_options_6;
   $q_a_options_7= array(
			'key' => 'q_a_auction_email_notification_answer_user',
			'label' => __("Email Notification for Answer to User", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_email_notification_answer_user',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_7;
		$q_a_options_8 =	array(
			'key' => 'q_a_auction_slider_title',
			'label' => __("Label for Title of Q&A Slider", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_slider_title',
			'type' => 'text',
			'instructions' => __("", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Q&A',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		);
		$q_and_a_array[] = $q_a_options_8;
		$q_a_options_9= array(
			'key' => 'q_a_auction_counter_with_title',
			'label' => __("Show Q&A Counter with Title", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_counter_with_title',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_9;
		$q_a_options_10= array(
			'key' => 'q_a_auction_button_with_title',
			'label' => __('Show Q&A Label with Text as "Ask a question"', 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_button_with_title',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
		);
		$q_and_a_array[] = $q_a_options_10;
   $q_a_options_11 =	array(
			'key' => 'q_a_auction_Label_title',
			'label' => __("Label for Q&A Button", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_Label_title',
			'type' => 'text',
			'instructions' => __("", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Ask a Question',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		);
		$q_and_a_array[] = $q_a_options_11;
		$q_a_options_12= array(
			'key' => 'q_a_auction_enable_voting',
			'label' => __("Enable Voting for Q&A", 'ultimate-auction-pro-software'),
			'name' => 'q_a_auction_enable_voting',
			'type' => 'button_group',
			'instructions' => __("", 'ultimate-auction-pro-software'),
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
			'default_value' => 'off',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
		$q_and_a_array[] = $q_a_options_12;




    // Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {

acf_add_local_field_group(array(
	'key' => 'q_a_auction_product_page_group',
	'title' => __("Q&A Setting", 'ultimate-auction-pro-software'),
	'fields' => $q_and_a_array,
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'qa_settings',
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
	));}