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
        Schema::create('permalinks', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->nullableMorphs('linkable');
            $table->string('type');
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }
};
