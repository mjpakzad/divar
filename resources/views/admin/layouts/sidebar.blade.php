<div class="col-md-3 left_col hidden-print">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="{{ url('/') }}" class="site_title" target="_blank"><i class="fa fa-bullhorn"></i> <span>{{ $site_settings['title'] }}</span></a>
        </div>
        <div class="clearfix"></div>
        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <ul class="nav side-menu">
                    @foreach($menus as $menu)
                        @if(user_has($menu['permissions'], $userPermissions))
                            @if(isset($menu['children']) && $menu['children'])
                                <li class="@if(isset($menu['active']) && $menu['active']) active @endif">
                                    <a>
                                        <i class="fa fa-{{$menu['icon']}}"></i>
                                        <span>{{ $menu['label'] }}</span>
                                        <span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul class="nav child_menu">
                                        @foreach($menu['children'] as $child)
                                            @if(user_has($child['permissions'] , $userPermissions))
                                                <li class="@if(isset($child['active']) && $child['active']) active @endif">
                                                    <a href="{{ isset($child['parameters']) ? route($child['route_name'], $child['parameters']) : route($child['route_name']) }}" class="nav-link">
                                                        <span class="fa fa-{{ $child['icon'] }}"></span>
                                                        <span class="title">{{ $child['label'] }}</span>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="@if(isset($menu['active']) && $menu['active']) active @endif">
                                    <a href="{{ isset($menu['parameters']) ? route($menu['route_name'], $menu['parameters']) : route($menu['route_name']) }}" class="nav-link">
                                        <i class="fa fa-{{ $menu['icon'] }}"></i>
                                        <span class="title">{{ $menu['label'] }}</span>
                                    </a>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>
            </div>

        </div>
        <!-- /sidebar menu -->

        <!-- /menu footer buttons -->
        <div class="sidebar-footer hidden-small">
            <a data-toggle="tooltip" data-placement="top" title="تنظیمات" href="{{ route('admin.settings.index') }}">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="تمام صفحه" onclick="toggleFullScreen();">
                <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="قفل" class="lock_btn">
                <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="خروج" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        <!-- /menu footer buttons -->
    </div>
</div>
