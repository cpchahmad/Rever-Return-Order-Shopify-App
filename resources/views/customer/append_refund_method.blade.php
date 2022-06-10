
<link rel="stylesheet" href="{{asset('css/design-app.css')}}">
<link rel="stylesheet" href="{{asset('css/refund_page.css')}}">

<style>
    @import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap");

    * {
        margin: 0;
        padding: 0;
    }

    body {
        background: #ecf2fe;
        height: 100vh;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        font-family: "Roboto", sans-serif;
    }

    .plans {

        padding: 1px 82px;

    }

    .plans .plan input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .plans .plan {
        cursor: pointer;
        /*width: 48.5%;*/
        width: 50%;
    }

    .plans .plan .plan-content {
        /*display: -webkit-box;*/
        /*display: -ms-flexbox;*/
        /*display: flex;*/
        padding: 5px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        border: 2px solid #e1e2e7;
        border-radius: 10px;
        -webkit-transition: -webkit-box-shadow 0.4s;
        transition: -webkit-box-shadow 0.4s;
        -o-transition: box-shadow 0.4s;
        transition: box-shadow 0.4s;
        transition: box-shadow 0.4s, -webkit-box-shadow 0.4s;
        /*position: relative;*/
    }

    .plans .plan .plan-content img {
        /*margin-right: 30px;*/
        /*height: 72px;*/
    }

    .plans .plan .plan-details span {
        margin-bottom: 10px;
        display: block;
        font-size: 20px;
        line-height: 24px;
        color: #252f42;
    }

    .container .title {
        font-size: 16px;
        font-weight: 500;
        -ms-flex-preferred-size: 100%;
        flex-basis: 100%;
        color: #252f42;
        margin-bottom: 20px;
    }

    .plans .plan .plan-details p {
        color: #646a79;
        font-size: 14px;
        line-height: 18px;
    }

    .plans .plan .plan-content:hover {
        -webkit-box-shadow: 0px 3px 5px 0px #e8e8e8;
        box-shadow: 0px 3px 5px 0px #e8e8e8;
    }

    .plans .plan input[type="radio"]:checked + .plan-content:after {
        content: "";
        position: absolute;
        height: 8px;
        width: 8px;
        background: #216fe0;
        right: 20px;
        top: 20px;
        border-radius: 100%;
        border: 3px solid #fff;
        -webkit-box-shadow: 0px 0px 0px 2px #0066ff;
        box-shadow: 0px 0px 0px 2px #0066ff;
    }

    .plans .plan input[type="radio"]:checked + .plan-content {
        border: 2px solid #216ee0;
        background: #eaf1fe;
        -webkit-transition: ease-in 0.3s;
        -o-transition: ease-in 0.3s;
        transition: ease-in 0.3s;
    }

    @media screen and (max-width: 991px) {
        .plans {
            margin: 0 20px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: flex-start;
            padding: 40px;
        }

        .plans .plan {
            width: 100%;
        }

        .plan.complete-plan {
            margin-top: 20px;
        }

        .plans .plan .plan-content .plan-details {
            width: 70%;
            display: inline-block;
        }

        .plans .plan input[type="radio"]:checked + .plan-content:after {
            top: 45%;
            -webkit-transform: translate(-50%);
            -ms-transform: translate(-50%);
            transform: translate(-50%);
        }
    }

    @media screen and (max-width: 767px) {
        .plans .plan .plan-content .plan-details {
            width: 60%;
            display: inline-block;
        }
    }

    @media screen and (max-width: 540px) {
        .plans .plan .plan-content img {
            margin-bottom: 20px;
            height: 56px;
            -webkit-transition: height 0.4s;
            -o-transition: height 0.4s;
            transition: height 0.4s;
        }

        .plans .plan input[type="radio"]:checked + .plan-content:after {
            top: 20px;
            right: 10px;
        }

        .plans .plan .plan-content .plan-details {
            width: 100%;
        }

        .plans .plan .plan-content {
            padding: 20px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: baseline;
            -ms-flex-align: baseline;
            align-items: baseline;
        }
    }

    /* inspiration */
    .inspiration {
        font-size: 12px;
        margin-top: 50px;
        position: absolute;
        bottom: 10px;
        font-weight: 300;
    }

    .inspiration a {
        color: #666;
    }
    @media screen and (max-width: 767px) {
        /* inspiration */
        .inspiration {
            display: none;
        }
    }

</style>
        <div class="option-heading row mt-4">
            <h3>select a refund option</h3>
        </div>
{{--        <div class="refund-option-div row gap-1">--}}
{{--            <div class="col-md-5">--}}
                @if(in_array('payment_method',$allowed_methods))

                        <div class="container">
                            <div class="plans">

                                <label class="plan basic-plan" for="basic">
                                    <input checked type="radio" name="refund" value="payment_method" id="basic" />
                                    <div class="plan-content">

                                        <div class="instant-refund">
                                            <div style="display: flex">
                                            <p><strong>Get an instant refund</strong></p>

                                               <span><img style="padding: unset" src="{{asset('images/Vector(1).png')}}" alt=""></span>
                                            </div>
                                            <p><small>Description</small></p>
                                                     </div>



                                        </div>

                                </label>

                            </div>
                        </div>

{{--                <div class="instant-refund">--}}
{{--                    <p><strong>Get an instant refund</strong>--}}
{{--                        <span><img src="img/Vector(1).png" alt=""></span></p>--}}
{{--                    <p><small>Description</small></p>--}}
{{--                </div>--}}

                    @endif
{{--            </div>--}}
{{--            <div class="col-md-5">--}}
{{--                <div class="giftcard">--}}
{{--                    <p><strong> Refund to a giftcard</strong><span><img src="img/Vector(2).png" alt=""></span></p>--}}
{{--                    <p><small>Description</small></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="option-heading row">--}}
{{--            <h3>select a return method</h3>--}}
{{--        </div>--}}
{{--        <div class="return-method row gap-1">--}}
{{--            <div class="col-md-5">--}}
{{--                <div class="pickup">--}}
{{--                    <p><strong>Home pickup</strong><span><img src="img/Vector(3).png" alt=""></span></p>--}}
{{--                    <p><small>Description</small></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col-md-5">--}}
{{--                <div class="collection">--}}
{{--                    <p><strong>Deliver to collection point</strong>--}}
{{--                        <span><img src="img/Vector(3).png" alt=""></span>--}}
{{--                    </p>--}}
{{--                    <p><small>Description</small></p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <button type="submit" class="continue-btn"><strong>continue</strong></button>
