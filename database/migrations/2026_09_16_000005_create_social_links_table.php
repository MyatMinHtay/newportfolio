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
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('url');
            $table->string('icon')->default('bi-link');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index(['is_published', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
