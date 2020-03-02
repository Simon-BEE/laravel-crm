<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoice['id'] = 256984;

        // $pdf = App::make('dompdf.wrapper');
        // $pdf->loadView('pdf.invoice', $invoice);
        // // $pdf->save(public_path() . '/invoices/invoice.pdf');
        // return $pdf->stream();
        return view('pdf.invoice');
    }
}
