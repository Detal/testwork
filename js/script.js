$(function(){
    $("[data-tooltip]").mousemove(function(eventObject){
        $data_tooltip = $(this).attr("data-tooltip");
       // $data1 = $(this).attr("value");
        if($(this).prop("disabled") == true){
            $("#tooltip").text($data_tooltip + ". недоступно")
                .css({
                    "top" : eventObject.pageY +5,
                    "left" : eventObject.pageX +5
                })
                .show();
        }else {
            $("#tooltip").text($data_tooltip)
                .css({
                    "top": eventObject.pageY + 5,
                    "left": eventObject.pageX + 5
                })
                .show();
        }
    }).mouseout(function(){
        $("#tooltip").hide()
            .text("")
            .css({
                "top" : 0,
                "left" : 0
            });
    });
});

/*$('form').submit(function(){

    $(this).find('.error_mail').remove();

    if($(this).find('input[name=mail]').val()==''){
        $(this).find('label.email').after('<span class="error_mail">Введите email</span>');
    }
    /!*if($(this).find('input[name=place]').prop('checked')){
        $(this).find('form').after('<span class="error_mail">Ввыберите место</span>');
    }*!/
    $.post(
        $(this).attr('/www/controller/control.php'),
        $(this).serialize()
    );
    return false;
});*/

$(function(){
    $("input[name=mail]").mousemove(function(eventObject){
        $data_tooltip = "Введите email";
        // $data1 = $(this).attr("value");
        if($(this).prop("disabled") == true){
            $("#tooltip").text($data_tooltip)
                .css({
                    "top" : eventObject.pageY +5,
                    "left" : eventObject.pageX +5
                })
                .show();
        }else {
            $("#tooltip").text($data_tooltip)
                .css({
                    "top": eventObject.pageY + 5,
                    "left": eventObject.pageX + 5
                })
                .show();
        }
    }).mouseout(function(){
        $("#tooltip").hide()
            .text("")
            .css({
                "top" : 0,
                "left" : 0
            });
    });
});