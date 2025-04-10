<?php
$qa_re = $wpdb->get_results("SELECT * FROM ".$ua_auction_question." where question_id=".$qa_id);
		$post_id=$qa_re[0]->post_id;
		?>
		<form id="frm_qa_admin" name="frm_qa_admin"  method="post" id="" class="ask-q" autocomplete="off" novalidate="">
<div class="d-flex-left-right-block">
  <div class="left-block">
    <div class="quastion-details ">
      <h2 class="hndle ui-sortable-handle"><?php echo __( 'Please select Product', 'ultimate-auction-pro-software' ); ?></h2>
      <div class="inside-details">
        <h3><strong><?php echo __( 'Select product', 'ultimate-auction-pro-software' ); ?></strong></h3>
		<select class="select2" name="product_id" id="product_id">
			<option value=""><?php echo __( 'Select product', 'ultimate-auction-pro-software' ); ?></option>
			<?php 
			 $args = array(
        'post_type'      => 'product',
        'posts_per_page' => '-1',
    );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
        global $product;
		$isselect="";
		if($post_id==get_the_ID()){
			$isselect="selected";
		}
       echo '<option value="'.get_the_ID().'" '.$isselect.'>'.get_the_title().'</option>';
    endwhile;
    wp_reset_query();
			?>
			</select>
      </div>
     </div> 
     <div class="quastion-quastion-textarea-input">
       <textarea class="quastion-textarea-input" id="qa_text" name="qa_text" required ><?php echo $qa_re[0]->question_text;?></textarea>
     </div>
  </div>
  <div class="right-block">
    <div class="quastion-details quastion-details-inline">
      <h2 class="hndle ui-sortable-handle"><?php echo __( 'Save Question', 'ultimate-auction-pro-software' ); ?></h2>
	    <button type="submit" class="button button-primary button-large">
			 <span class="sr-only"><?php echo __( 'update', 'ultimate-auction-pro-software' ); ?></span>
		  </button>
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
										   var qa_text=jQuery( "#qa_text" ).val();
										   if(qa_text==''){
											   return false;
										   }
										   var qa_asked_by_id=<?php echo $current_user->ID; ?>;
											jQuery.ajax({
												url:'<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
												type: "post",
												data: {
												action: 'edit_q_and_a',
												question_id: <?php echo $qa_id;?>,
												question_text: qa_text,
												asked_by_id: qa_asked_by_id,
												post_id: qa_post_id,
												},
												success: function(data){
													location.reload();
													
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
	 