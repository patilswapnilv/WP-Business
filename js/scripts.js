jQuery(document).ready(function( $ ){

    // Image caption toggle
    $('.wp-caption-text').before('<span class="caption-toggle genericon genericon-info"></span>');
    $('.caption-toggle').click(function(){
        $(this).next('.wp-caption-text').fadeToggle();
    });

    // Slideshow navigation toggle
    $('#toggle-navigation').click(function(){
        $('#slider-navigation li').slideToggle('fast');
    });
    /**
     * Note -- See CSS for initial left/right positioning of elements for slide
     * in effect.
     */
    $('.flexslider').flexslider({
        animation: "fade",
        controlNav: true,
        manualControls: "#slider-navigation li",
        slideshow: false,
        prevText: "",
        nextText: "",
        smoothHeight: false,
        start: function(){
                $('.flexslider .entry-title').animate({
                    opacity: 1,
                    left: "0"
                });
                $('.flexslider .entry-caption').stop().delay(400).animate({
                    opacity: 1,
                    right: "0"
                });
                $('.flexslider a.call-to-action').stop().stop().animate({
                    opacity: 1,
                }, 100 );
            },
        after: function(){
            $('.flexslider .entry-title').animate({
                opacity: 1,
                left: "0"
            });
            $('.flexslider .entry-caption').stop().delay(400).animate({
                opacity: 1,
                right: "0"
            });
            $('.flexslider a.call-to-action').stop().stop().animate({
                opacity: 1,
            }, 100 );
        },
        before: function(){
            $('.flexslider a.call-to-action').stop().animate({
                opacity: 0
            }, 100 );
            $('.flexslider .entry-title').stop().animate({
                opacity: 0,
                left: "-=50"
            }, 100 );
            $('.flexslider .entry-caption').stop().animate({
                opacity: 0,
                right: "-=50"
            }, 100 );
        }
    });

    // in view animation effect
    $('.home article').waypoint(function(){
        $(this).addClass('come-in');
    }, {
        offset: '100%'
    });


    $(window).load(function(){
        $("#preloader").fadeOut(100);
        $("#masthead").fadeIn(100);
    });
});