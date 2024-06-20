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
        Schema::create('companey_profile', function (Blueprint $table) {
            $table->id();
            $table->string('company_profile_en');
            $table->string('company_profile_ar');
            $table->string('business_interest_en');
            $table->string('business_interest_ar');
            $table->string('organization_desc_en');
            $table->string('organization_desc_ar');
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
