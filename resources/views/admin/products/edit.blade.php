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
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#fields').select2({
                dir: "rtl",
            });
            $('#parent_id').select2();
            $('.dropify').dropify();
            $(document).on('change', '.dropify', function (event) {
                var clone = $('#imageHolder').clone();
                clone.attr('id', '').removeClass('hide').appendTo('#galleryHolder');
                $('#galleryHolder input:last').addClass('dropify').dropify();
            });
            $('#manufacturers').select2({
                placeholder : 'تولید کننده محصول را انتخاب کنید',
                dir: "rtl",
            });
            $('#categories').select2({
                placeholder : 'دسته‌بندی‌ها را انتخاب کنید',
                dir: "rtl",
            });
            $('#filters').select2({
                placeholder : 'فیلترها را انتخاب کنید',
                dir: "rtl",
            });
            $('#options').select2({
                placeholder : 'گزینه را انتخاب کنید',
                dir: "rtl",
            });
        });
        $(document).ready(function(){
            $('#add-image').click(function(e) {
                e.preventDefault();
                $("#clone-image").clone().removeAttr('id').appendTo("table.images tbody");
            });
            $(document).on('click', '.add-option', function(e) {
                e.preventDefault();
                var optionId = $(this).data('option');
                var clone = $("#option_values_tbody" + optionId).clone();

                clone.removeAttr('id').appendTo("#option_values_table" + optionId + " tbody");
            });
            $(document).on('click', '.remove-option', function (e) {
                e.preventDefault();
                var optionId = $(this).data('option');
                $('#menu-option'+optionId).closest('li').remove();
                $('#menu-'+optionId).remove();
            });
            $('#add-attribute').click(function(e) {
                e.preventDefault();
                $("#clone-attribute").clone().attr('id', '').appendTo("table.attributes tbody");
                //$('table .attributes').select2();
            });
            $(document).on('click', '.remove-item',function () {
                $(this).closest('tr').remove();
            });
            $(document).on('change', '.mainHighlight', function() {
                var supportHighlight = $(this).siblings('.supportHighlight');
                if(this.checked)
                {
                    supportHighlight.removeAttr("checked");
                }
                else
                {
                    supportHighlight.prop("checked", true);
                }
            });
        });
        $(document).ready(function () {
            var menuCounter = 0;
            $('#options').change(function () {
                if($('#menu-option'+$(this).val()).length > 0) {
                    // does exist
                    alert('این گزینه قبلا انتخاب شده است.');
                    return;
                }
                ++menuCounter;
                var menuItem = $('#menuItem').clone();
                var menuContent = $('#menuContent').clone();

                menuItem.find('a').attr('href', 'menu-'+menuCounter).attr('id', 'menu-option'+$(this).val()).text($(this).find(":selected").text());
                menuContent.find('#required').attr('name', 'required['+$(this).val()+']').removeAttr('id');
                menuContent.find('table').attr('id', 'option_values_table'+$(this).val());
                menuContent.find('.add-option').attr('data-option', $(this).val());
                menuContent.find('.remove-option').attr('data-option', $(this).val());

                if(menuCounter === 1) {
                    menuItem.addClass('active');
                    menuContent.addClass('in active');
                }

                menuItem.removeAttr('id').appendTo('#options_tabs');
                menuContent.attr('id', 'menu-'+menuCounter).appendTo('#options_values');

                $(this).val([]).trigger('change.select2');
            });
        });
        $(document).ready(function () {
            $(document).on('click', '.menuItem', function () {
                $('#options_values .active').removeClass('in active').fadeOut();
                $('#'+$(this).attr('href')).addClass('in active').fadeIn();
            });
        });
        $(document).ready(function () {
            (function($, undefined) {
                "use strict";

                // When ready.
                $(function() {
                    var $form           = $("#form");
                    var $priceMask      = $form.find("#price_mask");
                    var $specialMask    = $form.find("#special_mask");
                    var $price          = $("#price");
                    var $special        = $("#special");

                    $priceMask.on("keyup", function(event) {
                        // When user select text in the document, also abort.
                        var selection = window.getSelection().toString();
                        if (selection !== '') {
                            return;
                        }
                        
                        // When the arrow keys are pressed, abort.
                        if ($.inArray(event.keyCode, [38,40,37,39]) !== -1) {
                            return;
                        }

                        var $this = $(this);

                        // Get the value.
                        var input = $this.val();

                        var input = input.replace(/[\D\s\._\-]+/g, "");
                        input = input ? parseInt( input, 10 ) : 0;

                        $this.val(function() {
                            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                        });

                        var withoutCommas = $priceMask.val().replace(/,/g, ''),
                            asANumber = +withoutCommas;
                        $price.val(withoutCommas);
                    });
                    $specialMask.on("keyup", function(event) {
                        // When user select text in the document, also abort.
                        var selection = window.getSelection().toString();
                        if (selection !== '') {
                            return;
                        }

                        // When the arrow keys are pressed, abort.
                        if ($.inArray(event.keyCode, [38,40,37,39]) !== -1) {
                            return;
                        }

                        var $this = $(this);

                        // Get the value.
                        var input = $this.val();

                        var input = input.replace(/[\D\s\._\-]+/g, "");
                        input = input ? parseInt( input, 10 ) : 0;

                        $this.val(function() {
                            return ( input === 0 ) ? "" : input.toLocaleString( "en-US" );
                        });

                        var withoutCommas = $specialMask.val().replace(/,/g, ''),
                            asANumber = +withoutCommas;
                        $special.val(withoutCommas);
                    });
                });
            })(jQuery);
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش محصول</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.products.index') }}">محصولات
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
                                <a href="#tab_links" data-toggle="tab" aria-expanded="false">لینک‌ها</a>
                            </li>
                            <li>
                                <a href="#tab_options" data-toggle="tab" aria-expanded="false">گزینه‌ها</a>
                            </li>
                            <li>
                                <a href="#tab_attributes" data-toggle="tab" aria-expanded="false">ویژگی‌ها</a>
                            </li>
                            <li>
                                <a href="#tab_images" data-toggle="tab" aria-expanded="false">تصاویر</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.products.update', $product->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left" id="form">
                            @csrf
                            @method('patch')
                            <div class="tab-content">
                                <div id="tab_general" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="slug" class="col-md-3 col-sm-3 col-xs-12 control-label">اسلاگ محصول *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="slug" type="text" class="form-control" name="slug" value="{{ old('slug', $product->slug) }}" placeholder="Enter the product slug" dir="ltr" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="description" id="description" class="form-control tinymce">{{ old('description', $product->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_seo" class="tab-pane">
                                    <div class="form-group">
                                        <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ کلمات کلیدی</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="کلمات کلیدی را با خط تیره (-) از هم جدا کنید">{{ old('meta_keywords', $product->meta_keywords) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ old('meta_description', $product->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_information" class="tab-pane">
                                    <div class="form-group">
                                        <label for="model" class="control-label col-md-3 col-sm-3 col-xs-12">مدل *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="model" type="text" class="form-control" name="model" value="{{ old('model', $product->model) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="code" class="control-label col-md-3 col-sm-3 col-xs-12">کد</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="code" type="text" class="form-control" name="code" value="{{ old('code', $product->code) }}" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">قیمت *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="price_mask" name="price_mask" class="form-control mask" value="{{ old('price_mask', number_format($product->price, 0, '', ',')) }}" required>
                                            <input type="hidden" name="price" id="price" class="price" value="{{ old('price', number_format($product->price, 0, '', '')) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="special" class="control-label col-md-3 col-sm-3 col-xs-12">قیمت ویژه</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="special_mask" name="special_mask" class="form-control mask" value="{{ old('special_mask', number_format($product->special, 0, '', ',')) }}" required>
                                            <input type="hidden" name="special" id="special" class="special" value="{{ old('special', number_format($product->special, 0, '', '')) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="stock" class="control-label col-md-3 col-sm-3 col-xs-12">موجودی</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', $product->stock) }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label form="image" class="control-label col-md-3 col-sm-3 col-xs-12">تصویر</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="image" id="image" class="dropify"@if($product->image_id) data-default-file="{{ asset($product->image->name) }}" @endif>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" name="status" id="status" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-cart-arrow-down'></i> انتشار" data-off="<i class='fa fa-cart-plus text-red'></i> پیش‌نویس"{{ old('status', $product->stock) ? ' checked' : '' }} data-width="120">
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_links" class="tab-pane">
                                    <div class="form-group">
                                    <label for="manufacturer_id" class="control-label col-md-3 col-sm-3 col-xs-12">تولیدکننده *</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="manufacturer_id" id="manufacturers" class="form-control" required>
                                            @foreach($manufacturers as $key => $manufacturer)
                                                <option value="{{ $key }}"{{ (old('manufacturer_id', $product->manufacturer_id) == $key ? ' selected' : '') }}>{{ $manufacturer }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="categories" class="control-label col-md-3 col-sm-3 col-xs-12">انتخاب دسته‌بندی‌ها</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="category_id[]" id="categories" class="form-control" multiple="multiple">
                                            @foreach($categories as $key => $category)
                                                <option value="{{ $key }}"{{ (in_array($key, old('category_id', $selectedCategories)) ? ' selected' : '') }}>{{ $category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="filter_id" class="control-label col-md-3 col-sm-3 col-xs-12">انتخاب فیلترها</label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <select name="filter_id[]" id="filters" class="form-control" multiple="multiple">
                                            @foreach($filters as $key => $filter)
                                                <option value="{{ $key }}"{{ (in_array($key, old('filter_id', $selectedFilters)) ? ' selected' : '') }}>{{ $filter }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                </div>
                                <div id="tab_options" class="tab-pane">
                                    <div class="form-group">
                                        <div class="col-md-2">
                                            <select id="options" class="form-control">
                                                <option value="" selected></option>
                                                @foreach($options as $option)
                                                    <option value="{{ $option->id }}">{{ $option->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <ul id="options_tabs" class="nav nav-pills nav-stacked">
                                            @foreach($product->options as $option)
                                                <li class="{{ ($loop->index == 0 ? ' active' : '') }}">
                                                    <a data-toggle="pill" id="menu-option{{ $option->option_id }}" class="menuItem" href="menu-{{ $loop->iteration }}">{{ $option->option->name }}</a>
                                                </li>
                                            @endforeach
                                            </ul>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="options_values" class="tab-content">
                                            @foreach($product->options as $option)
                                                <div id="menu-{{ $loop->iteration }}" class="tab-pane fade{{ ($loop->index == 0 ? ' in active' : '') }}">
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label for="required" class="col-md-2 control-label">اجباری</label>
                                                                <div class="col-md-10">
                                                                    <select name="required[{{ $option->option_id }}]" id="required" class="form-control">
                                                                        <option value="0"{{ ($option->required ? '' : ' selected') }}>نیست</option>
                                                                        <option value="1"{{ ($option->required ? ' selected' : '') }}>است</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button class="btn btn-danger btn-xs remove-option" data-option="{{ $option->option_id }}" type="button">
                                                                    <span class="fa fa-close"></span> حذف گزینه
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <table class="table table-bordered table-hover" id="option_values_table{{ $option->option_id }}">
                                                    <thead>
                                                        <tr>
                                                            <th>مقدار گزینه</th>
                                                            <th>قیمت</th>
                                                            <th>عملیات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($option->optionValues as $optionValue)
                                                        <tr>
                                                            <td>
                                                                <select name="option_values[{{ $option->option_id }}][value_id][]" class="form-control">
                                                                    @foreach($option->option->values as $value)
                                                                        <option value="{{ $value->id }}"{{ ($optionValue->id == $value->id ? ' selected' : '') }}>{{ $value->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select name="option_values[{{ $option->option_id }}][surplus_price][]" class="form-control">
                                                                    <option value="0"{{ ($optionValue->pivot->surplus_price ? '' : ' selected') }}>+</option>
                                                                    <option value="1"{{ ($optionValue->pivot->surplus_price ? ' selected' : '') }}>-</option>
                                                                </select>
                                                                <input type="text" name="option_values[{{ $option->option_id }}][price][]" class="form-control" min="0" value="{{ number_format($optionValue->pivot->price, 0, '', '') }}">
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
                                                            <button class="btn btn-default btn-xs add-option" type="button" data-option="{{ $option->option_id }}">
                                                                <span class="fa fa-plus"></span> افزودن
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_attributes" class="tab-pane">
                                    <table class="table table-hover attributes">
                                    <thead>
                                        <tr>
                                            <th>ویژگی</th>
                                            <th>برجسته</th>
                                            <th>مقدار</th>
                                            <th>عملیات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(old('attribute_id', $selectedAttributes) as $k => $attr)
                                        <tr>
                                            <td>
                                                <select name="attribute_id[]" class="attributes form-control">
                                                    @foreach($attributes as $key => $attribute)
                                                        <option value="{{ $key }}"{{ ($k == $key ? ' selected' : '') }}>{{ $attribute }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input name="attribute_highlight[]" class="supportHighlight hide" type="checkbox" value="0" checked{{ (old('attribute_highlight.' . $k) ? '' : ' checked') }}>
                                                <input name="attribute_highlight[]" class="mainHighlight" type="checkbox" value="1"{{ (old('attribute_highlight.' . $k) ? ' checked' : '') }}>
                                            </td>
                                            <td>
                                                <textarea name="attribute_value[]" class="form-control">{{ old('attribute_value.' . $k) }}</textarea>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-xs remove-attribute">
                                                    <span class="fa fa-trash"></span> حذف
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3"></td>
                                            <td>
                                                <button type="button" id="add-attribute" class="btn btn-default btn-xs">
                                                    <span class="fa fa-plus"></span> افزودن
                                                </button>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                                </div>
                                <div id="tab_position" class="tab-pane"></div>
                                <div id="tab_images" class="tab-pane">
                                    <div id="galleryHolder" class="form-group">
                                        @foreach($product->images as $image)
                                        <div class="col-md-3 col-sm-6 col-xs-12 imageWrapper">
                                            <input type="hidden" name="keeper[{{ $image->id }}]" value="{{ $image->id }}">
                                            <input type="file" name="images[]" data-default-file="{{ $image->name }}" class="dropify">
                                        </div>
                                        @endforeach
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <input type="file" name="images[]" class="dropify">
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
<div id="imageHolder" class="hide col-md-3 col-sm-6 col-xs-12">
    <input type="file" name="images[]">
</div>
<table class="hide">
    <tbody>
        <tr id="clone-attribute">
            <td>
                <select name="attribute_id[]" class="attributes form-control">
                    @foreach($attributes as $key => $attribute)
                        <option value="{{ $key }}">{{ $attribute }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input name="attribute_highlight[]" class="supportHighlight hide" type="checkbox" value="0" checked>
                <input name="attribute_highlight[]" class="mainHighlight" type="checkbox" value="1">
            </td>
            <td>
                <textarea name="attribute_value[]" class="form-control"></textarea>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-xs remove-item">
                    <span class="fa fa-trash"></span> حذف
                </button>
            </td>
        </tr>
    </tbody>
</table>
<div class="hide">
    <li id="menuItem">
        <a data-toggle="pill" class="menuItem"></a>
    </li>
    <div id="menuContent" class="tab-pane fade">
        <div class="row">
            <div class="col-md-10">
                <div class="form-group">
                    <label for="required" class="col-md-2 control-label">اجباری</label>
                    <div class="col-md-10">
                        <select name="required" id="required" class="form-control">
                            <option value="0">نیست</option>
                            <option value="1">است</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <button class="btn btn-danger btn-xs remove-option" data-option="" type="button">
                        <span class="fa fa-close"></span> حذف گزینه
                    </button>
                </div>
            </div>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
            <tr>
                <th>مقدار گزینه</th>
                <th>قیمت</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2"></td>
                <td>
                    <button class="btn btn-default btn-xs add-option" type="button" data-option="">
                        <span class="fa fa-plus"></span> افزودن
                    </button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    @foreach($options as $option)
        <table>
            <tbody>
                <tr id="option_values_tbody{{ $option->id }}">
                    <td>
                        <select name="option_values[{{ $option->id }}][value_id][]" class="form-control">
                            <option></option>
                            @foreach($option->values as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select name="option_values[{{ $option->id }}][surplus_price][]" class="form-control">
                            <option value="0">+</option>
                            <option value="1">-</option>
                        </select>
                        <input type="text" name="option_values[{{ $option->id }}][price][]" class="form-control" min="0">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs remove-item">
                            <span class="fa fa-trash"></span> حذف
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
</div>
@include('admin/layouts/partials/tinymce')
@endsection
