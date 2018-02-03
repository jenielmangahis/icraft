$(document).ready(function () {

    $(document).on("click", function (e) {
        if (!$(e.target).is(".navigation , .navigation  *  , .nav_wrapper , .nav_wrapper * ")) {

            $(".navigation").removeClass("active");
            $("body").removeClass("overlay");
        }
    });
    $(".close").on("click", function () {

        $("body").removeClass("overlay");
    });

    $(document).on("click", function (e) {
        if ($(".opend-pop").length > 0 && !$(e.target).is(".opend-pop , .opend-pop *, [data-attribute] , [data-attribute] * ")) {
           
        }
    });
    $("body").on("click", "[data-attribute] , [data-attribute] *", function (e) {
        e.preventDefault();
        $("[data-pop='" + $(this).attr("data-attribute") + "']").addClass("opend-pop").fadeIn();
        $("body").addClass("overlaypop");
        
    });


    $('.close_model').click(function () {
        $('body').removeClass('overlaypop');
        $('.insta-pop').removeClass('opend-pop');
        $('.insta-pop').fadeOut();
    });
    
    $('.close_model_call').click(function () {
        $('body').removeClass('overlaypop');
        $('.insta-pop.call-pop').removeClass('opend-pop');
        $('.insta-pop.call-pop').hide();
    });


    $('button.btn.blue_btn.btn_go.account-creation').click(function () {
        $(".slide-overflow").animate({ left: '-100%' }, 'slow');
        $('button.btn.blue_btn.btn_go.go_back').click(function () {
            $(".slide-overflow").animate({ left: '0' }, 'slow');
        });
    });
    $('.btn.blue_btn.btn_go.verification').click(function () {
        $('.overlaypop').addClass('moreindex');

    });
    //$.fn.openPopup = function (popVal) {
    //    $("[data-pop='" + popVal + "']").addClass("opend-pop").fadeIn();
    //    $("body").addClass("overlaypop");
    //};

    //$.fn.closePopup = function (popVal) {
    //    $("[data-pop='" + popVal + "']").removeClass("opend-pop").fadeOut();
    //    $("body").removeClass("overlaypop");
    //};

//    $("[data-pop]").closePopup("login_pop");
//    $("[data-pop]").openPopup("login_pop");

});



