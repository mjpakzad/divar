@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>گزارشات</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
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
                            <th>کاربر</th>
                            <th>دلیل</th>
                            <th>آگهی</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reports as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->user->name ?? 'مهمان' }}</td>
                            <td>{{ $report->reason->title }}</td>
                            <td>
                                <a href="{{ route('admin.commercials.edit', $report->commercial->slug) }}">
                                    {{ $report->commercial->title }}
                                </a>
                            </td>
                            <td>
                                <form method="post" action="{{ route('admin.reports.destroy', $report->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.reports.show', $report->id) }}" class="btn btn-default btn-xs">
                                        <span class="fa fa-eye"></span> مشاهده
                                    </a>
                                    <button type="submit" name="delete" class="btn btn-danger btn-xs">
                                        <span class="fa fa-trash"></span> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">هیچ گزارشی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $reports->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
