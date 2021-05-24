@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>هواشناسی</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>نام استان</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($weather as $province)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $province->name }}</td>
                            <td>
                                <span class="label label-{{ ($province->status ? 'success' : 'warning') }}">{{ $province->status ? 'فعال' : 'غیرفعال' }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.weather.edit', $province->slug) }}" class="btn btn-primary btn-xs">
                                        <span class="fa fa-pencil"></span> ویرایش
                                    </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ استانی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $weather->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
