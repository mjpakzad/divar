@extends('admin.layouts.app')
@section('styles')
    <link  rel="stylesheet"href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
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
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#parent_id').select2();
            $('#filters').select2({
                placeholder : 'گروه فیلترها انتخاب کنید',
                dir: "rtl",
            });
            $('#manufacturers').select2({
                placeholder : 'تولیدکننده‌ها را انتخاب کنید',
                dir: "rtl",
            });
        });
    </script>
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
                    <h2>افزودن دسته‌بندی</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.shop.categories.index') }}">دسته‌بندی‌ها
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
                            <li>
                                <a href="#tab_filters" data-toggle="tab" aria-expanded="false">فیلترها</a>
                            </li>
                            <li>
                                <a href="#tab_manufacturers" data-toggle="tab" aria-expanded="false">تولیدکننده‌ها</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.shop.categories.store') }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                            <div class="tab-content">
                                <div id="tab_general" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام دسته‌بندی *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" dir="ltr">
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
                                        <label for="parent_id" class="control-label col-md-3 col-sm-3 col-xs-12">دسته‌بندی والد</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="parent_id" id="parent_id" class="form-control" dir="rtl">
                                                <option value="">فاقد دسته‌بندی والد</option>
                                                @foreach($parents as $id => $name)
                                                    <option value="{{ $id }}"{{ (old('parent_id') == $id ? 'selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order') }}" min="0" max="999">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="image" id="image" class="dropify">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="featured" class="control-label col-md-3 col-sm-3 col-xs-12">برجسته</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" name="featured" id="featured" value="1"{{ (old('featured') ? ' checked' : '') }} class="flat">
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> انتشار" data-off="<i class='fa fa-close text-red'></i> پیش نویس"{{ old('status') ? ' checked' : '' }} data-width="120">
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_filters" class="tab-pane">
                                    <div class="form-group">
                                        <label for="filters" class="control-label col-md-3 col-sm-3 col-xs-12">فیلترها</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="filter_id[]" id="filters" class="form-control" multiple="multiple">
                                                @foreach($filters as $key => $filter)
                                                    <option value="{{ $key }}"{{ (in_array($key, old('filter_id') ?? []) ? ' selected' : '') }}>{{ $filter }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_manufacturers" class="tab-pane">
                                    <div class="form-group">
                                        <label for="manufacturers" class="control-label col-md-3 col-sm-3 col-xs-12">تولیدکننده‌ها</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="manufacturer_id[]" id="manufacturers" class="form-control" multiple="multiple">
                                                @foreach($manufacturers as $key => $manufacturer)
                                                    <option value="{{ $key }}"{{ (in_array($key, old('manufacturer_id') ?? []) ? ' selected' : '') }}>{{ $manufacturer }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="submit" class="btn btn-success" value="افزودن دسته‌بندی">
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
