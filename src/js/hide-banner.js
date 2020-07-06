$(".hdsb-stickybanner-close").click(function () {
    $(".hdsb-stickybanner").hide();
    $(".hdsb-stickybanner").addClass('is-inactive').removeClass('is-active');
    Cookies.set("sticky-banner", true, {
        expires: 7
    });
});
$(function () {
    if (Cookies.get("sticky-banner")) {
        $(".hdsb-stickybanner").addClass('is-inactive').removeClass('is-active');
    } else {
        $(".hdsb-stickybanner").addClass('is-active').removeClass('is-inactive');
    }
});