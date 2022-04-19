<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $settings=\App\Models\Setting::first();
    ?>
    <link rel="stylesheet" href="{{asset('css/font.css')}}">
    @if($settings!=null && $settings->logo!==null)
        <link rel="icon" href="{{asset('logos/'.$settings->logo)}}" type="image/png">
    @else
        <link rel="icon" href="{{asset('argon/img/brand/favicon.png')}}" type="image/png">
    @endif
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    @if($settings!=null && $settings->logo!==null)
        <style>
            body
            {
                background-image: url('{{asset('logos/'.$settings->background)}}') !important;
                height: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                /*background-position: center center !important;*/
                background-attachment: fixed !important;
            }
            @media screen and (max-width: 500px)
            {
                .product_title h3
                {
                    font-size: 15px;
                }
                .variants
                {
                    font-size: 14px;
                }
                .price_product
                {
                    font-size: 14px;
                }
            }

            /*@media only screen and (max-width: 360px) and (min-width: 320px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 50px !important;*/
            /*    }*/
            /*}*/

            /*@media only screen and (max-width: 370px) and (min-width: 360px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 60px !important;*/
            /*    }*/
            /*}*/

            /*@media only screen and (max-width: 380px) and (min-width: 370px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 65px !important;*/
            /*    }*/
            /*}*/

            /*@media only screen and (max-width: 390px) and (min-width: 380px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 70px !important;*/
            /*    }*/
            /*}*/

            /*@media only screen and (max-width: 400px) and (min-width: 390px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 75px !important;*/
            /*    }*/
            /*}*/

            /*@media only screen and (max-width: 430px) and (min-width: 400px)  {*/


            /*    .logo-img{*/

            /*        margin-left: 80px !important;*/
            /*    }*/
            /*}*/



        </style>
    @else
        <style>
            body
            {
                background-image: url('{{asset('images/Rectangle.png')}}') !important;
                height: 100%;
                background-repeat: no-repeat;
                background-size: cover;
                /*background-position: center center !important;*/
                background-attachment: fixed !important;
            }
        </style>
    @endif
<style>
    div#shopify-section-announcement-bar {
        display: none;
    }
    sticky-header.header-wrapper.color-background-1.gradient.header-wrapper--border-bottom {
        display: none;
    }
    footer.footer.color-background-1.gradient.section-footer-padding {
        display: none;
    }
</style>
    @yield('css')

    <title>Centric Return</title>
</head>
<body>
<section class="banner" id="append_data">
    @yield('content')
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script src="{{asset('js/customer.js')}}"></script>
@yield('script')

<script src="{{asset('argon/vendor/js-cookie/js.cookie.js')}}"></script>
<script src="{{asset('argon/vendor/jquery.scrollbar/jquery.scrollbar.min.js')}}"></script>
<script src="{{asset('argon/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js')}}"></script>
<script src="{{asset('argon/vendor/lavalamp/js/jquery.lavalamp.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.min.js')}}"></script>
<script src="{{asset('argon/vendor/chart.js/dist/Chart.extension.js')}}"></script>
<script src="{{asset('argon/js/argon.mine209.js?v=1.0.0')}}"></script>
<script src="{{asset('argon/js/demo.min.js')}}"></script>
<script src="{{asset('js/slick.min.js')}}"></script>


<script>

    $('.loading').fadeOut();

        $(".create_new").click(function (e) {

            e.preventDefault();
            $('.loading').fadeIn();
            $.ajax({
               type:"GET",
               url: $(".create_new").attr('href'),
                success:function (result) {

                    $("body").html(result);
                }
            });


        });


    $(".new_request").click(function (e) {

        e.preventDefault();
        $('.loading').fadeIn();
        $.ajax({
            type:"GET",
            url: $(".new_request").attr('href'),
            success:function (result) {
                // console.log();
                $("body").html(result);
            }
        });


    });


        $("#product_list").submit(function (e) {
            e.preventDefault();

            var checkedVals = $('.checkboxes:checkbox:checked').map(function() {
                return this.value;
            }).get();
            var count=0;
            for(var i=0; i<checkedVals.length;i++){
                if($('select[name="reason-'+checkedVals[i]+'"]').val() == '' ){
                    $('select[name="reason-'+checkedVals[i]+'"]').addClass('is-invalid');
                    count=i+1;
                }
                if($('select[name="type-'+checkedVals[i]+'"]').val() == '' ){
                    $('select[name="type-'+checkedVals[i]+'"]').addClass('is-invalid');
                    count=i+1;

                }
                if($('select[name="type-'+checkedVals[i]+'"]').val() == 'Exchange' ){

                    if($('option_submit-'+checkedVals[i]).val()=='0')
                    {
                        console.log('insde');
                        $('select[name="type-'+checkedVals[i]+'"]').addClass('is-invalid');
                        count=i+1;
                    }

                }
            }
            if(count != 0){
                // e.preventDefault();
                $("html, body").animate({
                    scrollTop: 0
                }, 2000);
                return false;
            }

            $('.loading').fadeIn();

            $.ajax({

              type:"GET",
              url:$("#product_list").attr("action"),
                data: $("#product_list").serialize(),
                success:function (result) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 2000);

                    $("body").html(result);

                }

            });

        });


        $("#upload_form").submit(function (e) {

           e.preventDefault();
            $('.loading').fadeIn();

            $.ajax({
                type:"POST",
                url: $("#upload_form").attr("action"),
                data: $("#upload_form").serialize(),
                success:function (result) {
                    $("body").html(result);
                }

            });
        });





        $("#finalselection").submit(function (e) {

            e.preventDefault();
            $('.loading').fadeIn();
            $.ajax({
                type:"GET",
                url: $("#finalselection").attr("action"),
                data: $("#finalselection").serialize(),
                success:function (result) {
                    $("body").html(result);
                }


            });
        })


        $('.payment_type_list').click(function(){

            var type = $(this).attr('type');
            $('#payment_type').val(type).change();
            // $('#payment_submit_form').submit();
            $('.loading').fadeIn();
            $.ajax({
                type:"POST",
                url:$("#payment_submit_form").attr("action"),
                data:$("#payment_submit_form").serialize(),
                success:function (result) {
                    $("body").html(result);
                }

            });


        });

        $("#conformed").submit(function (e) {

            e.preventDefault();
            $('.loading').fadeIn();

            $.ajax({
                type:"GET",
                url:$("#conformed").attr("action"),
                data:$("#conformed").serialize(),
                success:function (result) {
                    $("body").html(result);
                }


            });
        });

        $(".return_request").click(function (e) {
            e.preventDefault();
            $('.loading').fadeIn();
            $.ajax({
                type:"GET",
                url:$(this).attr("href"),
                success:function (result) {

                    $("body").html(result);

                }

            });

        });


        $(".back").click(function (e) {

            e.preventDefault();
            $('.loading').fadeIn();
            $.ajax({
            type:"GET",
             url:$(this).attr("href"),
             success:function (result) {
                 $("body").html(result);

             }

            });

        })
    $(".back_request").click(function (e) {

        e.preventDefault();
        // $('.loading').fadeIn();
        $.ajax({
            type:"GET",
            url:$(this).attr("href"),
            success:function (result) {


                // var results = JSON.parse(result);
                $('.loading').fadeOut();
                if(result.code ==  "404"){
                    $(".in-error ").addClass("alert alert-danger text-center");
                    $('.in-error').css("padding","10px");
                    $(".in-error").html(result.msg);

                }else if(result.code ==  "200") {

                    $("html, body").animate({
                        scrollTop: 0
                    }, 2000);


                    $("body").html(result.data);
                    // console.log($(result.data));
                }

            }
        });

    });





        $(".backs").click(function (e) {

            e.preventDefault();
            // $('.loading').fadeIn();
            $.ajax({
                type:"GET",
                url:$(this).attr("href"),
                success:function (result) {

                    $("body").html(result);

                }
            });

        })

