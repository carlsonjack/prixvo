
<?php
global $wp, $wp_query, $seller_current_page, $paged;
$current_request = $wp->request;
$parts = explode("/", $current_request);
$order_id = $parts[2];
$order = wc_get_order($order_id);
if(empty($order)){
   handle_404_error();
}
  

    // User details
    $user = $order->get_user();
    $user_name = $user->display_name;

    // Billing and shipping addresses
    $billing_address = $order->get_formatted_billing_address();
    $shipping_address = $order->get_formatted_shipping_address();
?>
<div class="salse_tab-content">
   <div class="Sales-tab-con">
      <div id="tabs-content" class="order-page">
         <div class="salse_tab-content">
            <div class="page-heading no-border">

               <div class="order-no">
                  <div class="order-d-left">
                     <h2><?php echo __('Order num', 'ultimate-auction-pro-software'); ?></h2>
                     <div class="order-num"><?php echo $order_id; ?></div>
                  </div>
                  <div class="order-d-right">
                     <!-- <ul>
                           <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/d--1.png"></a></li>
                           <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/d--2.png"></a></li>
                           <li><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/d--3.png"></a></li>
                           <li class="active"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/d--4.png"></a></li>
                     </ul> -->
                  </div>
               </div>
            </div>
            <div class="tab_con_box">
               <div class="tab_con_box-right">
                  <div class="product_data">
                  <table>
                        <tbody>
                           <tr>
                              <!-- <th class="check-box"></th> -->
                              <th class="front"><?php echo __('Front', 'ultimate-auction-pro-software'); ?></th>
                              <th class="lot"><?php echo __('Lot', 'ultimate-auction-pro-software'); ?></th>
                              <th class="from"><?php echo __('From', 'ultimate-auction-pro-software'); ?></th>
                              <th class="to"><?php echo __('To', 'ultimate-auction-pro-software'); ?></th>
                              <th class="shipment-status"><?php echo __('Shipment status', 'ultimate-auction-pro-software'); ?></th>
                              <th class="action-box"><?php echo __('Actions', 'ultimate-auction-pro-software'); ?></th>
                           </tr>
                           <?php 
                              $current_user = wp_get_current_user();
                              foreach ($order->get_items() as $item_id => $item) {

                                 $product = $item->get_product();
                                 $product_type = 'auction'; // <== Here define your product type slug
                                 $class_name   = WC_Product_Factory::get_classname_from_product_type($product_type); // Get the product Class name

                                 // If the product class exist for the defined product type
                                 if (!empty($class_name) && class_exists($class_name)) {
                                       $product = new $class_name($product); // Get an empty instance of a grouped product Object
                                 }
                                 if (method_exists($product, 'get_type') && $product->get_type() == 'auction') {
                                    $product_id = $product->get_id();
                                    $seller_user_name = $current_user->display_name;
                                    $seller_user_id = $product->get_meta('uat_seller_id');
                                    if($current_user->ID != $seller_user_id){
                                       continue;
                                    }
                                    // $seller_billing_address = get_user_meta($current_user->ID, 'billing_address', true);
                                    $seller_billing_address =$current_user->get_formatted_billing_address();
                                    // Product details for each item
                                    $product_title = $product->get_name();
                                    $lot_number = $product->get_lot_number()??"-";

                                    $thumbnail_url = wp_get_attachment_url(get_post_thumbnail_id($product_id));
                           ?>
                                       <tr>
                                          <td class="front"><img src="<?php echo $thumbnail_url; ?>" width="100px" height="" alt=""></td>
                                          <td class="lot">
                                         
                                             <div>
                                                <h3><?php echo $lot_number; ?>
                                                <br>
                                                <?php echo $product_title; ?></h3>
                                             </div>
                                          </td>
                                          <td class="from">
                                             <?php echo $seller_user_name; ?><br>
                                             <?php echo $seller_billing_address; ?>
                                          </td>
                                          <td class="to">
                                             <?php echo $user_name; ?><br>
                                             <?php echo $shipping_address; ?>
                                          </td>
                                          
                                       <td class="shipment-status">
                                             <button class="btn-link green-btn">-On Delivery</button>
                                       </td>
                                       <td class="action-box"> 
                                    
                                          <form name="lot_action" action="#" method="POST">
                                                <input type="hidden" name="action_lot_id" value="793">
                                                <input type="hidden" name="lot_action_type" value=""> 
                                                <div class="drop-down">
                                                   <div class="selected">
                                                      <span>Actions</span>
                                                   </div>
                                                   <div class="options">
                                                      <ul>
                                                         <li><a data-value="preview" href="#" disbaled="">Preview<span class="value" disbaled=""></span></a></li>
                                                         <li><a data-value="edit" href="#">Edit<span class="value"></span></a></li>
                                                         <li><a data-value="copy" href="#">Copy<span class="value"></span></a></li>
                                                         <li><a data-value="delete" href="#">Delete<span class="value"></span></a></li>
                                                      </ul>
                                                   </div>
                                                </div>
                                             </form>
                                          </td>
                                       </tr>
                           <?php
                              }
                           }
                           ?>
                           <!-- <tr>
                              <td class="image-box"><img src="http://localhost/niteshauction/wp-content/uploads/2022/09/pexels-dids-3045825.jpg" width="100px" height="" alt=""></td>
                              <td class="Title-box">
                                 <h3>Lorem sipum</h3>
                              </td>
                              <td class="Status-box">
                                 <div>Lo-22-54698632</div>
                                 
                              </td>
                              <td class="Category-box">22-02-2023</td>
                              <td class="date-of-auction">
                              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dil-scooter.png">
                              <h3>Lorem sipum</h3>
                              </td>
                              <td class="Status-box">
                              <button class="btn-link btn-gold">-On Delivery</button>         
                                 
                              </td>
                              <td class="action-box">
                                 <form name="lot_action" action="#" method="POST">
                                    <input type="hidden" name="action_lot_id" value="793">
                                    <input type="hidden" name="lot_action_type" value=""> 
                                    <div class="drop-down">
                                       <div class="selected">
                                          <span>Actions</span>
                                       </div>
                                       <div class="options">
                                          <ul>
                                             <li><a data-value="preview" href="#" disbaled="">Preview<span class="value" disbaled=""></span></a></li>
                                             <li><a data-value="edit" href="#">Edit<span class="value"></span></a></li>
                                             <li><a data-value="copy" href="#">Copy<span class="value"></span></a></li>
                                             <li><a data-value="delete" href="#">Delete<span class="value"></span></a></li>
                                          </ul>
                                       </div>
                                    </div>
                                 </form>
                              </td>
                           </tr> -->
                        </tbody>
                     </table>
                     
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>