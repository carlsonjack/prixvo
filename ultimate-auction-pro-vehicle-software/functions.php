<?php
/**
 * Theme functions and definitions. *
 * Sets up the theme and provides some helper functions *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/ *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Ultimate Auction Theme Pro Car Child
 */

/* Required minimums and constants */
if (!defined('ABSPATH')) {
    exit('Direct script access denied.');
}

global $wpdb;
$prefix = $wpdb->prefix;
/* Required minimums and constants */
if (!defined('UAT_THEME_PRO_VEHICLE_SOFTWARE_VERSION')) {
	define('UAT_THEME_PRO_VEHICLE_SOFTWARE_VERSION', "1.0.0");
}
add_action("wp_enqueue_scripts", "uat_vehicle_child_enqueue_script", 99);
function uat_vehicle_child_enqueue_script()
{
	//wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('vehicle-child-style', get_stylesheet_directory_uri() . '/style.css');
}

function enqueue_car_custom_script() {
    // Enqueue the custom script
    wp_enqueue_script('vehicle-theme-script', get_stylesheet_directory_uri() . '/assets/js/vehicle-theme-custom.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_car_custom_script');


/* Child theme funcations */ 
function show_closest_to_me() {
	$show = false;
	$ctos_car_closest_to_me = get_field('ctos_car_closest_to_me', 'option');
	if (!empty($ctos_car_closest_to_me) && $ctos_car_closest_to_me == 'on') {
		$show = true;
	}
	return $show;
}

function get_nearby_haversine($zip_code, $radius) {
	$api_key = get_option('options_uat_google_maps_api_key');	
	$post_ids = array();
	if(!empty($api_key) && !empty($zip_code)){
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . $zip_code . '&key=' . $api_key;
		$response = wp_remote_get($url);
		$data = json_decode(wp_remote_retrieve_body($response));
		if (!empty($data->results)) {
			$latitude = $data->results[0]->geometry->location->lat;
			$longitude = $data->results[0]->geometry->location->lng;
			global $wpdb;
			$query = "SELECT DISTINCT p1.post_id AS ID, 
						( 3959 * acos( cos( radians($latitude) ) * cos( radians( p2.meta_value ) ) * cos( radians( p3.meta_value ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians( p2.meta_value ) ) ) ) AS distance 
						FROM $wpdb->postmeta p1 
						JOIN $wpdb->postmeta p2 ON p1.post_id = p2.post_id AND p2.meta_key = 'uat_Product_loc_lat' 
						JOIN $wpdb->postmeta p3 ON p1.post_id = p3.post_id AND p3.meta_key = 'uat_Product_loc_lng' 
						HAVING distance < $radius 
						ORDER BY distance";

			$results = $wpdb->get_results( $query );
			if ( $results ) {
				foreach ( $results as $result ) {
					$post_ids[] = $result->ID;
				}
			} 
		}
	}
	return $post_ids;
}

function get_default_field_for_filter($field_key = ""){
	if ( function_exists( 'get_field_object' ) ) {
		$field_object = get_field_object($field_key);
		$allowd_types = ['text', 'number', 'taxonomy', 'checkbox', 'radio'];
		$filter_field = [];
		if(!empty($field_object)){
			$type = $field_object['type'];
			if (in_array($type, $allowd_types))
			{
				$filter_field['key'] = $field_object['key'];
				$filter_field['slug'] = $field_object['name'];
				$filter_field['label'] = $field_object['label'];
				$filter_field['is_custom'] = 'no';
			
				if($type != 'number'){
					$filter_field['input_type'] = 'text';
				}else{
					$filter_field['input_type'] = 'number';
				}
				if($type == 'taxonomy'){
					$filter_field['type'] = 'term';
					$filter_field['name'] = $field_object['taxonomy'];
				}else{
					$filter_field['type'] = 'meta';
					$filter_field['name'] = $field_object['name'];
				}	
			}
		}
	}else{
		$field_object = $field_key;
	}
	return $filter_field;	
}
function get_extra_fields_for_filters(){
	$filter_fields = [];
	/* fields that will not custom fields that is with meta */
	$filter_field = [];
	$filter_field['key'] = "woo_ua_opening_price";
	$filter_field['slug'] = "woo_ua_opening_price";
	$filter_field['name'] = "woo_ua_opening_price";
	$filter_field['label'] = "Opening price";
	$filter_field['type'] = 'meta';
	$filter_field['input_type'] = "number";
	$filter_field['oprator'] = "IN";
	$filter_field['is_custom'] = 'no';
	$filter_fields[] = $filter_field;


	$filter_field = [];
	$filter_field['key'] = "woo_ua_auction_current_bid";
	$filter_field['slug'] = "woo_ua_auction_current_bid";
	$filter_field['name'] = "woo_ua_auction_current_bid";
	$filter_field['label'] = "Current bid price";
	$filter_field['type'] = 'meta';
	$filter_field['input_type'] = "number";
	$filter_field['oprator'] = "IN";
	$filter_field['is_custom'] = 'no';
	$filter_fields[] = $filter_field;

	/* add custom categories use in filters */
	$filter_field = [];
	$filter_field['key'] = "car_models";
	$filter_field['slug'] = "car_models";
	$filter_field['name'] = "car_models";
	$filter_field['label'] = "Car Models";
	$filter_field['type'] = 'term';
	$filter_field['input_type'] = "text";
	$filter_field['oprator'] = "IN";
	$filter_field['is_custom'] = 'no';
	$filter_fields[] = $filter_field;
	/* add custom categories use in filters */
	
	$filter_field = [];
	$filter_field['key'] = "car_makes";
	$filter_field['slug'] = "car_makes";
	$filter_field['name'] = "car_makes";
	$filter_field['label'] = "Car Makes";
	$filter_field['type'] = 'term';
	$filter_field['input_type'] = "text";
	$filter_field['oprator'] = "IN";
	$filter_field['is_custom'] = 'no';	
	$filter_fields[] = $filter_field;

	return $filter_fields;

}

/* enter name to get one field data */
function get_all_filters($name = ""){
	global $wpdb;
	$filter_fields = [];

	/* add default fields added in products */
	$filter_fields[] =  array(
		'key' => 'cmf_condition',
		'slug' => 'cmf_condition',
		'label' => __("Condition", 'ultimate-auction-pro-software'),
		'name' => 'cmf_condition',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);
	
	$filter_fields[] =  array(
		'key' => 'cmf_mileage',
		'slug' => 'cmf_mileage',
		'label' => __("Mileage", 'ultimate-auction-pro-software'),
		'name' => 'cmf_mileage',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);

	$filter_fields[] =  array(
		'key' => 'cmf_fuel_type',
		'slug' => 'cmf_fuel_type',
		'label' => __("Fuel type", 'ultimate-auction-pro-software'),
		'name' => 'cmf_fuel_type',
		'input_type' => 'checkbox',
		'is_custom' => 'no',
		'type' =>'meta',
	);

	$filter_fields[] =  array(
		'key' => 'cmf_engine',
		'slug' => 'cmf_engine',
		'label' => __("Engine", 'ultimate-auction-pro-software'),
		'name' => 'cmf_engine',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);

	$filter_fields[] =  array(
		'key' => 'cmf_year',
		'slug' => 'cmf_year',
		'label' => __("Year", 'ultimate-auction-pro-software'),
		'name' => 'cmf_year',
		'input_type' => 'number',
		'is_custom' => 'no',
		'type' =>'meta',
	);
	
	$filter_fields[] =  array(
		'key' => 'cmf_make',
		'slug' => 'cmf_make',
		'label' => __("Make", 'ultimate-auction-pro-software'),
		'name' => 'cmf_make',
		'input_type' => 'taxonomy',
		'is_custom' => 'no',
		'type' =>'term',
	);

	$filter_fields[] =  array(
		'key' => 'cmf_transmission',
		'slug' => 'cmf_transmission',
		'label' => __("Transmission", 'ultimate-auction-pro-software'),
		'name' => 'cmf_transmission',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);

	$filter_fields[] =  array(
		'key' => 'cmf_interior_color',
		'slug' => 'cmf_interior_color',
		'label' => __("Interior Color", 'ultimate-auction-pro-software'),
		'name' => 'cmf_interior_color',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);
	$filter_fields[] =  array(
		'key' => 'cmf_exterior_color',
		'slug' => 'cmf_exterior_color',
		'label' => __("Exterior Color", 'ultimate-auction-pro-software'),
		'name' => 'cmf_exterior_color',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);
	$filter_fields[] =  array(
		'key' => 'cmf_body_style',
		'slug' => 'cmf_body_style',
		'label' => __("Body Style", 'ultimate-auction-pro-software'),
		'name' => 'cmf_body_style',
		'input_type' => 'text',
		'is_custom' => 'no',
		'type' =>'meta',
	);

	/*
	$filter_fields[] =  get_default_field_for_filter("cmf_condition");
	$filter_fields[] =  get_default_field_for_filter("cmf_mileage");
	$filter_fields[] =  get_default_field_for_filter("cmf_fuel_type");
	$filter_fields[] =  get_default_field_for_filter("cmf_engine");
	$filter_fields[] =  get_default_field_for_filter("cmf_year");
	//$filter_fields[] =  get_default_field_for_filter("cmf_make");
	$filter_fields[] =  get_default_field_for_filter("cmf_transmission");
	$filter_fields[] =  get_default_field_for_filter("cmf_interior_color");
	$filter_fields[] =  get_default_field_for_filter("cmf_exterior_color");
	$filter_fields[] =  get_default_field_for_filter("cmf_body_style");*/

	/* add extra meta and custom category fields that used for filters*/
	$extra_filters = get_extra_fields_for_filters();
	if(!empty($extra_filters)){
		foreach($extra_filters as $extra_filter){
			$filter_fields[] = $extra_filter;
		}
	}

	/* add custom fields user added in products */
	$query   ="SELECT * FROM `".$wpdb->prefix."ua_custom_fields` order by form_order ASC";
	$results = $wpdb->get_results( $query );
	if(count($results) > 0)
	{
		foreach($results as $field){
			$filed_key = $field->id;
			$filed_slug = $field->attribute_slug;
			$filed_name = $field->attribute_name;
			$filed_type = $field->attribute_type;

			$filter_field = [];
			$filter_field['key'] = $filed_key;
			$filter_field['slug'] = $filed_slug;
			$filter_field['name'] = $filed_slug;
			$filter_field['label'] = $filed_name;
			$filter_field['type'] = 'meta';
			$filter_field['input_type'] = $filed_type;
			$filter_field['is_custom'] = 'yes';

			$filter_fields[] = $filter_field;
		}
	}

	if(!empty($name)){
		foreach($filter_fields as $filter_field){
			if($name == $filter_field['name']){
				return $filter_field;
			}
		}
	}
	return $filter_fields;
}

function get_car_list_filers($page_id = 0)
{
	$all_filters = [];
	$proto_option[] = [ 'name' => "car_models", 'title' => "Models", 'type' => "term", 'input_type' => "text", 'operator' => "REGEXP", 'condition' => "AND", 'show' => 'yes', 'is_custom' => 'no'];

	$fields = get_field_objects();
	$page_id = get_the_ID();
	$selected_fields = get_field('car_filers_options', $page_id);
	$show_expired = get_field('car_filers_options_show_expired', $page_id);
	$range_slider_text = get_woocommerce_currency_symbol();

	if (isset($fields['car_filers_options']['layouts']) && !empty($fields['car_filers_options']['layouts'])) {
		$filter_fields = $fields['car_filers_options']['layouts'];
		if(!empty($selected_fields)){

			$layouts = $filter_fields; // Get all the layout options
			$selected = $selected_fields; // Get the selected layouts

			$selectedList = array(); // Initialize an empty array to hold the selected layouts
			$selectedOptions = array(); // Initialize an empty array to hold the selected layouts

			// Loop through the selected layouts
			foreach ($selected as $layout) {
				// Loop through the layout options to find the selected layout
				foreach ($layouts as $option) {
					if ($layout['acf_fc_layout'] == $option['name']) {
						// If a match is found, add it to the selected list array
						$selectedList[] = $option;
						$selectedOptions[$option['name']] = $layout;
						break; // Break out of the inner loop to save time
					}
				}
			}
			if(!empty($selectedList)){
				foreach($selectedList as $selected_filter_field){
					$name = $selected_filter_field['name'];
					$label = $selected_filter_field['label'];
					$label = $selected_filter_field['label'];
					$options = $selectedOptions[$name];
					$condition = "OR";
					$input_type = "text";
					$input_filter_type = "checkbox";
					$show = "yes";
					
					$get_default_field = get_all_filters($name);
					$is_custom = $get_default_field['is_custom']??"no";
					$type = $get_default_field['type']??"meta";
					$oprator = $get_default_field['oprator']??"LIKE";


					if(isset($options['clf_condition_'.$name])){
						$condition = $options['clf_condition_'.$name];
					}
					if(isset($options['clf_input_type_'.$name])){
						$input_type = $options['clf_input_type_'.$name];
						if($input_type == "number" && isset($options['clf_number_input_type_'.$name])){
							$input_filter_type = $options['clf_number_input_type_'.$name];
						}
						if(isset($options['clf_slider_text_'.$name])){
							$range_slider_text = $options['clf_slider_text_'.$name];
						}
					}
					if(isset($options['clf_show_'.$name])){
						$show = $options['clf_show_'.$name];
					}
					$title = $label;
					if(isset($options['clf_title_'.$name])){
						$title = $options['clf_title_'.$name];
					}
					

					$condition = "AND";
					
					$one_filter_add = [
						'name' => $name,
						'title' => $title,
						'type' => $type,
						'input_type' => $input_type,
						'input_filter_type' => $input_filter_type,
						'slider_help_text' => $range_slider_text,
						'show' => $show,
						'is_custom' => $is_custom,
						'operator' => $oprator, 
						'condition' => $condition,
						'show_expired' => $show_expired,
					];
					$all_filters[$name] = $one_filter_add;
				}
			}
		}
	}
	return $all_filters;
}

/* this is used to get number meta values array with count from db */
function get_unique_meta_number_field_values( $filter_options = []) {
	$values = array();
	if(empty($filter_options)){
		return $values;
	}
	$show_expired = $filter_options['show_expired']??'no';
	$field_name = $filter_options['name'];
	$field_key = $field_name;
	if(isset($filter_options['is_custom']) && $filter_options['is_custom'] == 'yes'){
		$field_key = 'uat_custom_field_'.$field_name;
	}
    $query_args = array(
        'post_type' => 'product', // Replace 'product' with your custom post type name
		'post_status' => 'publish',
        // 'meta_key' => $field_key,
        'meta_query' => array(
            array(
                'key' => $field_key,
                'compare' => 'EXISTS', // Only include posts with a non-empty meta field value
            ),
        ),
        'fields' => array( 'ids', 'meta_value' ), // Only retrieve post IDs to optimize performance
        'posts_per_page' => -1, // Retrieve all posts
    );
	if($show_expired == 'no'){
		$query_args['meta_query'][] = array(
											'key' => 'woo_ua_auction_closed',
											'compare' => 'NOT EXISTS',
										);
	}
	$query_args['text_query'][] =  array(
									'taxonomy' => 'product_type',
									'field' => 'slug',
									'terms' => 'auction'
								);
    $query = new WP_Query( $query_args );
    $min_price = 0;
	$max_price = 0;
	$values = [];

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$product_id = get_the_ID();
			$meta_value = get_post_meta( $product_id, $field_key, true );
			$values[] = $meta_value;
			if ( $meta_value && ( $min_price == 0 || $meta_value < $min_price ) ) {
				$min_price = $meta_value;
			}
			if ( $meta_value && $meta_value > $max_price ) {
				$max_price = $meta_value;
			}
		}
	}

	wp_reset_postdata();
    // Convert the associative array to a simple array with 'name' and 'count' keys
    $results = array();
    $results['min'] = $min_price;
    $results['max'] = $max_price;
    $results['values'] = $values;

    return $results;
}

