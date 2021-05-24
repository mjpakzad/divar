@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>ارسال sms</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.commercials.index') }}">
                            آگهی‌ها
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <p>آگهی: <a href="{{ route('admin.commercials.edit', $commercial->slug) }}">{{ $commercial->title }}</a></p>
                <form action="{{ route('admin.sms.send', $commercial->slug) }}" method="post" enctype="multipart/form-data" data-parsley-validate="" class="form-horizontal form-label-left">
                    @csrf
                    <div class="form-group">
                        <label for="content" class="control-label col-md-3 col-sm-3 col-xs-12">متن اس ام اس</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="content" id="content" class="form-control" rows="5">{{ old('content', route('frontend.commercials.show', $commercial->slug)) }}</textarea>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <input type="submit" class="btn btn-success" value="ارسال">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
