<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaneyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_image',
        'company_profile_en',
        'company_profile_ar',
        'business_interest_en',
        'business_interest_ar',
        'organization_desc_en',
        'organization_desc_ar',
        'organization_image',
    ];
}