/* this is used to get meta values array with count from db */
function get_unique_field_values_with_count( $filter_options = []) {
	$values = array();
	if(empty($filter_options)){
		return $values;
	}
	$show_expired = $filter_options['show_expired']??'no';
	$field_name = $filter_options['name'];
	$field_key = $field_name;
	if(isset($filter_options['is_custom']) && $filter_options['is_custom'] == 'yes'){
		$field_key = 'uat_custom_field_'.$field_name;
	}
    $query_args = array(
        'post_type' => 'product', // Replace 'product' with your custom post type name
		'post_status' => 'publish',
        'meta_key' => $field_key,
        'meta_query' => array(
            array(
                'key' => $field_key,
                'compare' => 'EXISTS', // Only include posts with a non-empty meta field value
            ),
        ),
        'fields' => 'ids', // Only retrieve post IDs to optimize performance
        'posts_per_page' => -1, // Retrieve all posts
		// 'post__in' => [1772, 1710, 1557, 1555, 1542, 1539],
    );
	if($show_expired == 'no'){
		$query_args['meta_query'][] = array(
											'key' => 'woo_ua_auction_closed',
											'compare' => 'NOT EXISTS',
										);
	}
		$query_args['text_query'][] =  array(
											'taxonomy' => 'product_type',
											'field' => 'slug',
											'terms' => 'auction'
										);
    $query = new WP_Query( $query_args );
    foreach ( $query->posts as $post_id ) {
        $meta_value = get_post_meta( $post_id, $field_key, true );
		$meta_value = maybe_unserialize($meta_value);
        // If the meta value contains commas, split it into an array and add each value separately
        if ( is_string($meta_value) && strpos( $meta_value, ',' ) !== false ) {
            $values_array = explode( ',', $meta_value );
            foreach ( $values_array as $value ) {
                $value = trim( $value ); // Remove any leading/trailing whitespace
                if ( ! isset( $values[ $value ] ) ) {
                    $values[ $value ] = 0;
                }
                $values[ $value ]++;
            }
        }elseif ( is_array($meta_value) ) {
            // $values_array = explode( ',', $meta_value );
            foreach ( $meta_value as $value ) {
                $value = trim( $value ); // Remove any leading/trailing whitespace
                if ( ! isset( $values[ $value ] ) ) {
                    $values[ $value ] = 0;
                }
                $values[ $value ]++;
            }
        } else {
            // If the meta value does not contain commas, add it directly to the $values array
            if ( ! isset( $values[ $meta_value ] ) ) {
                $values[ $meta_value ] = 0;
            }
            $values[ $meta_value ]++;
        }
    }

    // Convert the associative array to a simple array with 'name' and 'count' keys
    $result = array();
    foreach ( $values as $name => $count ) {
        $result[] = array(
            'name' => $name,
            'count' => $count,
            'Title' => ucwords( $name ), // Add a 'Title' key with the capitalized name value
        );
    }

    return $result;
}

