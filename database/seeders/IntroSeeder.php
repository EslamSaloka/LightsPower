<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Intro;

class IntroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intros = Intro::count();
        if($intros == 0) {
            Intro::insert([
                [
                    'description'  => "الصفحة الأولي الإفتتاحيه للتطبيق",
                ],
                [
                    'description'  => "الصفحة الثانية الإفتتاحيه للتطبيق",
                ],
                [
                    'description'  => "الصفحة الثالثة الإفتتاحيه للتطبيق",
                ],
            ]);
        }
    }
}
