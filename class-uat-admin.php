<?php
/**
 *A CLASS Manage Wordpress Admin Area
 * @author     NItesh Singh
 * @package    Ultimate Auction Pro Software
 * @since      1.0.0
 */
// Do not allow directly accessing this file.
if (!defined('ABSPATH'))
{
    exit('Direct script access denied.');
}
/**
 *A CLASS Manage Wordpress Admin Area
 */
class Ultimate_Auction_PRO_Admin
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
        /* Admin Menu Page init */
        add_action('admin_menu', array( $this, 'ultimate_auction_pro_admin_main_menu' ));
        add_action('init', array( $this,  'ultimate_auction_pro_admin_include_files' ));
		add_filter('parent_file', array( $this,  'ultimate_auction_pro_select_submenu' ));
    }
	public function ultimate_auction_pro_select_submenu($file) {
        global $plugin_page;
        if ('ua-auctions-details' == $plugin_page) {
            $plugin_page = 'ua-auctions-theme-products-lots';
        }
		if ('uat_auctions_event_details' == $plugin_page) {
            $plugin_page = 'edit.php?post_type=uat_event';
        }
		
		
        return $file;
	}	
    /**
     * Add Page In Admin Menu.
     *
     */
     public function ultimate_auction_pro_admin_main_menu()
    {
        global $wp_version;
        if ($wp_version >= '3.8') $menu_icon = UAT_THEME_PRO_IMAGE_URI . 'uat_admin_menu_icon.png';
        else $menu_icon = UAT_THEME_PRO_IMAGE_URI . 'uat_admin_menu_icon_black.png';
		/* Main Theme Page*/
		add_menu_page(__('Auctions', 'ultimate-auction-pro-software') , __('Auctions', 'ultimate-auction-pro-software') , 'manage_options', 'ua-auctions-theme', array( $this, 'uat_auctions_dashboard_page_handler') , $menu_icon, 2);
			
		/* Event menu */
        $events_lists_page = 'edit.php?post_type=' . UAT_THEME_PRO_EVENT_POST_TYPE;
        add_submenu_page('ua-auctions-theme', __('Auction Events', 'ultimate-auction-pro-software') , __('Auction Events', 'ultimate-auction-pro-software') , 'manage_options', $events_lists_page, NULL);
		add_submenu_page('null', __('Event Details', 'ultimate-auction-pro-software') , __('Event Details', 'ultimate-auction-pro-software') , 'manage_options', 'uat_auctions_event_details', array($this,'uat_auctions_event_details_page_handler' ));
		/* Event Categories menu */		
        $event_cat_page = 'edit-tags.php?taxonomy=uat-event-cat&post_type=' . UAT_THEME_PRO_EVENT_POST_TYPE;
        add_submenu_page('ua-auctions-theme', __('Event Categories', 'ultimate-auction-pro-software') , __('Event Categories', 'ultimate-auction-pro-software') , 'manage_options', $event_cat_page, NULL);	
		/* Auction Product menu */
        add_submenu_page('ua-auctions-theme', __('Product/Lot', 'ultimate-auction-pro-software') , __('Product/Lot', 'ultimate-auction-pro-software') , 'manage_options', 'ua-auctions-theme-products-lots', array( $this, 'uat_auctions_products_lots_page_handler'  ));
		add_submenu_page('null', __('Product/Lot', 'ultimate-auction-pro-software') , __('Product/Lot', 'ultimate-auction-pro-software') , 'manage_options', 'ua-auctions-details', array($this,'ua_auctions_details_page_handler' ));
	 	/* Notification menu */
		add_submenu_page('ua-auctions-theme', __('Notification', 'ultimate-auction-pro-software'), __('Notification', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-emails', array($this, 'uat_auctions_email_page_handler'));
		
		/* Seller Module 
		add_submenu_page('ua-auctions-theme', __('Seller Product/Lot', 'ultimate-auction-pro-software') , __('Seller Product/Lot', 'ultimate-auction-pro-software') , 'manage_options', 'ua-seller-auctions', array($this,'uat_seller_auctions_page_handler' ));*/
		
		add_submenu_page('ua-auctions-theme', __('Questions & Answers', 'ultimate-auction-pro-software'), __('Questions & Answers', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-qa', 'qa_list_callback');
		/* Logs menu */		
		 add_submenu_page('ua-auctions-theme', __('Logs', 'ultimate-auction-pro-software'), __('Logs', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-reports', array($this, 'uat_auctions_reports_page_handler'));
		 /* Auction Products Import menu */
		add_submenu_page('ua-auctions-theme', __('Auction Products Import', 'ultimate-auction-pro-software'), __('Import Auctions', 'ultimate-auction-pro-software'), 
			'manage_options', 'ua_auctions_products_import', array($this, 'uat_auction_products_import_page_handler'));
		/* Support menu */	
		add_submenu_page('ua-auctions-theme', __('Support', 'ultimate-auction-pro-software') , __('Support', 'ultimate-auction-pro-software') , 'manage_options', 'ua-auctions-help', array($this,    'uat_auctions_help_page_handler' ));
		add_submenu_page('null', __('Activity Details', 'ultimate-auction-pro-software') , __('Activity Details', 'ultimate-auction-pro-software') , 'manage_options', 'uat-auctions-activity-details', array($this,'uat_auctions_activity_details_page_handler' ));
		add_submenu_page('ua-auctions-theme', __('Theme Status', 'ultimate-auction-pro-software'), __('Theme Status', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-theme-status', array($this, 'uat_auctions_theme_status_page_handler'));
		/* Custom Fields*/
		add_submenu_page('ua-auctions-theme', __('Custom Fields', 'ultimate-auction-pro-software'), __('Custom Fields', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-theme-custom-fields', array($this, 'uat_auctions_theme_custom_fields_page_handler'));
    }
	public function uat_auctions_dashboard_page_handler() {
    }
	public function uat_auction_products_import_page_handler() {		
	    include_once( UAT_THEME_PRO_ADMIN . 'import/uat_auction_products_import_page.php');			   
	}
	public function uat_auctions_products_lots_page_handler() {
        include_once (UAT_THEME_PRO_ADMIN . 'auctions-products/class-auctions-products-list.php');
		uat_manage_auctions_list_page_handler_display();
    }
	public function ua_auctions_details_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'auctions-products/auctions-products-details.php');
    }
	
	public function uat_auctions_theme_custom_fields_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'custom-fields/custom-fields-setting.php');
    }
	public function uat_auctions_theme_status_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'theme_status/uat_theme_status_setting.php');
    }
	 public function uat_auctions_email_page_handler()
    {
        //include_once (UAT_THEME_PRO_ADMIN . 'emails/uat-email-setting.php');
        include_once (UAT_THEME_PRO_ADMIN . 'notifications/notification.php');
    }
    
    /*public function uat_seller_auctions_page_handler()
    {
		include_once (UAT_THEME_PRO_INC_DIR . 'seller/admin/uat-seller-auctions.php');
    }*/

    public function uat_auctions_help_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'pages/uat-auctions-help.php');
    }
	public function uat_auctions_event_details_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'events/uat-event-details.php');
    }
	public function uat_auctions_reports_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'activity/uat_auctions_reports.php');
    }
	public function uat_auctions_activity_details_page_handler()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'activity/uat-activity-details.php');
    }
    public function ultimate_auction_pro_admin_include_files()
    {
        include_once (UAT_THEME_PRO_ADMIN . 'class-uat-auctions-scripts.php');
    }
} /* end of class */
Ultimate_Auction_PRO_Admin::get_instance();