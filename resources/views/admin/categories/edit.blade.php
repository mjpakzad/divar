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
            $('#fields').select2({
                dir: "rtl",
            });
            $('#parent_id').select2();
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
                        <h2>ویرایش دسته‌بندی</h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="{{ route('admin.categories.index') }}">دسته‌بندی‌ها
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
                                    <a href="#tab_fields" data-toggle="tab" aria-expanded="false">فیلدهای داینامیک</a>
                                </li>
                            </ul>
                            <br>
                            <form action="{{ route('admin.categories.update', $category->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                                @csrf
                                @method('PATCH')
                                <div class="tab-content">
                                    <div id="tab_general" class="tab-pane active">
                                        <div class="form-group">
                                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام دسته‌بندی *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ *</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $category->slug) }}" dir="ltr">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="content" id="content" class="form-control tinymce">{{ old('content', $category->content) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab_seo" class="tab-pane">
                                        <div class="form-group">
                                            <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ کلمات کلیدی</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="کلمات کلیدی را با خط تیره (-) از هم جدا کنید">{{ old('meta_keywords', comma2dash($category->meta_keywords)) }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ توضیحات</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ old('meta_description', $category->meta_description) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab_information" class="tab-pane">
                                        <div class="form-group">
                                            <label for="parent_id" class="control-label col-md-3 col-sm-3 col-xs-12">دسته‌بندی والد</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="parent_id" id="parent_id" class="form-control" dir="rtl">
                                                    <option value="">فاقد والد</option>
                                                    @foreach($parents as $id => $name)
                                                        <option value="{{ $id }}"{{ (old('parent_id', $category->parent_id) == $id ? 'selected' : '') }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}" min="0" max="999">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="file" name="image" id="image" class="dropify" @if($category->image_id) data-default-file="{{ asset($category->image->name) }}" @endif >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="buy" class="control-label col-md-3 col-sm-3 col-xs-12">برچسب خرید</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="buy" id="buy" class="form-control" value="{{ old('buy', $category->buy) }}" placeholder="تقاضا">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="sell" class="control-label col-md-3 col-sm-3 col-xs-12">برچسب فروش</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="text" name="sell" id="sell" class="form-control" value="{{ old('sell', $category->sell) }}" placeholder="عرضه">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="featured" class="control-label col-md-3 col-sm-3 col-xs-12">برجسته</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="featured" id="featured" value="1"{{ (old('featured', $category->featured) ? ' checked' : '') }} class="flat">
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> انتشار" data-off="<i class='fa fa-close text-red'></i> پیش نویس"{{ old('status', $category->status) ? ' checked' : '' }} data-width="120">
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab_fields" class="tab-pane">
                                        <div class="form-group">
                                            <label for="fields" class="control-label col-md-3 col-sm-3 col-xs-12">فیلدها</label>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <select name="fields[]" id="fields" class="form-control" multiple="multiple" dir="rtl">
                                                    @foreach($fields as $field)
                                                        <option value="{{ $field->id }}"{{ (in_array($field->id, old('fields', $selectedFields)) ? 'selected' : '') }}>{{ $field->name_label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                        <input type="submit" class="btn btn-success" value="ذخیره تغییرات">
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
@include('admin/layouts/partials/tinymce')
@endsection
