<?php
$live_no = get_sub_field( 'uat_content_current_upcoming_auctions_no' );
$future_no = get_sub_field( 'uat_content_upcoming_auctions_no' );
$gmt_offset = get_option('gmt_offset') > 0 ? '+'.get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ','ultimate-auction-pro-software').$gmt_offset;
?>
<section class="currant-and-upcoming-auction">
    <div class="container">
        <?php $uat_content_current_upcoming_auctions_title = get_sub_field( 'uat_content_current_upcoming_auctions_title' ); ?>
        <?php $uat_content_current_upcoming_auctions_link = get_sub_field( 'uat_content_current_upcoming_auctions_link' ); ?>
        <?php if(!empty($uat_content_current_upcoming_auctions_title) || !empty($uat_content_current_upcoming_auctions_link) ){ ?>

        <div class="section-heading">
            <h4><?php echo get_sub_field( 'uat_content_current_upcoming_auctions_title' ); ?></h4>
            <?php if ( $uat_content_current_upcoming_auctions_link ) { ?>
            <a href="<?php echo esc_url($uat_content_current_upcoming_auctions_link['url']); ?>"
                target="<?php echo esc_attr($uat_content_current_upcoming_auctions_link['target']); ?>"><?php echo esc_attr($uat_content_current_upcoming_auctions_link['title']); ?></a>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="owl-carousel upcoming-auction-slider">
        <?php
		$selected_datetime ="";
		$event_status = "uat_live";
		$postids = uat_get_all_events_ids($event_status, "DESC", "date", $selected_datetime);
		if (empty($postids)) {
			$postids[] = array();
		}
		$args_live = array (
					'post_type'              => array( 'uat_event' ),
					'post_status'            => array( 'Publish' ),
					'posts_per_page' =>$live_no,

		);
		$args_live['post__in'] = $postids;
		// The Query
		$query_live = new WP_Query( $args_live );
		if ( $query_live->have_posts() ) {
		while ( $query_live->have_posts() ) : $query_live->the_post();
			$event_id =  get_the_ID();
			$featured_img_url = get_the_post_thumbnail_url($event_id, 'events-fw-list-thumbnails');
			if(empty($featured_img_url)){
			   $featured_img_url = uat_get_event_default_image();
			}
			$starting_on_date =get_post_meta($event_id, 'start_time_and_date', true);
			$ending_date =get_post_meta($event_id, 'end_time_and_date', true);
			$event_status = uat_get_event_status( $event_id );
			if($event_status =="uat_live") {				
				$sr_only_txt =__( "Live Auction", 'ultimate-auction-pro-software' );
			}elseif($event_status =="uat_past"){				
				$sr_only_txt =__( "Past Auction", 'ultimate-auction-pro-software' );
			}elseif($event_status =="uat_future"){
				$sr_only_txt =__( "Future Auction", 'ultimate-auction-pro-software' );
			}
		?>
             <div class="owl-item">
					<div class="product-img-box">
						<a class="ua-button" href="<?php the_permalink();?>"><img src="<?php echo $featured_img_url;?>"></a>
                    </div>
			<?php
			$timer = get_sub_field('uat_content_upcoming_auctions_timer');
			if($event_status =="uat_live") { 
			global $wpdb;
			$event_end_date = $wpdb->get_var('SELECT event_end_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
			$auc_end_date=$event_end_date;
			$rem_arr=get_remaining_time_by_timezone($auc_end_date);
			?>
			<?php if($timer==='true'){ ?>
			<div class="box-timer">
					
			<?php
				event_countdown_clock(
					$end_date=$auc_end_date,
					$item_id=$event_id,
					$item_class='time_countdown_event',   
				);					
			?>
			</div>
			<?php }  
			} elseif($event_status =="uat_future"){ 			
			global $wpdb;
			$event_start_date = $wpdb->get_var('SELECT event_start_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
			$auc_end_date=$event_start_date;
			$rem_arr=get_remaining_time_by_timezone($auc_end_date);
			 if($timer==='true'){ ?>
								<div class="box-timer">
									 
									<?php
										event_countdown_clock(
											$end_date=$auc_end_date,
											$item_id=$event_id,
											$item_class='time_countdown_event',   
										);					
									?>
								</div>
			<?php }  } ?>
                    <div class="ua-box-detail">
						<div class="Ua-category"><span class="sr-only"><?php echo __( "Category", 'ultimate-auction-pro-software' ); ?>: </span><?php echo $sr_only_txt;?></div>
						<div class="Ua-box-title"><?php the_title();?></div>
						<div class="Card-details">
						<?php echo date_i18n( get_option('date_format'),strtotime($starting_on_date));  ?>–<?php echo date_i18n( get_option('date_format'),strtotime($ending_date));  ?>
						| <?php echo date_i18n( get_option('time_format'), strtotime( $ending_date ));  ?> <?php echo $timezone_string; ?>
						  </div>
					</div>
				<?php
			if($event_status =="uat_live") { ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?></a>
			<?php } elseif($event_status =="uat_future"){ ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Preview', 'ultimate-auction-pro-software'); ?></a>
			<?php } ?>

            </div>
            <?php endwhile; ?>
            <?php } ?>
            <?php wp_reset_postdata(); ?>
            <?php
			$selected_datetime ="";
			$event_status = "uat_future";
			$postids = uat_get_all_events_ids($event_status, "DESC", "date", $selected_datetime);
			if (empty($postids)) {
				$postids[] = array();
			}
			$args_future = array (
					'post_type'              => array( 'uat_event' ),
					'post_status'            => array( 'Publish' ),
					'posts_per_page' =>$future_no,

			);
			$args_future['post__in'] = $postids;
		// The Query
		$query_future = new WP_Query( $args_future );
		if ( $query_future->have_posts() ) {
		while ( $query_future->have_posts() ) : $query_future->the_post();
			$event_id =  get_the_ID();
			$featured_img_url = get_the_post_thumbnail_url($event_id, 'events-fw-list-thumbnails');
			if(empty($featured_img_url)){
			   $featured_img_url = uat_get_event_default_image();
			}
			$starting_on_date =get_post_meta($event_id, 'start_time_and_date', true);
			$ending_date =get_post_meta($event_id, 'end_time_and_date', true);
			$event_status = uat_get_event_status( $event_id );
			if($event_status =="uat_live") {
				$sr_only_txt ="LIVE Auction";
			}elseif($event_status =="uat_past"){
				$sr_only_txt ="PAST Auction";
			}elseif($event_status =="uat_future"){
				$sr_only_txt ="Upcoming Auction";
			}
		?>
            <div class="owl-item">
					<div class="product-img-box">
						<a class="ua-button" href="<?php the_permalink();?>"><img src="<?php echo $featured_img_url;?>"></a>
                    </div>
			<?php			
			$timer = get_sub_field('uat_content_upcoming_auctions_timer');
			if($event_status =="uat_live") { 
			global $wpdb;
			$event_end_date = $wpdb->get_var('SELECT event_end_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
			$auc_end_date=$event_end_date;
			$rem_arr=get_remaining_time_by_timezone($auc_end_date);
			?>
			<?php if($timer==='true'){ ?>
			<div class="box-timer">
					 
					<?php
						event_countdown_clock(
							$end_date=$auc_end_date,
							$item_id=$event_id,
							$item_class='time_countdown_event',   
						);					
					?>
			</div>
			<?php }  
			} elseif($event_status =="uat_future"){ 			
			global $wpdb;
			$event_start_date = $wpdb->get_var('SELECT event_start_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
			$auc_end_date=$event_start_date;
			$rem_arr=get_remaining_time_by_timezone($auc_end_date);
			 if($timer==='true'){ ?>
								<div class="box-timer">
									<?php
										event_countdown_clock(
											$end_date=$auc_end_date,
											$item_id=$event_id,
											$item_class='time_countdown_event',   
										);					
									?>
								</div>
			<?php }  } ?>
					
                    <div class="ua-box-detail">
						<div class="Ua-category"><span class="sr-only"><?php _e('Category', 'ultimate-auction-pro-software'); ?>: </span><?php echo $sr_only_txt;?></div>
						<div class="Ua-box-title"><?php the_title();?></div>
						<div class="Card-details">
						<?php echo date_i18n( get_option('date_format'),strtotime($starting_on_date));  ?>–<?php echo date_i18n( get_option('date_format'),strtotime($ending_date));  ?>
						| <?php echo date_i18n( get_option('time_format'), strtotime( $ending_date ));  ?> | <?php echo $timezone_string; ?>
						  </div>
					</div>
				<?php
			if($event_status =="uat_live") { ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?></a>
			<?php } elseif($event_status =="uat_future"){ ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Preview', 'ultimate-auction-pro-software'); ?></a>
			<?php } ?>

            </div>
            <?php endwhile; ?>
            <?php } ?>
            <?php wp_reset_postdata(); ?>
        </div>

    </div>
</section>