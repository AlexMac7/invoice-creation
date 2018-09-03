@extends('layouts.main')

@section('main')
    <style>
        .container {
            margin: 15px 30px;
        }
        .create-payment-form {
            display: grid;
            align-items: center;
            grid-template-columns: 1fr;
        }
        .submit-payment {
            padding: 1.5rem 0;
        }
    </style>
    <div class="container">
        <h1 class="header">Create Payment</h1>
        <form class="create-payment-form" method="POST" action="{{ route('payments.store') }}">
            @csrf
            <div class="payment-section">
                @include('partials.payment-info-rows')
            </div>
            <input id="invoice-id" type="hidden" class="form-control" name="invoice_id" value={{$invoice->id}} />
            <div class="submit-payment">
                <button type="submit" class="create-order-item">
                    Add To Invoice
                </button>
            </div>
        </form>
    </div>
@endsection
