<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ForumCategory;

class ForumCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ForumCategory::insert([
    ['name' => 'Inscriptions',    'slug' => 'inscriptions',    'sort_order' => 1],
    ['name' => 'Certifications',  'slug' => 'certifications',  'sort_order' => 2],
    ['name' => 'Relevés de notes','slug' => 'releves',         'sort_order' => 3],
    ['name' => 'PVR',             'slug' => 'pvr',             'sort_order' => 4],
    ['name' => 'Rattrapages',     'slug' => 'rattrapages',     'sort_order' => 5],
    ['name' => 'Général',         'slug' => 'general',         'sort_order' => 6],
]);
    }
}
