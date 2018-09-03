<style>
    .product-info-rows > div {
        padding: .25rem 0;
    }
    #products {
        padding: 2rem 0;
    }
</style>
<div>
    <label for="product-select">Add Product(s)</label>
    <select id="product-select" onchange="addProduct(this.value)" required>
        Add Product(s)
        <option value="" disabled selected style="display:none;">Select Product(s) To Add</option>
        @foreach($products as $product)
            <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
    </select>
</div>
<div id="products">

</div>
<script type='text/javascript'>
    function addProduct(productId) {
        const productNameRowClassName = 'product-name-row-'.concat(productId);

        if (document.getElementsByClassName(productNameRowClassName).length != 0) {
            return; //if the product has been added already don't add it again
        }

        const allProducts = {!! $products !!};
        const product = allProducts.find(function (obj) { return obj.id == productId; });

        const container = document.getElementById("products");
        const productNameRow = document.createElement("div");
        productNameRow.className = productNameRowClassName;

        productNameRow.innerHTML =
            '<label for="product-name">Product Name</label>\
            <input id="product-name" type="text" class="form-control" name="product_name[]" readonly="readonly"/>\
            <label for="quantity">Quantity*</label>\
            <input id="quantity" type="text" class="form-control" name="quantity[]" />\
            <label for="price">Price* ($)</label>\
            <span><input id="price" type="number" step="0.01" class="form-control" name="price[]" /></span>\
            <label for="tax">Tax*</label>\
            <input id="tax" type="number" class="form-control" name="tax[]" readonly="readonly"/>\
            <input id="product-id" type="hidden" class="form-control" name="product_id[]" />\
            <button id="remove-product" value="-" onclick="removeProductRow(this)">Remove Product</button>';

        container.appendChild(productNameRow);

        const productNameId = 'product-name-'.concat(productId);
        const quantityId = 'quantity-'.concat(productId);
        const priceId = 'price-'.concat(productId);
        const taxId = 'tax-'.concat(productId);
        const productIdId = 'product-id-'.concat(productId);

        document.getElementById("product-name").id = productNameId;
        document.getElementById("quantity").id = quantityId;
        document.getElementById("price").id = priceId;
        document.getElementById("tax").id = taxId;
        document.getElementById("product-id").id = productIdId;

        document.getElementById(productNameId).value = product.name;
        document.getElementById(quantityId).value = 1;
        document.getElementById(priceId).value = product.price / 100;
        document.getElementById(taxId).value = 10;
        document.getElementById(productIdId).value = product.id;
        document.getElementById("remove-product").value = product.id;
    }

    function removeProductRow(input) {
        document.getElementById("products").removeChild(input.parentNode);
    }
</script>
