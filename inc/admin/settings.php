<?php
add_action('admin_menu', 'hdsb_stickybanner_menu');
function hdsb_stickybanner_menu()
{
    add_menu_page('Sticky Banner Settings', 'Sticky Banner', 'administrator', 'hdsb-stickybanner-settings', 'hdsb_stickybanner_settings_page', 'dashicons-admin-generic');
}

add_action('admin_init', 'hdsb_stickybanner_settings');
function hdsb_stickybanner_settings()
{
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_colour');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_text_colour');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_text');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_position');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_btn_text');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_btn_link');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_cookie_expiry');
    register_setting('hdsb-stickybanner-settings-group', 'hdsb_stickybanner_hide_on_pages');
}

function hdsb_stickybanner_settings_page()
{
?>
    <div class="wrap">
        <div style="display: flex;justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2>Sticky Banner <br>
                by <a href="https://hiddendepth.ie/?utm_source=wp_plugin&utm_medium=website&utm_campaign=sticky_banner" target="_blank" style="">Hidden Depth</a>
            </h2>
            <a class="hdsb_donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=22P45UAZ84JQL&source=url" target="_blank">Donate Now</a>
        </div>

        <!-- Preview Banner -->
        <div id="preview_banner" class="hdsb-stickybanner">
            <span id="preview_banner_inner_text" class="hdsb-stickybanner-text">This is what your banner will look like.</span>
            <a id="preview_btn" class="hdsb-stickybanner-btn" href="/">Button text</a>
        </div>

        <!-- Settings Form -->
        <form method="post" action="options.php">
            <?php settings_fields('hdsb-stickybanner-settings-group'); ?>
            <?php do_settings_sections('hdsb-stickybanner-settings-group'); ?>
            <table class="form-table hdsb-stickybanner-admin-table">
                <!-- Background Colour -->
                <tr valign="top">
                    <th scope="row">Background Colour<br><span style="font-weight:400;">(Also button text colour)</span></th>
                    <td style="vertical-align:top;">
                        <input type="text" class="hdsb-stickybanner-bg-colour-picker" id="hdsb_stickybanner_colour" name="hdsb_stickybanner_colour" value="<?php echo ((get_option('hdsb_stickybanner_colour') == '') ? '#910A06' : esc_attr(get_option('hdsb_stickybanner_colour'))); ?>" data-default-color="#910A06" />
                    </td>
                </tr>
                <!-- Text Colour -->
                <tr valign="top">
                    <th scope="row">Text Colour<br><span style="font-weight:400;">(Also button background colour)</span></th>
                    <td style="vertical-align:top;">
                        <input type="text" class="hdsb-stickybanner-text-colour-picker" id="hdsb_stickybanner_text_colour" name="hdsb_stickybanner_text_colour" value="<?php echo ((get_option('hdsb_stickybanner_text_colour') == '') ? '#ffffff' : esc_attr(get_option('hdsb_stickybanner_text_colour'))); ?>" data-default-color="#ffffff" />
                    </td>
                </tr>

                <!-- Positioning -->
                <tr valign="top" class="hdsb-stickybanner-position">
                    <th scope="row">
                        Position
                    </th>
                    <td>
                        <div class="hdsb-stickybanner-position-radios">
                            <label><input type="radio" name="hdsb_stickybanner_position" value="top" required <?php checked('top', get_option('hdsb_stickybanner_position'), true); ?>>Top</label><br />
                            <label><input type="radio" name="hdsb_stickybanner_position" value="bottom" <?php checked('bottom', get_option('hdsb_stickybanner_position'), true); ?>>Bottom</label>
                        </div>
                    </td>
                </tr>

                <!-- Text Contents -->
                <tr valign="top">
                    <th scope="row">
                        Announcement
                        <br><span style="font-weight:400;">(Empty removes the banner)</span>
                    </th>
                    <td>
                        <input type="text" id="hdsb_stickybanner_text" name="hdsb_stickybanner_text" value="<?php echo esc_attr(get_option('hdsb_stickybanner_text')); ?>" />
                    </td>
                </tr>

                <!-- Button Text -->
                <tr valign="top" class="hdsb-stickybanner-btn-text">
                    <th scope="row">Button Text</th>
                    <td style="vertical-align:top;">
                        <input type="text" id="hdsb_stickybanner_btn_text" name="hdsb_stickybanner_btn_text" placeholder="Learn more" value="<?php echo esc_attr(get_option('hdsb_stickybanner_btn_text')); ?>" />
                    </td>
                </tr>

                <!-- Button Link -->
                <tr valign="top">
                    <th scope="row">Button Link<br><span style="font-weight:400;">E.G. https://hiddendepth.ie</span></th>
                    <td style="vertical-align:top;">
                        <input type="url" id="hdsb_stickybanner_btn_link" name="hdsb_stickybanner_btn_link" placeholder="https://hiddendepth.ie" value="<?php echo esc_attr(get_option('hdsb_stickybanner_btn_link')); ?>" />
                    </td>
                </tr>

                <!-- Cookie Expiry -->
                <tr valign="top">
                    <th scope="row">Cookie Expiry<br><span style="font-weight:400;">Empty defaults to 7 days</span></th>
                    <td style="vertical-align:top;">
                        <input type="number" id="hdsb_stickybanner_cookie_expiry" name="hdsb_stickybanner_cookie_expiry" placeholder="7" value="<?php echo esc_attr(get_option('hdsb_stickybanner_cookie_expiry')); ?>" />
                    </td>
                </tr>

                <!-- Hide on pages -->
                <tr valign="top">
                    <th scope="row">Hide on pages<br><span style="font-weight:400;">Use page IDs separated by commas</span></th>
                    <td style="vertical-align:top;">
                        <input type="text" id="hdsb_stickybanner_hide_on_pages" name="hdsb_stickybanner_hide_on_pages" value="<?php echo esc_attr(get_option('hdsb_stickybanner_hide_on_pages')); ?>" aria-describedby="pageHideHelp" />
                        <br>
                        <small id="pageHideHelp">Go to Pages and click Edit. In the address bar look for something like ?post=7. This is the page ID</small>

                    </td>
                </tr>
            </table>

            <!-- Save Changes Button -->
            <?php submit_button(); ?>
        </form>
    </div>

    <!-- Script to apply styles to Preview Banner -->
    <script type="text/javascript">
        var style_background_colour = document.createElement('style');
        var style_text_colour = document.createElement('style');

        // Banner Text
        document.getElementById('preview_banner_inner_text').innerHTML = document.getElementById('hdsb_stickybanner_text').value != "" ? document.getElementById('hdsb_stickybanner_text').value : 'This is what your banner will look like';
        document.getElementById('hdsb_stickybanner_text').onchange = function(e) {
            document.getElementById('preview_banner_inner_text').innerHTML = e.target.value != "" ? e.target.value : 'This is what your banner will look like';
        };

        // Banner Button Text
        document.getElementById('preview_btn').innerHTML = document.getElementById('hdsb_stickybanner_btn_text').value != "" ? document.getElementById('hdsb_stickybanner_btn_text').value : 'Button text';
        document.getElementById('hdsb_stickybanner_btn_text').onchange = function(e) {
            document.getElementById('preview_btn').innerHTML = e.target.value != "" ? e.target.value : 'Button text';
        };

        // Background Colour
        style_background_colour.type = 'text/css';
        style_background_colour.id = 'preview_banner_background_colour'
        style_background_colour.appendChild(document.createTextNode('.hdsb-stickybanner {background:' + (document.getElementById('hdsb_stickybanner_colour').value || '#910A06') + '} .hdsb-stickybanner .hdsb-stickybanner-btn {text-decoration: none; color:' + (document.getElementById('hdsb_stickybanner_colour').value || '#910A06') + ';}'));
        document.getElementsByTagName('head')[0].appendChild(style_background_colour);

        // Text Colour
        style_text_colour.type = 'text/css';
        style_text_colour.id = 'preview_banner_text_colour'
        style_text_colour.appendChild(document.createTextNode('.hdsb-stickybanner .hdsb-stickybanner-text{color:' + (document.getElementById('hdsb_stickybanner_text_colour').value || '#ffffff') + ';} .hdsb-stickybanner .hdsb-stickybanner-btn {padding: 4px 8px; margin: 0 10px; background:' + (document.getElementById('hdsb_stickybanner_text_colour').value || '#ffffff') + ';}'));
        document.getElementsByTagName('head')[0].appendChild(style_text_colour);
    </script>
<?php
}
