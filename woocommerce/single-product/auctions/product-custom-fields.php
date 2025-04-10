<?php
$uat_custom_enable = get_option('uat_custom_enable', 'no');
if ($uat_custom_enable == "yes") {
	global $wpdb;
	global $product;
	$product_id = $product->get_id();
	$query = "SELECT meta_key FROM " . $wpdb->prefix . "postmeta where post_id='" . $product_id . "'  AND meta_key LIKE   'uat_custom_field_%' AND meta_value IS NOT NULL AND meta_value != ''";
	$result = $wpdb->get_results($query);
	$count_rows = $wpdb->num_rows;
	if ($count_rows > 0) {
?>
		<div class="lot-info">
			<div class="gray-box">
				<h2>
					<?php
					$uat_custom_fields_heading = get_option('uat_custom_fields_heading') ? get_option('uat_custom_fields_heading') : _e('Ultimate Auction Custom Fields:', 'ultimate-auction-pro-software'); ?>
					<?php echo $uat_custom_fields_heading; ?>
				</h2>
				<div class="info-row">
					<?php
					$uat_custom_fields_display_tabel =  get_option('uat_custom_fields_display_tabel', 2);
					$final_array = [];
					foreach ($result as $field_name) {
						$fields = get_field_object($field_name->meta_key);
						if (is_array($fields)) {

							if (!empty($fields)) {
								$one_array = [];
								$one_array['name'] = $fields['label'];
								$field_value = $fields['value'];
								if ($fields['type'] == 'select') {
									$field_value = $selected_value = $fields['choices'][$field_value];
								}
								$one_array['value'] = $field_value;
							}
							$final_array[] = $one_array;
						}
					}
					$data_count = count($final_array);
					for ($i = 0; $i < $uat_custom_fields_display_tabel; $i++) {
						for ($j = $i; $j < $data_count; $j += $uat_custom_fields_display_tabel) {
							$value = $final_array[$j]['value'];
							if (!empty($value)) {
								echo '<div class="info-row-text col-2"><label class="info-lable">' . $final_array[$j]['name'] . '</label><label class="info-lable-ans">' . $final_array[$j]['value'] . '</label></div>';
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	<?php } ?>
<?php } ?>