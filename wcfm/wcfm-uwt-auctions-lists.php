<?php
/**
 * WCFM plugin views
 *
 * Plugin WC UWA Auctions List Views 
 */
 global $WCFM, $WCFMu;
$wcfmu_auctions_menus = array( 'live' => __('Live Auctions', 'ultimate-auction-pro-software' ), 
	'expired' => __('Expired Auctions', 'ultimate-auction-pro-software' ),
	'scheduled' => __('Future Auctions', 'ultimate-auction-pro-software' ),
			);

$auctions_status = ! empty( $_GET['auctions_status'] ) ? sanitize_text_field( $_GET['auctions_status'] ) : 'live';
		
		
           ?>
    <style>
        li.wcfm_uwa_auctions_menu_item {
            display: inline-block;
            padding: 5px 0px 15px 0px;
        }
        ul.wcfm_uwa_auctions_menus {
            float: left;
        }
        .uwa_auction_relist_date_field {display:none;}
    </style>

<div class="collapse wcfm-collapse" id="wcfm_uwa_auctions_listing">
				<div class="wcfm-page-headig">
					<span class="wcfmfa fa-calendar"></span>
					<span class="wcfm-page-heading-text"><?php _e( 'Manage Auctions', 'ultimate-auction-pro-software' ); ?></span>
					<?php do_action( 'wcfm_page_heading' ); ?>
				</div>

				<div class="wcfm-collapse-content">
					<div id="wcfm_page_load"></div>
					<div class="wcfm-container wcfm-top-element-container">
						<ul class="wcfm_uwa_auctions_menus">
						<?php
						$is_first = true;
						foreach( $wcfmu_auctions_menus as $wcfmu_auctions_menu_key => $wcfmu_auctions_menu) {
						?>
						<li class="wcfm_uwa_auctions_menu_item">
						<?php
						if($is_first) $is_first = false;
						else echo " | ";
						?>
						<a class="<?php echo ( $wcfmu_bookings_menu_key == $auctions_status ) ? 'active' : ''; ?>" href="<?php echo get_wcfm_uwt_auction_url( $wcfmu_auctions_menu_key ); ?>"><?php echo $wcfmu_auctions_menu; ?></a>
						</li>
						<?php
						}
						?>
						</ul>
						
					<?php 
					echo '<a id="add_new_product_dashboard" class="add_new_wcfm_ele_dashboard text_tip" href="'.get_wcfm_edit_product_url().'" data-tip="' . __('Add New Product', 'ultimate-auction-pro-software') . '"><span class="wcfmfa fa-cube"></span><span class="text">' . __( 'Add New', 'ultimate-auction-pro-software') . '</span></a>';
					?>
					
					<div class="wcfm-clearfix"></div>
					</div>
				
				<div class="wcfm-clearfix"></div><br />
				
				<div class="wcfm-container">
			<div id="wwcfm_uwa_auctions_listing_expander" class="wcfm-content">
				<table id="wcfm-uwt-auctions" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
<th class="sorting_disabled" rowspan="1" colspan="1" style="width:41px;" >
<span class="wcfmfa fa-image text_tip" data-tip="Image" data-hasqtip="125" aria-describedby="qtip-125"></span></th>						
							<th><?php _e( 'Title', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Start On', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Ending On', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Current Price', 'ultimate-auction-pro-software' ); ?></th>							
							<th><?php _e( 'Actions', 'ultimate-auction-pro-software' ); ?></th>
							
						</tr>
					</thead>
					<tfoot>
						<tr>
					<th class="sorting_disabled" rowspan="1" colspan="1" style="width:41px;" >
<span class="wcfmfa fa-image text_tip" data-tip="Image" data-hasqtip="125" aria-describedby="qtip-125"></span></th>
							<th><?php _e( 'Title', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Start On', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Ending On', 'ultimate-auction-pro-software' ); ?></th>
							<th><?php _e( 'Current Price', 'ultimate-auction-pro-software' ); ?></th>						
							<th><?php _e( 'Actions', 'ultimate-auction-pro-software' ); ?></th>
						</tr>
					</tfoot>
				</table>
				<div class="wcfm-clearfix"></div>
			</div>
		</div>
				
				
				
			</div>  <!--wcfm-collapse-content END -->
			</div>  <!--Main Div END -->