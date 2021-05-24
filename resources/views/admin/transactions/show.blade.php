@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>جزئیات تراکنش</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.transactions.index') }}">تراکنش‌ها
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <h3>جزئیات</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <tbody>
                            <tr>
                                <th class="text-center">شناسه</th>
                                <td class="text-center">
                                    {{ $transaction->id }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">درگاه</th>
                                <td class="text-center">
                                    @switch($transaction->port)
                                        @case ('MELLAT')
                                        ملت
                                        @break
                                        @case ('SADAD')
                                        ملی (سداد)
                                        @break
                                        @case ('ZARINPAL')
                                        زرین پال
                                        @break
                                        @case ('PAYLINE')
                                        پی لاین
                                        @break
                                        @case ('JAHANPAY')
                                        جهان پی
                                        @break
                                        @case ('PARSIAN')
                                        پارسیان
                                        @break
                                        @case ('PASARGAD')
                                        پاسارگاد
                                        @break
                                        @case ('SAMAN')
                                        سامان
                                        @break
                                        @case ('ASANPARDAKHT')
                                        آسان پرداخت
                                        @break
                                        @case ('PAYPAL')
                                        پی پال
                                        @break
                                        @case ('PAYIR')
                                        پی دات آر
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">مبلغ</th>
                                <td class="text-center">{{ number_format($transaction->price, 0) }} تومان</td>
                            </tr>
                            <tr>
                                <th class="text-center">Ref Id</th>
                                <td class="text-center">
                                    {{ $transaction->ref_id }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">کد پیگیری</th>
                                <td class="text-center">{{ $transaction->tracking_code }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">شماره کارت</th>
                                <td class="text-center">{{ $transaction->card_number }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">وضعیت</th>
                                <td class="text-center">
                                    @switch($transaction->status)
                                        @case('INIT')
                                        <span class="text-info">تراکنش ایجاد شد.</span>
                                        @break
                                        @case('FAILED')
                                        <span class="text-danger">عملیات پرداخت با خطا مواجه شد.</span>
                                        @break
                                        @case('SUCCEED')
                                        <span class="text-success">پرداخت با موفقیت انجام شد.</span>
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">IP</th>
                                <td class="text-center">{{ $transaction->ip }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">توضیحات</th>
                                <td class="text-center">{{ $transaction->description }}</td>
                            </tr>
                            <tr>
                                <th class="text-center">تاریخ پرداخت</th>
                                <td class="text-center">
                                    @if($transaction->payment_date)
                                    {{ jdate($transaction->created_at)->format('d F Y ساعت H:i') }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">تاریخ ایجاد</th>
                                <td class="text-center">{{ jdate($transaction->created_at)->format('d F Y ساعت H:i') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <hr>
                <h3>لاگ‌ها</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <th>#</th>
                            <th>شناسه</th>
                            <th>کد نتیجه</th>
                            <th>پیام نتیجه</th>
                            <th>تاریخ لاگ</th>
                        </thead>
                        <tbody>
                            @forelse($transaction->logs as $log)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        {{ $transaction->id }}
                                    </td>
                                    <td class="text-center">
                                        {{ $transaction->result_code }}
                                    </td>
                                    <td class="text-center">
                                        {{ $transaction->result_message }}
                                    </td>
                                    <td class="text-center">
                                        {{ jdate($transaction->log_date)->format('d F Y ساعت H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">هیچ لاگی یافت نشد.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <hr>
                <h3>جزئیات خرید</h3>
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">کاربر</th>
                                <th class="text-center">فاکتور</th>
                                <th class="text-center">آگهی</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">{{ $payment->invoice->user->name }} ({{ $payment->invoice->user->mobile }})</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.invoices.show', $payment->invoice->id) }}" class="btn btn-link">
                                        {{ $payment->invoice->id }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.commercials.edit', $payment->invoice->commercial->slug) }}" class="btn btn-link">
                                        {{ $payment->invoice->commercial->title }}
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
