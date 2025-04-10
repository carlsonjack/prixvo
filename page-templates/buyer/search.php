 <?php
    $account_page_id = get_option('woocommerce_myaccount_page_id');
    $account_page_url = get_permalink($account_page_id);
    $notification_page =  $account_page_url . 'ua-auctions/notification/?notification-tab=email';
    $search_term = '{term}'; // Change this to your desired search term

    // Set the base URL
    $base_url = home_url('/');

    // Set the query arguments
    $query_args = array(
        's' => $search_term,
        'post_type' => 'product',
        'uat_auctions_search' => 'true'
    );

    // Generate the full URL
    $search_url = add_query_arg($query_args, $base_url);

    ?>
 <div class="buyer-page-title">
     <h1><?php _e('Saved Search', 'ultimate-auction-pro-software'); ?></h1>
 </div>

 <div class="search_input_box">

     <div class="search_result">
         <input type="search" id="savedSearchInput" placeholder="Add a new search" value="">
         <button id="savedSearchBtn" type="button" class="c-button-template">
             <span class="c-button__content">
                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="">
                     <path fill="currentColor" fill-rule="evenodd" d="M12.084 4.79a5.591 5.591 0 0 1 5.257-1.669 5.758 5.758 0 0 1 4.59 4.924 5.925 5.925 0 0 1-1.585 5.007L12 21.398l-8.346-8.346A5.925 5.925 0 0 1 2.07 8.045a5.758 5.758 0 0 1 4.59-4.924 5.591 5.591 0 0 1 5.257 1.67h.168ZM12 18.894l7.094-7.093a4.006 4.006 0 0 0 1.168-3.673 4.09 4.09 0 0 0-3.171-3.338 4.256 4.256 0 0 0-4.423 1.836.834.834 0 0 1-1.336 0A4.09 4.09 0 0 0 6.91 4.79a4.173 4.173 0 0 0-3.171 3.422 4.09 4.09 0 0 0 1.085 3.672L12 18.894Z" clip-rule="evenodd"></path>
                 </svg>
                 <span class="c-button__label"><?php _e('Save my search', 'ultimate-auction-pro-software'); ?></span>
             </span>
         </button>
     </div>
     <div class="search-tearm">
         <span class="search-team-text"><?php _e('We’ll let you know when there are new matches for your search terms.', 'ultimate-auction-pro-software'); ?> </span>
         <a href="<?php echo esc_url($notification_page); ?>" class="manage-link">
             <?php _e('Manage notifications', 'ultimate-auction-pro-software'); ?>
             <svg xmlns="http://www.w3.org/2000/svg" width="5" height="9" viewBox="0 0 5 9" class="u-m-l-xxs u-color-primary">
                 <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m1 8 3-3.5L1 1"></path>
             </svg>
         </a>
     </div>
 </div>
 <div>
     <span class="search-msg"><?php _e('Manage notifications', 'ultimate-auction-pro-software'); ?></span>
