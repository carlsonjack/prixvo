jQuery(document).ready(function($){
	
	Comment_Ajaxurl = frontend_custom_comment_object.ajaxurl;
	
	//alert(Comment_Ajaxurl);
	/* --------------------------------------------------------
	Open Popup when Not Logged
	----------------------------------------------------------- */		
	$( document ).on( 'click', '.notlogged', function() {	
	  $.fancybox.open({
		src  : '#uat-login-form',
		type : 'inline',		
	  });  
	  return false;
	});	
	/* --------------------------------------------------------
	Add Comment Message
	----------------------------------------------------------- */
	$(document).on("keyup keypress", ".custom_comment", function(e) { 
	  if ($(this).val().length == 0) {		 
			$("#save_comment").attr("disabled", true);
			$('#save_comment').addClass("disabled");
		  } else {
			$("#save_comment").removeAttr("disabled");
			 $('#save_comment').removeClass("disabled");
		  }
	 
	 
	
	});
	
	$('#save_comment').on('click', function(e) {
        e.preventDefault();
		var error = 0;
		var thisObj = $(this);
		var comment_form = $('#frm_cc');
		
		/* collect the data */ 
		var commentObj 		= comment_form.find( '.custom_comment' );
		var comment 		= commentObj.val();
		var product_idObj 	= comment_form.find( '.product_id' );
		var product_id 		= product_idObj.val();	
		var Cparent_idObj 	= comment_form.find( '.Comment_parent_id' );
		var Cparent_id 		= Cparent_idObj.val();	
		var comment_type =  jQuery('#comment_type').val();
		if(comment_type == undefined){
			 comment_type = "ua_comment";
		}
		$("#reply-to").css("display", "none")
		if( comment.length > 0 ) {
			if( error == 0 ) {
				var data = {
							action: 	'add_custom_comment',						
							comment: 		comment,
							product_id: 	product_id,
							Cparent_id: 	Cparent_id,
							comment_type: 	comment_type,
						}

				$.post( Comment_Ajaxurl, data, function(response) {										
					var data = $.parseJSON( response ); 
					commentObj.val('');
					$("#save_comment").attr("disabled", true);
					$('#save_comment').addClass("disabled");
					$("#Comment_reply_name").val("");
					$("#Comment_parent_id").val("");
					document.getElementById("reply-to").innerHTML = "";					
					$(".moderating_msg").text(data.comment_moderation_msg);					
					get_comment_list(1,product_id);
				});
			}
		}
		
	});	
	$(document).delegate(".reply-comment","click",function(e){	
        e.preventDefault();
		var comment_id = jQuery(this).data('comment_id');
		var user_name = jQuery(this).data('user_name');
		$("#Comment_reply_name").val(user_name);
		$("#Comment_parent_id").val(comment_id);		
		$("#reply-to").css("display", "block")
		document.getElementById("reply-to").innerHTML = 'Re:'+user_name;
		document.getElementById("reply-to").setAttribute("data-username", 'Re:'+user_name);
		var width_1 = document.getElementById("reply-to").offsetWidth;
		var width = width_1+15;		
		$('#custom_comment').css('padding-left', +width+"px");		
		window.setTimeout(function () {
				$("#reply-to").focus();
		}, 500);
		
	});	
	
	$("#uat-comment-filter li").click(function() {
		$(".moderating_msg").css("display", "none")
		$("#uat-comment-filter li").removeClass('active');
		$(this).addClass('active');		
		get_comment_list(1);
	});
	
	jQuery('.c_show_more' ).hide();
	get_comment_list(1);
	/* --------------------------------------------------------
     Up/Down vote
    ----------------------------------------------------------- */    
	$(document).delegate(".updownvote","click",function(e){	
        var comment_id = jQuery(this).data('comment_id'); 
		//alert(comment_id);
        jQuery.ajax({
            type: "get",
			dataType: 'JSON',
            url: Comment_Ajaxurl,
            data: {
                comment_id: comment_id,
                action: "uat_comment_upvote_downvote"
            },
            success: function(response) { 
				   var vote_total=0;       		
					if(response != "" ) {
					   vote_total = response.vote_count;
					  if(response.user_voted =="yes"){						 
						 $("#updownvote"+comment_id).addClass("green");
					  }	else {
						  $("#updownvote"+comment_id).removeClass("green");
					  }				 
					} 
					  
					jQuery('.vote_count_total'+comment_id ).text('('+vote_total +')');		   
                }
            
        });
     });
	
	 $(document).delegate(".flag_report","click",function(e){	
        var comment_id = jQuery(this).data('comment_id');
        jQuery.ajax({
            type: "get",
			dataType: 'JSON',
            url: Comment_Ajaxurl,
            data: {
                comment_id: comment_id,
                action: "uat_comment_flag_reported"
            },
            success: function(response) { 
					if(response != "" ) {
					  if(response.flag_reported =="yes"){						
						  $(".reported"+comment_id).html(frontend_custom_comment_object.reported); 
					  }
					 
					} 
				
                }
            
        });
     });

	
}); /* end of document ready */	


