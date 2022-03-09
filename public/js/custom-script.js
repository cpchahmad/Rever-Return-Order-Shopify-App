$(document).ready(function () {

    $('#customFileLang').change(function (e) {
        var fileName = e. target. files[0]. name;
        $('.file-name').text(fileName);

    });


    $('#request_settings').submit(function (e) {



        if($('#auto-decline').prop('checked')){
            if(!$("input:radio.decline:checked").val()){
               alert('Please decline request month');
               return false;
            }

        }
        if($('#auto-finished').prop('checked')){
            if(!$("input:radio.finished:checked").val()){
                alert('Please finished request month');
                return false;
            }

        }
    })

    $('.show_custom_add').click(function () {
        $('.custom_types').hide();
        $('.show_custom_add_form').show();
    });

    //


});
