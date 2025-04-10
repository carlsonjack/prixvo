<?php

/**
 * Theme updater admin page and functions.
 *
 * @package EDD Sample Theme
 */



class EDD_Child_Theme_Updater_Admin
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
				'theme_slug'     => 'ultimate-auction-pro-vehicle-software',
				'item_name'      => 'Ultimate Auction Pro Vehicle Software - Child Theme',
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
		//do_action('post_edd_sl_theme_updater_setup', $config);

		// Set config arguments
		$this->remote_api_url = $config['remote_api_url'];
		$this->item_name      = $config['item_name'];
		$this->theme_slug     = sanitize_key('ultimate-auction-pro-vehicle-software');
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
		add_action('update_option_' . $this->theme_slug . '_license_key_child', array($this, 'activate_license'), 10, 2);
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
		if ('valid' !== get_option($this->theme_slug . '_license_key_child_status', false)) {
			return;
		}

		if (!class_exists('EDD_Child_Theme_Updater')) {
			// Load our custom theme updater
			include dirname(__FILE__) . '/child-theme-updater-class.php';
		}

		new EDD_Child_Theme_Updater(
			array(
				'remote_api_url' => $this->remote_api_url,
				'version'        => $this->version,
				'license'        => trim(get_option($this->theme_slug . '_license_key_child')),
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

		//add_submenu_page('ua-auctions-theme', __('Welcome | License', 'ultimate-auction-pro-software'), __('Welcome | License', 'ultimate-auction-pro-software'), 'manage_options', 'ua-auctions-theme', array($this, 'license_page'), 1);
	}

	/**
	 * Outputs the markup used on the theme license page.
	 *
	 * since 1.0.0
	 */
	public function license_page()
	{
			?>

		
		
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
					
				
		<?php
		
	}
	
	public function license_page_child()
	{	
		$strings = $this->strings;

$license = trim(get_option($this->theme_slug . '_license_key_child'));
$status  = get_option($this->theme_slug . '_license_key_child_status', false);

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
	
	<form method="post" action="options.php">
		<?php settings_fields($this->theme_slug . '-license'); ?>
		<div class="activation-uat-form">
			<div class="form-lable">
				<?php echo $strings['license-key']; ?>
			</div>
			<div class="d-flex-form">
				<div class="input-form">
					<input id="<?php echo esc_attr($this->theme_slug); ?>_license_key_child" name="<?php echo $this->theme_slug; ?>_license_key_child" type="text" class="regular-text" value="<?php echo esc_attr($license); ?>" />
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
	<?php }

	
	//add_action('child_theme_licence', 'child_theme_licece_reg');


	/**
	 * Registers the option used to store the license key in the options table.
	 *
	 * since 1.0.0
	 */
	public function register_option()
	{
		register_setting(
			$this->theme_slug . '-license',
			$this->theme_slug . '_license_key_child',
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

		$old = get_option($this->theme_slug . '_license_key_child');

		if ($old && $old !== $new) {
			// New license has been entered, so must reactivate
			delete_option($this->theme_slug . '_license_key_child_status');
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

		$license = trim(get_option($this->theme_slug . '_license_key_child'));

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
			update_option($this->theme_slug . '_license_key_child_status', $license_data->license);
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
		$license = trim(get_option($this->theme_slug . '_license_key_child'));

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
				delete_option($this->theme_slug . '_license_key_child_status');
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
		$license_key = trim(get_option($this->theme_slug . '_license_key_child', false));
		if ('' !== $this->download_id && $license_key) {
			$url  = esc_url($this->remote_api_url);
			$url .= '/checkout/?edd_license_key_child=' . urlencode($license_key) . '&download_id=' . urlencode($this->download_id);
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

		$license = trim(get_option($this->theme_slug . '_license_key_child'));
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
				update_option($this->theme_slug . '_license_key_child_status', $license_data->license);
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
function edd_sample_theme_admin_notices_child()
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
add_action('admin_notices', 'edd_sample_theme_admin_notices_child');
