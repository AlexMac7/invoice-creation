@extends('layouts.main')

@section('main')
    <!-- Styles -->
    <style>
        .container {
            margin: 15px 30px;
        }
        .edit-invoice-form {
            display: grid;
            align-items: center;
            grid-template-columns: 1fr;
        }
        .invoice-section {
            padding: 20px 0;
        }
    </style>
    <div class="container">
        <h1 class="header">Edit Invoice</h1>
        <form class="button-holder" method="POST">
            @csrf
            {{ method_field('DELETE') }}
        </form>
        <a class="back-button" href="{{ route('invoices.index') }}"><strong>Return To Index</strong></a>
        <div class="invoice">
            <h3>General Info</h3>
            <form class="edit-invoice-form" method="POST" action="{{ route('invoices.update', $invoice) }}">
                @csrf
                {{ method_field('PATCH') }}
                <div class="invoice-section">
                    @include('partials.general-info-rows')
                </div>
                <div class="submit-invoice">
                    <button type="submit" class="edit-invoice">
                        Edit General Info
                    </button>
                </div>
                <button type="submit" class="delete-button" formaction="{{ route('invoices.delete', $invoice) }}">
                    Delete Invoice
                </button>
            </form>
        </div>
        <div class="order-items">
            <h3>Product(s) Purchased</h3>
            @include('partials.order-items-info-rows')
        </div>
        <div class="payments">
            <h3>Payment(s) Made</h3>
            @include('partials.payments-made-info-rows')
        </div>
    </div>
@endsection
