<?php

namespace Database\Seeders;

use App\Models\CompanyUpdate;
use Illuminate\Database\Seeder;

class CompanyUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        for ($i = 1; $i <= 5; $i++) {
            $update = CompanyUpdate::create([
                'title' => "Update $i",
                'content' => "This is the content for update $i.",
                'published' => rand(0, 1),
                'created_by' => rand(2, 5),
            ]);

            $update->tags()->attach([rand(1, 3), rand(4, 6)]);
        }
    }
}
