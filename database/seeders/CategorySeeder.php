<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Asosiy', 'color' => '#2f855a'],
            ['name' => 'O\'zbekiston', 'color' => '#1b5e20'],
            ['name' => 'Jahon', 'color' => '#0f766e'],
            ['name' => 'Iqtisodiyot', 'color' => '#b45309'],
            ['name' => 'Sport', 'color' => '#2563eb'],
            ['name' => 'Jamiyat', 'color' => '#7c3aed'],
            ['name' => 'Madaniyat', 'color' => '#be185d'],
            ['name' => 'Salomatlik', 'color' => '#059669'],
            ['name' => 'Hi-Tech', 'color' => '#334155'],
            ['name' => 'Tahlil', 'color' => '#dc2626'],
        ];

        foreach ($categories as $category) {
            $slug = Str::slug($category['name']);

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $category['name'],
                    'slug' => $slug,
                    'color' => $category['color'],
                ]
            );
        }
    }
}
