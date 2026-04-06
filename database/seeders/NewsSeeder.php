<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all()->keyBy('slug');
        $tags = Tag::all()->keyBy('slug');

        $items = [
            [
                'title' => 'Toshkentda yangi avtobus yo\'nalishlari ishga tushdi',
                'category' => 'o-zbekiston',
                'tags' => ['tezkor', 'jamiyat'],
                'accent' => '#16a34a',
                'days_ago' => 0,
            ],
            [
                'title' => 'Markaziy bank inflyatsiya bo\'yicha yangi prognozni e\'lon qildi',
                'category' => 'iqtisodiyot',
                'tags' => ['iqtisod', 'siyosat'],
                'accent' => '#d97706',
                'days_ago' => 1,
            ],
            [
                'title' => 'O\'zbekistonlik sportchilar xalqaro turnirda uchta medal oldi',
                'category' => 'sport',
                'tags' => ['sport', 'reportaj'],
                'accent' => '#2563eb',
                'days_ago' => 2,
            ],
            [
                'title' => 'Samarqandda yangi madaniy markaz faoliyati yo\'lga qo\'yildi',
                'category' => 'madaniyat',
                'tags' => ['madaniyat', 'jamiyat'],
                'accent' => '#db2777',
                'days_ago' => 3,
            ],
            [
                'title' => 'Raqamli xizmatlar bozorida yangi platforma taqdim etildi',
                'category' => 'hi-tech',
                'tags' => ['texnologiya', 'tezkor'],
                'accent' => '#0f172a',
                'days_ago' => 4,
            ],
            [
                'title' => 'Tibbiyot muassasalari uchun navbat tizimi yangilandi',
                'category' => 'salomatlik',
                'tags' => ['sog\'liq', 'jamiyat'],
                'accent' => '#059669',
                'days_ago' => 5,
            ],
            [
                'title' => 'Ta\'lim sohasida masofaviy o\'qitish bo\'yicha yangi tavsiyalar berildi',
                'category' => 'jamiyat',
                'tags' => ['ta\'lim', 'reportaj'],
                'accent' => '#7c3aed',
                'days_ago' => 6,
            ],
            [
                'title' => 'Jahon bozorlarida energiya narxlari keskin o\'zgardi',
                'category' => 'jahon',
                'tags' => ['siyosat', 'iqtisod'],
                'accent' => '#0f766e',
                'days_ago' => 7,
            ],
            [
                'title' => 'Tahlil: mintaqaviy loyihalar iqtisodiy faollikni oshiryapti',
                'category' => 'tahlil',
                'tags' => ['tahlil', 'iqtisod'],
                'accent' => '#dc2626',
                'days_ago' => 8,
            ],
            [
                'title' => 'Ko\'ngilochar dasturlar yangi mavsum bilan qaytmoqda',
                'category' => 'asosiy',
                'tags' => ['madaniyat', 'tezkor'],
                'accent' => '#2f855a',
                'days_ago' => 9,
            ],
        ];

        Storage::disk('public')->makeDirectory('seed-assets/news');

        foreach ($items as $index => $item) {
            $category = $categories[$item['category']] ?? $categories->first();
            $titleSlug = Str::slug($item['title']);
            $thumbnail = 'seed-assets/news/' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . '.svg';
            $publishedAt = now()->subDays($item['days_ago'])->setTime(9 + $index % 8, ($index * 7) % 60);

            Storage::disk('public')->put(
                $thumbnail,
                $this->buildSvgThumbnail($item['title'], $item['accent'], $index + 1)
            );

            $news = News::create([
                'title' => $item['title'],
                'slug' => $titleSlug,
                'body' => $this->buildBody($item['title']),
                'thumbnail' => $thumbnail,
                'category_id' => $category->id,
            ]);

            $tagIds = collect($item['tags'])
                ->map(fn (string $slug) => $tags[$slug]->id ?? null)
                ->filter()
                ->values()
                ->all();

            if ($tagIds) {
                $news->tags()->sync($tagIds);
            }

            DB::table('news')
                ->where('id', $news->id)
                ->update([
                    'created_at' => $publishedAt,
                    'updated_at' => $publishedAt,
                ]);
        }
    }

    private function buildBody(string $title): string
    {
        $lead = e($title);

        return <<<HTML
<p>{$lead} bo'yicha tahririyatimiz qisqa sharh tayyorladi. Bu test ma'lumot real bo'lmagan namunaviy kontent sifatida xizmat qiladi.</p>
<p>Yangilikning asosiy maqsadi sahifalardagi kartalar, kategoriya sahifalari, teglar va qidiruv ishlashini tekshirishdir. Materiallar bir-biri bilan bog'langan, slug'lar noyob va sanalar ketma-ket joylashtirilgan.</p>
HTML;
    }

    private function buildSvgThumbnail(string $title, string $accent, int $index): string
    {
        $safeTitle = htmlspecialchars($title, ENT_QUOTES | ENT_XML1, 'UTF-8');
        $shortTitle = htmlspecialchars(Str::limit($title, 44), ENT_QUOTES | ENT_XML1, 'UTF-8');
        $indexLabel = str_pad((string) $index, 2, '0', STR_PAD_LEFT);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800" width="1200" height="800" role="img" aria-label="{$safeTitle}">
  <defs>
    <linearGradient id="bg" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" stop-color="#111827"/>
      <stop offset="100%" stop-color="{$accent}"/>
    </linearGradient>
  </defs>
  <rect width="1200" height="800" fill="url(#bg)"/>
  <circle cx="980" cy="120" r="180" fill="rgba(255,255,255,0.08)"/>
  <circle cx="200" cy="640" r="220" fill="rgba(255,255,255,0.06)"/>
  <text x="72" y="110" fill="white" font-family="Arial, sans-serif" font-size="34" font-weight="700">ZamonLive</text>
  <text x="72" y="185" fill="white" font-family="Arial, sans-serif" font-size="72" font-weight="800">{$indexLabel}</text>
  <text x="72" y="290" fill="white" font-family="Arial, sans-serif" font-size="42" font-weight="700">{$shortTitle}</text>
  <text x="72" y="360" fill="rgba(255,255,255,0.85)" font-family="Arial, sans-serif" font-size="28">Test kontent</text>
  <text x="72" y="725" fill="rgba(255,255,255,0.72)" font-family="Arial, sans-serif" font-size="22">seed-assets/news/{$indexLabel}.svg</text>
</svg>
SVG;
    }
}
