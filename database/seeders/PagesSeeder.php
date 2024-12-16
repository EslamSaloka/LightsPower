<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Page;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = Page::count();
        if($pages == 0) {
            Page::insert([
                [
                    'key'       => "help",
                    'name'      => "المساعده و الدعم",
                    'content'   => "كتابه نص عربي طويل",
                ],
                [
                    'key'       => "policy",
                    'name'      => "سياسه الخصوصيه",
                    'content'   => "كتابه نص عربي طويل",
                ],
                [
                    'key'       => "terms",
                    'name'      => "الشروط و الأحكام",
                    'content'   => "كتابه نص عربي طويل",
                ],
            ]);
        }
    }
}
