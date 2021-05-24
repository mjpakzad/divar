@extends('admin.layouts.app')
@section('styles')
    <style>
        input[type='checkbox'] {
            margin-right:10px;
        }
    </style>
@endsection
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#add-item').click(function(e) {
                e.preventDefault();
                // $('tbody').append($('#clone'));
                $("#clone").clone().attr('id', '').appendTo("table.attributes tbody");
            });
            $(document).on('click', '.remove-item',function () {
                $(this).closest('tr').remove();
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
                    <h2>افزودن خصوصیت</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.attributes.index') }}">خصوصیات
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.attributes.store') }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="">نام گروه ویژگی *</label>
                                        <input name="group_name" type="text" placeholder="نام گروه ویژگی" class="form-control" required>
                                    </td>
                                    <td>
                                        <label for="">ترتیب</label>
                                        <input name="group_sort_order" type="number" min="0" max="255" placeholder="ترتیب" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-hover table-striped table-condensed attributes">
                            <thead>
                                <tr>
                                    <th>نام ویژگی</th>
                                    <th>توضیحات</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2"></td>
                                    <td>
                                        <button type="button" id="add-item" class="btn btn-default btn-xs">
                                            <span class="fa fa-plus"></span> افزودن
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <input type="submit" class="btn btn-success" value="افزودن خصوصیت">
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
