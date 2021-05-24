@extends('admin.layouts.app')
@section('content')
    <div class="row top_tiles">
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-bullhorn"></i></div>
                <div class="count">{{ $commercialCount }}</div>
                <h3>آگهی‌ها</h3>
                <p>تعداد آگهی‌های درج شده در سایت</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-pencil"></i></div>
                <div class="count">{{ $articleCount }}</div>
                <h3>مقالات</h3>
                <p>تعداد مقالات درج شده در سایت</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-users"></i></div>
                <div class="count">{{ $userCount }}</div>
                <h3>کاربران</h3>
                <p>تعداد اعضای سایت</p>
            </div>
        </div>
        <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <div class="tile-stats">
                <div class="icon"><i class="fa fa-tag"></i></div>
                <div class="count">{{ $productCount ?? '' }}</div>
                <h3>محصولات</h3>
                <p>تعداد محصولات سیستم</p>
            </div>
        </div>
    </div>
    <!-- /top tiles -->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="dashboard_graph">
                <div class="row x_title">
                    <div class="col-md-6">
                        <h3>داشبورد</h3>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <p>به داشبورد پنل مدیریت خوش آمدید.</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
@endsection