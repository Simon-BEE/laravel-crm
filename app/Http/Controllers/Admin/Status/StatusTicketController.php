<?php

namespace App\Http\Controllers\Admin\Status;

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
        return view('admin.status.tickets.create');
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

        return redirect()->route('admin.status.tickets.index')->with([
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

        return redirect()->route('admin.status.tickets.index')->with([
            'alertType' => 'success',
            'alertMessage' => 'Le status a bien été supprimé.',
        ]);
    }
}
