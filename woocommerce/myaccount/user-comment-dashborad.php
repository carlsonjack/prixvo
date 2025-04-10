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
$datetimeformat = get_option('date_format').' '.get_option('time_format');
$user_id  = get_current_user_id();
$active_tab = get_query_var('ua-comments') ? get_query_var('ua-comments') : 'all';
$my_auction_page_url = wc_get_endpoint_url('ua-comments');
$active_end_point = get_query_var('ua-comments') ? get_query_var('ua-comments') : ''; 
$ua_comment_type = isset($_POST['ua_comment_type']) ? $_POST['ua_comment_type'] : "";
$c_s = isset($_POST['c_s']) ? $_POST['c_s'] : "";
$paged = 1;
$paged_array = explode('/',get_query_var('ua-comments')); 
	if(empty($active_end_point) || count($paged_array)==1){
	$paged = 1;
	} elseif(count($paged_array)==2) {
		$paged = $paged_array[1];
	}else{
		$paged = $paged_array[2];
	}

	//echo "<pre>";
	//print_r($paged_array);
	$args_total = array(
				'orderby' => 'post_date',
				'order' => 'DESC',
				'user_id' => $user_id,
				'count'   => true
				
			);
	if($active_tab =="pending"){
		$args_total['status']="hold";
	}elseif($active_tab =="approved"){
		$args_total['status']=1;
	}elseif($active_tab =="trash"){
		$args_total['status']="trash";
	}
   if(!empty($ua_comment_type)){
	   $args_total['type']=$ua_comment_type;
   }
   if(!empty($c_s)){
	$args_total['search']=$c_s;
   }
	$comments_total = get_comments( $args_total );
	$limit = 10;
    $offset="";
	$offset = ($paged * $limit) - $limit;
	$pages = ceil($comments_total/$limit);	
	$args = array(
				'orderby' => 'post_date',
				'order' => 'DESC',	
				'user_id' => $user_id,
				'offset'=>$offset,
				'number'=>$limit,	
				
			);	
			
		if($active_tab =="pending"){
			$args['status']="hold";
		}elseif($active_tab =="approved"){
			$args['status']=1;
		}elseif($active_tab =="trash"){
			$args['status']="trash";
		}
		if(!empty($ua_comment_type)){
			$args['type']=$ua_comment_type;
		}
		if(!empty($c_s)){
		 $args['search']=$c_s;
		}


	$comments = get_comments( $args );
    $comments_count =count($comments);

?>  <ul class="uat-user-auction-dashboard subsubsub">
        <li class="<?php echo $active_tab == 'all' ? 'active' : '';?>">
            <a href="<?php echo $my_auction_page_url."all/";?>"><?php echo __( 'All', 'ultimate-auction-pro-software' ); ?> (<?php echo uat_front_user_comment_count($user_id, "all"); ?>)</a>
        </li>
		<?php /*<li class="<?php echo $active_tab == 'pending' ? 'active' : '';?>">
			<a href="<?php echo $my_auction_page_url."pending/";?>" class=""><?php echo __( 'Pending', 'ultimate-auction-pro-software' ); ?>(<?php echo uat_front_user_comment_count($user_id, "hold"); ?>)</a>
        </li>
		<li class="<?php echo $active_tab == 'approved' ? 'active' : '';?>">
			<a href="<?php echo $my_auction_page_url."approved/";?>" class=""><?php echo __( 'Approved', 'ultimate-auction-pro-software' ); ?>(<?php echo uat_front_user_comment_count($user_id, "1"); ?>)</a>
        </li>
		<li class="<?php echo $active_tab == 'trash' ? 'active' : '';?>">
			<a href="<?php echo $my_auction_page_url."trash/";?>" class=""><?php echo __( 'Trash', 'ultimate-auction-pro-software' ); ?>(<?php echo uat_front_user_comment_count($user_id, "trash"); ?>)</a>
        </li>*/ ?>
	</ul>
	
	<?php /*
    <div class="my-ac-comment-tb">
		
	<div class="alignleft actions">
		<form action="" method="post" class="my-ac-comment-filter">
			<label class="screen-reader-text" for="filter-by-comment-type"><?php echo __( 'Filter by comment type', 'ultimate-auction-pro-software' ); ?></label>
			<select id="filter-by-comment-type" name="ua_comment_type">	
				<option value=""><?php echo __( 'All comment types', 'ultimate-auction-pro-software' ); ?></option>	
				<option value="ua_comment" <?php selected( "ua_comment", $ua_comment_type ); ?> ><?php echo __( 'UA Comments', 'ultimate-auction-pro-software' ); ?></option>
				<option value="review" <?php selected( "review", $ua_comment_type ); ?> ><?php echo __( 'Woocomerce Review', 'ultimate-auction-pro-software' ); ?></option>
				<option value="comment" <?php selected( "comment", $ua_comment_type ); ?> ><?php echo __( 'Comments', 'ultimate-auction-pro-software' ); ?></option>
			
			</select>
			<input type="submit" name="filter_action" id="post-query-submit" class="button" value="<?php echo __( 'Filter', 'ultimate-auction-pro-software' ); ?>">

		</form>
		<form action="" method="post" class="my-ac-comment-search">
		<p class="search-box">
	<label class="screen-reader-text" for="comment-search-input"><?php echo __( 'Search Comments', 'ultimate-auction-pro-software' ); ?>:</label>
	<input type="search" id="comment-search-input" name="c_s" value="<?php if(!empty($c_s)){ echo $c_s; }?>">
		<input type="submit" id="search-submit" class="button" value="<?php echo __( 'Search Comments', 'ultimate-auction-pro-software' ); ?>"></p>
		</form>
		</div>
	</div>
	*/ ?>
	<?php if (  $comments_count > 0 ) { ?>	
	   <table class=" tbl_bidauc_list uat_table" style="margin-bottom:30px;">
		   <tr class="comment_heading">
				<th class="toptable"><?php echo __( 'Product', 'ultimate-auction-pro-software' ); ?></td>
				<th style="width:64%" class="toptable" colspan="2"><?php echo __( 'Comment', 'ultimate-auction-pro-software' ); ?></td>
				<th class="toptable"><?php echo __( 'Submitted On', 'ultimate-auction-pro-software' ); ?></td>
		   </tr>
		   <?php		   
		  foreach ( $comments as $comment ) :			 
				   $response_to = get_the_title( $comment->comment_post_ID );
				   $product_url  = get_the_permalink( $comment->comment_post_ID );				   
				   ?>
				   <tr class="comments_content">	
						<td class="comment_response_to"><a href="<?php echo $product_url; ?>"><?php echo $response_to ?></a></td>
						<td class="comment_content" colspan="2"><?php echo $comment->comment_content ?></td>
						<td class="comment_date"><?php echo mysql2date($datetimeformat, $comment->comment_date); ?></td>
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
	<?php } else { ?>
		
		 <table class="tbl_bidauc_list uat_table">
		   <tr class="comment_heading">			   
			   <th class="toptable" colspan="2"><?php echo __( 'Comment', 'ultimate-auction-pro-software' ); ?></td>
			   <th class="toptable"><?php echo __( 'In Response to', 'ultimate-auction-pro-software' ); ?></td>
			   <th class="toptable"><?php echo __( 'Submitted On', 'ultimate-auction-pro-software' ); ?></td>
		   </tr>
		   <tr class="comments_content">
		   <td class="comment_content" colspan="4"><?php _e( 'Nothing yet.' , 'ultimate-auction-pro-software' ); ?></td>
			</tr>
			</table>
		
	<?php } ?>
	
	