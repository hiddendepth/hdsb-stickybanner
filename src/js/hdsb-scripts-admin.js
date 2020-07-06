// @codekit-prepend quiet "js-cookies.min.js"

$(".hdsb-stickybanner-close").click(function () {
    $(".hdsb-stickybanner").hide();
});
$(function () {
    Cookies.remove('sticky-banner');
});