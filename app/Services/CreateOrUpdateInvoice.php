<?php

namespace App\Services;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Payment;

class CreateOrUpdateInvoice
{
    public function create($request)
    {
        $customer = Customer::firstOrCreate(
            ['name' => $request->input('customer_name')],
            ['address' => $request->input('customer_address')]
        );

        $productNames = $request->input('product_name');
        $quantities = $request->input('quantity');
        $price = $request->input('price');
        $tax = $request->input('tax')[0];
        $productIds = $request->input('product_id');
        $paymentTypes = $request->input('payment_type');
        $amountsPaid = $request->input('amount');

        $subtotal = $this->determineSubtotal($request->input('price'), $request->input('quantity'));
        $total = $subtotal + (int) ((int) $subtotal * ($tax / 100));

        $isPaid = ($total <= ((int) (array_sum($amountsPaid) * 100))) ? true : false;
        $status = $isPaid ? 'paid_in_full' : 'payment_due';

        $invoice = Invoice::create([
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
        ]);

        $this->createOrderItems($productNames, $quantities, $price, $tax, $productIds, $invoice->id);
        $this->createPayments($paymentTypes, $amountsPaid, $invoice->id);
    }

    public function forOrderItemsCreation($request, $invoice)
    {
        $productNames = $request->input('product_name');
        $quantities = $request->input('quantity');
        $price = $request->input('price');
        $tax = $request->input('tax')[0];
        $productIds = $request->input('product_id');

        $subtotal = $this->determineSubtotal($request->input('price'), $request->input('quantity'));
        $total = $subtotal + (int) ((int) $subtotal * ($tax / 100));

        $invoice->update([
            'total' => $invoice->total + $total,
            'subtotal' => $invoice->subtotal + $subtotal,
            'tax' => $tax,
            'status' => 'payment_due',
            'is_paid' => false,
        ]);

        $this->createOrderItems($productNames, $quantities, $price, $tax, $productIds, $invoice->id);
    }

    public function forPaymentsCreation($request, $invoice)
    {
        $paymentTypes = $request->input('payment_type');
        $amountsPaid = $request->input('amount');

        $previouslyPaid = $invoice->payments()->sum('amount');

        $isPaid = ($invoice->total <= ((int) $previouslyPaid + (array_sum($amountsPaid) * 100))) ? true : false;
        $status = $isPaid ? 'paid_in_full' : 'payment_due';

        $invoice->update([
            'status' => $status,
            'is_paid' => $isPaid,
        ]);

        $this->createPayments($paymentTypes, $amountsPaid, $invoice->id);
    }

    protected function determineSubtotal($prices, $quantities)
    {
        $subtotal = 0;
        for ($i = 0; $i < count($prices); $i++) {
            $subtotal += $prices[$i] * $quantities[$i];
        }

        return (int) $subtotal * 100;
    }

    protected function createOrderItems($productNames, $quantities, $price, $tax, $productIds, $invoiceId)
    {
        for ($i = 0; $i < count($productNames); $i++) {
            OrderItem::create([
                'product_name' => $productNames[$i],
                'invoice_id' => $invoiceId,
                'product_id' => $productIds[$i],
                'price' => $price[$i] * 100,
                'quantity' => $quantities[$i],
                'tax' => $tax,
            ]);
        }
    }

    protected function createPayments($paymentTypes, $amountsPaid, $invoiceId)
    {
        for ($i = 0; $i < count($paymentTypes); $i++) {
            Payment::create([
                'invoice_id' => $invoiceId,
                'amount' => $amountsPaid[$i] * 100,
                'type' => $paymentTypes[$i],
            ]);
        }
    }
}
