<?php
 if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array (
	'key' => 'group_1',
	'title' => 'My Group',
	'fields' => array (
		array (
			'key' => 'field_1',
			'label' => 'Sub Title',
			'name' => 'sub_title',
			'type' => 'text',
			'prefix' => '',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		)
	),
	'location' => array (
		array (
			array (
				'param' => 'page',
				'operator' => '==',
				'value' => 'uat_pop',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
));
endif;
add_action( 'admin_init', 'tarex_theme_activation_redirect' );
function tarex_theme_activation_redirect() {
    global $pagenow;
    if ( "themes.php" == $pagenow && is_admin() && isset( $_GET['activated'] ) ) {
		// wp_redirect( esc_url_raw( add_query_arg( 'page', 'uat_pop', admin_url( 'index.php' ) ) ) );
		 wp_safe_redirect( admin_url( 'admin.php?page=ua-auctions-theme' ) );
	}
}

/* old popup code - start */
// add_action( 'admin_init', 'tarex_theme_activation_redirect' );
// function tarex_theme_activation_redirect() {
//     global $pagenow;
//     if ( "themes.php" == $pagenow && is_admin() && isset( $_GET['activated'] ) ) {
// 		// wp_redirect( esc_url_raw( add_query_arg( 'page', 'uat_pop', admin_url( 'index.php' ) ) ) );
// 		 wp_safe_redirect( admin_url( 'index.php?page=uat_pop' ) );
// 	}
// }
// add_action( 'admin_menu', 'uat_auction_admin_menus' );
// function uat_auction_admin_menus() {		
// 		add_dashboard_page( '', '', 'manage_options', 'uat_pop', '');
// 		add_dashboard_page( '', '', 'manage_options', 'uat_site_setup', '');
// }
// add_action( 'admin_init','uat_auction_theme_setup' );
// function uat_auction_theme_setup() {
// 	$getpage=filter_input(INPUT_GET, 'page');
// 	if ( $getpage != 'uat_pop' && $getpage != 'uat_site_setup') {
// 			return;
// 	}
// 	if(!empty($_GET['page']) && $_GET['page']=='uat_pop'){
// 		require_once(plugin_dir_path(__FILE__) . 'step/step_uat_pop.php');
// 	}
// 	if(!empty($_GET['page']) && $_GET['page']=='uat_site_setup'){
// 		require_once(plugin_dir_path(__FILE__) . 'step/step_uat_site_setup.php');
// 	}
// }
/* old popup code - end */

function uat_create_all_default_options(){
	update_option('timezone_string', "Asia/Kolkata");
	//Credit card event page
	update_option("options_uat_enable_credit_cart_sp_events", "yes");
	update_option("_options_uat_enable_credit_cart_sp_events", "uat_enable_credit_cart_sp_events");
	//BP event page
	update_option("options_uat_enable_buyers_premium_ge", "yes");
	update_option("_options_uat_enable_buyers_premium_ge", "uat_enable_buyers_premium_ge");
	//Credit card product page
	update_option("options_uat_enable_credit_cart_sp_products", "yes");
	update_option("_options_uat_enable_credit_cart_sp_products", "uat_enable_credit_cart_sp_products");
	//BP product page
	update_option("options_uat_enable_buyers_premium_sp", "yes");
	update_option("_options_uat_enable_buyers_premium_sp", "uat_enable_buyers_premium_sp");
	//BP WCFM product page
	update_option("options_uat_enable_buyers_premium_sp_wcfm", "yes");
	update_option("_options_uat_enable_buyers_premium_sp_wcfm", "uat_enable_buyers_premium_sp_wcfm");
	//Q A on product page
	update_option("options_q_a_auction_product_page", "on");
	update_option("_options_q_a_auction_product_page", "q_a_auction_product_page");
	//comment on auction products page
	update_option("options_uat_auction_comments", "on");
	update_option("_options_uat_auction_comments", "uat_auction_comments");
	//comment on Default products page
	update_option("options_wc_default_page_comments", "on");
	update_option("_options_wc_default_page_comments", "wc_default_page_comments");
	//comment on Default products page
	update_option("options_blog_default_page_comments", "on");
	update_option("_options_blog_default_page_comments", "blog_default_page_comments");
	//comment on blog  page
	update_option("options_blog_default_page_comments", "on");
	update_option("_options_blog_default_page_comments", "blog_default_page_comments");
	//menu open type
	update_option("options_menu_link_types", "menu_open_in_popup");
	update_option("_options_menu_link_types", "menu_link_types");
	/*footer */
	$options_uat_copyright_text ='Copyright | <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> by <a href="https://getultimateauction.com/">Ultimate Auction Pro</a> | All Rights Reserved | Powered by <a href="https://wordpress.org">WordPress</a>';
	update_option("options_uat_copyright_bar", "on");
	update_option("options_uat_copyright_text", $options_uat_copyright_text);
}

function uat_create_all_default_pages(){
	/* Sample pages */
	$html = '';
	$html .= '<h3>All Auctions</h3>';
	$html .= '<!-- wp:shortcode -->[uwa_all_auctions timer="true"]<!-- /wp:shortcode -->';
	$html  .= '<h3>All Auction Events</h3>';
	$html .= '<!-- wp:shortcode -->[ua_all_events timer="true"]<!-- /wp:shortcode -->';
	$pname1 = 'Home';
    $pid1 = create_page($pname1, $html);
	$homepage_id = $pid1;
	if ( $homepage_id )
	{	update_option( 'page_on_front', $homepage_id );
		update_option( 'show_on_front', 'page' );
		//update_post_meta( $homepage_id, '_wp_page_template', 'page-templates/template-home.php' );
	}

	$pname2 = 'Sample Page 1';
	$pid2 = create_page($pname2, 'This is sample page 1');
	$html = '<!-- wp:shortcode -->[uwa_all_auctions timer="true"]<!-- /wp:shortcode -->';
	$pname3 = 'All Auctions';
	$pid3 = create_page($pname3, $html);
	$html = '<!-- wp:shortcode -->[uwa_expired_auctions]<!-- /wp:shortcode -->';
	$pname4 = 'Past Auctions';
	$pid4 = create_page($pname4, $html);
	$html = ' <!-- wp:shortcode -->[uwa_live_auctions timer="true"]<!-- /wp:shortcode -->';
	$pname5 = 'Live Auctions';
	$pid5 = create_page($pname5, $html);
	$html = ' <!-- wp:shortcode -->[uwa_pending_auctions timer="true"]<!-- /wp:shortcode -->';
	$pname13 = 'Future Auctions';
	$pid13 = create_page($pname13, $html);
	$html = ' <!-- wp:shortcode -->[ua_live_events timer="true"]<!-- /wp:shortcode -->';
	$pname10 = 'Live Events';
	$pid10 = create_page($pname10, $html);
	$html = ' <!-- wp:shortcode -->[ua_future_events timer="true"]<!-- /wp:shortcode -->';
	$pname11 = 'Future Events';
	$pid11 = create_page($pname11, $html);
	$html = ' <!-- wp:shortcode -->[ua_past_events timer="true"]<!-- /wp:shortcode -->';
	$pname12 = 'Past Events';
	$pid12 = create_page($pname12, $html);
	$html = "<h2>What is Lorem Ipsum?</h2>
<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum</p>";
	$pname6 = 'About Us';
	$pid6 = create_page($pname6, $html);
	$html = '[gravityform id="3" title="false" description="false" ajax="true" ]';
	$pname7 = 'Contact Us';
	$pid7 = create_page($pname7, $html);
	$html = ''; //template
	$pname8 = 'Event List';
	$pid8 = create_page($pname8, $html);
	update_post_meta($pid8, '_wp_page_template', 'page-templates/template-events-list.php');
	update_post_meta($pid8, 'event_page_tmp_page_layout', 'left-sidebar');
	update_post_meta($pid8, 'event_page_tmp_sortbydate', 'on');
	update_post_meta($pid8, 'event_page_tmp_reset_filter', 'on');
	update_post_meta($pid8, 'event_page_tmp_daterange', 'on');
	update_post_meta($pid8, 'event_page_tmp_searchbar', 'on');
	update_post_meta($pid8, 'event_page_tmp_viewbar', 'on');
	update_post_meta($pid8, 'event_list_page_timer', 'false');
	$html = ''; //template
	$pname9 = 'Single Auction Products List';
	$pid9 = create_page($pname9, $html);
	update_post_meta($pid9, '_wp_page_template', 'page-templates/template-Single-Products.php');
	update_post_meta($pid9, 'uat_product_single_list_page_layout', 'left-sidebar');
	update_post_meta($pid9, 'uat_product_single_list_sortbydate', 'on');
	update_post_meta($pid9, 'uat_product_single_list_pricerange_bids', 'on');
	update_post_meta($pid9, 'uat_product_single_list_pricerange', 'on');
	update_post_meta($pid9, 'uat_product_single_list_resultbar', 'on');
	update_post_meta($pid9, 'uat_product_single_list_reset_filter', 'on');
	update_post_meta($pid9, 'uat_product_single_list_daterange', 'on');
	update_post_meta($pid9, 'product_list_page_timer', 'true');
	update_option("uat_sample_pages_setup", "no");
	if( $pid9 ){
		update_option("uat_sample_pages_setup", "yes");
	}
	
    $user_id=get_current_user_id();
	$textset="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
	$post_name='Demo Post Created';
	$post_id = wp_insert_post( array(
		//'ID'  => 11,
	    'post_title' => $post_name.'',
	    'post_content' => $post_name.''.$textset,
	    'post_excerpt' => $post_name.''.$textset,
	    'post_status' => 'publish',
	    'post_type' => 'post',
	    'post_author' => $user_id,
	    'post_name'  => $post_name,
	));
	
	
	// create main menu if not exists
	$menuname = 'main_menu';
	$bpmenulocation = 'secondary';
	// Does the menu exist already?
	$menu_exists = wp_get_nav_menu_object($menuname);
	// If it doesn't exist, let's create it.
	if (!$menu_exists) {
		$menu_id = wp_create_nav_menu($menuname);
		if (!has_nav_menu($bpmenulocation)) {
			$locations = get_theme_mod('nav_menu_locations');
			$locations[$bpmenulocation] = $menu_id;
			set_theme_mod('nav_menu_locations', $locations);
		}
	}
	$main_menu = wp_get_nav_menu_items('main_menu');
	$main_menu_id = wp_get_nav_menu_object("main_menu")->term_id ?? "";
	if ($main_menu_id) {
		if (!find_my_menu_item($main_menu, $pname1)) {
			wp_update_nav_menu_item($main_menu_id, 0, array(
				'menu-item-title' =>  __($pname1),
				'menu-item-classes' => '',
				'menu-item-url' => get_page_link($pid1),
				'menu-item-status' => 'publish'
			));
		}
		if (!find_my_menu_item($main_menu, 'Events')) {
			$event_menu_id = wp_update_nav_menu_item($main_menu_id, 0, array(
				'menu-item-title' =>  __('Events'),
				'menu-item-classes' => '',
				'menu-item-url' => get_page_link($pid8),
				'menu-item-status' => 'publish'
			));
			if (!find_my_menu_item($main_menu, 'Future events')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Future events'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid11),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $event_menu_id
				));
			}
			if (!find_my_menu_item($main_menu, 'Live events')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Live events'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid10),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $event_menu_id
				));
			}
			if (!find_my_menu_item($main_menu, 'Past events')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Past events'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid12),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $event_menu_id
				));
			}
		}
		if (!find_my_menu_item($main_menu, 'Auctions')) {
			$auction_menu_id = wp_update_nav_menu_item($main_menu_id, 0, array(
				'menu-item-title' =>  __('Auctions'),
				'menu-item-classes' => '',
				'menu-item-url' => get_page_link($pid3),
				'menu-item-status' => 'publish'
			));
			if (!find_my_menu_item($main_menu, 'Future auctions')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Future auctions'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid13),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $auction_menu_id
				));
			}
			if (!find_my_menu_item($main_menu, 'Live auctions')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Live auctions'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid5),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $auction_menu_id
				));
			}
			if (!find_my_menu_item($main_menu, 'Past auctions')) {
				wp_update_nav_menu_item($main_menu_id, 0, array(
					'menu-item-title' =>  __('Past auctions'),
					'menu-item-classes' => '',
					'menu-item-url' => get_page_link($pid4),
					'menu-item-status' => 'publish',
					'menu-item-parent-id' => $auction_menu_id
				));
			}
		}
		if (!find_my_menu_item($main_menu, 'Simple Products')) {
			wp_update_nav_menu_item($main_menu_id, 0, array(
				'menu-item-title' =>  __('Simple Products'),
				'menu-item-classes' => '',
				'menu-item-url' => get_permalink(wc_get_page_id('shop')),
				'menu-item-status' => 'publish'
			));
		}

		 update_option("uat_sample_menu_setup", "yes");

	}
}

