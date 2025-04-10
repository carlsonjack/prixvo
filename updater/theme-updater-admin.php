<?php

/**
 * Theme updater admin page and functions.
 *
 * @package EDD Sample Theme
 */

class EDD_Theme_Updater_Admin
{

	/**
	 * Variables required for the theme updater
	 *
	 * @since 1.0.0
	 * @type string
	 */
	protected $remote_api_url = null;
	protected $theme_slug     = null;
	protected $version        = null;
	protected $author         = null;
	protected $download_id    = null;
	protected $renew_url      = null;
	protected $strings        = null;
	protected $item_name      = '';
	protected $beta           = false;
	protected $item_id        = null;

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct($config = array(), $strings = array())
	{

		if (isset($license_key) && $license_key != null) {
			$license_key;
		} else {
			$license_key = '';
		}

		$config = wp_parse_args(
			$config,
			array(
				'remote_api_url' => 'https://getultimateauction.com/',
				'theme_slug'     => get_template(),
				'item_name'      => 'Ultimate Auction Pro Software - All Access',
				'license'        => $license_key,
				'version'        => '1.0.5',
				'author'         => 'Nitesh Singh',
				'download_id'    => '',
				'renew_url'      => '',
				'beta'           => false,
				'item_id'        => '',
			)
		);

		/**
		 * Fires after the theme $config is setup.
		 *
		 * @since x.x.x
		 *
		 * @param array $config Array of EDD SL theme data.
		 */
		do_action('post_edd_sl_theme_updater_setup', $config);

		// Set config arguments
		$this->remote_api_url = $config['remote_api_url'];
		$this->item_name      = $config['item_name'];
		$this->theme_slug     = sanitize_key($config['theme_slug']);
		$this->version        = $config['version'];
		$this->author         = $config['author'];
		$this->download_id    = $config['download_id'];
		$this->renew_url      = $config['renew_url'];
		$this->beta           = $config['beta'];
		$this->item_id        = $config['item_id'];

		// Populate version fallback
		if ('' === $config['version']) {
			$theme         = wp_get_theme($this->theme_slug);
			$this->version = $theme->get('Version');
		}

		// Strings passed in from the updater config
		$this->strings = $strings;

		add_action('init', array($this, 'updater'));
		add_action('admin_init', array($this, 'register_option'));
		add_action('admin_init', array($this, 'license_action'));
		add_action('admin_menu', array($this, 'license_menu'));
		add_action('update_option_' . $this->theme_slug . '_license_key', array($this, 'activate_license'), 10, 2);
		add_filter('http_request_args', array($this, 'disable_wporg_request'), 5, 2);
	}

	/**
	 * Creates the updater class.
	 *
	 * since 1.0.0
	 */
	public function updater()
	{

		// To support auto-updates, this needs to run during the wp_version_check cron job for privileged users.
		$doing_cron = defined('DOING_CRON') && DOING_CRON;
		if (!current_user_can('manage_options') && !$doing_cron) {
			return;
		}

		/* If there is no valid license key status, don't allow updates. */
		if ('valid' !== get_option($this->theme_slug . '_license_key_status', false)) {
			return;
		}

		if (!class_exists('EDD_Theme_Updater')) {
			// Load our custom theme updater
			include dirname(__FILE__) . '/theme-updater-class.php';
		}

		new EDD_Theme_Updater(
			array(
				'remote_api_url' => $this->remote_api_url,
				'version'        => $this->version,
				'license'        => trim(get_option($this->theme_slug . '_license_key')),
				'item_name'      => $this->item_name,
				'author'         => $this->author,
				'beta'           => $this->beta,
				'item_id'        => $this->item_id,
				'theme_slug'     => $this->theme_slug,
			),
			$this->strings
		);
		
	}
	
