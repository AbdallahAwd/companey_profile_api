<?php

namespace App\Http\Controllers;

use App\Models\CompaneyProfile;
use App\Models\Contact;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class CompanyProfile extends Controller
{
    public function index()
    {
        $output = [];
        $output['company_info'] = CompaneyProfile::first();
        $output['work_experience'] = WorkExperience::all();
        $output['contact'] = Contact::first();
        return $output;
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_image' => 'required',
            'company_profile_en' => 'required',
            'company_profile_ar' => 'required',
            'business_interest_en' => 'required',
            'business_interest_ar' => 'required',
            'organization_desc_en' => 'required',
            'organization_desc_ar' => 'required',
            'organization_image' => 'required',
        ]);
        $profile = CompaneyProfile::all();
        if ($profile->count() > 1) {
            return response()->json([
                'status' => false,
                'message' => 'Company profile already exists',
            ], 400);
        } else {
            CompaneyProfile::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Company profile created successfully',
            ], 201);
        }

    }

    public function update(Request $request, $id)
    {

        $profile = CompaneyProfile::find($id);
        $profile->update($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Company profile updated successfully',
        ], 200);
    }
}
