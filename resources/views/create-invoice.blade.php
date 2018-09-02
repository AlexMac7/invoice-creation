@extends('layouts.main')

<!-- Styles -->
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
</style>
{{--todo--}}
<div class="container">
    <h1 class="header">Create Invoice</h1>
    <div class="invoice">
        <form class="create-invoice-form" method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <div class="invoice-section">
                @include('partials.general-info-rows')
            </div>
            <div class="invoice-section">
                @include('partials.product-info-rows')
            </div>
            <div class="invoice-section">
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

