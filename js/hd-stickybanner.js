jQuery(document).ready(function ($) {
    if (scriptParams.hd_stickybanner_text != "") {
        if (!scriptParams.in_array) {
            $('<div id="hd-stickybanner" class="hd-stickybanner hd-stickybanner-'+scriptParams.hd_stickybanner_position+'"><span class="hd-stickybanner-text">' + scriptParams.hd_stickybanner_text + '</span><a class="hd-stickybanner-btn" href="' + scriptParams.hd_stickybanner_btn_link + '">' + scriptParams.hd_stickybanner_btn_text + '</a></div>')
                .prependTo('body');
        }
    }
    // Use header height to set body padding-top
    $(window).resize(function() {
        $(document.body).css('padding-top', $('.hd-stickybanner-top').outerHeight(true));
    }).resize();
    
    // Use header height to set body padding-bottom
    $(window).resize(function() {
        $(document.body).css('padding-bottom', $('.hd-stickybanner-bottom').outerHeight(true));
    }).resize();
});