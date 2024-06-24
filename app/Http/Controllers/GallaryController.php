<?php

namespace App\Http\Controllers;

use App\Models\Gallary;
use Illuminate\Http\Request;

class GallaryController extends Controller
{
    public function index($locale)
    {
        $about = Gallary::all()->map(function ($item) use ($locale) {
            if ($locale == 'ar') {
                $item['title'] = $item['title_ar'];
            } else {
                $item['title'] = $item['title_en'];
            }
            unset($item['title_en']);
            unset($item['title_ar']);
            return $item;
        });
        return response()->json($about);

    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|file',
            'title_ar' => 'required',
            'title_en' => 'required',

        ]);
        $data = $request->all();
        if ($request->hasFile('image')) {
            $image = $data['image'];

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            $imageURL = url('/images/' . $imageName);

            $data['image'] = $imageURL;

        }

        Gallary::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Gallary item created successfully',
        ], 201);

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'file|mimes:jpeg,png,jpg,gif',
        ]);

        $gallary = Gallary::find($id); // Corrected typo

        if ($request->hasFile('image')) {
            $mainImage = $request->file('image');
            $imageName = time() . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->move(public_path('images'), $imageName);
            $imageURL = url('/images/' . $imageName);
            $gallary->image = $imageURL;
            $gallary->save();
            $request['image'] = null;

        }

        $data = $request->except([
            'image',
        ]);
        $gallary->update($data);

        return response()->json([
            'status' => true,
            'message' => 'About updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $gallary = Gallary::find($id);
        if ($gallary) {
            $gallary->delete();
            return response()->json([
                'status' => true,
                'message' => 'Gallary deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Gallary not found',
            ], 404);
        }
    }
}
