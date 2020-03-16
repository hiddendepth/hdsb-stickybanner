// Preview colour changes
jQuery(document).ready(function($){
    var bgColourOptions = {
        // a callback to fire whenever the color changes to a valid color
        change: function(event, ui){
            $(".hd-stickybanner").css( 'background', ui.color.toString());
            $(".hd-stickybanner-btn").css( 'color', ui.color.toString());
        },
        // a callback to fire when the input is emptied or an invalid color
        //clear: function() {},
        // show a group of common colors beneath the square
        // or, supply an array of colors to customize further
        palettes: ['#000', '#fff', '#FF003A', '#EACE47', '#3F9FF2', '#5B36B7', '#1AD490', '#242134']
    };
    $('.hd-stickybanner-bg-colour-picker').wpColorPicker(bgColourOptions);
});

jQuery(document).ready(function($){
    var bgTextOptions = {
        change: function(event, ui){
            $(".hd-stickybanner-text").css( 'color', ui.color.toString());
            $(".hd-stickybanner-btn").css( 'background', ui.color.toString());
        },
        palettes: ['#000', '#fff', '#FF003A', '#EACE47', '#3F9FF2', '#5B36B7', '#1AD490', '#242134']
    };
    $('.hd-stickybanner-text-colour-picker').wpColorPicker(bgTextOptions);
});