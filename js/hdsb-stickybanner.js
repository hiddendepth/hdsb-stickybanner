jQuery(document).ready(function ($) {
    if (scriptParams.hdsb_stickybanner_text != "") {
        if (!scriptParams.in_array) {
            $('<div id="hdsb-stickybanner" class="hdsb-stickybanner hdsb-stickybanner-'+scriptParams.hdsb_stickybanner_position+'"><span class="hdsb-stickybanner-text">' + scriptParams.hdsb_stickybanner_text + '</span><a class="hdsb-stickybanner-btn" href="' + scriptParams.hdsb_stickybanner_btn_link + '">' + scriptParams.hdsb_stickybanner_btn_text + '</a></div>')
                .prependTo('body');
        }
    }
    // Use header height to set body padding-top
    $(window).resize(function() {
        $(document.body).css('padding-top', $('.hdsb-stickybanner-top').outerHeight(true));
    }).resize();
    
    // Use header height to set body padding-bottom
    $(window).resize(function() {
        $(document.body).css('padding-bottom', $('.hdsb-stickybanner-bottom').outerHeight(true));
    }).resize();
});