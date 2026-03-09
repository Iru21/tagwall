<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            "fruit/apple", "fruit/banana", "fruit/orange", "fruit/grape", "fruit/pear",
            "vegetable/tomato", "vegetable/potato", "vegetable/carrot", "vegetable/onion",
            "meat/chicken", "meat/beef", "meat/pork", "meat/fish",
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
