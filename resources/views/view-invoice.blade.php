@extends('layouts.main')
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
    .info {

    }
</style>
{{--todo--}}
<div class="container">
    <h1 class="header">Invoice #{{$invoice->id}}</h1>
    <div class="invoice">
        <div class="info">
            <p>Customer Name: {{$invoice->id}}</p>
            <p>Customer Address: {{$invoice->id}}</p>
            <p>Invoice Date: {{$invoice->id}}</p>
            <p>Invoice Number: {{$invoice->id}}</p>
            <p>Invoice Payment Due Date: {{$invoice->id}}</p>
            <p>Invoice Note: {{$invoice->id}}</p>
        </div>
    </div>
</div>

