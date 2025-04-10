jQuery(document).ready(function ($) {
    UAT_Ajax_Url = UATAUCTION.ajaxurl;
    /* Ajax query String */
    Ajax_qry_str = Uat_Ajax_Qry.ajaxqry;
    Uat_last_activity = UATAUCTION.last_timestamp;
    /* --------------------------------------------------------
     AUction Products Countdown Timer
    ----------------------------------------------------------- */
    running = false;


    /* --------------------------------------------------------
     Add / Remove savedlist
    ----------------------------------------------------------- */
    $(".uat-savedlist-action").on('click', savedlist);
    function savedlist(event) {
        var auction_id = jQuery(this).data('auction-id');
        var page_name = jQuery(this).data('page-name');
        var currentelement = $(this);
        jQuery.ajax({
            type: "get",
            url: UAT_Ajax_Url,
            data: {
                post_id: auction_id,
                'uat-ajax': "savedlist"
            },
            success: function (response) {
                if (page_name == 'saved') {
                    location.reload(true);
                } else {
                    currentelement.parent().replaceWith(response);
                    $(".uat-savedlist-action").on('click', savedlist);
                    jQuery(document.body).trigger('uat-savedlist-action', [response, auction_id]);
                }
            }
        });
    }
    /* --------------------------------------------------------
     Add / Remove savedlist loop
    ----------------------------------------------------------- */
    jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);
    function savedlist_loop(event) {
        var auction_id = jQuery(this).data('auction-id');
        var currentelement = jQuery(this);
        jQuery.ajax({
            type: "get",
            url: UAT_Ajax_Url,
            data: {
                post_id: auction_id,
                'uat-ajax': "savedlist_loop"
            },
            success: function (response) {
                currentelement.parent().replaceWith(response);
                jQuery(".uat-savedlist-action-loop").unbind().on('click', savedlist_loop);
                jQuery(document.body).trigger('uat-savedlist-action-loop', [response, auction_id]);
            }
        });
    }
    /*appends an "active" class to .popup and .popup-content when the "Open" button is clicked */
    $(".share").on("click", function () {
        $(".sharebox").slideToggle(500);
    });
    /* --------------------------------------------------------
         Slider For Product Detail Page
        ----------------------------------------------------------- */
    if (jQuery('.swiper-container-wrapper').length > 0) {
        var slider = new Swiper('.gallery-slider', {
            slidesPerView: 1,
            centeredSlides: true,
            loop: true,
            autoHeight: true,
            loopedSlides: 6,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });


        var thumbs = new Swiper('.gallery-thumbs', {
            slidesPerView: 'auto',
            spaceBetween: 10,
            centeredSlides: true,
            loop: false,
            slideToClickedSlide: true,
            loopedSlides: 6
        });

        if (jQuery('.gallery-slider').length > 0) {
            thumbs.controller.control = slider;
        }
        if (jQuery('.gallery-thumbs').length > 0) {
            slider.controller.control = thumbs;
        }
    }

    /*
        --------------------------------------------------------
        Load More Lots
        -----------------------------------------------------------
        */
    size_li = jQuery('.LotmoreSearch-results').children('.item').length;
    x = 3;
    jQuery('#LotmoreSearch-results .item:lt(' + x + ')').show();
    if (x >= size_li) {
        jQuery('.load-more-btn').hide();
    }
    jQuery('#see_more_related').click(function () {
        x = (x + 3 <= size_li) ? x + 3 : size_li;
        //x= size_li;
        jQuery('#LotmoreSearch-results .item:lt(' + x + ')').show();
        if (size_li == x) {
            jQuery('.load-more-btn').hide();
        }
    });
    jQuery(document).on('click', '.share-icon', function () {
        jQuery(this).toggleClass('active'); // Add or remove the 'active' class when clicked
        jQuery(this).find('#share-icon-list').toggle('slow');
    });
});

jQuery(document).ready(function() {
    

    jQuery(document).on("click",".mobile-hamburger",function() {
        jQuery(this).toggleClass("change");
            jQuery(".top-right-menu-ul").toggleClass("show-menu");
        });        

    jQuery(".menuItem").click(function() {
        jQuery(".menuItem").removeClass("change");
        jQuery(this).addClass("change");
        jQuery(".top-right-menu-ul ol").removeClass("show");
        jQuery(this).closest("ol").addClass("show");
    });
});