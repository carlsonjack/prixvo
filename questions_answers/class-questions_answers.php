<?php
require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/admin/tpl-questions_answers_setting.php');
function add_q_and_a(){
ob_clean();
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_question=$prefix . 'ua_auction_question';
$question_text=$_REQUEST['question_text'];
$asked_by_id=$_REQUEST['asked_by_id'];
$post_id=$_REQUEST['post_id'];
$author_id = get_post_field( 'post_author', $post_id );
$auction_array = array();
$auction_array['question_text'] = $question_text;
$auction_array['asked_by_id'] = $asked_by_id;
$auction_array['post_id'] = $post_id;
$auction_array['post_owner_id'] = $author_id ;
$q_a_auction_approval_by_seller = get_option( 'options_q_a_auction_approval_by_seller', 'off' );
if($q_a_auction_approval_by_seller=='on'){
	$auction_array['status'] = 'deactive';
}else{
	$auction_array['status'] = 'active';
}
$auction_array['created_date'] = date('Y-m-d H:i:s');
$wpdb->insert($ua_auction_question, $auction_array);
echo $insert_id = $wpdb->insert_id;

echo $q_a_auction_email_notification_question = get_option( 'options_q_a_auction_email_notification_question', 'off' );
if($q_a_auction_email_notification_question=='on'){
	$mail = new QuestionMail();
	  $mail->question_email($insert_id);


}


wp_die();
 }
add_action( 'wp_ajax_nopriv_add_q_and_a', 'add_q_and_a' );
add_action( 'wp_ajax_add_q_and_a', 'add_q_and_a' );
function qa_list_callback(){
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_question=$prefix . 'ua_auction_question';
$ua_auction_answer=$prefix . 'ua_auction_answer';
$site_url=site_url();
$action="";
$qa_id="";
if(!empty($_REQUEST['action'])) {
	$action=$_REQUEST['action'];
}
if(!empty($_REQUEST['qa_id'])) {
	$qa_id=$_REQUEST['qa_id'];
}
if($action=='del_ans'){
$ans_id="";
if(!empty($_REQUEST['ans_id'])) {
	$ans_id=$_REQUEST['ans_id'];
}
	$wpdb->query("DELETE FROM `".$ua_auction_answer."` WHERE `answers_id` = ".$ans_id);
	$action="show";
	$url=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&action=show&qa_id='.$qa_id.'&msg=2';
	wp_redirect( $url );
	exit;
}
if($action=='del'){
	$wpdb->query("DELETE FROM `".$ua_auction_question."` WHERE `question_id` = ".$qa_id);
	$url=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&msg=1';
	wp_redirect( $url );
	exit;
}
if($action=='status'){
	  $sql_sts="SELECT * FROM ".$ua_auction_question." where question_id=".$qa_id;
	$qa_re = $wpdb->get_results($sql_sts);
	if($qa_re[0]->status=='active'){
		$wpdb->query("UPDATE `".$ua_auction_question."` SET `status` = 'deactive' WHERE `question_id` = ".$qa_id);
	}else{
		$wpdb->query("UPDATE `".$ua_auction_question."` SET `status` = 'active' WHERE `question_id` = ".$qa_id);
	}
	$url=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&msg=3';
	wp_redirect( $url );
	exit;
}
$filter="";
if(!empty($_REQUEST['filter'])) {
	$filter=$_REQUEST['filter'];
}
$filter_set="";
$all_count=0;
$pending_count=0;
$approved_count=0;
if($filter=='pending'){
	$filter_set=" where status='deactive'";
}
else if($filter=='approved'){
	$filter_set="where  status='active'";
}
	$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." $filter_set ");
	$popHTLM='';
	$qa_re_all = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." ");
	$all_count=count($qa_re_all);
	$qa_re_pending = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where status='deactive' ");
	$pending_count=count($qa_re_pending);
	$qa_re_approved = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where status='active' ");
	$approved_count=count($qa_re_approved);
