<?php
global $UATS_options;
function enqueue_jquery_ui()
{
   wp_enqueue_script('jquery-ui');
   wp_enqueue_style('jquery-ui-datepicker');
   wp_enqueue_script('jquery-ui-datepicker');
   wp_enqueue_script('jquery-ui-draggable');
   wp_enqueue_script('jquery-ui-droppable');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery_ui');

$message = "";
$user_id = get_current_user_id();
$active_theme_slug = get_stylesheet();
if (isset($_POST['save-type'])) {
   $product_status = 'draft';
   if (isset($_POST['submit_auction_product'])) {
      if ($_POST['save-type'] == "submit") {
         $product_status = 'uat_submited';
      }
   }
   $message = uat_seller_auction_save_action($product_status);
   $saved_message = $message;
   $add_auction_page = get_seller_page_url('submission')."?saved_message=".$message;
   wp_safe_redirect( $add_auction_page, 301);
   echo '<script>jQuery("#messageBox").show();</script>';
}

$product_id = "";
$product = "";
if(isset($edit_product_id) && !empty($edit_product_id)){
   $product_id = $edit_product_id;
   $product = wc_get_product( $product_id );
   $product_type = 'auction'; // <== Here define your product type slug
   $class_name   = WC_Product_Factory::get_classname_from_product_type($product_type); // Get the product Class name
   
   // If the product class exist for the defined product type
   if (!empty($class_name) && class_exists($class_name)) {
       $product = new $class_name($product_id); // Get an empty instance of a grouped product Object
   }
}


// echo $message;
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js" integrity="sha512-0bEtK0USNd96MnO4XhH8jhv3nyRF0eK87pJke6pkYf3cM0uDIhNJy9ltuzqgypoIFXw3JSuiy04tVk4AjpZdZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<section class="vendor-main">
   <div class="container">
      <div class="page-heading">
         <h1><?php echo __('Describe your lot', 'ultimate-auction-pro-software'); ?></h1>
         <p><?php echo __('Tell us everything about your lot by filling in the details below if you\'re unsure of something, don\'t worry! An expert will review your submission.', 'ultimate-auction-pro-software'); ?></p>
      </div>
      <div class="describe-lot-tab ">
         <form method="POST" name="seller-auction-save" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>" />
            <?php  if(!empty($product)): ?>
               <input type="hidden" name="edit_product_id" value="<?php echo $product_id; ?>" />
            <?php endif; ?>
            <input type="hidden" name="product-type" value="auction" />
            <input type="hidden" name="save-type" value="submit" />
            <input type="hidden" name="woo_ua_auction_type" value="normal" />
            <input type="hidden" name="is_seller_product" value="yes" />
            <!-- <input type="hidden" name="uwa_event_auction" value="no" /> -->
            <input type="hidden" name="uat_auction_lot_number" value="" />
            <input type="hidden" name="uwa_number_of_next_bids" value="10" />
            <input type="hidden" name="uat_estimate_price_from" value="" />
            <input type="hidden" name="uat_estimate_price_to" value="" />
            

            
            <input type="checkbox" name="uwa_auction_selling_type_auction" value="on"  checked style="display: none;"/>
            <input type="checkbox" name="uwa_auction_selling_type_buyitnow" value="off"  checked style="display: none;"/>
            <!-- <input type="hidden" name="uwa_auction_selling_type_buyitnow" value="" /> -->
            <div id="tabs-list" class="ui-tabs ui-corner-all ui-widget ui-widget-content ui_tabs_velrtical ui_helper_clearfix">
               <ul role="tablist" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ui-tabs-active">
                     <a href="javascript:void(0)" data-tab-id="tabs-1" class="tablink ui-tabs-anchor">
                        <div class="tab-title"><?php echo __('Category', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ">
                     <a href="javascript:void(0)" data-tab-id="tabs-2" class="tablink ui-tabs-anchor">
                        <div class="tab-title"><?php echo __('Media', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ">
                     <a href="javascript:void(0)" data-tab-id="tabs-3" class="tablink ui-tabs-anchor">
                        <div class="tab-title"><?php echo __('Auction Details', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ">
                     <a href="javascript:void(0)" data-tab-id="tabs-4" class="tablink ui-tabs-anchor">
                        <div class="tab-title"><?php echo __('Estimated Value', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ">
                     <a href="javascript:void(0)" data-tab-id="tabs-5" class="tablink ui-tabs-anchor">
                        <div class="tab-title"><?php echo __('Shipping', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
                  <li class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui_corner_left ">
                     <a href="javascript:void(0)" data-tab-id="tabs-6" class="tablink ui-tabs-anchor  preview-screen">
                        <div class="tab-title"><?php echo __('Preview', 'ultimate-auction-pro-software'); ?></div>
                     </a>
                  </li>
               </ul>
               <div class="lot-main">
                  <div class="tab-screen" id="tabs-1">
                     <section class="cover">
                        <h3><?php echo __('Category', 'ultimate-auction-pro-software'); ?></h3>
                        <div class="cover-intro mr-top-15">
                           <p>
                              <?php
                              echo __('Select you category that you auction belong to.', 'ultimate-auction-pro-software');
                              $args = array(
                                 'taxonomy' => 'product_cat',
                                 'hide_empty' => false,
                                 'depth' => 1,
                                 'exclude'    => array(get_option('default_product_cat')),
                              );
                              $categories = get_categories($args);
                              $category_names = array();
                              if(!empty($product_id)){
                                
                                 $product_categories = get_the_terms( $product_id, 'product_cat' );
                                 if ( $product_categories && ! is_wp_error( $product_categories ) ) {
                                    foreach ( $product_categories as $category ) {
                                       $category_names[] = $category->name;
                                    }
                                 }
                              }

                              ?>

                              <?php
                              $i = 0;
                              if(!empty($categories)){
                              foreach ($categories as $category) :
                                 $checked = "";
                                 if(!empty($product_id)){
                                    if(!empty($category_names)){
                                       if($category->name == $category_names[0]){
                                          $checked = "checked";
                                       }
                                    }  
                                 }else{
                                    if($i == 0){
                                       $checked = "checked";
                                    }
                                 }
                              ?>
                                 <div class="form-radio-gr">
                                    <input type="radio" id="product_category_<?php echo $category->term_id; ?>" name="product_category" value="<?php echo $category->term_id; ?>" <?php echo $checked; ?>>
                                    <label for="product_category_<?php echo $category->term_id; ?>"><?php echo $category->name; ?></label>
                                 </div>
                                 <?php $i++;
                              endforeach; 

                              } ?>

                        </p>
                        </div>
                     </section>
                  <div class="line-separator"></div>
                  </div>
                 
                  <div class="tab-screen" id="tabs-2">
                     <section>
                        <h3><?php echo __('Media', 'ultimate-auction-pro-software'); ?></h3>
                        <div class="prop-content cover-intro">
                           
                           <p><?php echo __('Upload photos thay showcase your lot in the best way. Remember to include different angles and to put your best photo first.', 'ultimate-auction-pro-software'); ?></p>
                           <?php if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') { ?>
                           <h4><?php echo __('Exterior Images', 'ultimate-auction-pro-software'); ?></h4>
                           
                              <?php if ( get_field( 'default_exterior_images', 'option' ) == 1 ) : ?>
                              <?php /* Exterior Images Start */ ?>
                              <div class="img-upload">
                                 <div class="form-box">
                                    <div class="vendor-form-row">
                                       <main class="main_full gallery_upload_box">
                                          <div class="panel">
                                             <div class="button_outer">
                                                <div class="btn_upload">
                                                   <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                                   <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                                   <input type="file"  name="gallery_images[]" id="gallery_images" data-setting="gallery_images_url" multiple>
                                                   <span class="upload-btn"><?php echo __('Upload Images', 'ultimate-auction-pro-software'); ?></span>
                                                </div>
                                                <div class="processing_bar"></div>
                                                <div class="success_box"></div>
                                             </div>
                                          </div>
                                          <div class="error_msg"></div>
                                       </main>
                                       <div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
                                          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                       </div>
                                       <div id="upload_message" style="display:none;"></div>
                                    </div>
                                    <div class="vendor-form-row gallery-box" style="display: none;">
                                       <div class="form-box col-md-4">
                                          <input type="hidden" name="gallery_images_url" id="gallery_images_url" />
                                          <input type="hidden" name="gallery_images_ids" id="gallery_images_ids" />
                                          <input type="hidden" name="featured_image_url" id="featured_image_url" />
                                          <input type="hidden" name="featured_image_id" id="featured_image_id" />
                                       </div>
                                       <div class="form-box col-md-12">
                                          <div class="auction-gallery-images" id="gallery_images_show">
                                             <div class="grid-container">
                                                <div class="fix-text-on-left-img">
                                                   <p class="text-b"><?php echo __('Cover image', 'ultimate-auction-pro-software'); ?></p>
                                                   <p class="text-b"><?php echo __('Drag another image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="upload-action">
                                             <div class="sort-image">
                                                <a class="links" id="deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                             </div>
                                             <div class="device-upload-btn">
                                                <button id="addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                 </div>
                              </div>
                              <?php endif; ?>


                              <?php if ( get_field( 'default_interior_images', 'option' ) == 1 ) : ?>
                              <?php /* Interior Images Start */ ?>
                              <h4><?php echo __('Interior Images', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="img-upload">
                                 <div class="form-box">
                                    <div class="vendor-form-row">
                                       <main class="main_full interior_images_gallery_upload_box">
                                          <div class="panel">
                                          <div class="button_outer">
                                             <div class="btn_upload">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                                <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                                <input type="file"  name="interior_images[]" id="interior_images" data-setting="interior_images_url" multiple>
                                                <span class="upload-btn"><?php echo __('Interior Images', 'ultimate-auction-pro-software'); ?></span>
                                             </div>
                                             <div class="interior_images_processing_bar"></div>
                                             <div class="interior_images_success_box"></div>
                                          </div>
                                          </div>
                                          <div class="interior_images_error_msg"></div>
                                       </main>
                                       <div class="blog_loader" id="interior_images_loader_ajax" style="display:none; height:80px; width:80px; ">
                                          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                       </div>
                                       <div id="interior_images_upload_message" style="display:none;"></div>
                                    </div>
                                    <div class="vendor-form-row interior_images_gallery-box" style="display: none;">
                                       <div class="form-box col-md-4">
                                          <input type="hidden" name="interior_images_url" id="interior_images_url" />
                                          <input type="hidden" name="interior_images_ids" id="interior_images_ids" />
                                       </div>
                                       <div class="form-box col-md-12">
                                          <div class="auction-gallery-images" id="interior_images_show">
                                          <div class="grid-container">
                                                <div class="fix-text-on-left-img">
                                                   <p class="text-b"><?php echo __('Drag another image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="upload-action">
                                             <div class="sort-image">
                                                <a class="links" id="interior_selecte_deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                             </div>
                                             <div class="device-upload-btn">
                                                <button id="interior_images_addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php endif; ?>

                              <?php if ( get_field( 'default_mechanical_images', 'option' ) == 1 ) : ?>
                              <?php /* Mechanical Images  */ ?>
                              <h4><?php echo __('Mechanical Images', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="img-upload">
                              <div class="form-box">
                                 <div class="vendor-form-row">
                                    <main class="main_full mechanical_images_gallery_upload_box">
                                       <div class="panel">
                                       <div class="button_outer">
                                       <div class="btn_upload">
                                          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                          <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                          <input type="file"  name="mechanical_images[]" id="mechanical_images" data-setting="mechanical_images_url" multiple>
                                          <span class="upload-btn"><?php echo __('Mechanical Images', 'ultimate-auction-pro-software'); ?></span>
                                       </div>
                                       <div class="mechanical_images_processing_bar"></div>
                                       <div class="mechanical_images_success_box"></div>
                                       </div>
                                       </div>
                                       <div class="mechanical_images_error_msg"></div>
                                    </main>
                                    <div class="blog_loader" id="mechanical_images_loader_ajax" style="display:none; height:80px; width:80px; ">
                                       <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                    </div>
                                    <div id="mechanical_images_upload_message" style="display:none;"></div>
                                 </div>
                                 <div class="vendor-form-row mechanical_images_gallery-box" style="display: none;">
                                    <div class="form-box col-md-4">
                                       <input type="hidden" name="mechanical_images_url" id="mechanical_images_url" />
                                       <input type="hidden" name="mechanical_images_ids" id="mechanical_images_ids" />
                                    </div>
                                    <div class="form-box col-md-12">
                                       <div class="auction-gallery-images" id="mechanical_images_show">
                                       <div class="grid-container">
                                          <div class="fix-text-on-left-img">
                                             <p class="text-b"><?php echo __('Cover image', 'ultimate-auction-pro-software'); ?></p>
                                             <p class="text-b"><?php echo __('Drag another image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                          </div>
                                       </div>
                                       </div>

                                       <div class="upload-action">
                                       <div class="sort-image">
                                          <a class="links" id="mechanical_selecte_deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                       </div>
                                       <div class="device-upload-btn">
                                          <button id="mechanical_images_addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </div>
                              <?php endif; ?>
                              <?php if ( get_field( 'default_other_images', 'option' ) == 1 ) : ?>
                              <?php /* Other Images  */ ?>
                              <h4><?php echo __('Other Images', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="img-upload">
                                 <div class="form-box">
                                    <div class="vendor-form-row">
                                       <main class="main_full other_images_gallery_upload_box">
                                          <div class="panel">
                                             <div class="button_outer">
                                             <div class="btn_upload">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                                <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                                <input type="file"  name="other_images[]" id="other_images" data-setting="other_images_url" multiple>
                                                <span class="upload-btn"><?php echo __('Other Images', 'ultimate-auction-pro-software'); ?></span>
                                             </div>
                                             <div class="other_images_processing_bar"></div>
                                             <div class="other_images_success_box"></div>
                                             </div>
                                          </div>
                                          <div class="other_images_error_msg"></div>
                                       </main>
                                       <div class="blog_loader" id="other_images_loader_ajax" style="display:none; height:80px; width:80px; ">
                                          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                       </div>
                                       <div id="other_images_upload_message" style="display:none;"></div>
                                    </div>
                                    <div class="vendor-form-row other_images_gallery-box" style="display: none;">
                                       <div class="form-box col-md-4">
                                          <input type="hidden" name="other_images_url" id="other_images_url" />
                                          <input type="hidden" name="other_images_ids" id="other_images_ids" />
                                       </div>
                                       <div class="form-box col-md-12">
                                       <div class="auction-gallery-images" id="other_images_show">
                                          <div class="grid-container">
                                             <div class="fix-text-on-left-img">
                                             <p class="text-b"><?php echo __('Cover image', 'ultimate-auction-pro-software'); ?></p>
                                             <p class="text-b"><?php echo __('Drag another image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="upload-action">
                                          <div class="sort-image">
                                             <a class="links" id="other_selecte_deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                          </div>
                                          <div class="device-upload-btn">
                                             <button id="other_images_addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                          </div>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php endif; ?>

                              <?php if ( get_field( 'default_docs_images', 'option' ) == 1 ) : ?>
                              <?php /* Docs Images  */ ?>
                              <h4><?php echo __('Docs Images', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="img-upload">
                                 <div class="form-box">
                                    <div class="vendor-form-row">
                                       <main class="main_full docs_images_gallery_upload_box">
                                          <div class="panel">
                                             <div class="button_outer">
                                             <div class="btn_upload">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                                <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                                <input type="file"  name="docs_images[]" id="docs_images" data-setting="docs_images_url" multiple>
                                                <span class="upload-btn"><?php echo __('Docs Images', 'ultimate-auction-pro-software'); ?></span>
                                             </div>
                                             <div class="docs_images_processing_bar"></div>
                                             <div class="docs_images_success_box"></div>
                                             </div>
                                          </div>
                                          <div class="docs_images_error_msg"></div>
                                       </main>
                                       <div class="blog_loader" id="docs_images_loader_ajax" style="display:none; height:80px; width:80px; ">
                                          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                       </div>
                                       <div id="docs_images_upload_message" style="display:none;"></div>
                                    </div>
                                    <div class="vendor-form-row docs_images_gallery-box" style="display: none;">
                                       <div class="form-box col-md-4">
                                          <input type="hidden" name="docs_images_url" id="docs_images_url" />
                                          <input type="hidden" name="docs_images_ids" id="docs_images_ids" />
                                       </div>
                                       <div class="form-box col-md-12">
                                       <div class="auction-gallery-images" id="docs_images_show">
                                          <div class="grid-container">
                                             <div class="fix-text-on-left-img">
                                             <p class="text-b"><?php echo __('Cover image', 'ultimate-auction-pro-software'); ?></p>
                                             <p class="text-b"><?php echo __('Drag andocs image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                             </div>
                                          </div>
                                       </div>

                                       <div class="upload-action">
                                          <div class="sort-image">
                                             <a class="links" id="docs_selecte_deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                          </div>
                                          <div class="device-upload-btn">
                                             <button id="docs_images_addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                          </div>
                                       </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php endif; ?>
                              
                              <?php if ( get_field( 'default_videos_gallery', 'option' ) == 1 ) : ?>
                                 
                                    <h4><?php echo __('Video', 'ultimate-auction-pro-software'); ?></h4>
                                    <p class="text-b mr-top-10 mr-bottom-5"><?php echo __('Add Youtube Video URL', 'ultimate-auction-pro-software'); ?></p>
                                    <div id="input-container"></div>
                                    <button id="add-btn" type="button" class="video-btn" onclick="addInput()"><?php echo __('Add Video URL', 'ultimate-auction-pro-software'); ?></button>
                                 
                              <?php endif; ?>

                           <?php }else{ ?>
                              <div class="img-upload">
                                 <div class="form-box">
                                    <div class="vendor-form-row">
                                       <main class="main_full gallery_upload_box">
                                          <div class="panel">
                                             <div class="button_outer">
                                                <div class="btn_upload">
                                                   <img src="<?php echo get_template_directory_uri(); ?>/assets/images/imageupload-background.png" width="330px">
                                                   
                                                   <h3><?php echo __('Drag and drop your images here', 'ultimate-auction-pro-software'); ?> </h3>
                                                   <input type="file"  name="gallery_images[]" id="gallery_images" data-setting="gallery_images_url" multiple>
                                                   <span class="upload-btn"><?php echo __('Upload Images', 'ultimate-auction-pro-software'); ?></span>


                                                  



                                                </div>
                                                <div class="processing_bar"></div>
                                                <div class="success_box"></div>
                                             </div>
                                          </div>
                                          <div class="error_msg"></div>
                                       </main>
                                       <div class="blog_loader" id="loader_ajax" style="display:none; height:80px; width:80px; ">
                                          <img src="<?php echo UAT_THEME_PRO_IMAGE_URI . "ajax_loader.gif"; ?>" alt="Loading..." />
                                       </div>
                                       <div id="upload_message" style="display:none;"></div>
                                    </div>
                                    <div class="vendor-form-row gallery-box" style="display: none;">
                                       <div class="form-box col-md-4">
                                          <input type="hidden" name="gallery_images_url" id="gallery_images_url" />
                                          <input type="hidden" name="gallery_images_ids" id="gallery_images_ids" />
                                          <input type="hidden" name="featured_image_url" id="featured_image_url" />
                                          <input type="hidden" name="featured_image_id" id="featured_image_id" />
                                       </div>
                                       <div class="form-box col-md-12">
                                          <div class="auction-gallery-images" id="gallery_images_show">
                                             <div class="grid-container">
                                                <div class="fix-text-on-left-img">
                                                   <p class="text-b"><?php echo __('Cover image', 'ultimate-auction-pro-software'); ?></p>
                                                   <p class="text-b"><?php echo __('Drag another image in its place to change', 'ultimate-auction-pro-software'); ?></p>
                                                </div>
                                             </div>
                                          </div>

                                          <div class="upload-action">
                                             <div class="sort-image">
                                                <a class="links" id="deleteImages" href="#"><?php echo __('Delete all', 'ultimate-auction-pro-software'); ?></a>
                                             </div>
                                             <div class="device-upload-btn">
                                                <button id="addByComputer"><?php echo __('Add via computer', 'ultimate-auction-pro-software'); ?></button>
                                             </div>
                                          </div>
                                       </div>
                                    </div>

                                 </div>
                              </div>
                           <?php  } ?>



                              

                        </div>
                     </section>
                  <div class="line-separator"></div>
                  </div>
                 
                  <div class="tab-screen" id="tabs-3">
                     <section>
                        <?php 
                           $product_title = "";
                           $product_description = "";
                           if(!empty($product)){
                              $product_title = $product->get_title();
                              $product_description = $product->get_description();
                           }
                           $auction_type = "simple";
                           if(!empty($product)){
                              $auction_type = $product->get_auction_type();
                           }
                           $simple_checked = "checked";
                           $proxy_checked = "";
                           $silent_checked = "";
                           if($auction_type == 'proxy'){
                              $proxy_checked = "checked";
                           }elseif($auction_type == 'proxy'){
                              $silent_checked = "checked";
                           }
                           $get_uwa_auction_start_dates = get_ultimate_auction_now_date();
                           if(!empty($product)){
                              $get_uwa_auction_start_dates = $product->get_uwa_auction_start_dates();
                           }
                           $get_uwa_auction_end_dates = wp_date('Y-m-d H:i:s', strtotime('+1 day', time()), get_ultimate_auction_wp_timezone());
                           if(!empty($product)){
                              $get_uwa_auction_end_dates = $product->get_uwa_auction_end_dates();
                           }
                           $auction_duration = get_post_meta( $product_id, 'auction_duration', true );

                           $cmf_vehicle_titled_yes = "";
                           $cmf_vehicle_titled_no = "";
                           $cmf_hand_title_yes = "";
                           $cmf_hand_title_no = "";
                           $cmf_specification = get_post_meta($product_id, 'cmf_specification', true);
                           $cmf_year = get_post_meta($product_id, 'cmf_year', true);
                           $cmf_make =  get_post_meta($product_id, 'cmf_make', true);
                           $cmf_model = get_post_meta($product_id, 'cmf_model', true);
                           $cmf_location_country = get_post_meta($product_id, 'cmf_location_country', true);
                           $cmf_location_postal_code = get_post_meta($product_id, 'cmf_location_postal_code', true);
                           $cmf_wheel_size_and_type = get_post_meta($product_id, 'cmf_wheel_size_and_type', true);
                           $cmf_tire_brand_and_model = get_post_meta($product_id, 'cmf_tire_brand_and_model', true);
                           $cmf_tire_size = get_post_meta($product_id, 'cmf_tire_size', true);
                           $cmf_title_status = get_post_meta($product_id, 'cmf_title_status', true);
                           $cmf_name_on_title = get_post_meta($product_id, 'cmf_name_on_title', true);
                           $cmf_state_on_title = get_post_meta($product_id, 'cmf_state_on_title', true);
                           $cmf_mileage = get_post_meta($product_id, 'cmf_mileage', true);
                           $cmf_is_this_number_accurate = get_post_meta($product_id, 'cmf_is_this_number_accurate', true);
                           $cmf_total_miles_accumulated_under_present_ownership = get_post_meta($product_id, 'cmf_total_miles_accumulated_under_present_ownership', true);
                           $cmf_vin = get_post_meta($product_id, 'cmf_vin', true);
                           $cmf_body_style = get_post_meta($product_id, 'cmf_body_style', true);
                           $cmf_engine = get_post_meta($product_id, 'cmf_engine', true);
                           $cmf_drivetrain = get_post_meta($product_id, 'cmf_drivetrain', true);
                           $cmf_transmission = get_post_meta($product_id, 'cmf_transmission', true);
                           $cmf_exterior_color = get_post_meta($product_id, 'cmf_exterior_color', true);
                           $cmf_interior_color = get_post_meta($product_id, 'cmf_interior_color', true);
                           $cmf_condition = get_post_meta($product_id, 'cmf_condition', true);
                           $cmf_registration_date = get_post_meta($product_id, 'cmf_registration_date', true);
                           $cmf_drive_type = get_post_meta($product_id, 'cmf_drive_type', true);
                           $cmf_cylinders =  get_post_meta($product_id, 'cmf_cylinders', true);
                           $cmf_doors = get_post_meta($product_id, 'cmf_doors', true);
                           $cmf_fuel_type = get_post_meta($product_id, 'cmf_fuel_type', true);
                           $cmf_fuel_economy = get_post_meta($product_id, 'cmf_fuel_economy', true);
                           $cmf_car_owner = get_post_meta($product_id, 'cmf_car_owner', true);
                           $cmf_nft_owner = get_post_meta($product_id, 'cmf_nft_owner', true);
                           $cmf_date_verified = get_post_meta($product_id, 'cmf_date_verified', true);
                           $cmf_mileage_reported = get_post_meta($product_id, 'cmf_mileage_reported', true);

                           $cmf_vehicle_highlights = get_post_meta($product_id, 'cmf_vehicle_highlights', true);
                           $cmf_equipment = get_post_meta($product_id, 'cmf_equipment', true);
                           $cmf_modifications = get_post_meta($product_id, 'cmf_modifications', true);
                           $cmf_known_issues = get_post_meta($product_id, 'cmf_known_issues', true);
                           $cmf_dealer_notes = get_post_meta($product_id, 'cmf_dealer_notes', true);


                           
                           $cmf_vehicle_titled = get_post_meta($product_id, 'cmf_vehicle_titled', true);
                           $cmf_hand_title = get_post_meta($product_id, 'cmf_hand_title', true);
                           if($cmf_vehicle_titled == 'yes'){
                              $cmf_vehicle_titled_yes = "checked";
                           }else{
                              $cmf_vehicle_titled_no  = "checked";
                           }

                           if($cmf_hand_title == 'yes'){
                              $cmf_hand_title_yes = "checked";
                           }else{
                              $cmf_hand_title_no  = "checked";
                           }
                        ?>
                        <h3><?php echo __('Auction Details', 'ultimate-auction-pro-software'); ?></h3>
                        <div class="prop-content cover-intro">
                           <div class="vendor-form-row">
                              <div class="form-box col-md-12">
                                 <label class="label-fix-top" for="product_name"><?php echo __('Title', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                 <input type="text" name="product_name" id="product_name" data-required-draft="yes" required value="<?php echo $product_title; ?>">
                                 <span class="input-error"><?php echo __('Please enter title', 'ultimate-auction-pro-software'); ?></span>
                              </div>                           
                           </div>
                           <div class="vendor-form-row">
                              <div class="form-box col-md-12">
                                 <label class="label-fix-top" for="product_description"><?php echo __('Description', 'ultimate-auction-pro-software'); ?></label>
                                 <textarea type="textarea" name="product_description" id="product_description"><?php echo $product_description; ?></textarea>
                              </div>
                           </div>

                           <?php if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') { ?>
                           <?php /* Code for car theme */ ?>
                           <h4 class="mr-top-20"><?php echo __('Vehicle Specification', 'ultimate-auction-pro-software'); ?></h4>

                           <div class="vendor-form-row">
                              
                              <?php if ( get_field( 'default_specification_summary', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-12">
                                 <label class="label-fix-top" for="cmf_specification"><?php echo __('Specification Summary', 'ultimate-auction-pro-software'); ?></label>
                                 <textarea type="textarea" rows="3" name="cmf_specification" id="cmf_specification"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_specification', true); ?></textarea>
                              </div> 
                              <?php endif; ?>
  
                              <?php if ( get_field( 'default_year', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_year"><?php echo __('Year', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                 <input type="text" name="cmf_year" id="cmf_year" data-required-draft="yes" required value="<?php echo $cmf_year; ?>">
                                 <span class="input-error"><?php echo __('Year', 'ultimate-auction-pro-software'); ?></span>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_make', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_make"><?php echo __('Make', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                 <?php 
                                       $taxonomy = 'car_models'; 
                                       $args = array(
                                          'orderby' => 'name',
                                          'order' => 'ASC',
                                          'hide_empty' => false,
                                          'parent' => 0, 
                                      );
                                      $terms = get_terms($taxonomy, $args);
                                      $selected_term_id = get_post_meta($product_id, 'cmf_make', true);

                                      // Output the custom select box
                                       if ($terms && !is_wp_error($terms)) {
                                          echo '<select data-required-draft="yes" required  name="cmf_make" id="cmf_make">';
                                          echo '<option value="">Select Make</option>'; // Default option

                                          foreach ($terms as $term) {
                                             $selected = ($term->term_id == $selected_term_id) ? 'selected="selected"' : '';
                                             echo '<option value="' . $term->term_id . '" ' . $selected . '>' . $term->name . '</option>';
                                          }

                                          echo '</select>';
                                    } else {
                                          echo 'No Make found.';
                                    }

                                 ?>
                                 <?php /*<input type="text" name="cmf_make" id="cmf_make" data-required-draft="yes" required value="<?php echo $cmf_make; ?>">*/ ?>
                                 <input type="hidden" name="cmf_post_id" id="cmf_post_id" value="<?php echo $product_id; ?>">
                                 <span class="input-error"><?php echo __('Make', 'ultimate-auction-pro-software'); ?></span>
                                 
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_model', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_model"><?php echo __('Model', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                 
                                 <select name="cmf_model" data-required-draft="yes" required  id="cmf_model" disabled>
                                    <option value="">Select Car Model</option>
                                 </select>
                                 
                                 <?php /*<input type="text" name="cmf_model" id="cmf_model" data-required-draft="yes" required value="<?php echo $cmf_model; ?>">*/ ?>
                                 <span class="input-error"><?php echo __('Model', 'ultimate-auction-pro-software'); ?></span>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_location_country', 'option' ) == 1 ) : ?>    
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_location_country"><?php echo __('Location Country', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_location_country" id="cmf_location_country"  value="<?php echo $cmf_location_country; ?>">
                                 <span class="input-error"><?php echo __('Location Country', 'ultimate-auction-pro-software'); ?></span>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_location_postal_code', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_location_postal_code"><?php echo __('Location Postal Code', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_location_postal_code" id="cmf_location_postal_code" value="<?php echo $cmf_location_postal_code; ?>">
                                 <span class="input-error"><?php echo __('Location Postal Code', 'ultimate-auction-pro-software'); ?></span>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_wheel_size_and_type', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_wheel_size_and_type"><?php echo __('Wheel Size and Type', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_wheel_size_and_type" id="cmf_wheel_size_and_type" value="<?php echo $cmf_wheel_size_and_type; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_tire_brand_and_model', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_tire_brand_and_model"><?php echo __('Tire Brand and Model', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_tire_brand_and_model" id="cmf_tire_brand_and_model" value="<?php echo $cmf_tire_brand_and_model; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_tire_size', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_tire_size"><?php echo __('Tire Size', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_tire_size" id="cmf_tire_size" value="<?php echo $cmf_tire_size; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_title_status', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_title_status"><?php echo __('Title Status', 'ultimate-auction-pro-software'); ?></label>
                                 <?php /*<input type="text" name="cmf_title_status" id="cmf_title_status" value="<?php echo $cmf_title_status; ?>">*/ ?>
                                 <select id="cmf_title_status" class="" name="cmf_title_status"  data-placeholder="Select">
                                    <option value="" <?php if ($cmf_fuel_type == "") echo "selected"; ?> data-i="0"><?php echo __('Select', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="clean" <?php if ($cmf_title_status == "clean") echo "selected"; ?>><?php echo __('Clean', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="rebuilt" <?php if ($cmf_title_status == "rebuilt") echo "selected"; ?> ><?php echo __('Rebuilt', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="salvage" <?php if ($cmf_title_status == "salvage") echo "selected"; ?> ><?php echo __('Salvage', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="branded" <?php if ($cmf_title_status == "branded") echo "selected"; ?> ><?php echo __('Branded', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="other" <?php if ($cmf_title_status == "other") echo "selected"; ?> ><?php echo __('Other', 'ultimate-auction-pro-software'); ?></option>
                                 </select>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_name_on_title', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_name_on_title"><?php echo __('Name on Title', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_name_on_title" id="cmf_name_on_title" value="<?php echo $cmf_name_on_title; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_state_on_title', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_state_on_title"><?php echo __('State on Title', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_state_on_title" id="cmf_state_on_title" value="<?php echo $cmf_state_on_title; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_mileage', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_mileage"><?php echo __('Current mileage on odometer', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_mileage" id="cmf_mileage"  value="<?php echo $cmf_mileage; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_is_this_number_accurate', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_is_this_number_accurate"><?php echo __('Is this number accurate?', 'ultimate-auction-pro-software'); ?></label>
                                 <?php /* 
                                 <input type="text" name="cmf_is_this_number_accurate" id="cmf_is_this_number_accurate" data-required-draft="yes" required value="<?php echo $cmf_is_this_number_accurate; ?>">
                                 <span class="input-error"><?php echo __('Is this number accurate?', 'ultimate-auction-pro-software'); ?></span>*/
                                 ?>
                                 <select id="cmf_is_this_number_accurate" class="" name="cmf_is_this_number_accurate"  data-placeholder="Select">
                                    <option value="" <?php if ($cmf_is_this_number_accurate == "") echo "selected"; ?> data-i="0"><?php echo __('Select', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="yes" <?php if ($cmf_is_this_number_accurate == "yes") echo "selected"; ?>><?php echo __('Yes', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="no" <?php if ($cmf_is_this_number_accurate == "no") echo "selected"; ?>><?php echo __('No', 'ultimate-auction-pro-software'); ?></option>
                                 </select>
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_total_miles_accumulated_under_present_ownership', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_total_miles_accumulated_under_present_ownership"><?php echo __('Total Miles Accumulated Under Present Ownership?', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_total_miles_accumulated_under_present_ownership" id="cmf_total_miles_accumulated_under_present_ownership" value="<?php echo $cmf_total_miles_accumulated_under_present_ownership; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_vin', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_vin"><?php echo __('VIN', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_vin" id="cmf_vin" value="<?php echo $cmf_vin; ?>">
                              </div>  
                              <?php endif; ?>

                              <?php if ( get_field( 'default_body_style', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_body_style"><?php echo __('Body Style', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_body_style" id="cmf_body_style" value="<?php echo $cmf_body_style; ?>">
                                 <span class="input-error"><?php echo __('Body Style', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_engine', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_engine"><?php echo __('Engine', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_engine" id="cmf_engine"  value="<?php echo $cmf_engine; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_drivetrain', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_drivetrain"><?php echo __('Drivetrain', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_drivetrain" id="cmf_drivetrain"  value="<?php echo $cmf_drivetrain; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_transmission', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_transmission"><?php echo __('Transmission', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_transmission" id="cmf_transmission" value="<?php echo $cmf_transmission; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_exterior_color', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_exterior_color"><?php echo __('Exterior Color', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_exterior_color" id="cmf_exterior_color"  value="<?php echo $cmf_exterior_color; ?>">
                                 <span class="input-error"><?php echo __('Exterior Color', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_interior_color', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_interior_color"><?php echo __('Interior Color', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_interior_color" id="cmf_interior_color" value="<?php echo $cmf_interior_color; ?>">
                                 <span class="input-error"><?php echo __('Interior Color', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_condition', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_condition"><?php echo __('Condition', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_condition" id="cmf_condition" value="<?php echo $cmf_condition; ?>">
                                 <span class="input-error"><?php echo __('Condition', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_registration_date', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_registration_date"><?php echo __('Registration date', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_registration_date" id="cmf_registration_date"  value="<?php echo $cmf_registration_date; ?>">
                                 <span class="input-error"><?php echo __('Registration date', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_drive_type', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_drive_type"><?php echo __('Drive Type', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_drive_type" id="cmf_drive_type" value="<?php echo $cmf_drive_type; ?>">
                                 <span class="input-error"><?php echo __('Drive Type', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_cylinders', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_cylinders"><?php echo __('Cylinders', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_cylinders" id="cmf_cylinders" value="<?php echo $cmf_cylinders; ?>">
                                 <span class="input-error"><?php echo __('Cylinders', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_doors', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_doors"><?php echo __('Doors', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_doors" id="cmf_doors"  value="<?php echo $cmf_doors; ?>">
                                 <span class="input-error"><?php echo __('Doors', 'ultimate-auction-pro-software'); ?></span>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_fuel_type', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_fuel_type"><?php echo __('Fuel type', 'ultimate-auction-pro-software'); ?></label>
                                 <?php /*<input type="text" name="cmf_fuel_type" id="cmf_fuel_type"  value="<?php echo $cmf_fuel_type; ?>">
                                 */ ?>
                                 <select id="cmf_fuel_type" class="" name="cmf_fuel_type"  data-placeholder="Select">
                                    <option value="" <?php if ($cmf_fuel_type == "") echo "selected"; ?> data-i="0"><?php echo __('Select', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="gas" <?php if ($cmf_fuel_type == "gas") echo "selected"; ?>><?php echo __('Gasoline', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="diesel" <?php if ($cmf_fuel_type == "diesel") echo "selected"; ?>><?php echo __('Diesel', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="hybrid" <?php if ($cmf_fuel_type == "hybrid") echo "selected"; ?>><?php echo __('Hybrid', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="electric" <?php if ($cmf_fuel_type == "electric") echo "selected"; ?>><?php echo __('Electric', 'ultimate-auction-pro-software'); ?></option>
                                    <option value="patrol" <?php if ($cmf_fuel_type == "patrol") echo "selected"; ?>><?php echo __('Patrol', 'ultimate-auction-pro-software'); ?></option>
                                 </select>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_fuel_economy', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_fuel_economy"><?php echo __('Fuel economy', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_fuel_economy" id="cmf_fuel_economy" value="<?php echo $cmf_fuel_economy; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_vehicle_owner', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_car_owner"><?php echo __('Vehicle Owner', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_car_owner" id="cmf_car_owner" value="<?php echo $cmf_car_owner; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_nft_owner', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_nft_owner"><?php echo __('NFT Owner', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_nft_owner" id="cmf_nft_owner" value="<?php echo $cmf_nft_owner; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_date_verified', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_date_verified"><?php echo __('Date Verified', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_date_verified" id="cmf_date_verified" value="<?php echo $cmf_date_verified; ?>">
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_mileage_reported', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top" for="cmf_mileage_reported"><?php echo __('Mileage Reported', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="text" name="cmf_mileage_reported" id="cmf_mileage_reported" value="<?php echo $cmf_mileage_reported; ?>">
                              </div> 
                              <?php endif; ?>
                              <?php if ( get_field( 'default_is_the_vehicle_titled_in_your_name', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top-main mr-bottom-10"><?php echo __('Is the vehicle titled in your name?', 'ultimate-auction-pro-software'); ?></label>
                                 <div class="form-radio-gr mr-bottom-0">
                                    <input type="radio" name="cmf_vehicle_titled" id="cmf_vehicle_titled_yes" value="yes" <?php echo $cmf_vehicle_titled_yes; ?>> <label for="cmf_vehicle_titled_yes"><?php echo __('Yes', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="radio" name="cmf_vehicle_titled" id="cmf_vehicle_titled_no" value="no" <?php echo $cmf_vehicle_titled_no; ?>> <label for="cmf_vehicle_titled_no"><?php echo __('No', 'ultimate-auction-pro-software'); ?></label>
                                 </div>
                              </div> 
                              <?php endif; ?>

                              <?php if ( get_field( 'default_do_you_have_the_title_in_hand', 'option' ) == 1 ) : ?>
                              <div class="form-box col-md-4">
                                 <label class="label-fix-top-main mr-bottom-10"><?php echo __('Do you have the title in hand?', 'ultimate-auction-pro-software'); ?></label>
                                 <div class="form-radio-gr mr-bottom-0">
                                    <input type="radio" name="cmf_hand_title" id="cmf_hand_title_yes" value="yes" <?php echo $cmf_hand_title_yes; ?>> <label for="cmf_hand_title_yes"><?php echo __('Yes', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="radio" name="cmf_hand_title" id="cmf_hand_title_no" value="no" <?php echo $cmf_hand_title_no; ?>> <label for="cmf_hand_title_no"><?php echo __('No', 'ultimate-auction-pro-software'); ?></label>
                                 </div>
                              </div> 
                              <?php endif; ?>

                           </div>
                           <?php } ?>

                           <?php 
                                 $uat_custom_enable = get_option('uat_custom_enable','no');
                                 if($uat_custom_enable==="yes"){
                                    global $wpdb;
                                    $custom_fields = [];
                                    $query   ="SELECT * FROM `".$wpdb->prefix."ua_custom_fields` order by form_order ASC";
                                    $results = $wpdb->get_results( $query );
                                    $fields_array = [];
                                    if(count($results) > 0)
                                    {
                                       $i = 1;
                                       foreach($results as $field){
                                          $custom_field = [];
                                          $custom_field['id'] = $field->id;
                                          $custom_field['name'] = $field->attribute_name;
                                          $custom_field['slug'] = $field->attribute_slug;
                                          $custom_field['type'] = $field->attribute_type;
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
                                                $custom_field['options'] = $field_options;
                                             }
                                          }
                                          $custom_fields[] = $custom_field;
                                       }
                                    }
                                    if(!empty($custom_fields)){
                                       echo '<div class="vendor-form-row">';
                                       foreach($custom_fields as $custom_field){
                                          $id = $custom_field['id'];
                                          $name = $custom_field['name'];
                                          $slug = "uat_custom_field_".$custom_field['slug'];
                                          $type = $custom_field['type'];
                                          $field_value = "";
                                          if(!empty($product)){
                                             $field_value = get_field($slug, $product_id);
                                          }
                                          // echo $field_value;
                                          $field_input = "";
                                          if($type == "select"){
                                             $options = $custom_field['options'];
                                             $options_html = "<select name='".$slug."'><option>". __('Select', 'ultimate-auction-pro-software')." ".$name."</option>";
                                             foreach($options as $key => $text){
                                                $selected = ($key === $field_value) ? 'selected="selected"' : '';
                                                $options_html .= "<option value='".$key."' $selected>".$text."</option>";
                                             }
                                             $options_html .= '</select>';
                                             $field_input = $options_html;
                                          }else{
                                             
                                             $field_input = '<input type="'.$type.'" name="'.$slug.'" id="'.$slug.'" data-required-draft="yes" value="'.$field_value.'">';      
                                          }
                                    ?>
                                          <div class="form-box col-md-4">
                                             <label class="label-fix-top" for="<?php echo $slug; ?>"><?php echo $name; ?></label>
                                             <?php echo $field_input; ?>                                             
                                          </div>
                                    <?php
                                       }
                                       echo '</div>';
                                    }
                                 }
                              ?>
                                 <?php if($active_theme_slug == 'ultimate-auction-pro-vehicle-software') { ?>
                                 <?php /* Code for car theme */ ?>
                                 <h4 class="mr-top-20"><?php echo __('Vehicle Details', 'ultimate-auction-pro-software'); ?></h4>

                                 <div class="vendor-form-row">
                                 <?php if ( get_field( 'default_vehicle_highlights', 'option' ) == 1 ) : ?>
                                 <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="cmf_vehicle_highlights"><?php echo __('Vehicle Highlights', 'ultimate-auction-pro-software'); ?></label>
                                    <textarea type="textarea" rows="6" name="cmf_vehicle_highlights" id="cmf_vehicle_highlights"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_vehicle_highlights', true); ?></textarea>
                                 </div> 
                                 <?php endif; ?>

                                 <?php if ( get_field( 'default_vehicle_equipment', 'option' ) == 1 ) : ?>
                                 <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="cmf_equipment"><?php echo __('Vehicle Equipment', 'ultimate-auction-pro-software'); ?></label>
                                    <textarea type="textarea" name="cmf_equipment" rows="5" id="cmf_equipment"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_equipment', true); ?></textarea>
                                    <span class="input-error"><?php echo __('Vehicle Equipment', 'ultimate-auction-pro-software'); ?></span>
                                 </div> 
                                 <?php endif; ?>
                                 
                                 <?php if ( get_field( 'default_vehicle_modifications', 'option' ) == 1 ) : ?>
                                 <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="cmf_modifications"><?php echo __('Vehicle Modifications', 'ultimate-auction-pro-software'); ?></label>
                                    <textarea type="textarea" rows="5" name="cmf_modifications" id="cmf_modifications"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_modifications', true); ?></textarea>
                                    <span class="input-error"><?php echo __('Vehicle Modifications', 'ultimate-auction-pro-software'); ?></span>
                                 </div> 
                                 <?php endif; ?>

                                 <?php if ( get_field( 'default_vehicle_known_issues', 'option' ) == 1 ) : ?>
                                 <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="cmf_known_issues"><?php echo __('Vehicle Known Issues', 'ultimate-auction-pro-software'); ?></label>
                                    <textarea type="textarea" rows="5" name="cmf_known_issues" id="cmf_known_issues"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_known_issues', true); ?></textarea>
                                    <span class="input-error"><?php echo __('Vehicle Modifications', 'ultimate-auction-pro-software'); ?></span>
                                 </div> 
                                 <?php endif; ?>

                                 
                                 <?php if ( get_field( 'default_dealer_notes', 'option' ) == 1 ) : ?>
                                 <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="cmf_dealer_notes"><?php echo __('Dealer Notes', 'ultimate-auction-pro-software'); ?></label>
                                    <textarea type="textarea" name="cmf_dealer_notes" rows="4" id="cmf_dealer_notes"><?php if(!empty($product)) echo get_post_meta($product_id, 'cmf_dealer_notes', true); ?></textarea>
                                 </div> 
                                 
                                 <?php endif; ?>
                                 </div>
                                 

                                 <?php } ?>

                           <h3 class="mr-top-20"><?php echo __('Auction type', 'ultimate-auction-pro-software'); ?></h3>
                           <div class="vendor-form-row">
                              <div class="form-box col-md-12">
                                 <div class="form-radio-gr mr-bottom-0">
                                    <input type="radio" name="auction_type" id="auction_type_simple" required value="simple" <?php echo $simple_checked; ?>> <label for="auction_type_simple"><?php echo __('Simple', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="radio" name="auction_type" id="auction_type_proxy"  value="proxy" <?php echo $proxy_checked; ?>> <label for="auction_type_proxy"><?php echo __('Proxy', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="radio" name="auction_type" id="auction_type_silent"  value="silent" <?php echo $silent_checked; ?>> <label for="auction_type_silent"><?php echo __('Silent', 'ultimate-auction-pro-software'); ?></label>
                                    <span class="input-error"><?php echo __('Please select type of auction', 'ultimate-auction-pro-software'); ?></span>
                                 </div>
                              </div>                           
                           </div>
                           
                           <div class="vendor-form-row">
                           <div class="form-box col-md-12">
                           <h3 class="mr-top-20"><?php echo __('Auction Duration', 'ultimate-auction-pro-software'); ?></h3>
                                 </div>
                              <div class="form-box col-md-12">
                                    <label class="label-fix-top" for="auction_duration"><?php echo __('Duration', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                    <input type="text" name="auction_duration" id="auction_duration" required value="<?php echo $auction_duration; ?>"> 
                                 </div>  
                                 <div class="form-box col-md-12">                         
                                 <span><?php echo __('Please specify the auction duration you desire, such as 2 days, 2 hours, 2 months, etc.', 'ultimate-auction-pro-software'); ?></span>
                                 </div>
                           </div>
                        </div>
                     </section>
                  <div class="line-separator"></div>
                  </div>
                 
                  <div class="tab-screen" id="tabs-4">
                     <section>
                        <?php 
                           $product_regular_price = "";
                           $product_opening_price = "";
                           $product_has_reserve = "";
                           $product_ua_lowest_price = "";
                           if(!empty($product)){
                              $product_opening_price = $product->get_uwa_auction_start_price();
                              $product_regular_price = $product->get_regular_price();
                              $product_has_reserve = $product->is_uwa_reserve_enabled();
                              if($product_has_reserve){
                                 $product_has_reserve = "checked";
                              }
                              $product_ua_lowest_price = $product->get_uwa_auction_reserved_price();
                           }
                        ?>
                        <h3><?php echo __('Estimated Value', 'ultimate-auction-pro-software'); ?></h3>
                        <div class="prop-content cover-intro">
                           <input type="hidden" name="woo_ua_bid_increment" value="100" />
                           <input type="hidden" name="uwa_number_of_next_bids" value="10" />
                           <input type="hidden" name="uat_estimate_price_from" value="" />
                           <input type="hidden" name="uat_estimate_price_to" value="" />

                           <div class="estimated-content">
                              <!-- <h4 class="mr-top-30"><?php echo __('How much do you think our auction is Worth?', 'ultimate-auction-pro-software'); ?> </h4> -->
                              <!-- <p class="mr-top-15">We only accept auctions With an estimated value above $75. <a href="#">Find out why</a> </p> -->
                           </div>
                           <div class="vendor-form-row">
                              <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                 <span class="cur_icon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                 <label class="label-fix-top" for="_regular_price"><?php echo __('Retail Price(Buy now)', 'ultimate-auction-pro-software'); ?>
                                    <!-- <span class="required-sign">*</span>
                                    <span class="tooltip-text">? <span class="tooltiptext">Hello-Word</span></span> -->
                                 </label>
                                 <input type="number" name="_regular_price" id="_regular_price" step="any" value="<?php echo $product_regular_price; ?>">
                                 <span class="input-error"><?php echo __('Please enter retail Price(Buy now)', 'ultimate-auction-pro-software'); ?></span>
                              </div>
                           </div>
                          
                           <div class="vendor-form-row">
                              <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                 <span class="cur_icon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                 <label class="label-fix-top" for="woo_ua_opening_price"><?php echo __('Opening Price', 'ultimate-auction-pro-software'); ?><span class="required-sign">*</span></label>
                                 <input type="number" name="woo_ua_opening_price" id="woo_ua_opening_price" step="any" required value="<?php echo $product_opening_price; ?>">
                                 <span class="input-error"><?php echo __('Please enter opening price', 'ultimate-auction-pro-software'); ?></span>
                              </div>
                           </div>
                           
                           <h3 class="mr-bottom-10 mr-top-20"><?php echo __('Reserve price', 'ultimate-auction-pro-software'); ?></h3>
                           <div class="vendor-switch-label">
                              <label class="checkbox_switch" for="checkbox">
                                 <input type="checkbox" name="uwa_auction_has_reserve" class="seller-reserve-check" id="checkbox" <?php echo $product_has_reserve; ?>/>
                                 <div class="checkbox-slider round"></div>
                              </label>
                              <p class="mr-bottom-0"><?php echo __('Set a reserve Price(minimum Price)', 'ultimate-auction-pro-software'); ?></p>
                           </div>
                           <div class="estimated-content seller-reserve-box">
                              <h4 class="mr-top-30"> <?php echo __('Enter your reserv price', 'ultimate-auction-pro-software'); ?></h4>
                              <p class="mr-top-15 mr-bottom-5"><?php echo __("Bidders won't see this Whether its Been met.", 'ultimate-auction-pro-software'); ?></p>
                           </div>
                           <div class="vendor-form-row seller-reserve-box">
                              <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                 <span class="cur_icon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                 <label class="label-fix-top" for="woo_ua_lowest_price"><?php echo __('Reserv price', 'ultimate-auction-pro-software'); ?></label>
                                 <input type="woo_ua_lowest_price" id="woo_ua_lowest_price" name="woo_ua_lowest_price" value="<?php echo $product_ua_lowest_price; ?>" />
                              </div>
                           </div>
                        </div>
                     </section>
                  <div class="line-separator"></div>
                  </div>
                 
                  <div class="tab-screen" id="tabs-5">
                     <section>
                        <div class="prop-content cover-intro">
                           <div class="estimated-content">
                              <h3><?php echo __('Shipping', 'ultimate-auction-pro-software'); ?></h3>
                              <h4 class="mr-bottom-15"><?php echo __('Choose preset:', 'ultimate-auction-pro-software'); ?></h4>
                              <div class=" ">
                                

                                 <div class="vendor-switch-label">
                                    <label class="checkbox_switch" for="shipping_preset_type">
                                       <input type="checkbox" name="shipping_preset_type" class="seller-shipping-new-check" id="shipping_preset_type" />
                                       <div class="checkbox-slider round"></div>
                                    </label>
                                    <h4><?php echo __('Add new', 'ultimate-auction-pro-software'); ?></h4>
                                 </div>
                                 </div>
                                 <div class="vendor-form-row">
                                
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                    <select name="shipping_preset_selection">
                                       <option><?php echo __('Select preset', 'ultimate-auction-pro-software'); ?></option>
                                    </select>
                                 </div>
                              </div>
                              <h4 class="mr-top-20"><?php echo __('Shipment will be paid by...', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="vendor-form-row">
                                 <div class="form-box curruncy-icon mr-bottom-0 col-md-4">
                                    <div class="form-radio-gr mr-bottom-0">
                                       <input type="radio" id="seller_shipping_fee_by" name="seller_shipping_fee_by" value="seller">
                                       <label for="seller_shipping_fee_by"> <?php echo __('The seller', 'ultimate-auction-pro-software'); ?></label>
                                    </div>
                                 </div>
                              </div>
                              <div class="vendor-form-row">
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                    <div class="form-radio-gr mr-bottom-40">
                                       <input type="radio" id="seller_shipping_fee_by_" name="seller_shipping_fee_by" value="buyer">
                                       <label for="seller_shipping_fee_by_"><?php echo __('The buyer', 'ultimate-auction-pro-software'); ?></label>
                                    </div>
                                 </div>
                              </div>
                              <h4><?php echo __('Establish a shipment price', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="vendor-form-row">
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                    <label class="label-fix-top" for="local_pickup_country_price"><?php echo __('Local price(same country)', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="number" placeholder="<?php echo __('Type here', 'ultimate-auction-pro-software'); ?>" name="local_pickup_country_price" id="local_pickup_country_price">
                                 </div>
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                    <label class="label-fix-top" for="local_pickup_continent_price"><?php echo __('Continent price(same continent)', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="number" placeholder="<?php echo __('Type here', 'ultimate-auction-pro-software'); ?>" name="local_pickup_continent_price" id="local_pickup_continent_price">
                                 </div>
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4">
                                    <label class="label-fix-top" for="local_pickup_world_price"><?php echo __('Worldwide', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="number" placeholder="<?php echo __('Type here', 'ultimate-auction-pro-software'); ?>" name="local_pickup_world_price" id="local_pickup_world_price">
                                 </div>
                              </div>
                              <h4><?php echo __('Save/update preset', 'ultimate-auction-pro-software'); ?></h4>
                              <div class="vendor-form-row">
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-4 preser-name">
                                    <label class="label-fix-top" for="local_pickup_country_price"><?php echo __('Preset name', 'ultimate-auction-pro-software'); ?></label>
                                    <input type="text" placeholder="<?php echo __('Type here', 'ultimate-auction-pro-software'); ?>" name="shipping_preset_name" id="shipping_preset_name">

                                 </div>
                                 <div class="form-box curruncy-icon mr-bottom-20 col-md-6">
                                       <button class="btn" type="button" id="delete-shiping-preset" action-type='delete'><?php echo __('Delete', 'ultimate-auction-pro-software'); ?></button>
                                       <button class="btn" type="button" id="save-shiping-preset"><?php echo __('Save', 'ultimate-auction-pro-software'); ?></button>
                                       <span class="preset-message p-message-success"><?php echo __('Preset saved successfully', 'ultimate-auction-pro-software'); ?></span>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </section>
                  <div class="line-separator"></div>
                  </div>
                 
                  <div class="tab-screen last-tab preview-screen" id="tabs-6" >
                     <section class="cover">

                        <div class="preview-screen-box">
                           <h3><?php echo __('Preview', 'ultimate-auction-pro-software'); ?></h3>
                           <div class="prev-item">
                              <h5><?php echo __('Category', 'ultimate-auction-pro-software'); ?></h5>
                              <p class="category-preview"></p>
                              <h5><?php echo __('Front', 'ultimate-auction-pro-software'); ?></h5>                     
                              <div class="front-img-preview"></div>
                              <p class="title-preview"></p>
                           </div>
                           <div class="prev-item">
                              <h5><?php echo __('Reserver Price', 'ultimate-auction-pro-software'); ?></h5>
                              <p class="reserver-price-preview"></p>
                           </div>
                           <div class="prev-item">
                              <h5><?php echo __('If lot doesn\'t reach RP', 'ultimate-auction-pro-software'); ?></h5>
                              <p class="reserver-action-preview"><?php echo __('No sell', 'ultimate-auction-pro-software'); ?></p>
                           </div>
                           <div class="prev-item">
                              <h5><?php echo __('Auction fee', 'ultimate-auction-pro-software'); ?></h5>
                              <p class="action-fees-preview">
                                 <?php
                                 $uat_seller_bp_percentage = get_option("uat_seller_bp_percentage", '0');
                                 printf(__('Will charge a commision of %s of the final bid.', 'ultimate-auction-pro-software'), $uat_seller_bp_percentage . "%");
                                 ?>
                              </p>
                           </div>
                           <div class="prev-item">
                              <h5><?php echo __('Shipping', 'ultimate-auction-pro-software'); ?></h5>
                              <p>
                                 <p><span class="shippign_payed_by"></span><?php echo __('will provide shipping', 'ultimate-auction-pro-software'); ?></p>
                                 <p>
                                    <?php echo __('Local price', 'ultimate-auction-pro-software'); ?>
                                    <span class="local_price"></span>
                                    <?php echo __('Continent price', 'ultimate-auction-pro-software'); ?>
                                    <span class="contunent_price"></span>
                                    <?php echo __('Worldwide', 'ultimate-auction-pro-software'); ?>
                                    <span class="worldwide_price"></span>
                                 </p>
                                 <p>
                                    <span class="shipping-local-fees-preview"></span>
                                    <span class="shipping-continent-fees-preview"></span>
                                    <span class="shipping-world-fees-preview"></span>
                                 </p>
                              </p>
                           </div>
                           <div class="prev-item">
                              <h5><?php echo __('Bid starts at', 'ultimate-auction-pro-software'); ?></h5>
                              <p class="bid-price-preview"></p>
                           </div>                          
                        </div>
                        <div class="preview-screen-box">
                           <div class="form-box  prev-item">
                              <h5><?php echo __('Send a message note to Admin', 'ultimate-auction-pro-software'); ?></h5>
                              <textarea type="textarea" name="uat_seller_message" id="uat_seller_message"><?php if(!empty($product)) echo get_post_meta($product_id, 'uat_seller_message', true); ?></textarea>
                           </div>
                        </div>                        
                     </section>
                  </div>
               </div>
               <div class="tab-footer-block">
                  <div class="left-arrow"><a class="prev-tab footer-btn " href="#"><?php echo __('prev', 'ultimate-auction-pro-software'); ?></a></div>
                  <p id="messageBox" style="display: none;"><?php echo $message; ?></p>
                  <div class="right-arrow">
                    
                     <input class="footer-btn draft-auction-input submit-auction-product btn-seller" name="submit_auction_product_darft" type="button" data-action-type='draft' value="Save as draft" />
                     <a class="next-tab footer-btn " href="#"><?php echo __('next', 'ultimate-auction-pro-software'); ?></a>
                     <input class=" footer-btn add-auction-input submit-auction-product" name="submit_auction_product" type="submit" data-action-type='submit' value="Submit" />
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</section>

<?php
wp_register_script( 'uat-datepicker', UAT_THEME_PRO_JS_URI . 'date-picker.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), '1.0' );
wp_register_script('uat-add-auction', get_template_directory_uri() . '/assets/js/seller/add-auction.js', array('uat-datepicker'));
wp_enqueue_script('uat-add-auction');
$shipping_data = get_user_meta($user_id, 'shipping_data', true);
$wc_currency_symbol = get_woocommerce_currency_symbol();
$no_reserve_text = __('No reserve', 'ultimate-auction-pro-software');
$wrong_msg = __('Something is wrong', 'ultimate-auction-pro-software');
$fill_values_msg = __('Please fill all values', 'ultimate-auction-pro-software');
$save_btn_text = __('Save', 'ultimate-auction-pro-software');
$update_btn_text = __('Update', 'ultimate-auction-pro-software');
$delete_image =  get_template_directory_uri()."/assets/images/delete-img.svg"; 

$selectedMediaIds = [];
$interior_selectedMediaIds = [];
$mechanical_selectedMediaIds= [];
$other_selectedMediaIds= [];
$docs_selectedMediaIds= [];
$uploads = wp_upload_dir();
$upload_path = $uploads['baseurl'];
/* Car theme image gallery */ 
$interior_selectedMediaIds = array();
$mechanical_selectedMediaIds = array();
$other_selectedMediaIds = array();
$docs_selectedMediaIds = array();
$video_selectedMediaIds = array();

if(!empty($product)){
   /* thumbnail image */
   $thumb_attachment_id = get_post_thumbnail_id( $product_id );
   $thumb_attachment_data = wp_get_attachment_metadata($thumb_attachment_id);
   $file = $thumb_attachment_data['file'];
   $filename = basename($file);
   $data = [];
   $data['id'] = $thumb_attachment_id;
   $data['url'] = $upload_path.'/'.$file;
   $data['filename'] = $filename;

   $selectedMediaIds[] = $data;
   /* galary images */
   $attachment_ids = $product->get_gallery_image_ids();
   foreach ($attachment_ids as $attachment_id) {
      $attachment_data = wp_get_attachment_metadata($attachment_id);
      $file = $attachment_data['file'];
      $filename = basename($file);

      $data = [];
      $data['id'] = $attachment_id;
      $data['url'] = $upload_path.'/'.$file;
      $data['filename'] = $filename;

      $selectedMediaIds[] = $data;
  }

  
   

   $exterior_images_images = get_field('exterior_images',$product_id); 
   $interior_images_images = get_field('interior_images',$product_id); 
   $mechanical_images_images = get_field('mechanical_images',$product_id); 
   $other_images_images = get_field('other_images',$product_id);
   $docs_images_images = get_field('docs_images',$product_id);

   
   if($interior_images_images) {
      foreach ($interior_images_images as $interior_images_image) {
         if(!empty($interior_images_image)) {
            $attachment_data = wp_get_attachment_metadata($interior_images_image);
            $file = $attachment_data['file'];
            $filename = basename($file);
      
            $data = [];
            $data['id'] = $interior_images_image;
            $data['url'] = $upload_path.'/'.$file;
            $data['filename'] = $filename;
            $interior_selectedMediaIds[] = $data;
         }   
   
      }
   }

   if($mechanical_images_images) {
      foreach ($mechanical_images_images as $mechanical_images_image) {
         if(!empty($mechanical_images_image)) {
         $attachment_data = wp_get_attachment_metadata($mechanical_images_image);
         $file = $attachment_data['file'];
         $filename = basename($file);

         $data = [];
         $data['id'] = $mechanical_images_image;
         $data['url'] = $upload_path.'/'.$file;
         $data['filename'] = $filename;
         $mechanical_selectedMediaIds[] = $data;
         }
   
      }
   }

   if($other_images_images) {
      foreach ($other_images_images as $other_images_image) {
         if(!empty($other_images_image)) {
            $attachment_data = wp_get_attachment_metadata($other_images_image);
            $file = $attachment_data['file'];
            $filename = basename($file);

            $data = [];
            $data['id'] = $other_images_image;
            $data['url'] = $upload_path.'/'.$file;
            $data['filename'] = $filename;
            $other_selectedMediaIds[] = $data;
         }
   
      }
   }
   if(!empty($docs_images_images)) {
      foreach ($docs_images_images as $docs_images_image) {
         if(!empty($docs_images_image)) {
            $attachment_data = wp_get_attachment_metadata($docs_images_image);
            $file = $attachment_data['file'];
            $filename = basename($file);

            $data = [];
            $data['id'] = $docs_images_image;
            $data['url'] = $upload_path.'/'.$file;
            $data['filename'] = $filename;
            $docs_selectedMediaIds[] = $data;
         }
   
      }
   }

   $youtube_video_url = get_field('cmf_videos_re',$product_id);
  
   if(isset($youtube_video_url)) { $i=0;
      foreach ($youtube_video_url as $row) {
         if(!empty($row)) { $i++;
           

            $data = [];
            $data['youtube_video'] = $row['cmf_videos'];
            $video_selectedMediaIds[] = $data;
         }
      }
   }

}


$imageUploadMode = $UATS_options['imageUploadMode'];
$upload_success_msg = __('The images were successfully uploaded.', 'ultimate-auction-pro-software');
$upload_failed_msg = __('Uploading of images was unsuccessful.', 'ultimate-auction-pro-software');
$upload_proccessing_msg = __('The process of uploading images is currently in progress.', 'ultimate-auction-pro-software');
$submit_proccessing_msg = __('Please wait while we submit your product information...', 'ultimate-auction-pro-software'); 
$add_auction_data = array(
   'shipping_presets' => $shipping_data,
   'user_id' => $user_id,
   'delete_image' => $delete_image,
   'wc_currency_symbol' => $wc_currency_symbol,
   'no_reserve_text' => $no_reserve_text,
   'wrong_msg' => $wrong_msg,
   'fill_values_msg' => $fill_values_msg,
   'save_btn_text' => $save_btn_text,
   'update_btn_text' => $update_btn_text,
   'selectedMediaIds' => $selectedMediaIds,
   'interior_selectedMediaIds' => $interior_selectedMediaIds,
   'mechanical_selectedMediaIds' => $mechanical_selectedMediaIds,
   'other_selectedMediaIds' => $other_selectedMediaIds,
   'docs_selectedMediaIds' => $docs_selectedMediaIds,
   'video_selectedMediaIds' => $video_selectedMediaIds,
   'imageUploadMode' => $imageUploadMode,
   'upload_success_msg' => $upload_success_msg,
   'upload_failed_msg' => $upload_failed_msg,
   'upload_proccessing_msg' => $upload_proccessing_msg,
   'submit_proccessing_msg' => $submit_proccessing_msg,
   'calendar_image' => WC()->plugin_url() . '/assets/images/calendar.png',
);
wp_localize_script('uat-add-auction', 'add_auction_data', $add_auction_data);
if(!empty($message)){
   echo '<script> jQuery("#messageBox").show(); </script>';
}