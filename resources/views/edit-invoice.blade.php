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
        <h1 class="header">Edit Invoice ({{$invoice->formatted_status}})</h1>
        <a class="back-button" href="{{ route('invoices.index') }}"><strong>Return To Index</strong></a>
        <div class="invoice">
            <h3>General Info</h3>
            <p>Total: {{$invoice->formatted_total}}</p>
            <form class="edit-invoice-form" method="POST" action="{{ route('invoices.update', $invoice) }}">
                @csrf
                {{ method_field('PATCH') }}
                <div class="invoice-section">
                    @include('partials.general-info-rows')
                </div>
                <div class="submit-invoice">
                    <button type="submit" class="edit-invoice">
                        Update General Info
                    </button>
                </div>
            </form>
            <form class="button-holder" method="POST">
                @csrf
                {{ method_field('DELETE') }}
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
