(function($){
    $('.box').hover(
        function(){
            $(this).find('.caption').fadeIn(250);  // slideDown(250);
        },
        function(){
            $(this).find('.caption').fadeOut(250); // slideUp(250);
        }
    ); 
})(jQuery);
