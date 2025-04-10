<?php 
function register_forms() {
	$form_success_message = get_option('options_success_message','Thank you for submitting your car details! Our admin will contact you shortly.');		
	$admin_enabled = get_option('options_email_notification');
    $admin_emails_array =array();
	$from_email = get_option('options_submit_car_from_email');		
	$from_name = get_option('options_submit_car_from_name');
	if($admin_enabled ==1){			
		$admin_email = get_option('options_emails');
		$admin_sub = get_option('options_admin_subject','New Car Submission by Seller.');	
		$admin_email_body = get_option('options_admin_content','A new car submission has been received from a seller. Here are the details');
		if ( ! $admin_email ){
			$admin_email = get_option( 'admin_email' );
		}
		$all_fields_show = get_option('options_summited_all_fields_show_in_email');
		if($all_fields_show ==1){
			$admin_email_body.="<p>{all_fields}</p>";
		}
		$admin_emails_array = array(
			'name' => 'Admin Email',
			'active' => true,
			'recipient_type' => 'custom',
			'recipient_field' => false,
			'recipient_custom' => $admin_email,
			'from' => $from_email,
			'subject' => $admin_sub,
			'content' => $admin_email_body,
		);
	}	
	$seller_enabled = get_option('options_user_email_notification');
    $seller_emails_array =array();	
	if($seller_enabled ==1){		
		$seller_sub = get_option('options_user_subject','Your Car Submission Received.');	
		$seller_email_body = get_option('options_user_content','Thank you for submitting the details of your car. We have received your submission and appreciate your interest in listing your vehicle with us.');			
		$seller_emails_array = array(
								'name' => 'User',
								'active' => true,
								'recipient_type' => 'field',
								'recipient_field' => 'field_64800923ca46d',
								'recipient_custom' => '',
								'from' => $from_email,
								'subject' => $seller_sub,
								'content' => $seller_email_body,
							);
	}
	
	
	af_register_form( array(
		'key' => 'form_6481d7e3e7585',
		'title' => 'Seller From',
		'display' => array(
			'description' => '',
			'success_message' => $form_success_message,
		),
		'create_entries' => true,
		'restrictions' => array(
			'entries' => false,
			'user' => false,
			'schedule' => false,
		),
		'emails' => array(
				$admin_emails_array,
				$seller_emails_array			
			),
	) );
}
add_action( 'af/register_forms', 'register_forms' );

/* seller from shortcode */ 
add_shortcode('ua_car_seller_form', 'ua_seller_form_shortcode');

function ua_seller_form_shortcode($atts, $content = null) { 
        
	ob_start();  
	$output  = ua_seller_form_shortcode_fun($atts, $content);
	$output  = ob_get_clean();
	
	return $output;  
}
function ua_seller_form_shortcode_fun($atts, $content) 
{ 
	
	if ( is_plugin_active( 'advanced-forms/advanced-forms.php' ) ) {
		
			acf_form_head(); 
			ob_start();
			echo do_shortcode('[advanced_form form="form_6481d7e3e7585" post_author="1"]');
			
			wp_enqueue_media();
			ob_end_flush();  		
			
	} else {
		// ACF plugin is not active
		// Add your code here or show a message
		?>
		
		<div class="notice notice-error">
			<p><?php esc_html_e( 'Sorry, but we are currently undergoing maintenance. Please check back later. Thank you!', 'ultimate-auction-pro-software' ); ?></p>
		</div>
		
		<?php 
		
	}
	
	
}




function acf_plugin_check_notice() {
    if ( ! is_plugin_active( 'advanced-forms/advanced-forms.php' ) ) {
        echo '<div class="notice notice-error"><p><a href="https://wordpress.org/plugins/advanced-forms/" target="_blank">The ACF Forms addon</a> plugin is not active. Please activate it to use the full functionality of this theme.</p></div>';
    }
}
add_action( 'admin_notices', 'acf_plugin_check_notice' );


