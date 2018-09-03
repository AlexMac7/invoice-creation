<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function create(Invoice $invoice)
    {
        $products = Product::all();

        return view('create-order-item', [
            'invoice' => $invoice,
            'products' => $products,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
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
            'invoice_id' => ['required', 'exists:invoices,id'],
        ]);

        $invoice = Invoice::firstOrFail($request->input('invoice_id'));

        //todo create the order item(s) and adjust invoice

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function edit(OrderItem $orderItem)
    {
        return view('edit-order-item', [
            'orderItem' => $orderItem,
        ]);
    }

    public function update(Request $request, OrderItem $orderItem)
    {
        $request->validate([
            'product_name' => ['nullable', 'string'],
            'quantity' => ['nullable', 'numeric'],
            'price' => ['nullable', 'numeric', 'min:1'],
            'tax' => ['nullable', 'numeric', 'min:0', 'max:20'],
        ]);

        $invoice = $orderItem->invoice;
        //todo, recalculate invoice totals

        $orderItem->update([
            'product_name' => $request->input('product_name'),
            'quantity' => $request->input('quantity'),
            'price' => ($request->input('price') * 100),
            'tax' => $request->input('tax'),
        ]);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function delete(OrderItem $orderItem)
    {
        $invoice = $orderItem->invoice;
        $orderItem->delete();

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }
}
