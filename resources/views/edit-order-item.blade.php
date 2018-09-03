@extends('layouts.main')

@section('main')
    <style>
    </style>
    <div class="container">
        <h1 class="header">Edit Order Item</h1>
        <form class="edit-order-item-form" method="POST">
            @csrf
            {{ method_field('PATCH') }}
            <div class="item-name-row">
                <label for="item-name">Product Name</label>
                <input id="item-name" type="text" class="form-control" name="product_name" readonly="readonly" value={{$orderItem->product_name}} />
            </div>
            <div class="item-quantity-row">
                <label for="item-quantity">Quantity*</label>
                <input id="item-quantity" type="number" class="form-control" name="quantity" value={{$orderItem->quantity}} />
            </div>
            <div class="item-price-row">
                <label for="item-price">Price* ($)</label>
                <input id="item-price" type="number" step="0.01" class="form-control" name="price" value={{$orderItem->price / 100}} />
            </div>
            <div class="item-tax-row">
                <label for="item-tax">Tax*</label>
                <input id="item-tax" type="number" class="form-control" name="tax" value={{$orderItem->tax}} />
            </div>
            <button type="submit" class="delete-button" formaction="{{ route('order-items.update', $orderItem) }}">
                Update Order Item
            </button>
        </form>
    </div>
@endsection
