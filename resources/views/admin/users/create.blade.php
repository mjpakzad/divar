@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <style>
        .select2-selection__choice {
            color: #666 !important;
        }
        .select2-container {
            width: 100% !important;
        }
        .select2-search__field {
            width: 100% !important;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#city').select2({
                dir: "rtl",
            });
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن کاربر</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.users.index') }}">کاربران
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.users.store') }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label for="first_name" class="control-label col-md-3 col-sm-3 col-xs-12">نام</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="control-label col-md-3 col-sm-3 col-xs-12">نام خانوادگی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">نقش کاربری</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}"{{ (old('role') == $id ? ' selected' : '') }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">نام کاربری</label>--}}
                            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                {{--<input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="mobile" class="control-label col-md-3 col-sm-3 col-xs-12">موبایل *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">ایمیل</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">تلفن ثابت</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="phone" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation" class="control-label col-md-3 col-sm-3 col-xs-12">شغل</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="occupation" name="occupation" id="occupation" class="form-control" value="{{ old('occupation') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">شهر</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="city_id" id="city" class="form-control">
                                    @foreach($cities as $id => $city)
                                        <option value="{{ $id }}"{{ (old('city_id') == $id ? ' selected' : '') }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">پسورد</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-primary" value="افزودن کاربر">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
