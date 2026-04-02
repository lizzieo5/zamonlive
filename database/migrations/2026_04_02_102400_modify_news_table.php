<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Add slug column only if it doesn't exist
        if (!Schema::hasColumn('news', 'slug')) {
            Schema::table('news', function (Blueprint $table) {
                $table->string('slug')->nullable()->after('title');
            });

            // Generate slugs for existing news
            $newsItems = DB::table('news')->get();
            foreach ($newsItems as $item) {
                $slug = Str::slug($item->title);
                
                // Make slug unique if duplicates exist
                $count = 1;
                $originalSlug = $slug;
                while (DB::table('news')->where('slug', $slug)->where('id', '!=', $item->id)->exists()) {
                    $slug = $originalSlug . '-' . $count;
                    $count++;
                }
                
                DB::table('news')
                    ->where('id', $item->id)
                    ->update(['slug' => $slug]);
            }

            // Now make slug NOT NULL and unique
            Schema::table('news', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->unique()->change();
            });
        }

        // Rename columns to match model and views
        if (Schema::hasColumn('news', 'content')) {
            Schema::table('news', function (Blueprint $table) {
                $table->renameColumn('content', 'body');
            });
        }
        if (Schema::hasColumn('news', 'image')) {
            Schema::table('news', function (Blueprint $table) {
                $table->renameColumn('image', 'thumbnail');
            });
        }
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('slug');
            
            // Revert renaming if columns exist
            if (Schema::hasColumn('news', 'body')) {
                $table->renameColumn('body', 'content');
            }
            if (Schema::hasColumn('news', 'thumbnail')) {
                $table->renameColumn('thumbnail', 'image');
            }
        });
    }
};