function get_make_term_filters($filter_options = []){

	$make_list = array();
	if(empty($filter_options)){
		return $make_list;
	}	
	$show_expired = $filter_options['show_expired']??'no';
	$term = 'car_models';
	$args = array(
		'taxonomy' => $term,
		'hide_empty' => true,		
	);
	$children_terms = get_terms( $args );    
	foreach ( $children_terms as $children_term ) {		
		if($children_term->parent !=0){
			$term_data = array(
				'id' => $children_term->term_id,
				'name' => $children_term->name,
				'count' => $children_term->count,			
			);	
			$make_list[] = $term_data;
		}	
		
	}
	
	return $make_list;
	
}
function get_term_filters($filter_options = []){

	$model_list = array();
	if(empty($filter_options)){
		return $model_list;
	}
	$show_expired = $filter_options['show_expired']??'no';
	$term = $filter_options['name']??'car_models';
	$args = array(
		'taxonomy' => $term,
		'hide_empty' => true,
		'parent' => 0,
	);	
	$parent_terms = get_terms( $args );	
	foreach ( $parent_terms as $parent_term ) {
		$term_data = array(
			'id' => $parent_term->term_id,
			'name' => $parent_term->name,
			'count' => $parent_term->count,
			'children' => array(),
		);		
		$model_list[] = $term_data;
	}
	
	return $model_list;
	
}

