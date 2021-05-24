@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>خدمات</h2>
                <ul class="nav navbar-right panel_toolbox">
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="text-center">نام</th>
                            <th class="text-center">توضیحات</th>
                            <th class="text-center">مبلغ</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $service->name }}</td>
                            <td class="text-center">{{ $service->description }}</td>
                            <td class="text-center">{{ ($service->price ? number_format($service->price, 0) . ' تومان' : 'رایگان') }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-primary btn-xs" title="مشاهده فاکتور">
                                    <span class="fa fa-pencil-alt"></span> ویرایش خدمت
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ خدمتی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $services->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
