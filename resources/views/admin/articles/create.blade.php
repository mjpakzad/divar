@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
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
    @parant
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('.dropify').dropify();
        $('#groups').select2({
            dir: "rtl",
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن مقاله</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.blog.index') }}">وبلاگ
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="nav-tabs-custom no-shadow">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_general" data-toggle="tab" aria-expanded="true">عمومی</a>
                            </li>
                            <li>
                                <a href="#tab_seo" data-toggle="tab" aria-expanded="false">سئو</a>
                            </li>
                            <li>
                                <a href="#tab_information" data-toggle="tab" aria-expanded="false">اطلاعات</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                            <div class="tab-content">
                                <div id="tab_general" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان مقاله *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" dir="ltr">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="groups" class="control-label col-md-3 col-sm-3 col-xs-12">دسته‌بندی‌ها</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="groups[]" id="groups" class="form-control" dir="rtl" multiple>
                                                <option value="">دسته‌بندی‌ها را انتخاب کنید</option>
                                                @foreach($groups as $id => $name)
                                                    <option value="{{ $id }}"{{ (in_array($id, old('groups') ?? []) ? 'selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="content" id="content" class="form-control tinymce">{{ old('content') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_seo" class="tab-pane">
                                    <div class="form-group">
                                        <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ کلمات کلیدی</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="کلمات کلیدی را با خط تیره (-) از هم جدا کنید">{{ old('meta_keywords') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_information" class="tab-pane">
                                    <div class="form-group">
                                        <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="image" id="image" value="{{ old('image') }}" class="dropify">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div id="gender" class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                    <input type="radio" name="status" value="0" data-parsley-multiple="status"{{ (old('status') == 0 ? ' checked' : '') }}> پیش‌نویس
                                                </label>
                                                <label class="btn btn-primary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                    <input type="radio" name="status" value="1" data-parsley-multiple="status"{{ (old('status') == 1 ? ' checked' : '') }}> انتشار
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="submit" class="btn btn-success" value="افزودن مقاله">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection
@include('admin/layouts/partials/tinymce')
