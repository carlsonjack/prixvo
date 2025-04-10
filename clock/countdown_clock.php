<?php
function countdown_clock(
    $end_date,
	$item_id,
	$item_class   
)
{
	 
	$clocktype =get_option('options_timer_type',"timer_jquery");
	if($clocktype=='timer_jquery'){
		$end_date;
		$product_id=$item_id;
		$uwa_countdown_format = get_option( 'woo_ua_auctions_countdown_format' );
		$uwa_time_zone =  (array)wp_timezone();
		$sinceday  =  wp_date('M j, Y H:i:s O',time(), wp_timezone());
		?>
		<script>
			var servertime='<?php echo $sinceday;?>';
		</script>
		<div class="uwa_auction_product_countdown <?php echo $item_class;?> clock_jquery " 
		data-time="<?php echo $end_date;?>" 
		data-auction-id="<?php echo esc_attr( $product_id ); ?>" 
		data-format="<?php echo $uwa_countdown_format; ?>"  
		data-timezonetype="<?php echo $uwa_time_zone['timezone_type']; ?>" 
		data-zone="<?php echo $uwa_time_zone['timezone']; ?>"  ></div>
		<?php
	}else{
		$product_id=$item_id;
		$rem_arr=get_remaining_time_by_timezone($end_date);
		$jscookie=json_encode($rem_arr);
		
		global $pagenow;
		$isadmin = ( $pagenow != 'widgets.php' )?"data-isadmin='admin'":""; 
		?>
		<script>
			setCookie("acution_antisniping_time_<?php echo $product_id;?>", JSON.stringify(<?php echo $jscookie;?>), '7');
			setCookie("acution_sync_time_<?php echo $product_id;?>", JSON.stringify(<?php echo $jscookie;?>), '7');
		</script>
		<div id="auction-countdown-check" class="uwa_auction_product_countdown  <?php echo $item_class;?> clock_server " 
			<?php echo $isadmin; ?>	
			data-time=""
			data-auction-id="<?php echo esc_attr( $product_id ); ?>" 			
			data-days="<?php  echo $rem_arr['days'] ?>"
			data-hours="<?php echo $rem_arr['hours'] ?>"
			data-minute="<?php echo $rem_arr['minute'] ?>"
			data-sec="<?php  echo $rem_arr['sec'] ?>"
		>
		</div>

 	
		<?php
	}
}



function event_countdown_clock(
    $end_date,
	$item_id,
	$item_class   
)
{
	global $wpdb;
	$clocktype =get_option('options_timer_type',"timer_jquery");
	if($clocktype=='timer_jquery'){
		
		$end_date;
		$event_id=$item_id;

		$post_id = $wpdb->get_var('SELECT post_id FROM '.$wpdb->prefix."ua_auction_product WHERE event_id=".$event_id);
				
		$uwa_countdown_format = get_option( 'woo_ua_auctions_countdown_format' );
		$uwa_time_zone =  (array)wp_timezone();
		$sinceday  =  wp_date('M j, Y H:i:s O',time(), wp_timezone());
		?>
		<script>
			var servertime='<?php echo $sinceday;?>';
		</script>
		<div class="uwa_auction_product_countdown <?php echo $item_class;?> clock_jquery " 
		data-time="<?php echo $end_date;?>" 
		data-auction-id="<?php echo esc_attr( $post_id ); ?>" 
		data-uatevent-id="<?php echo $event_id;?>"
		data-format="<?php echo $uwa_countdown_format; ?>"  
		data-timezonetype="<?php echo $uwa_time_zone['timezone_type']; ?>" 
		data-zone="<?php echo $uwa_time_zone['timezone']; ?>"  ></div>
		<?php
		
	}else{
		$event_id=$item_id;
		$rem_arr=get_remaining_time_by_timezone($end_date);
		$jscookie=json_encode($rem_arr);
		
		global $pagenow;
		
		?>
				
		<div data-uatevent-id="<?php echo $event_id;?>" class="<?php echo $item_class;?> clock_server" 
					data-days="<?php  echo $rem_arr['days'] ?>"
					data-hours="<?php echo $rem_arr['hours'] ?>"
					data-minute="<?php echo $rem_arr['minute'] ?>"
					data-sec="<?php  echo $rem_arr['sec'] ?>"
					>
		</div>

 	
		<?php
	}
}
function antisniping_check(){
	$uwa_auto_extend_when = get_option('uwa_auto_extend_when');
	$uwa_auto_extend_when_m = get_option('uwa_auto_extend_when_m');
	$uwa_auto_extend_time = get_option('uwa_auto_extend_time');
	$uwa_auto_extend_time_m = get_option('uwa_auto_extend_time_m');	
	$re="no";
	if(!empty($uwa_auto_extend_when) || !empty($uwa_auto_extend_when_m)){
		if(!empty($uwa_auto_extend_time) || !empty($uwa_auto_extend_time_m)){
			$re="yes";
		}
	}
	return $re;
}
?>