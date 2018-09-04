<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\OrderItem;
use App\Product;
use App\Services\CreateOrUpdateInvoice;
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

    public function store(Request $request, CreateOrUpdateInvoice $createOrUpdate)
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

        $invoice = Invoice::findOrFail($request->input('invoice_id'));

        $createOrUpdate->forOrderItemsCreation($request, $invoice);

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
        $quantity = ! empty($request->input('quantity')) ? $request->input('quantity') : $orderItem->quantity;
        $price = ! empty($request->input('price')) ? ($request->input('price') * 100) : $orderItem->price;
        $tax = ! empty($request->input('tax')) ? $request->input('tax') : $orderItem->tax;

        if (! empty($request->only('quantity', 'price', 'tax'))) {
            $itemSubtotal = (int) ($price * $quantity);
            $itemTotal = $itemSubtotal + (int) ($itemSubtotal * ($tax / 100));

            $previousItemSubtotal = $orderItem->price;
            $previousItemTotal = (int) ($orderItem->price + ($orderItem->price * ($tax / 100)));
            $previousInvoiceSubtotal = $invoice->subtotal;
            $previousInvoiceTotal = $invoice->total;

            $newSubtotal = ($previousInvoiceSubtotal - $previousItemSubtotal) + $itemSubtotal;
            $newTotal = ($previousInvoiceTotal - $previousItemTotal) + $itemTotal;

            //todo, calculate isPaid and status based on payments made so far
            $isPaid = ($newTotal <= ((int) $previousInvoiceTotal)) ? true : false;
            $status = $isPaid ? 'paid_in_full' : 'payment_due';

            $invoice->update([
                'total' => $newTotal,
                'subtotal' => $newSubtotal,
                'tax' => $tax,
                'status' => $status,
                'is_paid' => $isPaid,
            ]);
        }

        $orderItem->update([
            'product_name' => $request->input('product_name'),
            'quantity' => $quantity,
            'price' => $price,
            'tax' => $tax,
        ]);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function delete(OrderItem $orderItem)
    {
        //todo, recalculate invoice
        $invoice = $orderItem->invoice;
        $orderItem->delete();

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }
}
