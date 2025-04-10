<?php

/**
 * Class for logs and errors
 * Uat_Logs Main class
 */
if (!defined('ABSPATH')) {
	exit;
} ?>

<div class="wrap welcome-wrap uat-admin-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uwa_admin_page_title">
	  <?php _e('Reports', 'ultimate-auction-pro-software'); ?>
	</h1>

	<div class="uat_theme_page_nav">
		<h2 class="nav-tab-wrapper">
			<?php
			/*$uat_default_tab = array(array('uat-report-type' => 'products','range' => 'year','slug' => 'uat-report-report', 'label' => __('Report', 'ultimate-auction-pro-software')), array('uat-report-type' => 'log','range' => '','slug' => 'uat-report-logs', 'label' => __('Logs', 'ultimate-auction-pro-software')));*/
			$uat_default_tab = array( array('uat-report-type' => 'log','range' => '','slug' => 'uat-report-logs', 'label' => __('Logs', 'ultimate-auction-pro-software')));

			$active_tab = isset($_GET['uat-report-tab']) ? $_GET['uat-report-tab'] : 'uat-report-logs';

			foreach ($uat_default_tab as $tab) { ?>

				<a href="?page=ua-auctions-reports&uat-report-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label']; ?></a>

			<?php } ?>

		</h2>
	</div>

	<?php
	if ($active_tab == 'uat-report-logs') {
		include_once(UAT_THEME_PRO_ADMIN . 'activity/uat-auctions-logs-list.php');
		uat_logs_list_table_page_handler_display();
	}

	if ($active_tab == 'uat-report-report') {
		include_once(UAT_THEME_PRO_ADMIN . 'activity/uat-auctions-reports-list.php');
	 
	}
	?>
</div>