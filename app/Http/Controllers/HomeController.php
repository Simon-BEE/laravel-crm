<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // $invoice['id'] = 256984;

        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('pdf.invoice', $invoice);
        // // $pdf->save(public_path() . '/invoices/invoice.pdf');
        // return $pdf->stream();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return auth()->user()->isAdmin ? redirect()->route('admin.home') : redirect()->route('customer.home');
    }
}
