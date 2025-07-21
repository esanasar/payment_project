<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $categories = [
            'حمل و نقل',
            'ایاب و ذهاب',
            'خرید تجهیزات',
            'پذیرایی',
            'هزینه اداری',
        ];

        foreach ($categories as $title) {
            ExpenseCategory::create(['title' => $title]);
        }
    }
}
