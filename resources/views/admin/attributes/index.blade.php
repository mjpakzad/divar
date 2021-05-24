@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>خصوصیات</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.attributes.create') }}"><i class="fa fa-plus"></i> افزودن خصوصیت</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-condensed">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>نام گروه ویژگی</td>
                                <td>ترتیب</td>
                                <td>عملیات</td>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($attributeGroups as $group)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $group->name }}</td>
                                <td>{{ $group->sort_order }}</td>
                                <td>
                                    <form method="post" action="{{ route('admin.attributes.destroy', ['id' => $group->id]) }}" class="form-horizontal">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-primary btn-xs" href="{{ route('admin.attributes.edit', ['id' => $group->id]) }}">
                                            <span class="fa fa-pencil"></span>
                                            ویرایش گروه
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-xs" name="delete" value="1" onclick="return confirm('آیا از حذف این خصوصیت اطمینان دارید؟');">
                                            <span class="fa fa-minus"></span>
                                            حذف گروه
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">هیچ خصوصیتی یافت نشد!</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $attributeGroups->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
