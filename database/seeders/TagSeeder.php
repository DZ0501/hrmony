<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tags = [
            ['name' => 'Frontend'],
            ['name' => 'Backend'],
            ['name' => 'UI/UX'],
            ['name' => 'Marketing'],
            ['name' => 'SEO'],
            ['name' => 'Communication'],
            ['name' => 'Leadership'],
            ['name' => 'Project Management'],
            ['name' => 'Programming'],
            ['name' => 'Database Design'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }
    }
}
