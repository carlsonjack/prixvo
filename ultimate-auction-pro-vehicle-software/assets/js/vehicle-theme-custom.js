jQuery(function ($) {
    /*Gallery fancybox start*/
    /*Create template for the button*/
    var allCount = jQuery('[data-fancybox="gallery"]').length;
    $.fancybox.defaults.btnTpl.all = '<button data-fancybox-all class="fancybox-button fancybox-button-custom fancybox-button--all" data-type="all" >All Photos(' + allCount + ')</button>';
    $.fancybox.defaults.btnTpl.exterior = '<button data-fancybox-exterior class="fancybox-button fancybox-button-custom fancybox-button--exterior" data-type="Exterior" >Exterior</button>';
    $.fancybox.defaults.btnTpl.interior = '<button data-fancybox-interior class="fancybox-button fancybox-button-custom fancybox-button--interior" data-type="Interior" >Interior</button>';
    $.fancybox.defaults.btnTpl.mechanical = '<button data-fancybox-mechanical class="fancybox-button fancybox-button-custom fancybox-button--mechanical" data-type="Mechanical" >Mechanical</button>';
    $.fancybox.defaults.btnTpl.docs = '<button data-fancybox-docs class="fancybox-button fancybox-button-custom fancybox-button--docs" data-type="Docs" >Docs</button>';
    $.fancybox.defaults.btnTpl.other = '<button data-fancybox-other class="fancybox-button fancybox-button-custom fancybox-button--other" data-type="Other" >Other</button>';
    function menuClick(type = "") {
        if (type) {
            jQuery("div.card-image").each(function () {
                jQuery(this).find("a").removeClass("reopen");
                if (jQuery(this).data("type") == type) {
                    var imageUrl = jQuery(this).find("a:first-child").attr("href");
                    console.log(imageUrl)
                    jQuery(this).find("a:first-child").addClass("reopen");
                    $.fancybox.close();
                    return false;
                }
            });
        }
    }
    jQuery(document).on('click', 'div.img-group img', function () {
        $.fancybox.close();
        var imgUrl = jQuery(this).attr("src");
        var imgType = jQuery(this).attr("data-type");
        jQuery('.card-image-url[href="' + imgUrl + '"]').addClass("reopen");
    });
    jQuery('body').on('click', '[data-fancybox-exterior]', function () {
        var imgType = jQuery(this).attr("data-type");
        menuClick(imgType);
    });
    jQuery('body').on('click', '[data-fancybox-interior]', function () {
        var imgType = jQuery(this).attr("data-type");
        menuClick(imgType);
    });
    jQuery('body').on('click', '[data-fancybox-mechanical]', function () {
        var imgType = jQuery(this).attr("data-type");
        menuClick(imgType);
    });
    jQuery('body').on('click', '[data-fancybox-docs]', function () {
        var imgType = jQuery(this).attr("data-type");
        menuClick(imgType);
    });
    jQuery('body').on('click', '[data-fancybox-other]', function () {
        var imgType = jQuery(this).attr("data-type");
        menuClick(imgType);
    });
    jQuery('body').on('click', '[data-all-box="all"]', function (event) {
        if (jQuery('[data-all-box-img="all"]').length == 1) {
            jQuery('.fancybox-slide--current').removeClass("fancybox-slide--current fancybox-slide--complete");
            jQuery('.fancybox-navigation').css("display", "none");
            var imgGroupHtml = "";
            jQuery('.card-image-url').each(function () {
                var imgurl = jQuery(this).attr("href");
                imgGroupHtml = imgGroupHtml + "<img src='" + imgurl + "' />";
            });
            jQuery('.fancybox-stage').html("<div class='img-group'>" + imgGroupHtml + "</div>");
            jQuery("button.fancybox-button-custom").each(function () {
                if (jQuery(this).data("type") == 'all') {
                    jQuery(this).attr("style", "background-color: rgb(255, 255, 255) !important; color: #000 !important;");
                } else {
                    jQuery(this).attr("style", "");
                }
            });
            jQuery(this).removeAttr('data-all-box-img');
        }
    });
    $.fancybox.defaults.wheel = false;
    /*Gallery fancybox end*/
});
jQuery(document).on('click', '[data-fancybox-all]', function ($) {
    jQuery('.fancybox-slide--current').removeClass("fancybox-slide--current fancybox-slide--complete");
    jQuery('.fancybox-navigation').css("display", "none");
    var imgGroupHtml = "";
    jQuery('.card-image-url').each(function () {
        var imgurl = jQuery(this).attr("href");
        imgGroupHtml = imgGroupHtml + "<img src='" + imgurl + "' />";
    });
    jQuery('.fancybox-stage').html("<div class='img-group'>" + imgGroupHtml + "</div>");
    jQuery("button.fancybox-button-custom").each(function () {
        if (jQuery(this).data("type") == 'all') {
            jQuery(this).attr("style", "background-color: rgb(255, 255, 255) !important; color: #000 !important;");
        } else {
            jQuery(this).attr("style", "");
        }
    });
});
jQuery(document).ready(function () {
    jQuery('[data-fancybox="gallery"]').fancybox({
        buttons: [
            "all",
            "exterior",
            "interior",
            "mechanical",
            "docs",
            "other",
            "slideShow",
            "thumbs",
            "zoom",
            "fullScreen",
            "share",
            "close"
        ],
        loop: false,
        preload: 3,
        clickSlide: false,
        clickOutside: false,
        afterShow: function (instance, current) {
            var cur_image = current.src;
            var cur_image_div = jQuery("div.card-image > a[href='" + cur_image + "']");
            var imgType = cur_image_div.closest("div").attr("data-type");
            jQuery("button.fancybox-button-custom").each(function () {
                if (jQuery(this).data("type") == imgType) {
                    jQuery(this).attr("style", "background-color: rgb(255, 255, 255) !important; color: #000 !important;");
                } else {
                    jQuery(this).attr("style", "");
                }
            });
            jQuery("div.card-image").each(function () {
                jQuery(this).find("a").removeClass("reopen");
            });
        },
        afterClose: function () {
            jQuery('[data-all-box="all"]').attr('data-all-box-img', 'all');
            reopen();
        }
    });
});
function reopen() {
    jQuery("div.card-image > a").each(function () {
        if (jQuery(this).hasClass("reopen")) {
            var attr = jQuery(this).attr('data-all-box');
            if (typeof attr !== 'undefined' && attr !== false) {
                jQuery(this).removeAttr('data-all-box-img');
            }
            jQuery(this).click();
        }
    });
}
function keypressFunction() {
    document.getElementById("box").style.cssText = "background-color:White; box-shadow: -3px 1px 40px rgb(0 0 0 / 16%); border:none; ";
}
jQuery(function () {
    jQuery('a[href*="#"]:not([href="#"])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = jQuery(this.hash);
            target = target.length ? target : jQuery('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                jQuery('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
                return false;
            }
        }
    });
});