function uat_create_all_auction_productsand_events() {
	$currentuserid=get_current_user_id();
	$users = get_user_by('id',$currentuserid);
	$current_user =isset($users->data->user_login) ? $users->data->user_login : '';
	$user_emails = isset($users->data->user_email) ? $users->data->user_email : '';

	/* Product 1 Live	*/
	$post_name='White Bmw Car';
	$o_price="153000";
	$b_price="163000";
	$auction_type ="proxy";
	$product_id_live=uwa_create_product($post_name, $currentuserid,$type1='uat_live',$o_price,$b_price,$auction_type);
	
	/* Question 1	*/
	$data_questions_1=array();
	$data_questions_1['question_text'] ='What is Lorem Ipsum?';
	$data_questions_1['asked_by_id'] = $currentuserid;
	$data_questions_1['post_id'] = $product_id_live;
	$data_questions_1['post_owner_id'] = $currentuserid;
	$questions_id_1= uat_add_questions_to_products($product_id_live,$data_questions_1);

	$data_answer_1=array();
	$data_answer_1['question_id'] = $questions_id_1;
	$data_answer_1['answered_by_id'] = $currentuserid;
	$data_answer_1['answer_text'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_answer_to_questions($questions_id_1,$data_answer_1);

	$data_comments_1=array();
	$data_comments_1['comment_author'] = $current_user;
	$data_comments_1['comment_author_email'] = $user_emails;
	$data_comments_1['comment_author_url'] = "";
	$data_comments_1['comment_content'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_comment_products($product_id_live,$data_comments_1);
	wp_set_object_terms( $product_id_live, 'auction', 'product_type' );
	/* Question 2	*/
	$data_questions_2=array();
	$data_questions_2['question_text'] ='Why do we use it?';
	$data_questions_2['asked_by_id'] = $currentuserid;
	$data_questions_2['post_id'] = $product_id_live;
	$data_questions_2['post_owner_id'] = $currentuserid;
	$questions_id_2= uat_add_questions_to_products($product_id_live,$data_questions_2);

	$data_answer_2=array();
	$data_answer_2['question_id'] =$questions_id_2;
	$data_answer_2['answered_by_id'] = $currentuserid;
	$data_answer_2['answer_text'] = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters";
	uat_add_answer_to_questions($questions_id_2,$data_answer_2);

	$data_comments_2=array();
	$data_comments_2['comment_author'] = $current_user;
	$data_comments_2['comment_author_email'] = $user_emails;
	$data_comments_2['comment_author_url'] = "";
	$data_comments_2['comment_content'] = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor";
	uat_add_comment_products($product_id_live,$data_comments_2); 
	wp_set_object_terms( $product_id_live, 'auction', 'product_type' );
	
	/*Events 1 Live*/
	$event_name_live='BMW Car Auction';
	uwa_create_event($event_name_live, $currentuserid,$type='uat_live',$product_id_live);

	/* Product 1 Past	*/
	$post_name='Black Audi A-series';
	$o_price="35000";
	$b_price="45000";
	$auction_type ="simple";
	$product_id_past=uwa_create_product($post_name, $currentuserid,$type1='uat_past',$o_price,$b_price,$auction_type);

	/* Question 5	*/
	$data_questions_5=array();
	$data_questions_5['question_text'] ='What is Lorem Ipsum?';
	$data_questions_5['asked_by_id'] = $currentuserid;
	$data_questions_5['post_id'] = $product_id_past;
	$data_questions_5['post_owner_id'] = $currentuserid;
	$questions_id_1= uat_add_questions_to_products($product_id_past,$data_questions_5);

	$data_answer_5=array();
	$data_answer_5['question_id'] = $questions_id_1;
	$data_answer_5['answered_by_id'] = $currentuserid;
	$data_answer_5['answer_text'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_answer_to_questions($questions_id_1,$data_answer_5);

	$data_comments_5=array();
	$data_comments_5['comment_author'] = $current_user;
	$data_comments_5['comment_author_email'] = $user_emails;
	$data_comments_5['comment_author_url'] = "";
	$data_comments_5['comment_content'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_comment_products($product_id_past,$data_comments_5);
    wp_set_object_terms( $product_id_past, 'auction', 'product_type' );
	
	
	/* Question 2	*/
	$data_questions_6=array();
	$data_questions_6['question_text'] ='Why do we use it?';
	$data_questions_6['asked_by_id'] = $currentuserid;
	$data_questions_6['post_id'] = $product_id_past;
	$data_questions_6['post_owner_id'] = $currentuserid;
	$questions_id_6= uat_add_questions_to_products($product_id_past,$data_questions_6);

	$data_answer_6=array();
	$data_answer_6['question_id'] =$questions_id_6;
	$data_answer_6['answered_by_id'] = $currentuserid;
	$data_answer_6['answer_text'] = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters";
	uat_add_answer_to_questions($questions_id_6,$data_answer_6);

	$data_comments_6=array();
	$data_comments_6['comment_author'] = $current_user;
	$data_comments_6['comment_author_email'] = $user_emails;
	$data_comments_6['comment_author_url'] = "";
	$data_comments_6['comment_content'] = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor";
	uat_add_comment_products($product_id_past,$data_comments_6);
	wp_set_object_terms( $product_id_past, 'auction', 'product_type' );
	
	/*Events 1 Past*/
	$event_name_past='Audi Car Auction';
	uwa_create_event($event_name_past, $currentuserid,$type='uat_past',$product_id_past);

	/* Product 1 Future	*/
	$post_name='Black Mercedes Benz';
	$o_price="30000";
	$b_price="45000";
	$auction_type ="simple";
	$product_id_future=uwa_create_product($post_name, $currentuserid,$type1='uat_future',$o_price,$b_price,$auction_type);

	/* Question 3	*/
	$data_questions_3=array();
	$data_questions_3['question_text'] ='What is Lorem Ipsum?';
	$data_questions_3['asked_by_id'] = $currentuserid;
	$data_questions_3['post_id'] = $product_id_future;
	$data_questions_3['post_owner_id'] = $currentuserid;
	$questions_id_1= uat_add_questions_to_products($product_id_future,$data_questions_3);

	$data_answer_3=array();
	$data_answer_3['question_id'] = $questions_id_1;
	$data_answer_3['answered_by_id'] = $currentuserid;
	$data_answer_3['answer_text'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_answer_to_questions($questions_id_1,$data_answer_3);

	$data_comments_3=array();
	$data_comments_3['comment_author'] = $current_user;
	$data_comments_3['comment_author_email'] = $user_emails;
	$data_comments_3['comment_author_url'] = "";
	$data_comments_3['comment_content'] = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and ";
	uat_add_comment_products($product_id_future,$data_comments_3);
	wp_set_object_terms( $product_id_future, 'auction', 'product_type' );

	/* Question 2	*/
	$data_questions_4=array();
	$data_questions_4['question_text'] ='Why do we use it?';
	$data_questions_4['asked_by_id'] = $currentuserid;
	$data_questions_4['post_id'] = $product_id_future;
	$data_questions_4['post_owner_id'] = $currentuserid;
	$questions_id_4= uat_add_questions_to_products($product_id_future,$data_questions_4);

	$data_answer_4=array();
	$data_answer_4['question_id'] =$questions_id_4;
	$data_answer_4['answered_by_id'] = $currentuserid;
	$data_answer_4['answer_text'] = "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters";
	uat_add_answer_to_questions($questions_id_4,$data_answer_4);

	$data_comments_4=array();
	$data_comments_4['comment_author'] = $current_user;
	$data_comments_4['comment_author_email'] = $user_emails;
	$data_comments_4['comment_author_url'] = "";
	$data_comments_4['comment_content'] = "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor";
	uat_add_comment_products($product_id_future,$data_comments_4);
	wp_set_object_terms( $product_id_future, 'auction', 'product_type' );

	/*Events 1 Future*/
	$event_name_future='Mercedes Benz Car Auction';
	uwa_create_event($event_name_future, $currentuserid,$type='uat_future',$product_id_future);

	if( $product_id_future ){
		update_option("uat_sample_auction_products_setup", "yes");
		update_option("uat_sample_events_products_setup", "yes");
	}
}



function fun_import_demo_data_ajax(){
	global $wpdb;
	set_time_limit(300);
	$is_all_installed = get_option("is_uat_sample_data_installed", false);		
	if($is_all_installed != "yes"){
		// echo "<br>not installed..";
		uat_create_all_default_options();
		update_option('woo_acf_lets_go', "1");		
		uat_create_all_default_pages();
		uat_create_all_auction_productsand_events();
		//uat_create_all_menu();
		$uat_sample_menu = get_option("uat_sample_menu_setup", true);
		$uat_sample_pages = get_option("uat_sample_pages_setup", true);
		$sample_products = get_option("uat_sample_auction_products_setup", true);
		$sample_events = get_option("uat_sample_events_products_setup", true);
		if( $uat_sample_menu == "yes" && $uat_sample_pages == "yes"  && $sample_products == "yes"   && $sample_events == "yes"  ){
			update_option("is_uat_sample_data_installed", "yes");
			echo "Import Demo Data Successfull.";
		}
	}else{
		echo "Demo data already imported.";
	}
  	wp_die();
 }
 // creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_fun_import_demo_data_ajax', 'fun_import_demo_data_ajax' );
add_action( 'wp_ajax_fun_import_demo_data_ajax', 'fun_import_demo_data_ajax' );



function create_page($title_of_the_page, $content, $parent_id = NULL)
{
	$objPage = get_page_by_title($title_of_the_page, 'OBJECT', 'page');
	if (!empty($objPage)) {
		// echo "Page already exists:" . $title_of_the_page . "<br/>";
		return $objPage->ID;
	}
	$page_id = wp_insert_post(
		array(
			'comment_status' => 'close',
			'ping_status'    => 'close',
			'post_author'    => 1,
			'post_title'     => ucwords($title_of_the_page),
			'post_name'      => strtolower(str_replace(' ', '-', trim($title_of_the_page))),
			'post_status'    => 'publish',
			'post_content'   => $content,
			'post_type'      => 'page',
			'post_parent'    =>  $parent_id //'id_of_the_parent_page_if_it_available'
		)
	);

	return $page_id;
}

function find_my_menu_item($handle, $sub = false)
{
	if (empty($handle)) {
		return false;
	}
	foreach ($handle as $k => $item) {
		if ($item->post_title == $sub)
			return true;
	}
	return false;
}

function uwa_create_event($post_name, $currentuserid,$type,$product_id){
	 global $woocommerce;
	$textset="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
	 $post_id = wp_insert_post( array(
		//'ID'  => 11,
		'post_title' => $post_name.'',
		'post_content' => $textset,
		'post_excerpt' => $textset,
		'post_status' => 'publish',
		'post_type' => 'uat_event',
		'post_author' => $currentuserid,
		'post_name'  => $post_name,
	));
	$setstatus='';
	if($type=='uat_live'){
		$start_time_and_date=date('Y-m-d h:i:s',strtotime('-1 days',strtotime(date('Y-m-d h:i:s'))));
		$end_time_and_date=date('Y-m-d h:i:s',strtotime('+30 days',strtotime(date('Y-m-d h:i:s'))));
		update_post_meta($post_id, 'start_time_and_date', $start_time_and_date );
		update_post_meta($post_id, 'end_time_and_date', $end_time_and_date );
		update_post_meta( $product_id, 'woo_ua_auction_start_date',stripslashes($start_time_and_date));
		update_post_meta( $product_id, 'woo_ua_auction_end_date', stripslashes($end_time_and_date));
		$setstatus='uat_live';

	 }
	 if($type=='uat_past'){
		$start_time_and_date=date('Y-m-d h:i:s',strtotime('-15 days',strtotime(date('Y-m-d h:i:s')))) ;
		$end_time_and_date=date('Y-m-d h:i:s',strtotime('-10 days',strtotime(date('Y-m-d h:i:s'))));
		update_post_meta($post_id, 'start_time_and_date', $start_time_and_date );
		update_post_meta($post_id, 'end_time_and_date', $end_time_and_date );
		update_post_meta( $product_id, 'woo_ua_auction_start_date',stripslashes($start_time_and_date));
		update_post_meta( $product_id, 'woo_ua_auction_end_date', stripslashes($end_time_and_date));
		$setstatus='uat_past';
	 }
	  if($type=='uat_future'){
		 $start_time_and_date=date('Y-m-d h:i:s',strtotime('+10 days',strtotime(date('Y-m-d h:i:s'))));
		 $end_time_and_date=date('Y-m-d h:i:s',strtotime('+30 days',strtotime(date('Y-m-d h:i:s')))) ;
		update_post_meta($post_id, 'start_time_and_date', $start_time_and_date );
		update_post_meta($post_id, 'end_time_and_date', $end_time_and_date );
		update_post_meta( $product_id, 'woo_ua_auction_start_date',stripslashes($start_time_and_date));
		update_post_meta( $product_id, 'woo_ua_auction_end_date', stripslashes($end_time_and_date));
		$setstatus='uat_future';
	 }
	update_post_meta($post_id, 'uat_choose_product', 'uat_product_manually' );
	update_post_meta($post_id, 'uat_enable_bid_increment', 'yes' );
	update_post_meta($post_id, 'uat_set_bid_incremental_type', 'fix_inc' );
	update_post_meta($post_id, 'uat_flat_incremental_price', '1' );
	$proid=array();
	$proid[]=$product_id;
	$p_data = $proid;
	//print_r($p_data);
	update_post_meta($post_id, 'uat_select_products_menually', $p_data );	
    $p_dataset=serialize($p_data);
	global $wpdb;
	$query   ="UPDATE `".$wpdb->prefix."ua_auction_events` SET `event_status` = '".$type."', `event_products_ids` = '".$p_dataset."' WHERE `post_id` = ".$post_id;
	$wpdb->get_results( $query );
	$query_product   ="UPDATE `".$wpdb->prefix."ua_auction_product` SET `event_id` = '".$post_id."' WHERE `post_id` = ".$product_id;
	$wpdb->get_results( $query_product );
		$product = wc_get_product($product_id);
		$auction_array = array();
		$auction_array['post_id'] = $product->get_id();
		$auction_array['post_status'] = $product->get_status();
		$auction_array['auction_owner'] = 1;
		$auction_array['auction_status'] = $setstatus;
		$auction_array['auction_name'] = $product->get_name();
		$auction_array['auction_content'] = get_post_field('post_content', $post_id);
		$auction_array['product_type'] = $product->get_type();
		$auction_array['auction_start_date'] = $start_time_and_date;
		$auction_array['auction_end_date'] = $end_time_and_date;
		$auction_array['event_id'] = $post_id;
		$products_exists = $wpdb->get_var('SELECT post_id FROM ' . UA_AUCTION_PRODUCT_TABLE . " WHERE post_id=" . $product_id);
		if ($products_exists) {
			$wpdb->update(UA_AUCTION_PRODUCT_TABLE, $auction_array, array('post_id' => $post_id));
		} else {
			$wpdb->insert(UA_AUCTION_PRODUCT_TABLE, $auction_array);
			
		}
		$insert_id = $wpdb->insert_id;
		update_post_meta($product_id, 'auction_id', $insert_id);
		wat_auction_save_post_callback($product_id);

		update_post_meta($product_id, 'uat_event_id', $post_id);
		update_post_meta($product_id, 'uwa_event_auction', "yes");




	}
function uwa_create_product($post_name, $currentuserid,$type1,$o_price,$b_price,$auction_type){
	$textset="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
	$post_id = wp_insert_post( array(
		//'ID'  => 11,
	    'post_title' => $post_name.'',
	    'post_content' => $post_name.''.$textset,
	    'post_excerpt' => $post_name.''.$textset,
	    'post_status' => 'publish',
	    'post_type' => 'product',
	    'post_author' => $currentuserid,
	    'post_name'  => $post_name,
	));
	
	if($post_id > 0){
		wp_set_object_terms( $post_id, 'auction', 'product_type' );
		$auction_type = "normal"; // normal, reverse
		$product_condition = "used";  // new, used
		$opening_price = $o_price;
		$lowest_price = 35000;
		$increment = 500;
		$buy_now_price = $b_price;
		if($type1=='uat_live'){
			 
			$start_date=date('Y-m-d h:i:s',strtotime('-1 days',strtotime(date('Y-m-d h:i:s'))));
			$end_date=date('Y-m-d h:i:s',strtotime('+30 days',strtotime(date('Y-m-d h:i:s'))));
		}
		
		if($type1=='uat_past'){
			$start_date=date('Y-m-d h:i:s',strtotime('-15 days',strtotime(date('Y-m-d h:i:s')))) ;
			$end_date=date('Y-m-d h:i:s',strtotime('-10 days',strtotime(date('Y-m-d h:i:s'))));
		}
		
		if($type1=='uat_future'){
			 $start_date=date('Y-m-d h:i:s',strtotime('+10 days',strtotime(date('Y-m-d h:i:s'))));
			$end_date=date('Y-m-d h:i:s',strtotime('+30 days',strtotime(date('Y-m-d h:i:s')))) ;
		}
		$post_name_img = str_replace(" ", "_", $post_name);
		$image_url = "";
		$live_auction_arr  = array(
			//'auc_type_normal' => $auction_type_normal,
			'auc_pro_cond' => $product_condition,
			'auc_op_price' => $opening_price,
			'auc_low_price' => $lowest_price,
			'auc_inc' => $increment,
			'auc_buynow_price' => $buy_now_price,
			'auc_startdt' => $start_date,
			'auc_enddt' => $end_date,
			'auc_img_url' => $image_url,
			'auc_type' => $auction_type,
		);
		/* save all data */
		uwa_save_pruduct_data_oneclick($post_id, $live_auction_arr);
	if($type1=='uat_live'){
		update_post_meta( $post_id, 'woo_ua_auction_has_started', '1');
	 }
	 if($type1=='uat_past'){
		update_post_meta( $post_id, 'woo_ua_auction_closed', '1');
		update_post_meta( $post_id, 'woo_ua_auction_fail_reason', '1');
	 }
	  if($type1=='uat_future'){
		update_post_meta( $post_id, 'woo_ua_auction_started', '0');
	 }
	 update_post_meta( $post_id, 'uat_auction_lot_number', '');
	 update_post_meta( $post_id, 'uat_type_of_auction_event', 'uat_event_timed');
	// update_post_meta( $post_id, 'woo_ua_auction_selling_type', 'auction');
		return $post_id;
	} /* end of if - post id */
	else{
		return 0;
	}
}

function uwa_save_pruduct_data_oneclick($post_id, $data_arr){
	$auc_type_normal =  $data_arr['auc_type_normal'];
	$product_condition =  $data_arr['auc_pro_cond'];
	$opening_price =  $data_arr['auc_op_price'];
	$lowest_price =  $data_arr['auc_low_price'];
	$increment =  $data_arr['auc_inc'];
	$buy_now_price =  $data_arr['auc_buynow_price'];
    $start_date =  $data_arr['auc_startdt'];
    $end_date =  $data_arr['auc_enddt'];
	$image_url =  $data_arr['auc_img_url'];
	$auction_type =  $data_arr['auc_type'];
		// save woocommerce variables
		update_post_meta( $post_id, '_visibility', 'visible' );
		update_post_meta( $post_id, '_stock_status', 'instock');
		update_post_meta( $post_id, 'total_sales', '0' );
		update_post_meta( $post_id, '_downloadable', 'no' );
		update_post_meta( $post_id, '_virtual', 'no' );  /* changed as "no" */
		update_post_meta( $post_id, '_sale_price', '' );
		update_post_meta( $post_id, '_purchase_note', '' );
		update_post_meta( $post_id, '_featured', 'no' );
		update_post_meta( $post_id, '_weight', '' );
		update_post_meta( $post_id, '_length', '' );
		update_post_meta( $post_id, '_width', '' );
		update_post_meta( $post_id, '_height', '' );
		update_post_meta( $post_id, '_sku', '' );
		update_post_meta( $post_id, '_product_attributes', array() );
		update_post_meta( $post_id, '_sale_price_dates_from', '' );
		update_post_meta( $post_id, '_sale_price_dates_to', '' );
		// save auction variables

		if($auction_type =="proxy"){
			update_post_meta( $post_id, 'uwa_auction_proxy', 'yes' );
			update_post_meta( $post_id, 'uwa_auction_silent', '0' );
		//	 update_post_meta( $post_id, 'woo_ua_auction_selling_type', 'auction');
		}elseif($auction_type =="silent"){
			update_post_meta( $post_id, 'uwa_auction_silent', 'yes' );
			update_post_meta( $post_id, 'uwa_auction_proxy', '0' );
		} else {
			update_post_meta( $post_id, 'uwa_auction_proxy', '0' );
		    update_post_meta( $post_id, 'uwa_auction_silent', '0' );
			
		}
		update_post_meta( $post_id, '_manage_stock', 'yes' );
		update_post_meta( $post_id, '_stock', '1' );
		update_post_meta( $post_id, '_backorders', 'no' );
		update_post_meta( $post_id, '_sold_individually', 'yes' );
		update_post_meta( $post_id, 'woo_ua_auction_type',$auction_type);
		update_post_meta( $post_id, 'woo_ua_product_condition',$product_condition);
		update_post_meta( $post_id, 'woo_ua_opening_price',wc_format_decimal($opening_price));
		update_post_meta( $post_id, 'woo_ua_lowest_price',wc_format_decimal($lowest_price));
		update_post_meta( $post_id, 'woo_ua_bid_increment',wc_format_decimal($increment));
		update_post_meta( $post_id, '_regular_price',wc_format_decimal($buy_now_price));
		update_post_meta( $post_id, '_price',wc_format_decimal($buy_now_price));
		update_post_meta( $post_id, 'woo_ua_auction_start_date',stripslashes($start_date));
		update_post_meta( $post_id, 'woo_ua_auction_end_date',stripslashes($end_date));
		update_post_meta( $post_id, 'uwa_number_of_next_bids', '1' );
	   
}

function uat_add_questions_to_products($product_id,$data_questions){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$questions_id="";
	$tablename = $prefix . 'ua_auction_question';
	$data_questions_array = array();
	$data_questions_array['question_text'] = $data_questions['question_text'];
	$data_questions_array['asked_by_id'] = $data_questions['asked_by_id'];
	$data_questions_array['post_id'] = $product_id;
	$data_questions_array['post_owner_id'] = $data_questions['post_owner_id'];
	$data_questions_array['status'] = "active";
	$data_questions_array['created_date'] = date("Y-m-d H:i:s", time());
	$wpdb->insert($tablename, $data_questions_array);
	$questions_id = $wpdb->insert_id;
	if( $questions_id ){
		return $questions_id;
	}else{
		return 0;
	}
}

function uat_add_answer_to_questions($questions_id,$data_answer){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$data_answer_id="";
	$tablename = $prefix . 'ua_auction_answer';
	$data_answer_array = array();
	$data_answer_array['question_id'] = $questions_id;
	$data_answer_array['answered_by_id'] = $data_answer['answered_by_id'];
	$data_answer_array['answer_text'] = $data_answer['answer_text'];
	$data_answer_array['status'] = "active";
	$data_answer_array['created_date'] = date("Y-m-d H:i:s", time());
	$wpdb->insert($tablename, $data_answer_array);
	$data_answer_id = $wpdb->insert_id;
	if( $data_answer_id ){
		return $data_answer_id;
	}else{
		return 0;
	}

}

function uat_add_comment_products($product_id,$data_comments){
	global $wpdb;
	$prefix = $wpdb->prefix;
	$tablename = $prefix . 'comments';
	$agent = $_SERVER['HTTP_USER_AGENT'];
	$data_comments_array = array();
	$data_answer_array['comment_post_ID'] = $product_id;
	$data_answer_array['comment_author'] = $data_comments['comment_author'];
	$data_answer_array['comment_author_email'] = $data_comments['comment_author_email'];
	$data_answer_array['comment_author_url'] = $data_comments['comment_author_url'];
	$data_answer_array['comment_content'] = $data_comments['comment_content'];
	$data_answer_array['comment_author_IP'] = '127.3.1.1';
	$data_answer_array['comment_agent'] = $agent;
	$data_answer_array['comment_type'] = "ua_comment";
	$data_answer_array['comment_date'] = date('Y-m-d H:i:s');
	$data_answer_array['comment_date_gmt'] = date('Y-m-d H:i:s');
	$data_answer_array['user_id'] = '1';
	
	
		$comment_id = wp_insert_comment($data_answer_array);
	
		
	
	$data_comment_id = $wpdb->insert_id;
	if( $data_comment_id ){
		return $data_answer_id;
	}else{
		return 0;
	}
}


function run_activate_plugin( $plugin ) {
    $current = get_option( 'active_plugins' );
    $plugin = plugin_basename( trim( $plugin ) );
    if ( !in_array( $plugin, $current ) ) {
        $current[] = $plugin;
        sort( $current );
        do_action( 'activate_plugin', trim( $plugin ) );
        update_option( 'active_plugins', $current );
        do_action( 'activate_' . trim( $plugin ) );
        do_action( 'activated_plugin', trim( $plugin) );
    }
    return null;
}
//run_activate_plugin( 'akismet/akismet.php' );
//add_action( 'init', 'test_init');
function add_plugin_init(){
	$isplugin=[];
    $plugin_dir = WP_PLUGIN_DIR  .'';
	 $dirnm = scandir($plugin_dir);
     $dcount=count($dirnm);
	 if($dcount>2){
		 for($d=0;$d<$dcount;$d++){
			if($d>1){
			  $pluginnm=$dirnm[$d];
			  $isplugin[]=$pluginnm;
			}
		 }
	 }
	if(in_array("advanced-custom-fields-pro",$isplugin)){
		run_activate_plugin( $plugin_dir.'/advanced-custom-fields-pro/acf.php' );
	}
	if(in_array("woocommerce",$isplugin)){
		run_activate_plugin( $plugin_dir.'/woocommerce/woocommerce.php' );
	}
	if(!in_array("advanced-custom-fields-pro",$isplugin) || !in_array("woocommerce",$isplugin)){
		install_plugin_active();
	}
}
function install_plugin_active(){
	$plugin_dir = WP_PLUGIN_DIR  .'';
	$dir = get_template_directory().'/required_plugins/';
    $dirnm = scandir($dir);
    $dcount=count($dirnm);
   if($dcount>2){
		for($d=0;$d<$dcount;$d++){
			if($d>1){
			  $pluginnm=$dirnm[$d];
				$zip = new ZipArchive;
				$res = $zip->open($dir.$dirnm[$d]);
				if ($res === TRUE) {
				  $zip->extractTo($plugin_dir);
				  $zip->close();
				    if (strpos($pluginnm, 'advanced-custom-fields') !== false) {
						run_activate_plugin( $plugin_dir.'/advanced-custom-fields-pro/acf.php' );
					}
					if (strpos($pluginnm, 'woocommerce') !== false) {
						run_activate_plugin( $plugin_dir.'/woocommerce/woocommerce.php' );
					}
				} else {
				 // echo 'not extract!';
				}
			}
		}
   }
}
function add_preinstall_plugin() {
    add_plugin_init();
}
