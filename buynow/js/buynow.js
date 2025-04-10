jQuery( document ).ready( function( $ ) {
    var buyNowBtn = $("#buyNowBtn");
    function end_auction(auction_id){
        $.ajax({
            type : "post",
            url : frontend_buynow_object.ajaxurl,
            data : {action: "uwa_admin_force_end_now", postid:auction_id, ua_nonce : frontend_buynow_object.uwa_nonce },
            success: function(response) {
                var data = $.parseJSON( response );
                if( data.status == 1 ) {
                    alert(data.success_message);
                    window.location.reload();
                } else {
                    alert(data.error_message);
                    window.location.reload();
                }
            }
          });
    }

    if(buyNowBtn.length)
    {
        var acutionId = buyNowBtn.data('acution-id');
        var acutionBid = buyNowBtn.data('bid');
        $(buyNowBtn).on("click",function(){

            if (confirm("Are you sure to buy now for "+frontend_buynow_object.react_currency_symbol+acutionBid+"?") == true) {
                // alert(acutionId+" "+acutionBid);
                $.ajax({
                    url:frontend_buynow_object.ajaxurl,
                    type: "post",
                    dataType: 'JSON',
                    data : 	{action: "uat_user_place_bid_ajax",
                        auction_id : acutionId,
                        uwa_bid_value : acutionBid,
                        is_buynow : "buynow"
                        },
                    success: function(data){
                        if(data.success){
                            end_auction(acutionId);
                        }else{
                            alert("buy now proccess failed!");
                        }
						var getyimr=jquery_get_new_time(acutionId);
                    },
                    error:function(){ }
                 });
            }
        });
    }
});