<?php
function update_custom_fields_get_acf(){
			global $wpdb;
			$query   ="SELECT * FROM `".$wpdb->prefix."ua_custom_fields` order by form_order ASC";
			 $results = $wpdb->get_results( $query );
			 $fields_array = [];
			if(count($results) > 0)
			{
				$i = 1;
				foreach($results as $field){
					$one_field = array(
						'key' => 'field_63076eaf0c5fb'.$field->id,
						'label' => $field->attribute_name,
						'name' => "uat_custom_field_".$field->attribute_slug,
						'type' => $field->attribute_type,
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					);
					if($field->attribute_type == "select"){
						$field_options = [];
						$query   ="SELECT meta_value FROM `".$wpdb->prefix."ua_custom_fields_options` where field_id=".$field->id." and meta_key = 'select_values' ";
						$results = $wpdb->get_var( $query );
						$select_values = unserialize($results);
						foreach($select_values as $k => $select_value){
							$slug = sanitize_title($select_value);
							$field_options[$slug] = $select_value;
						}
						if(!empty($field_options)){
							$one_field['choices'] = $field_options;
						}
					}
					$fields_array[] = $one_field;
					$i++;
				}
			}
			return $fields_array;
		}

		if( function_exists('acf_add_local_field_group') ):
			$custom_fields_array = [];
			$custom_fields_array[] = array(
				'key' => 'field_63076eaf0c5fb',
				'label' => 'Test 1',
				'name' => 'test_1',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			);
			$custom_fields_array[] = array(
				'key' => 'field_63076ed138b74',
				'label' => 'Test 2',
				'name' => 'test_2',
				'type' => 'number',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			);
			$custom_fields_array = update_custom_fields_get_acf();

			//$custom_fields_array = [ $custom_fields_array_1,$custom_fields_array_2 ];
			acf_add_local_field_group(array(
				'key' => 'group_63076e9fdec6f',
				'title' => __('Ultimate Auction Custom Fields', 'ultimate-auction-pro-software'),
				'fields' => $custom_fields_array,
				'location' => array(
						array(
							array(
								'param' => 'post_type',
								'operator' => '==',
								'value' => 'product',
							),
							array(
								'param' => 'post_taxonomy',
								'operator' => '==',
								'value' => 'product_type:auction',
							),
						),
					),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => true,
				'description' => '',
				'show_in_rest' => 0,
			));

			endif;	