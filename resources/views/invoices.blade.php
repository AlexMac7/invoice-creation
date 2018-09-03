@extends('layouts.main')

@section('main')
    <!-- Styles -->
    <style>
        .container {
            margin: 15px 30px;
            display: grid;
            align-items: center;
            grid-template-columns: 1fr 1fr;
            grid-template-areas: "header     create-invoice" "invoices    invoices";
        }
        .header {
            grid-area: header;
        }
        .create-invoice {
            grid-area: create-invoice;
        }
        .invoices {
            grid-area: invoices;
        }
        .invoice {
            display: grid;
            grid-template-columns: 1fr 1fr;
        }
        .info {
            border-top: blue 5px solid;
        }
    </style>

    <div class="container">
        <h1 class="header">Invoices List</h1>
        <div class="create-invoice">
            <form class="button-holder" method="GET">
                <button type="submit" class="create-button" formaction="{{ route('invoices.create') }}">Create New
                    Invoice
                </button>
            </form>
        </div>
        <div class="invoices">
            @foreach($invoices as $invoice)
                <div class="invoice">
                    <div class="info">
                        <p>Invoice Id #{{$invoice->id}}</p>
                        <p>Customer Name: {{$invoice->customer->name}}</p>
                        <p>Total: {{$invoice->formatted_total}}</p>
                        <p>Status: {{$invoice->formatted_status}}</p>
                        <p>Date Issued: {{$invoice->created_at->toFormattedDateString()}}</p>
                        <p>Invoice Payment Due Date: {{$invoice->due_date->toFormattedDateString()}}</p>
                        <p>Invoice Paid Out
                            On: {{! empty($invoice->paid_at) ? $invoice->paid_at->toFormattedDateString() : 'N/A'}}</p>
                    </div>
                    <div class="invoice-actions">
                        <form class="button-holder" method="GET">
                            <button type="submit" class="view-button" formaction="{{ route('invoices.show', $invoice) }}">
                                View Invoice
                            </button>
                        </form>
                        <form class="button-holder" method="GET">
                            <button type="submit" class="edit-button" formaction="{{ route('invoices.edit', $invoice) }}">
                                Edit Invoice
                            </button>
                        </form>
                        <form class="button-holder" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="delete-button" formaction="{{ route('invoices.delete', $invoice) }}">
                                Delete Invoice
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
