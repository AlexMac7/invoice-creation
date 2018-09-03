<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Product;
use App\Services\CreateInvoice;
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
            'orderItems' => collect([]),
        ]);
    }

    public function store(Request $request, CreateInvoice $createInvoice)
    {
        $request->validate([
            //first part
            'customer_name' => ['required', 'string', 'min:2'],
            'customer_address' => ['required', 'string'],
            'invoice_date' => ['required', 'date'],
            'invoice_number' => ['required', 'numeric', 'unique:invoices,invoice_number'],
            'due_date' => ['required', 'date'],
            'note' => ['required', 'string'],
            //second part
            'product_name' => ['required'],
            'product_name.*' => ['required', 'string'],
            'quantity' => ['required'],
            'quantity.*' => ['required', 'numeric'],
            'price' => ['required'],
            'price.*' => ['required', 'numeric', 'min:1'],
            'tax' => ['required'],
            'tax.*' => ['required', 'numeric', 'min:0', 'max:20'],
            'product_id' => ['required'],
            'product_id.*' => ['required', 'exists:products,id'],
            //third part
            'payment_type' => ['required'],
            'payment_type.*' => ['required', 'string', 'in:cash,credit,debit,e-transfer'],
            'amount' => ['required'],
            'amount.*' => ['required', 'numeric'],
        ]);

        $createInvoice->create($request);

        return redirect('invoices');
    }

    public function show(Invoice $invoice)
    {
        $orderItems = $invoice->orderItems()->with('product')->get();
        $payments = $invoice->payments()->get();

        return view('view-invoice', [
            'invoice' => $invoice,
            'orderItems' => $orderItems,
            'payments' => $payments,
        ]);
    }

    public function edit(Invoice $invoice)
    {
        $orderItems = $invoice->orderItems;
        $payments = $invoice->payments;
        $products = Product::all();

        return view('edit-invoice', [
            'invoice' => $invoice,
            'orderItems' => $orderItems,
            'payments' => $payments,
            'products' => $products,
        ]);
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validatedFields = $request->validate([
//            'customer_name' => ['required', 'string', 'min:2'], //todo
//            'customer_address' => ['required', 'string'],
            'invoice_date' => ['required', 'date'],
            'invoice_number' => ['required', 'numeric', 'unique:invoices,invoice_number'],
            'due_date' => ['required', 'date'],
            'note' => ['required', 'string'],
        ]);

        $invoice->update($validatedFields);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function delete(Invoice $invoice)
    {
        $invoice->delete();

        return redirect('/invoices');
    }
}
