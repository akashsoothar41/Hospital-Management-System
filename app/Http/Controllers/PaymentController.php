<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Invoice;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request, $doctor_fees, $appointment_id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    
        $amount = $doctor_fees * 100; // Convert to cents for Stripe
        $appointment = Appointment::find($appointment_id);
        try {
            // Create a Stripe Checkout session
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Doctor Appointment',
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['session_id' => '{CHECKOUT_SESSION_ID}', 'appointmentId' => $appointment->id]),
                'cancel_url' => route('payment.cancel'),
            ]);
    
            // Get the session ID
            $sessionId = $session->id;
    
            // Redirect to Stripe Checkout session, replacing the placeholder with the actual session ID
            $successUrl = route('payment.success', ['session_id' => $sessionId, 'appointmentId' => $appointment->id]);
    
            // Create the session with the updated success URL
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => 'Doctor Appointment',
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => $successUrl,  // Use the updated success URL with the session ID
                'cancel_url' => route('payment.cancel'),
            ]);
    
            // Redirect to Stripe Checkout session URL
            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment session creation failed. Please try again.');
        }
    }
    
    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    
        $sessionId = $request->query('session_id');
        $appointmentId = $request->query('appointmentId');
    
        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            $appointment = Appointment::find($appointmentId);
    
            if ($appointment) {
                $appointment->stripe_invoice_id = $sessionId;
                $appointment->invoice_status = 'paid';
                $appointment->amount_paid = $session->amount_total / 100;
                $appointment->status = 'booked';
                $appointment->save();
    
                return redirect()->route('invoice_view', ['invoice_id' => $sessionId])->with([
                    'title' => 'Done!',
                    'type' => 'success',
                    'msg' => 'Payment Done'
                ]);
            } else {
                return redirect(url('patient_appointments'))->with([
                    'title' => 'Error!',
                    'type' => 'Error',
                    'msg' => 'Payment failed'
                ]);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Payment verification failed. Please try again.');
        }
    }
    
    

    public function paymentCancel(Request $request)
    {
        // Handle the cancellation (e.g., show a message or retry)
        return view('backend.patient.appointments')->with([
            'title' => 'Error!',
            'type' => 'Error',
            'msg' => 'Payment failed'
        ]);
    }
    public function invoiceView($invoice_id)
    {
        try {
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    
            // Retrieve the appointment using the stripe_invoice_id (session_id)
            $appointment = Appointment::where('stripe_invoice_id', $invoice_id)->first();
    
            if (!$appointment) {
                return redirect()->route('patient_appointments')->with('error', 'Appointment not found.');
            }
    
            // Retrieve the Stripe session object using the session ID stored in the appointment
            $session = \Stripe\Checkout\Session::retrieve($appointment->stripe_invoice_id);
    
            // Now, you can get the invoice associated with the session
            $invoiceId = $session->invoice;
            $invoice = \Stripe\Invoice::retrieve($invoiceId);
    
            if (!$invoice->finalized_at) {
                $invoice->finalizeInvoice();
            }
    
            return view('backend.patient.invoice.show', compact('invoice'));
    
        } catch (\Exception $e) {
            return back()->with('error', 'Could not retrieve the invoice. Please try again.');
        }
    }
    

    public function handleStripeWebhook(Request $request)
    {
        // You can use the stripe-php library to handle the webhook
        $payload = @file_get_contents('php://input');
        $event = null;

        try {
            $event = \Stripe\Event::constructFrom(json_decode($payload, true));
        } catch (\Exception $e) {
            return response('Webhook Error: ' . $e->getMessage(), 400);
        }

        // Check for the 'invoice.payment_succeeded' event
        if ($event->type === 'invoice.payment_succeeded') {
            $invoice = $event->data->object; // Contains the invoice object

            // Access the invoice's PDF URL
            $pdfUrl = $invoice->invoice_pdf;

            // You can now download and store the invoice as mentioned earlier
            // (Save the PDF to your server, store the file URL in the database, etc.)
        }

        return response('Webhook received successfully', 200);
    }

    public function downloadInvoice($invoiceId)
    {
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Fetch the invoice by ID
            $invoice = Invoice::retrieve($invoiceId);

            // Ensure invoice is finalized
            if ($invoice && isset($invoice->invoice_pdf)) {
                // Get the invoice PDF URL
                $pdfUrl = $invoice->invoice_pdf;

                // Download the PDF content
                $pdfContent = file_get_contents($pdfUrl);

                // Save the PDF file to local storage or public storage
                $filePath = storage_path("app/public/invoices/invoice_{$invoiceId}.pdf");
                file_put_contents($filePath, $pdfContent);

                // Optionally, store this in the database for later reference
                $this->storeInvoiceInDatabase($invoice, $filePath);

                return response()->download($filePath);
            } else {
                return response()->json(['error' => 'Invoice PDF not available'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function storeInvoiceInDatabase($invoice, $filePath)
    {
        // Store the invoice data in your database
        Appointment::create([
            'stripe_invoice_id' => $invoice->id,
            'user_id' => auth()->id(),
            'invoice_url' => $filePath,
            'amount' => $invoice->amount_paid / 100,
            'status' => $invoice->status,
            'pdf_url' => $invoice->invoice_pdf,
        ]);
    }

}
