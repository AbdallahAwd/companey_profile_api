<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    public function index($locale)
    {
        $inspect = Inspection::all()->map(function ($item) use ($locale) {
            if ($locale == 'ar') {
                $item['title'] = $item['title_ar'];
                $item['description'] = $item['description_ar'];
            } else {
                $item['title'] = $item['title_en'];
                $item['description'] = $item['description_en'];
            }
            unset($item['title_en']);
            unset($item['title_ar']);
            unset($item['description_en']);
            unset($item['description_ar']);
            return $item;
        });
        return response()->json($inspect);

    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
            'title_ar' => 'required',
            'title_en' => 'required',
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

        Inspection::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Certificate created successfully',
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,gif',
        ]);

        $inspect = Inspection::find($id); // Corrected typo

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            $inspect->image = $imageURL;
            $inspect->save();
            $request['image'] = null;

        }

        $data = $request->except([
            'image',
        ]);
        $inspect->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Certificates updated successfully',
        ], 200);
    }

}
