jQuery(document).ready(function ($) {
    var curent_buyer_page = jQuery("input[name='buyer-dashboard-page']").val();
    jQuery('.Sales-tab-list #tabs-nav li').removeClass('active');
    jQuery('.Sales-tab-list #tabs-nav li[data-page="'+curent_buyer_page+'"]').addClass('active');
});