add_action("wp_enqueue_scripts", "ua_child_car_listenqueue_script",100);
function ua_child_car_listenqueue_script()
{
	$dir_uri = get_stylesheet_directory_uri();
	wp_register_script('child_car_list_js', $dir_uri . '/assets/js/car-list-template.js', array('jquery'), "");
}


/*------------------------------------
- Functions Car list Template
-------------------------------------*/

add_action('wp_ajax_nopriv_get_car_results_data', 'fun_get_car_results_data');
add_action('wp_ajax_get_car_results_data', 'fun_get_car_results_data');
function fun_get_car_results_data()
{

	global $wpdb;
	$has_result = true;
	$perpage = $_REQUEST['perpage'];
	$setpage = $_REQUEST['setpage'];
	$page_id = $_REQUEST['page_id'];
	$zip_code = !empty($_REQUEST['zip_code']) ? $_REQUEST['zip_code'] : "";
	$radius = !empty($_REQUEST['radius']) ? $_REQUEST['radius'] : "";
	$year = !empty($_REQUEST['year']) ? $_REQUEST['year'] : "";
	$transmission = !empty($_REQUEST['transmission']) ? $_REQUEST['transmission'] : "";
	$body_style = !empty($_REQUEST['body_style']) ? $_REQUEST['body_style'] : "";
	$cat_flt_short = !empty($_REQUEST['cat_flt_short']) ? $_REQUEST['cat_flt_short'] : "";
	$conditinalarr = array('relation' => 'AND');
	$conditinalarr_meta = array('relation' => 'AND');
	$args = array(
		'post_type'	=> 'product',
		'post_status' => 'publish',
		'posts_per_page' =>  $perpage,
		'paged'         => $setpage,
	);
	$conditinalarr[] = array(
		'taxonomy' => 'product_type',
		'field' => 'slug',
		'terms' => 'auction'
	);

	$conditinalarr_meta[] = array(
		'key' => 'woo_ua_auction_closed',
		'compare' => 'NOT EXISTS',
	);
	if (!empty($year)) {
		$conditinalarr_meta[] = array(
			'key' => 'cmf_year',
			'value' => $year,
			'compare' => 'LIKE',
		);
	}
	if (!empty($transmission)) {
		$conditinalarr_meta[] = array(
			'key' => 'cmf_transmission',
			'value' => $transmission,
			'compare' => 'LIKE',
		);
	}
	if (!empty($body_style)) {
		$conditinalarr_meta[] = array(
			'key' => 'cmf_body_style',
			'value' => $body_style,
			'compare' => 'LIKE',
		);
	}


	if ($cat_flt_short == 'ending_soon') {
		$args['meta_key'] = 'woo_ua_auction_end_date';
		$args['orderby'] = 'meta_value woo_ua_auction_end_date';
		$args['order'] = 'ASC';
	}
	if ($cat_flt_short == 'newly_listed') {
		$args['orderby'] = 'date';
		$args['order'] = 'DESC';
	}
	if ($cat_flt_short == 'lowest_mileage') {
		$args['meta_key'] = 'cmf_mileage';
		$args['orderby'] = 'cmf_mileage';
		$args['order'] = 'ASC';
	}
	if ($cat_flt_short == 'no_reserve') {
		$conditinalarr_meta[] = array(
			'key' => 'uwa_auction_has_reserve',
			'value' => 'no',
			'compare' => '=',
		);
	}

	if (count($conditinalarr_meta) > 1) {
		$args['meta_query'] = $conditinalarr_meta;
	}
	if (count($conditinalarr) > 1) {
		$args['tax_query'] = $conditinalarr;
	}
	$productids = [];
	if ($cat_flt_short == 'closest_to_me' && !empty($zip_code) && !empty($radius)) {
		$has_result = false;
		if (!empty($radius)) {
			$productids = get_nearby_haversine($zip_code, $radius);
		}
		if (!empty($productids)) {
			$has_result = true;
			$args['post__in'] = $productids;
		}
	}
	$query = new WP_Query($args);
	$trecord = $query->post_count;
	$mpage = $query->max_num_pages;
	if ($has_result && $query->have_posts()) {
		while ($query->have_posts()) : $query->the_post();
			
			//get_template_part( 'page-templates/partials/car', 'one-product-box' );


			set_query_var('show_timer', 'on');
			wc_get_template_part('content', 'product');

			
			?>
			
		<?php endwhile; ?>
	<?php /*pagination*/
	} else { ?>
		<div class='no-result-found'>
			<?php echo __("Sorry, there are no results", 'ultimate-auction-pro-software'); ?>
		</div>
	<?php }
	// Restore original Post Data
	wp_reset_postdata();
	?>

	<script type="text/javascript">
		jQuery(".live_ac_cpunt").html('(<?php echo $t = $trecord * $mpage; ?>)');
		<?php if ($mpage == trim($_POST['setpage']) || $mpage == 0) { ?>
			jQuery(".show-more").hide();
			jQuery("#max_page").val("hide");
		<?php } else { ?>
			jQuery("#max_page").val("");
			jQuery(".show-more").show();
		<?php } ?>

		/* --------------------------------------------------------
		 Add / Remove savedlist loop
		----------------------------------------------------------- */

		jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);

		function savedlist_loop(event) {
			var auction_id = jQuery(this).data('auction-id');
			var currentelement = jQuery(this);
			jQuery.ajax({
				type: "get",
				url: UAT_Ajax_Url,
				data: {
					post_id: auction_id,
					'uat-ajax': "savedlist_loop"
				},
				success: function(response) {
					currentelement.parent().replaceWith(response);
					jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);
					jQuery(document.body).trigger('uat-savedlist-action-loop', [response, auction_id]);
				}
			});
		}
	</script>
