<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;
class SpecialityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $specialities = Speciality::get();
        return view('backend.admin.specialities.index', compact('specialities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form fields
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|boolean',
        ]);

        // Handle image upload
        $file = $this->storeFile('specialities', $request->image);
        // Store the data in the database
        Speciality::create([
            'name' => $request->name,
            'image' => $file,  // Store the file path in the database
            'status' => $request->status,
        ]);

        // Redirect or return a response
        return redirect(url('specialities'))->with([
            'title' => 'Done',
            'type' => 'success',
            'msg' => 'Specialty created successfully!',
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $speciality = Speciality::findOrFail($id);
        return view('website.ajax.edit_speciality', compact('speciality'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
//        return $request->all();
        // Validate the form data
        $request->validate([
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg', // Optional image validation
            'status' => 'required'
        ]);

        // Find the specialty by ID (make sure the ID exists)
        $speciality = Speciality::find($request->id);

        if (!$speciality) {
            return back()->withErrors(['message' => 'Specialty not found.']);
        }

        // Update the name and status
        $speciality->name = $request->name;
        $speciality->status = $request->status;

// Check if a new image was uploaded
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($speciality->image && file_exists(public_path('backend/' . $speciality->image))) {
                unlink(public_path('backend/' . $speciality->image));
            }

            // Store the new image using the storeFile helper function
            $imagePath = $this->storeFile('specialties_attachments', $request->image);
            $speciality->image = $imagePath;
        }


        // Save the updated speciality
        $speciality->save();

        // Redirect back with a success message
        return redirect(url('specialities'))->with([ 'title'=>'Done', 'type' => 'success' ,'msg'=>'Specialty updated successfully!']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $speciality = Speciality::find($id);
       $speciality->delete();

       return redirect(url('specialities'))->with(['title' => 'success', 'type' => 'Done!', 'msg' => 'Speciality deleted successfully']);
    }
}
