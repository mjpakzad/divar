@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $('#add-item').click(function(e) {
            e.preventDefault();
            var clone = $("#clone").clone();
            clone.attr('id', '');
            clone.find('.img').addClass('imageHolder');
            clone.appendTo("#items");
            $('.imageHolder:last').addClass('dropify').dropify();
        });
        $(document).on('click', '.remove-item', function () {
            $(this).closest('tr').remove();
        });
        $('.toggle').addClass('pull-right');
        $('.dropify').dropify();
    </script>
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
                            <a href="{{ route('admin.weather.index') }}"> هواشناسی
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
                                <a href="#tab_banner" data-toggle="tab" aria-expanded="true">استان</a>
                            </li>
                            <li>
                                <a href="#tab_items" data-toggle="tab" aria-expanded="false">آیتم‌ها</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.weather.update', $weather->id) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                            @csrf
                            @method('patch')
                            <div class="tab-content">
                                <div id="tab_banner" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-1 col-sm-3 col-xs-12">نام *</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $weather->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="control-label col-md-1 col-sm-3 col-xs-12">اسلاگ *</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $weather->slug) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> انتشار" data-off="<i class='fa fa-close text-red'></i> پیش‌نویس"{{ old('status', $weather->status) ? ' checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_items" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>عنوان</th>
                                                    <th>تصویر</th>
                                                    <th>فایل</th>
                                                    <th>ترتیب</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items">
                                            @foreach ($weather->items as $item)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="title[{{ $item->id }}]" class="form-control" value="{{ $item->title }}">
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="keeper[{{ $item->id }}]" value="{{ $item->id }}">
                                                        <input type="file" name="image[{{ $item->id }}]" data-default-file="/{{ $item->image->name ?? '' }}" class="dropify">
                                                    </td>
                                                    <td>
                                                        <input type="file" name="file[{{ $item->id }}]" class="form-control">
                                                        @if($item->file)
                                                        <br>
                                                        <a href="{{ asset($item->file) }}" class="btn btn-success btn-xs">دانلود</a>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <input type="number" name="sort_order[{{ $item->id }}]" class="form-control" value="{{ $item->sort_order }}">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs remove-item" title="حذف">
                                                            <span class="fa fa-trash"></span>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4"></td>
                                                    <td>
                                                        <button type="button" id="add-item" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> افزودن</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
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
<table class="hide">
    <tbody>
        <tr id="clone">
            <td><input type="text" name="title[]" class="form-control"></td>
            <td><input type="file" name="image[]" class="img"></td>
            <td><input type="file" name="file[]"></td>
            <td><input type="number" name="sort_order[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item" title="حذف">
                    <span class="fa fa-trash"></span>
                </button>
            </td>
        </tr>
    </tbody>
</table>
@endsection
