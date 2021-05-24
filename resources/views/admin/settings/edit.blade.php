@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش تنظیمات</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.settings.index') }}">تنظیمات عمومی
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.settings.update', $setting->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="value" class="control-label col-md-3 col-sm-3 col-xs-12">{{ $setting->label }}</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea name="value" id="value" class="form-control" rows="5">{{ old('value', $setting->value) }}</textarea>
                            </div>
                        </div>
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
<!-- /.row -->
@endsection
