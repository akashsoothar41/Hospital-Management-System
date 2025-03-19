{{-- invoice/show.blade.php --}}
<h3>Invoice Details</h3>
<p>Invoice ID: {{ $invoice->id }}</p>
<p>Amount Due: ${{ $invoice->amount_due / 100 }}</p>
<p>Amount Paid: ${{ $invoice->amount_paid / 100 }}</p>
<p>Status: {{ $invoice->status }}</p>
<p>Created At: {{ \Carbon\Carbon::createFromTimestamp($invoice->created)->toDateString() }}</p>

<!-- You can display the invoice URL here if needed -->
<p><a href="{{ $invoice->hosted_invoice_url }}" target="_blank">View Invoice on Stripe</a></p>
