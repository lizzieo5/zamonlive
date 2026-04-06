<?php

namespace Database\Seeders;

use App\Models\Newspaper;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewspaperSeeder extends Seeder
{
    public function run(): void
    {
        $issues = [
            '2026 yil 1-son',
            '2026 yil 2-son',
            '2026 yil 3-son',
            '2026 yil 4-son',
            '2026 yil 5-son',
            '2026 yil 6-son',
            '2026 yil 7-son',
            '2026 yil 8-son',
            '2026 yil 9-son',
            '2026 yil 10-son',
        ];

        Storage::disk('public')->makeDirectory('seed-assets/newspapers');

        foreach ($issues as $index => $issue) {
            $file = 'seed-assets/newspapers/' . str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) . '.pdf';
            $publishedAt = now()->subWeeks($index)->setTime(8, 0);

            Storage::disk('public')->put(
                $file,
                $this->buildPdfPlaceholder($issue, $index + 1)
            );

            $newspaper = Newspaper::create([
                'title' => 'ZamonLive Gazetasi - ' . $issue,
                'file' => $file,
            ]);

            DB::table('newspapers')
                ->where('id', $newspaper->id)
                ->update([
                    'created_at' => $publishedAt,
                    'updated_at' => $publishedAt,
                ]);
        }
    }

    private function buildPdfPlaceholder(string $issue, int $index): string
    {
        $safeIssue = Str::of($issue)->replace(['<', '>', '&'], '')->toString();

        return "ZamonLive Gazette Placeholder\nIssue: {$safeIssue}\nNumber: {$index}\nThis file exists for demo downloads.";
    }
}
