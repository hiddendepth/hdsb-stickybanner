<?php
$bgColour        = get_option('hdsb_stickybanner_colour');
$textColour      = get_option('hdsb_stickybanner_text_colour');
$text            = get_option('hdsb_stickybanner_text');
$sb_position     = get_option('hdsb_stickybanner_position');
$btnText         = get_option('hdsb_stickybanner_btn_text');
$btnLink         = get_option('hdsb_stickybanner_btn_link');
$sb_cookieExpiry = get_option('hdsb_stickybanner_cookie_expiry');
if (!empty($sb_cookieExpiry)) {
    $sb_cookieExpiry = $sb_cookieExpiry;
} else {
    $sb_cookieExpiry = 7;
}

$currentPage = get_the_ID();
$hidePages    = get_option('hdsb_stickybanner_hide_on_pages');
$hidePagesArray = explode(',', $hidePages);

if (!in_array($currentPage, $hidePagesArray) && !empty($text)) { ?>
    <div id="hdsb-stickybanner" class="hdsb-stickybanner hdsb-stickybanner-<?php echo $sb_position; ?>">
        <span class="hdsb-stickybanner-text"><?php echo $text; ?></span>
        <?php if (!empty($btnLink)) : ?>
            <a class="hdsb-stickybanner-btn" href="<?php echo $btnLink; ?>">
                <?php if (!empty($btnText)) {
                    echo $btnText;
                } else {
                    echo 'Learn more';
                }
                ?>
            </a>
        <?php endif; ?>
        <div class="hdsb-stickybanner-close"></div>
    </div><!-- hdsb-stickybanner -->
    <script>
        jQuery(document).ready(function($) {
            var $body = $("body");
            var $stickybanner_position = "<?php echo $sb_position; ?>";

            // Check for active SB cookie
            if (Cookies.get("sticky-banner")) {
                $(".hdsb-stickybanner").addClass('is-inactive').removeClass('is-active');
            } else {
                $(".hdsb-stickybanner").addClass('is-active').removeClass('is-inactive');
            }

            // Add class and padding to body
            if ($(".hdsb-stickybanner-top").hasClass("is-active")) {
                $body.addClass("hdsb-t-active");

                $(window).on("load resize", function() {
                    var $bannerTop = $(".hdsb-stickybanner-top");
                    $(".hdsb-t-active").css("padding-top", $bannerTop.outerHeight());
                }).resize();

            } else if ($(".hdsb-stickybanner-bottom").hasClass("is-active")) {
                $body.addClass("hdsb-b-active");

                $(window).on("load resize", function() {
                    var $bannerBottom = $(".hdsb-stickybanner-bottom");
                    $(".hdsb-b-active").css("padding-bottom", $bannerBottom.outerHeight());
                }).resize();
            }

            // Close SB and set cookie
            $(".hdsb-stickybanner-close").click(function() {
                $(".hdsb-stickybanner").hide();
                $(".hdsb-stickybanner").addClass("is-inactive").removeClass("is-active");
                $body.removeAttr("style");
                $body.removeClass("hdsb-b-active");
                $body.removeClass("hdsb-t-active");

                Cookies.set("sticky-banner", true, {
                    expires: <?php echo $sb_cookieExpiry; ?>
                });
            });
        });
    </script>
<?php } ?>