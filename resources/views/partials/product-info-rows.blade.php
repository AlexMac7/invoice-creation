<style>
    .product-info-rows > div {
        padding: .25rem 0;
    }
</style>
<div class="product-info-rows">
    <label for="product-select">Add Product(s)</label>
    <select id="product-select">
        Add Product(s)
        @foreach($products as $product)
            <option value={{$product->name}}>{{$product->name}}</option>
        @endforeach
    </select>

    {{--Todo add product items--}}
    {{--Need to select the item, have it added, display the set price + tax and quanitty of one. These fields need the option to be customized as well--}}

    <div class="product-name-row">
        <label for="product-name">{{ __('Product Name') }}</label>
        <input id="product-name" type="text" class="form-control" name="product_name" value="{{ old('product_name') }}" required autofocus>

        @if ($errors->has('product_name'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('product_name') }}</strong>
            </div>
        @endif
    </div>
    <div class="quantity-row">
        <label for="quantity">{{ __('Quantity*') }}</label>
        <input id="quantity" type="text" class="form-control" name="quantity" value="{{ old('quantity') }}" required autofocus>

        @if ($errors->has('quantity'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('quantity') }}</strong>
            </div>
        @endif
    </div>
    <div class="price-row">
        <label for="price">{{ __('Price*') }}</label>
        <input id="price" type="date" class="form-control" name="price" value="{{ old('price') }}" required autofocus>

        @if ($errors->has('price'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('price') }}</strong>
            </div>
        @endif
    </div>
    <div class="tax-row">
        <label for="tax">{{ __('Tax*') }}</label>
        <input id="tax" type="number" class="form-control" name="tax" value="{{ old('tax') }}" required autofocus>

        @if ($errors->has('tax'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('tax') }}</strong>
            </div>
        @endif
    </div>
</div>
<script>
    //todo
</script>