@extends('layouts.main')

@section('main')
    <style>
        .container {
            margin: 15px 30px;
        }
        .create-order-item-form {
            display: grid;
            align-items: center;
            grid-template-columns: 1fr;
        }
        .submit-order-item {
            padding: 1.5rem 0;
        }
    </style>
    <div class="container">
        <h1 class="header">Create Order Item</h1>
        <form class="create-order-item-form" method="POST" action="{{ route('order-items.store') }}">
            @csrf
            <div class="product-section">
                @include('partials.product-info-rows')
            </div>
            <input id="invoice-id" type="hidden" class="form-control" name="invoice_id" value={{$invoice->id}} />
            <div class="submit-order-item">
                <button type="submit" class="create-order-item">
                    Add To Invoice
                </button>
            </div>
        </form>
    </div>
@endsection
