jQuery(document).ready(function($){
    // Add custom status to quick edit
    $(document).on('click', '.editinline', function(){
        var post_id = inlineEditPost.getId(this);
        
        var post_status = $('#post_status_' + post_id).text();
        var select_element = $('#edit-' + post_id).find('.inline-edit-status select');
        post_status = select_element.val()
        console.log(post_status)
        // Remove existing custom status options
        select_element.find('option[value^="uat_"]').remove();
        
        $.each(sellerAdminData.seller_product_statuses, function(index, status){
            var custom_status_option = $('<option></option>').val(status.slug).text(status.label);
            select_element.append(custom_status_option);
        });
        
        // Set the custom status as selected if the post has the custom status
        select_element.val(post_status);
    });
    
    // Save custom status from quick edit
    $(document).on('click', '.save.inline-edit-row .button-primary', function(){
        var post_id = $('#post_ID').val();
        var post_status = $('#inline_' + post_id).find('.inline-edit-status select').val();
        
        // Update post status if custom status is selected
        $('#post_status_' + post_id).text(post_status);
    });
});

