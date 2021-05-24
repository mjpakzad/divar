@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>دلیل گزارش آگهی</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.reports.reasons.create') }}"><i class="fa fa-plus"></i> افزودن دلیل</a>
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
                            <th>عنوان</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reasons as $reason)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reason->title }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.reports.reasons.destroy', $reason->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.reports.reasons.edit', $reason->id) }}" class="btn btn-primary btn-xs">
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
                            <td colspan="3">هیچ دلایلی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $reasons->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
