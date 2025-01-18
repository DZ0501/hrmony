<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanyUpdate;


class CompanyUpdateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        CompanyUpdate::create([
            'title' => 'New Year Holiday Policy',
            'content' => 'The office will remain closed on January 1st for the New Year.',
            'published' => true,
        ]);

        CompanyUpdate::create([
            'title' => 'Remote Work Guidelines',
            'content' => 'All employees can request remote work days up to 3 times a month.',
            'published' => true,
        ]);
    }
}
