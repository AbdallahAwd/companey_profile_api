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
        Schema::create('companey_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('main_image');
            $table->text('company_profile_en');
            $table->text('company_profile_ar');
            $table->text('business_interest_en');
            $table->text('business_interest_ar');
            $table->text('organization_desc_en');
            $table->text('organization_desc_ar');
            $table->string('organization_image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companey_profiles');
    }
};
