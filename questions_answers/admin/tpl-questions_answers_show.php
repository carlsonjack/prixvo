<?php
	$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where question_id=".$qa_id);
	$question_id=$qa_re[0]->question_id;
	$post_id=$qa_re[0]->post_id;
?>
		<form id="frm_qa_admin" name="frm_qa_admin"  method="post" id="" class="ask-q" autocomplete="off" novalidate="">
<div class="d-flex-left-right-block">
  <div class="left-block">
     <div class="quastion-details quastion-details-inline">
      <h2 class="hndle ui-sortable-handle"><?php echo __( 'Questions &amp; Answers - Question information', 'ultimate-auction-pro-software' ); ?></h2>
      <div class="inside-details">
        <h3><strong><?php echo __( 'Select product', 'ultimate-auction-pro-software' ); ?></strong><a href="<?php echo get_permalink($post_id);?>"><?php echo get_the_title($post_id);?></a></h3>
        <h3><strong><?php echo __( 'Question', 'ultimate-auction-pro-software' ); ?> :</strong><span><?php echo $qa_re[0]->question_text; ?></span><a href="#"><?php echo __( 'Go to question', 'ultimate-auction-pro-software' ); ?></a></h3>
        <h3 id="ans_result">
		<?php
				$isansavailable=0;
				   $sql="SELECT * FROM ".$ua_auction_answer." where question_id=".$qa_id;
				 $qa_re = $wpdb->get_results($sql);
				 foreach($qa_re as $val){
					echo  '<strong>Answers :</strong><span>'.$val->answer_text.'</span> ';
					$answers_id=$val->answers_id;
					echo '<a href="'.$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&action=del_ans&qa_id='.$qa_id.'&ans_id='.$answers_id.'" >Delete</a>';
					 	$isansavailable=1;
				 }
				 ?>
		</h3>
      </div>
     </div>
      <?php if($isansavailable!=1){?>
     <div class="quastion-quastion-textarea-input">
       <textarea class="quastion-textarea-input" id="ans_text" name="ans_text" required ></textarea>
     </div>
<?php } ?>
  </div>
  <div class="right-block">
    <div class="quastion-details quastion-details-inline">
      <h2 class="hndle ui-sortable-handle"><?php echo __( 'Save Question', 'ultimate-auction-pro-software' ); ?></h2>
		<?php if($isansavailable!=1){?>
			<button type="submit" class="button button-primary button-large">
				<span class="sr-only"><?php echo __( 'update', 'ultimate-auction-pro-software' ); ?></span>
			</button>
		<?php } ?>
     </div>
  </div>
</div>
	</form>
<script>
<?php
global $current_user;
$current_user = wp_get_current_user();
?>
jQuery( document ).ready(function() {
	jQuery( "#frm_qa_admin" ).submit(function( event ) {
	   var qa_post_id=jQuery( "#product_id" ).val();
	   if(qa_post_id==''){
		   return false;
	   }
	   var ans_text=jQuery( "#ans_text" ).val();
	   if(ans_text==''){
		   return false;
	   }
	   var qa_asked_by_id=<?php echo $current_user->ID; ?>;
		jQuery.ajax({
			url:'<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
			type: "post",
			data: {
			action: 'add_ans_fun',
			question_text: ans_text,
			asked_by_id: qa_asked_by_id,
			post_id: <?php echo $question_id; ?>,
			},
			success: function(data){
			 
													
				jQuery( "#ans_text" ).val('');
				 
				<?php
				$url=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&action=show&qa_id='.$qa_id.'&msg=4';
				?>
				window.location.href = "<?php echo $url;?>";
							
				//location.reload();
			},
			error:function(){
				console.log('failure!');
			}                
		}); 
		  return false;
	});
});
</script>
		</form>
