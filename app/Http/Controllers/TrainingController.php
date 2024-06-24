<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index($locale)
    {
        $train = Training::all()->map(function ($item) use ($locale) {
            if ($locale == 'ar') {
                $item['description'] = $item['description_ar'];
            } else {
                $item['description'] = $item['description_en'];
            }
            unset($item['description_en']);
            unset($item['description_ar']);
            return $item;
        });
        return response()->json($train);

    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
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

        Training::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Training Card Created Successfully',
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,gif',
        ]);

        $train = Training::find($id); // Corrected typo

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            $train->image = $imageURL;
            $train->save();
            $request['image'] = null;

        }

        $data = $request->except([
            'image',
        ]);
        $train->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Training Card updated successfully',
        ], 200);
    }
}