function entry_created( $entry_id, $form ) {
	ob_start();
	// Set the source and destination post types
	$source_post_type = 'af_entry'; 
	$destination_post_type = 'product'; 
	$destination_product_type = 'auction'; 

	// Set the ID of the post to clone
	$source_post_id = $entry_id; 

	// Get the source post
	$source_post = get_post($source_post_id);

	// Check if the source post exists
	if ($source_post) {
	 
	  $post_title = $source_post->post_title;
	  $post_content = $source_post->post_content;

	  
	  	$new_post = array(
			'post_type' => $destination_post_type,
			'post_title' => $post_title,
			'post_content' => $post_content,
		);

	
	  // Insert the new post into the database
	  $new_post_id = wp_insert_post($new_post);

	  // Check if the new post was created successfully
	  if ($new_post_id) {
		wp_set_object_terms( $new_post_id, 'auction', 'product_type' );

		$meta_fields = get_fields($source_post_id);
		if ($meta_fields) {
		  foreach ($meta_fields as $meta_key => $meta_value) {
			update_field($meta_key, $meta_value, $new_post_id);
		  }
		}
		
		/* Update Exterior_images */
		$exterior_images_gallery = 'exterior_images_gallery';
		$image_field_name = 'add_image';
		$exterior_images_name = 'field_6231e3ae2224d';
		$repeater_data = get_field($exterior_images_gallery, $new_post_id);

		if ($repeater_data) {
			$gallery_images = array(); 

			foreach ($repeater_data as $item) {
				$image_id = $item[$image_field_name];
				$gallery_images[] = $image_id;
			}
			update_field($exterior_images_name, $gallery_images, $new_post_id);
		}

		/* Update interior_images_gallery */

		$interior_images_gallery = 'interior_images_gallery';
		$interior_images_name = 'field_6231e50d8661e';
		$repeater_data = get_field($interior_images_gallery, $new_post_id);

		if ($repeater_data) {
			$gallery_images = array(); 

			foreach ($repeater_data as $item) {
				$image_id = $item['add_image'];
				$gallery_images[] = $image_id;
			}
			update_field($interior_images_name, $gallery_images, $new_post_id);
		}


		/* Update mechanical_images_gallery */

		$mechanical_images_gallery = 'mechanical_images_gallery';
		$mechanical_images_name = 'field_6231e5378661f';
		$repeater_data = get_field($mechanical_images_gallery, $new_post_id);

		if ($repeater_data) {
			$gallery_images = array(); 

			foreach ($repeater_data as $item) {
				$image_id = $item['add_image'];
				$gallery_images[] = $image_id;
			}
			update_field($mechanical_images_name, $gallery_images, $new_post_id);
		}

		/* Update docs_images_gallery */
		$docs_images_gallery = 'docs_images_gallery';
		$docs_images_images_name = 'field_6231e56986621';
		$repeater_data = get_field($docs_images_gallery, $new_post_id);

		if ($repeater_data) {
			$gallery_images = array(); 

			foreach ($repeater_data as $item) {
				$image_id = $item['add_image'];
				$gallery_images[] = $image_id;
			}
			update_field($docs_images_images_name, $gallery_images, $new_post_id);
		}

		/* Update other_images_gallery */
		$other_images_gallery = 'other_images_gallery';
		$other_images_name = 'field_6231e55586620';
		$repeater_data = get_field($other_images_gallery, $new_post_id);

		if ($repeater_data) {
			$gallery_images = array(); 

			foreach ($repeater_data as $item) {
				$image_id = $item['add_image'];
				$gallery_images[] = $image_id;
			}
			update_field($other_images_name, $gallery_images, $new_post_id);
		}
		
	  } 
	} 
	ob_end_flush();  
}
add_action( 'af/form/entry_created/key=form_6481d7e3e7585', 'entry_created', 10, 2 );