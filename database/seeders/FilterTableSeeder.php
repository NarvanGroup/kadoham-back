<?php

namespace Database\Seeders;

use App\Models\Api\V1\Filter;
use Illuminate\Database\Seeder;

class FilterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seeds = [
            [
                "name"    => 'Man Upper Body Size',
                "options" => [
                    "columns" => ["UK", "EU", "INT", "Chest", "Sleeve"],
                    "rows"    => [
                        [38, 46, "XS", "110-116", "63-65"],
                        [40, 48, "S", "114-120", "64-66"],
                        [42, 50, "M", "118-124", "65-67"],
                        [44, 52, "L", "122-128", "66-68"],
                        [46, 54, "XL", "126-132", "67-69"],
                        [48, 56, "2XL", "130-136", "68-70"],
                        [50, 58, "3XL", "134-140", "69-71"],
                        [52, 60, "4XL", "138-144", "70-72"],
                        [54, 62, "5XL", "142-148", "70-72"],
                        [56, 54, "6XL", "146-152", "71-73"],
                    ]
                ]
            ],
            [
                "name"    => 'Man Lower Body Size',
                "options" => [
                    "columns" => ["Waist", "INT", "C"],
                    "rows"    => [
                        [28, "XS", "71"],
                        [30, "S", "76"],
                        [32, "M", "81"],
                        [34, "L", "86"],
                        [36, "XL", "91"],
                        [38, "2XL", "96"],
                        [40, "3XL", "101"],
                        [42, "4XL", "106"],
                        [44, "5XL", "111"],
                        [46, "6XL", "116"],
                    ]
                ]
            ],
            [
                "name"    => 'Women Upper Body Size',
                "options" => [
                    "columns" => ["UK", "EU", "INT", "Chest", "Sleeve"],
                    "rows"    => [
                        [8, 34, "XS", "98-104", "62-64"],
                        [10, 36, "S", "102-108", "63-65"],
                        [12, 38, "M", "106-112", "64-66"],
                        [14, 40, "L", "110-116", "65-67"],
                        [16, 42, "XL", "114-120", "66-68"],
                        [18, 44, "2XL", "118-124", "67-69"],
                        [20, 46, "3XL", "122-128", "68-70"],
                        [22, 48, "4XL", "126-132", "69-71"],
                        [24, 50, "5XL", "130-136", "69-71"],
                        [26, 52, "6XL", "134-140", "70-72"],
                    ]
                ]
            ],
            [
                "name"    => 'Women Lower Body Size',
                "options" => [
                    "columns" => ["Waist", "INT", "C"],
                    "rows"    => [
                        [26, "XS", "66"],
                        [28, "S", "71"],
                        [30, "M", "76"],
                        [32, "L", "81"],
                        [34, "XL", "86"],
                        [36, "2XL", "91"],
                        [38, "3XL", "96"],
                        [40, "4XL", "101"],
                        [42, "5XL", "106"],
                        [44, "6XL", "111"],
                    ]
                ]
            ],
            [
                "name"    => 'Gloves size',
                "options" => [
                    "columns" => ["EUR", "INT", "Length", "Width"],
                    "rows"    => [
                        [6, "XXS", "5.5-6", "16"],
                        [7, "XS", "6.5-7", "17"],
                        [8, "S", "7.5-8", "18"],
                        [9, "M", "8.5-9", "19"],
                        [10, "L", "9.5-10", "20"],
                        [11, "XL", "10.5-11", "21"],
                        [12, "2XL", "11.5-12", "22"],
                        [13, "3XL", "12.5-13", "23"],
                        [14, "4XL", "13.5-14", "24"]
                    ]
                ]
            ],
            [
                "name"    => 'Women Shoe Size',
                "options" => [
                    "columns" => ["US", "UK", "EUR"],
                    "rows"    => [
                        [4, 2, 35],
                        [4.5, 2.5, 35],
                        [5, 3, 36],
                        [5.5, 3.5, 36],
                        [6, 4, 36],
                        [6.5, 4.5, 37],
                        [7, 5, 37],
                        [7.5, 5.5, 38],
                        [8, 6, 38],
                        [8.5, 6.5, 39],
                        [9, 7, 40],
                        [9.5, 7.5, 40],
                        [10, 8, 41],
                        [10.5, 8.5, 41],
                        [11, 9, 42],
                        [11.5, 9.5, 42],
                        [12, 10, 43],
                        [12.5, 10.5, 43],
                        [13, 11, 45],
                        [13.5, 11.5, 45.5],
                        [14, 12, 46],
                        [15, 13, 47]
                    ]
                ]
            ],
            [
                "name"    => 'Men Shoe Size',
                "options" => [
                    "columns" => ["US", "UK", "EUR"],
                    "rows"    => [
                        [6, 5, 40],
                        [6.5, 5.5, 40],
                        [7, 6, 41],
                        [7.5, 6.5, 41],
                        [8, 7, 42],
                        [8.5, 7.5, 42],
                        [9, 8, 43],
                        [9.5, 8.5, 43],
                        [10, 9, 44],
                        [10.5, 9.5, 44],
                        [11, 10, 45],
                        [11.5, 10.5, 45],
                        [12, 11, 46],
                        [13, 12, 47],
                        [14, 13, 48],
                        [15, 14, 49],
                        [16, 15, 50]
                    ]
                ]
            ],
            [
                "name"    => 'Interests',
                "options" => [
                    "columns" => ["EN", "FA"],
                    "rows"    => [
                        ['Sports', 'ورزش'],
                        ['Travel', 'سفر و تجربه'],
                        ['Fashion', 'لباس و فشن'],
                        ['Cooking', 'غذا، آشپزی و رستوران'],
                        ['Drinks', 'نوشیدنی'],
                        ['Reading', 'کتاب و مطالعه'],
                        ['Technology', 'تکنولوژی'],
                        ['Arts and design', 'هنر و طراحی'],
                        ['Music', 'موسیقی'],
                        ['Gaming', 'بازی ویدیویی'],
                        ['Photography', 'عکاسی'],
                        ['Film and tv', 'فیلم و سریال'],
                        ['Outdoor activities', 'طبیعت گردی و کوه نوردی'],
                        ['Health and fitness', 'سلامت و تناسب اندام'],
                        ['Pets', 'حیوانات خانگی'],
                        ['Gardening', 'گل و گیاه'],
                        ['DIY', 'کارهای دستی'],
                        ['Personal growth', 'رشد فردی'],
                        ['Podcasts', 'پادکست'],
                        ['Beauty and skin care', 'مراقبت های آرایشی و بهداشتی'],
                        ['Science and education', 'علم و یادگیری'],
                        ['Other', 'نمیدانم'],
                        ['Board games', 'بورد گیم'],
                        ['Cleaning', 'تمیزکاری'],
                        ['Sleeping', 'خواب و استراحت'],
                        ['Social Media', 'شبکه های مجازی'],
                        ['Family time', 'وقت گذرانی با خانواده'],
                        ['Working', 'کار'],
                        ['Praying and meditation', 'دعا و مراقبه'],
                        ['Party', 'مهمونی و دورهمی']
                    ]
                ]
            ],
            [
                "name"    => 'Fashion style',
                "options" => [
                    "columns" => ["EN", "FA"],
                    "rows"    => [
                        ['Glamorous', 'شیک و مجلسی'],
                        ['Sporty', 'اسپرت'],
                        ['Professional', 'رسمی'],
                        ['Gothic', 'گات'],
                        ['Casual', 'راحت و روزمره'],
                        ['Trendy', 'مطابق مد روز'],
                        ['Don\'t care', 'سایر']
                    ]
                ]
            ],
            [
                "name"    => 'Gift type',
                "options" => [
                    "columns" => ["EN", "FA"],
                    "rows"    => [
                        ['Experience', 'سفر و تجربه'],
                        ['Products', 'لوازم'],
                        ['Cash', 'پول نقدی'],
                        ['Vouchers', 'کارت هدیه'],
                        ['DIY', 'کارهای دستی']
                    ]
                ]
            ],
        ];

        foreach ($seeds as $seed) {
            Filter::create($seed);
        }
    }
}