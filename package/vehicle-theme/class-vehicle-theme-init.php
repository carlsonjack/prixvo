<?php

if (!defined('ABSPATH')) {
	exit;
}

/**
 *
 * Car theme Package Initialize
 *
 * @class  UAT_vehicle_theme_Init
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if (!class_exists('UAT_vehicle_theme_Init')) :
	class UAT_vehicle_theme_Init
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
       
            add_action('wp_enqueue_scripts', array($this, 'vehicle_theme_pages_style_scripts'));
            require_once(UAT_THEME_PRO_INC_DIR . 'package/vehicle-theme/acf/vehicle-custom-taxonomy-models.php');
			require_once(UAT_THEME_PRO_INC_DIR . 'package/vehicle-theme/acf/vehicle-default-fields-setting.php');
            require_once(UAT_THEME_PRO_INC_DIR . 'package/vehicle-theme/acf/vehicle-meta-fields.php');
            //require_once(UAT_THEME_PRO_INC_DIR . 'package/car-theme/acf/car-seller-from.php');
        }
        /* add all seller scripts used in saller dashboard */
		public function vehicle_theme_pages_style_scripts()
		{
			wp_register_style('uat-vehicle-theme-style', UAT_THEME_PRO_CSS_URI. 'vehicle-theme-style.css', array());
			wp_enqueue_style('uat-vehicle-theme-style');
		}

    } /* end of class */

UAT_vehicle_theme_Init::get_instance();
endif;