<style>
    .payments-made-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
    }
    .payments-made-info-row {
        padding: .25rem 0;
    }
</style>
<div class="payments-made-info">
    @foreach($payments as $payment)
        <div class="payments-made-info-row">
            <p>Payment Type: {{ucfirst($payment->type)}}</p>
            <p>Amount: {{$payment->formatted_amount}}</p>
        </div>
        <div class="payments-made-actions">
            <form class="button-holder" method="GET">
                <button type="submit" class="create-button" formaction="{{ route('payments.edit', $payment) }}">
                    Edit Payment For Invoice
                </button>
            </form>
            <form class="button-holder" method="POST">
                @csrf
                {{ method_field('DELETE') }}
                <button type="submit" class="delete-button" formaction="{{ route('payments.delete', $payment) }}">
                    Delete Payment From Invoice
                </button>
            </form>
        </div>
    @endforeach
    <form class="button-holder" method="GET">
        <button type="submit" class="view-button" formaction="{{ route('payments.create', $invoice, $payment) }}">
            Create New Payment For Invoice
        </button>
    </form>
</div>

