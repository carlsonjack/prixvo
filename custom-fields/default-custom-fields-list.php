<?php 
// Add custom HTML to the ACF options page
function my_custom_acf_options_page_html($field) {
    global $hook_suffix;
    
    if ($hook_suffix === 'toplevel_page_acf-options-default-fields') { ?>
       
        <div class="wrap welcome-wrap uat-admin-wrap">
        <div class="uat_theme_page_nav">
        <?php echo uat_admin_side_top_menu();  ?>
            <h2 class="nav-tab-wrapper">
                <?php
                $uat_default_tab = array(
                    array('range' => 'general', 'slug' => 'ua-auctions-theme-custom-fields', 'label' => __('General Setting', 'ultimate-auction-pro-software')),
                    array('range' => 'default-fields', 'slug' => 'ua-auctions-theme-default-fields-list', 'label' => __('Vehicle Fields', 'ultimate-auction-pro-software')),
                    array('range' => 'fields', 'slug' => 'ua-auctions-theme-custom-fields-list', 'label' => __('Custom Fields', 'ultimate-auction-pro-software')),
                );
                $active_tab = isset($_GET['uat-custom-tab']) ? $_GET['uat-custom-tab'] : 'ua-auctions-theme-custom-fields';
                foreach ($uat_default_tab as $tab) { ?>

                    
                    <?php if($tab['slug']=='ua-auctions-theme-default-fields-list'){ ?>

                        <a href="?page=acf-options-default-fields&uat-custom-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab nav-tab-active"><?php echo $tab['label']; ?></a>


                    <?php }else{ ?>
                    

                        <a href="?page=ua-auctions-theme-custom-fields&uat-custom-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab "><?php echo $tab['label']; ?></a>
                    
                    <?php } ?>
                
                    
                    
                <?php } ?>
            </h2>
        </div>
        </div>
	


    <?php
    }
}
add_filter('admin_notices', 'my_custom_acf_options_page_html',10);