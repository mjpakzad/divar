@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>فاکتورها</h2>
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
                            <th class="text-center">کاربر</th>
                            <th class="text-center">آگهی</th>
                            <th class="text-center">مبلغ</th>
                            <th class="text-center">تاریخ ایجاد</th>
                            <th class="text-center">وضعیت</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-center">{{ $invoice->user->name }} ({{ $invoice->user->mobile }})</td>
                            <td class="text-center">
                                <a href="{{ route('admin.commercials.edit', $invoice->commercial->slug) }}">
                                {{ $invoice->commercial->title }}
                                </a>
                            </td>
                            <td class="text-center">{{ ($invoice->price ? number_format($invoice->price, 0) . ' تومان' : 'رایگان') }}</td>
                            <td class="text-center">{{ jdate($invoice->created_at)->format('d F Y ساعت H:i') }}</td>
                            <td class="text-center">
                                {{ ['غیرفعال', 'فعال', 'پرداخت شده', 'هدیه'][$invoice->status] }}
                            </td>
                            <td class="text-center">{{ $invoice->reason }}</td>
                            <td class="text-center">
                                <a href="{{ route('admin.invoices.show', $invoice->id) }}" class="btn btn-default btn-xs" title="مشاهده فاکتور">
                                    <span class="fa fa-eye"></span> مشاهده فاکتور
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ فاکتوری انجام نشده است!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
