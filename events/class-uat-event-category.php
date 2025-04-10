<?php
/**
 *A calss Manage custom Post type Admin Area
 *
 * @author     NItesh Singh
 * @package    Ultimate Auction Pro Software
 * @since      1.0.0
 */
// Do not allow directly accessing this file.
if (!defined('ABSPATH')) {
	exit('Direct script access denied.');
}
/**
 *A calss Manage Wordpress Admin Area
 */
class Ultimate_Auction_PRO_Events_Categories
{
	private static $instance;
	/**
	 * Returns the *Singleton* instance of this class.
	 *
	 * @return Singleton The *Singleton* instance.
	 *
	 */
	public static function get_instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function __construct()
	{
		/* Admin Menu Page init */

		add_action('init', array($this, 'ultimate_auction_pro_register_category_for_event_post'), 0);
		add_action('manage_edit-uat-event-cat_columns', array($this, 'custom_uat_event_cat_add_columns'), 10, 3);
		add_action('manage_uat-event-cat_custom_column', array($this, 'custom_uat_event_cat_column_content'), 10, 3);
	}

	/**	
	 *  Register Events Categories Taxonomy
	 *
	 */
	public function ultimate_auction_pro_register_category_for_event_post()
	{

		$labels = array(
			'name'                       => _x('Event Category', 'Taxonomy General Name', 'ultimate-auction-pro-software'),
			'singular_name'              => _x('Event Categories', 'Taxonomy Singular Name', 'ultimate-auction-pro-software'),
			'menu_name'                  => __('Categories', 'ultimate-auction-pro-software'),
			'all_items'                  => __('All Categories', 'ultimate-auction-pro-software'),
			'parent_item'                => __('Parent Category', 'ultimate-auction-pro-software'),
			'parent_item_colon'          => __('Parent Category:', 'ultimate-auction-pro-software'),
			'new_item_name'              => __('New Category', 'ultimate-auction-pro-software'),
			'add_new_item'               => __('Add New Category', 'ultimate-auction-pro-software'),
			'edit_item'                  => __('Edit Category', 'ultimate-auction-pro-software'),
			'update_item'                => __('Update Category', 'ultimate-auction-pro-software'),
			'view_item'                  => __('View Category', 'ultimate-auction-pro-software'),
			'separate_items_with_commas' => __('Separate Categories with commas', 'ultimate-auction-pro-software'),
			'add_or_remove_items'        => __('Add or remove items', 'ultimate-auction-pro-software'),
			'choose_from_most_used'      => __('Choose from the most used', 'ultimate-auction-pro-software'),
			'popular_items'              => __('Popular Items', 'ultimate-auction-pro-software'),
			'search_items'               => __('Search Categories', 'ultimate-auction-pro-software'),
			'not_found'                  => __('Not Found', 'ultimate-auction-pro-software'),
			'no_terms'                   => __('No Category', 'ultimate-auction-pro-software'),
			'items_list'                 => __('Categories list', 'ultimate-auction-pro-software'),
			'items_list_navigation'      => __('Categories list navigation', 'ultimate-auction-pro-software'),
		);
		$rewrite = array(
			'slug'                       => 'events-category',
			'with_front'                 => true,
			'hierarchical'               => true,
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => $rewrite,
		);
		register_taxonomy('uat-event-cat', array(UAT_THEME_PRO_EVENT_POST_TYPE), $args);
	}


	// Add ACF field value (image thumbnail) to uat-event-cat list table
	public function custom_uat_event_cat_column_content($deprecated, $column_name, $term_id)
	{
		if ($column_name === 'event_categorie_image') {
			// Replace 'event_categorie_image' with the actual name/slug of your ACF field
			$image = get_field('event_categorie_image', 'uat-event-cat_' . $term_id);
			// Display the image thumbnail
			$image_url = wc_placeholder_img_src();
			$image_alt = "";
			if ($image) {
				$image_url = $image['sizes']['thumbnail'];
				$image_alt = $image['alt'];
			}
			echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($image_alt) . '" width="50" height="50" />';
		}
	}


	// Add custom column to uat-event-cat list table
	public function custom_uat_event_cat_add_columns($columns)
	{
		// Create an array to hold the modified column order
		$new_columns = array();

		// Add the checkbox column to the beginning of the columns array
		$new_columns['cb'] = '<input type="checkbox" />';
	
		// Add a new column for the ACF field image thumbnail after the checkbox column
		$new_columns['event_categorie_image'] = 'Image';
	
		// Merge the new columns with the existing columns
		$columns = $new_columns + $columns;
	
		return $columns;
	}
} /* end of class */
Ultimate_Auction_PRO_Events_Categories::get_instance();