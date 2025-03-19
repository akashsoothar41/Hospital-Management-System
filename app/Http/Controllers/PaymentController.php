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

        try {
            // Create a Stripe Checkout session
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',  // You can change the currency
                            'product_data' => [
                                'name' => 'Doctor Appointment',
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ],
                ],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['session_id' => '{CHECKOUT_SESSION_ID}']),
                'cancel_url' => route('payment.cancel'),
            ]);

            // Retrieve the appointment from the database using the appointment ID
            $appointment = Appointment::find($appointment_id);

            if ($appointment) {
                // Store the invoice details in the appointment record
                $appointment->stripe_invoice_id = $session->id;  // Save Stripe session ID (which is the invoice ID)
                $appointment->amount_due = $doctor_fees;  // Set the amount due (doctor's fees)
                $appointment->amount_paid = 0;  // Initially, amount paid is 0
                $appointment->status = 'booked'; // Invoice status is pending
                $appointment->save();
            }

            // Redirect to Stripe Checkout session
            return redirect()->away($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Payment session creation failed. Please try again.');
        }
    }

    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $sessionId = $request->query('session_id');

        try {
            // Retrieve the session from Stripe
            $session = Session::retrieve($sessionId);

            // Retrieve the appointment using the Stripe session ID stored in the appointment table
            $appointment = Appointment::where('stripe_invoice_id', $session->id)->first();

            if ($appointment) {
                // Update the appointment with the payment information
                $appointment->invoice_status = 'paid';  // Set invoice status to paid
                $appointment->amount_paid = $session->amount_paid / 100;  // Convert cents to dollars

                // Change the status to 'Booked' once payment is successful
                $appointment->status = 'Booked'; // Update the status to "Booked"
                $appointment->save();

                return redirect(url('invoiceView'))->with([
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
//        return 123;
        try {
            // Set the Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

            // Retrieve the invoice using its ID
            $invoice = \Stripe\Invoice::retrieve($invoice_id);  // Use the fully qualified namespace

            if (!$invoice->finalized_at) {
                $invoice->finalizeInvoice();
            }
            // Now you can pass the invoice details to your view or process them further
            return view('backend.patient.invoice.show', compact('invoice'));

        } catch (\Exception $e) {
            return $e->getMessage();
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