<?php
	wp_die();
}



/* Closest to me filter popup */
add_action('wp_footer', 'uat_location_show_closest_to_me_filter_popup');
function uat_location_show_closest_to_me_filter_popup(){ 
	if(show_closest_to_me()){

		$ctos_car_closest_to_me_header_title = get_field('ctos_car_closest_to_me_header_title', 'option');
		$ctos_car_closest_to_me_header_title_show = true;
		if (empty($ctos_car_closest_to_me_header_title) ) {
			$ctos_car_closest_to_me_header_title = __("Cars closest to me", 'ultimate-auction-pro-software');
			$ctos_car_closest_to_me_header_title_show = false;
		}
		$ctos_car_closest_to_me_sub_title = get_field('ctos_car_closest_to_me_sub_title', 'option');
		$ctos_car_closest_to_me_sub_title_show = true;
		if (empty($ctos_car_closest_to_me_sub_title) ) {
			$ctos_car_closest_to_me_sub_title = __("We need your zip code to determine which cars are closest to you.", 'ultimate-auction-pro-software');
			$ctos_car_closest_to_me_sub_title_show = false;
		}
		$ctos_car_closest_to_me_distance_range = get_field('ctos_car_closest_to_me_distance_range', 'option');
		$ctos_car_closest_to_me_button_text = get_field('ctos_car_closest_to_me_button_text', 'option');
		if (empty($ctos_car_closest_to_me_button_text) ) {
			$ctos_car_closest_to_me_button_text = __("Save", 'ultimate-auction-pro-software');
		}
		$ctos_car_closest_to_me_button__reset_text = __("Reset", 'ultimate-auction-pro-software');
		?>
			<div style="display:none;" id="uat-closesToMebox" class="example6">
			<?php if($ctos_car_closest_to_me_header_title_show){ ?>
							<div class="popup-header"><?php echo $ctos_car_closest_to_me_header_title; ?></div>
						<?php } ?>
						<form method="post" class="search-zipcode-form" autocomplete="off" novalidate="">
							<?php  if($ctos_car_closest_to_me_sub_title_show){ ?>
								<p class="prompt"><?php echo $ctos_car_closest_to_me_sub_title; ?></p>
							<?php } ?>
							<div class="d-flex d-flex-row zipcode-form-m">
								<fieldset class="form-group ">
									<label for="zip_code"><?php echo __('Zip code', 'ultimate-auction-pro-software'); ?></label>
									<input name="zip_code" type="text" autocomplete="off" autocapitalize="off" autocorrect="off" spellcheck="false" id="zipCode" value="">
								</fieldset>
								<fieldset class="form-group max_distance">
								<label for="max_distance"><?php echo __('Max distance from you', 'ultimate-auction-pro-software'); ?></label>
								<select name="max_distance" id="radius">
									<?php	
										$ranges[] = array('100','150','200','500','1000'); 
										if (!empty($ctos_car_closest_to_me_distance_range) ) { 
											$custom_range = array();
											$ctos_car_closest_to_me_distance_range = explode(",",$ctos_car_closest_to_me_distance_range);
											foreach($ctos_car_closest_to_me_distance_range as $val){
												$val = (int)trim($val);
												if($val > 0){
													$custom_range[] = $val; 
												}
											}
											$ranges = $custom_range;
										}
										$ranges = array_unique($ranges);
										$mile_text = __('miles', 'ultimate-auction-pro-software');										
										for($i=0; $i<count($ranges); $i++){
											$selected = $i == 0?'selected="'.$ranges[$i].'"':"";
											echo "<option value='$ranges[$i]' $selected>$ranges[$i] $mile_text</option>";
										}
									?>
									<option value="0"><?php echo __('No limit', 'ultimate-auction-pro-software'); ?></option>
								</select>
								</fieldset>
							</div>
							<div class="d-flex d-flex-row pd-top-30">
								<div class="flex-column-50">
									<span style="display: none;" class="invalid_msg"><?php echo __('Please enter zip code', 'ultimate-auction-pro-software'); ?></span>
									<input class="submit_button" type="submit" id="saveClosestMe" value="<?php echo $ctos_car_closest_to_me_button_text; ?>">
									<input class="submit_button" type="submit" id="resetClosestMe"  value="<?php echo $ctos_car_closest_to_me_button__reset_text; ?>">
										
								</div>
								
								<!-- <div class="flex-column-50">
									<button type="button" class="location_link ">In Canada?</button>
								</div>					 -->
							</div>
							
						</form>
			</div>
			<a data-fancybox data-src="#uat-closesToMebox" class="closesToMebox" href="javascript:;"></a>

		<?php 
	}
}