	/**
	 * Adds a menu item for the theme license under the appearance menu.
	 *
	 * since 1.0.0
	 */
	public function license_menu()
	{

		$strings = $this->strings;

		add_submenu_page('ua-auctions-theme', __('Welcome | License', 'ultimate-auction-pro-software'), __('Welcome | License', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-theme', array($this, 'license_page'), 1);
	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	public function license_page()
	{

		$strings = $this->strings;

		$license = trim(get_option($this->theme_slug . '_license_key'));
		$status  = get_option($this->theme_slug . '_license_key_status', false);

		$license_child = trim(get_option($this->theme_slug . '_license_key_child'));
		$status_child  = get_option($this->theme_slug . '_license_key_child_status', false);

		// Checks license status to display under license key
		if (!$license) {
			$message = $strings['enter-key'];
		} else {
			// delete_transient( $this->theme_slug . '_license_message' );
			if (!get_transient($this->theme_slug . '_license_message', false)) {
				set_transient($this->theme_slug . '_license_message', $this->check_license(), (60 * 60 * 24));
			}
			$message = get_transient($this->theme_slug . '_license_message');
		}
		?>
		<?php wp_enqueue_style('licence-admin', UAT_THEME_PRO_CSS_URI . 'licence-admin.css', array(), UAT_THEME_PRO_VERSION); ?>
		<div class="wrap welcome-wrap uat-admin-wrap">
			<div class="wrap uat-das uat-db-welcome uat-registration-pending about-wrap">
				<header class="uat-db-header-main">
					<div class="uat-db-header-main-container">
						<a class="uat-db-logo" href="#" aria-label="Link to uat das">
							<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ultimate-aution-pro-software-logo.svg">
						</a>
						<nav class="uat-db-menu-main">
							<ul class="uat-db-menu">
								<?php $option_url = admin_url('admin.php?page=ua-auctions-theme-options');	?>
								<li class="uat-db-menu-item uat-db-menu-item-options">
									<a class="uat-db-menu-item-link" href="<?php echo $option_url; ?>"><span class="uat-db-menu-item-text"><?php _e('Options', 'ultimate-auction-pro-software'); ?></span></a>
								</li>
								<?php $uat_event_url = admin_url('edit.php?post_type=uat_event');	?>

								<li class="uat-db-menu-item uat-db-menu-item-prebuilt-websites"><a class="uat-db-menu-item-link" href="<?php echo $uat_event_url; ?>"><span class="uat-db-menu-item-text"><?php _e('Auction Events', 'ultimate-auction-pro-software'); ?></span></a></li>
								<?php $products_url = admin_url('admin.php?page=ua-auctions-theme-products-lots');	?>
								<li class="uat-db-menu-item uat-db-menu-item-maintenance"><a class="uat-db-menu-item-link" href="<?php echo $products_url; ?>"><span class="uat-db-menu-item-text"><?php _e('Product/Lot', 'ultimate-auction-pro-software'); ?></span><span class="uat-db-maintenance-counter" style="display: inline;"></span></a>
									<ul class="uat-db-menu-sub uat-db-menu-sub-maintenance">
										<?php $Emails_url = admin_url('admin.php?page=ua-auctions-emails');	?>
										<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
											<a class="uat-db-menu-sub-item-link" href="<?php echo $Emails_url; ?>"><?php _e('Notification', 'ultimate-auction-pro-software'); ?></a>
										</li>
										<?php $logs_url = admin_url('admin.php?page=ua-auctions-reports');	?>
										<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
											<a class="uat-db-menu-sub-item-link" href="<?php echo $logs_url; ?>"><?php _e('Logs', 'ultimate-auction-pro-software'); ?></a>
										</li>
										<?php $hel_url = admin_url('admin.php?page=ua-auctions-help');	?>
										<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
											<a class="uat-db-menu-sub-item-link" href="<?php echo $hel_url; ?>"><?php _e('Support', 'ultimate-auction-pro-software'); ?></a>
										</li>

										<?php $status_url = admin_url('admin.php?page=ua-auctions-theme-status');	?>
										<li class="uat-db-menu-sub-item uat-db-menu-sub-item-patcher">
											<a class="uat-db-menu-sub-item-link" href="<?php echo $status_url; ?>"><?php _e('Theme Status', 'ultimate-auction-pro-software'); ?></a>
										</li>

									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</header>
				<header class="uat-db-header-sticky">
					<div class="uat-db-menu-sticky">
						<div class="uat-db-menu-sticky-label">
							
							<?php
							$uat_theme = wp_get_theme();
							$uat_theme_version = esc_html($uat_theme->get('Version'));
							?>
							<span class="uat-db-version"><span>v<?php echo $uat_theme_version; ?></span> |</span>
							<?php if ('valid' === $status) {				?>
								<span class="uat-db-version-label uat-db-registered"><?php _e('Registered', 'ultimate-auction-pro-software'); ?></span>
							<?php  } else { ?>
								<span class="uat-db-version-label uat-db-unregistered"><?php _e('Unregistered', 'ultimate-auction-pro-software'); ?></span>
							<?php  } ?>
							|
							<span class="uat-db-version-label"><?php _e('License', 'ultimate-auction-pro-software'); ?> : </span>
							<span class="uat-db-version-label"><?php echo EDD_UAT_THEME_NAME; ?></span>
							
							<?php 
							$active_theme_slug = get_stylesheet();
							if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {
								$child_theme = wp_get_theme('ultimate-auction-pro-vehicle-software');
								$uat_child_theme_version = esc_html($child_theme->get('Version'));

								$license_child = trim(get_option($this->theme_slug . '_license_key_child'));
								$status_child  = get_option('ultimate-auction-pro-vehicle-software_license_key_child_status', false); ?>
								
								</br>
								<span class="uat-db-version"><span>v<?php echo $uat_child_theme_version; ?></span> |</span>
								<?php if ('valid' === $status_child) {				?>
									<span class="uat-db-version-label uat-db-registered"><?php _e('Registered', 'ultimate-auction-pro-software'); ?></span>
								<?php  } else { ?>
									<span class="uat-db-version-label uat-db-unregistered"><?php _e('Unregistered', 'ultimate-auction-pro-software'); ?></span>
								<?php  } ?>
								|
								<span class="uat-db-version-label"><?php _e('License', 'ultimate-auction-pro-software'); ?> : </span>
								<span class="uat-db-version-label"><?php echo EDD_UAT__CHILD_THEME_NAME; ?></span>
							<?php } ?>
						</div>
					</div>
				</header>
				<div class="uat-db-demos-notices"></div>

				<div class="uat-das">

					<div class="ua-install-panel-main">

						<div id="theme_install_menu" class="ua-theme-install-menu left-menu">
							<div class="ua-wizard-menu rsssl-grid-item">
								<div class="ua-grid-item-header">
									<h1 class="ua-h4"><?php _e('Theme Setup', 'ultimate-auction-pro-software'); ?></h1>
								</div>
								<div class="ua-grid-item-content">

									<div class="ua-wizard-menu-items">
										<div class="ua-menu-item tablinks rsssl-active" onclick="openTab(event, 'ua-system-status')" id="defaultOpen"><a href="#ua-system-status"><span><?php _e('System Status', 'ultimate-auction-pro-software'); ?></span></a></div>
										<div class="ua-menu-item tablinks" onclick="openTab(event, 'ua-install-plugin')"><a href="#ua-install-plugin"><span><?php _e('Install Plugins', 'ultimate-auction-pro-software'); ?></span></a></div>
										<div class="ua-menu-item tablinks" onclick="openTab(event, 'import-demo')"><a href="#import-demo"><span><?php _e('Import Demo', 'ultimate-auction-pro-software'); ?></span></a></div>
										<div class="ua-menu-item tablinks " onclick="openTab(event, 'registration')"><a href="#ua-license"><span><?php _e('Software License', 'ultimate-auction-pro-software'); ?></span></a></div>
									</div>
									<div class="rsssl-grid-item-footer"></div>
								</div>
							</div>
						</div>

						<div id="uat-db-panel-right" class="ua-theme-install_right right-menu">
							<?php /* System Status */ ?>
							<div class="tabcontent" id="ua-system-status">
								<div class="ua-grid-item">
									<section id="uat-db-registration" class="uat-db-card uat-db-registration right-menu">
										<h2 class="uat-db-reg-heading">
											<svg width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
												<style type="text/css">
													.st0 {
														fill: #FFFFFF;
													}
												</style>
												<g>
													<path d="M14.9,19c0.1,0.5,0.1,0.9,0.2,1.4c0.4,0,0.7,0,1.1,0c0.6,0,0.9,0.3,0.9,0.9c0,0.2,0,0.3,0,0.5c0,0.6-0.3,0.9-0.9,0.9 c-1.2,0-2.4,0-3.5,0c-1.6,0-3.3,0-4.9,0c-0.6,0-0.9-0.3-0.9-0.9c0-0.2,0-0.4,0-0.5c0-0.5,0.3-0.8,0.9-0.8c0.4,0,0.7,0,1.1,0 C8.9,19.9,9,19.5,9,19c-0.1,0-0.2,0-0.3,0c-2.3,0-4.7,0-7,0C0.6,19,0,18.4,0,17.3C0,12.5,0,7.8,0,3c0-1.1,0.6-1.7,1.7-1.7 c6.9,0,13.7,0,20.6,0C23.3,1.3,24,1.9,24,3c0,4.8,0,9.6,0,14.4c0,1.1-0.6,1.7-1.7,1.7c-2.3,0-4.7,0-7,0C15.2,19,15.1,19,14.9,19z M1.7,2.8c0,4.9,0,9.7,0,14.6c6.9,0,13.7,0,20.6,0c0-4.9,0-9.7,0-14.6C15.4,2.8,8.6,2.8,1.7,2.8z" />
													<path class="st0" d="M11.4,5.9C11.4,5.9,11.5,5.9,11.4,5.9c0.3,0.6,0.4,1.3,0.6,1.9c0.5,2.2,1.1,4.4,1.6,6.6 c0.1,0.5,0.3,0.9,0.5,1.3c0.1,0.3,0.3,0.5,0.7,0.5c0.4,0,0.6-0.3,0.7-0.6c0.1-0.2,0.2-0.5,0.2-0.7c0.4-1.9,0.7-3.9,1-5.8 c0.1-0.5,0.2-1.1,0.3-1.6c0,0,0,0,0.1,0c0.1,0.3,0.2,0.6,0.3,0.8c0.3,0.7,0.5,1.4,0.8,2.1c0.1,0.3,0.4,0.4,0.7,0.4 c0.7,0,1.4,0,2.1,0c0.1,0,0.1,0,0.2,0c0-0.4,0-0.7,0-1.1c-0.6,0-1.2,0-1.8,0c-0.2,0-0.3-0.1-0.4-0.3c-0.3-0.9-0.7-1.8-1.1-2.7 c-0.1-0.3-0.3-0.7-0.6-0.9c-0.4-0.4-0.9-0.3-1.1,0.2c-0.1,0.4-0.3,0.7-0.3,1.1c-0.3,1.9-0.6,3.7-1,5.6c-0.1,0.5-0.2,1-0.3,1.5 c0,0,0,0-0.1,0c-0.1-0.3-0.2-0.5-0.2-0.8c-0.6-2.4-1.2-4.9-1.8-7.3c-0.1-0.6-0.3-1.1-0.5-1.7C12.1,4.2,11.9,4,11.5,4 c-0.4,0-0.6,0.2-0.7,0.5c-0.1,0.3-0.3,0.5-0.3,0.8c-0.5,1.7-0.9,3.4-1.4,5c-0.1,0.4-0.2,0.8-0.3,1.2c-0.1-0.1-0.1-0.2-0.1-0.3 C8.4,10.5,8.2,9.7,8,9C7.9,8.5,7.7,8,7.5,7.5C7.2,7.1,6.7,7,6.3,7.4C6.1,7.6,6,7.8,5.9,8C5.6,8.5,5.4,9.1,5.2,9.6 C5.1,9.8,5,9.8,4.8,9.8c-0.6,0-1.3,0-1.9,0c-0.1,0-0.2,0-0.3,0c0,0.4,0,0.7,0,1.1c0.8,0,1.6,0,2.4,0c0.5,0,0.7-0.2,0.9-0.6 C6.2,9.9,6.4,9.4,6.7,9c0-0.1,0.1-0.1,0.1-0.2c0,0.1,0.1,0.2,0.1,0.3c0.3,1.2,0.6,2.4,0.9,3.5c0.1,0.3,0.2,0.6,0.4,0.8 c0.3,0.4,0.8,0.4,1,0c0.1-0.2,0.2-0.4,0.3-0.7c0.3-1,0.6-2.1,0.9-3.1C10.7,8.3,11.1,7.1,11.4,5.9z" />
													<path d="M11.4,5.9c-0.3,1.2-0.7,2.4-1,3.6c-0.3,1-0.6,2.1-0.9,3.1c-0.1,0.2-0.2,0.5-0.3,0.7c-0.2,0.4-0.8,0.4-1,0 c-0.2-0.2-0.3-0.5-0.4-0.8c-0.3-1.2-0.6-2.4-0.9-3.5c0-0.1,0-0.2-0.1-0.3C6.7,8.9,6.7,8.9,6.7,9C6.4,9.4,6.2,9.9,6,10.4 C5.8,10.8,5.6,11,5.1,11c-0.8,0-1.6,0-2.4,0c0-0.4,0-0.7,0-1.1c0.1,0,0.2,0,0.3,0c0.6,0,1.3,0,1.9,0c0.2,0,0.3-0.1,0.3-0.2 C5.4,9.1,5.6,8.5,5.9,8C6,7.8,6.1,7.6,6.3,7.4C6.7,7,7.2,7.1,7.5,7.5C7.7,8,7.9,8.5,8,9c0.2,0.8,0.4,1.5,0.6,2.3 c0,0.1,0.1,0.2,0.1,0.3c0.1-0.4,0.2-0.8,0.3-1.2c0.5-1.7,0.9-3.4,1.4-5c0.1-0.3,0.2-0.6,0.3-0.8c0.1-0.3,0.3-0.5,0.7-0.5 c0.3,0,0.5,0.2,0.6,0.5c0.2,0.6,0.4,1.1,0.5,1.7c0.6,2.4,1.2,4.9,1.8,7.3c0.1,0.3,0.2,0.5,0.2,0.8c0,0,0,0,0.1,0 c0.1-0.5,0.2-1,0.3-1.5c0.3-1.9,0.6-3.7,1-5.6c0.1-0.4,0.2-0.7,0.3-1.1c0.2-0.5,0.7-0.6,1.1-0.2c0.2,0.3,0.4,0.6,0.6,0.9 c0.4,0.9,0.7,1.8,1.1,2.7c0.1,0.2,0.2,0.3,0.4,0.3c0.6,0,1.2,0,1.8,0c0,0.4,0,0.7,0,1.1c-0.1,0-0.1,0-0.2,0c-0.7,0-1.4,0-2.1,0 c-0.3,0-0.6-0.1-0.7-0.4c-0.3-0.7-0.6-1.4-0.8-2.1c-0.1-0.3-0.2-0.6-0.3-0.8c0,0,0,0-0.1,0c-0.1,0.5-0.2,1.1-0.3,1.6 c-0.3,1.9-0.7,3.9-1,5.8c0,0.3-0.1,0.5-0.2,0.7c-0.1,0.3-0.3,0.6-0.7,0.6c-0.4,0-0.6-0.2-0.7-0.5c-0.2-0.4-0.4-0.9-0.5-1.3 c-0.6-2.2-1.1-4.4-1.6-6.6C11.8,7.2,11.7,6.6,11.4,5.9C11.5,5.9,11.4,5.9,11.4,5.9z" />
												</g>
											</svg>
											<span class="uat-db-reg-heading-text"><?php _e('System Status', 'ultimate-auction-pro-software'); ?></span>
										</h2>
										<div class="uat-db-reg-form-container activation-form">
											<p class="uat-db-reg-text title-theme-install"><?php _e('Site Readiness'); ?></p>
											<?php

											if (!class_exists('WP_Debug_Data')) {
												require_once ABSPATH . 'wp-admin/includes/class-wp-debug-data.php';
											}
											if (!class_exists('WP_Site_Health')) {
												require_once ABSPATH . 'wp-admin/includes/class-wp-site-health.php';
											}
											global $wpdb;
											WP_Debug_Data::check_for_updates();
											$info = WP_Debug_Data::debug_data();
											// echo "<pre>";
											// print_r($info);
											// echo "</pre>";
											$sizes_fields = array('uploads_size', 'themes_size', 'plugins_size', 'wordpress_size', 'database_size', 'total_size');
											echo '<ul>';
											$next_link_server = '';
											$next_php_version = '';
											$next_writable = '';
											$next_version = '';
											foreach ($info as $section => $details) {
												if ('wp-server' == esc_attr($section)) {

													foreach ($details['fields'] as $field_name => $field) {
														if (is_array($field['value'])) {
															$values = '<ul>';

															foreach ($field['value'] as $name => $value) {
																$values .= sprintf('<li>%s: %s</li>', esc_html($name), esc_html($value));
															}

															$values .= '</ul>';
														} else {
															$values = esc_html($field['value']);
														}
														if ('memory_limit' == $field_name) {
															if (version_compare($values, "256M", ">=")) { ?>
															<?php
																/*echo $values;*/
																$next_link_server = '1';
																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s: <span>PHP Memory Limit should be at least 256 MB. This is good to go.</span></li>', esc_html($field['label']), $values);
															} else {
																$next_link_server = '';
																$values = 'Please increase the PHP memory limit to 256MB. <a target="_blank" href="https://docs.getultimateauction.com/article/35-server-recommendations">Refer Artical</a>';

																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s: <span>' . $values . '</span></li>', esc_html($field['label']));
															}
														}
														if ('php_version' == $field_name) {
															if (version_compare(phpversion(), "7.4.0", ">=")) {
																$next_php_version = '1';
																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s: <span>Required PHP version 7.4 or higher. We have detected %s version which is good to go.</span>', esc_html($field['label']), $values);
															} else {
																$next_php_version = '0';
																$values = 'Required php version 7.4 or higher, Please Update PHP. <a target="_blank" href="https://docs.getultimateauction.com/article/35-server-recommendations">Refer Artical</a>';
																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s: <span>' . $values . '</span></li>', esc_html($field['label']));
															}
														}
													}
												}
												if ('wp-core' == esc_attr($section)) {

													foreach ($details['fields'] as $field_name => $field) {
														if (is_array($field['value'])) {
															$values = '<ul>';

															foreach ($field['value'] as $name => $value) {
																$values .= sprintf('<li>%s: %s</li>', esc_html($name), esc_html($value));
															}

															$values .= '</ul>';
														} else {
															$values = esc_html($field['value']);
														}

														if ('version' == $field_name) {
															if (version_compare($values, "5.9", ">=")) { ?>
													<?php
																/*echo $values;*/
																$next_version = '1';
																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s: <span>WP Version should be 5.9 or higher. This is good to go.</span></li>', esc_html($field['label']), $values);
															} else {

																$next_version = '0';
																$values = 'WP Version should be 5.9 or higher. Kindly update WordPress .';
																printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s: <span>' . $values . '</span></li>', esc_html($field['label']));
															}
														}
													}
												}
											}
											foreach ($info as $section => $details) {
												if ('wp-filesystem' == esc_attr($section)) { ?>
													<p class="uat-db-reg-text title-theme-install"><?php echo esc_html($details['label']); ?></p>
													<?php foreach ($details['fields'] as $field_name => $field) {
														if (is_array($field['value'])) {
															$values = '<ul>';

															foreach ($field['value'] as $name => $value) {
																$values .= sprintf('<li>%s: %s</li>', esc_html($name), esc_html($value));
															}

															$values .= '</ul>';
														} else {
															$values = esc_html($field['value']);
														}
														if ($values == 'Writable') {
															$next_writable = '1';
															printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s: WordPress Content Directory has writable file permissions.</li>', esc_html($field['label']), $values);
														} else {
															$next_writable = '0';
															$values = 'Directory does not have writable permission, please edit your directory permissions.';
															printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s: %s</li>', esc_html($field['label']), $values);
														}
													}


													if ($next_link_server == 1 && $next_php_version == 1 && $next_writable == 1 && $next_version == 1) {
														$disabled = 'onclick="openTab(event, \'ua-install-plugin\')"';
													} else {
														$disabled = 'disabled';
													}


													?>


											<?php }
											} ?>
											</ul>
										</div>
									</section>
									<div class="rsssl-grid-item-footer"><button class="button button-primary reset-button">Refresh</button>
										<div class="ua-menu-item tablinks"><a class="button button-primary" href="#ua-install-plugin" <?php echo $disabled; ?>>Continue</a></div><a class="button button-primary" href="https://getultimateauction.com/contact-us/" target="_blank">Contact Support</a>
									</div>
								</div>

							</div>
							<div class="tabcontent" id="ua-install-plugin">
								<div class="ua-grid-item">
									<section id="uat-db-registration" class="uat-db-card uat-db-registration right-menu">
										<h2 class="uat-db-reg-heading">
											<!-- Generator: Adobe Illustrator 25.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
											<svg width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
												<g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
													<path d="M7.7,4.2L7.7,4.2C7.4,4.1,7.4,3.8,7.4,3.8c0-0.1,0-0.3,0.3-0.5C7.8,3.3,7.9,3.1,8,3s0.1-0.3,0-0.4L7.6,1.6
									C7.5,1.3,7.2,1.2,6.9,1.3C6.6,1.4,6.4,1.3,6.3,1.2C6.3,1.2,6.1,1,6.2,0.7c0.1-0.1,0.1-0.3,0-0.4C6.2,0.1,6,0,5.9-0.1L5-0.5
									c-0.3-0.1-0.6,0-0.8,0.3C4.1,0.1,3.8,0.2,3.8,0.2s-0.3,0-0.5-0.3C3.3-0.3,3.1-0.4,3-0.5c-0.1-0.1-0.3-0.1-0.4,0L1.6-0.1
									C1.5,0,1.4,0.1,1.3,0.2c-0.1,0.1-0.1,0.3,0,0.4C1.4,1,1.3,1.2,1.2,1.2C1.2,1.3,1,1.4,0.7,1.3c-0.1-0.1-0.3-0.1-0.4,0
									C0.1,1.4,0,1.5-0.1,1.6l-0.4,0.9c-0.1,0.1-0.1,0.3,0,0.4c0.1,0.1,0.2,0.3,0.3,0.3c0.3,0.1,0.3,0.4,0.3,0.5c0,0.1,0,0.3-0.3,0.5
									C-0.4,4.4-0.6,4.7-0.5,5l0.4,0.9C0,6,0.1,6.2,0.2,6.2c0.1,0.1,0.3,0.1,0.4,0C1,6.1,1.2,6.3,1.2,6.3c0.1,0.1,0.2,0.3,0.1,0.5
									c-0.1,0.3,0,0.6,0.3,0.8L2.6,8c0.1,0,0.1,0,0.2,0C2.9,8,2.9,8,3,8c0.1-0.1,0.3-0.2,0.3-0.3c0.1-0.3,0.4-0.3,0.5-0.3s0.3,0,0.5,0.3
									C4.4,8,4.7,8.1,5,8l0.9-0.4c0.3-0.1,0.4-0.5,0.3-0.8C6.1,6.6,6.3,6.4,6.3,6.3c0.1-0.1,0.3-0.2,0.5-0.1c0.3,0.1,0.6,0,0.8-0.3L8,5
									C8.1,4.7,8,4.4,7.7,4.2z M3.8,6.2c-1.3,0-2.4-1.1-2.4-2.4s1.1-2.4,2.4-2.4s2.4,1.1,2.4,2.4S5.1,6.2,3.8,6.2z" />
													<path d="M3.8,5.3c-0.1,0-0.1,0-0.2-0.1L2.6,4.3C2.5,4.1,2.5,4,2.6,3.8c0.1-0.1,0.3-0.1,0.4,0l0.7,0.7l0.7-0.7
									c0.1-0.1,0.3-0.1,0.4,0C5,4,5,4.1,4.9,4.3L4,5.2C3.9,5.3,3.8,5.3,3.8,5.3z" />
													<path d="M3.8,5.3C3.6,5.3,3.5,5.2,3.5,5V2.5c0-0.2,0.1-0.3,0.3-0.3s0.3,0.1,0.3,0.3V5C4.1,5.2,3.9,5.3,3.8,5.3z" />
												</g>
											</svg>
											<span class="uat-db-reg-heading-text"><?php _e('Install Required Plugins', 'ultimate-auction-pro-software'); ?></span>
										</h2>
										<div class="uat-db-reg-form-container activation-form">
											<p class="uat-db-reg-text"><?php _e('Our theme is based on WooCommerce and uses the following plugins to provide many auction-related features to you. Please make sure to install these plugins and also keep them updated from time to time.'); ?></p>

											<div class="boxes-link">
												<div class="two-col-boxes">
													<div class="box">
														<a href="https://wordpress.org/plugins/woocommerce/" target="_blank"></a>
														<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/woocomerce-img.jpg">
														<a class="img-link" href="https://wordpress.org/plugins/woocommerce/" target="_blank"><?php _e('Woocomerce', 'ultimate-auction-pro-software'); ?></a>
													</div>
													<div class="box">
														<a href="https://www.advancedcustomfields.com/pro/"></a>
														<img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/acf-img.jpg">
														<a class="img-link" href="https://www.advancedcustomfields.com/pro/"><?php _e('Advanced Custom Fields Pro', 'ultimate-auction-pro-software'); ?></a>
													</div>
												</div>
											</div>
											<?php
											$woo_acf_install = get_option('woo_acf_install');
											$add_next = '';
											if (empty($woo_acf_install) || $woo_acf_install == 1) {
												$add_next = 'onclick="openTab(event, \'import-demo\')"';
											} else {
												$add_next = 'disabled';
											}
											?>
											<div id="data_result" class="ua-data-result"></div>
										</div>
									</section>
									<div class="rsssl-grid-item-footer">
										<?php if (empty($woo_acf_install) || $woo_acf_install != 1) { ?>
											<a class="button button-primary install" href="javascript:void(0)" onclick="install_plugins_data();"><?php _e('Install Core Plugin', 'ultimate-auction-pro-software'); ?></a>
											<a class="button button-primary installed" href="javascript:void(0)" style="display:none" disabled><?php _e('Plugin installed', 'ultimate-auction-pro-software'); ?></a>
											<div class="ua-menu-item tablinks "><a class="button button-primary next_demo" href="#import-demo" style="display:none" onclick="openTab(event, 'import-demo')"><?php _e('Continue', 'ultimate-auction-pro-software'); ?></a></div>
										<?php } else { ?>
											<a class="button button-primary installed" href="javascript:void(0)" disabled><?php _e('Plugin installed', 'ultimate-auction-pro-software'); ?></a>
											<div class="ua-menu-item tablinks install"><a class="button button-primary" href="#ua-auctions-theme#import-demo" <?php echo $add_next; ?>><?php _e('Continue', 'ultimate-auction-pro-software'); ?></a></div>
										<?php } ?>


									</div>
								</div>

							</div>
							<script type="text/javascript">
								function install_plugins_data() {

									jQuery.ajax({
										url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
										type: "post",
										dataType: 'json',
										data: {
											action: 'install_required_plugins',
											setp: '1',
											uat_install_btn: "true",

										},
										beforeSend: function() {
											jQuery('#data_result').html('The plugin installation and activation process is starting. This process may take a while on some hosts, so please be patient.');
										},
										success: function(data) {
											if (data.status) {
												jQuery(".install").hide();
												jQuery(".installed").show();
												jQuery(".next_demo").show();
												location.reload(true);
											}else{
												jQuery("#data_result").css('color', 'red');
											}
											jQuery("#data_result").html(data.message);

										},
										error: function() {
											console.log('failure!');

										}

									});

								}
							</script>
							<div class="tabcontent setupdemo" id="import-demo">
								<div class="ua-grid-item">
									<section id="uat-db-registration" class="uat-db-card uat-db-registration right-menu">
										<h2 class="uat-db-reg-heading">

											<svg width="25px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
												<g transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
													<path d="M7.7-0.5H5.4c-1.1,0-2,0.9-2,2v2.7L2.9,3.6c-0.1-0.1-0.4-0.1-0.5,0C2.2,3.8,2.2,4,2.3,4.2l1.2,1.2l0,0c0,0,0,0,0.1,0
									c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0.1,0s0.1,0,0.1,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0
									c0,0,0,0,0.1,0l0,0l1.2-1.2c0.1-0.1,0.1-0.4,0-0.5c-0.1-0.1-0.4-0.1-0.5,0L4.2,4.2V1.5c0-0.7,0.6-1.2,1.2-1.2h2.2
									C7.9,0.3,8,0.1,8-0.1S7.9-0.5,7.7-0.5z" />
													<path d="M6.8,8H0.7C0,8-0.5,7.5-0.5,6.8V0.7C-0.5,0,0-0.5,0.7-0.5h1.7c0.2,0,0.4,0.2,0.4,0.4S2.7,0.3,2.4,0.3H0.7
									c-0.2,0-0.4,0.2-0.4,0.4v6.1c0,0.2,0.2,0.4,0.4,0.4h6.1c0.2,0,0.4-0.2,0.4-0.4V1.6c0-0.2,0.2-0.4,0.4-0.4C7.9,1.3,8,1.4,8,1.6v5.2
									C8,7.5,7.5,8,6.8,8z" />
													<path d="M5.9,6.7H1.6c-0.2,0-0.4-0.2-0.4-0.4S1.4,6,1.6,6h4.3c0.2,0,0.4,0.2,0.4,0.4S6.1,6.7,5.9,6.7z" />
												</g>
											</svg>
											<span class="uat-db-reg-heading-text"><?php _e('Import Demo Data', 'ultimate-auction-pro-software'); ?></span>
										</h2>
										<div class="uat-db-reg-form-container">

											<p class="uat-db-reg-text title-theme-install"><?php _e('Server environment'); ?></p>

											<?php

											global $wpdb;
											if (class_exists('woocommerce')) {
												$report             = wc()->api->get_endpoint_data('/wc/v3/system_status');
												$environment        = $report['environment']??[];
												$remote_status = '';
											} else {
												$environment = [];
											}
											echo '<ul>';
											if (isset($environment['remote_post_successful']) && $environment['remote_post_successful'] == '200') {
												$remote_status_post = '1';
												printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s : <span> wp_remote_post() is enabled.  This is good to go.</span>', esc_html('Remote post'), $values);
											} else {
												$remote_status_post = '0';
												$values = 'wp_remote_post() failed to connact. please contact your hosting provider.';
												printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s : <span>' . $values . '</span></li>', esc_html('Remote post'));
											}
											if (isset($environment['remote_get_response']) && $environment['remote_get_response'] == '200') {
												$remote_status_get = '1';
												printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#2e8a37" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM371.8 211.8C382.7 200.9 382.7 183.1 371.8 172.2C360.9 161.3 343.1 161.3 332.2 172.2L224 280.4L179.8 236.2C168.9 225.3 151.1 225.3 140.2 236.2C129.3 247.1 129.3 264.9 140.2 275.8L204.2 339.8C215.1 350.7 232.9 350.7 243.8 339.8L371.8 211.8z"></path></svg></div> %s : <span> wp_remote_get() is enabled.  This is good to go.</span>', esc_html('Remote get'), $values);
											} else {
												$remote_status_get = '0';
												$values = 'wp_remote_get() failed to connact. please contact your hosting provider.';
												printf('<li><div class="rsssl-icon rsssl-icon-circle-check"><svg aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="15"><path fill="#d7263d" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM175 208.1L222.1 255.1L175 303C165.7 312.4 165.7 327.6 175 336.1C184.4 346.3 199.6 346.3 208.1 336.1L255.1 289.9L303 336.1C312.4 346.3 327.6 346.3 336.1 336.1C346.3 327.6 346.3 312.4 336.1 303L289.9 255.1L336.1 208.1C346.3 199.6 346.3 184.4 336.1 175C327.6 165.7 312.4 165.7 303 175L255.1 222.1L208.1 175C199.6 165.7 184.4 165.7 175 175C165.7 184.4 165.7 199.6 175 208.1V208.1z"></path></svg></div> %s : <span>' . $values . '</span></li>', esc_html('Remote get'));
											}
											echo '</ul>';
											if ($remote_status_post == '0' && $remote_status_get == '0') {
												$remote_status = '0';
											} else {
												$remote_status = '1';
											}
											?>
											<?php $woo_acf_lets_go = get_option('woo_acf_lets_go'); ?>

											<?php if ($remote_status == 0) {
												_e('<span style="color:red;font-weight:bold;">Failed to connect. Remote Get/Post Method. Click "Refresh" or please contact your hosting provider.</span>');
											} else { ?>
												<p class="uat-db-reg-text title-theme-install"><?php _e('Import theme Demo'); ?></p>
												<p class="uat-db-reg-text"><?php _e('Click here to import demo content'); ?></p>
												<div class="install-click">
													<?php
													$is_all_installed = get_option("is_uat_sample_data_installed", false);
													if ($is_all_installed != "yes") {
													?>
														<button type="button" class="button button-primary install alldone" onclick="import_demo_data_a();"><?php _e('Import Demo Data', 'ultimate-auction-pro-software'); ?></button>
														<button type="button" class="button button-primary installed" style="display:none" <?php if (!empty($woo_acf_lets_go) && $woo_acf_lets_go == 1) { ?>disabled <?php } ?>><?php _e('Demo installed', 'ultimate-auction-pro-software'); ?></button>
													<?php } else { ?>
														<button type="button" class="button button-primary alldone" disabled><?php _e('Demo installed', 'ultimate-auction-pro-software'); ?></button>
													<?php } ?>
												</div>
											<?php } ?>
											<div id="data_result_content" class="ua-data-result result"></div>
										</div>
									</section>
									<div class="rsssl-grid-item-footer">
										<?php if ($remote_status == 0) { ?>
											<div class="rsssl-grid-item-footer"><button class="button button-primary reset-button"><?php _e('Refresh', 'ultimate-auction-pro-software'); ?></button>
												<a class="button button-primary" href="https://getultimateauction.com/contact-us/" target="_blank"><?php _e('Contact Support', 'ultimate-auction-pro-software'); ?></a>
											</div>
										<?php } else { ?>
											<button type="button" class="button button-primary install alldone" disabled>Refresh</button>
										<?php } ?>
										<div class="ua-menu-item tablinks"><a class="button button-primary next_demo" href="#registration" onclick="openTab(event, 'registration')"><?php _e('Continue', 'ultimate-auction-pro-software'); ?></a></div>
										<a class="button button-primary seeletsgo" style="display:none" href="<?php echo admin_url('admin.php?page=ua-auctions-theme-options'); ?>"><?php _e('Go to Theme setting', 'ultimate-auction-pro-software'); ?></a>
									</div>
								</div>
							</div>
							<script type="text/javascript">
								function import_demo_data_a() {
									jQuery.ajax({
										url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
										type: "post",
										data: {
											action: 'fun_import_demo_data_ajax',
											setp: '1',
										},
										beforeSend: function() {
											jQuery('.result').html('The import porcess may take some time. please be patient.');
										},
										success: function(data) {
											jQuery(".result").html(data);
											jQuery(".alldone").hide();
											jQuery(".install").hide();
											jQuery(".alldone_1").show();
											jQuery(".installed").show();
											jQuery(".seeletsgo").show();
										},
										error: function() {
											console.log('failure!');
										}
									});
								}
							</script>
							<div class="tabcontent" id="registration">
								<div class="ua-grid-item">
									<section id="uat-db-registration" class="uat-db-card uat-db-registration right-menu">
										<h2 class="uat-db-reg-heading">
											<?php if ('valid' === $status) {				?>
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26" style="width: 25px;position: relative;top: -5px;">
													<path d="M 13 0 C 9.675781 0 7 2.675781 7 6 L 7 10 C 4.800781 10 3 11.800781 3 14 L 3 22 C 3 24.199219 4.800781 26 7 26 L 19 26 C 21.199219 26 23 24.199219 23 22 L 23 14 C 23 11.800781 21.199219 10 19 10 L 9 10 L 9 6 C 9 3.722656 10.722656 2 13 2 C 15.277344 2 17 3.722656 17 6 L 17 7 L 19 7 L 19 6 C 19 2.675781 16.324219 0 13 0 Z M 13 15 C 14.101563 15 15 15.898438 15 17 C 15 17.699219 14.601563 18.386719 14 18.6875 L 14 21 C 14 21.601563 13.601563 22 13 22 C 12.398438 22 12 21.601563 12 21 L 12 18.6875 C 11.398438 18.386719 11 17.699219 11 17 C 11 15.898438 11.898438 15 13 15 Z" style="width: 25px;height: 25px;"></path>
												</svg>
											<?php  } else { ?>
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50" style="width: 25px;position: relative;top: -5px;">
													<path d="M 25 3 C 18.363281 3 13 8.363281 13 15 L 13 20 L 9 20 C 7.300781 20 6 21.300781 6 23 L 6 47 C 6 48.699219 7.300781 50 9 50 L 41 50 C 42.699219 50 44 48.699219 44 47 L 44 23 C 44 21.300781 42.699219 20 41 20 L 37 20 L 37 15 C 37 8.363281 31.636719 3 25 3 Z M 25 5 C 30.566406 5 35 9.433594 35 15 L 35 20 L 15 20 L 15 15 C 15 9.433594 19.433594 5 25 5 Z M 25 30 C 26.699219 30 28 31.300781 28 33 C 28 33.898438 27.601563 34.6875 27 35.1875 L 27 38 C 27 39.101563 26.101563 40 25 40 C 23.898438 40 23 39.101563 23 38 L 23 35.1875 C 22.398438 34.6875 22 33.898438 22 33 C 22 31.300781 23.300781 30 25 30 Z"></path>
												</svg>
											<?php  } ?>
											<span class="uat-db-reg-heading-text"><?php _e('Register Your Website', 'ultimate-auction-pro-software'); ?></span>
											<span class="uat-db-card-heading-badge uat-db-card-heading-badge-howto">
												<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
													<path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
												</svg>
												<span class="uat-db-card-heading-badge-text"><?php _e('How To?', 'ultimate-auction-pro-software'); ?></span>
											</span>
										</h2>
										<div class="uat-db-reg-form-container activation-form">
											<p class="uat-db-reg-text">
											<?php echo sprintf( __( 'Thank you for choosing %s! Your product must be activated to receive theme updates and included premium modules. Please enter a valid License Key.', 'ultimate-auction-pro-software' ),'Ultimate Auction Pro Software' );?></p> 
											
											<form method="post" action="options.php">
												<?php settings_fields($this->theme_slug . '-license'); ?>
												<div class="activation-uat-form">
													<div class="form-lable">
														<?php echo $strings['license-key']; ?>
													</div>
													<div class="d-flex-form">
														<div class="input-form">
															<input id="<?php echo esc_attr($this->theme_slug); ?>_license_key" name="<?php echo $this->theme_slug; ?>_license_key" type="text" class="regular-text" value="<?php echo esc_attr($license); ?>" />
															<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
																<style type="text/css">
																	.st0 {
																		fill: #AAAEB2;
																	}
																</style>
																<path class="st0" d="M15.9,49.9c8.8,0.1,16-7.1,16.1-15.9c0-2-0.4-3.8-1-5.6L49.8,9.9l0.3-0.3l0-6.8l-0.3-0.3l-2-2l-0.3-0.3l-6.8,0
															l-0.3,0.3l-3,3l-0.3,0.3l0,2.4l-2.4,0l-0.3,0.3l-3,3l-0.3,0.3l0,1.4l-1.4,0l-0.3,0.3l-2,2l-0.3,0.3l0,1.4l-1.4,0l-0.3,0.3L21.6,19
															C19.9,18.4,18,18,16,17.9C7.2,17.9,0,25-0.1,33.9C-0.1,42.7,7,49.9,15.9,49.9z M15.9,47.9c-7.7,0-14-6.3-13.9-14.1
															c0-7.7,6.3-14,14.1-13.9c1.9,0,3.7,0.4,5.4,1.1c0,0,0,0,0,0c5,2.2,8.5,7.2,8.5,13C29.9,41.8,23.6,48,15.9,47.9z M15.9,44.9
															c2.8,0,5.6-1,7.8-3.2l0.7-0.7l-0.7-0.7L9.6,26.1l-0.7-0.7l-0.7,0.7c-4.3,4.3-4.4,11.3-0.1,15.6C10.3,43.8,13.1,44.9,15.9,44.9z
															M15.9,42.9c-2.3,0-4.6-0.9-6.4-2.7C6.3,37,6.2,31.9,9,28.4l12.4,12.5C19.8,42.2,17.9,43,15.9,42.9z M30.1,26.5
															c-1.5-2.8-3.8-5.1-6.6-6.6l2.9-2.9l2.6,0l0-2.6l1.4-1.4l2.6,0l0-2.6l2.5-2.4l3.6,0l0-3.6l2.5-2.4l5.1,0l1,1L31,19.6
															c-0.4,0.3-0.5,0.8-0.2,1.2c0.2,0.4,0.7,0.6,1.2,0.5c0.2,0,0.4-0.1,0.5-0.3L48.1,5.5l0,3.2L30.1,26.5z"></path>
															</svg>
														</div>
														<div class="uat-form-activation-msg">
															<?php if ('valid' === $status) {	?>
																<div class="active-msg"><?php echo $message; ?></div>
															<?php } else { ?>
																<div class="inactive-msg"><?php echo $message; ?></div>
															<?php } ?>
														</div>
														<?php
														wp_nonce_field($this->theme_slug . '_nonce', $this->theme_slug . '_nonce');
														if ($license) {
															if ('valid' === $status) {
														?>
																<div class="input-button">
																	<input type="submit" class="button-secondary" name="<?php echo esc_attr($this->theme_slug); ?>_license_deactivate" value="<?php echo esc_attr($strings['deactivate-license']); ?>" />
																	<div class="wrapper-tootltip">
																		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
																			<path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
																		</svg>
																		<div class="tooltip"><?php _e('This button is used to Deactivate License for theme', 'ultimate-auction-pro-software'); ?></div>
																	</div>
																</div>
															<?php  } else {  ?>
																<div class="ua-button-cover">
																	<div class="input-button">
																		<input type="submit" class="button-secondary" name="submit" id="submit" class="button button-primary" value="Register License">
																		<div class="wrapper-tootltip">
																			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
																				<path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
																			</svg>
																			<div class="tooltip"><?php _e('This button is used to register/update License key for theme', 'ultimate-auction-pro-software'); ?></div>
																		</div>
																	</div>
																	<div class="input-button">
																		<input type="submit" class="button-secondary" name="<?php echo esc_attr($this->theme_slug); ?>_license_activate" value="<?php echo esc_attr($strings['activate-license']); ?>" />
																		<div class="wrapper-tootltip">
																			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
																				<path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
																			</svg>
																			<div class="tooltip"><?php _e('This button is used to Activate License for theme', 'ultimate-auction-pro-software'); ?></div>
																		</div>
																	</div>
																</div>
															<?php
															}
														} else {
															?>
															<div class="input-button">
																<input type="submit" class="button-secondary" name="submit" id="submit" class="button button-primary" value="Register License">
																<div class="wrapper-tootltip">
																	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 14px;">
																		<path d="M 12 2 C 6.4889971 2 2 6.4889971 2 12 C 2 17.511003 6.4889971 22 12 22 C 17.511003 22 22 17.511003 22 12 C 22 6.4889971 17.511003 2 12 2 z M 12 4 C 16.430123 4 20 7.5698774 20 12 C 20 16.430123 16.430123 20 12 20 C 7.5698774 20 4 16.430123 4 12 C 4 7.5698774 7.5698774 4 12 4 z M 12 6 C 9.79 6 8 7.79 8 10 L 10 10 C 10 8.9 10.9 8 12 8 C 13.1 8 14 8.9 14 10 C 14 12 11 12.367 11 15 L 13 15 C 13 13.349 16 12.5 16 10 C 16 7.79 14.21 6 12 6 z M 11 16 L 11 18 L 13 18 L 13 16 L 11 16 z"></path>
																	</svg>
																	<div class="tooltip"><?php _e('This button is used to register/update License key for theme', 'ultimate-auction-pro-software'); ?></div>
																</div>
															</div>
														<?php
														}
														?>
													</div>
												</div>
											</form>

											<?php 
											$active_theme_slug = get_stylesheet();
											if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {
												$updater_child = new EDD_Child_Theme_Updater_Admin(
													// Config settings
													array(
														'remote_api_url' => EDD_UAT_STORE_URL, // Site where EDD is hosted
														'item_name'      => EDD_UAT__CHILD_THEME_NAME, // Name of theme
														'theme_slug'     => get_template(), // Theme slug
														'version'        => '1.0.0', // The current version of this theme
														'author'         => 'Nitesh Singh', // The author of this theme
														'download_id'    => '', // Optional, used for generating a license renewal link
														'renew_url'      => '', // Optional, allows for a custom license renewal link
														'beta'           => false, // Optional, set to true to opt into beta versions
														'item_id'        => '',
													),
													// Strings
													array(
														'theme-license'             => __( 'Theme License', "ultimate-auction-pro-software" ),
														'enter-key'                 => __( 'Enter your theme license key.', "ultimate-auction-pro-software" ),
														'license-key'               => __( 'Ultimate Auction Pro Vehicle Software - License Key', "ultimate-auction-pro-software" ),
														'license-action'            => __( 'License Action', "ultimate-auction-pro-software" ),
														'deactivate-license'        => __( 'Deactivate License', "ultimate-auction-pro-software" ),
														'activate-license'          => __( 'Activate License', "ultimate-auction-pro-software" ),
														'status-unknown'            => __( 'License status is unknown.', "ultimate-auction-pro-software" ),
														'renew'                     => __( 'Renew?', "ultimate-auction-pro-software" ),
														'unlimited'                 => __( 'unlimited', "ultimate-auction-pro-software" ),
														'license-key-is-active'     => __( 'License key is active.', "ultimate-auction-pro-software" ),
														/* translators: the license expiration date */
														'expires%s'                 => __( 'Expires %s.', "ultimate-auction-pro-software" ),
														'expires-never'             => __( 'Lifetime License.', "ultimate-auction-pro-software" ),
														/* translators: 1. the number of sites activated 2. the total number of activations allowed. */
														'%1$s/%2$-sites'            => __( 'You have %1$s / %2$s sites activated.', "ultimate-auction-pro-software" ),
														'activation-limit'          => __( 'Your license key has reached its activation limit.', "ultimate-auction-pro-software" ),
														/* translators: the license expiration date */
														'license-key-expired-%s'    => __( 'License key expired %s.', "ultimate-auction-pro-software" ),
														'license-key-expired'       => __( 'License key has expired.', "ultimate-auction-pro-software" ),
														/* translators: the license expiration date */
														'license-expired-on'        => __( 'Your license key expired on %s.', "ultimate-auction-pro-software" ),
														'license-keys-do-not-match' => __( 'License keys do not match.', "ultimate-auction-pro-software" ),
														'license-is-inactive'       => __( 'License is inactive.', "ultimate-auction-pro-software" ),
														'license-key-is-disabled'   => __( 'License key is disabled.', "ultimate-auction-pro-software" ),
														'license-key-invalid'       => __( 'Invalid license.', "ultimate-auction-pro-software" ),
														'site-is-inactive'          => __( 'Site is inactive.', "ultimate-auction-pro-software" ),
														/* translators: the theme name */
														'item-mismatch'             => __( 'This appears to be an invalid license key for %s.', "ultimate-auction-pro-software" ),
														'license-status-unknown'    => __( 'License status is unknown.', "ultimate-auction-pro-software" ),
														'update-notice'             => __( "Updating this theme will lose any customizations you have made. 'Cancel' to stop, 'OK' to update.", "ultimate-auction-pro-software" ),
														'error-generic'             => __( 'An error occurred, please try again.', "ultimate-auction-pro-software" ),
													)
												);

												// Call the license_page function
												$updater_child->license_page_child();
											}
											?>



										</div>
									</section>
								</div>
							</div>
						</div>
						<script>
							var url_hsh = window.location.hash;
							jQuery(document).ready(function() {
								jQuery(".reset-button").click(function() {
									location.reload(true);
								});
							});

							function openTab(evt, cityName) {
								var i, tabcontent, tablinks;
								tabcontent = document.getElementsByClassName("tabcontent");
								for (i = 0; i < tabcontent.length; i++) {
									tabcontent[i].style.display = "none";
								}
								tablinks = document.getElementsByClassName("tablinks");
								for (i = 0; i < tablinks.length; i++) {
									tablinks[i].className = tablinks[i].className.replace(" rsssl-active", "");
								}
								document.getElementById(cityName).style.display = "block";
								evt.currentTarget.className += " rsssl-active";
							}
							//url_hsh = url_hsh.substring(1);
							//console.log(url_hsh);
							if (url_hsh !== '') {
								var importDemoLink = document.querySelector('a[href="'+url_hsh+'"]');
								console.log(url_hsh);
								importDemoLink.click();
							} else {
								document.getElementById("defaultOpen").click();
							}

							//document.getElementById("defaultOpen").click();
						</script>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	public function register_option()
	{
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key',
			array($this, 'sanitize_license')
		);
	}

	/**
	 * Sanitizes the license key.
	 *
	 * since 1.0.0
	 *
	 * @param string $new License key that was submitted.
	 * @return string $new Sanitized license key.
	 */
	public function sanitize_license($new)
	{

		$old = get_option($this->theme_slug . '_license_key');

		if ($old && $old !== $new) {
			// New license has been entered, so must reactivate
			delete_option($this->theme_slug . '_license_key_status');
			delete_transient($this->theme_slug . '_license_message');
		}

		return $new;
	}

	/**
	 * Makes a call to the API.
	 *
	 * @since 1.0.0
	 *
	 * @param array $api_params to be used for wp_remote_get.
	 * @return array $response decoded JSON response.
	 */
	public function get_api_response($api_params)
	{

		// Call the custom API.
		$verify_ssl = (bool) apply_filters('edd_sl_api_request_verify_ssl', true);
		$response   = wp_remote_post(
			$this->remote_api_url,
			array(
				'timeout'   => 15,
				'sslverify' => $verify_ssl,
				'body'      => $api_params,
			)
		);

		return $response;
	}

	/**
	 * Activates the license key.
	 *
	 * @since 1.0.0
	 */
	public function activate_license()
	{

		$license = trim(get_option($this->theme_slug . '_license_key'));

		// Data to send in our API request.
		$api_params = array(
			'edd_action'  => 'activate_license',
			'license'     => $license,
			'item_name'   => urlencode($this->item_name),
			'url'         => home_url(),
			'item_id'     => $this->item_id,
			'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
		);

		$response = $this->get_api_response($api_params);

		// make sure the response came back okay
		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

			if (is_wp_error($response)) {
				$message = $response->get_error_message();
			} else {
				$message = $this->strings['error-generic'];
			}

			//$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
			$base_url = admin_url('admin.php?page=ua-auctions-theme#ua-license');
			$redirect = add_query_arg(
				array(
					'sl_theme_activation' => 'false',
					'message'             => urlencode($message),
				),
				$base_url
			);

			wp_redirect($redirect);
			exit();
		} else {

			$license_data = json_decode(wp_remote_retrieve_body($response));

			if (false === $license_data->success) {

				switch ($license_data->error) {

					case 'expired':
						$message = sprintf(
							$this->strings['license-expired-on'],
							date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
						);
						break;

					case 'disabled':
					case 'revoked':
						$message = $this->strings['license-key-is-disabled'];
						break;

					case 'missing':
						$message = $this->strings['license-key-invalid'];
						break;

					case 'invalid':
					case 'site_inactive':
						$message = $this->strings['site-is-inactive'];
						break;

					case 'item_name_mismatch':
						$message = sprintf($this->strings['item-mismatch'], $this->item_name);
						break;

					case 'no_activations_left':
						$message = $this->strings['activation-limit'];
						break;

					default:
						$message = $this->strings['error-generic'];
						break;
				}

				if (!empty($message)) {
					//$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
					$base_url = admin_url('admin.php?page=ua-auctions-theme#ua-license');
					$redirect = add_query_arg(
						array(
							'sl_theme_activation' => 'false',
							'message'             => urlencode($message),
						),
						$base_url
					);

					wp_redirect($redirect);
					exit();
				}
			}
		}

		// $response->license will be either "active" or "inactive"
		if ($license_data && isset($license_data->license)) {
			update_option($this->theme_slug . '_license_key_status', $license_data->license);
			delete_transient($this->theme_slug . '_license_message');
		}

		wp_redirect(admin_url('admin.php?page=ua-auctions-theme#ua-license'));
		exit();
	}

	/**
	 * Deactivates the license key.
	 *
	 * @since 1.0.0
	 */
	public function deactivate_license()
	{

		// Retrieve the license from the database.
		$license = trim(get_option($this->theme_slug . '_license_key'));

		// Data to send in our API request.
		$api_params = array(
			'edd_action'  => 'deactivate_license',
			'license'     => $license,
			'item_name'   => rawurlencode($this->item_name),
			'url'         => home_url(),
			'item_id'     => $this->item_id,
			'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
		);

		$response = $this->get_api_response($api_params);

		// make sure the response came back okay
		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

			if (is_wp_error($response)) {
				$message = $response->get_error_message();
			} else {
				$message = $this->strings['error-generic'];
			}

			$base_url = admin_url('themes.php?page=' . $this->theme_slug . '-license');
			$base_url = admin_url('admin.php?page=ua-auctions-theme#ua-license');
			$redirect = add_query_arg(
				array(
					'sl_theme_activation' => 'false',
					'message'             => urlencode($message),
				),
				$base_url
			);

			wp_redirect($redirect);
			exit();
		} else {

			$license_data = json_decode(wp_remote_retrieve_body($response));

			// $license_data->license will be either "deactivated" or "failed"
			if ($license_data && ($license_data->license == 'deactivated')) {
				delete_option($this->theme_slug . '_license_key_status');
				delete_transient($this->theme_slug . '_license_message');
			}
		}

		if (!empty($message)) {
			//$base_url = admin_url( 'themes.php?page=' . $this->theme_slug . '-license' );
			$base_url = admin_url('admin.php?page=ua-auctions-theme#ua-license');
			$redirect = add_query_arg(
				array(
					'sl_theme_activation' => 'false',
					'message'             => urlencode($message),
				),
				$base_url
			);

			wp_redirect($redirect);
			exit();
		}

		//wp_redirect( admin_url( 'admin.php?page=ua-auctions-theme' ));

		wp_redirect(admin_url('admin.php?page=ua-auctions-theme#ua-license'));
		exit();
	}

	/**
	 * Constructs a renewal link
	 *
	 * @since 1.0.0
	 */
	public function get_renewal_link()
	{

		// If a renewal link was passed in the config, use that
		if ('' !== $this->renew_url) {
			return $this->renew_url;
		}

		// If download_id was passed in the config, a renewal link can be constructed
		$license_key = trim(get_option($this->theme_slug . '_license_key', false));
		if ('' !== $this->download_id && $license_key) {
			$url  = esc_url($this->remote_api_url);
			$url .= '/checkout/?edd_license_key=' . urlencode($license_key) . '&download_id=' . urlencode($this->download_id);
			return $url;
		}

		// Otherwise return the remote_api_url
		return $this->remote_api_url;
	}

	/**
	 * Checks if a license action was submitted.
	 *
	 * @since 1.0.0
	 */
	public function license_action()
	{

		if (isset($_POST[$this->theme_slug . '_license_activate'])) {
			if (check_admin_referer($this->theme_slug . '_nonce', $this->theme_slug . '_nonce')) {
				$this->activate_license();
			}
		}

		if (isset($_POST[$this->theme_slug . '_license_deactivate'])) {
			if (check_admin_referer($this->theme_slug . '_nonce', $this->theme_slug . '_nonce')) {
				$this->deactivate_license();
			}
		}
	}

	/**
	 * Checks if license is valid and gets expire date.
	 *
	 * @since 1.0.0
	 *
	 * @return string $message License status message.
	 */
	public function check_license()
	{

		$license = trim(get_option($this->theme_slug . '_license_key'));
		$strings = $this->strings;

		$api_params = array(
			'edd_action'  => 'check_license',
			'license'     => $license,
			'item_name'   => rawurlencode($this->item_name),
			'url'         => home_url(),
			'item_id'     => $this->item_id,
			'environment' => function_exists('wp_get_environment_type') ? wp_get_environment_type() : 'production',
		);

		$response = $this->get_api_response($api_params);

		// make sure the response came back okay
		if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

			if (is_wp_error($response)) {
				$message = $response->get_error_message();
			} else {
				$message = $strings['license-status-unknown'];
			}

			$base_url = admin_url('themes.php?page=' . $this->theme_slug . '-license');
			$redirect = add_query_arg(
				array(
					'sl_theme_activation' => 'false',
					'message'             => urlencode($message),
				),
				$base_url
			);

			wp_redirect($redirect);
			exit();
		} else {

			$license_data = json_decode(wp_remote_retrieve_body($response));

			// If response doesn't include license data, return
			if (!isset($license_data->license)) {
				$message = $strings['license-status-unknown'];
				return $message;
			}

			// We need to update the license status at the same time the message is updated
			if ($license_data && isset($license_data->license)) {
				update_option($this->theme_slug . '_license_key_status', $license_data->license);
			}

			// Get expire date
			$expires = false;
			if (isset($license_data->expires) && 'lifetime' != $license_data->expires) {
				$expires    = date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')));
				$renew_link = '<a href="' . esc_url($this->get_renewal_link()) . '" target="_blank">' . $strings['renew'] . '</a>';
			} elseif (isset($license_data->expires) && 'lifetime' == $license_data->expires) {
				$expires = 'lifetime';
			}

			// Get site counts
			$site_count    = $license_data->site_count;
			$license_limit = $license_data->license_limit;

			// If unlimited
			if (0 === $license_limit) {
				$license_limit = $strings['unlimited'];
			}

			if ('valid' === $license_data->license) {
				$message = $strings['license-key-is-active'] . ' ';
				if (isset($expires) && 'lifetime' != $expires) {
					$message .= sprintf($strings['expires%s'], $expires) . ' ';
				}
				if (isset($expires) && 'lifetime' == $expires) {
					$message .= $strings['expires-never'];
				}
				if ($site_count && $license_limit) {
					$message .= sprintf($strings['%1$s/%2$-sites'], $site_count, $license_limit);
				}
			} elseif ('expired' === $license_data->license) {
				if ($expires) {
					$message = sprintf($strings['license-key-expired-%s'], $expires);
				} else {
					$message = $strings['license-key-expired'];
				}
				if ($renew_link) {
					$message .= ' ' . $renew_link;
				}
			} elseif ('invalid' === $license_data->license) {
				$message = $strings['license-keys-do-not-match'];
			} elseif ('inactive' === $license_data->license) {
				$message = $strings['license-is-inactive'];
			} elseif ('disabled' === $license_data->license) {
				$message = $strings['license-key-is-disabled'];
			} elseif ('site_inactive' === $license_data->license) {
				// Site is inactive
				$message = $strings['site-is-inactive'];
			} else {
				$message = $strings['license-status-unknown'];
			}
		}

		return $message;
	}

	/**
	 * Disable requests to wp.org repository for this theme.
	 *
	 * @since 1.0.0
	 */
	public function disable_wporg_request($r, $url)
	{

		// If it's not a theme update request, bail.
		if (0 !== strpos($url, 'https://api.wordpress.org/themes/update-check/1.1/')) {
			return $r;
		}

		// Decode the JSON response
		$themes = json_decode($r['body']['themes']);

		// Remove the active parent and child themes from the check
		$parent = get_option('template');
		$child  = get_option('stylesheet');
		unset($themes->themes->$parent);
		unset($themes->themes->$child);

		// Encode the updated JSON response
		$r['body']['themes'] = json_encode($themes);

		return $r;
	}
}

/**
 * This is a means of catching errors from the activation method above and displyaing it to the customer
 */
function edd_sample_theme_admin_notices()
{
	if (isset($_GET['sl_theme_activation']) && !empty($_GET['message'])) {

		switch ($_GET['sl_theme_activation']) {

			case 'false':
				$message = urldecode($_GET['message']);
		?>
				<div class="error">
					<p><?php echo $message; ?></p>
				</div>
<?php
				break;

			case 'true':
			default:
				break;
		}
	}
}
add_action('admin_notices', 'edd_sample_theme_admin_notices');
