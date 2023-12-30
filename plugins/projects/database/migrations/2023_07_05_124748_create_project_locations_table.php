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
        Schema::create('project_branches', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Appsorigin\Plots\Models\Location::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Appsorigin\Plots\Models\Project::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_branches');
    }
};
