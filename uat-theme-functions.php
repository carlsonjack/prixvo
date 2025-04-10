<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Ultimate_Auction
 */

if ( ! function_exists( 'uat_theme_posted_on' ) ) :
function uat_theme_posted_on() {
	//printf( '<span class="entry-date">%1$s</span>', );
	printf( '<span class="entry-date">' . esc_html__( 'Posted on %1$s', 'ultimate-auction-pro-software' ) . '</span>', esc_html(get_the_date()) );
	
	
}
endif;

function uat_theme_categorized_blog() {
	// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'ultimate-auction-pro-software' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'ultimate-auction-pro-software' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'ultimate-auction-pro-software' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'ultimate-auction-pro-software' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}
}


if ( ! function_exists( 'ultimate_auction_theme_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function ultimate_auction_theme_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'ultimate-auction-pro-software' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'ultimate_auction_theme_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function ultimate_auction_theme_entry_footer() {
		

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'ultimate-auction-pro-software' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'ultimate-auction-pro-software' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'ultimate_auction_theme_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function ultimate_auction_theme_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( array(300, 158), array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;


add_action('acf/init', 'uat_acf_op_init');
function uat_acf_op_init() {
	/* Get Active theme slug */
	$active_theme_slug = get_stylesheet();
	
	// Check function exists.
    if( function_exists('acf_add_options_sub_page') ) {

        acf_add_options_sub_page(array(
		'page_title' 	=> ' Ultimate Auction Pro Software',
		'menu_title'	=> 'Theme settings',
		'menu_slug' 	=> 'ua-auctions-theme-options',
		'capability'	=> 'edit_posts',
		'parent_slug'	=> 'ua-auctions-theme',
		'redirect'		=> false,
		'icon_url' => 'dashicons-admin-customizer',
        'update_button' => 'Update Options',
        'updated_message' => 'Theme settings successfully updated.',
		'position' => '6',
		'autoload' => true,
	));
	
	
	if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {

		// Default acf feield hide show for car theme */
		acf_add_options_page(array(
			'page_title'    => 'Vehicle Fields For Auction Products <span class="span-dec">Manage vehicle details efficiently by easily enabling or disabling specific fields directly from here.</span>',
			'menu_slug'     => 'acf-options-default-fields',
			'menu_title'    => 'Default Fields',
			'update_button' => 'Update',
			
		));
		include_once(UAT_THEME_PRO_ADMIN . 'custom-fields/default-custom-fields-list.php');

	}


	

	
	
	 /*acf_add_options_sub_page(array(
		'page_title' 	=> 'Q&A',
		'menu_title'	=> 'Q&A',
		'menu_slug' 	=> 'ua-auctions-question-answer-options',
		'capability'	=> 'edit_posts',
		'parent_slug'	=> 'ua-auctions-theme',
		'redirect'		=> false,
		'icon_url' => 'dashicons-admin-customizer',
        'update_button' => 'Update Options',
        'updated_message' => 'Q&A Successfully updated.',
		'position' => '6',
		'autoload' => true,
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Settings',
		'menu_title'	=> 'Settings',
		'menu_slug' 	=> 'ua-auctions-question-answer-options_settings',
		'capability'	=> 'edit_posts',
		'parent_slug'	=> 'ua-auctions-question-answer-options',
		'redirect'		=> true,
		'icon_url' => 'dashicons-admin-customizer',
        'update_button' => 'Update Options',
        'updated_message' => 'Q&A Successfully updated.',
		 
		'autoload' => true,
	));
	*/
	
	
	
	
	
    }
}

/* ACF google map Feild Key*/
add_filter('acf/fields/google_map/api', 'uat_acf_google_map_api');


function uat_acf_google_map_api( $api ){
	$key = get_option('options_uat_google_maps_api_key');	
    $api['key'] = $key;    
    return $api;
}


if (!function_exists('gatewayIsReady')) {
	/**
	 * Return Expired auctions ids
	 *
	 */
	function gatewayIsReady()
	{
		
		$gatewayIsReady = false;
		try {
			$gateway = '';
			$gateway = get_option( 'options_uat_payment_gateway', 'stripe' );
			
			if($gateway == 'stripe')
			{
				$stripe_mode = get_option('options_uat_stripe_mode_types' ,  'uat_stripe_test_mode');
				if ($stripe_mode == 'uat_stripe_live_mode') {
					$stripe_publishable_key = get_option('options_uat_stripe_live_publishable_key', '');
					$stripe_secret_key = get_option('options_uat_stripe_live_secret_key', '');
				} else {
					$stripe_publishable_key = get_option('options_stripe_test_publishable_key', '');
					$stripe_secret_key = get_option('options_uat_stripe_test_secret_key', '');
				}
				if(!empty($stripe_publishable_key) && !empty($stripe_secret_key))
				{
					$gatewayIsReady = true;
				}
			}
	
			if($gateway == 'braintree')
			{
				$StripePaymentModeTypes = get_option( 'options_uat_braintree_mode_types' , 'uat_braintree_test_mode' );
				if($StripePaymentModeTypes=='uat_braintree_live_mode'){
					$braintree_merchantId = get_option( 'options_uat_braintree_live_merchant_id', "" );
					$braintree_merchantAcountId = get_option( 'options_uat_braintree_live_merchant_account_id', "" );
					$braintree_publicKey = get_option( 'options_uat_braintree_live_public_key', "" );
					$braintree_privateKey = get_option( 'options_uat_braintree_live_private_key', "" );
				}else{
					$braintree_merchantId = get_option( 'options_uat_braintree_test_merchant_id', "" );
					$braintree_merchantAcountId = get_option( 'options_uat_braintree_test_merchant_account_id', "" );
					$braintree_publicKey = get_option( 'options_uat_braintree_test_public_key', "" );
					$braintree_privateKey = get_option( 'options_uat_braintree_test_private_key', "" );
				}
                if (!empty($braintree_merchantId) && !empty($braintree_publicKey) && !empty($braintree_privateKey) && !empty($braintree_merchantAcountId)) {
                    $gatewayIsReady = true;
                }
			}
		} catch (\Throwable $th) {
			
		}
		return $gatewayIsReady;
	}
}


if (!function_exists('uat_get_live_auctions_with_payment_ids')) {
	/**
	 * Return Expired auctions ids
	 *
	 */
	function uat_get_live_auctions_with_payment_ids()
	{
		global $wpdb;
		$live_auctions_ids = array();
		$table = UA_AUCTION_PRODUCT_TABLE;
		$where = "WHERE post_status='publish' AND auction_status = 'uat_live'";
		$query   = "SELECT post_id FROM $table $where ORDER by auction_id DESC";
		$results = $wpdb->get_results($query);
		foreach ($results as $row) {
			$hold_debit = "no";
			$uat_event_id = get_post_meta( $row->post_id, 'uat_event_id', true );
			if (!empty($uat_event_id)) {
				$hold_debit = get_post_meta($uat_event_id, 'uat_event_auto_debit_hold_enable', true);
			}else{
				$hold_debit = get_post_meta($row->post_id, 'sp_automatically_debit', true);
			}
			if ($hold_debit == "yes") {
				$live_auctions_ids[] =  $row->post_id;
			}
		}
		return $live_auctions_ids;
	}
}

function uat_check_gatway_change_ajax_callback_()
{
	$ids = uat_get_live_auctions_with_payment_ids();
	$enable_gateway = "false";
	if(count($ids) > 0)
	{
		$enable_gateway = "true";
	}
	return $enable_gateway;
}