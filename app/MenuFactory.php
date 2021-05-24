<?php
namespace App;

class MenuFactory {

    /**
     * Builds hierarchy menu.
     *
     * @return array $menu menu
     */
    public static function build(){
        $menus = [
            [
                'label' => 'داشبورد',
                'permissions' => ['dashboard-access'],
                'icon' => 'dashboard',
                'route_name' => 'admin.app.index',
            ],
            [
                'label'         => 'فروشگاه',
                'permissions'   => [
                    'filters-create', 'filters-edit', 'filters-delete',
                    'options-create', 'options-edit', 'options-delete',
                    'products-create', 'products-edit', 'products-delete',
                    'categories-create', 'categories-edit', 'categories-delete',
                    'attributes-create', 'attributes-edit', 'attributes-delete',
                    'manufacturers-create', 'manufacturers-edit', 'manufacturers-delete',
                ],
                'icon'          => 'tags',
                'children'      => [
                    [
                        'route_name'    => 'admin.shop.categories.index',
                        'label'         => 'دسته‌بندی‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['categories-create', 'categories-edit', 'categories-delete',],
                    ],
                    [
                        'route_name'    => 'admin.filters.index',
                        'label'         => 'فیلترها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['filters-create', 'filters-edit', 'filters-delete',],
                    ],
                    [
                        'route_name'    => 'admin.attributes.index',
                        'label'         => 'خصوصیات',
                        'icon'          => 'circle-o',
                        'permissions'   => ['attributes-create', 'attributes-edit', 'attributes-delete',],
                    ],
                    [
                        'route_name'    => 'admin.options.index',
                        'label'         => 'گزینه‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['options-create', 'options-edit', 'options-delete',],
                    ],
                    [
                        'route_name'    => 'admin.products.index',
                        'label'         => 'محصولات',
                        'icon'          => 'circle-o',
                        'permissions'   => ['products-create', 'products-edit', 'products-delete',],
                    ],
                    [
                        'route_name'    => 'admin.manufacturers.index',
                        'label'         => 'تولیدکنندگان',
                        'icon'          => 'circle-o',
                        'permissions'   => ['manufacturers-create', 'manufacturers-edit', 'manufacturers-delete',],
                    ],
                ]
            ],
            [
                'label'         => 'آگهی‌ها',
                'permissions'   => [
                    'commercials-edit', 'commercials-delete',
                    'categories-create', 'categories-edit', 'categories-delete',
                ],
                'icon'          => 'bullhorn',
                'children'      => [
                    [
                        'route_name'    => 'admin.commercials.index',
                        'label'         => 'آگهی‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['commercials-edit', 'commercials-delete'],
                    ],
                    [
                        'route_name'    => 'admin.categories.index',
                        'label'         => 'دسته‌بندی‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['categories-create', 'categories-edit', 'categories-delete'],
                    ],
                    [
                        'route_name'    => 'admin.cats.index',
                        'label'         => 'دسته‌بندی‌های اصلی',
                        'icon'          => 'circle-o',
                        'permissions'   => ['categories-create', 'categories-edit', 'categories-delete'],
                    ],
                    [
                        'route_name'    => 'admin.categories.create',
                        'label'         => 'افزودن دسته‌بندی',
                        'icon'          => 'circle-o',
                        'permissions'   => ['categories-create'],
                    ],
                    [
                        'route_name'    => 'admin.commercials.create',
                        'label'         => 'افزودن آگهی',
                        'icon'          => 'circle-o',
                        'permissions'   => ['dashboard-access', 'commercials-edit', 'commercials-delete'],
                    ],
                ]
            ],
            [
                'label'         => 'فیلدهای داینامیک',
                'icon'          => 'tasks',
                'permissions'   => ['fields-create', 'fields-edit', 'fields-delete'],
                'children'      => [
                    [
                        'route_name'    => 'admin.fields.index',
                        'label'         => 'فیلدهای داینامیک',
                        'icon'          => 'circle-o',
                        'permissions'   => ['comments-manage'],
                    ],
                    [
                        'route_name'    => 'admin.fields.create',
                        'label'         => 'افزودن فیلد داینامیک',
                        'icon'          => 'circle-o',
                        'permissions'   => ['comments-manage'],
                    ],
                ],
            ],
            [
                'label'         => 'مناطق',
                'permissions'   => [
                    'provinces-create', 'provinces-edit', 'provinces-delete',
                    'cities-create', 'cities-edit', 'cities-delete',
                    ],
                'icon'          => 'map-o',
                'children'      => [
                    /*[
                        'route_name'    => 'admin.provinces.index',
                        'label'         => 'استان‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['provinces-create', 'provinces-edit', 'provinces-delete',],
                    ],*/
                    [
                        'route_name'    => 'admin.cities.index',
                        'label'         => 'شهرها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['cities-create', 'cities-edit', 'cities-delete',],
                    ],
                    [
                        'route_name'    => 'admin.cities.create',
                        'label'         => 'افزودن شهر',
                        'icon'          => 'circle-o',
                        'permissions'   => ['cities-create'],
                    ],
                ]
            ],
            [
                'label'         => 'هواشناسی',
                'permissions'   => ['weather-manage'],
                'icon'          => 'map-signs',
                'children'      => [
                    [
                        'route_name'    => 'admin.weather.index',
                        'label'         => 'استان‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['weather-manage'],
                    ],
                ]
            ],
            [
                'label'         => 'صفحات',
                'permissions'   => ['pages-create', 'pages-edit', 'pages-delete',],
                'icon'          => 'files-o',
                'children'      => [
                    [
                        'route_name'    => 'admin.pages.index',
                        'label'         => 'صفحات',
                        'icon'          => 'circle-o',
                        'permissions'   => ['pages-create', 'pages-edit', 'pages-delete'],
                    ],
                    [
                        'route_name'    => 'admin.pages.create',
                        'label'         => 'افزودن صفحه',
                        'icon'          => 'circle-o',
                        'permissions'   => ['pages-create'],
                    ],
                ]
            ],
            [
                'label'         => 'مجله دریایی',
                'permissions'   => [
                    'blog-create', 'blog-edit', 'blog-delete',
                    'categories-create', 'categories-edit', 'categories-delete',
                ],
                'icon'          => 'pencil',
                'children'      => [
                    [
                        'route_name'    => 'admin.blog.index',
                        'label'         => 'مقالات',
                        'icon'          => 'circle-o',
                        'permissions'   => ['blog-create', 'blog-edit', 'blog-delete'],
                    ],
                    [
                        'route_name'    => 'admin.groups.index',
                        'label'         => 'دسته‌بندی‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['categories-create', 'categories-edit', 'categories-delete'],
                    ],
                    [
                        'route_name'    => 'admin.blog.create',
                        'label'         => 'افزودن مقاله',
                        'icon'          => 'circle-o',
                        'permissions'   => ['blog-create'],
                    ],
                ]
            ],
            [
                'label'         => 'طراحی',
                'permissions'   => ['banners-create', 'banners-edit', 'banners-delete'],
                'icon'          => 'paint-brush',
                'children'      => [
                    [
                        'route_name'    => 'admin.banners.index',
                        'label'         => 'بنرها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['banners-create', 'banners-edit', 'banners-delete'],
                    ],
                ]
            ],
            [
                'label'         => 'تماس',
                'permissions'   => ['contacts-manage'],
                'icon'          => 'envelope',
                'children'      => [
                    [
                        'route_name'    => 'admin.contacts.index',
                        'label'         => 'تماس‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['contacts-manage'],
                    ],
                ]
            ],
            [
                'label'         => 'گزارشات',
                'permissions'   => ['reports-show', 'reports-delete', 'reports-reasons'],
                'icon'          => 'newspaper-o',
                'children'      => [
                    [
                        'route_name'    => 'admin.reports.index',
                        'label'         => 'گزارشات',
                        'icon'          => 'circle-o',
                        'permissions'   => ['reports-show', 'reports-delete'],
                    ],
                    [
                        'route_name'    => 'admin.reports.reasons.index',
                        'label'         => 'دلایل',
                        'icon'          => 'circle-o',
                        'permissions'   => ['reports-reasons'],
                    ],
                ]
            ],
            [
                'label'         => 'امور مالی',
                'permissions'   => ['payments-manage', 'invoices-manage'],
                'icon'          => 'credit-card',
                'children'      => [
                    [
                        'route_name'    => 'admin.services.index',
                        'label'         => 'سرویس‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['services-manage'],
                    ],
                    [
                        'route_name'    => 'admin.invoices.index',
                        'label'         => 'فاکتورها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['invoices-manage'],
                    ],
                    [
                        'route_name'    => 'admin.payments.index',
                        'label'         => 'پرداخت‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['payments-manage'],
                    ],
                    [
                        'route_name'    => 'admin.transactions.index',
                        'label'         => 'تراکنش‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['payments-manage'],
                    ],
                ]
            ],
            [
                'label'         => 'کاربران',
                'permissions'   => [
                    'users-create', 'users-edit', 'users-delete',
                    'roles-create', 'roles-edit', 'roles-delete',
                ],
                'icon'          => 'users',
                'children'      => [
                    [
                        'route_name'    => 'admin.users.index',
                        'label'         => 'کاربران',
                        'icon'          => 'circle-o',
                        'permissions'   => ['users-create', 'users-edit', 'users-delete'],
                    ],
                    [
                        'route_name'    => 'admin.roles.index',
                        'label'         => 'گروه‌های کاربری',
                        'icon'          => 'circle-o',
                        'permissions'   => ['roles-create', 'roles-edit', 'roles-delete'],
                    ],
                ]
            ],
            [
                'label'         => 'سیستم',
                'permissions'   => ['settings-manage','banners-manage','tickets-manage'],
                'icon'          => 'cog',
                'children'      => [
                    [
                        'route_name'    => 'admin.settings.index',
                        'label'         => 'تنظیمات عمومی',
                        'icon'          => 'circle-o',
                        'permissions'   => ['settings-manage'],
                    ],
                    [
                        'route_name'    => 'admin.banners.index',
                        'label'         => 'بنرها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['banners-manage'],
                    ],
                    [
                        'route_name'    => 'admin.tickets.index',
                        'label'         => 'تیکت‌ها',
                        'icon'          => 'circle-o',
                        'permissions'   => ['tickets-manage'],
                    ],
                ]
            ],
        ];

        $currentRouteName = app('router')->getCurrentRoute()->getName();

        foreach($menus as &$menu) {
            if(isset($menu['route_name']) && $currentRouteName == $menu['route_name']) {
                $menu['active'] = true;
            }

            if(isset($menu['children']) && $menu['children']) {
                foreach($menu['children'] as &$child) {
                    if(isset($child['route_name']) && $currentRouteName == $child['route_name']) {
                        $menu['active'] = true;
                        $child['active'] = true;
                    }

                    if(isset($menu['permissions']) && $child['permissions']) {
                        $menu['permissions'] = array_merge($menu['permissions'], $child['permissions']);
                    }
                }
            }
        }

        return $menus;
    }

    /**
     * Puts user permissions in an array.
     *
     * @return array $user_permissions Permissions of the current user
     */
    public static function userPermissions()
    {
        $user_roles = auth()->user()->roles;
        $permissions = [];

        foreach($user_roles as $user_role)
        {
            $user_permissions = $user_role->permissions()->pluck('name')->toArray();
            foreach ($user_permissions as $permission)
            {
                $permissions[] = $permission;
            }
        }

        return $permissions;
    }
}
