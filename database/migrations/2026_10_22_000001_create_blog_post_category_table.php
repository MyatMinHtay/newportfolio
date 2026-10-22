<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('blog_post_category')) {
            Schema::create('blog_post_category', function (Blueprint $table) {
                $table->foreignId('blog_post_id')->constrained('blog_posts')->cascadeOnDelete();
                $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
                $table->primary(['blog_post_id', 'category_id']);
                $table->timestamps();
            });
        }

        if (! Schema::hasColumn('blog_posts', 'category_id')) {
            return;
        }

        $now = now();
        $rows = DB::table('blog_posts')
            ->whereNotNull('category_id')
            ->get(['id', 'category_id']);

        foreach ($rows as $row) {
            $alreadyLinked = DB::table('blog_post_category')
                ->where('blog_post_id', $row->id)
                ->where('category_id', $row->category_id)
                ->exists();

            if ($alreadyLinked) {
                continue;
            }

            DB::table('blog_post_category')->insert([
                'blog_post_id' => $row->id,
                'category_id' => $row->category_id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (Schema::getConnection()->getDriverName() === 'sqlite') {
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropIndex(['category_id']);
            });
            Schema::table('blog_posts', function (Blueprint $table) {
                $table->dropConstrainedForeignId('category_id');
            });

            return;
        }

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });

        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('user_id')->constrained('categories')->nullOnDelete();
        });

        $assigned = [];
        foreach (DB::table('blog_post_category')->orderBy('category_id')->get() as $row) {
            if (isset($assigned[$row->blog_post_id])) {
                continue;
            }

            $assigned[$row->blog_post_id] = true;
            DB::table('blog_posts')->where('id', $row->blog_post_id)->update([
                'category_id' => $row->category_id,
            ]);
        }

        Schema::dropIfExists('blog_post_category');
    }
};
