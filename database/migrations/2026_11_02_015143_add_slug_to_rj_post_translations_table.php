<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rj_post_translations', function (Blueprint $table) {
            $table->string('slug', 255)->nullable()->after('locale');
            $table->index('slug');
        });

        $posts = DB::table('rj_posts')->whereNotNull('slug')->get(['id', 'slug']);

        foreach ($posts as $post) {
            DB::table('rj_post_translations')
                ->where('post_id', $post->id)
                ->whereNull('slug')
                ->update(['slug' => $post->slug]);
        }
    }

    public function down(): void
    {
        Schema::table('rj_post_translations', function (Blueprint $table) {
            $table->dropIndex(['slug']);
            $table->dropColumn('slug');
        });
    }
};
