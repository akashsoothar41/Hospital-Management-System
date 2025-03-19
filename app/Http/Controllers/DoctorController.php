<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Review;
use App\Models\Speciality;
use App\Models\DoctorAttachment;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $appointments = DB::table('appointments')
            ->where('doctor_id', Auth::user()->id) // Ensure you're using the correct patient_id from the authenticated user
            ->whereIn('status', ['booked', 'pending', 'approved'])
            ->select([
                DB::raw('COUNT(DISTINCT patient_id) as patient'),
                DB::raw('COUNT(*) as total_count'),
                DB::raw('COUNT(CASE WHEN status = "booked" THEN 1 END) as booked_count'),
                DB::raw('COUNT(CASE WHEN status = "pending" THEN 1 END) as pending_count'),
            ])
            ->first();
        return view('backend.doctor.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $specialities = Speciality::where('status', '1')->get();
        return view('backend.admin.doctors.create', compact('specialities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

//        return $request->all();
        // Validate the request data
        $data = $request->validate([
            'speciality_id'  => 'required',
            'first_name'  => 'required',
            'last_name'   => 'required',
            'phone_number'=> 'required',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required',
            'fees'        => 'required',
            'address'     => 'required',
            'about'       => 'required',
            'status'      => 'required',
        ]);

        // Hash the password before storing it
        $data['password'] = bcrypt($data['password']);

        // Create a new doctor (user) record
        $doctor = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => $data['password'],
            'status'        => $request->status ?? '1',
            'role'          => 'doctor', // Assuming role 2 is for doctors
        ]);

         $profile = Profile::create([
            'user_id'       => $doctor->id,
            'speciality_id' => $request->speciality_id,
            'fees'          => $request->fees,
            'address'       => $request->address,
            'phone_number'  => $request->phone_number,
        ]);

        $experience = Experience::create([
            'doctor_id'     => $doctor->id,
        ]);

        $education = Education::create([
            'doctor_id'     => $doctor->id,
        ]);

        return redirect()->route('doctors.index')->with([
            'title' => 'Done!',
            'type' => 'success',
            'msg' => 'Doctor added successfully!'
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
    public function edit()
    {
        $user = Auth::user();
        $specialties = Speciality::all();
        return view('backend.doctor.edit_doctor' , [
            'user' => $user,
            'profile' => $user->profile,
            'experiences' => $user->experiences,
            'educations' => $user->educations,
            'specialities' => $user->specialities], compact('specialties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        extract($request->all());
//        return $request->all();
        // Validate the request data
         $validated = $request->validate([
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'email' => 'nullable|email',
            'password' => 'nullable|min:8',
            'age' => 'nullable',
            'speciality_id' => 'required',
            'date_of_birth' => 'nullable',
            'gender' => 'nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
            'emergency_contact' => 'nullable',
            'about' => 'nullable',
            'image' => 'nullable',
            'fees' => 'nullable',
            'work_start_time' => 'nullable',
            'work_end_time' => 'nullable',
            'hospital_name' => 'nullable|array',
            'position' => 'nullable|array',
            'start_date' => 'nullable|array',
            'end_date' => 'nullable|array',
            'university' => 'nullable|array',
            'field' => 'nullable|array',
            'university_start_date' => 'nullable|array',
            'university_end_date' => 'nullable|array',
        ]);

        // Update the user data
        $user = Auth::user();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->role = 'doctor';
        $user->status = '1';

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Save the updated user data
        $user->save();

        // Update the profile
        $profile = $user->profile;  // Using the relationship
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = $user->id;
        }

        $profile->age = $request->input('age');
        $profile->speciality_id = $request->input('speciality_id');
        $profile->date_of_birth = $request->input('date_of_birth');
        $profile->gender = $request->input('gender');
        $profile->phone_number = $request->input('phone_number');
        $profile->address = $request->input('address');
        $profile->emergency_contact = $request->input('emergency_contact');
        $profile->about = $request->input('about');
        $profile->fees = $request->input('fees');
// Handle 24-hour time input and convert it to 12-hour format for display
        $startTime = $request->input('work_start_time'); // Value from the time input field (HH:mm)

        if ($startTime) {
            // Convert from 24-hour format (HH:mm) to 12-hour format (g:i A)
            $profile->start_date = Carbon::createFromFormat('H:i', $startTime)->format('g:i A');
        }

// Handle 24-hour time input for end time
        $endTime = $request->input('work_end_time'); // Value from the time input field (HH:mm)

        if ($endTime) {
            // Convert from 24-hour format (HH:mm) to 12-hour format (g:i A)
            $profile->end_date = Carbon::createFromFormat('H:i', $endTime)->format('g:i A');
        }

// Now save the converted 24-hour formatted time (HH:mm:ss) into the database
        $profile->start_date = Carbon::createFromFormat('H:i', $startTime)->format('H:i:s');
        $profile->end_date = Carbon::createFromFormat('H:i', $endTime)->format('H:i:s');

        // Handle profile image upload
        if ($request->hasFile('image')) {
            $imagePath = $this->storeFile('profiles', $request->image);
            $profile->image = $imagePath;
        }

        // Save the profile data
        $profile->save();

        // Get the education input data (which are arrays)
        $universities = $request->input('university', []);
        $fields = $request->input('field', []);
        $startDates = $request->input('start_date', []);
        $endDates = $request->input('end_date', []);
        $certificates = $request->file('certificate', []); // Assumes 'certificate' contains the uploaded files



        // Get the education input data (which are arrays)
        $universities = $request->input('university', []);
        $fields = $request->input('field', []);
        $startDates = $request->input('start_date', []);
        $endDates = $request->input('end_date', []);
        $certificates = $request->file('certificate', []); // Assumes 'certificate' contains the uploaded files

// Check if the arrays are of the same length
        if (count($universities) !== count($fields) || count($universities) !== count($startDates) || count($universities) !== count($endDates)) {
            return response()->json(['error' => 'The education input arrays are mismatched.'], 400);
        }

        $educationCount = count($universities);

        if ($educationCount > 0) {
            // Iterate through each education entry
            for ($i = 0; $i < $educationCount; $i++) {
                // Get data for the current education entry
                $university = $universities[$i] ?? null;
                $field = $fields[$i] ?? null;
                $startDate = $startDates[$i] ?? null;
                $endDate = $endDates[$i] ?? null;
                $certificateFiles = isset($certificates[$i]) ? $certificates[$i] : []; // Files for the current education entry

                // Validate that required fields are present
                if (!$university || !$field || !$startDate || !$endDate) {
                    return response()->json(['error' => 'Missing required education details for entry ' . ($i + 1)], 400);
                }

                // Check if there's an existing education record, or create a new one
                $education = $user->educations()->where('university', $university)->first();

                if (!$education) {
                    $education = new Education();
                    $education->doctor_id = $user->id;
                }

                // Populate education fields
                $education->university = $university;
                $education->field = $field;
                $education->university_start_date = $startDate;
                $education->university_end_date = $endDate;

                // Handle the certificates if any are provided for this education entry
                if (is_array($certificateFiles) && !empty($certificateFiles)) {
                    // Dynamically store certificate paths in available columns
                    foreach ($certificateFiles as $index => $certificate) {
                        $certificateColumn = 'certificate_' . ($index + 1);

                        // Ensure file is valid before storing
                        if ($certificate->isValid()) {
                            // Store the certificate file and get its path
                            $certificatePath = $this->storeFile('education_attachment', $certificate);

                            // Set the certificate path in the corresponding column
                            $education->$certificateColumn = $certificatePath;
                        } else {
                            return response()->json(['error' => 'Invalid certificate file for education entry ' . ($i + 1)], 400);
                        }
                    }
                }

                // Save the education record
                $education->save();
            }
        }
// Assuming $request->input('hospital_name') is an array for multiple experiences
        $hospitalNames = $request->input('hospital_name', []);
        $positions = $request->input('position', []);
        $startDates = $request->input('start_date', []);
        $endDates = $request->input('end_date', []);

// Ensure all arrays have the same length
        if (count($hospitalNames) !== count($positions) || count($hospitalNames) !== count($startDates) || count($hospitalNames) !== count($endDates)) {
            return response()->json(['error' => 'Input arrays have mismatched lengths.'], 400);
        }

// Loop through each experience and save
        foreach ($hospitalNames as $index => $hospitalName) {
            $experience = new Experience();
            $experience->doctor_id = $user->id;
            $experience->hospital_name = $hospitalName;
            $experience->position = $positions[$index];
            $experience->start_date = $startDates[$index];
            $experience->end_date = $endDates[$index];

            // Save each experience
            $experience->save();
        }

        if (isset($attachments)) {
            foreach ($attachments as $file) {
                $filename = $this->storeFile('doctor_attachments',$file);
                DoctorAttachment::create(['file' => $filename, 'doctor_id'=>$user->id]);
            }
        }
        // Return success message
        return back()->with(['msg' => "Profile updated successfully.", 'title' => 'Done!', 'type' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     */


    public function myProfile()
    {
        $user = Auth::user();
        return view('backend.doctor.my_profile', [
                'user' => $user,
                'profile' => $user->profile
        ]);
    }

    public function doctorAppointmnets()
    {
        // Get the authenticated doctor (assuming the doctor is a user in the 'users' table)
        $doctor = Auth::user();

        // Get all appointments where the doctor_id matches the authenticated doctor's id
        $appointments = Appointment::where('doctor_id', $doctor->id)->get();

        // Return the view with the appointments data
        return view('backend.doctor.doctor_appointments', compact('appointments'));
    }

    public function doctorPatients()
    {
        // Get the authenticated doctor (assuming the doctor is a user in the 'users' table)
        $doctor = Auth::user();

        // Get all appointments where the doctor_id matches the authenticated doctor's id
        $appointments = Appointment::with('patient') // Eager load the patient relationship
        ->where('doctor_id', $doctor->id)
            ->get()
            ->unique('patient_id'); // Filter out duplicates by patient_id

        // Return the view with the appointments data, which includes patient details
        return view('backend.doctor.doctor_patients', compact('appointments'));
    }

    public function updateAppointmentStatus(Request $request)
    {
        $appointmentId = $request->input('appointment_id');
        $status = $request->input('status');

        $appointment = Appointment::find($appointmentId);

        if ($appointment) {
            $appointment->status = $status;
            $appointment->save();

            return response()->json(['title'=>'Done!', 'type'=>'success','msg' => 'Status updated successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Appointment not found']);
    }

    public function doctorReviews()
    {
        $doctor = Auth::user();
//        $review = Review::get();
        $reviews = Review::where('doctor_id', $doctor->id)->with(['patient.profile', 'doctor.profile'])->get(); // Eager load patient and doctor profiles
        return view('backend.doctor.reviews', compact('reviews'));
    }

    public function updateReviewStatus(Request $request)
    {
        $reviewId = $request->input('review_id');
        $status = $request->input('status');

        // Find the review and update the status
        $review = Review::find($reviewId);

        if ($review) {
            $review->status = $status;
            $review->save();

            return response()->json(['title'=>'Done!', 'type'=>'success','msg' => 'Status updated successfully']);
        }

        return response()->json(['msg' => 'Review not found'], 404);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete(); // Soft delete the review

        return redirect()->route('doctor_reviews')->with(['title' => 'Done!', 'type'=>'success', 'msg'=> 'Review deleted successfully']);
    }

    public function viewComments()
    {
        $comments = Comment::get();
        return view('backend.doctor.comments', compact('comments'));
    }

    public function deleteComment($id)
    {
         $comment = Comment::findorFail($id);
         $comment->delete();
         return redirect()->back()->with(['title'=>'Done!', 'type'=>'success', 'msg'=>'Comment deleted successfully']);
    }

    public function updateCommentStatus(Request $request) {
        $validated = $request->validate([
            'comment_id' => 'required|exists:comments,id',
            'status' => 'required|boolean',
        ]);

        $comment = Comment::find($validated['comment_id']);
        if ($comment) {
            $comment->status = $validated['status'];
            $comment->save();

            return response()->json(['title'=>'Done!', 'type'=>'success','msg' => 'Comment status updated successfully!']);
        }

        return response()->json(['msg' => 'Comment not found.'], 404);
    }

    public function blogStatus(Request $request) {
        $validated = $request->validate([
            'blog_id' => 'required|exists:blogs,id',
            'status' => 'required|boolean',
        ]);

        $blog = Blog::find($validated['blog_id']);
        if ($blog) {
            $blog->status = $validated['status'];
            $blog->save();

            return response()->json(['title'=>'Done!', 'type'=>'success','msg' => 'Blog status updated successfully!']);
        }

        return response()->json(['msg' => 'Blog not found.'], 404);
    }
}
