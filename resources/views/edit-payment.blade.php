@extends('layouts.main')

@section('main')
    <style>
    </style>
    <div class="container">
        <h1 class="header">Edit Payment</h1>
        <form class="edit-payment-form" method="POST">
            @csrf
            {{ method_field('PATCH') }}
            <div class="payment-type-row">
                <label for="type">Payment Type</label>
                <input id="type" type="text" class="form-control" name="payment_type" value={{$payment->type}} />
            </div>
            <div class="payment-amount-row">
                <label for="amount">Amount* ($)</label>
                <input id="amount" type="number" step="0.01" class="form-control" name="amount" value={{$payment->amount / 100}} />
            </div>
            <button type="submit" class="delete-button" formaction="{{ route('payments.update', $payment) }}">
                Update Payment
            </button>
        </form>
    </div>
@endsection
