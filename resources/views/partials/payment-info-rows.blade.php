<style>
    .payment-info-rows > div {
        padding: .25rem 0;
    }
    #payments {
        padding: 2rem 0;
    }
</style>
<div>
    <label for="payment-select">Add Payment Method(s)</label>
    <select id="payment-select" onchange="addPayment(this.value)" required>
        Add Payment Method(s)
        <option value="" disabled selected style="display:none;">Select Payment Method(s) To Add</option>
        <option value="cash">Cash</option>
        <option value="credit">Credit</option>
        <option value="debit">Debit</option>
        <option value="e-transfer">E Transfer</option>
    </select>
</div>
<div id="payments">

</div>
<script type='text/javascript'>
    function addPayment(type) {
        const paymentRowClassName = 'payment-row'.concat(type);

        if (document.getElementsByClassName(paymentRowClassName).length != 0) {
            return; //if the payment method has been added already don't add it again
        }
        const container = document.getElementById("payments");
        const productNameRow = document.createElement("div");
        productNameRow.className = paymentRowClassName;

        productNameRow.innerHTML =
            '<label for="type">Payment Type</label>\
            <input id="type" type="text" class="form-control" name="payment_type[]" value="" />\
            <label for="amount">Amount* ($)</label>\
            <input id="amount" type="number" step="0.01" class="form-control" name="amount[]" value="" />\
            <button id="remove-payment" value="-" onclick="removePaymentRow(this)">Remove Payment Method</button>';

        container.appendChild(productNameRow);

        const typeId = 'type-'.concat(type);
        const amountId = 'amount-'.concat(type);

        document.getElementById("type").id = typeId;
        document.getElementById("amount").id = amountId;

        document.getElementById(typeId).value = type;
    }

    function removePaymentRow(input) {
        document.getElementById("payments").removeChild(input.parentNode);
    }
</script>
