@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>مشاهده گزارش</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <a href="{{ route('admin.reports.index') }}">گزارشات
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>نام کاربر</th>
                                <td>{{ $report->user->name }} ({{ $report->user->email }})</td>
                            </tr>
                            <tr>
                                <th>آگهی</th>
                                <td>
                                    <a href="{{ route('admin.commercials.edit', $report->commercial->slug) }}">
                                        {{ $report->commercial->title }}
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th>دلیل</th>
                                <td>{{ $report->reason->title }}</td>
                            </tr>
                            <tr>
                                <th>توضیحات</th>
                                <td>{{ $report->content }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->
@endsection
