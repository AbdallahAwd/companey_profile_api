<?php

namespace App\Http\Controllers;

use App\Models\Approved;
use Illuminate\Http\Request;

class ApprovedController extends Controller
{
    public function index()
    {
        return response()->json(Approved::all());
    }

    public function store(Request $request)
    {
        $request->validate([
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

        Approved::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Brand Added successfully',
        ], 201);

    }

    public function destroy($id)
    {
        $approved = Approved::find($id);
        if ($approved) {
            $approved->delete();
            return response()->json([
                'status' => true,
                'message' => 'Brand deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Brand not found',
            ], 404);
        }
    }
}
