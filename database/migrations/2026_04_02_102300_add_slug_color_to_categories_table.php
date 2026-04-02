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
        Schema::table('categories', function (Blueprint $table) {
            // Add slug as nullable first (for existing data)
            $table->string('slug')->nullable()->after('name');
            $table->string('color')->nullable()->after('slug');
        });

        // Generate slugs for existing categories
        $categories = DB::table('categories')->get();
        foreach ($categories as $category) {
            $slug = Str::slug($category->name);
            
            // Make slug unique if duplicates exist
            $count = 1;
            $originalSlug = $slug;
            while (DB::table('categories')->where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            
            DB::table('categories')
                ->where('id', $category->id)
                ->update(['slug' => $slug]);
        }

        // Now make slug NOT NULL
        Schema::table('categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['slug', 'color']);
        });
    }
};