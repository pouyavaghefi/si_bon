<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [

            'چاپ استیکر',
            'چاپ بنر',
            'چاپ مش',
            'چاپ شیشه',
            'چاپ فلکس',
            'چاپ بک‌لایت',
            'چاپ UV',
            'چاپ کاتری',
            'چاپ لیبل',
            'چاپ رول آپ',
            'چاپ بوم',
            'چاپ پلات',
            'چاپ کارت ویزیت',
            'چاپ تراکت',
            'چاپ کاتالوگ',

        ];

        foreach ($categories as $category) {

            ProductCategory::firstOrCreate(
                [
                    'slug' => Str::slug($category),
                ],
                [
                    'title' => $category,
                ]
            );

        }
    }
}
