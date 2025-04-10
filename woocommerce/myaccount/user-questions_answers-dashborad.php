<?php
/**
 * My auctions tab list
 *
 * @package Ultimate WooCommerce Auction PRO
 * @author Nitesh Singh
 * @since 1.0
 *
 */
if (!defined('ABSPATH')) {
	exit;
}

global $wpdb,$product,$woocommerce,$sitepress;
$prefix = $wpdb->prefix;
$ua_auction_question=$prefix . 'ua_auction_question'; 
$ua_auction_answer=$prefix . 'ua_auction_answer'; 
$datetimeformat = get_option('date_format').' '.get_option('time_format');
$user_id  = get_current_user_id();

 
$active_tab = get_query_var('questions-answers') ? get_query_var('questions-answers') : 'all'; 
$active_end_point = get_query_var('questions-answers') ? get_query_var('questions-answers') : ''; 
$my_auction_page_url = wc_get_endpoint_url('questions-answers');
 
$c_s = isset($_POST['c_s']) ? $_POST['c_s'] : "";
$paged = 1;
$paged_array = explode('/',get_query_var('questions-answers')); 
	if(empty($active_end_point) || count($paged_array)==1){
	$paged = 1;
	} elseif(count($paged_array)==2) {
		$paged = $paged_array[1];
	}else{
		$paged = $paged_array[2];
	}
	 
	$issearch="";
	if(!empty($c_s)){ 
		$issearch=" AND question_text LIKE '%".$c_s."%'";
	}
 
	$setwhere="";
	if(strpos( $active_tab, 'pending') !== false){
		$setwhere=" AND status='deactive' ";
	}elseif(strpos( $active_tab, 'approved') !== false ){
		$setwhere=" AND status='active' ";
	}
	
 if(strpos( $active_tab, 'see-answer') !== false){
	$answers_id=$paged;

	$isansavailable=0;
	$sql="SELECT * FROM ".$ua_auction_answer." where answers_id=".$answers_id;
	$qa_re = $wpdb->get_results($sql);
	$anscontent="";
	$post_id=0;
	$question_id=0;
	foreach($qa_re as $val){
		$anscontent='<strong>Answers :</strong><span>'.$val->answer_text.'</span> ';
		$question_id=$val->question_id;
	}
	$sql_qna="SELECT * FROM ".$ua_auction_question." where question_id=".$question_id;
	$qa_re = $wpdb->get_results($sql_qna);
	$post_id=$qa_re[0]->post_id;
	$question_text=$qa_re[0]->question_text;
 ?>
	 
	 <div class="quastion-details quastion-details-inline">
      <h2 class="hndle ui-sortable-handle"><?php echo __( 'Questions &amp; Answers - Question information', 'ultimate-auction-pro-software' ); ?></h2>
      <div class="inside-details">
        <h3><strong><?php echo __( 'Product', 'ultimate-auction-pro-software' ); ?></strong><a href="<?php echo get_permalink($post_id);?>"><?php echo get_the_title($post_id);?></a></h3>
        <h3><strong><?php echo __( 'Question', 'ultimate-auction-pro-software' ); ?> :</strong><span><?php echo $question_text; ?></span><a href="#"><?php echo __( 'Go to question', 'ultimate-auction-pro-software' ); ?></a></h3>
        <h3 id="ans_result">
		<?php
			echo $anscontent;	
		?>
		</h3>
      </div>
     </div>
	 <?php 
	 
 }else{
 

	$sql_sts_count="SELECT * FROM ".$ua_auction_question." as qa,".$prefix."posts as pt  where pt.ID=qa.post_id AND asked_by_id=".$user_id. $issearch.$setwhere;
	$user_qa_list_count =   $wpdb->get_results($sql_sts_count);
	$user_qa_list_count =count($user_qa_list_count);
	

    
	
	$user_qa_list_total =$user_qa_list_count;
	$limit = 10;
    $offset="";
	$offset = ($paged * $limit) - $limit;
	$pages = ceil($user_qa_list_total/$limit);	
 
 	$sql_sts="SELECT * FROM ".$ua_auction_question." as qa,".$prefix."posts as pt  where pt.ID=qa.post_id AND asked_by_id=".$user_id . $issearch.$setwhere." LIMIT $limit OFFSET ".$offset;
	$user_qa_list =   $wpdb->get_results($sql_sts);
	
	$qa_re_all = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where asked_by_id=".$user_id );
	$all_count=count($qa_re_all);
	$qa_re_pending = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where status='deactive' AND asked_by_id=".$user_id );
	$pending_count=count($qa_re_pending);
	$qa_re_approved = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where status='active' AND asked_by_id=".$user_id );
	$approved_count=count($qa_re_approved);

?> 
	
	<ul class="uat-user-auction-dashboard subsubsub">
        <li class="<?php echo $active_tab == 'all' ? 'active' : '';?>">
            <a href="<?php echo $my_auction_page_url."all/";?>"><?php echo __( 'All', 'ultimate-auction-pro-software' ); ?> (<?php echo $all_count; ?>)</a>
        </li>
		<?php /*
		<li class="<?php echo $active_tab == 'pending' ? 'active' : '';?>">
			<a href="<?php echo $my_auction_page_url."pending/";?>" class=""><?php echo __( 'Pending', 'ultimate-auction-pro-software' ); ?>(<?php echo $pending_count; ?>)</a>
        </li>
		<li class="<?php echo $active_tab == 'approved' ? 'active' : '';?>">
			<a href="<?php echo $my_auction_page_url."approved/";?>" class=""><?php echo __( 'Approved', 'ultimate-auction-pro-software' ); ?>(<?php echo $approved_count; ?>)</a>
        </li>*/ ?>
	
	</ul>
	
    <div class="my-ac-comment-tb">
		
	<div class="alignleft actions">
		 
		<form action="" method="post" class="my-ac-comment-search">
		<p class="search-box">
		<label class="screen-reader-text" for="comment-search-input"><?php echo __( 'Search Questions', 'ultimate-auction-pro-software' ); ?>:</label>
		<input type="search" id="comment-search-input" name="c_s" value="<?php if(!empty($c_s)){ echo $c_s; }?>">
		<input type="submit" id="search-submit" class="button" value="Search Questions"></p>
		</form>
		</div>
	</div>
	<?php if (  $user_qa_list_count > 0 ) { ?>	
	   <table class=" tbl_bidauc_list uat_table" style="margin-bottom:30px;">
		   <tr class="comment_heading">			   
			   <?php /*<th style="width:10%" class="toptable" ><?php echo __( 'Event', 'ultimate-auction-pro-software' ); ?></td> */ ?>
			   <th style="width:20%" class="toptable" ><?php echo __( 'Auction', 'ultimate-auction-pro-software' ); ?></td>
			   <th style="width:20%" class="toptable" colspan="2"><?php echo __( 'Question', 'ultimate-auction-pro-software' ); ?></td>
			   <?php /*<th class="toptable"><?php echo __( 'Is it Approved?', 'ultimate-auction-pro-software' ); ?></td>*/ ?>
			   <th style="width:15%" class="toptable"><?php echo __( 'Submitted On', 'ultimate-auction-pro-software' ); ?></td>
			   <th style="width:45%" class="toptable"><?php echo __( 'Answer ', 'ultimate-auction-pro-software' ); ?></td>
		   </tr>
		   <?php		   
		  foreach ( $user_qa_list as $user_qa_list_val ) :			 
			 	   $qa_id=$user_qa_list_val->question_id;
			 	   $post_id=$user_qa_list_val->post_id;
			 		$product = wc_get_product(  $post_id );
					$uat_event_id = get_post_meta($post_id, 'uat_event_id', true);
				 
			 		   
				   ?>
				   <tr class="comments_content">
					  <?php /*if(!empty($uat_event_id)){?>
								<td class="comment_content"  ><?php echo get_the_title(  $uat_event_id );?></td>
					  <?php }else{ ?>
							 <td class="comment_content"  >NA</td>
					  <?php } */ ?>	
					   <td class="comment_content"  ><a href="<?php echo get_permalink($post_id); ?> "><?php echo $product->get_title();?></a></td>
					   <td class="comment_content" colspan="2"><?php echo $user_qa_list_val->question_text ?></td>
					  <?php /*<td class="comment_response_to">
					   
					   $status = $user_qa_list_val->status;
					   /*if($status=='active'){
							echo 'Yes';
						}else{
							echo 'No';
						}
						
						
					   ?>
					   </td> */ ?>
					   <?php $sql="SELECT * FROM ".$ua_auction_answer." where question_id=".$qa_id;
						$qa_re = $wpdb->get_results($sql);
						$ansdate="";
						$isans=0;
						$isans_id=0;
						foreach($qa_re as $val){
							
							$ansdate=$val->created_date;
							$isans=1;
							$isans_id=$val->answers_id;
						}
						?>
					   <td class="comment_date asf"><?php echo mysql2date($datetimeformat,$ansdate); ?></td>
					   <td class="comment_date">
						<?php if($isans==1){?>
						<?php 
							$sql="SELECT * FROM ".$ua_auction_answer." where answers_id=".$isans_id;
							$qa_re = $wpdb->get_results($sql);
							$anscontent="";
							$post_id=0;
							$question_id=0;
							foreach($qa_re as $val){
								$anscontent=$val->answer_text;
								//$question_id=$val->question_id;
							}
						echo $anscontent;
						?>
						
						<?php } ?>
					   </td>
					    
					   
				   </tr>			  
			<?php endforeach; ?>
	   </table>	  
	   
	   <nav class="woocommerce-pagination">
	<?php
	$format  = isset( $format ) ? $format : '';
	echo paginate_links(
		apply_filters(
			'woocommerce_pagination_args',
			array( // WPCS: XSS ok.
			'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'total'     => $pages,
				'current'   => max( 1, $paged ),
				'format'    => $format,
				  'show_all'     => false,
				'add_args'  => false,
				'type'      => 'list',
				
				
				'prev_text' => is_rtl() ? '&rarr;' : '&larr;',
				'next_text' => is_rtl() ? '&larr;' : '&rarr;',
				
				'end_size'  => 2,
				'mid_size'  => 1,
			)
		)
	);
	?>
</nav>

<div class="woocommerce-pagination">
		<?php
	    
	   
		} 	else {	 ?>
		 <table class=" tbl_bidauc_list uat_table">
		   <tr class="comment_heading">			   
				<?php /*<th style="width:10%" class="toptable" ><?php echo __( 'Event', 'ultimate-auction-pro-software' ); ?></td> */?>
				<th style="width:20%" class="toptable" ><?php echo __( 'Auction', 'ultimate-auction-pro-software' ); ?></td>
				<th style="width:26.66%" class="toptable" colspan="2"><?php echo __( 'Question', 'ultimate-auction-pro-software' ); ?></td>
				<th class="toptable"><?php echo __( 'In Response to', 'ultimate-auction-pro-software' ); ?></td>
				<th class="toptable"><?php echo __( 'Submitted On', 'ultimate-auction-pro-software' ); ?></td>
		   </tr>
		   </tr>
		   <tr class="comments_content">
		   <td class="comment_content" colspan="6"><?php _e( 'Nothing yet.' , 'ultimate-auction-pro-software' ); ?></td>
			</tr>
			</table>	 
	<?php } ?>
	</div>
	
	
 <?php } ?>