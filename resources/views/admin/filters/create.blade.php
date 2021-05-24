@extends('admin.layouts.app')
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#add-item').click(function(e) {
                e.preventDefault();
                $("#clone").clone().attr('id', '').appendTo("table.filters tbody");
            });
            $(document).on('click', '.remove-item',function () {
                $(this).closest('tr').remove();
            });
        });
    </script>
@endsection
@section('styles')
    <style>
        input[type='checkbox'] {
            margin-right:10px;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>افزودن شهر</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.filters.index') }}">فیلترها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.filters.store') }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="">نام گروه فیلتر *</label>
                                        <input name="group_name" type="text" placeholder="نام گروه فیلتر" class="form-control" required>
                                    </td>
                                    <td>
                                        <label for="">لیبل گروه فیلتر</label>
                                        <input name="group_label" type="text" placeholder="لیبل فیلتر" class="form-control">
                                    </td>
                                    <td>
                                        <label for="">ترتیب</label>
                                        <input name="group_sort_order" type="number" min="0" max="255" placeholder="ترتیب" class="form-control">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-hover table-striped table-condensed filters">
                            <thead>
                                <tr>
                                    <th>نام فیلتر</th>
                                    <th>ترتیب</th>
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
                                <input type="submit" class="btn btn-success" value="افزودن فیلتر">
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
            <td><input type="number" name="sort_order[]" class="form-control"></td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item">
                    <span class="fa fa-trash"></span> حذف
                </button>
            </td>
        </tr>
    </tbody>
</table>
@endsection
