<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Admin Email Setting page
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
 ?>

<?php
	$email_slug ="email_setting";
	$email_type ="email_setting";
	if (isset($_POST['uat_email_form_nonce_field']) && wp_verify_nonce($_POST['uat_email_form_nonce_field'], 'uat_email_form_nonce')) {

		$admin_email = get_option('admin_email');
		$blogname = get_option('blogname');
		if (is_array($_POST)) {

			foreach ($_POST as $email_type => $email_form_data) {
				if (is_array($email_form_data)) {
					if (isset($email_form_data['uat_email_hidden_field'])) {
						//echo"<pre>";print_r($email_form_data);echo"</pre>";
						$email_template_details = array(
							'from_name' => (isset($email_form_data["from_name"]) ? $email_form_data["from_name"] : $blogname),
							'from_address' => (isset($email_form_data["from_address"]) ? $email_form_data["from_address"] : $admin_email),
							'h_image' => (isset($email_form_data["h_image"]) ? $email_form_data["h_image"] : ""),
							'footer_txt' => (isset($email_form_data["footer_txt"]) ? stripslashes($email_form_data["footer_txt"]) : ""),
							'base_color' => (isset($email_form_data["base_color"]) ? stripslashes($email_form_data["base_color"]) : ""),
							'bg_color' => (isset($email_form_data["bg_color"]) ? stripslashes($email_form_data["bg_color"]) : ""),
							'body_color' => (isset($email_form_data["body_color"]) ? stripslashes($email_form_data["body_color"]) : ""),
							'body_text_color' => (isset($email_form_data["body_text_color"]) ? stripslashes($email_form_data["body_text_color"]) : ""),
							'template' => (isset($email_form_data["template"]) ? $email_form_data["template"] : 'default'),

						);

						update_option("uat_email_template_" . $email_type, $email_template_details);
					}
				}
			}
		}
	}


$template_details = get_email_temaplte_from_db($email_slug);
$popupDLogo = get_field( 'uat_website_logo','options');
$popupLLogo = UAT_THEME_PRO_IMAGE_URI.'logo.png';
$popupLogo = !empty($popupDLogo) ? $popupDLogo : $popupLLogo;
$default_from_name = get_option( 'admin_email' );
$default_from_email = get_option( 'blogname' );

$template = isset($template_details['template']) ? $template_details['template'] : "default";
$from_name = isset($template_details['from_name']) ? $template_details['from_name'] : $default_from_name;
$from_address = isset($template_details['from_address']) ? $template_details['from_address'] : $default_from_email;
$h_image = isset($template_details['h_image']) ? $template_details['h_image'] : $popupLogo;
$footer_txt = isset($template_details['footer_txt']) ? $template_details['footer_txt'] : "{site_title} — Built with {Ultimate Auction Pro}";
$base_color = isset($template_details['base_color']) ? $template_details['base_color'] : "#96588a";
$bg_color = isset($template_details['bg_color']) ? $template_details['bg_color'] : "#f7f7f7";
$body_color = isset($template_details['body_color']) ? $template_details['body_color'] : "#ffffff";
$body_text_color = isset($template_details['body_text_color']) ? $template_details['body_text_color'] : "#3c3c3c";


$templates = array(
			'default' => __( 'Default Template', 'ultimate-auction-pro-software' ),
			'none'    => __( 'No template, plain text only', 'ultimate-auction-pro-software' ),
			'traditional'=> __( 'Traditional', 'ultimate-auction-pro-software' ),
			'lines'=> __( 'Lines', 'ultimate-auction-pro-software' ),
			'minimal'=> __( 'Minimal', 'ultimate-auction-pro-software' ),
			'customize'=> __( 'Customize', 'ultimate-auction-pro-software' ),
		);

