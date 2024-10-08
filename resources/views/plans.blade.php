@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center " style="margin-top:5%">


            <div class="col col-lg-3 col-md-4 col-sm-8 m-2 " align="center"><div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('assets/img/aijob.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Silver</h5>
                    <p class="card-text">2 Lettres de motivation </p>
                    <p class="card-text">2 Textes TCF </p>
                    <p class="card-text">2 Textes IELTS </p>
                    <a href="{{ route('paiement', ['id' => 1]) }}" class="btn btn-primary border-0" style="background-color: purple;color:#f0d419;">Prix 1 Pi</a>
                </div>
            </div></div>
            <div class="col col-lg-3 col-md-4 col-sm-8 m-2 " align="center"><div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('assets/img/aijob2.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Gold</h5>
                    <p class="card-text">5 Lettres de motivation </p>
                    <p class="card-text">5 Textes TCF </p>
                    <p class="card-text">5 Textes IELTS </p>
                    <a href="{{ route('paiement', ['id' => 2]) }}" class="btn btn-primary border-0" style="background-color: purple;color:#f0d419;">Prix 2 Pi</a>
                </div>
            </div></div>
            <div class="col col-lg-3 col-md-4 col-sm-8 m-2 " align="center"><div class="card" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('assets/img/aijob3.jpg') }}" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Diamant</h5>
                    <p class="card-text">15 Lettres de motivation </p>
                    <p class="card-text">15 Textes TCF </p>
                    <p class="card-text">15 Textes IELTS </p>
                    <a href="{{ route('paiement', ['id' => 3]) }}" class="btn btn-primary border-0" style="background-color: purple;color:#f0d419;">Prix 5 Pi</a>
                </div>
            </div></div>

    </div>
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-4 col-sm-2">
            <div class="alert alert-indigo bg-indigo text-center " style="background-color:purple; margin-top:5%" >
                <p class="m-0 fs-5" style="color:#f0d419;">Paiement uniquement avec PI</p>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://sdk.minepi.com/pi-sdk.js"></script>
<script>Pi.init({ version: "2.0", sandbox: true })</script>
{{-- <script>
    // Authenticate the user, and get permission to request payments from them:
    const scopes = ['payments'];

    Pi.createPayment({
    // Amount of π to be paid:
    amount: 3.14,
    // An explanation of the payment - will be shown to the user:
    memo: "...", // e.g: "Digital kitten #1234",
    // An arbitrary developer-provided metadata object - for your own usage:
    metadata: { /* ... */ }, // e.g: { kittenId: 1234 }
    }, {
    // Callbacks you need to implement - read more about those in the detailed docs linked below:
    onReadyForServerApproval: function(paymentId) { /* ... */ },
    onReadyForServerCompletion: function(paymentId, txid) { /* ... */ },
    onCancel: function(paymentId) { /* ... */ },
    onError: function(error, payment) { /* ... */ },
    });

    // Read more about this callback in the SDK reference:
    function onIncompletePaymentFound(payment) { /* ... */ };
    Pi.authenticate(scopes, onIncompletePaymentFound).then(function(auth) {
    console.log(`Hi there! You're ready to make payments!`);
    }).catch(function(error) {
    console.error(error);
    });
</script> --}}

@endpush
