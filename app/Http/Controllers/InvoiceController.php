<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Invoice;
use App\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('customer')->get();

        return view('invoices', [
            'invoices' => $invoices,
        ]);
    }

    public function create()
    {
        $products = Product::all();

        return view('create-invoice', [
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            //first part
            'customer_name' => ['required', 'string', 'min:2'],
            'customer_address' => ['required', 'string'],
            'invoice_date' => ['required', 'date'],
            'invoice_number' => ['required', 'numeric'],
            'due_date' => ['required', 'date'],
            'note' => ['required', 'string'],
//            //second part
            'product_name' => ['required', 'string'],
            'quantity' => ['required', 'numeric'],
            'price' => ['required', 'numeric', 'min:1'],
            'tax' => ['required', 'numeric', 'min:0', 'max:20'],
//            //third part
            'payment_type' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        //todo, if no customer found for the address, create one?

        $customer = Customer::where([
            ['name', $request->input('customer_name')],
            ['address', $request->input('customer_address')]
        ])->first();
        $tax = $request->input('tax');
        $subtotal = $request->input('price') * $request->input('quantity');
        $total = $subtotal + (int) ($subtotal * ($tax / 100));
        $isPaid = ($total === $request->input('amount')) ? true : false;
        $status = $isPaid ? 'paid_in_full' : 'payment_due';
        $paidAt = $isPaid ? now()->toDateString() : null;

        Invoice::create([
            'invoice_number' => $request->input('invoice_number'),
            'customer_id' => $customer->id,
            'total' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'status' => $status,
            'note' => $request->input('note'),
            'is_paid' => $isPaid,
            'invoice_date' => $request->input('invoice_date'),
            'due_date' => $request->input('due_date'),
            'paid_at' => $paidAt,
        ]);

        return redirect('main');
    }

    public function show(Invoice $invoice)
    {
        $orderItems = $invoice->orderItems()->with('product')->get();
        $payments = $invoice->payments()->get();

        return view('view-invoice', [
            'invoice' => $invoice,
            'orderItems' =>  $orderItems,
            'payments' => $payments,
        ]);
    }

    public function edit(Invoice $invoice)
    {
        dd('todo edit');
        /*
         * return view 'edit' with $invoice
         */
    }

    public function update(Request $request, $id)
    {
        dd('todo update');
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();

        return redirect('/invoices');
    }
}
