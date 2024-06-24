<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required',
            'title_ar' => 'required',
            'description_en' => 'required',
            'description_ar' => 'required',
            'image' => 'required|file',
        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $data['image'];

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $imageURL = url('/images/' . $imageName);

            $data['image'] = $imageURL;

        }

        WorkExperience::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Work Experience Added successfully',
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,gif',
        ]);

        $work = WorkExperience::find($id); // Corrected typo

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            $work->image = $imageURL;
            $work->save();
            $request['image'] = null;

        }

        $data = $request->except([
            'image',
        ]);
        $work->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Work Expereince Item updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $we = WorkExperience::find($id);
        if ($we) {
            $we->delete();
            return response()->json([
                'status' => true,
                'message' => 'Work Experience deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gallary not found',
            ], 404);
        }
    }
}
