@extends('frontend.layouts.blank')
@section('styles')
    <style>
        #map{
            width: 900px;
            max-width: 100%;
            height: 500px;
            box-shadow: 0 0 2px 2px rgba(100,100,100,.1);
            border-radius: 4px;
        }
         .content {
            width: 100% !important;
            padding-right: 0 !important;
            padding-left: 0 !important;
            min-height: 100vh;
        }
    </style>
    <link rel="stylesheet" href="/template/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/template/css/owl.theme.default.css">
    <script src="/template/js/owl.carousel.js"></script>
    <script language="javascript">
        (function($){
            $(window).scroll(function () {
                var $heightScrolled = $(window).scrollTop();
                var $defaultHeight =210;

                if ( $heightScrolled < $defaultHeight )
                {
                    $('.top1').removeClass("fixedLinks-fx")
                }
                else {
                    $('.top1').addClass("fixedLinks-fx")
                }

            });
        })(jQuery);
    </script>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">تایید هویت</div>
                </div>
                <div class="panel-body">
                    <div id="loader" class="hide"></div>
                    <p class="text-center">کد ارسال شده به موبایل خود را وارد کنید، اعتبار کد تنها 15 دقیقه می‌باشد.</p>
                    <form action="{{ route('twoFactor.verification') }}" method="post">
                        @csrf
                        <div class="form-group row">
                            <label for="code" class="col-md-3 col-form-label text-md-left">کد تایید</label>

                            <div class="col-md-9">
                                <input id="code" type="number" class="text-right form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" value="{{ old('code') }}" required dir="ltr" size="4">

                                @if ($errors->has('code'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('code') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                                <button type="submit" class="btn-outline-success btn btn-block">تایید</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <form action="{{ route('twoFactor.resendVerification') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-link">ارسال مجدد کد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection