@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>نظرات</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>

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
                            <th>نویسنده</th>
                            <th>مقاله</th>
                            <th>موبایل</th>
                            <th>نظر</th>
                            <th>وضعیت</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $review->name }}</td>
                            <td>
                                <a href="{{ route('frontend.blog.show', $review->article->slug) }}">
                                    {{ $review->article->title }}
                                </a>
                            </td>
                            <td>{{ $review->mobile }}</td>
                            <td>{{ $review->content }}</td>
                            <td>
                                <span class="label label-{{ ($review->is_approved ? 'success' : 'warning') }}">{{ $review->is_approved ? 'تایید شده' : 'رد شده' }}</span>
                            </td>
                            <td>
                                <form method="post" action="{{ route('admin.reviews.destroy', ['id' => $review->id, 'active' => $review->is_approved ? 0 : 1]) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" name="active" class="btn btn-{{ $review->is_approved ? 'warning' : 'success' }} btn-xs" value="{{ $review->is_approved ? 0 : 1 }}">
                                        <span class="fa fa-{{ $review->is_approved ? 'close' : 'check' }}"></span> {{ $review->is_approved ? 'رد نظر' : 'تایید نظر' }}
                                    </button>
                                </form>
                                <form method="post" action="{{ route('admin.reviews.destroy', ['id' => $review->id, 'delete' => 1]) }}" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" name="delete" class="btn btn-danger btn-xs" value="1">
                                        <span class="fa fa-trash"></span> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5">هیچ نظری یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
