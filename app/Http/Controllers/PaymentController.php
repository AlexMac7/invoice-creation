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

        $invoice = $payment->invoice;
        //todo, recalculate invoice totals

        $payment->update([
            'type' => $request->input('type'),
            'amount' => ($request->input('amount') * 100),
        ]);

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }

    public function delete(Payment $payment)
    {
        $invoice = $payment->invoice;
        $payment->delete();

        return redirect()->route('invoices.edit', ['invoice' => $invoice]);
    }
}
