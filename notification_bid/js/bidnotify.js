'use strict';




function showBidNotifications(myJson){

  var ele = document.querySelector("span.span-auction-id");
  if (ele) {
    var auctionId = ele.dataset.acutionId;
    var userId = ele.dataset.userId;
    if (!getCookie("acution_" + auctionId)) {
      setCookie("acution_" + auctionId, myJson.length, '7');
    }else{

      if (getCookie("acution_" + auctionId) != myJson.length && userId != myJson[myJson.length - 1].woo_ua_auction_user_id) {
	

        if( uat_data_bid_notify.auction_type == 'yes' )
        {
            jQuery('#bid_msg').html('<div class="success-msg"> ' + uat_data_bid_notify.bid_placed_msg_re+ '</div>');
        }else{
         jQuery('#bid_msg').html('<div class="success-msg">'+ uat_data_bid_notify.bid_placed_msg_re + uat_data_bid.react_currency_symbol + myJson[myJson.length - 1].woo_ua_auction_bid_amount + '</div>');
        }

        setTimeout(function () {
          jQuery(".error-msg").fadeOut(1500);
          jQuery(".success-msg").fadeOut(1500);        
        }, 5000);
      }
      setCookie("acution_" + auctionId, myJson.length, '7');
    }
  }
}

function anti_sniping_timer_update(lastbiduser = 0){

  var ele = document.querySelector("span.span-auction-id");
  if (ele) {
      var auctionId = ele.dataset.acutionId;
      var userId = ele.dataset.userId;
      if(userId == lastbiduser)
      {
        return false;
      }else{
        if(uat_data_bid_notify.anti_sniping_timer_update_noti=="auto_page_refresh" || uat_data_bid_notify.anti_sniping_timer_update_noti==""){
          jQuery('.product-d-timer').html('<div class="refresh_msg"> <span class="refresh-msg-text">'+uat_data_bid_notify.anti_sniping_timer_update_noti_msg+'</span></div>');
          setTimeout(function(){ 
            location.reload();
          },5000);
        }
        if(uat_data_bid_notify.anti_sniping_timer_update_noti=="manual_page_refresh"){
          jQuery('.product-d-timer').html('<div class="refresh_msg"> <span class="refresh-msg-text">'+uat_data_bid_notify.anti_sniping_timer_update_noti_msg+'</span> <a href="javascript:;" onclick="location.reload();" class="btn_refresh">'+uat_data_bid_notify.refresh_btn_lable+'</a></div>');
        }
       }
  }  
}