<style>
    .general-info-rows > div {
        padding: .25rem 0;
    }
</style>

@php
    $invoicePresent = (! empty($invoice));
@endphp

<div class="general-info-rows">
    <div class="customer-name-row">
        <label for="customer-name">'Customer Name*'</label>
        <input id="customer-name" type="text" class="form-control" name="customer_name" value="{{ ($invoicePresent ? $invoice->customer->name : null) }}" required autofocus>

        @if ($errors->has('customer_name'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('customer_name') }}</strong>
            </div>
        @endif
    </div>
    <div class="customer-address-row">
        <label for="customer-address">{{ 'Customer Address*' }}</label>
        <input id="customer-address" type="text" class="form-control" name="customer_address" value="{{ ($invoicePresent ? $invoice->customer->address : null) }}" required autofocus>

        @if ($errors->has('customer_address'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('customer_address') }}</strong>
            </div>
        @endif
    </div>
    <div class="invoice-date-row">
        <label for="invoice-date">{{ 'Invoice Date*' }}</label>
        <input id="invoice-date" type="date" class="form-control" name="invoice_date" value="{{ ($invoicePresent ? $invoice->invoice_date->toDateString() : now()->toDateString()) }}" required autofocus>

        @if ($errors->has('invoice_date'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('invoice_date') }}</strong>
            </div>
        @endif
    </div>
    <div class="invoice-number-row">
        <label for="invoice-number">{{ 'Invoice Number*' }}</label>
        <input id="invoice-number" type="number" class="form-control" name="invoice_number" value="{{ ($invoicePresent ? $invoice->invoice_number : null) }}" min="0" autofocus>

        @if ($errors->has('invoice_number'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('invoice_number') }}</strong>
            </div>
        @endif
    </div>
    <div class="due-date-row">
        <label for="due-date">{{ 'Invoice Due Date*' }}</label>
        <input id="due-date" type="date" class="form-control" name="due_date" value="{{ ($invoicePresent ? $invoice->due_date->toDateString() : now()->addDays(13)->toDateString()) }}" required autofocus>

        @if ($errors->has('due_date'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('due_date') }}</strong>
            </div>
        @endif
    </div>
    <div class="note-row">
        <label for="note">{{ 'Invoice Note*' }}</label>
        <input id="note" type="text" class="form-control" name="note" value="{{ ($invoicePresent ? $invoice->note : null) }}" required autofocus>

        @if ($errors->has('note'))
            <div class="invalid-feedback">
                <strong>{{ $errors->first('note') }}</strong>
            </div>
        @endif
    </div>
</div>
