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
                    <h2>افزودن استان</h2>
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
                    <form action="{{ route('admin.provinces.store') }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام استان *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="code" class="control-label col-md-3 col-sm-3 col-xs-12">کد *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="latitude" class="control-label col-md-3 col-sm-3 col-xs-12">عرض جغرافیایی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="longitude" class="control-label col-md-3 col-sm-3 col-xs-12">طول جغرافیایی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}">
                            </div>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-success" value="افزودن استان">
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
