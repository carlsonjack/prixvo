<header class="header-layout-2">
	<div class="site-header">
		<div class="container header-container">
		<?php 
		/* Header logo */ 
		do_action('uat_header_logo');
		
		
		/* Search Box Option */ 	
		echo '<div class="right-side-menu 1">';
		$menu_search_box = get_option('options_uat_menu_search_box', "on");
		if ($menu_search_box == 'on') {  do_action('uat_search_box'); } 
			if (has_nav_menu('primary')) {
				wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => '', 'container' => '', 'items_wrap' => '<div class="mobile-hamburger"><span class="bar"></span><span class="bar"></span><span class="bar"></span></div><ul class="top-right-menu-ul">%3$s</ul>'));
			}
		/* Sign in Link option */ 
		do_action('uat_header_sign_in');
		echo '</div>';
		
		$options_uat_secondary_menu = get_option('options_uat_secondary_menu', "on");
		if ($options_uat_secondary_menu == 'on' && has_nav_menu('secondary')) { ?>
			<div class="Second-header-main-menu">
				<nav id='auctionmenu'>
					<div class="bar-button"></div>
					<?php 
						wp_nav_menu(array('theme_location' => 'secondary', 'menu_class' => '', 'container' => '', 'items_wrap' => '<ul>%3$s</ul>')); 
					?>
				</nav>
			</div>
		<?php } ?>
		
	</div>	
</header>