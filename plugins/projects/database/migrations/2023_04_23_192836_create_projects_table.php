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

            $table->string('name')->fulltext();
            $table->string('status')->default('for sale');
            $table->string('price');
            $table->text('body')->nullable();
            $table->text('amenities');
            $table->string('featured_image');
            $table->string('video_path')->nullable();
            $table->json('gallery')->nullable();
            $table->string('meta_title');
            $table->text('map')->nullable();
            $table->string('mutation')->nullable();
            $table->string('meta_description');
            $table->timestamps();
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
