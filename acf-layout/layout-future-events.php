<?php
$future_events_no = get_sub_field( 'uat_content_future_auction_events_no' );
$gmt_offset = get_option('gmt_offset') > 0 ? '+'.get_option('gmt_offset') : get_option('gmt_offset');
$timezone_string = get_option('timezone_string') ? get_option('timezone_string') : __('UTC ','ultimate-auction-pro-software').$gmt_offset;
if(empty($future_events_no)){$future_events_no =10;}
?>
<section class="currant-and-upcoming-auction">
    <div class="container">
        <div class="section-heading">
            <h4><?php the_sub_field( 'uat_content_future_auction_events_title' ); ?></h4>
            <?php $uat_content_future_auction_events_link = get_sub_field( 'uat_content_future_auction_events_link' ); ?>
            <?php if ( $uat_content_future_auction_events_link ) { ?>
            <a href="<?php echo $uat_content_future_auction_events_link['url']; ?>"
                target="<?php echo $uat_content_future_auction_events_link['target']; ?>"><?php echo $uat_content_future_auction_events_link['title']; ?></a>
            <?php } ?>
        </div>
        <?php
		$selected_datetime ="";
		$event_status = "uat_future";
		$postids = uat_get_all_events_ids($event_status, "DESC", "date", $selected_datetime);
		if (empty($postids)) {
			$postids[] = array();
		}
		$future_past = array (
					'post_type'              => array( 'uat_event' ),
					'post_status'            => array( 'Publish' ),
					'posts_per_page' =>$future_events_no,
		);
		$future_past['post__in'] = $postids;
		// The Query
		$query = new WP_Query( $future_past );
		if ( $query->have_posts() ) { ?>
        <div class="owl-carousel upcoming-auction-slider">
       <?php
		while ( $query->have_posts() ) : $query->the_post();
			$event_id =  get_the_ID();
			$thumb_id = get_post_thumbnail_id();
			$thumb_url = wp_get_attachment_image_src($thumb_id,'events-detail-list-thumbnails');
			$thumb_image_d = UAT_THEME_PRO_IMAGE_URI.'front/product_single_one_default.png';
			$thumb_image = isset($thumb_url[0]) ? $thumb_url[0] : $thumb_image_d;
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
						 <a class="ua-button" href="<?php the_permalink();?>"><img src="<?php echo esc_url($thumb_image);?>"></a>
                    </div>
				<?php
					$timer = get_sub_field('uat_content_future_auction_events_timer');
			if($event_status =="uat_live") { ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?></a>
			<?php } elseif($event_status =="uat_future"){ 
			global $wpdb;
			$event_start_date = $wpdb->get_var('SELECT event_start_date FROM '.UA_EVENTS_TABLE." WHERE post_id=".$event_id);
			$auc_end_date=$event_start_date;
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
			<?php }  } ?>
                    <div class="ua-box-detail">
						<div class="Ua-category"><span class="sr-only"><?php echo __( "Category", 'ultimate-auction-pro-software' ); ?>: </span><?php echo $sr_only_txt;?></div>
						<div class="Ua-box-title"><?php the_title();?></div>
						<div class="Card-details">
						<?php echo date_i18n( get_option('date_format'),strtotime($starting_on_date));  ?>–<?php echo date_i18n( get_option('date_format'),strtotime($ending_date));  ?>
						| <?php echo date_i18n( get_option('time_format'), strtotime( $ending_date ));  ?> <?php echo esc_attr($timezone_string); ?>
						  </div>
					</div>
				<?php
			if($event_status =="uat_live") { ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Bid', 'ultimate-auction-pro-software'); ?></a>
			<?php } elseif($event_status =="uat_future"){ ?>
				 <a class="ua-button" href="<?php the_permalink();?>"><?php _e('Preview', 'ultimate-auction-pro-software'); ?></a>
			<?php } ?>
            </div>
            <?php endwhile; wp_reset_query(); ?>
        </div>
        <?php
		} else {
			echo __( "Future Action Events not found.", 'ultimate-auction-pro-software' );
		} ?>
    </div>
</section>