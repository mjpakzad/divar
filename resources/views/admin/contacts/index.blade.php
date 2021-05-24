@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تماس‌ها</h2>
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
                            <th>نام تماس گیرنده</th>
                            <th>ایمیل</th>
                            <th>موبایل</th>
                            <th>تاریخ تماس</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($contacts as $contact)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->mobile }}</td>
                            <td>{{ jdate($contact->created_at)->format('d F Y ساعت H:i') }}</td>
                            <td>{{ is_null($contact->seen_at) ? 'مشاهده نشده' : 'مشاهده شده در ' . jdate($contact->seen_at)->format('d F Y ساعت H:i') }}</td>
                            <td>
                                <form method="post" action="{{ route('admin.contacts.destroy', $contact->id) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-default btn-xs">
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
                            <td colspan="7">هیچ پیامی یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