</div>
 <div class="save-search">

     <div class="right-save-search" style="display: none;">
         <div class="save-and-recent-searches">
             <h6><?php _e('Saved Search', 'ultimate-auction-pro-software'); ?></h6>
             <div class="save-searches-box"></div>
         </div>
     </div>

 </div>

 <script>
     var removeMsg = '<?php _e('The search term has been successfully removed.', 'ultimate-auction-pro-software'); ?>';
     var updateMsg = '<?php _e('The search term has been successfully updated.', 'ultimate-auction-pro-software'); ?>';
     var addedMsg = '<?php _e('The search term has been successfully added.', 'ultimate-auction-pro-software'); ?>';
     var searchUrlMain = '<?php echo $search_url; ?>';
     
     jQuery(document).ready(function($) {
         function searchResultHtml(term) {
            let searchUrl_ = searchUrlMain;
            searchUrl_ = searchUrl_.replace('{term}', term);
            let termHtml = `<div class="search-name-row">
                         <div class="icon-with-search-name">
                             <a class="like_icon" href="${searchUrl_}">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="u-color-light-gray">
                                     <path fill="currentColor" d="M17.341 3.121a5.591 5.591 0 0 0-5.258 1.67h-.167A5.591 5.591 0 0 0 6.66 3.12a5.758 5.758 0 0 0-4.59 4.924 5.925 5.925 0 0 0 1.585 5.007L12 21.398l8.346-8.346a5.925 5.925 0 0 0 1.585-5.007 5.758 5.758 0 0 0-4.59-4.924Z"></path>
                                 </svg>
                                 <p>${term}</p>
                             </a>
                         </div>
                         <div class="edit-and-remove" data-search-term="${term}">
                             <a class="edit_icon" href="#">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="c-button__icon u-color-dark-gray u-icon-m">
                                     <path fill="currentColor" d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25ZM5.92 19H5v-.92l9.06-9.06.92.92L5.92 19ZM20.71 5.63l-2.34-2.34c-.2-.2-.45-.29-.71-.29-.26 0-.51.1-.7.29l-1.83 1.83 3.75 3.75 1.83-1.83a.996.996 0 0 0 0-1.41Z"></path>
                                 </svg>
                             </a>
                             <a class="remove_icon" href="#">
                                 <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" role="img" class="c-button__icon u-color-dark-gray u-icon-m">
                                     <path fill="currentColor" d="M19 6.41 17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12 19 6.41Z"></path>
                                 </svg>
                             </a>
                         </div>
                     </div>`;
             return termHtml;
         }
         // Handle click event on the save-search button/link
         setSavedResults()

         function setSavedResults() {

             // Run the AJAX request
             $.ajax({
                 url: UAT_Ajax_Url,
                 type: 'POST',
                 data: {
                     action: 'save_search_result',
                 },
                 success: function(response) {
                     if (response.search_terms) {
                         $(".right-save-search").show();
                         $(".save-searches-box").html("");
                         if (response.search_terms.length) {
                             response.search_terms.forEach(term => {
                                 $(".save-searches-box").append(searchResultHtml(term));
                             });
                         } else {
                             $(".right-save-search").hide();
                         }
                     } else {
                         $(".right-save-search").hide();
                     }
                 }
             });
         }
         $(document).on('click', '.edit-and-remove .edit_icon', function(e) {
             e.preventDefault();
             $("#savedSearchInput").attr('data-old', "");
             $("#savedSearchInput").val("");
             var searchTerm = $(this).closest(".edit-and-remove").data('search-term');
             var searchStatus = true;
             $("#savedSearchInput").attr('data-old', searchTerm);
             $("#savedSearchInput").val(searchTerm);
         });
         $(document).keypress('#savedSearchInput', function(event) {
             // Check if the Enter key was pressed
             if (event.which === 13) {
                saveSearchActions()
             }
         });
         $(document).on('click', '#savedSearchBtn', function(event) {
             saveSearchActions()
         });
         
         function saveSearchActions(){
            var searchTerm = $("#savedSearchInput").val();
                 var searchTermOld = $("#savedSearchInput").attr('data-old');
                 $.ajax({
                     url: UAT_Ajax_Url,
                     type: 'POST',
                     data: {
                         action: 'save_search',
                         search_term: searchTerm,
                         search_term_old: searchTermOld,
                     },
                     success: function(response) {
                         if (searchTermOld != "") {
                             $(".search-msg").html(updateMsg).css('display', 'inline-block');
                         } else {
                             $(".search-msg").html(addedMsg).css('display', 'inline-block');
                         }
                         $("#savedSearchInput").attr('data-old', "");
                         $("#savedSearchInput").val("");
                         setSavedResults();
                         setTimeout(function() {
                             $(".search-msg").fadeOut();
                         }, 3000);
                     }
                 });
         }
         $(document).on('click', '.edit-and-remove .remove_icon', function(e) {
             e.preventDefault();

             var searchTerm = $(this).closest(".edit-and-remove").data('search-term');
             var searchStatus = true;

             // Run the AJAX request
             $.ajax({
                 url: UAT_Ajax_Url,
                 type: 'POST',
                 data: {
                     action: 'save_search',
                     search_term: searchTerm,
                     search_status: searchStatus,
                 },
                 success: function(response) {
                     $(".search-msg").html(removeMsg).css('display', 'inline-block');
                     setSavedResults();
                     setTimeout(function() {
                         $(".search-msg").fadeOut();
                     }, 3000);
                 }
             });
         });

     });
 </script>