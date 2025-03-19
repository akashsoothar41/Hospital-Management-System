<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Profile;
use App\Models\Speciality;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Blog;
use Auth;

class adminController extends Controller
{
    public function adminDashboard()
    {
        $patients = User::where('role', 'patient')->get()->count();
        $doctors = User::where('role', 'doctor')->get()->count();
        $appointments = Appointment::get()->count();
        return view('backend.admin.index', compact('patients', 'doctors', 'appointments'));
    }

    public function updateStatus(Request $request)
    {
        // Validate input
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'status' => 'required|in:0,1'
        ]);

        // Find the doctor by ID and update the status
        $doctor = User::find($request->doctor_id);
        $doctor->status = $request->status;
        $doctor->save();

        return response(url('doctors'))->with(['title'=> 'success', 'type'=> 'Done!', 'msg' => 'Doctor status updated successfully!']);
    }

    // In SpecialityController.php
// In AdminController.php
    public function updateDoctorStatus(Request $request)
    {
        // Validate the incoming request (ensure the status and doctor id are provided)
        $request->validate([
            'status' => 'required|boolean',
            'doctor_id' => 'required|exists:doctors,id',  // Ensure the doctor exists
        ]);

        // Find the doctor by id
        $doctor = Doctor::find($request->doctor_id);

        if (!$doctor) {
            return response()->json(['success' => false, 'msg' => 'Doctor not found.']);
        }

        // Update the doctor's status
        $doctor->status = $request->status;
        $doctor->save();

        return response()->json(['title'=>'Done!', 'type'=>'success','msg' => 'Status updated successfully!']);
    }



    public function patients()
    {
        $patients = User::where('role', 'patient')->get();
        return view('backend.admin.patients.index', compact('patients'));
    }
    public function allDoctors()
    {
        $doctors = User::where('role', 'doctor')
            ->with(['experiences', 'profile', 'profile.speciality', 'educations', 'speciality']) // eager load related data
            ->get();
        return view('backend.admin.doctors.index' , compact('doctors'));
    }

    public function adminProfile()
    {
        $user = Auth::user();
        return view('backend.admin.profile', compact('user'));
    }


    public function editAdmin()
    {
        $user = Auth::user();
        return view('backend.admin.edit_admin', compact('user'));
    }

    public function update(Request $request)
    {
//         return $request->all();
        $data = $request->validate([
            "first_name" => "nullable",
            "last_name" => "nullable",
            "email" => "nullable",
            "password" => "nullable",
            "age" =>"nullable",
            "date_of_birth" => "nullable",
            "gender" =>"nullable",
            "phone_number" =>"nullable",
            "emergency_contact" => "nullable",
            "address" => "nullable",
            "image" => 'nullable',
            'about' => 'nullable'
        ]);

        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->role = 'Admin';
        $user->status = '1';

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save the updated user data
        $user->save();

        // Update the profile
        $profile = $user->profile ?? new Profile();
        $profile->user_id = $user->id;

        $profile->age = $request->input('age');
        $profile->date_of_birth = $request->input('date_of_birth');
        $profile->gender = $request->input('gender');
        $profile->phone_number = $request->input('phone_number');
        $profile->address = $request->input('address');
        $profile->about = $request->input('about');
        $profile->emergency_contact = $request->input('emergency_contact');

        // Handle profile image upload
        if ($request->hasFile('image')) {
            $imagePath = $this->storeFile('profiles', $request->image);
            $profile->image = $imagePath;
        }

        // Save the profile data
        $profile->save();

        return back()->with([
            'msg' => "Profile updated successfully.",
            'title' => 'Done!',
            'type' => 'success'
        ]);
    }

    public function appointments()
    {
        // Fetch paginated appointments, 10 per page (or any number you'd prefer)
        $appointments = Appointment::get();

        // Return the view with paginated appointments
        return view('backend.admin.appointments', compact('appointments'));
    }


    public function Reviews()
    {
//        $review = Review::get();
        $reviews = Review::with(['patient.profile', 'doctor.profile'])->get(); // Eager load patient and doctor profiles
        return view('backend.admin.reviews', compact('reviews'));
    }

    public function allBlogs()
    {
        $blogs = Blog::get();
        return view('backend.admin.all_blogs', compact('blogs'));
    }


}
