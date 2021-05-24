@extends('admin.layouts.app')
@section('styles')
<link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
    <style>
        input[type='checkbox'] {
            margin-right:10px;
        }
    </style>
@endsection
@section('scripts')
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن تولیدکننده</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.manufacturers.index') }}">تولیدکننده‌ها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.manufacturers.update', $manufacturer->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                    @csrf
                    @method('patch')
                        <div class="form-group">
                            <label for="name" class="col-md-2 control-label">نام تولید کننده</label>
                            <div class="col-md-10">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $manufacturer->name) }}" placeholder="نام تولید کننده را وارد کنید">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="col-md-2 control-label">اسلاگ</label>
                            <div class="col-md-10">
                                <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $manufacturer->slug) }}" dir="ltr">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="image" class="col-md-2 control-label">لوگو</label>
                            <div class="col-md-10">
                                <input id="image" type="file" name="image" class="dropify">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="col-md-2 control-label">ترتیب</label>
                            <div class="col-md-10">
                                <input id="sort_order" type="number" class="form-control" name="sort_order" value="{{ old('sort_order', $manufacturer->sort_oreder) }}" min="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-md-2 control-label">معرفی</label>
                            <div class="col-md-10">
                                <textarea id="description" type="text" class="form-control" name="description" rows="5" value="{{ old('description', $manufacturer->description) }}"></textarea>
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
<table class="hide">
    <tbody>
        <tr id="clone">
            <td><input type="text" name="name[]" class="form-control"></td>
            <td><textarea name="sort_order[]" class="form-control"></textarea></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item">
                    <span class="fa fa-trash"></span> حذف
                </button>
            </td>
        </tr>
    </tbody>
</table>
@endsection
@include('admin/layouts/partials/tinymce')