/* Includer custom option for template */

require_once(get_stylesheet_directory() . '/include/admin/frotn-pages-options.php');
require_once(get_stylesheet_directory() . '/include/admin/search-page-options.php');


add_action('wp_ajax_nopriv_get_car_list_results_data', 'fun_get_car_list_results_data');
add_action('wp_ajax_get_car_list_results_data', 'fun_get_car_list_results_data');

function fun_get_car_list_results_data()
{
	$filters = isset($_POST['filters']) ? $_POST['filters'] : array();
	$sorting = isset($_POST['sorting']) ? $_POST['sorting'] : array();
	$perpage = $_REQUEST['perpage'];
	$show_expired = $_REQUEST['show_expired']??"no";
	$setpage = $_REQUEST['setpage'];
	$all_filters = $_REQUEST['all_filters'];
	$meta_query = [];
	$text_query = [];
	$valid_status = [];
	$valid_status[] = 'uat_live';
	$valid_status[] = 'uat_in_auction';
	$valid_status[] = 'publish';

	$args = array(
		'post_type' => 'product',
		'posts_per_page' =>  -1,
		'posts_per_page' =>  $perpage,
		'paged'         => $setpage,
		'post_status' => $valid_status,
		'tax_query' => array(
			array(
				'taxonomy' => 'product_type',
				'field' => 'slug',
				'terms' => 'auction',
			),
		),
	);


	if (isset($_REQUEST['sorting_key']) && !empty($_REQUEST['sorting_key'])) {
		$args['orderby'] = 'meta_value';
		$args['meta_key'] = $_REQUEST['sorting_key'];
		$args['order'] = $_REQUEST['sorting_order'];
	}

	$product_ids = [];
	$product_ids_test = [];

	$return_type = "query";

	if(!empty($filters) && !empty($all_filters))
	{
		foreach($filters as $f_name => $f_values)
		{
			if(!isset($all_filters[$f_name])){
				continue;
			}
			$filtered_ids = [];
			$one_filter = $all_filters[$f_name];
			$name = $one_filter['name'];
			$type = $one_filter['type'];
			$input_type = $one_filter['input_type'];
			$input_filter_type = $one_filter['input_filter_type'];
			$operator = $one_filter['operator'];
			$one_filter['return_type'] = $return_type;
			if($type == "term"){
				$one_filter['return_type'] = "";
				$one_filter['operator'] = 'IN';
				$filtered_ids = getProductsByTermIds($name, "term_id", $f_values, $product_ids, $one_filter);				
			}else{
				$operator = "REGEXP";
				if ($input_filter_type == 'range_slider' ) {
					$operator = "BETWEEN";
					$filtered_ids = getProductsByMeta($name, $operator, $f_values, $product_ids, $one_filter);
				}else{
					foreach($f_values as $value){
						$filtered_ids = getProductsByMeta($name, $operator, $value, $product_ids, $one_filter);
					}
				}
			}
			if(!empty($filtered_ids))
			{
				$return_type_ = $one_filter['return_type'];
				if($return_type_ == 'query'){
					if($type == "term"){
						$text_query[] = $filtered_ids;
					}else{
						$meta_query[] = $filtered_ids;
					}
				}else{
					$filtered_ids = array_unique($filtered_ids);
					$product_ids = array_merge( $product_ids, $filtered_ids );
					$product_ids = array_unique($product_ids);
				}
			}
			$product_ids_test[$name] = $filtered_ids;
		}
	}
	if($show_expired == 'no'){
		$meta_query[] = array(
			'key' => 'woo_ua_auction_closed',
			'compare' => 'NOT EXISTS',
		);
	}

	if(!empty($meta_query) && count($meta_query) > 0){
		if(count($meta_query) > 1){
			$meta_query['relation'] = 'AND';
		}
		$args['meta_query'] = $meta_query;
	}
	/*$text_query[] = array(
		'taxonomy' => 'product_type',
		'field' => 'slug',
		'terms' => 'auction'
	);*/
	
	if(!empty($text_query) && count($text_query) > 0){
		if(count($text_query) > 1){
			$text_query['relation'] = 'AND';
		}
		$args['text_query'] = $text_query;
	}
	if(!empty($product_ids) && count($product_ids) > 0){
		$product_ids = array_unique($product_ids);
		$args['post__in'] = $product_ids;
	}
	$query = new WP_Query($args);
	$have_posts = false;

	ob_start();
	$query_ = $query->request;
	$total_products = $query->found_posts;
	
	$count = $query->post_count;
	if ($query->have_posts()) {
		$have_posts = true; 
		while ($query->have_posts()) : $query->the_post();
			set_query_var('show_timer', 'on');
			wc_get_template_part('content', 'product');
		endwhile;
	} 
	if(!$have_posts && $setpage == 1) {  ?>
		<div class='no-result-found'>
			<?php echo __("Sorry, there are no results", 'ultimate-auction-theme'); ?>
		</div>
	<?php }
	// Restore original Post Data
	wp_reset_postdata();
	$html = ob_get_clean();
	$response['data'] = $html;
	$response['status'] = $have_posts;
	$response['count'] = $count;
	$response['total_products'] = $total_products;
	$response['have_posts'] = $have_posts;
	
	wp_send_json( $response );
}




