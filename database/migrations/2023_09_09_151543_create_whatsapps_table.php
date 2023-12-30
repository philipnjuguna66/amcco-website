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
        Schema::table('whatsapps', function (Blueprint $table) {

            Schema::disableForeignKeyConstraints();



            $table->dropColumn('location_id');

            $table->string('phone_number')->nullable()->change();

            $table->string('name')->nullable()->change();
            $table->string('avatar')->nullable()->change();

            $table->json('location_tags')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
