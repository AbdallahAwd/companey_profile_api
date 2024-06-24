<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return response()->json(Contact::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'adderss' => 'required|string',
            'tel' => 'required|string',
            'email' => 'required|string|email',
            'lat,lng' => 'required|string',
            'type' => 'required|in:enquire,cert,other',
        ]);

        $data = $request->all();

        Contact::create($data);
        return response()->json([
            'status' => true,
            'message' => 'Contact created successfully',
        ], 201);

    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'address' => 'nullable|string',
            'tel' => 'nullable|string',
            'email' => 'nullable|string',
            'latlng' => 'nullable|string',
            'type' => 'nullable|in:enquire,cert,other',
        ]);

        $contact = Contact::find($id); // Corrected typo

        $data = $request->all();
        $contact->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Contact updated successfully',
        ], 200);
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            $contact->delete();
            return response()->json([
                'status' => true,
                'message' => 'Contact deleted successfully',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Contact not found',
            ], 404);
        }
    }
}
