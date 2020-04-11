<?php

namespace App\Http\Controllers\Admin\Status;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Models\InvoiceStatus;
use App\Http\Controllers\Controller;

class StatusInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuts = Status::all();
        return view('admin.status.invoices.index', compact('status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = Color::all();
        return view('admin.status.invoices.create', compact('colors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:invoice_statuses,name',
            'color_id' => 'required|integer|exists:colors,id',
        ]);

        InvoiceStatus::create($data);

        return redirect()->route('admin.status.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été ajouté.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceStatus  $statusInvoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceStatus $statusInvoice)
    {
        $statusInvoice->delete();

        return redirect()->route('admin.status.invoices.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été supprimé.',
        ]);
    }
}
