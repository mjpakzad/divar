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
                    <h2>ویرایش گروه فیلتر</h2>
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
                    <form action="{{ route('admin.filters.update', $filterGroup->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="group_name">نام گروه فیلتر *</label>
                                        <input name="group_name" id="group_name" type="text" placeholder="نام گروه فیلتر" class="form-control" required value="{{ $filterGroup->name }}">
                                    </td>
                                    <td>
                                        <label for="group_label">لیبل گروه فیلتر</label>
                                        <input name="group_label" id="group_label" type="text" placeholder="لیبل فیلتر" class="form-control" value="{{ $filterGroup->label }}">
                                    </td>
                                    <td>
                                        <label for="group_sort_order">ترتیب</label>
                                        <input name="group_sort_order" id="group_sort_order" type="number" min="0" max="255" placeholder="ترتیب" class="form-control" value="{{ $filterGroup->sort_order }}">
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
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($filterGroup->filters as $filter)
                                <tr>
                                    <td>
                                        <input type="hidden" name="keep_filters[{{ $filter->id }}]" value="{{ $filter->id }}">
                                        <input name="name[{{ $filter->id }}]" type="text" placeholder="نام فیلتر" class="form-control" value="{{ $filter->name }}">
                                    </td>
                                    <td>
                                        <input name="sort_order[{{ $filter->id }}]" type="text" placeholder="ترتیب" class="form-control" value="{{ $filter->sort_order }}">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs remove-item">
                                            <span class="fa fa-trash"></span> حذف
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
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
