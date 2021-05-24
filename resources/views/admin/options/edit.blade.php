@extends('admin.layouts.app')
@section('scripts')
    <script>
        $(document).ready(function(){
            $('#add-item').click(function(e) {
                e.preventDefault();
                $("#clone").clone().attr('id', '').appendTo("table.options tbody");
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
                    <h2>ویرایش گزینه {{ $option->name }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.options.index') }}">گزینه‌ها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.options.update', $option->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <table class="table table-hover table-striped table-condensed">
                            <tbody>
                                <tr>
                                    <td>
                                        <label for="option_name">نام گزینه *</label>
                                        <input name="option_name" type="text" placeholder="نام گزینه" class="form-control" required value="{{ old('option_name', $option->name) }}">
                                    </td>
                                    <td>
                                        <label for="option_sort_order">ترتیب</label>
                                        <input name="option_sort_order" type="number" min="0" max="255" placeholder="ترتیب" class="form-control" value="{{ old('option_sort_order, $option->sort_order') }}">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <table class="table table-hover table-striped table-condensed options">
                            <thead>
                                <tr>
                                    <th>نام مقدار گزینه</th>
                                    {{--<th>تصویر</th>--}}
                                    <th>ترتیب</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($option->values as $value)
                                <tr>
                                    <td>
                                        <input type="hidden" name="keep_options[{{ $value->id }}]" value="{{ $value->id }}">
                                        <input type="hidden" name="keeper[{{ $value->id }}]" value="{{ $value->id }}">
                                        <input name="name[{{ $value->id }}]" type="text" placeholder="نام گزینه" class="form-control" value="{{ $value->name }}">
                                    </td>
                                    {{--<td>
                                        <input type="hidden" name="keeper[{{ $value->id }}]" value="{{ $value->id }}">
                                        @if($value->image)
                                        <img src="{{ asset(App\ImageManager::getResizeName($value->image, ['width' => 40, 'height' => 40])) }}" alt="{{ $value->name }}" class="col-md-2">
                                        @endif
                                        <input type="file" name="image[{{ $value->id }}]" class="col-md-10">
                                    </td>--}}
                                    <td>
                                        <input name="sort_order[{{ $value->id }}]" type="text" placeholder="ترتیب" class="form-control" value="{{ $value->sort_order }}">
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
            {{--<td><input type="file" name="image[]" class="form-control"></td>--}}
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
