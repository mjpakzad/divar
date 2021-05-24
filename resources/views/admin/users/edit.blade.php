@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش کاربر {{ $user->name }}</h2>
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
                    <form action="{{ route('admin.users.update', $user->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="first_name" class="control-label col-md-3 col-sm-3 col-xs-12">نام</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ old('first_name', $user->first_name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="control-label col-md-3 col-sm-3 col-xs-12">نام خانوادگی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ old('last_name', $user->last_name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">نقش کاربری</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="role" id="role" class="form-control">
                                    @foreach($roles as $id => $role)
                                        <option value="{{ $id }}"{{ (old('role', $user->roles()->pluck('id')[0] ?? '') == $id ? ' selected' : '') }}>{{ $role }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<div class="form-group">--}}
                            {{--<label for="username" class="control-label col-md-3 col-sm-3 col-xs-12">نام کاربری</label>--}}
                            {{--<div class="col-md-6 col-sm-6 col-xs-12">--}}
                                {{--<input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <label for="mobile" class="control-label col-md-3 col-sm-3 col-xs-12">موبایل *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="mobile" id="mobile" class="form-control" value="{{ old('mobile', $user->mobile) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="control-label col-md-3 col-sm-3 col-xs-12">ایمیل</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="control-label col-md-3 col-sm-3 col-xs-12">تلفن ثابت</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="phone" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="occupation" class="control-label col-md-3 col-sm-3 col-xs-12">شغل</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="occupation" name="occupation" id="occupation" class="form-control" value="{{ old('occupation', $user->occupation) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">شهر</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <select name="city_id" id="city" class="form-control">
                                    @foreach($cities as $id => $city)
                                        <option value="{{ $id }}"{{ (old('city_id', $user->city_id) == $id ? ' selected' : '') }}>{{ $city }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="control-label col-md-3 col-sm-3 col-xs-12">پسورد</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="password" name="password" id="password" class="form-control">
                                <small class="help-block">فقط برای تغییر پسورد مقدار این فیلد را پر کنید.</small>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-primary" value="ذخیره تغییرات">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
