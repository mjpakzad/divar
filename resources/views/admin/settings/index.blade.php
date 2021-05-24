@extends('admin.layouts.app')
@section('content')
<div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تنظیمات عمومی سایت</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>عنوان تنظیمات</th>
                            <th>محتوا</th>
                            <th>متد بارگذاری</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $setting->label }}</td>
                            <td>{{ $setting->value }}</td>
                            <td>
                                <span class="label label-{{ ($setting->autoload ? 'success' : 'default') }}">{{ $setting->autoload ? 'خودکار' : 'دستی' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.settings.edit', ['id' => $setting->id]) }}" class="btn btn-primary btn-xs">
                                    <span class="fa fa-pencil"></span> ویرایش مقدار
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ تنظیماتی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $settings->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
