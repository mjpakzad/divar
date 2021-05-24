@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>پرداخت‌ها</h2>
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
                            <th class="text-center">فاکتور</th>
                            <th class="text-center">کاربر</th>
                            <th class="text-center">مبلغ</th>
                            <th class="text-center">تاریخ</th>
                            <th class="text-center">کد پیگیری</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.invoices.show', $payment->invoice->id) }}" class="btn btn-link">
                                {{ $payment->invoice->id }}
                                </a>
                            </td>
                            <td class="text-center">{{ $payment->user->name }} ({{ $payment->user->mobile }})</td>
                            <td class="text-center">{{ number_format($payment->price, 0) }} تومان</td>
                            <td class="text-center">{{ jdate($payment->created_at)->format('d F Y ساعت H:i') }}</td>
                            <td class="text-center">{{ $payment->tracking_code }}</td>
                            <td class="text-center">
                                <span class="text-{{ $payment->status ? 'success' : 'danger' }}">
                                    {{ $payment->status ?  'موفق' : 'ناموفق'}}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="7">هیچ پرداختی انجام نشده است!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