$msg="";
if(!empty($_REQUEST['msg'])) {
	$msg=$_REQUEST['msg'];
}
	echo '<br>';
	$strmsg="";
	$strmsgstyle="";
	if($msg==1){
			$strmsg= __('Record Deleted Successfully', 'ultimate-auction-pro-software');
		}
		if($msg==2){
			$strmsg= __('Record Deleted Successfully', 'ultimate-auction-pro-software');
				$strmsgstyle="style='color:red'";
		}
		if($msg==3){
			$strmsg= __('Status Updated Successfully', 'ultimate-auction-pro-software');
		}
		if($msg==4){
			$strmsg= __('Record Added Successfully', 'ultimate-auction-pro-software');
		}
	echo '<div id="dis_msg" '.$strmsgstyle.'>'.$strmsg.'</div>';

	echo '<ul class="uat-user-auction-dashboard subsubsub">
        <li class="active">
            <a href="'.$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&filter=all">'.__('All ', 'ultimate-auction-pro-software').' ('.$all_count.')</a>
        </li>
		<li class="">
			<a href="'.$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&filter=pending" class="">'.__('Pending', 'ultimate-auction-pro-software').' ('.$pending_count.')</a>
        </li>
		<li class="">
			<a href="'.$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&filter=approved" class="">'.__('Approved', 'ultimate-auction-pro-software').' ('.$approved_count.')</a>
        </li>
	</ul>';
	echo '<br>';
	$addnew=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&action=add';
	echo '<div class="top-tab-header"><a href="'.$addnew.'" class="add-new-q">Add new</a></div>';
	wp_enqueue_style( 'uat-theme-qa-admin', UAT_THEME_PRO_CSS_URI.'uat-theme-qa-admin.css', array(), UAT_THEME_PRO_VERSION );
	if($action=='add'){
		 require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/admin/tpl-questions_answers_add.php');
	}
	if($action==''){
		 require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/admin/tpl-questions_answers_list.php');
	}
	if($action=='edit'){
		 require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/admin/tpl-questions_answers_edit.php');
	}
	if($action=='show'){
		require_once(UAT_THEME_PRO_INC_DIR . 'questions_answers/admin/tpl-questions_answers_show.php');
	}
}
 function add_ans_fun(){
ob_clean();
global $wpdb;
$prefix = $wpdb->prefix;
 $ua_auction_answer=$prefix . 'ua_auction_answer';
  $question_text=$_REQUEST['question_text'];
  $asked_by_id=$_REQUEST['asked_by_id'];
  $post_id=$_REQUEST['post_id'];
$auction_array = array();
$auction_array['answer_text'] = $question_text;
$auction_array['answered_by_id'] = $asked_by_id;
$auction_array['question_id'] = $post_id;
$auction_array['status'] = 'active';
$auction_array['created_date'] = date('Y-m-d H:i:s');
$wpdb->insert($ua_auction_answer, $auction_array);
	echo  $insert_id = $wpdb->insert_id;


	$q_a_auction_email_notification_answer_user = get_option( 'options_q_a_auction_email_notification_answer_user','off' );
if($q_a_auction_email_notification_answer_user=='on'){
	$mail = new AnswerMail();
	$mail->answer_email($insert_id);

}


wp_die();
 }
 // creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_add_ans_fun', 'add_ans_fun' );
add_action( 'wp_ajax_add_ans_fun', 'add_ans_fun' );
function edit_q_and_a(){
ob_clean();
global $wpdb;
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_question=$prefix . 'ua_auction_question';
$question_text=$_REQUEST['question_text'];
$asked_by_id=$_REQUEST['asked_by_id'];
$post_id=$_REQUEST['post_id'];
$question_id=$_REQUEST['question_id'];
$wpdb->query( $wpdb->prepare("UPDATE $ua_auction_question   SET question_text = %s  WHERE question_id = %s",$question_text, $question_id)
);
wp_die();
 }
 // creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_edit_q_and_a', 'edit_q_and_a' );
