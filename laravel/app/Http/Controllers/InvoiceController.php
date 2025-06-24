<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\ServiceActivation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Показать счёт по подключённой услуге.
     */
    public function show($id) 
    {
        $invoice = Invoice::with('service')
            ->where('id_invoice', $id)
            ->where('id_user', Auth::user()->id_user)
            ->firstOrFail();

        $activation = ServiceActivation::where('id_connection', $invoice->id_connection)->first();

        return view('invoices.show', compact('invoice', 'activation'));
    }



    /**
     * Обработать оплату счёта.
     */
    public function pay($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Проверка владельца
        if ($invoice->id_user !== Auth::user()->id_user) {
            abort(403);
        }

        $invoice->status_payment = true;
        $invoice->save();

        return redirect()->route('dashboard')->with('success', 'Счёт успешно оплачен');
    }

    /**
     * Отключить услугу.
     */
    public function disconnect($id)
    {
        $activation = ServiceActivation::findOrFail($id);

        if ($activation->id_user !== Auth::user()->id_user) {
            abort(403);
        }

        $activation->update(['date_disconnection' => now()]);

        return redirect()->route('dashboard')->with('success', 'Услуга отключена');
    }
}
