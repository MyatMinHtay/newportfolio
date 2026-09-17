<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary');
            $table->longText('body')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('project_url')->nullable();
            $table->string('repo_url')->nullable();
            $table->string('video_url')->nullable();
            $table->json('tech_stack')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(true);
            $table->integer('sort_order')->default(0);
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
            $table->index(['is_featured', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