function getProductsByTermIds($term = "car_models", $key = "term_id", $values = [], $product_ids = [], $filter_options = []){
	$product_ids_ = [];
	if(empty($filter_options)){
		return $product_ids_;
	}
	$return_type = "query";
	$operator = $filter_options['operator']??"IN";
	$return_type = $filter_options['return_type']??"query";

	$text_query = array();
	$text_query_sub = array(
							'taxonomy' => 'car_models',
							'field' => $key,
							'terms' => $values,
							'operator' => $operator
						);

	if($return_type == "query"){
		return $text_query_sub;
	}else{
		$text_query[] = $text_query_sub;
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'fields' => 'ids', // Set the query to only retrieve post IDs
			'tax_query' => $text_query,
		);
		if(!empty($product_ids) && count($product_ids) > 0){
			$args['post__in'] = array_unique($product_ids);
		}		
		$query = new WP_Query( $args );
		
		return $product_ids_ = $query->posts;
	}
}
function getProductsByMeta($key = "car_models", $oprator = "LIKE", $values = [], $product_ids = [], $filter_options = []){
	$product_ids_ = [];

	if(empty($filter_options)){
		return $product_ids_;
	}
	$field_key = $key;
	if(isset($filter_options['is_custom'])){
		if($filter_options['is_custom'] == 'yes'){
			$field_key = 'uat_custom_field_'.$field_key;
		}
	}
	$return_type = $filter_options['return_type']??"query";

	$meta_query = array();
	$meta_query_sub = array();

	$meta_query_sub = array(
							'key' => $field_key,
							'value' => $values,
							'compare' => $oprator
						);
	if($filter_options['input_filter_type'] == 'range_slider'){
		$meta_query_sub['type'] = 'numeric';
	}
	if($return_type == "query"){
		return $meta_query_sub;
	}else{
		$meta_query[] = array(
			'key' => 'woo_ua_auction_closed',
			'compare' => 'NOT EXISTS',
		);
		
		$meta_query[] = $meta_query_sub;	
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'fields' => 'ids', // Set the query to only retrieve post IDs
			'meta_query' => $meta_query,
		);
		$condition = $filter_options['condition'];
		if($condition == "AND"){
			if(!empty($product_ids) && count($product_ids) > 0){
				$args['post__in'] = array_unique($product_ids);
			}
		}
		$query = new WP_Query( $args );
		return $product_ids_ = $query->posts;
	}
}


