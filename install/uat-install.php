<?php
add_action("after_setup_theme", "mytheme_create_extra_table");
// add_action("after_setup_theme", "mytheme_create_extra_table");

function mytheme_create_extra_table()
{
	global $wpdb;

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	$charset_collate = $wpdb->get_charset_collate();

	$tbl_nm_vote = $wpdb->prefix . "ua_auction_vote";
	$tbl_nm_vote_sql="CREATE TABLE IF NOT EXISTS $tbl_nm_vote (
	  `vote_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `question_id` int(11) NOT NULL,
	  `voter_id` int(11) NOT NULL,
	  `created_date` datetime NOT NULL DEFAULT current_timestamp()
	) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

 	dbDelta($tbl_nm_vote_sql);
	
	$tbl_sql_question = $wpdb->prefix . "ua_auction_question";

	$sql_question = "CREATE TABLE IF NOT EXISTS $tbl_sql_question (
		`question_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`question_text` text NOT NULL,
		`asked_by_id` int(11) NOT NULL,
		`post_id` int(11) NOT NULL,
		 `post_owner_id` int(11) NOT NULL,
		`status` varchar(255) NOT NULL,
		`created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($sql_question);

	$tbl_sql_qa = $wpdb->prefix . "ua_auction_answer";

	$email_sql_qa = "CREATE TABLE IF NOT EXISTS $tbl_sql_qa (
		  `answers_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		  `question_id` int(11) NOT NULL,
		  `answered_by_id` int(11) NOT NULL,
		  `answer_text` text NOT NULL,
		  `created_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
		  `status` varchar(255) NOT NULL
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($email_sql_qa);

	$tbl_nm = $wpdb->prefix . "ua_auction_email";  //get the database table prefix to create my new table
	$email_sql = "CREATE TABLE IF NOT EXISTS $tbl_nm (
		`id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`auction_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,
		`user_email` varchar(255) NOT NULL,
		`receiver_email` varchar(255) NOT NULL,
		`admin_email` varchar(255) NOT NULL,
		`email_type` varchar(255) NOT NULL,
		`status` varchar(255) NOT NULL,
		`subject` varchar(255) NOT NULL,
		`headers` text NOT NULL,
		`message` text NOT NULL,
		`attachments` varchar(255) NOT NULL,
		`amount` int(11) NOT NULL,
		`error` varchar(255) NOT NULL,
		`email_date` datetime NOT NULL DEFAULT current_timestamp()
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($email_sql);

	$ua_auction_activity = $wpdb->prefix . "ua_auction_activity";  //get the database table prefix to create my new table
	$ua_auction_activity_sql = "CREATE TABLE IF NOT EXISTS $ua_auction_activity (
		`activity_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`post_parent` bigint(20) NOT NULL,
		`activity_name` longtext NOT NULL,
		`activity_type` varchar(300) NOT NULL,
		`activity_date` datetime NOT NULL,
		`activity_by` bigint(20) NOT NULL,
		`activity_data` text NOT NULL,
		PRIMARY KEY (`activity_id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($ua_auction_activity_sql);

	$ua_auction_activitymeta = $wpdb->prefix . "ua_auction_activitymeta";  //get the database table prefix to create my new table
	$ua_auction_activitymeta_sql = "CREATE TABLE {$ua_auction_activitymeta} (
		`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`activity_id` bigint(20) NOT NULL,
		`meta_key` varchar(255) NOT NULL,
		`meta_value` longtext NOT NULL,
		PRIMARY KEY (`meta_id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($ua_auction_activitymeta_sql);


	$ua_auction_events = $wpdb->prefix . "ua_auction_events";  //get the database table prefix to create my new table
	$ua_auction_events_sql = "CREATE TABLE IF NOT EXISTS $ua_auction_events (
		`event_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`post_id` bigint(20) NOT NULL,
		`post_status` varchar(20) NOT NULL,
		`event_owner` bigint(20) NOT NULL,
		`event_status` varchar(20) NOT NULL,
		`event_name` mediumtext NOT NULL,
		`post_content` longtext NOT NULL,
		`event_type` varchar(300) NOT NULL,
		`event_start_date` datetime NOT NULL,
		`event_end_date` datetime NOT NULL,
		`event_products_ids` longtext NOT NULL,
		PRIMARY KEY (`event_id`,`post_id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($ua_auction_events_sql);

	$ua_auction_payment_cards = $wpdb->prefix . "ua_auction_payment_cards";  //get the database table prefix to create my new table
	$ua_auction_payment_cards_sql = "CREATE TABLE IF NOT EXISTS $ua_auction_payment_cards (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`gateway_id` varchar(255) NOT NULL,
		`token` text NOT NULL,
		`user_id` bigint(20) NOT NULL,
		`type` varchar(255) NOT NULL,
		`is_default` tinyint(1) NOT NULL,
		`last4` varchar(255) NOT NULL,
		`expiry_year` varchar(255) NOT NULL,
		`expiry_month` varchar(255) NOT NULL,
		`card_type` varchar(255) NOT NULL,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($ua_auction_payment_cards_sql);

	$ua_auction_product = $wpdb->prefix . "ua_auction_product";  //get the database table prefix to create my new table
	$ua_auction_product_sql = "CREATE TABLE IF NOT EXISTS $ua_auction_product (
		`auction_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`post_id` bigint(20) NOT NULL,
		`post_status` varchar(20) NOT NULL,
		`auction_owner` bigint(20) NOT NULL,
		`auction_status` varchar(20) NOT NULL,
		`auction_name` mediumtext NOT NULL,
		`auction_content` longtext NOT NULL,
		`product_type` varchar(300) NOT NULL,
		`auction_start_date` datetime NOT NULL,
		`auction_end_date` datetime NOT NULL,
		`event_id` bigint(20) NOT NULL,
		`lang_code` varchar(10) DEFAULT NULL,
		PRIMARY KEY (`auction_id`,`post_id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($ua_auction_product_sql);

	$woo_ua_auction_log = $wpdb->prefix . "woo_ua_auction_log";  //get the database table prefix to create my new table
	$woo_ua_auction_log_sql = "CREATE TABLE IF NOT EXISTS $woo_ua_auction_log (
		`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		`userid` bigint(20) UNSIGNED NOT NULL,
		`auction_id` bigint(20) UNSIGNED DEFAULT NULL,
		`bid` decimal(32,4) DEFAULT NULL,
		`date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
		`proxy` tinyint(1) DEFAULT NULL,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($woo_ua_auction_log_sql);

	$auction_direct_payment = $wpdb->prefix . "auction_direct_payment";  //get the database table prefix to create my new table
	$auction_direct_payment_sql = "CREATE TABLE IF NOT EXISTS $auction_direct_payment (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`pid` int(11) NOT NULL,
		`uid` int(11) NOT NULL,
		`debit_type` varchar(255) NOT NULL,
		`debit_amount_type` varchar(255) NOT NULL,
		`amount_or_percentage` varchar(255) NOT NULL,
		`transaction_amount` varchar(255) NOT NULL,
		`main_amount` varchar(255) NOT NULL,
		`status` varchar(255) NOT NULL,
		`response_json` text NOT NULL,
		`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($auction_direct_payment_sql);

	$auction_payment = $wpdb->prefix . "auction_payment";  //get the database table prefix to create my new table
	$auction_payment_sql = "CREATE TABLE IF NOT EXISTS $auction_payment (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`pid` int(11) NOT NULL,
		`uid` int(11) NOT NULL,
		`transaction_id` varchar(255) NOT NULL,
		`transaction_amount` int(11) NOT NULL,
		`status` varchar(255) NOT NULL,
		`response_json` text NOT NULL,
		`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($auction_payment_sql);

	/* seller payment logs table */
	$auction_seller_payment = $wpdb->prefix . "auction_seller_payment";  //get the database table prefix to create my new table
	$auction_seller_payment_sql = "CREATE TABLE IF NOT EXISTS $auction_seller_payment (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`order_id` int(11) NOT NULL,
		`product_id` int(11) NOT NULL,
		`seller_id` int(11) NOT NULL,
		`payment_method` varchar(255) NOT NULL,
		`transaction_type` varchar(255),
		`transaction_id` varchar(255),
		`transaction_amount` int(11) NOT NULL,
		`transaction_msg` varchar(255),
		`status` varchar(255) NOT NULL,
		`response_json` text NOT NULL,
		`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";


	dbDelta($auction_seller_payment_sql);
	
	$custom_fields = $wpdb->prefix . "ua_custom_fields";  //get the database table prefix to create my new table
	$custom_fields_sql = "CREATE TABLE IF NOT EXISTS $custom_fields (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`attribute_name` varchar(255) NOT NULL,
		`attribute_slug` varchar(255) NOT NULL,
		`attribute_type` varchar(255) NOT NULL,
		`form_order` int(11) NOT NULL,
		`created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		`updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";


	dbDelta($custom_fields_sql);

	$custom_fields_options = $wpdb->prefix . "ua_custom_fields_options";  //get the database table prefix to create my new table
	$custom_fields_options_sql = "CREATE TABLE IF NOT EXISTS $custom_fields_options (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`field_id` int(11) NOT NULL,
		`meta_key` varchar(255) NOT NULL,
		`meta_value` text NOT NULL,
		PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";


	dbDelta($custom_fields_options_sql);
}
