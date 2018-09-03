@extends('layouts.main')

@section('main')
<style>
    .container {
        margin: 15px 30px;
    }
    .create-invoice-form {
        display: grid;
        align-items: center;
        grid-template-columns: 1fr;
    }
    .invoice-section {
        padding: 20px 0;
    }
    .submit-invoice {
        padding: 1.5rem 0;
    }
</style>
<div class="container">
    <h1 class="header">Create Invoice</h1>
    <a class="back-button" href="{{ route('invoices.index') }}"><strong>Return To Index</strong></a>
    <div class="invoice">
        <form class="create-invoice-form" method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <div class="invoice-section">
                @include('partials.general-info-rows')
            </div>
            <div class="product-section">
                @include('partials.product-info-rows')
            </div>
            <div class="payment-section">
                @include('partials.payment-info-rows')
            </div>
            <div class="submit-invoice">
                <button type="submit" class="create-invoice">
                    {{ __('Create') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
