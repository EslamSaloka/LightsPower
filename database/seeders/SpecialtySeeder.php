<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Specialty;

class SpecialtySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = Specialty::count();
        if($specialties == 0) {
            Specialty::insert([
                [
                    'name'          => "إثراء",
                    'description'   => "أدب و فنون",
                    'image'         => null,
                ],
                [
                    'name'          => "أدب و فنون",
                    'description'   => "أدب و فنون",
                    'image'         => null,
                ],
                [
                    'name'          => "حياه إجتماعية",
                    'description'   => "حياه إجتماعية",
                    'image'         => null,
                ],
                [
                    'name'          => "صحه و عناية",
                    'description'   => "صحه و عناية",
                    'image'         => null,
                ],
                [
                    'name'          => "إداره و تطوير",
                    'description'   => "إداره و تطوير",
                    'image'         => null,
                ],
                [
                    'name'          => "طاقة و استدامة",
                    'description'   => "طاقة و استدامة",
                    'image'         => null,
                ],
                [
                    'name'          => "نبات",
                    'description'   => "نبات",
                    'image'         => null,
                ],
                [
                    'name'          => "وثائقيات",
                    'description'   => "وثائقيات",
                    'image'         => null,
                ],
                [
                    'name'          => "فنون بصرية",
                    'description'   => "فنون بصرية",
                    'image'         => null,
                ],
                [
                    'name'          => "تقنية",
                    'description'   => "تقنية",
                    'image'         => null,
                ],
                [
                    'name'          => "هندسة",
                    'description'   => "هندسة",
                    'image'         => null,
                ],
                [
                    'name'          => "تصميمات",
                    'description'   => "تصميمات",
                    'image'         => null,
                ],
                [
                    'name'          => "حرفيات",
                    'description'   => "حرفيات",
                    'image'         => null,
                ],
            ]);
        }
    }
}
