(function($){
    function slick_slider() {
        $('.slick-carousel').slick({
            dots: true,
            arrows: true,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 5000,
            speed: 1000,
            slidesToShow: 1,
            slidesToScroll: 1,
            adaptiveHeight: true,
            useTransform: false,
            pauseOnHover:false,
            fade: true,
        });
        
    }
    $(document).ready(function(){

        slick_slider();
        $('.slick-carousel').css('visibility', 'visible');

        $(window).scroll(function(){
         
            var headerHeight = $(".nav-top").outerHeight();
          
                if($(document).scrollTop() > headerHeight){
                    // console.log("fixed");
                    $('.nav-bottom').addClass('sticky-header');
                    $('.nav-header').addClass('sticky-header-top');
                }else{
                    // console.log("remove fixed");
                    $('.nav-bottom').removeClass('sticky-header');
                    $('.nav-header').removeClass('sticky-header-top');
                }
        });
        
        
        
    });
})( jQuery );