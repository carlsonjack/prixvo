<?php

function uat_auctions_custom_fields_add($data){
    // Check for current user privileges
    if (!current_user_can('manage_options')) {
        return false;
    }

    // Check if we are in WP-Admin
    if (!is_admin()) {
        return false;
    }
	$response = [
	"status"=>false,
	"message"=>__('Failed to add Custom Field', 'ultimate-auction-pro-software')];
	$attribute_name = $_REQUEST['cf_name'];
	$attribute_type = $_REQUEST['cf_type'];
	$attribute_options = $_REQUEST['cf_options'];
	$field_slug = sanitize_title($attribute_name);
	$check_field_exists = check_uat_custom_field_exists($attribute_name,$attribute_type);
	if(empty($attribute_name))
	{
		$response["message"] = __('Please Enter Field Name', 'ultimate-auction-pro-software');
	}elseif($check_field_exists=== True){
		$response["message"] = __('The field already exists please use a different field', 'ultimate-auction-pro-software');
	}
	else{
		global $wpdb;
		$query   ="SELECT * FROM `".$wpdb->prefix."ua_custom_fields`";
		$results = $wpdb->get_results( $query );
		$count_rows = count($results);
		$attribute_order = $count_rows + 1;
		$custom_fields['attribute_name'] = $attribute_name;
		$custom_fields['attribute_type'] = $attribute_type;
		$custom_fields['attribute_slug'] =$field_slug;
		$custom_fields['form_order'] = $attribute_order;

		$wpdb->insert($wpdb->prefix.'ua_custom_fields',$custom_fields);
		$field_id = $wpdb->insert_id;
		if($attribute_type == 'select'){
			$serialized_options = serialize($attribute_options);
		}else{
			$serialized_options = "";
		}
		$custom_fields_attributes['field_id'] =$field_id;
		$custom_fields_attributes['meta_key'] = 'select_values';
		$custom_fields_attributes['meta_value'] = $serialized_options;
		$wpdb->insert($wpdb->prefix.'ua_custom_fields_options',$custom_fields_attributes);

		$response = [
		"status"=>true,
		"message"=>__('Custom Field Added', 'ultimate-auction-pro-software')
		];
	}
	echo json_encode( $response );
	exit;
	// wp_die();
}
add_action('wp_ajax_nopriv_uat_auctions_custom_fields_add', 'uat_auctions_custom_fields_add');
add_action('wp_ajax_uat_auctions_custom_fields_add', 'uat_auctions_custom_fields_add');


function uat_update_custom_field($data){
    global $wpdb;
	// Check for current user privileges
    if (!current_user_can('manage_options')) {
        return false;
    }
    // Check if we are in WP-Admin
    if (!is_admin()) {
        return false;
    }
	$response = [
	"status"=>false,
	"message"=>__('Failed to Update Custom Field', 'ultimate-auction-pro-software')];
	$attribute_name = $_REQUEST['cf_name'];
	$attribute_type = $_REQUEST['cf_type'];
	$attribute_options = $_REQUEST['cf_options'];
	$cf_edit_id = $_REQUEST['cf_edit_id'];
	$check_field_exists = check_uat_custom_field_exists($attribute_name,$attribute_type);
	if(empty($attribute_name))
	{
		$response["message"] = __('Please Enter Field Name', 'ultimate-auction-pro-software');
	}elseif($check_field_exists=== True && empty($cf_edit_id)){
		$response["message"] = __('The field already exists please use a different field', 'ultimate-auction-pro-software');
	} else{
		// 
		$custom_fields=array();
		$custom_fields['attribute_name'] = $attribute_name;
		$custom_fields['attribute_type'] = $attribute_type;		
		$where = [ 'id' => $cf_edit_id ]; // NULL value in WHERE clause.

		$wpdb->update( $wpdb->prefix . 'ua_custom_fields', $custom_fields, $where );

		if($attribute_type == 'select'){
			$serialized_options = serialize($attribute_options);
		}else{
			$serialized_options = "";
		}
		$where = [ 'field_id' => $cf_edit_id, 'meta_key' => 'select_values' ];
		$custom_fields_attributes['meta_value'] = $serialized_options;
		$wpdb->update($wpdb->prefix.'ua_custom_fields_options',$custom_fields_attributes, $where);

		$response = [
		"status"=>true,
		"message"=>__('Custom Field Updated', 'ultimate-auction-pro-software')
		];
	}
	echo json_encode( $response );
	exit;
	// wp_die();
}
add_action('wp_ajax_nopriv_update_custom_field', 'uat_update_custom_field');
add_action('wp_ajax_update_custom_field', 'uat_update_custom_field');



