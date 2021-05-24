@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>مشاهده فاکتور</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.invoices.index') }}">فاکتورها
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <h3>فاکتور</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>شماره فاکتور</th>
                                <th>نام کاربر</th>
                                <th>مبلغ</th>
                                <th>تاریخ ایجاد</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $invoice->id }}</td>
                                <td>{{ $invoice->user->id }}</td>
                                <td>{{ number_format($invoice->price) }} تومان</td>
                                <td>{{ jdate($invoice->created_at)->format('d F Y ساعت H:i') }}</td>
                                <td>
                                    @switch($invoice->status)
                                        @case(0)
                                        غیرفعال
                                        @break
                                        @case(1)
                                        فعال
                                        @break
                                        @case(2)
                                        پرداخت شده
                                        @break
                                        @case(3)
                                        هدیه
                                        @break
                                        @default
                                        وضعیت غیرمجاز
                                    @endswitch
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <h3>سرویس‌ها</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>نام</th>
                                <th>مبلغ</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->services as $service)
                            <tr>
                                <td>{{ $service->service_name }}</td>
                                <td>{{ $service->price }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <hr>
                <h3>پرداخت‌ها</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کد پیگیری</th>
                                <th>شناسه تراکنش</th>
                                <th>تاریخ</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice->payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->tracking_code }}</td>
                                <td>{{ $payment->ref_id }}</td>
                                <td>{{ jdate($payment->created_at)->format('d F Y ساعت H:i') }}</td>
                                <td>
                                    <span class="text-{{ $payment->status ? 'success' : 'danger' }}">
                                        {{ $payment->status ?  'موفق' : 'ناموفق'}}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
