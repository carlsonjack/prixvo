<?php
/* Get Active theme slug */
$active_theme_slug = get_stylesheet();



if (isset($_POST['uat-custom-settings-submit']) == 'Save Option') {
	if (isset($_POST['uat_custom_enable'])) {
		update_option('uat_custom_enable', "yes");
	} else {
		update_option('uat_custom_enable', "no");
	}

	if (isset($_POST['uat_custom_fields_heading'])) {
		update_option('uat_custom_fields_heading', sanitize_text_field($_POST['uat_custom_fields_heading']));
	}

	if (isset($_POST['uat_custom_fields_display_position'])) {
		$is_updated = update_option('uat_custom_fields_display_position', sanitize_text_field($_POST['uat_custom_fields_display_position']));
	}

	if (isset($_POST['uat_custom_fields_display_tabel_no_of_row'])) {
		update_option('uat_custom_fields_display_tabel', sanitize_text_field($_POST['uat_custom_fields_display_tabel_no_of_row']));
	}
}
?>
<div class="wrap welcome-wrap uat-admin-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uwa_admin_page_title"><?php _e('Ultimate Auction Pro Software Custom Fields', 'ultimate-auction-pro-software') ?></h1>
	<div class="uat_theme_page_nav">
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

					<?php if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') { ?>
						<a href="?page=acf-options-default-fields&uat-custom-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label']; ?></a>
					<?php } ?>


				<?php }else{ ?>
				

					<a href="?page=ua-auctions-theme-custom-fields&uat-custom-tab=<?php echo $tab['slug']; ?>&range=<?php echo $tab['range']; ?>" class="nav-tab <?php echo $active_tab == $tab['slug'] ? 'nav-tab-active' : ''; ?>"><?php echo $tab['label']; ?></a>
				
				<?php } ?>
			
				
				
			<?php } ?>
		</h2>
	</div>
	<?php
	$active_theme_slug = get_stylesheet();
	if (isset($_GET['range']) && $_GET['range'] == 'fields') {
		include_once(UAT_THEME_PRO_ADMIN . 'custom-fields/custom-fields-list.php');
	}else {
	?>
		<div class='custom_fields_option_setting_style'>
			<h2><?php _e('Dynamic Custom Fields Setting Option:', 'ultimate-auction-pro-software') ?></h2>

			<?php
			$uat_custom_enable = get_option('uat_custom_enable', 'no');
			$uat_custom_fields_heading = get_option('uat_custom_fields_heading', 'Ultimate Auction Custom Fields');
			$uat_custom_fields_display_position = get_option("uat_custom_fields_display_position", "top");
			$uat_custom_fields_display_tabel_no_of_row = get_option("uat_custom_fields_display_tabel", "2");
			?>

			<form method='post' class='custom_fields_option_setting_form'>
				<div class="mh-new-field__input-wrapper input-gr-row">
					<label for="field-type"><?php _e('Enable Custom Fields', 'ultimate-auction-pro-software') ?></label>
					<div class="input-gr">
						<input type="checkbox" <?php checked('yes', $uat_custom_enable); ?> name="uat_custom_enable" class="regular-number" value="1"><?php _e('Enable Custom Fields For Auction Products.', 'woo_ua'); ?>
					</div>
				</div>

				<?php if($active_theme_slug!='ultimate-auction-pro-vehicle-software'){ ?> 
				<div class="mh-new-field__input-wrapper input-gr-row">
					<label for="field-label"><?php _e(' Heading for custom fields on auction product detail page.', 'ultimate-auction-pro-software') ?></label>
					<input type="text" size="100" class="regular-text" name="uat_custom_fields_heading" id="uat_custom_fields_heading" value="<?php echo $uat_custom_fields_heading; ?>">
				</div>
				

				<div class="mh-new-field__input-wrapper input-gr-row">
					<label for="field-type"><?php _e('Where to show custom fields:', 'ultimate-auction-pro-software') ?></label>
					<div class="input-gr">
						<input type="radio" name="uat_custom_fields_display_position" value="top" <?php checked('top', $uat_custom_fields_display_position); ?>>
						<span class="description"><?php _e('Above "Auction Details" Section', 'ultimate-auction-pro-software');  ?></span>

						<input type="radio" name="uat_custom_fields_display_position" value="bottom" <?php checked('bottom', $uat_custom_fields_display_position); ?>>
						<span class="description"><?php _e('Below "Auction Details" Section', 'ultimate-auction-pro-software');  ?></span>
					</div>
				</div>
				
				
				<div class="mh-new-field__input-wrapper input-gr-row ">
					<label for="field-type"><?php _e('Choose number of columns for showing custom fields:', 'ultimate-auction-pro-software') ?></label>
				</div>
				<div class="mh-new-field__input-wrapper input-gr-row">
					<input type="number" name="uat_custom_fields_display_tabel_no_of_row" class="regular-number" min="1" id="uat_custom_fields_display_tabel_no_of_row" value="<?php echo $uat_custom_fields_display_tabel_no_of_row; ?>" min="1" max="3">

				</div>
				
				<?php } ?>
				<?php if($active_theme_slug=='ultimate-auction-pro-vehicle-software'){ ?>
				<?php /*<label for="field-type"><?php _e('Where to show custom fields:', 'ultimate-auction-pro-software') ?></label><br/> */ ?>
				<span class="description"><?php _e('Display custom fields on the Vehicle Details page, within the Vehicle Specification section.', 'ultimate-auction-pro-software');  ?></span>
				<?php } ?>
				<div class="mh-new-field__input-wrapper input-gr-row">
					<label></label>
					<input style="margin:0;" type="submit" id="uat-custom-settings-submit" name="uat-custom-settings-submit" class="button-primary btn-blue-save" value="<?php _e('Save Option', 'ultimate-auction-pro-software'); ?>" />

				</div>
			</form>
		</div>
	<?php } ?>

</div>