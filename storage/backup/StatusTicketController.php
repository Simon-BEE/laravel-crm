<?php

namespace App\Http\Controllers\Admin\Status;

use App\Models\Color;
use App\Models\StatusTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StatusTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuts = StatusTicket::all();
        return view('admin.status.tickets.index', compact('statuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colors = Color::all();
        return view('admin.status.tickets.create', compact('colors'));
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
            'name' => 'required|string|max:255|unique:status_projects,name',
            'color_id' => 'required|integer|exists:colors,id',
        ]);

        StatusTicket::create($data);

        return redirect()->route('admin.status.tickets.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été ajouté.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusTicket  $statusTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusTicket $statusTicket)
    {
        $statusTicket->delete();

        return redirect()->route('admin.status.tickets.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le statut a bien été supprimé.',
        ]);
    }
}
