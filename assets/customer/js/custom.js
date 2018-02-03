$(function () {
    $(document).on("click", "[data-attribute] , [data-attribute] *", function (e) {
        e.preventDefault();
        $("[data-pop='" + $(this).attr("data-attribute") + "']").addClass("opend-pop").fadeIn();
        $("body").addClass("overlay");
    });

    $(document).on("click", function (e) {
        if ($(".opend-pop").length > 0 && !$(e.target).is(" .opend-pop *  , [data-attribute] , [data-attribute] *")) {

            $(".opend-pop").fadeOut();
            $("body").removeClass("overlay");

        }
    });
});