jQuery(document).ready(function($){
   
    function showHideRegisterModel(){
        if(jQuery("body #uat-msgbox .fancybox-close-small").length > 0){
            jQuery.fancybox.close();
        }
        jQuery('.uatmodal').toggleClass('is-visible');
        jQuery('body').toggleClass('uat-model-open');
    }
    jQuery(document).on("click","div#uat-register-form a[data-src='#uat-login-form']",function(e) {
        showHideRegisterModel()
    });
    jQuery(".registerModal").click(function(e) {
        $.fancybox.close();
        showHideRegisterModel()
    });
	/* --------------------------------------------------------
	 Stickey header on/off
	----------------------------------------------------------- */
	if(front_data.menu_sticky =="on"){
		jQuery(document).on('scroll', function() {
			if (jQuery(this).scrollTop() > 250) {
				jQuery('header').addClass("sticky");
			} else {
				jQuery('header').removeClass("sticky");
			}
		});
	}
    /* --------------------------------------------------------
	 Add the css for auction menu in WCFM dashboard
	----------------------------------------------------------- */
	if (jQuery('#wwcfm_uwa_auctions_listing_expander').length) {
	    jQuery('.wcfm_menu_wcfm-uwa-auctionslist').css('background', '#17a2b8');
	}
	/* --------------------------------------------------------
	 Header My-account Menu
	----------------------------------------------------------- */
	$(".h-myaccount").on('click', header_my_account_menu);

    function header_my_account_menu(event) {
        if (jQuery(".h-myaccountwrap").hasClass("active")) {
            jQuery('.h-myaccountwrap').removeClass('active');
        } else {
            jQuery('.h-myaccountwrap').addClass('active');
        }
    }(function($) {
        $('[data-fancybox]').fancybox({
            closeExisting: true,
            loop: true
        });
    })(jQuery)
    if (typeof jQuery.fn.slick !== 'undefined') {

        jQuery('.slick-carousel-event').slick({
            arrows: true,
            centerPadding: "0px",
            dots: false,
            slidesToShow: 4,
            infinite: false,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,                                         
                  }
                },
                {
                  breakpoint: 640,
                  settings: {
                    slidesToShow: 2, 
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,                    
                  }
                }                
              ]
        });
        jQuery('.slick-carousel').slick({
            arrows: true,
            centerPadding: "0px",
            dots: false,
            slidesToShow: 4,
            infinite: false,
            responsive: [
                {
                  breakpoint: 1024,
                  settings: {
                    slidesToShow: 3,                                         
                  }
                },
                {
                  breakpoint: 640,
                  settings: {
                    slidesToShow: 2, 
                  }
                },
                {
                  breakpoint: 480,
                  settings: {
                    slidesToShow: 1,                    
                  }
                }                
              ]
        });
    }
});

/*Page Loader*/
jQuery(window).on('load', function() {
    jQuery(".se-pre-con").fadeOut("slow");
});
jQuery("#remove-msg").click(function() {
    jQuery(".error-msg-box div").hide();
});
/*Page Loader End*/

/* menu js start here */
(function($) {
    $.fn.menumaker = function(options) {
        var cssmenu = $(this),
            settings = $.extend({
                format: "dropdown",
                sticky: false
            }, options);
        return this.each(function() {
            $(this).find(".menu-icon").on('click', function() {
                $(this).toggleClass('menu-opened');
                var mainmenu = $(this).siblings('ul');
                if (mainmenu.hasClass('open')) {
                    mainmenu.slideToggle().removeClass('open');
                } else {
                    mainmenu.slideToggle().addClass('open');
                    if (settings.format === "dropdown") {
                        mainmenu.find('ul').show();
                    }
                }
            });
            cssmenu.find('li ul').parent().addClass('has-sub');
            multiTg = function() {
                cssmenu.find(".has-sub").prepend('<span class="submenu-button"></span>');
                cssmenu.find('.submenu-button').on('click', function() {
                    $(this).toggleClass('submenu-opened');
                    if ($(this).siblings('ul').hasClass('open')) {
                        $(this).siblings('ul').removeClass('open').slideToggle();
                    } else {
                        $(this).siblings('ul').addClass('open').slideToggle();
                    }
                });
            };
            if (settings.format === 'multitoggle') multiTg();
            else cssmenu.addClass('dropdown');
            if (settings.sticky === true) cssmenu.css('position', 'fixed');
            resizeFix = function() {
                var mediasize = 1023;
                if ($(window).width() > mediasize) {
                    cssmenu.find('ul').show();
                }
                if ($(window).width() <= mediasize) {
                    cssmenu.find('ul').hide().removeClass('open');
                }
            };
            resizeFix();
            return $(window).on('resize', resizeFix);
        });
    };
})(jQuery);
(function($) {
    $(document).ready(function() {
        $("#cssmenu").menumaker({
            format: "multitoggle"
        });
        $(".drop-down__button").click(function() {
            $(".drop-down__menu-box").toggleClass("active");
        });
    });
})(jQuery);

