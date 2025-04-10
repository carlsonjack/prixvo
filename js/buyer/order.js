jQuery(document).ready(function($) {
   
    setTimeout(function() {
       jQuery("#messageBox").hide('blind', {}, 500)
    }, 5000);
    jQuery(document).on('click', ".action-box .drop-down", function(e) {
       e.preventDefault();
       var options = jQuery(this).children(".options");
       if (options.is(":visible")) {
          options.hide();
       } else {
          jQuery(".action-box .drop-down .options").hide();
          options.show();
       }
    });
    jQuery(document).on('click', ".action-box .drop-down li a", function(e) {
       e.preventDefault();
       console.log(e)
       var $action = jQuery(this).data("value");
       var actionForm = jQuery(this).closest("form[name='lot_action']")
       actionForm.find('input[name="lot_action_type"]').val($action);
       actionForm.submit();
    });
      $("#copy_button").click(function() {
         var text = $(this).data('clipboard-text');
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(text).select();
        document.execCommand("copy");
        tempInput.remove();
        
        $("#copy_tooltip").addClass("active");
        setTimeout(function() {
          $("#copy_tooltip").removeClass("active");
        }, 2000);
    });
 });