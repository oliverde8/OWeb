$(document).ready(function () {

    $(".box_content").click(function () {



        if (!$(this).parent().find(".box_description_content").is(':visible')) {

            $(this).parent().find('.box_description').animate({height: "500px"}, 0);
            applyMasonary();
            $(this).parent().find('.box_description').animate({height: "0px"}, 0);

            $(this).parent().find('.box_description').animate({height: "200px"}, 500, function () {
                applyMasonary();
                $(this).parent().find(".box_description_content").show(0);
            });

        } else {
            $(this).parent().find(".box_description_content").hide(500, function () {
                $(this).parent().animate({height: "0px"}, 0, function () {
                    applyMasonary();
                });
            });
        }
    });

    function applyMasonary() {

        $('.programs').masonry({
            // options
            itemSelector: '.box'
        });
    }

});