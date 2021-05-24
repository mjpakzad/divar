@extends('admin.layouts.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dropify/css/dropify.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}">
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
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBUcxNAzDyoiTXUXpLwd1a-3jOwkQpDUs&callback=loadMap&language=fa"></script>
    <script>
        function loadMap() {
            var mapOptions = {
                center:new google.maps.LatLng({{ $commercial->lat ?? 35.712991 }}, {{ $commercial->lng ?? 51.367627 }}),
                zoom:13,
                mapTypeId:google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng({{ $commercial->lat ?? 35.712991 }}, {{ $commercial->lng ?? 51.367627 }}),
                draggable:true,
                animation: google.maps.Animation.DROP,
                map: map,
            });
            marker.addListener('drag', handleEvent);
            marker.addListener('dragend', handleEvent);
        }
        google.maps.event.addDomListener(window, 'load', loadMap);
        function handleEvent(event) {
            document.getElementById('latitude').value = event.latLng.lat();
            document.getElementById('longitude').value = event.latLng.lng();
        }
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
            $(document).on('click', '.dropify-clear', function () {
                $(this).closest('.imageWrapper').remove();
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $("#user_id").select2({
                placeholder : 'آگهی دهنده انتخاب کنید',
                ajax: {
                    url: "{{ route('admin.users.list') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {"results": response,};
                    },
                    cache: true
                }
            });
            $('#main_category').select2({
                dir: "rtl",
            });
            $('#category').select2({
                dir: "rtl",
                placeholder : 'دسته بندی را انتخاب کنید',
                ajax: {
                    url: "{{ route('admin.categories.list') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            category: $('#main_category').val(),
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {"results": response,};
                    },
                    cache: true
                }
            });
            $('#city').select2({
                dir: "rtl",
            });
            $('#district').select2({
                dir: "rtl",
                ajax: {
                    url: "{{ route('admin.commercials.districts') }}",
                    type: "post",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            city: $('#city').val(),
                            district: $('#district').val()
                        };
                    },
                    processResults: function (response) {
                        return {"results": response,};
                    },
                    cache: true
                },
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
                    <h2>ویرایش آگهی</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.commercials.index') }}">آگهی‌ها
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
                                <a href="#tab_position" data-toggle="tab" aria-expanded="false">موقعیت</a>
                            </li>
                            <li>
                                <a href="#tab_information" data-toggle="tab" aria-expanded="false">اطلاعات</a>
                            </li>
                            <li>
                                <a href="#tab_gallery" data-toggle="tab" aria-expanded="false">گالری</a>
                            </li>
                            <li>
                                <a href="#tab_update" data-toggle="tab" aria-expanded="false">بروزرسانی</a>
                            </li>
                        </ul>
                        <br>
                        <form action="{{ route('admin.commercials.update', $commercial->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                            @csrf
                            @method('patch')
                            <div class="tab-content">
                                <div id="tab_general" class="tab-pane active">
                                    <div class="form-group">
                                        <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $commercial->title) }}">
                                            <input type="hidden" id="slug" value="{{ $commercial->slug }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="main_category" class="control-label col-md-3 col-sm-3 col-xs-12">دسته‌بندی اصلی *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="main_category" id="main_category" class="form-control" dir="rtl">
                                                <option value="">دسته‌بندی اصلی را انتخاب کنید</option>
                                                @foreach($mainCategories as $id => $name)
                                                    <option value="{{ $id }}"{{ (old('category', $commercial->category->parent->id ?? null) == $id ? 'selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="category" class="control-label col-md-3 col-sm-3 col-xs-12">دسته‌بندی *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="category" id="category" class="form-control getCategoryFields" dir="rtl">
                                                <option value="">دسته‌بندی را انتخاب کنید</option>
                                                @foreach($categories as $id => $name)
                                                    <option value="{{ $id }}"{{ (old('category', $commercial->category_id) == $id ? 'selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_id" class="control-label col-md-3 col-sm-3 col-xs-12">آگهی دهنده</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select id='user_id' name="user_id" style='width: 200px;' class="form-control" dir="rtl">
                                                <option value='{{ $commercial->user_id }}'>{{ $commercial->user->name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">تاریخ ثبت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            {{ jdate($commercial->created_at)->format('d F Y ساعت H:i') }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">کد آگهی</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <span class="badge bg-green">{{ $commercial->id }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="content" id="content" class="form-control tinymce">{{ old('content', $commercial->content) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="whatsapp" class="control-label col-md-3 col-sm-3 col-xs-12">واتس اپ</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" name="whatsapp" id="whatsapp" class="form-control" value="{{ old('whatsapp', $commercial->whatsapp) }}">
                                        </div>
                                    </div>
                                    @if($commercial->voice)
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">صوت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <audio controls>
                                              <source src="{{ asset($commercial->voice) }}" type="{{ $commercial->voice_mime }}">
                                              مرورگر شما از پخش صوت پشتیبانی نمی‌کند
                                            </audio>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">صوت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="file" name="voice" id="voice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="aparat" class="control-label col-md-3 col-sm-3 col-xs-12">آپارات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="aparat" id="aparat" class="form-control">{{ old('aparat', $commercial->aparat) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">نوع معامله</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" name="buy" id="buy" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-cart-arrow-down'></i> {{ $commercial->category->sell }}" data-off="<i class='fa fa-cart-plus text-red'></i> {{ $commercial->category->buy }}"{{ old('buy', $commercial->buy) ? ' checked' : '' }} data-width="120">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">کارشناسی شده</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" name="expertise_checked" id="expertise_checked" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> بله" data-off="<i class='fa fa-close text-red'></i> خیر"{{ old('buy', $commercial->expertise_checked) ? ' checked' : '' }} data-width="120">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">وضعیت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div id="gender" class="btn-group" data-toggle="buttons">
                                                <label class="btn btn-default{{ old('status', $commercial->status) == 0 ? ' active': '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                    <input type="radio" name="status" value="0" data-parsley-multiple="status"{{ old('status', $commercial->status) == 0 ? ' checked': '' }}> منتظر تایید
                                                </label>
                                                <label class="btn btn-default{{ old('status', $commercial->status) == 1 ? ' active': '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                    <input type="radio" name="status" value="1" data-parsley-multiple="status"{{ old('status', $commercial->status) == 1 ? ' checked' : '' }}> تایید شده
                                                </label>
                                                <label class="btn btn-default{{ old('status', $commercial->status) == 2 ? ' active': '' }}" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                                    <input type="radio" name="status" value="2" data-parsley-multiple="status"{{ old('status', $commercial->status) == 2 ? ' checked' : '' }}> رد شده
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">برچسب‌ها</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            @foreach($commercial->tags as $tag)
                                            <span class="badge bg-green">{{ $tag->name }}</span>
                                            @endforeach
                                            {{--@include('admin.commercials.partials.tags')--}}
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_seo" class="tab-pane">
                                    <div class="form-group">
                                        <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ کلمات کلیدی</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_keywords" id="meta_keywords" class="form-control" rows="3" placeholder="کلمات کلیدی را با خط تیره (-) از هم جدا کنید">{{ old('meta_keywords', dash2comma($commercial->meta_keywords ?? '')) }}</textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متا تگ توضیحات</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <textarea name="meta_description" id="meta_description" class="form-control" rows="5">{{ old('meta_description', $commercial->meta_description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_position" class="tab-pane">
                                    <div class="form-group">
                                        <label for="city" class="control-label col-md-3 col-sm-3 col-xs-12">شهر *</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="city" id="city" class="form-control" dir="rtl">
                                                <option value="">شهر را انتخاب کنید</option>
                                                @foreach($cities as $id => $name)
                                                    <option value="{{ $id }}"{{ (old('city', $commercial->city_id) == $id ? ' selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="district" class="control-label col-md-3 col-sm-3 col-xs-12">محله</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select name="district" id="district" class="form-control" dir="rtl">
                                                <option value="">محله را انتخاب کنید</option>
                                                @foreach($districts as $id => $name)
                                                    <option value="{{ $id }}"{{ (old('district', $commercial->district_id) == $id ? ' selected' : '') }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="control-label col-md-3 col-sm-3 col-xs-12">موقعیت</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <div id="map" style="width:100%;min-height:300px"></div>
                                        </div>
                                        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $commercial->lat) }}">
                                        <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $commercial->lng) }}">
                                    </div>
                                </div>
                                <div id="tab_information" class="tab-pane">
                                    @include('admin.commercials.partials.fields', $fields)
                                </div>
                                <div id="tab_gallery" class="tab-pane">
                                    <div id="galleryHolder" class="form-group">
                                    @foreach($commercial->images as $image)
                                        <div class="col-md-3 col-sm-6 col-xs-12 imageWrapper">
                                            <input type="hidden" name="keeper[{{ $image->id }}]" value="{{ $image->id }}">
                                            <input type="file" name="images[]" data-default-file="{{ $image->name }}" class="dropify">
                                            <input type="text" name="alt[{{ $image->id }}]" class="form-control" placeholder="alt">
                                        </div>
                                    @endforeach
                                        <div class="col-md-3 col-sm-6 col-xs-12">
                                            <input type="file" name="images[]" class="dropify">
                                        </div>
                                    </div>
                                </div>
                                <div id="tab_update" class="tab-pane">
                                    <div class="form-group">
                                        <label for="ladder" class="control-label col-md-3 col-sm-3 col-xs-12">بروزرسانی نردبان</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" class="toggle" name="ladder" id="ladder" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> بروزرسانی" data-off="<i class='fa fa-close text-red'></i> حالت جاری" data-width="120">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="featured" class="control-label col-md-3 col-sm-3 col-xs-12">متمایز</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" class="toggle" name="featured" id="featured" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> متمایز" data-off="<i class='fa fa-close text-red'></i> معمولی" data-width="120"{{ old('featured', $commercial->featured) ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="immediate" class="control-label col-md-3 col-sm-3 col-xs-12">فوری</label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="checkbox" class="toggle" name="immediate" id="immediate" value="1" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> فوری" data-off="<i class='fa fa-close text-red'></i> معمولی" data-width="120"{{ old('immediate', $commercial->immediate) ? ' checked' : '' }}>
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
    <input type="text" name="alt[]" class="form-control" placeholder="alt">
</div>
<!-- /.row -->
@include('admin/layouts/partials/tinymce')
@endsection
