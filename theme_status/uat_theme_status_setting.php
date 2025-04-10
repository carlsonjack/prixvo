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

   	$isplugin=[];
       $plugin_dir = WP_PLUGIN_DIR  .'';
   	 $dirnm = scandir($plugin_dir);

        $dcount=count($dirnm);
   	 if($dcount>2){
   		 for($d=0;$d<$dcount;$d++){
   			if($d>1){
   			  $pluginnm=$dirnm[$d];
   			  $isplugin[]=$pluginnm;

   			}
   		 }
   	 }
   	$is_acf=0;
   	if(in_array("advanced-custom-fields-pro",$isplugin)){
   		$is_acf=1;
   	}

   	$is_woo=0;
   	if(in_array("woocommerce",$isplugin)){
   		$is_woo=1;
   	}

   	$blog_plugins = get_option( 'active_plugins', array() );

      if (isset($_POST['form_submitted'])){
         uat_acf_plugin_latest_update();
      }
      $status  = get_option( get_template(). '_license_key_status', false );
      $uat_woo_plugin_latest_get_version = uat_woo_plugin_latest_get_version();
      $uat_woo_plugin_current_get_version = uat_woo_plugin_current_get_version();
    ?>
<div class="wrap welcome-wrap uat-admin-wrap">
   <?php echo uat_admin_side_top_menu();  ?>
   <h1 class="uwa_admin_page_title">
      <?php _e( 'Theme Status', 'ultimate-auction-pro-software' ); ?>
   </h1>
   <br class="clear">
   <table class="wc_status_table widefat" cellspacing="0" id="status">
      <thead>
         <tr>
            <th colspan="5" data-export-label="WordPress Environment">
               <h2>Auction Theme Environment</h2>
            </th>
         </tr>
         <tr>
            <th><h3 style="margin: 0;">Plugin</h3></th>
            <th><h3  style="margin: 0;">Current version</h3></th>
            <th><h3  style="margin: 0;">Latest version</h3></th>
            <th><h3  style="margin: 0;">Installed satus</h3></th>
            <th><h3  style="margin: 0;">Activated status</h3></th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <td data-export-label="WordPress address (URL)">Woocommerce</td>
            <td data-export-label="Current version"><?php echo $uat_woo_plugin_current_get_version; ?></td>
            <td data-export-label="Latest version"><?php echo $uat_woo_plugin_latest_get_version; ?></td>
            <td class="help">
               <span class="woocommerce-help-tip"></span>
               <?php if($is_woo==1){ ?>
               <div style="color:green"><strong>Installed</strong></div>
               <?php }else{ ?>
               <div style="color:red"><strong>Not Installed</strong></div>
               <?php }?>
            </td>
            <td>
               <?php if ( in_array( 'woocommerce/woocommerce.php', $blog_plugins )  ) { ?>
               <div style="color:green"><strong><mark class="yes"><span class="dashicons dashicons-yes"></span></mark> Activated </strong></div>
               <?php }else{ ?>
               <div style="color:red"><strong><mark class="error"><span class="dashicons dashicons-warning"></span></mark> Not Activated </strong></div>
               <?php } ?>
            </td>
         </tr>
         <tr>
            <td data-export-label="WordPress address (URL)">Advanced Custom Fields</td>
            <td data-export-label="Current version"><?php echo uat_acf_plugin_current_get_version(); ?></td>
            <td data-export-label="Latest version">
                  <?php
                     $uat_acf_plugin_latest_get_version = uat_acf_plugin_latest_get_version();
                     $uat_acf_plugin_current_get_version = uat_acf_plugin_current_get_version();
                     if(!empty($uat_acf_plugin_latest_get_version)){
                  ?>
                     <form action="" method="POST">
                        <input type="hidden" name="form_submitted" value="1" />
                        <div style="display: flex;align-items: center;">
                           <label for="a"><?php echo $uat_acf_plugin_latest_get_version; ?></label>
                           <?php  if('valid' == $status){ ?>
                           <input id="a" class="button button-primary button-small" type="submit" value="Update now" style="margin: 0 10px;">
                           <?php } ?>
                        </div>
                     </form>
                  <?php } else{ echo $uat_acf_plugin_current_get_version; }?>
            </td>
            <td class="help">
               <span class="woocommerce-help-tip"></span>
               <?php if($is_acf==1){ ?>
               <div style="color:green"><strong>Installed</strong></div>
               <?php }else{ ?>
               <div style="color:red"><strong>Not Installed</strong></div>
               <?php }?>
            </td>
            <td>
               <?php if ( in_array( 'advanced-custom-fields-pro/acf.php', $blog_plugins )  ) { ?>
                  <div style="color:green"><strong><mark class="yes"><span class="dashicons dashicons-yes"></span></mark> Activated </strong></div>
               <?php }else{ ?>
               <div style="color:red"><strong><mark class="error"><span class="dashicons dashicons-warning"></span></mark> Not Activated </strong></div>
               <?php } ?>
            </td>
         </tr>
      </tbody>
   </table>
   <br class="clear">
   <table class="wc_status_table widefat" cellspacing="0" id="status">
      <thead>
         <tr>
            <th colspan="3" data-export-label="WordPress Environment">
               <h2>One Click Demo Import</h2>
            </th>
         </tr>
      </thead>
      <tbody id="data_result">
      </tbody>
      <tfoot>
         <tr >
            <td colspan="3">
               <button type="button" aria-disabled="false" class="components-button button button-primary button-large is-primary opt_import_cls" >Import Demo Data</button>
            </td>
         </tr>
      </tfoot>
   </table>
</div>
<tr>
   <td data-export-label="WordPress address (URL)"> </td>
   <td class="help">
   </td>
   <td>
   </td>
</tr>
<script type="text/javascript">
jQuery(document).ready(function(){

});
function import_demo_data(){


	 jQuery.ajax({
		url:ajaxurl ,
		type: "post",
		data: {
			action: 'fun_import_demo_data_ajax',
			setp: '1',


		 },
		beforeSend: function() {

			jQuery('#data_result').html('Loading...');
		},
		success: function(data){
			jQuery("#data_result").html(data);


		 },
		error:function(){
			 console.log('failure!');

		}

	 });

}
</script>