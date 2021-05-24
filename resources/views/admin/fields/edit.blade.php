@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#add-option').click(function(e) {
                e.preventDefault();
                $("#clone-option").clone().attr('id', '').appendTo("#options tbody");
            });
            $('#add-rule').click(function(e) {
                e.preventDefault();
                $("#clone-rule").clone().attr('id', '').appendTo("#rules tbody");
            });
            $(document).on('click', '.remove-item',function () {
                $(this).closest('tr').remove();
            });
            $('#type').change(function () {
                if($(this).val() == 'select') {
                    $('#selectOptions').removeClass('hide')
                } else {
                    $('#selectOptions').addClass('hide')
                }
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
                    <h2>ویرایش فیلد داینامیک</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.fields.index') }}">فیلدهای داینامیک
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
                                <a href="#tab_terms" data-toggle="tab" aria-expanded="false">قوانین</a>
                            </li>
                            <li id="selectOptions"{!! old('type', $field->type) == 'select' ? '' : ' class="hide"' !!}>
                                <a href="#tab_select" data-toggle="tab" aria-expanded="false">گزینه‌ها</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.fields.update', $field->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                            @csrf
                            @method('patch')
                            <div class="tab-content">
                                <div id="tab_general" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام فیلد *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $field->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="type" class="control-label col-md-3 col-sm-3 col-xs-12">نوع فیلد *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="type" id="type" class="form-control">
                                                <option value="text"{{ old('type', $field->type) == 'text' ? ' selected' : '' }}>متن</option>
                                                <option value="select"{{ old('type', $field->type) == 'select' ? ' selected' : '' }}>انتخابی</option>
                                                <option value="checkbox"{{ old('type', $field->type) == 'checkbox' ? ' selected' : '' }}>چکباکس</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="label" class="control-label col-md-3 col-sm-3 col-xs-12">لیبل</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="label" id="label" class="form-control" value="{{ old('label', $field->label) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="placeholder" class="control-label col-md-3 col-sm-3 col-xs-12">متن جایگزین</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="placeholder" id="placeholder" class="form-control" value="{{ old('placeholder', $field->placeholder) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $field->sort_order) }}" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="buy" class="control-label col-md-3 col-sm-3 col-xs-12">نوع معامله</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select id="buying" name="buying" class="form-control">
                                                <option value="2"{{ old('buyin', $field->buy) == 2 ? ' selected' : '' }}>مشترک</option>
                                                <option value="0"{{ old('buyin', $field->buy) == 0 ? ' selected' : '' }}>تحویل</option>
                                                <option value="1"{{ old('buyin', $field->buy) == 1 ? ' selected' : '' }}>دریافت</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_price" class="control-label col-md-3 col-sm-3 col-xs-12">فیلد قیمت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" class="toggle" name="is_price" id="is_price" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> فیلد قیمت" data-off="<i class='fa fa-close text-red'></i> فیلد معمولی" data-width="120"{{ ($field->is_price ? ' checked': '') }}>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_tag" class="control-label col-md-3 col-sm-3 col-xs-12">فیلد برچسب</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" class="toggle" name="is_tag" id="is_tag" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> بله" data-off="<i class='fa fa-close text-red'></i> خیر" data-width="120"{{ ($field->is_tag ? ' checked': '') }}>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_terms" class="tab-pane">
                                    <div class="table-responsive">
                                        <table id="rules" class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>قانون</th>
                                                    <th>مقدار</th>
                                                    <th>عملیات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($field->rules as $key => $rule)
                                                <tr>
                                                    <td>
                                                        <select name="rules[]" class="form-control">
                                                            <option value="required"{{ ($rule == 'required' ? ' selected' : '') }}>اجباری</option>
                                                            <option value="min"{{ ($rule == 'min' ? ' selected' : '') }}>حداقل طول</option>
                                                            <option value="max"{{ ($rule == 'max' ? ' selected' : '') }}>حداکثر طول</option>
                                                            <option value="accepted"{{ ($rule == 'accepted' ? ' selected' : '') }}>پذیرفتن</option>
                                                            <option value="url"{{ ($rule == 'url' ? ' selected' : '') }}>لینک</option>
                                                            <option value="iran_phone"{{ ($rule == 'iran_phone' ? ' selected' : '') }}>تلفن</option>
                                                            <option value="iran_mobile"{{ ($rule == 'iran_mobile' ? ' selected' : '') }}>موبایل</option>
                                                            <option value="address"{{ ($rule == 'address' ? ' selected' : '') }}>آدرس</option>
                                                            <option value="iran_postal_code"{{ ($rule == 'iran_postal_code' ? ' selected' : '') }}>کد پستی</option>
                                                            <option value="card_number"{{ ($rule == 'card_number' ? ' selected' : '') }}>کارت اعتباری</option>
                                                            <option value="melli_code"{{ ($rule == 'melli_code' ? ' selected' : '') }}>کدملی</option>
                                                            <option value="sheba"{{ ($rule == 'sheba' ? ' selected' : '') }}>شماره شبا</option>
                                                            <option value="email"{{ ($rule == 'email' ? ' selected' : '') }}>ایمیل</option>
                                                            <option value="numeric"{{ ($rule == 'numeric' ? ' selected' : '') }}>اعداد صحیح</option>
                                                            <option value="digits_between"{{ ($rule == 'digits_between' ? ' selected' : '') }}>بازه عددی</option>
                                                            <option value="starts_with"{{ ($rule == 'starts_with' ? ' selected' : '') }}>شروع با</option>
                                                            <option value="alpha"{{ ($rule == 'alpha' ? ' selected' : '') }}>حروف الفبای انگلیسی</option>
                                                            <option value="persian_alpha"{{ ($rule == 'persian_alpha' ? ' selected' : '') }}>حروف الفبای فارسی</option>
                                                            <option value="regex"{{ ($rule == 'regex' ? ' selected' : '') }}>عبارت باقاعده</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="values[]" class="form-control" dir="ltr" value="{{ $field->values[$key] }}">
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
                                                        <button type="button" id="add-rule" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> افزودن</button>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div id="tab_select" class="tab-pane">
                                    <div class="table-responsive">
                                        <table id="options" class="table table-hover">
                                            <thead>
                                            <tr>
                                                <th>مقدار</th>
                                                <th>عملیات</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($field->options as $option)
                                                <tr>
                                                    <td>
                                                        <input type="text" name="options[]" class="form-control" value="{{ $option }}">
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
                                                <td></td>
                                                <td>
                                                    <button type="button" id="add-option" class="btn btn-default btn-xs"><span class="fa fa-plus"></span> افزودن</button>
                                                </td>
                                            </tr>
                                            </tfoot>
                                        </table>
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
<table class="hide">
    <tbody>
    <tr id="clone-rule">
        <td>
            <select name="rules[]" class="form-control">
                <option value="required">اجباری</option>
                <option value="min">حداقل طول</option>
                <option value="max">حداکثر طول</option>
                <option value="accepted">پذیرفتن</option>
                <option value="url">لینک</option>
                <option value="iran_phone">تلفن</option>
                <option value="iran_mobile">موبایل</option>
                <option value="address">آدرس</option>
                <option value="iran_postal_code">کد پستی</option>
                <option value="card_number">کارت اعتباری</option>
                <option value="melli_code">کدملی</option>
                <option value="sheba">شماره شبا</option>
                <option value="email">ایمیل</option>
                <option value="numeric">اعداد صحیح</option>
                <option value="digits_between">بازه عددی</option>
                <option value="starts_with">شروع با</option>
                <option value="alpha">حروف الفبای انگلیسی</option>
                <option value="persian_alpha">حروف الفبای فارسی</option>
                <option value="regex">عبارت باقاعده</option>
            </select>
        </td>
        <td><input type="text" name="values[]" class="form-control" dir="ltr"></td>
        <td>
            <button type="button" class="btn btn-danger btn-xs remove-item">
                <span class="fa fa-trash"></span> حذف
            </button>
        </td>
    </tr>
    </tbody>
</table>
<table class="hide">
    <tbody>
    <tr id="clone-option">
        <td><input type="text" name="options[]" class="form-control"></td>
        <td>
            <button type="button" class="btn btn-danger btn-xs remove-item">
                <span class="fa fa-trash"></span> حذف
            </button>
        </td>
    </tr>
    </tbody>
</table>
@endsection
