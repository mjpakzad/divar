@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>صفحات</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.pages.create') }}"><i class="fa fa-plus"></i> افزودن صفحه</a>
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
                            <th>عنوان صفحه</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td>
                                <span class="label label-{{ ($page->status ? 'success' : 'warning') }}">{{ $page->status ? 'منتشر شده' : 'پیش‌نویس' }}</span>
                            </td>
                            <td>
                                <form method="post" action="{{ route('admin.pages.destroy', $page->slug) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    @if($page->status)
                                    <a href="{{ route('frontend.pages.show', $page->slug) }}" class="btn btn-default btn-xs">
                                        <span class="fa fa-eye"></span> مشاهده
                                    </a>
                                    @endif
                                    <a href="{{ route('admin.pages.edit', $page->slug) }}" class="btn btn-primary btn-xs">
                                        <span class="fa fa-pencil"></span> ویرایش
                                    </a>
                                    <button type="submit" name="delete" class="btn btn-danger btn-xs">
                                        <span class="fa fa-trash"></span> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ صفحه‌ای یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $pages->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
