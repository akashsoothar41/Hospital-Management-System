<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\Profile;
use App\Models\Speciality;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;
use DB;

class PatientController extends Controller
{
    public function patientDashboard()
    {
//       return $patient_id = Auth::user()->id;
        $appointments = DB::table('appointments')
            ->where('patient_id', Auth::user()->id) // Ensure you're using the correct patient_id from the authenticated user
            ->whereIn('status', ['booked', 'pending', 'approved'])
            ->select([
                DB::raw('COUNT(*) as total_count'),
                DB::raw('COUNT(CASE WHEN status = "booked" THEN 1 END) as booked_count'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count'),
                DB::raw('COUNT(CASE WHEN status = "approved" THEN 1 END) as approved_count')
            ])
            ->first();
        return view('backend.patient.index', compact('appointments'));
    }

    public function patientProfile()
    {
        // Fetch authenticated user
        $user = Auth::user();
        return view('backend.patient.my_profile', [
            'user' => $user,
            'profile' => $user->profile
        ]);
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('backend.patient.edit_profile', [
            'user' => $user,
            'profile' => $user->profile]);
    }
    public function update(Request $request)
    {
//        return $request->all();
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
        ]);

        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->role = 'patient';
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

    public function patientAppointment()
    {
        // Get the authenticated doctor (assuming the doctor is a user in the 'users' table)
        $patient = Auth::user();

        // Get all appointments where the doctor_id matches the authenticated doctor's id
        $appointments = Appointment::with('doctor') // Eager load the patient relationship
        ->where('patient_id', $patient->id)
            ->get();
        // Return the view with the appointments data, which includes patient details
        return view('backend.patient.appointments', compact('appointments'));
    }

    public function processPayment(Request $request)
    {
        // Validate the payment details
     return   $request->validate([
            'doctot_id' => 'required',
            'amount' => 'required|numeric',
            'payment_method' => 'required',
            'transaction_id' => 'required',
            'payment_date' => 'required|date',
        ]);

        // Process the payment logic here (e.g., saving the payment record)

        // Redirect or return response after processing
        return redirect()->route('appointments')->with('success', 'Payment processed successfully.');
    }

    public function blogDetail(Request $request, $id)
    {
        $blogsDetail = Blog::findorFail($id);
        $specialities = Speciality::select('name', \DB::raw('count(blogs.id) as blog_count'))
            ->leftJoin('blogs', 'blogs.speciality_id', '=', 'specialities.id')  // Join blogs table
            ->groupBy('specialities.id', 'specialities.name')  // Group by speciality id and name
            ->get();
        $latestBlogs = Blog::where('status', '1')->get();
        $tags = BlogTag::get();
        $comments = Comment::where('blog_id', $id)
            ->Where('status', '1')
            ->get();
        $commentCount = $comments->count();
        return view('website.blog_detail', compact('specialities', 'tags', 'latestBlogs', 'blogsDetail', 'comments', 'commentCount'));
    }


    public function comment(Request $request)
    {
        // Validate the incoming request
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:500',
            'blog_id' => 'required|exists:blogs,id', // Ensure the blog_id exists in the blogs table
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Add user_id to the input data
        $input['user_id'] = $user->id;

        // Create a new comment with validated data
        $comment = Comment::create($input);

        // Redirect to the blog detail page with a success message
        return redirect()->back()
            ->with([
                'title' => 'Done!',
                'type' => 'success',
                'msg' => 'Comment added successfully'
            ]);
    }

}