// Add a date field to the General tab
add_action('woocommerce_product_options_general_product_data', 'add_custom_general_date_field');

function add_custom_general_date_field() {
    global $woocommerce, $post;
  
    echo '<div class="options_group">';
  
    woocommerce_wp_text_input(
        array(
            'id'          => 'uwa_custom_date_field',
            'label'       => __('Listed On', 'woocommerce'),
            'placeholder' => '',
            'desc_tip'    => 'false',
            'description' => __('Select auction listing date', 'woocommerce'),
            'type'        => 'date'
        )
    );
  
    echo '</div>';
}

// Save the date field value
add_action('woocommerce_process_product_meta', 'save_custom_general_date_field');

function save_custom_general_date_field($post_id) {
    $custom_date_field = isset($_POST['uwa_custom_date_field']) ? sanitize_text_field($_POST['uwa_custom_date_field']) : '';
    update_post_meta($post_id, 'uwa_custom_date_field', $custom_date_field);
}


function acf_car_model_taxonomy_result( $text, $term, $field, $post_id ) {
 if($term->parent != '0'){
	   $child_term_text="";
	   $child_term_text .= $term->name;   
 }
 return $child_term_text;
}
add_filter('acf/fields/taxonomy/result/key=cmf_model', 'acf_car_model_taxonomy_result', 10, 4);
add_filter('acf/fields/taxonomy/result/key=cmf_model_new', 'acf_car_model_taxonomy_result', 10, 4);


function acf_car_make_model_relation_taxonomy_result( $args, $field, $post_id ){

	$parent_id = false;

	if ( $field['key'] == 'cmf_make' ) { // Parent
		$parent_id = 0;
	} else if ( $field['key'] == 'cmf_model_new' && !empty( $_POST['parent'] ) ) { // Child
    	
		$parent_id = (int)$_POST['parent'];
    }
    if ( $parent_id !== false ) {
    	$args['parent'] = $parent_id;
    }
	$args['number'] = 1000;
    return $args;
}
add_filter('acf/fields/taxonomy/query/key=cmf_make', 'acf_car_make_model_relation_taxonomy_result',10,3); // Parent
add_filter('acf/fields/taxonomy/query/key=cmf_model_new', 'acf_car_make_model_relation_taxonomy_result',10,3); // Child
function acf_car_make_model_relation_taxonomy_result_script_footer() { 
?>
<script>
(function($){

	$(document).ready( function() {
		 if (typeof acf !== 'undefined') {		
		acf.add_filter('select2_ajax_data', function( data, args, $input, field, instance ){
			var parent_field_key = 'cmf_make'; // Parent Field
			var target_field_key = 'cmf_model_new'; // Child Field	
			
			
			if( data.field_key == target_field_key ){
				var field_selector = 'select[name="acf[' + parent_field_key + ']"]'; //the select field holding the values already chosen
				if( $(field_selector).val() != '' && $(field_selector).val() != null ){
					parent_id = $(field_selector).val();
				} else{
					parent_id = 0; //nothing chosen yet, offer only top-level terms
				}
				data.parent = parent_id;
			}
		  	return data;
		});
		};
	});
})(jQuery);
</script>
<?php } 
add_action('wp_footer', 'acf_car_make_model_relation_taxonomy_result_script_footer');
function acf_car_make_model_relation_taxonomy_result_admin( $args, $field, $post_id ){

	$parent_id = false;
	if ( $field['key'] == 'cmf_make' ) { // Parent
		$parent_id = 0;		
	} else if ( $field['key'] == 'cmf_model_new' && !empty( $_POST['parent'] ) ) { // Child    	
		$parent_id = (int)$_POST['parent'];
		}
    if ( $parent_id !== false ) {
    	$args['parent'] = $parent_id;
    }
	$args['number'] = 1000;	
    return $args;
}
add_filter('acf/fields/taxonomy/query/key=cmf_make', 'acf_car_make_model_relation_taxonomy_result_admin',10,3); // Parent
add_filter('acf/fields/taxonomy/query/key=cmf_model_new', 'acf_car_make_model_relation_taxonomy_result_admin',10,3); // Child
add_action('acf/input/admin_footer', 'acf_car_make_model_relation_taxonomy_result_script_admin_footer');
function acf_car_make_model_relation_taxonomy_result_script_admin_footer() { 
?>
<script>
(function($){

	$(document).ready( function() {
	
		acf.add_filter('select2_ajax_data', function( data, args, $input, field, instance ){

			var parent_field_key = 'cmf_make'; // Parent Field
			var target_field_key = 'cmf_model_new'; // Child Field
			if( data.field_key == target_field_key ){
				var field_selector = 'select[name="acf[' + parent_field_key + ']"]'; //the select field holding the values already chosen
				if( $(field_selector).val() != '' && $(field_selector).val() != null ){
					parent_id = $(field_selector).val();
				} else{
					parent_id = 0; //nothing chosen yet, offer only top-level terms
				}
				data.parent = parent_id;
			}
		  	return data;
		});
	});
})(jQuery);
</script>
<?php } 