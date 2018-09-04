<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Payment;
use App\Services\CreateOrUpdateInvoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(Invoice $invoice)
    {
        return view('create-payment', [
            'invoice' => $invoice,
        ]);
    }

    public function store(Request $request, CreateOrUpdateInvoice $createOrUpdate)
    {
        $request->validate([
            'payment_type' => ['required'],
            'payment_type.*' => ['required', 'string', 'in:cash,credit,debit,e-transfer'],
            'amount' => ['required'],
            'amount.*' => ['required', 'numeric'],
            'invoice_id' => ['required', 'exists:invoices,id'],
        ]);

        $invoice = Invoice::findOrFail($request->input('invoice_id'));

        $createOrUpdate->forPaymentsCreation($request, $invoice);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function edit(Payment $payment)
    {
        return view('edit-payment', [
            'payment' => $payment,
        ]);
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'type' => ['nullable', 'string', 'in:cash,credit,debit,e-transfer'],
            'amount' => ['nullable', 'numeric'],
        ]);

        $amountUpdated = ! empty($request->input('amount'));
        $amount = $amountUpdated ? ($request->input('amount') * 100) : $payment->amount;
        $type = ! empty($request->input('type')) ? $request->input('type') : $payment->type;

        if ($amountUpdated) {
            $invoice = $payment->invoice;
            $previouslyPaid = $invoice->payments()->where('id', '!=', $payment->id)->sum('amount');

            $isPaid = ($invoice->total <= ((int) $previouslyPaid + $amount)) ? true : false;
            $status = $isPaid ? 'paid_in_full' : 'payment_due';

            $invoice->update([
                'is_paid' => $isPaid,
                'status' => $status,
            ]);
        }

        $payment->update([
            'type' => $type,
            'amount' => $amount,
        ]);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function delete(Payment $payment)
    {
        //todo, recalculate invoice
        $invoice = $payment->invoice;
        $payment->delete();

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }
}
