@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تیکت‌ها</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>کاربر</td>
                                <td>عنوان</td>
                                <td>وضعیت</td>
                                <td>عملیات</td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $ticket->user->name }}</td>
                                <td>{{ $ticket->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $ticket->status ? 'green' : 'red' }}">{{ $ticket->status ? 'باز' : 'بسته' }}</span>
                                </td>
                                <td>
                                    <form style="display: inline-block;" action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a class="btn btn-default btn-xs" href="{{ route('admin.tickets.show', $ticket->slug) }}">
                                            <span class="fa fa-eye"></span>
                                            مشاهده تیکت
                                        </a>
                                        <button type="submit" class="btn btn-{{ $ticket->status ? 'warning' : 'success' }} btn-xs" name="status" value="{{ $ticket->status ? 0 : 1}}" title="{{ $ticket->status == 1 ? 'رد نظر' : 'تایید نظر' }}">
                                            <span class="fa fa-{{ $ticket->status ? 'close' : 'check' }}"></span> {{ $ticket->status ? 'بستن تیکت' : 'باز کردن تیکت' }}
                                        </button>
                                        <button type="submit" class="btn btn-danger btn-xs" name="delete" value="1" title="حذف تیکت" onclick="return confirm('آیا از حذف این تیکت اطمینان دارید؟');">
                                            <span class="fa fa-trash"></span> حذف نظر
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5">هیچ تیکتی یافت نشد!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $tickets->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
