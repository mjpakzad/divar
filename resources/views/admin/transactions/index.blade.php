@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تراکنش‌ها</h2>
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
                            <th class="text-center">درگاه</th>
                            <th class="text-center">شناسه</th>
                            <th class="text-center">مبلغ</th>
                            <th class="text-center">تاریخ</th>
                            <th class="text-center">کد پیگیری</th>
                            <th class="text-center">وضعیت</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
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
                            <td class="text-center">
                                {{ $transaction->id }}
                            </td>
                            <td class="text-center">{{ number_format($transaction->price, 0) }} تومان</td>
                            <td class="text-center">{{ jdate($transaction->created_at)->format('d F Y ساعت H:i') }}</td>
                            <td class="text-center">{{ $transaction->tracking_code }}</td>
                            <td class="text-center">
                                @switch($transaction->status)
                                    @case('INIT')
                                        <span class="label label-info">ایجاد</span>
                                        @break
                                    @case('FAILED')
                                        <span class="label label-danger">شکست</span>
                                        @break
                                    @case('SUCCEED')
                                        <span class="label label-success">موفق</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-default btn-xs">
                                    <span class="fa fa-eye"></span>
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="7">هیچ تراکنشی انجام نشده است!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
