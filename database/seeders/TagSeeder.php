<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'tezkor',
            'siyosat',
            'sport',
            'iqtisod',
            'jamiyat',
            'madaniyat',
            'texnologiya',
            'sog\'liq',
            'ta\'lim',
            'reportaj',
        ];

        foreach ($tags as $tag) {
            $slug = Str::slug($tag);

            Tag::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $tag,
                    'slug' => $slug,
                ]
            );
        }
    }
}
