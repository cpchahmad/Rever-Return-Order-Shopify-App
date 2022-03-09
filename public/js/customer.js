$(document).ready(function () {
$('.payment_type_list').click(function(){
    var type = $(this).attr('type');
    $('#payment_type').val(type).change();
    $('#payment_submit_form').submit();
});
$('#additonal_information').click(function(){
    var add_comment = $('#add_comment').val();
    $('#confirm_comment').val(add_comment).change();
    $('.additional_information_wrapper').hide();
    $('.confirm_wrapper').show();
});
});

$( document ).ready(function() {
    $('.icons_images').click(function (e) {
        e.preventDefault()
        $(this).css("display", "none")
        $(this).parents().find(a)
    });
    $('.mina_oneeee').click(function (e){
        $('.two_popup').css("display", "block")
        $('.two_popup').css("opacity", "1")
        $(".one_popup").addClass('d__none');

    });

    $('.two_popup .header_popup .back img').click(function (e){
        $('.two_popup').css("display", "none")
        $(".one_popup").removeClass('d__none');
    });
    $('.img_Size_three .image_parentt').click(function (e){

        $(this).toggleClass('Custom_border')

    });
    $('.img_Size_three.active .image_parentt').click(function (e){
        $(this).removeClass('Custom_border');
    })

    $('#after_btn_checked').click(function (e){
        $(this).parents().find('.two_popup').css("display","none")
        $('.three_popup').css("display","block");
    });
    $('label[data-lable="retuen"]').click(function (e){
        $(this).parents().find('.one_popup').css("display","none");
        $('.four_popup').css("display","block");
    }) ;
    $('.click_label').click(function (e){
        var input_type = $(this).parent('.radio__start').find('input[name="refund"]');
        input_type.attr("checked","checked")
    });




});


