@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>دسته‌بندی‌ها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.categories.create') }}"><i class="fa fa-plus"></i> افزودن دسته‌بندی</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table id="categories" class="table table-hover">
                        <thead>
                            <tr>
                                <th>نام دسته‌بندی</th>
                                <th>ترتیب</th>
                                <th>تعدا آگهی‌ها</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->sort_order }}</td>
                                    <td>{{ $category->commercial_counts }}</td>
                                    <td>
                                        <span class="label label-{{ ($category->status ? 'success' : 'warning') }}">{{ $category->status ? 'فعال' : 'غیرفعال' }}</span>
                                    </td>
                                    <td>
                                        <form method="post" action="{{ route('admin.categories.destroy', $category->id) }}" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('admin.cats.show', $category->slug) }}" class="btn btn-info btn-xs">
                                                <span class="fa fa-folder-open"></span> دسته‌بندی‌ها
                                            </a>
                                            <a href="{{ route('admin.categories.edit', $category->slug) }}" class="btn btn-primary btn-xs">
                                                <span class="fa fa-pencil"></span> ویرایش
                                            </a>
                                            <button type="submit" name="delete" class="btn btn-danger btn-xs">
                                                <span class="fa fa-trash"></span> حذف
                                            </button>
                                        </form>
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
