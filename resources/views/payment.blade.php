@extends('website.layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form id="payment-form">
                <div id="card-element"></div>
                <button id="submit">Pay</button>
                <p id="error-message"></p>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        const stripe = Stripe('your_publishable_key'); // Use your Stripe publishable key
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit');
        const errorMessage = document.getElementById('error-message');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            // Call your backend to create a payment intent
            const response = await fetch('/create-payment-intent', {
                method: 'POST',
            });

            const { clientSecret, error } = await response.json();

            if (error) {
                errorMessage.textContent = error;
                return;
            }

            const { paymentIntent, error: stripeError } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                }
            });

            if (stripeError) {
                errorMessage.textContent = stripeError.message;
            } else if (paymentIntent.status === 'succeeded') {
                alert('Payment successful!');
            }
        });
    </script>

@endpush
