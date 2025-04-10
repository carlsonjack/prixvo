<?php
/*
* Ultimate_Auction_Pro_ACF class
*
* This class initiate general purpose custom fields.
*/
if (!defined('ABSPATH'))
{
    die('Access denied.');
}
if (!class_exists('Ultimate_Auction_Pro_ACF')):
    class Ultimate_Auction_Pro_ACF
    {
        /**
         * Ultimate_Auction_Pro_ACF constructor.
         */
        public function __construct()
        {
			$this->add_uat_theme_options_fields();
            $this->add_auction_event_fields(); 
			$this->add_uat_pages_fields();	
			$this->add_auction_event_locations_fields();
			$this->add_auction_products_locations_fields();
			$this->add_event_list_pages_template_fields();
			$this->add_auction_list_pages_template_fields();
			$this->add_event_categories_pages_template_fields();
			$this->add_woo_default_category_fields();
			$this->add_event_category_fields();
			$uat_custom_enable = get_option('uat_custom_enable','no');
			if($uat_custom_enable==="yes"){
				$this->add_custom_fields_for_auction_products_fields();
			}
        }
        /* 
		* add_auction_event_fields 
		*    
		* Setup Auction Event fields  
		*/
        private function add_auction_event_fields(){
            if (!function_exists('acf_add_local_field_group'))
            {
                return;
            }			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/events-fields.php');
        }
		private function add_event_list_pages_template_fields(){
            if (!function_exists('acf_add_local_field_group'))
            {
                return;
            }			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/event_list_pages_template.php');
        }
		private function add_auction_list_pages_template_fields(){
            if (!function_exists('acf_add_local_field_group'))
            {
                return;
            }			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/auction_list_pages_template.php');
        }
		private function add_event_categories_pages_template_fields(){
            if (!function_exists('acf_add_local_field_group'))
            {
                return;
            }			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/event_categories_pages_template.php');
        }
		private function add_uat_pages_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/flexible-content-fields.php');	
		}
		private function add_uat_theme_options_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/theme-options.php');	
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/reset-functions.php');	

		}
		private function add_auction_event_locations_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/events-locations.php');				
		}
		private function add_auction_products_locations_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/products-locations.php');				
		}
		
		private function add_woo_default_category_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/woo-default-category.php');				
		}
		private function add_event_category_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/event-category.php');				
		}		
		
		private function add_custom_fields_for_auction_products_fields() {        
			if (!function_exists('acf_add_local_field_group'))
			{
				return;
			}			
			include_once (UAT_THEME_PRO_ADMIN . 'acf-fields/auction_custom_fields.php');				
		}
    }
endif;