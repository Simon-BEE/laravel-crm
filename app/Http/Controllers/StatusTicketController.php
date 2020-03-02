<?php

namespace App\Http\Controllers;

use App\Models\StatusTicket;
use Illuminate\Http\Request;

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
        return view('status.tickets.index', compact('statuts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('status.tickets.create');
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
        ]);

        StatusTicket::create($data);

        return redirect()->route('status.tickets.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le status a bien été ajouté.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusTicket  $statusTicket
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusTicket $ticket)
    {
        $ticket->delete();

        return redirect()->route('status.tickets.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le status a bien été supprimé.',
        ]);
    }
}
