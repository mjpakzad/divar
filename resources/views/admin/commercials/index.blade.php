@extends('admin.layouts.app')
@section('styles')
    <link href="{{ asset('vendor/gentelella-rtl/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endsection
@section('scripts')
    <script src="{{ asset('vendor/yajra/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/yajra/js/datatables.bootstrap.js') }}"></script>
    <script src="{{ asset('vendor/yajra/js/simple_numbers_no_ellipses.js') }}"></script>
    <script type="text/javascript">
        $.fn.DataTable.ext.pager.simple_numbers_no_ellipses = function(page, pages){
            var numbers = [];
            var buttons = $.fn.DataTable.ext.pager.numbers_length;
            var half = Math.floor( buttons / 2 );

            var _range = function ( len, start ){
                var end;

                if ( typeof start === "undefined" ){
                    start = 0;
                    end = len;

                } else {
                    end = start;
                    start = len;
                }

                var out = [];
                for ( var i = start ; i < end; i++ ){ out.push(i); }

                return out;
            };


            if ( pages <= buttons ) {
                numbers = _range( 0, pages );

            } else if ( page <= half ) {
                numbers = _range( 0, buttons);

            } else if ( page >= pages - 1 - half ) {
                numbers = _range( pages - buttons, pages );

            } else {
                numbers = _range( page - half, page + half + 1);
            }

            numbers.DT_el = 'span';

            return [ 'previous', numbers, 'next' ];
        };
    </script>
    <script type="text/javascript">
        $('#commercials').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.commercials.ajax') }}',
            columns: [
                {data: 'title', name: 'title'},
                {data: 'mobile', name: 'users.mobile'},
                {data: 'city', name: 'city'},
                {data: 'name', name: 'name'},
                {data: 'staff', name: 'staff'},
                {data: 'created_at', name: 'created_at'},
                {data: 'clicks_count', name: 'clicks_count'},
                {data: 'views_count', name: 'views_count'},
                {data: 'id', name: 'id'},
                {data: 'buy', name: 'buy'},
                {data: 'status', name: 'status'},
                {data: 'tag', name: 'tag', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            "order": [[ 5, "desc" ]],
            "language": {
                "url": "{{ asset('vendor/yajra/i18n/Persian.json') }}"
            },
            "buttons": [ 'copy', 'excel', 'pdf', 'colvis' ],
            "pagingType": "simple_numbers_no_ellipses"
        });
    </script>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>آگهی‌ها</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li>
                        <a href="{{ route('admin.commercials.create') }}"><i class="fa fa-plus"></i> افزودن آگهی</a>
                    </li>
                    <li>
                        <a href="{{ route('admin.commercials.export') }}"><i class="fa fa-file-excel-o"></i> خروجی اکسل</a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="display: block;">
                <div class="table-responsive">
                    <table id="commercials" class="table table-hover">
                    <thead>
                        <tr>
                            <th>عنوان</th>
                            <th>کاربر</th>
                            <th>شهر</th>
                            <th>آگهی دهنده</th>
                            <th>ثبت کننده</th>
                            <th>تاریخ ایجاد</th>
                            <th>تعداد کلیک</th>
                            <th>تعداد نمایش</th>
                            <th>کد آگهی</th>
                            <th>نوع آگهی</th>
                            <th>وضعیت</th>
                            <th>برچسب</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
