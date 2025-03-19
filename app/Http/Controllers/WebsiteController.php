<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogTag;
use App\Models\Speciality;
use App\Models\Subscribe;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
class WebsiteController extends Controller
{
    public function websiteDashboard()
    {
        $blogs = Blog::where('status', '1')->get();
        // Get all doctors with their profiles
        $doctors = User::where('role', 'doctor')->with('profile')->get();

        // Fetch all reviews and associate them with the correct doctor
        $reviews = Review::with('patient')->whereIn('doctor_id', $doctors->pluck('id'))->get();

        // Get all specialties
        $specialties = Speciality::all();

        // Return view with doctors, reviews, and specialties
        return view('website.index', compact('doctors', 'specialties', 'reviews', 'blogs'));
    }


    public function doctorProfile(Request $request, $id)
    {
        $users = User::find($id);
        $speciality = $users->profile->speciality;

        // Get reviews where the status is 1 (approved)
        $reviews = Review::with('patient')
            ->where('doctor_id', $users->id) // Filter reviews by doctor_id
            ->where('status', 1)             // Filter reviews where the status is 1
            ->get();

        // Calculate the average rating (assuming the rating is stored as "star-4")
        $averageRating = $reviews->avg(function ($review) {
            return (int) str_replace('star-', '', $review->rating);  // Extract numeric rating from "star-4"
        });

        $reviewCount = $reviews->count();

        if ($speciality) {
            $specialityName = $speciality->name; // Speciality name
            $specialityImage = $speciality->image; // Speciality image
        }

        return view('website.doctor.doctor_profile', compact('users', 'speciality', 'reviews', 'reviewCount', 'averageRating'));
    }


    public function booking( Request $request, $id)
    {
        $doctor = User::find($id);
        return view('website.doctor.booking', compact('doctor'));
    }

    public function policy()
    {
        return view('website.policy');
    }
    public function termCondions()
    {
        return view('website.term_and_condition');
    }
    public function contactUs()
    {
        return view('website.contact_us');
    }

    public function subscribe(Request $request)
    {
         $data = $request->validate([
            'email' => 'required|email'
        ]);

        Subscribe::create($data);

        return redirect()->route('website')->with(['title' => 'success', 'type'=>'Done!', 'msg'=>'You started subscribing DOCCORE']);
    }

    public function bookAppointment(Request $request, $doctor_id)
    {
//         $request->all();
        // Validate incoming data
        $validatedData = $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
        ]);

        // Retrieve the doctor using the doctor_id
        $doctor = User::findOrFail($doctor_id);

        // Convert the start_time and end_time into Carbon instances to validate them properly
        $start_time = Carbon::parse($validatedData['start_time']);
        $end_time = Carbon::parse($validatedData['end_time']);

        // Check if the timeslot is valid
        if ($start_time >= $end_time) {
            return redirect()->with([
                'title' => 'Error!',
                'type' => 'error',
                'msg' => 'The start time must be earlier than the end time.',
            ]);
        }


        // Create the new appointment
        $appointment = new Appointment();
        $appointment->doctor_id = $doctor->id;
        $appointment->patient_id = auth()->id(); // Assuming the user is authenticated
        $appointment->day = $validatedData['day'];
        $appointment->start_time = $start_time->format('H:i');
        $appointment->end_time = $end_time->format('H:i');
        $appointment->status = 'pending'; // Or any other status you want (e.g., 'confirmed' when payment is made)
        $appointment->save();

        // Redirect with success message
        return redirect(url('patient_appointments'))->with([
            'title' => 'Done!',
            'type' => 'success',
            'msg' => 'Your appointment has been booked.',
        ]);
    }

    public function review(Request $request)
    {
        // Validate the incoming data
        $validated = $request->validate([
            'doctor_id' => 'required',
            'rating' => 'required',
            'title' => 'required',
            'review_desc' => 'required',
            'terms_accept' => 'required',
        ]);

        // Create and store the review with the authenticated user's id as patient_id
        $review = new Review();
        $review->patient_id = Auth::id();  // This gets the authenticated user's ID
        $review->doctor_id = $validated['doctor_id'];
        $review->title = $validated['title'];
        $review->description = $validated['review_desc'];
        $review->rating = $validated['rating'];
        $review->terms_accept = $validated['terms_accept'];
        $review->save();

        // Redirect with a success message
        return redirect()->back()->with(['title' => 'Done!', 'type'=>'success', 'msg' =>'Review added successfully!']);
    }

    public function search(Request $request)
    {
        // Capture the search query
        $searchTerm = $request->input('query');

        // Perform the search for doctors, filtering by first_name or last_name
        // and eager loading related data such as profile, attachments, and reviews
        $users = User::where('role', 'doctor')
            ->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchTerm}%");
            })
            ->with(['profile', 'attachments', 'reviews', 'comments'])
            ->get();

        // Return the results to the view
        return view('website.search', compact('users'));
    }

    public function tagBlog($tagId)
    {
        $tags = BlogTag::get();
        $tagBlogs = Blog::whereHas('tags', function ($query) use ($tagId) {
            $query->where('id', $tagId);
        })->get();
        $latestBlogs = Blog::where('status', '1')->get();
        $specialities = Speciality::select('name', \DB::raw('count(blogs.id) as blog_count'))
            ->leftJoin('blogs', 'blogs.speciality_id', '=', 'specialities.id')  // Join blogs table
            ->groupBy('specialities.id', 'specialities.name')  // Group by speciality id and name
            ->get();
        return view('website.tags_blog', compact('tagBlogs', 'latestBlogs', 'tags', 'specialities'));
    }
}
