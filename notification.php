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
	    <?php _e('Notification', 'ultimate-auction-pro-software'); ?>
	</h1>
	<div class="uat_theme_page_nav">
			<h2 class="nav-tab-wrapper">
				<?php
				$uat_default_tab = array(array('range' => 'email','slug' => 'uat-auctions-emails', 'label' => __('Emails', 'ultimate-auction-pro-software')), array('range' => '','slug' => 'ua-auctions-tsms', 'label' => __('SMS/Whatsapp', 'ultimate-auction-pro-software')));
				$active_tab = isset($_GET['uat-emails-tab']) ? $_GET['uat-emails-tab'] : 'uat-auctions-emails';
				foreach ($uat_default_tab as $tab) { ?>
					<a href="?page=ua-auctions-emails&uat-emails-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label']; ?></a>
				<?php } ?>
			</h2>
		</div>
	<?php
	if ($active_tab == 'uat-auctions-emails') {
		include_once(UAT_THEME_PRO_ADMIN . 'emails/uat-email-setting.php');
	}
	if ($active_tab == 'ua-auctions-tsms') {
		include_once(UAT_THEME_PRO_ADMIN . 'notifications/twilio-sms-admin.php');
	}
	?>
</div>