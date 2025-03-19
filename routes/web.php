<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpecialityController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\BlogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(url('website'));
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('admin', [AdminController::class, 'adminDashboard'])->name('admin');
//Speciality Routes
Route::resource('specialities', SpecialityController::class);
Route::resource('doctors', DoctorController::class);
Route::resource('blogs', BlogController::class);
Route::post('update-blog-status', [DoctorController::class, 'blogStatus'])->name('update-blog-status');

Route::post('/update-doctor-status', [AdminController::class, 'updateStatus'])->name('update-doctor-status');
Route::get('all_patients', [AdminController::class, 'patients'])->name('all_patients');
Route::get('all_doctors', [AdminController::class, 'allDoctors'])->name('all_doctors');
Route::get('edit_admin', [AdminController::class, 'editAdmin'])->name('edit_admin');
Route::post('admin_update', [AdminController::class, 'update'])->name('admin_update');
Route::get('appointments', [AdminController::class, 'appointments'])->name('appointments');
Route::post('/update-speciality-status/{id}', [AdminController::class, 'updateSpecialityStatus'])->name('speciality.updateStatus');
Route::get('admin_profile', [AdminController::class, 'adminProfile'])->name('admin_profile');
Route::get('reviews', [AdminController::class, 'Reviews'])->name('reviews');
Route::get('all_blogs', [AdminController::class, 'allBlogs'])->name('all_blogs');


Route::get('my_profile', [DoctorController::class, 'myProfile'])->name('my_profile');
Route::get('edit_doctor', [DoctorController::class, 'edit'])->name('edit_doctor');
Route::post('update_profile', [DoctorController::class, 'update'])->name('update_profile');
Route::get('doctor_appointments', [DoctorController::class, 'doctorAppointmnets'])->name('doctor_appointments');
Route::get('doctor_patients', [DoctorController::class, 'doctorPatients'])->name('doctor_patients');
Route::post('/update-appointment-status', [DoctorController::class, 'updateAppointmentStatus'])->name('update.appointment.status');
Route::get('doctor_reviews', [DoctorController::class, 'doctorReviews'])->name('doctor_reviews');
Route::post('/update-review-status', [DoctorController::class, 'updateReviewStatus']);
Route::delete('destroy/{id}', [DoctorController::class, 'destroy'])->name('destroy');
Route::get('view_comments', [DoctorController::class, 'viewComments'])->name('view_comments');
Route::delete('delete_comment/{id?}', [DoctorController::class, 'deleteComment'])->name('delete_comment');
Route::post('/update-comment-status', [DoctorController::class, 'updateCommentStatus']);



Route::get('patient', [PatientController::class, 'patientDashboard'])->name('patient');
Route::get('patient_profile', [PatientController::class, 'patientProfile'])->name('patient_profile');
Route::get('edit_patient', [PatientController::class, 'editProfile'])->name('edit_patient');
Route::post('patient_update', [PatientController::class, 'update'])->name('patient_update');
Route::get('patient_appointments', [PatientController::class, 'patientAppointment'])->name('patient_appointments');
Route::post('/payment/process', [PatientController::class, 'processPayment'])->name('payment.process');
Route::get('blog_detail/{id?}', [PatientController::class, 'blogDetail'])->name('blog_detail');
Route::post('comment', [PatientController::class, 'comment'])->name('comment');

Route::get('/', [WebsiteController::class, 'websiteDashboard'])->name('website');
Route::get('booking/{id}', [WebsiteController::class, 'booking'])->name('booking');
Route::get('policy',[WebsiteController::class, 'policy'])->name('policy');
Route::get('term_conditions',[WebsiteController::class, 'termCondions'])->name('term_conditions');
Route::get('contact_us',[WebsiteController::class, 'contactUs'])->name('contact_us');
Route::get('doctor_profile/{id}', [WebsiteController::class, 'doctorProfile'])->name('doctor_profile');
Route::post('subscribe', [WebsiteController::class, 'subscribe'])->name('subscribe');
Route::post('review', [WebsiteController::class, 'review'])->name('review');
Route::post('/appointments/book/{doctor_id}', [WebsiteController::class, 'bookAppointment'])->name('book_appointment');
Route::get('search', [WebsiteController::class, 'search'])->name('search');
Route::get('tag-blogs/{id?}', [WebsiteController::class, 'tagBlog'])->name('tag-blogs');




Route::get('/create-payment-intent/{doctor_fees}/{appointment_id}', [PaymentController::class, 'createPaymentIntent'])->name('create-payment-intent');
//Route::post('/payment-intent/{doctor_fees}/{appointment_id}', [PaymentController::class, 'createPaymentIntent']);
Route::get('/invoice_view/{invoice_id}', [PaymentController::class, 'invoiceView'])->name('invoice_view');

// Success and cancel routes for Stripe
Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');

//Auth::routes();
require __DIR__.'/auth.php';

//
//Route::get('testing',function(){
//    return bcrypt('nmdp7788');
//});
