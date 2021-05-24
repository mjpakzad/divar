@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش خدمت {{ $service->name }}</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.services.index') }}">خدمات
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.services.update', $service->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="price" class="control-label col-md-3 col-sm-3 col-xs-12">مبلغ *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="number" name="price" id="price" class="form-control" value="{{ old('price', number_format($service->price, 0, '', '')) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{ old('description', $service->description) }}</textarea>
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