add_action( 'wp_ajax_edit_q_and_a', 'edit_q_and_a' );
 function add_ans_fun_pop(){
ob_clean();
global $wpdb;
$prefix = $wpdb->prefix;
 $ua_auction_answer=$prefix . 'ua_auction_answer';
  $ans_text=$_REQUEST['ans_text'];
  $answered_by_id=$_REQUEST['answered_by_id'];
  $question_id=$_REQUEST['question_id'];
$auction_array = array();
$auction_array['answer_text'] = $ans_text;
$auction_array['answered_by_id'] = $answered_by_id;
$auction_array['question_id'] = $question_id;
$auction_array['status'] = 'active';
$auction_array['created_date'] = date('Y-m-d H:i:s');
$wpdb->insert($ua_auction_answer, $auction_array);
	 $insert_id = $wpdb->insert_id;
	 $mail = new AnswerMail();
$mail->answer_email($insert_id);
$user_info = get_userdata($answered_by_id);
$display_name = $user_info->display_name;

$attachment_id = get_user_meta( $answered_by_id, 'image', true );
$custom_avatar_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' ); 

if ( $custom_avatar_url ) {
	
	$answered_img =  $custom_avatar_url;

}else{

	$answered_img=esc_url( get_avatar_url( $answered_by_id ) );

}


echo '<div class="comment-thred">
   <div class="c-uder-detail-head"> <img class="comment-user-img" src="'.$answered_img.'"> </div>
   <div class="comment-text-box-details">
	  <div class="comment-user-name">
		 <span class="c-user-image">'.$display_name.'</span>
		 <a class="vote-icon-in-popup vote-icon "   href="javascript:;" data-qid="'.$question_id.'" ><svg class="reputation" width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-labelledby="ir-6r6jfi1YSir"><title id="ir-6r6jfi1YSir">Reputation Icon</title><path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>
		 <span class="vote_count_total25 q_vote" >('.q_vote_count($question_id).')</span>
		 </a><a class="time-to-comment" href="javascript:;"><small class="dyas-ago-time">'.meks_convert_to_time_ago( $orig_time=date('Y-m-d H:i:s') ).'</small></a>
	  </div>
	  <div class="comment-text">
		 <p><strong>A: </strong>'.$ans_text.'</p>
	  </div>
   </div>
</div>';
wp_die();
 }
 // creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_add_ans_fun_pop', 'add_ans_fun_pop' );
add_action( 'wp_ajax_add_ans_fun_pop', 'add_ans_fun_pop' );
function q_vote_fun(){
ob_clean();
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_vote=$prefix . 'ua_auction_vote';
$question_id=$_REQUEST['question_id'];
$voter_id=$_REQUEST['voter_id'];
$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_vote." where question_id=".$question_id." AND voter_id=".$voter_id);
if(count($qa_re)>0){
	$sql_del="DELETE FROM `".$ua_auction_vote."` WHERE `question_id` = ".$question_id." AND voter_id=".$voter_id;
	$wpdb->query($sql_del);
	$user_id = $voter_id;
	    $u_votes = get_user_meta( $user_id, 'user_votes', true );
	  $c=0;
	   $c=$u_votes-1;
	update_user_meta( $user_id, 'user_votes', $c);
}else{
	$question_text=$_REQUEST['question_text'];
	$asked_by_id=$_REQUEST['asked_by_id'];
	$post_id=$_REQUEST['post_id'];
	$auction_array = array();
	$auction_array['question_id'] = $question_id;
	$auction_array['voter_id'] = $voter_id;
	$auction_array['created_date'] = date('Y-m-d H:i:s');
	$wpdb->insert($ua_auction_vote, $auction_array);
	$insert_id = $wpdb->insert_id;
	$user_id = $voter_id;
	  $u_votes = get_user_meta( $user_id, 'user_votes', true );
	  $c=0;
	  $c=$u_votes+1;
	update_user_meta( $user_id, 'user_votes', $c);
}
$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_vote." where question_id=".$question_id."");
echo count($qa_re);
wp_die();
 }
 // creating Ajax call for WordPress
