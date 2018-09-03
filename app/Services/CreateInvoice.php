<?php

namespace App\Services;

use App\Customer;
use App\Invoice;
use App\OrderItem;
use App\Payment;

class CreateInvoice
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
        $total = $subtotal + (int) ($subtotal * ($tax / 100));

        $isPaid = ($total === array_sum($amountsPaid)) ? true : false;
        $status = $isPaid ? 'paid_in_full' : 'payment_due';
        $paidAt = $isPaid ? now()->toDateString() : null;

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
            'paid_at' => $paidAt,
        ]);

        $this->createOrderItems($productNames, $quantities, $price, $tax, $productIds, $invoice->id);
        $this->createPayments($paymentTypes, $amountsPaid, $invoice->id);
    }

    protected function determineSubtotal($prices, $quantities)
    {
        $subtotal = 0;
        for ($i = 0; $i < count($prices); $i++) {
            $subtotal += $prices[$i] * $quantities[$i];
        }

        return $subtotal;
    }

    protected function createOrderItems($productNames, $quantities, $price, $tax, $productIds, $invoiceId)
    {
        for ($i = 0; $i < count($productNames); $i++) {
            OrderItem::create([
                'product_name' => $productNames[$i],
                'invoice_id' => $invoiceId,
                'product_id' => $productIds[$i],
                'price' => $price[$i],
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
                'amount' => $amountsPaid[$i],
                'type' => $paymentTypes[$i],
            ]);
        }
    }
}
