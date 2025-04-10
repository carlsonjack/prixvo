<?php
/**
 * Ultimate Auction Pro Software Importer
 *
 * @package Ultimate WooCommerce Auction Pro
 * @author Nitesh Singh 
 * @since 1.1.1 
 *
 */  
	$auction_import_url = admin_url(). "admin.php?page=ua_auctions_products_import&tab=auction";
	$csv_url = UAT_THEME_PRO_URI.'includes/admin/import/uat_auction_products_import_sample.csv';
	$help_url = "https://docs.getultimateauction.com/article/133-import-auction-products";
	$wooimport_page_url = admin_url(). "edit.php?post_type=product&page=product_importer";
	?>	
	
	<div class="uwa_main_setting uwa_import_set wrap woocommerce">
		<?php echo uat_admin_side_top_menu();  ?>
		<h1 class="uat_theme_admin_page_title"> <?php _e( 'Import Auction Products', 'ultimate-auction-pro-software' ); ?></h1> 
		<div class="uwa_import">
		<div class="import-page-heading">
			<img src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/product-import.png">
			<!-- <h1 class="uwa_admin_page_title">
					<?php _e( 'Import <br>Auction Products', 'ultimate-auction-pro-software' ); ?>
			</h1>		 -->
		</div>
			<h1> <?php _e( 'Follow Below Steps to Import Auction Products inside your WooCommerce site.', 'ultimate-auction-pro-software' ); ?></h1>
			<ul>			
				<li> 
				 <h2> Step - 1 </h2>	
					<a href = "<?php echo $csv_url; ?>" class="button button-primary"><?php _e('Download Sample CSV file', 'ultimate-auction-pro-software');?> </a>
					<p><?php _e( 'Download Sample CSV file.', 'ultimate-auction-pro-software' ); ?></p>
				</li>																										
				
				<li>				
				<h2> Step - 2 </h2>	 
					<a target="_blank" href = "<?php echo $help_url; ?>" class="button button-primary"><?php _e('See Valid Values  Link Should be:', 'ultimate-auction-pro-software');?> </a>
					<p><?php _e( 'Open the article to see what valid values you need to enter in each field.', 'ultimate-auction-pro-software' ); ?></p>													
				</li>
				
				<li> 		
				<h2> Step - 3 </h2>				
				<form action="" method="post" id="postForm">
				<input id="btn_import" type="submit" value="Check Folders And Files Permission." class="button button-submit">				
				<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ajax-loader-import.gif" id="img_import" style="display:none"/ >				 
				</form>	
				<p><?php _e( 'Theme based on JSON file. So you need to test Folders and Files Permission before Importing Auction Products.', 'ultimate-auction-pro-software' ); ?></p>
					<h4 id="folder-exist" class="text-success"></h4></br>
					<h4 id="folder-perms" class="text-success"></h4></br>
					<h4 id="file-data" class="text-success"></h4></br>						
					<h4 id="not-writable" class="text-danger"></h4>	
				</li>	
				
				<li> 
				<h2> Step - 4 </h2>	
				<a href = "<?php echo $wooimport_page_url; ?>" class="button button-primary"><?php _e('WooCommerce Import Page', 'ultimate-auction-pro-software');?> </a> 
				<p><?php _e( 'Once your CSV file is ready, you can import here.', 'ultimate-auction-pro-software' ); ?></p>				
				</li>

																							
			</ul>	
		</div>		
	</div>
	
<script type="text/javascript">
jQuery(document).ready(function($) {
  jQuery("#btn_import").click(function(e) {
	   jQuery("#folder-exist").hide();
	   jQuery("#folder-perms").hide();
	   jQuery("#file-data").hide();
	   jQuery("#not-writable").hide();
	   jQuery('#img_import').show();
	var ajaxurl= "<?php echo admin_url('admin-ajax.php');?>";
    e.preventDefault();
    jQuery.ajax({
      type: 'POST',
	  url: ajaxurl,	 	
      data: {
        btn_import: 'btn_import',
		action: 'get_import_results_data',	
      },
	  dataType: 'JSON',
		success: function(response) {  
				 
			  if (response.folder_exist !== null){  	
					jQuery("#folder-exist").html(response.folder_exist).show();
					setTimeout(function(){
						jQuery("#folder-exist").html(response.folder_exist);
					},3000);			   
				   jQuery('#img_import').hide();
			  }  
			  
			  if (response.folder_perms !== null){  	
					jQuery("#folder-perms").html(response.folder_perms).show();
					setTimeout(function(){
						jQuery("#folder-perms").html(response.folder_perms);
					},3500);			   
				   jQuery('#img_import').hide();
			  }      	
			  
			  if (response.file_data !== null){  			   			  
					jQuery("#file-data").html(response.file_data).show();
					setTimeout(function(){
						jQuery("#file-data").html(response.file_data);
					},4000);			   
				   jQuery('#img_import').hide();
			  }
			  
			  if (response.not_writable !== null){  		
					jQuery("#not-writable").html(response.not_writable).show();			  
					setTimeout(function(){
						jQuery("#not-writable").html(response.not_writable);
					},5000);			   
				   jQuery('#img_import').hide();
			  }  
        }
    });
  });
});
</script>