add_action( 'wp_ajax_nopriv_q_vote_fun', 'q_vote_fun' );
add_action( 'wp_ajax_q_vote_fun', 'q_vote_fun' );
function q_vote_count($question_id){
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_vote=$prefix . 'ua_auction_vote';
$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_vote." where question_id=".$question_id);
return count($qa_re);
}
function user_vote_count($user_id){
global $wpdb;
$prefix = $wpdb->prefix;
$u_votes = get_user_meta( $user_id, 'user_votes', true );
return $u_votes;
}
function meks_convert_to_time_ago( $orig_time ) {
	$orig_time = strtotime( $orig_time );
	return human_time_diff( $orig_time, current_time( 'timestamp' ) ).' '.__( 'ago', 'ultimate-auction-pro-software' );
}
function qa_pagination_fun(){
ob_clean();
$perpage=10;
  $limit=$perpage;
$setpage=$_REQUEST['setpage'];
$setpage=$setpage;
  $paged=$setpage;
 $offset = ($paged * $limit) - $limit;
global $wpdb;
$prefix = $wpdb->prefix;
$ua_auction_question=$prefix . 'ua_auction_question';
$ua_auction_answer=$prefix . 'ua_auction_answer';
$datetimeformat = get_option('date_format').' '.get_option('time_format');
$filter_set="";
if($_REQUEST['filter_flt']=='pending'){
	$filter_set=" where status='deactive'";
}
else if($_REQUEST['filter_flt']=='approved'){
	$filter_set="where  status='active'";
}
$qa_re_count = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." $filter_set ");
$curent_count = $perpage*$setpage;
$filter_set="";
if($_REQUEST['filter_flt']=='pending'){
	$filter_set=" where status='deactive'";
}
else if($_REQUEST['filter_flt']=='approved'){
	$filter_set="where  status='active'";
}
$qa_re_count = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." $filter_set ");
$curent_count = $perpage*$setpage;
$sqllist="SELECT * FROM ".$ua_auction_question." $filter_set LIMIT $perpage OFFSET ".$offset;
$qa_re = $wpdb->get_results($sqllist);
$site_url=site_url();
foreach($qa_re as $key => $row) {
	$question_id = $row->question_id;
	$user_info = get_userdata($row->asked_by_id);
	$display_name = $user_info->display_name;
	$status = $row->status;
	$qnadate = $row->created_date;
	$asked_img=esc_url( get_avatar_url( $row->asked_by_id ) );
	$question_text = $row->question_text;
	$qa_id=$row->question_id;
	$post_id=$row->post_id;
	$product = wc_get_product(  $post_id );
	$product_type = 'auction'; // <== Here define your product type slug
	$class_name   = WC_Product_Factory::get_classname_from_product_type($product_type); // Get the product Class name

	// If the product class exist for the defined product type
	if (!empty($class_name) && class_exists($class_name)) {
		$product = new $class_name($product); // Get an empty instance of a grouped product Object
	}
	$uat_event_id = get_post_meta($post_id, 'uat_event_id', true);
	?>
	<div class="tr">
	<div class="table-td  Event-Name"><?php echo get_the_title(  $uat_event_id );?></div>

	<div class="table-td Product-Name"><?php echo get_the_title(  $post_id );?></div>
	<div class="table-td  Who-Asked "><?php echo $question_id;?> <?php echo $display_name;?></div>
	<div class="table-td Question-details"><?php echo $question_text;?></div>
	<div class="table-td Is-it-Approved">
	<?php
	if($status=='active'){
		echo _e('Yes', 'ultimate-auction-pro-software');
	}else{
		echo _e('No', 'ultimate-auction-pro-software');
	}
	?>
	</div>
	<div class="table-td Submitted-On"><?php echo mysql2date($datetimeformat,$qnadate); ?></div>
	<div class="table-td Actions-details">
		<div class="Button-row">
			<a class="view-btn" href="<?php echo $site_url ?>/wp-admin/admin.php?page=ua-auctions-qa&action=show&qa_id=<?php echo $question_id;?>" ><img src="<?php echo get_template_directory_uri(); ?>/assets/images/admin/view.png"> <span><?php echo _e('Show', 'ultimate-auction-pro-software'); ?></span></a>
			<a class="edit-btn" href="<?php echo $site_url ?>/wp-admin/admin.php?page=ua-auctions-qa&action=edit&qa_id=<?php echo $question_id;?>" ><span><?php echo _e('Edit', 'ultimate-auction-pro-software'); ?></span></a>
			<?php
			if($row->status=='active'){ ?>
				<a class="view-btn" href="<?php echo $site_url; ?>/wp-admin/admin.php?page=ua-auctions-qa&action=status&qa_id=<?php echo $question_id;?>" ><span><?php echo _e('Deactive', 'ultimate-auction-pro-software'); ?></span></a>
			<?php }else{ ?>
				<a class="view-btn" href="<?php echo $site_url; ?>/wp-admin/admin.php?page=ua-auctions-qa&action=status&qa_id=<?php echo $question_id;?>" ><span><?php echo _e('Active', 'ultimate-auction-pro-software'); ?></span></a>
			<?php  } ?>
				<a class="delete-btn" href="<?php echo $site_url; ?>/wp-admin/admin.php?page=ua-auctions-qa&action=del&qa_id=<?php echo $question_id;?>" ><span><?php echo _e('Delete', 'ultimate-auction-pro-software'); ?></span></a>
		</div>
	</div>
	</div>
	<script>
		<?php if(count($qa_re_count)>$curent_count){?>
			jQuery('#qa_list_loadmore').show();
		<?php }else{?>
			jQuery('#qa_list_loadmore').hide();
		<?php } ?>
	</script>
<?php } ?>


<?php  if(count($qa_re)==0) {   ?>
<?php echo __('Record not found !', 'ultimate-auction-pro-software'); ?>
<script> jQuery('#qa_list_loadmore').hide();
 </script>

<?php }

wp_die();
}
add_action( 'wp_ajax_nopriv_qa_pagination_fun', 'qa_pagination_fun' );
add_action( 'wp_ajax_qa_pagination_fun', 'qa_pagination_fun' );