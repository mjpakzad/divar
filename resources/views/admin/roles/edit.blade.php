@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>ویرایش گروه کاربری</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.roles.index') }}">گروه‌های کاربری
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form action="{{ route('admin.roles.update', $role->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="form-group">
                            <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">نام گروه کاربری *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $role->name) }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="control-label col-md-3 col-sm-3 col-xs-12">نام نمایشی *</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="display_name" id="display_name" class="form-control" value="{{ old('display_name', $role->display_name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label col-md-3 col-sm-3 col-xs-12">توضیحات</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $role->description) }}">
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
