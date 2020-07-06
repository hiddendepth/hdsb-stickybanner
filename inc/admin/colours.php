<?php
//add custom CSS colors
add_action('wp_head', 'hdsb_stickybanner_custom_colour');
function hdsb_stickybanner_custom_colour()
{
    if (get_option('hdsb_stickybanner_colour') != "") {
?>
        <style type="text/css" media="screen">
            .hdsb-stickybanner {
                background: <?php echo get_option('hdsb_stickybanner_colour'); ?> !important;
            }

            .hdsb-stickybanner-btn {
                color: <?php echo get_option('hdsb_stickybanner_colour'); ?> !important;
            }

            .hdsb-stickybanner-btn:hover {
                color: <?php echo get_option('hdsb_stickybanner_colour'); ?> !important;
            }
        </style>
    <?php
    }

    if (get_option('hdsb_stickybanner_text_colour') != "") {
    ?>
        <style type="text/css" media="screen">
            .hdsb-stickybanner-text {
                color: <?php echo get_option('hdsb_stickybanner_text_colour'); ?> !important;
            }

            .hdsb-stickybanner-btn {
                background: <?php echo get_option('hdsb_stickybanner_text_colour'); ?> !important;
            }
        </style>
<?php
    }
}
