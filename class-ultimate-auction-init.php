<?php
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package Ultimate Auction Pro Software
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
{
    exit('Direct script access denied.');
}
/**
 *A class Manage Theme main Functions file.
 */
class Ultimate_Auction_Pro_Init
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
        if (null === self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function __construct()
    {
       
        add_action('after_setup_theme', array( $this,'ultimate_auction_pro_setup') );  
        add_action('admin_footer_text', array( $this, 'ultimate_auction_pro_branding_footer' ) );
        add_action('wp_head', array( $this,  'ultimate_auction_pro_pingback_header' ) );
        add_action('widgets_init', array( $this, 'ultimate_auction_pro_widgets_init') );
        add_action('the_generator', array( $this, 'wp_remove_version' ));
		add_action( 'after_setup_theme', array( $this, 'register_image_sizes' ) );
    }    
    /**
     * Theme Setup
     *
     */
    public function ultimate_auction_pro_setup()
    {
        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         * If you're building a theme based on owr_theme, use a find and replace
         * to change 'owr' to the name of your theme in all the template files
         *Theme lang.
         */
        add_theme_support('title-tag');
        $header_defaults = array(
            'default-image' => '',
            'width' => 0,
            'height' => 0,
            'flex-height' => false,
            'flex-width' => false,
            'uploads' => true,
            'random-default' => false,
            'header-text' => true,
            'default-text-color' => '',
            'wp-head-callback' => '',
            'admin-head-callback' => '',
            'admin-preview-callback' => '',
        );
        add_theme_support('custom-header', $header_defaults);
        $defaults = array(
            'default-color' => '',
            'default-image' => '',
            'default-repeat' => 'repeat',
            'default-position-x' => 'left',
            'default-position-y' => 'top',
            'default-size' => 'auto',
            'default-attachment' => 'scroll',
            'wp-head-callback' => '_custom_background_cb',
            'admin-head-callback' => '',
            'admin-preview-callback' => ''
        );
        //add_theme_support('custom-background', $defaults);
        add_editor_style('style-editor.css');
       // comment_form(array('logged_in_as' => null,'title_reply' => null,));
        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus([		            
		            'primary' => __('Primary Menu', 'ultimate-auction-pro-software'),
					'secondary' => __('Secondary Menu', 'ultimate-auction-pro-software'),
                    'footer-menu' => __('Footer Disclaimer Menu ', 'ultimate-auction-pro-software'),
					
		]);
        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support('automatic-feed-links');
		add_theme_support('woocommerce');
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
				/**
         * Enable support for Post Thumbnails on posts and pages
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');
        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption', ]);

        /* Add To cart item */
		add_action('wp_loaded', array($this,'uwa_add_product_to_cart'));	
        
         /* Get Active theme slug */
        $active_theme_slug = get_stylesheet();
       
        if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {

        require_once(UAT_THEME_PRO_INC_DIR . 'package/vehicle-theme/class-vehicle-theme-init.php');
            UAT_vehicle_theme_Init::get_instance();
        }
       

	}
    /**
	 *  Auction Product  Add to Cart After Pay Now Button Click.	 
	 *
	 */	
	public function uwa_add_product_to_cart() {
        if (!is_admin()) {
            
            if (!empty($_GET['pay-uwa-auction'])) {
                

				$current_user = wp_get_current_user();
				
				//$product_ids = explode( ',', intval($_GET['pay-uwa-auction']));
				$product_ids = explode( ',', $_GET['pay-uwa-auction']);
                $count       = count( $product_ids );
				
				
				if ($count < 0) {
					wp_redirect(home_url());
					exit;
				}

				if (!is_user_logged_in()) {

					/*header('Location: ' . wp_login_url(WC()->cart->get_checkout_url() . '?pay-uwa-auction=' . 
						$_GET['pay-uwa-auction'])); */

						$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
						if($myaccount_page_id > 0){
							$myaccount_page_url = get_permalink( $myaccount_page_id );
							
							$checkout_url = add_query_arg(array( 'pay-uwa-auction' => $_GET['pay-uwa-auction']  ), wc_get_checkout_url()); 
							
							$url_val = add_query_arg(
								array('uwa-new-redirect' => urlencode($checkout_url)),  $myaccount_page_url);
						}
						else{
							$url_val = wp_login_url(wc_get_checkout_url() . '?pay-uwa-auction=' . 
										$_GET['pay-uwa-auction']);
						}						
					
						header('Location: ' . $url_val);
						exit;
				}
				
				foreach ( $product_ids as $product_id ) {
					
				   $product_data = wc_get_product($product_id);
				   
					if ($current_user->ID == $product_data->get_uwa_auction_current_bider()) {
						WC()->cart->add_to_cart($product_id);
					
				  	} else {
					  wc_add_notice(sprintf(__('You can not buy this "%s" auction because you have not won it!', 'ultimate-auction-pro-software'), $product_data->get_title()), 'error');
				  	}			   
				
				}				
				wp_safe_redirect(remove_query_arg(array('pay-uwa-auction', 'quantity', 'product_id'),wc_get_checkout_url()));
				exit;
			}
		}
	}
    //  WP admin footer branding.
    public function ultimate_auction_pro_branding_footer($default_text)
    {
        return '<span id="ultimate_auction_pro_branding">Website managed by <a href="#" target="_blank">Ultimate Auction Pro Software</a><span> | Powered by <a href="http://www.wordpress.org" target="_blank">WordPress</a>';
    }
    /**
     * Add a pingback url auto-discovery header for singularly identifiable articles.
     */
    public function ultimate_auction_pro_pingback_header()
    {
        if (is_singular() && pings_open())
        {
            printf('<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo('pingback_url')));
        }
    }
    /**
     * Set the content width in pixels, based on the theme's design and stylesheet.
     * @global int $content_width
     */
    public function ultimate_auction_pro_content_width()
    {
        $GLOBALS['content_width'] = apply_filters('uat_theme_pro_content_width', 640);
    }
    /**
     * Register widget area.
     * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
     */
    public function ultimate_auction_pro_widgets_init()
    {
        register_sidebar(array(
            'name' => __('Sidebar', 'ultimate-auction-pro-software') ,
            'id' => 'uat-theme-sidebar',
            'description' => __('Main Sidebar', 'ultimate-auction-pro-software') ,
            'before_widget' => '<div id="%1$s" class="row sidebar-widget %2$s"><div class="widget">',
            'after_widget' => '</div></div>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
        register_sidebar(array(
            'name' => __('WooCommerce Sidebar', 'ultimate-auction-pro-software') ,
            'id' => 'uat-theme-woocommerce',
            'description' => __('WooCommerce Sidebar', 'ultimate-auction-pro-software') ,
            'before_widget' => '<div id="%1$s" class="row sidebar-widget %2$s"><div class="widget">',
            'after_widget' => '</div></div>',
           'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
		
		register_sidebar(array(
            'name' => __('Event List Sidebar', 'ultimate-auction-pro-software') ,
            'id' => 'uat-theme-eventlist',
            'description' => __('Event List Sidebar', 'ultimate-auction-pro-software') ,
            'before_widget' => '<div id="%1$s" class="row sidebar-widget %2$s"><div class="widget">',
            'after_widget' => '</div></div>',
           'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        ));
		
        //Footer widget areas
        $uat_theme_option = get_option('options_uat_footer_columns_no');
        $widget_areas = !empty($uat_theme_option) ? $uat_theme_option : '4';
        for ($i = 1;$i <= $widget_areas;$i++)
        {
            register_sidebar(array(
                'name' => __('Footer Column ', 'ultimate-auction-pro-software') . $i,
                'id' => 'uat-theme-footer-sidebar-' . $i,
                'description' => '',
                'before_widget' => '<aside id="%1$s" class="widget %2$s">',
                'after_widget' => '</aside>',
                'before_title' => '<h3 class="column-heading">',
                'after_title' => '</h3>',
            ));
        }
    }
    /* Removing version history of WP for security alert */
    public function wp_remove_version()
    {
        return '';
    }
	public function register_image_sizes() {
		
		add_image_size( 'uat-home-blog-small', 327, 209, true ); //(cropped)
		add_image_size( 'uat-featured-categories', 382, 197, true ); //(cropped)		
		add_image_size( 'event-widget-thumb', 100, 100, true ); //(cropped)		
		//new Design Cropped
		add_image_size( 'events-fw-list-thumbnails', 440, 440, true ); //(cropped)
		add_image_size( 'event-detail-banner', 1920, 360, true ); //(cropped)
		add_image_size( 'events-detail-list-thumbnails', 438, 438, true ); //(cropped)		
		add_image_size( 'product-slider-thumb', 70, 70, true ); //(cropped)
		add_image_size( 'product-slider-big', 690, 690, true ); //(cropped)
		add_image_size( 'product-related', 438, 438, true ); //(cropped)		
		add_image_size( 'product-single-one', 690, 690, true ); //(cropped)
		add_image_size( 'blog-detail', 1200, 630, true ); //(cropped)
	}
	
} /* end of class */
Ultimate_Auction_Pro_Init::get_instance();