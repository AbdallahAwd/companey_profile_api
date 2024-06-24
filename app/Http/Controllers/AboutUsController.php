<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index($locale)
    {
        $about = AboutUs::all()->map(function ($item) use ($locale) {
            if ($locale == 'ar') {
                $item['role'] = $item['role_ar'];
                $item['description'] = $item['description_ar'];
            } else {
                $item['role'] = $item['role_en'];
                $item['description'] = $item['description_en'];
            }
            unset($item['role_en']);
            unset($item['role_ar']);
            unset($item['description_en']);
            unset($item['description_ar']);
            return $item;
        });
        return response()->json($about);
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
            'role_ar' => 'required',
            'role_en' => 'required',
            'description_ar' => 'required',
            'description_en' => 'required',

        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $data['image'];

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $imageURL = url('/images/' . $imageName);

            $data['image'] = $imageURL;

        }

        AboutUs::create($data);
        return response()->json([
            'status' => true,
            'message' => 'About us created successfully',
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,gif',
        ]);

        $about = AboutUs::find($id); // Corrected typo

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            $about->image = $imageURL;
            $about->save();
            $request['image'] = null;

        }

        $data = $request->except([
            'image',
        ]);
        $about->update($data);

        return response()->json([
            'status' => true,
            'message' => 'About updated successfully',
        ], 200);
    }
}
