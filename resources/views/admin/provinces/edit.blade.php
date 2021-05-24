@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش استان</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.provinces.index') }}">استان‌ها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.provinces.update', $province->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام استان *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $province->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-xs-12">کد *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $province->code) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="latitude" class="control-label col-md-3 col-sm-3 col-xs-12">عرض جغرافیایی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $province->latitude) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="longitude" class="control-label col-md-3 col-sm-3 col-xs-12">طول جغرافیایی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $province->longitude) }}">
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
<!-- /.row -->
@endsection
@include('admin/layouts/partials/tinymce')