</script>
<script>

    $('.returns_type').change(function (e) {

        var id= $(this).attr('name');
        var value=$(this).val();
        id=id.split('-');

        if(value == 'Exchange'){

            $('.exchange-box_'+id[1]).css('display', 'block');
        }else{
            $('.exchange-box_'+id[1]).css('display', 'none');
        }

    });

  $('#product_list').submit(function (e) {




  });
  $('.reason_type').change(function () {
        if($(this).val() != '' && $(this).hasClass('is-invalid')){
            $(this).removeClass('is-invalid');
        }
  })

    $('.returns_type').change(function () {
        if($(this).val() != '' && $(this).hasClass('is-invalid')){
            $(this).removeClass('is-invalid');
        }
        if($(this).val()=='Exchange')
            $('#exchange-modal-'+$(this).attr('data-id')).modal('show');
    });

  // $('.checkboxes').change(function(){
  //     if($('select[name=type-'+$(this).attr('data-id')+']').val()=='Exchange' && $(this).is('checked'))
  //         $('#exchange-modal-'+$(this).attr('data-id')).modal('show');
  // });

    if($('#inp').length){
        document.getElementById("inp").addEventListener("change", readFile);

    }

    function readFile() {

        if (this.files && this.files[0]) {
            var check =validate($(this).val());
            if(check != '404'){
                var FR= new FileReader();

                FR.addEventListener("load", function(e) {
                    $("#image_data").val(e.target.result) ;
                    var fa = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
                    $(".file_name_block").css("display", "block");
                    $(".file_name").text(fa+ " File is uploaded." );
                });

                FR.readAsDataURL( this.files[0] );
            }

        }

    }

    function validate(file) {
        var ext = file.split(".");
        ext = ext[ext.length-1].toLowerCase();
        var arrayExtensions = ["jpg","jpeg"];

        if (arrayExtensions.lastIndexOf(ext) == -1) {

            $("#inp").val("");
            $("#inp").addClass('is-invalid');
            $("#image_data").val("") ;
            $('.invalid-feedback').css('display','block');
            $(".file_name_block").css("display", "none");
            return "404";
        }else{
            $('.invalid-feedback').css('display','none');
        }
    }

    $('.option_submit_button').on('click',function(){
        $(this).closest('input').val('1');
    });

    $('.back_form_check').click(function (e) {

        e.preventDefault();
        $('.loading').fadeIn();

            $.ajax({
                type:"POST",
                url:$('#form_check').attr('action'),
                data:$('#form_check').serialize(),
                success:function(result) {
                    $("body").html(result);

                }



            });


    });

    function load_images_variant(element)
    {
        var baseUrl='https://phpstack-176572-1479351.cloudwaysapps.com';
        var item_id=$(element).attr('item');
        var elements=$('select[item='+item_id+']');
        var product=$(element).attr('product');
        var values=[];
        $.each($(elements),function(i,item){
            values[i]=$(item).val();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            method:'POST',
            url:baseUrl+'/product_images/'+product+'/image',
            data: {
                'options': values
            },
            success:function(response)
            {
                if(response!==null)
                {
                    $('#product_modal_image_'+product).attr('src',response.src);
                    $('#variant_exchange_'+item_id).val(response.variant_id);
                }
            },
            error:function(response)
            {

            }
        });
    }
</script>



</body>
</html>
