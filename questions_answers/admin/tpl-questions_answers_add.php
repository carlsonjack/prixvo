<form id="frm_qa_admin" name="frm_qa_admin"  method="post" id="" class="ask-q" autocomplete="off" novalidate="">
<div class="d-flex-left-right-block">
  <div class="left-block">
    <div class="quastion-details ">
      <h2 class="hndle ui-sortable-handle"><?php echo _e('Please select Product', 'ultimate-auction-pro-software'); ?></h2>
      <div class="inside-details">
        <h3><strong><?php echo _e('Select product', 'ultimate-auction-pro-software'); ?></strong></h3>
		<select class="select2"  name="product_id" id="product_id" required >
				<option value=""><?php echo _e('Select product', 'ultimate-auction-pro-software'); ?> </option>
				<?php 
				 $args = array(
					'post_type'      => 'product',
					'posts_per_page' => '-1',
				);
				$loop = new WP_Query( $args );
				while ( $loop->have_posts() ) : $loop->the_post();
					global $product;
				   echo '<option value="'.get_the_ID().'">'.get_the_title().'</option>';
				endwhile;
				wp_reset_query();
				?>
				</select>
      </div>
     </div> 
     <div class="quastion-quastion-textarea-input">
       <textarea class="quastion-textarea-input" id="qa_text" name="qa_text" required ></textarea>
     </div>
  </div>
  <div class="right-block">
    <div class="quastion-details quastion-details-inline">
      <h2 class="hndle ui-sortable-handle"><?php echo _e('Save Question', 'ultimate-auction-pro-software'); ?></h2>
       <button type="submit" class="button button-primary button-large">
			 <span class="sr-only"><?php echo _e('Insert', 'ultimate-auction-pro-software'); ?></span>
		  </button>
     </div>
  </div>
</div>
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
						action: 'add_q_and_a',
						question_text: qa_text,
						asked_by_id: qa_asked_by_id,
						post_id: qa_post_id,
						},
						success: function(data){
							jQuery( "#qa_ask_text" ).val('');
							location.reload();
							<?php
							$url=$site_url.'/wp-admin/admin.php?page=ua-auctions-qa&msg=4';
							?>
							window.location.href = "<?php echo $url;?>";
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