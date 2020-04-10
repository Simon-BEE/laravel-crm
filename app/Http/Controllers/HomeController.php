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
        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('pdf.invoice');
        // // $pdf->save(public_path() . '/invoices/invoice.pdf');
        // return $pdf->stream();

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // return auth()->user()->isAdmin ? redirect()->route('admin.home') : redirect()->route('customer.home');
        return redirect()->route(auth()->user()->isAdmin ? 'admin.home' : 'customer.home');
    }
}
