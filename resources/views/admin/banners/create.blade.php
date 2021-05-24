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
            clone.find('input[type=file]').addClass('imageHolder');
            clone.appendTo("#items");
            $('.imageHolder:last').addClass('dropify').dropify();
        });
        $(document).on('click', '.remove-item', function () {
            $(this).closest('tr').remove();
        });
        $('.toggle').addClass('pull-right');
        $('.dropify').dropify();
        $(document).on('click', '.editContent', function () {
            $(this).closest('tr').find('textarea').attr('id', 'activeEditor');
            var value = $('#activeEditor').val();
            tinymce.activeEditor.setContent(value);
        });
        $(document).on('click', '#accept', function () {
            var content = tinyMCE.activeEditor.getContent();
            $('#activeEditor').val(content).attr('id', '');
            tinymce.activeEditor.setContent('');
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن بنر</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.banners.index') }}">بنرها
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
                                <a href="#tab_banner" data-toggle="tab" aria-expanded="true">بنر</a>
                            </li>
                            <li>
                                <a href="#tab_items" data-toggle="tab" aria-expanded="false">آیتم‌ها</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.banners.store') }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                            <div class="tab-content">
                                <div id="tab_banner" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-1 col-sm-3 col-xs-12">نام بنر *</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="position" class="control-label col-md-1 col-sm-3 col-xs-12">موقعیت *</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="width" class="control-label col-md-1 col-sm-3 col-xs-12">عرض</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="number" name="width" id="width" class="form-control" value="{{ old('width') }}" dir="ltr" min="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="height" class="control-label col-md-1 col-sm-3 col-xs-12">طول</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="number" name="height" id="height" class="form-control" value="{{ old('height') }}" dir="ltr" min="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-1 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-11 col-sm-9 col-xs-12">
                                            <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> انتشار" data-off="<i class='fa fa-close text-red'></i> پیش‌نویس"{{ old('status') ? ' checked' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_items" class="tab-pane">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-condensed">
                                            <thead>
                                                <tr>
                                                    <th>عنوان</th>
                                                    <th>لینک</th>
                                                    <th>تصویر</th>
                                                    <th>توضیحات</th>
                                                    <th>ترتیب</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items">
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="5"></td>
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
                                    <input type="submit" class="btn btn-success" value="افزودن آگهی">
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
            <td><input type="text" name="url[]" class="form-control" dir="ltr"></td>
            <td><input type="file" name="image[]"></td>
            <td><textarea name="content[]" class="form-control"></textarea></td>
            <td><input type="number" name="sort_order[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-primary btn-xs editContent" data-toggle="modal" data-target=".tinymceModal" title="توضیحات html">
                    <span class="fa fa-pencil"></span>
                </button>
                <button type="button" class="btn btn-danger btn-xs remove-item" title="حذف">
                    <span class="fa fa-trash"></span>
                </button>
            </td>
        </tr>
    </tbody>
</table>
<div class="modal fade tinymceModal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close ignore" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">ویرایشگر html</h4>
            </div>
            <div class="modal-body">
                <h4>لطفا توضیحات مورد نظر خود را در ادیتور زیر بنویسید</h4>
                <input type="hidden" id="contentId">
                <textarea id="editor" class="tinymce"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default ignore" data-dismiss="modal">بستن</button>
                <button type="button" id="accept" class="btn btn-primary" data-dismiss="modal">تایید</button>
            </div>
        </div>
    </div>
</div>
@include('admin/layouts/partials/tinymce')
@endsection
