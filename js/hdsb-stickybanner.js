jQuery(document).ready(function ($) {
    if (scriptParams.hdsb_stickybanner_text != "") {
        if (!scriptParams.in_array) {
            $('<div id="hdsb-stickybanner" class="hdsb-stickybanner hdsb-stickybanner-'+scriptParams.hdsb_stickybanner_position+'"><span class="hdsb-stickybanner-text">' + scriptParams.hdsb_stickybanner_text + '</span><a class="hdsb-stickybanner-btn" href="' + scriptParams.hdsb_stickybanner_btn_link + '">' + scriptParams.hdsb_stickybanner_btn_text + '</a></div>')
                .prependTo('body');
        }
    }

    if (scriptParams.hdsb_stickybanner_position === "top") {
        $(window).on("load resize", function (event) {
            var $navbar = $(".hdsb-stickybanner-top");
            var $body = $("body");
        
            $body.css("padding-top", $navbar.outerHeight());
        });
    } else if (scriptParams.hdsb_stickybanner_position === "bottom") {
        $(window).on("load resize", function (event) {
            var $navbar = $(".hdsb-stickybanner-bottom");
            var $body = $("body");
        
            $body.css("padding-bottom", $navbar.outerHeight());
        });
    }
});