@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>گروه‌های کاربری</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.roles.create') }}"><i class="fa fa-plus"></i> افزودن گروه کاربری</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام</th>
                            <th>نام نمایشی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($roles as $role)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.roles.destroy', $role->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.permissions.edit', $role->id) }}" class="btn btn-default btn-xs">
                                        <span class="fa fa-key"></span> تخصیص دسترسی
                                    </a>
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary btn-xs">
                                        <span class="fa fa-pencil"></span> ویرایش
                                    </a>
                                    <button type="submit" name="delete" class="btn btn-danger btn-xs">
                                        <span class="fa fa-trash"></span> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="3">هیچ گروه کاربری یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
