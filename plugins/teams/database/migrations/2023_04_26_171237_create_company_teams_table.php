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
        Schema::create('company_teams', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('name');
            $table->string('featured_image')->nullable();
            $table->longText('body')->nullable();
            $table->json('socials')->nullable();
            $table->timestamps();
        });


        Schema::create('company_team_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Appsorigin\Teams\Models\CompanyTeam::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignIdFor(\Appsorigin\Teams\Models\TeamCategory::class)
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_team_categories');
        Schema::dropIfExists('company_teams');
    }
};
