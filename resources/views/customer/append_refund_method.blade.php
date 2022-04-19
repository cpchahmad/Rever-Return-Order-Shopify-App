<link rel="stylesheet" href="{{asset('css/refund_page.css')}}">

<style>

    @media only screen and (max-width: 350px) and (min-width: 320px)  {


        .popupBody{

            margin-top: 150px !important;
        }
    }
    @media only screen and (max-width: 450px) and (min-width: 351px)  {


        .popupBody{

            margin-top: 130px !important;
        }
    }


    @media only screen and (max-width: 820px) and (min-width: 700px)  {


        .popupBody{

            margin-top: 70px !important;
        }
    }
</style>
<div class="main_section_popup">

    <div class="overlay_section"></div>
    <div class="popUpmain">
        <div class="popupBody" style="margin-top: 10px;">
            <div class="title__main">
                <span>How do you want it to be refunded?</span>
            </div>
            <div class="div--two_section_under">
                <div class="label__one label_main">
                    @if(in_array('store_credit',$allowed_methods))
                        <div class="radio__start">
                            <input type="radio" name="refund" id="second" value="store_credit">
                            <label for="second" class="click_label">
                                <div class="under_padding">
                                    <div class="under_main_text">
                                        <div class="upper__title">
                                            <span>Refund to store credit</span>
                                        </div>
                                        <div class="main__flex_refund">
                                            <div class="under__paragraph">
                                                <p>Quick way to shop other products as soon as you ship the product
                                                    back.</p>
                                            </div>
                                            <div class="rupise__doller">
                                                <span>${{number_format(floatval($amount),2)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endif
                    @if(in_array('payment_method',$allowed_methods))
                        <div class="radio__start">
                            <input type="radio" name="refund" id="first" value="payment_method">
                            <label for="first" class="click_label">
                                <div class="under_padding">
                                    <div class="under_main_text">
                                        <div class="upper__title">
                                            <span>Refund to original Payment</span>
                                        </div>
                                        <div class="main__flex_refund">
                                            <div class="under__paragraph">
                                                <p>Receive a refund to original payment method once your return is
                                                    approved</p>
                                            </div>
                                            <div class="rupise__doller">
                                                <span>${{number_format(floatval($amount),2)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
