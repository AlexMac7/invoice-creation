@extends('layouts.main')

@section('main')
<style>
    .container {
        margin: 15px 30px;
        display: grid;
        align-items: center;
        grid-template-columns: 1fr;
    }
    .invoice {
        display: grid;
        grid-template-columns: 1fr;
    }
    .product-payment-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .order-items-list, .payments-list {
        border-top: blue 5px solid;
        width: 80%;
    }
</style>
<div class="container">
    <h1 class="header">Invoice #{{$invoice->invoice_number}}</h1>
    <a class="back-button" href="{{ route('invoices.index') }}"><strong>Return To Index</strong></a>
    <div class="invoice">
        <div class="customer-info">
            <p>Invoice Id #{{$invoice->id}}</p>
            <p>Customer Name: {{$invoice->customer->name}}</p>
            <p>Status: {{$invoice->formatted_status}}</p>
            <p>Date Issued: {{$invoice->created_at->toFormattedDateString()}}</p>
            <p>Invoice Payment Due Date: {{$invoice->due_date->toFormattedDateString()}}</p>
        </div>
        <div class="product-payment-info">
            <div class="product-info">
                <h4>Products</h4>
                @foreach($orderItems as $item)
                    <div class="order-items-list">
                        <p>Product Name: {{$item->product_name}}</p>
                        <p>Quantity: {{$item->quantity}}</p>
                        <p>Price: {{$item->formatted_price}}</p>
                        <p>Tax: {{$item->formatted_tax}}</p>
                    </div>
                @endforeach
            </div>
            <div class="payment-info">
                <h4>Payments</h4>
                @foreach($payments as $payment)
                    <div class="payments-list">
                        <p>Payment Type: {{$payment->type}}</p>
                        <p>Amount: {{$payment->formatted_amount}}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <h4>Total</h4>
        <div class="totals-info">
            <p>Subtotal: {{$invoice->formatted_subtotal}}</p>
            <p>Tax: {{$invoice->formatted_tax}}</p>
            <p>Total: {{$invoice->formatted_total}}</p>
        </div>
    </div>
</div>
@endsection
