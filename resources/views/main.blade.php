<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Invoice Creation</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html {
            font-family: 'Nunito', sans-serif;
            font-weight: 400;
            height: 100vh;
            margin: 0;
            box-sizing: border-box;
            line-height: 1.15;
            font-size: 20px; /* Todo */
        }

        *, *:before, *:after {
            box-sizing: inherit;
        }

        body {
            min-height: calc(100vh - 100px);
            background-color: #fff;
            color: #636b6f;
            margin: 0;
            padding: 0;
        }

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

        .button-holder > button {
            width: 100px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="header">Invoices List</h1>
    <button class="create-invoice">Create New Invoice</button>
    <div class="invoices">
        @foreach($invoices as $invoice)
            <div class="invoice">
                <div class="info">
                    <p>Invoice Id #{{$invoice->id}}</p>
                    <p>Customer Name: {{$invoice->customer->name}}</p>
                    <p>Total: ${{$invoice->formatted_total}}</p>
                    <p>Status: {{$invoice->formatted_status}}</p>
                    <p>Date Issued: {{$invoice->created_at->toFormattedDateString()}}</p>
                    <p>Invoice Payment Due Date: {{$invoice->due_date->toFormattedDateString()}}</p>
                    <p>Invoice Paid Out On: {{! empty($invoice->paid_at) ? $invoice->paid_at->toFormattedDateString() : 'N/A'}}</p>
                </div>
                <div class="invoice-actions">
                    <div class="button-holder">
                        <button>View</button>
                    </div>
                    <div class="button-holder">
                        <button>Edit</button>
                    </div>
                    <div class="button-holder">
                        <button>Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</body>
</html>
