<?php
global $wpdb;
global $current_user;
$current_user = wp_get_current_user();
$setlogpop = '';
if (!is_user_logged_in()) {
	$setlogpop = 'data-fancybox="" data-src="#uat-login-form"';
}


$prefix = $wpdb->prefix;
$isvoted = "";

$q_a_auction_slider_entries = get_option('options_q_a_auction_slider_entries', 3);

$q_a_auction_slider_title = get_option('options_q_a_auction_slider_title', 'Q&A');
$q_a_auction_counter_with_title = get_option('options_q_a_auction_counter_with_title','off');
$q_a_auction_button_with_title = get_option('options_q_a_auction_button_with_title', 'on');
$q_a_auction_Label_title = get_option('options_q_a_auction_Label_title', 'Ask a Question');

$ua_auction_question = $prefix . 'ua_auction_question';
$qa_re = $wpdb->get_results("SELECT * FROM " . $ua_auction_question . " WHERE status='active' AND post_id=" . get_the_ID() . " limit " . $q_a_auction_slider_entries);
$popHTLM = '';

?>
<div class="auction-question-sec">
    <div class="auction-question-heading">
        <h3>
            <?php echo $q_a_auction_slider_title; ?>
            <?php if ($q_a_auction_counter_with_title == 'on') { ?>
            <span class="q-count">(<?php echo count($qa_re); ?>) </span>
            <?php } ?>




            <?php if ($q_a_auction_button_with_title == 'on') { ?>
            <?php if (!is_user_logged_in()) { ?>
            <a data-fancybox data-src="#uat-login-form" class="btn-link ml-auto view-all"
                href="javascript:;"><?php echo $q_a_auction_Label_title; ?></a>
            <?php } else { ?>
            <a data-fancybox="" data-src="#ask-qus-popup" href="javascript:;"
                class="btn-link ml-auto view-all"><?php echo $q_a_auction_Label_title; ?></a>
            <?php } ?>
            <?php } ?>

        </h3>
        <button class="btn-link ml-auto view-all"><?php echo __('View all', 'ultimate-auction-pro-software') ?></button>
    </div>
    <div class="carousel-wrap">
        <div class="comment-view-slider owl-carousel">

            <?php




			$post_author_id = 0;
			foreach ($qa_re as $key => $row) {
				$user_info = get_userdata($row->asked_by_id);
				$display_name = $user_info->display_name;
				
				$attachment_id = get_user_meta( $row->asked_by_id, 'image', true );
				$custom_avatar_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' ); 
				
				if ( $custom_avatar_url ) {
					$asked_img = $custom_avatar_url;
				}else{
					$asked_img = esc_url(get_avatar_url($row->asked_by_id));
				}

				$question_text = $row->question_text;
			?>

            <div class="item">
                <div id="Newest-" class="panel">
                    <div class="comment-thred">
                        <div class="c-uder-detail-head">
                            <img class="comment-user-img" src="<?php echo $asked_img; ?>" />
                        </div>
                        <div class="comment-text-box-details">
                            <div class="comment-user-name">
                                <span class="c-user-image"><?php echo $display_name; ?></span>
                                <div class="rep-user"> <span class="days-cmt"><span class="rep"><svg class="reputation"
                                                width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                aria-labelledby="ir-6r6jfi1YSir">
                                                <title id="ir-6r6jfi1YSir">Reputation Icon</title>
                                                <path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg><?php echo user_vote_count($current_user->ID); ?></span></span> </div>
                            </div>
                            <div class="comment-text">
                                <p><strong><?php echo __('Q', 'ultimate-auction-pro-software') ?>: </strong>
                                    <?php echo $question_text; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php

						$qa_id = $row->question_id;
						$ua_auction_answer = $prefix . 'ua_auction_answer';
						$sql = "SELECT * FROM " . $ua_auction_answer . " where question_id=" . $qa_id;
						$qa_re = $wpdb->get_results($sql);
						$ansHTMLPOP = "";

						$post_author_id = $row->post_owner_id;
						foreach ($qa_re as $val) {


							$user_info = get_userdata($val->answered_by_id);
							$display_name = $user_info->display_name;

							
							
							
							$attachment_id = get_user_meta( $val->answered_by_id, 'image', true );
							$custom_avatar_url = wp_get_attachment_image_url( $attachment_id, 'thumbnail' ); 
							
							if ( $custom_avatar_url ) {
								$answered_img =  $custom_avatar_url;
							}else{
								$answered_img = esc_url(get_avatar_url($val->answered_by_id));
							}
							
							
						?>


                    <div class="comment-thred">
                        <div class="c-uder-detail-head"> <img class="comment-user-img"
                                src="<?php echo $answered_img; ?>"> </div>
                        <div class="comment-text-box-details">
                            <div class="comment-user-name">
                                <span class="c-user-image"><?php echo $display_name; ?></span>
                                <div class="rep-user"> <span class="days-cmt"><span class="rep"><svg class="reputation"
                                                width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg"
                                                aria-labelledby="ir-6r6jfi1YSir">
                                                <title id="ir-6r6jfi1YSir">Reputation Icon</title>
                                                <path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25"
                                                    stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg><?php echo user_vote_count($current_user->ID); ?></span></span> </div>
                            </div>


                            <div class="comment-text">
                                <p>
                                    <strong><?php echo __('A', 'ultimate-auction-pro-software') ?>:
                                    </strong><?php echo $val->answer_text; ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php

							//voted-cls

							global $wpdb;
							$prefix = $wpdb->prefix;
							$ua_auction_vote = $prefix . 'ua_auction_vote';
							$question_id = $qa_id;
							$voter_id = $current_user->ID;
							$qa_re = $wpdb->get_results("SELECT * FROM " . $ua_auction_vote . " where question_id=" . $question_id . " AND voter_id=" . $voter_id);

							$isvoted = "";
							if (count($qa_re) > 0) {
								$isvoted = "voted-cls";
							}

							$ansHTMLPOP = '<div class="comment-thred">
                           <div class="c-uder-detail-head"> <img class="comment-user-img" src="' . $answered_img . '"> </div>
                           <div class="comment-text-box-details">
                              <div class="comment-user-name">
                                 <span class="c-user-image">' . $display_name . '</span>
                                 <a class="vote-icon-in-popup vote-icon ' . $isvoted . ' " ' . $setlogpop . '  href="javascript:;" data-qid="' . $qa_id . '" ><svg class="reputation" width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-labelledby="ir-6r6jfi1YSir"><title id="ir-6r6jfi1YSir">Reputation Icon</title><path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg>
								 <span class="vote_count_total25 q_vote" >(' . q_vote_count($qa_id) . ')</span>
								 </a><a class="time-to-comment" href="javascript:;"><small class="dyas-ago-time">' . meks_convert_to_time_ago($orig_time = $val->created_date) . '</small></a>
                              </div>
                              <div class="comment-text">
                                 <p><strong>A: </strong>' . $val->answer_text . '</p>
                              </div>

                           </div>
                        </div>';
						}

						if ($ansHTMLPOP == "") {
							global $current_user;
							$current_user = wp_get_current_user();
							if ($current_user->ID == $post_author_id) {

								$ansHTMLPOP = '<div class="add_ans_front"><textarea id="add_ans_front_text_' . $qa_id . '" name="add_ans_front_text_' . $qa_id . '"></textarea><a href="javascript:;" id="add_ans_front_btn" class="add_ans_front_btn" data-faddqid="' . $qa_id . '">Add Answers</a></div>';
							}
						}

						?>


                </div>
                <div class="slide-footer">
                    <div class="interact">
                        <a class="vote-icon <?php echo $isvoted;  ?>" href="javascript:;" <?php echo $setlogpop; ?>
                            data-qid="<?php echo $qa_id; ?>"><svg class="reputation" width="8" height="10" fill="none"
                                xmlns="http://www.w3.org/2000/svg" aria-labelledby="ir-6r6jfi1YSir">
                                <title id="ir-6r6jfi1YSir">Reputation Icon</title>
                                <path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg><span
                                class="vote_count_total25 q_vote">(<?php echo q_vote_count($qa_id); ?>)</span></a>
                        <a class="view-ans-link" data-fancybox data-src="#view-answer-popup"
                            href="javascript:;"><?php echo __('View answer', 'ultimate-auction-pro-software') ?></a>

                    </div>
                </div>
            </div>
            <?php


				$popHTLM .= '<div class="comment-thred-box">
                        <div class="comment-thred">
                           <div class="c-uder-detail-head"> <img class="comment-user-img" src="' . $asked_img . '"> </div>
                           <div class="comment-text-box-details">
                              <div class="comment-user-name">
                                 <span class="c-user-image">admin</span>
                                 <a class="vote-icon-in-popup vote-icon ' . $isvoted . ' " ' . $setlogpop . ' href="javascript:;" data-qid="' . $qa_id . '"  ><svg class="reputation" width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-labelledby="ir-6r6jfi1YSir"><title id="ir-6r6jfi1YSir">Reputation Icon</title><path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg><span class="vote_count_total25 q_vote" >(' . q_vote_count($qa_id) . ')</span></a><a class="time-to-comment" href="javascript:;"><small class="dyas-ago-time">' . meks_convert_to_time_ago($orig_time = $row->created_date) . '</small></a>
                              </div>
                              <div class="comment-text">
                                 <p><strong>Q: </strong>' . $question_text . '</p>
                              </div>
                           </div>
                        </div>
                        <div id="pop_ans_' . $qa_id . '">' . $ansHTMLPOP . '</div>
                        <div class="comment-foot">
                                 <a class="vote-icon ' . $isvoted . ' " ' . $setlogpop . '  data-qid="' . $qa_id . '"  href="javascript:;"><svg class="reputation" width="8" height="10" fill="none" xmlns="http://www.w3.org/2000/svg" aria-labelledby="ir-6r6jfi1YSir"><title id="ir-6r6jfi1YSir">Reputation Icon</title><path d="M4 1v8M1 4l3-3 3 3" stroke="#262626" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path></svg><span class="vote_count_total25 q_vote"   >(' . q_vote_count($qa_id) . ')</span></a>
                              </div>
                     </div>';
			}
			?>


            <div class="item">
                <div class="qanda-empty-question">
                    <?php if (!is_user_logged_in()) { ?>


                    <a data-fancybox="" data-src="#uat-login-form" href="javascript:;"
                        class="ask-qustion-slider-btn"><?php echo $q_a_auction_Label_title; ?></a>
                    <?php } else { ?>
                    <a data-fancybox="" data-src="#ask-qus-popup" href="javascript:;"
                        class="ask-qustion-slider-btn"><?php echo $q_a_auction_Label_title; ?></a>


                    <?php } ?>


                </div>
            </div>


            <div style="display: none;" id="view-answer-popup">
                <div class="auction-question-heading popup-header">
                    <h3><?php echo __('Seller Q&amp;A', 'ultimate-auction-pro-software') ?></h3>
                    <a data-fancybox data-src="#ask-qus-popup" href="javascript:;"
                        class="btn-link ml-auto view-all"><?php echo __('Ask a Question', 'ultimate-auction-pro-software') ?></a>
                    <div style="display: none;" id="ask-qus-popup">
                        <div class="modal-header">
                            <h5 class="modal-title"></h5>
                        </div>
                        <div class="modal-body quation-box-area">
                            <div class="coment-bid-tabs">
                                <div class="coment-bid-tab-heading"><a href="javascript:;"
                                        class="ask-qustion-slider-btn">
                                        <h4 id="frm_qa_ask-h4"><?php echo __('Ask Question', 'ultimate-auction-pro-software') ?></h4>
                                    </a>
                                </div>
                                <div class="comments">
                                    <form id="frm_qa_ask" name="frm_qa_ask" placeholder="Ask the seller a question..."
                                        method="post" id="" class="ask-q" autocomplete="off" novalidate="">
                                        <textarea class="" id="qa_ask_text" name="qa_ask_text" tabindex="-1" required autocomplete="off" autocapitalize="on" autocorrect="on" spellcheck="false"
                                            rows="1" required=""></textarea>
                                        <button type="submit" class="ask-q-btn">
                                            <span
                                                class="sr-only"><?php echo __('Submit', 'ultimate-auction-pro-software') ?></span>
                                        </button>
                                    </form>
									<style>
									.Success-msg {
										border-left: none;
										background: #fff;
										font-weight: 600;
										font-size: 20px;
									}
									</style>
                                    <script>
                                    jQuery(document).ready(function() {
                                        jQuery("#frm_qa_ask").submit(function(event) {

                                            var qa_post_id = <?php echo get_the_ID(); ?>;
                                            var qa_question_text = jQuery("#qa_ask_text").val();
                                            var qa_asked_by_id = <?php echo $current_user->ID; ?>;

                                            jQuery.ajax({
                                                url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                                                type: "post",
                                                data: {
                                                    action: 'add_q_and_a',
                                                    question_text: qa_question_text,
                                                    asked_by_id: qa_asked_by_id,
                                                    post_id: qa_post_id,

                                                },
                                                success: function(data) {
                                                    jQuery("#qa_ask_text").val('');
                                                    //location.reload();
                                                    jQuery("#frm_qa_ask").html('<div class="success-msg" >Question Submitted</div>');
													jQuery("#frm_qa_ask-h4").html('');

                                                },
                                                error: function() {
                                                    console.log('failure!');
                                                }

                                            });
                                            return false;


                                        });


                                    });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php echo $popHTLM; ?>


            </div>
        </div>
    </div>
    <script>
    jQuery(document).ready(function() {
        jQuery(".add_ans_front_btn").on("click", function() {
            var faddqid = jQuery(this).attr('data-faddqid');
            var question_id = faddqid;
            var textval = jQuery('#add_ans_front_text_' + faddqid).val();

            var pop_ans_html = jQuery('#pop_ans_' + faddqid);


            var answered_by_id = <?php echo  $current_user->ID; ?>;
            if (answered_by_id == 0) {
                return false;
            }

            jQuery.ajax({
                url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                type: "post",
                data: {
                    action: 'add_ans_fun_pop',
                    ans_text: textval,
                    answered_by_id: answered_by_id,
                    question_id: question_id,
                },
                success: function(data) {
                    pop_ans_html.html(data);

                },
                error: function() {
                    console.log('failure!');
                }
            });
        });
    });
    (function($) {
        $('[data-fancybox]').fancybox({
            closeExisting: true,
            loop: true
        });
    })(jQuery)

    jQuery('.comment-view-slider').owlCarousel({
        items: 3,
        loop: false,
        margin: 15,
        nav: true,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    })
    </script>

    <script>
    jQuery(document).ready(function() {
        jQuery(".vote-icon").click(function(event) {

            var qid = jQuery(this).attr('data-qid');


            if (jQuery(this).hasClass("voted-cls")) {
                jQuery(this).removeClass('voted-cls');

            } else {
                jQuery(this).addClass('voted-cls');
            }
            var voter_id = <?php echo $current_user->ID; ?>;
            if (voter_id <= 0) {
                return false;
            }

            var votehtml = jQuery(this).find(".q_vote");
            jQuery.ajax({
                url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php',
                type: "post",
                data: {
                    action: 'q_vote_fun',
                    question_id: qid,
                    voter_id: <?php echo $current_user->ID; ?>,


                },
                success: function(data) {
                    votehtml.html('(' + data + ')');
                },
                error: function() {
                    console.log('failure!');
                }

            });

        });


    });
    </script>