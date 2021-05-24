<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('settings')->truncate();

        $settings = [
            [
                'key'           => 'title',
                'label'         => 'عنوان سایت',
                'value'         => 'تبلیغات دیوار',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'slogan',
                'label'         => 'شعار سایت',
                'value'         => 'شعار سایت در این قسمت قرار می‌گیرد.',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'meta_keywords',
                'label'         => 'کلمات کلیدی',
                'value'         => 'کلمات کلیدی را با کاما جدا کنید',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'meta_description',
                'label'         => 'متای توضیحات',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'app_bazaar',
                'label'         => 'لینک اپلیکیشن کافه بازار',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'google_play',
                'label'         => 'لینک اپلیکیشن در گوگل پلی',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'app_store',
                'label'         => 'لینک اپلیکیشن در اپ استور',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'email',
                'label'         => 'ایمیل سایت',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'copyright',
                'label'         => 'کپی رایت فوتر',
                'value'         => 'تمامی حقوق محفوظ است.',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'twitter',
                'label'         => 'توئیتر',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'whatsapp',
                'label'         => 'واتس‌اپ',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'telegram',
                'label'         => 'تلگرام',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'key'           => 'instagram',
                'label'         => 'اینستاگرام',
                'value'         => '',
                'autoload'      => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ];

        DB::table('settings')->insert($settings);
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