function check_uat_custom_field_exists($field_name,$field_type){
	global $wpdb;
	
	$field_slug = sanitize_title($field_name);	
	$query = "SELECT * FROM " . $wpdb->prefix . "ua_custom_fields where attribute_slug='". $field_slug ."' and  attribute_name='". $field_name ."'  and  attribute_type='". $field_type ."' ";
	$results = $wpdb->get_results( $query );		
	if(count($results) > 0){	
		return TRUE;
	}else{			
	   return FALSE;
	}	
}

function get_uat_auctions_custom_fields($data){
    // Check for current user privileges
    if (!current_user_can('manage_options')) {
        return false;
    }
   /* Check if we are in WP-Admin*/
    if (!is_admin()) {
        return false;
    }
	$ordered_ids = $_REQUEST['ordered_ids'];
	if(isset($ordered_ids)){
		if(!empty($ordered_ids)){
			update_custom_fields_order($ordered_ids);
		}
	}	
	$response = [
	"status"=>false,
	"message"=>__('No Custom Fields available', 'ultimate-auction-pro-software')];
	global $wpdb;
	$edit_id = $_REQUEST['edit_id'];
	$where = "";
	if(isset($edit_id)){
		if(!empty($edit_id)){
			$where = " where id=".$edit_id;
		}
	}

	$query   ="SELECT * FROM `".$wpdb->prefix."ua_custom_fields` $where order by form_order ASC";
	$results = $wpdb->get_results( $query );
	if(count($results) > 0)
	{	
		$data = $results;
		if($where != ""){
			$data = $results[0];
			if($data->attribute_type == 'select'){

				$query   ="SELECT meta_value FROM `".$wpdb->prefix."ua_custom_fields_options` where field_id=".$data->id." and meta_key = 'select_values' ";
				$results = $wpdb->get_var( $query );
					$data->options = unserialize($results);
			}
		}
		
		$response = [
				"status"=>true,
				"message"=>__('Custom Field Available', 'ultimate-auction-pro-software'),
				"data"=> $data
				];
		
	}


	echo json_encode( $response );
	exit;

}
add_action('wp_ajax_nopriv_uat_auctions_custom_fields_get', 'get_uat_auctions_custom_fields');
add_action('wp_ajax_uat_auctions_custom_fields_get', 'get_uat_auctions_custom_fields');


function uat_auctions_custom_fields_remove($data){
    /* Check for current user privileges*/
    if (!current_user_can('manage_options')) {
        return false;
    }

    // Check if we are in WP-Admin
    if (!is_admin()) {
        return false;
    }
	$response = [
				"status"=>false,
				"message"=>__('No Custom Fields available', 'ultimate-auction-pro-software')				
				];
	
	global $wpdb;
	$attribute_id = $_REQUEST['cf_id'];
	if(empty($attribute_id))
	{
		$response["message"] = __('Please select valid fields', 'ultimate-auction-pro-software');
	}else{
		$table_name = "`".$wpdb->prefix."ua_custom_fields`";
		$wpdb->query("DELETE FROM $table_name WHERE id=".$attribute_id);
		update_custom_fields_order();		
		$response = [
				"status"=>true,
				"message"=>__('Custom Field Deleted', 'ultimate-auction-pro-software')				
				];
	}


	echo json_encode( $response );
	exit;
	// wp_die();
}
add_action('wp_ajax_nopriv_uat_auctions_custom_fields_remove', 'uat_auctions_custom_fields_remove');
add_action('wp_ajax_uat_auctions_custom_fields_remove', 'uat_auctions_custom_fields_remove');


function update_custom_fields_order($orderIds = null){
	global $wpdb;
	if($orderIds != null)
	{
		$table_name = "`".$wpdb->prefix."ua_custom_fields`";
			$i = 1;
		foreach($orderIds as $key => $id){
			$q = "UPDATE $table_name SET `form_order` = ".$i." WHERE `id` = ".$id;
			$wpdb->query($q);
			$i++;
		}
	}else{
		$query   ="SELECT id FROM `".$wpdb->prefix."ua_custom_fields` order by form_order ASC";
		$results = $wpdb->get_results( $query );
		if(count($results) > 0)
		{
			$table_name = "`".$wpdb->prefix."ua_custom_fields`";
			$i = 1;
			foreach($results as $key){
				$q = "UPDATE $table_name SET `form_order` = ".$i." WHERE `id` = ".$key->id;
				$wpdb->query($q);
				$i++;
			}
		}
	}
}