@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>شهرها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.cities.create') }}"><i class="fa fa-plus"></i> افزودن شهر</a>
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
                            <th>نام شهر</th>
                            <th>عنوان</th>
                            <th>ترتیب</th>
                            <th>تعداد آگهی‌ها</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($cities as $city)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $city->name }}</td>
                            <td>{{ $city->title }}</td>
                            <td>{{ $city->sort_order }}</td>
                            <td>{{ $city->commercials_count }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.cities.destroy', $city->slug) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.cities.districts.index', $city->slug) }}" class="btn btn-default btn-xs">
                                        <span class="fa fa-eye"></span> محله‌ها
                                    </a>
                                    <a href="{{ route('admin.cities.edit', $city->slug) }}" class="btn btn-primary btn-xs">
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
                            <td colspan="5">هیچ شهری یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $cities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
