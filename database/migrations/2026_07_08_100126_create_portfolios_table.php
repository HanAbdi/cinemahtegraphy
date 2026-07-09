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
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category');
            $table->string('client');
            $table->year('year');
            $table->string('video_url')->nullable();
            $table->text('description');
            $table->string('service_type');
            $table->string('image_path')->nullable();
            $table->json('tags')->nullable();
            $table->string('project_scope')->nullable();
            $table->string('tag_scheme', 1)->default('A');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
