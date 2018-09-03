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
                <form class="button-holder" method="GET">
                    <button type="submit" class="view-button" formaction="{{ route('order-items.create', $invoice, $item) }}">
                        Create New Order Item For Invoice
                    </button>
                </form>
                <form class="button-holder" method="GET">
                    <button type="submit" class="create-button" formaction="{{ route('order-items.edit', $item) }}">
                        Edit Order Item For Invoice
                    </button>
                </form>
                <form class="button-holder" method="POST">
                    @csrf
                    {{ method_field('DELETE') }}
                    <button type="submit" class="delete-button" formaction="{{ route('order-items.delete', $item) }}">
                        Delete Order Item From Invoice
                    </button>
                </form>
            </div>
        @endforeach
    @endif
</div>
