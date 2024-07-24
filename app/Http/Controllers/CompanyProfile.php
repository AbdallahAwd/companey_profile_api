<?php

namespace App\Http\Controllers;

use App\Models\CompaneyProfile;
use App\Models\Contact;
use App\Models\Country;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Stevebauman\Location\Facades\Location;

class CompanyProfile extends Controller
{
    public function index(Request $request, $locale)
    {
        // $ip = $request->ip();
        $ip = "197.40.205.216"; // Example IP
        $details = Location::get($ip);
        $location = $details ? $details->countryCode : 'Unknown';

        $country = Country::firstOrCreate(['country' => $location]);
        $country->increment('number_of_visits');

        $companyProfile = CompaneyProfile::first();
        $workExperiences = WorkExperience::all();
        $contact = Contact::first();

        $output = [
            'company_info' => [
                'id' => $companyProfile->id,
                'main_image' => $companyProfile->main_image,
                'organization_image' => $companyProfile->organization_image,
                'created_at' => $companyProfile->created_at,
                'updated_at' => $companyProfile->updated_at,
            ],
            'work_experience' => [],
            'contact' => [
                'id' => $contact->id,
                'lat_lng' => $contact->lat_lng,
                'created_at' => $contact->created_at,
                'updated_at' => $contact->updated_at,
            ],
        ];

        $output['company_info']['company_profile'] = $companyProfile[$locale === 'ar' ? 'company_profile_ar' : 'company_profile_en'];
        $output['company_info']['business_interest'] = $companyProfile[$locale === 'ar' ? 'business_interest_ar' : 'business_interest_en'];
        $output['company_info']['organization_desc'] = $companyProfile[$locale === 'ar' ? 'organization_desc_ar' : 'organization_desc_en'];

        $output['work_experience'] = $workExperiences->map(function ($experience) use ($locale) {
            return [
                'id' => $experience->id,
                'title' => $experience["title_$locale"],
                'description' => $experience["description_$locale"],
                'image' => $experience->image,
                'created_at' => $experience->created_at,
                'updated_at' => $experience->updated_at,
            ];
        });

        $output['contact'] = $contact->only(['adderss', 'tel', 'email', 'lat,lng', 'type']);

        return response()->json($output);
    }

    public function store(Request $request)
    {
        $request->validate([
            'main_image' => 'required|file',
            'company_profile_en' => 'required',
            'company_profile_ar' => 'required',
            'business_interest_en' => 'required',
            'business_interest_ar' => 'required',
            'organization_desc_en' => 'required',
            'organization_desc_ar' => 'required',
            'organization_image' => 'required|file',
        ]);
        $data = $request->all();
        if ($request->hasFile('main_image') && $request->hasFile('organization_image')) {
            $mainImage = $data['main_image'];
            $organizationImage = $data['organization_image'];
            $imageName = "main_image" . '.' . $mainImage->getClientOriginalExtension();
            $organizationImageName = "organization_image" . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $organizationImage->move(public_path('images'), $organizationImageName);
            $imageURL = url('/images/' . $imageName);
            $organizationImageUrl = url('/images/' . $organizationImageName);
            $data['main_image'] = $imageURL;
            $data['organization_image'] = $organizationImageUrl;

        }

        $profile = CompaneyProfile::all();
        if ($profile->count() >= 1) {
            return response()->json([
                'status' => false,
                'message' => 'Company profile already exists',
            ], 400);
        } else {
            CompaneyProfile::create($data);
            return response()->json([
                'status' => true,
                'message' => 'Company profile created successfully',
            ], 201);
        }

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'main_image' => 'file|mimes:jpeg,png,jpg,gif', // Add mime type and size validation
        ]);

        $profile = CompaneyProfile::find($id); // Corrected typo

        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $imageName = "main_image" . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            // $request['main_image'] = $imageURL;
            $profile->main_image = $imageURL;
            $profile->save();
            $request['main_image'] = null;

        }

        $data = $request->except([
            'main_image',
        ]);
        $profile->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Company profile updated successfully',
        ], 200);
    }

}
