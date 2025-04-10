<?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
	'key' => 'group_62fa459713396',
	'title' => 'Models',
	'fields' => array(
		array(
			'key' => 'car_models',
			'label' => __("Vehicle Models", 'ultimate-auction-pro-software'),
			'name' => 'car_models',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => '',
			'sub_fields' => array(
				array(
					'key' => 'cmf_car_model',
					'label' => __("Model", 'ultimate-auction-pro-software'),
					'name' => 'cmf_car_model',
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
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
					'maxlength' => '',
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-models',
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
endif;		
function acf_load_selectnm_field_choices( $field ) {
 $field['choices'] = array();
  $choices = [];
 $taxonomies = get_terms( array(
    'taxonomy' => 'car_models',
    'hide_empty' => false
) );
if ( !empty($taxonomies) ) :
    foreach( $taxonomies as $category ) {
        if( $category->parent == 0 ) {
		    $choices[ $category->name ] = [];
            foreach( $taxonomies as $subcategory ) {
                if($subcategory->parent == $category->term_id) {
					$choice= $subcategory->name;
					 $choices[ $choice ] = $choice;
                }
            }
        }
    }
	$field['choices'] = $choices;
endif;
return $field; 
}
//add_filter('acf/load_field/name=cmf_model', 'acf_load_selectnm_field_choices');


function acf_load_selectnm_field_choices_cmf_make( $field ) {
 $field['choices'] = array();
  $choices = [];
 $taxonomies = get_terms( array(
    'taxonomy' => 'car_models',
    'hide_empty' => false
) );
if ( !empty($taxonomies) ) :
    foreach( $taxonomies as $category ) {
        if( $category->parent == 0 ) {
		    $choices[ $category->name ] = [];
            foreach( $taxonomies as $subcategory ) {
                if($subcategory->parent == $category->term_id) {
					$choice= $subcategory->name;
					 $choices[ $choice ] = $choice;
                }
            }
        }
    }
	$field['choices'] = $choices;
endif;
return $field; 
}
//add_filter('acf/load_field/name=cmf_make', 'acf_load_selectnm_field_choices_cmf_make');


if ( ! function_exists( 'car_custom_taxonomy' ) ) {
/* Register Custom Taxonomy*/
function car_custom_taxonomy() {
	$labels = array(
		'name'                       => _x( 'Vehicle models', 'Taxonomy General Name', 'ultimate-auction-pro-software' ),
		'singular_name'              => _x( 'Vehicle model', 'Taxonomy Singular Name', 'ultimate-auction-pro-software' ),
		'menu_name'                  => __( 'Vehicle models', 'ultimate-auction-pro-software' ),
		'all_items'                  => __( 'All Items', 'ultimate-auction-pro-software' ),
		'parent_item'                => __( 'Parent Item', 'ultimate-auction-pro-software' ),
		'parent_item_colon'          => __( 'Parent Item:', 'ultimate-auction-pro-software' ),
		'new_item_name'              => __( 'New Item Name', 'ultimate-auction-pro-software' ),
		'add_new_item'               => __( 'Add New Item', 'ultimate-auction-pro-software' ),
		'edit_item'                  => __( 'Edit Item', 'ultimate-auction-pro-software' ),
		'update_item'                => __( 'Update Item', 'ultimate-auction-pro-software' ),
		'view_item'                  => __( 'View Item', 'ultimate-auction-pro-software' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'ultimate-auction-pro-software' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'ultimate-auction-pro-software' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'ultimate-auction-pro-software' ),
		'popular_items'              => __( 'Popular Items', 'ultimate-auction-pro-software' ),
		'search_items'               => __( 'Search Items', 'ultimate-auction-pro-software' ),
		'not_found'                  => __( 'Not Found', 'ultimate-auction-pro-software' ),
		'no_terms'                   => __( 'No items', 'ultimate-auction-pro-software' ),
		'items_list'                 => __( 'Items list', 'ultimate-auction-pro-software' ),
		'items_list_navigation'      => __( 'Items list navigation', 'ultimate-auction-pro-software' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'car_models', array( 'product' ), $args );
}
add_action( 'init', 'car_custom_taxonomy',0 );
}

// AJAX handler to get vehicle models based on selected make
//add_action('wp_ajax_get_car_models', 'get_vehicle_models_callback');
//add_action('wp_ajax_nopriv_get_car_models', 'get_vehicle_models_callback');

function get_vehicle_models_callback() {
    $make_id = isset($_GET['make_id']) ? intval($_GET['make_id']) : 0;
	$cmf_post_id = isset($_GET['cmf_post_id']) ? intval($_GET['cmf_post_id']) : "";
	$selected_term_id = get_post_meta($cmf_post_id, 'cmf_model', true);
    // Your custom logic to get models based on the selected make
    $models = get_terms(array('taxonomy' => 'car_models', 'hide_empty' => false, 'parent' => $make_id));

    if ($models && !is_wp_error($models)) {
        $output = '<option value="">Select Car Model</option>';
		
        foreach ($models as $model) {
			$selected = ($model->term_id == $selected_term_id) ? 'selected="selected"' : '';
          	$output .=  '<option value="' . $model->term_id . '" ' . $selected . '>' . $model->name . '</option>';
        }
        echo $output;
    } else {
        echo '<option value="">No car models found</option>';
    }

    wp_die();
}

/* GET youtibe video ID */ 

/*function getYoutubeVideoId($url) {
    $startPosition = strpos($url, "/embed/") + 7; // Find the starting position of the video ID
    $endPosition = strpos($url, "?"); // Find the ending position of the video ID

    if ($endPosition === false) {
        $videoId = substr($url, $startPosition); // Extract the video ID from the URL
    } else {
        $videoId = substr($url, $startPosition, $endPosition - $startPosition); // Extract the video ID from the URL
    }

    return $videoId;
}*/

function getYoutubeVideoId($url) {
    $parsedUrl = parse_url($url);

    if (isset($parsedUrl['query'])) {
        parse_str($parsedUrl['query'], $query);

        if (isset($query['v'])) {
            return $query['v'];
        }
    }

    // Check for short YouTube URL format (youtu.be)
    if (isset($parsedUrl['path'])) {
        $pathSegments = explode('/', trim($parsedUrl['path'], '/'));

        if (in_array('youtu.be', $pathSegments) && isset($pathSegments[1])) {
            return $pathSegments[1];
        }
    }

    return null;
}