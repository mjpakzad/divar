@extends('admin.layouts.app')
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>تولیدکننده‌ها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.manufacturers.create') }}"><i class="fa fa-plus"></i> افزودن تولیدکننده</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام تولیدکننده</th>
                                <th>لوگو</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($manufacturers as $manufacturer)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $manufacturer->name }}</td>
                                <td>
                                    @if($manufacturer->image_id)
                                    <img src="{{ url(image_resize($manufacturer->image->name, ['width' => 25, 'height' => 25])) }}" alt="{{ $manufacturer->name }}" class="img-thumbnail">
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.manufacturers.destroy', ['id' => $manufacturer->id]) }}" method="post" class="form-horizontal">
                                        @csrf
                                        @method('delete')
                                        <a class="btn btn-primary btn-xs" href="{{ route('admin.manufacturers.edit', $manufacturer->slug) }}">
                                            <span class="fa fa-pencil"></span>
                                            ویرایش تولید کننده
                                        </a>
                                        <button type="submit" class="btn btn-danger btn-xs" name="delete" value="1" onclick="return confirm('آیا از حذف این تولید کننده اطمینان دارید؟');">
                                            <span class="fa fa-trash"></span>
                                            حذف تولید کننده
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        @unless(count($manufacturers))
                            <tr>
                                <td colspan="4">هیچ تولید کننده‌ای ایجاد نشده است.</td>
                            </tr>
                        @endunless
                        </tbody>
                    </table>
                </div>
                {{ $manufacturers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
