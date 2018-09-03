<style>
    .order-items-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .order-item-info-row {
        padding: .25rem 0;
    }
</style>

@php
    $orderItemsPresent = $orderItems->isNotEmpty();
@endphp

<div class="order-items-info">
    @if($orderItemsPresent)
        @foreach($orderItems as $item)
            <div class="order-item-info-row">
                <p>Product Name: {{$item->product_name}}</p>
                <p>Quantity: {{$item->quantity}}</p>
                <p>Price: {{$item->formatted_price}}</p>
                <p>Tax: {{$item->formatted_tax}}</p>
            </div>
            <div class="order-item-actions">
                <form class="button-holder" method="POST">
                    @csrf
                    {{ method_field('PATCH') }}
                    <button type="submit" class="patch-button" formaction="{{ route('invoices.delete', $invoice) }}">
                        Edit Order Item For Invoice
                    </button>
                </form>
                <form class="button-holder" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="delete-button" formaction="{{ route('invoices.delete', $invoice) }}">
                        Delete Order Item From Invoice
                    </button>
                </form>
            </div>
        @endforeach
    @endif
</div>

{{--TODO--}}
{{--<div class="item-name-row">--}}
    {{--<label for="item-name">Product Name</label>--}}
    {{--<input id="item-name" type="text" class="form-control" name="product_name[]" readonly="readonly" value={{$item->product_name}} />--}}
{{--</div>--}}
{{--<div class="item-quantity-row">--}}
    {{--<label for="item-quantity">Quantity*</label>--}}
    {{--<input id="item-quantity" type="number" class="form-control" name="quantity[]" value={{$item->quantity}} />--}}
{{--</div>--}}
{{--<div class="item-price-row">--}}
    {{--<label for="item-price">Price* ($)</label>--}}
    {{--<input id="item-price" type="number" step="0.01" class="form-control" name="price[]" value={{$item->price / 100}} />--}}
{{--</div>--}}
{{--<div class="item-tax-row">--}}
    {{--<label for="item-tax">Tax*</label>--}}
    {{--<input id="item-tax" type="number" class="form-control" name="tax[]" value={{$item->tax}} />--}}
{{--</div>--}}
