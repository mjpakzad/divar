@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>مشاهده تماس</h2>
                    <ul class="nav navbar-right panel_toolbox">
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content" style="display: block;">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>نام تماس گیرنده</th>
                                    <td>{{ $contact->name }}</td>
                                </tr>
                                <tr>
                                    <th>ایمیل</th>
                                    <td>{{ $contact->email }}</td>
                                </tr>
                                <tr>
                                    <th>موبایل</th>
                                    <td>{{ $contact->mobile }}</td>
                                </tr>
                                <tr>
                                    <th>تاریخ تماس</th>
                                    <td>{{ jdate($contact->created_at)->format('d F Y ساعت H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>متن</th>
                                    <td>{!! nl2br(strip_tags($contact->content)) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
