jQuery(document).ready(function($){
    // alert()
    var test_msg  = UWT_twilio_data.test_error_message;
    //alert(test_msg);
  /* start testing */
  jQuery(document).on('click','.uwt_twilio_sms_test_sms_button', function(event){
        var valid=1;
      var uwt_test_phone = jQuery('#uwt_twilio_sms_test_number').val();
      var uwt_test_message = jQuery('#uwt_twilio_sms_test_template').val();

          if (uwt_test_phone == "" || uwt_test_message == "" ) {
              valid=0;
              alert(test_msg);
          }

          if(valid==1)
          {
              jQuery.ajax({
                  type : "post",
                  url : UWT_TWILIO_SMS.ajaxurl,
                  data : {action: "uwt_twilio_send_test_sms", from:"whatsapp:", uwt_test_phone:uwt_test_phone,uwt_test_message:uwt_test_message, ua_nonce : UWT_TWILIO_SMS.UWA_TWILIO_SMS_NONCE },
                  success: function(response) {
                      var data = $.parseJSON( response );
                      alert(data.message);
                      window.location.reload();
                  }

              });

          }

      event.preventDefault();
  });
  jQuery(document).on('click','.uwt_twilio_sms_test_whatsapp_button', function(event){
    var valid=1;
  var uwt_test_phone = jQuery('#uwt_twilio_sms_test_number').val();
  var uwt_test_message = jQuery('#uwt_twilio_sms_test_template').val();

      if (uwt_test_phone == "" || uwt_test_message == "" ) {
          valid=0;
          alert(test_msg);
      }

      if(valid==1)
      {
          jQuery.ajax({
              type : "post",
              url : UWT_TWILIO_SMS.ajaxurl,
              data : {action: "uwt_twilio_send_test_sms", from:"whatsapp:", uwt_test_phone:uwt_test_phone,uwt_test_message:uwt_test_message, ua_nonce : UWT_TWILIO_SMS.UWA_TWILIO_SMS_NONCE },
              success: function(response) {
                  var data = $.parseJSON( response );
                  alert(data.message);
                  window.location.reload();
              }

          });

      }

  event.preventDefault();
});

}); /* end of document ready */