function get_comment_single_html(value){	
	
	var reply_to="";
	if(value.c_parent_name){
		reply_to  = `<a class="mention" href="">Re: @${value.c_parent_name}</a>`;
	}
	var voted_class ="";
	if(value.u_voted){
		 voted_class = "green"
	}
	
	if(frontend_custom_comment_object.logged_in){
		var upvote_icon = `<a class="vote-icon updownvote ${voted_class}" id="updownvote${value.comment_ID}" data-comment_id="${value.comment_ID}" href="javascript:void(0)"><img src="${frontend_custom_comment_object.upvote_icon}"><span class="vote_count_total${value.comment_ID}">${value.total_vote_count}</span></a>`;
	} else {
		var upvote_icon = `<a class="vote-icon ${voted_class}" data-fancybox="" data-src="#uat-login-form" href="javascript:;"><img src="${frontend_custom_comment_object.upvote_icon}"><span class="vote_count_total${value.comment_ID}">(${value.total_vote_count})</span></a>`;
	}
	
	if(value.moderated==1){
		var falg_reported = `<p>${frontend_custom_comment_object.moderated}</p>`;
	} else if(value.flag_reported==1) {
		var falg_reported = `<p>${frontend_custom_comment_object.reported}</p>`;
	} else {
		if(frontend_custom_comment_object.logged_in){
			var falg_reported = `<a class="flag-icon flag_report reported${value.comment_ID}"  data-comment_id="${value.comment_ID}" href="javascript:void(0)">${frontend_custom_comment_object.flag_txt}<img src="${frontend_custom_comment_object.flag_icon}"></a> `;
		} else {
			var falg_reported = `<a class="flag-icon flag_report"  data-fancybox="" data-src="#uat-login-form" href="javascript:;">${frontend_custom_comment_object.flag_txt}<img src="${frontend_custom_comment_object.flag_icon}"></a> `;
		}
	}


	
	
	var comment_html  =`<div class="comment-thred">
										<div class="c-uder-detail-head"> <img class="comment-user-img" src="${value.user_avtar}"> </div>
										<div class="comment-text-box-details">
											<div class="comment-user-name"> <span class="c-user-image">${value.comment_author}</span> 
<div class="rep-user">  <span class="days-cmt">${value.c_time}</span> </div>
											</div>
											<div class="comment-text">
												<p>${reply_to}	${value.comment_content}</p>						
												
											</div>
											<div class="comment-foot">
												${upvote_icon} <a data-user_id="${value.user_id}" data-user_name="${value.comment_author}" data-comment_id="${value.comment_ID}" class="reply-icon reply-comment" href="javascript:void(0)">Reply<img src="${frontend_custom_comment_object.reply_icon}"></a>${falg_reported} </div>
										</div>
									</div>`;
										
	return comment_html;		
}

 var Cperpage = 10;
 var setpage =1; 
function get_comment_list(setpage2){
	if(setpage2!=""){
			 setpage=setpage2;
		 }
		 else{
			 setpage=setpage;
		 }		
var product_id 	= jQuery('#product_id').val();	
var filter_by 	= jQuery("#uat-comment-filter li.active").attr('id');
var comment_type =  jQuery('#comment_type').val();

if(comment_type == undefined){
	 comment_type = "ua_comment";
}
jQuery('div.comment_ajax_loader' ).show();
jQuery.ajax({
	url:Comment_Ajaxurl,
	type: "post",
	dataType: 'JSON',
	data: {
		action: 'get_custom_comment_data',
		product_id: 	product_id,
		Cperpage : Cperpage,
		setpage : setpage,
		filter_by : filter_by,
		comment_type : comment_type,
	 },
	beforeSend: function(){},
	success: function(response){
		var comment_html="";       		
		var comment_total=0;       		
		if(response != "" ) {
		    jQuery('.c_show_more' ).show();
            var comment_count =0;		
			jQuery.each( response.comment_data, function( key, value ) {
				if( key  >=  0 ){
					comment_count++;
					comment_html += get_comment_single_html(value);
				}	
			});	
			var comment_count_ = Math.ceil(response.count/setpage-Cperpage)			
			if(comment_count_ <= 0  ){
				jQuery('.c_show_more' ).hide();
			}else {
				setpage++;
			}
		
			comment_total =response.count;
		} else {
			jQuery('.c_show_more' ).hide();
		}
		
		jQuery('.comment_count' ).text('('+comment_total +')');
		jQuery('div.comment_ajax_loader' ).hide();	
		if(setpage==1){
				jQuery("#Newest").html(comment_html);
		}else{
			jQuery("#Newest").append(comment_html);	 	
		 }	
		 
	 },
	complete: function() {},
	error:function(){}  	 
 }); 
}