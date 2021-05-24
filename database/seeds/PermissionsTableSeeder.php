<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permissions')->truncate();

        $permissions = [
            [
                'name' => 'dashboard-access',
                'display_name' => 'دسترسی پیش‌فرض',
                'description' => 'کاربر دارای این دسترسی توانایی‌های پیش‌فرض مدیریتی را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'categories-create',
                'display_name' => 'افزودن دسته‌بندی',
                'description' => 'کاربر دارای این دسترسی توانایی افزودن دسته‌بندی جدید را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'categories-edit',
                'display_name' => 'ویرایش دسته‌بندی',
                'description' => 'کاربر دارای این دسترسی توانایی ویرایش دسته‌بندی را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'categories-delete',
                'display_name' => 'حذف دسته‌بندی',
                'description' => 'کاربر دارای این دسترسی توانایی حذف دسته‌بندی‌ها را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cities-create',
                'display_name' => 'افزودن شهر',
                'description' => 'کاربر دارای این دسترسی توانایی افزودن شهر جدید را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cities-edit',
                'display_name' => 'ویرایش شهر',
                'description' => 'کاربر دارای این دسترسی توانایی ویرایش شهر را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'cities-delete',
                'display_name' => 'حذف شهر',
                'description' => 'کاربر دارای این دسترسی توانایی حذف شهر را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pages-create',
                'display_name' => 'افزودن صفحه',
                'description' => 'کاربر دارای این دسترسی توانایی افزودن صفحه جدید را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pages-edit',
                'display_name' => 'ویرایش صفحه',
                'description' => 'کاربر دارای این دسترسی توانایی ویرایش صفحه را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'pages-delete',
                'display_name' => 'حذف صفحه',
                'description' => 'کاربر دارای این دسترسی توانایی حذف صفحه را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users-edit',
                'display_name' => 'ویرایش کاربر',
                'description' => 'کاربر دارای این دسترسی توانایی ویرایش کاربر را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'users-delete',
                'display_name' => 'حذف کاربر',
                'description' => 'کاربر دارای این دسترسی توانایی حذف کاربر را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reports-show',
                'display_name' => 'مشاهده گزارش',
                'description' => 'کاربر دارای این دسترسی توانایی مشاهده گزارشات را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'reports-delete',
                'display_name' => 'حذف گزارش',
                'description' => 'کاربر دارای این دسترسی توانایی حذف گزارش را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'settings-manage',
                'display_name' => 'مدیریت تنظیمات',
                'description' => 'کاربر دارای این دسترسی توانایی مدیریت تنظیمات را خواهد داشت.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('permissions')->insert($permissions);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