/* menu js end */

jQuery(document).ready(function($) {
    $('.home-slider').owlCarousel({
        nav: true,
        items: 1,
        loop: true,
        center: true,
        margin: 0,
        dots: false,
        responsive: {
            0: {
                stagePadding: 60,
                items: 1,
                margin: 15,
            },
            767: {
                items: 1,
            }
        }
    })
    $('.midia-slider').owlCarousel({
        nav: false,
        items: 1,
        loop: true,
        center: true,
        margin: 15,
        dots: false,
        responsive: {
            0: {
                stagePadding: 60,
                items: 1,
            },
            767: {
                items: 1,
            }
        }
    })
    $('.upcoming-auction-slider').owlCarousel({
        nav: true,
        items: 3,
        itemsDesktop: false,
        itemsDesktopSmall: false,
        itemsTablet: false,
        itemsTabletSmall: false,
        itemsMobile: false,
        loop: false,
        center: false,
        margin: 13,
        dots: false,
        responsiveClass: true,
        stagePadding: 0,
        responsive: {
            0: {
                items: 1,
                stagePadding: 10,
            },
            640: {
                items: 2,
            },
            1024: {
                items: 3,
                nav: true
            }
        }
    })
    $('.trending-item-slider').owlCarousel({
        nav: true,
        items: 4,
        loop: false,
        center: false,
        margin: 15,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,
            },
            640: {
                items: 2,
            },
            1024: {
                items: 3,
                nav: true
            },
            1199: {
                items: 4,
                nav: true
            }
        }
    })
    $('.followed-campaings-slider').owlCarousel({
        nav: true,
        items: 2,
        loop: false,
        center: false,
        margin: 25,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                stagePadding: 40,
                items: 1,
            },
            600: {
                items: 1,
            },
            1024: {
                items: 2,
                nav: true
            }
        }
    })
    $('.Charity-partners-slider').owlCarousel({
        nav: true,
        items: 4,
        loop: false,
        center: false,
        margin: 25,
        dots: false,
        responsiveClass: true,
        responsive: {
            0: {
                stagePadding: 40,
                items: 1,
            },
            600: {
                items: 2,
            },
            1024: {
                items: 3,
                nav: true
            },
            1199: {
                items: 4,
                nav: true
            }
        }
    })
    $("#my-ac").click(function() {
        $(this).toggleClass("on");
        $("#my-ac-option").slideToggle();
    });
    $(".fancybox").fancybox();
    $(document).on("click", ".tab", function() {


        $id = $(this).attr("rel");
        $(".tab").removeClass("active");
        $(this).addClass("active");


        $(".tab_content").removeClass("tab_content_active").fadeOut(200);
        $(".tab_content" + $id).addClass("tab_content_active");
    })
    $('.auction-details a[href^="#"]').click(function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        if (target.length) {
            var scrollTo = target.offset().top - 300
            $('body, html').animate({
                scrollTop: scrollTo + '320'
            }, 800);
        }
    });
    $('a#bid-inc-tab').click(function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        var target_ = $(this).attr('href');

        $(".wc-tabs>li.active").removeClass("active");
        target_ = target_.replace('#', '');
       var target_title = target_.replace('tab-', '');
        $(".wc-tabs>li."+target_title+"_tab").addClass("active");

        jQuery("div.woocommerce-Tabs-panel").css("display","none");
        $("div#tabs-content>div#"+target_).css("display","block");
        if (target.length) {
            var scrollTo = target.offset().top
            $('body, html').animate({
                scrollTop: scrollTo - '320'
            }, 800);
        }
    });

});
jQuery(document).ready(function($) {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 4;
    var syncedSecondary = true;
    sync1.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: false,
        autoplay: true,
        dots: true,
        loop: true,
        responsiveRefreshRate: 200,
        navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
    }).on('changed.owl.carousel', syncPosition);
    sync2
        .on('initialized.owl.carousel', function() {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: true,
            nav: true,
            smartSpeed: 200,
            slideSpeed: 500,
            slideBy: 1,
            animateOut: 'slideOutUp',
            animateIn: 'slideInUp',
            responsiveRefreshRate: 100
        }).on('changed.owl.carousel', syncPosition2);
    function syncPosition(el) {
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);
        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        /*end block*/

        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();
        if (current > end) {
            sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }
    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
        }
    }
    sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
    });
});
jQuery(window).scroll(function() {
    if (jQuery(this).scrollTop() > 250) {
        jQuery('header').addClass("sticky");
    } else {
        jQuery('header').removeClass("sticky");
    }
});
jQuery(function() {
    jQuery('a[href="#search"]').on("click", function(event) {
        event.preventDefault();
        jQuery("#search").addClass("open");
        jQuery('#search > form > input[type="search"]').focus();
    });
    jQuery("#search, #search button.close").on("click keyup", function(event) {
        if (
            event.target == this ||
            event.target.className == "close" ||
            event.keyCode == 27
        ) {
            jQuery(this).removeClass("open");
        }
    });
});
jQuery(document).ready(function($) {
    $(document).on('click', '.close-user-notice', function() {
        var user_type = $(this).data('notice-type');
        var user_id = $(this).data('user-id');
        // Update the user's meta to prevent the notice from showing again
        $.ajax({
            type: 'POST',
            url: UAT_Ajax_Url,
            data: {
                action: 'update_user_notice_meta', 
                user_type: user_type, 
                user_id: user_id, 
            },
            success: function (response) {
                window.location.reload();
            },
            error: function (xhr, status, error) {
            }
        });
    });
});
(function($) {
    $.fn.menumaker = function(options) {  
     var auctionmenu = $(this), settings = $.extend({
       format: "dropdown",
       sticky: false
     }, options);
     return this.each(function() {
       $(this).find(".bar-button").on('click', function(){
         $(this).toggleClass('menu-opened');
         var mainmenu = $(this).next('ul');
         if (mainmenu.hasClass('open')) { 
           mainmenu.slideToggle().removeClass('open');
         }
         else {
           mainmenu.slideToggle().addClass('open');
           if (settings.format === "dropdown") {
             mainmenu.find('ul').show();
           }
         }
       });
       auctionmenu.find('li ul').parent().addClass('has-child');
    multiTg = function() {
         auctionmenu.find(".has-child").prepend('<span class="submenu-button"></span>');
         auctionmenu.find('.submenu-button').on('click', function() {
           $(this).toggleClass('child-menu-opened');
           if ($(this).siblings('ul').hasClass('open')) {
             $(this).siblings('ul').removeClass('open').slideToggle();
           }
           else {
             $(this).siblings('ul').addClass('open').slideToggle();
           }
         });
       };
       if (settings.format === 'multitoggle') multiTg();
       else auctionmenu.addClass('dropdown');
       if (settings.sticky === true) auctionmenu.css('position', 'fixed');
    resizeFix = function() {
      var mediasize = 1023;
         if ($( window ).width() > mediasize) {
           auctionmenu.find('ul').show();
         }
         if ($(window).width() <= mediasize) {
           auctionmenu.find('ul').hide().removeClass('open');
         }
       };
       resizeFix();
       return $(window).on('resize', resizeFix);
     });
      };
    })(jQuery);
 
    
    
    (function($){
    $(document).ready(function(){
    $("#auctionmenu").menumaker({
       format: "multitoggle"
    });
    });
    })(jQuery);

    /* Car theme JS */ 

    document.addEventListener("DOMContentLoaded", function() {
        (function() {
          var v = document.getElementsByClassName("youtube-player");
          for (var n = 0; n < v.length; n++) {
            v[n].innerHTML = labnolThumb(v[n].dataset.id);
            v[n].onclick = labnolIframe;
          }
        })();
      
        function labnolThumb(id) {
          return '<img class="youtube-thumb" src="//i.ytimg.com/vi/' + id + '/maxresdefault.jpg"><div class="play-button"></div>';
        }
      
        function labnolIframe() {
          var iframe = document.createElement("iframe");
          iframe.setAttribute("src", "//www.youtube.com/embed/" + this.parentNode.dataset.id + "?autoplay=1&autohide=2&border=0&wmode=opaque&enablejsapi=1&controls=1&showinfo=1");
          iframe.setAttribute("frameborder", "0");
          iframe.setAttribute("id", "youtube-iframe");
          this.parentNode.replaceChild(iframe, this);
        }
      });