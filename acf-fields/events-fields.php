<?php
$event_bp_tabs_0 = array();
$event_bp_tabs_1 = array();
$event_bp_tabs_1_1 = array();
$event_bp_tabs_1_1_1 = array();
$event_bp_tabs_1_1_2 = array();
$event_bp_tabs_2 = array();
$event_bp_tabs_3 = array();
$event_bp_tabs_4 = array();
$event_bp_tabs_5 = array();
$event_bp_tabs_6 = array();
$event_bp_tabs_7 = array();
$event_bp_tabs_8 = array();
$event_credit_card_tab_1 = array();
$event_credit_card_tab_2 = array();
$event_credit_card_tab_3 = array();
$event_credit_card_tab_4 = array();
$event_credit_card_tab_5 = array();

$event_terms_conditions_tab_1 = array();

$event_bp_tabs_0 = array(
	'key' => 'uat_events_tab_buyers_premium',
	'label' => __("Buyer&#039;s Premium", 'ultimate-auction-pro-software'),
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
$event_bp_tabs_1_1 = array(
	'key' => 'field_5e9d5s0sb936535',
	'label' => __("Buyer&#039;s Premium Options", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_buyers_premium_type',
	'type' => 'button_group',
	'instructions' => __("Choose to apply Buyer&#039;s Premium for this event from global or custom", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'global' => __("Global settings", 'ultimate-auction-pro-software'),
		'custom' => __("Custom settings", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_1 = array(
	'key' => 'field_5e9d50b936535',
	'label' => __("Enable Buyer&#039;s Premium", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium',
	'type' => 'button_group',
	'instructions' => __("Charge a premium amount over and above Bid Amount from Bidder to admin or auction owner.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d5s0sb936535',
				'operator' => '==',
				'value' => "custom",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Yes", 'ultimate-auction-pro-software'),
		'no' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_1_1_1 = array(
	'key' => 'field_5e9d50b936535r4',
	'label' => __("Product won by bidding", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium_bidding',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by bidding", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d5s0sb936535',
				'operator' => '==',
				'value' => 'custom',
			),
		),
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => 'yes',
			),
		),
	),
	'wrapper' => array(
		'width' => '50%',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => 'Yes',
		'no' => 'No',
	),
	'allow_null' => 0,
	'default_value' => 'yes',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_1_1_2 = array(
	'key' => 'field_5e9d50b936535r4j5',
	'label' => __("Product won by Buy Now", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium_buy_now',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by Buy Now", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d5s0sb936535',
				'operator' => '==',
				'value' => 'custom',
			),
		),
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => 'yes',
			),
		),
	),
	'wrapper' => array(
		'width' => '50%',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => 'Yes',
		'no' => 'No',
	),
	'allow_null' => 0,
	'default_value' => 'yes',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_2 = array(
	'key' => 'field_5e9d87ed72e1e',
	'label' => __("Do you want to automatically debit the Buyer&#039;s premium?", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_buyers_premium_enable',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => "yes",
			),
			array(
				'field' => 'field_5e9d5s0sb936535',
				'operator' => '==',
				'value' => "custom",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Yes", 'ultimate-auction-pro-software'),
		'no' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_3 = array(
	'key' => 'field_5e9d5045fa113',
	'label' => __("Who should receive Buyer&#039;s Premium :", 'ultimate-auction-pro-software'),
	'name' => 'uat_give_buyers_premium_to',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => "yes",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'admin' => __("Admin", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_4 =		array(
	'key' => 'field_5e9d5138af6b6',
	'label' => __("What will you charge :", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_type',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => "yes",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'flat' => __("Flat Rate", 'ultimate-auction-pro-software'),
		'percentage' => __("Percentage", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_bp_tabs_5 = array(
	'key' => 'field_5e9d51acaf6b7',
	'label' => __("Mention the Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_amount',
	'type' => 'number',
	'instructions' => __("This field signifies the amount in flat rate or percentage that you have selected above.", 'ultimate-auction-pro-software'),
	'required' => 1,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d50b936535',
				'operator' => '==',
				'value' => "yes",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '1',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
	'min' => 0,
	'max' => '',
	'step' => '',
);
$event_bp_tabs_7 =	array(
	'key' => 'field_5ea2ed067377c',
	'label' => __("Minimum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_min_premium',
	'type' => 'number',
	'instructions' => __("This amount is minimum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is below this minimum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d5138af6b6',
				'operator' => '==',
				'value' => "percentage",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => '',
	'max' => '',
	'step' => '',
);
$event_bp_tabs_8 =	array(
	'key' => 'field_5ea2ed617377f',
	'label' => __("Maximum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_max_premium',
	'type' => 'number',
	'instructions' => __("This amount is maximum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is above this maximum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d5138af6b6',
				'operator' => '==',
				'value' => "percentage",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => '',
	'max' => '',
	'step' => '',
);
$event_credit_card_tabs = array();
$event_credit_card_tab_1 =	array(
	'key' => 'uat_events_tab_auto_debit',
	'label' => __("Payment Hold & Debit", 'ultimate-auction-pro-software'),
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
$event_credit_card_tab_2 =	array(
	'key' => 'field_5ea3e35c0243f',
	'label' => __("Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed.", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_auto_debit_hold_enable',
	'type' => 'button_group',
	'instructions' => __("Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Yes", 'ultimate-auction-pro-software'),
		'no' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'no',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_credit_card_tab_2_1 =	array(
	'key' => 'field_5e9d867f7b31csdsfdf',
	'label' => __("Hold a specific amount (from first bid) only one time or hold bid amount each time bid is placed.", 'ultimate-auction-pro-software'),
	'name' => 'ep_type_automatically_debit_hold_type',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5ea3e35c0243f',
				'operator' => '==',
				'value' => "yes",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'ep_stripe_charge_type_fixed' => __("One Time Specific Amount", 'ultimate-auction-pro-software'),
		'ep_stripe_charge_type_exact_bid' => __("Exact Bid Amount Each Time", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'stripe_charge_type_exact_bid',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_credit_card_tab_2_1_1 =	array(
	'key' => 'field_5e9eca0d21aa6srerei',

	'label' => __("Enter specific amount", 'ultimate-auction-pro-software'),

	'name' => 'ep_stripe_charge_type_fixed_amount',
	'type' => 'number',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d867f7b31csdsfdf',
				'operator' => '==',
				'value' => 'ep_stripe_charge_type_fixed',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'default_value' => '0',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => '0',
	'max' => '',
	'step' => '',
);
$event_credit_card_tab_3 =	array(
	'key' => 'field_5e9d867f7b31c',
	'label' => __("Do you want to only automatically debit the winning amount on user's credit card", 'ultimate-auction-pro-software'),
	'name' => 'uat_auto_debit_options',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5ea3e35c0243f',
				'operator' => '==',
				'value' => "no",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'stripe_charge_type_full' => __("Full Amount", 'ultimate-auction-pro-software'),
		'stripe_charge_type_partially' => __("Partial Amount", 'ultimate-auction-pro-software'),
		'stripe_charge_type_no' => __("No Auto Debit. Collect Payment on checkout page.", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'stripe_charge_type_no',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_credit_card_tab_4 =	array(
	'key' => 'field_5e9ec82321aa5',
	'label' => __("Partial Amount Type", 'ultimate-auction-pro-software'),
	'name' => 'uat_partially_bid_amount_type',
	'type' => 'button_group',
	'instructions' => __("If you choose Percentage then the this entered value is treated as percentage of the total bid amount of the product, otherwise as fixed amount.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d867f7b31c',
				'operator' => '==',
				'value' => 'stripe_charge_type_partially',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'flat_rate' => __("Flat Rate", 'ultimate-auction-pro-software'),
		'percentage' => __("Percentage", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$event_credit_card_tab_5 =	array(
	'key' => 'field_5e9eca0d21aa6',
	'label' => __("Enter Partially Amount or Percentage", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_charge_type_partially_amt',
	'type' => 'number',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5e9d867f7b31c',
				'operator' => '==',
				'value' => 'stripe_charge_type_partially',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'default_value' => '',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => '',
	'max' => '',
	'step' => '',
);
$field_array = array(
	array(
		'key' => 'uat_events_tab_general',
		'label' => __("Basic Details", 'ultimate-auction-pro-software'),
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
		'placement' => 'left',
		'endpoint' => 0,
	),
	array(
		'key' => 'field_5e980696ec3c0',
		'label' => __("Type of Auction Event", 'ultimate-auction-pro-software'),
		'name' => 'uat_type_of_auction_event',
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
			'uat_event_timed' => __("Timed Event", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => 'uat_event_timed',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),

	array(
		'key' => 'field_5ea04cfb9e43c',
		'label' => __("Auction Type", 'ultimate-auction-pro-software'),
		'name' => 'uat_type_of_auction_type',
		'type' => 'button_group',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980696ec3c0',
					'operator' => '==',
					'value' => 'uat_event_timed',
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'proxy' => __("Proxy", 'ultimate-auction-pro-software'),
			'silent' => __("Silent", 'ultimate-auction-pro-software'),
			'simple' => __("Simple", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => 'simple',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),
	array(
		'key' => 'field_5e980d87af173',
		'label' => __("Choose Auction Products", 'ultimate-auction-pro-software'),
		'name' => 'uat_choose_product',
		'type' => 'button_group',
		'instructions' => __("if you want to select whole auction products from category please select &#039;Select Product Category&#039;. if you want to add manually products please select &#039;Auction Products Manually&#039;", 'ultimate-auction-pro-software'),
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'uat_product_category' => __("Select Product Category", 'ultimate-auction-pro-software'),
			'uat_product_manually' => __("Auction Products Manually", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => 'uat_product_manually',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),
	array(
		'key' => 'field_5e980f4c62061',
		'label' => __("Choose Product Category", 'ultimate-auction-pro-software'),
		'name' => 'uat_select_category',
		'type' => 'taxonomy',
		'instructions' => __("Selected category products include in this event.", 'ultimate-auction-pro-software'),
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980d87af173',
					'operator' => '==',
					'value' => 'uat_product_category',
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'taxonomy' => 'product_cat',
		'field_type' => 'select',
		'allow_null' => 0,
		'add_term' => 0,
		'save_terms' => 0,
		'load_terms' => 0,
		'return_format' => 'id',
		'multiple' => 0,
	),
	array(
		'key' => 'field_5e98106408fe6',
		'label' => __("Choose Product Manually", 'ultimate-auction-pro-software'),
		'name' => 'uat_select_products_menually',
		'type' => 'post_object',
		'instructions' => __("Select Auction product that you want to include in this event.", 'ultimate-auction-pro-software'),
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980d87af173',
					'operator' => '==',
					'value' => 'uat_product_manually',
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'post_type' => array(
			0 => 'product',
		),
		'taxonomy' => array(
			0 => 'product_type:auction',
		),
		'allow_null' => 0,
		'multiple' => 1,
		'return_format' => 'id',
		'ui' => 1,
	),
	array(
		'key' => 'field_5e980bc54353e',
		'label' => __("Start Date &amp; Time", 'ultimate-auction-pro-software'),
		'name' => 'start_time_and_date',
		'type' => 'date_time_picker',
		'instructions' => __("Set the Start date and time of Auction Event.", 'ultimate-auction-pro-software'),
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'display_format' => 'Y-m-d H:i:s',
		'return_format' => 'Y-m-d H:i:s',
		'first_day' => 1,
	),
	array(
		'key' => 'field_5e980bec4353f',
		'label' => __("End Date &amp; Time", 'ultimate-auction-pro-software'),
		'name' => 'end_time_and_date',
		'type' => 'date_time_picker',
		'instructions' => __("Set the End date and time of Auction Event.", 'ultimate-auction-pro-software'),
		'required' => 1,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '50',
			'class' => '',
			'id' => '',
		),
		'display_format' => 'Y-m-d H:i:s',
		'return_format' => 'Y-m-d H:i:s',
		'first_day' => 1,
	),
	array(
		'key' => 'field_5e98075acce3a',
		'label' => __("Enable Bid Increment", 'ultimate-auction-pro-software'),
		'name' => 'uat_enable_bid_increment',
		'type' => 'button_group',
		'instructions' => __("The price from which next bid should start", 'ultimate-auction-pro-software'),
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
		'default_value' => 'yes',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),
	array(
		'key' => 'field_5e980785cce3b',
		'label' => __("Set Bid Incremental Type", 'ultimate-auction-pro-software'),
		'name' => 'uat_set_bid_incremental_type',
		'type' => 'button_group',
		'instructions' => __("Choose Bid Incremental Type.", 'ultimate-auction-pro-software'),
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e98075acce3a',
					'operator' => '==',
					'value' => "yes",
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'fix_inc' => __("Flat price", 'ultimate-auction-pro-software'),
			'var_inc' => __("Variable Price: Price Table", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),
	array(
		'key' => 'field_5e980785cce3b344',
		'label' => __("Set Bid Variable Incremental Type", 'ultimate-auction-pro-software'),
		'name' => 'uat_set_bid_var_incremental_type',
		'type' => 'button_group',
		'instructions' => __("Choose Bid Variable Incremental Type.", 'ultimate-auction-pro-software'),
		'required' => 1,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980785cce3b',
					'operator' => '==',
					'value' => "var_inc",
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'global' => __("Global settings", 'ultimate-auction-pro-software'),
			'custom' => __("Custom price range", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	),
	array(
		'key' => 'field_5e9807fd5b30c',
		'label' => __("Flat Incremental Price", 'ultimate-auction-pro-software'),
		'name' => 'uat_flat_incremental_price',
		'type' => 'text',
		'instructions' => __("Set Flat Incremental Price", 'ultimate-auction-pro-software'),
		'required' => 1,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980785cce3b',
					'operator' => '==',
					'value' => 'fix_inc',
				),
			),
		),
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'default_value' => get_option('options_uat_global_bid_increment_event', "1"),
		'placeholder' => '',
		'prepend' => '',
		'append' => '',
		'maxlength' => '',
	),
	array(
		'key' => 'field_5e9808585b30e',
		'label' => __("Set Variable Incremental Price", 'ultimate-auction-pro-software'),
		'name' => 'uat_var_incremental_price',
		'type' => 'repeater',
		'instructions' => __("Set Variable Incremental Price", 'ultimate-auction-pro-software'),
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'field_5e980785cce3b344',
					'operator' => '==',
					'value' => 'custom',
				),
			),
		),
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'collapsed' => '',
		'min' => 0,
		'max' => 0,
		'layout' => 'table',
		'button_label' => __("Add Interval", 'ultimate-auction-pro-software'),
		'sub_fields' => array(
			array(
				'key' => 'field_5e98094deae7c',
				'label' => __("Start Price", 'ultimate-auction-pro-software'),
				'name' => 'start',
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
				'placeholder' => __("Start Price", 'ultimate-auction-pro-software'),
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e9809a8c239d',
				'label' => __("End Price", 'ultimate-auction-pro-software'),
				'name' => 'end',
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
				'placeholder' => __("End Price", 'ultimate-auction-pro-software'),
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5e980a136cb87',
				'label' => __("Increment Price", 'ultimate-auction-pro-software'),
				'name' => 'inc_val',
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
				'placeholder' => __("Increment Price", 'ultimate-auction-pro-software'),
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
		),
	)

);

$event_terms_conditions_tab_1 = array(
	'key' => 'events_terms_conditions_tab',
	'label' => __("Terms & Conditions", 'ultimate-auction-pro-software'),
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
	'placement' => __("top", 'ultimate-auction-pro-software'),
	'endpoint' => 0,
);

$event_terms_conditions_tab_2 = array(
	'key' => 'uat_events_terms_conditions',
	'label' => __("Terms &amp; Condition", 'ultimate-auction-pro-software'),
	'name' => 'uat_terms_condition',
	'type' => 'wysiwyg',
	'instructions' => __("Enter Event Terms &amp; Condition", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '',
	'tabs' => 'all',
	'toolbar' => 'basic',
	'media_upload' => 0,
	'delay' => 0,
);

$gatewayIsReady = gatewayIsReady();
/* Terms & Conditions */
if (get_option('options_uat_events_terms_conditions_tab', "off") == 'on') {
	$field_array[] = $event_terms_conditions_tab_1;
	$field_array[] = $event_terms_conditions_tab_2;
} else {
	$field_array[] = $event_terms_conditions_tab_1;
	$enable_terms_conditions = array(
		'key' => 'enable_terms_conditions',
		'label' => '',
		'name' => '',
		'type' => 'message',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => __("Turn ON Terms & Conditions from the <a target='_blank' href='admin.php?page=ua-auctions-theme-options#uat_pages_setting_tabs'>Page: Auction Event Detail</a> feature for Event Detail page from Theme settings.", 'ultimate-auction-pro-software'),
		'new_lines' => 'wpautop',
		'esc_html' => 0,
	);
	$field_array[] = $enable_terms_conditions;
}

/* BP card */
if (get_option('options_uat_enable_buyers_premium_ge', "no") == 'yes') {
	$field_array[] = $event_bp_tabs_0;
	$field_array[] = $event_bp_tabs_1_1;
	$field_array[] = $event_bp_tabs_1;
	$field_array[] = $event_bp_tabs_1_1_1;
	$field_array[] = $event_bp_tabs_1_1_2;
	if ($gatewayIsReady) {
		$field_array[] = $event_bp_tabs_2;
	}
	$field_array[] = $event_bp_tabs_3;
	$field_array[] = $event_bp_tabs_4;
	$field_array[] = $event_bp_tabs_5;
	$field_array[] = $event_bp_tabs_6;
	$field_array[] = $event_bp_tabs_7;
	$field_array[] = $event_bp_tabs_8;
} else {
	$field_array[] = $event_bp_tabs_0;
	$enable_buyers_premium = array(
		'key' => 'enable_buyers_premium',
		'label' => '',
		'name' => '',
		'type' => 'message',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => __("Enable <a target='_blank' href='admin.php?page=ua-auctions-theme-options#uat_bp_tab'>Buyer's Premium</a> feature for Event Product from Theme settings.", 'ultimate-auction-pro-software'),
		'new_lines' => 'wpautop',
		'esc_html' => 0,
	);
	$field_array[] = $enable_buyers_premium;
}
/* Credit card */

if (get_option('options_uat_enable_credit_cart_sp_events', "no") == 'yes' && $gatewayIsReady) {
	$field_array[] = $event_credit_card_tab_1;
	$field_array[] = $event_credit_card_tab_2;
	$field_array[] = $event_credit_card_tab_2_1;
	$field_array[] = $event_credit_card_tab_2_1_1;
	$field_array[] = $event_credit_card_tab_3;
	$field_array[] = $event_credit_card_tab_4;
	$field_array[] = $event_credit_card_tab_5;
} else {
	$field_array[] = $event_credit_card_tab_1;
	$enable_credit_card = array(
		'key' => 'enable_credit_card_message',
		'label' => '',
		'name' => '',
		'type' => 'message',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => __("1. Configure the <a target='_blank' href='admin.php?page=ua-auctions-theme-options#field_5f7585998b014'>Payment Gateway</a> from Theme settings to make it functional.  <br>2. Enable  <a target='_blank' href='admin.php?page=ua-auctions-theme-options#uat_credit_cart_setting'>Credit Card (Hold & Debit)</a> feature for Event Product from Theme settings.", 'ultimate-auction-pro-software'),
		'new_lines' => 'wpautop',
		'esc_html' => 0,
	);
	$field_array[] = $enable_credit_card;
}

acf_add_local_field_group(array(
	'key' => 'group_5fa1506ea1562',
	'title' => '<span class="dashicons dashicons-calendar"></span> Event Details',
	'fields' => $field_array,
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'uat_event',
			),
		),
	),
	'menu_order' => 1,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));
