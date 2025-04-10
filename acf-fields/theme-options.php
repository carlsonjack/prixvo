<?php
$active_theme_slug = get_stylesheet();
$theme_options_welcome = array();
$theme_options_menu = array();
$theme_options_logo = array();
$theme_options_login = array();
$theme_options_footer = array();
$theme_options_cron = array();
$theme_options_payment_gateway = array();
$theme_options_bp = array();
$theme_options_cc = array();
$theme_options_anti = array();
$theme_options_logs = array();
$theme_options_auction = array();
$theme_options_auction_car = array();
$theme_options_bid_increment = array();
$theme_options_pages = array();
$theme_options_welcome = array();
$theme_options_welcome_0 = array();
$theme_options_welcome_1 = array();

$register_confirm_link = admin_url('admin.php?page=ua-auctions-emails&email_type=registration_confirm');

$theme_options_menu = array(
	'key' => 'field_5f7585ad8b016',
	'label' => __("Menu", 'ultimate-auction-pro-software'),
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
);
$theme_options_menu_0 = array(
	'key' => 'field_5f75e20f707f1',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Main Menu</h3><p style=\"float:right\"><a class=\"reset-menu-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_menu_1 = array(
	'key' => 'field_5fa131cee1216',
	'label' => __("Sticky Header", 'ultimate-auction-pro-software'),
	'name' => 'uat_menu_sticky',
	'type' => 'button_group',
	'instructions' => __("Turn on to enable a sticky header.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_menu_2 = array(
	'key' => 'field_5fa007e7fd7e1',
	'label' => __("Menu Search box", 'ultimate-auction-pro-software'),
	'name' => 'uat_menu_search_box',
	'type' => 'button_group',
	'instructions' => __("Turn on to display the search icon in the menu.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
);
$theme_options_menu_3 = array(
	'key' => 'field_5fa10bc7935f4',
	'label' => __("Menu Login/Sign up button", 'ultimate-auction-pro-software'),
	'name' => 'uat_menu_login_link',
	'type' => 'button_group',
	'instructions' => __("Turn on to display the Login/Sign up button in the menu.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_menu_4 = array(
	'key' => 'uat_secondary_menu',
	'label' => __("Secondary Menu", 'ultimate-auction-pro-software'),
	'name' => 'uat_secondary_menu',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Secondary Menu in Header.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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

$theme_options_logo = array(
	'key' => 'field_5f7585af8b017',
	'label' => __("Logo", 'ultimate-auction-pro-software'),
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
);
$theme_options_logo_0 =	array(
	'key' => 'field_5f7c400dc35e6',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => "",
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_logo_1 =	array(
	'key' => 'field_5f75ee8fa0c07',
	'label' => __("Logo", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_logo_2 =	array(
	'key' => 'field_5f75e235707f2',
	'label' => __("Website Logo", 'ultimate-auction-pro-software'),
	'name' => 'uat_website_logo',
	'type' => 'image',
	'instructions' => __("Select an image for website logo.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'return_format' => 'url',
	'library' => 'all',
	'min_size' => '',
	'max_size' => '',
	'mime_types' => '',
);
$theme_options_logo_3 =	array(
	'key' => 'field_5f7c3da9dd954',
	'label' => __("Favicon", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_logo_4 =	array(
	'key' => 'field_5f7c3d7fdd953',
	'label' => __("Favicon", 'ultimate-auction-pro-software'),
	'name' => 'uat_website_favicon',
	'type' => 'image',
	'instructions' => __("Favicon for your website at 16px x 16px or 32px x 32px.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'return_format' => 'url',
	'library' => 'all',
	'min_size' => '',
	'max_size' => '',
	'mime_types' => '',
);
$theme_options_logo_5 =	array(
	'key' => 'field_5f75ef02d744b',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_login = array(
	'key' => 'uat_login_registration',
	'label' => __("Login & Registration", 'ultimate-auction-pro-software'),
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
);
$theme_options_login_0 = array(
	'key' => 'uat_login_registration_message',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Login & Registration </h3><p style=\"float:right\"><a class=\"reset-login-registration-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_login_11 =	array(
	'key' => 'uat_custom_fields_seller_registration',
	'label' => __("Do you want to enable seller registration?", 'ultimate-auction-pro-software'),
	'name' => 'uat_custom_fields_seller_registration',
	'type' => 'button_group',
	'instructions' => __("A user can register as a seller when this option is enabled", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Enable", 'ultimate-auction-pro-software'),
		'no' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'yes',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_login_2 =	array(
	'key' => 'registration_confirmation',
	'label' => __("Do you want to send confirmation email to user when they register?", 'ultimate-auction-pro-software'),
	'name' => 'uat_need_registration_confirmation',
	'type' => 'button_group',
	'instructions' => __("Send confirmation email to users when they register to validate their email address.</br>Make sure you have 
Enable  at <a target='_blank' href='$register_confirm_link'>Registration Confirm Email</a>", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);

$theme_options_login_3 =	array(
	'key' => 'registration_approval',
	'label' => __("Admin approval for new registrations", 'ultimate-auction-pro-software'),
	'name' => 'uat_need_registration_approval',
	'type' => 'button_group',
	'instructions' => __("Do you want to approve user when they register? User will be able to login only after approval.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);


$theme_options_login_1 = 	array(
	'key' => 'field_5f6b32f6a6f2f',
	'label' => __("Credit Card Details on Registration form.", 'ultimate-auction-pro-software'),
	'name' => 'uwt_stripe_card_myaccount_page',
	'type' => 'button_group',
	'instructions' => __("Do you want to capture credit card details during user registration? Make sure you have added correct stripe API detail at Payment Gateway->Stripe Payment", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);

$theme_options_login_165 = 	array(
	'key' => 'field_5f6b32f6a6f26f',
	'label' => __("Enable First Name & Last Name on Registration form.", 'ultimate-auction-pro-software'),
	'name' => 'uwt_enable_firstname_lastname_on_reg_page',
	'type' => 'button_group',
	'instructions' => __("Do you want to collect first name and last name details during user registration?", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);

$theme_options_login_4 =	array(
	'key' => 'registration_address_enabled',
	'label' => __("Do you want to capture address details during user registration?", 'ultimate-auction-pro-software'),
	'name' => 'uat_need_registration_address_enabled',
	'type' => 'button_group',
	'instructions' => "",
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_login_5 =	array(
	'key' => 'registration_phone_enabled',
	'label' => __("Do you want to capture mobile/phone number during user registration?", 'ultimate-auction-pro-software'),
	'name' => 'uat_need_registration_phone_enabled',
	'type' => 'button_group',
	'instructions' => "",
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);

$theme_options_login_56 =	array(
	'key' => 'registration_social_enabled',
	'label' => __('Do you want to offer "Social Media" (Google, Facebook) Login options?', 'ultimate-auction-pro-software'),
	'name' => 'registration_social_enabled',
	'type' => 'button_group',
	'instructions' => "",
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);

$theme_options_login_55 =	array(
	'key' => 'menu_link_types',
	'label' => __("Select Menu Link Type", 'ultimate-auction-pro-software'),
	'name' => 'menu_link_types',
	'type' => 'button_group',
	'instructions' => __("Choose how would Login & Registration forms be shown when Login & Registration button in the Header menu is clicked.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'choices' => array(
		'menu_open_in_popup' => __("Show in Pop-up", 'ultimate-auction-pro-software'),
		'menu_open_in_direct_link' => __("Open a page", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'menu_open_in_popup',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_login_6 = array(
	'key' => 'field_5fa013b3e9470',
	'label' => __("Settings for Login & Registration Pop-up Form", 'ultimate-auction-pro-software'),
	'name' => 'uat_register_login_popup',
	'type' => 'group',
	'instructions' => __("Settings for Login & Registration Pop-up Form", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'menu_link_types',
				'operator' => '==',
				'value' => 'menu_open_in_popup',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'layout' => 'block',
	'sub_fields' => array(
		array(
			'key' => 'field_5fa01467e9472',
			'label' => 'Tag Line',
			'name' => 'tag_line',
			'type' => 'textarea',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 4,
			'new_lines' => 'wpautop',
		),
		array(
			'key' => 'field_5fa0152ea5484',
			'label' => 'Term & Conditions',
			'name' => 'uat_term_condition',
			'type' => 'button_group',
			'instructions' => 'Turn on to display the Terms and condition checkbox.',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5f75e27aa615b',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
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
			'key' => 'field_5fa0e9bf03b4b',
			'label' => 'Term & Conditions Text and Link',
			'name' => 'uat_term_condition_txt',
			'type' => 'text',
			'instructions' => 'Add Term and condition text and page link here.	ex : I\'ve read and accept <a herf="" >term & conditions.</a>',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5fa0152ea5484',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'I\'ve read and accept <a herf="" >term & conditions.</a>',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),


	),
);
$theme_options_footer = array(
	'key' => 'field_5fa133c934518',
	'label' => __("Footer", 'ultimate-auction-pro-software'),
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
);
$theme_options_footer_0 =	array(
	'key' => 'field_5fa133d134519',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Footer Content</h3><p style=\"float:right\"><a class=\"reset-footer-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_footer_1 =	array(
	'key' => 'uat_footer_columns_no',
	'label' => __("Number of Footer Columns", 'ultimate-auction-pro-software'),
	'name' => 'uat_footer_columns_no',
	'type' => 'range',
	'instructions' => __("Controls the number of columns in the footer.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => 3,
	'min' => 1,
	'max' => 3,
	'step' => '',
	'prepend' => '',
	'append' => __("Default is 4", 'ultimate-auction-pro-software'),
);
$theme_options_footer_2 =	array(
	'key' => 'uat_copyright_bar',
	'label' => __("Copyright Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_copyright_bar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display the copyright bar.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_footer_3 =	array(
	'key' => 'uat_copyright_text',
	'label' => __("Copyright Text", 'ultimate-auction-pro-software'),
	'name' => 'uat_copyright_text',
	'type' => 'textarea',
	'instructions' => __("Enter the text that displays in the copyright bar. HTML markup can be used.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_copyright_bar',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'default_value' => __("Copyright | <a href=\"https://getultimateauction.com/\">Ultimate Auction Pro</a> by <a href=\"https://getultimateauction.com/\">Ultimate Auction Pro</a> | All Rights Reserved | Powered by <a href=\"https://wordpress.org\">WordPress</a>", 'ultimate-auction-pro-software'),
	'placeholder' => '',
	'maxlength' => '',
	'rows' => 4,
	'new_lines' => 'br',
);
$theme_options_footer_4 =	array(
	'key' => 'field_5fa13869181be',
	'label' => __("Social Media Icons", 'ultimate-auction-pro-software'),
	'name' => 'uat_social_media_icons',
	'type' => 'repeater',
	'instructions' => __("Social media links use a repeater field and allow one network per field. Click the \"Add New Icon\" button to add additional fields.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'collapsed' => '',
	'min' => 0,
	'max' => 0,
	'layout' => 'table',
	'button_label' => __("Add New Icon", 'ultimate-auction-pro-software'),
	'sub_fields' => array(
		array(
			'key' => 'field_5fa139e3e8f23',
			'label' => __("Social Network Icon", 'ultimate-auction-pro-software'),
			'name' => 'social_network_icon',
			'type' => 'image',
			'instructions' => __("Upload Social Network Icon.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array(
			'key' => 'field_5fa13a9568ebe',
			'label' => __("Social Network URL", 'ultimate-auction-pro-software'),
			'name' => 'social_network_url',
			'type' => 'url',
			'instructions' => __("Add Social Network URL.", 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
		),
	),
);
$theme_options_cron = array(
	'key' => 'uat_cron',
	'label' => __("Cron", 'ultimate-auction-pro-software'),
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
);
$theme_options_cron_0 =	array(
	'key' => 'uat_cron_msg',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Cron Setting</h3><p style=\"float:right\"><a class=\"reset-cron-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p><p style=\"float:left\">We recommend you to set up cron jobs for your auction products so that their status and associated emails are triggered properly.We recommend to set it to every minute.</p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_cron_01 = array(
	'key' => 'cron_options',
	'label' =>  __("Cron", 'ultimate-auction-pro-software'),
	'name' => 'cron_options',
	'type' => 'button_group',
	'instructions' =>  __("This Cron job will check the auction for completion, payment processing, order generation, and sending notifications. So please choose how you will configure cron on the site.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'page' =>  __("On page load", 'ultimate-auction-pro-software'),
		'server' =>  __("Server cron", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'page',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_cron_3 =	array(
	'key' => 'field_60195d2e43b86',
	'label' => __("Cron Winner Email", 'ultimate-auction-pro-software'),
	'name' => 'cron_winner_email',
	'type' => 'button_group',
	'instructions' => __("When you turn this ON then the software will check which auction products are due to send winning email.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_cron_4 =	array(
	'key' => 'field_60195d9143b87',
	'label' => __("Cron for loosing email", 'ultimate-auction-pro-software'),
	'name' => 'cron_loser_email',
	'type' => 'button_group',
	'instructions' => __("When you turn this ON then the software will check which auction products are due to send loosing email.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_cron_5 =	array(
	'key' => 'ending_soon_cron',
	'label' => __("Cron for Ending Soon Email", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron',
	'type' => 'button_group',
	'instructions' => __("Turn on to check which auction products are going to end soon and send ending soon email to Bidders.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_cron_6 =	array(
	'key' => 'ending_soon_cron_time_left',
	'label' => __("Mention time left for auction to close:", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron_time_left',
	'type' => 'number',
	'instructions' => __("Send reminder email. This setting is in minutes and default is 60.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'ending_soon_cron',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '60',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => 1,
	'max' => '',
	'step' => -1,
);
$theme_options_cron_66 =	array(
	'key' => 'ending_soon_for_bidders',
	'label' => __("Send email to all Bidders.", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_for_bidders',
	'type' => 'button_group',
	'instructions' => __("Ending Soon email will be sent to all Bidders who have placed a bid.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'ending_soon_cron',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
);
$theme_options_cron_7 =	array(
	'key' => 'ending_soon_for_savelist',
	'label' => __("Send email to users who has auction in their watch list.", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_for_savelist',
	'type' => 'button_group',
	'instructions' => __("Ending Soon email will be sent to all users who have added auction product in their watch list.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'ending_soon_cron',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'on' => __("ON", 'ultimate-auction-pro-software'),
		'off' => __("OFF", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => '',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_cron_8 =	array(
	'key' => 'ending_soon_cron_sms',
	'label' => __("Cron for Ending Soon SMS", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron_sms',
	'type' => 'button_group',
	'instructions' => __("Turn on to check which auction products are going to end soon and send ending soon sms for Bidders while CRON  Run. You can customize sms from Notifications Section.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_cron_9 =	array(
	'key' => 'ending_soon_cron_time_left_sms',
	'label' => __("Mention time left for auction to close:", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron_time_left_sms',
	'type' => 'number',
	'instructions' => __("Send reminder sms intervals in minutes default is 60.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'ending_soon_cron_sms',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'default_value' => '60',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => 1,
	'max' => '',
	'step' => -1,
);
$theme_options_cron_10 =	array(
	'key' => 'ending_soon_cron_whatsapp',
	'label' => __("Cron for Ending Soon Whatsapp SMS", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron_whatsapp',
	'type' => 'button_group',
	'instructions' => __("Turn on to check which auction products are going to end soon and send ending soon Whatsapp sms for Bidders while CRON  Run. You can customize Whatsapp sms from Notifications Section.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
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
$theme_options_cron_11 =	array(
	'key' => 'ending_soon_cron_time_left_whatsapp',
	'label' => __("Mention time left for auction to close:", 'ultimate-auction-pro-software'),
	'name' => 'ending_soon_cron_time_left_whatsapp',
	'type' => 'number',
	'instructions' => __("Send reminder Whatsapp sms intervals in minutes default is 60.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'ending_soon_cron_whatsapp',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'default_value' => '60',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'min' => 1,
	'max' => '',
	'step' => -1,
);

$theme_options_payment_gateway = array(
	'key' => 'field_5f7585998b014',
	'label' => __("Payment Gateway", 'ultimate-auction-pro-software'),
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
);
$theme_options_payment_gateway_0 =	array(
	'key' => 'field_5f7c4047d881a',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3>Payment Gateway (Credit Card Features)</h3><p style=\"float:left\">Below payment gateways are available to capture credit card details, hold the payments and debit the winning amount & buyer's premium</p><p style=\"float:right\"></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_payment_gateway_1 = array(
	'key' => 'field_5f7585d3901a8',
	'label' => __("Payment Gateway (Credit Card Features)", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);

$theme_options_payment_gateway_1_1 =	array(
	'key' => 'uat_payment_gateway',
	'label' => __("Select Payment Gateway", 'ultimate-auction-pro-software'),
	'name' => 'uat_payment_gateway',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'disabled-gateway',
		'data-status' => uat_check_gatway_change_ajax_callback_(),
	),
	'choices' => array(
		'stripe' => __("Stripe", 'ultimate-auction-pro-software'),
		'braintree' => __("Braintree", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'stripe',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_payment_gateway_2 =	array(
	'key' => 'field_5f6a06287919f',
	'label' => __("Select Mode", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_mode_types',
	'type' => 'button_group',
	'instructions' => 'Get your API keys from your <a target="_blank" href="https://stripe.com/docs/keys">stripe account</a>.',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_payment_gateway',
				'operator' => '==',
				'value' => 'stripe',
			),
		),
	),
	'choices' => array(
		'uat_stripe_test_mode' => __("Enable Test Mode", 'ultimate-auction-pro-software'),
		'uat_stripe_live_mode' => __("Enable Live Mode", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'uat_stripe_test_mode',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_payment_gateway_3 =	array(
	'key' => 'field_5f6a089e7e6d5',
	'label' => __("Test Publishable Key", 'ultimate-auction-pro-software'),
	'name' => 'stripe_test_publishable_key',
	'type' => 'text',
	'instructions' => __("Login to your Stripe and get Publishable key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_test_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_4 =	array(
	'key' => 'field_5f6a08bb7e6d6',
	'label' => __("Test Secret Key", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_test_secret_key',
	'type' => 'password',
	'instructions' => __("Login to your Stripe and get Secret key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_test_mode',
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
	'maxlength' => '',
);
$theme_options_payment_gateway_4_1 =	array(
	'key' => 'field_5f6a08bb7e6d62s',
	'label' => __("Test Client Id", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_test_client_id',
	'type' => 'password',
	'instructions' => __("Login to your Stripe and get Client Id.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_test_mode',
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
	'maxlength' => '',
);
$theme_options_payment_gateway_5 =	array(
	'key' => 'field_5f6a0a38e0a3b',
	'label' => __("Live Publishable Key", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_live_publishable_key',
	'type' => 'text',
	'instructions' => __("Login to your Stripe and get Publishable key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
);
$theme_options_payment_gateway_6 =	array(
	'key' => 'field_5f75b41905b12',
	'label' => __("Live Secret Key", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_live_secret_key',
	'type' => 'password',
	'instructions' => __("Login to your Stripe and get Secret key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_6_1 =	array(
	'key' => 'field_5f75b41905b312',
	'label' => __("Live Client Id", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_live_client_id',
	'type' => 'password',
	'instructions' => __("Login to your Stripe and get Client Id.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919f',
				'operator' => '==',
				'value' => 'uat_stripe_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_6_3 = array(
	'key' => 'uat_seller_settings_payment_methods',
	'label' => __("Choose seller withdrawal payment methods", 'ultimate-auction-pro-software'),
	'name' => 'uat_seller_settings_payment_methods',
	'type' => 'radio',
	'instructions' => __("Please enable your payment methods so that the seller can use any one of them to receive the payment for the sales.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_payment_gateway',
				'operator' => '==',
				'value' => 'stripe',
			),
		),
	),
	'wrapper' => array(
		'width' => '100',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'manual' => __("Manual payment", 'ultimate-auction-pro-software'),
		'automatic' => __("Automate payment", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'manual',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_payment_gateway_b_2 =	array(
	'key' => 'field_5f6a06287919fwer',
	'label' => __("Select Mode", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_mode_types',
	'type' => 'button_group',
	'instructions' => 'Get your API keys from your <a target="_blank" href="https://developer.paypal.com/braintree/articles/control-panel/important-gateway-credentials">braintree account</a>.',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_payment_gateway',
				'operator' => '==',
				'value' => 'braintree',
			),
		),
	),
	'choices' => array(
		'uat_braintree_test_mode' => __("Enable Test Mode", 'ultimate-auction-pro-software'),
		'uat_braintree_live_mode' => __("Enable Live Mode", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'uat_braintree_test_mode',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_payment_gateway_b_3 =	array(
	'key' => 'field_5f6a08sdsdsdbb7e6d6',
	'label' => __("Test Public key", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_test_public_key',
	'type' => 'text',
	'instructions' => __("Login to your Braintree and get public key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_test_mode',
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
	'maxlength' => '',
);
$theme_options_payment_gateway_b_4 =	array(
	'key' => 'field_5f6asdsd0a38e0a3b',
	'label' => __("Test Private key", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_test_private_key',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get private key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_test_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
);
$theme_options_payment_gateway_b_5 =	array(
	'key' => 'field_5f75b419ee05b12',
	'label' => __("Test Merchant ID", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_test_merchant_id',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get Merchant ID", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_test_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_b_5_2 =	array(
	'key' => 'field_5f75b419ee05bsdsd12',
	'label' => __("Test Merchant Account ID", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_test_merchant_account_id',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get Merchant Account ID", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_test_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_b_6 =	array(
	'key' => 'field_5f6a08suyudsdsdbb7e6d6',
	'label' => __("Live Public key", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_live_public_key',
	'type' => 'text',
	'instructions' => __("Login to your Braintree and get public key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_live_mode',
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
	'maxlength' => '',
);
$theme_options_payment_gateway_b_7 =	array(
	'key' => 'field_5f6ayyysdsd0a38e0a3b',
	'label' => __("Live Private key", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_live_private_key',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get private key.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
);
$theme_options_payment_gateway_b_8 =	array(
	'key' => 'field_5f75b419ettte05b12',
	'label' => __("Live Merchant ID", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_live_merchant_id',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get Merchant ID", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_payment_gateway_b_8_2 =	array(
	'key' => 'field_5f75b419etsdsdtte05b12',
	'label' => __("Live Merchant Account ID", 'ultimate-auction-pro-software'),
	'name' => 'uat_braintree_live_merchant_account_id',
	'type' => 'password',
	'instructions' => __("Login to your Braintree and get Merchant Account ID", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_5f6a06287919fwer',
				'operator' => '==',
				'value' => 'uat_braintree_live_mode',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
		'id' => '',
	),
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);



$theme_options_payment_gateway_7 =	array(
	'key' => 'field_5f7585fa901ab',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_bp = array(
	'key' => 'uat_bp_tab',
	'label' => __("Commissions", 'ultimate-auction-pro-software'),
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
$theme_options_bp_0 =	array(
	'key' => 'uat_bp_tab_message',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3>Buyer&#039;s Commission(Buyer&#039;s Premium)</h3><p style=\"float:left\">Site Owner (Admin) can charge commission from the buyers(bidders)</p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_bp_1 = array(
	'key' => 'bp_single_products',
	'label' => __("Single Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bp_2 = array(
	'key' => 'uat_enable_buyers_premium_sp',
	'label' => __("Enable Buyer&#039;s Premium", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium_sp',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products", 'ultimate-auction-pro-software'),
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
	'default_value' => 'no',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_bp_2_1 = array(
	'key' => 'uat_enable_bp_for_bidding_sp',
	'label' => __("Product won by bidding", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_bp_for_bidding_sp',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by bidding", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
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
$theme_options_bp_2_2 = array(
	'key' => 'uat_enable_bp_for_buynow_sp',
	'label' => __("Product won by Buy Now", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_bp_for_buynow_sp',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by Buy Now", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
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

$theme_options_bp_3 =	array(
	'key' => 'uat_stripe_buyers_premium_enable_sp',
	'label' => __("Do you want to automatically debit the Buyer&#039;s premium?", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_buyers_premium_enable_sp',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_4 =	array(
	'key' => 'uat_give_buyers_premium_to_sp',
	'label' => __("Who should receive Buyer&#039;s Premium :", 'ultimate-auction-pro-software'),
	'name' => 'uat_give_buyers_premium_to_sp',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
				'operator' => '==',
				'value' => 'yes',
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
		// 'auction_owner' => __("Auction Owners", 'ultimate-auction-pro-software'),		
	),
	'allow_null' => 0,
	'default_value' => 'admin',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_bp_5 =	array(
	'key' => 'uat_buyers_premium_type_sp',
	'label' => __("What will you charge :", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_type_sp',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_6 = array(
	'key' => 'uat_buyers_premium_amount_sp',
	'label' => __("Mention the Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_amount_sp',
	'type' => 'number',
	'instructions' => __("This field signifies the amount in flat rate or percentage that you have selected above.", 'ultimate-auction-pro-software'),
	'required' => 1,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_7 = 	array(
	'key' => 'uat_buyers_min_premium_sp',
	'label' => __("Minimum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_min_premium_sp',
	'type' => 'number',
	'instructions' => __("This amount is minimum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is below this minimum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_sp',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => '',
	'max' => '',
	'step' => '',
);
$theme_options_bp_77 = 	array(
	'key' => 'uat_buyers_max_premium_sp',
	'label' => __("Maximum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_max_premium_sp',
	'type' => 'number',
	'instructions' => __("This amount is maximum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is above this maximum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_sp',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => 1,
	'max' => '',
	'step' => '',
);

$theme_options_bp_wcfm_1 = array(
	'key' => 'bp_single_products_wcfm',
	'label' => __("Buyer&#039;s Commission(WCFM)", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => __("Site Owner (Admin) can charge commission from the buyers(bidders) from WCFM products", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bp_wcfm_2 = array(
	'key' => 'uat_enable_buyers_premium_sp_wcfm',
	'label' => __("Enable Buyer&#039;s Premium", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium_sp_wcfm',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for WCFM auction products", 'ultimate-auction-pro-software'),
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
	'default_value' => 'no',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_bp_wcfm_3 =	array(
	'key' => 'uat_stripe_buyers_premium_enable_sp_wcfm',
	'label' => __("Do you want to automatically debit the Buyer&#039;s premium?", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_buyers_premium_enable_sp_wcfm',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp_wcfm',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_wcfm_4 =	array(
	'key' => 'uat_give_buyers_premium_to_sp_wcfm',
	'label' => __("Who should receive Buyer&#039;s Premium :", 'ultimate-auction-pro-software'),
	'name' => 'uat_give_buyers_premium_to_sp_wcfm',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp_wcfm',
				'operator' => '==',
				'value' => 'yes',
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
		// 'auction_owner' => __("Auction Owners", 'ultimate-auction-pro-software'),		
	),
	'allow_null' => 0,
	'default_value' => 'admin',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_bp_wcfm_5 =	array(
	'key' => 'uat_buyers_premium_type_sp_wcfm',
	'label' => __("What will you charge :", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_type_sp_wcfm',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp_wcfm',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_wcfm_6 = array(
	'key' => 'uat_buyers_premium_amount_sp_wcfm',
	'label' => __("Mention the Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_amount_sp_wcfm',
	'type' => 'number',
	'instructions' => __("This field signifies the amount in flat rate or percentage that you have selected above.", 'ultimate-auction-pro-software'),
	'required' => 1,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_sp_wcfm',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_wcfm_7 = 	array(
	'key' => 'uat_buyers_min_premium_sp_wcfm',
	'label' => __("Minimum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_min_premium_sp_wcfm',
	'type' => 'number',
	'instructions' => __("This amount is minimum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is below this minimum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_sp_wcfm',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => '',
	'max' => '',
	'step' => '',
);
$theme_options_bp_wcfm_77 = 	array(
	'key' => 'uat_buyers_max_premium_sp_wcfm',
	'label' => __("Maximum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_max_premium_sp_wcfm',
	'type' => 'number',
	'instructions' => __("This amount is maximum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is above this maximum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_sp_wcfm',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => 1,
	'max' => '',
	'step' => '',
);


$theme_options_bp_8 = array(
	'key' => 'bp_events_products',
	'label' => __("Event Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bp_9 = array(
	'key' => 'uat_enable_buyers_premium_ge',
	'label' => __("Enable Buyer&#039;s Premium", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_buyers_premium_ge',
	'type' => 'button_group',
	'instructions' => __("Charge a premium amount over and above Bid Amount from Bidder to admin or auction owner.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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

$theme_options_bp_9_1 = array(
	'key' => 'uat_enable_bp_for_bidding_ge',
	'label' => __("Product won by bidding", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_bp_for_bidding_ge',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by bidding", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
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
$theme_options_bp_9_2 = array(
	'key' => 'uat_enable_bp_for_buynow_ge',
	'label' => __("Product won by Buy Now", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_bp_for_buynow_ge',
	'type' => 'button_group',
	'instructions' => __("Do you want to enable Buyers Commission for auction products won by Buy Now", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
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

$theme_options_bp_1_2 =	array(
	'key' => 'uat_stripe_buyers_premium_enable_ge',
	'label' => __("Do you want to automatically debit the Buyer&#039;s premium?", 'ultimate-auction-pro-software'),
	'name' => 'uat_stripe_buyers_premium_enable_ge',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_1_3 =	array(
	'key' => 'uat_give_buyers_premium_to_ge',
	'label' => __("Who should receive Buyer&#039;s Premium :", 'ultimate-auction-pro-software'),
	'name' => 'uat_give_buyers_premium_to_ge',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
				'operator' => '==',
				'value' => 'yes',
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
		// 'auction_owner' => __("Auction Owners", 'ultimate-auction-pro-software'),		
	),
	'allow_null' => 0,
	'default_value' => 'admin',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_bp_1_4 =	array(
	'key' => 'uat_buyers_premium_type_ge',
	'label' => __("What will you charge :", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_type_ge',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_1_5 = array(
	'key' => 'uat_buyers_premium_amount_ge',
	'label' => __("Mention the Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_premium_amount_ge',
	'type' => 'number',
	'instructions' => __("This field signifies the amount in flat rate or percentage that you have selected above.", 'ultimate-auction-pro-software'),
	'required' => 1,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_buyers_premium_ge',
				'operator' => '==',
				'value' => 'yes',
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
$theme_options_bp_1_6 = 	array(
	'key' => 'uat_buyers_min_premium_ge',
	'label' => __("Minimum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_min_premium_ge',
	'type' => 'number',
	'instructions' => __("This amount is minimum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is below this minimum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_ge',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => '',
	'max' => '',
	'step' => '',
);
$theme_options_bp_1_7 = 	array(
	'key' => 'uat_buyers_max_premium_ge',
	'label' => __("Maximum Premium Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyers_max_premium_ge',
	'type' => 'number',
	'instructions' => __("This amount is maximum buyer&#039;s premium amount in unit of currency that will be applicable. If the amount calculated in percentage is above this maximum amount then this amount will be charged.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_buyers_premium_type_ge',
				'operator' => '==',
				'value' => 'percentage',
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
	'min' => 1,
	'max' => '',
	'step' => '',
);



$theme_options_bp_10 = array(
	'key' => 'field_15f7sadc63sfa5c7ccs',
	'label' => __("Seller Commission Settings", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	// 'instructions' => __('Commission settings for sellers products', 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bp_11 = array(
	'key' => 'uat_admin_commission_percentage',
	'name' => 'uat_admin_commission_percentage',
	'label' => __("Commission percentage", 'ultimate-auction-pro-software'),
	'instructions' => __("Please enter the commission percentage you wish to earn from the seller's products", 'ultimate-auction-pro-software'),
	'required' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
		'style' => 'border-top: 0px;',
	),
	'default_value' => '0',
	'type' => 'number',
	'placeholder' => __("Enter the commission percentage", 'ultimate-auction-pro-software'),
	'maxlength' => '',
	'min' => '0',
);
$theme_options_bp_16 =	array(
	'key' => 'uat_bp_end_tab',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_cc =	array(
	'key' => 'uat_credit_cart_setting',
	'label' => __("Credit Card (Hold & Debit)", 'ultimate-auction-pro-software'),
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
$theme_options_cc_0 =	array(
	'key' => 'uat_credit_tab_message',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Credit Card (Hold & Debit)</h3>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_cc_1 = array(
	'key' => 'credit_card_single_products',
	'label' => __("Single Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_cc_2 =	array(
	'key' => 'uat_enable_credit_cart_sp_products',
	'label' => __("Enable feature of Credit Card (Hold & Debit).", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_credit_cart_sp_products',
	'type' => 'button_group',
	'instructions' => __("Enable feature of Credit Card (Hold & Debit).", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
$theme_options_cc_3 =	array(
	'key' => 'uat_autodebit_sp_header',
	'label' => __("Auto Debit Options for Vendor Auction.", 'ultimate-auction-pro-software'),
	'name' => 'uat_autodebit_sp_header',
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'layout' => 'horizontal',
);
$theme_options_cc_3_1 =	array(
	'key' => 'uat_enable_autodebit_vendor_sp_products',
	'label' => __("Enable Auto Debit Options for Vendor Auction.", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_autodebit_vendor_sp_products',
	'type' => 'button_group',
	'instructions' => __("Enable Auto Debit Options for Vendor Auction.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
$theme_options_cc_3_2 =	array(
	'key' => 'uat_autodebit_vendor_type_sp',
	'label' => __("Auto Debit Options", 'ultimate-auction-pro-software'),
	'name' => 'uat_autodebit_vendor_type_sp',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_autodebit_vendor_sp_products',
				'operator' => '==',
				'value' => 'yes',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'uat_full' => __("Full Bid Amount", 'ultimate-auction-pro-software'),
		'uat_partial' => __("Partial Bid Amount", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'uat_full',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_cc_3_3 =	array(
	'key' => 'uat_autodebit_vendor_amount_type_sp',
	'label' => __("Partially bid amount type.", 'ultimate-auction-pro-software'),
	'name' => 'uat_autodebit_vendor_amount_type_sp',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_autodebit_vendor_sp_products',
				'operator' => '==',
				'value' => 'yes',
			),
			array(
				'field' => 'uat_autodebit_vendor_type_sp',
				'operator' => '==',
				'value' => 'uat_partial',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'flat' => __("Flat rate", 'ultimate-auction-pro-software'),
		'percentage' => __("Percentage", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'flat',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_cc_3_4 = array(
	'key' => 'uat_autodebit_vendor_amount_sp',
	'label' => __("Mention the Charge", 'ultimate-auction-pro-software'),
	'name' => 'uat_autodebit_vendor_amount_sp',
	'type' => 'number',
	'instructions' => __("This field signifies the amount in flat rate or percentage that you have selected above.", 'ultimate-auction-pro-software'),
	'required' => 1,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_enable_autodebit_vendor_sp_products',
				'operator' => '==',
				'value' => 'yes',
			),
			array(
				'field' => 'uat_autodebit_vendor_type_sp',
				'operator' => '==',
				'value' => 'uat_partial',
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
	'min' => 1,
	'max' => '',
	'step' => '',
);


$theme_options_cc_7 = array(
	'key' => 'credit_cart_events_products',
	'label' => __("Event Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_cc_8 =	array(
	'key' => 'uat_enable_credit_cart_sp_events',
	'label' => __("Enable Credit Card", 'ultimate-auction-pro-software'),
	'name' => 'uat_enable_credit_cart_sp_events',
	'type' => 'button_group',
	'instructions' => __("Enable Credit Card.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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

$theme_options_cc_13 =	array(
	'key' => 'uat_credit_card_end_tab',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);

$theme_options_cc_13 =	array(
	'key' => 'uat_credit_card_end_tab',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);

$theme_options_fs =	array(
	'key' => 'uat_fix_shipping_setting',
	'label' => __("Orders & Shipping", 'ultimate-auction-pro-software'),
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
$order_page = admin_url('edit.php?post_type=shop_order');
$shiping_page = admin_url('admin.php?page=wc-settings&tab=shipping');
$theme_options_fs_0 = 	array(
	'key' => 'uat_fix_shipping_setting_reset',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => sprintf(__("<h3>Orders & Shipping</h3><p style=\"float:left\">When an auction event or single product expires then the settings given below will make sure if an automatic WooCommerce <a href=\"%s\" >Order</a> will be generated or not. If the order is generated automatically then admin can only charge a fixed shipping cost whose setting is provided below. Else WooCommerce <a href=\"%s\" >shipping</a> will apply to the expired products.</p>", 'ultimate-auction-pro-software'), $order_page, $shiping_page),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_os_1 =	array(
	'key' => 'uat_auto_order_enable',
	'label' => __("Enable auto order", 'ultimate-auction-pro-software'),
	'name' => 'uat_auto_order_enable',
	'type' => 'button_group',
	'instructions' => __("Do you want to automatically generate a WooCommerce Order?", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Yes, Generate It", 'ultimate-auction-pro-software'),
		'disable' => __("No, Show Pay Now option.", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_fs_1 =	array(
	'key' => 'uat_fix_shipping',
	'label' => __("Enable Fix Shipping", 'ultimate-auction-pro-software'),
	'name' => 'uat_fix_shipping',
	'type' => 'button_group',
	'instructions' => __("Enable Fix Shipping if you want add fix shipping while generate automatically order when auction expired.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_auto_order_enable',
				'operator' => '==',
				'value' => 'enable',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Yes", 'ultimate-auction-pro-software'),
		'disable' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_fs_2 = array(
	'key' => 'uat_fix_shipping_amount',
	'label' => __("Mention the fixed shipping cost", 'ultimate-auction-pro-software'),
	'name' => 'uat_fix_shipping_amount',
	'type' => 'number',
	'instructions' => __("Enter the cost", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fix_shipping',
				'operator' => '==',
				'value' => 'enable',
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
	'min' => 1,
	'max' => '',
	'step' => '',
);
$theme_options_fs_22 = array(
	'key' => 'uat_fix_shipping_title',
	'label' => __("Fixed shipping title", 'ultimate-auction-pro-software'),
	'name' => 'uat_fix_shipping_title',
	'type' => 'text',
	'instructions' => __("Enter Fixed shipping title", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fix_shipping',
				'operator' => '==',
				'value' => 'enable',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => 'Fix rate shipping',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',

);
$theme_options_sniping = array(
	'key' => 'uat_sniping_tab',
	'label' => __("Timer/Bid Sniping", 'ultimate-auction-pro-software'),
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
$theme_options_sniping_0 = 	array(
	'key' => 'field_anti_sniping_reset',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">" . __("Timer/Bid Sniping", 'ultimate-auction-pro-software') . "</h3>
	<p style=\"float:right\"><a class=\"reset-uat-anti_snipping-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\" button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);

$theme_options_timer = array(
	'key' => 'timer_type',
	'label' => __("Choose from where Countdown Timer would get time:", 'ultimate-auction-pro-software'),
	'name' => 'timer_type',
	'type' => 'button_group',
	'instructions' => __("Turn on to set anti sniping feature on auction products.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'timer_jquery' => __("Local - Ideal when Bidders are in single timezone (Recommended)", 'ultimate-auction-pro-software'),
		'timer_react' => __("Global - Ideal when Bidders are all over the World.", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'timer_jquery',
	'layout' => 'horizontal',
	'return_format' => 'value',
);


$theme_options_sniping_1 = array(
	'key' => 'uat_anti_snipping_enable',
	'label' => __("Do you want to enable anti sniping feature?", 'ultimate-auction-pro-software'),
	'name' => 'uat_anti_snipping_enable',
	'type' => 'button_group',
	'instructions' => __("Turn on to set anti sniping feature on auction products.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'on' => __("Yes", 'ultimate-auction-pro-software'),
		'off' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'off',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_sniping_2 =	array(
	'key' => 'uat_aviod_snipping_type',
	'label' => __("Anti sniping type", 'ultimate-auction-pro-software'),
	'name' => 'uat_aviod_snipping_type',
	'type' => 'button_group',
	'instructions' => __("Select anti sniping type for auction products.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'snipping_recursive' => __("Extend Auction in recursive manner", 'ultimate-auction-pro-software'),
		'snipping_only_once' => __("Extend Auction only once", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'snipping_only_once',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_sniping_anti_sniping_timer_update_notification =	array(
	'key' => 'anti_sniping_timer_update_notification',
	'label' => __("How should users see an updated time left (Timer value)?", 'ultimate-auction-pro-software'),
	'name' => 'anti_sniping_timer_update_notification',
	'type' => 'button_group',
	'instructions' => __("When a user places a bid which invokes anti-sniping (soft-close) then the time left will change and thus the timer shown on the page has to be updated to show correct present value. Since other users who were already seeing the product detail page, it is imperative for them to see the updated time left and the best way to update timer value on their product detail page would be to
Automatic Page Refresh
Manual Page Refresh
As admin you can choose among these two values.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'auto_page_refresh' => __("Auto Page Refresh", 'ultimate-auction-pro-software'),
		'manual_page_refresh' => __("Manual Page Refresh", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'snipping_only_once',
	'layout' => 'horizontal',
	'return_format' => 'value',
);


$theme_options_sniping_anti_sniping_timer_update_notification_2 =	array(
	'key' => 'anti_sniping_clock_msg',
	'label' => __("What message to show when timer has changed?", 'ultimate-auction-pro-software'),
	'name' => 'anti_sniping_clock_msg',
	'type' => 'textarea',
	'instructions' => __("Enter the text that displays in the copyright bar. HTML markup can be used.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_copyright_bar',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'default_value' => __("Time left has changed due to soft-close", 'ultimate-auction-pro-software'),
	'placeholder' => '',
	'maxlength' => '',
	'rows' => 4,
	'new_lines' => 'br',
);



$theme_options_sniping_3 =	array(
	'key' => 'uat_auto_extend_when',
	'label' => __("Specify the time left when it should trigger", 'ultimate-auction-pro-software'),
	'name' => 'uat_auto_extend_when',
	'type' => 'text',
	'instructions' => __("Enter hours to time left", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '0',
	'type' => 'number',
	'placeholder' => 'Hours',
	'maxlength' => '',
);
$theme_options_sniping_4 =	array(
	'key' => 'uat_auto_extend_when_m',
	'name' => 'uat_auto_extend_when_m',
	'type' => 'text',
	'instructions' => __("Enter minutes to time left", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '5',
	'type' => 'number',
	'placeholder' => 'Minutes',
	'maxlength' => '',
);
$theme_options_sniping_5 =	array(
	'key' => 'uat_auto_extend_time',
	'label' => __("Specify the time which the timer (Time Left) should reset to", 'ultimate-auction-pro-software'),
	'name' => 'uat_auto_extend_time',
	'type' => 'text',
	'instructions' => __("Enter hours to time left", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '0',
	'type' => 'number',
	'placeholder' => 'Hours',
	'maxlength' => '',
);
$theme_options_sniping_6 =	array(
	'key' => 'uat_auto_extend_time_m',
	'name' => 'uat_auto_extend_time_m',
	'type' => 'text',
	'instructions' => __("Enter minutes to time left", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_anti_snipping_enable',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '5',
	'type' => 'number',
	'placeholder' => 'Minutes',
	'maxlength' => '',
);
$theme_options_sniping_7 =	array(
	'key' => 'uat_snipping_end_tab',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_bid_increment = array(
	'key' => 'uat_bid_increment_tab',
	'label' => __("Bid Increment", 'ultimate-auction-pro-software'),
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
);
$theme_options_bid_increment_tab = array(
	'key' => 'field_5f7c57e31ddf82114',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Bid Increment</h3><p style=\"float:right\"><a class=\"reset-uat-bid-increment-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_bid_increment_tab_0 = array(
	'key' => 'uat_bid_increment_tab_event',
	'label' => __("Event Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bid_increment_tab_1 = array(
	'key' => 'field_5fa27e41f8a16223e',
	'label' => __("Set Bid Increment", 'ultimate-auction-pro-software'),
	'name' => 'uat_global_bid_increment_event',
	'type' => 'number',
	'instructions' => __("Set default Bid Increment for all events", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '1',
	'placeholder' => '',
	'prepend' => '',
);
$theme_options_bid_increment_tab_2 =	array(
	'key' => 'field_5e9808585b30eddde',
	'label' => __("Set Variable Incremental Price", 'ultimate-auction-pro-software'),
	'name' => 'uat_global_var_incremental_price_event',
	'type' => 'repeater',
	'instructions' => __("Set default Variable Bid Increment for all events", 'ultimate-auction-pro-software'),
	'required' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'ss',
		'id' => 'variable_bid_table',
	),
	'collapsed' => '',
	'min' => 0,
	'max' => 0,
	'layout' => 'table',
	'button_label' => __("Add Interval", 'ultimate-auction-pro-software'),
	'sub_fields' => array(
		array(
			'key' => 'start',
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
			'key' => 'field_5e9809a8c239d232',
			'label' => __("End Price", 'ultimate-auction-pro-software'),
			'name' => 'end',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'onword-text',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => __("End Price", 'ultimate-auction-pro-software'),
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5e980a136cb87232',
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
);
$theme_options_bid_increment_tab_product_0 = array(
	'key' => 'uat_bid_increment_tab_',
	'label' => __("Product", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_bid_increment_tab_product_1 = array(
	'key' => 'field_5fa27e41f8a16223',
	'label' => __("Set Bid Increment", 'ultimate-auction-pro-software'),
	'name' => 'uat_global_bid_increment',
	'type' => 'number',
	'instructions' => __("Set default Bid Increment for all auctions", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '1',
	'placeholder' => '',
	'prepend' => '',
);
$theme_options_bid_increment_tab_product_2 =	array(
	'key' => 'field_5e9808585b30eddd',
	'label' => __("Set Variable Incremental Price", 'ultimate-auction-pro-software'),
	'name' => 'uat_global_var_incremental_price',
	'type' => 'repeater',
	'instructions' => __("Set default Variable Bid Increment for all auctions", 'ultimate-auction-pro-software'),
	'required' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'ss',
		'id' => 'variable_bid_table',
	),
	'collapsed' => '',
	'min' => 0,
	'max' => 0,
	'layout' => 'table',
	'button_label' => __("Add Interval", 'ultimate-auction-pro-software'),
	'sub_fields' => array(
		array(
			'key' => 'start',
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
			'key' => 'field_5e9809a8c239d232',
			'label' => __("End Price", 'ultimate-auction-pro-software'),
			'name' => 'end',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => 'onword-text',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => __("End Price", 'ultimate-auction-pro-software'),
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5e980a136cb87232',
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
);

$theme_options_auction_tabs_end_bids = array(
	'key' => 'uat_bid_increment_tab_end',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_logs = array(
	'key' => 'field_5f7585ac8b015',
	'label' => __("Log Type", 'ultimate-auction-pro-software'),
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
);
$theme_options_logs_0 = array(
	'key' => 'field_5f7c402ad8819',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Logs Activity</h3><p style=\"float:right\"><a class=\"reset-log-activity-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_logs_1 =	array(
	'key' => 'field_5f6ad888099b1',
	'label' => __("Bid Logs", 'ultimate-auction-pro-software'),
	'name' => 'uat_bids_logs',
	'type' => 'button_group',
	'instructions' => __("Enable to keep a log of Placed Bid,Placed Bid Auto,Changed New Maximum Bid, Increased Max Bid,Bids Delete by admin etc.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'enable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_logs_2 =	array(
	'key' => 'field_5f6ae5bea3b18',
	'label' => __("Payment Hold", 'ultimate-auction-pro-software'),
	'name' => 'uat_payment_hold_logs',
	'type' => 'button_group',
	'instructions' => __("You can enable or disable Payment Hold logs.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => 'Enable',
		'disable' => 'Disable',
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_logs_3 =	array(
	'key' => 'field_5f6ae5bea3b1823',
	'label' => __("Payment Hold & Debit", 'ultimate-auction-pro-software'),
	'name' => 'ua_payment_hold_debit_logs',
	'type' => 'button_group',
	'instructions' => __("You can enable or disable API logs.API Logs includes Payment hold, Auto Debit.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'enable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_logs_4 =	array(
	'key' => 'field_5f6b260c4f4eb',
	'label' => __("Payment Direct Debit", 'ultimate-auction-pro-software'),
	'name' => 'ua_payment_direct_debit_logs',
	'type' => 'button_group',
	'instructions' => __("You can enable disable API logs.	API Logs includes Payment hold, Auto Debit etc.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_logs_5 =	array(
	'key' => 'field_5f6b260c4f4eb2',
	'label' => __("API Requests", 'ultimate-auction-pro-software'),
	'name' => 'uat_api_requests_logs',
	'type' => 'button_group',
	'instructions' => __("You can enable disable API logs.	API Logs includes Payment hold, Auto Debit etc.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'enable' => __("Enable", 'ultimate-auction-pro-software'),
		'disable' => __("Disable", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'disable',
	'layout' => 'horizontal',
	'return_format' => 'array',
);
$theme_options_logs_6 =	array(
	'key' => 'field_5f7c57d01ddf6',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
$theme_options_auction = array(
	'key' => 'uat_auction_settings_tab',
	'label' => __("Auction Settings", 'ultimate-auction-pro-software'),
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
);



$theme_options_auction_general = array(
	'key' => 'field_5f7c57e31ddf8',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Auction Settings</h3><p style=\"float:right\"><a class=\"reset-uat-page-auction-general-setting-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_auction_general_0 = array(
	'key' => 'theme_options_auction_general',
	'label' => __("Settings: General Auction", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_auction_general_1 = array(
	'key' => 'field_5fa27e41f8a16',
	'label' => __("Bidding Restriction", 'ultimate-auction-pro-software'),
	'name' => 'uat_can_max_bid_amt',
	'type' => 'number',
	'instructions' => __("You can set maximum bidding amount here. Default is 999,999,999,999.99", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'regular-number',
		'id' => '',
	),
	'default_value' => '999999999999.99',
	'placeholder' => '',
	'prepend' => '',
	'append' => 'Default is 999,999,999,999.99',
	'min' => '',
	'max' => '',
	'step' => '',
);
$theme_options_auction_general_2 =	array(
	'key' => 'field_5fa281e4bba28',
	'label' => __("Confirmation Alert when places a bid.", 'ultimate-auction-pro-software'),
	'name' => 'uat_bid_place_warning',
	'type' => 'button_group',
	'instructions' => __("Turn on to an alert box for confirmation when user places a bid.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);
$theme_options_auction_general_3 =	array(
	'key' => 'field_5fa2807221f29',
	'label' => __("Administrator to bid on their own auction.", 'ultimate-auction-pro-software'),
	'name' => 'uat_allow_admin_to_bid',
	'type' => 'button_group',
	'instructions' => __("Turn on to allow Administrator to bid on their own auction.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);
$theme_options_auction_general_4 = array(
	'key' => 'field_6037b3556e7ca',
	'label' => __("Badge image URL", 'ultimate-auction-pro-software'),
	'name' => 'uat_badge_image_url',
	'type' => 'image',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'return_format' => 'url',
	'preview_size' => 'medium',
	'library' => 'all',
	'min_width' => '',
	'min_height' => '',
	'min_size' => '',
	'max_width' => '',
	'max_height' => '',
	'max_size' => '',
	'mime_types' => '',
);
$theme_options_auction_general_44 = array(
	'key' => 'uat_hide_saved_for_desktop',
	'label' => __("Hide Save/Watch Icon For Desktop", 'ultimate-auction-pro-software'),
	'name' => 'uat_hide_saved_for_desktop',
	'type' => 'button_group',
	'instructions' => __("Turn On to hide Save/Watch Icon For Desktop", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);
$theme_options_auction_general_444 = array(
	'key' => 'uat_hide_saved_for_mobile',
	'label' => __("Hide Save/Watch Icon For Mobile", 'ultimate-auction-pro-software'),
	'name' => 'uat_hide_saved_for_mobile',
	'type' => 'button_group',
	'instructions' => __("Turn On to hide Save/Watch Icon For Mobile", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);

$theme_options_auction_general_5 =	array(
	'key' => 'field_5fa280fc14ac0',
	'label' => __("Auction Owner to bid on their own auction.", 'ultimate-auction-pro-software'),
	'name' => 'uat_allow_owner_to_bid',
	'type' => 'button_group',
	'instructions' => __("Turn on to allow Auction Owner to bid on their own auction.", 'ultimate-auction-pro-software'),
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

$theme_options_auction_general_7 =	array(
	'key' => 'uat_fee_to_place_bid',
	'label' => __("Do you want users to pay a bidding fee before placing their first bid", 'ultimate-auction-pro-software'),
	'name' => 'uat_fee_to_place_bid',
	'type' => 'button_group',
	// 'instructions' => __("Take one time fee before first bid place", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
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

$theme_options_listpage_sync_clock_enable =	array(
	'key' => 'uwa_listpage_sync_clock_enable',
	'label' => __("Sync Timer on Auction List Page", 'ultimate-auction-pro-software'),
	'name' => 'uwa_listpage_sync_clock_enable',
	'type' => 'button_group',
	'instructions' => __("When this checkbox is enabled then once the page loads, after five seconds an AJAX request will be sent to server to get server time and calculate the time left for expiration and update the timer of the product. We have given this provision if site takes too long to load and due to this the timer might have a lag and to overcome this lag, we have provided this setting. Please note that enabling this setting will increase number of AJAX request calls to the server which might lead to stress on the server.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("ON", 'ultimate-auction-pro-software'),
		'no' => __("OFF", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'no',
	'layout' => 'horizontal',
	'return_format' => 'value',
);


$bid_pop_on_list_page =	array(
	'key' => 'uat_bid_pop_on_list_page',
	'label' => __("Do you want to place bid using pop-up window on product list page?", 'ultimate-auction-pro-software'),
	'name' => 'uat_bid_pop_on_list_page',
	'type' => 'button_group',
	// 'instructions' => __("Take one time fee before first bid place", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'on' => __("Yes", 'ultimate-auction-pro-software'),
		'off' => __("No", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'off',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_auction_general_8 = array(
	'key' => 'field_options_to_place_bid_fee_type',
	'label' => __('Options to one time fee types', 'ultimate-auction-pro-software'),
	'name' => 'field_options_to_place_bid_fee_type',
	'type' => 'radio',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fee_to_place_bid',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
		'style' => 'border-top: 0px;',
	),
	'choices' => array(
		'fee-for-any-products' =>  __('Do you want users to pay a one time fee to bid for any product, <div class="tooltipopt-container"><a href="" onclick="return false"> Read more?</a><span class="tooltipopt">Each user has to pay a fee when they are placing their first bid on the website. After successful payment, user can place any number of bids on any product on the website.</span></div>', 'ultimate-auction-pro-software'),
		'fee-for-new-products' =>  __('Do you want users to pay a fee each time they bid on a new product, <div class="tooltipopt-container"><a href="" onclick="return false"> Read more?</a><span class="tooltipopt">Each user has to pay a fee when they are placing their first bid on every product on the website. After successful payment, user can place any number of bids on that particular product.</span></div>', 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'other_choice' => 0,
	'default_value' => 'fee-for-any-products',
	'layout' => 'vertical',
	'return_format' => 'value',
	'save_other_choice' => 0,
);
$theme_options_auction_general_9 =	array(
	'key' => 'field_options_to_place_bid_fee_amount',
	'name' => 'field_options_to_place_bid_fee_amount',
	'type' => 'text',
	'label' => __("Enter Fee Amount", 'ultimate-auction-pro-software'),
	// 'instructions' => __("Enter Fee Amount", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fee_to_place_bid',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => 'regular-number',
		'id' => '',
		'style' => 'border-top: 0px;',
	),
	'default_value' => '1',
	'type' => 'number',
	'placeholder' => __("Fee Amount", 'ultimate-auction-pro-software'),
	'maxlength' => '',
	'min' => '1',

);
$theme_options_auction_general_10 =	array(
	'key' => 'field_options_to_place_bid_fee_popup_btn_text',
	'name' => 'field_options_to_place_bid_fee_popup_btn_text',
	'type' => 'text',
	'label' => __("Mention Button label in displayed in Alert pop-up.", 'ultimate-auction-pro-software'),
	// 'instructions' => __("Enter Fee Amount", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fee_to_place_bid',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		// 'width' => '50',
		'class' => '',
		'id' => '',
		'style' => 'border-top: 0px;',
	),
	'default_value' => __('Pay Now', 'ultimate-auction-pro-software'),
	'type' => 'text',
	'placeholder' => __("Pay Button Label", 'ultimate-auction-pro-software'),
	'maxlength' => '',
	'min' => '1',

);


$theme_options_auction_general_address_mandatory =	array(
	'key' => 'uat_address_mandatory_bid_place',
	'label' => __("Do you want users to fill their shipping address before they place their bids?", 'ultimate-auction-pro-software'),
	'name' => 'uat_address_mandatory_bid_place',
	'type' => 'button_group',

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
);
$theme_options_auction_general_billing_address_mandatory =	array(
	'key' => 'uat_billing_address_mandatory_bid_place',
	'label' => __("Do you want users to fill their billing address before they place their bids?", 'ultimate-auction-pro-software'),
	'name' => 'uat_billing_address_mandatory_bid_place',
	'type' => 'button_group',

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
	'default_value' => 'true',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_auction_general_11 =	array(
	'key' => 'field_options_to_place_bid_fee_popup_text',
	'name' => 'field_options_to_place_bid_fee_popup_text',
	'type' => 'textarea',
	'label' => __("Mention the text message displayed in Alert pop-up", 'ultimate-auction-pro-software'),
	// 'instructions' => __("Enter Fee Amount", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_fee_to_place_bid',
				'operator' => '==',
				'value' => "on",
			),
		),
	),
	'wrapper' => array(
		// 'width' => '50',
		'class' => '',
		'id' => '',
		'style' => 'border-top: 0px;',
	),
	'default_value' => __("You need to pay fee once before placing your first bid on the website. After successful payment, you can place any number of bids on any product on the website.", 'ultimate-auction-pro-software'),
	'type' => 'textarea',
	'placeholder' => __("Display Text", 'ultimate-auction-pro-software'),
	'maxlength' => '',
	'min' => '1',

);
$theme_options_auction_events = array(
	'key' => 'field_5f7c63a59a615',
	'label' => __("Settings: Auction Event", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_auction_events_0 =	array(
	'key' => 'uat_google_maps_api_key',
	'label' => __("Google Maps API Key", 'ultimate-auction-pro-software'),
	'name' => 'uat_google_maps_api_key',
	'type' => 'text',
	'instructions' => __("Follow the steps in <a href=\"https://developers.google.com/maps/documentation/javascript/get-api-key#key\" target=\"_blank\" >the Google docs</a> to get the API key. This key applies to Event location map.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'default_value' => '',
	'placeholder' => '',
	'prepend' => '',
	'append' => '',
	'maxlength' => '',
);
$theme_options_auction_simple = array(
	'key' => 'field_5f7c6319ebc0b2',
	'label' => __("Settings: Simple Auction", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_auction_simple_0 = array(
	'key' => 'field_5fa2ad9da677f2',
	'label' => __("Mask Username.", 'ultimate-auction-pro-software'),
	'name' => 'uat_simple_maskusername_enable',
	'type' => 'button_group',
	'instructions' => __("if you enable this setting then username will be replaced with asterisk like ****** and username will not be displayed. ", 'ultimate-auction-pro-software'),
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
$theme_options_auction_simple_00 = array(
	'key' => 'hide_quick_bid_buttons_simple',
	'label' => __("Hide Quick bid buttons", 'ultimate-auction-pro-software'),
	'name' => 'hide_quick_bid_buttons_simple',
	'type' => 'button_group',
	'instructions' => __("Turn On to Hide Quick bid buttons", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);




$theme_options_auction_proxy =	array(
	'key' => 'field_5f7c6319ebc0b22',
	'label' => __("Settings: Proxy Auction", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_auction_proxy_0 =	array(
	'key' => 'field_5fa2ad9da677f22',
	'label' => __("Mask Username.", 'ultimate-auction-pro-software'),
	'name' => 'uat_proxy_maskusername_enable',
	'type' => 'button_group',
	'instructions' => __("if you enable this setting then username will be replaced with asterisk like ****** and username will not be displayed. ", 'ultimate-auction-pro-software'),
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
$theme_options_auction_proxy_00 = array(
	'key' => 'hide_quick_bid_buttons_proxy',
	'label' => __("Hide Quick bid buttons", 'ultimate-auction-pro-software'),
	'name' => 'hide_quick_bid_buttons_proxy',
	'type' => 'button_group',
	'instructions' => __("Turn On to Hide Quick bid buttons", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);
$theme_options_auction_proxy_000 = array(
	'key' => 'hide_direct_bid_proxy',
	'label' => __("Hide Direct Bid box", 'ultimate-auction-pro-software'),
	'name' => 'hide_direct_bid_proxy',
	'type' => 'button_group',
	'instructions' => __("Turn On to Hide Direct Bid box", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
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
);

$theme_options_auction_proxy_1 = array(
	'key' => 'field_5fa2ad9da677f222',
	'label' => __("Mask Bid Amount", 'ultimate-auction-pro-software'),
	'name' => 'uat_proxy_maskbid_enable',
	'type' => 'button_group',
	'instructions' => __("if you enable this setting then amount will be replaced with asterisk like ******.", 'ultimate-auction-pro-software'),
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
$theme_options_auction_proxy_2 = 	array(
	'key' => 'field_5fa2ad9da677f2223',
	'label' => __("Disable Proxy Bidding to happen for amount less than Reserve Price.", 'ultimate-auction-pro-software'),
	'name' => 'uat_proxy_disable_reserve_price',
	'type' => 'button_group',
	'instructions' => __("Proxy Bidding is by default enabled for all bidding amounts but you can disable proxy bidding for bidding amount which are less than reserve price. This setting will help administrator who wants to have simple bidding before reserve price is reached.	", 'ultimate-auction-pro-software'),
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
$theme_options_auction_proxy_3 = 	array(
	'key' => 'uat_proxy_autobid_accept_bid',
	'label' => __('Autobid option for bid place', 'ultimate-auction-pro-software'),
	'name' => 'uat_proxy_autobid_accept_bid',
	'type' => 'radio',
	'instructions' => '',
	'required' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'autobid-only-maximum' =>  __('Autobid only set maximum bid', 'ultimate-auction-pro-software'),
		'autobid-with-bid' =>  __('Autobid set maximum bid with bid place', 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'other_choice' => 0,
	'default_value' => 'autobid-with-bid',
	'layout' => 'vertical',
	'return_format' => 'value',
	'save_other_choice' => 0,
);
$theme_options_auction_silent = array(
	'key' => 'field_5f7c6319ebc0b2267',
	'label' => __("Settings: Silent Auction", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_auction_silent_0 = array(
	'key' => 'field_5fa2ad9da677f227',
	'label' => __("Mask Username.", 'ultimate-auction-pro-software'),
	'name' => 'uat_silent_maskusername_enable',
	'type' => 'button_group',
	'instructions' => __("if you enable this setting then username will be replaced with asterisk like ****** and username will not be displayed. ", 'ultimate-auction-pro-software'),
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
$theme_options_auction_silent_1 = array(
	'key' => 'field_5fa2ad9da677f22234',
	'label' => __("Mask Bid Amount", 'ultimate-auction-pro-software'),
	'name' => 'uat_silent_maskbid_enable',
	'type' => 'button_group',
	'instructions' => __("if you enable this setting then amount will be replaced with asterisk like ******.", 'ultimate-auction-pro-software'),
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
$theme_options_auction_silent_2 =  array(
	'key' => 'field_5fa2ad9da677f2223489',
	'label' => __("Restrict users to bid only one time.", 'ultimate-auction-pro-software'),
	'name' => 'uat_restrict_bidder_enable',
	'type' => 'button_group',
	'instructions' => __("In reality, Silent auctions accept single bid from each user. You can check this field to allow single bid for each user.", 'ultimate-auction-pro-software'),
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
$theme_options_auction_tabs_end = array(
	'key' => 'uat_auction_setting_tabs_end',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);


$theme_options_auction_offline_dealing_settings = array(
	'key' => 'uat_offline_dealing_settings',
	'label' => __("Offline Dealing Settings", 'ultimate-auction-pro-software'),
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
);

$theme_options_auction_offline_dealing_settings_0 =	array(
	'key' => 'field_5f7c6f1b17dsds02s234',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3>Offline Dealing Settings</h3><p style=\"float:left\">This feature will let the site owner (admin) enable proper options so that buyer and seller can settle their payment outside of this website and coordinate among themselves to send and receive won product.</p><p style=\"float:right\"></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);

$theme_options_auction_offline_dealing_settings_1 = array(
	'key' => 'field_6585761434008',
	'label' => __("Do you want to enable Offline Dealing for Buyer & Seller", 'ultimate-auction-pro-software'),
	'name' => 'uat_do_you_want_to_enable_offline_dealing_for_buyer_seller',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 0,
	'ui_on_text' => '',
	'ui_off_text' => '',
	'ui' => 1,
);
$theme_options_auction_offline_dealing_settings_2 = array(
	'key' => 'field_6585766134009',
	'label' =>  __("What User information do you want to send to the buyer and seller?", 'ultimate-auction-pro-software'),
	'name' => '',
	'aria-label' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' =>  __("This will ensure that the below fields are shown in the registration form so that all users provide this information.", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_auction_offline_dealing_settings_3 = array(
	'key' => 'field_658576823400a',
	'label' =>  __("Send First & Last Name", 'ultimate-auction-pro-software'),
	'name' => 'uat_send_first_last_name',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);
$theme_options_auction_offline_dealing_settings_4 = array(
	'key' => 'field_658576c23400b',
	'label' => __("Send Mailing Address", 'ultimate-auction-pro-software'),
	'name' => 'uat_send_mailing_address',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);
$theme_options_auction_offline_dealing_settings_5 = array(
	'key' => 'field_658576d13400c',
	'label' =>  __("Send Phone (Mobile) Number", 'ultimate-auction-pro-software'),
	'name' => 'uat_send_phone_mobile_number',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);

$theme_options_auction_offline_dealing_settings_9 = array(
	'key' => 'field_658576d13400c',
	'label' =>  __("Send Seller Address", 'ultimate-auction-pro-software'),
	'name' => 'uat_send_seller_address',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);

$theme_options_auction_offline_dealing_settings_6 = array(
	'key' => 'field_658576eb3400d',
	'label' =>  __("Do you want to send the above information via Email?", 'ultimate-auction-pro-software'),
	'name' => 'uat_do_you_want_to_send_information_via_email',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' =>  __('This option will enable the Auction > Notification > Email > "Won Email". Go to the option and update the "Subject" and "Body" parameters for each recipient.', 'ultimate-auction-pro-software'),
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);
$theme_options_auction_offline_dealing_settings_7 = array(
	'key' => 'field_658577403400e',
	'label' =>  __("Do you want the buyer and seller to view each other's information on the product page?", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyer_and_seller_to_view_each_others_information_on_the_product_page',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => '',
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);
$theme_options_auction_offline_dealing_settings_8 = array(
	'key' => 'field_658577783400f',
	'label' => __('Do you want to share the contact information only when "Buyer\'s Commission" has been automatically debited', 'ultimate-auction-pro-software'),
	'name' => 'uat_only_show_when_buyers_commission_has_been_automatically_debited',
	'aria-label' => '',
	'type' => 'true_false',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => __('This setting will work when as setting of Automatic Debit of Buyers Commission is enabled.', 'ultimate-auction-pro-software'),
	'default_value' => 1,
	'ui' => 1,
	'ui_on_text' => '',
	'ui_off_text' => '',
);

$theme_options_auction_offline_dealing_settings_10 = array(
	'key' => 'field_6585777883400f',
	'label' => __('Message for the Winner', 'ultimate-auction-pro-software'),
	'name' => 'uat_message_for_winner',
	'aria-label' => '',
	'type' => 'wysiwyg',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => __('This Message Visible on Product detail page', 'ultimate-auction-pro-software'),
	'default_value' => '<h5>Congratulations! You have Won!</h5><strong>You can reach out to Seller to finalize the transaction.</strong>',
	'tabs' => 'all',
	'toolbar' => 'full',
	'media_upload' => 0,
	'delay' => 0,
);

$theme_options_auction_offline_dealing_settings_11 = array(
	'key' => 'field_658e50c00a94a',
	'label' =>  __('Dynamic Winning Bid Information and Seller Details', 'ultimate-auction-pro-software'),
	'name' => '',
	'aria-label' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6585761434008',
				'operator' => '==',
				'value' => '1',
			),
		),
	),
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => __('<br/>This Message Visible on Product detail page', 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);

$theme_options_auction_car = array(
	'key' => 'uat_auction_settings_tab_car',
	'label' => __("Vehical Theme Settings", 'ultimate-auction-pro-software'),
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
);

$theme_options_auction_car_0 =	array(
	'key' => 'field_5f7c6f1b17dsds02234',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Vehical Theme Settings</h3>"), 
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_auction_car_001 = array(
	'key' => 'uat_auction_filter_setting',
	'label' => __("Auction Filter Setting", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);

$theme_options_auction_car_1 = array(
	'key' => 'label_auction_filter',
	'label' => __("Auction Filter", 'ultimate-auction-pro-software'),
	'name' => 'label_auction_filter',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'message' => __("The enabled filter will be displayed on the vehicle list page.", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);

$theme_options_auction_car_2 = array(
		'key' => 'ctos_car_years',
		'label' => __("Years", 'ultimate-auction-pro-software'),
		'name' => 'ctos_car_years',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
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
	$theme_options_auction_car_3 = 	array(
		'key' => 'ctos_car_transmission',
		'label' => __("Transmission", 'ultimate-auction-pro-software'),
		'name' => 'ctos_car_transmission',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
	$theme_options_auction_car_4 =	array(
		'key' => 'ctos_car_body_style',
		'label' => __("Body style", 'ultimate-auction-pro-software'),
		'name' => 'ctos_car_body_style',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);

	$theme_options_auction_car_5 =	array(
		'key' => 'label_suction_sorting',
		'label' => __("Auction Sorting", 'ultimate-auction-pro-software'),
		'name' => 'label_suction_sorting',
		'type' => 'message',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'message' => '',
		'new_lines' => 'wpautop',
		'esc_html' => 0,
	);

	$theme_options_auction_car_6 = 	array(
			'key' => 'ctos_car_ending_soon',
			'label' => __("Ending soon", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_ending_soon',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_7 = 	array(
			'key' => 'ctos_car_newly_listed',
			'label' => __("Newly listed", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_newly_listed',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_8 = 	array(
			'key' => 'ctos_car_no_reserve',
			'label' => __("No reserve", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_no_reserve',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_9 = 	array(
			'key' => 'ctos_car_lowest_mileage',
			'label' => __("Lowest mileage", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_lowest_mileage',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_10 = 	array(
			'key' => 'ctos_car_highest_mileage',
			'label' => __("Highest mileage", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_highest_mileage',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);		
	$theme_options_auction_car_11 = 	array(
			'key' => 'ctos_car_recently_ended',
			'label' => __("Recently ended", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_recently_ended',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			    'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_12 = 	array(
			'key' => 'ctos_car_lowest_price',
			'label' => __("Lowest price", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_lowest_price',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			    'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_13 = 	array(
			'key' => 'ctos_car_highest_price',
			'label' => __("Highest price", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_highest_price',
			'type' => 'button_group',
			'instructions' => 'Display In Filter ON/OFF',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			    'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);		
	/*$theme_options_auction_car_14 = 	array(
			'key' => 'front_end_saving_searches_display',
			'label' => __("Front-end Saving Searches display", 'ultimate-auction-pro-software'),
			'name' => 'front_end_saving_searches_display',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		);*/

	$theme_options_auction_car_15 = 	array(
			'key' => 'ctos_car_closest_to_me',
			'label' => __("Closest to me", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_closest_to_me',
			'type' => 'button_group',
			'instructions' =>  __('Display Closest to me ON/OFF', 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			    'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);

	/*$theme_options_auction_car_16 = 	array(
			'key' => 'ctos_car_closest_to_me_enable_logo',
			'label' => __("Show Logo?", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_closest_to_me_enable_logo',
			'type' => 'button_group',
			'instructions' =>  __('Display In Closest to me Popup ON/OFF', 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'ctos_car_closest_to_me',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
			    'on' => __("ON", 'ultimate-auction-pro-software'),
				'off' => __("OFF", 'ultimate-auction-pro-software'),
			),
			'allow_null' => 0,
			'default_value' => '',
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	*/	
	$theme_options_auction_car_17 = 	array(
			'key' => 'ctos_car_closest_to_me_header_title',
			'label' => __("Header title", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_closest_to_me_header_title',
			'type' => 'text',
			'instructions' =>  __('Leave blank to hide popup header title', 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'ctos_car_closest_to_me',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'allow_null' => 0,
			'default_value' => __("Cars closest to me", 'ultimate-auction-pro-software'),
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_18 = 	array(
			'key' => 'ctos_car_closest_to_me_sub_title',
			'label' => __("Sub Header title", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_closest_to_me_sub_title',
			'type' => 'text',
			'instructions' =>  __('Leave blank to hide popup sub header title', 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'ctos_car_closest_to_me',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'allow_null' => 0,
			'default_value' => __("We need your zip code to determine which cars are closest to you.", 'ultimate-auction-pro-software'),
			'layout' => 'horizontal',
			'return_format' => 'value',
		);
	$theme_options_auction_car_19 = 	array(
			'key' => 'ctos_car_closest_to_me_distance_range',
			'label' => __("This field allows you to add custom miles ranges to the dropdown options", 'ultimate-auction-pro-software'),
			'name' => 'ctos_car_closest_to_me_distance_range',
			'type' => 'text',
			'instructions' =>  __('Enter Dynamic Ranges (Zero not allowed, Numbers Only, Comma Separated): Please enter a comma-separated list of numbers and greter then 0 (e.g. 50, 75, 100). The options you enter here will be displayed in the dropdown along with the predefined options (100 miles, 200 miles, etc.)', 'ultimate-auction-pro-software'),
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'ctos_car_closest_to_me',
						'operator' => '==',
						'value' => 'on',
					),
				),
			),
			'wrapper' => array(
				'width' => '30',
				'class' => '',
				'id' => '',
			),
			'allow_null' => 0,
			'default_value' => __("100,150,200,500,1000", 'ultimate-auction-pro-software'),
			'layout' => 'horizontal',
			'return_format' => 'value',
		);

	$theme_options_auction_car_00_end = array(
			'key' => 'uat_auction_setting_tabs_end_all',
			'label' => __("End Tab", 'ultimate-auction-pro-software'),
			'name' => '',
			'type' => 'accordion',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'open' => 0,
			'multi_expand' => 0,
			'endpoint' => 1,
		);

	$theme_options_auction_car_002 = array(
		'key' => 'uat_auction_vehical_detail_setting',
		'label' => __("Vehical Auction Detail Page", 'ultimate-auction-pro-software'),
		'name' => '',
		'type' => 'accordion',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'open' => 0,
		'multi_expand' => 0,
		'endpoint' => 0,
	);

	$theme_options_auction_car_002_01 = array(
		'key' => 'ctos_detail_car_location',
		'label' => __("Location", 'ultimate-auction-pro-software'),
		'name' => 'ctos_detail_car_location',
		'type' => 'button_group',
		'instructions' => 'Turn On to Display Location.',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
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

	$theme_options_auction_car_002_02 = array(
		'key' => 'ctos_detail_car_location_flag',
		'label' => __("Location Country Flag", 'ultimate-auction-pro-software'),
		'name' => 'ctos_detail_car_location_flag',
		'type' => 'button_group',
		'instructions' => 'Turn On to Display Location Country Flag.',
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'ctos_detail_car_location',
					'operator' => '==',
					'value' => "on",
				),
			),
		),
		'wrapper' => array(
			'width' => '30',
			'class' => '',
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

	$theme_options_auction_car_003 = array(
		'key' => 'uat_auction_vehical_list_setting',
		'label' => __("List page grid block", 'ultimate-auction-pro-software'),
		'name' => '',
		'type' => 'accordion',
		'instructions' => '',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '',
			'class' => '',
			'id' => '',
		),
		'open' => 0,
		'multi_expand' => 0,
		'endpoint' => 0,
	);

	$theme_options_auction_car_003_01 = array(
		'key' => 'ctos_grid_car_bid_count',
		'label' => __("Bid Count and RESERVE PRICE Text", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_bid_count',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
	$theme_options_auction_car_003_02 = array(
		'key' => 'ctos_grid_car_current_bid',
		'label' => __("Current / Start Bid", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_current_bid',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
$theme_options_auction_car_003_03 =  array(
		'key' => 'ctos_grid_car_timer',
		'label' => __("Timer", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_timer',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
$theme_options_auction_car_003_04 = array(
		'key' => 'ctos_grid_car_sub_title',
		'label' => __("Sub Title", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_sub_title',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
$theme_options_auction_car_003_05 = array(
		'key' => 'ctos_grid_car_location',
		'label' => __("Location", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_location',
		'type' => 'button_group',
		'instructions' => 'Display In Filter ON/OFF',
		'required' => 0,
		'conditional_logic' => 0,
		'wrapper' => array(
			'width' => '30',
			'class' => '',
			'id' => '',
		),
		'choices' => array(
			'on' => __("ON", 'ultimate-auction-pro-software'),
			'off' => __("OFF", 'ultimate-auction-pro-software'),
		),
		'allow_null' => 0,
		'default_value' => '',
		'layout' => 'horizontal',
		'return_format' => 'value',
	);
	
$theme_options_auction_car_003_06 = array(
		'key' => 'ctos_grid_car_location_flag',
		'label' => __("Location Country Flag", 'ultimate-auction-pro-software'),
		'name' => 'ctos_grid_car_location_flag',
		'type' => 'button_group',
		'instructions' => 'Turn On to Display Location Country Flag.',
		'required' => 0,
		'conditional_logic' => array(
			array(
				array(
					'field' => 'ctos_grid_car_location',
					'operator' => '==',
					'value' => "on",
				),
			),
		),
		'wrapper' => array(
			'width' => '30',
			'class' => '',
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

$theme_options_auction_car_0_end = array(
	'key' => 'uat_auction_setting_tabs_end',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);






$theme_options_pages = array(
	'key' => 'uat_pages_setting_tabs',
	'label' => __("Page Settings", 'ultimate-auction-pro-software'),
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
);
$theme_options_pages_0 =	array(
	'key' => 'field_5f7c6f1b1702234',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">Page Settings</h3><p style=\"float:right\"><a class=\"reset-uat-page-auction-detail-setting-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> </p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_pages_auction_detail_options_to_place_bid_0 = array();
$theme_options_pages_auction_detail_options_to_place_bid_2 = array();

$theme_options_pages_general = array(
	'key' => 'uat_pages_general_setting',
	'label' => __("Page: General Setting", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);

$theme_options_pages_general_1 = array(
	'key' => 'uat_hide_breadcrumbs',
	'label' => __("Hide Breadcrumbs", 'ultimate-auction-pro-software'),
	'name' => 'uat_hide_breadcrumbs',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Breadcrumbs on all Pages.", 'ultimate-auction-pro-software'),
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


$theme_options_pages_auction_detail = array(
	'key' => 'field_5f7c6319ebc0b',
	'label' => __("Page: Auction Product Detail", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_pages_auction_detail_01 = array(
	'key' => 'single_auction_template',
	'label' => 'Single auction page template',
	'name' => 'single_auction_template',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'default' => 'Default',
		'catabook' => 'Catabook',
	),
	'allow_null' => 0,
	'default_value' => 'default',
	'layout' => 'horizontal',
	'return_format' => 'value',
	'save_other_choice' => 0,
);
$theme_options_pages_auction_detail_0 = array(
	'key' => 'field_options_to_place_bid',
	'label' => 'Options to Place Bid',
	'name' => 'field_options_to_place_bid',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '50',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'show-drop-down-with-bid-values' => 'Show Drop Down with bid values',
		'show-text-field-and-quick-bid' => 'Show Text Field and Quick Bid',
	),
	'allow_null' => 0,
	'default_value' => 'show-text-field-and-quick-bid',
	'layout' => 'horizontal',
	'return_format' => 'value',
	'save_other_choice' => 0,
);

$theme_options_pages_auction_detail_2 = array(
	'key' => 'field_5fa2843268107',
	'label' => __("Timer", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_timer',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Timer on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_3 = array();
$theme_options_pages_auction_detail_4 = array(
	'key' => 'field_5fa292da66182',
	'label' => __("Ending On date For Live Auction and Future Auction", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_ending_date',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Ending On date For Live Auction and Future Auction on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_5 = array(
	'key' => 'field_5fa2933e66183',
	'label' => __("Start On date For Future Auction.", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_start_date',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Start On date For Future Auction on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_6 = array(
	'key' => 'field_5fa293a666184',
	'label' =>  __("Timezone", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_timezone',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Timezone on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_66 = array(
	'key' => 'uat_auction_share_button',
	'label' =>  __("Share Button", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_share_button',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Share Button on Product Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_7 = array(
	'key' => 'field_5fa2a36b4d28c',
	'label' => __("Bids Tab", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_bid_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Bids Tab on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_8 = array(
	'key' => 'field_5fa2ac3f9d0ff',
	'label' => 'Terms & Conditions',
	'name' => 'single_terms_conditions_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the TERMS & CONDITIONS on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_88 = array(
	'key' => 'uat_auction_bid_increments_tab',
	'label' => 'Bid Increments Tab',
	'name' => 'uat_auction_bid_increments_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Bid Increments on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_888 = array(
	'key' => 'uat_auction_buyers_premium_tab',
	'label' => __("Buyer's Premium", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_buyers_premium_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Buyer's Premium on Auction Detail Page.", 'ultimate-auction-pro-software'),
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

$theme_options_pages_auction_detail_9 = array(
	'key' => 'field_5fa2acf62c05f',
	'label' => __("Meta Data", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_meta_data',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the Meta Data like category, tags , SKU on Auction Detail Page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_10 = array(
	'key' => 'field_5fa2ad9da677f',
	'label' => __("Related Products", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_related_products',
	'type' => 'button_group',
	'instructions' => __("Enable or disable related(TRENDING ITEMS) products on Auction Detail Page.", 'ultimate-auction-pro-software'),
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

$theme_options_pages_auction_detail_10_time = array(
	'key' => 'related_products_timer',
	'label' => __("Related Products Timer", 'ultimate-auction-pro-software'),
	'name' => 'related_products_timer',
	'type' => 'button_group',
	'instructions' => __("Display countdown clock on Related Products.", 'ultimate-auction-pro-software'),
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
	'default_value' => 'off',
	'layout' => 'horizontal',
	'return_format' => 'value',
);

$theme_options_pages_auction_detail_11 = array(
	'key' => 'uat_auction_comments',
	'label' => __("Comments", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_comments',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to disable comments section on this page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_detail_12 = array(
	'key' => 'uat_auction_bid_comments',
	'label' => __("Show bids in comments", 'ultimate-auction-theme'),
	'name' => 'uat_auction_bid_comments',
	'type' => 'button_group',
	'instructions' => __("Turn ON to Show bids in comments.", 'ultimate-auction-theme'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_auction_comments',
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
		'on' => __("ON", 'ultimate-auction-theme'),
		'off' => __("OFF", 'ultimate-auction-theme'),
	),
	'allow_null' => 0,
	'default_value' => 'on',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_auction_event_detail = array(
	'key' => 'field_5f7c63fa5c7cc',
	'label' => __("Page: Auction Event Detail", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_pages_auction_event_detail_0 = array(
	'key' => 'uat_event_details_page_layout',
	'label' => __("Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_page_layout',
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
);


$theme_options_pages_auction_event_detail_0_timer = array(
	'key' => 'event_detail_page_timer',
	'label' => __("Timer", 'ultimate-auction-pro-software'),
	'name' => 'event_detail_page_timer',
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
);
$theme_options_pages_auction_event_detail_1 = array(
	'key' => 'uat_event_details_resultbar',
	'label' => __("Showing results number", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_resultbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Showing results number on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_details_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_details_page_layout',
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
);

$theme_options_pages_auction_event_detail_3 = array(
	'key' => 'uat_event_details_reset_filter',
	'label' => __("Applied Filters", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_reset_filter',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Applied Filters date on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_details_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_details_page_layout',
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
);
$theme_options_pages_auction_event_detail_4 = array(
	'key' => 'uat_event_details_pricerange_bids',
	'label' => __("Current Bid Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_pricerange_bids',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Current Bid Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_details_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_details_page_layout',
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
);
$theme_options_pages_auction_event_detail_5 = array(
	'key' => 'uat_event_details_pricerange',
	'label' => __("Estimate Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_pricerange',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Estimate Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_details_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_details_page_layout',
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
);


$theme_options_pages_auction_event_detail_8 = array(
	'key' => 'uat_event_details_searchbar',
	'label' => __("Event Search Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_searchbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Auction Products(Lots) Search Bar on the events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_event_detail_9 = array(
	'key' => 'uat_events_terms_conditions_tab',
	'label' => __("Terms & Conditions", 'ultimate-auction-pro-software'),
	'name' => 'uat_events_terms_conditions_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the TERMS & CONDITIONS on events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_event_detail_10 = array(
	'key' => 'uat_event_details_default_view',
	'label' => __("Default Auction Products(Lots) View", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_default_view',
	'type' => 'button_group',
	'instructions' => __("Controls the Default Auction Products(Lots) View for the events detail page.", 'ultimate-auction-pro-software'),
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
);
$theme_options_pages_auction_event_detail_11 = array(
	'key' => 'uat_event_details_viewbar',
	'label' => __("Auction Products(Lots) View Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_viewbar',
	'type' => 'button_group',
	'instructions' => __("Controls the Auction Products(Lots) View Bar for the events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_auction_event_detail_12 = array(
	'key' => 'uat_event_details_pagination_type',
	'label' => __("Pagination Type", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_details_pagination_type',
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
	'default_value' => 'load-more',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_auction_event_detail_13 = array(
	'key' => 'uat_auction_products_no_event_detail',
	'label' => __("Number of Auction Products(Lots) to show per page", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_products_no_event_detail',
	'type' => 'range',
	'instructions' => __("Controls the number of Auction Products that display per page for Event Detail page. Set to -1 to display all.", 'ultimate-auction-pro-software'),
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
	'append' => 'Default is 12',
);
$theme_options_pages_event_cat = array(
	'key' => 'field_5f7c63e25c7cb',
	'label' => __("Page: Auction Event Category", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_pages_event_cat_0_1 = array(
	'key' => 'uat_event_list_page_populer_sub_cat_show',
	'label' => __("Show sub categories list", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_page_populer_sub_cat_show',
	'type' => 'button_group',
	'instructions' => __("Show sub categories list", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Yes", 'ultimate-auction-pro-software'),
		'no' => __("no", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 1,
	'default_value' => 'yes',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_event_cat_0_2 = array(
	'key' => 'uat_event_list_page_populer_event_show',
	'label' => __("Show populer events", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_page_populer_event_show',
	'type' => 'button_group',
	'instructions' => __("Show event list in slider", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'yes' => __("Yes", 'ultimate-auction-pro-software'),
		'no' => __("no", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 1,
	'default_value' => 'yes',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_event_cat_0_3 = array(
	'key' => 'uat_event_list_page_list_type',
	'label' => __("Choose what will be displayed in the filter?", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_page_list_type',
	'type' => 'button_group',
	'instructions' => __("Select Choose what will be displayed in the filter?", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'uat_button_group',
		'id' => '',
	),
	'choices' => array(
		'auction' => __("Auctions", 'ultimate-auction-pro-software'),
		'event' => __("Events", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 1,
	'default_value' => 'auction',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_event_cat_0 = array(
	'key' => 'uat_event_list_page_layout',
	'label' => __("Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_page_layout',
	'type' => 'button_group',
	'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
		)
	),
	'wrapper' => array(
		'width' => '',
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
);
$theme_options_pages_event_cat_1 = array(
	'key' => 'uat_event_list_resultbar',
	'label' => __("Showing results number for events", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_resultbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Showing results number on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'right-sidebar',
			),
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
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
);
$theme_options_pages_event_cat_2 = array(
	'key' => 'uat_event_list_sortbydate',
	'label' => __("Sort by Date", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_sortbydate',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Sort by date on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
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
);
$theme_options_pages_event_cat_3 =  array(
	'key' => 'uat_event_list_reset_filter',
	'label' => __("Applied Filters", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_reset_filter',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Applied Filters date on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
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
);
$theme_options_pages_event_cat_4 =   array(
	'key' => 'uat_event_list_daterange',
	'label' => __("Date Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_daterange',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Date Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
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
);
$theme_options_pages_event_cat_5 = array(
	'key' => 'uat_event_list_searchbar',
	'label' => __("Event Search Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_searchbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Event Search Bar on the events list page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			'field' => 'uat_event_list_page_list_type',
			'operator' => '==',
			'value' => 'event',
		),
	),
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
);

$theme_options_pages_event_cat_7 =  array(
	'key' => 'uat_event_list_location',
	'label' => __("Location Filter", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_location',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Location Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_page_layout',
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
);
$theme_options_pages_event_cat_8 = array(
	'key' => 'uat_event_list_location_county',
	'label' => __("Location Country Filter", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_location_county',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Location Country Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_location',
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
);
$theme_options_pages_event_cat_9 = array(
	'key' => 'uat_event_list_location_state',
	'label' => __("Location State Filter", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_location_state',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Location State Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_location',
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
);
$theme_options_pages_event_cat_10 = array(
	'key' => 'uat_event_list_location_city',
	'label' => __("Location City Filter", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_location_city',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Location City Filter on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'event',
			),
			array(
				'field' => 'uat_event_list_location',
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
);
$theme_options_pages_event_cat_11 = array(
	'key' => 'uat_event_list_default_view',
	'label' => __("Default Events View", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_default_view',
	'type' => 'button_group',
	'instructions' => __("Controls the Default Events View for the events list page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			'field' => 'uat_event_list_page_list_type',
			'operator' => '==',
			'value' => 'event',
		),
	),
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
);
$theme_options_pages_event_cat_12 = array(
	'key' => 'uat_event_list_viewbar',
	'label' => __("Event View Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_viewbar',
	'type' => 'button_group',
	'instructions' => __("Controls the Event View Bar for the events list page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			'field' => 'uat_event_list_page_list_type',
			'operator' => '==',
			'value' => 'event',
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
);
$theme_options_pages_event_cat_13 =  array(
	'key' => 'uat_event_list_pagination_type',
	'label' => __("Pagination Type", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_pagination_type',
	'type' => 'button_group',
	'instructions' => __("Controls the pagination type.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			'field' => 'uat_event_list_page_list_type',
			'operator' => '==',
			'value' => 'event',
		),
	),
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
);
$theme_options_pages_event_cat_14_time = array(
	'key' => 'uat_event_list_timer',
	'label' => __("Timer", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_list_timer',
	'type' => 'button_group',
	'instructions' => __("Display countdown clock.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			'field' => 'uat_event_list_page_list_type',
			'operator' => '==',
			'value' => 'event',
		),
	),
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
);

$theme_options_pages_event_cat_0_3_0 = array(
	'key' => 'uat_event_categories_auctions_layout',
	'label' => __("Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auctions_layout',
	'type' => 'button_group',
	'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
		)
	),
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
);


$theme_options_pages_event_cat_0_3_1 = array(
	'key' => 'event_cat_auctions_page_timer',
	'label' => __("Timer", 'ultimate-auction-pro-software'),
	'name' => 'event_cat_auctions_page_timer',
	'type' => 'button_group',
	'instructions' => __("Display countdown clock on event list page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
		)
	),
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
);
$theme_options_pages_event_cat_0_3_2 = array(
	'key' => 'uat_event_categories_auction_resultbar',
	'label' => __("Showing results number", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_resultbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Showing results number on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
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
);

$theme_options_pages_event_cat_0_3_3 = array(
	'key' => 'uat_event_categories_auction_reset_filter',
	'label' => __("Applied Filters", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_reset_filter',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Applied Filters date on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
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
);
$theme_options_pages_event_cat_0_3_4 = array(
	'key' => 'uat_event_categories_auction_pricerange_bids',
	'label' => __("Current Bid Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_pricerange_bids',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Current Bid Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
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
);
$theme_options_pages_event_cat_0_3_5 = array(
	'key' => 'uat_event_categories_auction_pricerange',
	'label' => __("Estimate Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_pricerange',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Estimate Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
			array(
				'field' => 'uat_event_categories_auctions_layout',
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
);


$theme_options_pages_event_cat_0_3_6 = array(
	'key' => 'uat_event_categories_auction_searchbar',
	'label' => __("Auction Search Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_searchbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Auction Products(Lots) Search Bar on the events detail page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
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
);
$theme_options_pages_event_cat_0_3_7 = array(
	'key' => 'uat_event_categories_auction_default_view',
	'label' => __("Default Auction Products(Lots) View", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_default_view',
	'type' => 'button_group',
	'instructions' => __("Controls the Default Auction Products(Lots) View for the events detail page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
		),
	),
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
);
$theme_options_pages_event_cat_0_3_8 = array(
	'key' => 'uat_event_categories_auction_viewbar',
	'label' => __("Auction Products(Lots) View Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_viewbar',
	'type' => 'button_group',
	'instructions' => __("Controls the Auction Products(Lots) View Bar for the events detail page.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
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
);
$theme_options_pages_event_cat_0_3_9 = array(
	'key' => 'uat_event_categories_auction_pagination_type',
	'label' => __("Pagination Type", 'ultimate-auction-pro-software'),
	'name' => 'uat_event_categories_auction_pagination_type',
	'type' => 'button_group',
	'instructions' => __("Controls the pagination type.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
			),
		),
	),
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
	'default_value' => 'load-more',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_event_cat_0_3_10 = array(
	'key' => 'uat_event_cat_auction_products_no',
	'label' => __("Number of Auction Products(Lots) to show per page", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_products_no',
	'type' => 'range',
	'instructions' => __("Controls the number of Auction Products that display per page for Event Detail page. Set to -1 to display all.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_event_list_page_list_type',
				'operator' => '==',
				'value' => 'auction',
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
	'append' => 'Default is 12',
);


$theme_options_pages_woo =  array(
	'key' => 'field_6037b4e6f1bbf',
	'label' => __("Page: WooCommerce", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_pages_woo_0 =  array(
	'key' => 'field_5f7c6f2e17023',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3 style=\"float:left\">WooCommerce Setting</h3><p style=\"float:right\"><a class=\"reset-uat-woocommerce-section button reset-options button-primary button-large\" href=\"javascript:void();\">Reset Section</a> <a class=\"reset-uat-all-theme-options button reset-options button-primary button-large\" href=\"javascript:void();\">Reset All</a></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_pages_woo_1 = array(
	'key' => 'uat_shop_page_layout',
	'label' => __("Shop Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_shop_page_layout',
	'type' => 'button_group',
	'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'full-width' => __("Full Width Content", 'ultimate-auction-pro-software'),
		'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-pro-software'),
		'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'full-width',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_2 = array(
	'key' => 'uat_woo_category_page_layout',
	'label' => __("Categories Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_woo_category_page_layout',
	'type' => 'button_group',
	'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'full-width' => __("Full Width Content", 'ultimate-auction-pro-software'),
		'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-pro-software'),
		'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'full-width',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_3 =  array(
	'key' => 'uat_woo_tags_page_layout',
	'label' => __("Tags Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_woo_tags_page_layout',
	'type' => 'button_group',
	'instructions' => __("Select page layout. Default is full width.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'choices' => array(
		'full-width' => __("Full Width Content", 'ultimate-auction-pro-software'),
		'left-sidebar' => __("Left Sidebar With Right Content", 'ultimate-auction-pro-software'),
		'right-sidebar' => __("Right Sidebar With Left Content", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'full-width',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_4 =  array(
	'key' => 'field_6037b806b3219',
	'label' => __("Mix Auctions Product On Product Category Page", 'ultimate-auction-pro-software'),
	'name' => 'uat_mix_auctions_product_on_category_page',
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
		'on' => __("ON", 'ultimate-auction-pro-software'),
		'off' => __("OFF", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'on',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_5 = array(
	'key' => 'field_6037b83eb321b',
	'label' => __("Show Expired Auctions on Category Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_expired_auction_on_cat',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b806b3219',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_6 = array(
	'key' => 'field_6037b869b321c',
	'label' => __("Show Future Auctions on Category Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_future_auction_on_cat',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b806b3219',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_7 = array(
	'key' => 'field_6037b828b321a',
	'label' => __("Mix Auctions Product On Product Tag Page", 'ultimate-auction-pro-software'),
	'name' => 'uat_mix_auctions_product_on_tag_page',
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
		'on' => __("ON", 'ultimate-auction-pro-software'),
		'off' => __("OFF", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'on',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_8 =	array(
	'key' => 'field_6037b83eb321b2',
	'label' => __("Show Expired Auctions on Tag Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_expired_auction_on_tag',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b828b321a',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_9 = array(
	'key' => 'field_6037b869b321c2',
	'label' => __("Show Future Auctions on Tag Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_future_auction_on_tag',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b828b321a',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_10 = array(
	'key' => 'field_6037b7e0b3218',
	'label' => __("Mix Auctions Product On Product Search Page", 'ultimate-auction-pro-software'),
	'name' => 'uat_mix_auctions_product_on_search_page',
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
		'on' => __("ON", 'ultimate-auction-pro-software'),
		'off' => __("OFF", 'ultimate-auction-pro-software'),
	),
	'allow_null' => 0,
	'default_value' => 'on',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_woo_11 = array(
	'key' => 'field_6037b83eb321b23',
	'label' => __("Show Expired Auctions on On Product Search Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_expired_auction_on_search',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b7e0b3218',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_12 =  array(
	'key' => 'field_6037b869b321c23',
	'label' => __("Show Future Auctions On Product Search Page.", 'ultimate-auction-pro-software'),
	'name' => 'uat_display_future_auction_on_search',
	'type' => 'button_group',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'field_6037b7e0b3218',
				'operator' => '==',
				'value' => 'on',
			),
		),
	),
	'wrapper' => array(
		'width' => '50',
		'class' => '',
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
$theme_options_pages_woo_detail =  array(
	'key' => 'wc_product_detail_page',
	'label' => __("Page: WooCommerce Default Product Detail Page", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);

$theme_options_pages_woo_detail_0 = array(
	'key' => 'wc_default_page_comments',
	'label' => __("Comments", 'ultimate-auction-pro-software'),
	'name' => 'wc_default_page_comments',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to disable comments section on this page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_blog_detail =  array(
	'key' => 'blog_product_detail_page',
	'label' => __("Page: Blog Detail Page", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);

$theme_options_pages_blog_detail_0 = array(
	'key' => 'blog_default_page_comments',
	'label' => __("Comments", 'ultimate-auction-pro-software'),
	'name' => 'blog_default_page_comments',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to disable comments section on this page.", 'ultimate-auction-pro-software'),
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

$theme_options_pages_search_result = array(
	'key' => 'field_15f7c63fa5c7cc',
	'label' => __("Page: Search result page", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$theme_options_pages_search_result_0 = array(
	'key' => 'uat_search_results_page_layout',
	'label' => __("Page Layout", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_page_layout',
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
);


$theme_options_pages_search_result_0_timer = array(
	'key' => 'uat_search_results_page_timer',
	'label' => __("Timer", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_page_timer',
	'type' => 'button_group',
	'instructions' => __("Display countdown clock on search results page.", 'ultimate-auction-pro-software'),
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
	'default_value' => 'false',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_search_result_1 = array(
	'key' => 'uat_search_results_resultbar',
	'label' => __("Showing results number", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_resultbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Showing results number on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_search_results_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_search_results_page_layout',
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
);


$theme_options_pages_search_result_4 = array(
	'key' => 'uat_search_results_pricerange_bids',
	'label' => __("Current Bid Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_pricerange_bids',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Current Bid Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_search_results_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_search_results_page_layout',
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
);
$theme_options_pages_search_result_5 = array(
	'key' => 'uat_search_results_pricerange',
	'label' => __("Estimate Range", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_pricerange',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Estimate Range on the in sidebar area.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => array(
		array(
			array(
				'field' => 'uat_search_results_page_layout',
				'operator' => '==',
				'value' => 'left-sidebar',
			),
		),
		array(
			array(
				'field' => 'uat_search_results_page_layout',
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
);


$theme_options_pages_search_result_8 = array(
	'key' => 'uat_search_results_searchbar',
	'label' => __("Event Search Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_searchbar',
	'type' => 'button_group',
	'instructions' => __("Turn on to display Auction Products(Lots) Search Bar on the events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_search_result_9 = array(
	'key' => 'uat_events_terms_conditions_tab',
	'label' => __("Terms & Conditions", 'ultimate-auction-pro-software'),
	'name' => 'uat_events_terms_conditions_tab',
	'type' => 'button_group',
	'instructions' => __("Turn OFF to hide the TERMS & CONDITIONS on events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_search_result_10 = array(
	'key' => 'uat_search_results_default_view',
	'label' => __("Default Auction Products(Lots) View", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_default_view',
	'type' => 'button_group',
	'instructions' => __("Controls the Default Auction Products(Lots) View for the events detail page.", 'ultimate-auction-pro-software'),
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
);
$theme_options_pages_search_result_11 = array(
	'key' => 'uat_search_results_viewbar',
	'label' => __("Auction Products(Lots) View Bar", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_viewbar',
	'type' => 'button_group',
	'instructions' => __("Controls the Auction Products(Lots) View Bar for the events detail page.", 'ultimate-auction-pro-software'),
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
$theme_options_pages_search_result_12 = array(
	'key' => 'uat_search_results_pagination_type',
	'label' => __("Pagination Type", 'ultimate-auction-pro-software'),
	'name' => 'uat_search_results_pagination_type',
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
	'default_value' => 'load-more',
	'layout' => 'horizontal',
	'return_format' => 'value',
);
$theme_options_pages_search_result_13 = array(
	'key' => 'uat_auction_products_no',
	'label' => __("Number of Auction Products(Lots) to show per page", 'ultimate-auction-pro-software'),
	'name' => 'uat_auction_products_no',
	'type' => 'range',
	'instructions' => __("Controls the number of Auction Products that display per page for Event Detail page. Set to -1 to display all.", 'ultimate-auction-pro-software'),
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
	'append' => 'Default is 12',
);

/* seller page options */
$theme_options_seller_pages = array(
	'key' => 'field_15f7c63fa5c7ccs',
	'label' => __("Page: Seller page options", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 0,
);
$page_options = get_all_pages_list();
$uat_seller_dashboard_page_id = get_option("options_uat_seller_dashboard_page_id");
$theme_options_seller_pages_dashboard = array(
	'key' => 'uat_seller_dashboard_page_id',
	'label' => __("Seller Dashboard page", 'ultimate-auction-pro-software'),
	'name' => 'uat_seller_dashboard_page_id',
	'type' => 'select',
	'instructions' => __("Don't use the seller dashboard page for other page settings, you'll break your site if you do.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
		'class' => '',
		'id' => '',
	),
	'choices' => $page_options, // Use the array of options
	'default_value' => $uat_seller_dashboard_page_id, // Default selected value
	'allow_null' => 0,
	'multiple' => 0,
	'ui' => 0,
	'return_format' => 'value',
);
$uat_buyer_dashboard_page_id = get_option("options_uat_buyer_dashboard_page_id");
$theme_options_buyer_pages_dashboard = array(
	'key' => 'uat_buyer_dashboard_page_id',
	'label' => __("Buyer Dashboard page", 'ultimate-auction-pro-software'),
	'name' => 'uat_buyer_dashboard_page_id',
	'type' => 'select',
	'instructions' => __("Don't use the buyer dashboard page for other page settings, you'll break your site if you do.", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
		'class' => '',
		'id' => '',
	),
	'choices' => $page_options, // Use the array of options
	'default_value' => $uat_buyer_dashboard_page_id, // Default selected value
	'allow_null' => 0,
	'multiple' => 0,
	'ui' => 0,
	'return_format' => 'value',
);
$uat_categories_page_id = get_option("options_uat_categories_page_id");
$theme_options_seller_categories_pages = array(
	'key' => 'uat_categories_page_id',
	'label' => __("Categories page", 'ultimate-auction-pro-software'),
	'name' => 'uat_categories_page_id',
	'type' => 'select',
	'instructions' => __("This page will contain the selected categories page template", 'ultimate-auction-pro-software'),
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '100',
		'class' => '',
		'id' => '',
	),
	'choices' => $page_options, // Use the array of options
	'default_value' => $uat_categories_page_id, // Default selected value
	'allow_null' => 0,
	'multiple' => 0,
	'ui' => 0,
	'return_format' => 'value',
);
$theme_options_pages_2 = array(
	'key' => 'uat_pages_setting_tabs_end',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);

$theme_options_import = array(
	'key' => 'theme_import_data',
	'label' => __("Import", 'ultimate-auction-pro-software'),
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
);
$theme_options_import_0 = array(
	'key' => 'theme_import_data_btn',
	'label' => '',
	'name' => '',
	'type' => 'message',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => 'reset_section',
		'id' => '',
	),
	'message' => __("<h3  >Import</h3> <p ><div id='data_result'></div><button type='button' aria-disabled='false' class='opt_import_cls components-button is-primary' >Import Demo Data</button></p>", 'ultimate-auction-pro-software'),
	'new_lines' => 'wpautop',
	'esc_html' => 0,
);
$theme_options_import_1 = array(
	'key' => 'theme_import_data_btn_end',
	'label' => __("End Tab", 'ultimate-auction-pro-software'),
	'name' => '',
	'type' => 'accordion',
	'instructions' => '',
	'required' => 0,
	'conditional_logic' => 0,
	'wrapper' => array(
		'width' => '',
		'class' => '',
		'id' => '',
	),
	'open' => 0,
	'multi_expand' => 0,
	'endpoint' => 1,
);
/*
	$theme_options_menu =array();
	$theme_options_logo =array();
	$theme_options_login =array();
	$theme_options_footer =array();
	$theme_options_cron =array();
	$theme_options_payment_gateway =array();
	$theme_options_bp =array();
	$theme_options_cc =array();
	$theme_options_anti =array();
	$theme_options_logs =array();
	$theme_options_auction =array();
	$theme_options_pages =array();
	*/
$theme_options_array[] = $theme_options_welcome;
$theme_options_array[] = $theme_options_welcome_0;
$theme_options_array[] = $theme_options_welcome_1;
$theme_options_array[] = $theme_options_menu;
$theme_options_array[] = $theme_options_menu_0;
$theme_options_array[] = $theme_options_menu_1;
$theme_options_array[] = $theme_options_menu_2;
$theme_options_array[] = $theme_options_menu_3;
$theme_options_array[] = $theme_options_menu_4;

$theme_options_array[] = $theme_options_logo;
$theme_options_array[] = $theme_options_logo_0;
$theme_options_array[] = $theme_options_logo_1;
$theme_options_array[] = $theme_options_logo_2;
$theme_options_array[] = $theme_options_logo_3;
$theme_options_array[] = $theme_options_logo_4;
$theme_options_array[] = $theme_options_logo_5;
$theme_options_array[] = $theme_options_login;
$theme_options_array[] = $theme_options_login_0;
$theme_options_array[] = $theme_options_login_11;

$theme_options_array[] = $theme_options_login_2;
$theme_options_array[] = $theme_options_login_3;

$theme_options_array[] = $theme_options_login_1;
$theme_options_array[] = $theme_options_login_4;
$theme_options_array[] = $theme_options_login_165;
$theme_options_array[] = $theme_options_login_5;
$theme_options_array[] = $theme_options_login_56;

$theme_options_array[] = $theme_options_login_55;
$theme_options_array[] = $theme_options_login_6;
$theme_options_array[] = $theme_options_footer;
$theme_options_array[] = $theme_options_footer_0;
$theme_options_array[] = $theme_options_footer_1;
$theme_options_array[] = $theme_options_footer_2;
$theme_options_array[] = $theme_options_footer_3;
$theme_options_array[] = $theme_options_footer_4;
$theme_options_array[] = $theme_options_cron;
$theme_options_array[] = $theme_options_cron_0;
$theme_options_array[] = $theme_options_cron_01;
$theme_options_array[] = $theme_options_cron_3;
$theme_options_array[] = $theme_options_cron_4;
$theme_options_array[] = $theme_options_cron_5;
$theme_options_array[] = $theme_options_cron_6;
$theme_options_array[] = $theme_options_cron_66;
$theme_options_array[] = $theme_options_cron_7;
$theme_options_array[] = $theme_options_cron_8;
$theme_options_array[] = $theme_options_cron_9;
$theme_options_array[] = $theme_options_cron_10;
$theme_options_array[] = $theme_options_cron_11;
$theme_options_array[] = $theme_options_payment_gateway;
$theme_options_array[] = $theme_options_payment_gateway_0;
// $theme_options_array[] = $theme_options_payment_gateway_1;
$theme_options_array[] = $theme_options_payment_gateway_1_1;
//$theme_options_array[] = $theme_options_payment_gateway_22;
$theme_options_array[] = $theme_options_payment_gateway_2;
$theme_options_array[] = $theme_options_payment_gateway_3;
$theme_options_array[] = $theme_options_payment_gateway_4;
$theme_options_array[] = $theme_options_payment_gateway_4_1;
$theme_options_array[] = $theme_options_payment_gateway_5;
$theme_options_array[] = $theme_options_payment_gateway_6;
$theme_options_array[] = $theme_options_payment_gateway_6_1;
$theme_options_array[] = $theme_options_payment_gateway_6_3;
$theme_options_array[] = $theme_options_payment_gateway_b_2;
$theme_options_array[] = $theme_options_payment_gateway_b_3;
$theme_options_array[] = $theme_options_payment_gateway_b_4;
$theme_options_array[] = $theme_options_payment_gateway_b_5;
$theme_options_array[] = $theme_options_payment_gateway_b_5_2;
$theme_options_array[] = $theme_options_payment_gateway_b_6;
$theme_options_array[] = $theme_options_payment_gateway_b_7;
$theme_options_array[] = $theme_options_payment_gateway_b_8;
$theme_options_array[] = $theme_options_payment_gateway_b_8_2;
$theme_options_array[] = $theme_options_payment_gateway_7;

/* Offline Dealing */
$theme_options_array[] = $theme_options_auction_offline_dealing_settings;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_0;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_1;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_2;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_3;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_4;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_5;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_9;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_6;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_7;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_8;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_10;
$theme_options_array[] = $theme_options_auction_offline_dealing_settings_11;


$theme_options_array[] = $theme_options_bp;
$theme_options_array[] = $theme_options_bp_0;
$theme_options_array[] = $theme_options_bp_1;
$theme_options_array[] = $theme_options_bp_2;
$theme_options_array[] = $theme_options_bp_2_1;
$theme_options_array[] = $theme_options_bp_2_2;
// $theme_options_array[] = $theme_options_bp_0000;
$theme_options_array[] = $theme_options_bp_3;



// $theme_options_array[] = $theme_options_bp_4;
$theme_options_array[] = $theme_options_bp_5;
$theme_options_array[] = $theme_options_bp_6;
$theme_options_array[] = $theme_options_bp_7;
$theme_options_array[] = $theme_options_bp_77;

/* WCFM plugin BP settings start*/

$theme_options_array[] = $theme_options_bp_wcfm_1;
$theme_options_array[] = $theme_options_bp_wcfm_2;
$theme_options_array[] = $theme_options_bp_wcfm_3;
$theme_options_array[] = $theme_options_bp_wcfm_4;
$theme_options_array[] = $theme_options_bp_wcfm_5;
$theme_options_array[] = $theme_options_bp_wcfm_6;
$theme_options_array[] = $theme_options_bp_wcfm_7;
$theme_options_array[] = $theme_options_bp_wcfm_77;

/* WCFM plugin BP settings end*/

$theme_options_array[] = $theme_options_bp_8;
$theme_options_array[] = $theme_options_bp_9;
$theme_options_array[] = $theme_options_bp_9_1;
$theme_options_array[] = $theme_options_bp_9_2;
$theme_options_array[] = $theme_options_bp_1_2;
$theme_options_array[] = $theme_options_bp_1_3;
$theme_options_array[] = $theme_options_bp_1_4;
$theme_options_array[] = $theme_options_bp_1_5;
$theme_options_array[] = $theme_options_bp_1_6;
$theme_options_array[] = $theme_options_bp_1_7;

$theme_options_array[] = $theme_options_bp_10;
$theme_options_array[] = $theme_options_bp_11;
$theme_options_array[] = $theme_options_bp_16;
$theme_options_array[] = $theme_options_cc;
$theme_options_array[] = $theme_options_cc_0;
$theme_options_array[] = $theme_options_cc_1;
$theme_options_array[] = $theme_options_cc_2;
$theme_options_array[] = $theme_options_cc_3;
$theme_options_array[] = $theme_options_cc_3_1;
$theme_options_array[] = $theme_options_cc_3_2;
$theme_options_array[] = $theme_options_cc_3_3;
$theme_options_array[] = $theme_options_cc_3_4;

$theme_options_array[] = $theme_options_cc_7;
$theme_options_array[] = $theme_options_cc_8;
$theme_options_array[] = $theme_options_cc_13;
$theme_options_array[] = $theme_options_fs;
$theme_options_array[] = $theme_options_fs_0;
$theme_options_array[] = $theme_options_os_1;
$theme_options_array[] = $theme_options_fs_1;
$theme_options_array[] = $theme_options_fs_22;
$theme_options_array[] = $theme_options_fs_2;
$theme_options_array[] = $theme_options_sniping;
$theme_options_array[] = $theme_options_sniping_0;
$theme_options_array[] = $theme_options_timer;
$theme_options_array[] = $theme_options_listpage_sync_clock_enable;
$theme_options_array[] = $theme_options_sniping_anti_sniping_timer_update_notification;
$theme_options_array[] = $theme_options_sniping_anti_sniping_timer_update_notification_2;

$theme_options_array[] = $theme_options_sniping_1;
$theme_options_array[] = $theme_options_sniping_2;

$theme_options_array[] = $theme_options_sniping_3;
$theme_options_array[] = $theme_options_sniping_4;
$theme_options_array[] = $theme_options_sniping_5;
$theme_options_array[] = $theme_options_sniping_6;
$theme_options_array[] = $theme_options_sniping_7;

$theme_options_array[] = $theme_options_bid_increment;
$theme_options_array[] = $theme_options_bid_increment_tab;
$theme_options_array[] = $theme_options_bid_increment_tab_product_0;
$theme_options_array[] = $theme_options_bid_increment_tab_product_1;
$theme_options_array[] = $theme_options_bid_increment_tab_product_2;
$theme_options_array[] = $theme_options_bid_increment_tab_0;
$theme_options_array[] = $theme_options_bid_increment_tab_1;
$theme_options_array[] = $theme_options_bid_increment_tab_2;
$theme_options_array[] = $theme_options_auction_tabs_end_bids;
$theme_options_array[] = $theme_options_logs;
$theme_options_array[] = $theme_options_logs_0;
$theme_options_array[] = $theme_options_logs_1;
$theme_options_array[] = $theme_options_logs_2;
$theme_options_array[] = $theme_options_logs_3;
$theme_options_array[] = $theme_options_logs_4;
$theme_options_array[] = $theme_options_logs_5;
$theme_options_array[] = $theme_options_logs_6;
$theme_options_array[] = $theme_options_auction;
$theme_options_array[] = $theme_options_auction_general;
$theme_options_array[] = $theme_options_auction_general_0;
$theme_options_array[] = $theme_options_auction_general_1;
$theme_options_array[] = $theme_options_auction_general_2;
$theme_options_array[] = $theme_options_auction_general_3;
$theme_options_array[] = $theme_options_auction_general_4;
$theme_options_array[] = $theme_options_auction_general_44;
$theme_options_array[] = $theme_options_auction_general_444;
$theme_options_array[] = $theme_options_auction_general_5;
$theme_options_array[] = $theme_options_auction_general_address_mandatory;
$theme_options_array[] = $theme_options_auction_general_billing_address_mandatory;
$theme_options_array[] = $theme_options_auction_general_7;




$theme_options_array[] = $theme_options_listpage_sync_clock_enable;



$theme_options_array[] = $theme_options_auction_general_8;
$theme_options_array[] = $theme_options_auction_general_9;
$theme_options_array[] = $theme_options_auction_general_11;
$theme_options_array[] = $theme_options_auction_general_10;
$theme_options_array[] = $bid_pop_on_list_page;

$theme_options_array[] = $theme_options_auction_events;
$theme_options_array[] = $theme_options_auction_events_0;
$theme_options_array[] = $theme_options_auction_simple;
$theme_options_array[] = $theme_options_auction_simple_0;
$theme_options_array[] = $theme_options_auction_simple_00;
$theme_options_array[] = $theme_options_auction_proxy;
$theme_options_array[] = $theme_options_auction_proxy_0;
$theme_options_array[] = $theme_options_auction_proxy_1;
$theme_options_array[] = $theme_options_auction_proxy_00;
$theme_options_array[] = $theme_options_auction_proxy_000;
$theme_options_array[] = $theme_options_auction_proxy_2;
$theme_options_array[] = $theme_options_auction_proxy_3;
$theme_options_array[] = $theme_options_auction_silent;
$theme_options_array[] = $theme_options_auction_silent_0;
$theme_options_array[] = $theme_options_auction_silent_1;
$theme_options_array[] = $theme_options_auction_silent_2;
$theme_options_array[] = $theme_options_auction_tabs_end;



/* Car theme tabs */ 



if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {
	$theme_options_array[] = $theme_options_auction_car;
	$theme_options_array[] = $theme_options_auction_car_0;
	$theme_options_array[] = $theme_options_auction_car_001;
	$theme_options_array[] = $theme_options_auction_car_1;
	$theme_options_array[] = $theme_options_auction_car_2;
	$theme_options_array[] = $theme_options_auction_car_3;
	$theme_options_array[] = $theme_options_auction_car_4;
	$theme_options_array[] = $theme_options_auction_car_5;
	$theme_options_array[] = $theme_options_auction_car_6;
	$theme_options_array[] = $theme_options_auction_car_7;
	$theme_options_array[] = $theme_options_auction_car_8;
	$theme_options_array[] = $theme_options_auction_car_9;
	$theme_options_array[] = $theme_options_auction_car_10;
	$theme_options_array[] = $theme_options_auction_car_11;
	$theme_options_array[] = $theme_options_auction_car_12;
	$theme_options_array[] = $theme_options_auction_car_13;
	/*$theme_options_array[] = $theme_options_auction_car_14;*/
	$theme_options_array[] = $theme_options_auction_car_15;
	/*$theme_options_array[] = $theme_options_auction_car_16;*/
	$theme_options_array[] = $theme_options_auction_car_17;
	$theme_options_array[] = $theme_options_auction_car_18;
	$theme_options_array[] = $theme_options_auction_car_19;
	$theme_options_array[] = $theme_options_auction_car_002;
	$theme_options_array[] = $theme_options_auction_car_002_01;
	$theme_options_array[] = $theme_options_auction_car_002_02;

	
	
	
	$theme_options_array[] = $theme_options_auction_car_003;
	$theme_options_array[] = $theme_options_auction_car_003_01;
	$theme_options_array[] = $theme_options_auction_car_003_02;
	$theme_options_array[] = $theme_options_auction_car_003_03;
	$theme_options_array[] = $theme_options_auction_car_003_04;
	$theme_options_array[] = $theme_options_auction_car_003_05;
	$theme_options_array[] = $theme_options_auction_car_003_06;


	


	$theme_options_array[] = $theme_options_auction_car_00_end;

	$theme_options_array[] = $theme_options_auction_car_0_end;
}
/* END car fields*/


$theme_options_array[] = $theme_options_pages;
$theme_options_array[] = $theme_options_pages_0;
$theme_options_array[] = $theme_options_pages_auction_detail_options_to_place_bid_0;
$theme_options_array[] = $theme_options_pages_auction_detail_options_to_place_bid_2;
$theme_options_array[] = $theme_options_pages_general;
$theme_options_array[] = $theme_options_pages_general_1;
$theme_options_array[] = $theme_options_pages_auction_detail;
// $theme_options_array[] = $theme_options_pages_auction_detail_01;
$theme_options_array[] = $theme_options_pages_auction_detail_0;
$theme_options_array[] = $theme_options_pages_auction_detail_2;
$theme_options_array[] = $theme_options_pages_auction_detail_3;
$theme_options_array[] = $theme_options_pages_auction_detail_4;
$theme_options_array[] = $theme_options_pages_auction_detail_5;
$theme_options_array[] = $theme_options_pages_auction_detail_6;
$theme_options_array[] = $theme_options_pages_auction_detail_66;
$theme_options_array[] = $theme_options_pages_auction_detail_7;
$theme_options_array[] = $theme_options_pages_auction_detail_8;
$theme_options_array[] = $theme_options_pages_auction_detail_88;
$theme_options_array[] = $theme_options_pages_auction_detail_888;
$theme_options_array[] = $theme_options_pages_auction_detail_9;
$theme_options_array[] = $theme_options_pages_auction_detail_10;
$theme_options_array[] = $theme_options_pages_auction_detail_10_time;
$theme_options_array[] = $theme_options_pages_auction_detail_11;
$theme_options_array[] = $theme_options_pages_auction_detail_12;
$theme_options_array[] = $theme_options_pages_auction_event_detail;
$theme_options_array[] = $theme_options_pages_auction_event_detail_0;
$theme_options_array[] = $theme_options_pages_auction_event_detail_0_timer;
$theme_options_array[] = $theme_options_pages_auction_event_detail_1;
$theme_options_array[] = $theme_options_pages_auction_event_detail_3;
$theme_options_array[] = $theme_options_pages_auction_event_detail_4;
$theme_options_array[] = $theme_options_pages_auction_event_detail_5;
$theme_options_array[] = $theme_options_pages_auction_event_detail_8;
$theme_options_array[] = $theme_options_pages_auction_event_detail_9;
$theme_options_array[] = $theme_options_pages_auction_event_detail_10;
$theme_options_array[] = $theme_options_pages_auction_event_detail_11;
$theme_options_array[] = $theme_options_pages_auction_event_detail_12;
$theme_options_array[] = $theme_options_pages_auction_event_detail_13;
$theme_options_array[] = $theme_options_pages_event_cat;
$theme_options_array[] = $theme_options_pages_event_cat_0_1;
$theme_options_array[] = $theme_options_pages_event_cat_0_2;
$theme_options_array[] = $theme_options_pages_event_cat_0_3;
$theme_options_array[] = $theme_options_pages_event_cat_0;
$theme_options_array[] = $theme_options_pages_event_cat_1;
$theme_options_array[] = $theme_options_pages_event_cat_2;
$theme_options_array[] = $theme_options_pages_event_cat_3;
$theme_options_array[] = $theme_options_pages_event_cat_4;
$theme_options_array[] = $theme_options_pages_event_cat_5;
$theme_options_array[] = $theme_options_pages_event_cat_7;
$theme_options_array[] = $theme_options_pages_event_cat_8;
$theme_options_array[] = $theme_options_pages_event_cat_9;
$theme_options_array[] = $theme_options_pages_event_cat_10;
$theme_options_array[] = $theme_options_pages_event_cat_11;
$theme_options_array[] = $theme_options_pages_event_cat_12;
$theme_options_array[] = $theme_options_pages_event_cat_13;
$theme_options_array[] = $theme_options_pages_event_cat_14_time;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_0;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_1;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_2;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_3;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_4;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_5;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_6;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_7;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_8;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_9;
$theme_options_array[] = $theme_options_pages_event_cat_0_3_10;

$theme_options_array[] = $theme_options_pages_woo;
$theme_options_array[] = $theme_options_pages_woo_0;
$theme_options_array[] = $theme_options_pages_woo_1;
$theme_options_array[] = $theme_options_pages_woo_2;
$theme_options_array[] = $theme_options_pages_woo_3;
$theme_options_array[] = $theme_options_pages_woo_4;
$theme_options_array[] = $theme_options_pages_woo_5;
$theme_options_array[] = $theme_options_pages_woo_6;
$theme_options_array[] = $theme_options_pages_woo_7;
$theme_options_array[] = $theme_options_pages_woo_8;
$theme_options_array[] = $theme_options_pages_woo_9;
$theme_options_array[] = $theme_options_pages_woo_10;
$theme_options_array[] = $theme_options_pages_woo_11;
$theme_options_array[] = $theme_options_pages_woo_12;
$theme_options_array[] = $theme_options_pages_woo_detail;
$theme_options_array[] = $theme_options_pages_woo_detail_0;
$theme_options_array[] = $theme_options_pages_blog_detail;
$theme_options_array[] = $theme_options_pages_blog_detail_0;

$theme_options_array[] = $theme_options_pages_search_result;
$theme_options_array[] = $theme_options_pages_search_result_0;
$theme_options_array[] = $theme_options_pages_search_result_0_timer;
$theme_options_array[] = $theme_options_pages_search_result_1;
// $theme_options_array[] = $theme_options_pages_search_result_3;
$theme_options_array[] = $theme_options_pages_search_result_4;
$theme_options_array[] = $theme_options_pages_search_result_5;
$theme_options_array[] = $theme_options_pages_search_result_8;
$theme_options_array[] = $theme_options_pages_search_result_9;
$theme_options_array[] = $theme_options_pages_search_result_10;
$theme_options_array[] = $theme_options_pages_search_result_11;
$theme_options_array[] = $theme_options_pages_search_result_12;
$theme_options_array[] = $theme_options_pages_search_result_13;

/* seller page options */
$theme_options_array[] = $theme_options_seller_pages;
$theme_options_array[] = $theme_options_seller_pages_dashboard;
$theme_options_array[] = $theme_options_buyer_pages_dashboard;
$theme_options_array[] = $theme_options_seller_categories_pages;

$theme_options_array[] = $theme_options_pages_2;


$theme_options_array[] = $theme_options_import;
$theme_options_array[] = $theme_options_import_0;
$theme_options_array[] = $theme_options_import_1;

acf_add_local_field_group(array(
	'key' => 'group_5f758592ed4ad',
	'title' => __("Theme settings", 'ultimate-auction-pro-software'),
	'fields' => $theme_options_array,
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'ua-auctions-theme-options',
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
));
