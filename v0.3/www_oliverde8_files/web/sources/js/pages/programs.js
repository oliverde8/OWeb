
$(document).ready(function(){

    $(".box_description").click(function() {
        alert("TEST1");
        $(this ).animate({height: "200px"}, 500);
        $(this).find(".box_description_content").animate({visibility: "visible"}, 750);
    });

});