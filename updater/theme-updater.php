<?php
/**
 * Easy Digital Downloads Theme Updater
 *
 * @package EDD Sample Theme
 */

// Includes the files needed for the theme updater
if ( ! class_exists( 'EDD_Theme_Updater_Admin' )) {
	include dirname( __FILE__ ) . '/theme-updater-admin.php';
}


// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'EDD_UAT_STORE_URL', 'https://getultimateauction.com/' );
// the name of your product. This should match the download name in EDD exactly
define( 'EDD_UAT_THEME_NAME', 'Ultimate Auction Pro Software - All Access' );

define( 'EDD_UAT__CHILD_THEME_NAME', 'Ultimate Auction Pro Vehicle Software - Child Theme' );

// Loads the updater classes
$updater = new EDD_Theme_Updater_Admin(
	// Config settings
	array(
		'remote_api_url' => EDD_UAT_STORE_URL, // Site where EDD is hosted
		'item_name'      => EDD_UAT_THEME_NAME, // Name of theme
		'theme_slug'     => get_template(), // Theme slug
		'version'        => '1.0.5', // The current version of this theme
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
		'license-key'               => __( 'Ultimate Auction Pro Software - License Key', "ultimate-auction-pro-software" ),
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

$active_theme_slug = get_stylesheet();
if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') {

// Include the file for the child theme updater
if (!class_exists('EDD_Child_Theme_Updater_Admin')) {
    include dirname(__FILE__) . '/child-theme-updater-admin.php';
}

// Loads the updater classes
$updater_child = new EDD_Child_Theme_Updater_Admin(
	// Config settings
	array(
		'remote_api_url' => EDD_UAT_STORE_URL, // Site where EDD is hosted
		'item_name'      => EDD_UAT__CHILD_THEME_NAME, // Name of theme
		'theme_slug'     => get_template(), // Theme slug
		'version'        => '1.0.5', // The current version of this theme
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

}