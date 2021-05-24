@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش شهر {{ $city->name }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.cities.index') }}">شهرها
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.cities.update', $city->slug) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام شهر *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $city->name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="slug" class="control-label col-md-3 col-sm-3 col-xs-12">اسلاگ  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $city->slug) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="control-label col-md-3 col-sm-3 col-xs-12">عنوان  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $city->title) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="latitude" class="control-label col-md-3 col-sm-3 col-xs-12">عرض جغرافیایی  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude', $city->latitude) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="longitude" class="control-label col-md-3 col-sm-3 col-xs-12">طول جغرافیایی  *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude', $city->longitude) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sort_order" class="control-label col-md-3 col-sm-3 col-xs-12">ترتیب</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="sort_order" id="sort_order" class="form-control" value="{{ old('sort_order', $city->sort_order) }}" min="0" max="999">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_keywords" class="control-label col-md-3 col-sm-3 col-xs-12">کلمات کلیدی</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords', comma2dash($city->meta_keywords)) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="meta_description" class="control-label col-md-3 col-sm-3 col-xs-12">متای توضیحات</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="meta_description" id="meta_description" class="form-control" value="{{ old('meta_description', $city->meta_description) }}">
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
<!-- /.row -->
@endsection
