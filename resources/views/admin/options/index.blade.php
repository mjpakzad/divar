@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>گزینه‌ها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.options.create') }}"><i class="fa fa-plus"></i> افزودن گزینه</a>
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
                            <th>گزینه</th>
                            <th>ترتیب</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($options as $option)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $option->name }}</td>
                            <td>{{ $option->sort_order }}</td>
                            <td>
                                <form action="{{ route('admin.options.destroy', $option->id) }}" method="post" class="form-horizontal">
                                    @csrf
                                    @method('delete')
                                    <a class="btn btn-primary btn-xs" href="{{ route('admin.options.edit', $option->id) }}">
                                        <span class="fa fa-pencil"></span>
                                        ویرایش گزینه
                                    </a>
                                    <button type="submit" class="btn btn-danger btn-xs" name="delete" value="1" onclick="return confirm('آیا از حذف این گزینه اطمینان دارید؟');">
                                        <span class="fa fa-minus"></span>
                                        حذف گزینه
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="4">هیچ گزینه‌ای یافت نشد!</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                </div>
                {{ $options->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
