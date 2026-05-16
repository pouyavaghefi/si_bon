<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('configurations')->insert([
            'site_name' => 'پنل مدیریت چاپ',
            'site_url' => 'http://localhost:8000',
            'admin_email' => 'admin@example.com',
            'phone' => '09120000000',

            'site_description' => 'سیستم مدیریت و سفارش چاپ آنلاین',

            'meta_title' => 'پنل مدیریت چاپ',
            'meta_keywords' => 'چاپ, طراحی, سفارش چاپ, مدیریت چاپ',
            'meta_description' => 'سیستم حرفه‌ای مدیریت چاپ و سفارشات',

            'instagram' => 'https://instagram.com/example',
            'telegram' => 'https://t.me/example',
            'linkedin' => 'https://linkedin.com',
            'youtube' => 'https://youtube.com',

            'site_logo' => null,

            'site_status' => 1,
            'maintenance_mode' => 0,

            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
