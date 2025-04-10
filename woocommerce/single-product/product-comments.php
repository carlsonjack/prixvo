<?php
 global $woocommerce, $post, $product;
 $user_id = get_current_user_id();
$user = get_user_by('id',$user_id);
$user_email = isset($user->data->user_email) ? $user->data->user_email : '';
$user_login = isset($user->data->user_login) ? $user->data->user_login : '';


?>
 
<section class="comment-section">
		<div class="product-destails-desc">
			<div class="product-details-area">
				<div class="car-details-text-descripton auction-details-comment">					
					
					<div id="Comments" class="custum-text-block comments-and-bids">
						<div class="coment-bid-tabs">
							<div class="coment-bid-tab-heading">
								<h4><?php _e( 'Comments' , 'ultimate-auction-pro-software' ); ?> 
								<span class="comment_count"></span>
								</h4>
								<ul class="comment-tabs" id="uat-comment-filter">								
									<li id="refresh_comment"><a href="javascript:;" ><?php _e( 'Refresh' , 'ultimate-auction-pro-software' ); ?></a></li>
									<li id="newest_comment"><a href="javascript:;"  ><?php _e( 'Newest' , 'ultimate-auction-pro-software' ); ?></a></li>
									<li id="most_upvoted_comment"><a href="javascript:;"  ><?php _e( 'Most Upvoted' , 'ultimate-auction-pro-software' ); ?></a></li>									
								</ul>
							</div>
							
							<div class="comments">							
								<div class="d-flex">
									<form method="post" id="frm_cc"  name="frm_cc" class="messenger for-comments reply " autocomplete="off" novalidate="">
									<input type="hidden" id="Comment_parent_id" name="Comment_parent_id" class="Comment_parent_id" value="" />
									<input type="hidden" id="Comment_reply_name" name="Comment_reply_name" class="Comment_reply_name" value="" />
									<input type="hidden" id="product_id" name="product_id" class="product_id" value="<?php echo $product->get_id(); ?>" />
										<label class="reply-to" id="reply-to" style="display:none"></label>
									
										<fieldset class="form-group textarea ">
											<label class="placeholder-shown" for="comment">Add a Comment...</label>
											<textarea class="form-control auto-expand custom_comment" name="custom_comment" tabindex="-1" autocomplete="off" autocapitalize="on" autocorrect="on" spellcheck="false" id="custom_comment" rows="1" required></textarea>
										</fieldset>
										<?php wp_nonce_field( 'custom_comment_nonce', 'name_of_nonce_field' ); ?>
										<?php if (!is_user_logged_in()) {?>
										<button type="submit"  class="disabled notlogged" >
										<span class="sr-only"><?php _e('Submit', 'ultimate-auction-pro-software') ?></span></button>
										<?php } else { ?>
										<button id="save_comment"  disabled type="submit" class="disabled save_comment" >
										<span class="sr-only"><?php _e('Submit', 'ultimate-auction-pro-software') ?></span></button>
										<?php } ?>
									 <input type="hidden" name="cmax_page" value="" id="cmax_page"/>
									</form>
								</div>

								<div><span class="moderating_msg"></span></div>
								
							</div>
							
							<div class="user-comment-details">
								<div id="Newest" class="panel" >								
									<div class="panel loader-center comment_ajax_loader">
									<img  style="display:block" class="" 
									src="<?php echo UAT_THEME_PRO_IMAGE_URI; ?>/ajax_loader.gif" alt="Loading..." />
									</div>
								</div>
								<div class="d-flex-just-content-center">
								 <a href="Javascript:void(0);"  class="c_show_more ua-button-black" onclick="get_comment_list('');">
								 <?php _e('Load more', 'ultimate-auction-pro-software'); ?></a>
								 </div>
							</div>
						</div>
						<div class="detail-body"> </div>
					</div>
				</div>
			</div>
		</div>
	</section>