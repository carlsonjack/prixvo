<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Theme Support Page
 *
 * @package Ultimate Auction Pro Software
 * @author Nitesh Singh
 * @since 1.0
 *
 */
 ?> 
 <div class="wrap welcome-wrap uat-admin-wrap">
	<?php echo uat_admin_side_top_menu();  ?>
	<h1 class="uat_theme_admin_page_title"> <?php _e( 'Help & Support', 'ultimate-auction-pro-software' ); ?></h1> 
		
	<div class="support-sec-admin">
		<h2 class="u-t-a-db-support-channels-heading"><?php _e( 'Cron Jobs', 'ultimate-auction-pro-software' ); ?></h2>
		
			<div class="uat-db-reg-form-container activation-form">
				<h4><?php _e( 'Why Cron Jobs Matter for Your Auctions site?', 'ultimate-auction-pro-software' ); ?></h4>
				<div class="uat-db-description">
					<?php _e( 'Cron jobs play a pivotal role in keeping your auctions running smoothly. They automate essential tasks like order processing, payment handling, and notifications, ensuring timely execution without manual intervention. Setting up cron jobs is crucial for optimizing your auction system, enhancing efficiency, and delivering a seamless experience to your users.', 'ultimate-auction-pro-software' ); ?>
				</div>
				<div class="uat-more-info">
					<strong><?php _e( 'More Info Link:', 'ultimate-auction-pro-software' ); ?> </strong>
					<a target="blank" href="https://docs.getultimateauction.com/article/65-cron-job"><?php _e( 'Learn how to set up cron jobs for your theme', 'ultimate-auction-pro-software' ); ?></a> 
				</div>
				<div class="uat-imp-notice">
				<span><?php _e( 'Important', 'ultimate-auction-pro-software' ); ?></span>
				<p><?php _e( 'Make sure CRON is Set in the server otherwise, this setting is not effective.', 'ultimate-auction-pro-software' ); ?></p>
				</div>
				<div class="cronn-status">
				<h3><?php _e( 'Cron Jobs Status:', 'ultimate-auction-pro-software' ); ?></h3>
					<?php 
					if (isset($_POST['uat_cron_current_status'])) {
						update_option('uat_cron_current_status', '0');
						update_option('uat_event_product_process_status', '0');
						update_option('uat_cron_process_status', '0');
						
					}
					$cron_status = get_option('uat_cron_current_status');					
					$event_cron_status = get_option('uat_event_product_process_status');
					$process_cron_status = get_option('uat_cron_process_status');
					if( $cron_status == '0' && $event_cron_status=='0' && $process_cron_status=='0')
					{
						echo "<span class='cron-status-text running'>Running</span></div>";
					}else{
						echo "<span class='cron-status-text red-stop'>Stopped</span>"; ?>
					</div><!--end cronn-status-->
						<div class="wrap">
						<form method="post" action="">
							<input type="hidden" name="uat_cron_current_status" value="0">
							<input type="submit" class="button button-primary" style="margin: 0 0 20px 0;" value="Reset CRON">
							
						</form>
						</div>
						<div class="cron-stop-instruction">
							<strong><?php _e( 'You should click on the "Reset CRON" button if any of the following conditions are met:', 'ultimate-auction-pro-software' ); ?></strong>
							<ol>
								<li>
									<?php _e( 'If you notice that auction orders or payments are pending or have stopped working even after the scheduled cron cycle has passed, then it\'s time to click on the "Reset CRON" button.', 'ultimate-auction-pro-software' ); ?>						
								</li>
								<li>
									<?php _e( 'If you keep refreshing the page and consistently see that the cron status remains "Stopped" after a few cron cycles have passed, then you should also click on the "Reset CRON" button.', 'ultimate-auction-pro-software' ); ?>							
								</li>
							</ol>
						</div>
					<?php }	?>				
			
		</div><!--end card-grid-->
	</div><!--end support-sec-admin-->
	
	
	<div class="support-sec-admin">
		<h2 class="u-t-a-db-support-channels-heading">Channels Of Support</h2>
		<div class="u-t-a-db-card-grid">
		<div class="u-t-a-db-card-notice">
		<div class="inner-block">
		<div class="u-t-a-db-card-notice-heading">
		<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/admin/QuickStartGuide.png" class="block-icon">
		<h3>Quick Start Guide</h3>
		</div>
		<p class="u-t-a-db-card-notice-content">
		We understand that it can be a daunting process getting started with WordPress. In light of this, we have prepared a starter pack for you, which includes all you need to know.				</p>
		<p class="u-t-a-db-card-notice-content">
		<a href="https://docs.getultimateauction.com" class="button button-primary" target="_blank" rel="noopener noreferrer">Starter Guide</a>
		</p>
		</div>
		</div>

		<div class="u-t-a-db-card-notice">
		<div class="inner-block">
		<div class="u-t-a-db-card-notice-heading">
		<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/admin/Documentation.png" class="block-icon">
		<h3>Documentation</h3>
		</div>
		<p class="u-t-a-db-card-notice-content">
		This is the place to go to reference different aspects of the product. Our online documentaiton is an incredible resource for learning the ins and outs of using the u-t-a Website Builder.				</p>
		<p class="u-t-a-db-card-notice-content">
		<a href="https://docs.getultimateauction.com" class="button button-primary" target="_blank" rel="noopener noreferrer">Documentation</a>
		</p>
		</div>
		</div>

		<div class="u-t-a-db-card-notice">
		<div class="inner-block">
		<div class="u-t-a-db-card-notice-heading">
		<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/admin/VideoTutorials.png" class="block-icon">
		<h3>Video Tutorials</h3>
		</div>
		<p class="u-t-a-db-card-notice-content">
		Nothing is better than watching a video to learn. We have a growing library of narrated HD video tutorials to help teach you the different aspects of using the u-t-a Website Builder.				</p>
		<p class="u-t-a-db-card-notice-content">
		<a href="https://www.youtube.com/@ultimateauctionprotheme4001" class="button button-primary" target="_blank" rel="noopener noreferrer">Watch Videos</a>
		</p>
		</div>
		</div>

		<div class="u-t-a-db-card-notice">
		<div class="inner-block">
		<div class="u-t-a-db-card-notice-heading">
		<img src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/admin/SubmitATicket.png" class="block-icon">
		<h3>Submit A Ticket</h3>
		</div>
		<p class="u-t-a-db-card-notice-content">
		We offer excellent support through our advanced ticket system. Make sure to register your purchase first to access our support services and other resources.				</p>
		<p class="u-t-a-db-card-notice-content">
		<a href="https://getultimateauction.com/contact-us" class="button button-primary" target="_blank" rel="noopener noreferrer">Submit A Ticket</a>
		</p>
		</div>
		</div>
		</div>
	</div>	
	</div>




	