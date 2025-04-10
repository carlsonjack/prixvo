<header class="header-layout-1">
	<div class="site-header">
		<div class="container header-container">
		<?php 
		/* Header logo */ 
		do_action('uat_header_logo');
		
		/* Search Box Option */ 	
		$menu_search_box = get_option('options_uat_menu_search_box', "on");
		if ($menu_search_box == 'on') {  do_action('uat_search_box'); } 

		if (has_nav_menu('primary')) {
			echo '<div class="right-side-menu">';
			wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => '', 'container' => '', 'items_wrap' => '<ul class="top-right-menu-ul">%3$s</ul>'));
			echo '</div>';
		}
		
		/* Sign in Link option */ 
		do_action('uat_header_sign_in');
		
		$options_uat_secondary_menu = get_option('options_uat_secondary_menu', "on");
		if ($options_uat_secondary_menu == 'on' && has_nav_menu('secondary')) {	 ?>
			<div class="Second-header-main-menu">
				<nav id='auctionmenu'>
					<div class="bar-button"></div>
					<?php wp_nav_menu(array('theme_location' => 'secondary', 'menu_class' => '', 'container' => '', 'items_wrap' => '<ul>%3$s</ul>')); ?>
				</nav>
			</div>
		<?php } ?>
	</div>	
</header>