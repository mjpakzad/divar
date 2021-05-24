@extends('admin.layouts.app')
@section('styles')
    <link href="{{ asset('vendor/bootstrap-toggle/css/bootstrap-toggle.min.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.toggle').addClass('pull-right');
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>کنترل دسترسی {{ $role->display_name }}</h2>
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
                    <form action="{{ route('admin.permissions.update', $role->id) }}" method="post" data-parsley-validate="" class="form-horizontal form-label-left">
                        @csrf
                        @method('patch')
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    @foreach($permissions as $permission)
                                        <tr>
                                            <td>
                                                <label class="control-label" for="lbl-{{ $permission->id }}" title="{{ $permission->description }}">{{ $permission->display_name }}</label>
                                            </td>
                                            <td width="50">
                                                <input type="checkbox" class="toggle" name="permissions_id[]" id="lbl-{{ $permission->id }}" value="{{ $permission->id }}" data-toggle="toggle" data-onstyle="success" data-on="<i class='fa fa-check'></i> دسترسی دارد" data-off="<i class='fa fa-close text-red'></i> دسترسی ندارد" {{ in_array($permission->id, $userPermissions) ? ' checked' : '' }}>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