?>
<form id="uat-email-setting-form" class="uat-<?php echo $email_slug;?>-email-setting-form" method="post" action="">
           <h3><?php _e("Email Configuration", "ultimate-auction-pro-software");?></h3>
           <table class="form-table">
           <tbody>

			<tr>
           		<th><label><?php _e('Header image', "ultimate-auction-pro-software");?></label></th>
           		<td><input class="regular-text" name="email_setting[h_image]" type="url" id="h_image"  value="<?php  echo esc_url($h_image); ?>" />
           		<div class="ult-auc-settings-tip"><?php _e("URL to an image you want to show in the email header. Upload images using the media uploader (Admin > Media).", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

			<tr>
           		<th><label><?php _e("Template", "ultimate-auction-pro-software");?></label></th>
           		<td>
				<select  name="email_setting[template]" id="uat_mail_temaplte" onchange="showDiv(this)">
				<?php
				foreach($templates as $key => $value){
				   $isSelected =""; //added this line
				   if($template == $key){
					 $isSelected = "selected";
				   }
				   echo '<option value="'.$key.'"'.$isSelected.'>'.$value.'</option>';
				} ?>

				</select>

           	    <div class="ult-auc-settings-tip"><?php _e('Choose a template. Click "Save Changes" then "Preview Email" to see the new template..', "ultimate-auction-pro-software");?></div>        </td>
           	</tr>


		   	<tr>
           		<th><label><?php _e('"From" name', "ultimate-auction-pro-software");?></label></th>
           		<td><input type="text" class="regular-text" id="from_name" name="email_setting[from_name]"  value="<?php echo esc_attr($from_name); ?>" />
           	    <div class="ult-auc-settings-tip"><?php _e("How the sender name appears in outgoing emails.", "ultimate-auction-pro-software");?></div>        </td>
           	</tr>
           <tr>
           		<th><label><?php _e('"From" address', "ultimate-auction-pro-software");?></label></th>
           		<td><input class="regular-text" name="email_setting[from_address]" type="email" id="from_address"  value="<?php  echo esc_attr($from_address); ?>" />
           		<div class="ult-auc-settings-tip"><?php _e("How the sender email appears in outgoing emails.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

		   <tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Footer text', "ultimate-auction-pro-software");?></label></th>
           		<td>
				<textarea id="footer_txt" name="email_setting[footer_txt]" rows="4" cols="50"><?php  echo $footer_txt; ?></textarea>
           		<div class="ult-auc-settings-tip"><?php _e("The text to appear in the footer of all Auction emails. Available placeholders: {site_title} {site_url}", "ultimate-auction-pro-software");?>	</div>
           		</td>
           	</tr>
		   <tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Base color', "ultimate-auction-pro-software");?></label></th>
           		<td>
				<input id="base_color"name="email_setting[base_color]"  value="<?php  echo esc_attr($base_color); ?>" type="text"  data-default-color="#96588a" />
           		<div class="ult-auc-settings-tip"><?php _e("The base color for Auction emails templates. Default #96588a.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

			<tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Background color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="bg_color" name="email_setting[bg_color]" value="<?php  echo esc_attr($bg_color); ?>" type="text"  data-default-color="#f7f7f7" />

           		<div class="ult-auc-settings-tip"><?php _e("The background color for WooCommerce email templates. Default #f7f7f7.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

			<tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Body background color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="body_color" name="email_setting[body_color]" type="text" value="<?php  echo esc_attr($body_color); ?>" data-default-color="#ffffff" />
           		<div class="ult-auc-settings-tip"><?php _e("The main body background color. Default #ffffff.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

		  <tr class="show_custom_temp" style="display:none;">
           		<th><label><?php _e('Body text color', "ultimate-auction-pro-software");?></label></th>
           		<td><input id="body_text_color" name="email_setting[body_text_color]" type="text" value="<?php  echo esc_attr($body_text_color); ?>" data-default-color="#3c3c3c" />
           		<div class="ult-auc-settings-tip"><?php _e("The main body text color. Default #3c3c3c.", "ultimate-auction-pro-software");?></div>
           		</td>
           	</tr>

           </tbody>
           </table>
       <?php 	echo get_email_save_nonce_field($email_slug); ?>
	   

	</form>
<?php wp_enqueue_script( 'jquery-color-picker', UAT_THEME_PRO_JS_URI . 'color-picker.js', array('wp-color-picker'), UAT_THEME_PRO_VERSION); ?>
	<script type="text/javascript">
	jQuery(document).ready(function($){
		var objSelect = document.getElementById("uat_mail_temaplte");
		showDiv(objSelect);
	});
	function showDiv(select){
		   if(select.value=='customize'){
			jQuery("tr.show_custom_temp").show();
		   } else{
			jQuery("tr.show_custom_temp").hide();
		   }
	}

	(function( $ ) { 
				// Add Color Picker to all inputs that have 'color-field' id
				$(function() {
					$('#base_color').wpColorPicker();
					$('#bg_color').wpColorPicker();
					$('#body_bg_color').wpColorPicker();
					$('#body_text_color').wpColorPicker();
					$('#body_color').wpColorPicker();
				});				 
	})( jQuery );

	</script>